<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🔄 Return Order Management</h1>
                        <p class="text-gray-600 mt-1">Manage return requests, refunds, and quality checks</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.return-orders.export', array_merge(request()->query(), ['tab' => $tab])) }}" 
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
                                'ready_to_return' => ['name' => 'Ready to Return', 'icon' => 'box-open', 'color' => 'purple'],
                                'in_transit' => ['name' => 'In Transit', 'icon' => 'truck', 'color' => 'indigo'],
                                'pending_refund' => ['name' => 'Pending Refund', 'icon' => 'money-bill-wave', 'color' => 'orange'],
                                'completed' => ['name' => 'Completed', 'icon' => 'check-circle', 'color' => 'green'],
                                'rejected' => ['name' => 'Rejected', 'icon' => 'times-circle', 'color' => 'red']
                            ];
                        @endphp

                        @foreach($tabs as $tabKey => $tabData)
                            <a href="{{ route('admin.return-orders.index', ['tab' => $tabKey]) }}" 
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
                    <form method="GET" action="{{ route('admin.return-orders.index') }}" class="flex items-center space-x-4">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by return number, order number, AWB, customer name or email..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.return-orders.index', ['tab' => $tab]) }}" 
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

            <!-- Return Orders Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Return Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Products
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer & Order
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Return Info
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tracking
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
                            @forelse($returnOrders as $returnOrder)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $returnOrder->return_number }}</div>
                                            <div class="text-sm text-gray-500">{{ $returnOrder->created_at->format('M d, Y g:i A') }}</div>
                                            <div class="text-xs text-gray-400">{{ $returnOrder->days_from_creation }} days ago</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            @php
                                                $firstItem = $returnOrder->return_items[0] ?? null;
                                                $itemCount = count($returnOrder->return_items);

                                                // Try to get image from return_items first, then fallback to order_item's product
                                                $productImage = null;
                                                $variantSize = null;

                                                if ($firstItem) {
                                                    // Check if image is in return_items
                                                    if (isset($firstItem['main_image'])) {
                                                        $productImage = $firstItem['main_image'];
                                                    } elseif (isset($firstItem['image'])) {
                                                        $productImage = asset('storage/' . $firstItem['image']);
                                                    } else {
                                                        // Fallback: get from order_item's product
                                                        $orderItem = $returnOrder->order->items()->find($firstItem['order_item_id']);
                                                        if ($orderItem && $orderItem->product) {
                                                            $productImage = $orderItem->product->main_image;
                                                        }
                                                    }

                                                    // Check for variant details
                                                    if (isset($firstItem['variant_details']['size'])) {
                                                        $variantSize = $firstItem['variant_details']['size'];
                                                    } else {
                                                        // Fallback: get from order_item
                                                        $orderItem = $orderItem ?? $returnOrder->order->items()->find($firstItem['order_item_id']);
                                                        if ($orderItem) {
                                                            if ($orderItem->productVariant) {
                                                                $variantSize = $orderItem->productVariant->option1_value;
                                                            } elseif ($orderItem->variant_details && isset($orderItem->variant_details['size'])) {
                                                                $variantSize = $orderItem->variant_details['size'];
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if($firstItem)
                                                @if($productImage)
                                                    <img src="{{ $productImage }}"
                                                         alt="{{ $firstItem['product_name'] }}"
                                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400 text-xs"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $firstItem['product_name'] }}</div>
                                                    @if($variantSize)
                                                        <div class="text-xs text-blue-600">Size: {{ $variantSize }}</div>
                                                    @endif
                                                    @if($itemCount > 1)
                                                        <div class="text-xs text-gray-500">+{{ $itemCount - 1 }} more item(s)</div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-400">No items</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $returnOrder->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $returnOrder->user->email }}</div>
                                            <div class="text-xs text-blue-600">Order: {{ $returnOrder->order->order_number }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $returnOrder->formatted_return_amount }}</div>
                                            <div class="text-sm text-gray-500">{{ $returnOrder->return_type_display }}</div>
                                            @if($returnOrder->refund_amount && $returnOrder->refund_amount != $returnOrder->return_amount)
                                                <div class="text-xs text-orange-600">Refund: {{ $returnOrder->formatted_refund_amount }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            @if($returnOrder->return_awb_number)
                                                <div class="text-sm font-medium text-gray-900">{{ $returnOrder->return_awb_number }}</div>
                                                <div class="text-sm text-gray-500">{{ $returnOrder->return_shipping_method }}</div>
                                                @if($returnOrder->return_tracking_url)
                                                    <a href="{{ $returnOrder->return_tracking_url }}" target="_blank" 
                                                       class="text-xs text-blue-600 hover:text-blue-800">Track Return</a>
                                                @endif
                                            @elseif($returnOrder->manual_return_tracking_id)
                                                <div class="text-sm font-medium text-gray-900">{{ $returnOrder->manual_return_tracking_id }}</div>
                                                <div class="text-sm text-gray-500">{{ $returnOrder->manual_return_courier_name }}</div>
                                                <span class="text-xs text-purple-600">Manual</span>
                                            @else
                                                <span class="text-sm text-gray-400">Not assigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $returnOrder->status_badge['class'] }}">
                                            {{ $returnOrder->status_badge['text'] }}
                                        </span>
                                        @if($returnOrder->quality_check_status)
                                            <div class="text-xs text-gray-500 mt-1">
                                                QC: {{ ucfirst($returnOrder->quality_check_status) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.return-orders.show', $returnOrder) }}" 
                                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-xs font-medium">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>

                                            @if($tab === 'pending')
                                                <button onclick="showApproveModal({{ $returnOrder->id }})" 
                                                        class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-check mr-1"></i>Approve
                                                </button>
                                                <button onclick="showRejectModal({{ $returnOrder->id }})" 
                                                        class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-times mr-1"></i>Reject
                                                </button>
                                            @endif

                                            @if($tab === 'ready_to_return')
                                                <a href="{{ route('admin.return-orders.return-options', $returnOrder) }}" 
                                                   class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-undo mr-1"></i>Initiate
                                                </a>
                                            @endif

                                            @if($tab === 'in_transit')
                                                <button onclick="showReceivedModal({{ $returnOrder->id }})" 
                                                        class="inline-flex items-center px-2 py-1 bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-inbox mr-1"></i>Received
                                                </button>
                                            @endif

                                            @if($tab === 'pending_refund')
                                                <button onclick="showQualityCheckModal({{ $returnOrder->id }})" 
                                                        class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 transition-colors text-xs font-medium">
                                                    <i class="fas fa-search mr-1"></i>QC
                                                </button>
                                                @if($returnOrder->quality_check_status === 'passed')
                                                    <button onclick="showRefundModal({{ $returnOrder->id }})" 
                                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors text-xs font-medium">
                                                        <i class="fas fa-money-bill mr-1"></i>Refund
                                                    </button>
                                                @endif
                                            @endif

                                            @if($returnOrder->hasShiprocketIntegration())
                                                <form action="{{ route('admin.return-orders.sync-shiprocket', $returnOrder) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition-colors text-xs font-medium">
                                                        <i class="fas fa-sync mr-1"></i>Sync
                                                    </button>
                                                </form>
                                            @endif

                                            <button onclick="showStatusModal({{ $returnOrder->id }}, '{{ $returnOrder->status }}')" 
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
                                            <i class="fas fa-undo text-4xl mb-4"></i>
                                            <p class="text-lg font-medium">No return orders found</p>
                                            <p class="text-sm">No return orders in {{ $tabs[$tab]['name'] ?? 'this' }} status.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($returnOrders->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $returnOrders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Approve Return Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Return Request</h3>
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Notes (Optional)
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="3"
                                  placeholder="Add any notes about this approval..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideApproveModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Approve Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Return Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Return Request</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for rejection *
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3" required
                                  placeholder="Please provide a reason for rejecting this return request..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideRejectModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Reject Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mark Received Modal -->
    <div id="receivedModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Mark Return as Received</h3>
                <form id="receivedForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="quality_check_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Initial Quality Check Notes (Optional)
                        </label>
                        <textarea name="quality_check_notes" id="quality_check_notes" rows="3"
                                  placeholder="Add any initial observations about the returned items..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideReceivedModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Mark Received
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quality Check Modal -->
    <div id="qualityCheckModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Quality Check</h3>
                <form id="qualityCheckForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="quality_check_status" class="block text-sm font-medium text-gray-700 mb-2">
                                Quality Check Result *
                            </label>
                            <select name="quality_check_status" id="quality_check_status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Result</option>
                                <option value="passed">Passed - Items in good condition</option>
                                <option value="failed">Failed - Items damaged/not returnable</option>
                            </select>
                        </div>
                        <div>
                            <label for="deduction_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Deduction Amount (₹)
                            </label>
                            <input type="number" name="deduction_amount" id="deduction_amount" step="0.01" min="0"
                                   placeholder="0.00"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="quality_check_notes_detailed" class="block text-sm font-medium text-gray-700 mb-2">
                            Quality Check Notes *
                        </label>
                        <textarea name="quality_check_notes" id="quality_check_notes_detailed" rows="4" required
                                  placeholder="Provide detailed notes about the quality check results..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="mb-4" id="deductionReasonDiv" style="display: none;">
                        <label for="deduction_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Deduction Reason
                        </label>
                        <textarea name="deduction_reason" id="deduction_reason" rows="2"
                                  placeholder="Explain why deduction is being applied..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideQualityCheckModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Complete Quality Check
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Process Refund Modal -->
    <div id="refundModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Process Refund</h3>
                <form id="refundForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="refund_method" class="block text-sm font-medium text-gray-700 mb-2">
                            Refund Method *
                        </label>
                        <select name="refund_method" id="refund_method" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Method</option>
                            <option value="original_payment">Original Payment Method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="store_credit">Store Credit</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="refund_transaction_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Transaction ID (Optional)
                        </label>
                        <input type="text" name="refund_transaction_id" id="refund_transaction_id"
                               placeholder="Enter transaction/reference ID"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="mb-4">
                        <label for="refund_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Refund Notes (Optional)
                        </label>
                        <textarea name="refund_notes" id="refund_notes" rows="3"
                                  placeholder="Add any notes about the refund process..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideRefundModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Process Refund
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
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Return Status</h3>
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
                            <option value="approved">Approved</option>
                            <option value="ready_to_return">Ready to Return</option>
                            <option value="in_transit">In Transit</option>
                            <option value="pending_refund">Pending Refund</option>
                            <option value="completed">Completed</option>
                            <option value="rejected">Rejected</option>
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
        // Modal functions
        function showApproveModal(returnOrderId) {
            document.getElementById('approveForm').action = `/admin/return-orders/${returnOrderId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function hideApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
            document.getElementById('admin_notes').value = '';
        }

        function showRejectModal(returnOrderId) {
            document.getElementById('rejectForm').action = `/admin/return-orders/${returnOrderId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        function showReceivedModal(returnOrderId) {
            document.getElementById('receivedForm').action = `/admin/return-orders/${returnOrderId}/received`;
            document.getElementById('receivedModal').classList.remove('hidden');
        }

        function hideReceivedModal() {
            document.getElementById('receivedModal').classList.add('hidden');
            document.getElementById('quality_check_notes').value = '';
        }

        function showQualityCheckModal(returnOrderId) {
            document.getElementById('qualityCheckForm').action = `/admin/return-orders/${returnOrderId}/quality-check`;
            document.getElementById('qualityCheckModal').classList.remove('hidden');
        }

        function hideQualityCheckModal() {
            document.getElementById('qualityCheckModal').classList.add('hidden');
            document.getElementById('quality_check_status').value = '';
            document.getElementById('quality_check_notes_detailed').value = '';
            document.getElementById('deduction_amount').value = '';
            document.getElementById('deduction_reason').value = '';
            document.getElementById('deductionReasonDiv').style.display = 'none';
        }

        function showRefundModal(returnOrderId) {
            document.getElementById('refundForm').action = `/admin/return-orders/${returnOrderId}/refund`;
            document.getElementById('refundModal').classList.remove('hidden');
        }

        function hideRefundModal() {
            document.getElementById('refundModal').classList.add('hidden');
            document.getElementById('refund_method').value = '';
            document.getElementById('refund_transaction_id').value = '';
            document.getElementById('refund_notes').value = '';
        }

        function showStatusModal(returnOrderId, currentStatus) {
            document.getElementById('statusForm').action = `/admin/return-orders/${returnOrderId}/status`;
            document.getElementById('status').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function hideStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('notes').value = '';
        }

        // Show/hide deduction reason field
        document.getElementById('deduction_amount').addEventListener('input', function() {
            const deductionDiv = document.getElementById('deductionReasonDiv');
            if (this.value && parseFloat(this.value) > 0) {
                deductionDiv.style.display = 'block';
            } else {
                deductionDiv.style.display = 'none';
            }
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['approveModal', 'rejectModal', 'receivedModal', 'qualityCheckModal', 'refundModal', 'statusModal'];

            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    </script>
</x-layouts.admin>
