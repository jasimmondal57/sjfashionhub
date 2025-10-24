<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FacebookCatalogService;
use App\Models\FacebookSetting;
use Illuminate\Support\Facades\Log;

class SyncFacebookCatalogue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:sync-catalogue {--force : Force sync even if recently synced}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products to Facebook catalogue every hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $settings = FacebookSetting::getInstance();

            // Check if Facebook catalogue is configured
            if (!$settings->isCatalogConfigured()) {
                $this->warn('Facebook Catalogue is not configured. Skipping sync.');
                Log::warning('Facebook catalogue sync skipped - not configured');
                return Command::FAILURE;
            }

            // Check if auto-sync is enabled
            if (!$settings->auto_sync_enabled && !$this->option('force')) {
                $this->warn('Auto-sync is disabled. Use --force to override.');
                return Command::SUCCESS;
            }

            $this->info('Starting Facebook Catalogue sync...');
            Log::info('Starting scheduled Facebook catalogue sync');

            // Initialize the service
            $catalogService = new FacebookCatalogService();

            // Sync all products
            $result = $catalogService->syncAllProducts();

            $this->info("✅ Sync completed!");
            $this->info("📊 Synced: {$result['synced']} products");
            $this->info("❌ Failed: {$result['failed']} products");

            Log::info('Facebook catalogue sync completed', [
                'synced' => $result['synced'],
                'failed' => $result['failed'],
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Sync failed: {$e->getMessage()}");
            Log::error('Facebook catalogue sync error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}

