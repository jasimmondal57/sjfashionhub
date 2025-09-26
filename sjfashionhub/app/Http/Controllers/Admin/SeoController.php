<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\SeoService;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Display SEO dashboard
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'products_with_seo' => Product::where('seo_generated', true)->count(),
            'total_categories' => Category::count(),
            'categories_with_seo' => Category::where('seo_generated', true)->count(),
        ];

        $recentProducts = Product::with('category')
            ->where('seo_generated', true)
            ->latest('seo_generated_at')
            ->limit(5)
            ->get();

        $recentCategories = Category::where('seo_generated', true)
            ->latest('seo_generated_at')
            ->limit(5)
            ->get();

        return view('admin.seo.index', compact('stats', 'recentProducts', 'recentCategories'));
    }

    /**
     * Display products SEO management
     */
    public function products(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'with_seo':
                    $query->where('seo_generated', true);
                    break;
                case 'without_seo':
                    $query->where('seo_generated', false);
                    break;
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(20);

        return view('admin.seo.products', compact('products'));
    }

    /**
     * Display categories SEO management
     */
    public function categories(Request $request)
    {
        $query = Category::query();

        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'with_seo':
                    $query->where('seo_generated', true);
                    break;
                case 'without_seo':
                    $query->where('seo_generated', false);
                    break;
            }
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(20);

        return view('admin.seo.categories', compact('categories'));
    }

    /**
     * Generate SEO for specific product
     */
    public function generateProduct(Product $product)
    {
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

            return response()->json([
                'success' => true,
                'message' => 'SEO content generated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate SEO content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate SEO for specific category
     */
    public function generateCategory(Category $category)
    {
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

            return response()->json([
                'success' => true,
                'message' => 'SEO content generated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate SEO content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk generate SEO
     */
    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:products,categories',
            'force' => 'boolean'
        ]);

        try {
            if ($request->type === 'products') {
                $query = Product::with('category');
                if (!$request->force) {
                    $query->where('seo_generated', false);
                }
                $items = $query->get();

                foreach ($items as $product) {
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
                }
            } else {
                $query = Category::query();
                if (!$request->force) {
                    $query->where('seo_generated', false);
                }
                $items = $query->get();

                foreach ($items as $category) {
                    $seoData = $this->seoService->generateCategorySeo($category);
                    $category->update([
                        'seo_title' => $seoData['seo_title'],
                        'meta_description' => $seoData['meta_description'],
                        'description' => $seoData['description'],
                        'meta_keywords' => $seoData['meta_keywords'],
                        'seo_generated' => true,
                        'seo_generated_at' => now(),
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "SEO content generated for {$items->count()} {$request->type}!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate SEO content: ' . $e->getMessage()
            ], 500);
        }
    }
}
