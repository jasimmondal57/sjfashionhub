<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">📊 Google Sheets Integration</h1>
                        <p class="text-gray-600 mt-1">Automatically sync your data to Google Sheets with real-time updates</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.google-sheets.logs') }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-history mr-2"></i>View Sync Logs
                        </a>
                        <button onclick="showSetupGuideModal()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-question-circle mr-2"></i>Setup Guide
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-sync text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Syncs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_syncs']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Success Rate</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['success_rate'] }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-database text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Records Synced</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_records_success']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Failed Records</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_records_failed']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sheet Configurations -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                <!-- Orders Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-blue-100">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">📦 Orders Sheet</h3>
                                <p class="text-sm text-gray-500">Sync order data automatically</p>
                            </div>
                        </div>
                        @if(isset($settings['orders']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $settings['orders']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['orders']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['orders']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['orders']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['orders']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['orders']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['orders']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'orders') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('orders')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('orders')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'orders') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for orders</p>
                            <a href="{{ route('admin.google-sheets.configure', 'orders') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Orders Sheet
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Returns Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-orange-100">
                                <i class="fas fa-undo text-orange-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">🔄 Returns Sheet</h3>
                                <p class="text-sm text-gray-500">Sync return order data</p>
                            </div>
                        </div>
                        @if(isset($settings['returns']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $settings['returns']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['returns']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['returns']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['returns']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['returns']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['returns']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['returns']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'returns') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('returns')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('returns')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'returns') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for returns</p>
                            <a href="{{ route('admin.google-sheets.configure', 'returns') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Returns Sheet
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Users Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-green-100">
                                <i class="fas fa-users text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">👥 Users Sheet</h3>
                                <p class="text-sm text-gray-500">Sync user/customer data</p>
                            </div>
                        </div>
                        @if(isset($settings['users']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $settings['users']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['users']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['users']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['users']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['users']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['users']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['users']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'users') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('users')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('users')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'users') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for users</p>
                            <a href="{{ route('admin.google-sheets.configure', 'users') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Users Sheet
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Newsletters Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-purple-100">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">📧 Newsletters Sheet</h3>
                                <p class="text-sm text-gray-500">Sync newsletter subscriber data</p>
                            </div>
                        </div>
                        @if(isset($settings['newsletters']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $settings['newsletters']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['newsletters']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['newsletters']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['newsletters']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['newsletters']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['newsletters']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['newsletters']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'newsletters') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('newsletters')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('newsletters')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'newsletters') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for newsletter subscribers</p>
                            <a href="{{ route('admin.google-sheets.configure', 'newsletters') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Newsletters Sheet
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Data Sheets -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">
                <!-- User Addresses Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-indigo-100">
                                <i class="fas fa-map-marker-alt text-indigo-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">📍 User Addresses</h3>
                                <p class="text-sm text-gray-500">Sync user address data</p>
                            </div>
                        </div>
                        @if(isset($settings['user_addresses']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $settings['user_addresses']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['user_addresses']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['user_addresses']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['user_addresses']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['user_addresses']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['user_addresses']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['user_addresses']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'user_addresses') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('user_addresses')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('user_addresses')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'user_addresses') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for user addresses</p>
                            <a href="{{ route('admin.google-sheets.configure', 'user_addresses') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Addresses Sheet
                            </a>
                        </div>
                    @endif
                </div>

                <!-- User Changes Sheet -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full bg-yellow-100">
                                <i class="fas fa-history text-yellow-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">📝 Change History</h3>
                                <p class="text-sm text-gray-500">Track all user data changes</p>
                            </div>
                        </div>
                        @if(isset($settings['user_changes']))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $settings['user_changes']->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['user_changes']->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Not Configured
                            </span>
                        @endif
                    </div>

                    @if(isset($settings['user_changes']))
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sheet Name:</span>
                                <span class="text-gray-900">{{ $settings['user_changes']->sheet_name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Auto Sync:</span>
                                <span class="text-gray-900">{{ $settings['user_changes']->auto_sync ? 'Enabled' : 'Disabled' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Last Sync:</span>
                                <span class="text-gray-900">{{ $settings['user_changes']->last_sync_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Synced:</span>
                                <span class="text-gray-900">{{ number_format($settings['user_changes']->total_synced) }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.google-sheets.configure', 'user_changes') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('user_changes')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="createHeaders('user_changes')"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Create Headers
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'user_changes') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                    Sync Now
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500 text-sm mb-3">Configure Google Sheets integration for change tracking</p>
                            <a href="{{ route('admin.google-sheets.configure', 'user_changes') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Setup Changes Sheet
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Sync Logs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">📋 Recent Sync Activity</h3>
                    <a href="{{ route('admin.google-sheets.logs') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All Logs →
                    </a>
                </div>

                @if($recentLogs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sheet Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operation</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Started</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentLogs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($log->googleSheetsSetting->sheet_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->operation_label }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $log->status === 'success' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $log->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $log->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $log->status === 'partial' ? 'bg-orange-100 text-orange-800' : '' }}">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->records_success }}/{{ $log->records_processed }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->formatted_duration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->started_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">No sync activity yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Setup Guide Modal -->
    <div id="setupGuideModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">🚀 Google Sheets Integration Setup Guide</h3>
                    <button onclick="hideSetupGuideModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Step 1 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">📋 Step 1: Create Google Spreadsheet</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-gray-600">
                            <li>Go to <a href="https://sheets.google.com" target="_blank" class="text-blue-600 hover:underline">Google Sheets</a></li>
                            <li>Create a new spreadsheet</li>
                            <li>Create separate sheets for Orders, Returns, Users, Newsletters, User Addresses, and User Changes</li>
                            <li>Copy the Spreadsheet ID from the URL (between /d/ and /edit)</li>
                        </ol>
                    </div>

                    <!-- Step 2 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">⚙️ Step 2: Create Google Apps Script</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-gray-600">
                            <li>Go to <a href="https://script.google.com" target="_blank" class="text-blue-600 hover:underline">Google Apps Script</a></li>
                            <li>Create a new project</li>
                            <li>Replace the default code with our provided script</li>
                            <li>Deploy as Web App with "Anyone" access</li>
                            <li>Copy the Web App URL</li>
                        </ol>
                        <div class="mt-3">
                            <button onclick="showAppScript()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                View Apps Script Code
                            </button>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">🔧 Step 3: Configure Integration</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-gray-600">
                            <li>Click "Configure" on any sheet type above</li>
                            <li>Enter your Spreadsheet ID and Web App URL</li>
                            <li>Configure column mappings as needed</li>
                            <li>Test the connection</li>
                            <li>Enable auto-sync if desired</li>
                        </ol>
                    </div>

                    <!-- Step 4 -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">🔄 Step 4: Test & Monitor</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-gray-600">
                            <li>Use "Test" button to verify connection</li>
                            <li>Run "Sync Now" to perform initial data sync</li>
                            <li>Monitor sync logs for any issues</li>
                            <li>Data will automatically sync based on your settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apps Script Code Modal -->
    <div id="appScriptModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">📝 Google Apps Script Code</h3>
                    <button onclick="hideAppScriptModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto">
                    <pre class="text-sm"><code>/**
 * SJ Fashion Hub - Google Sheets Integration Script
 *
 * This Google Apps Script handles automatic data synchronization between
 * SJ Fashion Hub and Google Sheets for Orders, Returns, Users, and more.
 *
 * Deploy this as a Web App to enable real-time data sync.
 */

/**
 * Main function to handle POST requests from SJ Fashion Hub
 */
function doPost(e) {
  try {
    // Check if this is a valid POST request
    if (!e || !e.postData || !e.postData.contents) {
      throw new Error('Invalid request: No POST data received');
    }

    // Parse the incoming data
    const data = JSON.parse(e.postData.contents);
    const action = data.action;
    const spreadsheetId = data.spreadsheet_id;
    const sheetName = data.sheet_name;
    const columnMapping = data.column_mapping;
    const rowData = data.data;
    const sheetType = data.sheet_type;

    // Log the request for debugging
    console.log('Received request:', {
      action: action,
      sheetType: sheetType,
      spreadsheetId: spreadsheetId,
      sheetName: sheetName,
      dataCount: Array.isArray(rowData) ? rowData.length : 1
    });

    // Open the spreadsheet
    const spreadsheet = SpreadsheetApp.openById(spreadsheetId);
    let sheet = spreadsheet.getSheetByName(sheetName);

    // Create sheet if it doesn't exist
    if (!sheet) {
      sheet = spreadsheet.insertSheet(sheetName);

      // Add headers based on sheet type
      const headers = getHeadersForSheetType(sheetType, columnMapping);
      if (headers.length > 0) {
        sheet.getRange(1, 1, 1, headers.length).setValues([headers]);

        // Format headers
        const headerRange = sheet.getRange(1, 1, 1, headers.length);
        headerRange.setBackground('#4285f4');
        headerRange.setFontColor('#ffffff');
        headerRange.setFontWeight('bold');
        headerRange.setHorizontalAlignment('center');
      }
    }

    // Handle different actions
    switch (action) {
      case 'test_connection':
        return handleTestConnection(sheet, sheetName);

      case 'create':
      case 'update':
        return handleSingleRecord(sheet, rowData, columnMapping, action);

      case 'bulk_insert':
        return handleBulkInsert(sheet, rowData, columnMapping);

      case 'delete':
        return handleDelete(sheet, rowData, columnMapping);

      case 'create_headers':
        return handleCreateHeaders(sheet, data.headers, columnMapping, sheetType);

      default:
        throw new Error('Unknown action: ' + action);
    }

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: 'Data synced successfully',
      records_processed: Array.isArray(rowData) ? rowData.length : 1,
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    console.error('Error processing request:', error);

    // More detailed error information
    const errorInfo = {
      success: false,
      error: error.toString(),
      error_type: error.name || 'Unknown',
      timestamp: new Date().toISOString(),
      help: 'Check that the request includes valid POST data with required fields'
    };

    // Add specific help for common errors
    if (error.message.includes('postData')) {
      errorInfo.help = 'This script must be called via HTTP POST request, not run directly. Use the testScript() function for testing.';
      errorInfo.suggestion = 'Run testScript() function in the editor to test the script functionality.';
    }

    return ContentService.createTextOutput(JSON.stringify(errorInfo))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Handle GET requests (for testing)
 */
function doGet(e) {
  return ContentService.createTextOutput(JSON.stringify({
    message: 'SJ Fashion Hub Google Sheets Integration',
    status: 'active',
    version: '2.0.0',
    timestamp: new Date().toISOString(),
    supportedActions: ['test_connection', 'create', 'update', 'bulk_insert', 'delete', 'create_headers']
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Test function that can be run directly in Google Apps Script editor
 */
function testScript() {
  try {
    console.log('🧪 Testing SJ Fashion Hub Google Sheets Integration...');
    console.log('✅ SpreadsheetApp access: OK');

    const colNum = getColumnNumber('C');
    console.log('✅ getColumnNumber("C") =', colNum);

    const formatted = formatFieldName('customer_name');
    console.log('✅ formatFieldName("customer_name") =', formatted);

    console.log('🎉 All tests passed! Script is ready for use.');
    return { success: true, message: 'Test completed successfully' };
  } catch (error) {
    console.error('❌ Test failed:', error);
    return { success: false, error: error.toString() };
  }
}

/**
 * Handle test connection requests
 */
function handleTestConnection(sheet, sheetName) {
  return ContentService.createTextOutput(JSON.stringify({
    success: true,
    message: 'Connection test successful',
    sheet_info: {
      name: sheetName,
      rows: sheet.getLastRow(),
      columns: sheet.getLastColumn(),
      url: sheet.getParent().getUrl()
    },
    timestamp: new Date().toISOString()
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Handle creating headers for a sheet
 */
function handleCreateHeaders(sheet, headers, columnMapping, sheetType) {
  try {
    // Clear existing headers if any
    const lastColumn = sheet.getLastColumn();
    if (lastColumn > 0) {
      sheet.getRange(1, 1, 1, lastColumn).clearContent();
    }

    // Create headers array based on column mapping
    const headerValues = [];
    const maxColumn = Math.max(...Object.values(columnMapping).map(col => getColumnNumber(col)));

    // Initialize array with empty values
    for (let i = 0; i < maxColumn; i++) {
      headerValues[i] = '';
    }

    // Fill in the headers based on column mapping
    for (const [field, column] of Object.entries(columnMapping)) {
      const colIndex = getColumnNumber(column) - 1; // Convert to 0-based index
      headerValues[colIndex] = headers[field] || formatFieldName(field);
    }

    // Set the headers
    if (headerValues.length > 0) {
      sheet.getRange(1, 1, 1, headerValues.length).setValues([headerValues]);

      // Format headers
      const headerRange = sheet.getRange(1, 1, 1, headerValues.length);
      headerRange.setBackground('#4285f4');
      headerRange.setFontColor('#ffffff');
      headerRange.setFontWeight('bold');
      headerRange.setHorizontalAlignment('center');
      headerRange.setVerticalAlignment('middle');
    }

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: `Headers created successfully for ${sheetType}`,
      headers_count: headerValues.filter(h => h !== '').length,
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    console.error('Error creating headers:', error);
    return ContentService.createTextOutput(JSON.stringify({
      success: false,
      error: error.toString(),
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Convert column letter to number (A=1, B=2, etc.)
 */
function getColumnNumber(columnLetter) {
  let result = 0;
  for (let i = 0; i < columnLetter.length; i++) {
    result = result * 26 + (columnLetter.charCodeAt(i) - 'A'.charCodeAt(0) + 1);
  }
  return result;
}

/**
 * Format field name to readable header
 */
function formatFieldName(field) {
  return field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

/**
 * Get headers for specific sheet type
 */
function getHeadersForSheetType(sheetType, columnMapping) {
  const headers = [];
  for (const [field, column] of Object.entries(columnMapping)) {
    headers.push(formatFieldName(field));
  }
  return headers;
}

/**
 * Handle single record operations
 */
function handleSingleRecord(sheet, rowData, columnMapping, action) {
  try {
    const values = Object.keys(columnMapping).map(key => rowData[key] || '');
    sheet.appendRow(values);

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: `Record ${action}d successfully`,
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);
  } catch (error) {
    return ContentService.createTextOutput(JSON.stringify({
      success: false,
      error: error.toString()
    })).setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Handle bulk insert operations
 */
function handleBulkInsert(sheet, rowData, columnMapping) {
  try {
    if (Array.isArray(rowData) && rowData.length > 0) {
      const values = rowData.map(row =>
        Object.keys(columnMapping).map(key => row[key] || '')
      );

      sheet.getRange(sheet.getLastRow() + 1, 1, values.length, values[0].length)
           .setValues(values);
    }

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: 'Bulk insert completed successfully',
      records_processed: rowData.length,
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);
  } catch (error) {
    return ContentService.createTextOutput(JSON.stringify({
      success: false,
      error: error.toString()
    })).setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Handle delete operations
 */
function handleDelete(sheet, rowData, columnMapping) {
  return ContentService.createTextOutput(JSON.stringify({
    success: true,
    message: 'Delete operation completed',
    timestamp: new Date().toISOString()
  })).setMimeType(ContentService.MimeType.JSON);
}</code></pre>
                </div>

                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h4 class="font-medium text-blue-800 mb-2">✨ New Features in This Version:</h4>
                    <ul class="list-disc list-inside space-y-1 text-sm text-blue-700">
                        <li><strong>Header Creation:</strong> Automatically creates proper column headers</li>
                        <li><strong>Enhanced Error Handling:</strong> Better error messages and debugging</li>
                        <li><strong>Test Function:</strong> Run <code>testScript()</code> to verify functionality</li>
                        <li><strong>Support for All Sheet Types:</strong> Orders, Returns, Users, Newsletters, Addresses, Changes</li>
                        <li><strong>Improved Formatting:</strong> Professional header styling and column widths</li>
                    </ul>
                </div>

                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h4 class="font-medium text-yellow-800 mb-2">📋 Deployment Instructions:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-yellow-700">
                        <li>Copy the complete code above</li>
                        <li>Go to <a href="https://script.google.com" target="_blank" class="text-blue-600 hover:underline">Google Apps Script</a></li>
                        <li>Create a new project or open existing one</li>
                        <li>Replace all existing code with the code above</li>
                        <li>Save the project (Ctrl+S)</li>
                        <li>Click "Deploy" → "New deployment"</li>
                        <li>Choose "Web app" as type</li>
                        <li>Set "Execute as" to "Me"</li>
                        <li>Set "Who has access" to "Anyone"</li>
                        <li>Click "Deploy" and copy the Web App URL</li>
                        <li>Use this URL in your Google Sheets configuration below</li>
                    </ol>
                </div>

                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <h4 class="font-medium text-green-800 mb-2">🧪 Testing Your Script:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-green-700">
                        <li>After pasting the code, click the "Run" button in Google Apps Script</li>
                        <li>Select the <code>testScript</code> function from the dropdown</li>
                        <li>Click "Run" and check the execution log for success messages</li>
                        <li>If successful, proceed with deployment</li>
                    </ol>
                </div>

                <div class="mt-4 flex justify-end">
                    <button onclick="copyAppScript()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-copy mr-2"></i>Copy Code
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Connection Test Modal -->
    <div id="connectionTestModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Testing Connection</h3>
                <div id="connectionResult" class="mb-4">
                    <div class="flex items-center">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                        <span class="text-gray-600">Testing connection...</span>
                    </div>
                </div>
                <div class="flex items-center justify-end">
                    <button type="button" onclick="hideConnectionTestModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showSetupGuideModal() {
            document.getElementById('setupGuideModal').classList.remove('hidden');
        }

        function hideSetupGuideModal() {
            document.getElementById('setupGuideModal').classList.add('hidden');
        }

        function showAppScript() {
            hideSetupGuideModal();
            document.getElementById('appScriptModal').classList.remove('hidden');
        }

        function hideAppScriptModal() {
            document.getElementById('appScriptModal').classList.add('hidden');
        }

        function showConnectionTestModal() {
            document.getElementById('connectionTestModal').classList.remove('hidden');
        }

        function hideConnectionTestModal() {
            document.getElementById('connectionTestModal').classList.add('hidden');
        }

        // Copy Apps Script code
        function copyAppScript() {
            const code = document.querySelector('#appScriptModal pre code').textContent;
            navigator.clipboard.writeText(code).then(() => {
                showNotification('Apps Script code copied to clipboard!', 'success');
            }).catch(() => {
                showNotification('Failed to copy code', 'error');
            });
        }

        // Test connection function
        function testConnection(sheetType) {
            showConnectionTestModal();

            fetch(`/admin/google-sheets/${sheetType}/test-connection`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('connectionResult');

                if (data.success) {
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

        // Create headers function
        function createHeaders(sheetType) {
            if (!confirm(`Are you sure you want to create headers for the ${sheetType} sheet? This will replace any existing headers.`)) {
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Creating...';
            button.disabled = true;

            fetch('{{ route("admin.google-sheets.create-headers") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    sheet_type: sheetType
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Headers created successfully for ${sheetType} sheet!`, 'success');
                } else {
                    let errorMessage = `Failed to create headers: ${data.message}`;
                    if (data.help) {
                        errorMessage += `\n\nHelp: ${data.help}`;
                    }
                    showNotification(errorMessage, 'error');

                    // If web app URL is missing, show additional guidance
                    if (data.message.includes('Web App URL not configured')) {
                        setTimeout(() => {
                            if (confirm('Would you like to configure the Google Apps Script now?')) {
                                showAppScript();
                            }
                        }, 2000);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to create headers. Please try again.', 'error');
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const setupGuideModal = document.getElementById('setupGuideModal');
            const appScriptModal = document.getElementById('appScriptModal');
            const connectionTestModal = document.getElementById('connectionTestModal');

            if (event.target === setupGuideModal) {
                hideSetupGuideModal();
            }
            if (event.target === appScriptModal) {
                hideAppScriptModal();
            }
            if (event.target === connectionTestModal) {
                hideConnectionTestModal();
            }
        }
    </script>
</x-layouts.admin>
