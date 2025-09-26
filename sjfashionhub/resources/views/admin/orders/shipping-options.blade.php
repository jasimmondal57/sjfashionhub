<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🚚 Create Shipping Label</h1>
                        <p class="text-gray-600 mt-1">Order #{{ $order->order_number }} - Choose shipping method</p>
                    </div>
                    <a href="{{ route('admin.orders.index', ['tab' => 'ready_to_ship']) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Customer Details</h4>
                        <div class="text-sm text-gray-600">
                            <p><strong>Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h4>
                        <div class="text-sm text-gray-600">
                            <p>{{ $order->shipping_address['address'] ?? 'N/A' }}</p>
                            <p>{{ $order->shipping_address['city'] ?? 'N/A' }}, {{ $order->shipping_address['state'] ?? 'N/A' }}</p>
                            <p>{{ $order->shipping_address['postal_code'] ?? 'N/A' }}, {{ $order->shipping_address['country'] ?? 'India' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                        <span class="text-lg font-bold text-gray-900">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Shiprocket Option -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-rocket text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Shiprocket Integration</h3>
                        <p class="text-gray-600 mt-2">Automated shipping with multiple courier options</p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">Features:</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Multiple courier options with rates</li>
                                <li>• Automatic tracking updates</li>
                                <li>• Real-time delivery status</li>
                                <li>• Professional shipping labels</li>
                            </ul>
                        </div>

                        @if(!empty($courierRates))
                            <div class="space-y-3">
                                <h4 class="text-sm font-medium text-gray-700">Available Couriers:</h4>
                                @foreach($courierRates as $courier)
                                    <div class="border border-gray-200 rounded-lg p-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $courier['courier_name'] }}</p>
                                                <p class="text-sm text-gray-600">{{ $courier['estimated_delivery_days'] }} days delivery</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-gray-900">₹{{ number_format($courier['rate'], 2) }}</p>
                                                <p class="text-xs text-gray-500">{{ $courier['courier_type'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <button onclick="showShiprocketModal()" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-md font-medium transition-colors">
                            <i class="fas fa-rocket mr-2"></i>Create Shiprocket Label
                        </button>
                    </div>
                </div>

                <!-- Manual Option -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-edit text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Manual Shipping</h3>
                        <p class="text-gray-600 mt-2">Create shipping label with your own courier</p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-purple-900 mb-2">Features:</h4>
                            <ul class="text-sm text-purple-800 space-y-1">
                                <li>• Use your preferred courier</li>
                                <li>• Custom tracking ID</li>
                                <li>• Manual status updates</li>
                                <li>• Full control over shipping</li>
                            </ul>
                        </div>

                        <button onclick="showManualModal()" 
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Create Manual Label
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shiprocket Modal -->
    <div id="shiprocketModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Create Shiprocket Shipping Label</h3>
                <form action="{{ route('admin.orders.create-shiprocket-label', $order) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="courier_company_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Courier *
                            </label>
                            <select name="courier_company_id" id="courier_company_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Choose Courier</option>
                                @foreach($courierRates as $courier)
                                    <option value="{{ $courier['courier_company_id'] }}" 
                                            data-rate="{{ $courier['rate'] }}" 
                                            data-days="{{ $courier['estimated_delivery_days'] }}">
                                        {{ $courier['courier_name'] }} - ₹{{ number_format($courier['rate'], 2) }} ({{ $courier['estimated_delivery_days'] }} days)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="package_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Package Weight (kg) *
                            </label>
                            <input type="number" name="package_weight" id="package_weight" step="0.1" min="0.1" required
                                   placeholder="0.5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="package_length" class="block text-sm font-medium text-gray-700 mb-2">
                                Length (cm) *
                            </label>
                            <input type="number" name="package_length" id="package_length" min="1" required
                                   placeholder="20"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="package_breadth" class="block text-sm font-medium text-gray-700 mb-2">
                                Breadth (cm) *
                            </label>
                            <input type="number" name="package_breadth" id="package_breadth" min="1" required
                                   placeholder="15"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="package_height" class="block text-sm font-medium text-gray-700 mb-2">
                                Height (cm) *
                            </label>
                            <input type="number" name="package_height" id="package_height" min="1" required
                                   placeholder="10"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideShiprocketModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-rocket mr-2"></i>Create Label
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manual Shipping Modal -->
    <div id="manualModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Create Manual Shipping Label</h3>
                <form action="{{ route('admin.orders.create-manual-label', $order) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="manual_tracking_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tracking ID *
                            </label>
                            <input type="text" name="manual_tracking_id" id="manual_tracking_id" required
                                   placeholder="Enter tracking number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="manual_courier_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Courier Company *
                            </label>
                            <select name="manual_courier_name" id="manual_courier_name" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Select Courier</option>
                                <option value="Blue Dart">Blue Dart</option>
                                <option value="DTDC">DTDC</option>
                                <option value="FedEx">FedEx</option>
                                <option value="Delhivery">Delhivery</option>
                                <option value="Ecom Express">Ecom Express</option>
                                <option value="India Post">India Post</option>
                                <option value="Professional Couriers">Professional Couriers</option>
                                <option value="Aramex">Aramex</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label for="manual_package_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Weight (kg) *
                            </label>
                            <input type="number" name="package_weight" id="manual_package_weight" step="0.1" min="0.1" required
                                   placeholder="0.5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="manual_package_length" class="block text-sm font-medium text-gray-700 mb-2">
                                Length (cm) *
                            </label>
                            <input type="number" name="package_length" id="manual_package_length" min="1" required
                                   placeholder="20"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="manual_package_breadth" class="block text-sm font-medium text-gray-700 mb-2">
                                Breadth (cm) *
                            </label>
                            <input type="number" name="package_breadth" id="manual_package_breadth" min="1" required
                                   placeholder="15"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="manual_package_height" class="block text-sm font-medium text-gray-700 mb-2">
                                Height (cm) *
                            </label>
                            <input type="number" name="package_height" id="manual_package_height" min="1" required
                                   placeholder="10"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideManualModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Create Label
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showShiprocketModal() {
            document.getElementById('shiprocketModal').classList.remove('hidden');
        }

        function hideShiprocketModal() {
            document.getElementById('shiprocketModal').classList.add('hidden');
        }

        function showManualModal() {
            document.getElementById('manualModal').classList.remove('hidden');
        }

        function hideManualModal() {
            document.getElementById('manualModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const shiprocketModal = document.getElementById('shiprocketModal');
            const manualModal = document.getElementById('manualModal');
            
            if (event.target === shiprocketModal) {
                hideShiprocketModal();
            }
            if (event.target === manualModal) {
                hideManualModal();
            }
        }
    </script>
</x-layouts.admin>
