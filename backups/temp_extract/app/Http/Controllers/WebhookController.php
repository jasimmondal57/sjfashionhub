<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\CommunicationSetting;

class WebhookController extends Controller
{
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

            // Process different message types
            switch ($type) {
                case 'text':
                    $text = $message['text']['body'] ?? '';
                    Log::info('WhatsApp text message', [
                        'from' => $from,
                        'text' => $text
                    ]);
                    // Handle text message (e.g., customer inquiry)
                    break;

                case 'image':
                    Log::info('WhatsApp image received', ['from' => $from]);
                    // Handle image
                    break;

                case 'document':
                    Log::info('WhatsApp document received', ['from' => $from]);
                    // Handle document
                    break;

                default:
                    Log::info('WhatsApp message type not handled', ['type' => $type]);
                    break;
            }
        }

        // Process message status updates
        if (isset($value['statuses'])) {
            foreach ($value['statuses'] as $status) {
                $messageId = $status['id'] ?? null;
                $statusType = $status['status'] ?? null;

                Log::info('WhatsApp message status update', [
                    'message_id' => $messageId,
                    'status' => $statusType
                ]);

                // Update message delivery status in your database
                // e.g., sent, delivered, read, failed
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

