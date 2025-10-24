<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\FacebookSetting;
use App\Services\FacebookCatalogService;
use Illuminate\Support\Facades\Log;

class ProductFacebookObserver
{
    protected $catalogService;

    public function __construct(FacebookCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->syncToFacebook($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $settings = FacebookSetting::getInstance();
        
        if (!$settings->isCatalogConfigured()) {
            return;
        }

        // Check what was updated
        if ($product->wasChanged('stock') && $settings->auto_sync_inventory) {
            // Stock changed - update inventory
            try {
                $this->catalogService->updateInventory($product);
            } catch (\Exception $e) {
                Log::error('Failed to auto-update Facebook inventory', [
                    'product_id' => $product->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        if (($product->wasChanged('price') || $product->wasChanged('sale_price')) && $settings->auto_sync_prices) {
            // Price changed - update price
            try {
                $this->catalogService->updatePrice($product);
            } catch (\Exception $e) {
                Log::error('Failed to auto-update Facebook price', [
                    'product_id' => $product->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // If other important fields changed, do full sync
        if ($product->wasChanged(['name', 'description', 'image', 'status'])) {
            $this->syncToFacebook($product);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $settings = FacebookSetting::getInstance();
        
        if (!$settings->isCatalogConfigured()) {
            return;
        }

        try {
            $this->catalogService->deleteProduct($product);
        } catch (\Exception $e) {
            Log::error('Failed to delete product from Facebook', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Sync product to Facebook
     */
    private function syncToFacebook(Product $product)
    {
        $settings = FacebookSetting::getInstance();
        
        if (!$settings->isCatalogConfigured()) {
            return;
        }

        // Only sync active products
        if ($product->status !== 'active') {
            return;
        }

        try {
            $this->catalogService->syncProduct($product);
        } catch (\Exception $e) {
            Log::error('Failed to sync product to Facebook', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

