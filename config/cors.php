<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // تأكدي أن الـ API و CSRF مسموح لهم

    'allowed_methods' => ['*'], // السماح بكل الطرق: GET, POST, PUT, DELETE, إلخ

    'allowed_origins' => [
        'http://localhost:8001', // التطوير المحلي
        'https://drone-production-59a0.up.railway.app', // رابط Railway
        'http://drone-production-59a0.up.railway.app', // رابط Railway
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // السماح بكل الهيدرز

    'exposed_headers' => ['Authorization', 'Content-Type'], // الهيدرز التي يمكن للـ frontend قراءتها

    'max_age' => 0,

    'supports_credentials' => true, // دعم الكوكيز والجلسات

];
