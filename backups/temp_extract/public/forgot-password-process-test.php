<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting process...<br>";

try {
    echo "1. Checking POST data...<br>";
    var_dump($_POST);
    
    echo "2. Testing Laravel bootstrap...<br>";
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "Autoload OK<br>";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "App bootstrap OK<br>";
    
    echo "3. Testing User model...<br>";
    $user = App\Models\User::first();
    echo "User model OK<br>";
    
    echo "4. Testing UserOtp model...<br>";
    $otp = App\Models\UserOtp::first();
    echo "UserOtp model OK<br>";
    
    echo "All tests passed!";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}
?>
