<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Men\'s Fashion',
                'slug' => 'mens-fashion',
                'description' => 'Stylish clothing and accessories for men',
                'sort_order' => 1,
                'is_active' => true,
                'children' => [
                    ['name' => 'T-Shirts', 'slug' => 'mens-t-shirts', 'sort_order' => 1],
                    ['name' => 'Shirts', 'slug' => 'mens-shirts', 'sort_order' => 2],
                    ['name' => 'Jeans', 'slug' => 'mens-jeans', 'sort_order' => 3],
                    ['name' => 'Jackets', 'slug' => 'mens-jackets', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'Women\'s Fashion',
                'slug' => 'womens-fashion',
                'description' => 'Trendy clothing and accessories for women',
                'sort_order' => 2,
                'is_active' => true,
                'children' => [
                    ['name' => 'Dresses', 'slug' => 'womens-dresses', 'sort_order' => 1],
                    ['name' => 'Tops', 'slug' => 'womens-tops', 'sort_order' => 2],
                    ['name' => 'Jeans', 'slug' => 'womens-jeans', 'sort_order' => 3],
                    ['name' => 'Jackets', 'slug' => 'womens-jackets', 'sort_order' => 4],
                ]
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Fashion accessories for all',
                'sort_order' => 3,
                'is_active' => true,
                'children' => [
                    ['name' => 'Bags', 'slug' => 'bags', 'sort_order' => 1],
                    ['name' => 'Watches', 'slug' => 'watches', 'sort_order' => 2],
                    ['name' => 'Jewelry', 'slug' => 'jewelry', 'sort_order' => 3],
                ]
            ],
            [
                'name' => 'Footwear',
                'slug' => 'footwear',
                'description' => 'Comfortable and stylish footwear',
                'sort_order' => 4,
                'is_active' => true,
                'children' => [
                    ['name' => 'Sneakers', 'slug' => 'sneakers', 'sort_order' => 1],
                    ['name' => 'Formal Shoes', 'slug' => 'formal-shoes', 'sort_order' => 2],
                    ['name' => 'Sandals', 'slug' => 'sandals', 'sort_order' => 3],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = \App\Models\Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['is_active'] = true;
                \App\Models\Category::create($childData);
            }
        }
    }
}
