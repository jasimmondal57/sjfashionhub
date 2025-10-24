<?php
// Production Forgot Password System - Uses Laravel Blade Components
require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel properly
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

// Get CSRF token and messages
$csrfToken = csrf_token();
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

// Render the view using Laravel's view system
$viewContent = view('auth.forgot-password-custom', [
    'error' => $error,
    'success' => $success
])->render();

echo $viewContent;
