<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Category;
use App\Services\SeoService;
use Illuminate\Console\Command;

class GenerateSeoContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:generate
                            {--type=all : Type of content to generate (products, categories, all)}
                            {--force : Force regenerate even if SEO content already exists}
                            {--id= : Generate SEO for specific ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate AI-powered SEO content for products and categories';

    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        parent::__construct();
        $this->seoService = $seoService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $force = $this->option('force');
        $id = $this->option('id');

        $this->info('🚀 Starting AI-powered SEO content generation...');

        if ($type === 'products' || $type === 'all') {
            $this->generateProductSeo($force, $id);
        }

        if ($type === 'categories' || $type === 'all') {
            $this->generateCategorySeo($force, $id);
        }

        $this->info('✅ SEO content generation completed!');
    }

    /**
     * Generate SEO content for products
     */
    private function generateProductSeo(bool $force, ?string $id): void
    {
        $this->info('📦 Generating SEO content for products...');

        $query = Product::with('category');

        if ($id) {
            $query->where('id', $id);
        } elseif (!$force) {
            $query->where('seo_generated', false);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->warn('No products found to generate SEO content for.');
            return;
        }

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            try {
                $seoData = $this->seoService->generateProductSeo($product);

                $product->update([
                    'seo_title' => $seoData['seo_title'],
                    'meta_description' => $seoData['meta_description'],
                    'short_description' => $seoData['short_description'],
                    'long_description' => $seoData['long_description'],
                    'meta_keywords' => $seoData['meta_keywords'],
                    'structured_data' => $seoData['structured_data'],
                    'seo_generated' => true,
                    'seo_generated_at' => now(),
                ]);

                $bar->advance();
            } catch (\Exception $e) {
                $this->error("Failed to generate SEO for product {$product->id}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Generated SEO content for {$products->count()} products");
    }

    /**
     * Generate SEO content for categories
     */
    private function generateCategorySeo(bool $force, ?string $id): void
    {
        $this->info('📂 Generating SEO content for categories...');

        $query = Category::query();

        if ($id) {
            $query->where('id', $id);
        } elseif (!$force) {
            $query->where('seo_generated', false);
        }

        $categories = $query->get();

        if ($categories->isEmpty()) {
            $this->warn('No categories found to generate SEO content for.');
            return;
        }

        $bar = $this->output->createProgressBar($categories->count());
        $bar->start();

        foreach ($categories as $category) {
            try {
                $seoData = $this->seoService->generateCategorySeo($category);

                $category->update([
                    'seo_title' => $seoData['seo_title'],
                    'meta_description' => $seoData['meta_description'],
                    'description' => $seoData['description'],
                    'meta_keywords' => $seoData['meta_keywords'],
                    'seo_generated' => true,
                    'seo_generated_at' => now(),
                ]);

                $bar->advance();
            } catch (\Exception $e) {
                $this->error("Failed to generate SEO for category {$category->id}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Generated SEO content for {$categories->count()} categories");
    }
}
