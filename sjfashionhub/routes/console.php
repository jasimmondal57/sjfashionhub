<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule daily backups
Schedule::command('backup:create --description="Scheduled daily backup"')
    ->dailyAt(setting('backup_schedule_time', '02:00'))
    ->when(function () {
        return setting('backup_schedule_enabled', false);
    })
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Scheduled backup completed successfully');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('Scheduled backup failed');
    });
