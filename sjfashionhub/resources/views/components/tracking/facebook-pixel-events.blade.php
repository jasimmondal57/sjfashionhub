@php
    $settings = \App\Models\AnalyticsSetting::first();
@endphp

@if($settings && $settings->isFacebookPixelActive())
<script>
// Facebook Pixel Event Tracking

@if(isset($event) && $event === 'ViewContent' && isset($product))
// Track Product View
fbq('track', 'ViewContent', {
    content_name: '{{ addslashes($product->name) }}',
    content_category: '{{ $product->category->name ?? "Fashion" }}',
    content_ids: ['{{ $product->id }}'],
    content_type: 'product',
    value: {{ $product->sale_price ?? $product->price }},
    currency: 'INR',
    contents: [{
        id: '{{ $product->id }}',
        quantity: 1,
        item_price: {{ $product->sale_price ?? $product->price }}
    }]
});
@endif

@if(isset($event) && $event === 'AddToCart')
// Track Add to Cart (triggered via JavaScript)
window.trackAddToCart = function(productId, productName, price, quantity, category) {
    if (typeof fbq !== 'undefined') {
        fbq('track', 'AddToCart', {
            content_name: productName,
            content_category: category || 'Fashion',
            content_ids: [productId],
            content_type: 'product',
            value: price * quantity,
            currency: 'INR',
            contents: [{
                id: productId,
                quantity: quantity || 1,
                item_price: price
            }]
        });
    }
};
@endif

@if(isset($event) && $event === 'InitiateCheckout' && isset($cartTotal))
// Track Checkout Initiation
fbq('track', 'InitiateCheckout', {
    content_type: 'product',
    value: {{ $cartTotal }},
    currency: 'INR',
    num_items: {{ $cartItemCount ?? 0 }}
    @if(isset($cartItems) && count($cartItems) > 0)
    ,
    content_ids: {!! json_encode($cartItems->pluck('product_id')->toArray()) !!},
    contents: {!! json_encode($cartItems->map(function($item) {
        return [
            'id' => $item->product_id,
            'quantity' => $item->quantity,
            'item_price' => $item->price
        ];
    })->toArray()) !!}
    @endif
});
@endif

@if(isset($event) && $event === 'Purchase' && isset($order))
// Track Purchase
fbq('track', 'Purchase', {
    content_type: 'product',
    value: {{ $order->total }},
    currency: 'INR',
    content_ids: {!! json_encode($order->items->pluck('product_id')->toArray()) !!},
    num_items: {{ $order->items->count() }},
    contents: {!! json_encode($order->items->map(function($item) {
        return [
            'id' => $item->product_id,
            'quantity' => $item->quantity,
            'item_price' => $item->price
        ];
    })->toArray()) !!}
});
@endif

@if(isset($event) && $event === 'Search' && isset($searchQuery))
// Track Search
fbq('track', 'Search', {
    search_string: '{{ $searchQuery }}'
});
@endif

@if(isset($event) && $event === 'AddToWishlist' && isset($product))
// Track Add to Wishlist
fbq('track', 'AddToWishlist', {
    content_name: '{{ addslashes($product->name) }}',
    content_category: '{{ $product->category->name ?? "Fashion" }}',
    content_ids: ['{{ $product->id }}'],
    content_type: 'product',
    value: {{ $product->sale_price ?? $product->price }},
    currency: 'INR',
    contents: [{
        id: '{{ $product->id }}',
        quantity: 1,
        item_price: {{ $product->sale_price ?? $product->price }}
    }]
});
@endif
</script>
@endif

