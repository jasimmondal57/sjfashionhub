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
    // Get all table names
    $tables = Capsule::select("SELECT name FROM sqlite_master WHERE type='table'");
    
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- {$table->name}\n";
    }
    
    // Check if mobile_app_banners table exists
    $mobileAppTables = array_filter($tables, function($table) {
        return strpos($table->name, 'mobile_app') !== false;
    });
    
    echo "\nMobile app tables:\n";
    if (empty($mobileAppTables)) {
        echo "No mobile app tables found.\n";
    } else {
        foreach ($mobileAppTables as $table) {
            echo "- {$table->name}\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
