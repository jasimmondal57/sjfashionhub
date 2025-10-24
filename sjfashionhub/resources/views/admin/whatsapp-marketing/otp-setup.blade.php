<x-layouts.admin>
    <x-slot name="title">WhatsApp OTP Template Setup</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">🔐 WhatsApp OTP Template Setup</h1>
            <p class="text-gray-600 mt-1">Create and manage authentication template for mobile login OTP</p>
        </div>
        <a href="{{ route('admin.whatsapp-marketing.templates') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            ← Back to Templates
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if(!$hasCredentials)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">⚠️ WhatsApp API Not Configured</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Before creating OTP templates, you need to configure your WhatsApp Business API credentials.</p>
                        <p class="mt-2"><strong>Steps to configure:</strong></p>
                        <ol class="list-decimal list-inside mt-2 space-y-1">
                            <li>Go to <a href="{{ route('admin.communication.whatsapp-settings') }}" class="underline font-semibold">Admin → Communication → WhatsApp Settings</a></li>
                            <li>Enter your WhatsApp Business API credentials:
                                <ul class="list-disc list-inside ml-6 mt-1">
                                    <li>Access Token (from Meta Business Manager)</li>
                                    <li>Business Account ID</li>
                                    <li>Phone Number ID</li>
                                </ul>
                            </li>
                            <li>Test the connection</li>
                            <li>Return here to create OTP template</li>
                        </ol>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.communication.whatsapp-settings') }}"
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-semibold transition-colors">
                            → Configure WhatsApp Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Current OTP Template Status -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">📊 Current OTP Template Status</h2>
        
        @if($otpTemplate)
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $otpTemplate->display_name }}</p>
                        <p class="text-sm text-gray-600 mt-1">Template Name: <code class="bg-gray-200 px-2 py-1 rounded">{{ $otpTemplate->name }}</code></p>
                        <p class="text-sm text-gray-600 mt-1">Category: {{ $otpTemplate->category }}</p>
                    </div>
                    <div class="text-right">
                        @if($otpTemplate->status === 'approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                ✅ Approved
                            </span>
                        @elseif($otpTemplate->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                ⏳ Pending
                            </span>
                        @elseif($otpTemplate->status === 'rejected')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                ❌ Rejected
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                📝 Draft
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Template Preview -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">📱 Template Preview</h3>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 max-w-md">
                        @if($otpTemplate->header_text)
                            <p class="font-bold text-gray-900 mb-2">{{ $otpTemplate->header_text }}</p>
                        @endif
                        <p class="text-gray-800 whitespace-pre-line">{!! str_replace('{{1}}', '123456', $otpTemplate->body_text) !!}</p>
                        @if($otpTemplate->footer_text)
                            <p class="text-xs text-gray-600 mt-3">{{ $otpTemplate->footer_text }}</p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    @if($otpTemplate->status === 'draft')
                        <form method="POST" action="{{ route('admin.whatsapp-marketing.templates.submit', $otpTemplate) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                📤 Submit to Meta for Approval
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($otpTemplate->status, ['pending', 'approved']))
                        <button onclick="checkTemplateStatus({{ $otpTemplate->id }})" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            🔄 Check Status
                        </button>
                    @endif

                    <a href="{{ route('admin.whatsapp-marketing.templates.show', $otpTemplate) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        👁️ View Details
                    </a>

                    @if($otpTemplate->status === 'rejected' || $otpTemplate->status === 'draft')
                        <button onclick="showCreateForm()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                            🔄 Create New Template
                        </button>
                    @endif
                </div>

                @if($otpTemplate->rejection_reason)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="font-semibold text-red-900 mb-2">❌ Rejection Reason:</p>
                        <p class="text-red-800">{{ $otpTemplate->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 mb-4">No OTP authentication template found. Create one to enable WhatsApp OTP login.</p>
                @if($hasCredentials)
                    <button onclick="showCreateForm()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                        ✨ Create OTP Template
                    </button>
                @else
                    <a href="{{ route('admin.communication.whatsapp-settings') }}"
                       class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg transition-colors">
                        ⚙️ Configure WhatsApp First
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Create Template Form (Hidden by default) -->
    <div id="createTemplateForm" class="bg-white rounded-lg shadow-md p-6 {{ $otpTemplate || !$hasCredentials ? 'hidden' : '' }}">
        <h2 class="text-xl font-bold text-gray-900 mb-4">✨ Create OTP Authentication Template</h2>

        @if(!$hasCredentials)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <p class="text-red-800">⚠️ Please configure WhatsApp API credentials first before creating templates.</p>
            </div>
        @endif

        <!-- AUTHENTICATION Template Restrictions -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">📋 AUTHENTICATION Template Requirements</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p class="mb-2">Meta has specific requirements for AUTHENTICATION category templates:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>NO Header allowed</strong> - Header will be automatically removed</li>
                            <li><strong>NO Footer allowed</strong> - Footer will be automatically removed</li>
                            <li><strong>NO Buttons allowed</strong> - Only body text is supported</li>
                            <li><strong>Body text only</strong> - Use variables like {{1}} for OTP code</li>
                            <li><strong>Keep it simple</strong> - Clear, concise OTP message</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Generator -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg p-6 mb-6 text-white">
            <h3 class="text-lg font-bold mb-3">🤖 AI Template Generator</h3>
            <p class="text-sm mb-4 opacity-90">Let AI create a professional OTP template for you!</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                <select id="ai_tone" class="px-3 py-2 rounded-lg border-0 text-gray-900">
                    <option value="professional">Professional Tone</option>
                    <option value="friendly">Friendly Tone</option>
                    <option value="urgent">Urgent Tone</option>
                </select>
                <select id="ai_language" class="px-3 py-2 rounded-lg border-0 text-gray-900">
                    <option value="en">English</option>
                    <option value="hi">Hindi</option>
                    <option value="en_US">English (US)</option>
                </select>
            </div>

            <button onclick="generateOTPTemplate()" id="ai_generate_btn"
                    class="w-full bg-white text-purple-600 px-4 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                ✨ Generate with AI
            </button>
        </div>

        <!-- Manual Form -->
        <form method="POST" action="{{ route('admin.whatsapp-marketing.otp-setup.store') }}">
            @csrf

            <div class="space-y-4">
                <!-- Display Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Template Display Name</label>
                    <input type="text" name="display_name" id="display_name" required
                           value="OTP Login Verification"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Internal name for your reference</p>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                    <select name="language" id="language" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="en">English</option>
                        <option value="hi">Hindi</option>
                        <option value="en_US">English (US)</option>
                    </select>
                </div>

                <!-- Header Text (NOT USED for AUTHENTICATION) -->
                <div class="opacity-50 pointer-events-none">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="line-through">Header Text</span>
                        <span class="text-red-600 text-xs ml-2">❌ Not allowed for AUTHENTICATION templates</span>
                    </label>
                    <input type="text" name="header_text" id="header_text" maxlength="60" disabled
                           placeholder="Headers are not supported for OTP templates"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    <p class="text-xs text-red-600 mt-1">⚠️ Meta does not allow headers in AUTHENTICATION category templates</p>
                </div>

                <!-- Body Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Body Text (Required, max 1024 chars)</label>
                    <textarea name="body_text" id="body_text" required rows="6" maxlength="1024"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Your SJ Fashion Hub login OTP is {{1}}. Valid for 10 minutes. Do not share this code with anyone.">Your SJ Fashion Hub login OTP is {{1}}

⏰ Valid for 10 minutes
🚫 Do not share this code with anyone

Happy Shopping!</textarea>
                    <p class="text-xs text-gray-500 mt-1">Use {{1}} for OTP code. You can add emojis here.</p>
                </div>

                <!-- Footer Text (NOT USED for AUTHENTICATION) -->
                <div class="opacity-50 pointer-events-none">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="line-through">Footer Text</span>
                        <span class="text-red-600 text-xs ml-2">❌ Not allowed for AUTHENTICATION templates</span>
                    </label>
                    <input type="text" name="footer_text" id="footer_text" maxlength="60" disabled
                           placeholder="Footers are not supported for OTP templates"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                    <p class="text-xs text-red-600 mt-1">⚠️ Meta does not allow footers in AUTHENTICATION category templates</p>
                </div>

                <!-- Variable Samples -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sample OTP (for Meta approval)</label>
                    <input type="text" name="variable_samples[]" value="123456" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Example OTP code for template approval</p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    💾 Create Template
                </button>
                @if($otpTemplate)
                    <button type="button" onclick="hideCreateForm()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Setup Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
        <h3 class="font-bold text-blue-900 mb-3">📋 Setup Instructions</h3>
        <ol class="list-decimal list-inside space-y-2 text-blue-800">
            <li>Create an OTP authentication template using AI or manually</li>
            <li>Submit the template to Meta for approval (usually takes 1-24 hours)</li>
            <li>Check the status periodically until it's approved</li>
            <li>Once approved, the WhatsApp OTP login will automatically use this template</li>
            <li>Test the OTP login at <a href="{{ route('mobile.login') }}" class="underline font-semibold" target="_blank">{{ route('mobile.login') }}</a></li>
        </ol>
    </div>
</div>

<script>
function showCreateForm() {
    document.getElementById('createTemplateForm').classList.remove('hidden');
}

function hideCreateForm() {
    document.getElementById('createTemplateForm').classList.add('hidden');
}

async function generateOTPTemplate() {
    const tone = document.getElementById('ai_tone').value;
    const language = document.getElementById('ai_language').value;
    const button = document.getElementById('ai_generate_btn');
    const originalText = button.innerHTML;
    
    button.innerHTML = '⏳ Generating with AI...';
    button.disabled = true;

    try {
        const response = await fetch('{{ route("admin.whatsapp-marketing.templates.generate-ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                purpose: 'OTP verification code for mobile login authentication',
                category: 'AUTHENTICATION',
                tone: tone,
                include_discount: false,
                include_cta: false
            })
        });

        const data = await response.json();

        if (data.success && data.data) {
            // Fill form with AI generated content
            document.getElementById('display_name').value = data.data.display_name || 'OTP Login Verification';
            document.getElementById('header_text').value = data.data.header_text || '';
            document.getElementById('body_text').value = data.data.body_text || '';
            document.getElementById('footer_text').value = data.data.footer_text || 'SJ Fashion Hub';
            document.getElementById('language').value = language;
            
            alert('✅ Template generated successfully! Review and submit.');
        } else {
            alert('❌ Failed to generate template: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Network error. Please try again.');
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

async function checkTemplateStatus(templateId) {
    try {
        const response = await fetch(`/admin/whatsapp-marketing/templates/${templateId}/check-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('✅ ' + data.message);
            window.location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error checking status');
    }
}
</script>
</x-layouts.admin>

