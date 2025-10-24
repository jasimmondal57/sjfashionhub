<x-layouts.admin>
    <x-slot name="title">Backup Test</x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900">💾 Backup Management</h1>
        <p class="text-gray-600 mt-1">This is a test page to verify the backup system is working.</p>
        
        <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-xl font-semibold mb-4">System Status</h2>
            <p>✅ Backup page is loading correctly</p>
            <p>✅ Admin layout is working</p>
            <p>✅ Tailwind CSS is applied</p>
            
            <div class="mt-6">
                <a href="{{ route('admin.backup.settings') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Go to Settings
                </a>
            </div>
        </div>
    </div>
</x-layouts.admin>
