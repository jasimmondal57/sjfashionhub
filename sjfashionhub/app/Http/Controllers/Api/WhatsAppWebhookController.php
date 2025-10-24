<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppCommerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    protected $commerceService;

    public function __construct(WhatsAppCommerceService $commerceService)
    {
        $this->commerceService = $commerceService;
    }

    /**
     * Verify webhook (GET request from Meta)
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        // Get verification token from settings
        $verifyToken = config('services.whatsapp.webhook_verify_token', 'sjfashion_webhook_2024');

        if ($mode === 'subscribe' && $token === $verifyToken) {
            Log::info('WhatsApp webhook verified successfully');
            return response($challenge, 200)->header('Content-Type', 'text/plain');
        }

        Log::warning('WhatsApp webhook verification failed', [
            'mode' => $mode,
            'token' => $token
        ]);

        return response('Forbidden', 403);
    }

    /**
     * Handle incoming webhook messages (POST request from Meta)
     */
    public function handle(Request $request)
    {
        try {
            $data = $request->all();
            
            Log::info('WhatsApp webhook received', ['data' => $data]);

            // Verify the request is from Meta
            if (!$this->verifySignature($request)) {
                Log::warning('Invalid webhook signature');
                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
            }

            // Process webhook data
            if (isset($data['entry'])) {
                foreach ($data['entry'] as $entry) {
                    if (isset($entry['changes'])) {
                        foreach ($entry['changes'] as $change) {
                            if ($change['field'] === 'messages') {
                                $this->processMessage($change['value']);
                            }
                        }
                    }
                }
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('WhatsApp webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Process incoming message
     */
    protected function processMessage($value)
    {
        try {
            // Extract message data
            $messages = $value['messages'] ?? [];
            $contacts = $value['contacts'] ?? [];

            foreach ($messages as $message) {
                $from = $message['from']; // Phone number
                $messageId = $message['id'];
                $timestamp = $message['timestamp'];
                $type = $message['type']; // text, interactive, order, etc.

                // Get contact name
                $contactName = null;
                foreach ($contacts as $contact) {
                    if ($contact['wa_id'] === $from) {
                        $contactName = $contact['profile']['name'] ?? null;
                        break;
                    }
                }

                Log::info('Processing WhatsApp message', [
                    'from' => $from,
                    'type' => $type,
                    'message_id' => $messageId
                ]);

                // Handle different message types
                switch ($type) {
                    case 'text':
                        $text = $message['text']['body'] ?? '';
                        $this->commerceService->handleTextMessage($from, $text, $contactName, $messageId);
                        break;

                    case 'interactive':
                        $this->handleInteractiveMessage($from, $message['interactive'], $contactName, $messageId);
                        break;

                    case 'order':
                        $this->handleOrderMessage($from, $message['order'], $contactName, $messageId);
                        break;

                    case 'button':
                        $buttonPayload = $message['button']['payload'] ?? '';
                        $this->commerceService->handleButtonClick($from, $buttonPayload, $contactName, $messageId);
                        break;

                    default:
                        Log::info('Unsupported message type', ['type' => $type]);
                }

                // Mark message as read
                $this->markMessageAsRead($messageId);
            }

        } catch (\Exception $e) {
            Log::error('Error processing WhatsApp message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Handle interactive message (list reply, button reply)
     */
    protected function handleInteractiveMessage($from, $interactive, $contactName, $messageId)
    {
        $type = $interactive['type']; // list_reply, button_reply

        if ($type === 'list_reply') {
            $listReply = $interactive['list_reply'];
            $selectedId = $listReply['id'];
            $this->commerceService->handleListReply($from, $selectedId, $contactName, $messageId);
        } elseif ($type === 'button_reply') {
            $buttonReply = $interactive['button_reply'];
            $selectedId = $buttonReply['id'];
            $this->commerceService->handleButtonReply($from, $selectedId, $contactName, $messageId);
        }
    }

    /**
     * Handle order message from WhatsApp catalog
     */
    protected function handleOrderMessage($from, $order, $contactName, $messageId)
    {
        try {
            $catalogId = $order['catalog_id'] ?? null;
            $productItems = $order['product_items'] ?? [];

            Log::info('WhatsApp order received', [
                'from' => $from,
                'catalog_id' => $catalogId,
                'items_count' => count($productItems)
            ]);

            $this->commerceService->handleCatalogOrder($from, $productItems, $contactName, $messageId);

        } catch (\Exception $e) {
            Log::error('Error handling WhatsApp order', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Mark message as read
     */
    protected function markMessageAsRead($messageId)
    {
        try {
            $phoneNumberId = config('services.whatsapp.phone_number_id');
            $accessToken = config('services.whatsapp.access_token');

            if (!$phoneNumberId || !$accessToken) {
                return;
            }

            \Http::withToken($accessToken)
                ->post("https://graph.facebook.com/v18.0/{$phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'status' => 'read',
                    'message_id' => $messageId
                ]);

        } catch (\Exception $e) {
            Log::error('Failed to mark message as read', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Verify webhook signature from Meta
     */
    protected function verifySignature(Request $request)
    {
        // For now, skip signature verification in development
        // In production, you should verify the X-Hub-Signature-256 header
        
        $signature = $request->header('X-Hub-Signature-256');
        
        if (!$signature) {
            // Allow requests without signature for testing
            return true;
        }

        $appSecret = config('services.whatsapp.app_secret');
        
        if (!$appSecret) {
            return true; // Skip verification if no app secret configured
        }

        $payload = $request->getContent();
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $appSecret);

        return hash_equals($expectedSignature, $signature);
    }
}

