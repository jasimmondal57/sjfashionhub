<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Checking Google Sheets Settings Schema...\n\n";

try {
    // Check if table exists
    $tableExists = \Schema::hasTable('google_sheets_settings');
    echo "Table exists: " . ($tableExists ? 'Yes' : 'No') . "\n";
    
    if ($tableExists) {
        // Get all columns
        $columns = \Schema::getColumnListing('google_sheets_settings');
        echo "Columns in table:\n";
        foreach ($columns as $column) {
            echo "  - {$column}\n";
        }
        
        // Check specific columns
        $hasWebhookUrl = \Schema::hasColumn('google_sheets_settings', 'webhook_url');
        echo "\nwebhook_url column exists: " . ($hasWebhookUrl ? 'Yes' : 'No') . "\n";
        
        // Show sample data
        echo "\nSample data from table:\n";
        $sampleData = \DB::table('google_sheets_settings')->limit(2)->get();
        foreach ($sampleData as $row) {
            echo "ID: {$row->id}, Type: {$row->sheet_type}\n";
            foreach ((array)$row as $key => $value) {
                echo "  {$key}: " . ($value ?: 'NULL') . "\n";
            }
            echo "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check the migration files
echo "Checking migration files...\n";
$migrationPath = database_path('migrations');
$files = glob($migrationPath . '/*google_sheets*');

foreach ($files as $file) {
    echo "Found migration: " . basename($file) . "\n";
}

if (empty($files)) {
    echo "No Google Sheets migration files found!\n";
    echo "This might be why the webhook_url column is missing.\n";
}
