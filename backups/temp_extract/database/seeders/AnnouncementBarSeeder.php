<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AnnouncementBar::create([
            'message' => 'Free Shipping Sitewide on Every Order, Don\'t Miss Out!!',
            'background_color' => '#000000',
            'text_color' => '#ffffff',
            'links' => [
                ['text' => 'About Us', 'url' => '/about'],
                ['text' => 'Contact Us', 'url' => '/contact'],
                ['text' => 'Orders Tracking', 'url' => '/track-order'],
            ],
            'is_active' => true,
            'is_scrolling' => false,
            'scroll_speed' => 50,
            'sort_order' => 1,
        ]);
    }
}
