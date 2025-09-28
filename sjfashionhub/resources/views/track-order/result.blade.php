<x-layouts.main>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Tracking</h1>
                <p class="text-gray-600">Track your order status and delivery progress</p>
            </div>

            <!-- Order Information Card -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Order #{{ $order->order_number }}</h2>
                            <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge['class'] }}">
                                {{ $order->status_badge['text'] }}
                            </span>
                            <p class="text-lg font-semibold text-gray-900 mt-1">₹{{ number_format($order->total_amount, 0) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Tracking Timeline</h3>
                    
                    @php
                        $timeline = [];
                        
                        // Order placed
                        $timeline[] = [
                            'status' => 'Order Placed',
                            'description' => 'Your order has been placed successfully',
                            'date' => $order->created_at,
                            'completed' => true
                        ];
                        
                        // Order confirmed
                        if ($order->confirmed_at) {
                            $timeline[] = [
                                'status' => 'Order Confirmed',
                                'description' => 'Your order has been confirmed and is being prepared',
                                'date' => $order->confirmed_at,
                                'completed' => true
                            ];
                        }
                        
                        // Ready to ship
                        if ($order->ready_to_ship_at) {
                            $timeline[] = [
                                'status' => 'Ready to Ship',
                                'description' => 'Your order is packed and ready for shipment',
                                'date' => $order->ready_to_ship_at,
                                'completed' => true
                            ];
                        }
                        
                        // In transit
                        if ($order->in_transit_at) {
                            $timeline[] = [
                                'status' => 'In Transit',
                                'description' => 'Your order is on the way',
                                'date' => $order->in_transit_at,
                                'completed' => true
                            ];
                        }
                        
                        // Out for delivery
                        if ($order->out_for_delivery_at) {
                            $timeline[] = [
                                'status' => 'Out for Delivery',
                                'description' => 'Your order is out for delivery',
                                'date' => $order->out_for_delivery_at,
                                'completed' => true
                            ];
                        }
                        
                        // Delivered
                        if ($order->delivered_at) {
                            $timeline[] = [
                                'status' => 'Delivered',
                                'description' => 'Your order has been delivered successfully',
                                'date' => $order->delivered_at,
                                'completed' => true
                            ];
                        } else {
                            // Add expected delivery if not delivered yet
                            $timeline[] = [
                                'status' => 'Delivered',
                                'description' => $order->estimated_delivery_date ? 'Expected delivery: ' . $order->estimated_delivery_date->format('F j, Y') : 'Your order will be delivered soon',
                                'date' => $order->estimated_delivery_date,
                                'completed' => false
                            ];
                        }
                    @endphp

                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($timeline as $index => $event)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $event['completed'] ? 'bg-green-500' : 'bg-gray-300' }}" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                @if($event['completed'])
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $event['status'] }}</p>
                                                    <p class="text-sm text-gray-500">{{ $event['description'] }}</p>
                                                    @if($event['date'])
                                                        <p class="text-xs text-gray-400 mt-1">{{ $event['date']->format('F j, Y \a\t g:i A') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            @if($order->courier_company || $order->awb_number)
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Shipping Information</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($order->courier_company)
                                <div>
                                    <p class="text-sm text-gray-600">Courier Company</p>
                                    <p class="font-medium text-gray-900">{{ $order->courier_company }}</p>
                                </div>
                            @endif
                            @if($order->awb_number)
                                <div>
                                    <p class="text-sm text-gray-600">Tracking Number</p>
                                    <p class="font-medium text-gray-900">{{ $order->awb_number }}</p>
                                </div>
                            @endif
                        </div>
                        @if($order->tracking_url)
                            <div class="mt-4">
                                <a href="{{ $order->tracking_url }}" target="_blank" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Track on Courier Website
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center space-x-4">
                                @if($item->product && $item->product->featured_image)
                                    <img class="h-16 w-16 rounded-lg object-cover" src="{{ Storage::url($item->product->featured_image) }}" alt="{{ $item->product_name }}">
                                @else
                                    <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->total_price, 0) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center">
                <a href="{{ route('track-order.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-4">
                    Track Another Order
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-md text-sm font-medium text-white bg-black hover:bg-gray-800">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
