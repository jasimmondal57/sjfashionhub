<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Support\Facades\Route;

// Social Login Routes (MUST BE BEFORE EVERYTHING)
Route::get('social-auth/google/redirect', function() {
    return app(App\Http\Controllers\Auth\SocialLoginController::class)->redirect('google');
})->name('social.redirect.google');

Route::get('social-auth/google/callback', function() {
    return app(App\Http\Controllers\Auth\SocialLoginController::class)->callback('google');
})->name('social.callback.google');

Route::get('social-auth/facebook/redirect', function() {
    return app(App\Http\Controllers\Auth\SocialLoginController::class)->redirect('facebook');
})->name('social.redirect.facebook');

Route::get('social-auth/facebook/callback', function() {
    return app(App\Http\Controllers\Auth\SocialLoginController::class)->callback('facebook');
})->name('social.callback.facebook');

// WhatsApp Webhook Routes (must be before auth middleware)
Route::get('/webhook/whatsapp', [App\Http\Controllers\WebhookController::class, 'verifyWhatsApp'])->name('webhook.whatsapp.verify');
Route::post('/webhook/whatsapp', [App\Http\Controllers\WebhookController::class, 'handleWhatsApp'])->name('webhook.whatsapp.handle');
Route::post('/webhook/twilio-whatsapp', [App\Http\Controllers\WebhookController::class, 'handleTwilioWhatsApp'])->name('webhook.twilio-whatsapp');
Route::post('/webhook/msg91-whatsapp', [App\Http\Controllers\WebhookController::class, 'handleMsg91WhatsApp'])->name('webhook.msg91-whatsapp');

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Search Route
Route::get('/search', function () {
    $query = request('q');
    // For now, just redirect to products with search query
    // Later this can be implemented with actual product search
    return redirect()->route('products.index', ['search' => $query]);
})->name('search');

// Cart Routes (Public - accessible to all users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/calculate-shipping', [CartController::class, 'calculateShipping'])->name('cart.calculate-shipping');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Delivery Check Route
Route::post('/check-delivery', [App\Http\Controllers\DeliveryController::class, 'checkPincode'])->name('check.delivery');

// Shiprocket Webhook Routes (public - no auth required, IP whitelisted)
// Note: Cannot use keywords like "shiprocket", "kartrocket", "sr", or "kr" in URL
Route::post('/webhook/shipping-updates', [App\Http\Controllers\ShiprocketWebhookController::class, 'handle'])
    ->middleware('shiprocket.webhook')
    ->name('webhook.shiprocket');
Route::get('/webhook/shipping-updates/test', [App\Http\Controllers\ShiprocketWebhookController::class, 'test'])
    ->name('webhook.shiprocket.test');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Payment Routes
Route::get('/payment/{orderId}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{orderId}/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/{orderId}/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/{orderId}/failure', [App\Http\Controllers\PaymentController::class, 'failure'])->name('payment.failure');
Route::post('/payment/{orderId}/cod-fallback', [App\Http\Controllers\PaymentController::class, 'codFallback'])->name('payment.cod-fallback');
Route::post('/payment/update-status', [App\Http\Controllers\PaymentController::class, 'updateStatus'])->name('payment.update-status');
Route::post('/webhook/razorpay', [App\Http\Controllers\PaymentController::class, 'razorpayWebhook'])->name('webhook.razorpay');
Route::post('/webhook/cashfree', [App\Http\Controllers\PaymentController::class, 'cashfreeWebhook'])->name('webhook.cashfree');
Route::get('/webhook/cashfree/test', [App\Http\Controllers\PaymentController::class, 'cashfreeWebhookTest'])->name('webhook.cashfree.test');

// PayU specific routes
Route::post('/payment/payu/success', [App\Http\Controllers\PaymentController::class, 'payuSuccess'])->name('payment.payu.success');
Route::post('/payment/payu/failure', [App\Http\Controllers\PaymentController::class, 'payuFailure'])->name('payment.payu.failure');



// Newsletter routes
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// SEO routes (public)
Route::get('/sitemap.xml', function () {
    $sitemapPath = public_path('sitemap.xml');
    if (file_exists($sitemapPath)) {
        return response()->file($sitemapPath, [
            'Content-Type' => 'application/xml'
        ]);
    }
    return response('Sitemap not found', 404);
})->name('sitemap');

Route::get('/robots.txt', function () {
    $robotsPath = public_path('robots.txt');
    if (file_exists($robotsPath)) {
        return response()->file($robotsPath, [
            'Content-Type' => 'text/plain'
        ]);
    }
    return response('Robots.txt not found', 404);
})->name('robots');



// Wishlist routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');

    // Products
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/bulk-action', [App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])->name('products.bulk-action');

    // AI Product Details
    Route::post('ai/generate-details', [App\Http\Controllers\Admin\GeminiAIController::class, 'generateDetails'])->name('ai.generate-details');

    // AI Settings
    Route::get('ai-settings', [App\Http\Controllers\Admin\AISettingsController::class, 'index'])->name('ai-settings.index');
    Route::put('ai-settings', [App\Http\Controllers\Admin\AISettingsController::class, 'update'])->name('ai-settings.update');
    Route::delete('ai-settings', [App\Http\Controllers\Admin\AISettingsController::class, 'remove'])->name('ai-settings.remove');
    Route::post('ai-settings/test', [App\Http\Controllers\Admin\AISettingsController::class, 'test'])->name('ai-settings.test');
    Route::post('ai-settings/sample', [App\Http\Controllers\Admin\AISettingsController::class, 'generateSample'])->name('ai-settings.sample');

    // Variant Management Routes
    Route::resource('variants', App\Http\Controllers\Admin\VariantController::class);
    Route::post('variants/{variant}/options', [App\Http\Controllers\Admin\VariantController::class, 'storeOption'])->name('variants.options.store');
    Route::put('variants/{variant}/options/{option}', [App\Http\Controllers\Admin\VariantController::class, 'updateOption'])->name('variants.options.update');
    Route::delete('variants/{variant}/options/{option}', [App\Http\Controllers\Admin\VariantController::class, 'destroyOption'])->name('variants.options.destroy');
    Route::get('variants/{variant}/options', [App\Http\Controllers\Admin\VariantController::class, 'getOptions'])->name('variants.options.get');

    // Size Chart Management Routes
    Route::resource('size-charts', App\Http\Controllers\Admin\SizeChartController::class);

    // Bulk Upload Routes
    Route::get('/bulk-upload', [App\Http\Controllers\Admin\BulkUploadController::class, 'index'])->name('bulk-upload.index');
    Route::get('/bulk-upload/sample', [App\Http\Controllers\Admin\BulkUploadController::class, 'downloadSample'])->name('bulk-upload.sample');
    Route::get('/bulk-upload/current-products', [App\Http\Controllers\Admin\BulkUploadController::class, 'downloadCurrentProducts'])->name('bulk-upload.current-products');
    Route::post('/bulk-upload/excel', [App\Http\Controllers\Admin\BulkUploadController::class, 'uploadExcel'])->name('bulk-upload.excel');
    Route::post('/bulk-upload/update', [App\Http\Controllers\Admin\BulkUploadController::class, 'bulkUpdateProducts'])->name('bulk-upload.update');
    Route::post('/bulk-upload/shopify', [App\Http\Controllers\Admin\BulkUploadController::class, 'importShopify'])->name('bulk-upload.shopify');
    Route::post('/bulk-upload/woocommerce', [App\Http\Controllers\Admin\BulkUploadController::class, 'importWooCommerce'])->name('bulk-upload.woocommerce');

    // Coupon Management Routes
    Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);
    Route::patch('coupons/{coupon}/toggle', [App\Http\Controllers\Admin\CouponController::class, 'toggle'])->name('coupons.toggle');
    Route::get('coupons-generate-code', [App\Http\Controllers\Admin\CouponController::class, 'generateCode'])->name('coupons.generate-code');
    Route::post('coupons-validate', [App\Http\Controllers\Admin\CouponController::class, 'validateCode'])->name('coupons.validate');

    // User Management Routes
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');
    Route::get('users-export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');

    // Categories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::patch('categories/{category}/toggle', [App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('categories.toggle');
    Route::post('categories/sort', [App\Http\Controllers\Admin\CategoryController::class, 'sort'])->name('categories.sort');
    Route::post('categories/quick-sort', [App\Http\Controllers\Admin\CategoryController::class, 'quickSort'])->name('categories.quick-sort');

    // Announcement Bars
    Route::resource('announcement-bars', App\Http\Controllers\Admin\AnnouncementBarController::class);
    Route::patch('announcement-bars/{announcement_bar}/toggle', [App\Http\Controllers\Admin\AnnouncementBarController::class, 'toggle'])->name('announcement-bars.toggle');
    Route::post('announcement-bars/sort', [App\Http\Controllers\Admin\AnnouncementBarController::class, 'sort'])->name('announcement-bars.sort');

    // Header Settings
    Route::get('header-settings', [App\Http\Controllers\Admin\HeaderSettingController::class, 'index'])->name('header-settings.index');
    Route::get('header-settings/edit', [App\Http\Controllers\Admin\HeaderSettingController::class, 'edit'])->name('header-settings.edit');
    Route::put('header-settings', [App\Http\Controllers\Admin\HeaderSettingController::class, 'update'])->name('header-settings.update');
    Route::post('header-settings/reset', [App\Http\Controllers\Admin\HeaderSettingController::class, 'reset'])->name('header-settings.reset');
    Route::get('header-settings/urls', [App\Http\Controllers\Admin\HeaderSettingController::class, 'getAvailableUrls'])->name('header-settings.urls');

    // Hero Sections
    Route::resource('hero-sections', App\Http\Controllers\Admin\HeroSectionController::class);
    Route::patch('hero-sections/{hero_section}/toggle', [App\Http\Controllers\Admin\HeroSectionController::class, 'toggle'])->name('hero-sections.toggle');
    Route::post('hero-sections/sort', [App\Http\Controllers\Admin\HeroSectionController::class, 'sort'])->name('hero-sections.sort');

    // Body Feature Sections
    Route::resource('body-feature-sections', App\Http\Controllers\Admin\BodyFeatureSectionController::class);
    Route::patch('body-feature-sections/{body_feature_section}/toggle', [App\Http\Controllers\Admin\BodyFeatureSectionController::class, 'toggle'])->name('body-feature-sections.toggle');
    Route::post('body-feature-sections/sort', [App\Http\Controllers\Admin\BodyFeatureSectionController::class, 'sort'])->name('body-feature-sections.sort');

    // Newsletter Management
    Route::resource('newsletters', App\Http\Controllers\Admin\NewsletterController::class);
    Route::patch('newsletters/{newsletter}/toggle', [App\Http\Controllers\Admin\NewsletterController::class, 'toggle'])->name('newsletters.toggle');

    // Newsletter Subscribers
    Route::resource('newsletter-subscribers', App\Http\Controllers\Admin\NewsletterSubscriberController::class)->except(['create', 'store']);
    Route::patch('newsletter-subscribers/{newsletterSubscriber}/unsubscribe', [App\Http\Controllers\Admin\NewsletterSubscriberController::class, 'unsubscribe'])->name('newsletter-subscribers.unsubscribe');
    Route::patch('newsletter-subscribers/{newsletterSubscriber}/resubscribe', [App\Http\Controllers\Admin\NewsletterSubscriberController::class, 'resubscribe'])->name('newsletter-subscribers.resubscribe');
    Route::get('newsletter-subscribers-export', [App\Http\Controllers\Admin\NewsletterSubscriberController::class, 'export'])->name('newsletter-subscribers.export');

    // Banners
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class);
    Route::patch('banners/{banner}/toggle', [App\Http\Controllers\Admin\BannerController::class, 'toggle'])->name('banners.toggle');

    // Features
    Route::resource('features', App\Http\Controllers\Admin\FeatureController::class);
    Route::patch('features/{feature}/toggle', [App\Http\Controllers\Admin\FeatureController::class, 'toggle'])->name('features.toggle');

    // Orders
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    Route::post('orders/{order}/confirm', [App\Http\Controllers\Admin\OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('orders/{order}/decline', [App\Http\Controllers\Admin\OrderController::class, 'decline'])->name('orders.decline');
    Route::get('orders/{order}/shipping-options', [App\Http\Controllers\Admin\OrderController::class, 'showShippingOptions'])->name('orders.shipping-options');
    Route::post('orders/{order}/get-courier-rates', [App\Http\Controllers\Admin\OrderController::class, 'getCourierRates'])->name('orders.get-courier-rates');
    Route::post('orders/{order}/create-shiprocket-label', [App\Http\Controllers\Admin\OrderController::class, 'createShiprocketLabel'])->name('orders.create-shiprocket-label');
    Route::get('orders/{order}/download-shiprocket-label', [App\Http\Controllers\Admin\OrderController::class, 'downloadShiprocketLabel'])->name('orders.download-shiprocket-label');
    Route::post('orders/{order}/create-manual-label', [App\Http\Controllers\Admin\OrderController::class, 'createManualLabel'])->name('orders.create-manual-label');
    Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/sync-shiprocket', [App\Http\Controllers\Admin\OrderController::class, 'syncWithShiprocket'])->name('orders.sync-shiprocket');
    Route::get('orders/export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');

    // Return Orders
    Route::resource('return-orders', App\Http\Controllers\Admin\ReturnOrderController::class);
    Route::post('return-orders/{returnOrder}/approve', [App\Http\Controllers\Admin\ReturnOrderController::class, 'approve'])->name('return-orders.approve');
    Route::post('return-orders/{returnOrder}/reject', [App\Http\Controllers\Admin\ReturnOrderController::class, 'reject'])->name('return-orders.reject');
    Route::get('return-orders/{returnOrder}/return-options', [App\Http\Controllers\Admin\ReturnOrderController::class, 'showReturnOptions'])->name('return-orders.return-options');
    Route::post('return-orders/{returnOrder}/initiate-shiprocket', [App\Http\Controllers\Admin\ReturnOrderController::class, 'initiateShiprocketReturn'])->name('return-orders.initiate-shiprocket');
    Route::post('return-orders/{returnOrder}/initiate-manual', [App\Http\Controllers\Admin\ReturnOrderController::class, 'initiateManualReturn'])->name('return-orders.initiate-manual');
    Route::post('return-orders/{returnOrder}/received', [App\Http\Controllers\Admin\ReturnOrderController::class, 'markReceived'])->name('return-orders.received');
    Route::post('return-orders/{returnOrder}/quality-check', [App\Http\Controllers\Admin\ReturnOrderController::class, 'completeQualityCheck'])->name('return-orders.quality-check');
    Route::post('return-orders/{returnOrder}/refund', [App\Http\Controllers\Admin\ReturnOrderController::class, 'processRefund'])->name('return-orders.refund');
    Route::patch('return-orders/{returnOrder}/status', [App\Http\Controllers\Admin\ReturnOrderController::class, 'updateStatus'])->name('return-orders.update-status');
    Route::post('return-orders/{returnOrder}/sync-shiprocket', [App\Http\Controllers\Admin\ReturnOrderController::class, 'syncWithShiprocket'])->name('return-orders.sync-shiprocket');
    Route::get('return-orders/export', [App\Http\Controllers\Admin\ReturnOrderController::class, 'export'])->name('return-orders.export');

    // Shiprocket Settings
    Route::get('shiprocket-settings', [App\Http\Controllers\Admin\ShiprocketSettingsController::class, 'index'])->name('shiprocket-settings.index');
    Route::put('shiprocket-settings', [App\Http\Controllers\Admin\ShiprocketSettingsController::class, 'update'])->name('shiprocket-settings.update');
    Route::post('shiprocket-settings/test-connection', [App\Http\Controllers\Admin\ShiprocketSettingsController::class, 'testConnectionAjax'])->name('shiprocket-settings.test-connection');
    Route::get('shiprocket-settings/pickup-locations', [App\Http\Controllers\Admin\ShiprocketSettingsController::class, 'getPickupLocations'])->name('shiprocket-settings.pickup-locations');
    Route::delete('shiprocket-settings/reset', [App\Http\Controllers\Admin\ShiprocketSettingsController::class, 'reset'])->name('shiprocket-settings.reset');



    // Shipping Settings
    Route::get('shipping-settings', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'index'])->name('shipping-settings.index');
    Route::put('shipping-settings', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'update'])->name('shipping-settings.update');
    Route::post('shipping-settings/test', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'testCalculation'])->name('shipping-settings.test');
    Route::post('shipping-settings/save-zone', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'saveZone'])->name('shipping-settings.save-zone');
    Route::get('shipping-settings/reset', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'reset'])->name('shipping-settings.reset');
    Route::get('shipping-settings/export', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'export'])->name('shipping-settings.export');
    Route::post('shipping-settings/import', [App\Http\Controllers\Admin\ShippingSettingsController::class, 'import'])->name('shipping-settings.import');

    // Abandoned Cart Recovery
    Route::get('abandoned-carts', [App\Http\Controllers\Admin\AbandonedCartController::class, 'index'])->name('abandoned-carts.index');
    Route::get('abandoned-carts/{abandonedCart}', [App\Http\Controllers\Admin\AbandonedCartController::class, 'show'])->name('abandoned-carts.show');
    Route::post('abandoned-carts/{abandonedCart}/send-email', [App\Http\Controllers\Admin\AbandonedCartController::class, 'sendRecoveryEmail'])->name('abandoned-carts.send-email');
    Route::post('abandoned-carts/{abandonedCart}/mark-recovered', [App\Http\Controllers\Admin\AbandonedCartController::class, 'markAsRecovered'])->name('abandoned-carts.mark-recovered');
    Route::post('abandoned-carts/{abandonedCart}/mark-expired', [App\Http\Controllers\Admin\AbandonedCartController::class, 'markAsExpired'])->name('abandoned-carts.mark-expired');
    Route::delete('abandoned-carts/{abandonedCart}', [App\Http\Controllers\Admin\AbandonedCartController::class, 'destroy'])->name('abandoned-carts.destroy');
    Route::post('abandoned-carts/bulk-action', [App\Http\Controllers\Admin\AbandonedCartController::class, 'bulkAction'])->name('abandoned-carts.bulk-action');
    Route::get('abandoned-carts/export', [App\Http\Controllers\Admin\AbandonedCartController::class, 'export'])->name('abandoned-carts.export');
    Route::get('abandoned-carts/analytics', [App\Http\Controllers\Admin\AbandonedCartController::class, 'analytics'])->name('abandoned-carts.analytics');

    // Google Sheets Integration
    Route::get('google-sheets', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'index'])->name('google-sheets.index');
    Route::get('google-sheets/{sheetType}/configure', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'configure'])->name('google-sheets.configure');
    Route::post('google-sheets/{sheetType}/store', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'store'])->name('google-sheets.store');
    Route::post('google-sheets/{sheetType}/test-connection', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'testConnection'])->name('google-sheets.test-connection');
    Route::post('google-sheets/{sheetType}/manual-sync', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'manualSync'])->name('google-sheets.manual-sync');
    Route::post('google-sheets/create-headers', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'createHeaders'])->name('google-sheets.create-headers');

    // Facebook Integration
    Route::prefix('facebook')->name('facebook.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'index'])->name('index');
        Route::post('/update-pixel', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'updatePixel'])->name('update-pixel');
        Route::post('/update-catalog', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'updateCatalog'])->name('update-catalog');
        Route::post('/sync-all', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'syncAllProducts'])->name('sync-all');
        Route::post('/sync-product/{product}', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'syncProduct'])->name('sync-product');
        Route::post('/update-inventory/{product}', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'updateInventory'])->name('update-inventory');
        Route::delete('/delete-product/{product}', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'deleteProduct'])->name('delete-product');
        Route::get('/download-feed', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'downloadFeed'])->name('download-feed');
        Route::get('/sync-logs', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'syncLogs'])->name('sync-logs');
        Route::post('/test-connection', [App\Http\Controllers\Admin\FacebookIntegrationController::class, 'testConnection'])->name('test-connection');
    });

    // Communication System
    Route::get('communication', [App\Http\Controllers\Admin\CommunicationController::class, 'index'])->name('communication.index');
    Route::post('communication/preferences', [App\Http\Controllers\Admin\CommunicationController::class, 'updatePreferences'])->name('communication.update-preferences');
    Route::get('communication/email-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'emailSettings'])->name('communication.email-settings');
    Route::post('communication/email-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'updateEmailSettings'])->name('communication.email-settings.update');
    Route::get('communication/sms-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'smsSettings'])->name('communication.sms-settings');
    Route::post('communication/sms-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'updateSmsSettings'])->name('communication.sms-settings.update');
    Route::get('communication/whatsapp-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'whatsappSettings'])->name('communication.whatsapp-settings');
    Route::post('communication/whatsapp-settings', [App\Http\Controllers\Admin\CommunicationController::class, 'updateWhatsappSettings'])->name('communication.whatsapp-settings.update');
    Route::post('communication/test-connection', [App\Http\Controllers\Admin\CommunicationController::class, 'testConnection'])->name('communication.test-connection');
    Route::get('communication/logs', [App\Http\Controllers\Admin\CommunicationController::class, 'logs'])->name('communication.logs');
    Route::post('communication/logs/{log}/retry', [App\Http\Controllers\Admin\CommunicationController::class, 'retryFailed'])->name('communication.logs.retry');
    Route::post('communication/send-test', [App\Http\Controllers\Admin\CommunicationController::class, 'sendTest'])->name('communication.send-test');

    // WhatsApp Management
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'dashboard'])->name('dashboard');

        // Messages
        Route::get('/messages', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'messages'])->name('messages.index');
        Route::get('/messages/{message}', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'showMessage'])->name('messages.show');
        Route::post('/messages/sync', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'syncMessagesFromMeta'])->name('messages.sync');
        Route::post('/messages/create-manual', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'createManualMessage'])->name('messages.create-manual');

        // Conversations
        Route::get('/conversations', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'conversations'])->name('conversations.index');
        Route::get('/conversations/{conversation}', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'showConversation'])->name('conversations.show');
        Route::post('/conversations/{conversation}/send', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'sendMessage'])->name('conversations.send');
        Route::post('/conversations/{conversation}/assign', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'assignConversation'])->name('conversations.assign');
        Route::post('/conversations/{conversation}/close', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'closeConversation'])->name('conversations.close');

        // Orders
        Route::get('/orders', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{whatsappOrder}', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'showOrder'])->name('orders.show');
        Route::post('/orders/{whatsappOrder}/confirm', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'confirmOrder'])->name('orders.confirm');

        // Catalog
        Route::get('/catalog', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'catalog'])->name('catalog.index');
        Route::post('/catalog/sync/{product}', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'syncProduct'])->name('catalog.sync');
        Route::post('/catalog/sync-all', [App\Http\Controllers\Admin\WhatsAppManagementController::class, 'syncAllProducts'])->name('catalog.sync-all');
    });

    // WhatsApp Marketing
    Route::prefix('whatsapp-marketing')->name('whatsapp-marketing.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'index'])->name('index');

        // WhatsApp Accounts
        Route::get('/accounts', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'index'])->name('accounts.index');
        Route::get('/accounts/create', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'create'])->name('accounts.create');
        Route::post('/accounts', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'store'])->name('accounts.store');
        Route::get('/accounts/{account}', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{account}/edit', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{account}', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'update'])->name('accounts.update');
        Route::delete('/accounts/{account}', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'destroy'])->name('accounts.destroy');
        Route::post('/accounts/{account}/set-default', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'setDefault'])->name('accounts.set-default');
        Route::post('/accounts/{account}/sync-info', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'syncInfo'])->name('accounts.sync-info');
        Route::post('/accounts/{account}/sync-templates', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'syncTemplates'])->name('accounts.sync-templates');
        Route::post('/accounts/{account}/templates/{template}/copy', [App\Http\Controllers\Admin\WhatsAppAccountController::class, 'copyTemplate'])->name('accounts.copy-template');

        // Templates
        Route::get('/templates', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'templates'])->name('templates');
        Route::get('/templates/create', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'createTemplate'])->name('templates.create');
        Route::post('/templates', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'storeTemplate'])->name('templates.store');
        Route::post('/templates/generate-ai', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'generateTemplateWithAI'])->name('templates.generate-ai');
        Route::post('/templates/sync-all', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'syncAllTemplates'])->name('templates.sync-all');
        Route::get('/templates/{template}', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'showTemplate'])->name('templates.show');
        Route::post('/templates/{template}/submit', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'submitTemplate'])->name('templates.submit');
        Route::post('/templates/{template}/check-status', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'checkTemplateStatus'])->name('templates.check-status');
        Route::delete('/templates/{template}', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'deleteTemplate'])->name('templates.delete');

        // OTP Template Setup
        Route::get('/otp-setup', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'otpSetup'])->name('otp-setup');
        Route::post('/otp-setup', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'storeOtpTemplate'])->name('otp-setup.store');

        // Campaigns
        Route::get('/campaigns', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'campaigns'])->name('campaigns');
        Route::get('/campaigns/create', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'createCampaign'])->name('campaigns.create');
        Route::post('/campaigns', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'storeCampaign'])->name('campaigns.store');
        Route::get('/campaigns/{campaign}', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'showCampaign'])->name('campaigns.show');
        Route::post('/campaigns/{campaign}/start', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'startCampaign'])->name('campaigns.start');
        Route::post('/campaigns/{campaign}/pause', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'pauseCampaign'])->name('campaigns.pause');
        Route::post('/campaigns/{campaign}/resume', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'resumeCampaign'])->name('campaigns.resume');
        Route::delete('/campaigns/{campaign}', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'deleteCampaign'])->name('campaigns.delete');

        // AJAX/API
        Route::get('/get-users', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'getUsers'])->name('get-users');
    });

    // API routes for WhatsApp Marketing
    Route::get('/api/coupons', [App\Http\Controllers\Admin\WhatsAppMarketingController::class, 'getCoupons'])->name('api.coupons');

    // Communication Templates
    Route::resource('communication-templates', App\Http\Controllers\Admin\CommunicationTemplateController::class)->names('communication-templates');
    Route::post('communication-templates/{communicationTemplate}/preview', [App\Http\Controllers\Admin\CommunicationTemplateController::class, 'preview'])->name('communication-templates.preview');
    Route::post('communication-templates/{communicationTemplate}/duplicate', [App\Http\Controllers\Admin\CommunicationTemplateController::class, 'duplicate'])->name('communication-templates.duplicate');

    // Payment Gateway Management
    Route::get('payment-gateways', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'index'])->name('payment-gateways.index');
    Route::get('payment-gateways/transactions/all', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'allTransactions'])->name('payment-gateways.transactions.all');
    Route::get('payment-gateways/{gateway}/configure', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'configure'])->name('payment-gateways.configure');
    Route::put('payment-gateways/{gateway}/configure', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'updateConfiguration'])->name('payment-gateways.configure.update');
    Route::patch('payment-gateways/{paymentGateway}/toggle', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'toggleStatus'])->name('payment-gateways.toggle');
    Route::post('payment-gateways/{gateway}/test-connection', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'testConnection'])->name('payment-gateways.test-connection');
    Route::get('payment-gateways/{gateway}/transactions', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'transactions'])->name('payment-gateways.transactions');
    Route::post('payment-gateways/initialize', [App\Http\Controllers\Admin\PaymentGatewayController::class, 'initializeDefaults'])->name('payment-gateways.initialize');
    Route::post('google-sheets/{sheetType}/toggle-status', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'toggleStatus'])->name('google-sheets.toggle-status');
    Route::delete('google-sheets/{sheetType}', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'destroy'])->name('google-sheets.destroy');
    Route::get('google-sheets/logs', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'syncLogs'])->name('google-sheets.logs');
    Route::get('google-sheets/logs/export', [App\Http\Controllers\Admin\GoogleSheetsController::class, 'exportLogs'])->name('google-sheets.logs.export');

    // Customers
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);

    // SEO Management
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SeoController::class, 'index'])->name('index');
        Route::get('/products', [App\Http\Controllers\Admin\SeoController::class, 'products'])->name('products');
        Route::get('/categories', [App\Http\Controllers\Admin\SeoController::class, 'categories'])->name('categories');
        Route::post('/generate/product/{product}', [App\Http\Controllers\Admin\SeoController::class, 'generateProduct'])->name('generate.product');
        Route::post('/generate/category/{category}', [App\Http\Controllers\Admin\SeoController::class, 'generateCategory'])->name('generate.category');
        Route::post('/bulk-generate', [App\Http\Controllers\Admin\SeoController::class, 'bulkGenerate'])->name('bulk.generate');

        // Sitemap Management
        Route::get('/sitemap', [App\Http\Controllers\Admin\SeoController::class, 'sitemap'])->name('sitemap');
        Route::post('/sitemap/generate', [App\Http\Controllers\Admin\SeoController::class, 'generateSitemap'])->name('sitemap.generate');

        // Robots.txt Management
        Route::get('/robots', [App\Http\Controllers\Admin\SeoController::class, 'robots'])->name('robots');
        Route::post('/robots/update', [App\Http\Controllers\Admin\SeoController::class, 'updateRobots'])->name('robots.update');
    });

    // Analytics Management
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\Admin\AnalyticsController::class, 'update'])->name('update');
        Route::post('/test/google-analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'testGoogleAnalytics'])->name('test.google-analytics');
        Route::post('/test/facebook-pixel', [App\Http\Controllers\Admin\AnalyticsController::class, 'testFacebookPixel'])->name('test.facebook-pixel');
    });

    // Footer Settings
    Route::get('/footer-settings', [App\Http\Controllers\Admin\FooterSettingController::class, 'index'])->name('footer-settings.index');
    Route::get('/footer-settings/edit', [App\Http\Controllers\Admin\FooterSettingController::class, 'edit'])->name('footer-settings.edit');
    Route::put('/footer-settings', [App\Http\Controllers\Admin\FooterSettingController::class, 'update'])->name('footer-settings.update');



    // Blog Management
    Route::prefix('blog')->name('blog.')->group(function () {
        // Main blog routes
        Route::get('/', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('store');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\BlogController::class, 'bulkAction'])->name('bulk-action');

        // Blog categories (must come before {post} routes)
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BlogCategoryController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\BlogCategoryController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\BlogCategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [App\Http\Controllers\Admin\BlogCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [App\Http\Controllers\Admin\BlogCategoryController::class, 'destroy'])->name('destroy');
        });

        // AI Blog Generator (must come before {post} routes)
        Route::prefix('ai')->name('ai.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BlogAiController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\BlogAiController::class, 'create'])->name('create');
            Route::post('/generate', [App\Http\Controllers\Admin\BlogAiController::class, 'generate'])->name('generate');
            Route::get('/auto-generate/{product}', [App\Http\Controllers\Admin\BlogAiController::class, 'autoGenerate'])->name('auto-generate');
            Route::get('/generate-all-types/{product}', [App\Http\Controllers\Admin\BlogAiController::class, 'generateAllBlogTypes'])->name('generate-all-types');
            Route::post('/store', [App\Http\Controllers\Admin\BlogAiController::class, 'store'])->name('store');
            Route::post('/generate-titles', [App\Http\Controllers\Admin\BlogAiController::class, 'generateTitles'])->name('generate-titles');
            Route::get('/status', [App\Http\Controllers\Admin\BlogAiController::class, 'status'])->name('status');
            Route::get('/products-without-blogs', [App\Http\Controllers\Admin\BlogAiController::class, 'getProductsWithoutBlogs'])->name('products-without-blogs');
            Route::get('/all-products', [App\Http\Controllers\Admin\BlogAiController::class, 'getAllProducts'])->name('all-products');
        });

        // Individual blog post routes (must come last)
        Route::get('/{post}', [App\Http\Controllers\Admin\BlogController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('edit');
        Route::put('/{post}', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('update');
        Route::delete('/{post}', [App\Http\Controllers\Admin\BlogController::class, 'destroy'])->name('destroy');
    });

    // Backup routes
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/test', function() { return view('admin.backup.test'); })->name('test');
        Route::get('/', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('index');
        Route::get('/settings', [App\Http\Controllers\Admin\BackupController::class, 'settings'])->name('settings');
        Route::post('/settings', [App\Http\Controllers\Admin\BackupController::class, 'updateSettings'])->name('settings.update');
        Route::get('/authorize', [App\Http\Controllers\Admin\BackupController::class, 'authorize'])->name('authorize');
        Route::get('/callback', [App\Http\Controllers\Admin\BackupController::class, 'callback'])->name('callback');
        Route::post('/create', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('create');
        Route::get('/download/{fileId}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('download');
        Route::delete('/delete/{fileId}', [App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('delete');
        Route::post('/test-connection', [App\Http\Controllers\Admin\BackupController::class, 'testConnection'])->name('test-connection');
        Route::get('/status', [App\Http\Controllers\Admin\BackupController::class, 'status'])->name('status');
    });

    // Admin Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('index');
        Route::put('/update', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('update');
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password');
        Route::put('/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'updateAvatar'])->name('avatar');
        Route::delete('/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'removeAvatar'])->name('avatar.remove');
    });

    // Pages Management
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);
    Route::get('pages-create-defaults', [App\Http\Controllers\Admin\PageController::class, 'createDefaults'])->name('pages.create-defaults');

    // Super Admin Routes (Role-based access)
    Route::prefix('super-admin')->name('super-admin.')->middleware('super_admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SuperAdminController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\SuperAdminController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\SuperAdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [App\Http\Controllers\Admin\SuperAdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [App\Http\Controllers\Admin\SuperAdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [App\Http\Controllers\Admin\SuperAdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [App\Http\Controllers\Admin\SuperAdminController::class, 'destroy'])->name('destroy');
        Route::patch('/{admin}/toggle-status', [App\Http\Controllers\Admin\SuperAdminController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{admin}/reset-password', [App\Http\Controllers\Admin\SuperAdminController::class, 'resetPassword'])->name('reset-password');
    });

    // Social Media Management Routes
    Route::prefix('social-media')->name('social-media.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SocialMediaController::class, 'index'])->name('index');
        Route::get('/config', [App\Http\Controllers\Admin\SocialMediaController::class, 'config'])->name('config');
        Route::put('/config/{platform}', [App\Http\Controllers\Admin\SocialMediaController::class, 'updateConfig'])->name('config.update');

        // Product posting routes
        Route::post('/products/{product}/post-all', [App\Http\Controllers\Admin\SocialMediaController::class, 'postToAll'])->name('products.post-all');
        Route::post('/products/{product}/post/{platform}', [App\Http\Controllers\Admin\SocialMediaController::class, 'postToSingle'])->name('products.post-single');
        Route::get('/products/{product}/posts', [App\Http\Controllers\Admin\SocialMediaController::class, 'productPosts'])->name('products.posts');

        // Post management
        Route::delete('/posts/{post}', [App\Http\Controllers\Admin\SocialMediaController::class, 'deletePost'])->name('posts.delete');
        Route::post('/posts/{post}/retry', [App\Http\Controllers\Admin\SocialMediaController::class, 'retryPost'])->name('posts.retry');
    });

    // Authentication Settings Management
    Route::prefix('auth-settings')->name('auth-settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'index'])->name('index');
        Route::put('/social/{provider}', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'updateSocialProvider'])->name('update-social');
        Route::put('/method/{method}', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'updateAuthMethod'])->name('update-method');
        Route::post('/toggle', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'toggleStatus'])->name('toggle');
        Route::get('/test-social/{provider}', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'testSocialProvider']);
        Route::get('/test-method/{method}', [App\Http\Controllers\Admin\AuthenticationSettingController::class, 'testAuthMethod']);
    });

    // Contact Management
    // Custom routes must be defined BEFORE resource route to take precedence
    Route::post('contacts/bulk-delete', [App\Http\Controllers\Admin\ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    Route::post('contacts/delete-page-messages', [App\Http\Controllers\Admin\ContactController::class, 'deletePageMessages'])->name('contacts.delete-page-messages');
    Route::post('contacts/delete-all-pages', [App\Http\Controllers\Admin\ContactController::class, 'deleteAllPages'])->name('contacts.delete-all-pages');
    Route::post('contacts/delete-all-messages', [App\Http\Controllers\Admin\ContactController::class, 'deleteAllMessages'])->name('contacts.delete-all-messages');

    Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class)->except(['create', 'store', 'edit']);
    Route::patch('contacts/{contact}/mark-resolved', [App\Http\Controllers\Admin\ContactController::class, 'markAsResolved'])->name('contacts.mark-resolved');
    Route::patch('contacts/{contact}/mark-in-progress', [App\Http\Controllers\Admin\ContactController::class, 'markAsInProgress'])->name('contacts.mark-in-progress');
    Route::post('contacts/{contact}/reply', [App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('contacts.reply');

    // Maintenance Mode Management
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('index');
        Route::post('/toggle', [App\Http\Controllers\Admin\MaintenanceController::class, 'toggle'])->name('toggle');
        Route::put('/update', [App\Http\Controllers\Admin\MaintenanceController::class, 'update'])->name('update');
        Route::post('/clear-password', [App\Http\Controllers\Admin\MaintenanceController::class, 'clearPassword'])->name('clear-password');
    });

    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
});

// Blog routes (public)
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('index');
    Route::get('/category/{category}', [App\Http\Controllers\BlogController::class, 'category'])->name('category');
    Route::get('/tag/{tag}', [App\Http\Controllers\BlogController::class, 'tag'])->name('tag');
    Route::get('/{post}', [App\Http\Controllers\BlogController::class, 'show'])->name('show');
});

// Track Order Routes
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track-order.index');
Route::post('/track-order', [TrackOrderController::class, 'track'])->name('track-order.track');
Route::get('/track-order/{orderNumber}', [TrackOrderController::class, 'trackAuthenticated'])->name('track-order.authenticated');

// Maintenance Mode Routes
Route::get('/maintenance', [App\Http\Controllers\MaintenanceController::class, 'show'])->name('maintenance.show');
Route::post('/maintenance/verify', [App\Http\Controllers\MaintenanceController::class, 'verify'])->name('maintenance.verify');

// Static pages - Named routes for common pages
Route::get('/about', [App\Http\Controllers\PageController::class, 'show'])->defaults('slug', 'about')->name('about');
Route::get('/contact', [App\Http\Controllers\PageController::class, 'show'])->defaults('slug', 'contact')->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->middleware('throttle:5,60')->name('contact.store');

// Static pages - Dynamic page routing
Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show'])
    ->where('slug', '^(?!admin|api|dashboard|login|register|cart|checkout|products|categories|blog|track-order|about|contact|account|mobileadmin|mobile).*$')
    ->name('pages.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test route for cart animation button
Route::get('/test-cart-button', function () {
    return view('test-cart-button');
})->name('test.cart.button');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard Routes
    Route::prefix('account')->name('user.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\User\DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\User\DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [\App\Http\Controllers\User\DashboardController::class, 'updatePassword'])->name('password.update');
        Route::get('/orders', [\App\Http\Controllers\User\DashboardController::class, 'orders'])->name('orders');

        // Address Management Routes
        Route::resource('addresses', \App\Http\Controllers\User\AddressController::class);
        Route::patch('/addresses/{address}/set-default', [\App\Http\Controllers\User\AddressController::class, 'setDefault'])->name('addresses.set-default');
        Route::get('/orders/{order}', [\App\Http\Controllers\User\DashboardController::class, 'orderDetails'])->name('orders.show');
        Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\User\DashboardController::class, 'cancelOrder'])->name('orders.cancel');

        // Return Routes
        Route::get('/returns', [\App\Http\Controllers\User\ReturnController::class, 'index'])->name('returns.index');
        Route::get('/orders/{order}/return', [\App\Http\Controllers\User\ReturnController::class, 'create'])->name('returns.create');
        Route::post('/orders/{order}/return', [\App\Http\Controllers\User\ReturnController::class, 'store'])->name('returns.store');
        Route::get('/returns/{returnOrder}', [\App\Http\Controllers\User\ReturnController::class, 'show'])->name('returns.show');
        Route::patch('/returns/{returnOrder}/cancel', [\App\Http\Controllers\User\ReturnController::class, 'cancel'])->name('returns.cancel');

        Route::get('/wishlist', [\App\Http\Controllers\User\DashboardController::class, 'wishlist'])->name('wishlist');

        // Support Routes
        Route::prefix('support')->name('support.')->group(function () {
            Route::get('/', [\App\Http\Controllers\User\SupportController::class, 'index'])->name('index');
            Route::get('/{contact}', [\App\Http\Controllers\User\SupportController::class, 'show'])->name('show');
            Route::post('/{contact}/reply', [\App\Http\Controllers\User\SupportController::class, 'reply'])->name('reply');
        });
    });
});

// Registration success route (must be before auth.php)
Route::get('register/success', [App\Http\Controllers\Auth\RegisteredUserController::class, 'success'])
    ->name('register.success');

// Separate Mobile Admin Panel (uses same admin auth) - MUST BE BEFORE auth.php
Route::prefix('mobileadmin')->name('mobileadmin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'updateSettings'])->name('settings.update');

    // Theme
    Route::get('/theme', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'theme'])->name('theme');
    Route::post('/theme', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'updateTheme'])->name('theme.update');

    // Analytics
    Route::get('/analytics', [App\Http\Controllers\MobileAdmin\DashboardController::class, 'analytics'])->name('analytics');

    // Sections
    Route::get('/sections', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}/edit', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [App\Http\Controllers\Admin\MobileAdmin\SectionController::class, 'destroy'])->name('sections.delete');

    // Banners
    Route::get('/banners', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [App\Http\Controllers\Admin\MobileAdmin\BannerController::class, 'destroy'])->name('banners.delete');

    // Featured Categories
    Route::get('/featured-categories', [App\Http\Controllers\Admin\MobileAdmin\FeaturedCategoryController::class, 'index'])->name('featured-categories.index');
    Route::post('/featured-categories', [App\Http\Controllers\Admin\MobileAdmin\FeaturedCategoryController::class, 'store'])->name('featured-categories.store');
    Route::put('/featured-categories/{featuredCategory}', [App\Http\Controllers\Admin\MobileAdmin\FeaturedCategoryController::class, 'update'])->name('featured-categories.update');
    Route::delete('/featured-categories/{featuredCategory}', [App\Http\Controllers\Admin\MobileAdmin\FeaturedCategoryController::class, 'destroy'])->name('featured-categories.destroy');
    Route::post('/featured-categories/update-order', [App\Http\Controllers\Admin\MobileAdmin\FeaturedCategoryController::class, 'updateOrder'])->name('featured-categories.update-order');

    // Menu Items
    Route::get('/menu', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menuItem}/edit', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menuItem}', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [App\Http\Controllers\Admin\MobileAdmin\MenuController::class, 'destroy'])->name('menu.delete');

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Admin\MobileAdmin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/send', [App\Http\Controllers\Admin\MobileAdmin\NotificationController::class, 'send'])->name('notifications.send');
});

// Mobile OTP Login Routes
Route::prefix('mobile')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\MobileLoginController::class, 'showLoginForm'])
        ->name('mobile.login');
    Route::post('send-otp', [App\Http\Controllers\Auth\MobileLoginController::class, 'sendOtp'])
        ->name('mobile.send-otp');
    Route::post('verify-otp', [App\Http\Controllers\Auth\MobileLoginController::class, 'verifyOtp'])
        ->name('mobile.verify-otp');
    Route::get('verify', [App\Http\Controllers\Auth\MobileLoginController::class, 'showVerifyForm'])
        ->name('mobile.verify');
});

require __DIR__.'/auth.php';

// Admin Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'create'])
        ->name('admin.login');
    Route::post('admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'destroy'])
        ->name('admin.logout');
});
