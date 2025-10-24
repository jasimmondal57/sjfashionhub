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

// Update contact information
$contactInfo = [
    'email' => 'contact@sjfashionhub.com',
    'phone' => '+91 7063474409',
    'address' => 'Near Masjid, Nazrulpally, Bhubandanga, Bolpur, Pin: 731204, West Bengal, India',
    'gstin' => '19DFEPM6450N1ZU'
];

$footerSetting->update([
    'contact_info' => $contactInfo,
]);

echo "✓ Footer contact information updated successfully\n";
echo "✓ Email: " . $contactInfo['email'] . "\n";
echo "✓ Phone: " . $contactInfo['phone'] . "\n";
echo "✓ Address: " . $contactInfo['address'] . "\n";
echo "✓ GSTIN: " . $contactInfo['gstin'] . "\n";

