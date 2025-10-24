<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/database.sqlite',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Hash the new password
    $newPassword = password_hash('8536945959', PASSWORD_DEFAULT);
    
    // Update the super admin password
    $result = Capsule::table('users')
        ->where('email', 'superadmin@sjfashionhub.in')
        ->update([
            'password' => $newPassword,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    if ($result) {
        echo "Super admin password updated successfully!\n";
        echo "Email: superadmin@sjfashionhub.in\n";
        echo "New Password: 8536945959\n";
    } else {
        echo "Failed to update password or user not found.\n";
    }

    // Check if user exists
    $user = Capsule::table('users')
        ->where('email', 'superadmin@sjfashionhub.in')
        ->first();
    
    if ($user) {
        echo "User found: {$user->name} ({$user->email})\n";
        echo "Role: {$user->role}\n";
        echo "Status: {$user->status}\n";
    } else {
        echo "Super admin user not found!\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
