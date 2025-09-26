<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">⚙️ Configure {{ ucfirst($sheetType) }} Sheet</h1>
                        <p class="text-gray-600 mt-1">Set up Google Sheets integration for {{ $sheetType }} data</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.google-sheets.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                        @if($setting)
                            <button onclick="testConnection()" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-plug mr-2"></i>Test Connection
                            </button>
                        @endif
                    </div>
                </div>
            </div>

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

            <form action="{{ route('admin.google-sheets.store', $sheetType) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Basic Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📋 Basic Configuration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sheet_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Sheet Name *
                            </label>
                            <input type="text" name="sheet_name" id="sheet_name" required
                                   value="{{ old('sheet_name', $setting->sheet_name ?? ucfirst($sheetType)) }}"
                                   placeholder="e.g., Orders, Returns, Users"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sheet_name') border-red-500 @enderror">
                            @error('sheet_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="spreadsheet_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Spreadsheet ID *
                            </label>
                            <input type="text" name="spreadsheet_id" id="spreadsheet_id" required
                                   value="{{ old('spreadsheet_id', $setting->spreadsheet_id ?? '') }}"
                                   placeholder="1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('spreadsheet_id') border-red-500 @enderror">
                            @error('spreadsheet_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Found in the Google Sheets URL between /d/ and /edit</p>
                        </div>
                        <div>
                            <label for="sheet_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sheet ID (Optional)
                            </label>
                            <input type="text" name="sheet_id" id="sheet_id"
                                   value="{{ old('sheet_id', $setting->sheet_id ?? '') }}"
                                   placeholder="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-gray-500 text-xs mt-1">Found in the URL after #gid= (0 for first sheet)</p>
                        </div>
                        <div>
                            <label for="web_app_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Google Apps Script Web App URL *
                            </label>
                            <input type="url" name="web_app_url" id="web_app_url" required
                                   value="{{ old('web_app_url', $setting->web_app_url ?? '') }}"
                                   placeholder="https://script.google.com/macros/s/..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('web_app_url') border-red-500 @enderror">
                            @error('web_app_url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sync Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🔄 Sync Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="auto_sync" id="auto_sync" value="1"
                                       {{ old('auto_sync', $setting->auto_sync ?? true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="auto_sync" class="ml-2 block text-sm text-gray-700">
                                    Enable automatic sync
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="real_time_sync" id="real_time_sync" value="1"
                                       {{ old('real_time_sync', $setting->real_time_sync ?? false) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="real_time_sync" class="ml-2 block text-sm text-gray-700">
                                    Enable real-time sync (immediate updates)
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="sync_frequency" class="block text-sm font-medium text-gray-700 mb-2">
                                Sync Frequency
                            </label>
                            <select name="sync_frequency" id="sync_frequency"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="hourly" {{ old('sync_frequency', $setting->sync_frequency ?? 'hourly') === 'hourly' ? 'selected' : '' }}>Hourly</option>
                                <option value="daily" {{ old('sync_frequency', $setting->sync_frequency ?? 'hourly') === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('sync_frequency', $setting->sync_frequency ?? 'hourly') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Column Mapping -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">📊 Column Mapping</h3>
                        <button type="button" onclick="resetToDefaults()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                            Reset to Defaults
                        </button>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Map database fields to Google Sheets columns (A, B, C, etc.)</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="columnMapping">
                        @foreach($defaultMapping as $field => $defaultColumn)
                            <div class="flex items-center space-x-3">
                                <label class="text-sm font-medium text-gray-700 w-32">{{ ucfirst(str_replace('_', ' ', $field)) }}:</label>
                                <input type="text" name="column_mapping[{{ $field }}]" 
                                       value="{{ old('column_mapping.' . $field, $setting->column_mapping[$field] ?? $defaultColumn) }}"
                                       placeholder="{{ $defaultColumn }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Service Account (Optional) -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">🔐 Service Account (Optional)</h3>
                    <p class="text-gray-600 text-sm mb-4">For enhanced security, you can use a Google Service Account instead of public access</p>
                    
                    <div>
                        <label for="service_account_json" class="block text-sm font-medium text-gray-700 mb-2">
                            Service Account JSON
                        </label>
                        <textarea name="service_account_json" id="service_account_json" rows="6"
                                  placeholder='{"type": "service_account", "project_id": "...", ...}'
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('service_account_json') border-red-500 @enderror">{{ old('service_account_json') }}</textarea>
                        @error('service_account_json')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 text-xs mt-1">Paste the entire JSON content from your Google Service Account key file</p>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">📝 Notes</h3>
                    <textarea name="notes" id="notes" rows="3"
                              placeholder="Add any notes about this configuration..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $setting->notes ?? '') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.google-sheets.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-md font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Configuration
                    </button>
                </div>
            </form>
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
        const defaultMapping = @json($defaultMapping);

        function resetToDefaults() {
            Object.keys(defaultMapping).forEach(field => {
                const input = document.querySelector(`input[name="column_mapping[${field}]"]`);
                if (input) {
                    input.value = defaultMapping[field];
                }
            });
            showNotification('Column mapping reset to defaults', 'success');
        }

        function testConnection() {
            document.getElementById('connectionTestModal').classList.remove('hidden');
            
            fetch(`{{ route('admin.google-sheets.test-connection', $sheetType) }}`, {
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

        function hideConnectionTestModal() {
            document.getElementById('connectionTestModal').classList.add('hidden');
        }

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
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const connectionTestModal = document.getElementById('connectionTestModal');
            if (event.target === connectionTestModal) {
                hideConnectionTestModal();
            }
        }
    </script>
</x-layouts.admin>
