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
    // Create mobile_app_banners table
    $sql = "
    CREATE TABLE IF NOT EXISTS mobile_app_banners (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL,
        link_type VARCHAR(255) DEFAULT 'none',
        link_value VARCHAR(255),
        `order` INTEGER DEFAULT 0,
        is_active BOOLEAN DEFAULT 1,
        start_date TIMESTAMP NULL,
        end_date TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    Capsule::statement($sql);
    echo "mobile_app_banners table created successfully!\n";
    
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
    }
    
    // Create mobile_app_settings table
    $sql2 = "
    CREATE TABLE IF NOT EXISTS mobile_app_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        `key` VARCHAR(255) UNIQUE NOT NULL,
        value TEXT,
        type VARCHAR(255) DEFAULT 'text',
        `group` VARCHAR(255) DEFAULT 'general',
        label VARCHAR(255) NOT NULL,
        description TEXT,
        `order` INTEGER DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    Capsule::statement($sql2);
    echo "mobile_app_settings table created successfully!\n";

    // Check if banner exists
    $banners = Capsule::table('mobile_app_banners')->get();
    echo "Total banners: " . count($banners) . "\n";
    
    foreach ($banners as $banner) {
        echo "Banner: {$banner->title} (Active: {$banner->is_active})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
