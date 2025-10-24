<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSection;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of sections
     */
    public function index()
    {
        $sections = MobileAppSection::orderBy('order')->get();
        return view('mobileadmin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('mobileadmin.sections.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:banner,category,product_grid,product_carousel,featured,deals,custom,body,category_products',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'config' => 'nullable|json',
            'category_id' => 'nullable|exists:categories,id',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle configuration
        $config = [];
        if (isset($validated['config'])) {
            $config = json_decode($validated['config'], true) ?: [];
        }

        // Add category_id to config if provided
        if ($request->category_id) {
            $config['category_id'] = $request->category_id;
        }

        // Add product_ids to config if provided
        if ($request->product_ids) {
            $config['product_ids'] = $request->product_ids;
        }

        $validated['config'] = $config;

        // Remove category_id and product_ids from validated data as they're now in config
        unset($validated['category_id'], $validated['product_ids']);

        MobileAppSection::create($validated);

        return redirect()->route('mobileadmin.sections.index')
            ->with('success', 'Section created successfully!');
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit(MobileAppSection $section)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('mobileadmin.sections.edit', compact('section', 'categories', 'products'));
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, MobileAppSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:banner,category,product_grid,product_carousel,featured,deals,custom,body,category_products',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'config' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        if (isset($validated['config'])) {
            $validated['config'] = json_decode($validated['config'], true);
        }

        $section->update($validated);

        return redirect()->route('mobileadmin.sections.index')
            ->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the specified section
     */
    public function destroy(MobileAppSection $section)
    {
        $section->delete();

        return redirect()->route('mobileadmin.sections.index')
            ->with('success', 'Section deleted successfully!');
    }
}

