<?php

namespace App\Services;

use App\Models\UserChangeLog;
use App\Models\GoogleSheetsSetting;
use Illuminate\Support\Facades\Log;

class UserChangeLogSyncService
{
    /**
     * Sync user change log to Google Sheets
     */
    public static function syncChangeLog(UserChangeLog $changeLog): void
    {
        try {
            $setting = GoogleSheetsSetting::where('sheet_type', 'user_changes')
                ->where('is_active', true)
                ->first();

            if (!$setting) {
                return;
            }

            $changeData = [
                'change_id' => $changeLog->id,
                'user_id' => $changeLog->user_id,
                'user_name' => $changeLog->user->name ?? 'Unknown',
                'user_email' => $changeLog->user->email ?? 'Unknown',
                'change_type' => $changeLog->change_type,
                'field_name' => $changeLog->field_name,
                'old_value' => $changeLog->formatted_old_value,
                'new_value' => $changeLog->formatted_new_value,
                'changed_by' => $changeLog->changedBy->name ?? 'System',
                'ip_address' => $changeLog->ip_address,
                'user_agent' => $changeLog->user_agent,
                'changed_at' => $changeLog->changed_at->format('Y-m-d H:i:s'),
            ];

            $setting->syncData($changeData, 'create');

        } catch (\Exception $e) {
            Log::error("Failed to sync user change log to Google Sheets: " . $e->getMessage());
        }
    }

    /**
     * Sync multiple change logs to Google Sheets
     */
    public static function syncMultipleChangeLogs(array $changeLogs): void
    {
        try {
            $setting = GoogleSheetsSetting::where('sheet_type', 'user_changes')
                ->where('is_active', true)
                ->first();

            if (!$setting) {
                return;
            }

            $changeData = [];
            foreach ($changeLogs as $changeLog) {
                $changeData[] = [
                    'change_id' => $changeLog->id,
                    'user_id' => $changeLog->user_id,
                    'user_name' => $changeLog->user->name ?? 'Unknown',
                    'user_email' => $changeLog->user->email ?? 'Unknown',
                    'change_type' => $changeLog->change_type,
                    'field_name' => $changeLog->field_name,
                    'old_value' => $changeLog->formatted_old_value,
                    'new_value' => $changeLog->formatted_new_value,
                    'changed_by' => $changeLog->changedBy->name ?? 'System',
                    'ip_address' => $changeLog->ip_address,
                    'user_agent' => $changeLog->user_agent,
                    'changed_at' => $changeLog->changed_at->format('Y-m-d H:i:s'),
                ];
            }

            $setting->bulkSync($changeData);

        } catch (\Exception $e) {
            Log::error("Failed to sync multiple user change logs to Google Sheets: " . $e->getMessage());
        }
    }
}
