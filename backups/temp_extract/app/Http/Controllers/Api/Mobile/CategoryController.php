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
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $product->image ? url('storage/' . $product->image) : null,
                    'in_stock' => $product->stock > 0,
                    'rating' => $product->rating ?? 0,
                ];
            });

        return response()->json([
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'image' => $category->image ? url('storage/' . $category->image) : null,
            ],
            'products' => $products,
        ]);
    }
}

