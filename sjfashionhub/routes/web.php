<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

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

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

// Wishlist routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
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
    Route::post('/bulk-upload/excel', [App\Http\Controllers\Admin\BulkUploadController::class, 'uploadExcel'])->name('bulk-upload.excel');
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
    Route::post('orders/{order}/create-shiprocket-label', [App\Http\Controllers\Admin\OrderController::class, 'createShiprocketLabel'])->name('orders.create-shiprocket-label');
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

    // Communication System
    Route::get('communication', [App\Http\Controllers\Admin\CommunicationController::class, 'index'])->name('communication.index');
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

// Static pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/orders/track', 'pages.track-order')->name('orders.track');

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
});

require __DIR__.'/auth.php';
