<x-layouts.admin>
    <x-slot name="title">Backup Settings</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">⚙️ Backup Settings</h1>
                <p class="text-gray-600 mt-1">Configure Google Drive integration and backup schedule</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.backup.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Backups
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
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

        <!-- Settings Form -->
        <div class="bg-white rounded-lg border border-gray-200">
            <form action="{{ route('admin.backup.settings.update') }}" method="POST">
                @csrf
                
                <!-- Google Drive Configuration -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Google Drive Configuration</h3>
                    <p class="text-sm text-gray-600 mt-1">Configure your Google Drive API credentials for backup storage</p>
                </div>
                
                <div class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="google_drive_client_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Client ID
                            </label>
                            <input type="text" 
                                   id="google_drive_client_id" 
                                   name="google_drive_client_id" 
                                   value="{{ $settings['google_drive_client_id'] ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter Google Drive Client ID">
                        </div>
                        
                        <div>
                            <label for="google_drive_client_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                Client Secret
                            </label>
                            <input type="password" 
                                   id="google_drive_client_secret" 
                                   name="google_drive_client_secret" 
                                   value="{{ $settings['google_drive_client_secret'] ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter Google Drive Client Secret">
                        </div>
                    </div>
                    
                    <div>
                        <label for="google_drive_redirect_uri" class="block text-sm font-medium text-gray-700 mb-2">
                            Redirect URI
                        </label>
                        <input type="url" 
                               id="google_drive_redirect_uri" 
                               name="google_drive_redirect_uri" 
                               value="{{ $settings['google_drive_redirect_uri'] ?? route('admin.backup.callback') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter Redirect URI">
                        <p class="text-sm text-gray-500 mt-1">Default: {{ route('admin.backup.callback') }}</p>
                    </div>
                    
                    <div>
                        <label for="google_drive_backup_folder" class="block text-sm font-medium text-gray-700 mb-2">
                            Backup Folder Name
                        </label>
                        <input type="text" 
                               id="google_drive_backup_folder" 
                               name="google_drive_backup_folder" 
                               value="{{ $settings['google_drive_backup_folder'] ?? 'SJ Fashion Hub Backups' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter folder name for backups">
                    </div>
                </div>

                <!-- Backup Schedule -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Backup Schedule</h3>
                    <p class="text-sm text-gray-600 mt-1">Configure automatic backup scheduling</p>
                </div>
                
                <div class="px-6 py-4 space-y-6">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="backup_schedule_enabled" 
                               name="backup_schedule_enabled" 
                               value="1"
                               {{ ($settings['backup_schedule_enabled'] ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="backup_schedule_enabled" class="ml-2 block text-sm text-gray-900">
                            Enable automatic daily backups
                        </label>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="backup_schedule_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Backup Time
                            </label>
                            <input type="time" 
                                   id="backup_schedule_time" 
                                   name="backup_schedule_time" 
                                   value="{{ $settings['backup_schedule_time'] ?? '02:00' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="backup_retention_days" class="block text-sm font-medium text-gray-700 mb-2">
                                Retention Days
                            </label>
                            <input type="number" 
                                   id="backup_retention_days" 
                                   name="backup_retention_days" 
                                   value="{{ $settings['backup_retention_days'] ?? 7 }}"
                                   min="1" 
                                   max="30"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Number of days to keep backups (1-30)</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 border-t border-gray-200 flex justify-between">
                    <div class="flex space-x-3">
                        @if($isConfigured)
                            <button type="button" 
                                    onclick="testConnection()" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Test Connection
                            </button>
                        @else
                            <a href="{{ route('admin.backup.authorize') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Authorize Google Drive
                            </a>
                        @endif
                    </div>
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-4">📋 Setup Instructions</h3>
            <div class="space-y-3 text-sm text-blue-800">
                <p><strong>1.</strong> Go to <a href="https://console.developers.google.com/" target="_blank" class="underline">Google Cloud Console</a></p>
                <p><strong>2.</strong> Create a new project or select an existing one</p>
                <p><strong>3.</strong> Enable the Google Drive API</p>
                <p><strong>4.</strong> Create OAuth 2.0 credentials (Web application)</p>
                <p><strong>5.</strong> Add the redirect URI: <code class="bg-blue-100 px-2 py-1 rounded">{{ route('admin.backup.callback') }}</code></p>
                <p><strong>6.</strong> Copy the Client ID and Client Secret to the form above</p>
                <p><strong>7.</strong> Save settings and authorize Google Drive access</p>
            </div>
        </div>
    </div>

<script>
function testConnection() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = 'Testing...';
    button.disabled = true;
    
    fetch('{{ route("admin.backup.test-connection") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Connection successful! Google Drive is properly configured.');
        } else {
            alert('❌ Connection failed: ' + (data.message || 'Unknown error'));
        }
        button.innerHTML = originalText;
        button.disabled = false;
    })
    .catch(error => {
        alert('❌ Error: ' + error.message);
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script>

</x-layouts.admin>
