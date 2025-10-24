<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Get payment gateways
     */
    public function gateways(Request $request)
    {
        $gateways = [
            [
                'id' => 'stripe',
                'name' => 'Stripe',
                'description' => 'Pay with credit/debit card via Stripe',
                'logo' => asset('images/payment/stripe.png'),
                'is_active' => true,
                'supported_currencies' => ['USD', 'EUR', 'GBP'],
                'type' => 'card'
            ],
            [
                'id' => 'paypal',
                'name' => 'PayPal',
                'description' => 'Pay with your PayPal account',
                'logo' => asset('images/payment/paypal.png'),
                'is_active' => true,
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'CAD'],
                'type' => 'wallet'
            ],
            [
                'id' => 'razorpay',
                'name' => 'Razorpay',
                'description' => 'Pay with UPI, cards, wallets & more',
                'logo' => asset('images/payment/razorpay.png'),
                'is_active' => true,
                'supported_currencies' => ['INR'],
                'type' => 'gateway'
            ],
            [
                'id' => 'flutterwave',
                'name' => 'Flutterwave',
                'description' => 'Pay with cards, bank transfer & more',
                'logo' => asset('images/payment/flutterwave.png'),
                'is_active' => true,
                'supported_currencies' => ['NGN', 'USD', 'EUR'],
                'type' => 'gateway'
            ],
            [
                'id' => 'paystack',
                'name' => 'Paystack',
                'description' => 'Pay with cards, bank transfer & USSD',
                'logo' => asset('images/payment/paystack.png'),
                'is_active' => true,
                'supported_currencies' => ['NGN', 'USD', 'ZAR'],
                'type' => 'gateway'
            ],
            [
                'id' => 'bank_transfer',
                'name' => 'Bank Transfer',
                'description' => 'Pay via direct bank transfer',
                'logo' => asset('images/payment/bank.png'),
                'is_active' => true,
                'supported_currencies' => ['USD', 'EUR', 'GBP'],
                'type' => 'bank'
            ],
            [
                'id' => 'cod',
                'name' => 'Cash on Delivery',
                'description' => 'Pay when you receive your order',
                'logo' => asset('images/payment/cod.png'),
                'is_active' => true,
                'supported_currencies' => ['USD'],
                'type' => 'cod'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $gateways
        ]);
    }

    /**
     * Get bank information for bank transfer
     */
    public function bankInfo(Request $request)
    {
        $bankInfo = [
            'bank_name' => 'SJ Fashion Hub Bank',
            'account_name' => 'SJ Fashion Hub Ltd',
            'account_number' => '1234567890',
            'routing_number' => '123456789',
            'swift_code' => 'SJFHUS33',
            'iban' => 'US12 3456 7890 1234 5678 90',
            'bank_address' => '123 Banking Street, Finance City, FC 12345',
            'instructions' => [
                'Please use your order number as the payment reference',
                'Transfer the exact amount shown in your order',
                'Upload the transfer receipt after payment',
                'Orders will be processed after payment confirmation'
            ],
            'processing_time' => '1-3 business days',
            'supported_currencies' => ['USD', 'EUR', 'GBP']
        ];

        return response()->json([
            'success' => true,
            'data' => $bankInfo
        ]);
    }

    /**
     * Store bank payment data
     */
    public function storeBankPaymentData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'transaction_reference' => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = \App\Models\Order::where('id', $request->order_id)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receiptPath = $request->file('receipt')->store('payment_receipts', 'public');
            }

            // Create payment record
            $paymentData = [
                'order_id' => $order->id,
                'payment_method' => 'bank_transfer',
                'transaction_reference' => $request->transaction_reference,
                'transfer_date' => $request->transfer_date,
                'amount' => $request->amount,
                'receipt_path' => $receiptPath,
                'notes' => $request->notes,
                'status' => 'pending_verification',
                'created_at' => now()
            ];

            // Store in database (you'll need to create a payments table)
            // For now, we'll update the order with payment info
            $order->update([
                'payment_status' => 'pending_verification',
                'transaction_id' => $request->transaction_reference,
                'payment_gateway' => 'bank_transfer',
                'payment_data' => json_encode($paymentData)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment information submitted successfully. We will verify and process your payment within 1-3 business days.',
                'data' => [
                    'order_id' => $order->id,
                    'transaction_reference' => $request->transaction_reference,
                    'status' => 'pending_verification'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store payment data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
