<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceSetting extends Model
{
    protected $table = 'maintenance_settings';

    protected $fillable = [
        'is_enabled',
        'password',
        'message',
        'title',
        'description',
        'started_at',
        'expected_end_at',
        'enabled_by',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'started_at' => 'datetime',
        'expected_end_at' => 'datetime',
    ];

    /**
     * Get the admin user who enabled maintenance mode
     */
    public function enabledByUser()
    {
        return $this->belongsTo(User::class, 'enabled_by');
    }

    /**
     * Get the current maintenance settings (singleton pattern)
     */
    public static function getCurrent()
    {
        return self::first() ?? self::create([
            'is_enabled' => false,
            'title' => 'Site Maintenance',
            'description' => 'We are currently performing maintenance. We will be back online shortly.',
        ]);
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isEnabled()
    {
        return self::getCurrent()->is_enabled;
    }

    /**
     * Enable maintenance mode
     */
    public static function enable($password = null, $userId = null)
    {
        $settings = self::getCurrent();
        $settings->is_enabled = true;
        $settings->started_at = now();
        $settings->enabled_by = $userId;
        
        if ($password) {
            $settings->password = bcrypt($password);
        }
        
        $settings->save();
        return $settings;
    }

    /**
     * Disable maintenance mode
     */
    public static function disable()
    {
        $settings = self::getCurrent();
        $settings->is_enabled = false;
        $settings->password = null;
        $settings->save();
        return $settings;
    }

    /**
     * Check if password is correct
     */
    public function checkPassword($password)
    {
        if (!$this->password) {
            return false;
        }
        return \Hash::check($password, $this->password);
    }
}

