<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $mensShirts = \App\Models\Category::where('slug', 'mens-shirts')->first();
        $mensTshirts = \App\Models\Category::where('slug', 'mens-t-shirts')->first();
        $mensJeans = \App\Models\Category::where('slug', 'mens-jeans')->first();
        $womensDresses = \App\Models\Category::where('slug', 'womens-dresses')->first();
        $womensTops = \App\Models\Category::where('slug', 'womens-tops')->first();
        $womensJeans = \App\Models\Category::where('slug', 'womens-jeans')->first();

        $products = [
            // Men's Products
            [
                'name' => 'Classic White Cotton Shirt',
                'slug' => 'classic-white-cotton-shirt',
                'description' => 'Premium quality white cotton shirt perfect for formal and casual occasions. Made with 100% pure cotton for maximum comfort.',
                'short_description' => 'Premium white cotton shirt for all occasions',
                'sku' => 'MCS001',
                'price' => 1299.00,
                'sale_price' => 999.00,
                'stock_quantity' => 50,
                'category_id' => $mensShirts?->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Casual Blue Denim Shirt',
                'slug' => 'casual-blue-denim-shirt',
                'description' => 'Stylish blue denim shirt with a modern fit. Perfect for weekend outings and casual meetings.',
                'short_description' => 'Stylish blue denim shirt with modern fit',
                'sku' => 'MCS002',
                'price' => 1599.00,
                'stock_quantity' => 30,
                'category_id' => $mensShirts?->id,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Black T-Shirt',
                'slug' => 'premium-black-t-shirt',
                'description' => 'High-quality black t-shirt made from soft cotton blend. Comfortable fit with excellent durability.',
                'short_description' => 'High-quality black cotton blend t-shirt',
                'sku' => 'MTS001',
                'price' => 799.00,
                'sale_price' => 599.00,
                'stock_quantity' => 100,
                'category_id' => $mensTshirts?->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Slim Fit Dark Blue Jeans',
                'slug' => 'slim-fit-dark-blue-jeans',
                'description' => 'Modern slim fit jeans in dark blue wash. Made with stretch denim for comfort and style.',
                'short_description' => 'Slim fit dark blue stretch jeans',
                'sku' => 'MJ001',
                'price' => 2299.00,
                'sale_price' => 1799.00,
                'stock_quantity' => 40,
                'category_id' => $mensJeans?->id,
                'is_featured' => true,
                'is_active' => true,
            ],

            // Women's Products
            [
                'name' => 'Elegant Black Evening Dress',
                'slug' => 'elegant-black-evening-dress',
                'description' => 'Sophisticated black evening dress perfect for special occasions. Features elegant design and comfortable fit.',
                'short_description' => 'Sophisticated black evening dress',
                'sku' => 'WD001',
                'price' => 2999.00,
                'sale_price' => 2399.00,
                'stock_quantity' => 25,
                'category_id' => $womensDresses?->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Floral Summer Dress',
                'slug' => 'floral-summer-dress',
                'description' => 'Light and breezy floral dress perfect for summer days. Made with breathable fabric for all-day comfort.',
                'short_description' => 'Light floral dress for summer',
                'sku' => 'WD002',
                'price' => 1899.00,
                'stock_quantity' => 35,
                'category_id' => $womensDresses?->id,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Casual White Blouse',
                'slug' => 'casual-white-blouse',
                'description' => 'Versatile white blouse that pairs well with any bottom. Perfect for office and casual wear.',
                'short_description' => 'Versatile white blouse for any occasion',
                'sku' => 'WT001',
                'price' => 1199.00,
                'sale_price' => 899.00,
                'stock_quantity' => 60,
                'category_id' => $womensTops?->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'High-Waist Skinny Jeans',
                'slug' => 'high-waist-skinny-jeans',
                'description' => 'Trendy high-waist skinny jeans with excellent stretch. Flattering fit that enhances your silhouette.',
                'short_description' => 'Trendy high-waist skinny jeans',
                'sku' => 'WJ001',
                'price' => 2199.00,
                'sale_price' => 1699.00,
                'stock_quantity' => 45,
                'category_id' => $womensJeans?->id,
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            \App\Models\Product::create($productData);
        }
    }
}
