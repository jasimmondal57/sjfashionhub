<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\WhatsAppTemplate;
use App\Models\CommunicationTemplate;
use Illuminate\Support\Facades\DB;

echo "Creating all notification templates...\n\n";

// ============================================
// WHATSAPP TEMPLATES
// ============================================

$whatsappTemplates = [
    // Order Confirmed
    [
        'name' => 'order_confirmed_sjfashion',
        'display_name' => 'Order Confirmed - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "✅ *Order Confirmed!*\n\nHi {{1}},\n\nYour order #{{2}} has been confirmed and is being prepared for shipment.\n\n💰 Amount: ₹{{3}}\n📦 Items: {{4}}\n\nWe'll notify you once it's ready to ship!\n\nThank you for shopping with SJ Fashion Hub! 🛍️",
        'footer_text' => 'Track your order anytime on our website',
        'buttons' => null,
        'example_values' => ['Rahul Kumar', 'ORD123456', '2499.00', '3']
    ],
    
    // Ready to Ship
    [
        'name' => 'ready_to_ship_sjfashion',
        'display_name' => 'Ready to Ship - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "📦 *Ready to Ship!*\n\nHi {{1}},\n\nGreat news! Your order #{{2}} is packed and ready to ship.\n\n📋 Items: {{3}}\n💰 Total: ₹{{4}}\n\nIt will be shipped soon. We'll send you tracking details once it's dispatched.\n\nThank you for your patience! 🙏",
        'footer_text' => 'SJ Fashion Hub - Your Style Partner',
        'buttons' => null,
        'example_values' => ['Priya Sharma', 'ORD123457', '2', '1899.00']
    ],
    
    // Order Cancelled
    [
        'name' => 'order_cancelled_sjfashion',
        'display_name' => 'Order Cancelled - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "❌ *Order Cancelled*\n\nHi {{1}},\n\nYour order #{{2}} has been cancelled.\n\n💰 Amount: ₹{{3}}\n\nReason: {{4}}\n\nIf you paid online, your refund will be processed within 5-7 business days.\n\nFor any questions, please contact our support team.",
        'footer_text' => 'We hope to serve you again soon!',
        'buttons' => null,
        'example_values' => ['Amit Singh', 'ORD123458', '3299.00', 'Customer request']
    ],
    
    // Order RTO
    [
        'name' => 'order_rto_sjfashion',
        'display_name' => 'Order RTO - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "🔄 *Order Returned to Origin*\n\nHi {{1}},\n\nYour order #{{2}} could not be delivered and is being returned to us.\n\n💰 Amount: ₹{{3}}\n\nReason: {{4}}\n\nYour refund will be processed once we receive the package.\n\nPlease contact us if you'd like to re-order.",
        'footer_text' => 'SJ Fashion Hub Support Team',
        'buttons' => null,
        'example_values' => ['Neha Patel', 'ORD123459', '2799.00', 'Delivery failed - Customer unavailable']
    ],
    
    // Return Request Submitted
    [
        'name' => 'return_request_sjfashion',
        'display_name' => 'Return Request Submitted - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "🔄 *Return Request Received*\n\nHi {{1}},\n\nWe've received your return request for order #{{2}}.\n\n📋 Return ID: {{3}}\n💰 Amount: ₹{{4}}\n\nOur team will review your request and get back to you within 24-48 hours.\n\nThank you for your patience! 🙏",
        'footer_text' => 'SJ Fashion Hub Returns Team',
        'buttons' => null,
        'example_values' => ['Vikram Reddy', 'ORD123460', 'RET123001', '1999.00']
    ],
    
    // Return Approved
    [
        'name' => 'return_approved_sjfashion',
        'display_name' => 'Return Approved - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "✅ *Return Request Approved!*\n\nHi {{1}},\n\nYour return request #{{2}} for order #{{3}} has been approved!\n\n💰 Refund Amount: ₹{{4}}\n\nPlease pack the items securely. Our courier partner will pick up the package soon.\n\nYou'll receive pickup details shortly. 📦",
        'footer_text' => 'Thank you for your cooperation!',
        'buttons' => null,
        'example_values' => ['Sneha Gupta', 'RET123002', 'ORD123461', '2499.00']
    ],
    
    // Return Rejected
    [
        'name' => 'return_rejected_sjfashion',
        'display_name' => 'Return Rejected - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "❌ *Return Request Rejected*\n\nHi {{1}},\n\nWe're sorry, but your return request #{{2}} for order #{{3}} has been rejected.\n\nReason: {{4}}\n\nIf you have any questions or concerns, please contact our support team.\n\nWe're here to help! 💬",
        'footer_text' => 'SJ Fashion Hub Support',
        'buttons' => null,
        'example_values' => ['Rajesh Kumar', 'RET123003', 'ORD123462', 'Return period expired']
    ],
    
    // Return In Transit
    [
        'name' => 'return_in_transit_sjfashion',
        'display_name' => 'Return In Transit - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "🚚 *Return Package In Transit*\n\nHi {{1}},\n\nYour return package for order #{{2}} is on its way to us!\n\n📦 Return ID: {{3}}\n🚛 Tracking ID: {{4}}\n\nWe'll process your refund once we receive and verify the items.\n\nThank you! 🙏",
        'footer_text' => 'Expected to reach us in 3-5 days',
        'buttons' => null,
        'example_values' => ['Kavita Joshi', 'ORD123463', 'RET123004', 'RTN987654321']
    ],
    
    // Return Received
    [
        'name' => 'return_received_sjfashion',
        'display_name' => 'Return Received - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "📦 *Return Package Received!*\n\nHi {{1}},\n\nWe've received your return package for order #{{2}}.\n\n📋 Return ID: {{3}}\n\nOur quality team is verifying the items. Your refund will be processed within 2-3 business days.\n\nThank you for your patience! 🙏",
        'footer_text' => 'SJ Fashion Hub Returns Team',
        'buttons' => null,
        'example_values' => ['Deepak Verma', 'ORD123464', 'RET123005']
    ],
    
    // Return Refund Processed
    [
        'name' => 'return_refund_processed_sjfashion',
        'display_name' => 'Return Refund Processed - SJ Fashion Hub',
        'category' => 'UTILITY',
        'language' => 'en',
        'header_type' => null,
        'header_text' => null,
        'body_text' => "💰 *Refund Processed Successfully!*\n\nHi {{1}},\n\nYour refund for return #{{2}} has been processed!\n\n💵 Refund Amount: ₹{{3}}\n💳 Method: {{4}}\n\nThe amount will reflect in your account within 5-7 business days.\n\nThank you for shopping with us! We hope to serve you again soon! 🛍️",
        'footer_text' => 'SJ Fashion Hub - Your Style Partner',
        'buttons' => null,
        'example_values' => ['Anjali Mehta', 'RET123006', '1799.00', 'Original payment method']
    ],
];

echo "Creating WhatsApp templates...\n";
foreach ($whatsappTemplates as $template) {
    $existing = WhatsAppTemplate::where('name', $template['name'])->first();
    
    if ($existing) {
        echo "  ⚠️  Template '{$template['name']}' already exists (ID: {$existing->id})\n";
        continue;
    }
    
    $whatsappTemplate = WhatsAppTemplate::create([
        'name' => $template['name'],
        'display_name' => $template['display_name'],
        'category' => $template['category'],
        'language' => $template['language'],
        'header_type' => $template['header_type'],
        'header_text' => $template['header_text'],
        'body_text' => $template['body_text'],
        'footer_text' => $template['footer_text'],
        'buttons' => $template['buttons'],
        'example_values' => json_encode($template['example_values']),
        'status' => 'draft',
        'is_active' => true,
    ]);
    
    echo "  ✅ Created WhatsApp template: {$template['display_name']} (ID: {$whatsappTemplate->id})\n";
}

echo "\n";
echo "WhatsApp templates created successfully!\n";
echo "Total templates: " . WhatsAppTemplate::count() . "\n\n";

echo "Now submitting WhatsApp templates to Meta for approval...\n\n";

// Submit all draft templates to Meta
$draftTemplates = WhatsAppTemplate::where('status', 'draft')->get();

foreach ($draftTemplates as $template) {
    echo "Submitting: {$template->display_name}...\n";
    
    try {
        $result = $template->submitToWhatsApp();
        
        if ($result['success']) {
            echo "  ✅ Submitted successfully! Template ID: {$result['template_id']}\n";
        } else {
            echo "  ❌ Failed: {$result['message']}\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Error: " . $e->getMessage() . "\n";
    }
    
    sleep(1); // Rate limiting
}

echo "\n✅ All WhatsApp templates submitted to Meta!\n\n";

// ============================================
// EMAIL TEMPLATES
// ============================================

echo "Creating Email templates...\n";

$emailTemplates = [
    // Order Confirmed
    [
        'event' => 'order_confirmed_customer',
        'name' => 'Order Confirmed - Customer',
        'subject' => 'Order Confirmed - {{order_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour order #{{order_number}} has been confirmed!\n\nOrder Details:\n- Total Amount: ₹{{order_total}}\n- Items: {{item_count}}\n- Payment Method: {{payment_method}}\n\nYour order is being prepared for shipment. We'll notify you once it's ready to ship.\n\nThank you for shopping with SJ Fashion Hub!",
    ],

    // Ready to Ship
    [
        'event' => 'order_ready_to_ship_customer',
        'name' => 'Order Ready to Ship - Customer',
        'subject' => 'Order Ready to Ship - {{order_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nGreat news! Your order #{{order_number}} is packed and ready to ship.\n\nOrder Details:\n- Items: {{item_count}}\n- Total: ₹{{order_total}}\n\nIt will be shipped soon. We'll send you tracking details once it's dispatched.\n\nThank you for your patience!",
    ],

    // Out for Delivery
    [
        'event' => 'order_out_for_delivery_customer',
        'name' => 'Order Out for Delivery - Customer',
        'subject' => 'Out for Delivery - {{order_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour order #{{order_number}} is out for delivery!\n\nDelivery Details:\n- Expected Delivery: Today\n- Delivery Address: {{delivery_address}}\n\nPlease keep your phone handy. Our delivery partner will contact you shortly.\n\nThank you!",
    ],

    // Order Cancelled
    [
        'event' => 'order_cancelled_customer',
        'name' => 'Order Cancelled - Customer',
        'subject' => 'Order Cancelled - {{order_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour order #{{order_number}} has been cancelled.\n\nOrder Amount: ₹{{order_total}}\nReason: {{cancellation_reason}}\n\nIf you paid online, your refund will be processed within 5-7 business days.\n\nFor any questions, please contact our support team.",
    ],

    // Order RTO
    [
        'event' => 'order_rto_customer',
        'name' => 'Order RTO - Customer',
        'subject' => 'Order Returned to Origin - {{order_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour order #{{order_number}} could not be delivered and is being returned to us.\n\nOrder Amount: ₹{{order_total}}\nReason: {{rto_reason}}\n\nYour refund will be processed once we receive the package.\n\nPlease contact us if you'd like to re-order.",
    ],

    // Return Approved
    [
        'event' => 'return_approved_customer',
        'name' => 'Return Approved - Customer',
        'subject' => 'Return Request Approved - {{return_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour return request #{{return_number}} for order #{{order_number}} has been approved!\n\nRefund Amount: ₹{{refund_amount}}\n\nPlease pack the items securely. Our courier partner will pick up the package soon.\n\nYou'll receive pickup details shortly.",
    ],

    // Return Rejected
    [
        'event' => 'return_rejected_customer',
        'name' => 'Return Rejected - Customer',
        'subject' => 'Return Request Rejected - {{return_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nWe're sorry, but your return request #{{return_number}} for order #{{order_number}} has been rejected.\n\nReason: {{rejection_reason}}\n\nIf you have any questions or concerns, please contact our support team.\n\nWe're here to help!",
    ],

    // Return In Transit
    [
        'event' => 'return_in_transit_customer',
        'name' => 'Return In Transit - Customer',
        'subject' => 'Return Package In Transit - {{return_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour return package for order #{{order_number}} is on its way to us!\n\nReturn ID: {{return_number}}\nTracking ID: {{tracking_id}}\n\nWe'll process your refund once we receive and verify the items.\n\nThank you!",
    ],

    // Return Received
    [
        'event' => 'return_received_customer',
        'name' => 'Return Received - Customer',
        'subject' => 'Return Package Received - {{return_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nWe've received your return package for order #{{order_number}}.\n\nReturn ID: {{return_number}}\n\nOur quality team is verifying the items. Your refund will be processed within 2-3 business days.\n\nThank you for your patience!",
    ],

    // Return Refund Processed
    [
        'event' => 'return_refund_processed_customer',
        'name' => 'Refund Processed - Customer',
        'subject' => 'Refund Processed - {{return_number}} | SJ Fashion Hub',
        'content' => "Hi {{customer_name}},\n\nYour refund for return #{{return_number}} has been processed!\n\nRefund Amount: ₹{{refund_amount}}\nMethod: {{refund_method}}\n\nThe amount will reflect in your account within 5-7 business days.\n\nThank you for shopping with us! We hope to serve you again soon!",
    ],
];

foreach ($emailTemplates as $template) {
    $existing = CommunicationTemplate::where('type', 'email')
        ->where('event', $template['event'])
        ->first();

    if ($existing) {
        echo "  ⚠️  Email template '{$template['event']}' already exists\n";
        continue;
    }

    CommunicationTemplate::create([
        'name' => $template['name'],
        'type' => 'email',
        'category' => 'transactional',
        'event' => $template['event'],
        'subject' => $template['subject'],
        'content' => $template['content'],
        'html_content' => null,
        'variables' => json_encode(['customer_name', 'order_number', 'order_total', 'item_count']),
        'language' => 'en',
        'is_active' => true,
        'is_default' => true,
    ]);

    echo "  ✅ Created email template: {$template['name']}\n";
}

echo "\n✅ All Email templates created!\n\n";

// ============================================
// SMS TEMPLATES
// ============================================

echo "Creating SMS templates...\n";

$smsTemplates = [
    ['event' => 'order_confirmed_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is confirmed! Amount: Rs.{{order_total}}. We will notify you once shipped. -SJ Fashion Hub'],
    ['event' => 'order_ready_to_ship_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is ready to ship! It will be dispatched soon. -SJ Fashion Hub'],
    ['event' => 'order_shipped_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is shipped! Track: {{tracking_id}}. Expected delivery: {{delivery_date}}. -SJ Fashion Hub'],
    ['event' => 'order_out_for_delivery_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is out for delivery! Please keep your phone handy. -SJ Fashion Hub'],
    ['event' => 'order_delivered_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is delivered! Thank you for shopping with SJ Fashion Hub!'],
    ['event' => 'order_cancelled_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is cancelled. Refund will be processed in 5-7 days. -SJ Fashion Hub'],
    ['event' => 'order_rto_customer', 'content' => 'Hi {{customer_name}}, your order #{{order_number}} is returned. Refund will be processed once received. -SJ Fashion Hub'],
    ['event' => 'return_request_submitted_customer', 'content' => 'Hi {{customer_name}}, return request #{{return_number}} received. We will review within 24-48 hours. -SJ Fashion Hub'],
    ['event' => 'return_approved_customer', 'content' => 'Hi {{customer_name}}, return #{{return_number}} approved! Pickup will be scheduled soon. -SJ Fashion Hub'],
    ['event' => 'return_rejected_customer', 'content' => 'Hi {{customer_name}}, return #{{return_number}} rejected. Reason: {{rejection_reason}}. Contact support for help. -SJ Fashion Hub'],
    ['event' => 'return_in_transit_customer', 'content' => 'Hi {{customer_name}}, return package #{{return_number}} is in transit. Track: {{tracking_id}}. -SJ Fashion Hub'],
    ['event' => 'return_received_customer', 'content' => 'Hi {{customer_name}}, return #{{return_number}} received! Refund will be processed in 2-3 days. -SJ Fashion Hub'],
    ['event' => 'return_refund_processed_customer', 'content' => 'Hi {{customer_name}}, refund of Rs.{{refund_amount}} processed for return #{{return_number}}. Amount will reflect in 5-7 days. -SJ Fashion Hub'],
    ['event' => 'user_registered', 'content' => 'Welcome to SJ Fashion Hub, {{customer_name}}! Explore our latest collection. Happy Shopping!'],
];

foreach ($smsTemplates as $template) {
    $existing = CommunicationTemplate::where('type', 'sms')
        ->where('event', $template['event'])
        ->first();

    if ($existing) {
        echo "  ⚠️  SMS template '{$template['event']}' already exists\n";
        continue;
    }

    CommunicationTemplate::create([
        'name' => ucwords(str_replace('_', ' ', $template['event'])),
        'type' => 'sms',
        'category' => 'transactional',
        'event' => $template['event'],
        'subject' => null,
        'content' => $template['content'],
        'html_content' => null,
        'variables' => json_encode(['customer_name', 'order_number']),
        'language' => 'en',
        'is_active' => true,
        'is_default' => true,
    ]);

    echo "  ✅ Created SMS template: {$template['event']}\n";
}

echo "\n✅ All SMS templates created!\n\n";
echo "========================================\n";
echo "SUMMARY:\n";
echo "========================================\n";
echo "WhatsApp Templates: " . WhatsAppTemplate::count() . "\n";
echo "Email Templates: " . CommunicationTemplate::where('type', 'email')->count() . "\n";
echo "SMS Templates: " . CommunicationTemplate::where('type', 'sms')->count() . "\n";
echo "========================================\n";

