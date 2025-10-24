<x-layouts.admin>
    <x-slot name="title">Analytics & Tracking</x-slot>
    <x-slot name="description">Manage Google Analytics, Google Tag Manager, and Facebook Pixel</x-slot>
    <x-slot name="pageTitle">📊 Analytics & Tracking Management</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Analytics Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-black">Google Analytics</h3>
                    <div class="w-3 h-3 rounded-full {{ $settings->isGoogleAnalyticsActive() ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                <p class="text-sm text-gray-600 mb-2">
                    {{ $settings->isGoogleAnalyticsActive() ? 'Active' : 'Inactive' }}
                </p>
                @if($settings->google_analytics_id)
                    <p class="text-xs text-gray-500">ID: {{ $settings->google_analytics_id }}</p>
                @endif
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-black">Google Tag Manager</h3>
                    <div class="w-3 h-3 rounded-full {{ $settings->isGoogleTagManagerActive() ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                <p class="text-sm text-gray-600 mb-2">
                    {{ $settings->isGoogleTagManagerActive() ? 'Active' : 'Inactive' }}
                </p>
                @if($settings->google_tag_manager_id)
                    <p class="text-xs text-gray-500">ID: {{ $settings->google_tag_manager_id }}</p>
                @endif
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-black">Facebook Pixel</h3>
                    <div class="w-3 h-3 rounded-full {{ $settings->isFacebookPixelActive() ? 'bg-green-500' : 'bg-red-500' }}"></div>
                </div>
                <p class="text-sm text-gray-600 mb-2">
                    {{ $settings->isFacebookPixelActive() ? 'Active' : 'Inactive' }}
                </p>
                @if($settings->facebook_pixel_id)
                    <p class="text-xs text-gray-500">ID: {{ $settings->facebook_pixel_id }}</p>
                @endif
            </div>
        </div>

        <!-- Analytics Configuration Form -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-6">Analytics Configuration</h3>

            <form id="analytics-form" onsubmit="updateAnalytics(event)">
                <!-- Google Analytics Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-medium text-black">Google Analytics 4</h4>
                        <label class="flex items-center">
                            <input type="checkbox" name="google_analytics_enabled" value="1"
                                   {{ $settings->google_analytics_enabled ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:border-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="google_analytics_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Measurement ID
                            </label>
                            <input type="text"
                                   id="google_analytics_id"
                                   name="google_analytics_id"
                                   value="{{ $settings->google_analytics_id }}"
                                   placeholder="G-XXXXXXXXXX"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                            <p class="text-xs text-gray-500 mt-1">Format: G-XXXXXXXXXX</p>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="testGoogleAnalytics()" class="btn btn-outline">
                                🧪 Test Connection
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Google Tag Manager Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-medium text-black">Google Tag Manager</h4>
                        <label class="flex items-center">
                            <input type="checkbox" name="google_tag_manager_enabled" value="1"
                                   {{ $settings->google_tag_manager_enabled ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:border-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="google_tag_manager_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Container ID
                            </label>
                            <input type="text"
                                   id="google_tag_manager_id"
                                   name="google_tag_manager_id"
                                   value="{{ $settings->google_tag_manager_id }}"
                                   placeholder="GTM-XXXXXXX"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                            <p class="text-xs text-gray-500 mt-1">Format: GTM-XXXXXXX</p>
                        </div>
                    </div>
                </div>

                <!-- Facebook Pixel Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-medium text-black">Facebook Pixel</h4>
                        <label class="flex items-center">
                            <input type="checkbox" name="facebook_pixel_enabled" value="1"
                                   {{ $settings->facebook_pixel_enabled ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:border-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Enable</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="facebook_pixel_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pixel ID
                            </label>
                            <input type="text"
                                   id="facebook_pixel_id"
                                   name="facebook_pixel_id"
                                   value="{{ $settings->facebook_pixel_id }}"
                                   placeholder="1234567890123456"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black">
                            <p class="text-xs text-gray-500 mt-1">16-digit numeric ID</p>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="testFacebookPixel()" class="btn btn-outline">
                                🧪 Test Connection
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="btn btn-primary">
                        💾 Save Settings
                    </button>
                    <button type="button" onclick="resetForm()" class="btn btn-outline">
                        🔄 Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Implementation Guide -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">📚 Implementation Guide</h3>
            <div class="space-y-4 text-sm text-blue-800">
                <div>
                    <h4 class="font-medium mb-2">Google Analytics 4:</h4>
                    <p>• Create a GA4 property in Google Analytics</p>
                    <p>• Copy the Measurement ID (starts with G-)</p>
                    <p>• Tracks page views, events, and conversions automatically</p>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Google Tag Manager:</h4>
                    <p>• Create a container in Google Tag Manager</p>
                    <p>• Copy the Container ID (starts with GTM-)</p>
                    <p>• Allows advanced tracking configuration without code changes</p>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Facebook Pixel:</h4>
                    <p>• Create a pixel in Facebook Business Manager</p>
                    <p>• Copy the 16-digit Pixel ID</p>
                    <p>• Tracks conversions for Facebook and Instagram ads</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateAnalytics(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const button = event.target.querySelector('button[type="submit"]');
            const originalText = button.textContent;

            button.textContent = '💾 Saving...';
            button.disabled = true;

            fetch('{{ route("admin.analytics.update") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Error: ' + error.message);
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }

        function testGoogleAnalytics() {
            const trackingId = document.getElementById('google_analytics_id').value;

            if (!trackingId) {
                alert('Please enter a Google Analytics Measurement ID');
                return;
            }

            fetch('{{ route("admin.analytics.test.google-analytics") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ tracking_id: trackingId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
            })
            .catch(error => {
                alert('❌ Error: ' + error.message);
            });
        }

        function testFacebookPixel() {
            const pixelId = document.getElementById('facebook_pixel_id').value;

            if (!pixelId) {
                alert('Please enter a Facebook Pixel ID');
                return;
            }

            fetch('{{ route("admin.analytics.test.facebook-pixel") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ pixel_id: pixelId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
            })
            .catch(error => {
                alert('❌ Error: ' + error.message);
            });
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset all analytics settings?')) {
                document.getElementById('analytics-form').reset();
            }
        }
    </script>
</x-layouts.admin>
