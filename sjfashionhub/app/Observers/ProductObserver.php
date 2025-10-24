<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\SeoService;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->generateSeoContent($product);
        $this->checkStockLevel($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Only regenerate SEO if core product data changed
        if ($this->shouldRegenerateSeo($product)) {
            $this->generateSeoContent($product);
        }

        // Check if stock quantity changed
        if ($product->isDirty('stock_quantity')) {
            $oldStock = $product->getOriginal('stock_quantity');
            $newStock = $product->stock_quantity;

            Log::info("Product stock changed from {$oldStock} to {$newStock} for product: {$product->name} (SKU: {$product->sku})");

            // Check stock level after update
            $this->checkStockLevel($product);
        }
    }

    /**
     * Generate SEO content for the product
     */
    private function generateSeoContent(Product $product): void
    {
        try {
            // Load the category relationship if not already loaded
            if (!$product->relationLoaded('category')) {
                $product->load('category');
            }

            $seoData = $this->seoService->generateProductSeo($product);

            // Update without triggering observers again
            $product->updateQuietly([
                'seo_title' => $seoData['seo_title'],
                'meta_description' => $seoData['meta_description'],
                'short_description' => $seoData['short_description'],
                'long_description' => $seoData['long_description'],
                'meta_keywords' => $seoData['meta_keywords'],
                'structured_data' => $seoData['structured_data'],
                'seo_generated' => true,
                'seo_generated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't fail the product creation/update
            \Log::error("Failed to generate SEO content for product {$product->id}: " . $e->getMessage());
        }
    }

    /**
     * Check if SEO content should be regenerated
     */
    private function shouldRegenerateSeo(Product $product): bool
    {
        // Regenerate if core product information changed
        $coreFields = ['name', 'description', 'category_id', 'price', 'sale_price'];

        foreach ($coreFields as $field) {
            if ($product->isDirty($field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check stock level and send alert if needed
     */
    private function checkStockLevel(Product $product): void
    {
        try {
            // Only check if stock management is enabled for this product
            if (!$product->manage_stock) {
                return;
            }

            $threshold = $product->low_stock_threshold ?? 10; // Default threshold of 10

            // Check if stock is below threshold
            if ($product->stock_quantity <= $threshold) {
                // Use cache to prevent spam emails (send alert only once per hour per product)
                $cacheKey = "low_stock_alert_sent_{$product->id}";

                if (!Cache::has($cacheKey)) {
                    // Send low stock alert
                    EmailNotificationService::sendLowStockAlert($product);

                    // Cache for 1 hour to prevent spam
                    Cache::put($cacheKey, true, 3600);

                    Log::info("Low stock alert sent for product: {$product->name} (SKU: {$product->sku}) - Stock: {$product->stock_quantity}, Threshold: {$threshold}");
                }
            } else {
                // Clear cache if stock is above threshold (so alert can be sent again if it drops)
                $cacheKey = "low_stock_alert_sent_{$product->id}";
                Cache::forget($cacheKey);
            }
        } catch (\Exception $e) {
            Log::error("Failed to check stock level for product {$product->sku}: " . $e->getMessage());
        }
    }
}
