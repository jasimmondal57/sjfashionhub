<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all categories
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image' => $category->image ? url('storage/' . $category->image) : null,
                    'products_count' => $category->products()->where('is_active', true)->count(),
                ];
            });

        return response()->json([
            'categories' => $categories,
        ]);
    }

    /**
     * Get single category with products
     */
    public function show($id)
    {
        $category = Category::where('is_active', true)->findOrFail($id);

        $products = $category->products()
            ->where('is_active', true)
            ->with(['category'])
            ->get()
            ->map(function ($product) {
                // Get images array
                $images = [];
                if ($product->images) {
                    $imageArray = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                    if (is_array($imageArray)) {
                        $images = array_map(function($img) {
                            return str_starts_with($img, 'http') ? $img : asset($img);
                        }, $imageArray);
                    }
                }

                // Set main image from first image in array if available
                $mainImage = null;
                if (!empty($images)) {
                    $mainImage = $images[0];
                } elseif ($product->image) {
                    $mainImage = str_starts_with($product->image, 'http') ? $product->image : asset($product->image);
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $mainImage,
                    'images' => $images,
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

        // Return in the format expected by Flutter app
        $response = [
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
                'AllProducts' => [
                    'data' => $products,
                    'total' => $products->count(),
                ],
                'categoryImage' => $category->image ? [
                    'id' => 1,
                    'category_id' => $category->id,
                    'image' => asset('storage/' . $category->image),
                ] : null,
                'parentCategory' => null,
                'subCategories' => []
            ]
        ];

        return response()->json($response);
    }
}

