<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AllowShiprocketWebhook
{
    /**
     * Shiprocket IP addresses (whitelist)
     * These IPs are allowed to access the webhook endpoint
     */
    protected $allowedIps = [
        // Shiprocket known IPs
        '13.234.176.102',
        '13.234.22.87',
        '13.234.22.88',
        '13.234.22.89',
        '13.234.22.90',
        '13.234.22.91',
        '13.234.22.92',
        '13.234.22.93',
        '13.234.22.94',
        '13.234.22.95',
        '13.234.22.96',
        '13.234.22.97',
        '13.234.22.98',
        '13.234.22.99',
        '13.234.22.100',
        '13.234.22.101',
        '13.234.22.102',
        '13.234.22.103',
        '13.234.22.104',
        '13.234.22.105',
        '13.234.22.106',
        '13.234.22.107',
        '13.234.22.108',
        '13.234.22.109',
        '13.234.22.110',
        '13.234.22.111',
        '13.234.22.112',
        '13.234.22.113',
        '13.234.22.114',
        '13.234.22.115',
        '13.234.22.116',
        '13.234.22.117',
        '13.234.22.118',
        '13.234.22.119',
        '13.234.22.120',
        '13.234.22.121',
        '13.234.22.122',
        '13.234.22.123',
        '13.234.22.124',
        '13.234.22.125',
        '13.234.22.126',
        '13.234.22.127',
        '13.234.22.128',
        '13.234.22.129',
        '13.234.22.130',
        // Add more Shiprocket IPs as needed
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();
        
        // Get real IP if behind proxy (Cloudflare, nginx, etc.)
        $realIp = $request->header('X-Forwarded-For') 
               ?? $request->header('X-Real-IP') 
               ?? $request->header('CF-Connecting-IP')
               ?? $clientIp;
        
        // Extract first IP if multiple IPs in X-Forwarded-For
        if (str_contains($realIp, ',')) {
            $realIp = trim(explode(',', $realIp)[0]);
        }

        Log::info('Shiprocket Webhook IP Check', [
            'client_ip' => $clientIp,
            'real_ip' => $realIp,
            'x_forwarded_for' => $request->header('X-Forwarded-For'),
            'x_real_ip' => $request->header('X-Real-IP'),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Allow localhost and private IPs for testing
        if ($this->isLocalOrPrivateIp($realIp)) {
            Log::info('Shiprocket Webhook: Local/Private IP allowed', ['ip' => $realIp]);
            return $next($request);
        }

        // Check if IP is in whitelist
        if (in_array($realIp, $this->allowedIps)) {
            Log::info('Shiprocket Webhook: IP whitelisted', ['ip' => $realIp]);
            return $next($request);
        }

        // For now, allow all IPs but log them (for debugging)
        // Once you confirm Shiprocket's IPs, you can uncomment the block below
        Log::warning('Shiprocket Webhook: IP not in whitelist (allowing anyway)', [
            'ip' => $realIp,
            'user_agent' => $request->header('User-Agent')
        ]);
        
        return $next($request);

        // Uncomment below to enforce IP whitelist:
        /*
        Log::error('Shiprocket Webhook: IP blocked', [
            'ip' => $realIp,
            'user_agent' => $request->header('User-Agent')
        ]);

        return response()->json([
            'success' => false,
            'message' => 'IP address not allowed'
        ], 403);
        */
    }

    /**
     * Check if IP is localhost or private network
     */
    private function isLocalOrPrivateIp($ip): bool
    {
        // Localhost
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return true;
        }

        // Private network ranges
        $privateRanges = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ];

        foreach ($privateRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP is in CIDR range
     */
    private function ipInRange($ip, $range): bool
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        
        return ($ip & $mask) == $subnet;
    }
}

