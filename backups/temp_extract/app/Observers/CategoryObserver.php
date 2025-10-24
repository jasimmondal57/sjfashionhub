<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\SeoService;

class CategoryObserver
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->generateSeoContent($category);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        // Only regenerate SEO if core category data changed
        if ($this->shouldRegenerateSeo($category)) {
            $this->generateSeoContent($category);
        }
    }

    /**
     * Generate SEO content for the category
     */
    private function generateSeoContent(Category $category): void
    {
        try {
            $seoData = $this->seoService->generateCategorySeo($category);

            // Update without triggering observers again
            $category->updateQuietly([
                'seo_title' => $seoData['seo_title'],
                'meta_description' => $seoData['meta_description'],
                'description' => $seoData['description'],
                'meta_keywords' => $seoData['meta_keywords'],
                'seo_generated' => true,
                'seo_generated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't fail the category creation/update
            \Log::error("Failed to generate SEO content for category {$category->id}: " . $e->getMessage());
        }
    }

    /**
     * Check if SEO content should be regenerated
     */
    private function shouldRegenerateSeo(Category $category): bool
    {
        // Regenerate if core category information changed
        $coreFields = ['name', 'description'];

        foreach ($coreFields as $field) {
            if ($category->isDirty($field)) {
                return true;
            }
        }

        return false;
    }
}
