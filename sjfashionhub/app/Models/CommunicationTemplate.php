<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunicationTemplate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
        'event',
        'subject',
        'content',
        'html_content',
        'variables',
        'settings',
        'language',
        'is_active',
        'is_default',
        'priority',
        'description',
        'metadata'
    ];

    protected $casts = [
        'variables' => 'array',
        'settings' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'priority' => 'integer'
    ];

    /**
     * Get communication logs for this template
     */
    public function communicationLogs()
    {
        return $this->hasMany(CommunicationLog::class, 'template_id');
    }

    /**
     * Render template with variables
     */
    public function render($variables = [])
    {
        $content = $this->content;
        $htmlContent = $this->html_content;
        $subject = $this->subject;

        // Replace variables in content
        foreach ($variables as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $content = str_replace($placeholder, $value, $content);

            if ($htmlContent) {
                $htmlContent = str_replace($placeholder, $value, $htmlContent);
            }

            if ($subject) {
                $subject = str_replace($placeholder, $value, $subject);
            }
        }

        return [
            'subject' => $subject,
            'content' => $content,
            'html_content' => $htmlContent
        ];
    }

    /**
     * Get available template variables
     */
    public function getAvailableVariables()
    {
        // If variables is set and is an array, return it
        if ($this->variables && is_array($this->variables)) {
            return $this->variables;
        }

        // Otherwise return keys from default variables
        return array_keys($this->getDefaultVariables());
    }

    /**
     * Get default variables based on template type and category
     */
    private function getDefaultVariables()
    {
        $baseVariables = [
            'user_name' => 'User\'s name',
            'user_email' => 'User\'s email',
            'user_phone' => 'User\'s phone number',
            'site_name' => 'Website name',
            'site_url' => 'Website URL',
            'current_date' => 'Current date',
            'current_time' => 'Current time'
        ];

        $categoryVariables = match($this->category) {
            'order' => [
                'order_id' => 'Order ID',
                'order_total' => 'Order total amount',
                'order_status' => 'Order status',
                'order_date' => 'Order date',
                'order_items' => 'Order items list',
                'shipping_address' => 'Shipping address',
                'tracking_number' => 'Tracking number'
            ],
            'verification' => [
                'verification_code' => 'Verification code',
                'verification_link' => 'Verification link',
                'expiry_time' => 'Code expiry time'
            ],
            'promotion' => [
                'coupon_code' => 'Coupon code',
                'discount_amount' => 'Discount amount',
                'discount_percentage' => 'Discount percentage',
                'offer_title' => 'Offer title',
                'offer_description' => 'Offer description',
                'expiry_date' => 'Offer expiry date'
            ],
            'return' => [
                'return_id' => 'Return ID',
                'return_reason' => 'Return reason',
                'return_status' => 'Return status',
                'refund_amount' => 'Refund amount'
            ],
            default => []
        };

        return array_merge($baseVariables, $categoryVariables);
    }

    /**
     * Get template by event
     */
    public static function getByEvent($type, $event, $language = 'en')
    {
        return static::where('type', $type)
            ->where('event', $event)
            ->where('language', $language)
            ->where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('priority', 'desc')
            ->first();
    }

    /**
     * Get default template for category
     */
    public static function getDefault($type, $category, $language = 'en')
    {
        return static::where('type', $type)
            ->where('category', $category)
            ->where('language', $language)
            ->where('is_default', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Create default templates
     */
    public static function createDefaults()
    {
        $templates = [
            // Email Templates
            [
                'name' => 'Email Verification',
                'type' => 'email',
                'category' => 'verification',
                'event' => 'email_verification',
                'subject' => 'Verify Your Email - {{site_name}}',
                'content' => 'Hi {{user_name}}, Please verify your email by clicking this link: {{verification_link}}',
                'html_content' => '<h2>Hi {{user_name}}</h2><p>Please verify your email by clicking this link:</p><a href="{{verification_link}}">Verify Email</a>',
                'is_default' => true
            ],
            [
                'name' => 'Order Confirmation',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_placed',
                'subject' => 'Order Confirmation #{{order_id}} - {{site_name}}',
                'content' => 'Hi {{user_name}}, Your order #{{order_id}} has been placed successfully. Total: ₹{{order_total}}',
                'html_content' => '<h2>Order Confirmation</h2><p>Hi {{user_name}}</p><p>Your order #{{order_id}} has been placed successfully.</p><p>Total: ₹{{order_total}}</p>',
                'is_default' => true
            ],
            // SMS Templates
            [
                'name' => 'OTP Verification',
                'type' => 'sms',
                'category' => 'verification',
                'event' => 'phone_verification',
                'content' => 'Your OTP for {{site_name}} is {{verification_code}}. Valid for 10 minutes.',
                'is_default' => true
            ],
            [
                'name' => 'Order Shipped',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_shipped',
                'content' => 'Your order #{{order_id}} has been shipped. Track: {{tracking_number}}',
                'is_default' => true
            ],
            // WhatsApp Templates
            [
                'name' => 'Order Update',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_status_update',
                'content' => 'Hi {{user_name}}, Your order #{{order_id}} status: {{order_status}}. Track your order: {{tracking_number}}',
                'is_default' => true
            ]
        ];

        foreach ($templates as $template) {
            static::updateOrCreate(
                [
                    'type' => $template['type'],
                    'category' => $template['category'],
                    'event' => $template['event'],
                    'language' => 'en'
                ],
                $template
            );
        }
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for event
     */
    public function scopeEvent($query, $event)
    {
        return $query->where('event', $event);
    }
}
