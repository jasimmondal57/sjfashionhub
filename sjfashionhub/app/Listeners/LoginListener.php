<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\UserChangeLog;

class LoginListener
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        try {
            $ip = $this->request->ip();
            $userAgent = $this->request->userAgent();

            // Dispatch background job for all tracking (non-blocking)
            // This ensures login completes immediately
            dispatch(new \App\Jobs\TrackUserLogin(
                $user->id,
                $ip,
                $userAgent
            ))->onQueue('default');

        } catch (\Exception $e) {
            Log::error("Failed to dispatch login tracking job: " . $e->getMessage(), [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get location data from IP address with caching
     */
    private function getLocationFromIPCached($ip)
    {
        // Cache location data for 24 hours per IP
        return Cache::remember("ip_location_{$ip}", 86400, function () use ($ip) {
            return $this->getLocationFromIP($ip);
        });
    }

    /**
     * Get location data from IP address
     */
    private function getLocationFromIP($ip)
    {
        try {
            // Skip for local IPs
            if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
                return [
                    'location' => 'Local/Private Network',
                    'country' => 'Local'
                ];
            }

            // Use stream context with timeout to prevent hanging
            $context = stream_context_create([
                'http' => [
                    'timeout' => 2, // 2 second timeout
                    'ignore_errors' => true
                ]
            ]);

            $response = @file_get_contents(
                "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,query",
                false,
                $context
            );

            if ($response) {
                $data = json_decode($response, true);

                if ($data && $data['status'] === 'success') {
                    $location = [];
                    if (!empty($data['city'])) $location[] = $data['city'];
                    if (!empty($data['regionName'])) $location[] = $data['regionName'];

                    return [
                        'location' => !empty($location) ? implode(', ', $location) : $data['country'],
                        'country' => $data['country'] ?? 'Unknown'
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get location for IP {$ip}: " . $e->getMessage());
        }

        return [
            'location' => 'Unknown',
            'country' => 'Unknown'
        ];
    }

    /**
     * Determine the login method based on the request
     */
    private function getLoginMethod()
    {
        $route = $this->request->route();
        
        if (!$route) {
            return 'unknown';
        }

        $routeName = $route->getName();
        $uri = $this->request->getRequestUri();

        if (strpos($uri, '/admin/') !== false || strpos($routeName, 'admin') !== false) {
            return 'admin_panel';
        }

        if (strpos($uri, '/api/') !== false) {
            return 'api';
        }

        if (strpos($uri, '/mobile/') !== false || strpos($routeName, 'mobile') !== false) {
            return 'mobile_app';
        }

        if (strpos($routeName, 'social') !== false) {
            return 'social_login';
        }

        if (strpos($routeName, 'otp') !== false) {
            return 'otp_verification';
        }

        return 'web_login';
    }
}
