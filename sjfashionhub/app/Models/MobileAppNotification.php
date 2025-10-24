<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppNotification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'data',
        'user_id',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the user that received this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

