<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Facebook Connection ===\n\n";

$config = \App\Models\SocialMediaConfig::where('platform', 'facebook')->first();

if (!$config) {
    echo "❌ No Facebook config found\n";
    exit;
}

echo "Platform: " . $config->platform . "\n";
echo "Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
echo "Access Token: " . substr($config->getCredential('access_token'), 0, 20) . "...\n";
echo "Page ID: " . $config->getCredential('page_id') . "\n\n";

// Test Facebook API connection
echo "Testing Facebook Graph API connection...\n";

$accessToken = $config->getCredential('access_token');
$pageId = $config->getCredential('page_id');

if (!$accessToken || !$pageId) {
    echo "❌ Missing credentials\n";
    exit;
}

// Test with a simple API call
$url = "https://graph.facebook.com/v18.0/{$pageId}?access_token={$accessToken}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "✅ Connection successful!\n";
    echo "Page Name: " . ($data['name'] ?? 'N/A') . "\n";
    echo "Page ID: " . ($data['id'] ?? 'N/A') . "\n";
} else {
    echo "❌ Connection failed\n";
    $error = json_decode($response, true);
    if (isset($error['error']['message'])) {
        echo "Error: " . $error['error']['message'] . "\n";
    }
}

