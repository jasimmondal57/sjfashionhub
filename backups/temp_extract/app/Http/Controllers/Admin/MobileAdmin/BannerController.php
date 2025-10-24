<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of banners
     */
    public function index()
    {
        $banners = MobileAppBanner::orderBy('order')->get();
        return view('mobileadmin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner
     */
    public function create()
    {
        return view('mobileadmin.banners.create');
    }

    /**
     * Store a newly created banner
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'order' => 'required|integer|min:0',
            'link_type' => 'required|in:none,product,category,url,screen',
            'link_value' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('mobile/banners', 'public');
        }

        unset($validated['image']);

        MobileAppBanner::create($validated);

        return redirect()->route('mobileadmin.banners.index')
            ->with('success', 'Banner created successfully!');
    }

    /**
     * Show the form for editing the specified banner
     */
    public function edit(MobileAppBanner $banner)
    {
        return view('mobileadmin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner
     */
    public function update(Request $request, MobileAppBanner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order' => 'required|integer|min:0',
            'link_type' => 'required|in:none,product,category,url,screen',
            'link_value' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_url) {
                Storage::disk('public')->delete($banner->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('mobile/banners', 'public');
        }

        unset($validated['image']);

        $banner->update($validated);

        return redirect()->route('mobileadmin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove the specified banner
     */
    public function destroy(MobileAppBanner $banner)
    {
        // Delete image
        if ($banner->image_url) {
            Storage::disk('public')->delete($banner->image_url);
        }

        $banner->delete();

        return redirect()->route('mobileadmin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }
}

