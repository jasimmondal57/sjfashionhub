<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use ZipArchive;

class GoogleDriveBackupService
{
    private $client;
    private $driveService;
    private $backupFolderId;

    public function __construct()
    {
        $this->initializeGoogleClient();
    }

    /**
     * Initialize Google Drive client
     */
    private function initializeGoogleClient()
    {
        try {
            $this->client = new Client();
            $this->client->setApplicationName('SJ Fashion Hub Backup');
            $this->client->setScopes([Drive::DRIVE_FILE]);
            $this->client->setAccessType('offline');
            $this->client->setPrompt('select_account consent');

            // Get credentials from settings
            $credentials = $this->getGoogleDriveCredentials();
            if ($credentials) {
                $this->client->setAuthConfig($credentials);
                
                // Set refresh token if available
                $refreshToken = config('backup.google_drive_refresh_token');
                if ($refreshToken) {
                    $this->client->refreshToken($refreshToken);
                }
                
                $this->driveService = new Drive($this->client);
                $this->backupFolderId = $this->getOrCreateBackupFolder();
            }
        } catch (\Exception $e) {
            Log::error('Failed to initialize Google Drive client: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get Google Drive credentials from settings
     */
    private function getGoogleDriveCredentials()
    {
        $clientId = config('backup.google_drive_client_id');
        $clientSecret = config('backup.google_drive_client_secret');
        $redirectUri = config('backup.google_drive_redirect_uri', route('admin.backup.callback'));

        if (!$clientId || !$clientSecret || !$redirectUri) {
            return null;
        }

        return [
            'web' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uris' => [$redirectUri],
                'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
                'token_uri' => 'https://oauth2.googleapis.com/token',
            ]
        ];
    }

    /**
     * Get or create backup folder in Google Drive
     */
    private function getOrCreateBackupFolder()
    {
        $folderName = config('backup.google_drive_backup_folder', 'SJ Fashion Hub Backups');
        
        // Search for existing folder
        $response = $this->driveService->files->listFiles([
            'q' => "name='{$folderName}' and mimeType='application/vnd.google-apps.folder' and trashed=false",
            'fields' => 'files(id, name)'
        ]);

        if (count($response->files) > 0) {
            return $response->files[0]->id;
        }

        // Create new folder
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        $folder = $this->driveService->files->create($fileMetadata, [
            'fields' => 'id'
        ]);

        return $folder->id;
    }

    /**
     * Create complete site backup
     */
    public function createBackup($description = null)
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = "sjfashionhub_backup_{$timestamp}";
            $tempPath = storage_path("app/temp/{$backupName}");
            
            // Create temp directory
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }

            Log::info("Starting backup creation: {$backupName}");

            // 1. Database backup
            $this->createDatabaseBackup($tempPath);

            // 2. Files backup
            $this->createFilesBackup($tempPath);

            // 3. Configuration backup
            $this->createConfigBackup($tempPath);

            // 4. Create ZIP archive
            $zipPath = $this->createZipArchive($tempPath, $backupName);

            // 5. Upload to Google Drive
            $driveFileId = $this->uploadToGoogleDrive($zipPath, $backupName, $description);

            // 6. Clean up temp files
            $this->cleanupTempFiles($tempPath, $zipPath);

            // 7. Clean old backups (keep last 7 days)
            $this->cleanOldBackups();

            Log::info("Backup completed successfully: {$backupName}");

            return [
                'success' => true,
                'backup_name' => $backupName,
                'drive_file_id' => $driveFileId,
                'timestamp' => $timestamp,
                'description' => $description
            ];

        } catch (\Exception $e) {
            Log::error('Backup creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create database backup
     */
    private function createDatabaseBackup($tempPath)
    {
        $dbPath = database_path('database.sqlite');
        $backupDbPath = $tempPath . '/database.sqlite';
        
        if (file_exists($dbPath)) {
            copy($dbPath, $backupDbPath);
        }

        // Also create SQL dump for portability
        $sqlDumpPath = $tempPath . '/database_dump.sql';
        Artisan::call('backup:database', ['--path' => $sqlDumpPath]);
    }

    /**
     * Create files backup
     */
    private function createFilesBackup($tempPath)
    {
        $filesPath = $tempPath . '/files';
        mkdir($filesPath, 0755, true);

        // Backup storage directory
        $storagePath = storage_path('app/public');
        if (is_dir($storagePath)) {
            $this->copyDirectory($storagePath, $filesPath . '/storage');
        }

        // Backup uploads
        $uploadsPath = public_path('uploads');
        if (is_dir($uploadsPath)) {
            $this->copyDirectory($uploadsPath, $filesPath . '/uploads');
        }
    }

    /**
     * Create configuration backup
     */
    private function createConfigBackup($tempPath)
    {
        $configPath = $tempPath . '/config';
        mkdir($configPath, 0755, true);

        // Backup .env file (without sensitive data)
        $envContent = file_get_contents(base_path('.env'));
        $envContent = $this->sanitizeEnvFile($envContent);
        file_put_contents($configPath . '/env_backup.txt', $envContent);

        // Backup important config files
        $configFiles = ['app.php', 'database.php', 'filesystems.php'];
        foreach ($configFiles as $file) {
            $sourcePath = config_path($file);
            if (file_exists($sourcePath)) {
                copy($sourcePath, $configPath . '/' . $file);
            }
        }

        // Backup composer files
        copy(base_path('composer.json'), $configPath . '/composer.json');
        if (file_exists(base_path('composer.lock'))) {
            copy(base_path('composer.lock'), $configPath . '/composer.lock');
        }
    }

    /**
     * Sanitize .env file by removing sensitive data
     */
    private function sanitizeEnvFile($content)
    {
        $sensitiveKeys = [
            'DB_PASSWORD',
            'GOOGLE_DRIVE_CLIENT_SECRET',
            'GEMINI_API_KEY',
            'MAIL_PASSWORD',
            'AWS_SECRET_ACCESS_KEY'
        ];

        foreach ($sensitiveKeys as $key) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}=***HIDDEN***", $content);
        }

        return $content;
    }

    /**
     * Copy directory recursively
     */
    private function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $destPath = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            
            if ($item->isDir()) {
                if (!is_dir($destPath)) {
                    mkdir($destPath, 0755, true);
                }
            } else {
                copy($item, $destPath);
            }
        }
    }

    /**
     * Create ZIP archive
     */
    private function createZipArchive($tempPath, $backupName)
    {
        $zipPath = storage_path("app/temp/{$backupName}.zip");
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new \Exception("Cannot create zip file: {$zipPath}");
        }

        $this->addDirectoryToZip($zip, $tempPath, '');
        $zip->close();

        return $zipPath;
    }

    /**
     * Add directory to ZIP archive
     */
    private function addDirectoryToZip($zip, $source, $prefix)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $relativePath = $prefix . $iterator->getSubPathName();

            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($file, $relativePath);
            }
        }
    }

    /**
     * Upload backup to Google Drive
     */
    private function uploadToGoogleDrive($zipPath, $backupName, $description)
    {
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $backupName . '.zip',
            'parents' => [$this->backupFolderId],
            'description' => $description ?: "Automated backup created on " . Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $content = file_get_contents($zipPath);
        $file = $this->driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/zip',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $file->id;
    }

    /**
     * Clean up temporary files
     */
    private function cleanupTempFiles($tempPath, $zipPath)
    {
        // Remove temp directory
        $this->removeDirectory($tempPath);

        // Remove zip file
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

    /**
     * Remove directory recursively
     */
    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dir);
    }

    /**
     * Clean old backups (keep last 7 days)
     */
    private function cleanOldBackups()
    {
        $cutoffDate = Carbon::now()->subDays(7);

        $response = $this->driveService->files->listFiles([
            'q' => "parents in '{$this->backupFolderId}' and trashed=false",
            'fields' => 'files(id, name, createdTime)',
            'orderBy' => 'createdTime desc'
        ]);

        foreach ($response->files as $file) {
            $createdTime = Carbon::parse($file->createdTime);

            if ($createdTime->lt($cutoffDate)) {
                $this->driveService->files->delete($file->id);
                Log::info("Deleted old backup: {$file->name}");
            }
        }
    }

    /**
     * List all backups
     */
    public function listBackups()
    {
        $response = $this->driveService->files->listFiles([
            'q' => "parents in '{$this->backupFolderId}' and trashed=false",
            'fields' => 'files(id, name, size, createdTime, description)',
            'orderBy' => 'createdTime desc'
        ]);

        $backups = [];
        foreach ($response->files as $file) {
            $backups[] = [
                'id' => $file->id,
                'name' => $file->name,
                'size' => $this->formatFileSize($file->size),
                'size_bytes' => $file->size,
                'created_at' => Carbon::parse($file->createdTime),
                'description' => $file->description
            ];
        }

        return $backups;
    }

    /**
     * Download backup from Google Drive
     */
    public function downloadBackup($fileId)
    {
        $response = $this->driveService->files->get($fileId, [
            'alt' => 'media'
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Delete backup from Google Drive
     */
    public function deleteBackup($fileId)
    {
        $this->driveService->files->delete($fileId);
        Log::info("Backup deleted: {$fileId}");
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

    /**
     * Get authorization URL for Google Drive
     */
    public function getAuthorizationUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle OAuth callback and store tokens
     */
    public function handleCallback($code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['refresh_token'])) {
            // Store tokens in config or database
            config(['backup.google_drive_refresh_token' => $token['refresh_token']]);
            config(['backup.google_drive_access_token' => $token['access_token']]);
            return true;
        }

        return false;
    }

    /**
     * Check if Google Drive is properly configured
     */
    public function isConfigured()
    {
        return $this->client &&
               config('backup.google_drive_client_id') &&
               config('backup.google_drive_client_secret') &&
               config('backup.google_drive_refresh_token');
    }
}
