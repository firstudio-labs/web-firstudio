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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
    ],

    'deepseek' => [
        'api_key' => env('DEEPSEEK_API_KEY'),
    ],

    'openrouter' => [
        'api_key' => env('OPENROUTER_API_KEY'),
        // Opsional namun direkomendasikan oleh OpenRouter untuk identitas aplikasi
        'referer' => env('OPENROUTER_REFERER', ''), // contoh: https://your-domain.com
        'app_title' => env('OPENROUTER_APP_TITLE', 'Firstudio Starter'),
    ],

    'ai' => [
        'preferred_provider' => env('AI_PREFERRED_PROVIDER', 'openrouter'),
        // OpenRouter sebagai provider utama, DeepSeek sebagai fallback
        'enabled_providers' => ['openrouter', 'deepseek'],
        'model_rotation' => env('AI_MODEL_ROTATION', true),
    ],

    'hcaptcha' => [
        'site_key' => env('HCAPTCHA_SITE_KEY'),
        'secret_key' => env('HCAPTCHA_SECRET_KEY'),
    ],

];
