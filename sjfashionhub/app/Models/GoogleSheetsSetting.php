<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class GoogleSheetsSetting extends Model
{
    protected $fillable = [
        'sheet_type',
        'sheet_name',
        'spreadsheet_id',
        'sheet_id',
        'web_app_url',
        'service_account_json',
        'column_mapping',
        'auto_sync',
        'real_time_sync',
        'sync_frequency',
        'last_sync_at',
        'total_synced',
        'sync_errors',
        'is_active',
        'sync_filters',
        'notes'
    ];

    protected $casts = [
        'column_mapping' => 'array',
        'sync_filters' => 'array',
        'auto_sync' => 'boolean',
        'real_time_sync' => 'boolean',
        'is_active' => 'boolean',
        'last_sync_at' => 'datetime',
    ];

    /**
     * Get the sync logs for this setting
     */
    public function syncLogs(): HasMany
    {
        return $this->hasMany(GoogleSheetsSyncLog::class);
    }

    /**
     * Get the decrypted service account JSON
     */
    public function getDecryptedServiceAccountAttribute()
    {
        if ($this->service_account_json) {
            try {
                return json_decode(Crypt::decryptString($this->service_account_json), true);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Set the encrypted service account JSON
     */
    public function setServiceAccountJsonAttribute($value)
    {
        if ($value) {
            $this->attributes['service_account_json'] = Crypt::encryptString(
                is_array($value) ? json_encode($value) : $value
            );
        }
    }

    /**
     * Get the Google Sheets URL
     */
    public function getSheetUrlAttribute()
    {
        if ($this->sheet_id) {
            return "https://docs.google.com/spreadsheets/d/{$this->spreadsheet_id}/edit#gid={$this->sheet_id}";
        }
        return "https://docs.google.com/spreadsheets/d/{$this->spreadsheet_id}/edit";
    }

    /**
     * Get default column mappings for different sheet types
     */
    public static function getDefaultColumnMapping($sheetType)
    {
        return match($sheetType) {
            'orders' => [
                'order_id' => 'A',
                'customer_name' => 'B',
                'customer_email' => 'C',
                'customer_phone' => 'D',
                'total_amount' => 'E',
                'status' => 'F',
                'payment_status' => 'G',
                'shipping_address' => 'H',
                'order_date' => 'I',
                'updated_at' => 'J',
                'items_count' => 'K',
                'shipping_method' => 'L',
                'tracking_number' => 'M',
                'notes' => 'N'
            ],
            'returns' => [
                'return_id' => 'A',
                'order_id' => 'B',
                'customer_name' => 'C',
                'customer_email' => 'D',
                'return_reason' => 'E',
                'return_status' => 'F',
                'refund_amount' => 'G',
                'return_date' => 'H',
                'approved_date' => 'I',
                'refund_date' => 'J',
                'quality_check' => 'K',
                'admin_notes' => 'L',
                'tracking_number' => 'M'
            ],
            'users' => [
                'user_id' => 'A',
                'name' => 'B',
                'email' => 'C',
                'phone' => 'D',
                'role' => 'E',
                'status' => 'F',
                'registration_date' => 'G',
                'last_login' => 'H',
                'total_orders' => 'I',
                'total_spent' => 'J',
                'address' => 'K',
                'city' => 'L',
                'state' => 'M',
                'country' => 'N'
            ],
            'newsletters' => [
                'subscriber_id' => 'A',
                'email' => 'B',
                'name' => 'C',
                'status' => 'D',
                'subscribed_at' => 'E',
                'unsubscribed_at' => 'F',
                'source' => 'G',
                'ip_address' => 'H',
                'user_agent' => 'I',
                'preferences' => 'J',
                'created_at' => 'K',
                'updated_at' => 'L'
            ],
            default => []
        };
    }

    /**
     * Sync data to Google Sheets
     */
    public function syncData($data, $operation = 'create')
    {
        if (!$this->is_active || !$this->web_app_url) {
            return false;
        }

        $syncLog = $this->syncLogs()->create([
            'sync_type' => 'auto',
            'operation' => $operation,
            'status' => 'pending',
            'started_at' => now(),
            'triggered_by' => 'system'
        ]);

        try {
            $payload = [
                'action' => $operation,
                'sheet_type' => $this->sheet_type,
                'spreadsheet_id' => $this->spreadsheet_id,
                'sheet_name' => $this->sheet_name,
                'column_mapping' => $this->column_mapping,
                'data' => $data
            ];

            $response = Http::timeout(30)->post($this->web_app_url, $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                $syncLog->update([
                    'status' => 'success',
                    'records_processed' => 1,
                    'records_success' => 1,
                    'completed_at' => now(),
                    'duration_seconds' => now()->diffInSeconds($syncLog->started_at),
                    'response_data' => $responseData
                ]);

                $this->increment('total_synced');
                $this->update(['last_sync_at' => now()]);

                return true;
            } else {
                throw new \Exception('HTTP Error: ' . $response->status() . ' - ' . $response->body());
            }

        } catch (\Exception $e) {
            $syncLog->update([
                'status' => 'failed',
                'records_processed' => 1,
                'records_failed' => 1,
                'error_message' => $e->getMessage(),
                'completed_at' => now(),
                'duration_seconds' => now()->diffInSeconds($syncLog->started_at)
            ]);

            $this->increment('sync_errors');
            return false;
        }
    }

    /**
     * Bulk sync data to Google Sheets
     */
    public function bulkSync($dataCollection, $batchSize = 100)
    {
        if (!$this->is_active || !$this->web_app_url) {
            return false;
        }

        $batchId = uniqid('batch_');
        $totalRecords = count($dataCollection);
        $successCount = 0;
        $failedCount = 0;

        $syncLog = $this->syncLogs()->create([
            'sync_type' => 'manual',
            'operation' => 'bulk_sync',
            'status' => 'pending',
            'records_processed' => $totalRecords,
            'started_at' => now(),
            'batch_id' => $batchId,
            'triggered_by' => auth()->id() ?? 'system'
        ]);

        try {
            $chunks = array_chunk($dataCollection, $batchSize);

            foreach ($chunks as $chunk) {
                $payload = [
                    'action' => 'bulk_insert',
                    'sheet_type' => $this->sheet_type,
                    'spreadsheet_id' => $this->spreadsheet_id,
                    'sheet_name' => $this->sheet_name,
                    'column_mapping' => $this->column_mapping,
                    'data' => $chunk
                ];

                $response = Http::timeout(60)->post($this->web_app_url, $payload);

                if ($response->successful()) {
                    $successCount += count($chunk);
                } else {
                    $failedCount += count($chunk);
                }
            }

            $status = $failedCount === 0 ? 'success' : ($successCount === 0 ? 'failed' : 'partial');

            $syncLog->update([
                'status' => $status,
                'records_success' => $successCount,
                'records_failed' => $failedCount,
                'completed_at' => now(),
                'duration_seconds' => now()->diffInSeconds($syncLog->started_at)
            ]);

            $this->increment('total_synced', $successCount);
            if ($failedCount > 0) {
                $this->increment('sync_errors', $failedCount);
            }
            $this->update(['last_sync_at' => now()]);

            return $status === 'success' || $status === 'partial';

        } catch (\Exception $e) {
            $syncLog->update([
                'status' => 'failed',
                'records_failed' => $totalRecords,
                'error_message' => $e->getMessage(),
                'completed_at' => now(),
                'duration_seconds' => now()->diffInSeconds($syncLog->started_at)
            ]);

            $this->increment('sync_errors', $totalRecords);
            return false;
        }
    }

    /**
     * Test connection to Google Sheets
     */
    public function testConnection()
    {
        if (!$this->web_app_url) {
            return [
                'success' => false,
                'message' => 'Web App URL not configured'
            ];
        }

        try {
            $payload = [
                'action' => 'test_connection',
                'spreadsheet_id' => $this->spreadsheet_id,
                'sheet_name' => $this->sheet_name
            ];

            $response = Http::timeout(10)->post($this->web_app_url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => 'Connection successful',
                    'data' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'HTTP Error: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get sync statistics
     */
    public function getSyncStats($days = 30)
    {
        $logs = $this->syncLogs()
            ->where('started_at', '>=', now()->subDays($days))
            ->get();

        return [
            'total_syncs' => $logs->count(),
            'successful_syncs' => $logs->where('status', 'success')->count(),
            'failed_syncs' => $logs->where('status', 'failed')->count(),
            'partial_syncs' => $logs->where('status', 'partial')->count(),
            'total_records_synced' => $logs->sum('records_success'),
            'total_errors' => $logs->sum('records_failed'),
            'average_duration' => $logs->where('duration_seconds', '>', 0)->avg('duration_seconds'),
            'last_sync' => $this->last_sync_at?->diffForHumans(),
        ];
    }
}
