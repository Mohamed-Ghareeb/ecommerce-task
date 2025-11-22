<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\DashboardStatisticsController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        // statistics endpoint
        Route::get('dashboard/statistics', DashboardStatisticsController::class);

        // product endpoints
        Route::apiResource('products', ProductController::class);

        // Cart endpoints
        Route::prefix('cart')->group(function () {
            Route::get('get', [CartController::class, 'index']);
            Route::post('add', [CartController::class, 'add']);
            Route::post('remove', [CartController::class, 'remove']);
            Route::post('update', [CartController::class, 'update']);
            Route::post('clear', [CartController::class, 'clear']);
        });

        // checkout endpoint
        Route::post('checkout', CheckoutController::class);
    });
});
