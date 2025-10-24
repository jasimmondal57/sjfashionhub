<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppDevice extends Model
{
    protected $fillable = [
        'user_id',
        'fcm_token',
        'platform',
        'device_id',
        'device_name',
        'app_version',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns this device
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

