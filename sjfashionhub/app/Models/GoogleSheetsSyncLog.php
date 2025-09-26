<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleSheetsSyncLog extends Model
{
    protected $fillable = [
        'google_sheets_setting_id',
        'sync_type',
        'operation',
        'status',
        'records_processed',
        'records_success',
        'records_failed',
        'sync_data',
        'error_message',
        'error_details',
        'started_at',
        'completed_at',
        'duration_seconds',
        'triggered_by',
        'batch_id',
        'response_data'
    ];

    protected $casts = [
        'sync_data' => 'array',
        'error_details' => 'array',
        'response_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the Google Sheets setting that owns this log
     */
    public function googleSheetsSetting(): BelongsTo
    {
        return $this->belongsTo(GoogleSheetsSetting::class);
    }

    /**
     * Get the user who triggered this sync
     */
    public function triggeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }

    /**
     * Scope for successful syncs
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope for failed syncs
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for pending syncs
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'success' => 'green',
            'failed' => 'red',
            'pending' => 'yellow',
            'partial' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_seconds) {
            return 'N/A';
        }

        if ($this->duration_seconds < 60) {
            return $this->duration_seconds . 's';
        }

        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;

        return $minutes . 'm ' . $seconds . 's';
    }

    /**
     * Get success rate percentage
     */
    public function getSuccessRateAttribute()
    {
        if ($this->records_processed === 0) {
            return 0;
        }

        return round(($this->records_success / $this->records_processed) * 100, 2);
    }

    /**
     * Get sync type label
     */
    public function getSyncTypeLabelAttribute()
    {
        return match($this->sync_type) {
            'manual' => 'Manual',
            'auto' => 'Automatic',
            'real_time' => 'Real-time',
            default => ucfirst($this->sync_type)
        };
    }

    /**
     * Get operation label
     */
    public function getOperationLabelAttribute()
    {
        return match($this->operation) {
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
            'bulk_sync' => 'Bulk Sync',
            'test_connection' => 'Test Connection',
            default => ucfirst(str_replace('_', ' ', $this->operation))
        };
    }

    /**
     * Check if sync is still running
     */
    public function isRunning()
    {
        return $this->status === 'pending' && !$this->completed_at;
    }

    /**
     * Mark sync as completed
     */
    public function markAsCompleted($status = 'success', $additionalData = [])
    {
        $this->update(array_merge([
            'status' => $status,
            'completed_at' => now(),
            'duration_seconds' => now()->diffInSeconds($this->started_at)
        ], $additionalData));
    }

    /**
     * Get recent sync logs with statistics
     */
    public static function getRecentStats($days = 7)
    {
        $logs = static::where('started_at', '>=', now()->subDays($days))->get();

        return [
            'total_syncs' => $logs->count(),
            'successful_syncs' => $logs->where('status', 'success')->count(),
            'failed_syncs' => $logs->where('status', 'failed')->count(),
            'pending_syncs' => $logs->where('status', 'pending')->count(),
            'total_records_processed' => $logs->sum('records_processed'),
            'total_records_success' => $logs->sum('records_success'),
            'total_records_failed' => $logs->sum('records_failed'),
            'average_duration' => $logs->where('duration_seconds', '>', 0)->avg('duration_seconds'),
            'success_rate' => $logs->count() > 0 ? round(($logs->where('status', 'success')->count() / $logs->count()) * 100, 2) : 0,
        ];
    }
}
