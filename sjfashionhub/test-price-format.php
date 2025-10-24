<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FacebookCatalogService;
use App\Models\Product;

echo "Testing Facebook Catalog Price Format...\n\n";

$product = Product::where('status', 'active')->where('id', 25)->first();

if (!$product) {
    echo "❌ Product not found\n";
    exit(1);
}

echo "Product: {$product->name} (ID: {$product->id})\n";
echo "Price: ₹{$product->price}\n";
echo "Sale Price: ₹" . ($product->sale_price ?? 'N/A') . "\n";
echo "Stock: {$product->stock_quantity}\n\n";

// Get the service and use reflection to access private method
$service = app(FacebookCatalogService::class);
$reflection = new ReflectionClass($service);
$method = $reflection->getMethod('prepareProductData');
$method->setAccessible(true);

$productData = $method->invoke($service, $product);

echo "Prepared data for Facebook:\n";
echo "- price: " . ($productData['price'] ?? 'NOT SET') . "\n";
echo "- sale_price: " . ($productData['sale_price'] ?? 'NOT SET') . "\n";
echo "- inventory: " . ($productData['inventory'] ?? 'NOT SET') . "\n";
echo "- availability: " . ($productData['availability'] ?? 'NOT SET') . "\n\n";

echo "Now syncing to Facebook...\n";
try {
    $result = $service->syncProduct($product);
    echo "✅ SUCCESS!\n";
    echo "Facebook Product ID: " . ($result['facebook_product_id'] ?? 'N/A') . "\n";
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

