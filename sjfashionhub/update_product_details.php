<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;

// Color detection from product names and images
function detectColor($productName, $images) {
    $name = strtolower($productName);
    
    // Common colors to detect
    $colors = [
        'black' => 'Black',
        'white' => 'White',
        'red' => 'Red',
        'blue' => 'Blue',
        'yellow' => 'Yellow',
        'green' => 'Green',
        'pink' => 'Pink',
        'purple' => 'Purple',
        'orange' => 'Orange',
        'brown' => 'Brown',
        'grey' => 'Grey',
        'gray' => 'Grey',
        'beige' => 'Beige',
        'cream' => 'Cream',
        'maroon' => 'Maroon',
        'navy' => 'Navy Blue',
        'golden' => 'Golden',
        'silver' => 'Silver',
        'multicolor' => 'Multicolor',
        'multi' => 'Multicolor',
    ];
    
    foreach ($colors as $key => $value) {
        if (strpos($name, $key) !== false) {
            return $value;
        }
    }
    
    // Default colors based on common patterns
    return 'Multicolor'; // Default for sets and kurtis
}

echo "🚀 Starting product details update...\n\n";

$products = Product::with('category')->get();
$blouseCategory = Category::where('name', 'LIKE', '%Blouse%')->first();

$updated = 0;
$variantsCreated = 0;

foreach ($products as $product) {
    echo "Processing: {$product->name} (ID: {$product->id})\n";
    
    $isBlouse = $product->category_id == $blouseCategory->id;
    $color = detectColor($product->name, $product->images);
    
    // Common updates for all products
    $updateData = [
        'material' => 'Cotton',
        'color' => $color,
        'fabric_composition' => '100% Cotton',
        'care_instructions' => 'Machine wash cold, Do not bleach, Tumble dry low, Iron on low heat if needed',
        'season' => 'All Season',
        'is_active' => true,
        'manage_stock' => true,
        'track_quantity' => true,
    ];
    
    if ($isBlouse) {
        echo "  → Blouse detected - Creating size variants (26-42)\n";
        
        // Update blouse with base info
        $updateData['size'] = '26-42'; // Size range
        $updateData['fit_type'] = 'Regular';
        $updateData['occasion'] = 'Casual';
        $updateData['sleeve_type'] = 'Half Sleeve';
        $updateData['neck_type'] = 'Round Neck';
        
        $product->update($updateData);
        
        // Delete existing variants
        ProductVariant::where('product_id', $product->id)->delete();
        
        // Create size variants for blouses: 26, 30, 32, 34, 36, 38, 40, 42
        $blouseSizes = [26, 30, 32, 34, 36, 38, 40, 42];
        
        foreach ($blouseSizes as $index => $size) {
            ProductVariant::create([
                'product_id' => $product->id,
                'option1_name' => 'Size',
                'option1_value' => (string)$size,
                'option2_name' => null,
                'option2_value' => null,
                'option3_name' => null,
                'option3_value' => null,
                'sku' => $product->sku ? $product->sku . '-' . $size : 'BL-' . $product->id . '-' . $size,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity > 0 ? intval($product->stock_quantity / count($blouseSizes)) : 10,
                'is_active' => true,
                'is_default' => $index === 0, // First size is default
                'sort_order' => $index,
            ]);
            $variantsCreated++;
        }
        
        echo "  ✅ Created " . count($blouseSizes) . " size variants\n";
        
    } else {
        echo "  → Non-blouse product - Setting size 38\n";
        
        // Update non-blouse products with size 38
        $updateData['size'] = '38';
        $updateData['fit_type'] = 'Regular';
        $updateData['occasion'] = 'Casual';
        
        // Determine sleeve and neck type based on category
        $categoryName = strtolower($product->category->name ?? '');
        
        if (strpos($categoryName, 'kurti') !== false) {
            $updateData['sleeve_type'] = '3/4 Sleeve';
            $updateData['neck_type'] = 'Round Neck';
            $updateData['length_type'] = 'Knee-length';
        } else {
            $updateData['sleeve_type'] = 'Half Sleeve';
            $updateData['neck_type'] = 'Round Neck';
        }
        
        $product->update($updateData);
        
        // Delete existing variants for non-blouse products
        ProductVariant::where('product_id', $product->id)->delete();
        
        // Create single variant with size 38
        ProductVariant::create([
            'product_id' => $product->id,
            'option1_name' => 'Size',
            'option1_value' => '38',
            'option2_name' => null,
            'option2_value' => null,
            'option3_name' => null,
            'option3_value' => null,
            'sku' => $product->sku ? $product->sku . '-38' : 'PRD-' . $product->id . '-38',
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity > 0 ? $product->stock_quantity : 50,
            'is_active' => true,
            'is_default' => true,
            'sort_order' => 0,
        ]);
        $variantsCreated++;
        
        echo "  ✅ Created size 38 variant\n";
    }
    
    $updated++;
    echo "  Color: {$color}\n";
    echo "  Material: Cotton\n\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════\n";
echo "✅ UPDATE COMPLETE!\n";
echo "═══════════════════════════════════════════════════════\n";
echo "📊 Products updated: {$updated}\n";
echo "🔧 Variants created: {$variantsCreated}\n";
echo "\n";
echo "Summary:\n";
echo "  • All products now have Cotton material\n";
echo "  • Colors detected from product names\n";
echo "  • Blouses have 8 size variants (26, 30, 32, 34, 36, 38, 40, 42)\n";
echo "  • Other products have size 38\n";
echo "  • All products have care instructions\n";
echo "  • All products set to All Season\n";
echo "\n";

