<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Transports\API\Controllers\ProductController;

$prefix = 'products/api/v1';
$middlewares = ['api', 'auth:api'];

Route::group(['prefix' => $prefix, 'middleware' => $middlewares],
    static function () {
        Route::post('list', [ProductController::class, 'list']);
        Route::post('', [ProductController::class, 'create']);
        Route::patch('{productId}', [ProductController::class, 'update']);
        Route::get('{productId}', [ProductController::class, 'detail']);
    });
