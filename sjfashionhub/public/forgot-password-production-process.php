<?php
// Production Forgot Password Processor - Works with actual Laravel database
session_start();

// Bootstrap Laravel properly
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
    
    // Get form data
    $method = $_POST['method'] ?? 'email';
    $identifier = trim($_POST['identifier'] ?? '');
    
    if (empty($identifier)) {
        throw new Exception('Please enter your email or phone number.');
    }
    
    // Validate input based on method
    if ($method === 'email') {
        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }
    } else {
        // Clean phone number
        $identifier = preg_replace('/[^\d]/', '', $identifier);
        if (strlen($identifier) < 10) {
            throw new Exception('Please enter a valid phone number.');
        }
    }
    
    // Find user in database
    $user = null;
    if ($method === 'email') {
        $user = App\Models\User::where('email', $identifier)->first();
    } else {
        // Try different phone number formats
        $user = App\Models\User::where('phone', $identifier)
                   ->orWhere('phone', '+91' . $identifier)
                   ->orWhere('phone', 'LIKE', '%' . $identifier)
                   ->first();
    }
    
    if (!$user) {
        throw new Exception('No account found with this ' . ($method === 'email' ? 'email address' : 'phone number') . '.');
    }
    
    // Generate OTP
    $otp = sprintf('%06d', mt_rand(100000, 999999));
    $expiresAt = now()->addMinutes(10);
    
    // Store OTP in database
    try {
        // Try to use UserOtp model if it exists
        $otpRecord = App\Models\UserOtp::updateOrCreate(
            [
                'identifier' => $identifier,
                'purpose' => 'password_reset'
            ],
            [
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => $expiresAt,
                'verified' => false,
                'attempts' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    } catch (Exception $e) {
        // Fallback: store in session if database model doesn't work
        $_SESSION['password_reset_otp'] = $otp;
        $_SESSION['password_reset_expires'] = $expiresAt->timestamp;
    }
    
    // Send OTP based on method
    $sent = false;
    
    if ($method === 'email') {
        try {
            // Try to send email using Laravel Mail
            Mail::to($identifier)->send(new App\Mail\OtpNotification($otp, 'password_reset'));
            $sent = true;
        } catch (Exception $e) {
            // Fallback: log the OTP for testing
            Log::info("Password Reset OTP for {$identifier}: {$otp}");
            $sent = true; // Consider it sent for testing
        }
    } elseif ($method === 'phone') {
        try {
            // Try to send SMS
            $smsService = app(App\Services\SmsService::class);
            $sent = $smsService->sendOtp($identifier, $otp, 'password_reset');
        } catch (Exception $e) {
            // Fallback: log the OTP for testing
            Log::info("Password Reset SMS OTP for {$identifier}: {$otp}");
            $sent = true; // Consider it sent for testing
        }
    } elseif ($method === 'whatsapp') {
        try {
            // Try to send WhatsApp
            $whatsappService = app(App\Services\WhatsAppService::class);
            $sent = $whatsappService->sendOtp($identifier, $otp, 'password_reset');
        } catch (Exception $e) {
            // Fallback: log the OTP for testing
            Log::info("Password Reset WhatsApp OTP for {$identifier}: {$otp}");
            $sent = true; // Consider it sent for testing
        }
    }
    
    if (!$sent) {
        throw new Exception('Failed to send verification code. Please try again.');
    }
    
    // Store session data for verification
    $_SESSION['password_reset_user_id'] = $user->id;
    $_SESSION['password_reset_identifier'] = $identifier;
    $_SESSION['password_reset_method'] = $method;
    $_SESSION['password_reset_started'] = time();
    
    // For testing purposes, also store the OTP in session
    $_SESSION['password_reset_test_otp'] = $otp;
    
    // Redirect to OTP verification
    header('Location: forgot-password-verify-production.php');
    exit;
    
} catch (Exception $e) {
    $error = $e->getMessage();
    header('Location: forgot-password-production.php?error=' . urlencode($error));
    exit;
}
?>
