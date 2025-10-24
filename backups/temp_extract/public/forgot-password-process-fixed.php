<?php
// Proper Laravel bootstrap for standalone PHP files
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Properly initialize Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Now Laravel is fully initialized
try {
    // Get form data
    $method = $_POST['method'] ?? 'email';
    $identifier = $_POST['identifier'] ?? '';
    
    if (empty($identifier)) {
        throw new Exception('Please enter your email or phone number.');
    }
    
    // Find user
    $user = null;
    if ($method === 'email') {
        $user = App\Models\User::where('email', $identifier)->first();
    } else {
        $user = App\Models\User::where('phone', $identifier)
                   ->orWhere('phone', 'LIKE', '%' . $identifier)
                   ->first();
    }
    
    if (!$user) {
        throw new Exception('No account found with this ' . ($method === 'email' ? 'email' : 'phone number') . '.');
    }
    
    // Generate and send OTP
    $otpRecord = App\Models\UserOtp::generateAndSend(
        $identifier, 
        $method, 
        'password_reset', 
        $user->id
    );
    
    if (!$otpRecord) {
        throw new Exception('Failed to send verification code. Please try again.');
    }
    
    // Store in session for verification
    session_start();
    $_SESSION['password_reset_user_id'] = $user->id;
    $_SESSION['password_reset_identifier'] = $identifier;
    $_SESSION['password_reset_method'] = $method;
    
    // Redirect to OTP verification
    header('Location: forgot-password-verify.php');
    exit;
    
} catch (Exception $e) {
    $error = $e->getMessage();
    header('Location: forgot-password-test.php?error=' . urlencode($error));
    exit;
}
?>
