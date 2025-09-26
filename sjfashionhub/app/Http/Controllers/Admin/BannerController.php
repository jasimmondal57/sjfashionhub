<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::with(['category', 'product'])
            ->ordered()
            ->paginate(20);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('admin.banners.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'link_type' => 'required|in:category,product,custom,none',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'custom_link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'text_color' => 'required|string|max:7',
            'button_color' => 'required|string|max:7',
            'text_position' => 'required|in:left,center,right',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set button_link based on link_type
        $validated['button_link'] = $this->generateButtonLink($validated);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('admin.banners.edit', compact('banner', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'link_type' => 'required|in:category,product,custom,none',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'custom_link' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'text_color' => 'required|string|max:7',
            'button_color' => 'required|string|max:7',
            'text_position' => 'required|in:left,center,right',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image_path'] = $imagePath;
        }

        // Set button_link based on link_type
        $validated['button_link'] = $this->generateButtonLink($validated);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Delete image file
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }

    /**
     * Toggle banner status
     */
    public function toggle(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner status updated successfully!');
    }

    /**
     * Generate button link based on link type
     */
    private function generateButtonLink(array $data): ?string
    {
        return match ($data['link_type']) {
            'category' => $data['category_id'] ? route('categories.show', Category::find($data['category_id'])->slug) : null,
            'product' => $data['product_id'] ? route('products.show', Product::find($data['product_id'])->slug) : null,
            'custom' => $data['custom_link'] ?? null,
            default => null,
        };
    }
}
