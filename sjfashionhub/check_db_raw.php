<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$config = \App\Models\SocialMediaConfig::where('platform', 'facebook')->first();

if ($config) {
    echo "=== Facebook Configuration (Raw DB) ===\n";
    echo "Platform: " . $config->platform . "\n";
    echo "Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
    
    // Get raw attributes without casting
    $attributes = $config->getAttributes();
    echo "Raw credentials from DB: " . $attributes['credentials'] . "\n";
    echo "Raw credentials length: " . strlen($attributes['credentials']) . "\n";
    
    // Try to decrypt manually
    if ($attributes['credentials']) {
        try {
            $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($attributes['credentials']);
            echo "Decrypted: " . $decrypted . "\n";
        } catch (\Exception $e) {
            echo "Decryption error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Credentials field is empty in database!\n";
    }
} else {
    echo "No Facebook config found\n";
}

