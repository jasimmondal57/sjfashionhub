<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSections = HeroSection::ordered()->get();
        $activeHero = HeroSection::getActiveHero();

        return view('admin.hero-sections.index', compact('heroSections', 'activeHero'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'primary_button_text' => 'required|string|max:100',
            'primary_button_url' => 'required|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'accent_color' => 'required|string|max:7',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'layout_style' => 'required|string|in:split,centered,full-width',
            'show_buttons' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('hero-images', 'public');
            $validated['hero_image'] = $imagePath;
        }

        // If this is set as active, deactivate others
        if ($validated['is_active'] ?? false) {
            HeroSection::where('is_active', true)->update(['is_active' => false]);
        }

        HeroSection::create($validated);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSection $heroSection)
    {
        return view('admin.hero-sections.show', compact('heroSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSection $heroSection)
    {
        return view('admin.hero-sections.edit', compact('heroSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'primary_button_text' => 'required|string|max:100',
            'primary_button_url' => 'required|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_url' => 'nullable|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'accent_color' => 'required|string|max:7',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'layout_style' => 'required|string|in:split,centered,full-width',
            'show_buttons' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Delete old image if exists
            if ($heroSection->hero_image) {
                Storage::delete($heroSection->hero_image);
            }

            $imagePath = $request->file('hero_image')->store('hero-images', 'public');
            $validated['hero_image'] = $imagePath;
        }

        // If this is set as active, deactivate others
        if ($validated['is_active'] ?? false) {
            HeroSection::where('id', '!=', $heroSection->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $heroSection->update($validated);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSection $heroSection)
    {
        // Delete hero image if exists
        if ($heroSection->hero_image) {
            Storage::delete($heroSection->hero_image);
        }

        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggle(HeroSection $heroSection)
    {
        if (!$heroSection->is_active) {
            // Deactivate all other hero sections
            HeroSection::where('is_active', true)->update(['is_active' => false]);
            $heroSection->update(['is_active' => true]);
            $message = 'Hero section activated successfully!';
        } else {
            $heroSection->update(['is_active' => false]);
            $message = 'Hero section deactivated successfully!';
        }

        return redirect()->route('admin.hero-sections.index')
            ->with('success', $message);
    }

    /**
     * Sort hero sections
     */
    public function sort(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:hero_sections,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            HeroSection::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
