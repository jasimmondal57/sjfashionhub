<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CommunicationTemplate;

class CreateEmailTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:create-email {--force : Force recreate existing templates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create comprehensive email templates for orders, returns, and alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $this->info('Creating comprehensive email templates...');
        
        $templates = $this->getEmailTemplates();
        $created = 0;
        $skipped = 0;
        
        foreach ($templates as $template) {
            $existing = CommunicationTemplate::where('event', $template['event'])
                ->where('type', 'email')
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
        $this->info("📧 Email Template Creation Complete!");
        $this->info("✅ Created: {$created} templates");
        $this->info("⏭️ Skipped: {$skipped} templates");
        $this->newLine();
        $this->info("All templates are now available in Admin Panel > Communication > Templates");
    }

    /**
     * Get all email templates
     */
    private function getEmailTemplates()
    {
        return [
            // ORDER TEMPLATES - CUSTOMER
            [
                'name' => 'Order Placed - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_placed_customer',
                'subject' => '🎉 Order Confirmation #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderPlacedCustomerContent(),
                'html_content' => $this->getOrderPlacedCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is placed',
                'variables' => ['user_name', 'order_number', 'order_total', 'order_items', 'billing_address', 'shipping_address', 'payment_method', 'tracking_url', 'site_name', 'site_url']
            ],
            
            [
                'name' => 'Order Confirmed - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_confirmed_customer',
                'subject' => '✅ Order Confirmed #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderConfirmedCustomerContent(),
                'html_content' => $this->getOrderConfirmedCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is confirmed by admin',
                'variables' => ['user_name', 'order_number', 'order_total', 'estimated_delivery', 'tracking_url', 'site_name']
            ],
            
            [
                'name' => 'Order Ready to Ship - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_ready_to_ship_customer',
                'subject' => '📦 Order Ready to Ship #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderReadyToShipCustomerContent(),
                'html_content' => $this->getOrderReadyToShipCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is ready to ship',
                'variables' => ['user_name', 'order_number', 'estimated_delivery', 'tracking_url', 'site_name']
            ],

            // LOW STOCK ALERT - ADMIN
            [
                'name' => 'Low Stock Alert - Admin',
                'type' => 'email',
                'category' => 'notification',
                'event' => 'low_stock_alert_admin',
                'subject' => '⚠️ Low Stock Alert - {{product_name}} - {{site_name}}',
                'content' => $this->getLowStockAlertContent(),
                'html_content' => $this->getLowStockAlertHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to admin when product stock is low',
                'variables' => ['product_name', 'product_sku', 'current_stock', 'threshold', 'admin_url', 'site_name']
            ],

            // RETURN REQUEST - ADMIN ALERT
            [
                'name' => 'Return Request Alert - Admin',
                'type' => 'email',
                'category' => 'return',
                'event' => 'return_request_admin',
                'subject' => '🔄 Return Request Alert #{{return_number}} - {{site_name}}',
                'content' => $this->getReturnRequestAdminContent(),
                'html_content' => $this->getReturnRequestAdminHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to admin when customer submits return request',
                'variables' => ['return_number', 'order_number', 'customer_name', 'return_reason', 'return_items', 'admin_url', 'site_name']
            ],

            // WELCOME EMAIL - CUSTOMER
            [
                'name' => 'Welcome Email - Customer',
                'type' => 'email',
                'category' => 'notification',
                'event' => 'user_registered',
                'subject' => '👋 Welcome to {{site_name}}!',
                'content' => $this->getWelcomeEmailContent(),
                'html_content' => $this->getWelcomeEmailHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when they register',
                'variables' => ['user_name', 'user_email', 'site_name', 'site_url', 'login_url']
            ]
        ];
    }

    private function getOrderPlacedCustomerContent()
    {
        return "Hi {{user_name}},

Thank you for your order! We're excited to confirm that we've received your order #{{order_number}}.

Order Details:
- Order Number: {{order_number}}
- Total Amount: ₹{{order_total}}
- Payment Method: {{payment_method}}

Your order is being processed and you'll receive another email once it's confirmed.

You can track your order status at: {{tracking_url}}

Thank you for shopping with {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getOrderPlacedCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .button { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Order Confirmation</h1>
            <p>Thank you for your order!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>We are excited to confirm that we have received your order <strong>#{{order_number}}</strong>.</p>

        <div class="order-details">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Payment Method:</strong> {{payment_method}}</p>
        </div>

        <p>Your order is being processed and you will receive another email once it is confirmed by our team.</p>

        <div style="text-align: center;">
            <a href="{{tracking_url}}" class="button">📦 Track Your Order</a>
        </div>

        <div class="footer">
            <p>Thank you for shopping with <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getOrderConfirmedCustomerContent()
    {
        return "Hi {{user_name}},

Great news! Your order #{{order_number}} has been confirmed and is now being prepared for shipment.

Order Details:
- Order Number: {{order_number}}
- Total Amount: ₹{{order_total}}
- Estimated Delivery: {{estimated_delivery}}

We'll send you another email with tracking information once your order is shipped.

Track your order: {{tracking_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getOrderConfirmedCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #f0fdf4; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669; }
        .button { display: inline-block; background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Order Confirmed</h1>
            <p>Your order is being prepared!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your order <strong>#{{order_number}}</strong> has been confirmed and is now being prepared for shipment.</p>

        <div class="order-details">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>We will send you another email with tracking information once your order is shipped.</p>

        <div style="text-align: center;">
            <a href="{{tracking_url}}" class="button">📦 Track Your Order</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getOrderReadyToShipCustomerContent()
    {
        return "Hi {{user_name}},

Your order #{{order_number}} is now ready to ship! Our team has carefully packed your items and they will be dispatched soon.

Order Details:
- Order Number: {{order_number}}
- Estimated Delivery: {{estimated_delivery}}

You'll receive tracking information once the package is picked up by our courier partner.

Track your order: {{tracking_url}}

Thank you for your patience!

Best regards,
{{site_name}} Team";
    }

    private function getOrderReadyToShipCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ready to Ship</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #7c3aed; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #faf5ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #7c3aed; }
        .button { display: inline-block; background: #7c3aed; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Ready to Ship</h1>
            <p>Your order is packed and ready!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your order <strong>#{{order_number}}</strong> is now ready to ship! Our team has carefully packed your items and they will be dispatched soon.</p>

        <div class="order-details">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>You will receive tracking information once the package is picked up by our courier partner.</p>

        <div style="text-align: center;">
            <a href="{{tracking_url}}" class="button">📦 Track Your Order</a>
        </div>

        <div class="footer">
            <p>Thank you for your patience!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getLowStockAlertContent()
    {
        return "Low Stock Alert!

Product: {{product_name}} (SKU: {{product_sku}})
Current Stock: {{current_stock}} units
Threshold: {{threshold}} units

The product stock has fallen below the minimum threshold. Please restock soon to avoid stockouts.

Admin Panel: {{admin_url}}

{{site_name}} Admin System";
    }

    private function getLowStockAlertHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .alert-box { background: #fffbeb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b; }
        .button { display: inline-block; background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Low Stock Alert</h1>
            <p>Immediate attention required</p>
        </div>

        <h2>Stock Running Low!</h2>

        <div class="alert-box">
            <h3>📦 Product Details</h3>
            <p><strong>Product:</strong> {{product_name}}</p>
            <p><strong>SKU:</strong> {{product_sku}}</p>
            <p><strong>Current Stock:</strong> {{current_stock}} units</p>
            <p><strong>Threshold:</strong> {{threshold}} units</p>
        </div>

        <p>The product stock has fallen below the minimum threshold. Please restock soon to avoid stockouts.</p>

        <div style="text-align: center;">
            <a href="{{admin_url}}" class="button">🔧 Manage Inventory</a>
        </div>

        <div class="footer">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getReturnRequestAdminContent()
    {
        return "Return Request Alert!

A new return request has been submitted.

Return Details:
- Return Number: {{return_number}}
- Order Number: {{order_number}}
- Customer: {{customer_name}}
- Reason: {{return_reason}}
- Items: {{return_items}}

Please review and process the return request in the admin panel.

Admin Panel: {{admin_url}}

{{site_name}} Admin System";
    }

    private function getReturnRequestAdminHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Request Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #8b5cf6; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f5f3ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #8b5cf6; }
        .button { display: inline-block; background: #8b5cf6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Return Request Alert</h1>
            <p>New return request received</p>
        </div>

        <h2>Return Request Submitted!</h2>
        <p>A new return request has been submitted and requires your attention.</p>

        <div class="return-details">
            <h3>📋 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Customer:</strong> {{customer_name}}</p>
            <p><strong>Reason:</strong> {{return_reason}}</p>
            <p><strong>Items:</strong> {{return_items}}</p>
        </div>

        <p>Please review and process the return request in the admin panel.</p>

        <div style="text-align: center;">
            <a href="{{admin_url}}" class="button">🔧 Process Return</a>
        </div>

        <div class="footer">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getWelcomeEmailContent()
    {
        return "Hi {{user_name}},

Welcome to {{site_name}}! We're thrilled to have you join our fashion community.

Your account has been successfully created with email: {{user_email}}

Here's what you can do now:
- Browse our latest collections
- Add items to your wishlist
- Enjoy exclusive member benefits
- Track your orders easily

Start shopping: {{site_url}}
Login to your account: {{login_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getWelcomeEmailHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SJ Fashion Hub</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #6366f1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .welcome-box { background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1; }
        .button { display: inline-block; background: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
        .benefits { background: #f8fafc; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👋 Welcome to {{site_name}}!</h1>
            <p>Your fashion journey starts here</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Welcome to <strong>{{site_name}}</strong>! We are thrilled to have you join our fashion community.</p>

        <div class="welcome-box">
            <h3>✅ Account Created Successfully</h3>
            <p>Your account has been created with email: <strong>{{user_email}}</strong></p>
        </div>

        <div class="benefits">
            <h3>🎉 What you can do now:</h3>
            <ul>
                <li>Browse our latest collections</li>
                <li>Add items to your wishlist</li>
                <li>Enjoy exclusive member benefits</li>
                <li>Track your orders easily</li>
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{site_url}}" class="button">🛍️ Start Shopping</a>
            <a href="{{login_url}}" class="button">🔐 Login</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }
}
