<x-layouts.admin>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Message Details</h1>
                <p class="text-gray-600 mt-1">View WhatsApp message information</p>
            </div>
            <a href="{{ route('admin.whatsapp.messages.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ← Back to Messages
            </a>
        </div>

        <!-- Message Card -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Message Header -->
            <div class="border-b pb-4 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            {{ ucfirst($message->direction) }} Message
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $message->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($message->status === 'sent') bg-blue-100 text-blue-800
                            @elseif($message->status === 'delivered') bg-green-100 text-green-800
                            @elseif($message->status === 'read') bg-purple-100 text-purple-800
                            @elseif($message->status === 'failed') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($message->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Message Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <p class="text-gray-900">{{ $message->phone_number }}</p>
                </div>

                <!-- User -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                    <p class="text-gray-900">
                        @if($message->user)
                            <a href="{{ route('admin.users.show', $message->user) }}" class="text-blue-600 hover:underline">
                                {{ $message->user->name }}
                            </a>
                        @else
                            <span class="text-gray-500">Not registered</span>
                        @endif
                    </p>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <p class="text-gray-900">{{ ucfirst($message->category) }}</p>
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message Type</label>
                    <p class="text-gray-900">{{ ucfirst($message->type) }}</p>
                </div>

                <!-- Direction -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Direction</label>
                    <p class="text-gray-900">
                        @if($message->direction === 'outbound')
                            <span class="text-blue-600">↗ Outbound (Sent)</span>
                        @else
                            <span class="text-green-600">↙ Inbound (Received)</span>
                        @endif
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Status</label>
                    <p class="text-gray-900">{{ ucfirst($message->status) }}</p>
                </div>
            </div>

            <!-- Message Content -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Message Content</label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $message->content }}</p>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sent At</label>
                    <p class="text-gray-900">
                        {{ $message->sent_at ? $message->sent_at->format('M d, Y h:i A') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Delivered At</label>
                    <p class="text-gray-900">
                        {{ $message->delivered_at ? $message->delivered_at->format('M d, Y h:i A') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Read At</label>
                    <p class="text-gray-900">
                        {{ $message->read_at ? $message->read_at->format('M d, Y h:i A') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Related Order -->
            @if($message->order)
            <div class="border-t pt-4 mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Related Order</label>
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">Order #{{ $message->order->order_number }}</p>
                            <p class="text-sm text-gray-600">Total: ₹{{ number_format($message->order->total_amount, 2) }}</p>
                        </div>
                        <a href="{{ route('admin.orders.show', $message->order) }}" class="text-blue-600 hover:underline text-sm">
                            View Order →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Related Return Order -->
            @if($message->returnOrder)
            <div class="border-t pt-4 mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Related Return</label>
                <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">Return #{{ $message->returnOrder->return_number }}</p>
                            <p class="text-sm text-gray-600">Status: {{ ucfirst($message->returnOrder->status) }}</p>
                        </div>
                        <a href="{{ route('admin.returns.show', $message->returnOrder) }}" class="text-orange-600 hover:underline text-sm">
                            View Return →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Conversation -->
            @if($message->conversation)
            <div class="border-t pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Conversation</label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">{{ $message->conversation->customer_name ?? $message->phone_number }}</p>
                            <p class="text-sm text-gray-600">
                                Status: {{ ucfirst($message->conversation->status) }}
                                @if($message->conversation->unread_count > 0)
                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                        {{ $message->conversation->unread_count }} unread
                                    </span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('admin.whatsapp.conversations.show', $message->conversation) }}" class="text-blue-600 hover:underline text-sm">
                            View Conversation →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Message -->
            @if($message->error_message)
            <div class="border-t pt-4 mt-4">
                <label class="block text-sm font-medium text-red-700 mb-2">Error Message</label>
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <p class="text-red-900">{{ $message->error_message }}</p>
                </div>
            </div>
            @endif

            <!-- Meta Data -->
            @if($message->meta_data)
            <div class="border-t pt-4 mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Data</label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <pre class="text-xs text-gray-700 overflow-x-auto">{{ json_encode($message->meta_data, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-6 flex gap-4">
            <a href="{{ route('admin.whatsapp.messages.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                ← Back to Messages
            </a>
            
            @if($message->conversation)
            <a href="{{ route('admin.whatsapp.conversations.show', $message->conversation) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                View Full Conversation
            </a>
            @endif
        </div>
    </div>
</x-layouts.admin>

