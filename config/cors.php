<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:8000',
        'https://drone-production-59a0.up.railway.app',
        'https://your-production-domain.com', // رابط الاستضافة الفعلية
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['Authorization', 'Content-Type'],

    'max_age' => 0,

    'supports_credentials' => true,

];
