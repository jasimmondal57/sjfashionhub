<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Get user notifications
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->has('unread_only') && $request->boolean('unread_only')) {
            $query->whereNull('read_at');
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $notifications = $query->paginate($request->get('per_page', 20));

        $formattedNotifications = $notifications->getCollection()->map(function ($notification) {
            return $this->formatNotification($notification);
        });

        // Get unread count
        $unreadCount = Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'data' => $formattedNotifications,
            'unread_count' => $unreadCount,
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ]
        ]);
    }

    /**
     * Get notification settings
     */
    public function settings(Request $request)
    {
        $user = $request->user();
        
        $settings = [
            'email_notifications' => [
                'order_updates' => $user->email_order_updates ?? true,
                'promotional_emails' => $user->email_promotional ?? true,
                'newsletter' => $user->email_newsletter ?? true,
                'security_alerts' => $user->email_security ?? true
            ],
            'push_notifications' => [
                'order_updates' => $user->push_order_updates ?? true,
                'promotional_offers' => $user->push_promotional ?? true,
                'new_arrivals' => $user->push_new_arrivals ?? false,
                'price_drops' => $user->push_price_drops ?? false
            ],
            'sms_notifications' => [
                'order_updates' => $user->sms_order_updates ?? false,
                'delivery_updates' => $user->sms_delivery_updates ?? false,
                'security_alerts' => $user->sms_security ?? true
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Update notification settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'nullable|array',
            'email_notifications.order_updates' => 'nullable|boolean',
            'email_notifications.promotional_emails' => 'nullable|boolean',
            'email_notifications.newsletter' => 'nullable|boolean',
            'email_notifications.security_alerts' => 'nullable|boolean',
            'push_notifications' => 'nullable|array',
            'push_notifications.order_updates' => 'nullable|boolean',
            'push_notifications.promotional_offers' => 'nullable|boolean',
            'push_notifications.new_arrivals' => 'nullable|boolean',
            'push_notifications.price_drops' => 'nullable|boolean',
            'sms_notifications' => 'nullable|array',
            'sms_notifications.order_updates' => 'nullable|boolean',
            'sms_notifications.delivery_updates' => 'nullable|boolean',
            'sms_notifications.security_alerts' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $updateData = [];

            // Email notification settings
            if ($request->has('email_notifications')) {
                $emailSettings = $request->email_notifications;
                if (isset($emailSettings['order_updates'])) {
                    $updateData['email_order_updates'] = $emailSettings['order_updates'];
                }
                if (isset($emailSettings['promotional_emails'])) {
                    $updateData['email_promotional'] = $emailSettings['promotional_emails'];
                }
                if (isset($emailSettings['newsletter'])) {
                    $updateData['email_newsletter'] = $emailSettings['newsletter'];
                }
                if (isset($emailSettings['security_alerts'])) {
                    $updateData['email_security'] = $emailSettings['security_alerts'];
                }
            }

            // Push notification settings
            if ($request->has('push_notifications')) {
                $pushSettings = $request->push_notifications;
                if (isset($pushSettings['order_updates'])) {
                    $updateData['push_order_updates'] = $pushSettings['order_updates'];
                }
                if (isset($pushSettings['promotional_offers'])) {
                    $updateData['push_promotional'] = $pushSettings['promotional_offers'];
                }
                if (isset($pushSettings['new_arrivals'])) {
                    $updateData['push_new_arrivals'] = $pushSettings['new_arrivals'];
                }
                if (isset($pushSettings['price_drops'])) {
                    $updateData['push_price_drops'] = $pushSettings['price_drops'];
                }
            }

            // SMS notification settings
            if ($request->has('sms_notifications')) {
                $smsSettings = $request->sms_notifications;
                if (isset($smsSettings['order_updates'])) {
                    $updateData['sms_order_updates'] = $smsSettings['order_updates'];
                }
                if (isset($smsSettings['delivery_updates'])) {
                    $updateData['sms_delivery_updates'] = $smsSettings['delivery_updates'];
                }
                if (isset($smsSettings['security_alerts'])) {
                    $updateData['sms_security'] = $smsSettings['security_alerts'];
                }
            }

            $user->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notification settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|exists:notifications,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $notification = Notification::where('id', $request->notification_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Format notification data for API response
     */
    private function formatNotification($notification)
    {
        return [
            'id' => $notification->id,
            'type' => $notification->type,
            'title' => $notification->title,
            'message' => $notification->message,
            'data' => $notification->data,
            'is_read' => $notification->read_at !== null,
            'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
            'read_at' => $notification->read_at ? $notification->read_at->format('Y-m-d H:i:s') : null,
            'time_ago' => $notification->created_at->diffForHumans()
        ];
    }
}
