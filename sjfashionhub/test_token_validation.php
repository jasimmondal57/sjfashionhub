<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Facebook Token Validation ===\n\n";

$config = \App\Models\SocialMediaConfig::where('platform', 'facebook')->first();

if (!$config) {
    echo "❌ No Facebook config found\n";
    exit;
}

$accessToken = $config->getCredential('access_token');
$pageId = $config->getCredential('page_id');

echo "Access Token: " . substr($accessToken, 0, 30) . "...\n";
echo "Page ID: " . $pageId . "\n\n";

// Test token validation
echo "Testing token validation...\n";

$response = \Illuminate\Support\Facades\Http::get("https://graph.facebook.com/debug_token", [
    'input_token' => $accessToken,
    'access_token' => $accessToken
]);

echo "Response Status: " . $response->status() . "\n";
echo "Response Body:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT) . "\n";

if ($response->successful()) {
    $data = $response->json();
    if (isset($data['data']['is_valid']) && $data['data']['is_valid']) {
        echo "\n✅ Token is VALID!\n";
        echo "App ID: " . ($data['data']['app_id'] ?? 'Unknown') . "\n";
    } else {
        echo "\n❌ Token is INVALID\n";
    }
}

