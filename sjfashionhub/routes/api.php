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
