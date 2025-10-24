<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SizeChart;

class ComboSetSizeChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comboSizeCharts = [
            // Women's 2 Piece Set (Top + Bottom)
            [
                'name' => "Women's 2 Piece Set (Top + Bottom)",
                'slug' => 'womens-2-piece-set',
                'description' => 'Standard sizing for women\'s 2-piece sets including top and bottom. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 14,
                'size_data' => [
                    'headers' => ['Size', 'Top Bust (in)', 'Top Length (in)', 'Bottom Waist (in)', 'Bottom Length (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '24-26', '26-27', '36-38']],
                        ['size' => 'S', 'measurements' => ['34-35', '25-27', '28-29', '37-39']],
                        ['size' => 'M', 'measurements' => ['36-37', '26-28', '30-31', '38-40']],
                        ['size' => 'L', 'measurements' => ['38-39', '27-29', '32-33', '39-41']],
                        ['size' => 'XL', 'measurements' => ['40-41', '28-30', '34-35', '40-42']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '29-31', '36-37', '41-43']],
                        ['size' => '3XL', 'measurements' => ['44-45', '30-32', '38-39', '42-44']],
                    ],
                ],
            ],

            // Women's 3 Piece Set (Top + Bottom + Dupatta)
            [
                'name' => "Women's 3 Piece Set (Kurti + Bottom + Dupatta)",
                'slug' => 'womens-3-piece-set',
                'description' => 'Standard sizing for women\'s 3-piece sets including kurti, bottom, and dupatta. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 15,
                'size_data' => [
                    'headers' => ['Size', 'Kurti Bust (in)', 'Kurti Length (in)', 'Bottom Waist (in)', 'Dupatta Length'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '42-44', '26-27', '2.25 meters']],
                        ['size' => 'S', 'measurements' => ['34-35', '43-45', '28-29', '2.25 meters']],
                        ['size' => 'M', 'measurements' => ['36-37', '44-46', '30-31', '2.25 meters']],
                        ['size' => 'L', 'measurements' => ['38-39', '45-47', '32-33', '2.25 meters']],
                        ['size' => 'XL', 'measurements' => ['40-41', '46-48', '34-35', '2.25 meters']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '47-49', '36-37', '2.25 meters']],
                        ['size' => '3XL', 'measurements' => ['44-45', '48-50', '38-39', '2.25 meters']],
                    ],
                ],
            ],

            // Salwar Kameez Set
            [
                'name' => 'Salwar Kameez Set',
                'slug' => 'salwar-kameez-set',
                'description' => 'Standard sizing for salwar kameez sets. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 16,
                'size_data' => [
                    'headers' => ['Size', 'Kameez Bust (in)', 'Kameez Length (in)', 'Salwar Waist (in)', 'Salwar Length (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '42-44', '26-28', '38-40']],
                        ['size' => 'S', 'measurements' => ['34-35', '43-45', '28-30', '38-40']],
                        ['size' => 'M', 'measurements' => ['36-37', '44-46', '30-32', '38-40']],
                        ['size' => 'L', 'measurements' => ['38-39', '45-47', '32-34', '38-40']],
                        ['size' => 'XL', 'measurements' => ['40-41', '46-48', '34-36', '38-40']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '47-49', '36-38', '38-40']],
                        ['size' => '3XL', 'measurements' => ['44-45', '48-50', '38-40', '38-40']],
                    ],
                ],
            ],

            // Lehenga Choli Set
            [
                'name' => 'Lehenga Choli Set',
                'slug' => 'lehenga-choli-set',
                'description' => 'Standard sizing for lehenga choli sets. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 17,
                'size_data' => [
                    'headers' => ['Size', 'Choli Bust (in)', 'Choli Length (in)', 'Lehenga Waist (in)', 'Lehenga Length (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '14-15', '26-27', '40-42']],
                        ['size' => 'S', 'measurements' => ['34-35', '15-16', '28-29', '40-42']],
                        ['size' => 'M', 'measurements' => ['36-37', '16-17', '30-31', '40-42']],
                        ['size' => 'L', 'measurements' => ['38-39', '17-18', '32-33', '40-42']],
                        ['size' => 'XL', 'measurements' => ['40-41', '18-19', '34-35', '40-42']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '19-20', '36-37', '40-42']],
                        ['size' => '3XL', 'measurements' => ['44-45', '20-21', '38-39', '40-42']],
                    ],
                ],
            ],

            // Co-ord Set (Matching Top + Bottom)
            [
                'name' => 'Co-ord Set (Matching Top + Bottom)',
                'slug' => 'coord-set',
                'description' => 'Standard sizing for co-ord sets with matching top and bottom. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 18,
                'size_data' => [
                    'headers' => ['Size', 'Top Bust (in)', 'Top Length (in)', 'Bottom Waist (in)', 'Bottom Hip (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '18-20', '26-27', '35-36']],
                        ['size' => 'S', 'measurements' => ['34-35', '19-21', '28-29', '37-38']],
                        ['size' => 'M', 'measurements' => ['36-37', '20-22', '30-31', '39-40']],
                        ['size' => 'L', 'measurements' => ['38-39', '21-23', '32-33', '41-42']],
                        ['size' => 'XL', 'measurements' => ['40-41', '22-24', '34-35', '43-44']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '23-25', '36-37', '45-46']],
                        ['size' => '3XL', 'measurements' => ['44-45', '24-26', '38-39', '47-48']],
                    ],
                ],
            ],
        ];

        foreach ($comboSizeCharts as $chartData) {
            SizeChart::updateOrCreate(
                ['slug' => $chartData['slug']],
                $chartData
            );
        }

        $this->command->info('Combo set size charts seeded successfully!');
    }
}

