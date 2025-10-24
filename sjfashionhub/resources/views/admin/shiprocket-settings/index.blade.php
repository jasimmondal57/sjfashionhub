<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🚀 Shiprocket Settings</h1>
                        <p class="text-gray-600 mt-1">Configure your Shiprocket integration for automated shipping</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        @if($isConfigured)
                            <button onclick="testConnection()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-plug mr-2"></i>Test Connection
                            </button>
                        @endif
                        <button onclick="showResetModal()" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-undo mr-2"></i>Reset Settings
                        </button>
                    </div>
                </div>
            </div>

            <!-- Connection Status -->
            @if($isConfigured && $connectionStatus)
                <div class="mb-6">
                    @if($connectionStatus['status'] === 'success')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-green-800 font-medium">Connection Successful</p>
                                    <p class="text-green-700 text-sm">{{ $connectionStatus['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                                <div>
                                    <p class="text-red-800 font-medium">Connection Failed</p>
                                    <p class="text-red-700 text-sm">{{ $connectionStatus['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Settings Form -->
            <form action="{{ route('admin.shiprocket-settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- API Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🔑 API Configuration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="shiprocket_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Shiprocket Email *
                            </label>
                            <input type="email" name="shiprocket_email" id="shiprocket_email" required
                                   value="{{ old('shiprocket_email', $settings['api']['shiprocket_email'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_email') border-red-500 @enderror">
                            @error('shiprocket_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Shiprocket Password *
                            </label>
                            <input type="password" name="shiprocket_password" id="shiprocket_password" required
                                   value="{{ old('shiprocket_password') }}"
                                   placeholder="{{ isset($settings['api']['shiprocket_password']) ? '••••••••' : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_password') border-red-500 @enderror">
                            @error('shiprocket_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_base_url" class="block text-sm font-medium text-gray-700 mb-2">
                                API Base URL
                            </label>
                            <input type="url" name="shiprocket_base_url" id="shiprocket_base_url"
                                   value="{{ old('shiprocket_base_url', $settings['api']['shiprocket_base_url'] ?? 'https://apiv2.shiprocket.in/v1/external') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="shiprocket_is_sandbox" id="shiprocket_is_sandbox" value="1"
                                   {{ old('shiprocket_is_sandbox', $settings['api']['shiprocket_is_sandbox'] ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="shiprocket_is_sandbox" class="ml-2 block text-sm text-gray-700">
                                Enable Sandbox Mode (for testing)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Pickup Address Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">📍 Pickup Address Configuration</h3>
                        <button type="button" onclick="fetchPickupLocations()" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                            <i class="fas fa-sync mr-1"></i>Fetch from Shiprocket
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="shiprocket_pickup_location" class="block text-sm font-medium text-gray-700 mb-2">
                                Pickup Location Name *
                            </label>
                            <input type="text" name="shiprocket_pickup_location" id="shiprocket_pickup_location" required
                                   value="{{ old('shiprocket_pickup_location', $settings['pickup']['shiprocket_pickup_location'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_location') border-red-500 @enderror">
                            @error('shiprocket_pickup_location')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Name *
                            </label>
                            <input type="text" name="shiprocket_pickup_name" id="shiprocket_pickup_name" required
                                   value="{{ old('shiprocket_pickup_name', $settings['pickup']['shiprocket_pickup_name'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_name') border-red-500 @enderror">
                            @error('shiprocket_pickup_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Email *
                            </label>
                            <input type="email" name="shiprocket_pickup_email" id="shiprocket_pickup_email" required
                                   value="{{ old('shiprocket_pickup_email', $settings['pickup']['shiprocket_pickup_email'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_email') border-red-500 @enderror">
                            @error('shiprocket_pickup_email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Phone *
                            </label>
                            <input type="text" name="shiprocket_pickup_phone" id="shiprocket_pickup_phone" required
                                   value="{{ old('shiprocket_pickup_phone', $settings['pickup']['shiprocket_pickup_phone'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_phone') border-red-500 @enderror">
                            @error('shiprocket_pickup_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="shiprocket_pickup_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address Line 1 *
                            </label>
                            <textarea name="shiprocket_pickup_address" id="shiprocket_pickup_address" rows="2" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_address') border-red-500 @enderror">{{ old('shiprocket_pickup_address', $settings['pickup']['shiprocket_pickup_address'] ?? '') }}</textarea>
                            @error('shiprocket_pickup_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_address_2" class="block text-sm font-medium text-gray-700 mb-2">
                                Address Line 2
                            </label>
                            <input type="text" name="shiprocket_pickup_address_2" id="shiprocket_pickup_address_2"
                                   value="{{ old('shiprocket_pickup_address_2', $settings['pickup']['shiprocket_pickup_address_2'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shiprocket_pickup_city" class="block text-sm font-medium text-gray-700 mb-2">
                                City *
                            </label>
                            <input type="text" name="shiprocket_pickup_city" id="shiprocket_pickup_city" required
                                   value="{{ old('shiprocket_pickup_city', $settings['pickup']['shiprocket_pickup_city'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_city') border-red-500 @enderror">
                            @error('shiprocket_pickup_city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_state" class="block text-sm font-medium text-gray-700 mb-2">
                                State *
                            </label>
                            <input type="text" name="shiprocket_pickup_state" id="shiprocket_pickup_state" required
                                   value="{{ old('shiprocket_pickup_state', $settings['pickup']['shiprocket_pickup_state'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_state') border-red-500 @enderror">
                            @error('shiprocket_pickup_state')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shiprocket_pickup_country" class="block text-sm font-medium text-gray-700 mb-2">
                                Country
                            </label>
                            <input type="text" name="shiprocket_pickup_country" id="shiprocket_pickup_country"
                                   value="{{ old('shiprocket_pickup_country', $settings['pickup']['shiprocket_pickup_country'] ?? 'India') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shiprocket_pickup_pin_code" class="block text-sm font-medium text-gray-700 mb-2">
                                PIN Code *
                            </label>
                            <input type="text" name="shiprocket_pickup_pin_code" id="shiprocket_pickup_pin_code" required
                                   value="{{ old('shiprocket_pickup_pin_code', $settings['pickup']['shiprocket_pickup_pin_code'] ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('shiprocket_pickup_pin_code') border-red-500 @enderror">
                            @error('shiprocket_pickup_pin_code')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Webhook Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🔗 Webhook Configuration</h3>
                    <p class="text-sm text-gray-600 mb-4">Configure this webhook URL in your Shiprocket dashboard to receive real-time shipping updates</p>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Webhook URL to provide to Shiprocket -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Your Webhook URL
                                <span class="text-xs text-gray-500 font-normal">(Copy this to Shiprocket dashboard)</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                <input type="text"
                                       id="webhook-url-display"
                                       value="{{ url('/webhook/shipping-updates') }}"
                                       readonly
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700 font-mono text-sm">
                                <button type="button"
                                        onclick="copyWebhookUrl()"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors whitespace-nowrap">
                                    <i class="fas fa-copy mr-1"></i> Copy
                                </button>
                            </div>
                            <p class="text-gray-500 text-xs mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Add this URL in Shiprocket Dashboard → Settings → Webhooks
                            </p>
                            <p class="text-orange-600 text-xs mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <strong>Important:</strong> Shiprocket does not allow URLs containing "shiprocket", "kartrocket", "sr", or "kr"
                            </p>
                        </div>

                        <!-- Webhook Token -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Webhook Token
                                <span class="text-xs text-gray-500 font-normal">(For authentication)</span>
                            </label>
                            <div class="flex items-center space-x-2">
                                <input type="text"
                                       id="webhook-token-display"
                                       value="{{ $settings['webhook']['shiprocket_webhook_token'] ?? Str::random(32) }}"
                                       readonly
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700 font-mono text-sm">
                                <button type="button"
                                        onclick="copyWebhookToken()"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors whitespace-nowrap">
                                    <i class="fas fa-copy mr-1"></i> Copy
                                </button>
                                <button type="button"
                                        onclick="regenerateToken()"
                                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-medium transition-colors whitespace-nowrap">
                                    <i class="fas fa-sync-alt mr-1"></i> Regenerate
                                </button>
                            </div>
                            <input type="hidden"
                                   name="shiprocket_webhook_token"
                                   id="webhook-token-hidden"
                                   value="{{ $settings['webhook']['shiprocket_webhook_token'] ?? Str::random(32) }}">
                            <p class="text-gray-500 text-xs mt-1">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Use this token to authenticate webhook requests from Shiprocket
                            </p>
                        </div>

                        <!-- Instructions -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-blue-900 mb-2">
                                <i class="fas fa-book mr-1"></i> Setup Instructions:
                            </h4>
                            <ol class="text-sm text-blue-800 space-y-1 list-decimal list-inside">
                                <li>Copy the Webhook URL above</li>
                                <li>Copy the Webhook Token above</li>
                                <li>Login to your Shiprocket dashboard</li>
                                <li>Go to Settings → API → Webhooks</li>
                                <li>Click "Add Webhook"</li>
                                <li>Paste the URL in the "URL" field</li>
                                <li>Paste the Token in the "Token" field</li>
                                <li>Note: Shiprocket will send the token in HTTP header: <code class="bg-blue-100 px-1 rounded">x-api-key</code></li>
                                <li>Select events to track (Delivered, In Transit, etc.)</li>
                                <li>Click "Save" to activate the webhook</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- General Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">⚙️ General Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="shiprocket_auto_assign_awb" id="shiprocket_auto_assign_awb" value="1"
                                       {{ old('shiprocket_auto_assign_awb', $settings['general']['shiprocket_auto_assign_awb'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="shiprocket_auto_assign_awb" class="ml-2 block text-sm text-gray-700">
                                    Automatically assign AWB numbers when creating shipments
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="shiprocket_auto_pickup" id="shiprocket_auto_pickup" value="1"
                                       {{ old('shiprocket_auto_pickup', $settings['general']['shiprocket_auto_pickup'] ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="shiprocket_auto_pickup" class="ml-2 block text-sm text-gray-700">
                                    Automatically schedule pickups for new shipments
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="shiprocket_default_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Default Package Weight (kg)
                            </label>
                            <input type="number" name="shiprocket_default_weight" id="shiprocket_default_weight" step="0.1" min="0.1"
                                   value="{{ old('shiprocket_default_weight', $settings['general']['shiprocket_default_weight'] ?? 0.5) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shiprocket_default_length" class="block text-sm font-medium text-gray-700 mb-2">
                                Default Package Length (cm)
                            </label>
                            <input type="number" name="shiprocket_default_length" id="shiprocket_default_length" min="1"
                                   value="{{ old('shiprocket_default_length', $settings['general']['shiprocket_default_length'] ?? 10) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shiprocket_default_breadth" class="block text-sm font-medium text-gray-700 mb-2">
                                Default Package Breadth (cm)
                            </label>
                            <input type="number" name="shiprocket_default_breadth" id="shiprocket_default_breadth" min="1"
                                   value="{{ old('shiprocket_default_breadth', $settings['general']['shiprocket_default_breadth'] ?? 10) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="shiprocket_default_height" class="block text-sm font-medium text-gray-700 mb-2">
                                Default Package Height (cm)
                            </label>
                            <input type="number" name="shiprocket_default_height" id="shiprocket_default_height" min="1"
                                   value="{{ old('shiprocket_default_height', $settings['general']['shiprocket_default_height'] ?? 10) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reset Confirmation Modal -->
    <div id="resetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reset Shiprocket Settings</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to reset all Shiprocket settings? This action cannot be undone.</p>
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="hideResetModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                        Cancel
                    </button>
                    <form action="{{ route('admin.shiprocket-settings.reset') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Reset Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Connection Test Modal -->
    <div id="connectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Testing Connection</h3>
                <div id="connectionResult" class="mb-4">
                    <div class="flex items-center">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                        <span class="text-gray-600">Testing connection to Shiprocket...</span>
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button type="button" onclick="hideConnectionModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showResetModal() {
            document.getElementById('resetModal').classList.remove('hidden');
        }

        function hideResetModal() {
            document.getElementById('resetModal').classList.add('hidden');
        }

        function showConnectionModal() {
            document.getElementById('connectionModal').classList.remove('hidden');
        }

        function hideConnectionModal() {
            document.getElementById('connectionModal').classList.add('hidden');
        }

        // Test connection function
        function testConnection() {
            showConnectionModal();

            fetch('{{ route("admin.shiprocket-settings.test-connection") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('connectionResult');

                if (data.status === 'success') {
                    resultDiv.innerHTML = `
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-3"></i>
                            <div>
                                <p class="font-medium">Connection Successful!</p>
                                <p class="text-sm text-gray-600">${data.message}</p>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <div>
                                <p class="font-medium">Connection Failed</p>
                                <p class="text-sm text-gray-600">${data.message}</p>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                const resultDiv = document.getElementById('connectionResult');
                resultDiv.innerHTML = `
                    <div class="flex items-center text-red-600">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        <div>
                            <p class="font-medium">Error</p>
                            <p class="text-sm text-gray-600">Failed to test connection</p>
                        </div>
                    </div>
                `;
            });
        }

        // Fetch pickup locations function
        function fetchPickupLocations() {
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Fetching...';
            button.disabled = true;

            fetch('{{ route("admin.shiprocket-settings.pickup-locations") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.pickup_locations.length > 0) {
                    // Fill form with first pickup location
                    const location = data.pickup_locations[0];

                    document.getElementById('shiprocket_pickup_location').value = location.pickup_location || '';
                    document.getElementById('shiprocket_pickup_name').value = location.name || '';
                    document.getElementById('shiprocket_pickup_email').value = location.email || '';
                    document.getElementById('shiprocket_pickup_phone').value = location.phone || '';
                    document.getElementById('shiprocket_pickup_address').value = location.address || '';
                    document.getElementById('shiprocket_pickup_address_2').value = location.address_2 || '';
                    document.getElementById('shiprocket_pickup_city').value = location.city || '';
                    document.getElementById('shiprocket_pickup_state').value = location.state || '';
                    document.getElementById('shiprocket_pickup_country').value = location.country || 'India';
                    document.getElementById('shiprocket_pickup_pin_code').value = location.pin_code || '';

                    // Show success message
                    showNotification('Pickup location details fetched successfully!', 'success');
                } else {
                    showNotification(data.message || 'No pickup locations found', 'error');
                }
            })
            .catch(error => {
                showNotification('Failed to fetch pickup locations', 'error');
            })
            .finally(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }

        // Show notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800'}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Copy webhook URL
        function copyWebhookUrl() {
            const input = document.getElementById('webhook-url-display');
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(input.value).then(() => {
                showNotification('Webhook URL copied to clipboard!', 'success');
            }).catch(() => {
                // Fallback for older browsers
                document.execCommand('copy');
                showNotification('Webhook URL copied to clipboard!', 'success');
            });
        }

        // Copy webhook token
        function copyWebhookToken() {
            const input = document.getElementById('webhook-token-display');
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices

            navigator.clipboard.writeText(input.value).then(() => {
                showNotification('Webhook token copied to clipboard!', 'success');
            }).catch(() => {
                // Fallback for older browsers
                document.execCommand('copy');
                showNotification('Webhook token copied to clipboard!', 'success');
            });
        }

        // Regenerate webhook token
        function regenerateToken() {
            if (!confirm('Are you sure you want to regenerate the webhook token? This will invalidate the current token.')) {
                return;
            }

            // Generate a new random token
            const newToken = generateRandomToken(32);

            // Update both display and hidden inputs
            document.getElementById('webhook-token-display').value = newToken;
            document.getElementById('webhook-token-hidden').value = newToken;

            showNotification('New webhook token generated! Remember to save the settings.', 'success');
        }

        // Generate random token
        function generateRandomToken(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let token = '';
            for (let i = 0; i < length; i++) {
                token += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return token;
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const resetModal = document.getElementById('resetModal');
            const connectionModal = document.getElementById('connectionModal');

            if (event.target === resetModal) {
                hideResetModal();
            }
            if (event.target === connectionModal) {
                hideConnectionModal();
            }
        }
    </script>
</x-layouts.admin>
