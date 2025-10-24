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

// ==================== AMAZCART COMPATIBLE API ROUTES ====================

// Public routes (no authentication required)
Route::prefix('api')->group(function () {
    // ========== AUTHENTICATION ==========
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/social-login', [App\Http\Controllers\Api\AuthController::class, 'socialLogin']);
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
    Route::post('/general-setting/send-otp', [App\Http\Controllers\Api\OtpController::class, 'sendOtp']);

    // ========== HOME & CONTENT ==========
    Route::get('/homepage-data', [App\Http\Controllers\Api\HomeController::class, 'homepageData']);
Route::get('/mobile-home-data', [App\Http\Controllers\Api\HomeController::class, 'mobileHomeData']);
    Route::get('/general-settings', [App\Http\Controllers\Api\SettingsController::class, 'generalSettings']);
    Route::get('/appearance/sliders', [App\Http\Controllers\Api\SliderController::class, 'index']);

    // ========== PRODUCTS & CATALOG ==========
    Route::get('/seller/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/seller/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);
    Route::post('/seller/product/get-sku-wise-price', [App\Http\Controllers\Api\ProductController::class, 'getSkuWisePrice']);
    Route::get('/seller/product/recomanded-product', [App\Http\Controllers\Api\ProductController::class, 'recommended']);
    Route::get('/seller/product/top-picks', [App\Http\Controllers\Api\ProductController::class, 'topPicks']);
    Route::post('/seller/product/sort-before-filter', [App\Http\Controllers\Api\ProductController::class, 'sortBeforeFilter']);
    Route::post('/seller/product/filter/fetch-data', [App\Http\Controllers\Api\ProductController::class, 'filterFetchData']);
    Route::post('/seller/product/filter/filter-product-page-by-type', [App\Http\Controllers\Api\ProductController::class, 'filterByType']);
    Route::post('/seller/filter-by-type', [App\Http\Controllers\Api\SellerController::class, 'filterByType']);

    // ========== CATEGORIES & BRANDS ==========
    Route::get('/product/category', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('/product/category/filter/top', [App\Http\Controllers\Api\CategoryController::class, 'topCategories']);
    Route::get('/product/category/{categoryId}', [App\Http\Controllers\Api\CategoryController::class, 'getProductsByCategory']);
    Route::get('/product/brand', [App\Http\Controllers\Api\BrandController::class, 'index']);
    Route::get('/product/tag', [App\Http\Controllers\Api\TagController::class, 'singleTagProducts']);

    // ========== SEARCH ==========
    Route::post('/live-search', [App\Http\Controllers\Api\SearchController::class, 'liveSearch']);

    // ========== MARKETING ==========
    Route::get('/marketing/new-user-zone', [App\Http\Controllers\Api\MarketingController::class, 'newUserZone']);
    Route::get('/marketing/flash-deal', [App\Http\Controllers\Api\MarketingController::class, 'flashDeal']);
    Route::get('/marketing/new-user-zone/{slug}/fetch-product-data', [App\Http\Controllers\Api\MarketingController::class, 'fetchNewUserProductData']);
    Route::get('/marketing/new-user-zone/{slug}/fetch-all-category-data', [App\Http\Controllers\Api\MarketingController::class, 'fetchNewUserCategoryAllProducts']);
    Route::get('/marketing/new-user-zone/{slug}/fetch-all-coupon-category-data', [App\Http\Controllers\Api\MarketingController::class, 'fetchNewUserCouponAllProducts']);
    Route::get('/marketing/new-user-zone/{slug}/fetch-category-data', [App\Http\Controllers\Api\MarketingController::class, 'fetchNewUserCategoryProducts']);
    Route::get('/marketing/new-user-zone/{slug}/fetch-coupon-category-data', [App\Http\Controllers\Api\MarketingController::class, 'fetchNewUserCouponProducts']);

    // ========== LOCATION ==========
    Route::get('/location/country', [App\Http\Controllers\Api\LocationController::class, 'countries']);
    Route::get('/location/country/{id}/states', [App\Http\Controllers\Api\LocationController::class, 'states']);
    Route::get('/location/state/{id}/cities', [App\Http\Controllers\Api\LocationController::class, 'cities']);

    // ========== PAYMENT GATEWAYS ==========
    Route::get('/payment-gateway', [App\Http\Controllers\Api\PaymentController::class, 'gateways']);
    Route::get('/payment-gateway/bank/bank-info', [App\Http\Controllers\Api\PaymentController::class, 'bankInfo']);

    // ========== SUPPORT ==========
    Route::get('/ticket/categories', [App\Http\Controllers\Api\SupportController::class, 'categories']);
    Route::get('/ticket/priorities', [App\Http\Controllers\Api\SupportController::class, 'priorities']);

    // ========== CONFIGURATION ==========
    Route::get('/currency-list', [App\Http\Controllers\Api\SettingsController::class, 'currencies']);
    Route::get('/shipping-lists', [App\Http\Controllers\Api\SettingsController::class, 'shippingMethods']);
    Route::get('/get-lang', [App\Http\Controllers\Api\LanguageController::class, 'getLanguage']);
    Route::post('/set-lang', [App\Http\Controllers\Api\LanguageController::class, 'setLanguage']);

    // ========== GIFT CARDS ==========
    Route::get('/gift-card/list', [App\Http\Controllers\Api\GiftCardController::class, 'index']);
    Route::get('/gift-card', [App\Http\Controllers\Api\GiftCardController::class, 'show']);
});

// Protected routes (authentication required)
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // ========== AUTHENTICATION ==========
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/get-user', [App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);
    Route::delete('/customer-delete', [App\Http\Controllers\Api\AuthController::class, 'deleteAccount']);

    // ========== PROFILE ==========
    Route::post('/profile/update-information', [App\Http\Controllers\Api\ProfileController::class, 'updateInformation']);
    Route::post('/profile/update-photo', [App\Http\Controllers\Api\ProfileController::class, 'updatePhoto']);
    Route::get('/profile/get-customer-data', [App\Http\Controllers\Api\ProfileController::class, 'getCustomerData']);

    // ========== ADDRESS MANAGEMENT ==========
    Route::get('/profile/address-list', [App\Http\Controllers\Api\AddressController::class, 'index']);
    Route::post('/profile/address-store', [App\Http\Controllers\Api\AddressController::class, 'store']);
    Route::put('/profile/address-update/{id}', [App\Http\Controllers\Api\AddressController::class, 'update']);
    Route::delete('/profile/address-delete', [App\Http\Controllers\Api\AddressController::class, 'destroy']);
    Route::post('/profile/default-billing-address', [App\Http\Controllers\Api\AddressController::class, 'setDefaultBilling']);
    Route::post('/profile/default-shipping-address', [App\Http\Controllers\Api\AddressController::class, 'setDefaultShipping']);

    // ========== SHOPPING CART ==========
    Route::get('/cart', [App\Http\Controllers\Api\CartController::class, 'index']);
    Route::post('/cart', [App\Http\Controllers\Api\CartController::class, 'store']);
    Route::post('/cart/update-qty', [App\Http\Controllers\Api\CartController::class, 'updateQuantity']);
    Route::post('/cart/select-all', [App\Http\Controllers\Api\CartController::class, 'selectAll']);
    Route::post('/cart/select-seller-item', [App\Http\Controllers\Api\CartController::class, 'selectSellerItems']);
    Route::post('/cart/select-item', [App\Http\Controllers\Api\CartController::class, 'selectItem']);
    Route::delete('/cart/remove-all', [App\Http\Controllers\Api\CartController::class, 'removeAll']);
    Route::delete('/cart/remove', [App\Http\Controllers\Api\CartController::class, 'removeItem']);
    Route::post('/cart/update-shipping-method', [App\Http\Controllers\Api\CartController::class, 'updateShippingMethod']);

    // ========== CHECKOUT ==========
    Route::get('/checkout', [App\Http\Controllers\Api\CheckoutController::class, 'index']);
    Route::post('/checkout/check-price-update', [App\Http\Controllers\Api\CheckoutController::class, 'checkPriceUpdate']);
    Route::post('/checkout/coupon-apply', [App\Http\Controllers\Api\CheckoutController::class, 'applyCoupon']);
    Route::get('/tabby-checkout', [App\Http\Controllers\Api\CheckoutController::class, 'tabbyCheckout']);

    // ========== PAYMENT ==========
    Route::post('/payment-gateway/bank/payment-data-store', [App\Http\Controllers\Api\PaymentController::class, 'storeBankPaymentData']);

    // ========== ORDERS ==========
    Route::post('/order-store', [App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::post('/order-payment-info-store', [App\Http\Controllers\Api\OrderController::class, 'storePaymentInfo']);
    Route::get('/order-list', [App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::get('/order-by-delivery-status', [App\Http\Controllers\Api\OrderController::class, 'byDeliveryStatus']);
    Route::get('/delivery-processes', [App\Http\Controllers\Api\OrderController::class, 'deliveryProcesses']);
    Route::get('/order-pending-list', [App\Http\Controllers\Api\OrderController::class, 'pendingOrders']);
    Route::get('/order-cancel-list', [App\Http\Controllers\Api\OrderController::class, 'cancelledOrders']);
    Route::get('/order-refund-list', [App\Http\Controllers\Api\OrderController::class, 'refundOrders']);
    Route::get('/order-to-ship', [App\Http\Controllers\Api\OrderController::class, 'ordersToShip']);
    Route::get('/order-to-receive', [App\Http\Controllers\Api\OrderController::class, 'ordersToReceive']);
    Route::get('/order-review', [App\Http\Controllers\Api\OrderController::class, 'ordersForReview']);

    // ========== ORDER MANAGEMENT ==========
    Route::get('/order-manage/cancel-reason-list', [App\Http\Controllers\Api\OrderManageController::class, 'cancelReasons']);
    Route::post('/order-manage/cancel-store', [App\Http\Controllers\Api\OrderManageController::class, 'cancelOrder']);
    Route::get('/refund/reason-list', [App\Http\Controllers\Api\RefundController::class, 'reasonList']);
    Route::post('/order-refund/store', [App\Http\Controllers\Api\RefundController::class, 'store']);

    // ========== REVIEWS & RATINGS ==========
    Route::get('/order-review/waiting-for-review-list', [App\Http\Controllers\Api\ReviewController::class, 'waitingForReview']);
    Route::get('/order-review/list', [App\Http\Controllers\Api\ReviewController::class, 'myReviews']);

    // ========== WISHLIST ==========
    Route::get('/wishlist', [App\Http\Controllers\Api\WishlistController::class, 'index']);
    Route::delete('/wishlist/delete', [App\Http\Controllers\Api\WishlistController::class, 'destroy']);

    // ========== COUPONS ==========
    Route::get('/coupon', [App\Http\Controllers\Api\CouponController::class, 'myCoupons']);
    Route::delete('/coupon/delete', [App\Http\Controllers\Api\CouponController::class, 'deleteCoupon']);

    // ========== GIFT CARDS (PROTECTED) ==========
    Route::get('/gift-card/my-purchased/list', [App\Http\Controllers\Api\GiftCardController::class, 'myPurchased']);

    // ========== SELLER PROFILE ==========
    Route::get('/seller-profile', [App\Http\Controllers\Api\SellerController::class, 'profile']);

    // ========== NOTIFICATIONS ==========
    Route::get('/user-notifications', [App\Http\Controllers\Api\NotificationController::class, 'index']);
    Route::get('/user-notifications-setting', [App\Http\Controllers\Api\NotificationController::class, 'settings']);
    Route::post('/user-notifications-setting/update', [App\Http\Controllers\Api\NotificationController::class, 'updateSettings']);

    // ========== SUPPORT TICKETS ==========
    Route::get('/ticket-list-get-data', [App\Http\Controllers\Api\SupportController::class, 'ticketList']);
    Route::post('/ticket-store', [App\Http\Controllers\Api\SupportController::class, 'store']);
    Route::get('/ticket-show', [App\Http\Controllers\Api\SupportController::class, 'show']);
    Route::post('/ticket-show/reply', [App\Http\Controllers\Api\SupportController::class, 'reply']);

    // ========== IN-APP PURCHASE ==========
    Route::post('/in-app-cart-store', [App\Http\Controllers\Api\InAppController::class, 'cartStore']);
    Route::post('/order-store/in-app-purchase', [App\Http\Controllers\Api\InAppController::class, 'orderStore']);
    Route::delete('/in-app-cart-delete', [App\Http\Controllers\Api\InAppController::class, 'cartDelete']);
});

// ==================== MOBILE APP API ROUTES (LEGACY SUPPORT) ====================

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

// ========== MOBILE APP ROUTES ==========
Route::prefix('mobile')->group(function () {
    Route::get('/banners', [App\Http\Controllers\Api\MobileAppController::class, 'getBanners']);
    Route::get('/settings', [App\Http\Controllers\Api\MobileAppController::class, 'getSettings']);
    Route::get('/home-data', [App\Http\Controllers\Api\MobileAppController::class, 'getHomeData']);
});

// ========== WHATSAPP WEBHOOK ROUTES ==========
// WhatsApp webhook (no authentication - verified by Meta signature)
Route::get('/whatsapp/webhook', [App\Http\Controllers\Api\WhatsAppWebhookController::class, 'verify']);
Route::post('/whatsapp/webhook', [App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handle']);

// ========== ADMIN ROUTES ==========
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Banner Management
    Route::get('/banners', [App\Http\Controllers\Api\Admin\BannerController::class, 'index']);
    Route::post('/banners', [App\Http\Controllers\Api\Admin\BannerController::class, 'store']);
    Route::get('/banners/{id}', [App\Http\Controllers\Api\Admin\BannerController::class, 'show']);
    Route::put('/banners/{id}', [App\Http\Controllers\Api\Admin\BannerController::class, 'update']);
    Route::delete('/banners/{id}', [App\Http\Controllers\Api\Admin\BannerController::class, 'destroy']);
    Route::put('/banners/{id}/toggle-status', [App\Http\Controllers\Api\Admin\BannerController::class, 'toggleStatus']);
});
