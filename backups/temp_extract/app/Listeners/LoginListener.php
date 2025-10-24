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
            
            // Get location data from cache or fetch (with timeout)
            $locationData = $this->getLocationFromIPCached($ip);
            
            // Update last login time and location (non-blocking)
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $ip,
                'last_login_location' => $locationData['location'] ?? null,
                'last_login_country' => $locationData['country'] ?? null,
                'last_login_user_agent' => $this->request->userAgent(),
            ]);

            // Log the login activity asynchronously
            dispatch(function () use ($user, $ip, $locationData) {
                try {
                    UserChangeLog::logChange(
                        $user->id,
                        'user_login',
                        'login_activity',
                        null,
                        [
                            'login_time' => now()->format('Y-m-d H:i:s'),
                            'ip_address' => $ip,
                            'location' => $locationData['location'] ?? 'Unknown',
                            'country' => $locationData['country'] ?? 'Unknown',
                            'user_agent' => request()->userAgent(),
                            'login_method' => $this->getLoginMethod(),
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Failed to log user activity: " . $e->getMessage());
                }
            })->afterResponse();

        } catch (\Exception $e) {
            Log::error("Failed to track user login: " . $e->getMessage(), [
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
