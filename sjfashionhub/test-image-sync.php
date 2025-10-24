<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\FacebookCatalogService;
use App\Models\Product;

echo "Testing Facebook Catalog Image Upload...\n\n";

$product = Product::where('status', 'active')->first();

if (!$product) {
    echo "❌ No active products found\n";
    exit(1);
}

echo "Product: {$product->name} (ID: {$product->id})\n";
echo "Images field: " . json_encode($product->images) . "\n\n";

// Get the service and use reflection to access private method
$service = app(FacebookCatalogService::class);
$reflection = new ReflectionClass($service);
$method = $reflection->getMethod('prepareProductData');
$method->setAccessible(true);

$productData = $method->invoke($service, $product);

echo "Prepared data for Facebook:\n";
echo "- image_url: " . ($productData['image_url'] ?? 'NOT SET') . "\n";
echo "- additional_image_url: " . json_encode($productData['additional_image_url'] ?? []) . "\n";
echo "- inventory: " . ($productData['inventory'] ?? 'NOT SET') . "\n";
echo "- price: " . ($productData['price'] ?? 'NOT SET') . " paise\n";
echo "- availability: " . ($productData['availability'] ?? 'NOT SET') . "\n\n";

// Test if image URL is accessible
if (isset($productData['image_url'])) {
    echo "Testing image URL accessibility...\n";
    $ch = curl_init($productData['image_url']);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        echo "✅ Image URL is accessible (HTTP {$httpCode})\n";
    } else {
        echo "❌ Image URL returned HTTP {$httpCode}\n";
    }
}

echo "\nNow syncing to Facebook...\n";
try {
    $result = $service->syncProduct($product);
    echo "✅ SUCCESS!\n";
    echo "Facebook Product ID: " . ($result['facebook_product_id'] ?? 'N/A') . "\n";
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

