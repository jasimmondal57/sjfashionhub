<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::post('/validate-coupon', [CouponController::class, 'validateCode'])->name('api.coupon.validate');

// User address routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/user/addresses', [\App\Http\Controllers\User\AddressController::class, 'getAddresses']);
});

// ==================== MOBILE APP API ROUTES ====================

// Public routes (no authentication required)
Route::prefix('mobile')->group(function () {
    // App configuration
    Route::get('/config', [App\Http\Controllers\Api\Mobile\ConfigController::class, 'index']);

    // Home data
    Route::get('/home', [App\Http\Controllers\Api\Mobile\HomeController::class, 'index']);

    // Products
    Route::get('/products', [App\Http\Controllers\Api\Mobile\ProductController::class, 'index']);
    Route::get('/products/{id}', [App\Http\Controllers\Api\Mobile\ProductController::class, 'show']);

    // Categories
    Route::get('/categories', [App\Http\Controllers\Api\Mobile\CategoryController::class, 'index']);
    Route::get('/categories/{id}', [App\Http\Controllers\Api\Mobile\CategoryController::class, 'show']);

    // Authentication
    Route::post('/auth/register', [App\Http\Controllers\Api\Mobile\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Api\Mobile\AuthController::class, 'login']);
});

// Protected routes (authentication required)
Route::prefix('mobile')->middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [App\Http\Controllers\Api\Mobile\AuthController::class, 'logout']);
    Route::get('/auth/user', [App\Http\Controllers\Api\Mobile\AuthController::class, 'user']);

    // Profile
    Route::get('/profile', [App\Http\Controllers\Api\Mobile\ProfileController::class, 'show']);
    Route::put('/profile', [App\Http\Controllers\Api\Mobile\ProfileController::class, 'update']);

    // Cart
    Route::get('/cart', [App\Http\Controllers\Api\Mobile\CartController::class, 'index']);
    Route::post('/cart', [App\Http\Controllers\Api\Mobile\CartController::class, 'store']);
    Route::put('/cart/{id}', [App\Http\Controllers\Api\Mobile\CartController::class, 'update']);
    Route::delete('/cart/{id}', [App\Http\Controllers\Api\Mobile\CartController::class, 'destroy']);
    Route::delete('/cart', [App\Http\Controllers\Api\Mobile\CartController::class, 'clear']);

    // Orders
    Route::get('/orders', [App\Http\Controllers\Api\Mobile\OrderController::class, 'index']);
    Route::get('/orders/{id}', [App\Http\Controllers\Api\Mobile\OrderController::class, 'show']);
    Route::post('/orders', [App\Http\Controllers\Api\Mobile\OrderController::class, 'store']);

    // Wishlist
    Route::get('/wishlist', [App\Http\Controllers\Api\Mobile\WishlistController::class, 'index']);
    Route::post('/wishlist', [App\Http\Controllers\Api\Mobile\WishlistController::class, 'store']);
    Route::delete('/wishlist/{productId}', [App\Http\Controllers\Api\Mobile\WishlistController::class, 'destroy']);

    // Device registration (for push notifications)
    Route::post('/devices', [App\Http\Controllers\Api\Mobile\DeviceController::class, 'register']);
});
