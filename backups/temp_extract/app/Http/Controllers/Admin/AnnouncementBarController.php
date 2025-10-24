<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementBarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcementBars = AnnouncementBar::ordered()->get();

        $stats = [
            'total' => AnnouncementBar::count(),
            'active' => AnnouncementBar::active()->count(),
            'inactive' => AnnouncementBar::where('is_active', false)->count(),
            'scrolling' => AnnouncementBar::where('is_scrolling', true)->count(),
        ];

        return view('admin.announcement-bars.index', compact('announcementBars', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcement-bars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'links' => 'nullable|array',
            'links.*.text' => 'required_with:links|string|max:100',
            'links.*.url' => 'required_with:links|string|max:255',
            'is_active' => 'boolean',
            'is_scrolling' => 'boolean',
            'scroll_speed' => 'integer|min:10|max:200',
            'sort_order' => 'integer|min:0',
        ]);

        // Filter out empty links
        if (isset($validated['links'])) {
            $validated['links'] = array_filter($validated['links'], function($link) {
                return !empty($link['text']) && !empty($link['url']);
            });
        }

        AnnouncementBar::create($validated);

        return redirect()->route('admin.announcement-bars.index')
            ->with('success', 'Announcement bar created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnouncementBar $announcementBar)
    {
        return view('admin.announcement-bars.show', compact('announcementBar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnnouncementBar $announcementBar)
    {
        return view('admin.announcement-bars.edit', compact('announcementBar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnouncementBar $announcementBar)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'links' => 'nullable|array',
            'links.*.text' => 'required_with:links|string|max:100',
            'links.*.url' => 'required_with:links|string|max:255',
            'is_active' => 'boolean',
            'is_scrolling' => 'boolean',
            'scroll_speed' => 'integer|min:10|max:200',
            'sort_order' => 'integer|min:0',
        ]);

        // Filter out empty links
        if (isset($validated['links'])) {
            $validated['links'] = array_filter($validated['links'], function($link) {
                return !empty($link['text']) && !empty($link['url']);
            });
        }

        $announcementBar->update($validated);

        return redirect()->route('admin.announcement-bars.index')
            ->with('success', 'Announcement bar updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnouncementBar $announcementBar)
    {
        $announcementBar->delete();

        return redirect()->route('admin.announcement-bars.index')
            ->with('success', 'Announcement bar deleted successfully!');
    }

    public function toggle(AnnouncementBar $announcementBar)
    {
        $announcementBar->update(['is_active' => !$announcementBar->is_active]);

        $status = $announcementBar->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Announcement bar {$status} successfully!");
    }

    public function sort(Request $request)
    {
        $validated = $request->validate([
            'announcement_bar_ids' => 'required|array',
            'announcement_bar_ids.*' => 'exists:announcement_bars,id'
        ]);

        foreach ($validated['announcement_bar_ids'] as $index => $announcementBarId) {
            AnnouncementBar::where('id', $announcementBarId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
