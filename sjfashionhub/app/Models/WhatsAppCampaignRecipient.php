<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppCampaignRecipient extends Model
{
    protected $table = 'whatsapp_campaign_recipients';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'phone_number',
        'status',
        'whatsapp_message_id',
        'error_message',
        'sent_at',
        'delivered_at',
        'read_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the campaign
     */
    public function campaign()
    {
        return $this->belongsTo(WhatsAppCampaign::class, 'campaign_id');
    }

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'gray',
            'sent' => 'blue',
            'delivered' => 'green',
            'read' => 'purple',
            'failed' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'pending' => '⏳',
            'sent' => '📤',
            'delivered' => '✅',
            'read' => '👁️',
            'failed' => '❌',
            default => '📄',
        };
    }
}

