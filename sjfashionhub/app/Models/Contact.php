<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'admin_notes',
        'resolved_at',
        'resolved_by'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the user who resolved this contact
     */
    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get all replies for this contact
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get public replies only (not internal notes)
     */
    public function publicReplies(): HasMany
    {
        return $this->hasMany(ContactReply::class)->publicReplies()->orderBy('created_at', 'asc');
    }

    /**
     * Get internal notes only
     */
    public function internalNotes(): HasMany
    {
        return $this->hasMany(ContactReply::class)->internalNotes()->orderBy('created_at', 'asc');
    }

    /**
     * Scope for new contacts
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for resolved contacts
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Mark contact as resolved
     */
    public function markAsResolved($userId = null): void
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => $userId
        ]);
    }

    /**
     * Mark contact as in progress
     */
    public function markAsInProgress(): void
    {
        $this->update(['status' => 'in_progress']);
    }
}
