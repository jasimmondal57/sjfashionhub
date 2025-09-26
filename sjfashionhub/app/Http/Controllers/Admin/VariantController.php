<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantType;
use App\Models\VariantOption;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariantController extends Controller
{
    public function index()
    {
        $variantTypes = VariantType::with('options')->orderBy('sort_order')->get();
        return view('admin.variants.index', compact('variantTypes'));
    }

    public function create()
    {
        return view('admin.variants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $variantType = VariantType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->integer('sort_order', 0)
        ]);

        return redirect()->route('admin.variants.show', $variantType)
            ->with('success', 'Variant type created successfully!');
    }

    public function show(VariantType $variant)
    {
        $variant->load('options');
        return view('admin.variants.show', compact('variant'));
    }

    public function edit(VariantType $variant)
    {
        return view('admin.variants.edit', compact('variant'));
    }

    public function update(Request $request, VariantType $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $variant->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order')
        ]);

        return redirect()->route('admin.variants.show', $variant)
            ->with('success', 'Variant type updated successfully!');
    }

    public function destroy(VariantType $variant)
    {
        $variant->delete();
        return redirect()->route('admin.variants.index')
            ->with('success', 'Variant type deleted successfully!');
    }

    // Variant Options Management
    public function storeOption(Request $request, VariantType $variant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $variant->options()->create([
            'name' => $request->name,
            'value' => $request->value,
            'color_code' => $request->color_code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->integer('sort_order', 0)
        ]);

        return redirect()->route('admin.variants.show', $variant)
            ->with('success', 'Variant option added successfully!');
    }

    public function updateOption(Request $request, VariantType $variant, VariantOption $option)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $option->update([
            'name' => $request->name,
            'value' => $request->value,
            'color_code' => $request->color_code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->integer('sort_order')
        ]);

        return redirect()->route('admin.variants.show', $variant)
            ->with('success', 'Variant option updated successfully!');
    }

    public function destroyOption(VariantType $variant, VariantOption $option)
    {
        $option->delete();
        return redirect()->route('admin.variants.show', $variant)
            ->with('success', 'Variant option deleted successfully!');
    }

    // API endpoints for getting variant options
    public function getOptions(VariantType $variant)
    {
        return response()->json([
            'success' => true,
            'options' => $variant->activeOptions
        ]);
    }
}
