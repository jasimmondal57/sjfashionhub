<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactReply extends Model
{
    protected $fillable = [
        'contact_id',
        'user_id',
        'message',
        'sender_type',
        'sender_name',
        'sender_email',
        'is_internal_note',
        'read_at',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'read_at' => 'datetime',
        'is_internal_note' => 'boolean',
    ];

    /**
     * Get the contact that this reply belongs to
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the admin user who sent this reply
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for admin replies only
     */
    public function scopeAdminReplies($query)
    {
        return $query->where('sender_type', 'admin');
    }

    /**
     * Scope for user replies only
     */
    public function scopeUserReplies($query)
    {
        return $query->where('sender_type', 'user');
    }

    /**
     * Scope for public replies (not internal notes)
     */
    public function scopePublicReplies($query)
    {
        return $query->where('is_internal_note', false);
    }

    /**
     * Scope for internal notes only
     */
    public function scopeInternalNotes($query)
    {
        return $query->where('is_internal_note', true);
    }

    /**
     * Get the sender's display name
     */
    public function getSenderDisplayNameAttribute(): string
    {
        if ($this->sender_type === 'admin') {
            return $this->user ? $this->user->name : 'Admin';
        }

        return $this->sender_name ?: 'Customer';
    }

    /**
     * Mark this reply as read
     */
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Check if this reply has been read
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }
}
