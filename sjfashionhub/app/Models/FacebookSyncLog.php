<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookSyncLog extends Model
{
    protected $fillable = [
        'sync_type',
        'status',
        'products_synced',
        'products_failed',
        'error_message',
        'details',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'products_synced' => 'integer',
        'products_failed' => 'integer',
        'details' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Start a new sync log
     */
    public static function start($syncType)
    {
        return static::create([
            'sync_type' => $syncType,
            'status' => 'started',
            'started_at' => now(),
        ]);
    }

    /**
     * Mark as completed
     */
    public function complete($synced = 0, $failed = 0, $details = null)
    {
        $this->update([
            'status' => 'completed',
            'products_synced' => $synced,
            'products_failed' => $failed,
            'details' => $details,
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark as failed
     */
    public function fail($error, $details = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $error,
            'details' => $details,
            'completed_at' => now(),
        ]);
    }

    /**
     * Get duration in seconds
     */
    public function getDurationAttribute()
    {
        if (!$this->started_at || !$this->completed_at) {
            return null;
        }

        return $this->completed_at->diffInSeconds($this->started_at);
    }

    /**
     * Get status badge
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'completed' => 'badge-success',
            'started' => 'badge-info',
            'failed' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}

