<x-layouts.admin>
    <x-slot name="title">Backup Management</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">💾 Backup Management</h1>
                <p class="text-gray-600 mt-1">Manage your site backups and Google Drive integration</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.backup.settings') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-gray-700">
                    ⚙️ Settings
                </a>
                @if($isConfigured ?? false)
                <button id="createBackupBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-blue-500">
                    ➕ Create Backup
                </button>
                @endif
            </div>
        </div>

        @if(!($isConfigured ?? false))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                <h4 class="font-bold text-lg mb-2">⚠️ Google Drive Not Configured</h4>
                <p class="mb-4">To use the backup system, you need to configure Google Drive integration first.</p>
                <a href="{{ route('admin.backup.settings') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center font-medium">
                    Configure Google Drive
                </a>
            </div>
        @else
            <!-- Backup Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Backups</p>
                            <p class="text-3xl font-bold text-gray-900">{{ count($backups ?? []) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Last Backup</p>
                            <p class="text-lg font-bold text-gray-900">Never</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Size</p>
                            <p class="text-lg font-bold text-gray-900">0 MB</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Status</p>
                            <p class="text-lg font-bold text-green-600">Ready</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup List -->
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Backups</h3>
                </div>

                @if(count($backups ?? []) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($backups as $backup)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $backup['name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $backup['size_formatted'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $backup['created_at_human'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.backup.download', $backup['name']) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                            ⬇️ Download
                                        </a>
                                        <button onclick="deleteBackup('{{ $backup['name'] }}')" class="text-red-600 hover:text-red-900">
                                            🗑️ Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No backups</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first backup.</p>
                        <div class="mt-6">
                            <button id="createBackupBtn2" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg border border-blue-500">
                                ➕ Create Backup
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <script>
        // Create backup functionality
        document.getElementById('createBackupBtn')?.addEventListener('click', createBackup);
        document.getElementById('createBackupBtn2')?.addEventListener('click', createBackup);

        function createBackup() {
            if (!confirm('Create a new backup? This may take a few moments.')) {
                return;
            }

            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '⏳ Creating...';

            fetch('{{ route('admin.backup.create') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    description: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                alert('❌ Error creating backup: ' + error.message);
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        function deleteBackup(filename) {
            if (!confirm('Are you sure you want to delete this backup?')) {
                return;
            }

            fetch('/admin/backup/delete/' + filename, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Error deleting backup: ' + error.message);
            });
        }
    </script>
</x-layouts.admin>
