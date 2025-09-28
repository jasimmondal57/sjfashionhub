<x-layouts.user title="Return Request" subtitle="Request a return for your order">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <!-- Order Information -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Return Request for Order #{{ $order->order_number }}</h2>
                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }} • Delivered on {{ $order->delivered_at->format('F j, Y') }}</p>
            </div>

            <form method="POST" action="{{ route('user.returns.store', $order) }}" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Return Items Selection -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Items to Return</h3>
                    <div class="space-y-4">
                        @php
                            $deliveredDays = $order->delivered_at ? $order->delivered_at->diffInDays(now()) : 999;
                        @endphp

                        @foreach($order->items as $item)
                            @php
                                $isEligible = $item->product && $item->product->has_return_policy && $deliveredDays <= $item->product->return_days;
                                $daysLeft = $item->product ? $item->product->return_days - $deliveredDays : 0;
                            @endphp

                            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg {{ !$isEligible ? 'bg-gray-50 opacity-60' : '' }}">
                                @if($isEligible)
                                    <input type="checkbox" name="return_items[]" value="{{ $item->id }}" id="item_{{ $item->id }}"
                                           class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                @else
                                    <input type="checkbox" disabled class="h-4 w-4 text-gray-400 border-gray-300 rounded cursor-not-allowed">
                                @endif

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
                                    <label for="item_{{ $item->id }}" class="text-sm font-medium text-gray-900 {{ $isEligible ? 'cursor-pointer' : 'cursor-not-allowed' }}">{{ $item->product_name }}</label>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }} • ₹{{ number_format($item->total_price, 0) }}</p>

                                    @if($item->product)
                                        @if($isEligible)
                                            <p class="text-xs text-green-600 mt-1">
                                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Eligible for return • {{ $daysLeft }} days left ({{ $item->product->return_days }} day policy)
                                            </p>
                                        @else
                                            <p class="text-xs text-red-600 mt-1">
                                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                @if(!$item->product->has_return_policy)
                                                    No return policy
                                                @else
                                                    Return period expired ({{ $item->product->return_days }} day policy)
                                                @endif
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('return_items')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Reason -->
                <div class="mb-6">
                    <label for="return_reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Return</label>
                    <select name="return_reason" id="return_reason" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                        <option value="">Select a reason</option>
                        <option value="defective_product">Defective/Damaged Product</option>
                        <option value="wrong_item">Wrong Item Received</option>
                        <option value="size_issue">Size Issue</option>
                        <option value="quality_issue">Quality Issue</option>
                        <option value="not_as_described">Not as Described</option>
                        <option value="changed_mind">Changed Mind</option>
                        <option value="other">Other</option>
                    </select>
                    @error('return_reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Notes -->
                <div class="mb-6">
                    <label for="customer_notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                    <textarea name="customer_notes" id="customer_notes" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                              placeholder="Please provide any additional details about the return...">{{ old('customer_notes') }}</textarea>
                    @error('customer_notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Images -->
                <div class="mb-6">
                    <label for="return_images" class="block text-sm font-medium text-gray-700 mb-2">Upload Images (Optional)</label>
                    <input type="file" name="return_images[]" id="return_images" multiple accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                    <p class="mt-1 text-sm text-gray-500">Upload images to support your return request. Max 5 images, 2MB each.</p>
                    @error('return_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Refund Method for COD Orders -->
                @if($order->payment_method === 'cod')
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="text-sm font-medium text-yellow-800 mb-3">Refund Information</h4>
                        <p class="text-sm text-yellow-700 mb-4">Since this was a Cash on Delivery order, please provide your bank details for the refund.</p>
                        
                        <input type="hidden" name="refund_method" value="bank_transfer">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="bank_account_holder" class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                                <input type="text" name="bank_account_holder" id="bank_account_holder" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                                       value="{{ old('bank_account_holder') }}">
                                @error('bank_account_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                                <input type="text" name="bank_account_number" id="bank_account_number" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                                       value="{{ old('bank_account_number') }}">
                                @error('bank_account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="bank_ifsc_code" class="block text-sm font-medium text-gray-700 mb-1">IFSC Code</label>
                                <input type="text" name="bank_ifsc_code" id="bank_ifsc_code" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                                       value="{{ old('bank_ifsc_code') }}">
                                @error('bank_ifsc_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black"
                                       value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Refund Information</h4>
                        <p class="text-sm text-blue-700">Your refund will be processed to the original payment method used for this order.</p>
                    </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('user.orders') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-black text-white rounded-md text-sm font-medium hover:bg-gray-800">
                        Submit Return Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Limit file selection to 5 images
        document.getElementById('return_images').addEventListener('change', function(e) {
            if (e.target.files.length > 5) {
                alert('You can only select up to 5 images.');
                e.target.value = '';
            }
        });
    </script>
</x-layouts.user>
