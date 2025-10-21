<?php

namespace App\Http\Middleware;

use App\Models\MaintenanceSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow admin panel to bypass maintenance mode
        if ($request->is('admin/*')) {
            return $next($request);
        }

        // Allow maintenance page itself
        if ($request->is('maintenance') || $request->is('maintenance/verify')) {
            return $next($request);
        }

        $settings = MaintenanceSetting::getCurrent();

        // If maintenance mode is not enabled, proceed normally
        if (!$settings->is_enabled) {
            return $next($request);
        }

        // Check if user has valid maintenance password in session
        if ($settings->password && session('maintenance_verified')) {
            return $next($request);
        }

        // If no password is set, show maintenance page
        if (!$settings->password) {
            return response()->view('maintenance', [
                'settings' => $settings,
                'requiresPassword' => false,
            ], 503);
        }

        // If password is set but not verified, show maintenance page with password form
        return response()->view('maintenance', [
            'settings' => $settings,
            'requiresPassword' => true,
        ], 503);
    }
}

