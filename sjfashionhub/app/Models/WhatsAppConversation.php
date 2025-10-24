<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsAppConversation extends Model
{
    protected $table = 'whatsapp_conversations';

    protected $fillable = [
        'phone_number', 'user_id', 'customer_name', 'status', 'assigned_to',
        'last_message_at', 'last_message_type', 'last_message_preview',
        'unread_count', 'metadata'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(WhatsAppMessage::class, 'phone_number', 'phone_number');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeUnread($query)
    {
        return $query->where('unread_count', '>', 0);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    // Methods
    public function markAsRead()
    {
        $this->update(['unread_count' => 0]);
    }

    public function incrementUnread()
    {
        $this->increment('unread_count');
    }

    public function updateLastMessage($message)
    {
        $this->update([
            'last_message_at' => now(),
            'last_message_type' => $message->type,
            'last_message_preview' => substr($message->content, 0, 100),
        ]);
    }

    // Accessors
    public function getFormattedPhoneAttribute()
    {
        return '+' . $this->phone_number;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'open' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            'archived' => 'bg-yellow-100 text-yellow-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}

