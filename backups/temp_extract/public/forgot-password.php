<?php
// Forgot password page with proper Laravel integration
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Create proper request with correct URL
$request = Illuminate\Http\Request::create(
    'https://sjfashionhub.com/forgot-password',
    'GET',
    [],
    $_COOKIE,
    [],
    $_SERVER
);

$kernel->handle($request);

try {
    echo view('auth.forgot-password')->render();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
