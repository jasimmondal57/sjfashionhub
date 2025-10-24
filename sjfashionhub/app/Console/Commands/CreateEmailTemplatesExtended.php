<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CommunicationTemplate;

class CreateEmailTemplatesExtended extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:create-extended {--force : Force recreate existing templates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create extended email templates for shipping, delivery, returns, and admin alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $this->info('Creating extended email templates...');
        
        $templates = $this->getExtendedEmailTemplates();
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
        $this->info("📧 Extended Email Template Creation Complete!");
        $this->info("✅ Created: {$created} templates");
        $this->info("⏭️ Skipped: {$skipped} templates");
        $this->newLine();
        $this->info("All templates are now available in Admin Panel > Communication > Templates");
    }

    /**
     * Get extended email templates
     */
    private function getExtendedEmailTemplates()
    {
        return [
            // ORDER SHIPPED - CUSTOMER
            [
                'name' => 'Order Shipped - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_shipped_customer',
                'subject' => '🚚 Order Shipped #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderShippedCustomerContent(),
                'html_content' => $this->getOrderShippedCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is shipped',
                'variables' => ['user_name', 'order_number', 'tracking_number', 'courier_company', 'estimated_delivery', 'tracking_url', 'site_name']
            ],

            // ORDER OUT FOR DELIVERY - CUSTOMER
            [
                'name' => 'Order Out for Delivery - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_out_for_delivery_customer',
                'subject' => '🏃‍♂️ Order Out for Delivery #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderOutForDeliveryCustomerContent(),
                'html_content' => $this->getOrderOutForDeliveryCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is out for delivery',
                'variables' => ['user_name', 'order_number', 'tracking_number', 'courier_company', 'delivery_date', 'tracking_url', 'site_name']
            ],

            // ORDER DELIVERED - CUSTOMER
            [
                'name' => 'Order Delivered - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_delivered_customer',
                'subject' => '🎉 Order Delivered #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderDeliveredCustomerContent(),
                'html_content' => $this->getOrderDeliveredCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is delivered',
                'variables' => ['user_name', 'order_number', 'delivery_date', 'return_policy_url', 'review_url', 'site_name']
            ],

            // ORDER CANCELLED - CUSTOMER
            [
                'name' => 'Order Cancelled - Customer',
                'type' => 'email',
                'category' => 'order',
                'event' => 'order_cancelled_customer',
                'subject' => '❌ Order Cancelled #{{order_number}} - {{site_name}}',
                'content' => $this->getOrderCancelledCustomerContent(),
                'html_content' => $this->getOrderCancelledCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when order is cancelled',
                'variables' => ['user_name', 'order_number', 'cancellation_reason', 'refund_amount', 'refund_timeline', 'site_name']
            ],

            // RETURN REQUEST SUBMITTED - CUSTOMER
            [
                'name' => 'Return Request Submitted - Customer',
                'type' => 'email',
                'category' => 'return',
                'event' => 'return_request_submitted_customer',
                'subject' => '📋 Return Request Submitted #{{return_number}} - {{site_name}}',
                'content' => $this->getReturnRequestSubmittedCustomerContent(),
                'html_content' => $this->getReturnRequestSubmittedCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when return request is submitted',
                'variables' => ['user_name', 'return_number', 'order_number', 'return_reason', 'return_items', 'processing_timeline', 'site_name']
            ],

            // RETURN APPROVED - CUSTOMER
            [
                'name' => 'Return Approved - Customer',
                'type' => 'email',
                'category' => 'return',
                'event' => 'return_approved_customer',
                'subject' => '✅ Return Approved #{{return_number}} - {{site_name}}',
                'content' => $this->getReturnApprovedCustomerContent(),
                'html_content' => $this->getReturnApprovedCustomerHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to customer when return is approved',
                'variables' => ['user_name', 'return_number', 'pickup_date', 'pickup_instructions', 'refund_amount', 'refund_timeline', 'site_name']
            ],

            // NEW ORDER - ADMIN ALERT
            [
                'name' => 'New Order Alert - Admin',
                'type' => 'email',
                'category' => 'order',
                'event' => 'new_order_admin',
                'subject' => '🔔 New Order Alert #{{order_number}} - {{site_name}}',
                'content' => $this->getNewOrderAdminContent(),
                'html_content' => $this->getNewOrderAdminHtml(),
                'language' => 'en',
                'is_active' => true,
                'is_default' => true,
                'priority' => 100,
                'description' => 'Sent to admin when new order is placed',
                'variables' => ['order_number', 'customer_name', 'customer_email', 'order_total', 'payment_method', 'order_items', 'admin_url', 'site_name']
            ]
        ];
    }

    private function getOrderShippedCustomerContent()
    {
        return "Hi {{user_name}},

Great news! Your order #{{order_number}} has been shipped and is on its way to you.

Shipping Details:
- Tracking Number: {{tracking_number}}
- Courier Company: {{courier_company}}
- Estimated Delivery: {{estimated_delivery}}

You can track your package in real-time using the tracking link below.

Track your package: {{tracking_url}}

Thank you for shopping with {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getOrderShippedCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Shipped</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .shipping-details { background: #eff6ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚚 Order Shipped</h1>
            <p>Your package is on the way!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your order <strong>#{{order_number}}</strong> has been shipped and is on its way to you.</p>

        <div class="shipping-details">
            <h3>🚛 Shipping Details</h3>
            <p><strong>Tracking Number:</strong> {{tracking_number}}</p>
            <p><strong>Courier Company:</strong> {{courier_company}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>You can track your package in real-time using the tracking link below.</p>

        <div style="text-align: center;">
            <a href="{{tracking_url}}" class="button">📦 Track Your Package</a>
        </div>

        <div class="footer">
            <p>Thank you for shopping with <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getOrderOutForDeliveryCustomerContent()
    {
        return "Hi {{user_name}},

Your order #{{order_number}} is out for delivery and will reach you today!

Delivery Details:
- Tracking Number: {{tracking_number}}
- Courier Company: {{courier_company}}
- Expected Delivery: {{delivery_date}}

Please ensure someone is available to receive the package.

Track your delivery: {{tracking_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getOrderOutForDeliveryCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Out for Delivery</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .delivery-details { background: #fffbeb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b; }
        .button { display: inline-block; background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
        .alert { background: #fef3c7; border: 1px solid #f59e0b; padding: 10px; border-radius: 6px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏃‍♂️ Out for Delivery</h1>
            <p>Your package will arrive today!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your order <strong>#{{order_number}}</strong> is out for delivery and will reach you today!</p>

        <div class="delivery-details">
            <h3>🚛 Delivery Details</h3>
            <p><strong>Tracking Number:</strong> {{tracking_number}}</p>
            <p><strong>Courier Company:</strong> {{courier_company}}</p>
            <p><strong>Expected Delivery:</strong> {{delivery_date}}</p>
        </div>

        <div class="alert">
            <p><strong>📍 Important:</strong> Please ensure someone is available to receive the package.</p>
        </div>

        <div style="text-align: center;">
            <a href="{{tracking_url}}" class="button">📦 Track Your Delivery</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getOrderDeliveredCustomerContent()
    {
        return "Hi {{user_name}},

Congratulations! Your order #{{order_number}} has been successfully delivered on {{delivery_date}}.

We hope you love your purchase! If you have any questions or concerns about your order, please don't hesitate to contact us.

We'd love to hear about your experience:
- Leave a review: {{review_url}}
- Need to return something? {{return_policy_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getOrderDeliveredCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Delivered</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .success-box { background: #ecfdf5; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981; }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Order Delivered</h1>
            <p>Your package has arrived!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Congratulations! Your order <strong>#{{order_number}}</strong> has been successfully delivered on <strong>{{delivery_date}}</strong>.</p>

        <div class="success-box">
            <h3>✅ Delivery Confirmed</h3>
            <p>We hope you love your purchase! If you have any questions or concerns about your order, please do not hesitate to contact us.</p>
        </div>

        <p>We would love to hear about your experience:</p>

        <div style="text-align: center;">
            <a href="{{review_url}}" class="button">⭐ Leave a Review</a>
            <a href="{{return_policy_url}}" class="button">📋 Return Policy</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getOrderCancelledCustomerContent()
    {
        return "Hi {{user_name}},

We regret to inform you that your order #{{order_number}} has been cancelled.

Cancellation Details:
- Reason: {{cancellation_reason}}
- Refund Amount: ₹{{refund_amount}}
- Refund Timeline: {{refund_timeline}}

If you paid online, your refund will be processed automatically. For COD orders, no payment was collected.

We apologize for any inconvenience caused. Please feel free to place a new order anytime.

Best regards,
{{site_name}} Team";
    }

    private function getOrderCancelledCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #ef4444; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .cancel-details { background: #fef2f2; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ef4444; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Order Cancelled</h1>
            <p>We apologize for the inconvenience</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>We regret to inform you that your order <strong>#{{order_number}}</strong> has been cancelled.</p>

        <div class="cancel-details">
            <h3>📋 Cancellation Details</h3>
            <p><strong>Reason:</strong> {{cancellation_reason}}</p>
            <p><strong>Refund Amount:</strong> ₹{{refund_amount}}</p>
            <p><strong>Refund Timeline:</strong> {{refund_timeline}}</p>
        </div>

        <p>If you paid online, your refund will be processed automatically. For COD orders, no payment was collected.</p>
        <p>We apologize for any inconvenience caused. Please feel free to place a new order anytime.</p>

        <div class="footer">
            <p>Best regards,<br><strong>{{site_name}}</strong> Team</p>
        </div>
    </div>
</body>
</html>';
    }

    // Add remaining methods for return templates and admin alerts
    private function getReturnRequestSubmittedCustomerContent()
    {
        return "Hi {{user_name}},

Your return request #{{return_number}} for order #{{order_number}} has been submitted successfully.

Return Details:
- Return Number: {{return_number}}
- Order Number: {{order_number}}
- Reason: {{return_reason}}
- Items: {{return_items}}

Our team will review your request and get back to you within {{processing_timeline}}.

Thank you for your patience!

Best regards,
{{site_name}} Team";
    }

    private function getReturnRequestSubmittedCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Request Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #6366f1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Return Request Submitted</h1>
            <p>We have received your return request</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your return request <strong>#{{return_number}}</strong> for order <strong>#{{order_number}}</strong> has been submitted successfully.</p>

        <div class="return-details">
            <h3>📦 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Reason:</strong> {{return_reason}}</p>
            <p><strong>Items:</strong> {{return_items}}</p>
        </div>

        <p>Our team will review your request and get back to you within <strong>{{processing_timeline}}</strong>.</p>

        <div class="footer">
            <p>Thank you for your patience!</p>
            <p>Best regards,<br><strong>{{site_name}}</strong> Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getReturnApprovedCustomerContent()
    {
        return "Hi {{user_name}},

Great news! Your return request #{{return_number}} has been approved.

Return Details:
- Return Number: {{return_number}}
- Pickup Date: {{pickup_date}}
- Refund Amount: ₹{{refund_amount}}
- Refund Timeline: {{refund_timeline}}

Pickup Instructions:
{{pickup_instructions}}

Your refund will be processed once we receive and verify the returned items.

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team";
    }

    private function getReturnApprovedCustomerHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f0fdf4; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669; }
        .pickup-box { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Return Approved</h1>
            <p>Your return request has been approved!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your return request <strong>#{{return_number}}</strong> has been approved.</p>

        <div class="return-details">
            <h3>📦 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Pickup Date:</strong> {{pickup_date}}</p>
            <p><strong>Refund Amount:</strong> ₹{{refund_amount}}</p>
            <p><strong>Refund Timeline:</strong> {{refund_timeline}}</p>
        </div>

        <div class="pickup-box">
            <h3>📍 Pickup Instructions</h3>
            <p>{{pickup_instructions}}</p>
        </div>

        <p>Your refund will be processed once we receive and verify the returned items.</p>

        <div class="footer">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>';
    }

    private function getNewOrderAdminContent()
    {
        return "New Order Alert!

A new order has been placed on {{site_name}}.

Order Details:
- Order Number: {{order_number}}
- Customer: {{customer_name}} ({{customer_email}})
- Total Amount: ₹{{order_total}}
- Payment Method: {{payment_method}}

Items Ordered:
{{order_items}}

Please review and confirm the order in the admin panel.

Admin Panel: {{admin_url}}

{{site_name}} Admin System";
    }

    private function getNewOrderAdminHtml()
    {
        return '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #dc2626; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #fef2f2; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626; }
        .button { display: inline-block; background: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 New Order Alert</h1>
            <p>Action required in admin panel</p>
        </div>

        <h2>New Order Received!</h2>
        <p>A new order has been placed on <strong>{{site_name}}</strong>.</p>

        <div class="order-details">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Customer:</strong> {{customer_name}} ({{customer_email}})</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Payment Method:</strong> {{payment_method}}</p>
            <p><strong>Items Ordered:</strong><br>{{order_items}}</p>
        </div>

        <p>Please review and confirm the order in the admin panel.</p>

        <div style="text-align: center;">
            <a href="{{admin_url}}" class="button">🔧 Open Admin Panel</a>
        </div>

        <div class="footer">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>';
    }
}
