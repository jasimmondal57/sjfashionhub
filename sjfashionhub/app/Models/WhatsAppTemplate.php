<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'account_id',
        'name',
        'display_name',
        'category',
        'language',
        'header_text',
        'header_type',
        'body_text',
        'footer_text',
        'buttons',
        'variables',
        'variable_samples',
        'status',
        'whatsapp_template_id',
        'last_synced_at',
        'rejection_reason',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'buttons' => 'array',
        'variables' => 'array',
        'variable_samples' => 'array',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    /**
     * Get the WhatsApp account for this template
     */
    public function account()
    {
        return $this->belongsTo(WhatsAppAccount::class, 'account_id');
    }

    /**
     * Get campaigns using this template
     */
    public function campaigns()
    {
        return $this->hasMany(WhatsAppCampaign::class, 'template_id');
    }

    /**
     * Submit template to WhatsApp for approval
     */
    public function submitToWhatsApp()
    {
        try {
            // Get WhatsApp settings - use decrypted values
            $settings = CommunicationSetting::where('provider', 'whatsapp')
                ->where('service', 'whatsapp_business')
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->decrypted_value];
                });

            $accessToken = $settings['api_key'] ?? null;
            $businessAccountId = $settings['business_account_id'] ?? null;
            $apiVersion = $settings['api_version'] ?? 'v18.0';

            if (!$accessToken || !$businessAccountId) {
                throw new \Exception('WhatsApp Business API credentials not configured');
            }

            // Prepare template components
            $components = [];

            // AUTHENTICATION templates use OTP type with autofill button
            if ($this->category === 'AUTHENTICATION') {
                // For AUTHENTICATION category, use the OTP type format
                // Get OTP code sample from variable_samples
                $otpSample = '123456'; // default
                if ($this->variable_samples && is_array($this->variable_samples)) {
                    $samples = array_values($this->variable_samples);
                    if (!empty($samples[0])) {
                        $otpSample = $samples[0];
                    }
                }

                $components[] = [
                    'type' => 'BODY',
                    'add_security_recommendation' => true,
                ];

                // Add button with autofill for OTP
                $components[] = [
                    'type' => 'BUTTONS',
                    'buttons' => [
                        [
                            'type' => 'OTP',
                            'otp_type' => 'COPY_CODE',
                            'text' => 'Copy code',
                        ]
                    ]
                ];

                // Add footer with OTP example
                $components[] = [
                    'type' => 'FOOTER',
                    'code_expiration_minutes' => 10,
                ];

            } else {
                // For non-AUTHENTICATION templates, use the standard structure

                // Header component
                if ($this->header_text) {
                    $headerComponent = [
                        'type' => 'HEADER',
                        'format' => $this->header_type ?? 'TEXT',
                        'text' => $this->header_text,
                    ];

                    // Add example values for header variables if any
                    if ($this->variable_samples && is_array($this->variable_samples)) {
                        // Check if header has variables
                        preg_match_all('/\{\{(\d+)\}\}/', $this->header_text, $headerMatches);
                        if (!empty($headerMatches[1])) {
                            $headerSamples = [];
                            foreach ($headerMatches[1] as $varNum) {
                                $index = (int)$varNum - 1;
                                if (isset($this->variable_samples[$index])) {
                                    $headerSamples[] = $this->variable_samples[$index];
                                }
                            }
                            if (!empty($headerSamples)) {
                                $headerComponent['example'] = [
                                    'header_text' => $headerSamples
                                ];
                            }
                        }
                    }

                    $components[] = $headerComponent;
                }

                // Body component (with variable samples if provided)
                $bodyComponent = [
                    'type' => 'BODY',
                    'text' => $this->body_text,
                ];

                // Add example values for variables if provided
                if ($this->variable_samples && is_array($this->variable_samples) && count($this->variable_samples) > 0) {
                    $bodyComponent['example'] = [
                        'body_text' => [array_values($this->variable_samples)]
                    ];
                }

                $components[] = $bodyComponent;
            }

            // Footer component (NOT allowed for AUTHENTICATION templates)
            if ($this->footer_text && $this->category !== 'AUTHENTICATION') {
                $components[] = [
                    'type' => 'FOOTER',
                    'text' => $this->footer_text,
                ];
            }

            // Buttons component
            if ($this->buttons && is_array($this->buttons) && count($this->buttons) > 0) {
                $buttonsArray = [];
                foreach ($this->buttons as $button) {
                    if (isset($button['type']) && isset($button['text'])) {
                        $buttonData = [
                            'type' => $button['type'],
                            'text' => $button['text'],
                        ];

                        // Add URL for URL type buttons
                        if ($button['type'] === 'URL' && isset($button['url'])) {
                            $buttonData['url'] = $button['url'];
                        }

                        // Add phone number for PHONE_NUMBER type buttons
                        if ($button['type'] === 'PHONE_NUMBER' && isset($button['phone_number'])) {
                            $buttonData['phone_number'] = $button['phone_number'];
                        }

                        $buttonsArray[] = $buttonData;
                    }
                }

                if (count($buttonsArray) > 0) {
                    $components[] = [
                        'type' => 'BUTTONS',
                        'buttons' => $buttonsArray,
                    ];
                }
            }

            // Prepare request payload
            $payload = [
                'name' => $this->name,
                'language' => $this->language,
                'category' => $this->category,
                'components' => $components,
            ];

            // Log the full request for debugging
            Log::info('WhatsApp template submission request', [
                'template_id' => $this->id,
                'payload' => $payload,
                'payload_json' => json_encode($payload, JSON_PRETTY_PRINT),
            ]);

            // Submit to WhatsApp
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post("https://graph.facebook.com/{$apiVersion}/{$businessAccountId}/message_templates", $payload);

            if ($response->successful()) {
                $data = $response->json();

                $this->update([
                    'status' => 'pending',
                    'whatsapp_template_id' => $data['id'] ?? null,
                    'submitted_at' => now(),
                ]);

                Log::info('WhatsApp template submitted successfully', [
                    'template_id' => $this->id,
                    'whatsapp_template_id' => $data['id'] ?? null,
                ]);

                return [
                    'success' => true,
                    'message' => 'Template submitted to WhatsApp for approval',
                    'template_id' => $data['id'] ?? null
                ];
            }

            $error = $response->json();
            $errorMessage = 'Failed to submit template';

            if (isset($error['error']['message'])) {
                $errorMessage = $error['error']['message'];
            } elseif (isset($error['error']['error_user_msg'])) {
                $errorMessage = $error['error']['error_user_msg'];
            } elseif (isset($error['message'])) {
                $errorMessage = $error['message'];
            }

            Log::error('WhatsApp template submission failed', [
                'template_id' => $this->id,
                'status_code' => $response->status(),
                'error' => $error,
                'request_data' => [
                    'name' => $this->name,
                    'language' => $this->language,
                    'category' => $this->category,
                    'components' => $components,
                ],
            ]);

            return [
                'success' => false,
                'message' => $errorMessage . ' (Status: ' . $response->status() . ')',
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp template submission error', [
                'template_id' => $this->id,
                'error' => $e->getMessage(),
            ]);

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Check template status from WhatsApp
     */
    public function checkStatus()
    {
        try {
            if (!$this->whatsapp_template_id) {
                return ['success' => false, 'message' => 'Template not submitted to WhatsApp'];
            }

            // Get WhatsApp settings - use decrypted values
            $settings = CommunicationSetting::where('provider', 'whatsapp')
                ->where('service', 'whatsapp_business')
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->decrypted_value];
                });

            $accessToken = $settings['api_key'] ?? null;
            $apiVersion = $settings['api_version'] ?? 'v18.0';

            if (!$accessToken) {
                throw new \Exception('WhatsApp Business API credentials not configured');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get("https://graph.facebook.com/{$apiVersion}/{$this->whatsapp_template_id}");

            if ($response->successful()) {
                $data = $response->json();
                $status = strtolower($data['status'] ?? 'pending');

                // Log the full response for debugging
                Log::info('WhatsApp template status check response', [
                    'template_id' => $this->id,
                    'status' => $status,
                    'full_response' => $data,
                ]);

                // Update local status
                $updateData = ['status' => $status];

                if ($status === 'approved') {
                    $updateData['approved_at'] = now();
                } elseif ($status === 'rejected') {
                    // Try multiple possible fields for rejection reason
                    $rejectionReason = $data['rejected_reason']
                        ?? $data['rejection_reason']
                        ?? $data['quality_score']['reasons'][0] ?? null;

                    if ($rejectionReason && is_array($rejectionReason)) {
                        $rejectionReason = json_encode($rejectionReason);
                    }

                    $updateData['rejection_reason'] = $rejectionReason ?? 'No specific reason provided by WhatsApp';
                }

                $this->update($updateData);

                return [
                    'success' => true,
                    'status' => $status,
                    'message' => 'Status updated: ' . ucfirst($status),
                    'data' => $data,
                ];
            }

            return ['success' => false, 'message' => 'Failed to check template status'];

        } catch (\Exception $e) {
            Log::error('WhatsApp template status check error', [
                'template_id' => $this->id,
                'error' => $e->getMessage(),
            ]);

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'draft' => '📝',
            'pending' => '⏳',
            'approved' => '✅',
            'rejected' => '❌',
            default => '📄',
        };
    }

    /**
     * Extract variables from body text
     */
    public function extractVariables()
    {
        $allText = ($this->header_text ?? '') . ' ' . ($this->body_text ?? '');
        preg_match_all('/\{\{(\d+)\}\}/', $allText, $matches);
        return array_unique($matches[1] ?? []);
    }

    /**
     * Get variables attribute (accessor)
     */
    public function getVariablesAttribute()
    {
        // If variables are stored in database, return them
        if (isset($this->attributes['variables'])) {
            $stored = json_decode($this->attributes['variables'], true);
            if (is_array($stored) && !empty($stored)) {
                return $stored;
            }
        }

        // Otherwise, extract from text
        return $this->extractVariables();
    }

    /**
     * Scope for approved templates
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending templates
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}

