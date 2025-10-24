<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\GoogleSheetsSetting;
use Illuminate\Support\Facades\Http;

echo "Testing Google Sheets with Your Credentials...\n\n";

// Get the first configured sheet with webhook URL
$setting = GoogleSheetsSetting::whereNotNull('webhook_url')
    ->where('webhook_url', '!=', '')
    ->where('is_active', true)
    ->first();

if (!$setting) {
    echo "❌ No sheet found with webhook URL configured\n";
    echo "Available sheets:\n";
    
    $allSettings = GoogleSheetsSetting::where('is_active', true)->get();
    foreach ($allSettings as $s) {
        echo "  - {$s->sheet_type}: " . ($s->webhook_url ? 'Has webhook' : 'No webhook') . "\n";
    }
    exit;
}

echo "✅ Found configured sheet: {$setting->sheet_type}\n";
echo "📋 Sheet Name: {$setting->sheet_name}\n";
echo "🔗 Webhook URL: " . substr($setting->webhook_url, 0, 50) . "...\n";
echo "📊 Spreadsheet ID: " . substr($setting->spreadsheet_id, 0, 20) . "...\n\n";

// Test 1: Test Connection
echo "🔍 Test 1: Testing Connection...\n";
try {
    $testResponse = Http::timeout(30)->post($setting->webhook_url, [
        'action' => 'test_connection',
        'spreadsheet_id' => $setting->spreadsheet_id,
        'sheet_name' => $setting->sheet_name,
        'column_mapping' => $setting->column_mapping,
        'sheet_type' => $setting->sheet_type
    ]);

    echo "Response Status: " . $testResponse->status() . "\n";
    echo "Response Body: " . $testResponse->body() . "\n";
    
    if ($testResponse->successful()) {
        $data = $testResponse->json();
        echo "✅ Connection test: " . ($data['success'] ? 'SUCCESS' : 'FAILED') . "\n";
        if (isset($data['sheet_info'])) {
            echo "📊 Sheet Info: " . json_encode($data['sheet_info']) . "\n";
        }
    } else {
        echo "❌ Connection test failed with status: " . $testResponse->status() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Connection test error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Test Header Creation
echo "🔍 Test 2: Testing Header Creation...\n";
try {
    // Get column mapping and create headers
    $columnMapping = $setting->column_mapping;
    echo "Column mapping: " . json_encode($columnMapping) . "\n";
    
    // Create sample headers
    $headers = [];
    foreach ($columnMapping as $field => $column) {
        $headers[$field] = ucwords(str_replace('_', ' ', $field));
    }
    
    echo "Headers to create: " . json_encode($headers) . "\n\n";
    
    $headerResponse = Http::timeout(30)->post($setting->webhook_url, [
        'action' => 'create_headers',
        'spreadsheet_id' => $setting->spreadsheet_id,
        'sheet_name' => $setting->sheet_name,
        'column_mapping' => $columnMapping,
        'sheet_type' => $setting->sheet_type,
        'headers' => $headers
    ]);

    echo "Header Response Status: " . $headerResponse->status() . "\n";
    echo "Header Response Body: " . $headerResponse->body() . "\n";
    
    if ($headerResponse->successful()) {
        $data = $headerResponse->json();
        echo "✅ Header creation: " . ($data['success'] ? 'SUCCESS' : 'FAILED') . "\n";
        if (isset($data['message'])) {
            echo "📝 Message: " . $data['message'] . "\n";
        }
    } else {
        echo "❌ Header creation failed with status: " . $headerResponse->status() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Header creation error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check Google Apps Script directly
echo "🔍 Test 3: Testing Google Apps Script directly...\n";
try {
    $directResponse = Http::timeout(30)->get($setting->webhook_url);
    
    echo "Direct GET Response Status: " . $directResponse->status() . "\n";
    echo "Direct GET Response Body: " . $directResponse->body() . "\n";
    
    if ($directResponse->successful()) {
        $data = $directResponse->json();
        echo "✅ Direct access: SUCCESS\n";
        echo "📝 Script info: " . json_encode($data) . "\n";
    } else {
        echo "❌ Direct access failed\n";
    }
} catch (Exception $e) {
    echo "❌ Direct access error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test with minimal data
echo "🔍 Test 4: Testing with minimal header data...\n";
try {
    $minimalHeaders = [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email'
    ];
    
    $minimalMapping = [
        'id' => 'A',
        'name' => 'B',
        'email' => 'C'
    ];
    
    $minimalResponse = Http::timeout(30)->post($setting->webhook_url, [
        'action' => 'create_headers',
        'spreadsheet_id' => $setting->spreadsheet_id,
        'sheet_name' => $setting->sheet_name,
        'column_mapping' => $minimalMapping,
        'sheet_type' => 'test',
        'headers' => $minimalHeaders
    ]);

    echo "Minimal Response Status: " . $minimalResponse->status() . "\n";
    echo "Minimal Response Body: " . $minimalResponse->body() . "\n";
    
} catch (Exception $e) {
    echo "❌ Minimal test error: " . $e->getMessage() . "\n";
}

echo "\n✅ Testing completed!\n";
echo "\n💡 Next steps:\n";
echo "1. Check the Google Apps Script execution logs\n";
echo "2. Verify the script has the latest code\n";
echo "3. Check Google Sheets permissions\n";
echo "4. Try re-deploying the Google Apps Script\n";
