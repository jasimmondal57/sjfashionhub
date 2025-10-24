<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppMenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of menu items
     */
    public function index()
    {
        $menuItems = MobileAppMenuItem::orderBy('order')->get();
        return view('mobileadmin.menu.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new menu item
     */
    public function create()
    {
        return view('mobileadmin.menu.create');
    }

    /**
     * Store a newly created menu item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'type' => 'required|in:home,categories,cart,profile,orders,wishlist,custom,url',
            'route' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        MobileAppMenuItem::create($validated);

        return redirect()->route('mobileadmin.menu.index')
            ->with('success', 'Menu item created successfully!');
    }

    /**
     * Show the form for editing the specified menu item
     */
    public function edit(MobileAppMenuItem $menuItem)
    {
        return view('mobileadmin.menu.edit', compact('menuItem'));
    }

    /**
     * Update the specified menu item
     */
    public function update(Request $request, MobileAppMenuItem $menuItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'type' => 'required|in:home,categories,cart,profile,orders,wishlist,custom,url',
            'route' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menuItem->update($validated);

        return redirect()->route('mobileadmin.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove the specified menu item
     */
    public function destroy(MobileAppMenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('mobileadmin.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}

