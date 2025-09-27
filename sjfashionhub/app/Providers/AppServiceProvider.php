<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;
use App\Observers\CategoryObserver;
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
        // Register model observers for automatic SEO generation
        Product::observe(ProductObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
