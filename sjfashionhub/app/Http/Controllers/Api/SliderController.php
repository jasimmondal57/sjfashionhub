<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Get all sliders/banners
     */
    public function index(Request $request)
    {
        $sliders = Banner::where('status', 'active')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($banner) {
                return $this->formatSlider($banner);
            });

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    /**
     * Format slider data for API response
     */
    private function formatSlider($banner)
    {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'description' => $banner->description,
            'image' => $banner->image ? asset('storage/' . $banner->image) : null,
            'link' => $banner->link,
            'link_type' => $banner->link_type ?? 'external',
            'sort_order' => $banner->sort_order,
            'is_active' => $banner->status === 'active'
        ];
    }
}
