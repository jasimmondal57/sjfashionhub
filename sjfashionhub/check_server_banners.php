<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/database.sqlite',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Get all mobile app banners
    $banners = Capsule::table('mobile_app_banners')->orderBy('id', 'desc')->get();
    
    echo "Mobile App Banners (Latest First):\n";
    echo "==================================\n";
    
    if ($banners->isEmpty()) {
        echo "No banners found.\n";
    } else {
        foreach ($banners as $banner) {
            echo "ID: {$banner->id} | Title: {$banner->title} | Image: {$banner->image} | Active: " . ($banner->is_active ? 'Yes' : 'No') . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
