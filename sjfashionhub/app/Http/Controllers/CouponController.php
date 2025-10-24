<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    /**
     * Validate coupon code (public endpoint for checkout)
     */
    public function validateCode(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'order_amount' => 'nullable|numeric|min:0'
            ]);

            $coupon = Coupon::where('code', strtoupper($request->code))->first();

            if (!$coupon) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Invalid coupon code.'
                ], 404);
            }

            if (!$coupon->isValid()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon is no longer valid.'
                ], 400);
            }

            $orderAmount = $request->order_amount ?? 0;
            if (!$coupon->canBeUsedBy(null, $orderAmount)) {
                $message = 'This coupon cannot be applied to your order.';
                if ($coupon->minimum_amount && $orderAmount < $coupon->minimum_amount) {
                    $message = "Minimum order amount of ₹{$coupon->minimum_amount} required.";
                }

                return response()->json([
                    'valid' => false,
                    'message' => $message
                ], 400);
            }

            $discount = $coupon->calculateDiscount($orderAmount);

            return response()->json([
                'valid' => true,
                'coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'formatted_value' => $coupon->formatted_value,
                    'discount_amount' => $discount
                ],
                'message' => "Coupon applied! You save ₹{$discount}"
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid request data.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Coupon validation error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'valid' => false,
                'message' => 'An error occurred while validating the coupon. Please try again.'
            ], 500);
        }
    }
}
