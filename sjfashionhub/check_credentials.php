<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$config = \App\Models\SocialMediaConfig::where('platform', 'facebook')->first();

if ($config) {
    echo "=== Facebook Configuration ===\n";
    echo "Platform: " . $config->platform . "\n";
    echo "Name: " . $config->name . "\n";
    echo "Is Active: " . ($config->is_active ? 'Yes' : 'No') . "\n";
    echo "Credentials (decrypted): " . json_encode($config->credentials, JSON_PRETTY_PRINT) . "\n";
    echo "Raw DB Value: " . $config->getAttributes()['credentials'] . "\n";
} else {
    echo "No Facebook config found\n";
}

echo "\n=== All Configs ===\n";
$all = \App\Models\SocialMediaConfig::all();
foreach ($all as $c) {
    echo $c->platform . " - Active: " . ($c->is_active ? 'Yes' : 'No') . " - Credentials: " . json_encode($c->credentials) . "\n";
}

