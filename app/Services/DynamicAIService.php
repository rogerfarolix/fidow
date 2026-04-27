<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\LlmConfiguration;

class DynamicAIService
{
    /**
     * Génère du texte via les providers configurés dynamiquement
     */
    public function generateText(string $prompt, array $options = []): array
    {
        try {
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
                    return $result;
                }
                
                // Enregistrer l'échec et continuer avec le suivant
                $provider->recordUsage(false, $result['error'] ?? 'Unknown error');
                Log::warning("Provider {$provider->provider} failed, trying next", [
                    'error' => $result['error'] ?? 'Unknown error'
                ]);
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
}
