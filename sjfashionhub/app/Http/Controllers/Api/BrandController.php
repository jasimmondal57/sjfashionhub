<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Get all brands (using categories as brands)
     */
    public function index(Request $request)
    {
        $query = Category::where('is_active', true);

        // Apply filters
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        $brands = $query->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return $this->formatBrand($category);
            });

        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    /**
     * Format brand data for API response (using category data)
     */
    private function formatBrand($category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'logo' => $category->image ? asset('storage/' . $category->image) : null,
            'image' => $category->image ? asset('storage/' . $category->image) : null,
            'is_featured' => $category->is_featured ?? false,
            'sort_order' => $category->sort_order ?? 0,
            'products_count' => $category->products()->where('is_active', true)->count()
        ];
    }
}
