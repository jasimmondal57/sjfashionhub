<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\SizeChart;
use App\Models\Category;

class AssignSizeChartsToProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:assign-size-charts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically assign appropriate size charts to all products based on their categories and names';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to assign size charts to products...');

        // Get all size charts
        $sizeCharts = SizeChart::all()->keyBy('slug');
        
        if ($sizeCharts->isEmpty()) {
            $this->error('No size charts found! Please run the size chart seeders first.');
            return 1;
        }

        $this->info('Found ' . $sizeCharts->count() . ' size charts.');

        // Get all products with their categories
        $products = Product::with('category')->get();
        
        if ($products->isEmpty()) {
            $this->warn('No products found in the database.');
            return 0;
        }

        $this->info('Found ' . $products->count() . ' products to process.');

        $updated = 0;
        $skipped = 0;

        foreach ($products as $product) {
            $sizeChartSlug = $this->determineSizeChart($product, $sizeCharts);
            
            if ($sizeChartSlug && isset($sizeCharts[$sizeChartSlug])) {
                $product->size_chart_id = $sizeCharts[$sizeChartSlug]->id;
                $product->save();
                $updated++;
                $this->line("✓ {$product->name} → {$sizeCharts[$sizeChartSlug]->name}");
            } else {
                $skipped++;
                $this->line("⊘ {$product->name} → No matching size chart");
            }
        }

        $this->newLine();
        $this->info("✅ Size chart assignment completed!");
        $this->info("Updated: {$updated} products");
        $this->info("Skipped: {$skipped} products");

        return 0;
    }

    /**
     * Determine which size chart to assign based on product details
     */
    private function determineSizeChart($product, $sizeCharts)
    {
        $productName = strtolower($product->name);
        $categoryName = $product->category ? strtolower($product->category->name) : '';
        $gender = strtolower($product->gender ?? '');

        // Combine product name and category for better matching
        $searchText = $productName . ' ' . $categoryName;

        // Combo Sets (check first for specific set types)
        if ($this->contains($searchText, ['3 pcs set', '3 piece set', 'three piece', 'capsule 3', 'nayara 3'])) {
            if ($this->contains($searchText, ['kurti', 'kurta', 'salwar', 'kameez', 'dupatta'])) {
                return 'womens-3-piece-set';
            } elseif ($this->contains($searchText, ['lehenga', 'choli'])) {
                return 'lehenga-choli-set';
            } else {
                return 'womens-3-piece-set'; // Default for 3-piece sets
            }
        }

        if ($this->contains($searchText, ['2 pcs set', '2 piece set', 'two piece', 'capsule 2', 'co-ord', 'coord'])) {
            return 'womens-2-piece-set';
        }

        // Blouse patterns (check as they're most specific)
        if ($this->contains($searchText, ['blouse', 'saree blouse'])) {
            if ($this->contains($searchText, ['unstitched', 'fabric', 'piece'])) {
                return 'saree-blouse-unstitched';
            } elseif ($this->contains($searchText, ['designer', 'heavy work', 'embroidered'])) {
                return 'designer-blouse';
            } elseif ($this->contains($searchText, ['readymade', 'ready made', 'stretchable'])) {
                return 'readymade-blouse';
            } elseif ($this->contains($searchText, ['stitched', 'saree'])) {
                return 'saree-blouse-stitched';
            } else {
                return 'womens-blouse';
            }
        }

        // Women's clothing
        if ($gender === 'female' || $this->contains($searchText, ['women', 'ladies', 'girls', 'female'])) {
            // Dresses
            if ($this->contains($searchText, ['dress', 'gown', 'maxi', 'midi', 'mini dress', 'frock'])) {
                return 'womens-dresses';
            }
            
            // Tops & Kurtis
            if ($this->contains($searchText, ['kurti', 'kurta', 'top', 'tunic', 'shirt', 'blouse'])) {
                return 'womens-tops-kurtis';
            }
            
            // Bottoms
            if ($this->contains($searchText, ['jeans', 'pants', 'trousers', 'leggings', 'palazzo', 'bottom'])) {
                return 'womens-jeans-pants';
            }
        }

        // Men's clothing
        if ($gender === 'male' || $this->contains($searchText, ['men', 'boys', 'male', 'gents'])) {
            // T-Shirts & Casual Tops
            if ($this->contains($searchText, ['t-shirt', 'tshirt', 'tee', 'polo', 'casual top', 'tank top'])) {
                return 'mens-tshirts-tops';
            }
            
            // Shirts
            if ($this->contains($searchText, ['shirt', 'formal shirt', 'casual shirt'])) {
                return 'mens-shirts';
            }
            
            // Bottoms
            if ($this->contains($searchText, ['jeans', 'pants', 'trousers', 'chinos', 'cargo', 'bottom'])) {
                return 'mens-jeans-pants';
            }
        }

        // Kids clothing
        if ($this->contains($searchText, ['kids', 'children', 'baby', 'infant', 'toddler', 'boy', 'girl']) && 
            !$this->contains($searchText, ['men', 'women', 'ladies', 'gents'])) {
            if ($this->contains($searchText, ['clothing', 'dress', 'top', 'shirt', 'tshirt', 'pants', 'jeans', 'shorts'])) {
                return 'kids-clothing';
            }
        }

        // Footwear
        if ($this->contains($searchText, ['shoes', 'sandals', 'slippers', 'sneakers', 'boots', 'footwear', 'heels', 'flats'])) {
            return 'footwear-unisex';
        }

        // Fallback based on category name only
        if ($this->contains($categoryName, ['t-shirt', 'tshirt', 'tee'])) {
            return $gender === 'female' ? 'womens-tops-kurtis' : 'mens-tshirts-tops';
        }
        
        if ($this->contains($categoryName, ['shirt'])) {
            return $gender === 'female' ? 'womens-tops-kurtis' : 'mens-shirts';
        }
        
        if ($this->contains($categoryName, ['jeans', 'pants', 'trousers'])) {
            return $gender === 'female' ? 'womens-jeans-pants' : 'mens-jeans-pants';
        }
        
        if ($this->contains($categoryName, ['dress', 'gown'])) {
            return 'womens-dresses';
        }
        
        if ($this->contains($categoryName, ['kurti', 'kurta', 'tunic'])) {
            return 'womens-tops-kurtis';
        }
        
        if ($this->contains($categoryName, ['kids', 'children', 'baby'])) {
            return 'kids-clothing';
        }
        
        if ($this->contains($categoryName, ['footwear', 'shoes'])) {
            return 'footwear-unisex';
        }

        // No match found
        return null;
    }

    /**
     * Check if text contains any of the keywords
     */
    private function contains($text, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }
        return false;
    }
}

