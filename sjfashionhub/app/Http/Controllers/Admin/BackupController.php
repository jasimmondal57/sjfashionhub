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

    public function __construct()
    {
        // Initialize service only when needed to avoid constructor errors
    }

    private function getBackupService()
    {
        if (!$this->backupService) {
            $this->backupService = new GoogleDriveBackupService();
        }
        return $this->backupService;
    }

    /**
     * Display backup management page
     */
    public function index()
    {
        // List local backups
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $backups = [];
        $files = glob($backupPath . '/*.zip');

        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'path' => $file,
                'size' => filesize($file),
                'size_formatted' => $this->formatBytes(filesize($file)),
                'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                'created_at_human' => \Carbon\Carbon::createFromTimestamp(filemtime($file))->diffForHumans(),
            ];
        }

        // Sort by creation time (newest first)
        usort($backups, function($a, $b) {
            return filemtime($b['path']) - filemtime($a['path']);
        });

        $isConfigured = true; // Local backups always work

        return view('admin.backup.index', compact('backups', 'isConfigured'));
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Display Google Drive settings page
     */
    public function settings()
    {
        $settings = [
            'google_drive_client_id' => env('GOOGLE_DRIVE_CLIENT_ID', ''),
            'google_drive_client_secret' => env('GOOGLE_DRIVE_CLIENT_SECRET', ''),
            'google_drive_redirect_uri' => env('GOOGLE_DRIVE_REDIRECT_URI', route('admin.backup.callback')),
            'google_drive_backup_folder' => env('GOOGLE_DRIVE_BACKUP_FOLDER', 'SJ Fashion Hub Backups'),
            'backup_schedule_enabled' => env('BACKUP_SCHEDULE_ENABLED', false),
            'backup_schedule_time' => env('BACKUP_SCHEDULE_TIME', '02:00'),
            'backup_retention_days' => env('BACKUP_RETENTION_DAYS', 7),
        ];

        $isConfigured = !empty($settings['google_drive_client_id']) &&
                       !empty($settings['google_drive_client_secret']) &&
                       !empty($settings['google_drive_redirect_uri']);

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

        // Save settings to .env file (simplified approach)
        // Note: In production, you might want to use a database or proper config management
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // Update or add environment variables
        $updates = [
            'GOOGLE_DRIVE_CLIENT_ID' => $request->google_drive_client_id,
            'GOOGLE_DRIVE_CLIENT_SECRET' => $request->google_drive_client_secret,
            'GOOGLE_DRIVE_REDIRECT_URI' => $request->google_drive_redirect_uri,
            'GOOGLE_DRIVE_BACKUP_FOLDER' => '"' . $request->google_drive_backup_folder . '"',
            'BACKUP_SCHEDULE_ENABLED' => $request->has('backup_schedule_enabled') ? 'true' : 'false',
            'BACKUP_SCHEDULE_TIME' => $request->backup_schedule_time,
            'BACKUP_RETENTION_DAYS' => $request->backup_retention_days,
        ];

        // Update .env file
        foreach ($updates as $key => $value) {
            if (strpos($envContent, $key . '=') !== false) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envFile, $envContent);

        return redirect()->route('admin.backup.settings')
                        ->with('success', 'Google Drive settings updated successfully!');
    }

    /**
     * Start Google Drive authorization
     */
    public function authorize()
    {
        try {
            $authUrl = $this->getBackupService()->getAuthorizationUrl();
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
            $success = $this->getBackupService()->handleCallback($request->code);

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
     * Create manual backup (Full Site)
     */
    public function create(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:255'
        ]);

        try {
            set_time_limit(300); // 5 minutes timeout for large backups

            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $timestamp = date('Y-m-d_H-i-s');
            $description = $request->description ? '_' . str_replace(' ', '_', $request->description) : '';
            $filename = "sjfashionhub_full_backup_{$timestamp}{$description}.zip";
            $zipPath = $backupPath . '/' . $filename;

            // Create ZIP archive
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Failed to create ZIP file');
            }

            $basePath = base_path();

            // Add database
            $dbPath = database_path('database.sqlite');
            if (file_exists($dbPath)) {
                $zip->addFile($dbPath, 'database/database.sqlite');
            }

            // Add .env file
            $envPath = base_path('.env');
            if (file_exists($envPath)) {
                $zip->addFile($envPath, '.env');
            }

            // Add all important directories
            $directories = [
                'app' => 'app',
                'bootstrap' => 'bootstrap',
                'config' => 'config',
                'database/migrations' => 'database/migrations',
                'database/seeders' => 'database/seeders',
                'public' => 'public',
                'resources' => 'resources',
                'routes' => 'routes',
                'storage/app/public' => 'storage/app/public',
            ];

            foreach ($directories as $dir => $zipDir) {
                $fullPath = base_path($dir);
                if (is_dir($fullPath)) {
                    $this->addDirectoryToZip($zip, $fullPath, $zipDir, 10000); // Allow up to 10k files
                }
            }

            // Add important root files
            $rootFiles = [
                'composer.json',
                'composer.lock',
                'package.json',
                'package-lock.json',
                'artisan',
                'vite.config.js',
                'tailwind.config.js',
                'postcss.config.js',
            ];

            foreach ($rootFiles as $file) {
                $filePath = base_path($file);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file);
                }
            }

            $zip->close();

            return response()->json([
                'success' => true,
                'message' => 'Full site backup created successfully!',
                'backup' => [
                    'name' => $filename,
                    'size' => $this->formatBytes(filesize($zipPath)),
                    'created_at' => date('Y-m-d H:i:s'),
                ]
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
     * Add directory to ZIP recursively (with file limit)
     */
    private function addDirectoryToZip($zip, $dir, $zipDir = '', $maxFiles = 10000)
    {
        if (!is_dir($dir)) {
            return;
        }

        $fileCount = 0;

        // Exclude patterns
        $excludePatterns = [
            '/node_modules/',
            '/vendor/',
            '/.git/',
            '/storage/logs/',
            '/storage/framework/cache/',
            '/storage/framework/sessions/',
            '/storage/framework/views/',
            '/storage/app/backups/',
        ];

        try {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if ($fileCount >= $maxFiles) {
                    break;
                }

                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();

                    // Skip excluded paths
                    $skip = false;
                    foreach ($excludePatterns as $pattern) {
                        if (strpos($filePath, $pattern) !== false) {
                            $skip = true;
                            break;
                        }
                    }

                    if (!$skip) {
                        $relativePath = $zipDir . '/' . substr($filePath, strlen($dir) + 1);
                        $zip->addFile($filePath, $relativePath);
                        $fileCount++;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error adding directory to zip: ' . $e->getMessage());
        }
    }

    /**
     * Download backup (Local)
     */
    public function download($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . $filename);

            if (!file_exists($backupPath)) {
                return redirect()->route('admin.backup.index')
                                ->with('error', 'Backup file not found.');
            }

            return response()->download($backupPath);

        } catch (\Exception $e) {
            Log::error('Backup download failed: ' . $e->getMessage());
            return redirect()->route('admin.backup.index')
                            ->with('error', 'Failed to download backup: ' . $e->getMessage());
        }
    }

    /**
     * Delete backup (Local)
     */
    public function delete($filename)
    {
        try {
            $backupPath = storage_path('app/backups/' . $filename);

            if (!file_exists($backupPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Backup file not found.'
                ], 404);
            }

            unlink($backupPath);

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
            if (!$this->getBackupService()->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Drive is not properly configured.'
                ]);
            }

            // Try to list files to test connection
            $backups = $this->getBackupService()->listBackups();
            
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
            $isConfigured = $this->getBackupService()->isConfigured();
            $backupCount = 0;
            $lastBackup = null;
            $totalSize = 0;

            if ($isConfigured) {
                $backups = $this->getBackupService()->listBackups();
                $backupCount = count($backups);
                $lastBackup = $backups[0] ?? null;
                $totalSize = array_sum(array_column($backups, 'size_bytes'));
            }

            return response()->json([
                'configured' => $isConfigured,
                'backup_count' => $backupCount,
                'last_backup' => $lastBackup,
                'total_size' => $this->formatFileSize($totalSize),
                'schedule_enabled' => config('backup.schedule_enabled', false),
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
        if (!config('backup.schedule_enabled', false)) {
            return null;
        }

        $scheduleTime = config('backup.schedule_time', '02:00');
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
