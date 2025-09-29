<x-layouts.user title="My Addresses" subtitle="Manage your shipping and billing addresses">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Add Button -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Addresses</h1>
                <p class="text-gray-600 mt-1">Manage your shipping and billing addresses</p>
            </div>
            <a href="{{ route('user.addresses.create') }}" 
               class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Address
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($addresses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 relative">
                        <!-- Default Badge -->
                        @if($address->is_default)
                            <div class="absolute top-4 right-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    Default
                                </span>
                            </div>
                        @endif

                        <!-- Address Type & Label -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center space-x-2">
                                @if($address->type === 'shipping')
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-blue-600">Shipping</span>
                                @elseif($address->type === 'billing')
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-purple-600">Billing</span>
                                @else
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-green-600">Both</span>
                                @endif
                                
                                @if($address->label)
                                    <span class="text-gray-400">•</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $address->label }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Address Details -->
                        <div class="space-y-2 mb-4">
                            <h3 class="font-semibold text-gray-900">{{ $address->full_name }}</h3>
                            <p class="text-gray-600">{{ $address->phone }}</p>
                            <div class="text-gray-600">
                                <p>{{ $address->address_line_1 }}</p>
                                @if($address->address_line_2)
                                    <p>{{ $address->address_line_2 }}</p>
                                @endif
                                <p>{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}</p>
                                @if($address->country !== 'India')
                                    <p>{{ $address->country }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('user.addresses.edit', $address) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Edit
                                </a>
                                @if(!$address->is_default)
                                    <form method="POST" action="{{ route('user.addresses.set-default', $address) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            Set as Default
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <form method="POST" action="{{ route('user.addresses.destroy', $address) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this address?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No addresses</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding your first address.</p>
                <div class="mt-6">
                    <a href="{{ route('user.addresses.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Address
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.user>
