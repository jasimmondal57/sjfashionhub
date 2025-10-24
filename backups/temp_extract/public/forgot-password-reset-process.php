<?php
// Process password reset
session_start();

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

try {
    // Check session
    if (!isset($_SESSION['password_reset_verified']) || !$_SESSION['password_reset_verified']) {
        header('Location: /forgot-password.php?error=' . urlencode('Please complete verification first'));
        exit;
    }
    
    // Check if not expired (30 minutes)
    if (time() - $_SESSION['password_reset_verified_at'] > 1800) {
        session_destroy();
        header('Location: /forgot-password.php?error=' . urlencode('Verification expired. Please start over.'));
        exit;
    }
    
    $password = $request->input('password');
    $passwordConfirmation = $request->input('password_confirmation');
    
    // Validate password
    if (empty($password) || strlen($password) < 8) {
        header('Location: /forgot-password-reset.php?error=' . urlencode('Password must be at least 8 characters'));
        exit;
    }
    
    if ($password !== $passwordConfirmation) {
        header('Location: /forgot-password-reset.php?error=' . urlencode('Passwords do not match'));
        exit;
    }
    
    // Update password
    $user = App\Models\User::find($_SESSION['password_reset_user_id']);
    if (!$user) {
        header('Location: /forgot-password.php?error=' . urlencode('User not found'));
        exit;
    }
    
    $user->password = Illuminate\Support\Facades\Hash::make($password);
    $user->save();
    
    // Clear session
    session_destroy();
    
    // Redirect to login with success message
    header('Location: /login?success=' . urlencode('Password reset successfully! Please login with your new password.'));
    exit;
    
} catch (Exception $e) {
    header('Location: /forgot-password-reset.php?error=' . urlencode($e->getMessage()));
    exit;
}
