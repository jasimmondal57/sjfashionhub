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
            // Send order placed notifications (email, SMS, WhatsApp) to customer
            EmailNotificationService::sendOrderPlacedNotifications($order);

            // Send new order alert to admin
            EmailNotificationService::sendNewOrderAdminAlert($order);

            Log::info("Order created notifications sent for order: {$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order created notifications for order {$order->order_number}: " . $e->getMessage());
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
                
                // Send appropriate notifications (email, SMS, WhatsApp) based on new status
                switch ($newStatus) {
                    case 'confirmed':
                        if ($oldStatus === 'pending') {
                            EmailNotificationService::sendOrderConfirmedEmail($order);
                            EmailNotificationService::sendOrderConfirmedWhatsApp($order);
                        }
                        break;

                    case 'ready_to_ship':
                        if ($oldStatus === 'confirmed') {
                            EmailNotificationService::sendOrderReadyToShipEmail($order);
                            EmailNotificationService::sendReadyToShipWhatsApp($order);
                        }
                        break;

                    case 'in_transit':
                        EmailNotificationService::sendOrderShippedNotifications($order);
                        break;

                    case 'out_for_delivery':
                        EmailNotificationService::sendOrderOutForDeliveryNotifications($order);
                        break;

                    case 'delivered':
                        EmailNotificationService::sendOrderDeliveredNotifications($order);
                        break;

                    case 'cancelled':
                        $reason = $order->cancellation_reason ?? 'Order cancelled by admin';
                        EmailNotificationService::sendOrderCancelledEmail($order, $reason);
                        EmailNotificationService::sendOrderCancelledWhatsApp($order);
                        break;

                    case 'rto':
                        // RTO (Return to Origin)
                        EmailNotificationService::sendOrderCancelledEmail($order, 'Order returned to origin due to delivery issues');
                        EmailNotificationService::sendOrderRTOWhatsApp($order);
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
