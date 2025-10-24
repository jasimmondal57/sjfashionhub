<x-layouts.user title="Return Request Details" subtitle="View your return request status and details">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <!-- Return Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Return Request #{{ $returnOrder->return_number }}</h2>
                        <p class="text-sm text-gray-600">For Order #{{ $returnOrder->order->order_number }} • Submitted on {{ $returnOrder->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-blue-100 text-blue-800',
                                'ready_to_return' => 'bg-purple-100 text-purple-800',
                                'in_transit' => 'bg-indigo-100 text-indigo-800',
                                'received' => 'bg-orange-100 text-orange-800',
                                'pending_refund' => 'bg-pink-100 text-pink-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'cancelled' => 'bg-gray-100 text-gray-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$returnOrder->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $returnOrder->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Return Status Timeline -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Return Status</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @php
                                $statuses = [
                                    'pending' => 'Request Submitted',
                                    'approved' => 'Request Approved',
                                    'ready_to_return' => 'Ready for Pickup',
                                    'in_transit' => 'In Transit',
                                    'received' => 'Received by Seller',
                                    'pending_refund' => 'Refund Processing',
                                    'completed' => 'Refund Completed'
                                ];
                                
                                $currentStatusIndex = array_search($returnOrder->status, array_keys($statuses));
                            @endphp
                            
                            @foreach($statuses as $status => $label)
                                @php
                                    $statusIndex = array_search($status, array_keys($statuses));
                                    $isCompleted = $statusIndex <= $currentStatusIndex && $returnOrder->status !== 'rejected' && $returnOrder->status !== 'cancelled';
                                    $isCurrent = $status === $returnOrder->status;
                                @endphp
                                
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $isCompleted ? 'bg-green-500' : 'bg-gray-200' }}" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                @if($isCompleted)
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                @elseif($isCurrent)
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <span class="h-2 w-2 bg-white rounded-full"></span>
                                                    </span>
                                                @else
                                                    <span class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center ring-8 ring-white">
                                                        <span class="h-2 w-2 bg-white rounded-full"></span>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                                                @if($isCurrent)
                                                    <p class="text-sm text-gray-500">Current status</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Return Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Return Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Return Information</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Reason</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $returnOrder->return_reason)) }}</dd>
                            </div>
                            @if($returnOrder->customer_notes)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Your Notes</dt>
                                    <dd class="text-sm text-gray-900">{{ $returnOrder->customer_notes }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Amount</dt>
                                <dd class="text-sm text-gray-900">₹{{ number_format($returnOrder->return_amount, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Refund Method</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($returnOrder->refund_method === 'original_payment')
                                        Original Payment Method
                                    @elseif($returnOrder->refund_method === 'bank_transfer')
                                        Bank Transfer
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $returnOrder->refund_method)) }}
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Admin Notes -->
                    @if($returnOrder->admin_notes || $returnOrder->rejection_reason)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Updates from Seller</h3>
                            <div class="space-y-3">
                                @if($returnOrder->rejection_reason)
                                    <div class="p-3 bg-red-50 border border-red-200 rounded-md">
                                        <p class="text-sm font-medium text-red-800">Rejection Reason:</p>
                                        <p class="text-sm text-red-700">{{ $returnOrder->rejection_reason }}</p>
                                    </div>
                                @endif
                                @if($returnOrder->admin_notes)
                                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-md">
                                        <p class="text-sm font-medium text-blue-800">Seller Notes:</p>
                                        <p class="text-sm text-blue-700">{{ $returnOrder->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Return Items -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Items to Return</h3>
                    <div class="space-y-4">
                        @foreach($returnOrder->return_items as $item)
                            @php
                                // Find the order item to get product image
                                $orderItem = $returnOrder->order->items->firstWhere('id', $item['order_item_id']);
                                $productImage = null;

                                if (isset($item['main_image']) && $item['main_image']) {
                                    $productImage = $item['main_image'];
                                } elseif ($orderItem && $orderItem->product) {
                                    $productImage = $orderItem->product->main_image;
                                }
                            @endphp
                            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($productImage)
                                        <img src="{{ $productImage }}" alt="{{ $item['product_name'] }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item['product_name'] }}</h4>
                                    @if(isset($item['variant_details']) && isset($item['variant_details']['size']))
                                        <p class="text-xs text-blue-600 font-medium">Size: {{ $item['variant_details']['size'] }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }} • ₹{{ number_format($item['total_price'], 0) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Return Images -->
                @if($returnOrder->return_images && count($returnOrder->return_images) > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Uploaded Images</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($returnOrder->return_images as $image)
                                <img src="{{ Storage::url($image) }}" alt="Return image" class="h-24 w-24 object-cover rounded-lg border border-gray-200">
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('user.returns.index') }}" class="text-black hover:text-gray-700 text-sm font-medium">
                        ← Back to Returns
                    </a>
                    
                    @if($returnOrder->status === 'pending')
                        <form method="POST" action="{{ route('user.returns.cancel', $returnOrder) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Are you sure you want to cancel this return request?')" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                                Cancel Return Request
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.user>
