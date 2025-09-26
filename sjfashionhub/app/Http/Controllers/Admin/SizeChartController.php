<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SizeChart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SizeChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizeCharts = SizeChart::ordered()->paginate(15);
        return view('admin.size-charts.index', compact('sizeCharts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.size-charts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'size_data' => 'required|array',
            'size_data.headers' => 'required|array|min:1',
            'size_data.headers.*' => 'required|string|max:100',
            'size_data.rows' => 'required|array|min:1',
            'size_data.rows.*.size' => 'required|string|max:50',
            'size_data.rows.*.measurements' => 'required|array',
        ]);

        // Generate unique slug
        $validated['slug'] = Str::slug($validated['name']);
        $originalSlug = $validated['slug'];
        $counter = 1;

        while (SizeChart::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        SizeChart::create($validated);

        return redirect()->route('admin.size-charts.index')
            ->with('success', 'Size chart created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SizeChart $sizeChart)
    {
        return view('admin.size-charts.show', compact('sizeChart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SizeChart $sizeChart)
    {
        return view('admin.size-charts.edit', compact('sizeChart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SizeChart $sizeChart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'size_data' => 'required|array',
            'size_data.headers' => 'required|array|min:1',
            'size_data.headers.*' => 'required|string|max:100',
            'size_data.rows' => 'required|array|min:1',
            'size_data.rows.*.size' => 'required|string|max:50',
            'size_data.rows.*.measurements' => 'required|array',
        ]);

        // Update slug if name changed
        if ($validated['name'] !== $sizeChart->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $counter = 1;

            while (SizeChart::where('slug', $validated['slug'])->where('id', '!=', $sizeChart->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $sizeChart->update($validated);

        return redirect()->route('admin.size-charts.index')
            ->with('success', 'Size chart updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SizeChart $sizeChart)
    {
        // Check if any products are using this size chart
        if ($sizeChart->products()->count() > 0) {
            return redirect()->route('admin.size-charts.index')
                ->with('error', 'Cannot delete size chart. It is being used by ' . $sizeChart->products()->count() . ' product(s).');
        }

        $sizeChart->delete();

        return redirect()->route('admin.size-charts.index')
            ->with('success', 'Size chart deleted successfully.');
    }
}
