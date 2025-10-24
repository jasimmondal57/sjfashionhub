<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FacebookCatalogService;
use App\Models\Product;

echo "Testing Facebook Catalog API Connection...\n\n";

$service = app(FacebookCatalogService::class);
$product = Product::where('status', 'active')->first();

if (!$product) {
    echo "❌ No active products found\n";
    exit(1);
}

echo "Testing with product: {$product->name} (ID: {$product->id})\n";
echo "Price: ₹{$product->price}\n";
echo "Stock: {$product->stock}\n\n";

try {
    echo "Syncing product to Facebook Catalog...\n";
    $result = $service->syncProduct($product);
    
    echo "✅ SUCCESS!\n";
    echo "Result: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR!\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

