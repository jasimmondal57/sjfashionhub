<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Models\CommunicationSetting;
use App\Notifications\OtpNotification;
use App\Services\MailConfigService;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'type',
        'otp',
        'purpose',
        'method',
        'expires_at',
        'verified',
        'verified_at',
        'attempts',
        'metadata',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'verified' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Generate and send OTP
     */
    public static function generateAndSend($identifier, $type, $purpose, $method = null, $metadata = null)
    {
        // Generate 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        // Determine best method if not specified
        if (!$method) {
            $method = self::getBestDeliveryMethod($type);
        }

        // Create OTP record
        $otpRecord = self::create([
            'identifier' => $identifier,
            'type' => $type,
            'otp' => $otp,
            'purpose' => $purpose,
            'method' => $method,
            'expires_at' => now()->addMinutes(10), // 10 minutes expiry
            'metadata' => $metadata,
        ]);

        // Send OTP
        $sent = self::sendOtp($identifier, $otp, $method, $purpose);

        if (!$sent) {
            $otpRecord->delete();
            return false;
        }

        return $otpRecord;
    }

    /**
     * Verify OTP
     */
    public static function verify($identifier, $otp, $purpose)
    {
        $otpRecord = self::where('identifier', $identifier)
            ->where('otp', $otp)
            ->where('purpose', $purpose)
            ->where('verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return false;
        }

        // Check attempts limit
        if ($otpRecord->attempts >= 3) {
            return false;
        }

        // Increment attempts
        $otpRecord->increment('attempts');

        // Mark as verified
        $otpRecord->update([
            'verified' => true,
            'verified_at' => now(),
        ]);

        return $otpRecord;
    }

    /**
     * Get best delivery method based on available services
     */
    private static function getBestDeliveryMethod($type)
    {
        if ($type === 'email') {
            return 'email';
        }

        // For phone, check available services
        $smsEnabled = CommunicationSetting::where('provider', 'sms')
            ->where('is_active', true)
            ->exists();

        $whatsappEnabled = CommunicationSetting::where('provider', 'whatsapp')
            ->where('is_active', true)
            ->exists();

        if ($whatsappEnabled) {
            return 'whatsapp';
        } elseif ($smsEnabled) {
            return 'sms';
        }

        return 'sms'; // fallback
    }

    /**
     * Send OTP via specified method
     */
    private static function sendOtp($identifier, $otp, $method, $purpose)
    {
        try {
            $message = self::getOtpMessage($otp, $purpose);

            switch ($method) {
                case 'sms':
                    return self::sendSms($identifier, $message);
                case 'whatsapp':
                    return self::sendWhatsApp($identifier, $message);
                case 'email':
                    return self::sendEmail($identifier, $message, $purpose);
                default:
                    return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send OTP: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate OTP message
     */
    private static function getOtpMessage($otp, $purpose)
    {
        $purposeText = [
            'registration' => 'complete your registration',
            'login' => 'login to your account',
            'password_reset' => 'reset your password',
        ];

        return "Your SJ Fashion Hub OTP is: {$otp}. Use this code to {$purposeText[$purpose]}. Valid for 10 minutes. Do not share this code.";
    }

    /**
     * Send SMS
     */
    private static function sendSms($phone, $message)
    {
        // Implementation would use your SMS service
        // For now, just log it
        Log::info("SMS OTP sent to {$phone}: {$message}");
        return true;
    }

    /**
     * Send WhatsApp
     */
    private static function sendWhatsApp($phone, $message)
    {
        // Implementation would use your WhatsApp service
        // For now, just log it
        Log::info("WhatsApp OTP sent to {$phone}: {$message}");
        return true;
    }

    /**
     * Send Email
     */
    private static function sendEmail($email, $message, $purpose)
    {
        try {
            // Configure mail settings from database
            MailConfigService::configure();

            // Extract OTP from message
            preg_match('/OTP is: (\d{6})/', $message, $matches);
            $otp = $matches[1] ?? '000000';

            // Create a temporary notifiable object
            $notifiable = new class($email) {
                public $email;
                public function __construct($email) {
                    $this->email = $email;
                }
                public function routeNotificationFor($driver) {
                    return $this->email;
                }
            };

            // Send notification
            Notification::send($notifiable, new OtpNotification($otp, $purpose));

            Log::info("Email OTP sent to {$email}: {$otp}");
            return true;

        } catch (\Exception $e) {
            Log::error("Failed to send email OTP to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Clean expired OTPs
     */
    public static function cleanExpired()
    {
        self::where('expires_at', '<', now())->delete();
    }
}
