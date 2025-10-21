<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\EventServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'shiprocket.webhook' => \App\Http\Middleware\AllowShiprocketWebhook::class,
        ]);

        // Add mobile detection and maintenance mode middleware to web group
        $middleware->web(append: [
            \App\Http\Middleware\DetectMobileDevice::class,
            \App\Http\Middleware\MaintenanceMode::class,
        ]);

        // Exclude webhook and API endpoints from CSRF protection
        $middleware->validateCsrfTokens(except: [
            'webhook/*',
            'check-delivery',
            'payment/payu/success',
            'payment/payu/failure',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
