<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class WhatsAppAccount extends Model
{
    use SoftDeletes;

    protected $table = 'whatsapp_accounts';

    protected $fillable = [
        'name',
        'business_account_id',
        'phone_number_id',
        'display_phone_number',
        'verified_name',
        'access_token',
        'api_version',
        'quality_rating',
        'messaging_limit_tier',
        'is_active',
        'is_default',
        'webhook_url',
        'webhook_verify_token',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'metadata' => 'array',
    ];

    protected $hidden = [
        'access_token',
    ];

    /**
     * Get decrypted access token
     */
    public function getDecryptedTokenAttribute()
    {
        try {
            return Crypt::decryptString($this->access_token);
        } catch (\Exception $e) {
            return $this->access_token;
        }
    }

    /**
     * Set encrypted access token
     */
    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = Crypt::encryptString($value);
    }

    /**
     * Get templates for this account
     */
    public function templates()
    {
        return $this->hasMany(WhatsAppTemplate::class, 'account_id');
    }

    /**
     * Get campaigns for this account
     */
    public function campaigns()
    {
        return $this->hasMany(WhatsAppCampaign::class, 'account_id');
    }

    /**
     * Get approved templates count
     */
    public function getApprovedTemplatesCountAttribute()
    {
        return $this->templates()->where('status', 'approved')->count();
    }

    /**
     * Get pending templates count
     */
    public function getPendingTemplatesCountAttribute()
    {
        return $this->templates()->where('status', 'pending')->count();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        if (!$this->is_active) {
            return 'gray';
        }

        return match($this->quality_rating) {
            'GREEN' => 'green',
            'YELLOW' => 'yellow',
            'RED' => 'red',
            default => 'blue',
        };
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        if (!$this->is_active) {
            return '⏸️';
        }

        return match($this->quality_rating) {
            'GREEN' => '✅',
            'YELLOW' => '⚠️',
            'RED' => '❌',
            default => '📱',
        };
    }

    /**
     * Scope for active accounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for default account
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Set as default account
     */
    public function setAsDefault()
    {
        // Remove default from all other accounts
        static::where('id', '!=', $this->id)->update(['is_default' => false]);
        
        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Sync account info from WhatsApp API
     */
    public function syncAccountInfo()
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->decrypted_token,
            ])->get("https://graph.facebook.com/{$this->api_version}/{$this->phone_number_id}", [
                'fields' => 'verified_name,display_phone_number,quality_rating,messaging_limit_tier',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $this->update([
                    'verified_name' => $data['verified_name'] ?? null,
                    'display_phone_number' => $data['display_phone_number'] ?? null,
                    'quality_rating' => $data['quality_rating'] ?? 'UNKNOWN',
                    'messaging_limit_tier' => $data['messaging_limit_tier'] ?? null,
                ]);

                return ['success' => true, 'message' => 'Account info synced successfully'];
            }

            return ['success' => false, 'message' => 'Failed to sync account info'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Sync templates from WhatsApp API
     */
    public function syncTemplates()
    {
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->decrypted_token,
            ])->get("https://graph.facebook.com/{$this->api_version}/{$this->business_account_id}/message_templates", [
                'fields' => 'name,status,category,language,components,id',
                'limit' => 100,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $synced = 0;

                foreach ($data['data'] ?? [] as $template) {
                    // Extract body text from components
                    $bodyText = '';
                    $headerText = '';
                    $headerType = null;
                    $footerText = '';

                    foreach ($template['components'] ?? [] as $component) {
                        if ($component['type'] === 'BODY') {
                            $bodyText = $component['text'] ?? '';
                        } elseif ($component['type'] === 'HEADER') {
                            $headerType = strtolower($component['format'] ?? 'text');
                            $headerText = $component['text'] ?? '';
                        } elseif ($component['type'] === 'FOOTER') {
                            $footerText = $component['text'] ?? '';
                        }
                    }

                    WhatsAppTemplate::updateOrCreate(
                        [
                            'account_id' => $this->id,
                            'name' => $template['name'],
                        ],
                        [
                            'display_name' => ucwords(str_replace('_', ' ', $template['name'])),
                            'whatsapp_template_id' => $template['id'],
                            'status' => strtolower($template['status']),
                            'category' => strtolower($template['category'] ?? 'marketing'),
                            'language' => $template['language'] ?? 'en',
                            'body_text' => $bodyText,
                            'header_text' => $headerText,
                            'header_type' => $headerType,
                            'footer_text' => $footerText,
                            'last_synced_at' => now(),
                        ]
                    );
                    $synced++;
                }

                return ['success' => true, 'message' => "Synced {$synced} templates", 'count' => $synced];
            }

            return ['success' => false, 'message' => 'Failed to sync templates'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

