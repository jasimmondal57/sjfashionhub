<?php
// Process OTP verification
session_start();

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

try {
    // Check session
    if (!isset($_SESSION['password_reset_user_id'])) {
        header('Location: /forgot-password.php?error=' . urlencode('Session expired. Please start over.'));
        exit;
    }
    
    $otp = $request->input('otp');
    $identifier = $_SESSION['password_reset_identifier'];
    
    // Verify OTP
    $verified = App\Models\UserOtp::verifyOtp($identifier, $otp, 'password_reset');
    
    if (!$verified) {
        header('Location: /forgot-password-verify.php?error=' . urlencode('Invalid or expired OTP'));
        exit;
    }
    
    // Generate reset token
    $token = bin2hex(random_bytes(32));
    $_SESSION['password_reset_token'] = $token;
    $_SESSION['password_reset_verified'] = true;
    $_SESSION['password_reset_verified_at'] = time();
    
    // Redirect to password reset form
    header('Location: /forgot-password-reset.php?token=' . $token);
    exit;
    
} catch (Exception $e) {
    header('Location: /forgot-password-verify.php?error=' . urlencode($e->getMessage()));
    exit;
}
