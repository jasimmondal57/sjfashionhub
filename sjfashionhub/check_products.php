<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$products = Product::with('category')->limit(20)->get();

foreach ($products as $p) {
    echo $p->name . " | Category: " . ($p->category ? $p->category->name : "None") . " | Gender: " . ($p->gender ?? "None") . "\n";
}

