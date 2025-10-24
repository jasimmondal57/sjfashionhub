<x-layouts.admin>
    <x-slot name="pageTitle">WhatsApp Catalog</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">WhatsApp Product Catalog</h1>
        <div class="flex gap-2">
            <form action="{{ route('admin.whatsapp.catalog.sync-all') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700" onclick="return confirm('Sync all products to WhatsApp catalog?')">
                    <i class="fas fa-sync mr-2"></i> Sync All Products
                </button>
            </form>
            <a href="{{ route('admin.whatsapp.dashboard') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-green-600 uppercase mb-1">Synced Products</div>
                    <div class="text-2xl font-bold text-gray-800">
                        {{ $catalogProducts->where('sync_status', 'synced')->count() }}
                    </div>
                </div>
                <div>
                    <i class="fas fa-check-circle text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-yellow-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Pending Sync</div>
                    <div class="text-2xl font-bold text-gray-800">
                        {{ $catalogProducts->where('sync_status', 'pending')->count() }}
                    </div>
                </div>
                <div>
                    <i class="fas fa-clock text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-500 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase mb-1">Not in Catalog</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $unsyncedProducts }}</div>
                </div>
                <div>
                    <i class="fas fa-box text-3xl text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
        <form method="GET" action="{{ route('admin.whatsapp.catalog.index') }}" class="flex flex-wrap items-center gap-3">
            <select name="sync_status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="">All Status</option>
                <option value="synced" {{ request('sync_status') == 'synced' ? 'selected' : '' }}>Synced</option>
                    <option value="pending" {{ request('sync_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('sync_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>

                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('admin.whatsapp.catalog.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i> Clear
                </a>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">
                Catalog Products ({{ $catalogProducts->total() }})
            </h6>
        </div>
        <div class="overflow-x-auto">
            @if($catalogProducts->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sync Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Synced</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($catalogProducts as $catalogProduct)
                            @php $product = $catalogProduct->product; @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 flex items-center justify-center rounded">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $catalogProduct->retailer_id }}</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ₹{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->stock > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $product->stock }}</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'synced' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'failed' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusColor = $statusColors[$catalogProduct->sync_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($catalogProduct->sync_status) }}
                                    </span>
                                    @if($catalogProduct->sync_status === 'failed' && $catalogProduct->sync_error)
                                        <div class="text-xs text-red-600 mt-1">{{ Str::limit($catalogProduct->sync_error, 30) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($catalogProduct->last_synced_at)
                                        <div class="text-sm text-gray-900">{{ $catalogProduct->last_synced_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $catalogProduct->last_synced_at->diffForHumans() }}</div>
                                    @else
                                        <span class="text-sm text-gray-500">Never</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.whatsapp.catalog.sync', $product) }}" method="POST" class="inline mr-2">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900" title="Sync to Catalog">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($catalogProducts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $catalogProducts->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fas fa-box text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 mb-4">No products in catalog</p>
                    <form action="{{ route('admin.whatsapp.catalog.sync-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-sync mr-2"></i> Sync All Products to Catalog
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
</x-layouts.admin>
