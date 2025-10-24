<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSetting;
use App\Models\MobileAppSection;
use App\Models\MobileAppBanner;
use App\Models\MobileAppMenuItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileAdminController extends Controller
{
    /**
     * Display mobile admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_sections' => MobileAppSection::count(),
            'active_sections' => MobileAppSection::where('is_active', true)->count(),
            'total_banners' => MobileAppBanner::count(),
            'active_banners' => MobileAppBanner::getActive()->count(),
            'menu_items' => MobileAppMenuItem::count(),
        ];

        return view('admin.mobile.index', compact('stats'));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $settings = MobileAppSetting::getAllGrouped();
        return view('admin.mobile.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = MobileAppSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        MobileAppSetting::clearCache();

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Display sections management
     */
    public function sections()
    {
        $sections = MobileAppSection::orderBy('order')->get();
        return view('admin.mobile.sections.index', compact('sections'));
    }

    /**
     * Create section form
     */
    public function createSection()
    {
        return view('admin.mobile.sections.create');
    }

    /**
     * Store new section
     */
    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'config' => 'nullable|json',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $validated['config'] = $request->config ? json_decode($request->config, true) : [];

        MobileAppSection::create($validated);

        return redirect()->route('admin.mobile.sections')
            ->with('success', 'Section created successfully!');
    }

    /**
     * Edit section form
     */
    public function editSection(MobileAppSection $section)
    {
        return view('admin.mobile.sections.edit', compact('section'));
    }

    /**
     * Update section
     */
    public function updateSection(Request $request, MobileAppSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'config' => 'nullable|json',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        $validated['config'] = $request->config ? json_decode($request->config, true) : [];

        $section->update($validated);

        return redirect()->route('admin.mobile.sections')
            ->with('success', 'Section updated successfully!');
    }

    /**
     * Delete section
     */
    public function deleteSection(MobileAppSection $section)
    {
        $section->delete();

        return back()->with('success', 'Section deleted successfully!');
    }

    /**
     * Display banners management
     */
    public function banners()
    {
        $banners = MobileAppBanner::orderBy('order')->get();
        return view('admin.mobile.banners.index', compact('banners'));
    }

    /**
     * Create banner form
     */
    public function createBanner()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.mobile.banners.create', compact('categories', 'products'));
    }

    /**
     * Store new banner
     */
    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'link_type' => 'required|string',
            'link_value' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('mobile/banners', 'public');
        }

        MobileAppBanner::create($validated);

        return redirect()->route('admin.mobile.banners')
            ->with('success', 'Banner created successfully!');
    }

    /**
     * Edit banner form
     */
    public function editBanner(MobileAppBanner $banner)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.mobile.banners.edit', compact('banner', 'categories', 'products'));
    }

    /**
     * Update banner
     */
    public function updateBanner(Request $request, MobileAppBanner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link_type' => 'required|string',
            'link_value' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('mobile/banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.mobile.banners')
            ->with('success', 'Banner updated successfully!');
    }

    /**
     * Delete banner
     */
    public function deleteBanner(MobileAppBanner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return back()->with('success', 'Banner deleted successfully!');
    }

    /**
     * Display menu items management
     */
    public function menuItems()
    {
        $menuItems = MobileAppMenuItem::orderBy('order')->get();
        return view('admin.mobile.menu.index', compact('menuItems'));
    }

    /**
     * Create menu item form
     */
    public function createMenuItem()
    {
        return view('admin.mobile.menu.create');
    }

    /**
     * Store new menu item
     */
    public function storeMenuItem(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'type' => 'required|string',
            'value' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'show_in_bottom_nav' => 'boolean',
            'show_in_drawer' => 'boolean',
        ]);

        MobileAppMenuItem::create($validated);

        return redirect()->route('admin.mobile.menu')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Edit menu item form
     */
    public function editMenuItem(MobileAppMenuItem $menuItem)
    {
        return view('admin.mobile.menu.edit', compact('menuItem'));
    }

    /**
     * Update menu item
     */
    public function updateMenuItem(Request $request, MobileAppMenuItem $menuItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'type' => 'required|string',
            'value' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'show_in_bottom_nav' => 'boolean',
            'show_in_drawer' => 'boolean',
        ]);

        $menuItem->update($validated);

        return redirect()->route('admin.mobile.menu')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Delete menu item
     */
    public function deleteMenuItem(MobileAppMenuItem $menuItem)
    {
        $menuItem->delete();

        return back()->with('success', 'Menu item deleted successfully!');
    }
}

