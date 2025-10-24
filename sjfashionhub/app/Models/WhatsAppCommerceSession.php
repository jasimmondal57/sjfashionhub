<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppCommerceSession extends Model
{
    protected $table = 'whatsapp_commerce_sessions';

    protected $fillable = [
        'phone_number',
        'user_id',
        'current_step',
        'session_data',
        'last_message_id',
        'last_activity_at'
    ];

    protected $casts = [
        'session_data' => 'array',
        'last_activity_at' => 'datetime'
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get or create session for phone number
     */
    public static function getSession($phoneNumber)
    {
        return self::firstOrCreate(
            ['phone_number' => $phoneNumber],
            [
                'current_step' => 'browse',
                'session_data' => [],
                'last_activity_at' => now()
            ]
        );
    }

    /**
     * Update session step
     */
    public function updateStep($step, $data = [])
    {
        $this->current_step = $step;
        
        if (!empty($data)) {
            $sessionData = $this->session_data ?? [];
            $this->session_data = array_merge($sessionData, $data);
        }
        
        $this->last_activity_at = now();
        $this->save();
    }

    /**
     * Get session data value
     */
    public function getData($key, $default = null)
    {
        return $this->session_data[$key] ?? $default;
    }

    /**
     * Set session data value
     */
    public function setData($key, $value)
    {
        $sessionData = $this->session_data ?? [];
        $sessionData[$key] = $value;
        $this->session_data = $sessionData;
        $this->last_activity_at = now();
        $this->save();
    }

    /**
     * Clear session data
     */
    public function clearData()
    {
        $this->session_data = [];
        $this->current_step = 'browse';
        $this->last_activity_at = now();
        $this->save();
    }

    /**
     * Check if session is expired (inactive for more than 30 minutes)
     */
    public function isExpired()
    {
        return $this->last_activity_at && $this->last_activity_at->diffInMinutes(now()) > 30;
    }
}

