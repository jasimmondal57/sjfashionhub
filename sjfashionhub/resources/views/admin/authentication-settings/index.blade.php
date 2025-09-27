<x-layouts.admin>
    <x-slot name="title">Authentication Settings - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Manage social login providers and authentication methods</x-slot>
    <x-slot name="pageTitle">🔐 Authentication Settings</x-slot>
<div class="container mx-auto px-4 py-6">


    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Social Login Providers -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">🌐 Social Login Providers</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Configure OAuth providers for social authentication</p>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($socialProviders as $provider)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $provider->icon }}</span>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $provider->display_name }}</h3>
                                <p class="text-sm text-gray-500">OAuth 2.0 Authentication</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Status Toggle -->
                            <button type="button" 
                                    onclick="toggleStatus('social', '{{ $provider->provider }}')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $provider->enabled ? 'bg-indigo-600' : 'bg-gray-200' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $provider->enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                            <span class="text-sm {{ $provider->enabled ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $provider->enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>

                    <!-- Configuration Form -->
                    <form action="{{ route('admin.auth-settings.update-social', $provider->provider) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="enabled" value="{{ $provider->enabled ? 1 : 0 }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client ID</label>
                            <input type="text" name="client_id" value="{{ $provider->client_id }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Enter {{ $provider->display_name }} Client ID">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client Secret</label>
                            <input type="password" name="client_secret" value="{{ $provider->client_secret }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Enter {{ $provider->display_name }} Client Secret">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Redirect URI</label>
                            <input type="url" name="redirect_uri"
                                   value="{{ str_replace('localhost', 'sjfashionhub.in', str_replace('http://', 'https://', $provider->redirect_uri)) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="https://sjfashionhub.in/auth/{{ $provider->provider }}/callback">
                            <p class="mt-1 text-sm text-gray-500">Use this URL in your {{ ucfirst($provider->provider) }} OAuth app configuration</p>
                        </div>

                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                💾 Save Settings
                            </button>
                            <button type="button" 
                                    onclick="testProvider('{{ $provider->provider }}')"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                🧪 Test
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Authentication Methods -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">🔑 Authentication Methods</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Enable or disable login methods (SMS/WhatsApp settings are in Communication menu)</p>
        </div>

        <div class="p-6">
            <div class="space-y-6">
                @foreach($authMethods as $method)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $method->icon }}</span>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $method->display_name }}</h3>
                                <p class="text-sm text-gray-500">
                                    @if($method->method === 'email')
                                        Traditional email and password authentication
                                    @elseif($method->method === 'mobile_sms')
                                        SMS-based OTP authentication
                                    @elseif($method->method === 'mobile_whatsapp')
                                        WhatsApp-based OTP authentication
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Status Toggle -->
                            <button type="button" 
                                    onclick="toggleStatus('auth', '{{ $method->method }}')"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $method->enabled ? 'bg-indigo-600' : 'bg-gray-200' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $method->enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                            <span class="text-sm {{ $method->enabled ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $method->enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>

                    @if($method->method !== 'email')
                    <!-- Note about configuration -->
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            @if($method->method === 'mobile_sms')
                                📱 SMS settings are configured in <a href="{{ route('admin.communication.sms-settings') }}" class="underline font-medium">Communication → SMS Settings</a>
                            @elseif($method->method === 'mobile_whatsapp')
                                💬 WhatsApp settings are configured in <a href="{{ route('admin.communication.whatsapp-settings') }}" class="underline font-medium">Communication → WhatsApp Settings</a>
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
async function toggleStatus(type, identifier) {
    try {
        const response = await fetch('{{ route("admin.auth-settings.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ type, identifier })
        });

        const data = await response.json();
        
        if (data.success) {
            // Reload page to update UI
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Network error occurred');
    }
}

async function testProvider(provider) {
    try {
        const response = await fetch(`{{ url('admin/auth-settings/test-social') }}/${provider}`);
        const data = await response.json();
        
        if (data.success) {
            alert('✅ ' + data.message);
            if (data.redirect_url) {
                console.log('Test URL:', data.redirect_url);
            }
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        alert('Network error occurred');
    }
}

async function testMethod(method) {
    if (method === 'mobile_sms') {
        alert('📱 SMS settings are configured in Communication → SMS Settings');
        return;
    }
    if (method === 'mobile_whatsapp') {
        alert('💬 WhatsApp settings are configured in Communication → WhatsApp Settings');
        return;
    }

    try {
        const response = await fetch(`{{ url('admin/auth-settings/test-method') }}/${method}`);
        const data = await response.json();

        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        alert('Network error occurred');
    }
}
</script>
</x-layouts.admin>
