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
    // Insert sample banner
    $result = Capsule::table('mobile_app_banners')->insert([
        'title' => 'Welcome to SJ Fashion Hub Mobile App',
        'image' => 'mobile/banners/sample-banner.jpg',
        'link_type' => 'none',
        'link_value' => null,
        'order' => 1,
        'is_active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    if ($result) {
        echo "Sample banner created successfully!\n";
    } else {
        echo "Failed to create sample banner.\n";
    }

    // Check if banner exists
    $banners = Capsule::table('mobile_app_banners')->get();
    echo "Total banners: " . count($banners) . "\n";
    
    foreach ($banners as $banner) {
        echo "Banner: {$banner->title} (Active: {$banner->is_active})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
