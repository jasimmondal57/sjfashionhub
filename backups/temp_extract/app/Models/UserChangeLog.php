<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\UserChangeLogSyncService;

class UserChangeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'change_type',
        'field_name',
        'old_value',
        'new_value',
        'changed_by',
        'ip_address',
        'user_agent',
        'changed_at'
    ];

    protected $casts = [
        'old_value' => 'json',
        'new_value' => 'json',
        'changed_at' => 'datetime'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($changeLog) {
            // Sync to Google Sheets after creation
            UserChangeLogSyncService::syncChangeLog($changeLog);
        });
    }

    /**
     * Get the user that this change log belongs to
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who made the change
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Create a change log entry
     */
    public static function logChange($userId, $changeType, $fieldName, $oldValue, $newValue, $changedBy = null)
    {
        return static::create([
            'user_id' => $userId,
            'change_type' => $changeType,
            'field_name' => $fieldName,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'changed_by' => $changedBy ?? auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'changed_at' => now()
        ]);
    }

    /**
     * Log multiple field changes at once
     */
    public static function logMultipleChanges($userId, $changeType, $changes, $changedBy = null)
    {
        $logs = [];
        foreach ($changes as $fieldName => $values) {
            $logs[] = [
                'user_id' => $userId,
                'change_type' => $changeType,
                'field_name' => $fieldName,
                'old_value' => $values['old'] ?? null,
                'new_value' => $values['new'] ?? null,
                'changed_by' => $changedBy ?? auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        return static::insert($logs);
    }

    /**
     * Get formatted old value for display
     */
    public function getFormattedOldValueAttribute()
    {
        if (is_null($this->old_value)) {
            return 'NULL';
        }
        if (is_array($this->old_value)) {
            return json_encode($this->old_value, JSON_PRETTY_PRINT);
        }
        return (string) $this->old_value;
    }

    /**
     * Get formatted new value for display
     */
    public function getFormattedNewValueAttribute()
    {
        if (is_null($this->new_value)) {
            return 'NULL';
        }
        if (is_array($this->new_value)) {
            return json_encode($this->new_value, JSON_PRETTY_PRINT);
        }
        return (string) $this->new_value;
    }
}
