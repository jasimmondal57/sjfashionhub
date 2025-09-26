<?php

namespace Database\Seeders;

use App\Models\BodyFeatureSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BodyFeatureSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Trending Now Section
        BodyFeatureSection::create([
            'title' => 'Trending Now',
            'subtitle' => 'Discover our most popular items',
            'section_type' => 'products',
            'display_style' => 'grid',
            'items_limit' => 8,
            'background_color' => '#ffffff',
            'text_color' => '#000000',
            'button_text' => 'View All',
            'button_url' => '/products',
            'show_button' => true,
            'content_settings' => [
                'featured_only' => true,
                'sort_by' => 'featured'
            ],
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // New Collections 2025 Section
        BodyFeatureSection::create([
            'title' => 'New Collections 2025',
            'subtitle' => 'Latest fashion trends and styles',
            'section_type' => 'products',
            'display_style' => 'carousel',
            'items_limit' => 12,
            'background_color' => '#f9fafb',
            'text_color' => '#000000',
            'button_text' => 'Shop New Arrivals',
            'button_url' => '/products?filter=new',
            'show_button' => true,
            'content_settings' => [
                'sort_by' => 'newest'
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
