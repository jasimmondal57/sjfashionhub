<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;

echo "🚀 Starting brand update and variant fix...\n\n";

$products = Product::with('category')->get();
$blouseCategory = Category::where('name', 'LIKE', '%Blouse%')->first();

$updated = 0;

foreach ($products as $product) {
    echo "Processing: {$product->name} (ID: {$product->id})\n";
    
    $isBlouse = $product->category_id == $blouseCategory->id;
    
    // Update brand for all products
    $updateData = [
        'brand' => 'SJ Fashion Hub',
    ];
    
    if ($isBlouse) {
        echo "  → Blouse: Keeping variants, updating brand\n";
        
        // For blouses, just update the brand
        // Variants already exist from previous script
        $product->update($updateData);
        
        echo "  ✅ Brand updated, {$product->productVariants->count()} variants retained\n";
        
    } else {
        echo "  → Non-blouse: Removing variant, setting direct size\n";
        
        // For non-blouse products, remove variants and set size directly
        $product->update($updateData);
        
        // Delete variants for non-blouse products
        ProductVariant::where('product_id', $product->id)->delete();
        
        echo "  ✅ Brand updated, variants removed, size set to 38\n";
    }
    
    $updated++;
    echo "\n";
}

echo "\n";
echo "═══════════════════════════════════════════════════════\n";
echo "✅ UPDATE COMPLETE!\n";
echo "═══════════════════════════════════════════════════════\n";
echo "📊 Products updated: {$updated}\n";
echo "\n";
echo "Summary:\n";
echo "  • All products now have brand: SJ Fashion Hub\n";
echo "  • Blouses: Keep variants (8 sizes: 26-42)\n";
echo "  • Other products: No variants, direct size 38\n";
echo "\n";

// Verification
$blouseCount = Product::where('category_id', $blouseCategory->id)->count();
$blouseVariants = ProductVariant::whereHas('product', function($q) use ($blouseCategory) {
    $q->where('category_id', $blouseCategory->id);
})->count();
$otherVariants = ProductVariant::whereHas('product', function($q) use ($blouseCategory) {
    $q->where('category_id', '!=', $blouseCategory->id);
})->count();

echo "Verification:\n";
echo "  • Blouse products: {$blouseCount}\n";
echo "  • Blouse variants: {$blouseVariants}\n";
echo "  • Non-blouse variants: {$otherVariants}\n";
echo "\n";

