<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'title' => 'Free Shipping',
                'description' => 'On orders above ₹999',
                'icon_type' => 'svg',
                'icon_svg' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'background_color' => '#000000',
                'icon_color' => '#ffffff',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Premium Quality',
                'description' => '100% authentic products',
                'icon_type' => 'svg',
                'icon_svg' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'background_color' => '#000000',
                'icon_color' => '#ffffff',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Customer Support',
                'description' => '24/7 dedicated support',
                'icon_type' => 'svg',
                'icon_svg' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75A9.75 9.75 0 0012 2.25z"></path></svg>',
                'background_color' => '#000000',
                'icon_color' => '#ffffff',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Return & Exchange',
                'description' => 'Easy 30-day returns',
                'icon_type' => 'svg',
                'icon_svg' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>',
                'background_color' => '#000000',
                'icon_color' => '#ffffff',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($features as $featureData) {
            Feature::create($featureData);
        }
    }
}
