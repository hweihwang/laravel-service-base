<?php

declare(strict_types=1);

return [
    'connection' => [
        'host' => env('ELASTIC_HOST', 'localhost'),
        'port' => env('ELASTIC_PORT', 9200),
        'scheme' => env('ELASTIC_SCHEME', 'http'),
    ],

    'auth' => [
        'username' => env('ELASTIC_USERNAME', ''),
        'password' => env('ELASTIC_PASSWORD', ''),
    ],

    'ssl_verification' => env('ELASTIC_SSL_VERIFICATION', false),

    'indexes' => [],

    'prune_old_aliases' => true,
];
