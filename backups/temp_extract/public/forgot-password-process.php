<?php
// Process forgot password form submission
session_start();

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

try {
    // Get form data
    $method = $request->input('method');
    $identifier = $request->input('identifier');
    
    // Validate
    if (empty($method) || empty($identifier)) {
        header('Location: /forgot-password?error=' . urlencode('Please fill in all fields'));
        exit;
    }
    
    // Find user
    $user = null;
    if ($method === 'email') {
        $user = App\Models\User::where('email', $identifier)->first();
    } else {
        $user = App\Models\User::where('phone', $identifier)->first();
    }
    
    if (!$user) {
        header('Location: /forgot-password?error=' . urlencode('User not found'));
        exit;
    }
    
    // Generate and send OTP
    // Correct parameter order: generateAndSend($identifier, $type, $purpose, $method, $metadata)
    $otpRecord = App\Models\UserOtp::generateAndSend(
        $identifier,           // identifier (email or phone)
        $method,              // type (email, phone, whatsapp)
        'password_reset',     // purpose
        $method,              // method (same as type for delivery)
        json_encode(['user_id' => $user->id])  // metadata
    );
    
    if (!$otpRecord) {
        header('Location: /forgot-password?error=' . urlencode('Failed to send OTP. Please try again.'));
        exit;
    }
    
    // Store in session
    $_SESSION['password_reset_user_id'] = $user->id;
    $_SESSION['password_reset_identifier'] = $identifier;
    $_SESSION['password_reset_method'] = $method;
    $_SESSION['password_reset_otp'] = $otpRecord->otp; // For testing/debugging
    
    // Redirect to verification page
    header('Location: /forgot-password-verify.php');
    exit;
    
} catch (Exception $e) {
    \Illuminate\Support\Facades\Log::error('Forgot password error', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    header('Location: /forgot-password?error=' . urlencode('An error occurred: ' . $e->getMessage()));
    exit;
}
