<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyFeatureSection;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BodyFeatureSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = BodyFeatureSection::ordered()->get();
        return view('admin.body-feature-sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::select('id', 'name', 'category_id')->with('category')->get();
        $categories = Category::select('id', 'name', 'parent_id')->get();

        return view('admin.body-feature-sections.create', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'section_type' => 'required|in:products,categories,mixed',
            'display_style' => 'required|in:grid,carousel,list',
            'items_limit' => 'required|integer|min:1|max:50',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'show_button' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'content_settings' => 'nullable|array',
        ]);

        // Handle content settings based on section type
        $contentSettings = $this->processContentSettings($request);
        $validated['content_settings'] = $contentSettings;

        BodyFeatureSection::create($validated);

        return redirect()->route('admin.body-feature-sections.index')
            ->with('success', 'Body feature section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BodyFeatureSection $bodyFeatureSection)
    {
        $contentItems = $bodyFeatureSection->getContentItems();
        return view('admin.body-feature-sections.show', compact('bodyFeatureSection', 'contentItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BodyFeatureSection $bodyFeatureSection)
    {
        $products = Product::select('id', 'name', 'category_id')->with('category')->get();
        $categories = Category::select('id', 'name', 'parent_id')->get();

        return view('admin.body-feature-sections.edit', compact('bodyFeatureSection', 'products', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BodyFeatureSection $bodyFeatureSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'section_type' => 'required|in:products,categories,mixed',
            'display_style' => 'required|in:grid,carousel,list',
            'items_limit' => 'required|integer|min:1|max:50',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:255',
            'show_button' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'content_settings' => 'nullable|array',
        ]);

        // Handle content settings based on section type
        $contentSettings = $this->processContentSettings($request);
        $validated['content_settings'] = $contentSettings;

        $bodyFeatureSection->update($validated);

        return redirect()->route('admin.body-feature-sections.index')
            ->with('success', 'Body feature section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BodyFeatureSection $bodyFeatureSection)
    {
        $bodyFeatureSection->delete();

        return redirect()->route('admin.body-feature-sections.index')
            ->with('success', 'Body feature section deleted successfully.');
    }

    /**
     * Toggle the active status of a section.
     */
    public function toggle(BodyFeatureSection $bodyFeatureSection)
    {
        $bodyFeatureSection->update([
            'is_active' => !$bodyFeatureSection->is_active
        ]);

        $status = $bodyFeatureSection->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Body feature section {$status} successfully.");
    }

    /**
     * Update the sort order of sections.
     */
    public function sort(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:body_feature_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->sections as $sectionData) {
            BodyFeatureSection::where('id', $sectionData['id'])
                ->update(['sort_order' => $sectionData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Process content settings based on section type and form data.
     */
    private function processContentSettings(Request $request)
    {
        $settings = [];

        switch ($request->section_type) {
            case 'products':
                if ($request->has('specific_products') && $request->specific_products !== null) {
                    $specificProducts = is_array($request->specific_products) ? $request->specific_products : [$request->specific_products];
                    $settings['specific_products'] = array_filter($specificProducts);
                }
                if ($request->has('filter_categories') && $request->filter_categories !== null) {
                    $filterCategories = is_array($request->filter_categories) ? $request->filter_categories : [$request->filter_categories];
                    $settings['categories'] = array_filter($filterCategories);
                }
                $settings['featured_only'] = $request->boolean('featured_only');
                $settings['on_sale_only'] = $request->boolean('on_sale_only');
                $settings['sort_by'] = $request->sort_by ?? 'newest';
                break;

            case 'categories':
                if ($request->has('specific_categories') && $request->specific_categories !== null) {
                    $specificCategories = is_array($request->specific_categories) ? $request->specific_categories : [$request->specific_categories];
                    $settings['specific_categories'] = array_filter($specificCategories);
                }
                $settings['parent_only'] = $request->boolean('parent_only');
                break;

            case 'mixed':
                if ($request->has('mixed_products') && $request->mixed_products !== null) {
                    $mixedProducts = is_array($request->mixed_products) ? $request->mixed_products : [$request->mixed_products];
                    $settings['products'] = array_filter($mixedProducts);
                }
                if ($request->has('mixed_categories') && $request->mixed_categories !== null) {
                    $mixedCategories = is_array($request->mixed_categories) ? $request->mixed_categories : [$request->mixed_categories];
                    $settings['categories'] = array_filter($mixedCategories);
                }
                break;
        }

        return $settings;
    }
}
