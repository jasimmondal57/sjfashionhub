<x-layouts.admin>
    <x-slot name="pageTitle">Facebook Integration</x-slot>

<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">📘 Facebook Integration</h1>
        <div class="flex gap-2">
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700" onclick="testConnection()">
                <i class="fas fa-plug mr-2"></i> Test Connection
            </button>
            <a href="{{ route('admin.facebook.download-feed') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                <i class="fas fa-download mr-2"></i> Download Feed XML
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase mb-1">Total Products</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_products']) }}</div>
                </div>
                <div>
                    <i class="fas fa-box text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-600 uppercase mb-1">Synced to Facebook</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['synced_products']) }}</div>
                </div>
                <div>
                    <i class="fas fa-check-circle text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-yellow-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Pending Sync</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_products']) }}</div>
                </div>
                <div>
                    <i class="fas fa-clock text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-red-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-red-600 uppercase mb-1">Failed</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['failed_products']) }}</div>
                </div>
                <div>
                    <i class="fas fa-exclamation-triangle text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Facebook Pixel Settings -->
        <div>
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-base font-semibold text-gray-900">📊 Facebook Pixel Settings</h6>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.facebook.update-pixel') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pixel ID</label>
                            <input type="text" name="pixel_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->pixel_id }}" placeholder="123456789012345">
                            <p class="mt-1 text-xs text-gray-500">Your Facebook Pixel ID from Meta Events Manager</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="pixel_enabled" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="pixelEnabled" {{ $settings->pixel_enabled ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-gray-900" for="pixelEnabled">
                                    Enable Facebook Pixel Tracking
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Events to Track</label>
                            @php
                                $eventTracking = $settings->event_tracking ?? \App\Models\FacebookSetting::getDefaultEventTracking();
                            @endphp
                            <div class="space-y-2">
                                @foreach($eventTracking as $event => $enabled)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="event_tracking[{{ $event }}]" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="event{{ $event }}" {{ $enabled ? 'checked' : '' }}>
                                        <label class="ml-2 block text-sm text-gray-700" for="event{{ $event }}">
                                            {{ $event }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i> Save Pixel Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Facebook Catalog Settings -->
        <div>
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-base font-semibold text-gray-900">🛍️ Facebook Catalog Settings</h6>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.facebook.update-catalog') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Access Token *</label>
                            <input type="text" name="access_token" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->access_token ? '••••••••' : '' }}" placeholder="Enter new token to update">
                            <p class="mt-1 text-xs text-gray-500">Long-lived access token from Meta Business</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catalog ID *</label>
                            <input type="text" name="catalog_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->catalog_id }}" placeholder="123456789012345">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business ID</label>
                            <input type="text" name="business_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->business_id }}" placeholder="123456789012345">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">App ID</label>
                                <input type="text" name="app_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->app_id }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">App Secret</label>
                                <input type="text" name="app_secret" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->app_secret ? '••••••••' : '' }}" placeholder="Enter new secret to update">
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="catalog_sync_enabled" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="catalogEnabled" {{ $settings->catalog_sync_enabled ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-gray-900" for="catalogEnabled">
                                    Enable Catalog Sync
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="auto_sync_inventory" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="autoInventory" {{ $settings->auto_sync_inventory ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-gray-900" for="autoInventory">
                                    Auto-sync Inventory Updates
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="auto_sync_prices" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" id="autoPrices" {{ $settings->auto_sync_prices ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-gray-900" for="autoPrices">
                                    Auto-sync Price Updates
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sync Frequency (hours)</label>
                            <input type="number" name="sync_frequency_hours" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ $settings->sync_frequency_hours }}" min="1" max="168">
                            <p class="mt-1 text-xs text-gray-500">How often to run full catalog sync</p>
                        </div>

                        @if($settings->last_sync_at)
                            <p class="text-sm text-gray-500 mb-4">
                                Last synced: {{ $settings->last_sync_at->diffForHumans() }}
                            </p>
                        @endif

                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i> Save Catalog Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sync Actions -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">🔄 Sync Actions</h6>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('admin.facebook.sync-all') }}" method="POST" class="inline" onsubmit="return confirm('This will sync all active products to Facebook. Continue?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <i class="fas fa-sync mr-2"></i> Sync All Products Now
                    </button>
                </form>

                <a href="{{ route('admin.facebook.sync-logs') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-history mr-2"></i> View Sync Logs
                </a>
            </div>

            <div class="mt-4 rounded-md bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Products are automatically synced when created or updated. Use "Sync All" to force a full catalog sync.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sync Logs -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">📋 Recent Sync Activity</h6>
        </div>
        <div class="overflow-x-auto">
            @if($recentLogs->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Synced</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentLogs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $log->sync_type)) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'running' => 'bg-blue-100 text-blue-800',
                                            'partial' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                        $statusColor = $statusColors[$log->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">{{ ucfirst($log->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->products_synced }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->products_failed }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->duration ? $log->duration . 's' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('M d, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No sync activity yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function testConnection() {
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';

    fetch('{{ route('admin.facebook.test-connection') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message + '\n\nCatalog: ' + (data.catalog_name || 'Unknown') + '\nProducts: ' + (data.product_count || 0));
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Connection test failed: ' + error.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    });
}
</script>
</x-layouts.admin>

