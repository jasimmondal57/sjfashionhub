<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Manual Update of Facebook Credentials ===\n\n";

// Your credentials
$accessToken = "EAAQZBPE3hI4UBPxfZCNCJckdGm5xzFqqnh1IsIxheHumc46WD1E7otBdcES76SCzqgo5f3Qfcq6kclOi4TPuaheew64W3xSU5tHpRTPiBrCyekkLVdilUwOzZCkEat0DzUOcYz6c5sgdM1UgosG0ZBFoW6NfoDyE9gu4B5tImRRVG8ZC1EsAibzQz5HXM3Vxu9AZDZD";
$pageId = "436860479502683";

$credentials = [
    'access_token' => $accessToken,
    'page_id' => $pageId
];

echo "Credentials to save:\n";
echo json_encode($credentials, JSON_PRETTY_PRINT) . "\n\n";

// Get or create config
$config = \App\Models\SocialMediaConfig::firstOrCreate(
    ['platform' => 'facebook'],
    ['name' => 'Facebook', 'description' => 'Configuration for Facebook social media platform']
);

echo "Before update:\n";
echo "- Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
echo "- Credentials: " . json_encode($config->credentials) . "\n";
echo "- Raw DB Value: " . $config->getAttributes()['credentials'] . "\n\n";

// Update with credentials
$config->update([
    'is_active' => true,
    'credentials' => $credentials,
]);

echo "After update:\n";
echo "- Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
echo "- Credentials: " . json_encode($config->credentials) . "\n";
echo "- Raw DB Value: " . $config->getAttributes()['credentials'] . "\n\n";

// Refresh from database
$config->refresh();

echo "After refresh from DB:\n";
echo "- Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
echo "- Credentials: " . json_encode($config->credentials) . "\n";
echo "- Raw DB Value: " . $config->getAttributes()['credentials'] . "\n\n";

// Test retrieval
echo "=== Testing Credential Retrieval ===\n";
echo "Access Token: " . $config->getCredential('access_token') . "\n";
echo "Page ID: " . $config->getCredential('page_id') . "\n";

echo "\n✅ Manual update completed!\n";

