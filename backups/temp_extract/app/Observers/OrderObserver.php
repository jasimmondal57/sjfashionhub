<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        try {
            // Send order placed email to customer
            EmailNotificationService::sendOrderPlacedEmail($order);
            
            // Send new order alert to admin
            EmailNotificationService::sendNewOrderAdminAlert($order);
            
            Log::info("Order created emails sent for order: {$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order created emails for order {$order->order_number}: " . $e->getMessage());
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        try {
            // Check if order status changed
            if ($order->isDirty('order_status')) {
                $oldStatus = $order->getOriginal('order_status');
                $newStatus = $order->order_status;
                
                Log::info("Order status changed from {$oldStatus} to {$newStatus} for order: {$order->order_number}");
                
                // Send appropriate email based on new status
                switch ($newStatus) {
                    case 'confirmed':
                    case 'ready_to_ship':
                        if ($oldStatus === 'pending') {
                            EmailNotificationService::sendOrderConfirmedEmail($order);
                        } elseif ($oldStatus === 'confirmed') {
                            EmailNotificationService::sendOrderReadyToShipEmail($order);
                        }
                        break;
                        
                    case 'in_transit':
                        EmailNotificationService::sendOrderShippedEmail($order);
                        break;
                        
                    case 'out_for_delivery':
                        EmailNotificationService::sendOrderOutForDeliveryEmail($order);
                        break;
                        
                    case 'delivered':
                        EmailNotificationService::sendOrderDeliveredEmail($order);
                        break;
                        
                    case 'cancelled':
                        $reason = $order->cancellation_reason ?? 'Order cancelled by admin';
                        EmailNotificationService::sendOrderCancelledEmail($order, $reason);
                        break;
                        
                    case 'rto':
                        // RTO (Return to Origin) - could send a specific email or treat as cancelled
                        EmailNotificationService::sendOrderCancelledEmail($order, 'Order returned to origin due to delivery issues');
                        break;
                }
                
                Log::info("Order status change email sent for order: {$order->order_number}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send order status change email for order {$order->order_number}: " . $e->getMessage());
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        // Log order deletion
        Log::info("Order deleted: {$order->order_number}");
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        // Log order restoration
        Log::info("Order restored: {$order->order_number}");
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        // Log order force deletion
        Log::info("Order force deleted: {$order->order_number}");
    }
}
