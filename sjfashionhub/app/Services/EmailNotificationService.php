<?php

namespace App\Services;

use App\Models\CommunicationTemplate;
use App\Models\CommunicationLog;
use App\Models\CommunicationSetting;
use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\User;
use App\Models\Product;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotificationService
{
    /**
     * Send order placed notifications to customer (email, SMS, WhatsApp based on preferences)
     */
    public static function sendOrderPlacedNotifications(Order $order)
    {
        $preferences = self::getUserNotificationPreferences($order->user);

        if ($preferences['email']) {
            self::sendOrderPlacedEmail($order);
        }

        if ($preferences['sms']) {
            self::sendOrderPlacedSms($order);
        }

        if ($preferences['whatsapp']) {
            self::sendOrderPlacedWhatsApp($order);
        }
    }

    /**
     * Send order shipped notifications to customer (email, SMS, WhatsApp based on preferences)
     */
    public static function sendOrderShippedNotifications(Order $order)
    {
        $preferences = self::getUserNotificationPreferences($order->user);

        if ($preferences['email']) {
            self::sendOrderShippedEmail($order);
        }

        if ($preferences['sms']) {
            self::sendOrderShippedSms($order);
        }

        if ($preferences['whatsapp']) {
            self::sendOrderShippedWhatsApp($order);
        }
    }

    /**
     * Send order delivered notifications to customer (email, SMS, WhatsApp based on preferences)
     */
    public static function sendOrderDeliveredNotifications(Order $order)
    {
        $preferences = self::getUserNotificationPreferences($order->user);

        if ($preferences['email']) {
            self::sendOrderDeliveredEmail($order);
        }

        if ($preferences['sms']) {
            self::sendOrderDeliveredSms($order);
        }

        if ($preferences['whatsapp']) {
            self::sendOrderDeliveredWhatsApp($order);
        }
    }

    /**
     * Send order out for delivery notifications to customer (email, SMS, WhatsApp based on preferences)
     */
    public static function sendOrderOutForDeliveryNotifications(Order $order)
    {
        $preferences = self::getUserNotificationPreferences($order->user);

        if ($preferences['email']) {
            self::sendOrderOutForDeliveryEmail($order);
        }

        if ($preferences['sms']) {
            self::sendOrderOutForDeliverySms($order);
        }

        if ($preferences['whatsapp']) {
            self::sendOrderOutForDeliveryWhatsApp($order);
        }
    }

    /**
     * Send order placed email to customer
     */
    public static function sendOrderPlacedEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_placed_customer');
            if (!$template) {
                Log::warning('Order placed email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'order_total' => number_format($order->total_amount, 2),
                'payment_method' => ucfirst($order->payment_method),
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub'),
                'site_url' => config('app.url')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order confirmed email to customer
     */
    public static function sendOrderConfirmedEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_confirmed_customer');
            if (!$template) {
                Log::warning('Order confirmed email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'order_total' => number_format($order->total_amount, 2),
                'estimated_delivery' => $order->estimated_delivery_date ? $order->estimated_delivery_date->format('M d, Y') : '5-7 business days',
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmed email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order ready to ship email to customer
     */
    public static function sendOrderReadyToShipEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_ready_to_ship_customer');
            if (!$template) {
                Log::warning('Order ready to ship email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'estimated_delivery' => $order->estimated_delivery_date ? $order->estimated_delivery_date->format('M d, Y') : '3-5 business days',
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order ready to ship email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order shipped email to customer
     */
    public static function sendOrderShippedEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_shipped_customer');
            if (!$template) {
                Log::warning('Order shipped email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'tracking_number' => $order->awb_number ?? 'Will be updated soon',
                'courier_company' => $order->courier_company ?? 'Our delivery partner',
                'estimated_delivery' => $order->estimated_delivery_date ? $order->estimated_delivery_date->format('M d, Y') : '2-3 business days',
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order out for delivery email to customer
     */
    public static function sendOrderOutForDeliveryEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_out_for_delivery_customer');
            if (!$template) {
                Log::warning('Order out for delivery email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'tracking_number' => $order->awb_number ?? 'N/A',
                'courier_company' => $order->courier_company ?? 'Our delivery partner',
                'delivery_date' => 'Today',
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order out for delivery email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order delivered email to customer
     */
    public static function sendOrderDeliveredEmail(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_delivered_customer');
            if (!$template) {
                Log::warning('Order delivered email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'delivery_date' => $order->delivered_at ? $order->delivered_at->format('M d, Y') : now()->format('M d, Y'),
                'return_policy_url' => route('pages.show', 'return-policy'),
                'review_url' => route('home') . '#reviews',
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order delivered email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order cancelled email to customer
     */
    public static function sendOrderCancelledEmail(Order $order, $reason = 'Order cancelled by admin')
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'order_cancelled_customer');
            if (!$template) {
                Log::warning('Order cancelled email template not found');
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'cancellation_reason' => $reason,
                'refund_amount' => number_format($order->total_amount, 2),
                'refund_timeline' => $order->payment_method === 'cod' ? 'No refund needed (COD order)' : '5-7 business days',
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $order->user->email, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order cancelled email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send new order alert to admin
     */
    public static function sendNewOrderAdminAlert(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'new_order_admin');
            if (!$template) {
                Log::warning('New order admin alert template not found');
                return false;
            }

            // Get admin emails
            $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email')->toArray();
            if (empty($adminEmails)) {
                Log::warning('No admin emails found for order alert');
                return false;
            }

            // Format order items
            $orderItems = $order->items->map(function ($item) {
                return "- {$item->product->name} (Qty: {$item->quantity}) - ₹" . number_format($item->price * $item->quantity, 2);
            })->join("\n");

            $variables = [
                'order_number' => $order->order_number,
                'customer_name' => $order->user->name ?? 'Guest Customer',
                'customer_email' => $order->user->email ?? 'N/A',
                'order_total' => number_format($order->total_amount, 2),
                'payment_method' => ucfirst($order->payment_method),
                'order_items' => $orderItems,
                'admin_url' => route('admin.orders.show', $order),
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            // Send to all admins
            $sent = false;
            foreach ($adminEmails as $email) {
                if (self::sendEmail($template, $email, $variables, $order)) {
                    $sent = true;
                }
            }

            return $sent;
        } catch (\Exception $e) {
            Log::error('Failed to send new order admin alert: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome notifications to new user (email, WhatsApp based on preferences)
     */
    public static function sendWelcomeNotifications(User $user)
    {
        $preferences = self::getUserNotificationPreferences($user);

        if ($preferences['email']) {
            self::sendWelcomeEmail($user);
        }

        if ($preferences['whatsapp'] && $user->phone) {
            self::sendWelcomeWhatsApp($user);
        }
    }

    /**
     * Send welcome email to new user
     */
    public static function sendWelcomeEmail(User $user)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'user_registered');
            if (!$template) {
                Log::warning('Welcome email template not found');
                return false;
            }

            $variables = [
                'user_name' => $user->name,
                'user_email' => $user->email,
                'site_name' => config('app.name', 'SJ Fashion Hub'),
                'site_url' => config('app.url'),
                'login_url' => route('login')
            ];

            return self::sendEmail($template, $user->email, $variables);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send welcome WhatsApp to new user
     */
    public static function sendWelcomeWhatsApp(User $user)
    {
        try {
            if (!$user->phone) {
                return false;
            }

            // Use WhatsApp template
            $whatsappService = new WhatsAppService();
            $templateName = 'welcome_message_sjfashion';

            $parameters = [
                $user->name ?? 'Customer',
            ];

            return $whatsappService->sendTemplateMessage($user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send welcome WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return request submitted email to customer
     */
    public static function sendReturnRequestSubmittedEmail(ReturnOrder $returnOrder)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'return_request_submitted_customer');
            if (!$template) {
                Log::warning('Return request submitted email template not found');
                return false;
            }

            // Build return items list from JSON data
            $returnItems = '';
            if ($returnOrder->return_items && is_array($returnOrder->return_items)) {
                foreach ($returnOrder->return_items as $item) {
                    $returnItems .= "- " . ($item['product_name'] ?? 'Product') . " (Qty: " . ($item['quantity'] ?? 1) . ")\n";
                }
            }

            $variables = [
                'user_name' => $returnOrder->user->name ?? 'Customer',
                'return_number' => $returnOrder->return_number,
                'order_number' => $returnOrder->order->order_number,
                'return_reason' => $returnOrder->return_reason,
                'return_items' => $returnItems,
                'processing_timeline' => '2-3 business days',
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $returnOrder->user->email, $variables, $returnOrder->order);
        } catch (\Exception $e) {
            Log::error('Failed to send return request submitted email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return approved email to customer
     */
    public static function sendReturnApprovedEmail(ReturnOrder $returnOrder)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'return_approved_customer');
            if (!$template) {
                Log::warning('Return approved email template not found');
                return false;
            }

            $variables = [
                'user_name' => $returnOrder->user->name ?? 'Customer',
                'return_number' => $returnOrder->return_number,
                'pickup_date' => $returnOrder->pickup_date ? $returnOrder->pickup_date->format('M d, Y') : 'Will be scheduled soon',
                'pickup_instructions' => 'Please keep the items ready in original packaging. Our courier will contact you before pickup.',
                'refund_amount' => number_format($returnOrder->refund_amount, 2),
                'refund_timeline' => '5-7 business days after item verification',
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendEmail($template, $returnOrder->user->email, $variables, $returnOrder->order);
        } catch (\Exception $e) {
            Log::error('Failed to send return approved email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return request alert to admin
     */
    public static function sendReturnRequestAdminAlert(ReturnOrder $returnOrder)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'return_request_admin');
            if (!$template) {
                Log::warning('Return request admin alert template not found');
                return false;
            }

            // Get admin emails
            $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email')->toArray();
            if (empty($adminEmails)) {
                Log::warning('No admin emails found for return alert');
                return false;
            }

            $returnItems = $returnOrder->items->map(function ($item) {
                return "- {$item->product->name} (Qty: {$item->quantity})";
            })->join("\n");

            $variables = [
                'return_number' => $returnOrder->return_number,
                'order_number' => $returnOrder->order->order_number,
                'customer_name' => $returnOrder->user->name ?? 'Guest Customer',
                'return_reason' => $returnOrder->reason,
                'return_items' => $returnItems,
                'admin_url' => route('admin.return-orders.show', $returnOrder),
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            // Send to all admins
            $sent = false;
            foreach ($adminEmails as $email) {
                if (self::sendEmail($template, $email, $variables, $returnOrder->order)) {
                    $sent = true;
                }
            }

            return $sent;
        } catch (\Exception $e) {
            Log::error('Failed to send return request admin alert: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send low stock alert to admin
     */
    public static function sendLowStockAlert(Product $product)
    {
        try {
            $template = CommunicationTemplate::getByEvent('email', 'low_stock_alert_admin');
            if (!$template) {
                Log::warning('Low stock alert template not found');
                return false;
            }

            // Get admin emails
            $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email')->toArray();
            if (empty($adminEmails)) {
                Log::warning('No admin emails found for low stock alert');
                return false;
            }

            $variables = [
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'current_stock' => $product->stock_quantity,
                'threshold' => $product->low_stock_threshold ?? 10,
                'admin_url' => route('admin.products.edit', $product),
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            // Send to all admins
            $sent = false;
            foreach ($adminEmails as $email) {
                if (self::sendEmail($template, $email, $variables)) {
                    $sent = true;
                }
            }

            return $sent;
        } catch (\Exception $e) {
            Log::error('Failed to send low stock alert: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Core method to send email using template
     */
    private static function sendEmail(CommunicationTemplate $template, string $email, array $variables, $relatedModel = null)
    {
        try {
            // Configure mail settings
            MailConfigService::configure();

            // Render template content
            $rendered = $template->render($variables);
            $subject = $rendered['subject'];
            $content = $rendered['content'];
            $htmlContent = $rendered['html_content'];

            // Send email
            Mail::send([], [], function ($message) use ($email, $subject, $content, $htmlContent) {
                $message->to($email)
                        ->subject($subject)
                        ->from(config('mail.from.address', 'noreply@sjfashionhub.in'),
                               config('mail.from.name', 'SJ Fashion Hub'));

                if ($htmlContent) {
                    $message->html($htmlContent);
                } else {
                    $message->text($content);
                }
            });

            // Log communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'email',
                'provider' => 'email',
                'recipient' => $email,
                'subject' => $subject,
                'content' => $content,
                'status' => 'sent',
                'sent_at' => now(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::info("Email sent successfully to {$email} using template {$template->name}");
            return true;

        } catch (\Exception $e) {
            // Log failed communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'email',
                'provider' => 'email',
                'recipient' => $email,
                'subject' => $subject ?? 'Failed to render',
                'content' => $content ?? 'Failed to render',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::error("Failed to send email to {$email}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send SMS notification
     */
    private static function sendSms(CommunicationTemplate $template, string $phone, array $variables, $relatedModel = null)
    {
        try {
            // Render template content
            $rendered = $template->render($variables);
            $content = $rendered['content'];

            // Send SMS using SmsService
            $smsService = app(SmsService::class);
            $result = $smsService->sendSms($phone, $content);

            // Log communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'sms',
                'provider' => 'sms',
                'recipient' => $phone,
                'content' => $content,
                'status' => $result['success'] ? 'sent' : 'failed',
                'message_id' => $result['message_id'] ?? null,
                'error_message' => $result['error'] ?? null,
                'sent_at' => $result['success'] ? now() : null,
                'failed_at' => $result['success'] ? null : now(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::info("SMS sent successfully to {$phone} using template {$template->name}");
            return $result['success'];

        } catch (\Exception $e) {
            // Log failed communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'sms',
                'provider' => 'sms',
                'recipient' => $phone,
                'content' => $content ?? 'Failed to render',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'failed_at' => now(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::error("Failed to send SMS to {$phone}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send WhatsApp notification
     */
    private static function sendWhatsApp(CommunicationTemplate $template, string $phone, array $variables, $relatedModel = null)
    {
        try {
            // Render template content
            $rendered = $template->render($variables);
            $content = $rendered['content'];

            // Send WhatsApp using WhatsAppService
            $whatsappService = app(WhatsAppService::class);
            $result = $whatsappService->sendMessage($phone, $content);

            // Log communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'whatsapp',
                'provider' => 'whatsapp',
                'recipient' => $phone,
                'content' => $content,
                'status' => $result['success'] ? 'sent' : 'failed',
                'message_id' => $result['message_id'] ?? null,
                'error_message' => $result['error'] ?? null,
                'sent_at' => $result['success'] ? now() : null,
                'failed_at' => $result['success'] ? null : now(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::info("WhatsApp sent successfully to {$phone} using template {$template->name}");
            return $result['success'];

        } catch (\Exception $e) {
            // Log failed communication
            CommunicationLog::create([
                'template_id' => $template->id,
                'type' => 'whatsapp',
                'provider' => 'whatsapp',
                'recipient' => $phone,
                'content' => $content ?? 'Failed to render',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'failed_at' => now(),
                'reference_type' => $relatedModel ? get_class($relatedModel) : null,
                'reference_id' => $relatedModel ? $relatedModel->id : null,
                'user_id' => $relatedModel && method_exists($relatedModel, 'user') ? $relatedModel->user_id : null,
                'order_id' => $relatedModel instanceof Order ? $relatedModel->id : null
            ]);

            Log::error("Failed to send WhatsApp to {$phone}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user notification preferences
     */
    private static function getUserNotificationPreferences($user)
    {
        // Get global settings
        $globalSettings = CommunicationSetting::getGlobalSettings();

        // Default preferences (can be overridden by user preferences in future)
        $preferences = [
            'email' => $globalSettings['email_enabled'] ?? true,
            'sms' => $globalSettings['sms_enabled'] ?? false,
            'whatsapp' => $globalSettings['whatsapp_enabled'] ?? false
        ];

        // TODO: Add user-specific preferences from user profile
        // if ($user && $user->notification_preferences) {
        //     $userPrefs = json_decode($user->notification_preferences, true);
        //     $preferences = array_merge($preferences, $userPrefs);
        // }

        return $preferences;
    }

    /**
     * Send order placed SMS to customer
     */
    public static function sendOrderPlacedSms(Order $order)
    {
        try {
            $template = CommunicationTemplate::getByEvent('sms', 'order_placed_customer');
            if (!$template || !$order->user->phone) {
                return false;
            }

            $variables = [
                'user_name' => $order->user->name ?? 'Customer',
                'order_number' => $order->order_number,
                'order_total' => number_format($order->total_amount, 2),
                'tracking_url' => route('track-order.index') . '?order=' . $order->order_number,
                'site_name' => config('app.name', 'SJ Fashion Hub')
            ];

            return self::sendSms($template, $order->user->phone, $variables, $order);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed SMS: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order placed WhatsApp to customer
     */
    public static function sendOrderPlacedWhatsApp(Order $order)
    {
        try {
            if (!$order->user->phone) {
                return false;
            }

            // Use WhatsApp template instead of communication template
            $whatsappService = new WhatsAppService();
            $templateName = 'order_placed_sjfashion';

            // Ensure items are loaded
            if (!$order->relationLoaded('items')) {
                $order->load('items');
            }

            $itemCount = $order->items->count();
            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                number_format($order->total_amount, 2),
                (string)$itemCount,
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed WhatsApp: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send order shipped WhatsApp to customer
     */
    public static function sendOrderShippedWhatsApp(Order $order)
    {
        try {
            // Use WhatsApp template instead of communication template
            $whatsappService = new WhatsAppService();
            $templateName = 'order_shipped_sjfashion';

            // Get tracking ID - check manual shipping first, then Shiprocket
            $trackingId = $order->is_manual_shipping
                ? ($order->manual_tracking_id ?? 'Will be updated soon')
                : ($order->awb_number ?? 'Will be updated soon');

            // Get courier company - check manual shipping first, then Shiprocket
            $courierCompany = $order->is_manual_shipping
                ? ($order->manual_courier_name ?? 'Our delivery partner')
                : ($order->courier_company ?? 'Our delivery partner');

            // Get estimated delivery
            $estimatedDelivery = $order->estimated_delivery_date
                ? $order->estimated_delivery_date->format('M d, Y')
                : ($order->estimated_delivery_days ? $order->estimated_delivery_days . ' days' : '3-5 days');

            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                $trackingId,
                $courierCompany,
                $estimatedDelivery,
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order delivered WhatsApp to customer
     */
    public static function sendOrderDeliveredWhatsApp(Order $order)
    {
        try {
            // Use WhatsApp template instead of communication template
            $whatsappService = new WhatsAppService();
            $templateName = 'order_delivered_sjfashion';

            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order delivered WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order out for delivery WhatsApp to customer
     */
    public static function sendOrderOutForDeliveryWhatsApp(Order $order)
    {
        try {
            // Use WhatsApp template instead of communication template
            $whatsappService = new WhatsAppService();
            $templateName = 'order_out_for_delivery_sjfashion';

            // Format shipping address
            $shippingAddress = 'Your address';
            if (is_array($order->shipping_address)) {
                $address = $order->shipping_address;
                $parts = array_filter([
                    $address['city'] ?? null,
                    $address['state'] ?? null,
                ]);
                $shippingAddress = !empty($parts) ? implode(', ', $parts) : 'Your address';
            }

            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                $shippingAddress,
                'Today by 6 PM',
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order out for delivery WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order confirmed WhatsApp to customer
     */
    public static function sendOrderConfirmedWhatsApp(Order $order)
    {
        try {
            if (!$order->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_order_confirmed_v2';

            // Ensure items are loaded
            if (!$order->relationLoaded('items')) {
                $order->load('items');
            }

            $itemCount = $order->items->count();
            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                number_format($order->total_amount, 2),
                (string)$itemCount,
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmed WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send ready to ship WhatsApp to customer
     */
    public static function sendReadyToShipWhatsApp(Order $order)
    {
        try {
            if (!$order->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_ready_to_ship_v2';

            // Ensure items are loaded
            if (!$order->relationLoaded('items')) {
                $order->load('items');
            }

            $itemCount = $order->items->count();
            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                (string)$itemCount,
                number_format($order->total_amount, 2),
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send ready to ship WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order cancelled WhatsApp to customer
     */
    public static function sendOrderCancelledWhatsApp(Order $order)
    {
        try {
            if (!$order->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_order_cancelled_v2';

            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                number_format($order->total_amount, 2),
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order cancelled WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order RTO WhatsApp to customer
     */
    public static function sendOrderRTOWhatsApp(Order $order)
    {
        try {
            if (!$order->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_order_rto_v2';

            $parameters = [
                $order->user->name ?? 'Customer',
                $order->order_number,
                number_format($order->total_amount, 2),
            ];

            return $whatsappService->sendTemplateMessage($order->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send order RTO WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order shipped SMS to customer
     */
    public static function sendOrderShippedSms(Order $order)
    {
        try {
            $smsService = new SmsService();
            $message = "Your order #{$order->order_number} has been shipped! Track: " . route('track-order.index') . "?order=" . $order->order_number;

            return $smsService->sendSms($order->user->phone, $message);
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped SMS: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order delivered SMS to customer
     */
    public static function sendOrderDeliveredSms(Order $order)
    {
        try {
            $smsService = new SmsService();
            $message = "Your order #{$order->order_number} has been delivered! Thank you for shopping with SJ Fashion Hub.";

            return $smsService->sendSms($order->user->phone, $message);
        } catch (\Exception $e) {
            Log::error('Failed to send order delivered SMS: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order out for delivery SMS to customer
     */
    public static function sendOrderOutForDeliverySms(Order $order)
    {
        try {
            $smsService = new SmsService();
            $message = "Your order #{$order->order_number} is out for delivery and will reach you soon!";

            return $smsService->sendSms($order->user->phone, $message);
        } catch (\Exception $e) {
            Log::error('Failed to send order out for delivery SMS: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return request WhatsApp to customer
     */
    public static function sendReturnRequestWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_return_request_v2';

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->order->order_number,
                $returnOrder->return_number,
                number_format($returnOrder->return_amount, 2),
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send return request WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return approved WhatsApp to customer
     */
    public static function sendReturnApprovedWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_return_approved_v2';

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->return_number,
                $returnOrder->order->order_number,
                number_format($returnOrder->refund_amount ?? $returnOrder->return_amount, 2),
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send return approved WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return rejected WhatsApp to customer
     */
    public static function sendReturnRejectedWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_return_rejected_v2';

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->return_number,
                $returnOrder->order->order_number,
                $returnOrder->rejection_reason ?? 'Return period expired',
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send return rejected WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return in transit WhatsApp to customer
     */
    public static function sendReturnInTransitWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_return_in_transit_v2';

            $trackingId = $returnOrder->is_manual_return
                ? ($returnOrder->manual_return_tracking_id ?? 'TBD')
                : ($returnOrder->return_awb_number ?? 'TBD');

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->order->order_number,
                $returnOrder->return_number,
                $trackingId,
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send return in transit WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send return received WhatsApp to customer
     */
    public static function sendReturnReceivedWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_return_received_v2';

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->order->order_number,
                $returnOrder->return_number,
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send return received WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send refund processed WhatsApp to customer
     */
    public static function sendRefundProcessedWhatsApp(ReturnOrder $returnOrder)
    {
        try {
            if (!$returnOrder->user->phone) {
                return false;
            }

            $whatsappService = new WhatsAppService();
            $templateName = 'sjfashion_refund_processed_v2';

            $refundMethod = $returnOrder->refund_method ?? 'Original payment method';

            $parameters = [
                $returnOrder->user->name ?? 'Customer',
                $returnOrder->return_number,
                number_format($returnOrder->refund_amount ?? $returnOrder->return_amount, 2),
                $refundMethod,
            ];

            return $whatsappService->sendTemplateMessage($returnOrder->user->phone, $templateName, $parameters);
        } catch (\Exception $e) {
            Log::error('Failed to send refund processed WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
