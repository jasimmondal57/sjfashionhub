<?php

namespace App\Observers;

use App\Models\ReturnOrder;
use App\Services\EmailNotificationService;
use Illuminate\Support\Facades\Log;

class ReturnOrderObserver
{
    /**
     * Handle the ReturnOrder "created" event.
     */
    public function created(ReturnOrder $returnOrder): void
    {
        try {
            // Send return request submitted email to customer
            EmailNotificationService::sendReturnRequestSubmittedEmail($returnOrder);

            // Send return request WhatsApp to customer
            EmailNotificationService::sendReturnRequestWhatsApp($returnOrder);

            // Send return request alert to admin
            EmailNotificationService::sendReturnRequestAdminAlert($returnOrder);

            Log::info("Return request notifications sent for return: {$returnOrder->return_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send return request notifications for return {$returnOrder->return_number}: " . $e->getMessage());
        }
    }

    /**
     * Handle the ReturnOrder "updated" event.
     */
    public function updated(ReturnOrder $returnOrder): void
    {
        try {
            // Check if return status changed
            if ($returnOrder->isDirty('status')) {
                $oldStatus = $returnOrder->getOriginal('status');
                $newStatus = $returnOrder->status;
                
                Log::info("Return status changed from {$oldStatus} to {$newStatus} for return: {$returnOrder->return_number}");
                
                // Send appropriate notifications based on new status
                switch ($newStatus) {
                    case 'approved':
                        EmailNotificationService::sendReturnApprovedEmail($returnOrder);
                        EmailNotificationService::sendReturnApprovedWhatsApp($returnOrder);
                        break;

                    case 'rejected':
                        EmailNotificationService::sendReturnRejectedWhatsApp($returnOrder);
                        Log::info("Return rejected for return: {$returnOrder->return_number}");
                        break;

                    case 'in_transit':
                        EmailNotificationService::sendReturnInTransitWhatsApp($returnOrder);
                        Log::info("Return in transit for return: {$returnOrder->return_number}");
                        break;

                    case 'received':
                        EmailNotificationService::sendReturnReceivedWhatsApp($returnOrder);
                        Log::info("Return received for return: {$returnOrder->return_number}");
                        break;

                    case 'pending_refund':
                    case 'completed':
                        EmailNotificationService::sendRefundProcessedWhatsApp($returnOrder);
                        Log::info("Refund processed for return: {$returnOrder->return_number}");
                        break;
                }
                
                Log::info("Return status change email sent for return: {$returnOrder->return_number}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send return status change email for return {$returnOrder->return_number}: " . $e->getMessage());
        }
    }

    /**
     * Handle the ReturnOrder "deleted" event.
     */
    public function deleted(ReturnOrder $returnOrder): void
    {
        // Log return deletion
        Log::info("Return order deleted: {$returnOrder->return_number}");
    }

    /**
     * Handle the ReturnOrder "restored" event.
     */
    public function restored(ReturnOrder $returnOrder): void
    {
        // Log return restoration
        Log::info("Return order restored: {$returnOrder->return_number}");
    }

    /**
     * Handle the ReturnOrder "force deleted" event.
     */
    public function forceDeleted(ReturnOrder $returnOrder): void
    {
        // Log return force deletion
        Log::info("Return order force deleted: {$returnOrder->return_number}");
    }
}
