<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleDriveBackupService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CreateBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create {--description= : Optional description for the backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a complete site backup and upload to Google Drive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting backup creation...');
        
        try {
            $backupService = app(GoogleDriveBackupService::class);
            
            // Check if Google Drive is configured
            if (!$backupService->isConfigured()) {
                $this->error('Google Drive is not properly configured. Please check your settings.');
                return 1;
            }

            $description = $this->option('description') ?: 'Scheduled backup created on ' . Carbon::now()->format('Y-m-d H:i:s');
            
            $this->info('Creating backup with description: ' . $description);
            
            $result = $backupService->createBackup($description);
            
            if ($result['success']) {
                $this->info('✅ Backup created successfully!');
                $this->info('📁 Backup name: ' . $result['backup_name']);
                $this->info('☁️  Google Drive file ID: ' . $result['drive_file_id']);
                
                Log::info('Scheduled backup completed successfully', $result);
                return 0;
            } else {
                $this->error('❌ Backup creation failed');
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Backup failed: ' . $e->getMessage());
            Log::error('Scheduled backup failed: ' . $e->getMessage());
            return 1;
        }
    }
}
