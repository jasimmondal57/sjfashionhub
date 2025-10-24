<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppMessage extends Model
{
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'message_id', 'wamid', 'direction', 'type', 'status', 'phone_number',
        'user_id', 'category', 'template_name', 'content', 'media', 'parameters',
        'metadata', 'sent_at', 'delivered_at', 'read_at', 'failed_at',
        'error_message', 'order_id', 'return_order_id'
    ];

    protected $casts = [
        'media' => 'array',
        'parameters' => 'array',
        'metadata' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function returnOrder(): BelongsTo
    {
        return $this->belongsTo(ReturnOrder::class);
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(WhatsAppConversation::class, 'phone_number', 'phone_number');
    }

    // Scopes
    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPhone($query, $phone)
    {
        return $query->where('phone_number', $phone);
    }

    // Accessors
    public function getFormattedPhoneAttribute()
    {
        return '+' . $this->phone_number;
    }

    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'marketing' => 'bg-purple-100 text-purple-800',
            'otp' => 'bg-blue-100 text-blue-800',
            'notification' => 'bg-green-100 text-green-800',
            'support' => 'bg-yellow-100 text-yellow-800',
            'order' => 'bg-indigo-100 text-indigo-800',
        ];

        return $badges[$this->category] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-gray-100 text-gray-800',
            'sent' => 'bg-blue-100 text-blue-800',
            'delivered' => 'bg-green-100 text-green-800',
            'read' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getDirectionIconAttribute()
    {
        return $this->direction === 'outbound' ? '→' : '←';
    }
}

