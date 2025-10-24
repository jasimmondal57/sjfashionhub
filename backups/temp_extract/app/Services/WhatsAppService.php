<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $accessToken;
    protected $phoneNumberId;
    protected $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.whatsapp.access_token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->baseUrl = config('services.whatsapp.base_url', 'https://graph.facebook.com/v18.0');
    }

    /**
     * Send OTP via WhatsApp
     */
    public function sendOtp($phone, $otp)
    {
        $message = "🔐 Your SJ Fashion Hub login OTP is: *{$otp}*\n\n⏰ Valid for 10 minutes\n🚫 Do not share this code\n\n👗 Happy Shopping!";
        
        return $this->sendMessage($phone, $message);
    }

    /**
     * Send WhatsApp message
     */
    public function sendMessage($phone, $message)
    {
        try {
            // Format phone number (add country code if not present)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (!str_starts_with($phone, '91') && strlen($phone) === 10) {
                $phone = '91' . $phone; // Add India country code
            }

            // For demo purposes, log the WhatsApp message instead of actually sending
            if (config('app.env') === 'local') {
                Log::info("WhatsApp to {$phone}: {$message}");
                return true;
            }

            // WhatsApp Business API integration
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json'
            ])->post("{$this->baseUrl}/{$this->phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('WhatsApp sending failed', [
                'phone' => $phone,
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp service error', [
                'phone' => $phone,
                'message' => $message,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send order confirmation via WhatsApp
     */
    public function sendOrderConfirmation($phone, $orderNumber, $amount)
    {
        $message = "🎉 *Order Confirmed!*\n\n📦 Order #: {$orderNumber}\n💰 Amount: ₹{$amount}\n\n🚚 We'll notify you when your order ships.\n\n👗 Thank you for shopping with SJ Fashion Hub!";
        
        return $this->sendMessage($phone, $message);
    }

    /**
     * Send order status update via WhatsApp
     */
    public function sendOrderUpdate($phone, $orderNumber, $status)
    {
        $statusEmojis = [
            'processing' => '⏳',
            'shipped' => '🚚',
            'delivered' => '✅',
            'cancelled' => '❌'
        ];

        $emoji = $statusEmojis[$status] ?? '📦';
        
        $message = "{$emoji} *Order Update*\n\n📦 Order #: {$orderNumber}\n📋 Status: " . ucfirst($status) . "\n\n🔗 Track your order: sjfashionhub.in/orders\n\n👗 SJ Fashion Hub";
        
        return $this->sendMessage($phone, $message);
    }

    /**
     * Send welcome message to new customers
     */
    public function sendWelcomeMessage($phone, $name)
    {
        $message = "🎉 Welcome to SJ Fashion Hub, {$name}!\n\n👗 Discover the latest fashion trends\n🛍️ Exclusive deals and offers\n🚚 Fast delivery across India\n\n🔗 Start shopping: sjfashionhub.in\n\nHappy Shopping! 💫";
        
        return $this->sendMessage($phone, $message);
    }
}
