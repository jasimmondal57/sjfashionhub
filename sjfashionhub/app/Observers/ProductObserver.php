<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\SocialMediaConfig;
use App\Models\SocialMediaPost;
use App\Services\SeoService;
use App\Services\EmailNotificationService;
use App\Services\AIContentGeneratorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    protected SeoService $seoService;
    protected AIContentGeneratorService $aiContentGenerator;

    public function __construct(SeoService $seoService, AIContentGeneratorService $aiContentGenerator)
    {
        $this->seoService = $seoService;
        $this->aiContentGenerator = $aiContentGenerator;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->generateSeoContent($product);
        $this->checkStockLevel($product);

        // Auto-share to social media if enabled
        if ($product->auto_share_social_media && $product->is_active) {
            $this->autoShareToSocialMedia($product);
        }
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

        // Auto-share if just activated and auto_share is enabled
        if ($product->auto_share_social_media && $product->is_active && !$product->auto_shared_at) {
            $this->autoShareToSocialMedia($product);
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

    /**
     * Auto-share product to configured social media platforms
     */
    private function autoShareToSocialMedia(Product $product): void
    {
        try {
            // Get active social media configs
            $platforms = $product->auto_share_platforms ?? [];

            // If no specific platforms selected, use all active ones
            if (empty($platforms)) {
                $activeConfigs = SocialMediaConfig::where('is_active', true)->get();
                $platforms = $activeConfigs->pluck('platform')->toArray();
            }

            if (empty($platforms)) {
                Log::info("No active social media platforms configured for auto-share", [
                    'product_id' => $product->id
                ]);
                return;
            }

            $sharedPlatforms = [];

            foreach ($platforms as $platform) {
                try {
                    // Check if platform is configured
                    $config = SocialMediaConfig::where('platform', $platform)
                        ->where('is_active', true)
                        ->first();

                    if (!$config) {
                        Log::warning("Platform not configured or inactive", [
                            'product_id' => $product->id,
                            'platform' => $platform
                        ]);
                        continue;
                    }

                    // Generate AI content for this platform
                    $content = $this->aiContentGenerator->generateProductPost($product, $platform);

                    // Create social media post record
                    $post = SocialMediaPost::create([
                        'product_id' => $product->id,
                        'user_id' => 1, // System user
                        'platform' => $platform,
                        'content' => $content['text'],
                        'hashtags' => $content['hashtags'],
                        'images' => $product->images,
                        'status' => 'pending',
                        'is_ai_generated' => true,
                        'ai_prompt' => $content['prompt'],
                        'metadata' => [
                            'product_url' => $content['product_url'] ?? url("/products/{$product->slug}"),
                            'price_info' => $content['price_info'] ?? null,
                            'call_to_action' => $content['call_to_action'] ?? 'Shop now at sjfashionhub.in',
                            'ai_model' => 'gemini-pro',
                            'auto_shared' => true
                        ]
                    ]);

                    $sharedPlatforms[] = $platform;

                    Log::info("Auto-shared product to social media", [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'platform' => $platform,
                        'post_id' => $post->id
                    ]);

                } catch (\Exception $e) {
                    Log::error("Failed to auto-share product to platform", [
                        'product_id' => $product->id,
                        'platform' => $platform,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Update product with auto-shared timestamp and platforms
            if (!empty($sharedPlatforms)) {
                $product->updateQuietly([
                    'auto_shared_at' => now(),
                    'auto_share_platforms' => $sharedPlatforms
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Error in auto-share process", [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
