<x-layouts.admin>
    <x-slot name="title">Configure {{ $paymentGateway->display_name }}</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">⚙️ Configure {{ $paymentGateway->display_name }}</h1>
            <p class="text-gray-600 mt-1">Set up credentials and configuration for {{ $paymentGateway->display_name }}</p>
        </div>
        <a href="{{ route('admin.payment-gateways.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            ← Back to Gateways
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

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.payment-gateways.configure.update', $paymentGateway->name) }}">
            @csrf
            @method('PUT')
            
            <!-- Basic Settings -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ $paymentGateway->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm font-medium text-gray-700">Enable this payment gateway</span>
                        </label>
                    </div>
                    
                    @if($paymentGateway->name !== 'cod')
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_test_mode" value="1" 
                                   {{ $paymentGateway->is_test_mode ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm font-medium text-gray-700">Test Mode</span>
                        </label>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Credentials Section -->
            @if($paymentGateway->name !== 'cod')
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">API Credentials</h3>
                
                @php
                    $credentials = $paymentGateway->getDecryptedCredentialsAttribute();
                @endphp

                @if($paymentGateway->name === 'razorpay')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Key ID *</label>
                            <input type="text" name="key_id" 
                                   value="{{ old('key_id', $credentials['key_id'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="rzp_test_xxxxxxxxxx" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Key Secret *</label>
                            <input type="password" name="key_secret" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Enter key secret" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Webhook Secret</label>
                            <input type="text" name="webhook_secret" 
                                   value="{{ old('webhook_secret', $credentials['webhook_secret'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Webhook secret for payment verification">
                        </div>
                    </div>
                @elseif($paymentGateway->name === 'cashfree')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">App ID *</label>
                            <input type="text" name="app_id" 
                                   value="{{ old('app_id', $credentials['app_id'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Your Cashfree App ID" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key *</label>
                            <input type="password" name="secret_key" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Enter secret key" required>
                        </div>
                    </div>
                @elseif($paymentGateway->name === 'payu')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Key *</label>
                            <input type="text" name="merchant_key" 
                                   value="{{ old('merchant_key', $credentials['merchant_key'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Your PayU Merchant Key" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Salt *</label>
                            <input type="password" name="merchant_salt" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Enter merchant salt" required>
                        </div>
                    </div>
                @elseif($paymentGateway->name === 'paytm')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant ID *</label>
                            <input type="text" name="merchant_id" 
                                   value="{{ old('merchant_id', $credentials['merchant_id'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Your Paytm Merchant ID" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Merchant Key *</label>
                            <input type="password" name="merchant_key" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Enter merchant key" required>
                        </div>
                    </div>
                @elseif($paymentGateway->name === 'paypal')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Client ID *</label>
                            <input type="text" name="client_id" 
                                   value="{{ old('client_id', $credentials['client_id'] ?? '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Your PayPal Client ID" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Client Secret *</label>
                            <input type="password" name="client_secret" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                                   placeholder="Enter client secret" required>
                        </div>
                    </div>
                @endif
            </div>
            @endif

            <!-- Fee Settings -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Fee Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Fee (%)</label>
                        <input type="number" name="transaction_fee" step="0.01" min="0" max="100"
                               value="{{ old('transaction_fee', $paymentGateway->transaction_fee) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="2.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fixed Fee (₹)</label>
                        <input type="number" name="fixed_fee" step="0.01" min="0"
                               value="{{ old('fixed_fee', $paymentGateway->fixed_fee) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Amount Limits -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Amount Limits</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Amount (₹)</label>
                        <input type="number" name="min_amount" step="0.01" min="0"
                               value="{{ old('min_amount', $paymentGateway->min_amount) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Amount (₹)</label>
                        <input type="number" name="max_amount" step="0.01" min="0"
                               value="{{ old('max_amount', $paymentGateway->max_amount) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="Leave empty for no limit">
                    </div>
                </div>
            </div>

            <!-- Additional Settings -->
            @if($paymentGateway->name !== 'cod')
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Settings</h3>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="webhook_url" 
                               value="{{ old('webhook_url', $paymentGateway->settings['webhook_url'] ?? '') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                               placeholder="https://yoursite.com/webhook/{{ $paymentGateway->name }}">
                        <p class="text-sm text-gray-500 mt-1">URL to receive payment notifications</p>
                    </div>
                    
                    @if($paymentGateway->name === 'razorpay')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme Color</label>
                        <input type="color" name="theme_color" 
                               value="{{ old('theme_color', $paymentGateway->settings['theme_color'] ?? '#3399cc') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 h-10">
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                <div class="flex space-x-3">
                    @if($paymentGateway->name !== 'cod')
                    <button type="button" onclick="testConnection('{{ $paymentGateway->name }}')" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🧪 Test Connection
                    </button>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.payment-gateways.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        💾 Save Configuration
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Setup Instructions -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">📋 Setup Instructions for {{ $paymentGateway->display_name }}</h3>
        <div class="space-y-4 text-sm text-blue-800">
            @if($paymentGateway->name === 'razorpay')
                <div>
                    <h4 class="font-medium">Razorpay Setup:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Create a Razorpay account at <a href="https://razorpay.com" target="_blank" class="underline">razorpay.com</a></li>
                        <li>Go to Settings → API Keys to get your Key ID and Key Secret</li>
                        <li>For webhooks, go to Settings → Webhooks and add your webhook URL</li>
                        <li>Enable required payment methods in your Razorpay dashboard</li>
                    </ul>
                </div>
            @elseif($paymentGateway->name === 'cashfree')
                <div>
                    <h4 class="font-medium">Cashfree Setup:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Create a Cashfree account at <a href="https://cashfree.com" target="_blank" class="underline">cashfree.com</a></li>
                        <li>Complete KYC verification</li>
                        <li>Get your App ID and Secret Key from the dashboard</li>
                        <li>Configure webhook URL for payment notifications</li>
                    </ul>
                </div>
            @elseif($paymentGateway->name === 'payu')
                <div>
                    <h4 class="font-medium">PayU Setup:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Create a PayU account at <a href="https://payu.in" target="_blank" class="underline">payu.in</a></li>
                        <li>Complete merchant onboarding process</li>
                        <li>Get your Merchant Key and Salt from the dashboard</li>
                        <li>Configure success and failure URLs</li>
                    </ul>
                </div>
            @elseif($paymentGateway->name === 'paytm')
                <div>
                    <h4 class="font-medium">Paytm Setup:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Create a Paytm Business account</li>
                        <li>Complete merchant verification</li>
                        <li>Get your Merchant ID and Key from developer console</li>
                        <li>Configure callback URLs for payment status</li>
                    </ul>
                </div>
            @elseif($paymentGateway->name === 'paypal')
                <div>
                    <h4 class="font-medium">PayPal Setup:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Create a PayPal Business account</li>
                        <li>Go to PayPal Developer Console</li>
                        <li>Create an app to get Client ID and Secret</li>
                        <li>Configure webhook endpoints for payment events</li>
                    </ul>
                </div>
            @elseif($paymentGateway->name === 'cod')
                <div>
                    <h4 class="font-medium">Cash on Delivery:</h4>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>No API credentials required</li>
                        <li>Simply enable/disable as needed</li>
                        <li>Configure minimum and maximum order amounts</li>
                        <li>Set up delivery areas where COD is available</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function testConnection(gateway) {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '⏳ Testing...';
    button.disabled = true;
    
    fetch(`/admin/payment-gateways/${gateway}/test-connection`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
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
