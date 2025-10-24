<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SizeChart;

class BlouseSizeChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blouseSizeCharts = [
            // 1. Women's Blouse (Standard)
            [
                'name' => "Women's Blouse",
                'slug' => 'womens-blouse',
                'description' => 'Standard sizing for women\'s blouses. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 9,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Waist (in)', 'Hip (in)', 'Length (in)', 'Shoulder (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '26-27', '35-36', '22-23', '13']],
                        ['size' => 'S', 'measurements' => ['34-35', '28-29', '37-38', '23-24', '13.5']],
                        ['size' => 'M', 'measurements' => ['36-37', '30-31', '39-40', '24-25', '14']],
                        ['size' => 'L', 'measurements' => ['38-39', '32-33', '41-42', '25-26', '14.5']],
                        ['size' => 'XL', 'measurements' => ['40-41', '34-35', '43-44', '26-27', '15']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '36-37', '45-46', '27-28', '15.5']],
                        ['size' => '3XL', 'measurements' => ['44-45', '38-39', '47-48', '28-29', '16']],
                    ],
                ],
            ],

            // 2. Saree Blouse (Stitched)
            [
                'name' => 'Saree Blouse (Stitched)',
                'slug' => 'saree-blouse-stitched',
                'description' => 'Standard sizing for stitched saree blouses. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 10,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Waist (in)', 'Hip (in)', 'Shoulder (in)', 'Sleeve (in)'],
                    'rows' => [
                        ['size' => '32', 'measurements' => ['32', '26', '34', '13', '5-6']],
                        ['size' => '34', 'measurements' => ['34', '28', '36', '13.5', '5-6']],
                        ['size' => '36', 'measurements' => ['36', '30', '38', '14', '5-6']],
                        ['size' => '38', 'measurements' => ['38', '32', '40', '14.5', '5-6']],
                        ['size' => '40', 'measurements' => ['40', '34', '42', '15', '5-6']],
                        ['size' => '42', 'measurements' => ['42', '36', '44', '15.5', '5-6']],
                        ['size' => '44', 'measurements' => ['44', '38', '46', '16', '5-6']],
                    ],
                ],
            ],

            // 3. Saree Blouse (Unstitched)
            [
                'name' => 'Saree Blouse (Unstitched)',
                'slug' => 'saree-blouse-unstitched',
                'description' => 'Fabric length for unstitched saree blouses. Can be customized as per your measurements.',
                'is_active' => true,
                'sort_order' => 11,
                'size_data' => [
                    'headers' => ['Type', 'Fabric Length', 'Width', 'Description'],
                    'rows' => [
                        ['size' => 'Standard', 'measurements' => ['0.8 meters', '44-48 inches', 'Suitable for sizes 32-40']],
                        ['size' => 'Plus Size', 'measurements' => ['1.0 meters', '44-48 inches', 'Suitable for sizes 42-46']],
                        ['size' => 'Designer', 'measurements' => ['1.25 meters', '44-48 inches', 'For heavy work or long sleeves']],
                    ],
                ],
            ],

            // 4. Readymade Blouse
            [
                'name' => 'Readymade Blouse',
                'slug' => 'readymade-blouse',
                'description' => 'Standard sizing for readymade blouses with stretchable fabric. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 12,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Length (in)', 'Suitable For'],
                    'rows' => [
                        ['size' => 'S', 'measurements' => ['32-34', '14-15', 'Bust 32-34 inches']],
                        ['size' => 'M', 'measurements' => ['34-36', '15-16', 'Bust 34-36 inches']],
                        ['size' => 'L', 'measurements' => ['36-38', '16-17', 'Bust 36-38 inches']],
                        ['size' => 'XL', 'measurements' => ['38-40', '17-18', 'Bust 38-40 inches']],
                        ['size' => 'XXL', 'measurements' => ['40-42', '18-19', 'Bust 40-42 inches']],
                        ['size' => '3XL', 'measurements' => ['42-44', '19-20', 'Bust 42-44 inches']],
                    ],
                ],
            ],

            // 5. Designer Blouse
            [
                'name' => 'Designer Blouse',
                'slug' => 'designer-blouse',
                'description' => 'Detailed measurements for designer blouses with custom fitting. All measurements in inches.',
                'is_active' => true,
                'sort_order' => 13,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Waist (in)', 'Shoulder (in)', 'Sleeve (in)', 'Length (in)', 'Armhole (in)'],
                    'rows' => [
                        ['size' => '32', 'measurements' => ['32', '26', '13', '5-6', '14', '16']],
                        ['size' => '34', 'measurements' => ['34', '28', '13.5', '5-6', '14.5', '17']],
                        ['size' => '36', 'measurements' => ['36', '30', '14', '5-6', '15', '18']],
                        ['size' => '38', 'measurements' => ['38', '32', '14.5', '5-6', '15.5', '19']],
                        ['size' => '40', 'measurements' => ['40', '34', '15', '5-6', '16', '20']],
                        ['size' => '42', 'measurements' => ['42', '36', '15.5', '5-6', '16.5', '21']],
                        ['size' => '44', 'measurements' => ['44', '38', '16', '5-6', '17', '22']],
                    ],
                ],
            ],
        ];

        foreach ($blouseSizeCharts as $chartData) {
            SizeChart::updateOrCreate(
                ['slug' => $chartData['slug']],
                $chartData
            );
        }

        $this->command->info('Blouse size charts seeded successfully!');
    }
}

