<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Services\EmailNotificationService;

class TestEmailTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {type=welcome} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email templates by sending sample emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $email = $this->option('email');

        if (!$email) {
            $email = $this->ask('Enter email address to send test email to:');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address provided.');
            return 1;
        }

        $this->info("Testing email template: {$type}");
        $this->info("Sending to: {$email}");

        try {
            switch ($type) {
                case 'welcome':
                    $this->testWelcomeEmail($email);
                    break;
                    
                case 'order-placed':
                    $this->testOrderPlacedEmail($email);
                    break;
                    
                case 'order-confirmed':
                    $this->testOrderConfirmedEmail($email);
                    break;
                    
                case 'order-shipped':
                    $this->testOrderShippedEmail($email);
                    break;
                    
                case 'order-delivered':
                    $this->testOrderDeliveredEmail($email);
                    break;
                    
                case 'low-stock':
                    $this->testLowStockAlert($email);
                    break;
                    
                default:
                    $this->error("Unknown email type: {$type}");
                    $this->info("Available types: welcome, order-placed, order-confirmed, order-shipped, order-delivered, low-stock");
                    return 1;
            }

            $this->info("✅ Test email sent successfully!");
            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            return 1;
        }
    }

    private function testWelcomeEmail($email)
    {
        // Create a temporary user for testing
        $user = new User([
            'name' => 'Test User',
            'email' => $email,
            'role' => 'customer'
        ]);

        EmailNotificationService::sendWelcomeEmail($user);
    }

    private function testOrderPlacedEmail($email)
    {
        // Create a mock order for testing
        $user = new User([
            'name' => 'Test Customer',
            'email' => $email
        ]);

        $order = new Order([
            'order_number' => 'TEST-' . time(),
            'total_amount' => 1500.00,
            'payment_method' => 'online',
            'order_status' => 'pending'
        ]);
        
        $order->setRelation('user', $user);

        EmailNotificationService::sendOrderPlacedEmail($order);
    }

    private function testOrderConfirmedEmail($email)
    {
        $user = new User([
            'name' => 'Test Customer',
            'email' => $email
        ]);

        $order = new Order([
            'order_number' => 'TEST-' . time(),
            'total_amount' => 1500.00,
            'payment_method' => 'online',
            'order_status' => 'confirmed',
            'estimated_delivery_date' => now()->addDays(5)
        ]);
        
        $order->setRelation('user', $user);

        EmailNotificationService::sendOrderConfirmedEmail($order);
    }

    private function testOrderShippedEmail($email)
    {
        $user = new User([
            'name' => 'Test Customer',
            'email' => $email
        ]);

        $order = new Order([
            'order_number' => 'TEST-' . time(),
            'total_amount' => 1500.00,
            'payment_method' => 'online',
            'order_status' => 'in_transit',
            'awb_number' => 'AWB123456789',
            'courier_company' => 'Blue Dart',
            'estimated_delivery_date' => now()->addDays(2)
        ]);
        
        $order->setRelation('user', $user);

        EmailNotificationService::sendOrderShippedEmail($order);
    }

    private function testOrderDeliveredEmail($email)
    {
        $user = new User([
            'name' => 'Test Customer',
            'email' => $email
        ]);

        $order = new Order([
            'order_number' => 'TEST-' . time(),
            'total_amount' => 1500.00,
            'payment_method' => 'online',
            'order_status' => 'delivered',
            'delivered_at' => now()
        ]);
        
        $order->setRelation('user', $user);

        EmailNotificationService::sendOrderDeliveredEmail($order);
    }

    private function testLowStockAlert($email)
    {
        $product = new Product([
            'name' => 'Test Product',
            'sku' => 'TEST-SKU-001',
            'stock_quantity' => 5,
            'low_stock_threshold' => 10,
            'manage_stock' => true
        ]);

        EmailNotificationService::sendLowStockAlert($product);
    }
}
