<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Sync Facebook Catalogue every hour
        $schedule->command('facebook:sync-catalogue')
            ->hourly()
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Facebook catalogue sync failed');
            })
            ->onSuccess(function () {
                \Log::info('Facebook catalogue sync completed successfully');
            });

        // Check for sold-out products and sync to Facebook every 30 minutes
        $schedule->command('facebook:sync-soldout')
            ->everyThirtyMinutes()
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Facebook sold-out sync failed');
            });

        // Optional: Full catalogue sync at midnight
        $schedule->command('facebook:sync-catalogue')
            ->dailyAt('00:00')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

