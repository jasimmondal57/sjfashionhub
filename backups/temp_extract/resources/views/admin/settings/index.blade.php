<x-layouts.admin>
    <x-slot name="title">Settings - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Configure system settings and preferences</x-slot>
    <x-slot name="pageTitle">⚙️ System Settings</x-slot>

    <!-- Coming Soon Message -->
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">System Settings Coming Soon</h3>
            <p class="text-gray-600 mb-6">Configuration options and system settings will be available in future updates.</p>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-orange-900 mb-2">Planned Settings:</h4>
                <ul class="text-sm text-orange-800 space-y-1">
                    <li>• Site configuration and branding</li>
                    <li>• Payment gateway settings</li>
                    <li>• Shipping and tax configuration</li>
                    <li>• Email and notification settings</li>
                    <li>• SEO and meta tag management</li>
                </ul>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-layouts.admin>
