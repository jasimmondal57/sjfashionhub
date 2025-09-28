<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🔄 Return Order Details</h1>
                        <p class="text-gray-600 mt-1">Return #{{ $returnOrder->return_number }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $returnOrder->status_badge['class'] }}">
                            {{ $returnOrder->status_badge['text'] }}
                        </span>
                        <a href="{{ route('admin.return-orders.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Returns
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Return Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Return Items -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Return Items</h3>
                        <div class="space-y-4">
                            @foreach($returnOrder->return_items as $item)
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    @if(isset($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $item['product_name'] }}</h4>
                                        <p class="text-sm text-gray-600">SKU: {{ $item['sku'] ?? 'N/A' }}</p>
                                        @if(isset($item['variant_details']))
                                            <p class="text-sm text-gray-600">
                                                Variant: {{ collect($item['variant_details'])->map(fn($value, $key) => "$key: $value")->join(', ') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">₹{{ number_format($item['unit_price'], 2) }}</p>
                                        <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                        <p class="text-sm font-medium text-gray-900">₹{{ number_format($item['total_price'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Return Timeline -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Return Timeline</h3>
                        <div class="space-y-4">
                            @php
                                $timeline = [];
                                if ($returnOrder->created_at) $timeline[] = ['date' => $returnOrder->created_at, 'status' => 'Return Requested', 'icon' => 'plus-circle', 'color' => 'blue'];
                                if ($returnOrder->approved_at) $timeline[] = ['date' => $returnOrder->approved_at, 'status' => 'Return Approved', 'icon' => 'check-circle', 'color' => 'green'];
                                if ($returnOrder->rejected_at) $timeline[] = ['date' => $returnOrder->rejected_at, 'status' => 'Return Rejected', 'icon' => 'times-circle', 'color' => 'red'];
                                if ($returnOrder->ready_to_return_at) $timeline[] = ['date' => $returnOrder->ready_to_return_at, 'status' => 'Ready to Return', 'icon' => 'box-open', 'color' => 'purple'];
                                if ($returnOrder->in_transit_at) $timeline[] = ['date' => $returnOrder->in_transit_at, 'status' => 'Return In Transit', 'icon' => 'truck', 'color' => 'indigo'];
                                if ($returnOrder->received_at) $timeline[] = ['date' => $returnOrder->received_at, 'status' => 'Return Received', 'icon' => 'inbox', 'color' => 'orange'];
                                if ($returnOrder->quality_checked_at) $timeline[] = ['date' => $returnOrder->quality_checked_at, 'status' => 'Quality Check Completed', 'icon' => 'search', 'color' => 'yellow'];
                                if ($returnOrder->refund_processed_at) $timeline[] = ['date' => $returnOrder->refund_processed_at, 'status' => 'Refund Processed', 'icon' => 'money-bill-wave', 'color' => 'green'];
                                if ($returnOrder->completed_at) $timeline[] = ['date' => $returnOrder->completed_at, 'status' => 'Return Completed', 'icon' => 'check-circle', 'color' => 'green'];
                                
                                $timeline = collect($timeline)->sortBy('date');
                            @endphp

                            @foreach($timeline as $event)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-{{ $event['color'] }}-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $event['icon'] }} text-{{ $event['color'] }}-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $event['status'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $event['date']->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Return Images -->
                    @if($returnOrder->return_images && count($returnOrder->return_images) > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Return Images</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($returnOrder->return_images as $image)
                                    <div class="aspect-square">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             alt="Return Image" 
                                             class="w-full h-full object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Return Tracking Information -->
                    @if($returnOrder->return_awb_number || $returnOrder->manual_return_tracking_id)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Return Tracking Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Tracking Number</p>
                                    <p class="text-sm text-gray-900">{{ $returnOrder->return_awb_number ?? $returnOrder->manual_return_tracking_id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Courier Company</p>
                                    <p class="text-sm text-gray-900">{{ $returnOrder->return_shipping_method }}</p>
                                </div>
                                @if($returnOrder->return_shipping_charges)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Return Shipping Charges</p>
                                        <p class="text-sm text-gray-900">₹{{ number_format($returnOrder->return_shipping_charges, 2) }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->pickup_scheduled_at)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Pickup Scheduled</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->pickup_scheduled_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                            @if($returnOrder->return_tracking_url)
                                <div class="mt-4">
                                    <a href="{{ $returnOrder->return_tracking_url }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i>Track Return
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Quality Check Information -->
                    @if($returnOrder->quality_check_status)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quality Check Results</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Status:</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $returnOrder->quality_check_status === 'passed' ? 'bg-green-100 text-green-800' : ($returnOrder->quality_check_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($returnOrder->quality_check_status) }}
                                    </span>
                                </div>
                                @if($returnOrder->quality_check_notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Notes:</p>
                                        <p class="text-sm text-gray-900 mt-1">{{ $returnOrder->quality_check_notes }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->qualityCheckedBy)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Checked By:</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->qualityCheckedBy->name }} on {{ $returnOrder->quality_checked_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->deduction_amount > 0)
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                        <p class="text-sm font-medium text-orange-900">Deduction Applied</p>
                                        <p class="text-sm text-orange-800">Amount: ₹{{ number_format($returnOrder->deduction_amount, 2) }}</p>
                                        @if($returnOrder->deduction_reason)
                                            <p class="text-sm text-orange-800">Reason: {{ $returnOrder->deduction_reason }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Name</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Email</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->user->email }}</p>
                            </div>
                            @if($returnOrder->user->phone)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Phone</p>
                                    <p class="text-sm text-gray-900">{{ $returnOrder->user->phone }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Original Order Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Original Order</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Order Number</p>
                                <a href="{{ route('admin.orders.show', $returnOrder->order) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800">{{ $returnOrder->order->order_number }}</a>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Order Date</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Order Total</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->order->formatted_total }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Order Status</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $returnOrder->order->status_badge['class'] }}">
                                    {{ $returnOrder->order->status_badge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Return Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Return Summary</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Return Type</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->return_type_display }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Return Reason</p>
                                <p class="text-sm text-gray-900">{{ $returnOrder->return_reason }}</p>
                            </div>
                            @if($returnOrder->customer_notes)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Customer Notes</p>
                                    <p class="text-sm text-gray-900">{{ $returnOrder->customer_notes }}</p>
                                </div>
                            @endif
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Return Amount</span>
                                    <span class="text-gray-900">₹{{ number_format($returnOrder->return_amount, 2) }}</span>
                                </div>
                                @if($returnOrder->deduction_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Deduction</span>
                                        <span class="text-red-600">-₹{{ number_format($returnOrder->deduction_amount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-gray-200 pt-2">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Refund Amount</span>
                                        <span class="text-base font-bold text-gray-900">₹{{ number_format($returnOrder->refund_amount ?? $returnOrder->return_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Refund Information -->
                    @if($returnOrder->refund_details)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Refund Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Refund Method</p>
                                    <p class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $returnOrder->refund_method)) }}</p>
                                </div>
                                @if($returnOrder->refund_transaction_id)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Transaction ID</p>
                                        <p class="text-sm text-gray-900 font-mono">{{ $returnOrder->refund_transaction_id }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Processed On</p>
                                    <p class="text-sm text-gray-900">{{ $returnOrder->refund_processed_at->format('M d, Y g:i A') }}</p>
                                </div>
                                @if(isset($returnOrder->refund_details['processed_by']))
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Processed By</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->refund_details['processed_by'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Admin Notes -->
                    @if($returnOrder->admin_notes || $returnOrder->rejection_reason)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Notes</h3>
                            <div class="space-y-3">
                                @if($returnOrder->admin_notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Notes</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->admin_notes }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->rejection_reason)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Rejection Reason</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->rejection_reason }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->processedBy)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Processed By</p>
                                        <p class="text-sm text-gray-900">{{ $returnOrder->processedBy->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            @if($returnOrder->canBeApproved())
                                <button onclick="showApproveModal({{ $returnOrder->id }})" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-check mr-2"></i>Approve Return
                                </button>
                                <button onclick="showRejectModal({{ $returnOrder->id }})" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-times mr-2"></i>Reject Return
                                </button>
                            @endif

                            @if($returnOrder->canInitiateReturn())
                                <a href="{{ route('admin.return-orders.return-options', $returnOrder) }}" 
                                   class="block w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors text-center">
                                    <i class="fas fa-undo mr-2"></i>Initiate Return
                                </a>
                            @endif

                            @if($returnOrder->status === 'in_transit')
                                <button onclick="showReceivedModal({{ $returnOrder->id }})" 
                                        class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-inbox mr-2"></i>Mark Received
                                </button>
                            @endif

                            @if($returnOrder->status === 'pending_refund')
                                <button onclick="showQualityCheckModal({{ $returnOrder->id }})" 
                                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-search mr-2"></i>Quality Check
                                </button>
                                @if($returnOrder->canProcessRefund())
                                    <button onclick="showRefundModal({{ $returnOrder->id }})" 
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-money-bill mr-2"></i>Process Refund
                                    </button>
                                @endif
                            @endif

                            @if($returnOrder->hasShiprocketIntegration())
                                <form action="{{ route('admin.return-orders.sync-shiprocket', $returnOrder) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-sync mr-2"></i>Sync with Shiprocket
                                    </button>
                                </form>
                            @endif

                            <button onclick="showStatusModal({{ $returnOrder->id }}, '{{ $returnOrder->status }}')" 
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-edit mr-2"></i>Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
