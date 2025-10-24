<x-layouts.admin>
    <x-slot name="pageTitle">WhatsApp Management</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">WhatsApp Management Dashboard</h1>
        <div class="flex gap-2">
            <form action="{{ route('admin.whatsapp.messages.sync') }}" method="POST" class="inline" onsubmit="return confirm('This will attempt to sync messages from logs. Continue?');">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    <i class="fas fa-sync mr-2"></i> Sync Messages
                </button>
            </form>
            <a href="{{ route('admin.whatsapp.messages.index') }}" class="inline-flex items-center px-3 py-2 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-envelope mr-2"></i> All Messages
            </a>
            <a href="{{ route('admin.whatsapp.conversations.index') }}" class="inline-flex items-center px-3 py-2 border border-green-600 text-sm font-medium rounded-md text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-comments mr-2"></i> Conversations
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase mb-1">Messages Today</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['messages_today']) }}</div>
                </div>
                <div>
                    <i class="fas fa-paper-plane text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-600 uppercase mb-1">Delivered Today</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['delivered_today']) }}</div>
                </div>
                <div>
                    <i class="fas fa-check-double text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-cyan-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-cyan-600 uppercase mb-1">Open Conversations</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['open_conversations']) }}</div>
                    @if($stats['unread_messages'] > 0)
                        <small class="text-red-600">{{ $stats['unread_messages'] }} unread</small>
                    @endif
                </div>
                <div>
                    <i class="fas fa-comments text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-yellow-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Pending Orders</div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_orders']) }}</div>
                </div>
                <div>
                    <i class="fas fa-shopping-cart text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Messages by Category -->
        <div>
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-base font-semibold text-gray-900">Messages by Category (Last 7 Days)</h6>
                </div>
                <div class="p-6">
                    @if($messagesByCategory->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $total = $messagesByCategory->sum('count'); @endphp
                                    @foreach($messagesByCategory as $item)
                                        <tr>
                                            <td class="px-3 py-3 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ ['marketing' => 'bg-purple-100 text-purple-800', 'otp' => 'bg-blue-100 text-blue-800', 'notification' => 'bg-green-100 text-green-800', 'support' => 'bg-yellow-100 text-yellow-800', 'order' => 'bg-cyan-100 text-cyan-800'][$item->category] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($item->category ?? 'Other') }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-3 whitespace-nowrap text-right text-sm text-gray-900">{{ number_format($item->count) }}</td>
                                            <td class="px-3 py-3 whitespace-nowrap text-right text-sm text-gray-900">{{ number_format(($item->count / $total) * 100, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No messages in the last 7 days</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div>
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h6 class="text-base font-semibold text-gray-900">Recent Messages</h6>
                    <a href="{{ route('admin.whatsapp.messages.index') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">View All</a>
                </div>
                <div class="p-0">
                    @if($recentMessages->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($recentMessages as $message)
                                <a href="{{ route('admin.whatsapp.messages.show', $message) }}" class="block hover:bg-gray-50 transition-colors duration-150">
                                    <div class="px-6 py-4 flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-1">
                                                <span class="mr-2 text-gray-600">{{ $message->direction === 'outbound' ? '→' : '←' }}</span>
                                                <strong class="text-gray-900">{{ $message->formatted_phone }}</strong>
                                                @if($message->user)
                                                    <small class="text-gray-500 ml-2">{{ $message->user->name }}</small>
                                                @endif
                                            </div>
                                            <p class="mb-1 text-sm text-gray-700 truncate" style="max-width: 300px;">
                                                {{ Str::limit($message->content, 60) }}
                                            </p>
                                            <small class="text-gray-500 text-xs">{{ $message->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="text-right ml-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $message->status_badge }}">{{ $message->status }}</span>
                                            @if($message->category)
                                                <br><span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1 {{ $message->category_badge }}">{{ $message->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No messages yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h6 class="text-base font-semibold text-gray-900">Quick Actions</h6>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.whatsapp.conversations.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-green-600 text-sm font-medium rounded-md text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-comments mr-2"></i> View Conversations
                    </a>
                    <a href="{{ route('admin.whatsapp.orders.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-cyan-600 text-sm font-medium rounded-md text-cyan-600 bg-white hover:bg-cyan-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                        <i class="fas fa-shopping-cart mr-2"></i> WhatsApp Orders
                    </a>
                    <a href="{{ route('admin.whatsapp.catalog.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-yellow-600 text-sm font-medium rounded-md text-yellow-600 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <i class="fas fa-box mr-2"></i> Product Catalog
                    </a>
                    <a href="{{ route('admin.whatsapp-marketing.index') }}" class="inline-flex items-center justify-center px-4 py-3 border border-blue-600 text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-file-alt mr-2"></i> Templates
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="mt-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h6 class="text-base font-semibold text-gray-900">Overall Statistics</h6>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                    <div>
                        <h4 class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_messages']) }}</h4>
                        <p class="text-gray-500 mt-1">Total Messages</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-green-600">{{ number_format($stats['open_conversations']) }}</h4>
                        <p class="text-gray-500 mt-1">Open Conversations</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-yellow-600">{{ number_format($stats['pending_orders']) }}</h4>
                        <p class="text-gray-500 mt-1">Pending Orders</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-cyan-600">{{ number_format($stats['catalog_products']) }}</h4>
                        <p class="text-gray-500 mt-1">Catalog Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>
