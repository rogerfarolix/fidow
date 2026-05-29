<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'groq' => [
        'key' => env('GROQ_API_KEY'),
    ],
    'mistral' => [
        'api_key' => env('MISTRAL_API_KEY'),
    ],
    'google_ai' => [
        'api_key' => env('GOOGLE_AI_API_KEY'),
    ],
    'cloudflare' => [
        'api_key'    => env('CLOUDFLARE_API_KEY'),
        'account_id' => env('CLOUDFLARE_ACCOUNT_ID'),
    ],
    'cerebras' => [
        'api_key' => env('CEREBRAS_API_KEY'),
    ],

    // RapidAPI — clé unique valable pour toutes les APIs souscrites
    'rapidapi' => [
        'key' => env('RAPIDAPI_KEY'),
        // Mots-clés LinkedIn (séparés par virgule). Chaque terme = 1 requête API.
        'linkedin_keywords' => env(
            'RAPIDAPI_LINKEDIN_KEYWORDS',
            'remote developer,remote designer,remote data scientist,remote marketing,remote product manager,remote devops'
        ),
        // Requêtes Google Jobs (séparées par |)
        'websearch_queries' => env(
            'RAPIDAPI_WEBSEARCH_QUERIES',
            'remote developer engineer jobs site:greenhouse.io OR site:lever.co OR site:jobs.ashbyhq.com|remote designer ux ui jobs site:greenhouse.io OR site:lever.co|remote data scientist machine learning jobs site:greenhouse.io OR site:lever.co|remote marketing seo growth jobs site:greenhouse.io OR site:lever.co'
        ),
    ],
];
