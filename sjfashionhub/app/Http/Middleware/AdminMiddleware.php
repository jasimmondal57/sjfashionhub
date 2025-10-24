<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
        }

        $user = Auth::user();
        
        // Check if user is active
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }

        // Check if user has admin or manager role
        if (!in_array($user->role, ['admin', 'manager', 'super_admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access admin panel.');
        }

        return $next($request);
    }
}
