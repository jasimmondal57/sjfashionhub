<x-layouts.admin>
    <x-slot name="title">Communication Dashboard</x-slot>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Communication Dashboard</h1>
            <p class="text-gray-600 mt-1">Manage email, SMS, and WhatsApp communications</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.communication.logs') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                View Logs
            </a>
            <a href="{{ route('admin.communication-templates.index') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Templates
            </a>
            <button onclick="openTestModal()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Send Test
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Sent</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Delivered</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['delivered']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Failed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['failed']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Cost</p>
                    <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['total_cost'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Provider Configuration Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Email Configuration -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">📧 Email (SMTP)</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ isset($providers['email']['active_service']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ isset($providers['email']['active_service']) ? 'Configured' : 'Not Configured' }}
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Configure SMTP settings for email notifications</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Emails Sent:</span>
                    <span class="font-medium">{{ number_format($stats['email_count']) }}</span>
                </div>
                @if(isset($providers['email']['from_address']))
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">From Address:</span>
                    <span class="font-medium">{{ $providers['email']['from_address'] }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('admin.communication.email-settings') }}" 
               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center block">
                Configure Email
            </a>
        </div>

        <!-- SMS Configuration -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">📱 SMS</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ isset($providers['sms']['active_service']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ isset($providers['sms']['active_service']) ? 'Configured' : 'Not Configured' }}
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Configure SMS providers like Twilio, MSG91</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">SMS Sent:</span>
                    <span class="font-medium">{{ number_format($stats['sms_count']) }}</span>
                </div>
                @if(isset($providers['sms']['sender_id']))
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Sender ID:</span>
                    <span class="font-medium">{{ $providers['sms']['sender_id'] }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('admin.communication.sms-settings') }}"
               class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-center block font-medium"
               style="background-color: #059669 !important; color: white !important; text-decoration: none !important;">
                Configure SMS
            </a>
        </div>

        <!-- WhatsApp Configuration -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">💬 WhatsApp</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ isset($providers['whatsapp']['active_service']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ isset($providers['whatsapp']['active_service']) ? 'Configured' : 'Not Configured' }}
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">Configure WhatsApp Business API</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Messages Sent:</span>
                    <span class="font-medium">{{ number_format($stats['whatsapp_count']) }}</span>
                </div>
                @if(isset($providers['whatsapp']['phone_number']))
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Phone Number:</span>
                    <span class="font-medium">{{ $providers['whatsapp']['phone_number'] }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('admin.communication.whatsapp-settings') }}"
               class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors text-center block font-medium"
               style="background-color: #9333ea !important; color: white !important; text-decoration: none !important;">
                Configure WhatsApp
            </a>
        </div>
    </div>

    <!-- Notification Preferences -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">📢 Notification Preferences</h3>
            <p class="text-gray-600 text-sm mt-1">Configure which notification methods to use for different events</p>
        </div>
        <div class="p-6">
            <form id="notification-preferences-form" action="{{ route('admin.communication.update-preferences') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Email Notifications -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <h4 class="text-md font-medium text-gray-900">Email Notifications</h4>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="email_welcome" value="1"
                                       {{ old('email_welcome', $preferences['email_welcome'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Welcome Message</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_placed" value="1"
                                       {{ old('email_order_placed', $preferences['email_order_placed'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Placed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_confirmed" value="1"
                                       {{ old('email_order_confirmed', $preferences['email_order_confirmed'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Confirmed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_ready_to_ship" value="1"
                                       {{ old('email_ready_to_ship', $preferences['email_ready_to_ship'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Ready to Ship</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_shipped" value="1"
                                       {{ old('email_order_shipped', $preferences['email_order_shipped'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Shipped (In Transit)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_out_for_delivery" value="1"
                                       {{ old('email_out_for_delivery', $preferences['email_out_for_delivery'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Out for Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_delivered" value="1"
                                       {{ old('email_order_delivered', $preferences['email_order_delivered'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Delivered</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_cancelled" value="1"
                                       {{ old('email_order_cancelled', $preferences['email_order_cancelled'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Cancelled</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_order_rto" value="1"
                                       {{ old('email_order_rto', $preferences['email_order_rto'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order RTO</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_request" value="1"
                                       {{ old('email_return_request', $preferences['email_return_request'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Request Submitted</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_approved" value="1"
                                       {{ old('email_return_approved', $preferences['email_return_approved'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Approved</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_rejected" value="1"
                                       {{ old('email_return_rejected', $preferences['email_return_rejected'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Rejected</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_in_transit" value="1"
                                       {{ old('email_return_in_transit', $preferences['email_return_in_transit'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return In Transit</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_received" value="1"
                                       {{ old('email_return_received', $preferences['email_return_received'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Received</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_return_refund_processed" value="1"
                                       {{ old('email_return_refund_processed', $preferences['email_return_refund_processed'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Refund Processed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_admin_alerts" value="1"
                                       {{ old('email_admin_alerts', $preferences['email_admin_alerts'] ?? '1') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Admin Alerts</span>
                            </label>
                        </div>
                    </div>

                    <!-- SMS Notifications -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h4 class="text-md font-medium text-gray-900">SMS Notifications</h4>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_welcome" value="1"
                                       {{ old('sms_welcome', $preferences['sms_welcome'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Welcome Message</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_placed" value="1"
                                       {{ old('sms_order_placed', $preferences['sms_order_placed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Placed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_confirmed" value="1"
                                       {{ old('sms_order_confirmed', $preferences['sms_order_confirmed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Confirmed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_ready_to_ship" value="1"
                                       {{ old('sms_ready_to_ship', $preferences['sms_ready_to_ship'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Ready to Ship</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_shipped" value="1"
                                       {{ old('sms_order_shipped', $preferences['sms_order_shipped'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Shipped (In Transit)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_out_for_delivery" value="1"
                                       {{ old('sms_out_for_delivery', $preferences['sms_out_for_delivery'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Out for Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_delivered" value="1"
                                       {{ old('sms_order_delivered', $preferences['sms_order_delivered'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Delivered</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_cancelled" value="1"
                                       {{ old('sms_order_cancelled', $preferences['sms_order_cancelled'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Cancelled</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_order_rto" value="1"
                                       {{ old('sms_order_rto', $preferences['sms_order_rto'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order RTO</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_request" value="1"
                                       {{ old('sms_return_request', $preferences['sms_return_request'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Request Submitted</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_approved" value="1"
                                       {{ old('sms_return_approved', $preferences['sms_return_approved'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Approved</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_rejected" value="1"
                                       {{ old('sms_return_rejected', $preferences['sms_return_rejected'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Rejected</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_in_transit" value="1"
                                       {{ old('sms_return_in_transit', $preferences['sms_return_in_transit'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return In Transit</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_received" value="1"
                                       {{ old('sms_return_received', $preferences['sms_return_received'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Received</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="sms_return_refund_processed" value="1"
                                       {{ old('sms_return_refund_processed', $preferences['sms_return_refund_processed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Refund Processed</span>
                            </label>
                        </div>
                    </div>

                    <!-- WhatsApp Notifications -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h4 class="text-md font-medium text-gray-900">WhatsApp Notifications</h4>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_welcome" value="1"
                                       {{ old('whatsapp_welcome', $preferences['whatsapp_welcome'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Welcome Message</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_placed" value="1"
                                       {{ old('whatsapp_order_placed', $preferences['whatsapp_order_placed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Placed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_confirmed" value="1"
                                       {{ old('whatsapp_order_confirmed', $preferences['whatsapp_order_confirmed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Confirmed</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_ready_to_ship" value="1"
                                       {{ old('whatsapp_ready_to_ship', $preferences['whatsapp_ready_to_ship'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Ready to Ship</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_shipped" value="1"
                                       {{ old('whatsapp_order_shipped', $preferences['whatsapp_order_shipped'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Shipped (In Transit)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_out_for_delivery" value="1"
                                       {{ old('whatsapp_out_for_delivery', $preferences['whatsapp_out_for_delivery'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Out for Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_delivered" value="1"
                                       {{ old('whatsapp_order_delivered', $preferences['whatsapp_order_delivered'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Delivered</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_cancelled" value="1"
                                       {{ old('whatsapp_order_cancelled', $preferences['whatsapp_order_cancelled'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order Cancelled</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_order_rto" value="1"
                                       {{ old('whatsapp_order_rto', $preferences['whatsapp_order_rto'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Order RTO</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_request" value="1"
                                       {{ old('whatsapp_return_request', $preferences['whatsapp_return_request'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Request Submitted</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_approved" value="1"
                                       {{ old('whatsapp_return_approved', $preferences['whatsapp_return_approved'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Approved</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_rejected" value="1"
                                       {{ old('whatsapp_return_rejected', $preferences['whatsapp_return_rejected'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Rejected</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_in_transit" value="1"
                                       {{ old('whatsapp_return_in_transit', $preferences['whatsapp_return_in_transit'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return In Transit</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_received" value="1"
                                       {{ old('whatsapp_return_received', $preferences['whatsapp_return_received'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Received</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="whatsapp_return_refund_processed" value="1"
                                       {{ old('whatsapp_return_refund_processed', $preferences['whatsapp_return_refund_processed'] ?? '0') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Return Refund Processed</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors font-medium">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Communications -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Communications</h3>
                <a href="{{ route('admin.communication.logs') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View All →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject/Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentLogs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $log->type === 'email' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->type === 'sms' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $log->type === 'whatsapp' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($log->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $log->recipient }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate">
                                {{ $log->subject ?: Str::limit($log->content, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $log->status === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $log->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $log->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $log->sent_at ? $log->sent_at->format('M d, Y H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No communications found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Test Message Modal -->
<div id="testModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Send Test Message</h3>
            </div>
            <form id="testForm" class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" id="testType" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <option value="">Select Type</option>
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recipient</label>
                    <input type="text" name="recipient" class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                           placeholder="Email address or phone number" required>
                </div>
                <div class="mb-4" id="subjectField" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <input type="text" name="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                           placeholder="Email subject">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea name="content" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                              placeholder="Test message content" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeTestModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Send Test
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTestModal() {
    document.getElementById('testModal').classList.remove('hidden');
}

function closeTestModal() {
    document.getElementById('testModal').classList.add('hidden');
    document.getElementById('testForm').reset();
}

document.getElementById('testType').addEventListener('change', function() {
    const subjectField = document.getElementById('subjectField');
    if (this.value === 'email') {
        subjectField.style.display = 'block';
        subjectField.querySelector('input').required = true;
    } else {
        subjectField.style.display = 'none';
        subjectField.querySelector('input').required = false;
    }
});

document.getElementById('testForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.communication.send-test") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Test message sent successfully!');
            closeTestModal();
        } else {
            alert('Failed to send test message: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error sending test message');
        console.error('Error:', error);
    });
});
</script>
</x-layouts.admin>
