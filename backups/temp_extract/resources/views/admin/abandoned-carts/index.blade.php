<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🛒 Abandoned Cart Recovery</h1>
                        <p class="text-gray-600 mt-1">Recover lost sales and increase revenue</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="showAnalyticsModal()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-chart-line mr-2"></i>Analytics
                        </button>
                        <a href="{{ route('admin.abandoned-carts.export', request()->query()) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-download mr-2"></i>Export CSV
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100">
                            <i class="fas fa-shopping-cart text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Abandoned Carts</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_abandoned']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-undo text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Recovered Carts</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_recovered']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-percentage text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Recovery Rate</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['recovery_rate'] }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <i class="fas fa-rupee-sign text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Revenue Lost</p>
                            <p class="text-2xl font-bold text-gray-900">₹{{ number_format($stats['revenue_lost'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <form method="GET" action="{{ route('admin.abandoned-carts.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Customer name, email..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                            <input type="date" name="date_from" id="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                            <input type="date" name="date_to" id="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="min_value" class="block text-sm font-medium text-gray-700 mb-1">Min Value (₹)</label>
                            <input type="number" name="min_value" id="min_value" 
                                   value="{{ request('min_value') }}"
                                   placeholder="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.abandoned-carts.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label for="bulk_action" class="text-sm font-medium text-gray-700">Bulk Action:</label>
                            <select id="bulk_action" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Action</option>
                                <option value="send_email">Send Recovery Email</option>
                                <option value="mark_recovered">Mark as Recovered</option>
                                <option value="mark_expired">Mark as Expired</option>
                                <option value="delete">Delete</option>
                            </select>
                            <button type="button" onclick="executeBulkAction()" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                Execute
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Horizontal Tabs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'abandoned'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'abandoned' ? 'border-blue-500 text-blue-600' : '' }}">
                            🛒 Abandoned ({{ $stats['total_abandoned'] }})
                        </a>
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'recovered'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'recovered' ? 'border-blue-500 text-blue-600' : '' }}">
                            ✅ Recovered ({{ $stats['total_recovered'] }})
                        </a>
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'expired'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'expired' ? 'border-blue-500 text-blue-600' : '' }}">
                            ⏰ Expired ({{ $stats['total_expired'] }})
                        </a>
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'guest'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'guest' ? 'border-blue-500 text-blue-600' : '' }}">
                            👤 Guest Carts
                        </a>
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'registered'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'registered' ? 'border-blue-500 text-blue-600' : '' }}">
                            👥 Registered Users
                        </a>
                        <a href="{{ route('admin.abandoned-carts.index', ['tab' => 'high_value'] + request()->except('tab')) }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $tab === 'high_value' ? 'border-blue-500 text-blue-600' : '' }}">
                            💎 High Value (₹5000+)
                        </a>
                    </nav>
                </div>

                <!-- Cart List -->
                <div class="p-6">
                    @if($carts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="select_all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cart Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abandoned</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Emails</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($carts as $cart)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="cart_ids[]" value="{{ $cart->id }}" 
                                                       class="cart-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $cart->customer_name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $cart->customer_email }}</div>
                                                        @if($cart->phone)
                                                            <div class="text-sm text-gray-500">{{ $cart->phone }}</div>
                                                        @endif
                                                        @if($cart->is_guest)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                Guest
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $cart->formatted_total }}</div>
                                                <div class="text-sm text-gray-500">{{ $cart->items_count }} items</div>
                                                @if($cart->country)
                                                    <div class="text-sm text-gray-500">{{ $cart->city }}, {{ $cart->country }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $cart->status === 'abandoned' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $cart->status === 'recovered' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $cart->status === 'expired' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ ucfirst($cart->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $cart->time_since_abandoned }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $cart->email_count }} sent</div>
                                                @if($cart->last_email_sent_at)
                                                    <div class="text-sm text-gray-500">Last: {{ $cart->last_email_sent_at->diffForHumans() }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('admin.abandoned-carts.show', $cart) }}" 
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                @if($cart->status === 'abandoned')
                                                    <button onclick="showEmailModal({{ $cart->id }})" 
                                                            class="text-green-600 hover:text-green-900">Send Email</button>
                                                    <button onclick="markAsRecovered({{ $cart->id }})" 
                                                            class="text-purple-600 hover:text-purple-900">Mark Recovered</button>
                                                @endif
                                                <button onclick="deleteCart({{ $cart->id }})" 
                                                        class="text-red-600 hover:text-red-900">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $carts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-shopping-cart text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No abandoned carts found</h3>
                            <p class="text-gray-500">No carts match your current filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Send Email Modal -->
    <div id="emailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Send Recovery Email</h3>
                <form id="emailForm" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email_type" class="block text-sm font-medium text-gray-700 mb-1">Email Type</label>
                            <select name="email_type" id="email_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="reminder_1">First Reminder</option>
                                <option value="reminder_2">Second Reminder</option>
                                <option value="reminder_3">Third Reminder</option>
                                <option value="final_reminder">Final Reminder</option>
                                <option value="custom">Custom Email</option>
                            </select>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" name="subject" id="subject" required
                                   value="Don't forget your items!"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Email Content</label>
                            <textarea name="content" id="content" rows="4" required
                                      placeholder="Your personalized message..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="include_coupon" id="include_coupon" value="1"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="include_coupon" class="ml-2 block text-sm text-gray-700">
                                Include discount coupon
                            </label>
                        </div>
                        <div id="couponFields" class="space-y-3 hidden">
                            <div>
                                <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                                <input type="text" name="coupon_code" id="coupon_code"
                                       placeholder="COMEBACK10"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="discount_amount" class="block text-sm font-medium text-gray-700 mb-1">Discount</label>
                                    <input type="number" name="discount_amount" id="discount_amount" min="0"
                                           placeholder="10"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                    <select name="discount_type" id="discount_type"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed Amount</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-3 mt-6">
                        <button type="button" onclick="hideEmailModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Analytics Modal -->
    <div id="analyticsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">📊 Abandoned Cart Analytics</h3>
                    <button onclick="hideAnalyticsModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="analyticsContent">
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <span class="ml-3 text-gray-600">Loading analytics...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showEmailModal(cartId) {
            document.getElementById('emailForm').action = `/admin/abandoned-carts/${cartId}/send-email`;
            document.getElementById('emailModal').classList.remove('hidden');
        }

        function hideEmailModal() {
            document.getElementById('emailModal').classList.add('hidden');
        }

        function showAnalyticsModal() {
            document.getElementById('analyticsModal').classList.remove('hidden');
            loadAnalytics();
        }

        function hideAnalyticsModal() {
            document.getElementById('analyticsModal').classList.add('hidden');
        }

        // Toggle coupon fields
        document.getElementById('include_coupon').addEventListener('change', function() {
            const couponFields = document.getElementById('couponFields');
            if (this.checked) {
                couponFields.classList.remove('hidden');
            } else {
                couponFields.classList.add('hidden');
            }
        });

        // Select all functionality
        document.getElementById('select_all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.cart-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk actions
        function executeBulkAction() {
            const action = document.getElementById('bulk_action').value;
            const selectedCarts = Array.from(document.querySelectorAll('.cart-checkbox:checked')).map(cb => cb.value);

            if (!action) {
                alert('Please select an action');
                return;
            }

            if (selectedCarts.length === 0) {
                alert('Please select at least one cart');
                return;
            }

            if (confirm(`Are you sure you want to ${action.replace('_', ' ')} ${selectedCarts.length} cart(s)?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.abandoned-carts.bulk-action") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;
                form.appendChild(actionInput);

                selectedCarts.forEach(cartId => {
                    const cartInput = document.createElement('input');
                    cartInput.type = 'hidden';
                    cartInput.name = 'cart_ids[]';
                    cartInput.value = cartId;
                    form.appendChild(cartInput);
                });

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Individual actions
        function markAsRecovered(cartId) {
            if (confirm('Mark this cart as recovered?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/abandoned-carts/${cartId}/mark-recovered`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteCart(cartId) {
            if (confirm('Are you sure you want to delete this abandoned cart?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/abandoned-carts/${cartId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Load analytics
        function loadAnalytics() {
            fetch('{{ route("admin.abandoned-carts.analytics") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('analyticsContent').innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Recovery Rate Trend</h4>
                                <div class="text-sm text-gray-600">Last 30 days data visualization would go here</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Revenue Impact</h4>
                                <div class="text-sm text-gray-600">Revenue lost vs recovered chart would go here</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Email Performance</h4>
                                <div class="text-sm text-gray-600">Email open/click rates by type would go here</div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Top Insights</h4>
                                <div class="text-sm text-gray-600">Key insights and recommendations would go here</div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    document.getElementById('analyticsContent').innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-600 mb-2">
                                <i class="fas fa-exclamation-circle text-2xl"></i>
                            </div>
                            <p class="text-gray-600">Failed to load analytics data</p>
                        </div>
                    `;
                });
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const emailModal = document.getElementById('emailModal');
            const analyticsModal = document.getElementById('analyticsModal');

            if (event.target === emailModal) {
                hideEmailModal();
            }
            if (event.target === analyticsModal) {
                hideAnalyticsModal();
            }
        }
    </script>
</x-layouts.admin>
