@props([
    'text' => 'Add to Cart',
    'successText' => 'Added to Cart!',
    'disabled' => false,
    'onclick' => '',
    'class' => '',
    'id' => ''
])

<button 
    class="cart-button {{ $class }}" 
    @if($id) id="{{ $id }}" @endif
    @if($onclick) onclick="{{ $onclick }}" @endif
    @if($disabled) disabled @endif
    {{ $attributes }}
>
    <span class="button-text">{{ $text }}</span>
    <span class="success-text">{{ $successText }}</span>
    
    <!-- Cart Icon -->
    <div class="cart-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="m1 1 4 4 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
    </div>
    
    <!-- Product Item Animation -->
    <div class="product-item">
        <div class="item-box"></div>
    </div>
    
    <!-- Success Checkmark -->
    <div class="checkmark">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <polyline points="20,6 9,17 4,12"></polyline>
        </svg>
    </div>
</button>

<style>
.cart-button {
    position: relative;
    padding: 12px 24px;
    min-width: 180px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    overflow: hidden;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cart-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.cart-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Button Text */
.cart-button .button-text {
    opacity: 1;
    transition: opacity 0.3s ease;
}

.cart-button .success-text {
    position: absolute;
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Cart Icon */
.cart-button .cart-icon {
    position: absolute;
    right: 16px;
    width: 20px;
    height: 20px;
    opacity: 1;
    transform: scale(1);
    transition: all 0.4s ease;
}

.cart-button .cart-icon svg {
    width: 100%;
    height: 100%;
}

/* Product Item */
.cart-button .product-item {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.cart-button .product-item .item-box {
    width: 12px;
    height: 12px;
    background: #ffd700;
    border-radius: 2px;
    transform: scale(0);
    transition: all 0.3s ease;
}

/* Checkmark */
.cart-button .checkmark {
    position: absolute;
    right: 16px;
    width: 20px;
    height: 20px;
    opacity: 0;
    transform: scale(0);
    transition: all 0.4s ease;
}

.cart-button .checkmark svg {
    width: 100%;
    height: 100%;
    stroke: #4ade80;
}

/* Animation States */
.cart-button.adding .button-text {
    opacity: 0;
}

.cart-button.adding .cart-icon {
    transform: scale(1.2) rotate(10deg);
    animation: cartShake 0.6s ease-in-out;
}

.cart-button.adding .product-item {
    opacity: 1;
    animation: itemToCart 0.8s ease-out;
}

.cart-button.adding .product-item .item-box {
    transform: scale(1);
    animation: itemPulse 0.8s ease-out;
}

.cart-button.added .button-text {
    opacity: 0;
}

.cart-button.added .success-text {
    opacity: 1;
}

.cart-button.added .cart-icon {
    opacity: 0;
    transform: scale(0);
}

.cart-button.added .checkmark {
    opacity: 1;
    transform: scale(1);
    animation: checkmarkPop 0.5s ease-out;
}

.cart-button.added {
    background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
}

/* Keyframe Animations */
@keyframes cartShake {
    0%, 100% { transform: scale(1.2) rotate(10deg); }
    25% { transform: scale(1.3) rotate(-5deg); }
    50% { transform: scale(1.2) rotate(15deg); }
    75% { transform: scale(1.3) rotate(-10deg); }
}

@keyframes itemToCart {
    0% {
        transform: translate(-50%, -50%) translateX(-60px) scale(0);
        opacity: 0;
    }
    30% {
        transform: translate(-50%, -50%) translateX(-30px) scale(1);
        opacity: 1;
    }
    70% {
        transform: translate(-50%, -50%) translateX(20px) scale(0.8);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) translateX(40px) scale(0);
        opacity: 0;
    }
}

@keyframes itemPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

@keyframes checkmarkPop {
    0% {
        transform: scale(0) rotate(-45deg);
        opacity: 0;
    }
    50% {
        transform: scale(1.2) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

/* Ripple Effect */
.cart-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.cart-button.adding::before {
    width: 300px;
    height: 300px;
}
</style>
