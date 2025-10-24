<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Get user's coupons
     */
    public function myCoupons(Request $request)
    {
        $user = $request->user();
        
        // Get user's available coupons
        $userCoupons = UserCoupon::where('user_id', $user->id)
            ->where('is_used', false)
            ->with('coupon')
            ->get()
            ->map(function ($userCoupon) {
                return $this->formatCoupon($userCoupon->coupon, $userCoupon);
            });

        // Get public coupons that user can use
        $publicCoupons = Coupon::where('status', 'active')
            ->where('is_public', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->whereDoesntHave('userCoupons', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get()
            ->map(function ($coupon) {
                return $this->formatCoupon($coupon);
            });

        $allCoupons = $userCoupons->concat($publicCoupons);

        return response()->json([
            'success' => true,
            'data' => $allCoupons
        ]);
    }

    /**
     * Delete/Remove coupon from user's collection
     */
    public function deleteCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required|exists:coupons,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $userCoupon = UserCoupon::where('user_id', $request->user()->id)
            ->where('coupon_id', $request->coupon_id)
            ->first();

        if (!$userCoupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not found in your collection'
            ], 404);
        }

        if ($userCoupon->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete used coupon'
            ], 400);
        }

        $userCoupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed from your collection'
        ]);
    }

    /**
     * Validate coupon code
     */
    public function validateCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'cart_total' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $coupon = Coupon::where('code', $request->code)
            ->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ], 400);
        }

        // Check usage limits
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit exceeded'
            ], 400);
        }

        // Check minimum order amount
        if ($coupon->minimum_amount && $request->cart_total < $coupon->minimum_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of $" . number_format($coupon->minimum_amount, 2) . " required"
            ], 400);
        }

        // Check if user has already used this coupon (for single-use coupons)
        if ($coupon->usage_limit_per_user) {
            $userUsageCount = UserCoupon::where('user_id', $request->user()->id)
                ->where('coupon_id', $coupon->id)
                ->where('is_used', true)
                ->count();

            if ($userUsageCount >= $coupon->usage_limit_per_user) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already used this coupon'
                ], 400);
            }
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($request->cart_total * $coupon->value) / 100;
            if ($coupon->maximum_discount && $discount > $coupon->maximum_discount) {
                $discount = $coupon->maximum_discount;
            }
        } else {
            $discount = min($coupon->value, $request->cart_total);
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon is valid',
            'data' => [
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'title' => $coupon->title,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount_amount' => number_format($discount, 2),
                'final_total' => number_format($request->cart_total - $discount, 2)
            ]
        ]);
    }

    /**
     * Format coupon data for API response
     */
    private function formatCoupon($coupon, $userCoupon = null)
    {
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = $coupon->value . '%';
        } else {
            $discount = '$' . number_format($coupon->value, 2);
        }

        return [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'title' => $coupon->title,
            'description' => $coupon->description,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount_display' => $discount,
            'minimum_amount' => $coupon->minimum_amount,
            'maximum_discount' => $coupon->maximum_discount,
            'starts_at' => $coupon->starts_at->format('Y-m-d H:i:s'),
            'expires_at' => $coupon->expires_at->format('Y-m-d H:i:s'),
            'is_expired' => $coupon->expires_at < now(),
            'days_left' => max(0, $coupon->expires_at->diffInDays(now())),
            'usage_limit' => $coupon->usage_limit,
            'used_count' => $coupon->used_count,
            'is_public' => $coupon->is_public,
            'is_used' => $userCoupon ? $userCoupon->is_used : false,
            'user_coupon_id' => $userCoupon ? $userCoupon->id : null,
            'terms_and_conditions' => $coupon->terms_and_conditions
        ];
    }
}
