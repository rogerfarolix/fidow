<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\LlmConfiguration;

class HealthCheckService
{
    /**
     * Vérifie la santé de tous les providers IA
     */
    public function checkAllProviders(): array
    {
        $results = [];
        $providers = LlmConfiguration::getActiveProviders()->get();

        foreach ($providers as $provider) {
            $results[$provider->provider] = $this->checkProvider($provider);
        }

        return $results;
    }

    /**
     * Vérifie la santé d'un provider spécifique
     */
    public function checkProvider(LlmConfiguration $provider): array
    {
        $startTime = microtime(true);
        
        try {
            if (!$provider->hasApiKey()) {
                return $this->createHealthResult(
                    false,
                    'API key not configured',
                    0,
                    'critical'
                );
            }

            $testResult = $this->performHealthCheck($provider);
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);

            if ($testResult['success']) {
                $provider->recordUsage(true);
                return $this->createHealthResult(
                    true,
                    'Provider healthy',
                    $responseTime,
                    'healthy'
                );
            } else {
                $provider->recordUsage(false, $testResult['error']);
                return $this->createHealthResult(
                    false,
                    $testResult['error'],
                    $responseTime,
                    $this->determineSeverity($testResult['error'])
                );
            }

        } catch (\Exception $e) {
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Health check failed for {$provider->provider}", [
                'error' => $e->getMessage(),
                'response_time' => $responseTime
            ]);

            return $this->createHealthResult(
                false,
                'Health check exception: ' . $e->getMessage(),
                $responseTime,
                'critical'
            );
        }
    }

    /**
     * Effectue un test de santé minimal sur un provider
     */
    private function performHealthCheck(LlmConfiguration $provider): array
    {
        $dynamicAI = app(DynamicAIService::class);
        
        return $dynamicAI->callProvider(
            $provider,
            'Health check - respond with {"status":"ok"}',
            [
                'max_tokens' => 50,
                'temperature' => 0.1
            ]
        );
    }

    /**
     * Crée un résultat de santé standardisé
     */
    private function createHealthResult(bool $healthy, string $message, float $responseTime, string $severity): array
    {
        return [
            'healthy' => $healthy,
            'message' => $message,
            'response_time_ms' => $responseTime,
            'severity' => $severity,
            'checked_at' => now()->toISOString(),
            'status' => $healthy ? 'up' : 'down'
        ];
    }

    /**
     * Détermine la sévérité d'une erreur
     */
    private function determineSeverity(string $error): string
    {
        $errorLower = strtolower($error);

        // Quota exceeded -> warning
        if (str_contains($errorLower, 'quota') || str_contains($errorLower, 'rate limit')) {
            return 'warning';
        }

        // Timeout -> warning
        if (str_contains($errorLower, 'timeout') || str_contains($errorLower, 'connection')) {
            return 'warning';
        }

        // API key issues -> critical
        if (str_contains($errorLower, 'api key') || str_contains($errorLower, 'unauthorized')) {
            return 'critical';
        }

        // Server errors -> warning
        if (str_contains($errorLower, '500') || str_contains($errorLower, '502') || str_contains($errorLower, '503')) {
            return 'warning';
        }

        // Default -> critical
        return 'critical';
    }

    /**
     * Obtient le statut de santé global
     */
    public function getOverallHealth(): array
    {
        $cacheKey = 'ai_providers_health';
        $cacheTtl = 300; // 5 minutes

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $providerHealth = $this->checkAllProviders();
        
        $healthyCount = count(array_filter($providerHealth, fn($h) => $h['healthy']));
        $totalCount = count($providerHealth);
        $overallHealthy = $healthyCount > 0; // Au moins un provider fonctionnel

        $result = [
            'overall_healthy' => $overallHealthy,
            'healthy_providers' => $healthyCount,
            'total_providers' => $totalCount,
            'health_ratio' => $totalCount > 0 ? round(($healthyCount / $totalCount) * 100, 2) : 0,
            'providers' => $providerHealth,
            'checked_at' => now()->toISOString(),
            'status' => $overallHealthy ? 'healthy' : 'unhealthy'
        ];

        Cache::put($cacheKey, $result, $cacheTtl);
        
        return $result;
    }

    /**
     * Vérifie si des alertes doivent être déclenchées
     */
    public function checkAlerts(): array
    {
        $health = $this->getOverallHealth();
        $alerts = [];

        // Alertes critiques
        if (!$health['overall_healthy']) {
            $alerts[] = [
                'type' => 'critical',
                'message' => 'Aucun provider IA fonctionnel',
                'created_at' => now()->toISOString()
            ];
        }

        // Alertes warning
        if ($health['health_ratio'] < 50) {
            $alerts[] = [
                'type' => 'warning',
                'message' => 'Moins de 50% des providers IA fonctionnels',
                'created_at' => now()->toISOString()
            ];
        }

        // Alertes par provider
        foreach ($health['providers'] as $provider => $providerHealth) {
            if (!$providerHealth['healthy'] && $providerHealth['severity'] === 'critical') {
                $alerts[] = [
                    'type' => 'critical',
                    'message' => "Provider {$provider} critique: {$providerHealth['message']}",
                    'provider' => $provider,
                    'created_at' => now()->toISOString()
                ];
            }
        }

        return $alerts;
    }

    /**
     * Enregistre les métriques de monitoring
     */
    public function recordMetrics(): void
    {
        $health = $this->getOverallHealth();
        
        $metrics = [
            'ai_providers_healthy_count' => $health['healthy_providers'],
            'ai_providers_total_count' => $health['total_providers'],
            'ai_providers_health_ratio' => $health['health_ratio'],
            'ai_providers_overall_healthy' => $health['overall_healthy'] ? 1 : 0,
            'recorded_at' => now()->toISOString()
        ];

        // Stocker dans les logs pour monitoring externe
        Log::info('AI Providers Health Metrics', $metrics);

        // Optionnel: envoyer vers un service de monitoring externe
        $this->sendMetricsToMonitoring($metrics);
    }

    /**
     * Envoie les métriques vers un service de monitoring
     */
    private function sendMetricsToMonitoring(array $metrics): void
    {
        // Implémenter l'envoi vers des services comme:
        // - Prometheus Pushgateway
        // - DataDog
        // - New Relic
        // - Custom webhook
        
        // Pour l'instant, on stocke en cache pour consultation
        Cache::put('ai_health_metrics_last', $metrics, 3600);
    }

    /**
     * Obtient les métriques récentes
     */
    public function getRecentMetrics(): array
    {
        return Cache::get('ai_health_metrics_last', [
            'message' => 'No metrics available',
            'recorded_at' => null
        ]);
    }
}
