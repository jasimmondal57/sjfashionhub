<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserChangeLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrackUserLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $ip;
    protected $userAgent;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $ip, $userAgent)
    {
        $this->userId = $userId;
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::find($this->userId);
            
            if (!$user) {
                Log::warning("User not found for login tracking", ['user_id' => $this->userId]);
                return;
            }

            // Get location data from IP (with caching)
            $locationData = $this->getLocationFromIPCached($this->ip);

            // Update user with login details
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $this->ip,
                'last_login_location' => $locationData['location'] ?? null,
                'last_login_country' => $locationData['country'] ?? null,
                'last_login_user_agent' => $this->userAgent,
            ]);

            // Log the login activity
            UserChangeLog::logChange(
                $user->id,
                'user_login',
                'login_activity',
                null,
                [
                    'login_time' => now()->format('Y-m-d H:i:s'),
                    'ip_address' => $this->ip,
                    'location' => $locationData['location'] ?? 'Unknown',
                    'country' => $locationData['country'] ?? 'Unknown',
                    'user_agent' => $this->userAgent,
                    'login_method' => 'web_login',
                ]
            );

            Log::info("User login tracked successfully", [
                'user_id' => $user->id,
                'ip' => $this->ip,
                'location' => $locationData['location'] ?? 'Unknown'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to track user login: " . $e->getMessage(), [
                'user_id' => $this->userId,
                'ip' => $this->ip,
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
                    'timeout' => 3, // 3 second timeout
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
}

