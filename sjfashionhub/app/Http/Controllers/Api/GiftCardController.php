<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use App\Models\UserGiftCard;
use Illuminate\Http\Request;

class GiftCardController extends Controller
{
    /**
     * Get available gift cards
     */
    public function index(Request $request)
    {
        $giftCards = GiftCard::where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('amount')
            ->get()
            ->map(function ($giftCard) {
                return $this->formatGiftCard($giftCard);
            });

        return response()->json([
            'success' => true,
            'data' => $giftCards
        ]);
    }

    /**
     * Get single gift card details
     */
    public function show(Request $request)
    {
        $giftCardId = $request->get('id');
        
        if (!$giftCardId) {
            return response()->json([
                'success' => false,
                'message' => 'Gift card ID is required'
            ], 400);
        }

        $giftCard = GiftCard::where('id', $giftCardId)
            ->where('status', 'active')
            ->first();

        if (!$giftCard) {
            return response()->json([
                'success' => false,
                'message' => 'Gift card not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatGiftCard($giftCard, true)
        ]);
    }

    /**
     * Get user's purchased gift cards
     */
    public function myPurchased(Request $request)
    {
        $userGiftCards = UserGiftCard::where('user_id', $request->user()->id)
            ->with('giftCard')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($userGiftCard) {
                return $this->formatUserGiftCard($userGiftCard);
            });

        return response()->json([
            'success' => true,
            'data' => $userGiftCards
        ]);
    }

    /**
     * Format gift card data for API response
     */
    private function formatGiftCard($giftCard, $detailed = false)
    {
        $data = [
            'id' => $giftCard->id,
            'title' => $giftCard->title,
            'description' => $giftCard->description,
            'amount' => number_format($giftCard->amount, 2),
            'image' => $giftCard->image ? asset('storage/' . $giftCard->image) : null,
            'is_active' => $giftCard->status === 'active',
            'sort_order' => $giftCard->sort_order
        ];

        if ($detailed) {
            $data['terms_and_conditions'] = $giftCard->terms_and_conditions;
            $data['validity_days'] = $giftCard->validity_days;
            $data['is_transferable'] = $giftCard->is_transferable;
            $data['minimum_purchase_amount'] = $giftCard->minimum_purchase_amount;
        }

        return $data;
    }

    /**
     * Format user gift card data for API response
     */
    private function formatUserGiftCard($userGiftCard)
    {
        $giftCard = $userGiftCard->giftCard;
        
        return [
            'id' => $userGiftCard->id,
            'gift_card_id' => $giftCard->id,
            'gift_card_title' => $giftCard->title,
            'code' => $userGiftCard->code,
            'amount' => number_format($userGiftCard->amount, 2),
            'balance' => number_format($userGiftCard->balance, 2),
            'is_used' => $userGiftCard->balance <= 0,
            'is_expired' => $userGiftCard->expires_at < now(),
            'purchased_at' => $userGiftCard->created_at->format('Y-m-d H:i:s'),
            'expires_at' => $userGiftCard->expires_at->format('Y-m-d H:i:s'),
            'days_left' => max(0, $userGiftCard->expires_at->diffInDays(now())),
            'image' => $giftCard->image ? asset('storage/' . $giftCard->image) : null,
            'recipient_name' => $userGiftCard->recipient_name,
            'recipient_email' => $userGiftCard->recipient_email,
            'message' => $userGiftCard->message
        ];
    }
}
