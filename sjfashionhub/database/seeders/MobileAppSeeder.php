<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobileAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mobile App Settings
        $settings = [
            // API Settings
            ['key' => 'api_base_url', 'value' => 'https://sjfashionhub.com', 'type' => 'text', 'group' => 'api', 'label' => 'API Base URL', 'description' => 'Base URL for API requests', 'order' => 1],
            ['key' => 'api_version', 'value' => 'v1', 'type' => 'text', 'group' => 'api', 'label' => 'API Version', 'description' => 'API version to use', 'order' => 2],
            
            // General Settings
            ['key' => 'app_name', 'value' => 'SJ Fashion Hub', 'type' => 'text', 'group' => 'general', 'label' => 'App Name', 'description' => 'Mobile app name', 'order' => 1],
            ['key' => 'app_logo', 'value' => '', 'type' => 'image', 'group' => 'general', 'label' => 'App Logo', 'description' => 'App logo image', 'order' => 2],
            ['key' => 'app_version', 'value' => '1.0.0', 'type' => 'text', 'group' => 'general', 'label' => 'App Version', 'description' => 'Current app version', 'order' => 3],
            ['key' => 'force_update', 'value' => 'false', 'type' => 'boolean', 'group' => 'general', 'label' => 'Force Update', 'description' => 'Force users to update app', 'order' => 4],
            ['key' => 'min_version', 'value' => '1.0.0', 'type' => 'text', 'group' => 'general', 'label' => 'Minimum Version', 'description' => 'Minimum supported app version', 'order' => 5],
            
            // Theme Settings
            ['key' => 'primary_color', 'value' => '#6200EE', 'type' => 'color', 'group' => 'theme', 'label' => 'Primary Color', 'description' => 'Main app color', 'order' => 1],
            ['key' => 'secondary_color', 'value' => '#03DAC6', 'type' => 'color', 'group' => 'theme', 'label' => 'Secondary Color', 'description' => 'Secondary app color', 'order' => 2],
            ['key' => 'dark_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'theme', 'label' => 'Dark Mode', 'description' => 'Enable dark mode', 'order' => 3],
            
            // Notification Settings
            ['key' => 'firebase_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'notification', 'label' => 'Firebase Enabled', 'description' => 'Enable Firebase notifications', 'order' => 1],
            ['key' => 'fcm_server_key', 'value' => '', 'type' => 'text', 'group' => 'notification', 'label' => 'FCM Server Key', 'description' => 'Firebase Cloud Messaging server key', 'order' => 2],
            
            // Feature Flags
            ['key' => 'enable_wishlist', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'label' => 'Enable Wishlist', 'description' => 'Enable wishlist feature', 'order' => 1],
            ['key' => 'enable_reviews', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'label' => 'Enable Reviews', 'description' => 'Enable product reviews', 'order' => 2],
            ['key' => 'enable_tracking', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'label' => 'Enable Order Tracking', 'description' => 'Enable order tracking', 'order' => 3],
            ['key' => 'enable_cod', 'value' => 'true', 'type' => 'boolean', 'group' => 'features', 'label' => 'Enable COD', 'description' => 'Enable Cash on Delivery', 'order' => 4],
        ];

        foreach ($settings as $setting) {
            DB::table('mobile_app_settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Default Theme
        DB::table('mobile_app_themes')->insert([
            'name' => 'Default Theme',
            'primary_color' => '#6200EE',
            'secondary_color' => '#03DAC6',
            'background_color' => '#FFFFFF',
            'text_color' => '#000000',
            'card_color' => '#F5F5F5',
            'app_bar_color' => '#6200EE',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Default Menu Items
        $menuItems = [
            ['title' => 'Home', 'icon' => 'home', 'type' => 'home', 'value' => null, 'order' => 1, 'show_in_bottom_nav' => true, 'show_in_drawer' => true],
            ['title' => 'Categories', 'icon' => 'category', 'type' => 'categories', 'value' => null, 'order' => 2, 'show_in_bottom_nav' => true, 'show_in_drawer' => true],
            ['title' => 'Cart', 'icon' => 'shopping_cart', 'type' => 'cart', 'value' => null, 'order' => 3, 'show_in_bottom_nav' => true, 'show_in_drawer' => true],
            ['title' => 'Wishlist', 'icon' => 'favorite', 'type' => 'wishlist', 'value' => null, 'order' => 4, 'show_in_bottom_nav' => false, 'show_in_drawer' => true],
            ['title' => 'Orders', 'icon' => 'receipt', 'type' => 'orders', 'value' => null, 'order' => 5, 'show_in_bottom_nav' => false, 'show_in_drawer' => true],
            ['title' => 'Profile', 'icon' => 'person', 'type' => 'profile', 'value' => null, 'order' => 6, 'show_in_bottom_nav' => true, 'show_in_drawer' => true],
        ];

        foreach ($menuItems as $item) {
            DB::table('mobile_app_menu_items')->insert(array_merge($item, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Default Home Sections
        $sections = [
            [
                'title' => 'Main Banners',
                'type' => 'banner',
                'description' => 'Main promotional banners',
                'config' => json_encode(['auto_play' => true, 'interval' => 3000]),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Featured Categories',
                'type' => 'category',
                'description' => 'Featured product categories',
                'config' => json_encode(['layout' => 'grid', 'columns' => 2]),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Featured Products',
                'type' => 'featured',
                'description' => 'Featured products showcase',
                'config' => json_encode(['layout' => 'carousel']),
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'New Arrivals',
                'type' => 'product_grid',
                'description' => 'Latest products',
                'config' => json_encode(['filter' => 'new', 'limit' => 10]),
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Best Sellers',
                'type' => 'product_carousel',
                'description' => 'Best selling products',
                'config' => json_encode(['filter' => 'bestseller', 'limit' => 10]),
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            DB::table('mobile_app_sections')->insert(array_merge($section, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}

