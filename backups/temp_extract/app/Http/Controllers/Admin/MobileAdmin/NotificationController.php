<?php

namespace App\Http\Controllers\Admin\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppNotification;
use App\Models\MobileAppDevice;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display notifications page
     */
    public function index()
    {
        $notifications = MobileAppNotification::latest()->paginate(20);
        
        $stats = [
            'total_sent' => MobileAppNotification::where('status', 'sent')->count(),
            'active_devices' => MobileAppDevice::where('is_active', true)->count(),
            'delivered' => MobileAppNotification::where('status', 'sent')->count(),
            'failed' => MobileAppNotification::where('status', 'failed')->count(),
        ];

        return view('mobileadmin.notifications.index', compact('notifications', 'stats'));
    }

    /**
     * Send push notification
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:500',
            'target' => 'required|in:all,android,ios',
            'action_url' => 'nullable|string',
        ]);

        // Get target devices
        $devicesQuery = MobileAppDevice::where('is_active', true);
        
        if ($validated['target'] === 'android') {
            $devicesQuery->where('platform', 'android');
        } elseif ($validated['target'] === 'ios') {
            $devicesQuery->where('platform', 'ios');
        }

        $devices = $devicesQuery->get();

        if ($devices->isEmpty()) {
            return back()->with('error', 'No active devices found for the selected target.');
        }

        // Create notification record
        $notification = MobileAppNotification::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'data' => $validated['action_url'] ? ['action_url' => $validated['action_url']] : null,
            'status' => 'pending',
        ]);

        // Send to Firebase Cloud Messaging
        $fcmTokens = $devices->pluck('fcm_token')->toArray();
        
        try {
            $this->sendToFirebase($fcmTokens, $validated['title'], $validated['body'], $validated['action_url'] ?? null);
            
            $notification->update(['status' => 'sent', 'sent_at' => now()]);
            
            return back()->with('success', 'Notification sent successfully to ' . count($fcmTokens) . ' devices!');
        } catch (\Exception $e) {
            $notification->update(['status' => 'failed']);
            
            return back()->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }

    /**
     * Send notification to Firebase Cloud Messaging
     */
    private function sendToFirebase(array $tokens, string $title, string $body, ?string $actionUrl = null)
    {
        // This is a placeholder - you'll need to implement actual Firebase integration
        // For now, we'll just log it
        \Log::info('FCM Notification', [
            'tokens' => $tokens,
            'title' => $title,
            'body' => $body,
            'action_url' => $actionUrl,
        ]);

        // TODO: Implement actual Firebase Cloud Messaging
        // You'll need to:
        // 1. Install firebase/php-jwt or kreait/firebase-php package
        // 2. Configure Firebase credentials
        // 3. Send the notification using Firebase SDK
        
        // Example with kreait/firebase-php:
        /*
        $messaging = app('firebase.messaging');
        
        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body))
            ->withData(['action_url' => $actionUrl]);
        
        $messaging->sendMulticast($message, $tokens);
        */
    }
}

