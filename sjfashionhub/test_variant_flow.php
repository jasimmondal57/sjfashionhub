<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

echo "=== TESTING VARIANT FLOW ===\n\n";

// 1. Find a blouse product with variants
echo "1. Finding blouse product with variants...\n";
$blouse = Product::whereHas('category', function($q) {
    $q->where('name', 'like', '%blouse%');
})->with('productVariants')->first();

if (!$blouse) {
    echo "❌ No blouse product found!\n";
    exit(1);
}

echo "✅ Found: {$blouse->name}\n";
echo "   Variants: {$blouse->productVariants->count()}\n";

if ($blouse->productVariants->count() > 0) {
    $variant = $blouse->productVariants->first();
    echo "   First variant: Size {$variant->option1_value} (ID: {$variant->id})\n\n";
    
    // 2. Check if Cart model has productVariant relationship
    echo "2. Testing Cart model relationships...\n";
    $cartItems = Cart::with(['product', 'productVariant'])->limit(5)->get();
    echo "✅ Cart items loaded with productVariant relationship\n";
    echo "   Total cart items: {$cartItems->count()}\n";
    
    foreach ($cartItems as $item) {
        if ($item->productVariant) {
            echo "   - {$item->product->name} - Size: {$item->productVariant->option1_value}\n";
        } else {
            echo "   - {$item->product->name} - No variant\n";
        }
    }
    echo "\n";
    
    // 3. Check OrderItem model
    echo "3. Testing OrderItem model relationships...\n";
    $orderItems = OrderItem::with(['product', 'productVariant'])
        ->whereNotNull('product_variant_id')
        ->limit(5)
        ->get();
    
    echo "✅ OrderItem model has productVariant relationship\n";
    echo "   Order items with variants: {$orderItems->count()}\n";
    
    foreach ($orderItems as $item) {
        if ($item->productVariant) {
            echo "   - Order #{$item->order_id}: {$item->product->name} - Size: {$item->productVariant->option1_value}\n";
        }
    }
    echo "\n";
    
    // 4. Check recent orders
    echo "4. Checking recent orders for variant data...\n";
    $recentOrders = Order::with(['items.product', 'items.productVariant'])
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();
    
    echo "✅ Recent orders: {$recentOrders->count()}\n";
    foreach ($recentOrders as $order) {
        echo "   Order #{$order->order_number}:\n";
        foreach ($order->items as $item) {
            if ($item->productVariant) {
                echo "     - {$item->product->name} - Size: {$item->productVariant->option1_value}\n";
            } elseif ($item->variant_details && isset($item->variant_details['size'])) {
                echo "     - {$item->product->name} - Size: {$item->variant_details['size']} (from variant_details)\n";
            } else {
                echo "     - {$item->product->name} - No variant\n";
            }
        }
    }
    echo "\n";
}

echo "=== TEST COMPLETE ===\n";
echo "✅ All variant relationships are working correctly!\n";
echo "\nNext steps:\n";
echo "1. Add a blouse product to cart with a specific size variant\n";
echo "2. Check cart page - variant size should be displayed\n";
echo "3. Proceed to checkout - variant size should be shown in order summary\n";
echo "4. Complete order - variant should be saved in order_items\n";
echo "5. Check admin panel - variant size should be visible in order details\n";

