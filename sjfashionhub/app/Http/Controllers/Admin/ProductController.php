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

            // NEW FIELDS - Inventory & Stock Management
            'barcode' => 'nullable|string|max:255',
            'supplier_name' => 'nullable|string|max:255',
            'supplier_sku' => 'nullable|string|max:255',
            'supplier_cost' => 'nullable|numeric|min:0',
            'supplier_lead_time_days' => 'nullable|integer|min:0',
            'reorder_point' => 'nullable|integer|min:0',
            'reorder_quantity' => 'nullable|integer|min:0',
            'stock_location' => 'nullable|string|max:255',
            'backorder_status' => 'nullable|in:no,notify,yes',
            'allow_preorder' => 'boolean',
            'preorder_release_date' => 'nullable|date',

            // Fashion Attributes
            'fabric_composition' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'fit_type' => 'nullable|string|max:100',
            'occasion' => 'nullable|string|max:100',
            'sleeve_type' => 'nullable|string|max:100',
            'neck_type' => 'nullable|string|max:100',
            'length_type' => 'nullable|string|max:100',
            'closure_type' => 'nullable|string|max:100',
            'pocket_details' => 'nullable|string|max:255',
            'has_lining' => 'boolean',
            'transparency' => 'nullable|in:opaque,semi-transparent,sheer',
            'is_stretchable' => 'boolean',
            'season' => 'nullable|string|max:100',
            'style_code' => 'nullable|string|max:100',
            'collection_name' => 'nullable|string|max:255',

            // Shipping & Dimensions
            'length_cm' => 'nullable|numeric|min:0',
            'width_cm' => 'nullable|numeric|min:0',
            'height_cm' => 'nullable|numeric|min:0',
            'volumetric_weight' => 'nullable|numeric|min:0',
            'package_type' => 'nullable|string|max:100',
            'is_fragile' => 'boolean',
            'requires_signature' => 'boolean',
            'shipping_class' => 'nullable|string|max:100',

            // Pricing & Promotions
            'bulk_price_tier1_qty' => 'nullable|numeric|min:0',
            'bulk_price_tier1_price' => 'nullable|numeric|min:0',
            'bulk_price_tier2_qty' => 'nullable|numeric|min:0',
            'bulk_price_tier2_price' => 'nullable|numeric|min:0',
            'bulk_price_tier3_qty' => 'nullable|numeric|min:0',
            'bulk_price_tier3_price' => 'nullable|numeric|min:0',
            'member_price' => 'nullable|numeric|min:0',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after:sale_start_date',
            'min_order_quantity' => 'nullable|integer|min:1',
            'max_order_quantity' => 'nullable|integer|min:1',
            'quantity_increment' => 'nullable|integer|min:1',
            'wholesale_price' => 'nullable|numeric|min:0',
            'margin_percentage' => 'nullable|numeric|min:0|max:100',

            // Media & Content
            'video_url' => 'nullable|url|max:500',
            'model_info' => 'nullable|string',
            'lifestyle_images' => 'nullable|array',
            'image_360_urls' => 'nullable|array',
            'product_documents' => 'nullable|array',

            // SEO & Marketing
            'url_slug' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:500',
            'meta_robots' => 'nullable|string|max:100',
            'og_image_url' => 'nullable|url|max:500',
            'twitter_card_type' => 'nullable|string|max:100',
            'schema_type' => 'nullable|string|max:100',
            'product_badges' => 'nullable|array',
            'product_labels' => 'nullable|array',
            'launch_date' => 'nullable|date',
            'discontinue_date' => 'nullable|date',

            // Additional Features
            'enable_reviews' => 'boolean',
            'enable_questions' => 'boolean',
            'allow_personalization' => 'boolean',
            'personalization_instructions' => 'nullable|string',
            'gift_wrap_available' => 'boolean',
            'gift_wrap_price' => 'nullable|numeric|min:0',
            'allow_gift_message' => 'boolean',
            'assembly_required' => 'boolean',
            'certifications' => 'nullable|array',
            'sustainability_info' => 'nullable|string',
            'made_to_order' => 'boolean',
            'production_time_days' => 'nullable|integer|min:0',

            // Additional Info
            'wash_care_symbols' => 'nullable|string',
            'country_of_manufacture' => 'nullable|string|max:100',
            'is_eco_friendly' => 'boolean',
            'is_handmade' => 'boolean',
            'special_features' => 'nullable|string',

            // Social Media Auto-Share
            'auto_share_social_media' => 'boolean',

            // Variants
            'variants_data' => 'nullable|json',
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

        // Handle variants
        if ($request->filled('variants_data')) {
            $variantsData = json_decode($request->variants_data, true);

            if (is_array($variantsData) && count($variantsData) > 0) {
                foreach ($variantsData as $variantData) {
                    \App\Models\ProductVariant::create([
                        'product_id' => $product->id,
                        'option1_name' => $variantData['option1_name'] ?? null,
                        'option1_value' => $variantData['option1_value'] ?? null,
                        'option2_name' => $variantData['option2_name'] ?? null,
                        'option2_value' => $variantData['option2_value'] ?? null,
                        'option3_name' => $variantData['option3_name'] ?? null,
                        'option3_value' => $variantData['option3_value'] ?? null,
                        'sku' => $variantData['sku'] ?? null,
                        'barcode' => $variantData['barcode'] ?? null,
                        'price' => $variantData['price'] ?? null,
                        'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                        'image_url' => $variantData['image_url'] ?? null,
                        'is_active' => $variantData['is_active'] ?? true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully with ' . ($product->productVariants()->count()) . ' variants!');
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
