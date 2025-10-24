<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Page;

// Get the PageController to access the default content methods
$controller = new \App\Http\Controllers\Admin\PageController();

// Use reflection to call private methods
$reflection = new ReflectionClass($controller);

// Update Shipping Policy
$shippingMethod = $reflection->getMethod('getDefaultShippingContent');
$shippingMethod->setAccessible(true);
$shippingContent = $shippingMethod->invoke($controller);

$shippingPage = Page::where('slug', 'shipping-policy')->first();
if ($shippingPage) {
    $shippingPage->update(['content' => $shippingContent]);
    echo "✓ Shipping Policy updated\n";
} else {
    echo "✗ Shipping Policy not found\n";
}

// Update Return Policy
$returnMethod = $reflection->getMethod('getDefaultReturnContent');
$returnMethod->setAccessible(true);
$returnContent = $returnMethod->invoke($controller);

$returnPage = Page::where('slug', 'return-policy')->first();
if ($returnPage) {
    $returnPage->update(['content' => $returnContent]);
    echo "✓ Return Policy updated\n";
} else {
    echo "✗ Return Policy not found\n";
}

// Update Privacy Policy
$privacyMethod = $reflection->getMethod('getDefaultPrivacyContent');
$privacyMethod->setAccessible(true);
$privacyContent = $privacyMethod->invoke($controller);

$privacyPage = Page::where('slug', 'privacy-policy')->first();
if ($privacyPage) {
    $privacyPage->update(['content' => $privacyContent]);
    echo "✓ Privacy Policy updated\n";
} else {
    echo "✗ Privacy Policy not found\n";
}

// Update Terms of Service
$termsMethod = $reflection->getMethod('getDefaultTermsContent');
$termsMethod->setAccessible(true);
$termsContent = $termsMethod->invoke($controller);

$termsPage = Page::where('slug', 'terms-of-service')->first();
if ($termsPage) {
    $termsPage->update(['content' => $termsContent]);
    echo "✓ Terms of Service updated\n";
} else {
    echo "✗ Terms of Service not found\n";
}

// Update Contact Page
$contactMethod = $reflection->getMethod('getDefaultContactContent');
$contactMethod->setAccessible(true);
$contactContent = $contactMethod->invoke($controller);

$contactPage = Page::where('slug', 'contact')->first();
if ($contactPage) {
    $contactPage->update(['content' => $contactContent]);
    echo "✓ Contact Page updated\n";
} else {
    echo "✗ Contact Page not found\n";
}

echo "\n✅ All policies updated successfully!\n";

