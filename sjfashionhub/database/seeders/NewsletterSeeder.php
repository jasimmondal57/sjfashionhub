<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Newsletter::create([
            'title' => 'Stay Updated with SJ Fashion Hub',
            'subtitle' => 'Get exclusive offers and fashion updates',
            'description' => 'Subscribe to our newsletter and be the first to know about new collections, exclusive offers, and fashion tips delivered directly to your inbox.',
            'placeholder_text' => 'Enter your email address',
            'button_text' => 'Subscribe Now',
            'background_color' => '#000000',
            'text_color' => '#ffffff',
            'button_color' => '#ffffff',
            'button_text_color' => '#000000',
            'show_social_links' => true,
            'social_links' => [
                [
                    'platform' => 'facebook',
                    'url' => 'https://facebook.com/sjfashionhub'
                ],
                [
                    'platform' => 'instagram',
                    'url' => 'https://instagram.com/sjfashionhub'
                ],
                [
                    'platform' => 'twitter',
                    'url' => 'https://twitter.com/sjfashionhub'
                ]
            ],
            'is_active' => true,
            'sort_order' => 0,
        ]);
    }
}
