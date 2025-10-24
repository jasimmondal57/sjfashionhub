<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppFeaturedCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class FeaturedCategoryController extends Controller
{
    /**
     * Display a listing of featured categories
     */
    public function index()
    {
        $featuredCategories = MobileAppFeaturedCategory::getAllForAdmin();
        $availableCategories = Category::where('is_active', true)
            ->whereNotIn('id', $featuredCategories->pluck('category_id'))
            ->orderBy('name')
            ->get();
            
        return view('mobileadmin.featured-categories.index', compact('featuredCategories', 'availableCategories'));
    }

    /**
     * Store a newly created featured category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        // Check if category is already featured
        $exists = MobileAppFeaturedCategory::where('category_id', $validated['category_id'])->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Category is already featured!');
        }

        // Get the next order number
        $maxOrder = MobileAppFeaturedCategory::max('order') ?? 0;

        MobileAppFeaturedCategory::create([
            'category_id' => $validated['category_id'],
            'order' => $maxOrder + 1,
            'is_active' => true,
        ]);

        return redirect()->route('mobileadmin.featured-categories.index')
            ->with('success', 'Featured category added successfully!');
    }

    /**
     * Update the specified featured category
     */
    public function update(Request $request, MobileAppFeaturedCategory $featuredCategory)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $featuredCategory->update($validated);

        return redirect()->route('mobileadmin.featured-categories.index')
            ->with('success', 'Featured category updated successfully!');
    }

    /**
     * Remove the specified featured category
     */
    public function destroy(MobileAppFeaturedCategory $featuredCategory)
    {
        $featuredCategory->delete();

        return redirect()->route('mobileadmin.featured-categories.index')
            ->with('success', 'Featured category removed successfully!');
    }

    /**
     * Update the order of featured categories
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:mobile_app_featured_categories,id',
        ]);

        MobileAppFeaturedCategory::reorder($validated['category_ids']);

        return response()->json(['success' => true]);
    }
}
