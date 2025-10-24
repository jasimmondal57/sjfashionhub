<?php
// OTP Verification page
session_start();

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create(
    'https://sjfashionhub.com/forgot-password/verify-otp',
    'GET',
    $_GET,
    $_COOKIE,
    [],
    $_SERVER
);
$kernel->handle($request);

// Check if user came from forgot password form
if (!isset($_SESSION['password_reset_user_id'])) {
    header('Location: /forgot-password?error=' . urlencode('Please start the password reset process first.'));
    exit;
}

try {
    $method = $_SESSION['password_reset_method'] ?? 'email';
    $identifier = $_SESSION['password_reset_identifier'] ?? '';
    $error = $_GET['error'] ?? '';
    
    echo view('auth.forgot-password-verify-otp', [
        'method' => $method,
        'identifier' => $identifier,
        'error' => $error
    ])->render();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<br>Trace: " . $e->getTraceAsString();
}
