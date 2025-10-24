<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get featured products
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['category', 'activeVariants'])
            ->take(8)
            ->get();

        // Get latest products
        $latestProducts = Product::where('is_active', true)
            ->with(['category', 'activeVariants'])
            ->latest()
            ->take(8)
            ->get();

        // Get main categories
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
