<?php

namespace App\Jobs;

use App\Models\WhatsAppCampaign;
use App\Models\WhatsAppCampaignRecipient;
use App\Models\WhatsAppAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(WhatsAppCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get WhatsApp account from campaign or use default
        $account = $this->campaign->account;

        if (!$account) {
            // Fallback to default account if campaign doesn't have one
            $account = WhatsAppAccount::where('is_default', true)->where('is_active', true)->first();
        }

        if (!$account || !$account->is_active) {
            Log::error('No active WhatsApp account found for campaign', [
                'campaign_id' => $this->campaign->id,
                'account_id' => $this->campaign->account_id,
            ]);
            return;
        }

        $accessToken = $account->decrypted_token;
        $phoneNumberId = $account->phone_number_id;
        $apiVersion = $account->api_version;

        if (!$accessToken || !$phoneNumberId) {
            Log::error('WhatsApp credentials not configured for account', [
                'campaign_id' => $this->campaign->id,
                'account_id' => $account->id,
            ]);
            return;
        }

        // Get pending recipients
        $recipients = $this->campaign->recipients()
            ->where('status', 'pending')
            ->get();

        foreach ($recipients as $recipient) {
            // Check if campaign is paused
            $this->campaign->refresh();
            if ($this->campaign->status === 'paused') {
                Log::info('Campaign paused, stopping message sending', [
                    'campaign_id' => $this->campaign->id,
                ]);
                break;
            }

            try {
                // Prepare template message with personalized variables
                $messageData = $this->prepareTemplateMessage(
                    $recipient->phone_number,
                    $this->campaign->template,
                    $this->campaign->variable_values ?? [],
                    $recipient->user
                );

                // Log the message data being sent
                Log::info('Sending WhatsApp message', [
                    'campaign_id' => $this->campaign->id,
                    'recipient_id' => $recipient->id,
                    'phone' => $recipient->phone_number,
                    'template' => $this->campaign->template->name,
                    'message_data' => $messageData,
                ]);

                // Send message via WhatsApp Business API
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])->post("https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages", $messageData);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Update recipient status
                    $recipient->update([
                        'status' => 'sent',
                        'whatsapp_message_id' => $data['messages'][0]['id'] ?? null,
                        'sent_at' => now(),
                    ]);

                    // Update campaign sent count
                    $this->campaign->increment('sent_count');

                    Log::info('WhatsApp campaign message sent', [
                        'campaign_id' => $this->campaign->id,
                        'recipient_id' => $recipient->id,
                        'message_id' => $data['messages'][0]['id'] ?? null,
                    ]);

                } else {
                    $error = $response->json();
                    
                    // Update recipient as failed
                    $recipient->update([
                        'status' => 'failed',
                        'error_message' => $error['error']['message'] ?? 'Unknown error',
                    ]);

                    // Update campaign failed count
                    $this->campaign->increment('failed_count');

                    Log::error('WhatsApp campaign message failed', [
                        'campaign_id' => $this->campaign->id,
                        'recipient_id' => $recipient->id,
                        'error' => $error,
                    ]);
                }

                // Rate limiting: wait 1 second between messages
                sleep(1);

            } catch (\Exception $e) {
                // Update recipient as failed
                $recipient->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                // Update campaign failed count
                $this->campaign->increment('failed_count');

                Log::error('WhatsApp campaign message exception', [
                    'campaign_id' => $this->campaign->id,
                    'recipient_id' => $recipient->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Check if campaign is completed
        $pendingCount = $this->campaign->recipients()
            ->where('status', 'pending')
            ->count();

        if ($pendingCount === 0 && $this->campaign->status === 'running') {
            $this->campaign->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            Log::info('WhatsApp campaign completed', [
                'campaign_id' => $this->campaign->id,
                'sent' => $this->campaign->sent_count,
                'failed' => $this->campaign->failed_count,
            ]);
        }
    }

    /**
     * Prepare template message data
     */
    private function prepareTemplateMessage($phoneNumber, $template, $variableMapping, $user)
    {
        // Format phone number (ensure it has country code)
        $phone = $this->formatPhoneNumber($phoneNumber);

        // Prepare template components
        $components = [];

        // Body component with variables
        if (!empty($variableMapping)) {
            $parameters = [];
            foreach ($variableMapping as $mapping) {
                $value = '';

                // Get value based on type
                if ($mapping['type'] === 'user_field') {
                    // Get value from user object
                    $field = $mapping['value'];
                    if ($field && $user) {
                        $value = $user->$field ?? '';
                    }
                } elseif ($mapping['type'] === 'coupon') {
                    // Use coupon code directly
                    $value = $mapping['value'] ?? '';
                } elseif ($mapping['type'] === 'custom') {
                    // Use custom value directly
                    $value = $mapping['value'] ?? '';
                }

                // Skip empty values or add placeholder
                if (empty($value)) {
                    $value = '-'; // Placeholder for empty values
                }

                $parameters[] = [
                    'type' => 'text',
                    'text' => (string) $value,
                ];
            }

            if (!empty($parameters)) {
                $components[] = [
                    'type' => 'body',
                    'parameters' => $parameters,
                ];
            }
        }

        return [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'template',
            'template' => [
                'name' => $template->name,
                'language' => [
                    'code' => $template->language,
                ],
                'components' => $components,
            ],
        ];
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If doesn't start with country code, assume India (+91)
        if (!str_starts_with($phone, '91') && strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        return $phone;
    }
}

