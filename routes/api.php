<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;

Route::middleware('apikey')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('variant', ProductVariantController::class);
    Route::apiResource('cart', CartController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('order_item', OrderItemController::class);
    Route::get('order/track/{track_number}', [OrderController::class, 'track']);
});