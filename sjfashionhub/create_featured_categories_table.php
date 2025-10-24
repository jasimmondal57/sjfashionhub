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
    // Create mobile_app_featured_categories table
    $sql = "
    CREATE TABLE IF NOT EXISTS mobile_app_featured_categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER NOT NULL,
        `order` INTEGER DEFAULT 0,
        is_active BOOLEAN DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    )";
    
    Capsule::statement($sql);
    echo "mobile_app_featured_categories table created successfully!\n";
    
    // Get some categories to add as featured
    $categories = Capsule::table('categories')
        ->where('is_active', true)
        ->limit(6)
        ->get();
    
    if ($categories->count() > 0) {
        echo "Adding sample featured categories...\n";
        
        $order = 1;
        foreach ($categories as $category) {
            // Check if already exists
            $exists = Capsule::table('mobile_app_featured_categories')
                ->where('category_id', $category->id)
                ->exists();
                
            if (!$exists) {
                Capsule::table('mobile_app_featured_categories')->insert([
                    'category_id' => $category->id,
                    'order' => $order,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                
                echo "Added category: {$category->name} (Order: {$order})\n";
                $order++;
            }
        }
    }
    
    // Check results
    $featuredCategories = Capsule::table('mobile_app_featured_categories as mfc')
        ->join('categories as c', 'mfc.category_id', '=', 'c.id')
        ->select('mfc.*', 'c.name', 'c.slug')
        ->orderBy('mfc.order')
        ->get();
    
    echo "\nFeatured Categories:\n";
    echo "==================\n";
    foreach ($featuredCategories as $fc) {
        echo "Order {$fc->order}: {$fc->name} (Active: " . ($fc->is_active ? 'Yes' : 'No') . ")\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
