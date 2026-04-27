<?php
// config/ai.php

return [
    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default AI provider that will be used by the
    | AI service. Options: 'deepseek', 'groq', 'hybrid'
    |
    */
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'hybrid'),

    /*
    |--------------------------------------------------------------------------
    | AI Providers Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for different AI providers
    |
    */
    'providers' => [
        'deepseek' => [
            'api_key' => env('DEEPSEEK_API_KEY'),
            'model' => 'deepseek-chat',
            'max_tokens' => 4096,
            'temperature' => 0.7,
        ],
        
        'groq' => [
            'key' => env('GROQ_API_KEY'),
            'model' => 'llama-3.3-70b-versatile',
            'max_tokens' => 8192,
            'temperature' => 0.7,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Strategy
    |--------------------------------------------------------------------------
    |
    | Configure how the service should handle provider failures
    |
    */
    'fallback' => [
        'enabled' => true,
        'timeout' => 30, // seconds
        'retry_attempts' => 2,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache AI responses to improve performance and reduce costs
    |
    */
    'cache' => [
        'enabled' => env('AI_CACHE_ENABLED', true),
        'ttl' => env('AI_CACHE_TTL', 3600), // 1 hour
        'prefix' => 'ai_response:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for AI API calls
    |
    */
    'rate_limit' => [
        'enabled' => true,
        'requests_per_minute' => 60,
        'requests_per_hour' => 1000,
    ],
];
