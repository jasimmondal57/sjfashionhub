<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate a form submission
$_SERVER['REQUEST_METHOD'] = 'PUT';
$_POST = [
    'is_active' => '1',
    'credentials' => [
        'access_token' => 'test_token_12345',
        'page_id' => 'test_page_id_67890'
    ]
];

echo "=== Simulating Form Submission ===\n";
echo "Platform: facebook\n";
echo "POST Data: " . json_encode($_POST, JSON_PRETTY_PRINT) . "\n\n";

// Test the controller logic
$credentials = $_POST['credentials'] ?? [];
echo "Raw credentials: " . json_encode($credentials) . "\n";

$credentials = array_filter($credentials, function($value) {
    return !empty($value);
});

echo "Filtered credentials: " . json_encode($credentials) . "\n\n";

if (!empty($credentials)) {
    echo "✅ Credentials would be saved!\n";
    
    // Try to save
    $config = \App\Models\SocialMediaConfig::firstOrCreate(
        ['platform' => 'facebook'],
        ['name' => 'Facebook', 'description' => 'Configuration for Facebook social media platform']
    );
    
    $config->update([
        'is_active' => true,
        'credentials' => $credentials,
    ]);
    
    echo "Saved to database!\n";
    echo "Credentials in DB: " . json_encode($config->credentials) . "\n";
} else {
    echo "❌ No credentials to save\n";
}

