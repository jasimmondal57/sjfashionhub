<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppTemplate;
use App\Models\WhatsAppCampaign;
use App\Models\WhatsAppCampaignRecipient;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppMarketingController extends Controller
{
    /**
     * Show marketing dashboard
     */
    public function index()
    {
        $templates = WhatsAppTemplate::latest()->paginate(10);
        $campaigns = WhatsAppCampaign::with('template')->latest()->paginate(10);
        
        $stats = [
            'total_templates' => WhatsAppTemplate::count(),
            'approved_templates' => WhatsAppTemplate::where('status', 'approved')->count(),
            'pending_templates' => WhatsAppTemplate::where('status', 'pending')->count(),
            'total_campaigns' => WhatsAppCampaign::count(),
            'active_campaigns' => WhatsAppCampaign::whereIn('status', ['scheduled', 'running'])->count(),
            'total_sent' => WhatsAppCampaign::sum('sent_count'),
        ];

        return view('admin.whatsapp-marketing.index', compact('templates', 'campaigns', 'stats'));
    }

    /**
     * Show templates list
     */
    public function templates()
    {
        $templates = WhatsAppTemplate::latest()->paginate(15);
        return view('admin.whatsapp-marketing.templates.index', compact('templates'));
    }

    /**
     * Show OTP template setup page
     */
    public function otpSetup()
    {
        // Check WhatsApp credentials - use decrypted values
        $settings = \App\Models\CommunicationSetting::where('provider', 'whatsapp')
            ->where('service', 'whatsapp_business')
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->decrypted_value];
            });

        $hasCredentials = !empty($settings['api_key']) && !empty($settings['business_account_id']);

        // Find existing OTP authentication template
        $otpTemplate = WhatsAppTemplate::where('category', 'AUTHENTICATION')
            ->where(function($query) {
                $query->where('name', 'like', '%otp%')
                      ->orWhere('name', 'like', '%login%')
                      ->orWhere('name', 'like', '%verification%');
            })
            ->first();

        return view('admin.whatsapp-marketing.otp-setup', compact('otpTemplate', 'hasCredentials'));
    }

    /**
     * Store OTP template
     */
    public function storeOtpTemplate(Request $request)
    {
        try {
            $validated = $request->validate([
                'display_name' => 'required|string|max:255',
                'language' => 'required|string|max:10',
                'header_text' => 'nullable|string|max:60',
                'body_text' => 'required|string|max:1024',
                'footer_text' => 'nullable|string|max:60',
                'variable_samples' => 'required|array|min:1',
            ]);

            // Check if OTP template already exists
            $existingTemplate = WhatsAppTemplate::where('category', 'AUTHENTICATION')
                ->where(function($query) {
                    $query->where('name', 'like', '%otp%')
                          ->orWhere('name', 'like', '%login%')
                          ->orWhere('name', 'like', '%verification%');
                })
                ->first();

            if ($existingTemplate) {
                return redirect()->route('admin.whatsapp-marketing.otp-setup')
                    ->with('error', 'An OTP authentication template already exists. Please delete the existing one first or edit it.');
            }

            // Generate template name (lowercase, no spaces, no special chars)
            $name = 'otp_login_' . strtolower($validated['language']) . '_' . time();
            $name = preg_replace('/[^a-z0-9_]/', '', $name);

            // Extract variables from body text
            preg_match_all('/\{\{(\d+)\}\}/', $validated['body_text'], $matches);
            $variables = array_unique($matches[1] ?? []);

            // Prepare variable samples
            $variableSamples = [];
            foreach ($variables as $index => $varNum) {
                $variableSamples[$varNum] = $validated['variable_samples'][$index] ?? '123456';
            }

            $template = WhatsAppTemplate::create([
                'name' => $name,
                'display_name' => $validated['display_name'],
                'category' => 'AUTHENTICATION',
                'language' => $validated['language'],
                'header_text' => null, // Not allowed for AUTHENTICATION
                'header_type' => null, // Not allowed for AUTHENTICATION
                'body_text' => $validated['body_text'],
                'footer_text' => null, // Not allowed for AUTHENTICATION
                'buttons' => null, // No buttons for OTP
                'variables' => $variables,
                'variable_samples' => !empty($variableSamples) ? $variableSamples : null,
                'status' => 'draft',
            ]);

            return redirect()->route('admin.whatsapp-marketing.otp-setup')
                ->with('success', 'OTP template created successfully! Now submit it to Meta for approval.');
        } catch (\Exception $e) {
            \Log::error('OTP template creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.whatsapp-marketing.otp-setup')
                ->with('error', 'Failed to create OTP template: ' . $e->getMessage());
        }
    }

    /**
     * Show create template form
     */
    public function createTemplate()
    {
        return view('admin.whatsapp-marketing.templates.create');
    }

    /**
     * Store new template
     */
    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'category' => 'required|in:MARKETING,UTILITY,AUTHENTICATION',
            'language' => 'required|string|max:10',
            'header_text' => 'nullable|string|max:60',
            'header_type' => 'nullable|in:TEXT,IMAGE,VIDEO,DOCUMENT',
            'body_text' => 'required|string|max:1024',
            'footer_text' => 'nullable|string|max:60',
            'buttons' => 'nullable|array',
            'variable_samples' => 'nullable|array',
        ]);

        // Generate template name (lowercase, no spaces)
        $name = Str::slug($validated['display_name'], '_');
        $name = strtolower(preg_replace('/[^a-z0-9_]/', '', $name));

        // Check if name exists
        $counter = 1;
        $originalName = $name;
        while (WhatsAppTemplate::where('name', $name)->exists()) {
            $name = $originalName . '_' . $counter;
            $counter++;
        }

        // Extract variables from header and body
        $allText = ($validated['header_text'] ?? '') . ' ' . $validated['body_text'];
        preg_match_all('/\{\{(\d+)\}\}/', $allText, $matches);
        $variables = !empty($matches[1]) ? array_unique($matches[1]) : [];

        // Clean up variable samples - remove empty values
        $variableSamples = [];
        if (isset($validated['variable_samples']) && is_array($validated['variable_samples'])) {
            foreach ($validated['variable_samples'] as $sample) {
                if (!empty(trim($sample))) {
                    $variableSamples[] = trim($sample);
                }
            }
        }

        $template = WhatsAppTemplate::create([
            'name' => $name,
            'display_name' => $validated['display_name'],
            'category' => $validated['category'],
            'language' => $validated['language'],
            'header_text' => $validated['header_text'] ?? null,
            'header_type' => $validated['header_type'] ?? null,
            'body_text' => $validated['body_text'],
            'footer_text' => $validated['footer_text'] ?? null,
            'buttons' => $validated['buttons'] ?? null,
            'variables' => $variables,
            'variable_samples' => !empty($variableSamples) ? $variableSamples : null,
            'status' => 'draft',
        ]);

        return redirect()->route('admin.whatsapp-marketing.templates.show', $template)
            ->with('success', 'Template created successfully!');
    }

    /**
     * Show template details
     */
    public function showTemplate(WhatsAppTemplate $template)
    {
        return view('admin.whatsapp-marketing.templates.show', compact('template'));
    }

    /**
     * Submit template to WhatsApp for approval
     */
    public function submitTemplate(WhatsAppTemplate $template)
    {
        // Validate header doesn't contain emojis or special characters
        if ($template->header_text) {
            // Remove emojis and check if text changed
            $cleanHeader = preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $template->header_text);
            $cleanHeader = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $cleanHeader);
            $cleanHeader = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $cleanHeader);

            if ($cleanHeader !== $template->header_text) {
                return back()->with('error', 'Header cannot contain emojis. Please remove emojis from the header and try again.');
            }

            // Check for newlines
            if (strpos($template->header_text, "\n") !== false) {
                return back()->with('error', 'Header cannot contain new lines. Please remove line breaks from the header.');
            }
        }

        $result = $template->submitToWhatsApp();

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Check template status from WhatsApp
     */
    public function checkTemplateStatus(WhatsAppTemplate $template)
    {
        $result = $template->checkStatus();

        if ($result['success']) {
            $message = 'Status: ' . ucfirst($result['status']);

            // Add rejection reason if rejected
            if ($result['status'] === 'rejected' && $template->rejection_reason) {
                $message .= ' - Reason: ' . $template->rejection_reason;
            }

            return response()->json([
                'success' => true,
                'status' => $result['status'],
                'message' => $message,
                'rejection_reason' => $template->rejection_reason ?? null,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ]);
    }

    /**
     * Sync all pending/rejected templates status from WhatsApp
     */
    public function syncAllTemplates()
    {
        try {
            $templates = WhatsAppTemplate::whereIn('status', ['pending', 'rejected'])
                ->whereNotNull('whatsapp_template_id')
                ->get();

            if ($templates->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending or rejected templates to sync',
                ]);
            }

            $approved = 0;
            $rejected = 0;
            $pending = 0;
            $errors = 0;

            foreach ($templates as $template) {
                $result = $template->checkStatus();

                if ($result['success']) {
                    switch ($result['status']) {
                        case 'approved':
                            $approved++;
                            break;
                        case 'rejected':
                            $rejected++;
                            break;
                        case 'pending':
                            $pending++;
                            break;
                    }
                } else {
                    $errors++;
                }

                // Small delay to avoid rate limiting
                usleep(500000); // 0.5 seconds
            }

            return response()->json([
                'success' => true,
                'message' => "Synced {$templates->count()} templates",
                'approved' => $approved,
                'rejected' => $rejected,
                'pending' => $pending,
                'errors' => $errors,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error syncing templates: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete template
     */
    public function deleteTemplate(WhatsAppTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.whatsapp-marketing.templates')
            ->with('success', 'Template deleted successfully!');
    }

    /**
     * Show campaigns list
     */
    public function campaigns()
    {
        $campaigns = WhatsAppCampaign::with('template')->latest()->paginate(15);
        return view('admin.whatsapp-marketing.campaigns.index', compact('campaigns'));
    }

    /**
     * Show create campaign form
     */
    public function createCampaign()
    {
        $templates = WhatsAppTemplate::approved()->get();
        $users = User::select('id', 'name', 'email', 'phone')->get();
        $totalUsers = User::count();

        return view('admin.whatsapp-marketing.campaigns.create', compact('templates', 'users', 'totalUsers'));
    }

    /**
     * Store new campaign
     */
    public function storeCampaign(Request $request)
    {
        // Build validation rules dynamically based on recipient_type
        $rules = [
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:whatsapp_templates,id',
            'recipient_type' => 'required|in:all,specific,csv',
            'variable_types' => 'nullable|array',
            'variable_values' => 'nullable|array',
            'schedule_type' => 'required|in:now,later',
            'scheduled_at' => 'required_if:schedule_type,later|nullable|date|after:now',
        ];

        // Add conditional validation based on recipient_type
        if ($request->recipient_type === 'specific') {
            $rules['user_ids'] = 'required|array|min:1';
            $rules['user_ids.*'] = 'exists:users,id';
        } elseif ($request->recipient_type === 'csv') {
            $rules['csv_file'] = 'required|file|mimes:csv,txt';
        }

        $validated = $request->validate($rules);

        $template = WhatsAppTemplate::findOrFail($validated['template_id']);

        if ($template->status !== 'approved') {
            return back()->with('error', 'Template must be approved before creating a campaign');
        }

        // Determine recipients based on type
        $recipients = [];

        if ($validated['recipient_type'] === 'all') {
            $recipients = User::whereNotNull('phone')->get();
        } elseif ($validated['recipient_type'] === 'specific') {
            $recipients = User::whereIn('id', $validated['user_ids'] ?? [])->whereNotNull('phone')->get();
        } elseif ($validated['recipient_type'] === 'csv' && $request->hasFile('csv_file')) {
            // TODO: Parse CSV file
            return back()->with('error', 'CSV upload not yet implemented');
        }

        if (empty($recipients) || count($recipients) === 0) {
            return back()->with('error', 'No valid recipients found');
        }

        // Prepare variable mapping
        $variableMapping = [];
        if (isset($validated['variable_types']) && isset($validated['variable_values'])) {
            foreach ($validated['variable_types'] as $index => $type) {
                $variableMapping[] = [
                    'type' => $type,
                    'value' => $validated['variable_values'][$index] ?? null,
                ];
            }
        }

        // Get default account if not specified
        $defaultAccount = \App\Models\WhatsAppAccount::where('is_default', true)
            ->where('is_active', true)
            ->first();

        if (!$defaultAccount) {
            return back()->with('error', 'No active WhatsApp account found. Please configure an account first.');
        }

        // Create campaign
        $campaign = WhatsAppCampaign::create([
            'name' => $validated['name'],
            'template_id' => $validated['template_id'],
            'account_id' => $defaultAccount->id,
            'status' => $validated['schedule_type'] === 'later' ? 'scheduled' : 'draft',
            'variable_values' => $variableMapping,
            'scheduled_at' => $validated['schedule_type'] === 'later' ? $validated['scheduled_at'] : null,
            'total_recipients' => count($recipients),
        ]);

        // Create recipient records in database
        foreach ($recipients as $user) {
            WhatsAppCampaignRecipient::create([
                'campaign_id' => $campaign->id,
                'user_id' => $user->id,
                'phone_number' => $user->phone,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('admin.whatsapp-marketing.campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully!');
    }

    /**
     * Show campaign details
     */
    public function showCampaign(WhatsAppCampaign $campaign)
    {
        $campaign->load(['template', 'recipients.user']);
        return view('admin.whatsapp-marketing.campaigns.show', compact('campaign'));
    }

    /**
     * Start campaign (send messages)
     */
    public function startCampaign(WhatsAppCampaign $campaign)
    {
        if ($campaign->status === 'running') {
            return back()->with('error', 'Campaign is already running');
        }

        if ($campaign->template->status !== 'approved') {
            return back()->with('error', 'Template must be approved to start campaign');
        }

        // Update campaign status
        $campaign->update([
            'status' => 'running',
            'started_at' => now(),
        ]);

        // Dispatch job to send messages (we'll create this next)
        \App\Jobs\SendWhatsAppCampaign::dispatch($campaign);

        return back()->with('success', 'Campaign started! Messages are being sent...');
    }

    /**
     * Pause campaign
     */
    public function pauseCampaign(WhatsAppCampaign $campaign)
    {
        $campaign->update(['status' => 'paused']);
        return back()->with('success', 'Campaign paused');
    }

    /**
     * Resume campaign
     */
    public function resumeCampaign(WhatsAppCampaign $campaign)
    {
        $campaign->update(['status' => 'running']);
        \App\Jobs\SendWhatsAppCampaign::dispatch($campaign);
        return back()->with('success', 'Campaign resumed');
    }

    /**
     * Delete campaign
     */
    public function deleteCampaign(WhatsAppCampaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.whatsapp-marketing.campaigns')
            ->with('success', 'Campaign deleted successfully!');
    }

    /**
     * Get users for campaign (AJAX)
     */
    public function getUsers(Request $request)
    {
        $query = User::query();

        // Filter by search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by has phone
        $query->whereNotNull('phone');

        $users = $query->select('id', 'name', 'email', 'phone')
            ->limit(100)
            ->get();

        return response()->json($users);
    }

    /**
     * Generate template using AI
     */
    public function generateTemplateWithAI(Request $request)
    {
        try {
            $validated = $request->validate([
                'purpose' => 'required|string|max:500',
                'category' => 'required|in:MARKETING,UTILITY,AUTHENTICATION',
                'tone' => 'nullable|in:professional,friendly,casual,urgent',
                'include_discount' => 'nullable|boolean',
                'include_cta' => 'nullable|boolean',
            ]);

            $geminiApiKey = env('GEMINI_API_KEY');

            if (!$geminiApiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gemini API key not configured. Please add GEMINI_API_KEY to your .env file.'
                ], 500);
            }

            $prompt = $this->buildWhatsAppTemplatePrompt($validated);

            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $geminiApiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Clean up the response - remove markdown code blocks if present
                $generatedText = preg_replace('/```json\s*/', '', $generatedText);
                $generatedText = preg_replace('/```\s*$/', '', $generatedText);
                $generatedText = trim($generatedText);

                $aiData = json_decode($generatedText, true);

                if ($aiData) {
                    return response()->json([
                        'success' => true,
                        'data' => $aiData
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to parse AI response',
                        'raw_response' => $generatedText
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate template with AI'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Build prompt for Gemini AI
     */
    private function buildWhatsAppTemplatePrompt($input)
    {
        $purpose = $input['purpose'];
        $category = $input['category'];
        $tone = $input['tone'] ?? 'professional';
        $includeDiscount = $input['include_discount'] ?? false;
        $includeCta = $input['include_cta'] ?? true;

        $discountText = $includeDiscount ? "Include a discount/offer variable (use {{2}} for percentage or amount)." : "";
        $ctaText = $includeCta ? "Include 1-2 call-to-action buttons." : "";

        return "You are an expert WhatsApp Business API message template creator. Create a professional WhatsApp message template for the following purpose:

**Purpose:** {$purpose}
**Category:** {$category}
**Tone:** {$tone}
**Requirements:**
- Must follow WhatsApp Business Policy guidelines
- Use variables {{1}}, {{2}}, {{3}}, etc. for personalization
- {{1}} should always be customer name
- Keep it concise and clear
- {$discountText}
- {$ctaText}
- Must be compliant with WhatsApp template rules

Generate a JSON response with this EXACT structure (return ONLY valid JSON, no markdown, no additional text):

{
    \"display_name\": \"Template name for admin (e.g., Summer Sale 2025)\",
    \"header_text\": \"Short header with emoji (max 60 chars, optional)\",
    \"body_text\": \"Main message with variables like {{1}} for name, {{2}} for value, {{3}} for code, etc. (max 1024 chars)\",
    \"footer_text\": \"Footer text like brand name (max 60 chars, optional)\",
    \"buttons\": [
        {\"type\": \"QUICK_REPLY\", \"text\": \"Button text\"}
    ]
}

**Important:**
1. Use {{1}} for customer name in body_text
2. Use {{2}}, {{3}}, {{4}} for other dynamic values (discount, code, date, etc.)
3. Keep messages clear and actionable
4. Follow WhatsApp's character limits
5. Buttons are optional but recommended for {$category} category
6. Header and footer are optional
7. Body text is required

Generate the template now:";
    }

    /**
     * API: Get coupons for variable mapping
     */
    public function getCoupons()
    {
        $coupons = Coupon::where('is_active', true)
            ->select('id', 'code', 'type', 'value')
            ->get()
            ->map(function($coupon) {
                return [
                    'code' => $coupon->code,
                    'discount' => $coupon->type === 'percentage'
                        ? $coupon->value . '%'
                        : '₹' . $coupon->value,
                    'type' => $coupon->type
                ];
            });

        return response()->json(['coupons' => $coupons]);
    }
}

