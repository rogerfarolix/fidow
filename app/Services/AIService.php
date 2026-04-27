<?php
// app/Services/AIService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    private string $provider;
    private array $config;

    public function __construct()
    {
        $this->provider = config('ai.default_provider', 'groq');
        $this->config = $this->getProviderConfig();
    }

public function generateText(string $prompt, array $options = []): array
{
    try {
        // Mistral en premier
        if (in_array($this->provider, ['mistral', 'hybrid'])) {
            $result = $this->callMistral($prompt, $options);
            if ($result['success']) return $result;
            Log::warning('Mistral failed, falling back to Groq', ['error' => $result['error'] ?? '']);
        }

        // Groq en fallback (toujours gratuit et fiable)
        $result = $this->callGroq($prompt, $options);
        if ($result['success']) return $result;

        throw new \Exception('All AI providers failed');

    } catch (\Exception $e) {
        Log::error('AI Service error', ['message' => $e->getMessage()]);
        return [
            'success' => false,
            'error'   => 'Service IA temporairement indisponible. Réessaie dans quelques minutes.'
        ];
    }
}

private function callMistral(string $prompt, array $options = []): array
{
    $apiKey = config('services.mistral.api_key');
    if (!$apiKey) return ['success' => false, 'error' => 'Mistral API key not configured'];

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(30)->post('https://api.mistral.ai/v1/chat/completions', [
            'model'       => 'open-mistral-7b',   // ← mistral-tiny est déprécié
            'temperature' => $options['temperature'] ?? 0.7,
            'max_tokens'  => $options['max_tokens'] ?? 1024,
            'messages'    => [
                ['role' => 'system', 'content' => 'Tu réponds UNIQUEMENT en JSON valide, sans texte additionnel.'],
                ['role' => 'user',   'content' => $prompt],
            ],
        ]);

        if (!$response->successful()) {
            return ['success' => false, 'error' => "Mistral API error: {$response->status()}"];
        }

        $raw    = $response->json('choices.0.message.content', '');
        $clean  = trim(preg_replace('/```json|```/i', '', $raw));
        $parsed = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error' => 'Invalid JSON response from Mistral'];
        }

        return ['success' => true, 'data' => $parsed, 'provider' => 'mistral'];

    } catch (\Exception $e) {
        return ['success' => false, 'error' => 'Mistral connection failed: ' . $e->getMessage()];
    }
}

private function callGroq(string $prompt, array $options = []): array
{
    $apiKey = config('services.groq.key');
    if (!$apiKey) return ['success' => false, 'error' => 'Groq API key not configured'];

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => 'llama-3.3-70b-versatile',
            'temperature' => $options['temperature'] ?? 0.7,
            'max_tokens'  => $options['max_tokens'] ?? 1024,
            'messages'    => [
                ['role' => 'system', 'content' => 'Tu réponds UNIQUEMENT en JSON valide, sans texte additionnel.'],
                ['role' => 'user',   'content' => $prompt],
            ],
        ]);

        if (!$response->successful()) {
            return ['success' => false, 'error' => "Groq API error: {$response->status()}"];
        }

        $raw    = $response->json('choices.0.message.content', '');
        $clean  = trim(preg_replace('/```json|```/i', '', $raw));
        $parsed = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error' => 'Invalid JSON response from Groq'];
        }

        return ['success' => true, 'data' => $parsed, 'provider' => 'groq'];

    } catch (\Exception $e) {
        return ['success' => false, 'error' => 'Groq connection failed: ' . $e->getMessage()];
    }
}

    /**
     * Récupère la configuration du provider
     */
    private function getProviderConfig(): array
    {
        return match($this->provider) {
            'deepseek' => [
                'api_url' => 'https://api.deepseek.com/v1/chat/completions',
                'model' => 'deepseek-chat',
                'max_tokens' => 4096,
            ],
            'mistral' => [
                'api_url' => 'https://api.mistral.ai/v1/chat/completions',
                'model' => 'mistral-tiny',
                'max_tokens' => 4096,
            ],
            'groq' => [
                'api_url' => 'https://api.groq.com/openai/v1/chat/completions',
                'model' => 'llama-3.3-70b-versatile',
                'max_tokens' => 8192,
            ],
            default => []
        };
    }

    /**
     * Change le provider IA dynamiquement
     */
    public function setProvider(string $provider): self
    {
        $this->provider = $provider;
        $this->config = $this->getProviderConfig();
        return $this;
    }

    /**
     * Test la connexion à tous les providers
     */
    public function testConnections(): array
    {
        $results = [];
        
        // Test DeepSeek
        $deepseekResult = $this->callDeepSeek('Test message - respond with {"status":"ok"}', ['max_tokens' => 50]);
        $results['deepseek'] = [
            'available' => $deepseekResult['success'],
            'error' => $deepseekResult['error'] ?? null
        ];

        // Test Mistral
        $mistralResult = $this->callMistral('Test message - respond with {"status":"ok"}', ['max_tokens' => 50]);
        $results['mistral'] = [
            'available' => $mistralResult['success'],
            'error' => $mistralResult['error'] ?? null
        ];

        // Test Groq
        $groqResult = $this->callGroq('Test message - respond with {"status":"ok"}', ['max_tokens' => 50]);
        $results['groq'] = [
            'available' => $groqResult['success'],
            'error' => $groqResult['error'] ?? null
        ];

        return $results;
    }
}
