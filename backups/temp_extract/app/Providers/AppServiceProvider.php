<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\User;
use App\Models\UserAddress;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
use App\Observers\OrderObserver;
use App\Observers\ReturnOrderObserver;
use App\Observers\UserObserver;
use App\Observers\UserAddressObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\SocialMediaService::class);
        $this->app->singleton(\App\Services\AIContentGeneratorService::class);
        $this->app->singleton(\App\Services\SmsService::class);
        $this->app->singleton(\App\Services\WhatsAppService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for automatic SEO generation and email notifications
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
        Order::observe(OrderObserver::class);
        ReturnOrder::observe(ReturnOrderObserver::class);
        User::observe(UserObserver::class);
        UserAddress::observe(UserAddressObserver::class);
    }
}
