<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleDriveBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BackupController extends Controller
{
    private $backupService;

    public function __construct(GoogleDriveBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Display backup management page
     */
    public function index()
    {
        try {
            $isConfigured = $this->backupService->isConfigured();
            $backups = $isConfigured ? $this->backupService->listBackups() : [];
            
            return view('admin.backup.index', compact('backups', 'isConfigured'));
        } catch (\Exception $e) {
            Log::error('Failed to load backups: ' . $e->getMessage());
            return view('admin.backup.index', [
                'backups' => [],
                'isConfigured' => false,
                'error' => 'Failed to connect to Google Drive: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display Google Drive settings page
     */
    public function settings()
    {
        $settings = [
            'google_drive_client_id' => setting('google_drive_client_id'),
            'google_drive_client_secret' => setting('google_drive_client_secret'),
            'google_drive_redirect_uri' => setting('google_drive_redirect_uri'),
            'google_drive_backup_folder' => setting('google_drive_backup_folder', 'SJ Fashion Hub Backups'),
            'backup_schedule_enabled' => setting('backup_schedule_enabled', false),
            'backup_schedule_time' => setting('backup_schedule_time', '02:00'),
            'backup_retention_days' => setting('backup_retention_days', 7),
        ];

        $isConfigured = $this->backupService->isConfigured();
        
        return view('admin.backup.settings', compact('settings', 'isConfigured'));
    }

    /**
     * Update Google Drive settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'google_drive_client_id' => 'required|string',
            'google_drive_client_secret' => 'required|string',
            'google_drive_redirect_uri' => 'required|url',
            'google_drive_backup_folder' => 'required|string|max:255',
            'backup_schedule_enabled' => 'boolean',
            'backup_schedule_time' => 'required|date_format:H:i',
            'backup_retention_days' => 'required|integer|min:1|max:30',
        ]);

        // Save settings
        setting([
            'google_drive_client_id' => $request->google_drive_client_id,
            'google_drive_client_secret' => $request->google_drive_client_secret,
            'google_drive_redirect_uri' => $request->google_drive_redirect_uri,
            'google_drive_backup_folder' => $request->google_drive_backup_folder,
            'backup_schedule_enabled' => $request->has('backup_schedule_enabled'),
            'backup_schedule_time' => $request->backup_schedule_time,
            'backup_retention_days' => $request->backup_retention_days,
        ]);

        return redirect()->route('admin.backup.settings')
                        ->with('success', 'Google Drive settings updated successfully!');
    }

    /**
     * Start Google Drive authorization
     */
    public function authorize()
    {
        try {
            $authUrl = $this->backupService->getAuthorizationUrl();
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Failed to get authorization URL: ' . $e->getMessage());
            return redirect()->route('admin.backup.settings')
                            ->with('error', 'Failed to start authorization: ' . $e->getMessage());
        }
    }

    /**
     * Handle Google Drive OAuth callback
     */
    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('admin.backup.settings')
                            ->with('error', 'Authorization was denied or failed.');
        }

        if (!$request->has('code')) {
            return redirect()->route('admin.backup.settings')
                            ->with('error', 'No authorization code received.');
        }

        try {
            $success = $this->backupService->handleCallback($request->code);
            
            if ($success) {
                return redirect()->route('admin.backup.settings')
                                ->with('success', 'Google Drive authorization successful! You can now create backups.');
            } else {
                return redirect()->route('admin.backup.settings')
                                ->with('error', 'Failed to complete authorization.');
            }
        } catch (\Exception $e) {
            Log::error('OAuth callback failed: ' . $e->getMessage());
            return redirect()->route('admin.backup.settings')
                            ->with('error', 'Authorization failed: ' . $e->getMessage());
        }
    }

    /**
     * Create manual backup
     */
    public function create(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:255'
        ]);

        try {
            if (!$this->backupService->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive is not properly configured. Please check your settings.'
                ], 400);
            }

            $result = $this->backupService->createBackup($request->description);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup created successfully!',
                'backup' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Manual backup failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download backup
     */
    public function download($fileId)
    {
        try {
            if (!$this->backupService->isConfigured()) {
                return redirect()->route('admin.backup.index')
                                ->with('error', 'Google Drive is not properly configured.');
            }

            $content = $this->backupService->downloadBackup($fileId);
            $filename = 'sjfashionhub_backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.zip';
            
            return response($content)
                    ->header('Content-Type', 'application/zip')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            Log::error('Backup download failed: ' . $e->getMessage());
            return redirect()->route('admin.backup.index')
                            ->with('error', 'Failed to download backup: ' . $e->getMessage());
        }
    }

    /**
     * Delete backup
     */
    public function delete($fileId)
    {
        try {
            if (!$this->backupService->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive is not properly configured.'
                ], 400);
            }

            $this->backupService->deleteBackup($fileId);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Backup deletion failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete backup: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Google Drive connection
     */
    public function testConnection()
    {
        try {
            if (!$this->backupService->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive is not properly configured.'
                ]);
            }

            // Try to list files to test connection
            $backups = $this->backupService->listBackups();
            
            return response()->json([
                'success' => true,
                'message' => 'Google Drive connection successful!',
                'backup_count' => count($backups)
            ]);

        } catch (\Exception $e) {
            Log::error('Connection test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get backup status for dashboard
     */
    public function status()
    {
        try {
            $isConfigured = $this->backupService->isConfigured();
            $backupCount = 0;
            $lastBackup = null;
            $totalSize = 0;

            if ($isConfigured) {
                $backups = $this->backupService->listBackups();
                $backupCount = count($backups);
                $lastBackup = $backups[0] ?? null;
                $totalSize = array_sum(array_column($backups, 'size_bytes'));
            }

            return response()->json([
                'configured' => $isConfigured,
                'backup_count' => $backupCount,
                'last_backup' => $lastBackup,
                'total_size' => $this->formatFileSize($totalSize),
                'schedule_enabled' => setting('backup_schedule_enabled', false),
                'next_backup' => $this->getNextBackupTime()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'configured' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get next scheduled backup time
     */
    private function getNextBackupTime()
    {
        if (!setting('backup_schedule_enabled', false)) {
            return null;
        }

        $scheduleTime = setting('backup_schedule_time', '02:00');
        $nextBackup = Carbon::today()->setTimeFromTimeString($scheduleTime);
        
        if ($nextBackup->isPast()) {
            $nextBackup->addDay();
        }

        return $nextBackup;
    }

    /**
     * Format file size
     */
    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
