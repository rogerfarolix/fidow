<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\LlmConfiguration;

class DynamicAIService
{
    /**
     * Génère du texte via les providers configurés dynamiquement
     */
    public function generateText(string $prompt, array $options = []): array
    {
        try {
            // Vérifier le cache d'abord
            $cacheKey = 'ai_response:' . md5($prompt . serialize($options));
            $cacheTtl = config('ai.cache.ttl', 3600);
            
            if (config('ai.cache.enabled', true) && Cache::has($cacheKey)) {
                $cachedResponse = Cache::get($cacheKey);
                Log::info('AI response retrieved from cache', ['cache_key' => $cacheKey]);
                return $cachedResponse;
            }

            // Obtenir les providers actifs dans l'ordre de priorité
            $providers = LlmConfiguration::getActiveProviders()->get();
            
            if ($providers->isEmpty()) {
                return [
                    'success' => false,
                    'error' => 'Aucun provider IA configuré'
                ];
            }

            // Essayer chaque provider dans l'ordre
            foreach ($providers as $provider) {
                if (!$provider->hasApiKey()) {
                    Log::warning("Provider {$provider->provider} skipped: API key not configured");
                    continue;
                }

                $result = $this->callProvider($provider, $prompt, $options);
                
                if ($result['success']) {
                    $provider->recordUsage(true);
                    
                    // Mettre en cache la réponse réussie
                    if (config('ai.cache.enabled', true)) {
                        Cache::put($cacheKey, $result, $cacheTtl);
                        Log::info('AI response cached', ['cache_key' => $cacheKey, 'ttl' => $cacheTtl]);
                    }
                    
                    // Enregistrer les métriques de performance
                    $this->recordPerformanceMetrics($provider, $result, true);
                    
                    return $result;
                }
                
                // Enregistrer l'échec et continuer avec le suivant
                $provider->recordUsage(false, $result['error'] ?? 'Unknown error');
                Log::warning("Provider {$provider->provider} failed, trying next", [
                    'error' => $result['error'] ?? 'Unknown error'
                ]);
                
                // Enregistrer les métriques de performance même pour les échecs
                $this->recordPerformanceMetrics($provider, $result, false);
            }

            return [
                'success' => false,
                'error' => 'Tous les providers IA ont échoué'
            ];

        } catch (\Exception $e) {
            Log::error('Dynamic AI Service error', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => 'Service IA temporairement indisponible. Réessaie dans quelques minutes.'
            ];
        }
    }

    /**
     * Appelle un provider spécifique
     */
    public function callProvider(LlmConfiguration $provider, string $prompt, array $options = []): array
    {
        try {
            $payload = $this->buildPayload($provider, $prompt, $options);
            
            // Gérer les URLs spécifiques pour certains providers
            $apiUrl = $this->getApiUrl($provider);
            
            $response = Http::withHeaders($provider->getHttpHeaders())
                ->timeout($provider->timeout_seconds)
                ->post($apiUrl, $payload);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'error' => "API error: {$response->status()} - {$response->body()}"
                ];
            }

            $parsed = $this->parseResponse($provider, $response);

            if ($parsed === null) {
                return [
                    'success' => false,
                    'error' => 'Invalid response format from ' . $provider->provider
                ];
            }

            return [
                'success' => true,
                'data' => $parsed,
                'provider' => $provider->provider,
                'model' => $provider->model
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtient l'URL API correcte pour chaque provider
     */
    private function getApiUrl(LlmConfiguration $provider): string
    {
        return match($provider->provider) {
            'google_ai' => "https://generativelanguage.googleapis.com/v1beta/models/{$provider->model}:generateContent?key=" . $provider->getApiKey(),
            'cloudflare' => str_replace('CF_ACCOUNT', $this->getCloudflareAccountId($provider), $provider->api_url),
            default => $provider->api_url,
        };
    }

    /**
     * Obtient l'ID de compte Cloudflare
     */
    private function getCloudflareAccountId(LlmConfiguration $provider): string
    {
        return $provider->getCloudflareAccountId() ?? 'YOUR_ACCOUNT_ID';
    }

private function buildPayload(LlmConfiguration $provider, string $prompt, array $options): array
{
    $systemPrompt = $options['system_prompt'] 
        ?? 'Tu es un expert en personal branding digital. Tu réponds UNIQUEMENT en JSON valide, sans texte additionnel.';

    return match($provider->provider) {
        'google_ai' => [
            'contents' => [
                ['role' => 'user', 'parts' => [['text' => $systemPrompt . "\n\n" . $prompt]]]
            ],
            'generationConfig' => [
                'temperature'     => $options['temperature'] ?? $provider->temperature,
                'maxOutputTokens' => $options['max_tokens'] ?? $provider->max_tokens,
                'responseMimeType' => 'application/json', // force JSON natif
            ],
        ],
        'cloudflare' => [
            'messages'   => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $prompt],
            ],
            'max_tokens'  => $options['max_tokens'] ?? $provider->max_tokens,
            'temperature' => $options['temperature'] ?? $provider->temperature,
        ],
        'mistral' => [
            'model'           => $provider->model,
            'temperature'     => $options['temperature'] ?? $provider->temperature,
            'max_tokens'      => $options['max_tokens'] ?? $provider->max_tokens,
            'response_format' => ['type' => 'json_object'], // force JSON strict
            'messages'        => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $prompt],
            ],
        ],
        default => [
            'model'       => $provider->model,
            'temperature' => $options['temperature'] ?? $provider->temperature,
            'max_tokens'  => $options['max_tokens'] ?? $provider->max_tokens,
            'messages'    => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $prompt],
            ],
        ],
    };
}
    /**
     * Parse la réponse selon le provider
     */
    private function parseResponse(LlmConfiguration $provider, $response): ?array
    {
        $raw = match($provider->provider) {
            'google_ai' => $response->json('candidates.0.content.parts.0.text', ''),
            'cloudflare' => $response->json('result.response', ''),
            default => $response->json('choices.0.message.content', ''),
        };

        if (empty($raw)) {
            return null;
        }

        // Nettoyer et parser le JSON
        $clean = preg_replace('/```json|```/i', '', $raw);
        $clean = trim($clean);
        
        // Tenter de parser le JSON
        $parsed = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Si le JSON est invalide, essayer de réparer les JSON tronqués
            $parsed = $this->attemptJsonRepair($clean);
            
            if ($parsed === null) {
                return null;
            }
        }

        return $parsed;
    }

    /**
     * Tente de réparer un JSON tronqué ou malformé
     */
    private function attemptJsonRepair(string $jsonString): ?array
    {
        // Si la chaîne se termine par des guillemets ouvrants non fermés
        if (substr_count($jsonString, '"') % 2 !== 0) {
            $jsonString .= '"';
        }
        
        // Si les accolades ne sont pas équilibrées
        $openBraces = substr_count($jsonString, '{');
        $closeBraces = substr_count($jsonString, '}');
        
        if ($openBraces > $closeBraces) {
            $jsonString .= str_repeat('}', $openBraces - $closeBraces);
        }
        
        // Si les crochets ne sont pas équilibrés
        $openBrackets = substr_count($jsonString, '[');
        $closeBrackets = substr_count($jsonString, ']');
        
        if ($openBrackets > $closeBrackets) {
            $jsonString .= str_repeat(']', $openBrackets - $closeBrackets);
        }
        
        // Tenter de parser à nouveau
        $parsed = json_decode($jsonString, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            return $parsed;
        }
        
        return null;
    }

    /**
     * Test la connexion à tous les providers actifs
     */
    public function testConnections(): array
    {
        $results = [];
        $providers = LlmConfiguration::getActiveProviders()->get();

        foreach ($providers as $provider) {
            if (!$provider->hasApiKey()) {
                $results[$provider->provider] = [
                    'available' => false,
                    'error' => 'API key not configured'
                ];
                continue;
            }

            $result = $this->callProvider($provider, 'Test message - respond with {"status":"ok"}', ['max_tokens' => 50]);
            $results[$provider->provider] = [
                'available' => $result['success'],
                'error' => $result['error'] ?? null
            ];
        }

        return $results;
    }

    /**
     * Obtient les statistiques d'utilisation
     */
    public function getUsageStats(): array
    {
        $providers = LlmConfiguration::get()
            ->map(function ($provider) {
                return [
                    'provider' => $provider->provider,
                    'display_name' => $provider->display_name,
                    'model' => $provider->model,
                    'is_primary' => $provider->is_primary,
                    'is_active' => $provider->is_active,
                    'priority_order' => $provider->priority_order,
                    'usage_count' => $provider->usage_count,
                    'success_count' => $provider->success_count,
                    'failure_count' => $provider->failure_count,
                    'success_rate' => $provider->success_rate,
                    'last_used_at' => $provider->last_used_at,
                    'last_error' => $provider->last_error,
                    'has_api_key' => $provider->hasApiKey(),
                ];
            });

        return [
            'providers' => $providers->toArray(),
            'total_usage' => $providers->sum('usage_count'),
            'primary_provider' => $providers->where('is_primary', true)->first(),
        ];
    }

    /**
     * Change le provider principal
     */
    public function setPrimaryProvider(string $providerName): bool
    {
        $provider = LlmConfiguration::where('provider', $providerName)->first();
        
        if (!$provider) {
            return false;
        }

        $provider->setAsPrimary();
        return true;
    }

    /**
     * Met à jour l'ordre des providers
     */
    public function updateProviderOrder(array $orderedProviders): bool
    {
        try {
            foreach ($orderedProviders as $index => $providerName) {
                LlmConfiguration::where('provider', $providerName)
                    ->update(['priority_order' => $index + 1]);
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update provider order', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Enregistre les métriques de performance pour le monitoring
     */
    private function recordPerformanceMetrics(LlmConfiguration $provider, array $result, bool $success): void
    {
        $metrics = [
            'provider' => $provider->provider,
            'model' => $provider->model,
            'success' => $success,
            'response_time_ms' => $result['response_time_ms'] ?? null,
            'error_type' => $this->getErrorType($result['error'] ?? null),
            'timestamp' => now()->toISOString(),
            'success_rate' => $provider->success_rate,
            'usage_count' => $provider->usage_count,
            'failure_count' => $provider->failure_count
        ];

        // Stocker les métriques en cache pour consultation
        $cacheKey = "ai_metrics_{$provider->provider}";
        $existingMetrics = Cache::get($cacheKey, []);
        
        // Garder seulement les 100 dernières métriques pour éviter la surcharge
        $existingMetrics[] = $metrics;
        if (count($existingMetrics) > 100) {
            $existingMetrics = array_slice($existingMetrics, -100);
        }
        
        Cache::put($cacheKey, $existingMetrics, 3600); // 1 heure

        // Log pour monitoring externe
        Log::info('AI Performance Metrics', $metrics);

        // Vérifier si une alerte doit être déclenchée
        $this->checkPerformanceAlerts($provider, $metrics);
    }

    /**
     * Détermine le type d'erreur pour le monitoring
     */
    private function getErrorType(?string $error): string
    {
        if (!$error) return 'none';
        
        $errorLower = strtolower($error);
        
        if (str_contains($errorLower, 'quota') || str_contains($errorLower, 'rate limit')) {
            return 'quota_exceeded';
        }
        
        if (str_contains($errorLower, 'timeout') || str_contains($errorLower, 'connection')) {
            return 'network';
        }
        
        if (str_contains($errorLower, 'api key') || str_contains($errorLower, 'unauthorized')) {
            return 'authentication';
        }
        
        if (str_contains($errorLower, '500') || str_contains($errorLower, '502') || str_contains($errorLower, '503')) {
            return 'server_error';
        }
        
        return 'unknown';
    }

    /**
     * Vérifie si des alertes de performance doivent être déclenchées
     */
    private function checkPerformanceAlerts(LlmConfiguration $provider, array $metrics): void
    {
        $alerts = [];

        // Alertes sur le taux de succès
        if ($metrics['success_rate'] < 50 && $metrics['usage_count'] > 10) {
            $alerts[] = [
                'type' => 'warning',
                'provider' => $provider->provider,
                'message' => "Taux de succès faible: {$metrics['success_rate']}%",
                'metric' => 'success_rate',
                'value' => $metrics['success_rate']
            ];
        }

        // Alertes sur les temps de réponse
        if ($metrics['response_time_ms'] && $metrics['response_time_ms'] > 5000) {
            $alerts[] = [
                'type' => 'warning',
                'provider' => $provider->provider,
                'message' => "Temps de réponse élevé: {$metrics['response_time_ms']}ms",
                'metric' => 'response_time',
                'value' => $metrics['response_time_ms']
            ];
        }

        // Alertes sur les erreurs d'authentification
        if ($metrics['error_type'] === 'authentication') {
            $alerts[] = [
                'type' => 'critical',
                'provider' => $provider->provider,
                'message' => 'Problème d\'authentification détecté',
                'metric' => 'authentication_error',
                'value' => 1
            ];
        }

        // Stocker les alertes
        if (!empty($alerts)) {
            $existingAlerts = Cache::get('ai_performance_alerts', []);
            $existingAlerts = array_merge($existingAlerts, $alerts);
            
            // Garder seulement les 50 dernières alertes
            if (count($existingAlerts) > 50) {
                $existingAlerts = array_slice($existingAlerts, -50);
            }
            
            Cache::put('ai_performance_alerts', $existingAlerts, 3600);
            
            // Log des alertes critiques
            foreach ($alerts as $alert) {
                if ($alert['type'] === 'critical') {
                    Log::critical('AI Performance Alert', $alert);
                }
            }
        }
    }

    /**
     * Obtient les métriques récentes pour un provider
     */
    public function getRecentMetrics(string $provider): array
    {
        $cacheKey = "ai_metrics_{$provider}";
        return Cache::get($cacheKey, []);
    }

    /**
     * Obtient toutes les alertes de performance
     */
    public function getPerformanceAlerts(): array
    {
        return Cache::get('ai_performance_alerts', []);
    }

    /**
     * Calcule les statistiques de performance pour un provider
     */
    public function getPerformanceStats(string $provider): array
    {
        $metrics = $this->getRecentMetrics($provider);
        
        if (empty($metrics)) {
            return [
                'provider' => $provider,
                'message' => 'No metrics available',
                'stats' => []
            ];
        }

        $responseTimes = array_filter(array_column($metrics, 'response_time_ms'));
        $successCount = count(array_filter($metrics, fn($m) => $m['success']));
        $totalCount = count($metrics);

        return [
            'provider' => $provider,
            'period' => [
                'start' => $metrics[0]['timestamp'] ?? null,
                'end' => $metrics[count($metrics) - 1]['timestamp'] ?? null,
                'total_requests' => $totalCount
            ],
            'stats' => [
                'success_rate' => $totalCount > 0 ? round(($successCount / $totalCount) * 100, 2) : 0,
                'avg_response_time_ms' => !empty($responseTimes) ? round(array_sum($responseTimes) / count($responseTimes), 2) : null,
                'min_response_time_ms' => !empty($responseTimes) ? min($responseTimes) : null,
                'max_response_time_ms' => !empty($responseTimes) ? max($responseTimes) : null,
                'error_types' => array_count_values(array_column($metrics, 'error_type'))
            ]
        ];
    }
}
