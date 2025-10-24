<x-layouts.admin>
    <x-slot name="pageTitle">WhatsApp Messages</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">WhatsApp Messages</h1>
        <div class="flex flex-wrap gap-2">
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700" onclick="document.getElementById('addMessageModal').classList.remove('hidden')">
                <i class="fas fa-plus mr-2"></i> Add Manual Entry
            </button>
            <form action="{{ route('admin.whatsapp.messages.sync') }}" method="POST" class="inline" onsubmit="return confirm('Sync messages from logs?');">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                    <i class="fas fa-sync mr-2"></i> Sync from Logs
                </button>
            </form>
            <a href="{{ route('admin.whatsapp.dashboard') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">Filters</h6>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.whatsapp.messages.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">All Categories</option>
                            <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="otp" {{ request('category') == 'otp' ? 'selected' : '' }}>OTP</option>
                            <option value="notification" {{ request('category') == 'notification' ? 'selected' : '' }}>Notification</option>
                            <option value="support" {{ request('category') == 'support' ? 'selected' : '' }}>Support</option>
                            <option value="commerce" {{ request('category') == 'commerce' ? 'selected' : '' }}>Commerce</option>
                            <option value="order" {{ request('category') == 'order' ? 'selected' : '' }}>Order</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                        <select name="direction" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            <option value="">All</option>
                            <option value="outbound" {{ request('direction') == 'outbound' ? 'selected' : '' }}>Outbound</option>
                            <option value="inbound" {{ request('direction') == 'inbound' ? 'selected' : '' }}>Inbound</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Search phone" value="{{ request('phone') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" value="{{ request('date_from') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.whatsapp.messages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-times mr-2"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">
                Messages ({{ $messages->total() }})
            </h6>
        </div>
        <div class="overflow-x-auto">
            @if($messages->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Dir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone / Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $message->direction === 'outbound' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $message->direction === 'outbound' ? '→' : '←' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $message->formatted_phone }}</div>
                                    @if($message->user)
                                        <div class="text-sm text-gray-500">{{ $message->user->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 truncate" style="max-width: 300px;">
                                        {{ Str::limit($message->content, 80) }}
                                    </div>
                                    @if($message->template_name)
                                        <div class="text-xs text-gray-500">Template: {{ $message->template_name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($message->category)
                                        @php
                                            $categoryColors = [
                                                'marketing' => 'bg-purple-100 text-purple-800',
                                                'otp' => 'bg-blue-100 text-blue-800',
                                                'notification' => 'bg-green-100 text-green-800',
                                                'support' => 'bg-yellow-100 text-yellow-800',
                                                'order' => 'bg-cyan-100 text-cyan-800',
                                                'commerce' => 'bg-indigo-100 text-indigo-800'
                                            ];
                                            $color = $categoryColors[$message->category] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                            {{ ucfirst($message->category) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'sent' => 'bg-blue-100 text-blue-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'read' => 'bg-cyan-100 text-cyan-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                        $statusColor = $statusColors[$message->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                    @if($message->status === 'failed' && $message->error_message)
                                        <div class="text-xs text-red-600 mt-1">{{ Str::limit($message->error_message, 30) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $message->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $message->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.whatsapp.messages.show', $message) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($messages->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $messages->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500">No messages found</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Manual Message Modal -->
<div id="addMessageModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4">
        <form action="{{ route('admin.whatsapp.messages.create-manual') }}" method="POST">
            @csrf
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Add Manual Message Entry</h3>
                <button type="button" onclick="document.getElementById('addMessageModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input type="text" name="phone_number" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="+919876543210" required>
                    <p class="mt-1 text-xs text-gray-500">Include country code (e.g., +91)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message Content *</label>
                    <textarea name="content" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        <option value="notification">Notification</option>
                        <option value="marketing">Marketing</option>
                        <option value="otp">OTP</option>
                        <option value="support">Support</option>
                        <option value="commerce">Commerce</option>
                        <option value="order">Order</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                    <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                        <option value="sent">Sent</option>
                        <option value="delivered">Delivered</option>
                        <option value="read">Read</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sent At (Optional)</label>
                    <input type="datetime-local" name="sent_at" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addMessageModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Add Message
                </button>
            </div>
        </form>
    </div>
</div>
</x-layouts.admin>
