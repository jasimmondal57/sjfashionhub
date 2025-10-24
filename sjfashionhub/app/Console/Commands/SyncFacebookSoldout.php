<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FacebookCatalogService;
use App\Models\FacebookSetting;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class SyncFacebookSoldout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:sync-soldout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync sold-out products to Facebook catalogue';

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
                return Command::FAILURE;
            }

            $this->info('Checking for sold-out products...');
            Log::info('Starting Facebook sold-out products sync');

            // Initialize the service
            $catalogService = new FacebookCatalogService();

            // Find products that are out of stock
            $soldOutProducts = Product::where('status', 'active')
                ->where('stock_quantity', '<=', 0)
                ->get();

            if ($soldOutProducts->isEmpty()) {
                $this->info('✅ No sold-out products to sync.');
                return Command::SUCCESS;
            }

            $this->info("Found {$soldOutProducts->count()} sold-out products. Syncing...");

            $synced = 0;
            $failed = 0;

            foreach ($soldOutProducts as $product) {
                try {
                    // Update inventory to mark as out of stock
                    $catalogService->updateInventory($product);
                    $synced++;
                    $this->line("  ✓ {$product->name} - marked as out of stock");
                } catch (\Exception $e) {
                    $failed++;
                    $this->error("  ✗ {$product->name} - {$e->getMessage()}");
                    Log::error('Failed to sync sold-out product', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $this->info("✅ Sold-out sync completed!");
            $this->info("📊 Updated: {$synced} products");
            $this->info("❌ Failed: {$failed} products");

            Log::info('Facebook sold-out sync completed', [
                'synced' => $synced,
                'failed' => $failed,
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Sync failed: {$e->getMessage()}");
            Log::error('Facebook sold-out sync error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}

