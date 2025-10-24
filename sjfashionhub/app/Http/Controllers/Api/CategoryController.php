<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function index(Request $request)
    {
        $query = Category::where('is_active', true);

        // Apply filters
        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return $this->formatCategory($category);
            });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get top categories
     */
    public function topCategories(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(10)
            ->get()
            ->map(function ($category) {
                return $this->formatCategory($category);
            });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get products by category ID
     */
    public function getProductsByCategory(Request $request, $categoryId)
    {
        try {
            // Find the category
            $category = Category::where('id', $categoryId)
                ->where('is_active', true)
                ->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Get products for this category with pagination
            $perPage = $request->get('per_page', 20);
            $page = $request->get('page', 1);

            $query = Product::where('category_id', $categoryId)
                ->where('is_active', true)
                ->with(['category']);

            // Apply sorting if provided
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');

            if (in_array($sortBy, ['name', 'price', 'created_at'])) {
                $query->orderBy($sortBy, $sortOrder);
            }

            $products = $query->paginate($perPage, ['*'], 'page', $page);

            // Format products for API response - simple format matching our site structure
            $formattedProducts = $products->getCollection()->map(function ($product) {
                // Get images array
                $images = $product->image_urls ?? [];

                // Set main image to first image if available
                $mainImage = null;
                if (!empty($images)) {
                    $mainImage = $images[0];
                    // Add full URL if not already present
                    if (!str_starts_with($mainImage, 'http')) {
                        $mainImage = asset($mainImage);
                    }
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $mainImage,
                    'images' => array_map(function($img) {
                        return str_starts_with($img, 'http') ? $img : asset($img);
                    }, $images),
                    'is_featured' => $product->is_featured,
                    'in_stock' => $product->stock_quantity > 0,
                    'stock' => $product->stock_quantity,
                    'rating' => $product->rating ?? 0,
                    'category' => [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                        'slug' => $product->category->slug,
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'parent_id' => $category->parent_id,
                    'depth_level' => 0,
                    'icon' => $category->image ? asset('storage/' . $category->image) : null,
                    'searchable' => 1,
                    'status' => 1,
                    'AllProducts' => $formattedProducts,
                    'categoryImage' => $category->image ? [
                        'id' => 1,
                        'category_id' => $category->id,
                        'image' => asset('storage/' . $category->image),
                    ] : null,
                    'parentCategory' => null,
                    'subCategories' => []
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format category data for API response
     */
    private function formatCategory($category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'image' => $category->image ? asset('storage/' . $category->image) : null,
            'parent_id' => $category->parent_id,
            'is_featured' => $category->is_featured,
            'sort_order' => $category->sort_order,
            'products_count' => $category->products()->where('is_active', true)->count(),
            'children' => $category->children->where('is_active', true)->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'slug' => $child->slug,
                    'image' => $child->image ? asset('storage/' . $child->image) : null,
                    'products_count' => $child->products()->where('is_active', true)->count()
                ];
            })
        ];
    }
}
