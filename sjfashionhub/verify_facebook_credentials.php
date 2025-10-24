<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Facebook Credentials Verification ===\n\n";

$config = \App\Models\SocialMediaConfig::where('platform', 'facebook')->first();

if (!$config) {
    echo "❌ No Facebook config found\n";
    exit;
}

echo "✅ Facebook Configuration Found\n";
echo "Platform: " . $config->platform . "\n";
echo "Name: " . $config->name . "\n";
echo "Is Active: " . ($config->is_active ? 'Yes ✅' : 'No ❌') . "\n\n";

echo "=== Credentials ===\n";
$accessToken = $config->getCredential('access_token');
$pageId = $config->getCredential('page_id');

if ($accessToken) {
    echo "✅ Access Token: " . substr($accessToken, 0, 30) . "..." . substr($accessToken, -10) . "\n";
} else {
    echo "❌ Access Token: Not found\n";
}

if ($pageId) {
    echo "✅ Page ID: " . $pageId . "\n";
} else {
    echo "❌ Page ID: Not found\n";
}

if ($accessToken && $pageId) {
    echo "\n✅ All credentials are properly saved and accessible!\n";
} else {
    echo "\n❌ Some credentials are missing\n";
}

