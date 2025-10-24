<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of banners
     */
    public function index()
    {
        try {
            $banners = Banner::ordered()->get()->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image_path ? url('storage/' . $banner->image_path) : null,
                    'link' => $banner->custom_link,
                    'sort_order' => $banner->sort_order,
                    'is_active' => $banner->is_active,
                    'created_at' => $banner->created_at,
                    'updated_at' => $banner->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $banners,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banners',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created banner
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'link' => 'nullable|url',
                'sort_order' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
            }

            $banner = Banner::create([
                'title' => $request->title,
                'image_path' => $imagePath,
                'custom_link' => $request->link,
                'link_type' => 'custom',
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Banner created successfully',
                'data' => [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image_path ? url('storage/' . $banner->image_path) : null,
                    'link' => $banner->custom_link,
                    'sort_order' => $banner->sort_order,
                    'is_active' => $banner->is_active,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create banner',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified banner
     */
    public function show($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image_path ? url('storage/' . $banner->image_path) : null,
                    'link' => $banner->custom_link,
                    'sort_order' => $banner->sort_order,
                    'is_active' => $banner->is_active,
                    'created_at' => $banner->created_at,
                    'updated_at' => $banner->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found',
            ], 404);
        }
    }

    /**
     * Update the specified banner
     */
    public function update(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'link' => 'nullable|url',
                'sort_order' => 'required|integer|min:1',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $imagePath = $banner->image_path;
            if ($request->hasFile('image')) {
                // Delete old image
                if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                    Storage::disk('public')->delete($banner->image_path);
                }

                // Store new image
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('banners', $imageName, 'public');
            }

            $banner->update([
                'title' => $request->title,
                'image_path' => $imagePath,
                'custom_link' => $request->link,
                'sort_order' => $request->sort_order,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Banner updated successfully',
                'data' => [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image_path ? url('storage/' . $banner->image_path) : null,
                    'link' => $banner->custom_link,
                    'sort_order' => $banner->sort_order,
                    'is_active' => $banner->is_active,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified banner
     */
    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            // Delete image file
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $banner->delete();

            return response()->json([
                'success' => true,
                'message' => 'Banner deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete banner',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle banner status
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'is_active' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $banner->update([
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Banner status updated successfully',
                'data' => [
                    'id' => $banner->id,
                    'is_active' => $banner->is_active,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
