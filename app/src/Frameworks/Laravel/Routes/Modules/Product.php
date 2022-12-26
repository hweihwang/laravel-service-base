<?php

use Applications\CMS\Sku\Transports\API\Controllers\SkuController;
use Applications\CMS\Sku\Transports\API\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;
use Modules\Product\Transports\API\Controllers\ProductController;

$prefix = 'products';
$middlewares = ['api', 'auth:api'];
$v1Prefix = $prefix . '/' . 'v1';

Route::group(['prefix' => $v1Prefix, 'middleware' => $middlewares],
    static function () {
        Route::post('list', [ProductController::class, 'list']);
        Route::post('', [ProductController::class, 'create']);
        Route::patch('{productId}', [ProductController::class, 'update']);
        Route::get('{productId}', [ProductController::class, 'detail']);
    });
