<x-layouts.user title="My Returns" subtitle="Track your return requests and refund status">
    @if($returns->count() > 0)
        <div class="space-y-6">
            @foreach($returns as $return)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Return #{{ $return->return_number }}</h3>
                                <p class="text-sm text-gray-600">
                                    For Order #{{ $return->order->order_number }} • 
                                    Submitted on {{ $return->created_at->format('F j, Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">₹{{ number_format($return->return_amount, 0) }}</p>
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$return->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $return->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Return Items Summary -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Return Items</h4>
                                <div class="text-sm text-gray-600">
                                    @foreach($return->return_items as $item)
                                        <span class="inline-block mr-4">{{ $item['product_name'] }} ({{ $item['quantity'] }})</span>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Return Reason -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Return Reason</h4>
                                <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $return->return_reason)) }}</p>
                            </div>
                            
                            <!-- Status Updates -->
                            @if($return->admin_notes || $return->rejection_reason)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Latest Update</h4>
                                    @if($return->rejection_reason)
                                        <p class="text-sm text-red-600">Rejected: {{ $return->rejection_reason }}</p>
                                    @elseif($return->admin_notes)
                                        <p class="text-sm text-gray-600">{{ $return->admin_notes }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('user.returns.show', $return) }}" class="text-black hover:text-gray-700 text-sm font-medium">
                                View Details
                            </a>
                            
                            <div class="flex space-x-2">
                                @if($return->status === 'pending')
                                    <form method="POST" action="{{ route('user.returns.cancel', $return) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this return request?')" 
                                                class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700">
                                            Cancel Request
                                        </button>
                                    </form>
                                @elseif($return->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Refund Completed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $returns->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No return requests</h3>
            <p class="mt-2 text-gray-600">You haven't submitted any return requests yet.</p>
            <div class="mt-6">
                <a href="{{ route('user.orders') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800">
                    View Orders
                </a>
            </div>
        </div>
    @endif
</x-layouts.user>
