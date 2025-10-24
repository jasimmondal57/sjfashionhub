<x-layouts.admin>
    <x-slot name="title">WhatsApp Marketing</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📱 WhatsApp Marketing</h1>
            <p class="text-gray-600 mt-1">Create templates, manage campaigns, and send marketing messages</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.whatsapp-marketing.otp-setup') }}"
               class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                🔐 OTP Setup
            </a>
            <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Accounts
            </a>
            <a href="{{ route('admin.whatsapp-marketing.templates.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Template
            </a>
            <a href="{{ route('admin.whatsapp-marketing.campaigns.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Campaign
            </a>
        </div>
    </div>

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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Templates Stats -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Templates</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_templates'] }}</p>
                    <p class="text-blue-100 text-xs mt-2">
                        ✅ {{ $stats['approved_templates'] }} Approved | 
                        ⏳ {{ $stats['pending_templates'] }} Pending
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Campaigns Stats -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Campaigns</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_campaigns'] }}</p>
                    <p class="text-green-100 text-xs mt-2">
                        🚀 {{ $stats['active_campaigns'] }} Active
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Messages Sent Stats -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Messages Sent</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_sent']) }}</p>
                    <p class="text-purple-100 text-xs mt-2">
                        📊 All time
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP Setup Card -->
    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-lg shadow-md p-6 border-2 border-orange-200 mb-8">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-orange-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">🔐 WhatsApp OTP Authentication</h2>
                        <p class="text-sm text-gray-600 mt-1">Enable mobile login with WhatsApp OTP verification</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-700 mb-3">
                        <strong>What is OTP Authentication?</strong><br>
                        Allow users to log in to your mobile app using their phone number. They'll receive a one-time password (OTP) via WhatsApp to verify their identity.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-start gap-2">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Secure passwordless login</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Fast WhatsApp delivery</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-green-600 mt-0.5">✓</span>
                            <span class="text-gray-700">Better user experience</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ml-6">
                <a href="{{ route('admin.whatsapp-marketing.otp-setup') }}"
                   class="inline-block bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                    Setup OTP Template →
                </a>
                <p class="text-xs text-gray-600 mt-2 text-center">Takes 5 minutes</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Templates -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">📝 Recent Templates</h2>
                <a href="{{ route('admin.whatsapp-marketing.templates') }}" 
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="p-6">
                @forelse($templates->take(5) as $template)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $template->display_name }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $template->category }} • {{ $template->language }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $template->status_color }}-100 text-{{ $template->status_color }}-800">
                                {{ $template->status_icon }} {{ ucfirst($template->status) }}
                            </span>
                            <a href="{{ route('admin.whatsapp-marketing.templates.show', $template) }}" 
                               class="text-blue-600 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="font-medium">No templates yet</p>
                        <p class="text-sm mt-1">Create your first template to get started</p>
                        <a href="{{ route('admin.whatsapp-marketing.templates.create') }}" 
                           class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            Create Template
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Campaigns -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">🚀 Recent Campaigns</h2>
                <a href="{{ route('admin.whatsapp-marketing.campaigns') }}" 
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="p-6">
                @forelse($campaigns->take(5) as $campaign)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $campaign->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $campaign->sent_count }}/{{ $campaign->total_recipients }} sent
                                @if($campaign->total_recipients > 0)
                                    • {{ $campaign->success_rate }}% success
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $campaign->status_color }}-100 text-{{ $campaign->status_color }}-800">
                                {{ $campaign->status_icon }} {{ ucfirst($campaign->status) }}
                            </span>
                            <a href="{{ route('admin.whatsapp-marketing.campaigns.show', $campaign) }}" 
                               class="text-blue-600 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <p class="font-medium">No campaigns yet</p>
                        <p class="text-sm mt-1">Create your first campaign to start marketing</p>
                        <a href="{{ route('admin.whatsapp-marketing.campaigns.create') }}" 
                           class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            Create Campaign
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Getting Started Guide -->
    @if($stats['total_templates'] == 0)
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg shadow-md p-8 border-2 border-blue-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">🚀 Getting Started with WhatsApp Marketing</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <span class="text-2xl">1️⃣</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Create Template</h3>
                <p class="text-sm text-gray-600 mb-4">Design your message template with variables and buttons</p>
                <a href="{{ route('admin.whatsapp-marketing.templates.create') }}" 
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Create Template →
                </a>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <span class="text-2xl">2️⃣</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Get Approval</h3>
                <p class="text-sm text-gray-600 mb-4">Submit template to WhatsApp for approval (usually 24-48 hours)</p>
                <span class="text-gray-400 text-sm">After creating template</span>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mb-4">
                    <span class="text-2xl">3️⃣</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Launch Campaign</h3>
                <p class="text-sm text-gray-600 mb-4">Select users and send marketing messages at scale</p>
                <span class="text-gray-400 text-sm">After approval</span>
            </div>
        </div>
    </div>
    @endif
</div>
</x-layouts.admin>

