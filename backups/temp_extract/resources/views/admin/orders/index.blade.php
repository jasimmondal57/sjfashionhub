<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">📦 Order Management</h1>
                        <p class="text-gray-600 mt-1">Manage orders, shipping, and delivery status</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.orders.export', array_merge(request()->query(), ['tab' => $tab])) }}"
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-download mr-2"></i>Export CSV
                        </a>
                    </div>
                </div>
            </div>

            <!-- Horizontal Tabs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        @php
                            $tabs = [
                                'pending' => ['name' => 'Pending', 'icon' => 'clock', 'color' => 'yellow'],
                                'ready_to_ship' => ['name' => 'Ready to Ship', 'icon' => 'box', 'color' => 'purple'],
                                'in_transit' => ['name' => 'In Transit', 'icon' => 'truck', 'color' => 'indigo'],
                                'out_for_delivery' => ['name' => 'Out for Delivery', 'icon' => 'shipping-fast', 'color' => 'orange'],
                                'delivered' => ['name' => 'Delivered', 'icon' => 'check-circle', 'color' => 'green'],
                                'cancelled' => ['name' => 'Cancelled', 'icon' => 'times-circle', 'color' => 'red'],
                                'rto' => ['name' => 'RTO', 'icon' => 'undo', 'color' => 'gray']
                            ];
                        @endphp

                        @foreach($tabs as $tabKey => $tabData)
                            <a href="{{ route('admin.orders.index', ['tab' => $tabKey]) }}"
                               class="flex items-center py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === $tabKey ? 'border-' . $tabData['color'] . '-500 text-' . $tabData['color'] . '-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                <i class="fas fa-{{ $tabData['icon'] }} mr-2"></i>
                                {{ $tabData['name'] }}
                                <span class="ml-2 bg-{{ $tab === $tabKey ? $tabData['color'] . '-100 text-' . $tabData['color'] . '-600' : 'gray-100 text-gray-600' }} rounded-full px-2 py-0.5 text-xs font-medium">
                                    {{ $stats[$tabKey] ?? 0 }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>

                <!-- Search and Filters -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center space-x-4">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search by order number, AWB, customer name or email..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.orders.index', ['tab' => $tab]) }}"
                               class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount & Payment
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Shipping Info
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y g:i A') }}</div>
                                            <div class="text-xs text-gray-400">{{ $order->items->count() }} item(s)</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                            @if($order->user->phone)
                                                <div class="text-xs text-gray-400">{{ $order->user->phone }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->formatted_total }}</div>
                                            <div class="text-sm text-gray-500">{{ ucfirst($order->payment_method) }}</div>
                                            @php
                                                $paymentStatusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                    'refunded' => 'bg-gray-100 text-gray-800'
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $paymentStatusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            @if($order->awb_number)
                                                <div class="text-sm font-medium text-gray-900">{{ $order->awb_number }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->shipping_method }}</div>
                                                @if($order->tracking_url)
                                                    <a href="{{ $order->tracking_url }}" target="_blank"
                                                       class="text-xs text-blue-600 hover:text-blue-800">Track Package</a>
                                                @endif
                                            @elseif($order->manual_tracking_id)
                                                <div class="text-sm font-medium text-gray-900">{{ $order->manual_tracking_id }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->manual_courier_name }}</div>
                                                <span class="text-xs text-purple-600">Manual</span>
                                            @else
                                                <span class="text-sm text-gray-400">Not assigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $order->status_badge['class'] }}">
                                            {{ $order->status_badge['text'] }}
                                        </span>
                                        @if($order->estimated_delivery_date)
                                            <div class="text-xs text-gray-500 mt-1">
                                                ETA: {{ $order->estimated_delivery_date->format('M d') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-xs font-medium">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>

                                            @if($tab === 'pending')
                                                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors text-xs font-medium">
                                                        <i class="fas fa-check mr-1"></i>Confirm
                                                    </button>
                                                </form>
                                                <button onclick="showDeclineModal({{ $order->id }})"
                                                        class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-times mr-1"></i>Decline
                                                </button>
                                            @endif

                                            @if($tab === 'ready_to_ship')
                                                <a href="{{ route('admin.orders.shipping-options', $order) }}"
                                                   class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-shipping-fast mr-1"></i>Ship
                                                </a>
                                            @endif

                                            @if($order->hasShiprocketIntegration())
                                                <form action="{{ route('admin.orders.sync-shiprocket', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors text-xs font-medium">
                                                        <i class="fas fa-sync mr-1"></i>Sync
                                                    </button>
                                                </form>
                                            @endif

                                            <button onclick="showStatusModal({{ $order->id }}, '{{ $order->order_status }}')"
                                                    class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors text-xs font-medium">
                                                <i class="fas fa-edit mr-1"></i>Status
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-box text-4xl mb-4"></i>
                                            <p class="text-lg font-medium">No orders found</p>
                                            <p class="text-sm">No orders in {{ $tabs[$tab]['name'] ?? 'this' }} status.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Decline Order Modal -->
    <div id="declineModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Decline Order</h3>
                <form id="declineForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for cancellation *
                        </label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="3" required
                                  placeholder="Please provide a reason for declining this order..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideDeclineModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Decline Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            New Status *
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="ready_to_ship">Ready to Ship</option>
                            <option value="in_transit">In Transit</option>
                            <option value="out_for_delivery">Out for Delivery</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="rto">RTO</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  placeholder="Add any notes about this status change..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideStatusModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeclineModal(orderId) {
            document.getElementById('declineForm').action = `/admin/orders/${orderId}/decline`;
            document.getElementById('declineModal').classList.remove('hidden');
        }

        function hideDeclineModal() {
            document.getElementById('declineModal').classList.add('hidden');
            document.getElementById('cancellation_reason').value = '';
        }

        function showStatusModal(orderId, currentStatus) {
            document.getElementById('statusForm').action = `/admin/orders/${orderId}/status`;
            document.getElementById('status').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function hideStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('notes').value = '';
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const declineModal = document.getElementById('declineModal');
            const statusModal = document.getElementById('statusModal');

            if (event.target === declineModal) {
                hideDeclineModal();
            }
            if (event.target === statusModal) {
                hideStatusModal();
            }
        }
    </script>
</x-layouts.admin>
