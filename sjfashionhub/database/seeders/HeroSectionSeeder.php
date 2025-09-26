<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSection::create([
            'title' => 'Where Elegance',
            'subtitle' => 'Meets Comfort',
            'description' => 'Refined Style, Perfect Fit. Style Made Effortless. Elevate Your Style Everyday.',
            'primary_button_text' => 'Shop Now',
            'primary_button_url' => '/products',
            'secondary_button_text' => 'Browse Categories',
            'secondary_button_url' => '/categories',
            'background_color' => '#f9fafb',
            'text_color' => '#000000',
            'accent_color' => '#000000',
            'hero_image' => null,
            'decorative_elements' => null,
            'layout_style' => 'split',
            'show_buttons' => true,
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }
}
