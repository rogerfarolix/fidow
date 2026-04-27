<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LlmConfiguration;

class LlmConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            [
                'provider'        => 'groq',
                'display_name'    => 'Groq (Llama 3.3)',
                'model'           => 'llama-3.3-70b-versatile',
                'api_url'         => 'https://api.groq.com/openai/v1/chat/completions',
                'is_active'       => true,
                'priority_order'  => 1,
                'is_primary'      => true,
                'max_tokens'      => 8192,
                'temperature'     => 0.7,
                'timeout_seconds' => 30,
            ],
            [
                'provider'        => 'cerebras',
                'display_name'    => 'Cerebras Llama',
                'model'           => 'llama3.1-8b',
                'api_url'         => 'https://api.cerebras.ai/v1/chat/completions',
                'is_active'       => true,
                'priority_order'  => 2,
                'is_primary'      => false,
                'max_tokens'      => 4096,
                'temperature'     => 0.7,
                'timeout_seconds' => 30,
            ],
            [
                'provider'        => 'mistral',
                'display_name'    => 'Mistral Small',
                'model'           => 'mistral-small-latest', // supporte response_format JSON
                'api_url'         => 'https://api.mistral.ai/v1/chat/completions',
                'is_active'       => true,
                'priority_order'  => 3,
                'is_primary'      => false,
                'max_tokens'      => 4096,
                'temperature'     => 0.7,
                'timeout_seconds' => 30,
            ],
            [
                'provider'        => 'google_ai',
                'display_name'    => 'Google Gemini Flash',
                'model'           => 'gemini-2.0-flash', // gemini-1.5-flash retiré de v1beta
                'api_url'         => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',
                'is_active'       => false, // Désactivé temporairement à cause du quota exceeded
                'priority_order'  => 4,
                'is_primary'      => false,
                'max_tokens'      => 2048,
                'temperature'     => 0.7,
                'timeout_seconds' => 30,
            ],
            [
                'provider'        => 'cloudflare',
                'display_name'    => 'Cloudflare Workers AI',
                'model'           => '@cf/meta/llama-3.1-8b-instruct', // disponible sur tier gratuit
                'api_url'         => 'https://api.cloudflare.com/client/v4/accounts/CF_ACCOUNT/ai/run/@cf/meta/llama-3.1-8b-instruct',
                'is_active'       => true,
                'priority_order'  => 4, // Passé en priorité 4 après désactivation de Google AI
                'is_primary'      => false,
                'max_tokens'      => 4096,
                'temperature'     => 0.7,
                'timeout_seconds' => 30,
            ],
        ];

        foreach ($providers as $data) {
            LlmConfiguration::updateOrCreate(
                ['provider' => $data['provider']],
                $data
            );
        }

        LlmConfiguration::where('provider', 'deepseek')->delete();
    }
}