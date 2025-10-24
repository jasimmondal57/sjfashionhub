<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Get products by tag
     */
    public function singleTagProducts(Request $request)
    {
        $tagSlug = $request->get('tag');
        
        if (!$tagSlug) {
            return response()->json([
                'success' => false,
                'message' => 'Tag parameter is required'
            ], 400);
        }

        // Find tag
        $tag = Tag::where('slug', $tagSlug)
            ->where('status', 'active')
            ->first();

        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found'
            ], 404);
        }

        // Get products with this tag
        $query = Product::where('status', 'active')
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->with(['images', 'category']);

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        $formattedProducts = $products->getCollection()->map(function ($product) {
            return $this->formatProduct($product);
        });

        return response()->json([
            'success' => true,
            'data' => [
                'tag' => [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'description' => $tag->description
                ],
                'products' => $formattedProducts,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]
        ]);
    }

    /**
     * Format product data for API response
     */
    private function formatProduct($product)
    {
        $images = $product->images->pluck('image_path')->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => number_format($product->price, 2),
            'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
            'image' => $images[0] ?? null,
            'images' => $images,
            'is_featured' => $product->is_featured,
            'in_stock' => $product->stock_quantity > 0,
            'stock' => $product->stock_quantity,
            'rating' => $product->rating ?? 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug
            ] : null
        ];
    }
}
