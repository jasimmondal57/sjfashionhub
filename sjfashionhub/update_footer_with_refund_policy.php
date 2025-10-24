<?php

require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\FooterSetting;

// Get active footer settings
$footerSetting = FooterSetting::active()->first();

if (!$footerSetting) {
    echo "✗ No active footer settings found\n";
    exit(1);
}

// Get current quick links
$quickLinks = $footerSetting->quick_links ?? [];

// Check if refund policy link already exists
$refundPolicyExists = false;
foreach ($quickLinks as $link) {
    if ($link['url'] === '/refund-policy') {
        $refundPolicyExists = true;
        break;
    }
}

// Add refund policy link if it doesn't exist
if (!$refundPolicyExists) {
    $quickLinks[] = ['text' => 'Refund Policy', 'url' => '/refund-policy'];
    echo "✓ Added Refund Policy to Quick Links\n";
} else {
    echo "✓ Refund Policy already exists in Quick Links\n";
}

// Update footer settings
$footerSetting->update([
    'quick_links' => $quickLinks,
]);

echo "✓ Footer settings updated successfully\n";
echo "✓ Refund Policy link is now visible in footer Quick Links\n";

