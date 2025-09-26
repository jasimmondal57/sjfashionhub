<x-layouts.main>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl font-bold text-center mb-8">Cart Animation Button Test</h1>
                
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-semibold mb-6">Test Different Cart Animation Buttons</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Default Button -->
                        <div class="text-center">
                            <h3 class="text-lg font-medium mb-4">Default Style</h3>
                            <x-cart-animation-button 
                                text="Add to Cart" 
                                success-text="Added to Cart!"
                                id="test-btn-1"
                            />
                        </div>
                        
                        <!-- Custom Text Button -->
                        <div class="text-center">
                            <h3 class="text-lg font-medium mb-4">Custom Text</h3>
                            <x-cart-animation-button 
                                text="Buy Now" 
                                success-text="Item Added!"
                                id="test-btn-2"
                            />
                        </div>
                        
                        <!-- Wide Button -->
                        <div class="text-center">
                            <h3 class="text-lg font-medium mb-4">Wide Button</h3>
                            <x-cart-animation-button 
                                text="Add to Shopping Cart" 
                                success-text="Successfully Added!"
                                id="test-btn-3"
                                class="w-full"
                            />
                        </div>
                        
                        <!-- Product Card Example -->
                        <div class="col-span-full mt-8">
                            <h3 class="text-xl font-semibold mb-4">Product Card Example</h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center space-x-6">
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">DEMO</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold">Sample Product</h4>
                                        <p class="text-gray-600 mb-2">This is a demo product for testing the cart animation.</p>
                                        <p class="text-xl font-bold text-green-600">$29.99</p>
                                    </div>
                                    <div>
                                        <x-cart-animation-button 
                                            text="Add to Cart" 
                                            success-text="Added!"
                                            id="product-cart-btn"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Instructions -->
                    <div class="mt-12 bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">How it works:</h3>
                        <ul class="text-blue-800 space-y-2">
                            <li>• Click any "Add to Cart" button to see the animation</li>
                            <li>• Watch the item animate into the shopping cart</li>
                            <li>• The cart shakes to indicate the item was added</li>
                            <li>• Success state shows with checkmark</li>
                            <li>• Button automatically resets after 3 seconds</li>
                        </ul>
                    </div>
                    
                    <!-- Reset Button -->
                    <div class="mt-6 text-center">
                        <button onclick="resetAllCartButtons()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                            Reset All Buttons
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add event listeners for testing
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for cart animation completion
            document.querySelectorAll('.cart-button').forEach(button => {
                button.addEventListener('cartAnimationComplete', function(e) {
                    console.log('Cart animation completed for button:', e.detail.button.id);
                    
                    // You could add additional functionality here like:
                    // - Update cart count in header
                    // - Show toast notification
                    // - Send AJAX request to server
                });
            });
        });
    </script>
    @endpush
</x-layouts.main>
