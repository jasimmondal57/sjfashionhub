<?php
// Production OTP Verification - Uses Laravel Blade Components
session_start();

// Check if user came from forgot password form
if (!isset($_SESSION['password_reset_user_id'])) {
    header('Location: forgot-password-production.php?error=' . urlencode('Please start the password reset process first.'));
    exit;
}

// Bootstrap Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

$error = $_GET['error'] ?? '';
$identifier = $_SESSION['password_reset_identifier'] ?? '';
$method = $_SESSION['password_reset_method'] ?? 'email';
$testOtp = $_SESSION['password_reset_test_otp'] ?? '';

// Render the view using Laravel's view system
$viewContent = view('auth.forgot-password-verify-custom', [
    'error' => $error,
    'identifier' => $identifier,
    'method' => $method,
    'testOtp' => $testOtp
])->render();

echo $viewContent;
