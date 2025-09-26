<x-layouts.admin>
    <x-slot name="title">Analytics Dashboard - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">View business analytics and insights</x-slot>
    <x-slot name="pageTitle">📊 Analytics Dashboard</x-slot>

    <!-- Coming Soon Message -->
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 00-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Analytics Dashboard Coming Soon</h3>
            <p class="text-gray-600 mb-6">Advanced analytics and reporting will be available once order and customer data is collected.</p>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-purple-900 mb-2">Planned Analytics:</h4>
                <ul class="text-sm text-purple-800 space-y-1">
                    <li>• Sales performance and revenue tracking</li>
                    <li>• Product popularity and inventory insights</li>
                    <li>• Customer behavior and demographics</li>
                    <li>• SEO performance and traffic analytics</li>
                    <li>• Conversion rates and funnel analysis</li>
                </ul>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-layouts.admin>
