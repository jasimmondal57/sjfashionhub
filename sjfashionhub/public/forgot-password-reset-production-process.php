<?php
// Production Password Reset Processor - Updates actual database
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

try {
    // Verify CSRF token
    $token = $_POST['_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        throw new Exception('Invalid security token. Please try again.');
    }
    
    $password = $_POST['password'] ?? '';
    $passwordConfirmation = $_POST['password_confirmation'] ?? '';
    $userId = $_SESSION['password_reset_user_id'];
    
    // Validate password
    if (strlen($password) < 8) {
        throw new Exception('Password must be at least 8 characters long.');
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        throw new Exception('Password must contain at least one uppercase letter.');
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        throw new Exception('Password must contain at least one lowercase letter.');
    }
    
    if (!preg_match('/\d/', $password)) {
        throw new Exception('Password must contain at least one number.');
    }
    
    if ($password !== $passwordConfirmation) {
        throw new Exception('Passwords do not match.');
    }
    
    // Find and update user
    $user = App\Models\User::find($userId);
    if (!$user) {
        throw new Exception('User not found. Please start the process again.');
    }
    
    // Update password
    $user->password = Hash::make($password);
    $user->save();
    
    // Log the password reset
    Log::info("Password reset completed for user ID: {$userId}, Email: {$user->email}");
    
    // Clear all password reset session data
    unset($_SESSION['password_reset_user_id']);
    unset($_SESSION['password_reset_identifier']);
    unset($_SESSION['password_reset_method']);
    unset($_SESSION['password_reset_token']);
    unset($_SESSION['password_reset_verified']);
    unset($_SESSION['password_reset_verified_at']);
    unset($_SESSION['password_reset_started']);
    
    // Optionally, invalidate all existing sessions for this user
    // This would log out the user from all devices
    // DB::table('sessions')->where('user_id', $userId)->delete();
    
    // Redirect to login with success message
    header('Location: /login?message=' . urlencode('Password updated successfully! Please login with your new password.'));
    exit;
    
} catch (Exception $e) {
    $error = $e->getMessage();
    header('Location: forgot-password-reset-production.php?error=' . urlencode($error));
    exit;
}
?>
