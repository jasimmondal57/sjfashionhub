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
    $banners = Capsule::table('mobile_app_banners')->get();
    
    echo "Mobile App Banners:\n";
    echo "==================\n";
    
    if ($banners->isEmpty()) {
        echo "No banners found.\n";
    } else {
        foreach ($banners as $banner) {
            echo "ID: {$banner->id}\n";
            echo "Title: {$banner->title}\n";
            echo "Image: {$banner->image}\n";
            echo "Link Type: {$banner->link_type}\n";
            echo "Link Value: {$banner->link_value}\n";
            echo "Order: {$banner->order}\n";
            echo "Active: " . ($banner->is_active ? 'Yes' : 'No') . "\n";
            echo "Created: {$banner->created_at}\n";
            echo "Updated: {$banner->updated_at}\n";
            echo "---\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
