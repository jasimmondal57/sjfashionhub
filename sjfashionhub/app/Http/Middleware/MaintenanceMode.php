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

        // Maintenance mode is enabled - check if user is authorized

        // If password is set, check if user has verified it in session
        if ($settings->password) {
            if (session('maintenance_verified') === true) {
                // Password verified, allow access
                return $next($request);
            }
            // Password not verified, show maintenance page with password form
            return response()->view('maintenance', [
                'settings' => $settings,
                'requiresPassword' => true,
            ], 503);
        }

        // No password set, show maintenance page without password form
        return response()->view('maintenance', [
            'settings' => $settings,
            'requiresPassword' => false,
        ], 503);
    }
}

