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
                <a href="{{ route('admin.backup.settings') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    Settings
                </a>
                @if($isConfigured ?? false)
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    Create Backup
                </button>
                @endif
            </div>
        </div>

        @if(!($isConfigured ?? false))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                <h4 class="font-bold text-lg mb-2">⚠️ Google Drive Not Configured</h4>
                <p class="mb-4">To use the backup system, you need to configure Google Drive integration first.</p>
                <a href="{{ route('admin.backup.settings') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
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
                <div class="text-center py-12">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No backups</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first backup.</p>
                    <div class="mt-6">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Create Backup
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin>
