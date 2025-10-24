<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headerSetting = HeaderSetting::active()->first();

        if (!$headerSetting) {
            // Create default header setting if none exists
            $headerSetting = HeaderSetting::create([
                'site_name' => 'SJ Fashion Hub',
                'logo_text' => 'SJ Fashion Hub',
                'navigation_menu' => [
                    ['text' => 'Home', 'url' => '/', 'is_active' => true],
                    ['text' => 'Shop', 'url' => '/products', 'is_active' => true],
                    ['text' => 'Categories', 'url' => '/categories', 'is_active' => true],
                    ['text' => 'About', 'url' => '/about', 'is_active' => true],
                    ['text' => 'Contact', 'url' => '/contact', 'is_active' => true],
                ],
                'show_search' => true,
                'show_wishlist' => true,
                'show_cart' => true,
                'show_account' => true,
                'search_placeholder' => 'Search products...',
                'contact_info' => [
                    'phone' => '+1 (555) 123-4567',
                    'email' => 'info@sjfashionhub.com',
                ],
                'social_links' => [
                    ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
                    ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
                    ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
                ],
                'sticky_header' => false,
                'header_style' => 'default',
                'is_active' => true,
            ]);
        }

        return view('admin.header-settings.index', compact('headerSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $headerSetting = HeaderSetting::active()->first();

        if (!$headerSetting) {
            return redirect()->route('admin.header-settings.index');
        }

        return view('admin.header-settings.edit', compact('headerSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $headerSetting = HeaderSetting::active()->first();

        if (!$headerSetting) {
            return redirect()->route('admin.header-settings.index')
                ->with('error', 'Header settings not found.');
        }

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'logo_text' => 'nullable|string|max:255',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'navigation_menu' => 'nullable|array',
            'navigation_menu.*.text' => 'required_with:navigation_menu|string|max:100',
            'navigation_menu.*.url' => 'required_with:navigation_menu|string|max:255',
            'navigation_menu.*.is_active' => 'boolean',
            'show_search' => 'boolean',
            'show_wishlist' => 'boolean',
            'show_cart' => 'boolean',
            'show_account' => 'boolean',
            'search_placeholder' => 'nullable|string|max:255',
            'contact_info' => 'nullable|array',
            'contact_info.phone' => 'nullable|string|max:50',
            'contact_info.email' => 'nullable|email|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|max:50',
            'social_links.*.url' => 'required_with:social_links|string|max:255',
            'social_links.*.icon' => 'required_with:social_links|string|max:50',
            'sticky_header' => 'boolean',
            'header_style' => 'required|string|in:default,minimal,modern',
        ]);

        // Handle logo image upload
        if ($request->hasFile('logo_image')) {
            // Delete old logo if exists
            if ($headerSetting->logo_image) {
                Storage::delete($headerSetting->logo_image);
            }

            $logoPath = $request->file('logo_image')->store('logos', 'public');
            $validated['logo_image'] = $logoPath;
        }

        // Filter out empty navigation menu items
        if (isset($validated['navigation_menu'])) {
            $validated['navigation_menu'] = array_filter($validated['navigation_menu'], function($item) {
                return !empty($item['text']) && !empty($item['url']);
            });
            $validated['navigation_menu'] = array_values($validated['navigation_menu']); // Re-index array
        }

        // Filter out empty social links
        if (isset($validated['social_links'])) {
            $validated['social_links'] = array_filter($validated['social_links'], function($link) {
                return !empty($link['platform']) && !empty($link['url']) && !empty($link['icon']);
            });
            $validated['social_links'] = array_values($validated['social_links']); // Re-index array
        }

        $headerSetting->update($validated);

        return redirect()->route('admin.header-settings.index')
            ->with('success', 'Header settings updated successfully!');
    }

    /**
     * Reset header settings to default.
     */
    public function reset()
    {
        $headerSetting = HeaderSetting::active()->first();

        if ($headerSetting) {
            // Delete logo image if exists
            if ($headerSetting->logo_image) {
                Storage::delete($headerSetting->logo_image);
            }

            $headerSetting->update([
                'site_name' => 'SJ Fashion Hub',
                'logo_text' => 'SJ Fashion Hub',
                'logo_image' => null,
                'navigation_menu' => [
                    ['text' => 'Home', 'url' => '/', 'is_active' => true],
                    ['text' => 'Shop', 'url' => '/products', 'is_active' => true],
                    ['text' => 'Categories', 'url' => '/categories', 'is_active' => true],
                    ['text' => 'About', 'url' => '/about', 'is_active' => true],
                    ['text' => 'Contact', 'url' => '/contact', 'is_active' => true],
                ],
                'show_search' => true,
                'show_wishlist' => true,
                'show_cart' => true,
                'show_account' => true,
                'search_placeholder' => 'Search products...',
                'contact_info' => [
                    'phone' => '+1 (555) 123-4567',
                    'email' => 'info@sjfashionhub.com',
                ],
                'social_links' => [
                    ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
                    ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
                    ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
                ],
                'sticky_header' => false,
                'header_style' => 'default',
            ]);
        }

        return redirect()->route('admin.header-settings.index')
            ->with('success', 'Header settings reset to default successfully!');
    }

    /**
     * Get available URLs for menu dropdown
     */
    public function getAvailableUrls()
    {
        $urls = [];

        // Static pages
        $urls['Static Pages'] = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => 'About Us', 'url' => '/about'],
            ['text' => 'Contact Us', 'url' => '/contact'],
            ['text' => 'Track Order', 'url' => '/orders/track'],
            ['text' => 'All Products', 'url' => '/products'],
            ['text' => 'All Categories', 'url' => '/categories'],
            ['text' => 'Cart', 'url' => '/cart'],
            ['text' => 'Wishlist', 'url' => '/wishlist'],
        ];

        // Categories
        $categories = \App\Models\Category::active()->orderBy('sort_order')->get();
        if ($categories->count() > 0) {
            $urls['Categories'] = $categories->map(function ($category) {
                return [
                    'text' => $category->name,
                    'url' => '/categories/' . $category->slug
                ];
            })->toArray();
        }

        // Products (limit to featured or latest 20)
        $products = \App\Models\Product::active()
            ->where('is_featured', true)
            ->orWhere(function($query) {
                $query->active()->latest()->limit(20);
            })
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        if ($products->count() > 0) {
            $urls['Featured Products'] = $products->map(function ($product) {
                return [
                    'text' => $product->name,
                    'url' => '/products/' . $product->slug
                ];
            })->toArray();
        }

        // Auth pages
        $urls['User Pages'] = [
            ['text' => 'Login', 'url' => '/login'],
            ['text' => 'Register', 'url' => '/register'],
            ['text' => 'Dashboard', 'url' => '/dashboard'],
            ['text' => 'Profile', 'url' => '/profile'],
        ];

        return response()->json($urls);
    }
}
