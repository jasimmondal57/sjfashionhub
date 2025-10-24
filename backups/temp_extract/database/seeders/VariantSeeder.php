<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VariantType;
use App\Models\VariantOption;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Size variant type
        $sizeType = VariantType::create([
            'name' => 'Size',
            'slug' => 'size',
            'description' => 'Product sizes for clothing',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Size options
        $sizes = [
            ['name' => 'Extra Small', 'value' => 'XS', 'sort_order' => 1],
            ['name' => 'Small', 'value' => 'S', 'sort_order' => 2],
            ['name' => 'Medium', 'value' => 'M', 'sort_order' => 3],
            ['name' => 'Large', 'value' => 'L', 'sort_order' => 4],
            ['name' => 'Extra Large', 'value' => 'XL', 'sort_order' => 5],
            ['name' => 'Double XL', 'value' => 'XXL', 'sort_order' => 6],
            ['name' => 'Triple XL', 'value' => 'XXXL', 'sort_order' => 7],
            ['name' => 'Free Size', 'value' => 'Free Size', 'sort_order' => 8],
            ['name' => '28', 'value' => '28', 'sort_order' => 9],
            ['name' => '30', 'value' => '30', 'sort_order' => 10],
            ['name' => '32', 'value' => '32', 'sort_order' => 11],
            ['name' => '34', 'value' => '34', 'sort_order' => 12],
            ['name' => '36', 'value' => '36', 'sort_order' => 13],
            ['name' => '38', 'value' => '38', 'sort_order' => 14],
            ['name' => '40', 'value' => '40', 'sort_order' => 15],
            ['name' => '42', 'value' => '42', 'sort_order' => 16],
        ];

        foreach ($sizes as $size) {
            VariantOption::create([
                'variant_type_id' => $sizeType->id,
                'name' => $size['name'],
                'value' => $size['value'],
                'is_active' => true,
                'sort_order' => $size['sort_order']
            ]);
        }

        // Create Color variant type
        $colorType = VariantType::create([
            'name' => 'Color',
            'slug' => 'color',
            'description' => 'Product colors',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Color options
        $colors = [
            ['name' => 'Black', 'value' => 'Black', 'color_code' => '#000000', 'sort_order' => 1],
            ['name' => 'White', 'value' => 'White', 'color_code' => '#FFFFFF', 'sort_order' => 2],
            ['name' => 'Red', 'value' => 'Red', 'color_code' => '#FF0000', 'sort_order' => 3],
            ['name' => 'Blue', 'value' => 'Blue', 'color_code' => '#0000FF', 'sort_order' => 4],
            ['name' => 'Green', 'value' => 'Green', 'color_code' => '#008000', 'sort_order' => 5],
            ['name' => 'Yellow', 'value' => 'Yellow', 'color_code' => '#FFFF00', 'sort_order' => 6],
            ['name' => 'Pink', 'value' => 'Pink', 'color_code' => '#FFC0CB', 'sort_order' => 7],
            ['name' => 'Purple', 'value' => 'Purple', 'color_code' => '#800080', 'sort_order' => 8],
            ['name' => 'Orange', 'value' => 'Orange', 'color_code' => '#FFA500', 'sort_order' => 9],
            ['name' => 'Brown', 'value' => 'Brown', 'color_code' => '#A52A2A', 'sort_order' => 10],
            ['name' => 'Grey', 'value' => 'Grey', 'color_code' => '#808080', 'sort_order' => 11],
            ['name' => 'Navy Blue', 'value' => 'Navy Blue', 'color_code' => '#000080', 'sort_order' => 12],
            ['name' => 'Maroon', 'value' => 'Maroon', 'color_code' => '#800000', 'sort_order' => 13],
            ['name' => 'Beige', 'value' => 'Beige', 'color_code' => '#F5F5DC', 'sort_order' => 14],
            ['name' => 'Cream', 'value' => 'Cream', 'color_code' => '#FFFDD0', 'sort_order' => 15],
        ];

        foreach ($colors as $color) {
            VariantOption::create([
                'variant_type_id' => $colorType->id,
                'name' => $color['name'],
                'value' => $color['value'],
                'color_code' => $color['color_code'],
                'is_active' => true,
                'sort_order' => $color['sort_order']
            ]);
        }

        // Create Material variant type
        $materialType = VariantType::create([
            'name' => 'Material',
            'slug' => 'material',
            'description' => 'Fabric and material types',
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Material options
        $materials = [
            ['name' => 'Cotton', 'value' => 'Cotton', 'sort_order' => 1],
            ['name' => 'Polyester', 'value' => 'Polyester', 'sort_order' => 2],
            ['name' => 'Cotton Blend', 'value' => 'Cotton Blend', 'sort_order' => 3],
            ['name' => 'Silk', 'value' => 'Silk', 'sort_order' => 4],
            ['name' => 'Linen', 'value' => 'Linen', 'sort_order' => 5],
            ['name' => 'Wool', 'value' => 'Wool', 'sort_order' => 6],
            ['name' => 'Denim', 'value' => 'Denim', 'sort_order' => 7],
            ['name' => 'Chiffon', 'value' => 'Chiffon', 'sort_order' => 8],
            ['name' => 'Georgette', 'value' => 'Georgette', 'sort_order' => 9],
            ['name' => 'Crepe', 'value' => 'Crepe', 'sort_order' => 10],
            ['name' => 'Rayon', 'value' => 'Rayon', 'sort_order' => 11],
            ['name' => 'Viscose', 'value' => 'Viscose', 'sort_order' => 12],
            ['name' => 'Lycra', 'value' => 'Lycra', 'sort_order' => 13],
            ['name' => 'Spandex', 'value' => 'Spandex', 'sort_order' => 14],
            ['name' => 'Net', 'value' => 'Net', 'sort_order' => 15],
        ];

        foreach ($materials as $material) {
            VariantOption::create([
                'variant_type_id' => $materialType->id,
                'name' => $material['name'],
                'value' => $material['value'],
                'is_active' => true,
                'sort_order' => $material['sort_order']
            ]);
        }
    }
}
