<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\GoogleSheetsSetting;

echo "Debugging Webhook URLs...\n\n";

$settings = GoogleSheetsSetting::all();

foreach ($settings as $setting) {
    echo "=== {$setting->sheet_type} ===\n";
    echo "ID: {$setting->id}\n";
    echo "Sheet Name: {$setting->sheet_name}\n";
    echo "Is Active: " . ($setting->is_active ? 'Yes' : 'No') . "\n";
    echo "Spreadsheet ID: " . ($setting->spreadsheet_id ?: 'NULL') . "\n";
    echo "Webhook URL: '" . ($setting->webhook_url ?: 'NULL') . "'\n";
    echo "Webhook URL Length: " . strlen($setting->webhook_url ?: '') . "\n";
    echo "Webhook URL Type: " . gettype($setting->webhook_url) . "\n";
    
    // Check if it's actually null vs empty string
    if ($setting->webhook_url === null) {
        echo "Status: NULL value\n";
    } elseif ($setting->webhook_url === '') {
        echo "Status: Empty string\n";
    } else {
        echo "Status: Has value\n";
        echo "First 100 chars: " . substr($setting->webhook_url, 0, 100) . "\n";
    }
    echo "\n";
}

// Check if any have webhook URLs
$withWebhook = GoogleSheetsSetting::whereNotNull('webhook_url')
    ->where('webhook_url', '!=', '')
    ->get();

echo "Settings with webhook URLs: " . $withWebhook->count() . "\n";

if ($withWebhook->count() > 0) {
    echo "Found settings with webhooks:\n";
    foreach ($withWebhook as $setting) {
        echo "  - {$setting->sheet_type}: " . substr($setting->webhook_url, 0, 50) . "...\n";
    }
} else {
    echo "❌ No settings found with webhook URLs!\n";
    echo "\n💡 This means you need to:\n";
    echo "1. Go to admin panel Google Sheets settings\n";
    echo "2. Configure each sheet type\n";
    echo "3. Add the Google Apps Script Web App URL\n";
    echo "4. Save the configuration\n";
}

echo "\n";

// Show the raw database values
echo "Raw database check:\n";
$rawData = \DB::table('google_sheets_settings')->select('id', 'sheet_type', 'webhook_url')->get();
foreach ($rawData as $row) {
    echo "ID {$row->id} ({$row->sheet_type}): webhook_url = ";
    if ($row->webhook_url === null) {
        echo "NULL\n";
    } elseif ($row->webhook_url === '') {
        echo "EMPTY STRING\n";
    } else {
        echo "'{$row->webhook_url}'\n";
    }
}
