<?php

/*
 * This file is part of jwt-auth.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'secret' => env('JWT_SECRET'),

    'keys' => [
        'public' => env('JWT_PUBLIC_KEY'),

        'private' => env('JWT_PRIVATE_KEY'),

        'passphrase' => env('JWT_PASSPHRASE'),

    ],

    'ttl' => env('JWT_TTL', 10080),

    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),

    'algo' => env('JWT_ALGO', 'HS256'),

    'required_claims' => [
        'iss',
        'iat',
        'exp',
        'nbf',
        'sub',
        'jti',
    ],

    'persistent_claims' => [
        // 'foo',
        // 'bar',
    ],

    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', false),

    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),

    'providers' => [
        'jwt' => PHPOpenSourceSaver\JWTAuth\Providers\JWT\Namshi::class,

        'auth' => PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate::class,

        'storage' => PHPOpenSourceSaver\JWTAuth\Providers\Storage\Illuminate::class,
    ],
];
