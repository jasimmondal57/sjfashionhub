<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectMobileDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');
        
        // Detect mobile devices
        $isMobile = $this->isMobileDevice($userAgent);
        
        // Store in request for use in views
        $request->attributes->set('is_mobile', $isMobile);
        
        // Share with all views
        view()->share('isMobile', $isMobile);
        
        return $next($request);
    }
    
    /**
     * Check if the user agent is a mobile device
     */
    private function isMobileDevice($userAgent): bool
    {
        if (empty($userAgent)) {
            return false;
        }
        
        // Mobile device patterns
        $mobilePatterns = [
            '/android/i',
            '/webos/i',
            '/iphone/i',
            '/ipad/i',
            '/ipod/i',
            '/blackberry/i',
            '/windows phone/i',
            '/mobile/i',
        ];
        
        foreach ($mobilePatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }
        
        return false;
    }
}

