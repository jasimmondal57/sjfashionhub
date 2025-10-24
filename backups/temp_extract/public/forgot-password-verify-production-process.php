<?php
// Production OTP Verification Processor
session_start();

// Check session
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

try {
    // Verify CSRF token
    $token = $_POST['_token'] ?? '';
    if (!hash_equals(csrf_token(), $token)) {
        throw new Exception('Invalid security token. Please try again.');
    }
    
    $otp = trim($_POST['otp'] ?? '');
    $identifier = $_SESSION['password_reset_identifier'];
    $userId = $_SESSION['password_reset_user_id'];
    
    if (empty($otp) || strlen($otp) !== 6 || !ctype_digit($otp)) {
        throw new Exception('Please enter a valid 6-digit code.');
    }
    
    // Verify OTP
    $verified = false;
    
    try {
        // Try to verify using UserOtp model
        $verified = App\Models\UserOtp::verifyOtp($identifier, $otp, 'password_reset');
    } catch (Exception $e) {
        // Fallback: check session OTP
        $sessionOtp = $_SESSION['password_reset_test_otp'] ?? '';
        $expiresAt = $_SESSION['password_reset_expires'] ?? 0;
        
        if ($otp === $sessionOtp && time() < $expiresAt) {
            $verified = true;
        }
    }
    
    if (!$verified) {
        throw new Exception('Invalid or expired verification code. Please try again.');
    }
    
    // Generate password reset token
    $resetToken = bin2hex(random_bytes(32));
    
    // Store reset token in session
    $_SESSION['password_reset_token'] = $resetToken;
    $_SESSION['password_reset_verified'] = true;
    $_SESSION['password_reset_verified_at'] = time();
    
    // Clear OTP from session
    unset($_SESSION['password_reset_test_otp']);
    unset($_SESSION['password_reset_expires']);
    
    // Redirect to password reset form
    header('Location: forgot-password-reset-production.php');
    exit;
    
} catch (Exception $e) {
    $error = $e->getMessage();
    header('Location: forgot-password-verify-production.php?error=' . urlencode($error));
    exit;
}
?>
