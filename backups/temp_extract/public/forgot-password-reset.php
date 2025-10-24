<?php
// Password reset form
session_start();

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create(
    'https://sjfashionhub.com/reset-password-new/' . ($_GET['token'] ?? ''),
    'GET',
    $_GET,
    $_COOKIE,
    [],
    $_SERVER
);
$kernel->handle($request);

// Check if user is verified
if (!isset($_SESSION['password_reset_verified']) || !$_SESSION['password_reset_verified']) {
    header('Location: /forgot-password?error=' . urlencode('Please complete verification first'));
    exit;
}

// Check if not expired (30 minutes)
if (time() - ($_SESSION['password_reset_verified_at'] ?? 0) > 1800) {
    session_destroy();
    header('Location: /forgot-password?error=' . urlencode('Verification expired. Please start over.'));
    exit;
}

try {
    $error = $_GET['error'] ?? '';
    
    echo view('auth.forgot-password-reset-new', [
        'error' => $error
    ])->render();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
