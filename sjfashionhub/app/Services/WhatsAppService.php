<?php

namespace App\Services;

use App\Models\WhatsAppTemplate;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppConversation;
use App\Models\CommunicationSetting;
use App\Models\User;
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
     * Send OTP via WhatsApp using approved template
     */
    public function sendOtp($phone, $otp)
    {
        // Try to find approved OTP template
        $template = WhatsAppTemplate::where('category', 'AUTHENTICATION')
            ->where('status', 'approved')
            ->where(function($query) {
                $query->where('name', 'like', '%otp%')
                      ->orWhere('name', 'like', '%login%')
                      ->orWhere('name', 'like', '%verification%');
            })
            ->first();

        // If approved template exists, use it
        if ($template) {
            return $this->sendTemplateMessage($phone, $template->name, [$otp]);
        }

        // Fallback to regular message if no approved template
        $message = "🔐 Your SJ Fashion Hub login OTP is: *{$otp}*\n\n⏰ Valid for 10 minutes\n🚫 Do not share this code\n\n👗 Happy Shopping!";

        return $this->sendMessage($phone, $message);
    }

    /**
     * Send WhatsApp template message
     */
    public function sendTemplateMessage($phone, $templateName, $parameters = [])
    {
        try {
            // Format phone number (add country code if not present)
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (!str_starts_with($phone, '91') && strlen($phone) === 10) {
                $phone = '91' . $phone; // Add India country code
            }

            // Log the WhatsApp message for debugging
            Log::info("WhatsApp Template to {$phone}: Template={$templateName}, Parameters=" . json_encode($parameters));

            // Get WhatsApp settings - use decrypted values
            $settings = CommunicationSetting::where('provider', 'whatsapp')
                ->where('service', 'whatsapp_business')
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->decrypted_value];
                });

            $accessToken = $settings['api_key'] ?? $this->accessToken;
            $phoneNumberId = $settings['phone_number'] ?? $this->phoneNumberId;
            $apiVersion = $settings['api_version'] ?? 'v18.0';

            if (!$accessToken || !$phoneNumberId) {
                Log::error('WhatsApp credentials not configured');
                return false;
            }

            // Get template details to check if it's AUTHENTICATION category
            $template = WhatsAppTemplate::where('name', $templateName)->first();

            // Prepare template components
            $components = [];
            if (!empty($parameters)) {
                $bodyParameters = [];
                foreach ($parameters as $param) {
                    $bodyParameters[] = [
                        'type' => 'text',
                        'text' => (string)$param
                    ];
                }

                $components[] = [
                    'type' => 'body',
                    'parameters' => $bodyParameters
                ];

                // For AUTHENTICATION templates, also add button parameters
                if ($template && $template->category === 'AUTHENTICATION') {
                    // The OTP button needs the OTP code as parameter
                    $components[] = [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => (string)$parameters[0] // OTP code
                            ]
                        ]
                    ];
                }
            }

            // WhatsApp Business API integration
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post("https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => 'en'
                    ],
                    'components' => $components
                ]
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp template sent successfully', [
                    'phone' => $phone,
                    'template' => $templateName
                ]);

                // Log to database
                $responseData = $response->json();
                $this->logMessage([
                    'message_id' => $responseData['messages'][0]['id'] ?? null,
                    'wamid' => $responseData['messages'][0]['id'] ?? null,
                    'direction' => 'outbound',
                    'type' => 'template',
                    'status' => 'sent',
                    'phone_number' => $phone,
                    'template_name' => $templateName,
                    'content' => "Template: {$templateName}",
                    'parameters' => $parameters,
                    'sent_at' => now(),
                ]);

                return $responseData;
            }

            Log::error('WhatsApp template sending failed', [
                'phone' => $phone,
                'template' => $templateName,
                'response' => $response->body()
            ]);

            // Log failed message
            $this->logMessage([
                'direction' => 'outbound',
                'type' => 'template',
                'status' => 'failed',
                'phone_number' => $phone,
                'template_name' => $templateName,
                'content' => "Template: {$templateName}",
                'parameters' => $parameters,
                'error_message' => $response->body(),
                'failed_at' => now(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp template service error', [
                'phone' => $phone,
                'template' => $templateName,
                'error' => $e->getMessage()
            ]);

            return false;
        }
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

            // Log the WhatsApp message for debugging
            Log::info("WhatsApp to {$phone}: {$message}");

            // Get WhatsApp settings - use decrypted values
            $settings = CommunicationSetting::where('provider', 'whatsapp')
                ->where('service', 'whatsapp_business')
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->decrypted_value];
                });

            $accessToken = $settings['api_key'] ?? $this->accessToken;
            $phoneNumberId = $settings['phone_number'] ?? $this->phoneNumberId;
            $apiVersion = $settings['api_version'] ?? 'v18.0';

            if (!$accessToken || !$phoneNumberId) {
                Log::error('WhatsApp credentials not configured');
                return false;
            }

            // WhatsApp Business API integration
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post("https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                // Log to database
                $responseData = $response->json();
                $this->logMessage([
                    'message_id' => $responseData['messages'][0]['id'] ?? null,
                    'wamid' => $responseData['messages'][0]['id'] ?? null,
                    'direction' => 'outbound',
                    'type' => 'text',
                    'status' => 'sent',
                    'phone_number' => $phone,
                    'category' => 'support',
                    'content' => $message,
                    'sent_at' => now(),
                ]);

                return $responseData;
            }

            Log::error('WhatsApp sending failed', [
                'phone' => $phone,
                'response' => $response->body()
            ]);

            // Log failed message
            $this->logMessage([
                'direction' => 'outbound',
                'type' => 'text',
                'status' => 'failed',
                'phone_number' => $phone,
                'category' => 'support',
                'content' => $message,
                'error_message' => $response->body(),
                'failed_at' => now(),
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

    /**
     * Log WhatsApp message to database
     */
    protected function logMessage(array $data)
    {
        try {
            // Find or create conversation
            $conversation = WhatsAppConversation::firstOrCreate(
                ['phone_number' => $data['phone_number']],
                [
                    'status' => 'open',
                    'last_message_at' => now(),
                ]
            );

            // Find user by phone if exists
            $user = User::where('phone', $data['phone_number'])
                ->orWhere('phone', '+' . $data['phone_number'])
                ->orWhere('phone', preg_replace('/^91/', '', $data['phone_number']))
                ->first();

            if ($user) {
                $conversation->update([
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                ]);
                $data['user_id'] = $user->id;
            }

            // Determine category from template name or context
            if (!isset($data['category'])) {
                $data['category'] = $this->determineCategoryFromTemplate($data['template_name'] ?? null);
            }

            // Create message log
            $message = WhatsAppMessage::create($data);

            // Update conversation
            if ($data['direction'] === 'inbound') {
                $conversation->incrementUnread();
            }
            $conversation->updateLastMessage($message);

            return $message;
        } catch (\Exception $e) {
            Log::error('Failed to log WhatsApp message: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Determine message category from template name
     */
    protected function determineCategoryFromTemplate($templateName)
    {
        if (!$templateName) {
            return 'notification';
        }

        if (str_contains($templateName, 'otp') || str_contains($templateName, 'login')) {
            return 'otp';
        }

        if (str_contains($templateName, 'order') || str_contains($templateName, 'shipping')) {
            return 'order';
        }

        if (str_contains($templateName, 'marketing') || str_contains($templateName, 'promo')) {
            return 'marketing';
        }

        return 'notification';
    }
}
