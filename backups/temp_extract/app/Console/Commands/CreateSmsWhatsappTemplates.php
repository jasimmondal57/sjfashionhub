<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CommunicationTemplate;

class CreateSmsWhatsappTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:create-sms-whatsapp {--force : Force recreate existing templates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create SMS and WhatsApp templates for order notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $this->info('Creating SMS and WhatsApp templates...');
        
        $templates = $this->getSmsWhatsappTemplates();
        $created = 0;
        $skipped = 0;
        
        foreach ($templates as $template) {
            $existing = CommunicationTemplate::where('event', $template['event'])
                ->where('type', $template['type'])
                ->where('language', $template['language'] ?? 'en')
                ->first();
            
            if ($existing && !$force) {
                $this->warn("Template '{$template['name']}' already exists. Use --force to recreate.");
                $skipped++;
                continue;
            }
            
            if ($existing && $force) {
                $existing->delete();
                $this->info("Deleted existing template: {$template['name']}");
            }
            
            CommunicationTemplate::create($template);
            $this->info("✅ Created: {$template['name']}");
            $created++;
        }
        
        $this->newLine();
        $this->info("📱 SMS & WhatsApp Template Creation Complete!");
        $this->info("✅ Created: {$created} templates");
        $this->info("⏭️ Skipped: {$skipped} templates");
        $this->newLine();
        $this->info("All templates are now available in Admin Panel > Communication > Templates");
    }

    /**
     * Get SMS and WhatsApp templates
     */
    private function getSmsWhatsappTemplates()
    {
        return [
            // SMS TEMPLATES
            [
                'name' => 'Order Placed - SMS',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_placed_customer',
                'subject' => null,
                'content' => 'Hi {{user_name}}, your order #{{order_number}} for ₹{{order_total}} has been placed successfully. Track: {{tracking_url}} - {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'SMS sent to customer when order is placed',
                'variables' => ['user_name', 'order_number', 'order_total', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Confirmed - SMS',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_confirmed_customer',
                'subject' => null,
                'content' => 'Hi {{user_name}}, your order #{{order_number}} has been confirmed! Expected delivery: {{estimated_delivery}}. Track: {{tracking_url}} - {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'SMS sent to customer when order is confirmed',
                'variables' => ['user_name', 'order_number', 'estimated_delivery', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Shipped - SMS',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_shipped_customer',
                'subject' => null,
                'content' => 'Hi {{user_name}}, your order #{{order_number}} has been shipped! Tracking: {{tracking_number}} via {{courier_company}}. Track: {{tracking_url}} - {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'SMS sent to customer when order is shipped',
                'variables' => ['user_name', 'order_number', 'tracking_number', 'courier_company', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Out for Delivery - SMS',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_out_for_delivery_customer',
                'subject' => null,
                'content' => 'Hi {{user_name}}, your order #{{order_number}} is out for delivery and will reach you today! Please be available to receive it. - {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'SMS sent to customer when order is out for delivery',
                'variables' => ['user_name', 'order_number', 'site_name']
            ],

            [
                'name' => 'Order Delivered - SMS',
                'type' => 'sms',
                'category' => 'order',
                'event' => 'order_delivered_customer',
                'subject' => null,
                'content' => 'Hi {{user_name}}, your order #{{order_number}} has been delivered! Thank you for shopping with {{site_name}}. Need help? Contact us anytime.',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'SMS sent to customer when order is delivered',
                'variables' => ['user_name', 'order_number', 'site_name']
            ],

            // WHATSAPP TEMPLATES
            [
                'name' => 'Order Placed - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_placed_customer',
                'subject' => null,
                'content' => '🛍️ *Order Placed Successfully!*

Hi {{user_name}},

Your order #{{order_number}} for *₹{{order_total}}* has been placed successfully.

💳 Payment: {{payment_method}}
📦 Track your order: {{tracking_url}}

Thank you for choosing {{site_name}}! 🙏',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when order is placed',
                'variables' => ['user_name', 'order_number', 'order_total', 'payment_method', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Confirmed - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_confirmed_customer',
                'subject' => null,
                'content' => '✅ *Order Confirmed!*

Hi {{user_name}},

Great news! Your order #{{order_number}} has been confirmed and is being prepared for shipment.

📅 Expected delivery: {{estimated_delivery}}
📦 Track your order: {{tracking_url}}

We\'ll notify you once it\'s shipped! 🚚

- {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when order is confirmed',
                'variables' => ['user_name', 'order_number', 'estimated_delivery', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Shipped - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_shipped_customer',
                'subject' => null,
                'content' => '🚚 *Order Shipped!*

Hi {{user_name}},

Your order #{{order_number}} is on its way to you!

📦 Tracking Number: {{tracking_number}}
🚛 Courier: {{courier_company}}
📅 Expected delivery: {{estimated_delivery}}

Track your package: {{tracking_url}}

- {{site_name}}',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when order is shipped',
                'variables' => ['user_name', 'order_number', 'tracking_number', 'courier_company', 'estimated_delivery', 'tracking_url', 'site_name']
            ],

            [
                'name' => 'Order Out for Delivery - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_out_for_delivery_customer',
                'subject' => null,
                'content' => '🏃‍♂️ *Out for Delivery!*

Hi {{user_name}},

Your order #{{order_number}} is out for delivery and will reach you today!

📍 Please ensure someone is available to receive the package.

Thank you for choosing {{site_name}}! 🙏',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when order is out for delivery',
                'variables' => ['user_name', 'order_number', 'site_name']
            ],

            [
                'name' => 'Order Delivered - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'order',
                'event' => 'order_delivered_customer',
                'subject' => null,
                'content' => '🎉 *Order Delivered!*

Hi {{user_name}},

Your order #{{order_number}} has been delivered successfully!

We hope you love your purchase! 💕

📝 Rate your experience
🔄 Need to return something?
💬 Have questions? Just reply to this message!

Thank you for shopping with {{site_name}}! 🛍️',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when order is delivered',
                'variables' => ['user_name', 'order_number', 'site_name']
            ],

            [
                'name' => 'Welcome Message - WhatsApp',
                'type' => 'whatsapp',
                'category' => 'notification',
                'event' => 'user_registered',
                'subject' => null,
                'content' => '👋 *Welcome to {{site_name}}!*

Hi {{user_name}},

Welcome to our fashion family! 🎉

🛍️ Browse latest collections
💕 Add items to wishlist
🎁 Enjoy exclusive member benefits
📦 Track orders easily

Start shopping: {{site_url}}

Thank you for joining us! 🙏',
                'html_content' => null,
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'WhatsApp message sent to customer when they register',
                'variables' => ['user_name', 'site_name', 'site_url']
            ]
        ];
    }
}
