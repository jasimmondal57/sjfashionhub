<x-layouts.admin>
    <x-slot name="title">Email Settings</x-slot>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📧 Email Settings</h1>
            <p class="text-gray-600 mt-1">Configure SMTP and email service providers</p>
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

    <!-- Email Service Tabs -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button onclick="showTab('smtp')" id="smtp-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    SMTP
                </button>
                <button onclick="showTab('mailgun')" id="mailgun-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Mailgun
                </button>
                <button onclick="showTab('ses')" id="ses-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Amazon SES
                </button>
                <button onclick="showTab('postmark')" id="postmark-tab" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Postmark
                </button>
            </nav>
        </div>

        <!-- SMTP Configuration -->
        <div id="smtp-content" class="tab-content p-6">
            <form method="POST" action="{{ route('admin.communication.email-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="smtp">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host *</label>
                        <input type="text" name="host"
                               value="{{ old('host', $settings['smtp']['host']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="smtp.gmail.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port *</label>
                        <input type="number" name="port"
                               value="{{ old('port', $settings['smtp']['port']->value ?? '587') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="587" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                        <input type="text" name="username"
                               value="{{ old('username', $settings['smtp']['username']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="your-email@gmail.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <input type="password" name="password"
                               value="{{ old('password', $settings['smtp']['password']->decrypted_value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2"
                               placeholder="Enter password" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Encryption</label>
                        <select name="encryption" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">None</option>
                            <option value="tls" {{ old('encryption', $settings['smtp']['encryption']->value ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ old('encryption', $settings['smtp']['encryption']->value ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                        <input type="email" name="from_address"
                               value="{{ old('from_address', $settings['smtp']['from_address']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="noreply@yoursite.com" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name *</label>
                        <input type="text" name="from_name"
                               value="{{ old('from_name', $settings['smtp']['from_name']->value ?? 'SJ Fashion Hub') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="SJ Fashion Hub" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('smtp')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save SMTP Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Mailgun Configuration -->
        <div id="mailgun-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.email-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="mailgun">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Key *</label>
                        <input type="password" name="api_key"
                               value="{{ old('api_key', $settings['mailgun']['api_key']->decrypted_value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2"
                               placeholder="key-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Domain *</label>
                        <input type="text" name="domain"
                               value="{{ old('domain', $settings['mailgun']['domain']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="mg.yoursite.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                        <input type="email" name="from_address"
                               value="{{ old('from_address', $settings['mailgun']['from_address']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="noreply@yoursite.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name *</label>
                        <input type="text" name="from_name"
                               value="{{ old('from_name', $settings['mailgun']['from_name']->value ?? 'SJ Fashion Hub') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="SJ Fashion Hub" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('mailgun')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Mailgun Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Amazon SES Configuration -->
        <div id="ses-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.email-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="ses">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">AWS Access Key *</label>
                        <input type="password" name="api_key"
                               value="{{ old('api_key', $settings['ses']['api_key']->decrypted_value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2"
                               placeholder="AKIAIOSFODNN7EXAMPLE" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">AWS Secret Key *</label>
                        <input type="password" name="secret_key"
                               value="{{ old('secret_key', $settings['ses']['secret_key']->decrypted_value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2"
                               placeholder="wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">AWS Region *</label>
                        <select name="region" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="">Select Region</option>
                            <option value="us-east-1" {{ old('region', $settings['ses']['region']->value ?? '') == 'us-east-1' ? 'selected' : '' }}>US East (N. Virginia)</option>
                            <option value="us-west-2" {{ old('region', $settings['ses']['region']->value ?? '') == 'us-west-2' ? 'selected' : '' }}>US West (Oregon)</option>
                            <option value="eu-west-1" {{ old('region', $settings['ses']['region']->value ?? '') == 'eu-west-1' ? 'selected' : '' }}>Europe (Ireland)</option>
                            <option value="ap-southeast-1" {{ old('region', $settings['ses']['region']->value ?? '') == 'ap-southeast-1' ? 'selected' : '' }}>Asia Pacific (Singapore)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                        <input type="email" name="from_address" 
                               value="{{ old('from_address', $settings['ses']['from_address']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="noreply@yoursite.com" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name *</label>
                        <input type="text" name="from_name" 
                               value="{{ old('from_name', $settings['ses']['from_name']->value ?? 'SJ Fashion Hub') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="SJ Fashion Hub" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('ses')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save SES Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Postmark Configuration -->
        <div id="postmark-content" class="tab-content p-6 hidden">
            <form method="POST" action="{{ route('admin.communication.email-settings.update') }}">
                @csrf
                <input type="hidden" name="service" value="postmark">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Server API Token *</label>
                        <input type="password" name="api_key"
                               value="{{ old('api_key', $settings['postmark']['api_key']->decrypted_value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2"
                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Email *</label>
                        <input type="email" name="from_address" 
                               value="{{ old('from_address', $settings['postmark']['from_address']->value ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="noreply@yoursite.com" required>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Name *</label>
                        <input type="text" name="from_name" 
                               value="{{ old('from_name', $settings['postmark']['from_name']->value ?? 'SJ Fashion Hub') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="SJ Fashion Hub" required>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-6">
                    <button type="button" onclick="testConnection('postmark')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Postmark Settings
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
            provider: 'email',
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
