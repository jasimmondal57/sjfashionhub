<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort functionality
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $variantTypes = \App\Models\VariantType::with('activeOptions')->where('is_active', true)->orderBy('sort_order')->get();
        $sizeCharts = \App\Models\SizeChart::active()->ordered()->get();
        return view('admin.products.create', compact('categories', 'variantTypes', 'sizeCharts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'track_quantity' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'shipping_weight' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'uploaded_images' => 'nullable|array|max:8',
            'uploaded_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'url',
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'size_chart_id' => 'nullable|exists:size_charts,id',

            // Google Merchant Center fields
            'gtin' => 'nullable|string|max:50',
            'mpn' => 'nullable|string|max:100',
            'identifier_exists' => 'boolean',
            'google_product_category' => 'nullable|string|max:255',
            'condition' => 'nullable|in:new,used,refurbished',
            'availability' => 'nullable|in:in_stock,out_of_stock,preorder',
            'age_group' => 'nullable|in:adult,kids,toddler,infant,newborn',
            'gender' => 'nullable|in:male,female,unisex',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'pattern' => 'nullable|string|max:100',
            'item_group_id' => 'nullable|string|max:100',
            'product_type' => 'nullable|string|max:255',
            'custom_labels' => 'nullable|array',

            // Meta Pixel fields
            'facebook_product_id' => 'nullable|string|max:100',
            'cost_of_goods' => 'nullable|numeric|min:0',

            // SEO fields
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string',

            // Quality & Trust fields
            'has_warranty' => 'boolean',
            'warranty_period' => 'nullable|string|max:100',
            'has_return_policy' => 'boolean',
            'return_days' => 'nullable|integer|min:0',
            'price_includes_tax' => 'boolean',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle images
        $allImages = [];

        // Handle URL-based images
        if ($request->filled('images')) {
            $allImages = array_merge($allImages, array_filter($request->images));
        }

        // Handle uploaded images
        if ($request->hasFile('uploaded_images')) {
            foreach ($request->file('uploaded_images') as $file) {
                if ($file->isValid()) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Store in public/storage/products directory
                    $path = $file->storeAs('products', $filename, 'public');

                    // Add full URL to images array
                    $allImages[] = asset('storage/' . $path);
                }
            }
        }

        $validated['images'] = $allImages;

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        $product = Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $variantTypes = \App\Models\VariantType::with('activeOptions')->where('is_active', true)->orderBy('sort_order')->get();
        $sizeCharts = \App\Models\SizeChart::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories', 'variantTypes', 'sizeCharts'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product->id)],
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'uploaded_images' => 'nullable|array|max:8',
            'uploaded_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string',
        ]);

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);

            // Ensure unique slug
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle images
        $allImages = [];

        // Keep existing images if no new images provided
        if (!$request->filled('images') && !$request->hasFile('uploaded_images')) {
            $allImages = $product->images ?? [];
        }

        // Handle URL-based images
        if ($request->filled('images')) {
            $allImages = array_merge($allImages, array_filter($request->images));
        }

        // Handle uploaded images
        if ($request->hasFile('uploaded_images')) {
            foreach ($request->file('uploaded_images') as $file) {
                if ($file->isValid()) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                    // Store in public/storage/products directory
                    $path = $file->storeAs('products', $filename, 'public');

                    // Add full URL to images array
                    $allImages[] = asset('storage/' . $path);
                }
            }
        }

        $validated['images'] = $allImages;

        // Handle tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        } else {
            $validated['tags'] = [];
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'products' => 'required|array',
            'products.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->products);

        switch ($request->action) {
            case 'delete':
                $count = $products->count();
                $products->delete();
                return redirect()->back()->with('success', "{$count} products deleted successfully!");

            case 'activate':
                $count = $products->update(['is_active' => true]);
                return redirect()->back()->with('success', "{$count} products activated successfully!");

            case 'deactivate':
                $count = $products->update(['is_active' => false]);
                return redirect()->back()->with('success', "{$count} products deactivated successfully!");
        }

        return redirect()->back();
    }
}
