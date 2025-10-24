<x-layouts.admin>
    <x-slot name="title">WhatsApp Settings</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">💬 WhatsApp Settings</h1>
            <p class="text-gray-600 mt-1">Configure WhatsApp Business API and messaging providers</p>
        </div>
        <a href="{{ route('admin.communication.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            ← Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- WhatsApp Service Tabs -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button onclick="showTab('whatsapp_business')" id="whatsapp_business-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    WhatsApp Business API
                </button>
                <button onclick="showTab('twilio_whatsapp')" id="twilio_whatsapp-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Twilio WhatsApp
                </button>
                <button onclick="showTab('msg91_whatsapp')" id="msg91_whatsapp-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    MSG91 WhatsApp
                </button>
            </nav>
        </div>

        <!-- WhatsApp Business API Configuration -->
        <div id="whatsapp_business-content" class="tab-content p-6">
            <form method="POST" action="{{ route('admin.communication.whatsapp-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="whatsapp_business">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Access Token *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter WhatsApp Business API access token" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number ID *</label>
                        <input type="text" name="phone_number" 
                               value="{{ old('phone_number', isset($settings['whatsapp_business']) ? $settings['whatsapp_business']->where('key', 'phone_number')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="123456789012345" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Business Account ID</label>
                        <input type="text" name="business_account_id" 
                               value="{{ old('business_account_id', isset($settings['whatsapp_business']) ? $settings['whatsapp_business']->where('key', 'business_account_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Business Account ID">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Webhook URL
                            <span class="text-xs text-gray-500">(Copy this to Meta Developer Console)</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="url" name="webhook_url" id="webhook_url_business"
                                   value="{{ route('webhook.whatsapp.verify') }}"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50"
                                   readonly>
                            <button type="button" onclick="copyToClipboard('webhook_url_business')"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                📋 Copy
                            </button>
                        </div>
                        <p class="text-xs text-green-600 mt-1">✅ Webhook endpoint is configured and ready</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Webhook Verify Token
                            <span class="text-xs text-gray-500">(Copy this to Meta Developer Console)</span>
                        </label>
                        @php
                            $currentToken = isset($settings['whatsapp_business']) ? ($settings['whatsapp_business']->where('key', 'webhook_verify_token')->first()->value ?? '') : '';
                            $verifyToken = $currentToken ?: 'sjfashion_' . bin2hex(random_bytes(16));
                        @endphp
                        <div class="flex gap-2">
                            <input type="text" name="webhook_verify_token" id="webhook_verify_token"
                                   value="{{ old('webhook_verify_token', $verifyToken) }}"
                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50"
                                   readonly>
                            <button type="button" onclick="copyToClipboard('webhook_verify_token')"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                📋 Copy
                            </button>
                            <button type="button" onclick="generateNewToken()"
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                🔄 Generate New
                            </button>
                        </div>
                        <p class="text-xs text-blue-600 mt-1">💡 Use this exact token in Meta Developer Console webhook settings</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Version</label>
                        <select name="api_version" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="v18.0">v18.0</option>
                            <option value="v17.0">v17.0</option>
                            <option value="v16.0">v16.0</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('whatsapp_business')"
                            class="px-4 py-2 rounded-lg transition-colors border shadow-md font-medium"
                            style="background-color: #059669 !important; color: white !important; border-color: #047857 !important;">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save WhatsApp Business Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Twilio WhatsApp Configuration -->
        <div id="twilio_whatsapp-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.whatsapp-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="twilio_whatsapp">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Account SID *</label>
                        <input type="text" name="account_sid" 
                               value="{{ old('account_sid', isset($settings['twilio_whatsapp']) ? ($settings['twilio_whatsapp']->where('key', 'account_sid')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Auth Token *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter Twilio auth token" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number *</label>
                        <input type="text" name="phone_number" 
                               value="{{ old('phone_number', isset($settings['twilio_whatsapp']) ? ($settings['twilio_whatsapp']->where('key', 'phone_number')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="whatsapp:+14155238886" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="webhook_url" 
                               value="{{ old('webhook_url', isset($settings['twilio_whatsapp']) ? ($settings['twilio_whatsapp']->where('key', 'webhook_url')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="https://yoursite.com/webhook/twilio-whatsapp">
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('twilio_whatsapp')"
                            class="px-4 py-2 rounded-lg transition-colors border shadow-md font-medium"
                            style="background-color: #059669 !important; color: white !important; border-color: #047857 !important;">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Twilio WhatsApp Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- MSG91 WhatsApp Configuration -->
        <div id="msg91_whatsapp-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.whatsapp-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="msg91_whatsapp">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter MSG91 WhatsApp API key" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number *</label>
                        <input type="text" name="phone_number" 
                               value="{{ old('phone_number', isset($settings['msg91_whatsapp']) ? ($settings['msg91_whatsapp']->where('key', 'phone_number')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="+91xxxxxxxxxx" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template Namespace</label>
                        <input type="text" name="template_namespace" 
                               value="{{ old('template_namespace', isset($settings['msg91_whatsapp']) ? ($settings['msg91_whatsapp']->where('key', 'template_namespace')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="your_namespace">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="webhook_url" 
                               value="{{ old('webhook_url', isset($settings['msg91_whatsapp']) ? ($settings['msg91_whatsapp']->where('key', 'webhook_url')->first()->value ?? '') : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="https://yoursite.com/webhook/msg91-whatsapp">
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('msg91_whatsapp')"
                            class="px-4 py-2 rounded-lg transition-colors border shadow-md font-medium"
                            style="background-color: #059669 !important; color: white !important; border-color: #047857 !important;">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save MSG91 WhatsApp Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Setup Instructions -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">📋 Setup Instructions</h3>
        <div class="space-y-4 text-sm text-blue-800">
            <div>
                <h4 class="font-medium">WhatsApp Business API:</h4>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Create a Facebook Developer account and WhatsApp Business app</li>
                    <li>Get your access token from the app dashboard</li>
                    <li>Configure webhook URL for receiving messages</li>
                    <li>Verify your business phone number</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium">Twilio WhatsApp:</h4>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Create a Twilio account and get Account SID and Auth Token</li>
                    <li>Enable WhatsApp sandbox or get approved WhatsApp number</li>
                    <li>Configure webhook URL for message status updates</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium">MSG91 WhatsApp:</h4>
                <ul class="list-disc list-inside ml-4 space-y-1">
                    <li>Create MSG91 account and get WhatsApp API key</li>
                    <li>Register your WhatsApp business number</li>
                    <li>Create and approve message templates</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-blue-500', 'text-blue-600');
}

function testConnection(service) {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '⏳ Testing...';
    button.disabled = true;
    
    fetch('{{ route("admin.communication.test-connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            provider: 'whatsapp',
            service: service
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Connection successful: ' + data.message);
        } else {
            alert('❌ Connection failed: ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Error testing connection');
        console.error('Error:', error);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Copy to clipboard function
function copyToClipboard(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices

    navigator.clipboard.writeText(input.value).then(() => {
        // Show success message
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '✅ Copied!';
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        button.classList.add('bg-green-600');

        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }, 2000);
    }).catch(err => {
        alert('Failed to copy: ' + err);
    });
}

// Generate new verify token
function generateNewToken() {
    const input = document.getElementById('webhook_verify_token');
    const randomBytes = new Uint8Array(16);
    crypto.getRandomValues(randomBytes);
    const token = 'sjfashion_' + Array.from(randomBytes, byte => byte.toString(16).padStart(2, '0')).join('');
    input.value = token;

    // Show notification
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '✅ Generated!';
    button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
    button.classList.add('bg-green-600');

    setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('bg-green-600');
        button.classList.add('bg-gray-600', 'hover:bg-gray-700');
    }, 2000);
}
</script>
</x-layouts.admin>
