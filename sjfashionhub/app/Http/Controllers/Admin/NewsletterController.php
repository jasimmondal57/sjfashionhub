<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsletters = Newsletter::ordered()->get();
        return view('admin.newsletters.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'placeholder_text' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'button_color' => 'required|string|max:7',
            'button_text_color' => 'required|string|max:7',
            'show_social_links' => 'boolean',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string',
            'social_links.*.url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Process social links
        if ($request->has('social_links')) {
            $socialLinks = [];
            foreach ($request->social_links as $link) {
                if (!empty($link['platform']) && !empty($link['url'])) {
                    $socialLinks[] = $link;
                }
            }
            $validated['social_links'] = $socialLinks;
        }

        Newsletter::create($validated);

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Newsletter $newsletter)
    {
        return view('admin.newsletters.show', compact('newsletter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletters.edit', compact('newsletter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'placeholder_text' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'button_color' => 'required|string|max:7',
            'button_text_color' => 'required|string|max:7',
            'show_social_links' => 'boolean',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string',
            'social_links.*.url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Process social links
        if ($request->has('social_links')) {
            $socialLinks = [];
            foreach ($request->social_links as $link) {
                if (!empty($link['platform']) && !empty($link['url'])) {
                    $socialLinks[] = $link;
                }
            }
            $validated['social_links'] = $socialLinks;
        }

        $newsletter->update($validated);

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter section deleted successfully.');
    }

    /**
     * Toggle newsletter status
     */
    public function toggle(Newsletter $newsletter)
    {
        $newsletter->update(['is_active' => !$newsletter->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $newsletter->is_active,
            'message' => 'Newsletter status updated successfully.'
        ]);
    }
}
