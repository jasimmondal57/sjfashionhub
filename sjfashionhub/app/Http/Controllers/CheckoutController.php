<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingSetting;
use App\Models\UserAddress;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Get cart items
        $cartItems = Cart::getCartItems();
        
        // If cart is empty, redirect to cart page
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        $cartTotal = Cart::getCartTotal();
        $cartCount = Cart::getCartCount();
        
        // Calculate totals with inclusive GST (reverse calculation)
        // Product prices include GST based on their individual tax_rate
        $total_with_tax = $cartTotal; // This is the final amount for products

        // Calculate tax based on actual product tax rates
        $tax = 0;
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $itemTotal = $price * $item->quantity;
            $taxRate = $item->product->tax_rate ?? 5; // Default to 5% if not set

            // Reverse GST calculation: tax portion from inclusive price
            $itemTax = $itemTotal * ($taxRate / (100 + $taxRate));
            $itemSubtotal = $itemTotal - $itemTax;

            $tax += $itemTax;
            $subtotal += $itemSubtotal;
        }

        // Get shipping cost from settings
        $shippingSettings = ShippingSetting::getSettings();

        // Try to get destination from default address for location-based shipping
        $destination = null;
        $defaultAddress = Auth::check() ? Auth::user()->defaultAddress : null;
        if ($defaultAddress) {
            $destination = [
                'state' => $defaultAddress->state,
                'country' => $defaultAddress->country ?? 'India'
            ];
        }

        $shipping = $shippingSettings->calculateShipping($cartTotal, null, $destination);

        $total = $subtotal + $shipping + $tax; // Final total

        // Get user's saved addresses if authenticated
        $userAddresses = Auth::check() ? Auth::user()->addresses()->orderBy('is_default', 'desc')->get() : collect();

        return view('checkout.index', compact(
            'cartItems',
            'cartTotal',
            'cartCount',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'userAddresses',
            'defaultAddress'
        ));
    }
    
    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'payment_method' => 'required|string|in:cod,online',
            'coupon_code' => 'nullable|string|max:50',
            'coupon_discount' => 'nullable|numeric|min:0',
        ]);
        
        // Get cart items
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals with inclusive GST (reverse calculation)
        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();
        $total_with_tax = $cartTotal; // Product prices include tax

        // Calculate tax based on actual product tax rates
        $tax = 0;
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $itemTotal = $price * $item->quantity;
            $taxRate = $item->product->tax_rate ?? 5; // Default to 5% if not set

            // Reverse GST calculation: tax portion from inclusive price
            $itemTax = $itemTotal * ($taxRate / (100 + $taxRate));
            $itemSubtotal = $itemTotal - $itemTax;

            $tax += $itemTax;
            $subtotal += $itemSubtotal;
        }

        // Get shipping cost from settings
        $shippingSettings = ShippingSetting::getSettings();
        $shipping = $shippingSettings->calculateShipping($cartTotal);

        $total = $subtotal + $shipping + $tax; // Final total

        // Handle coupon discount
        $couponCode = null;
        $couponDiscount = 0;
        $appliedCoupon = null;

        if ($request->filled('coupon_code') && $request->filled('coupon_discount')) {
            $couponCode = strtoupper($request->coupon_code);
            $couponDiscount = (float) $request->coupon_discount;

            // Validate the coupon again for security
            $appliedCoupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($appliedCoupon && $appliedCoupon->isValid() && $appliedCoupon->canBeUsedBy(Auth::id(), $total)) {
                $calculatedDiscount = $appliedCoupon->calculateDiscount($total, $shipping);

                // Ensure the discount matches what was calculated on frontend
                if (abs($calculatedDiscount - $couponDiscount) < 0.01) {
                    $total -= $couponDiscount;
                } else {
                    // Discount mismatch, recalculate
                    $couponDiscount = $calculatedDiscount;
                    $total -= $couponDiscount;
                }
            } else {
                // Invalid coupon, reset discount
                $couponCode = null;
                $couponDiscount = 0;
                $appliedCoupon = null;
            }
        }

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);

            // Ensure order number is unique
            while (Order::where('order_number', $orderNumber)->exists()) {
                $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            }

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'discount_amount' => $couponDiscount,
                'coupon_code' => $couponCode,
                'total_amount' => $total,
                'currency' => 'INR',
                'is_cod' => $request->payment_method === 'cod',
                'cod_amount' => $request->payment_method === 'cod' ? $total : 0,
                'billing_address' => [
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                ],
                'shipping_address' => [
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                ],
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $price = $cartItem->product->sale_price ?? $cartItem->product->price;

                // Prepare variant details if variant exists
                $variantDetails = null;
                if ($cartItem->productVariant) {
                    $variantDetails = [
                        'size' => $cartItem->productVariant->option1_value,
                        'option1_name' => $cartItem->productVariant->option1_name,
                        'option1_value' => $cartItem->productVariant->option1_value,
                        'option2_name' => $cartItem->productVariant->option2_name,
                        'option2_value' => $cartItem->productVariant->option2_value,
                        'option3_name' => $cartItem->productVariant->option3_name,
                        'option3_value' => $cartItem->productVariant->option3_value,
                        'sku' => $cartItem->productVariant->sku,
                    ];
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $price,
                    'total_price' => $price * $cartItem->quantity,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku ?? '',
                    'variant_details' => $variantDetails,
                ]);

                // Update stock for variant or product
                if ($cartItem->productVariant) {
                    $cartItem->productVariant->decreaseStock($cartItem->quantity);
                } elseif ($cartItem->product->manage_stock) {
                    $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Increment coupon usage if coupon was applied
            if ($appliedCoupon) {
                $appliedCoupon->incrementUsage();
            }

            // Save address to user's address book if authenticated and not already saved
            if (Auth::check()) {
                $this->saveUserAddress($request, Auth::id());
            }

            DB::commit();

            // Handle payment method routing
            if ($request->payment_method === 'online') {
                // Check which payment gateway to use (default to PayU for now)
                $activeGateway = \App\Models\PaymentGateway::where('is_active', true)
                    ->where('type', 'online')
                    ->orderBy('sort_order')
                    ->first();

                if (!$activeGateway) {
                    return back()->with('error', 'No payment gateway available. Please try Cash on Delivery.');
                }

                // Route to appropriate payment gateway
                if ($activeGateway->name === 'payu') {
                    return $this->processPayUPayment($order);
                } elseif ($activeGateway->name === 'cashfree') {
                    return $this->processCashfreePayment($order);
                } else {
                    return back()->with('error', 'Payment gateway not supported. Please try Cash on Delivery.');
                }
            } else {
                // For COD, clear cart and show success page
                Cart::clearCart();
                return redirect()->route('checkout.success', ['order' => $order->id])->with('success', 'Order placed successfully!');
            }

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()])->withInput();
        }
    }
    
    /**
     * Show order success page
     */
    public function success(Request $request)
    {
        $order = null;

        if ($request->has('order')) {
            $order = Order::with('items.product')->find($request->order);

            // If token is provided (from payment gateway), verify it
            if ($request->has('token') && $order) {
                $expectedToken = hash('sha256', $order->id . $order->order_number . $order->created_at);

                if (!hash_equals($expectedToken, $request->token)) {
                    \Log::warning('Invalid success token for order', [
                        'order_id' => $order->id,
                        'provided_token' => $request->token
                    ]);

                    return redirect()->route('home')->with('error', 'Invalid order access.');
                }

                \Log::info('Order success page accessed with valid token', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            }
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Process Cashfree payment directly
     */
    private function processCashfreePayment($order)
    {
        // Get Cashfree gateway configuration
        $cashfreeGateway = \App\Models\PaymentGateway::where('name', 'cashfree')
            ->where('is_active', true)
            ->first();

        if (!$cashfreeGateway) {
            return back()->with('error', 'Cashfree payment gateway is not available.');
        }

        $credentials = $cashfreeGateway->decrypted_credentials ?? [];
        $appId = $credentials['app_id'] ?? null;
        $secretKey = $credentials['secret_key'] ?? null;

        // Debug logging
        \Log::info('Cashfree credentials check', [
            'app_id_length' => $appId ? strlen($appId) : 0,
            'secret_key_length' => $secretKey ? strlen($secretKey) : 0,
            'app_id_start' => $appId ? substr($appId, 0, 10) : 'null',
        ]);

        if (!$appId || !$secretKey) {
            \Log::error('Cashfree credentials missing', [
                'app_id' => $appId ? 'present' : 'missing',
                'secret_key' => $secretKey ? 'present' : 'missing'
            ]);
            return back()->with('error', 'Cashfree payment gateway not configured properly.');
        }

        try {
            // Create Cashfree payment session
            $paymentSession = $this->createCashfreePaymentSession($order, $appId, $secretKey);

            if (!$paymentSession || !isset($paymentSession['payment_link'])) {
                throw new \Exception('Failed to create payment session - no payment link received');
            }

            \Log::info('Cashfree payment session created successfully', [
                'order_id' => $order->id,
                'payment_link' => $paymentSession['payment_link']
            ]);

            // Redirect directly to Cashfree payment gateway
            return redirect($paymentSession['payment_link']);

        } catch (\Exception $e) {
            \Log::error('Cashfree payment session creation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            // For account not activated error, show helpful message
            if (str_contains($e->getMessage(), 'transactions are not enabled')) {
                return back()->with('error', 'Your Cashfree account needs to be activated for live transactions. Please contact Cashfree support or use Cash on Delivery for now.');
            }

            // For other errors, show generic message
            return back()->with('error', 'Payment gateway is currently unavailable. Please try Cash on Delivery or contact support.');
        }
    }

    /**
     * Process PayU payment directly
     */
    private function processPayUPayment($order)
    {
        // Get PayU gateway configuration
        $payuGateway = \App\Models\PaymentGateway::where('name', 'payu')
            ->where('is_active', true)
            ->first();

        if (!$payuGateway) {
            return back()->with('error', 'PayU payment gateway is not available.');
        }

        $credentials = $payuGateway->decrypted_credentials ?? [];
        $merchantKey = $credentials['merchant_key'] ?? null;
        $merchantSalt = $credentials['merchant_salt'] ?? null;

        if (!$merchantKey || !$merchantSalt) {
            \Log::error('PayU credentials missing', [
                'merchant_key' => $merchantKey ? 'present' : 'missing',
                'merchant_salt' => $merchantSalt ? 'present' : 'missing'
            ]);
            return back()->with('error', 'PayU payment gateway not configured properly.');
        }

        try {
            // Prepare PayU payment data
            $paymentData = $this->preparePayUPaymentData($order, $merchantKey, $merchantSalt, $payuGateway->is_test_mode);

            \Log::info('PayU payment initiated', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => $order->total_amount,
                'test_mode' => $payuGateway->is_test_mode
            ]);

            // Create auto-submit form and redirect directly to PayU
            $formHtml = $this->generatePayUForm($paymentData);
            return response($formHtml);

        } catch (\Exception $e) {
            \Log::error('PayU payment initiation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Payment processing failed. Please try again or use Cash on Delivery.');
        }
    }

    /**
     * Prepare PayU payment data
     */
    private function preparePayUPaymentData($order, $merchantKey, $merchantSalt, $isTestMode = true)
    {
        // PayU URLs
        $payuUrl = $isTestMode
            ? 'https://test.payu.in/_payment'  // Test URL
            : 'https://secure.payu.in/_payment'; // Production URL

        // Prepare payment parameters
        $txnid = 'TXN' . $order->id . '_' . time();
        $amount = number_format($order->total_amount, 2, '.', '');
        $productinfo = 'Order #' . $order->order_number;
        $firstname = $order->billing_address['full_name'] ?? 'Customer';
        $email = $order->billing_address['email'] ?? 'customer@example.com';
        $phone = $order->billing_address['phone'] ?? '9999999999';

        // Success and failure URLs
        $surl = route('payment.payu.success');
        $furl = route('payment.payu.failure');

        // Generate hash
        $hashString = $merchantKey . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $merchantSalt;
        $hash = strtolower(hash('sha512', $hashString));

        // Store transaction ID in order for verification
        $order->update(['transaction_id' => $txnid]);

        \Log::info('Transaction ID updated for order', [
            'order_id' => $order->id,
            'txnid' => $txnid,
            'updated' => $order->fresh()->transaction_id
        ]);

        return [
            'action' => $payuUrl,
            'key' => $merchantKey,
            'txnid' => $txnid,
            'amount' => $amount,
            'productinfo' => $productinfo,
            'firstname' => $firstname,
            'email' => $email,
            'phone' => $phone,
            'surl' => $surl,
            'furl' => $furl,
            'hash' => $hash,
            'service_provider' => 'payu_paisa',
        ];
    }

    /**
     * Generate PayU auto-submit form
     */
    private function generatePayUForm($paymentData)
    {
        $formFields = '';
        foreach ($paymentData as $key => $value) {
            if ($key !== 'action') {
                $formFields .= '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '" />' . "\n";
            }
        }

        return '<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayU...</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <h2>Redirecting to PayU Payment Gateway...</h2>
    <div class="loader"></div>
    <p>Please wait while we redirect you to complete your payment.</p>

    <form id="payuForm" action="' . htmlspecialchars($paymentData['action']) . '" method="post">
        ' . $formFields . '
    </form>

    <script>
        // Auto-submit form immediately
        document.getElementById("payuForm").submit();
    </script>
</body>
</html>';
    }

    /**
     * Create Cashfree payment session using API
     */
    private function createCashfreePaymentSession($order, $appId, $secretKey)
    {
        // Get gateway to check test mode
        $gateway = \App\Models\PaymentGateway::where('name', 'cashfree')->first();
        $isTestMode = $gateway ? $gateway->is_test_mode : true;

        $baseUrl = $isTestMode
            ? 'https://sandbox.cashfree.com/pg'
            : 'https://api.cashfree.com/pg';

        \Log::info('Cashfree API URL', [
            'test_mode' => $isTestMode,
            'url' => $baseUrl,
            'app_env' => config('app.env')
        ]);

        $orderData = [
            'order_id' => $order->order_number,
            'order_amount' => floatval($order->total_amount),
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => $order->user_id ? 'user_' . $order->user_id : 'guest_' . $order->id,
                'customer_name' => $order->billing_address['full_name'] ?? 'Guest User',
                'customer_email' => $order->billing_address['email'] ?? 'guest@example.com',
                'customer_phone' => $order->billing_address['phone'] ?? '9999999999',
            ],
            'order_meta' => [
                'return_url' => route('payment.success', $order->id),
                'notify_url' => route('webhook.cashfree'),
            ]
        ];

        // Create order first
        $orderResponse = $this->makeCashfreeApiCall($baseUrl . '/orders', $orderData, $appId, $secretKey);

        if (!$orderResponse || !isset($orderResponse['order_token'])) {
            throw new \Exception('Failed to create Cashfree order');
        }

        // Create payment session
        $sessionData = [
            'order_token' => $orderResponse['order_token'],
            'order_id' => $order->order_number,
        ];

        $sessionResponse = $this->makeCashfreeApiCall($baseUrl . '/orders/sessions', $sessionData, $appId, $secretKey);

        if (!$sessionResponse || !isset($sessionResponse['payment_link'])) {
            throw new \Exception('Failed to create Cashfree payment session');
        }

        return $sessionResponse;
    }

    /**
     * Make API call to Cashfree
     */
    private function makeCashfreeApiCall($url, $data, $appId, $secretKey)
    {
        $headers = [
            'Content-Type: application/json',
            'x-api-version: 2023-08-01',
            'x-client-id: ' . $appId,
            'x-client-secret: ' . $secretKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            \Log::error('Cashfree API call failed', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $response
            ]);

            // Try to extract error message from response
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['message'] ?? 'API call failed';

            throw new \Exception($errorMessage);
        }

        return json_decode($response, true);
    }

    /**
     * Save user address from checkout form
     */
    private function saveUserAddress(Request $request, int $userId)
    {
        // Check if this exact address already exists for the user
        $existingAddress = UserAddress::where('user_id', $userId)
            ->where('full_name', $request->full_name)
            ->where('phone', $request->phone)
            ->where('address_line_1', $request->address)
            ->where('city', $request->city)
            ->where('state', $request->state)
            ->where('pincode', $request->pincode)
            ->first();

        if (!$existingAddress) {
            // Create new address
            $address = UserAddress::create([
                'user_id' => $userId,
                'type' => 'both', // Can be used for both shipping and billing
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address_line_1' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => 'India',
                'is_default' => false, // Don't auto-set as default
            ]);

            // If this is the user's first address, make it default
            $addressCount = UserAddress::where('user_id', $userId)->count();
            if ($addressCount === 1) {
                $address->setAsDefault();
            }
        }
    }
}
