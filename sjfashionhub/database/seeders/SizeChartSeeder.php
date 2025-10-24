<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SizeChart;
use Illuminate\Support\Str;

class SizeChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeCharts = [
            // 1. Men's T-Shirts & Tops
            [
                'name' => "Men's T-Shirts & Tops",
                'slug' => 'mens-tshirts-tops',
                'description' => 'Standard sizing for men\'s t-shirts, polo shirts, and casual tops. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 1,
                'size_data' => [
                    'headers' => ['Size', 'Chest (in)', 'Length (in)', 'Shoulder (in)', 'Sleeve (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['34-36', '26', '15.5', '7.5']],
                        ['size' => 'S', 'measurements' => ['36-38', '27', '16', '8']],
                        ['size' => 'M', 'measurements' => ['38-40', '28', '16.5', '8.5']],
                        ['size' => 'L', 'measurements' => ['40-42', '29', '17', '9']],
                        ['size' => 'XL', 'measurements' => ['42-44', '30', '17.5', '9.5']],
                        ['size' => 'XXL', 'measurements' => ['44-46', '31', '18', '10']],
                        ['size' => '3XL', 'measurements' => ['46-48', '32', '18.5', '10.5']],
                    ],
                ],
            ],

            // 2. Men's Shirts
            [
                'name' => "Men's Shirts",
                'slug' => 'mens-shirts',
                'description' => 'Standard sizing for men\'s formal and casual shirts. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 2,
                'size_data' => [
                    'headers' => ['Size', 'Neck (in)', 'Chest (in)', 'Length (in)', 'Shoulder (in)', 'Sleeve (in)'],
                    'rows' => [
                        ['size' => 'S', 'measurements' => ['14-14.5', '36-38', '28', '16.5', '32-33']],
                        ['size' => 'M', 'measurements' => ['15-15.5', '38-40', '29', '17', '33-34']],
                        ['size' => 'L', 'measurements' => ['16-16.5', '40-42', '30', '17.5', '34-35']],
                        ['size' => 'XL', 'measurements' => ['17-17.5', '42-44', '31', '18', '35-36']],
                        ['size' => 'XXL', 'measurements' => ['18-18.5', '44-46', '32', '18.5', '36-37']],
                        ['size' => '3XL', 'measurements' => ['19-19.5', '46-48', '33', '19', '37-38']],
                    ],
                ],
            ],

            // 3. Men's Jeans & Pants
            [
                'name' => "Men's Jeans & Pants",
                'slug' => 'mens-jeans-pants',
                'description' => 'Standard sizing for men\'s jeans, trousers, and casual pants. Waist measurements are in inches.',
                'is_active' => true,
                'sort_order' => 3,
                'size_data' => [
                    'headers' => ['Waist (in)', 'Size', 'Waist (cm)', 'Inseam'],
                    'rows' => [
                        ['size' => '28', 'measurements' => ['28', '71', 'Regular: 30-32']],
                        ['size' => '30', 'measurements' => ['30', '76', 'Regular: 30-32']],
                        ['size' => '32', 'measurements' => ['32', '81', 'Regular: 30-32']],
                        ['size' => '34', 'measurements' => ['34', '86', 'Regular: 30-32']],
                        ['size' => '36', 'measurements' => ['36', '91', 'Regular: 30-32']],
                        ['size' => '38', 'measurements' => ['38', '97', 'Regular: 30-32']],
                        ['size' => '40', 'measurements' => ['40', '102', 'Regular: 30-32']],
                        ['size' => '42', 'measurements' => ['42', '107', 'Regular: 30-32']],
                        ['size' => '44', 'measurements' => ['44', '112', 'Regular: 30-32']],
                    ],
                ],
            ],

            // 4. Women's Tops & Kurtis
            [
                'name' => "Women's Tops & Kurtis",
                'slug' => 'womens-tops-kurtis',
                'description' => 'Standard sizing for women\'s tops, kurtis, and tunics. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 4,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Waist (in)', 'Hip (in)', 'Length (in)', 'Shoulder (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '26-27', '35-36', '26', '13']],
                        ['size' => 'S', 'measurements' => ['34-35', '28-29', '37-38', '27', '13.5']],
                        ['size' => 'M', 'measurements' => ['36-37', '30-31', '39-40', '28', '14']],
                        ['size' => 'L', 'measurements' => ['38-39', '32-33', '41-42', '29', '14.5']],
                        ['size' => 'XL', 'measurements' => ['40-41', '34-35', '43-44', '30', '15']],
                        ['size' => 'XXL', 'measurements' => ['42-43', '36-37', '45-46', '31', '15.5']],
                        ['size' => '3XL', 'measurements' => ['44-45', '38-39', '47-48', '32', '16']],
                    ],
                ],
            ],

            // 5. Women's Jeans & Pants
            [
                'name' => "Women's Jeans & Pants",
                'slug' => 'womens-jeans-pants',
                'description' => 'Standard sizing for women\'s jeans, trousers, and casual pants. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 5,
                'size_data' => [
                    'headers' => ['Size', 'Waist (in)', 'Hip (in)', 'Waist (cm)', 'Hip (cm)'],
                    'rows' => [
                        ['size' => '26', 'measurements' => ['26', '36', '66', '91']],
                        ['size' => '28', 'measurements' => ['28', '38', '71', '97']],
                        ['size' => '30', 'measurements' => ['30', '40', '76', '102']],
                        ['size' => '32', 'measurements' => ['32', '42', '81', '107']],
                        ['size' => '34', 'measurements' => ['34', '44', '86', '112']],
                        ['size' => '36', 'measurements' => ['36', '46', '91', '117']],
                        ['size' => '38', 'measurements' => ['38', '48', '97', '122']],
                    ],
                ],
            ],

            // 6. Women's Dresses
            [
                'name' => "Women's Dresses",
                'slug' => 'womens-dresses',
                'description' => 'Standard sizing for women\'s dresses, gowns, and one-piece outfits. Measurements are in inches.',
                'is_active' => true,
                'sort_order' => 6,
                'size_data' => [
                    'headers' => ['Size', 'Bust (in)', 'Waist (in)', 'Hip (in)', 'Length (in)'],
                    'rows' => [
                        ['size' => 'XS', 'measurements' => ['32-33', '25-26', '35-36', '36-38']],
                        ['size' => 'S', 'measurements' => ['34-35', '27-28', '37-38', '38-40']],
                        ['size' => 'M', 'measurements' => ['36-37', '29-30', '39-40', '40-42']],
                        ['size' => 'L', 'measurements' => ['38-39', '31-32', '41-42', '42-44']],
                        ['size' => 'XL', 'measurements' => ['40-42', '33-35', '43-45', '44-46']],
                        ['size' => 'XXL', 'measurements' => ['43-45', '36-38', '46-48', '46-48']],
                    ],
                ],
            ],

            // 7. Kids Clothing
            [
                'name' => "Kids Clothing (Boys & Girls)",
                'slug' => 'kids-clothing',
                'description' => 'Age-based sizing for kids clothing. Measurements are approximate and may vary.',
                'is_active' => true,
                'sort_order' => 7,
                'size_data' => [
                    'headers' => ['Size', 'Age', 'Height (cm)', 'Chest (in)', 'Waist (in)'],
                    'rows' => [
                        ['size' => '2-3Y', 'measurements' => ['2-3 years', '92-98', '20-21', '19-20']],
                        ['size' => '3-4Y', 'measurements' => ['3-4 years', '98-104', '21-22', '20-21']],
                        ['size' => '4-5Y', 'measurements' => ['4-5 years', '104-110', '22-23', '21-22']],
                        ['size' => '5-6Y', 'measurements' => ['5-6 years', '110-116', '23-24', '22-23']],
                        ['size' => '6-7Y', 'measurements' => ['6-7 years', '116-122', '24-25', '23-24']],
                        ['size' => '7-8Y', 'measurements' => ['7-8 years', '122-128', '25-26', '24-25']],
                        ['size' => '8-9Y', 'measurements' => ['8-9 years', '128-134', '26-27', '25-26']],
                        ['size' => '9-10Y', 'measurements' => ['9-10 years', '134-140', '27-28', '26-27']],
                        ['size' => '10-11Y', 'measurements' => ['10-11 years', '140-146', '28-29', '27-28']],
                        ['size' => '11-12Y', 'measurements' => ['11-12 years', '146-152', '29-30', '28-29']],
                        ['size' => '12-13Y', 'measurements' => ['12-13 years', '152-158', '30-31', '29-30']],
                        ['size' => '13-14Y', 'measurements' => ['13-14 years', '158-164', '31-32', '30-31']],
                    ],
                ],
            ],

            // 8. Footwear
            [
                'name' => 'Footwear (Unisex)',
                'slug' => 'footwear-unisex',
                'description' => 'Standard footwear sizing with India/UK to US/EU conversion. Measure your foot length for best fit.',
                'is_active' => true,
                'sort_order' => 8,
                'size_data' => [
                    'headers' => ['India/UK', 'US Men', 'US Women', 'EU', 'Foot Length (cm)'],
                    'rows' => [
                        ['size' => '3', 'measurements' => ['4', '5', '36', '22.0']],
                        ['size' => '4', 'measurements' => ['5', '6', '37', '22.9']],
                        ['size' => '5', 'measurements' => ['6', '7', '38', '23.7']],
                        ['size' => '6', 'measurements' => ['7', '8', '39', '24.6']],
                        ['size' => '7', 'measurements' => ['8', '9', '40', '25.4']],
                        ['size' => '8', 'measurements' => ['9', '10', '42', '26.2']],
                        ['size' => '9', 'measurements' => ['10', '11', '43', '27.1']],
                        ['size' => '10', 'measurements' => ['11', '12', '44', '27.9']],
                        ['size' => '11', 'measurements' => ['12', '13', '46', '28.8']],
                        ['size' => '12', 'measurements' => ['13', '14', '47', '29.6']],
                    ],
                ],
            ],
        ];

        foreach ($sizeCharts as $chartData) {
            SizeChart::updateOrCreate(
                ['slug' => $chartData['slug']],
                $chartData
            );
        }

        $this->command->info('Size charts seeded successfully!');
    }
}

