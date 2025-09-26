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
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
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

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.google-sheets.configure', 'orders') }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('orders')" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'orders') }}" method="POST" class="flex-1">
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

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.google-sheets.configure', 'returns') }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('returns')" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'returns') }}" method="POST" class="flex-1">
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

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.google-sheets.configure', 'users') }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('users')" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'users') }}" method="POST" class="flex-1">
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

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.google-sheets.configure', 'newsletters') }}"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors text-center">
                                Configure
                            </a>
                            <button onclick="testConnection('newsletters')"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Test
                            </button>
                            <form action="{{ route('admin.google-sheets.manual-sync', 'newsletters') }}" method="POST" class="flex-1">
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
                            <li>Create separate sheets for Orders, Returns, and Users</li>
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
                    <pre class="text-sm"><code>function doPost(e) {
  try {
    const data = JSON.parse(e.postData.contents);
    const action = data.action;
    const spreadsheetId = data.spreadsheet_id;
    const sheetName = data.sheet_name;
    const columnMapping = data.column_mapping;
    const rowData = data.data;

    const spreadsheet = SpreadsheetApp.openById(spreadsheetId);
    let sheet = spreadsheet.getSheetByName(sheetName);

    // Create sheet if it doesn't exist
    if (!sheet) {
      sheet = spreadsheet.insertSheet(sheetName);
      // Add headers
      const headers = Object.keys(columnMapping);
      sheet.getRange(1, 1, 1, headers.length).setValues([headers]);
    }

    switch (action) {
      case 'test_connection':
        return ContentService.createTextOutput(JSON.stringify({
          success: true,
          message: 'Connection successful',
          sheet_info: {
            name: sheetName,
            rows: sheet.getLastRow(),
            columns: sheet.getLastColumn()
          }
        })).setMimeType(ContentService.MimeType.JSON);

      case 'create':
      case 'update':
        if (Array.isArray(rowData)) {
          // Handle single record
          const values = Object.keys(columnMapping).map(key => rowData[key] || '');
          sheet.appendRow(values);
        }
        break;

      case 'bulk_insert':
        if (Array.isArray(rowData)) {
          const values = rowData.map(row =>
            Object.keys(columnMapping).map(key => row[key] || '')
          );
          if (values.length > 0) {
            sheet.getRange(sheet.getLastRow() + 1, 1, values.length, values[0].length)
                 .setValues(values);
          }
        }
        break;
    }

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: 'Data synced successfully',
      records_processed: Array.isArray(rowData) ? rowData.length : 1
    })).setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    return ContentService.createTextOutput(JSON.stringify({
      success: false,
      error: error.toString()
    })).setMimeType(ContentService.MimeType.JSON);
  }
}

function doGet(e) {
  return ContentService.createTextOutput(JSON.stringify({
    message: 'SJ Fashion Hub Google Sheets Integration',
    status: 'active'
  })).setMimeType(ContentService.MimeType.JSON);
}</code></pre>
                </div>

                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <h4 class="font-medium text-yellow-800 mb-2">📋 Deployment Instructions:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-yellow-700">
                        <li>Copy the code above</li>
                        <li>Paste it into your Google Apps Script project</li>
                        <li>Save the project</li>
                        <li>Click "Deploy" → "New deployment"</li>
                        <li>Choose "Web app" as type</li>
                        <li>Set "Execute as" to "Me"</li>
                        <li>Set "Who has access" to "Anyone"</li>
                        <li>Click "Deploy" and copy the Web App URL</li>
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
