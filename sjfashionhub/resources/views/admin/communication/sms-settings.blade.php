<x-layouts.admin>
    <x-slot name="title">SMS Settings</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📱 SMS Settings</h1>
            <p class="text-gray-600 mt-1">Configure SMS providers like Twilio, MSG91, TextLocal</p>
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

    <!-- SMS Service Tabs -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button onclick="showTab('twilio')" id="twilio-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    Twilio
                </button>
                <button onclick="showTab('msg91')" id="msg91-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    MSG91
                </button>
                <button onclick="showTab('textlocal')" id="textlocal-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    TextLocal
                </button>
                <button onclick="showTab('fast2sms')" id="fast2sms-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Fast2SMS
                </button>
            </nav>
        </div>

        <!-- Twilio Configuration -->
        <div id="twilio-content" class="tab-content p-6">
            <form method="POST" action="{{ route('admin.communication.sms-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="twilio">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Account SID *</label>
                        <input type="text" name="account_sid" 
                               value="{{ old('account_sid', isset($settings['twilio']) ? $settings['twilio']->where('key', 'account_sid')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Auth Token *</label>
                        <input type="password" name="auth_token" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter auth token" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter API key" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID *</label>
                        <input type="text" name="sender_id" 
                               value="{{ old('sender_id', isset($settings['twilio']) ? $settings['twilio']->where('key', 'sender_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="+1234567890" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('twilio')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Twilio Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- MSG91 Configuration -->
        <div id="msg91-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.sms-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="msg91">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter MSG91 API key" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID *</label>
                        <input type="text" name="sender_id" 
                               value="{{ old('sender_id', isset($settings['msg91']) ? $settings['msg91']->where('key', 'sender_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="SJFASH" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template ID</label>
                        <input type="text" name="template_id" 
                               value="{{ old('template_id', isset($settings['msg91']) ? $settings['msg91']->where('key', 'template_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Template ID for OTP">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                        <select name="route" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="4">Transactional</option>
                            <option value="1">Promotional</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('msg91')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save MSG91 Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- TextLocal Configuration -->
        <div id="textlocal-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.sms-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="textlocal">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter TextLocal API key" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID *</label>
                        <input type="text" name="sender_id" 
                               value="{{ old('sender_id', isset($settings['textlocal']) ? $settings['textlocal']->where('key', 'sender_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="TXTLCL" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('textlocal')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save TextLocal Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Fast2SMS Configuration -->
        <div id="fast2sms-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.sms-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="fast2sms">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Enter Fast2SMS API key" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID *</label>
                        <input type="text" name="sender_id" 
                               value="{{ old('sender_id', isset($settings['fast2sms']) ? $settings['fast2sms']->where('key', 'sender_id')->first()->value ?? '' : '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="FSTSMS" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                        <select name="route" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="otp">OTP</option>
                            <option value="bulk">Bulk</option>
                            <option value="quick">Quick</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('fast2sms')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Fast2SMS Settings
                    </button>
                </div>
            </form>
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
            provider: 'sms',
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
</script>
</x-layouts.admin>
