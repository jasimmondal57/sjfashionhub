<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationTemplate;
use Illuminate\Http\Request;

class CommunicationTemplateController extends Controller
{
    /**
     * Display a listing of templates
     */
    public function index(Request $request)
    {
        $query = CommunicationTemplate::query();

        // Apply filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $templates = $query->latest()->paginate(15)->withQueryString();

        $types = ['email', 'sms', 'whatsapp'];
        $categories = ['verification', 'notification', 'promotion', 'order', 'return', 'newsletter'];
        $languages = ['en', 'hi'];

        return view('admin.communication.templates.index', compact('templates', 'types', 'categories', 'languages'));
    }

    /**
     * Show the form for creating a new template
     */
    public function create()
    {
        $types = ['email', 'sms', 'whatsapp'];
        $categories = ['verification', 'notification', 'promotion', 'order', 'return', 'newsletter'];
        $events = $this->getEventsByCategory();
        $languages = ['en' => 'English', 'hi' => 'Hindi'];

        return view('admin.communication.templates.create', compact('types', 'categories', 'events', 'languages'));
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:email,sms,whatsapp',
            'category' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'subject' => 'required_if:type,email|string|max:255',
            'content' => 'required|string',
            'html_content' => 'nullable|string',
            'language' => 'required|string|max:10',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'priority' => 'integer|min:0|max:100',
            'description' => 'nullable|string',
            'variables' => 'nullable|array',
        ]);

        // Check for unique constraint
        $exists = CommunicationTemplate::where('type', $request->type)
            ->where('category', $request->category)
            ->where('event', $request->event)
            ->where('language', $request->language)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['event' => 'A template for this type, category, event, and language already exists.']);
        }

        $template = CommunicationTemplate::create([
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'event' => $request->event,
            'subject' => $request->subject,
            'content' => $request->content,
            'html_content' => $request->html_content,
            'language' => $request->language,
            'is_active' => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default', false),
            'priority' => $request->priority ?? 0,
            'description' => $request->description,
            'variables' => $request->variables ?? [],
        ]);

        return redirect()->route('admin.communication-templates.index')
            ->with('success', 'Template created successfully!');
    }

    /**
     * Display the specified template
     */
    public function show(CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;
        $availableVariables = $template->getAvailableVariables();

        return view('admin.communication.templates.show', compact('template', 'availableVariables'));
    }

    /**
     * Show the form for editing the template
     */
    public function edit(CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;
        $types = ['email', 'sms', 'whatsapp'];
        $categories = ['verification', 'notification', 'promotion', 'order', 'return', 'newsletter'];
        $events = $this->getEventsByCategory();
        $languages = ['en' => 'English', 'hi' => 'Hindi'];
        $availableVariables = $template->getAvailableVariables();

        return view('admin.communication.templates.edit', compact('template', 'types', 'categories', 'events', 'languages', 'availableVariables'));
    }

    /**
     * Update the specified template
     */
    public function update(Request $request, CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:email,sms,whatsapp',
            'category' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'subject' => 'required_if:type,email|string|max:255',
            'content' => 'required|string',
            'html_content' => 'nullable|string',
            'language' => 'required|string|max:10',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'priority' => 'integer|min:0|max:100',
            'description' => 'nullable|string',
            'variables' => 'nullable|array',
        ]);

        // Check for unique constraint (excluding current template)
        $exists = CommunicationTemplate::where('type', $request->type)
            ->where('category', $request->category)
            ->where('event', $request->event)
            ->where('language', $request->language)
            ->where('id', '!=', $template->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['event' => 'A template for this type, category, event, and language already exists.']);
        }

        $template->update([
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'event' => $request->event,
            'subject' => $request->subject,
            'content' => $request->content,
            'html_content' => $request->html_content,
            'language' => $request->language,
            'is_active' => $request->boolean('is_active'),
            'is_default' => $request->boolean('is_default'),
            'priority' => $request->priority ?? 0,
            'description' => $request->description,
            'variables' => $request->variables ?? [],
        ]);

        return redirect()->route('admin.communication-templates.index')
            ->with('success', 'Template updated successfully!');
    }

    /**
     * Remove the specified template
     */
    public function destroy(CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;

        // Check if template is being used
        $usageCount = $template->communicationLogs()->count();

        if ($usageCount > 0) {
            return redirect()->back()
                ->with('error', "Cannot delete template. It has been used in {$usageCount} communications.");
        }

        $template->delete();

        return redirect()->route('admin.communication-templates.index')
            ->with('success', 'Template deleted successfully!');
    }

    /**
     * Preview template with sample data
     */
    public function preview(Request $request, CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;

        // Sample variables for preview
        $sampleVariables = [
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'user_phone' => '+91 9876543210',
            'site_name' => 'SJ Fashion Hub',
            'site_url' => url('/'),
            'current_date' => now()->format('Y-m-d'),
            'current_time' => now()->format('H:i:s'),
            'order_id' => 'ORD-12345',
            'order_total' => '2,499.00',
            'order_status' => 'Shipped',
            'verification_code' => '123456',
            'coupon_code' => 'SAVE20',
            'discount_amount' => '500.00',
        ];

        $rendered = $template->render($sampleVariables);

        return response()->json([
            'success' => true,
            'preview' => $rendered
        ]);
    }

    /**
     * Duplicate a template
     */
    public function duplicate(CommunicationTemplate $communicationTemplate)
    {
        $template = $communicationTemplate;

        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (Copy)';
        $newTemplate->is_default = false;
        $newTemplate->save();

        return redirect()->route('admin.communication-templates.edit', $newTemplate)
            ->with('success', 'Template duplicated successfully!');
    }

    /**
     * Get events by category
     */
    private function getEventsByCategory()
    {
        return [
            'verification' => [
                'email_verification' => 'Email Verification',
                'phone_verification' => 'Phone Verification',
                'password_reset' => 'Password Reset',
                'account_activation' => 'Account Activation'
            ],
            'order' => [
                'order_placed' => 'Order Placed',
                'order_confirmed' => 'Order Confirmed',
                'order_shipped' => 'Order Shipped',
                'order_delivered' => 'Order Delivered',
                'order_cancelled' => 'Order Cancelled',
                'order_status_update' => 'Order Status Update'
            ],
            'notification' => [
                'welcome_message' => 'Welcome Message',
                'account_created' => 'Account Created',
                'profile_updated' => 'Profile Updated',
                'security_alert' => 'Security Alert'
            ],
            'promotion' => [
                'promotional_offer' => 'Promotional Offer',
                'discount_coupon' => 'Discount Coupon',
                'flash_sale' => 'Flash Sale',
                'newsletter_campaign' => 'Newsletter Campaign'
            ],
            'return' => [
                'return_requested' => 'Return Requested',
                'return_approved' => 'Return Approved',
                'return_rejected' => 'Return Rejected',
                'refund_processed' => 'Refund Processed'
            ],
            'newsletter' => [
                'subscription_confirmed' => 'Subscription Confirmed',
                'unsubscribe_confirmed' => 'Unsubscribe Confirmed',
                'newsletter_digest' => 'Newsletter Digest'
            ]
        ];
    }
}
