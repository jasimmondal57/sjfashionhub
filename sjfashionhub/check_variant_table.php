<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::select("PRAGMA table_info(product_variants)");
echo json_encode($columns, JSON_PRETTY_PRINT);
echo PHP_EOL;

