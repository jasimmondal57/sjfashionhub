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
                            <p>{{ $order->shipping_address['pincode'] ?? $order->shipping_address['postal_code'] ?? 'N/A' }}, {{ $order->shipping_address['country'] ?? 'India' }}</p>
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
        <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Create Shiprocket Shipping Label</h3>

                <!-- Step 1: Enter Package Details -->
                <div id="packageDetailsSection">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">
                            <i class="fas fa-box mr-2"></i>Step 1: Enter Package Details
                        </h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="package_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Package Weight (kg) *
                            </label>
                            <input type="number" id="package_weight" step="0.1" min="0.1" required
                                   value="0.5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div></div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="package_length" class="block text-sm font-medium text-gray-700 mb-2">
                                Length (cm) *
                            </label>
                            <input type="number" id="package_length" min="1" required
                                   value="20"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="package_breadth" class="block text-sm font-medium text-gray-700 mb-2">
                                Breadth (cm) *
                            </label>
                            <input type="number" id="package_breadth" min="1" required
                                   value="15"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="package_height" class="block text-sm font-medium text-gray-700 mb-2">
                                Height (cm) *
                            </label>
                            <input type="number" id="package_height" min="1" required
                                   value="10"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideShiprocketModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="button" onclick="getAvailableCouriers()" id="getCouriersBtn"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-search mr-2"></i>Get Available Couriers
                        </button>
                    </div>
                </div>

                <!-- Step 2: Select Courier (Hidden initially) -->
                <div id="courierSelectionSection" class="hidden">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-medium text-green-900 mb-2">
                            <i class="fas fa-truck mr-2"></i>Step 2: Select Courier
                        </h4>
                    </div>

                    <!-- Loading State -->
                    <div id="couriersLoading" class="hidden text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                        <p class="text-gray-600 mt-4">Fetching available couriers...</p>
                    </div>

                    <!-- Couriers List -->
                    <div id="couriersList" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                        <!-- Couriers will be loaded here dynamically -->
                    </div>

                    <!-- Create Label Form -->
                    <form id="createLabelForm" action="{{ route('admin.orders.create-shiprocket-label', $order) }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="courier_company_id" id="selected_courier_id">
                        <input type="hidden" name="package_weight" id="final_package_weight">
                        <input type="hidden" name="package_length" id="final_package_length">
                        <input type="hidden" name="package_breadth" id="final_package_breadth">
                        <input type="hidden" name="package_height" id="final_package_height">

                        <div class="flex items-center justify-end space-x-3 mt-4">
                            <button type="button" onclick="backToPackageDetails()"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </button>
                            <button type="submit" id="createLabelBtn"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-check mr-2"></i>Create Label
                            </button>
                        </div>
                    </form>
                </div>
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
            // Reset to step 1
            document.getElementById('packageDetailsSection').classList.remove('hidden');
            document.getElementById('courierSelectionSection').classList.add('hidden');
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

        function backToPackageDetails() {
            document.getElementById('packageDetailsSection').classList.remove('hidden');
            document.getElementById('courierSelectionSection').classList.add('hidden');
        }

        async function getAvailableCouriers() {
            const weight = document.getElementById('package_weight').value;
            const length = document.getElementById('package_length').value;
            const breadth = document.getElementById('package_breadth').value;
            const height = document.getElementById('package_height').value;

            if (!weight || !length || !breadth || !height) {
                alert('Please fill in all package details');
                return;
            }

            // Show loading
            document.getElementById('packageDetailsSection').classList.add('hidden');
            document.getElementById('courierSelectionSection').classList.remove('hidden');
            document.getElementById('couriersLoading').classList.remove('hidden');
            document.getElementById('couriersList').innerHTML = '';

            try {
                const response = await fetch('{{ route("admin.orders.get-courier-rates", $order) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        weight: weight,
                        length: length,
                        breadth: breadth,
                        height: height
                    })
                });

                const data = await response.json();
                document.getElementById('couriersLoading').classList.add('hidden');

                if (data.success && data.couriers && data.couriers.length > 0) {
                    displayCouriers(data.couriers);
                } else {
                    document.getElementById('couriersList').innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl mb-2"></i>
                            <p class="text-red-800">${data.message || 'No couriers available for this delivery'}</p>
                        </div>
                    `;
                }
            } catch (error) {
                document.getElementById('couriersLoading').classList.add('hidden');
                document.getElementById('couriersList').innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-2xl mb-2"></i>
                        <p class="text-red-800">Failed to fetch courier rates. Please try again.</p>
                    </div>
                `;
                console.error('Error:', error);
            }
        }

        function displayCouriers(couriers) {
            const couriersList = document.getElementById('couriersList');
            couriersList.innerHTML = '';

            couriers.forEach(courier => {
                const courierCard = document.createElement('div');
                courierCard.className = 'border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-all';
                courierCard.onclick = () => selectCourier(courier);

                courierCard.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h5 class="font-bold text-gray-900 text-lg">${courier.courier_name}</h5>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2 text-blue-600"></i>
                                    <strong>Estimated Delivery:</strong> ${courier.estimated_delivery_days || 'N/A'}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-calendar mr-2 text-green-600"></i>
                                    <strong>Pickup:</strong> ${courier.pickup_availability || 'Available'}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-truck mr-2 text-purple-600"></i>
                                    <strong>Type:</strong> ${courier.courier_type || 'Standard'}
                                </p>
                                ${courier.cod == 1 ? '<p class="text-sm text-green-600"><i class="fas fa-money-bill mr-2"></i>COD Available</p>' : ''}
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <p class="text-2xl font-bold text-blue-600">₹${parseFloat(courier.rate).toFixed(2)}</p>
                            <p class="text-xs text-gray-500 mt-1">${courier.freight_charge ? 'Freight: ₹' + courier.freight_charge : ''}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-check mr-2"></i>Select This Courier
                        </button>
                    </div>
                `;

                couriersList.appendChild(courierCard);
            });
        }

        function selectCourier(courier) {
            // Store selected courier data
            document.getElementById('selected_courier_id').value = courier.courier_company_id;
            document.getElementById('final_package_weight').value = document.getElementById('package_weight').value;
            document.getElementById('final_package_length').value = document.getElementById('package_length').value;
            document.getElementById('final_package_breadth').value = document.getElementById('package_breadth').value;
            document.getElementById('final_package_height').value = document.getElementById('package_height').value;

            // Highlight selected courier
            const allCards = document.querySelectorAll('#couriersList > div');
            allCards.forEach(card => {
                card.classList.remove('border-green-500', 'bg-green-50');
                card.classList.add('border-gray-200');
            });
            event.currentTarget.classList.remove('border-gray-200');
            event.currentTarget.classList.add('border-green-500', 'bg-green-50');

            // Show create label button
            document.getElementById('createLabelForm').classList.remove('hidden');
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
