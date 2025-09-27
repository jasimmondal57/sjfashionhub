<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'otp',
        'type',
        'purpose',
        'is_verified',
        'expires_at',
        'attempts'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Generate a new OTP for the given phone number
     */
    public static function generateOtp($phone, $type = 'sms', $purpose = 'login')
    {
        // Delete any existing unverified OTPs for this phone
        static::where('phone', $phone)
            ->where('is_verified', false)
            ->delete();

        // Generate 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return static::create([
            'phone' => $phone,
            'otp' => $otp,
            'type' => $type,
            'purpose' => $purpose,
            'expires_at' => Carbon::now()->addMinutes(10), // 10 minutes expiry
        ]);
    }

    /**
     * Verify OTP
     */
    public static function verifyOtp($phone, $otp)
    {
        $verification = static::where('phone', $phone)
            ->where('otp', $otp)
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($verification) {
            $verification->update([
                'is_verified' => true
            ]);
            return true;
        }

        // Increment attempts for failed verification
        static::where('phone', $phone)
            ->where('otp', $otp)
            ->increment('attempts');

        return false;
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Check if too many attempts
     */
    public function tooManyAttempts()
    {
        return $this->attempts >= 3;
    }
}
