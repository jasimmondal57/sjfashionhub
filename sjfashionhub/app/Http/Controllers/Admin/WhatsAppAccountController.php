<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppAccount;
use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppAccountController extends Controller
{
    /**
     * Display all WhatsApp accounts
     */
    public function index()
    {
        $accounts = WhatsAppAccount::withCount(['templates', 'campaigns'])
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.whatsapp-marketing.accounts.index', compact('accounts'));
    }

    /**
     * Show create account form
     */
    public function create()
    {
        return view('admin.whatsapp-marketing.accounts.create');
    }

    /**
     * Store new WhatsApp account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_account_id' => 'required|string|unique:whatsapp_accounts,business_account_id',
            'phone_number_id' => 'required|string',
            'access_token' => 'required|string',
            'api_version' => 'nullable|string',
            'webhook_verify_token' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $account = WhatsAppAccount::create([
            'name' => $validated['name'],
            'business_account_id' => $validated['business_account_id'],
            'phone_number_id' => $validated['phone_number_id'],
            'access_token' => $validated['access_token'], // Will be encrypted by mutator
            'api_version' => $validated['api_version'] ?? 'v18.0',
            'webhook_verify_token' => $validated['webhook_verify_token'] ?? 'sjfashion_' . bin2hex(random_bytes(16)),
            'webhook_url' => route('webhook.whatsapp.verify'),
            'is_active' => true,
            'is_default' => $validated['is_default'] ?? false,
        ]);

        // If set as default, remove default from others
        if ($account->is_default) {
            $account->setAsDefault();
        }

        // Sync account info from WhatsApp
        $account->syncAccountInfo();

        return redirect()->route('admin.whatsapp-marketing.accounts.index')
            ->with('success', 'WhatsApp account added successfully!');
    }

    /**
     * Show account details
     */
    public function show(WhatsAppAccount $account)
    {
        $account->load(['templates' => function($query) {
            $query->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }]);

        return view('admin.whatsapp-marketing.accounts.show', compact('account'));
    }

    /**
     * Show edit form
     */
    public function edit(WhatsAppAccount $account)
    {
        return view('admin.whatsapp-marketing.accounts.edit', compact('account'));
    }

    /**
     * Update account
     */
    public function update(Request $request, WhatsAppAccount $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_account_id' => 'required|string|unique:whatsapp_accounts,business_account_id,' . $account->id,
            'phone_number_id' => 'required|string',
            'access_token' => 'nullable|string',
            'api_version' => 'nullable|string',
            'webhook_verify_token' => 'nullable|string',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'business_account_id' => $validated['business_account_id'],
            'phone_number_id' => $validated['phone_number_id'],
            'api_version' => $validated['api_version'] ?? 'v18.0',
            'webhook_verify_token' => $validated['webhook_verify_token'],
            'is_active' => $validated['is_active'] ?? true,
            'is_default' => $validated['is_default'] ?? false,
        ];

        // Only update access token if provided
        if (!empty($validated['access_token'])) {
            $updateData['access_token'] = $validated['access_token'];
        }

        $account->update($updateData);

        // If set as default, remove default from others
        if ($account->is_default) {
            $account->setAsDefault();
        }

        return redirect()->route('admin.whatsapp-marketing.accounts.index')
            ->with('success', 'WhatsApp account updated successfully!');
    }

    /**
     * Delete account
     */
    public function destroy(WhatsAppAccount $account)
    {
        if ($account->is_default && WhatsAppAccount::count() > 1) {
            return redirect()->back()
                ->with('error', 'Cannot delete default account. Set another account as default first.');
        }

        $account->delete();

        return redirect()->route('admin.whatsapp-marketing.accounts.index')
            ->with('success', 'WhatsApp account deleted successfully!');
    }

    /**
     * Set account as default
     */
    public function setDefault(WhatsAppAccount $account)
    {
        $account->setAsDefault();

        return redirect()->back()
            ->with('success', $account->name . ' set as default account!');
    }

    /**
     * Sync account info from WhatsApp API
     */
    public function syncInfo(WhatsAppAccount $account)
    {
        $result = $account->syncAccountInfo();

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Sync templates from WhatsApp API
     */
    public function syncTemplates(WhatsAppAccount $account)
    {
        $result = $account->syncTemplates();

        if ($result['success']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Copy template to another account
     */
    public function copyTemplate(Request $request, WhatsAppAccount $account, WhatsAppTemplate $template)
    {
        $validated = $request->validate([
            'target_account_id' => 'required|exists:whatsapp_accounts,id',
        ]);

        $targetAccount = WhatsAppAccount::findOrFail($validated['target_account_id']);

        try {
            // Prepare template data for WhatsApp API
            $components = [];

            // Header
            if ($template->header_type && $template->header_text) {
                $components[] = [
                    'type' => 'HEADER',
                    'format' => strtoupper($template->header_type),
                    'text' => $template->header_text,
                ];
            }

            // Body
            $components[] = [
                'type' => 'BODY',
                'text' => $template->body_text,
            ];

            // Footer
            if ($template->footer_text) {
                $components[] = [
                    'type' => 'FOOTER',
                    'text' => $template->footer_text,
                ];
            }

            // Buttons
            if ($template->buttons && count($template->buttons) > 0) {
                $buttons = [];
                foreach ($template->buttons as $button) {
                    $buttonData = [
                        'type' => strtoupper($button['type']),
                        'text' => $button['text'],
                    ];
                    if ($button['type'] === 'url' && isset($button['url'])) {
                        $buttonData['url'] = $button['url'];
                    }
                    $buttons[] = $buttonData;
                }
                $components[] = [
                    'type' => 'BUTTONS',
                    'buttons' => $buttons,
                ];
            }

            // Add variable samples as examples
            $examples = [];
            if ($template->variable_samples && count($template->variable_samples) > 0) {
                $examples['body_text'] = [[$template->variable_samples]];
            }

            // Submit to WhatsApp API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $targetAccount->decrypted_token,
                'Content-Type' => 'application/json',
            ])->post("https://graph.facebook.com/{$targetAccount->api_version}/{$targetAccount->business_account_id}/message_templates", [
                'name' => $template->name,
                'category' => strtoupper($template->category),
                'language' => $template->language,
                'components' => $components,
            ] + (empty($examples) ? [] : ['examples' => $examples]));

            if ($response->successful()) {
                $data = $response->json();

                // Create template record for target account
                WhatsAppTemplate::create([
                    'account_id' => $targetAccount->id,
                    'name' => $template->name,
                    'display_name' => $template->display_name,
                    'category' => $template->category,
                    'language' => $template->language,
                    'header_type' => $template->header_type,
                    'header_text' => $template->header_text,
                    'body_text' => $template->body_text,
                    'footer_text' => $template->footer_text,
                    'buttons' => $template->buttons,
                    'variables' => $template->variables,
                    'variable_samples' => $template->variable_samples,
                    'whatsapp_template_id' => $data['id'] ?? null,
                    'status' => 'pending',
                    'submitted_at' => now(),
                ]);

                return redirect()->back()
                    ->with('success', "Template '{$template->display_name}' submitted to {$targetAccount->name} successfully!");
            }

            $error = $response->json();
            Log::error('Failed to copy template to another account', [
                'template_id' => $template->id,
                'target_account_id' => $targetAccount->id,
                'error' => $error,
            ]);

            return redirect()->back()
                ->with('error', 'Failed to copy template: ' . ($error['error']['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            Log::error('Exception copying template', [
                'template_id' => $template->id,
                'target_account_id' => $targetAccount->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to copy template: ' . $e->getMessage());
        }
    }
}

