<?php

namespace Database\Seeders;

use App\Models\HeaderSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeaderSetting::create([
            'site_name' => 'SJ Fashion Hub',
            'logo_text' => 'SJ Fashion Hub',
            'logo_image' => null,
            'navigation_menu' => [
                ['text' => 'Home', 'url' => '/', 'is_active' => true],
                ['text' => 'Shop', 'url' => '/products', 'is_active' => true],
                ['text' => 'Categories', 'url' => '/categories', 'is_active' => true],
                ['text' => 'About', 'url' => '/about', 'is_active' => true],
                ['text' => 'Contact', 'url' => '/contact', 'is_active' => true],
            ],
            'show_search' => true,
            'show_wishlist' => true,
            'show_cart' => true,
            'show_account' => true,
            'search_placeholder' => 'Search products...',
            'contact_info' => [
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@sjfashionhub.com',
            ],
            'social_links' => [
                ['platform' => 'Facebook', 'url' => 'https://facebook.com/sjfashionhub', 'icon' => 'facebook'],
                ['platform' => 'Instagram', 'url' => 'https://instagram.com/sjfashionhub', 'icon' => 'instagram'],
                ['platform' => 'Twitter', 'url' => 'https://twitter.com/sjfashionhub', 'icon' => 'twitter'],
            ],
            'sticky_header' => false,
            'header_style' => 'default',
            'is_active' => true,
        ]);
    }
}
