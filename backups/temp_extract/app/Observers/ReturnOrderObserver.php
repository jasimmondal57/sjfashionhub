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
            
            // Send return request alert to admin
            EmailNotificationService::sendReturnRequestAdminAlert($returnOrder);
            
            Log::info("Return request emails sent for return: {$returnOrder->return_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send return request emails for return {$returnOrder->return_number}: " . $e->getMessage());
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
                
                // Send appropriate email based on new status
                switch ($newStatus) {
                    case 'approved':
                        EmailNotificationService::sendReturnApprovedEmail($returnOrder);
                        break;
                        
                    case 'rejected':
                        // Could add a return rejected email template
                        Log::info("Return rejected for return: {$returnOrder->return_number}");
                        break;
                        
                    case 'completed':
                        // Could add a return completed/refund processed email template
                        Log::info("Return completed for return: {$returnOrder->return_number}");
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
