<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSection;
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
        return view('mobileadmin.sections.create');
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:banner,category,product_grid,product_carousel,featured,deals,custom',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:0',
            'config' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        if (isset($validated['config'])) {
            $validated['config'] = json_decode($validated['config'], true);
        }

        MobileAppSection::create($validated);

        return redirect()->route('mobileadmin.sections.index')
            ->with('success', 'Section created successfully!');
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit(MobileAppSection $section)
    {
        return view('mobileadmin.sections.edit', compact('section'));
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, MobileAppSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:banner,category,product_grid,product_carousel,featured,deals,custom',
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

