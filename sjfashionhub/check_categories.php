<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Product;

echo "=== ALL CATEGORIES ===\n";
$categories = Category::all();
foreach ($categories as $cat) {
    $productCount = Product::where('category_id', $cat->id)->count();
    echo $cat->name . " (ID: " . $cat->id . ") - " . $productCount . " products\n";
}

echo "\n=== SAMPLE PRODUCTS BY CATEGORY ===\n";
foreach ($categories as $cat) {
    $products = Product::where('category_id', $cat->id)->limit(3)->get();
    if ($products->count() > 0) {
        echo "\n" . $cat->name . ":\n";
        foreach ($products as $p) {
            echo "  - " . $p->name . "\n";
        }
    }
}

