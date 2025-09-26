<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\SeoService;

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
}
