<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Show payment page for an order
     */
    public function show($orderId)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($orderId);

        // Check if order is already paid
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $order->id)
                ->with('message', 'This order has already been paid.');
        }

        // Check if payment is expired (30 minutes)
        if ($order->created_at->diffInMinutes(now()) > 30 && $order->payment_status === 'pending') {
            return view('payment.expired', compact('order'));
        }

        // Get active payment gateways
        $paymentGateways = PaymentGateway::where('is_active', true)
            ->where('type', 'online')
            ->orderBy('sort_order')
            ->get();

        return view('payment.show', compact('order', 'paymentGateways'));
    }

    /**
     * Process payment
     */
    public function process(Request $request, $orderId)
    {
        $request->validate([
            'payment_gateway' => 'required|string'
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $order->id)
                ->with('message', 'This order has already been paid.');
        }

        $gateway = PaymentGateway::where('name', $request->payment_gateway)
            ->where('is_active', true)
            ->firstOrFail();

        // For now, simulate payment success (integrate with actual gateway later)
        // In production, this would redirect to gateway or process payment

        if ($request->payment_gateway === 'razorpay') {
            return $this->processRazorpay($order, $gateway);
        } elseif ($request->payment_gateway === 'cashfree') {
            return $this->processCashfree($order, $gateway);
        } elseif ($request->payment_gateway === 'cod') {
            return $this->processCOD($order);
        }

        // Default: mark as pending and show instructions
        return view('payment.pending', compact('order', 'gateway'));
    }

    /**
     * Process Razorpay payment
     */
    protected function processRazorpay($order, $gateway)
    {
        $credentials = $gateway->credentials ?? [];
        $keyId = $credentials['key_id'] ?? null;

        if (!$keyId) {
            return back()->with('error', 'Payment gateway not configured properly.');
        }

        // Generate Razorpay order
        // This is a placeholder - integrate with actual Razorpay SDK

        return view('payment.razorpay', compact('order', 'keyId'));
    }

    /**
     * Process Cashfree payment
     */
    protected function processCashfree($order, $gateway)
    {
        $credentials = $gateway->decrypted_credentials ?? [];
        $appId = $credentials['app_id'] ?? null;
        $secretKey = $credentials['secret_key'] ?? null;

        if (!$appId || !$secretKey) {
            return back()->with('error', 'Cashfree payment gateway not configured properly.');
        }

        // Prepare Cashfree payment data
        $paymentData = [
            'order_id' => $order->order_number,
            'order_amount' => $order->total_amount,
            'order_currency' => $order->currency ?? 'INR',
            'customer_details' => [
                'customer_id' => $order->user_id ?? 'guest_' . $order->id,
                'customer_name' => $order->billing_address['full_name'] ?? 'Guest User',
                'customer_email' => $order->billing_address['email'] ?? 'guest@example.com',
                'customer_phone' => $order->billing_address['phone'] ?? '9999999999',
            ],
            'order_meta' => [
                'return_url' => route('payment.success', $order->id),
                'notify_url' => route('webhook.cashfree'),
            ]
        ];

        return view('payment.cashfree', compact('order', 'appId', 'paymentData'));
    }

    /**
     * Process COD payment
     */
    protected function processCOD($order)
    {
        // For COD, mark order as confirmed and clear cart
        $order->update([
            'payment_status' => 'pending', // COD payments are pending until delivery
            'order_status' => 'confirmed'
        ]);

        // Clear cart after COD order confirmation
        \App\Models\Cart::clearCart();

        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Order placed successfully! You can pay cash on delivery.');
    }

    /**
     * Payment success callback
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order status to paid if not already updated by webhook
        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);
        }

        // Clear cart after successful payment
        \App\Models\Cart::clearCart();

        return view('payment.success', compact('order'));
    }

    /**
     * Payment failure callback
     */
    public function failure($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('payment.failure', compact('order'));
    }

    /**
     * COD fallback when online payment fails
     */
    public function codFallback($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order to COD
        $order->update([
            'payment_method' => 'cod',
            'payment_status' => 'pending'
        ]);

        // Clear cart
        \App\Models\Cart::clearCart();

        // Redirect to success page
        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Order confirmed with Cash on Delivery payment method!');
    }

    /**
     * Update payment status
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:paid,failed,pending'
        ]);

        $order = Order::findOrFail($request->order_id);

        $order->update([
            'payment_status' => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : null
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Razorpay webhook
     */
    public function razorpayWebhook(Request $request)
    {
        try {
            // Verify webhook signature
            $webhookSecret = config('services.razorpay.webhook_secret');
            $signature = $request->header('X-Razorpay-Signature');
            
            $payload = $request->getContent();
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);

            if ($signature !== $expectedSignature) {
                Log::warning('Invalid Razorpay webhook signature');
                return response()->json(['status' => 'invalid signature'], 400);
            }

            $data = $request->all();
            $event = $data['event'] ?? null;

            if ($event === 'payment.captured') {
                $paymentId = $data['payload']['payment']['entity']['id'] ?? null;
                $orderId = $data['payload']['payment']['entity']['notes']['order_id'] ?? null;

                if ($orderId) {
                    $order = Order::find($orderId);
                    
                    if ($order) {
                        $order->update([
                            'payment_status' => 'paid',
                            'transaction_id' => $paymentId,
                            'paid_at' => now()
                        ]);

                        Log::info('Razorpay payment captured', ['order_id' => $orderId]);
                    }
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Razorpay webhook error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Cashfree webhook
     */
    public function cashfreeWebhook(Request $request)
    {
        try {
            Log::info('Cashfree webhook received', [
                'headers' => $request->headers->all(),
                'payload' => $request->all()
            ]);

            // Get webhook data
            $data = $request->all();

            // Verify webhook signature
            if (!$this->verifyCashfreeSignature($request)) {
                Log::warning('Invalid Cashfree webhook signature');
                return response()->json(['status' => 'invalid signature'], 400);
            }

            $eventType = $data['type'] ?? null;

            if ($eventType === 'PAYMENT_SUCCESS_WEBHOOK') {
                $orderId = $data['data']['order']['order_id'] ?? null;
                $paymentId = $data['data']['payment']['cf_payment_id'] ?? null;
                $orderAmount = $data['data']['order']['order_amount'] ?? null;
                $paymentStatus = $data['data']['payment']['payment_status'] ?? null;

                Log::info('Cashfree payment webhook', [
                    'event_type' => $eventType,
                    'order_id' => $orderId,
                    'payment_id' => $paymentId,
                    'payment_status' => $paymentStatus,
                    'amount' => $orderAmount
                ]);

                if ($orderId && $paymentStatus === 'SUCCESS') {
                    $order = Order::find($orderId);

                    if ($order) {
                        $order->update([
                            'payment_status' => 'paid',
                            'transaction_id' => $paymentId,
                            'paid_at' => now()
                        ]);

                        Log::info('Cashfree payment success processed', [
                            'order_id' => $orderId,
                            'payment_id' => $paymentId
                        ]);
                    } else {
                        Log::warning('Cashfree webhook: Order not found', ['order_id' => $orderId]);
                    }
                }
            } elseif ($eventType === 'PAYMENT_FAILED_WEBHOOK') {
                $orderId = $data['data']['order']['order_id'] ?? null;
                $paymentId = $data['data']['payment']['cf_payment_id'] ?? null;
                $failureReason = $data['data']['payment']['failure_reason'] ?? 'Unknown';

                Log::info('Cashfree payment failed', [
                    'order_id' => $orderId,
                    'payment_id' => $paymentId,
                    'failure_reason' => $failureReason
                ]);

                if ($orderId) {
                    $order = Order::find($orderId);

                    if ($order) {
                        $order->update([
                            'payment_status' => 'failed',
                            'transaction_id' => $paymentId,
                            'payment_notes' => 'Payment failed: ' . $failureReason
                        ]);

                        Log::info('Cashfree payment failure processed', [
                            'order_id' => $orderId,
                            'failure_reason' => $failureReason
                        ]);
                    }
                }
            } else {
                Log::info('Cashfree webhook: Unhandled event type', ['event_type' => $eventType]);
            }

            // Always return success to acknowledge receipt
            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('Cashfree webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            // Return success even on error to prevent retries
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Test endpoint for Cashfree webhook
     */
    public function cashfreeWebhookTest()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Cashfree webhook endpoint is working',
            'webhook_url' => route('webhook.cashfree'),
            'timestamp' => now()->toISOString(),
            'supported_events' => [
                'PAYMENT_SUCCESS_WEBHOOK',
                'PAYMENT_FAILED_WEBHOOK'
            ],
            'expected_headers' => [
                'Content-Type: application/json',
                'x-webhook-signature: <signature>',
                'x-webhook-timestamp: <timestamp>'
            ],
            'sample_payload' => [
                'type' => 'PAYMENT_SUCCESS_WEBHOOK',
                'data' => [
                    'order' => [
                        'order_id' => 'your_order_id',
                        'order_amount' => 100.00
                    ],
                    'payment' => [
                        'cf_payment_id' => 'cashfree_payment_id',
                        'payment_status' => 'SUCCESS'
                    ]
                ]
            ]
        ], 200);
    }

    /**
     * Verify Cashfree webhook signature
     */
    private function verifyCashfreeSignature(Request $request)
    {
        try {
            // Get the signature from headers
            $receivedSignature = $request->header('x-webhook-signature');
            $timestamp = $request->header('x-webhook-timestamp');

            if (!$receivedSignature) {
                Log::warning('Cashfree webhook: No signature provided');
                return false;
            }

            // Get Cashfree webhook secret from payment gateway configuration
            $cashfreeGateway = PaymentGateway::where('name', 'cashfree')->first();

            if (!$cashfreeGateway || !$cashfreeGateway->credentials) {
                Log::warning('Cashfree webhook: Gateway not configured');
                return false;
            }

            $credentials = $cashfreeGateway->decrypted_credentials;
            $webhookSecret = $credentials['webhook_secret'] ?? null;

            if (!$webhookSecret) {
                Log::warning('Cashfree webhook: No webhook secret configured');
                return false;
            }

            // Get raw payload
            $payload = $request->getContent();
            $data = json_decode($payload, true);

            if (!$data) {
                Log::warning('Cashfree webhook: Invalid JSON payload');
                return false;
            }

            // Sort the data by keys (as per Cashfree documentation)
            ksort($data);

            // Concatenate all values
            $postDataString = '';
            foreach ($data as $value) {
                if (is_array($value) || is_object($value)) {
                    $postDataString .= json_encode($value);
                } else {
                    $postDataString .= $value;
                }
            }

            // Generate HMAC signature
            $expectedSignature = base64_encode(hash_hmac('sha256', $postDataString, $webhookSecret, true));

            Log::info('Cashfree signature verification', [
                'received_signature' => $receivedSignature,
                'expected_signature' => $expectedSignature,
                'post_data_string' => $postDataString,
                'webhook_secret_length' => strlen($webhookSecret)
            ]);

            // Compare signatures
            $isValid = hash_equals($expectedSignature, $receivedSignature);

            if (!$isValid) {
                Log::warning('Cashfree webhook signature mismatch', [
                    'received' => $receivedSignature,
                    'expected' => $expectedSignature
                ]);
            }

            return $isValid;

        } catch (\Exception $e) {
            Log::error('Cashfree signature verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Handle PayU success callback
     */
    public function payuSuccess(Request $request)
    {
        try {
            \Log::info('PayU Success Callback', [
                'request_data' => $request->all(),
                'user_authenticated' => \Auth::check(),
                'session_id' => session()->getId(),
                'user_agent' => $request->header('User-Agent')
            ]);

            // Get PayU gateway for salt verification
            $payuGateway = \App\Models\PaymentGateway::where('name', 'payu')
                ->where('is_active', true)
                ->first();

            if (!$payuGateway) {
                \Log::error('PayU gateway not found or not active');
                return redirect()->route('checkout.index')->with('error', 'Payment gateway configuration error.');
            }

            $credentials = $payuGateway->decrypted_credentials ?? [];
            $merchantSalt = $credentials['merchant_salt'] ?? null;

            if (!$merchantSalt) {
                \Log::error('PayU merchant salt not configured');
                return redirect()->route('checkout.index')->with('error', 'Payment gateway configuration error.');
            }

            // Verify PayU response hash
            if (!$this->verifyPayUHash($request->all(), $merchantSalt)) {
                \Log::error('PayU hash verification failed', $request->all());
                return redirect()->route('checkout.index')->with('error', 'Payment verification failed.');
            }

            // Find order by transaction ID
            $txnid = $request->input('txnid');
            $order = \App\Models\Order::where('transaction_id', $txnid)->first();

            // If not found by transaction_id, try to extract order ID from txnid format (TXN{order_id}_{timestamp})
            if (!$order && preg_match('/^TXN(\d+)_\d+$/', $txnid, $matches)) {
                $orderId = $matches[1];
                $order = \App\Models\Order::find($orderId);

                if ($order) {
                    // Update the order with the correct transaction ID
                    $order->update(['transaction_id' => $txnid]);
                    \Log::info('Order found by ID and transaction_id updated', [
                        'order_id' => $orderId,
                        'txnid' => $txnid
                    ]);
                }
            }

            if (!$order) {
                \Log::error('Order not found for PayU transaction', [
                    'txnid' => $txnid,
                    'extracted_order_id' => $matches[1] ?? 'none'
                ]);
                return redirect()->route('checkout.index')->with('error', 'Order not found.');
            }

            // Check payment status
            $status = $request->input('status');
            $amount = $request->input('amount');
            $payuMoneyId = $request->input('payuMoneyId');

            if ($status === 'success' && $amount == $order->total_amount) {
                // Payment successful
                $order->update([
                    'payment_status' => 'paid',
                    'payment_gateway' => 'payu',
                    'transaction_id' => $payuMoneyId ?: $txnid,
                    'paid_at' => now(),
                    'order_status' => 'confirmed'
                ]);

                // Clear cart for the order's user/session
                $this->clearCartForOrder($order);

                \Log::info('PayU payment successful', [
                    'order_id' => $order->id,
                    'txnid' => $txnid,
                    'payuMoneyId' => $payuMoneyId,
                    'amount' => $amount
                ]);

                // Generate success token for secure access
                $successToken = hash('sha256', $order->id . $order->order_number . $order->created_at);

                \Log::info('Redirecting to success page', [
                    'route' => 'checkout.success',
                    'order_id' => $order->id,
                    'redirect_url' => route('checkout.success', ['order' => $order->id, 'token' => $successToken])
                ]);

                return redirect()->route('checkout.success', [
                    'order' => $order->id,
                    'token' => $successToken
                ])->with('success', 'Payment successful! Your order has been confirmed.');
            } else {
                // Payment failed or amount mismatch
                \Log::warning('PayU payment failed or amount mismatch', [
                    'order_id' => $order->id,
                    'status' => $status,
                    'expected_amount' => $order->total_amount,
                    'received_amount' => $amount
                ]);

                return redirect()->route('checkout.index')
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            \Log::error('PayU success callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'Payment processing error. Please contact support.');
        }
    }

    /**
     * Handle PayU failure callback
     */
    public function payuFailure(Request $request)
    {
        try {
            \Log::info('PayU Failure Callback', $request->all());

            $txnid = $request->input('txnid');
            $error = $request->input('error');
            $errorMessage = $request->input('error_Message');

            // Find order by transaction ID
            $order = \App\Models\Order::where('transaction_id', $txnid)->first();

            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_gateway' => 'payu'
                ]);

                \Log::info('PayU payment failed', [
                    'order_id' => $order->id,
                    'txnid' => $txnid,
                    'error' => $error,
                    'error_message' => $errorMessage
                ]);
            }

            return redirect()->route('checkout.index')
                ->with('error', 'Payment failed: ' . ($errorMessage ?: 'Unknown error. Please try again.'));

        } catch (\Exception $e) {
            \Log::error('PayU failure callback error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->route('checkout.index')
                ->with('error', 'Payment processing error. Please try again.');
        }
    }

    /**
     * Verify PayU response hash
     */
    private function verifyPayUHash($response, $merchantSalt)
    {
        $status = $response['status'] ?? '';
        $firstname = $response['firstname'] ?? '';
        $amount = $response['amount'] ?? '';
        $txnid = $response['txnid'] ?? '';
        $hash = $response['hash'] ?? '';
        $key = $response['key'] ?? '';
        $productinfo = $response['productinfo'] ?? '';
        $email = $response['email'] ?? '';

        // Generate hash for verification
        $hashString = $merchantSalt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        $calculatedHash = strtolower(hash('sha512', $hashString));

        return hash_equals($calculatedHash, strtolower($hash));
    }

    /**
     * Clear cart for order (works even when user is logged out)
     */
    private function clearCartForOrder($order)
    {
        try {
            // Clear cart based on order's user_id or session_id
            if ($order->user_id) {
                // Clear cart for registered user
                \App\Models\Cart::where('user_id', $order->user_id)->delete();
                \Log::info('Cart cleared for user', ['user_id' => $order->user_id]);
            } else {
                // For guest orders, we can't reliably clear cart since session might be different
                // This is normal behavior for guest checkouts with payment gateways
                \Log::info('Guest order - cart clearing skipped (session may differ)');
            }
        } catch (\Exception $e) {
            \Log::error('Failed to clear cart for order', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

