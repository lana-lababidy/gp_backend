<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the AI ranking service that provides urgency 
    | classification for aid requests using machine learning.
    |
    */

    'base_url' => env('AI_SERVICE_URL', 'http://localhost:5000'),
    
    'auth_token' => env('AI_SERVICE_TOKEN', 'aidranker_secure'),
    
    'timeout' => env('AI_SERVICE_TIMEOUT', 30),
    
    'endpoints' => [
        'rank' => '/rank',
        'health' => '/health',
    ],
];