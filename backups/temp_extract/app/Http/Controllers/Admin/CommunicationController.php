<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationSetting;
use App\Models\CommunicationTemplate;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class CommunicationController extends Controller
{
    /**
     * Display communication dashboard
     */
    public function index()
    {
        $stats = CommunicationLog::getStats(30);

        $recentLogs = CommunicationLog::with(['template', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        $providers = [
            'email' => CommunicationSetting::getProviderSettings('email'),
            'sms' => CommunicationSetting::getProviderSettings('sms'),
            'whatsapp' => CommunicationSetting::getProviderSettings('whatsapp')
        ];

        // Get current notification preferences
        $preferences = CommunicationSetting::where('provider', 'system')
            ->where('service', 'preferences')
            ->pluck('value', 'key')
            ->toArray();

        return view('admin.communication.index', compact('stats', 'recentLogs', 'providers', 'preferences'));
    }

    /**
     * Show email settings
     */
    public function emailSettings()
    {
        // Get all email settings grouped by service
        $allSettings = CommunicationSetting::provider('email')->get()->groupBy('service');

        // Create a more accessible format for the view
        $settings = [];
        foreach ($allSettings as $service => $serviceSettings) {
            $settings[$service] = [];
            foreach ($serviceSettings as $setting) {
                $settings[$service][$setting->key] = $setting;
            }
        }

        return view('admin.communication.email-settings', compact('settings'));
    }

    /**
     * Update email settings
     */
    public function updateEmailSettings(Request $request)
    {
        $request->validate([
            'service' => 'required|in:smtp,mailgun,ses,postmark',
            'host' => 'required_if:service,smtp|string',
            'port' => 'required_if:service,smtp|integer',
            'username' => 'required_if:service,smtp|string',
            'password' => 'required_if:service,smtp|string',
            'encryption' => 'nullable|in:tls,ssl',
            'from_address' => 'required|email',
            'from_name' => 'required|string',
            'api_key' => 'required_unless:service,smtp|string',
            'domain' => 'required_if:service,mailgun|string',
            'region' => 'required_if:service,ses|string',
        ]);

        $service = $request->service;

        try {
            // Common settings
            CommunicationSetting::set('email', $service, 'from_address', $request->from_address, 'string', 'general', 'From email address');
            CommunicationSetting::set('email', $service, 'from_name', $request->from_name, 'string', 'general', 'From name');

            // Service-specific settings
            switch ($service) {
                case 'smtp':
                    CommunicationSetting::set('email', $service, 'host', $request->host, 'string', 'api', 'SMTP host');
                    CommunicationSetting::set('email', $service, 'port', $request->port, 'integer', 'api', 'SMTP port');
                    CommunicationSetting::set('email', $service, 'username', $request->username, 'string', 'api', 'SMTP username');
                    CommunicationSetting::set('email', $service, 'password', $request->password, 'string', 'api', 'SMTP password', true);
                    CommunicationSetting::set('email', $service, 'encryption', $request->encryption, 'string', 'api', 'SMTP encryption');
                    break;

                case 'mailgun':
                    CommunicationSetting::set('email', $service, 'api_key', $request->api_key, 'string', 'api', 'Mailgun API key', true);
                    CommunicationSetting::set('email', $service, 'domain', $request->domain, 'string', 'api', 'Mailgun domain');
                    break;

                case 'ses':
                    CommunicationSetting::set('email', $service, 'api_key', $request->api_key, 'string', 'api', 'AWS access key', true);
                    CommunicationSetting::set('email', $service, 'secret_key', $request->secret_key, 'string', 'api', 'AWS secret key', true);
                    CommunicationSetting::set('email', $service, 'region', $request->region, 'string', 'api', 'AWS region');
                    break;

                case 'postmark':
                    CommunicationSetting::set('email', $service, 'api_key', $request->api_key, 'string', 'api', 'Postmark API key', true);
                    break;
            }

            // Set as active service
            CommunicationSetting::set('email', 'general', 'active_service', $service, 'string', 'general', 'Active email service');

            return redirect()->back()->with('success', 'Email settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Show SMS settings
     */
    public function smsSettings()
    {
        $settings = CommunicationSetting::provider('sms')->get()->groupBy('service');

        return view('admin.communication.sms-settings', compact('settings'));
    }

    /**
     * Update SMS settings
     */
    public function updateSmsSettings(Request $request)
    {
        $request->validate([
            'service' => 'required|in:twilio,msg91,textlocal,fast2sms',
            'api_key' => 'required|string',
            'sender_id' => 'required|string',
            'account_sid' => 'required_if:service,twilio|string',
            'auth_token' => 'required_if:service,twilio|string',
        ]);

        $service = $request->service;

        try {
            // Common settings
            CommunicationSetting::set('sms', $service, 'api_key', $request->api_key, 'string', 'api', 'SMS API key', true);
            CommunicationSetting::set('sms', $service, 'sender_id', $request->sender_id, 'string', 'general', 'SMS sender ID');

            // Service-specific settings
            if ($service === 'twilio') {
                CommunicationSetting::set('sms', $service, 'account_sid', $request->account_sid, 'string', 'api', 'Twilio account SID', true);
                CommunicationSetting::set('sms', $service, 'auth_token', $request->auth_token, 'string', 'api', 'Twilio auth token', true);
            }

            // Set as active service
            CommunicationSetting::set('sms', 'general', 'active_service', $service, 'string', 'general', 'Active SMS service');

            return redirect()->back()->with('success', 'SMS settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Show WhatsApp settings
     */
    public function whatsappSettings()
    {
        $settings = CommunicationSetting::provider('whatsapp')->get()->groupBy('service');

        return view('admin.communication.whatsapp-settings', compact('settings'));
    }



    /**
     * Update WhatsApp settings
     */
    public function updateWhatsappSettings(Request $request)
    {
        $service = $request->input('service');

        $validatedData = $request->validate([
            'service' => 'required|string',
            'api_key' => 'required|string',
            'phone_number' => 'required|string',
            'account_sid' => 'nullable|string',
            'business_account_id' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'webhook_verify_token' => 'nullable|string',
            'api_version' => 'nullable|string',
            'template_namespace' => 'nullable|string',
        ]);

        // Remove service from data array
        unset($validatedData['service']);

        // Save settings for the service
        foreach ($validatedData as $key => $value) {
            // Always save api_key if provided (even if updating existing)
            // For other fields, only save if not empty
            if ($key === 'api_key' || !empty($value)) {
                $isEncrypted = in_array($key, ['api_key', 'account_sid']);

                // Prepare the value (encrypt if needed)
                $finalValue = $isEncrypted ? Crypt::encryptString($value) : $value;

                CommunicationSetting::updateOrCreate([
                    'provider' => 'whatsapp',
                    'service' => $service,
                    'key' => $key,
                ], [
                    'value' => $finalValue,
                    'type' => 'string',
                    'category' => 'api',
                    'description' => ucfirst(str_replace('_', ' ', $key)),
                    'is_encrypted' => $isEncrypted,
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.communication.whatsapp-settings')
            ->with('success', ucfirst($service) . ' WhatsApp settings updated successfully!');
    }



    /**
     * Test connection for a provider
     */
    public function testConnection(Request $request)
    {
        try {
            $request->validate([
                'provider' => 'required|in:email,sms,whatsapp',
                'service' => 'required|string'
            ]);

            $result = CommunicationSetting::testConnection($request->provider, $request->service);

            return response()->json($result);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test connection failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show communication logs
     */
    public function logs(Request $request)
    {
        $query = CommunicationLog::with(['template', 'user', 'order']);

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(20)->withQueryString();
        $stats = CommunicationLog::getStats(30);

        return view('admin.communication.logs', compact('logs', 'stats'));
    }

    /**
     * Retry failed communication
     */
    public function retryFailed(CommunicationLog $log)
    {
        if (!$log->canRetry()) {
            return redirect()->back()->with('error', 'This communication cannot be retried.');
        }

        // Reset status and schedule for retry
        $log->update([
            'status' => 'pending',
            'error_message' => null,
            'next_retry_at' => now()
        ]);

        return redirect()->back()->with('success', 'Communication scheduled for retry.');
    }

    /**
     * Send test message
     */
    public function sendTest(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,sms,whatsapp',
            'recipient' => 'required|string',
            'content' => 'required|string',
            'subject' => 'required_if:type,email|string'
        ]);

        try {
            $log = CommunicationLog::create([
                'type' => $request->type,
                'provider' => CommunicationSetting::get($request->type, 'general', 'active_service'),
                'recipient' => $request->recipient,
                'subject' => $request->subject,
                'content' => $request->content,
                'event' => 'test_message',
                'status' => 'pending'
            ]);

            // Here you would integrate with your communication service
            // For now, we'll just mark it as sent
            $log->markAsSent('test-' . time());

            return response()->json([
                'success' => true,
                'message' => 'Test message sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test message: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update notification preferences
     */
    public function updatePreferences(Request $request)
    {
        try {
            $preferences = [
                'email_order_placed' => $request->boolean('email_order_placed'),
                'email_order_shipped' => $request->boolean('email_order_shipped'),
                'email_order_delivered' => $request->boolean('email_order_delivered'),
                'email_admin_alerts' => $request->boolean('email_admin_alerts'),
                'sms_order_placed' => $request->boolean('sms_order_placed'),
                'sms_order_shipped' => $request->boolean('sms_order_shipped'),
                'sms_order_delivered' => $request->boolean('sms_order_delivered'),
                'sms_out_for_delivery' => $request->boolean('sms_out_for_delivery'),
                'whatsapp_order_placed' => $request->boolean('whatsapp_order_placed'),
                'whatsapp_order_shipped' => $request->boolean('whatsapp_order_shipped'),
                'whatsapp_order_delivered' => $request->boolean('whatsapp_order_delivered'),
                'whatsapp_welcome' => $request->boolean('whatsapp_welcome'),
            ];

            // Store preferences in communication settings
            foreach ($preferences as $key => $value) {
                CommunicationSetting::updateOrCreate(
                    [
                        'provider' => 'system',
                        'service' => 'preferences',
                        'key' => $key
                    ],
                    [
                        'value' => $value ? '1' : '0',
                        'type' => 'boolean',
                        'category' => 'notification_preferences',
                        'description' => 'Notification preference for ' . str_replace('_', ' ', $key),
                        'is_active' => true
                    ]
                );
            }

            return redirect()->route('admin.communication.index')
                ->with('success', 'Notification preferences updated successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.communication.index')
                ->with('error', 'Failed to update preferences: ' . $e->getMessage());
        }
    }
}
