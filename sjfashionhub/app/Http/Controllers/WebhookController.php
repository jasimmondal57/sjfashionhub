<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CommunicationSetting;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppConversation;
use App\Models\User;
use App\Services\WhatsAppCommerceService;

class WebhookController extends Controller
{
    protected $commerceService;

    public function __construct(WhatsAppCommerceService $commerceService)
    {
        $this->commerceService = $commerceService;
    }
    /**
     * Handle WhatsApp Business API webhook verification (GET request)
     */
    public function verifyWhatsApp(Request $request)
    {
        // Get verification parameters from Meta
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        Log::info('WhatsApp webhook verification attempt', [
            'mode' => $mode,
            'token' => $token,
            'challenge' => $challenge
        ]);

        // Get stored verify token from settings
        $storedToken = CommunicationSetting::get('whatsapp', 'whatsapp_business', 'webhook_verify_token');

        // Check if mode and token are correct
        if ($mode === 'subscribe' && $token === $storedToken) {
            Log::info('WhatsApp webhook verified successfully');
            
            // Respond with challenge to complete verification
            return response($challenge, 200)
                ->header('Content-Type', 'text/plain');
        }

        Log::warning('WhatsApp webhook verification failed', [
            'expected_token' => $storedToken,
            'received_token' => $token
        ]);

        // Verification failed
        return response('Forbidden', 403);
    }

    /**
     * Handle WhatsApp Business API webhook events (POST request)
     */
    public function handleWhatsApp(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('WhatsApp webhook received', [
                'data' => $data
            ]);

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

            // Always return 200 OK to acknowledge receipt
            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('WhatsApp webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Still return 200 to prevent Meta from retrying
            return response()->json(['status' => 'error'], 200);
        }
    }

    /**
     * Process incoming WhatsApp message
     */
    private function processMessage($value)
    {
        if (!isset($value['messages'])) {
            return;
        }

        foreach ($value['messages'] as $message) {
            $from = $message['from'] ?? null;
            $messageId = $message['id'] ?? null;
            $timestamp = $message['timestamp'] ?? null;
            $type = $message['type'] ?? 'unknown';

            Log::info('WhatsApp message received', [
                'from' => $from,
                'message_id' => $messageId,
                'type' => $type,
                'timestamp' => $timestamp
            ]);

            // Find or create conversation
            $conversation = WhatsAppConversation::firstOrCreate(
                ['phone_number' => $from],
                [
                    'status' => 'open',
                    'last_message_at' => now(),
                    'customer_name' => $value['contacts'][0]['profile']['name'] ?? null
                ]
            );

            // Find user by phone
            $user = User::where('phone', $from)->first();

            // Get contact name
            $contactName = $value['contacts'][0]['profile']['name'] ?? null;

            // Process different message types
            $content = '';
            switch ($type) {
                case 'text':
                    $content = $message['text']['body'] ?? '';
                    Log::info('WhatsApp text message', [
                        'from' => $from,
                        'text' => $content
                    ]);

                    // Call commerce service to handle the message
                    $this->commerceService->handleTextMessage($from, $content, $contactName, $messageId);
                    break;

                case 'interactive':
                    $content = 'Interactive message received';
                    Log::info('WhatsApp interactive message', ['from' => $from]);

                    // Handle interactive messages (button/list replies)
                    if (isset($message['interactive'])) {
                        $interactive = $message['interactive'];
                        $interactiveType = $interactive['type'] ?? null;

                        if ($interactiveType === 'button_reply') {
                            $buttonReply = $interactive['button_reply'];
                            $selectedId = $buttonReply['id'];
                            $this->commerceService->handleButtonReply($from, $selectedId, $contactName, $messageId);
                        } elseif ($interactiveType === 'list_reply') {
                            $listReply = $interactive['list_reply'];
                            $selectedId = $listReply['id'];
                            $this->commerceService->handleListReply($from, $selectedId, $contactName, $messageId);
                        }
                    }
                    break;

                case 'order':
                    $content = 'Order received from catalog';
                    Log::info('WhatsApp catalog order', ['from' => $from]);

                    // Handle catalog orders
                    if (isset($message['order'])) {
                        $order = $message['order'];
                        $productItems = $order['product_items'] ?? [];
                        $this->commerceService->handleCatalogOrder($from, $productItems, $contactName, $messageId);
                    }
                    break;

                case 'button':
                    $content = 'Button clicked';
                    $buttonPayload = $message['button']['payload'] ?? '';
                    Log::info('WhatsApp button click', ['from' => $from, 'payload' => $buttonPayload]);

                    // Handle button clicks
                    $this->commerceService->handleButtonClick($from, $buttonPayload, $contactName, $messageId);
                    break;

                case 'image':
                    $content = 'Image received';
                    Log::info('WhatsApp image received', ['from' => $from]);
                    break;

                case 'document':
                    $content = 'Document received';
                    Log::info('WhatsApp document received', ['from' => $from]);
                    break;

                default:
                    $content = ucfirst($type) . ' message received';
                    Log::info('WhatsApp message type not handled', ['type' => $type]);
                    break;
            }

            // Save incoming message to database
            $whatsappMessage = WhatsAppMessage::create([
                'wamid' => $messageId,
                'message_id' => $messageId,
                'direction' => 'inbound',
                'type' => $type,
                'status' => 'received',
                'phone_number' => $from,
                'user_id' => $user?->id,
                'category' => 'support',
                'content' => $content,
                'metadata' => $message,
                'sent_at' => $timestamp ? date('Y-m-d H:i:s', $timestamp) : now(),
                'delivered_at' => now(),
            ]);

            // Update conversation
            $conversation->updateLastMessage($whatsappMessage);
            $conversation->incrementUnread();
        }

        // Process message status updates
        if (isset($value['statuses'])) {
            foreach ($value['statuses'] as $status) {
                $messageId = $status['id'] ?? null;
                $statusType = $status['status'] ?? null;
                $timestamp = $status['timestamp'] ?? null;

                Log::info('WhatsApp message status update', [
                    'message_id' => $messageId,
                    'status' => $statusType,
                    'timestamp' => $timestamp
                ]);

                // Update message delivery status in database
                if ($messageId && $statusType) {
                    $updateData = ['status' => $statusType];

                    // Set timestamp based on status
                    if ($statusType === 'sent') {
                        $updateData['sent_at'] = $timestamp ? date('Y-m-d H:i:s', $timestamp) : now();
                    } elseif ($statusType === 'delivered') {
                        $updateData['delivered_at'] = $timestamp ? date('Y-m-d H:i:s', $timestamp) : now();
                    } elseif ($statusType === 'read') {
                        $updateData['read_at'] = $timestamp ? date('Y-m-d H:i:s', $timestamp) : now();
                    } elseif ($statusType === 'failed') {
                        $updateData['failed_at'] = $timestamp ? date('Y-m-d H:i:s', $timestamp) : now();
                        $updateData['error_message'] = $status['errors'][0]['title'] ?? 'Message failed';
                    }

                    WhatsAppMessage::where('wamid', $messageId)
                        ->orWhere('message_id', $messageId)
                        ->update($updateData);

                    Log::info('WhatsApp message status updated in database', [
                        'message_id' => $messageId,
                        'status' => $statusType
                    ]);
                }
            }
        }
    }

    /**
     * Handle Twilio WhatsApp webhook
     */
    public function handleTwilioWhatsApp(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('Twilio WhatsApp webhook received', [
                'data' => $data
            ]);

            $from = $request->input('From');
            $body = $request->input('Body');
            $messageId = $request->input('MessageSid');
            $status = $request->input('MessageStatus');

            Log::info('Twilio WhatsApp message', [
                'from' => $from,
                'body' => $body,
                'message_id' => $messageId,
                'status' => $status
            ]);

            // Process Twilio message
            // You can add auto-reply logic here

            return response('', 200);

        } catch (\Exception $e) {
            Log::error('Twilio WhatsApp webhook error', [
                'error' => $e->getMessage()
            ]);

            return response('', 200);
        }
    }

    /**
     * Handle MSG91 WhatsApp webhook
     */
    public function handleMsg91WhatsApp(Request $request)
    {
        try {
            $data = $request->all();

            Log::info('MSG91 WhatsApp webhook received', [
                'data' => $data
            ]);

            // Process MSG91 webhook data
            // MSG91 sends delivery reports and incoming messages

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('MSG91 WhatsApp webhook error', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['status' => 'error'], 200);
        }
    }
}

