<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🔔 Push Notifications</h1>
                <p class="text-gray-600 mt-1">Send push notifications to app users</p>
            </div>
            <button onclick="document.getElementById('sendNotificationModal').classList.remove('hidden')"
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-all shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i>Send Notification
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Sent</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_sent'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Active Devices</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['active_devices'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-mobile-alt text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Delivered</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['delivered'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Failed</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['failed'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications History -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Notification History</h2>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notifications as $notification)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $notification->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ Str::limit($notification->body, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    @if($notification->user_id)
                                        Single User
                                    @else
                                        All Users
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($notification->status === 'sent')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sent
                                    </span>
                                @elseif($notification->status === 'failed')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Failed
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $notification->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-bell-slash text-4xl mb-3"></i>
                                    <p class="text-lg">No notifications sent yet</p>
                                    <p class="text-sm mt-2">Send your first notification to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Send Notification Modal -->
    <div id="sendNotificationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <form action="{{ route('mobileadmin.notifications.send') }}" method="POST">
                @csrf
                
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Send Push Notification</h2>
                        <button type="button" 
                                onclick="document.getElementById('sendNotificationModal').classList.add('hidden')"
                                class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="notification_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Notification Title *
                        </label>
                        <input type="text" 
                               id="notification_title" 
                               name="title" 
                               required
                               maxlength="100"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="notification_body" class="block text-sm font-medium text-gray-700 mb-2">
                            Message *
                        </label>
                        <textarea id="notification_body" 
                                  name="body" 
                                  required
                                  rows="4"
                                  maxlength="500"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>

                    <!-- Target Audience -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Send To *
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="target" 
                                       value="all" 
                                       checked
                                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">All Users</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="target" 
                                       value="android" 
                                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Android Users Only</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="target" 
                                       value="ios" 
                                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">iOS Users Only</span>
                            </label>
                        </div>
                    </div>

                    <!-- Action (Optional) -->
                    <div>
                        <label for="notification_action" class="block text-sm font-medium text-gray-700 mb-2">
                            Action URL (Optional)
                        </label>
                        <input type="text" 
                               id="notification_action" 
                               name="action_url" 
                               placeholder="e.g., /products/123"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <p class="text-xs text-gray-500 mt-1">Deep link or screen to open when notification is tapped</p>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" 
                            onclick="document.getElementById('sendNotificationModal').classList.add('hidden')"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-all shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.mobileadmin>

