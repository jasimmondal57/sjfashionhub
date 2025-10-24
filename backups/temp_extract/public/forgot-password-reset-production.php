<?php
// Production Password Reset Form - Uses Laravel Blade Components
session_start();

// Check if user is verified
if (!isset($_SESSION['password_reset_verified']) || !$_SESSION['password_reset_verified']) {
    header('Location: forgot-password-production.php?error=' . urlencode('Please complete the verification process first.'));
    exit;
}

// Check if verification is not too old (30 minutes max)
$verifiedAt = $_SESSION['password_reset_verified_at'] ?? 0;
if (time() - $verifiedAt > 1800) { // 30 minutes
    session_destroy();
    header('Location: forgot-password-production.php?error=' . urlencode('Verification expired. Please start over.'));
    exit;
}

// Bootstrap Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

$error = $_GET['error'] ?? '';

// Render the view using Laravel's view system
$viewContent = view('auth.forgot-password-reset-custom', [
    'error' => $error
])->render();

echo $viewContent;
