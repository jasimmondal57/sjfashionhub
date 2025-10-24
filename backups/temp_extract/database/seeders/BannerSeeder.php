<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample banner images directory
        Storage::disk('public')->makeDirectory('banners');

        // Get some categories and products for linking
        $category = Category::first();
        $product = Product::first();

        $banners = [
            [
                'title' => 'Summer Collection 2024',
                'description' => 'Discover our latest summer fashion trends with up to 50% off on selected items',
                'image_path' => 'banners/summer-banner.jpg', // We'll create a placeholder
                'button_text' => 'Shop Now',
                'link_type' => 'category',
                'category_id' => $category?->id,
                'is_active' => true,
                'sort_order' => 1,
                'text_color' => '#ffffff',
                'button_color' => '#000000',
                'text_position' => 'left',
            ],
            [
                'title' => 'New Arrivals',
                'description' => 'Fresh styles just landed! Be the first to wear the latest fashion',
                'image_path' => 'banners/new-arrivals-banner.jpg',
                'button_text' => 'Explore Collection',
                'link_type' => 'product',
                'product_id' => $product?->id,
                'is_active' => true,
                'sort_order' => 2,
                'text_color' => '#ffffff',
                'button_color' => '#000000',
                'text_position' => 'center',
            ],
            [
                'title' => 'Premium Quality',
                'description' => 'Experience luxury fashion with our premium collection',
                'image_path' => 'banners/premium-banner.jpg',
                'button_text' => 'View Premium',
                'link_type' => 'custom',
                'custom_link' => 'https://sjfashion.in',
                'is_active' => true,
                'sort_order' => 3,
                'text_color' => '#000000',
                'button_color' => '#ffffff',
                'text_position' => 'right',
            ],
        ];

        foreach ($banners as $bannerData) {
            // Create a simple colored placeholder image
            $this->createPlaceholderImage($bannerData['image_path'], $bannerData['title']);

            Banner::create($bannerData);
        }
    }

    /**
     * Create a simple placeholder image
     */
    private function createPlaceholderImage($path, $title)
    {
        // Create a simple placeholder - in a real scenario, you'd have actual banner images
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];
        $color = $colors[array_rand($colors)];

        // For now, we'll just create the path - in production you'd upload actual images
        // This is just to prevent errors when the banner component tries to load images
        $fullPath = storage_path('app/public/' . $path);
        $directory = dirname($fullPath);

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create a simple 1200x600 colored rectangle as placeholder
        if (extension_loaded('gd')) {
            $image = imagecreate(1200, 600);
            $bgColor = imagecolorallocate($image,
                hexdec(substr($color, 1, 2)),
                hexdec(substr($color, 3, 2)),
                hexdec(substr($color, 5, 2))
            );
            $textColor = imagecolorallocate($image, 255, 255, 255);

            // Add title text
            $font = 5; // Built-in font
            $textWidth = imagefontwidth($font) * strlen($title);
            $textHeight = imagefontheight($font);
            $x = (1200 - $textWidth) / 2;
            $y = (600 - $textHeight) / 2;

            imagestring($image, $font, $x, $y, $title, $textColor);
            imagejpeg($image, $fullPath, 90);
            imagedestroy($image);
        } else {
            // If GD is not available, create an empty file
            file_put_contents($fullPath, '');
        }
    }
}
