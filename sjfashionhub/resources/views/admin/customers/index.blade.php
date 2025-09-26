<x-layouts.admin>
    <x-slot name="title">Customers Management - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Manage customer accounts and profiles</x-slot>
    <x-slot name="pageTitle">👥 Customers Management</x-slot>

    <!-- Coming Soon Message -->
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Management Coming Soon</h3>
            <p class="text-gray-600 mb-6">This feature will be available once user authentication and registration is implemented.</p>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-green-900 mb-2">Planned Features:</h4>
                <ul class="text-sm text-green-800 space-y-1">
                    <li>• Customer registration and profiles</li>
                    <li>• Order history and tracking</li>
                    <li>• Wishlist management</li>
                    <li>• Customer support tickets</li>
                    <li>• Loyalty programs and rewards</li>
                </ul>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-layouts.admin>
