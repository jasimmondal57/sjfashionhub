<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $apiKey;
    protected $senderId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.sms.api_key');
        $this->senderId = config('services.sms.sender_id', 'SJFASHION');
        $this->baseUrl = config('services.sms.base_url', 'https://api.textlocal.in/send/');
    }

    /**
     * Send OTP via SMS
     */
    public function sendOtp($phone, $otp)
    {
        $message = "Your SJ Fashion Hub login OTP is: {$otp}. Valid for 10 minutes. Do not share this code.";
        
        return $this->sendSms($phone, $message);
    }

    /**
     * Send SMS
     */
    public function sendSms($phone, $message)
    {
        try {
            // Format phone number (remove +91 if present, ensure 10 digits)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($phone) > 10) {
                $phone = substr($phone, -10);
            }

            // For demo purposes, log the SMS instead of actually sending
            if (config('app.env') === 'local') {
                Log::info("SMS to {$phone}: {$message}");
                return true;
            }

            // Textlocal API integration
            $response = Http::post($this->baseUrl, [
                'apikey' => $this->apiKey,
                'numbers' => $phone,
                'message' => $message,
                'sender' => $this->senderId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return isset($data['status']) && $data['status'] === 'success';
            }

            Log::error('SMS sending failed', [
                'phone' => $phone,
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('SMS service error', [
                'phone' => $phone,
                'message' => $message,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send order confirmation SMS
     */
    public function sendOrderConfirmation($phone, $orderNumber)
    {
        $message = "Your SJ Fashion Hub order #{$orderNumber} has been confirmed. Track your order at sjfashionhub.in";
        
        return $this->sendSms($phone, $message);
    }

    /**
     * Send order status update SMS
     */
    public function sendOrderUpdate($phone, $orderNumber, $status)
    {
        $message = "Your SJ Fashion Hub order #{$orderNumber} is now {$status}. Track at sjfashionhub.in";
        
        return $this->sendSms($phone, $message);
    }
}
