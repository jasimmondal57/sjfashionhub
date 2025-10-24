<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    /**
     * Get refund reasons
     */
    public function reasonList(Request $request)
    {
        $reasons = [
            ['id' => 1, 'reason' => 'Product damaged during shipping'],
            ['id' => 2, 'reason' => 'Wrong item received'],
            ['id' => 3, 'reason' => 'Product not as described'],
            ['id' => 4, 'reason' => 'Product defective/faulty'],
            ['id' => 5, 'reason' => 'Size/fit issues'],
            ['id' => 6, 'reason' => 'Color different from image'],
            ['id' => 7, 'reason' => 'Quality not satisfactory'],
            ['id' => 8, 'reason' => 'Missing parts/accessories'],
            ['id' => 9, 'reason' => 'Changed mind'],
            ['id' => 10, 'reason' => 'Other']
        ];

        return response()->json([
            'success' => true,
            'data' => $reasons
        ]);
    }

    /**
     * Create refund request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'reason_id' => 'required|integer',
            'reason_text' => 'nullable|string|max:500',
            'description' => 'required|string|max:1000',
            'refund_amount' => 'required|numeric|min:0',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::where('id', $request->order_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Check if order is eligible for refund
        if ($order->delivery_status !== 'delivered') {
            return response()->json([
                'success' => false,
                'message' => 'Order must be delivered before requesting refund'
            ], 400);
        }

        // Check if refund period is valid (e.g., within 30 days)
        $deliveredAt = $order->delivered_at ?? $order->updated_at;
        if ($deliveredAt->diffInDays(now()) > 30) {
            return response()->json([
                'success' => false,
                'message' => 'Refund period has expired (30 days from delivery)'
            ], 400);
        }

        // Check if refund amount is valid
        if ($request->refund_amount > $order->total_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Refund amount cannot exceed order total'
            ], 400);
        }

        // Check if refund already exists
        $existingRefund = Refund::where('order_id', $order->id)->first();
        if ($existingRefund) {
            return response()->json([
                'success' => false,
                'message' => 'Refund request already exists for this order'
            ], 400);
        }

        try {
            // Handle image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('refund_images', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Get reason text
            $reasons = [
                1 => 'Product damaged during shipping',
                2 => 'Wrong item received',
                3 => 'Product not as described',
                4 => 'Product defective/faulty',
                5 => 'Size/fit issues',
                6 => 'Color different from image',
                7 => 'Quality not satisfactory',
                8 => 'Missing parts/accessories',
                9 => 'Changed mind',
                10 => 'Other'
            ];

            $reasonText = $reasons[$request->reason_id] ?? 'Other';
            if ($request->reason_id == 10 && $request->reason_text) {
                $reasonText = $request->reason_text;
            }

            // Create refund request
            $refund = Refund::create([
                'order_id' => $order->id,
                'user_id' => $request->user()->id,
                'refund_number' => 'REF-' . time() . '-' . rand(1000, 9999),
                'reason' => $reasonText,
                'description' => $request->description,
                'refund_amount' => $request->refund_amount,
                'images' => $imagePaths,
                'status' => 'pending',
                'requested_at' => now()
            ]);

            // Update order status
            $order->update([
                'refund_status' => 'requested'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Refund request submitted successfully',
                'data' => [
                    'refund_id' => $refund->id,
                    'refund_number' => $refund->refund_number,
                    'status' => $refund->status,
                    'refund_amount' => number_format($refund->refund_amount, 2),
                    'estimated_processing_time' => '3-7 business days'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create refund request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's refund requests
     */
    public function index(Request $request)
    {
        $refunds = Refund::where('user_id', $request->user()->id)
            ->with(['order'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $formattedRefunds = $refunds->getCollection()->map(function ($refund) {
            return $this->formatRefund($refund);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedRefunds,
            'pagination' => [
                'current_page' => $refunds->currentPage(),
                'last_page' => $refunds->lastPage(),
                'per_page' => $refunds->perPage(),
                'total' => $refunds->total(),
            ]
        ]);
    }

    /**
     * Format refund data for API response
     */
    private function formatRefund($refund)
    {
        $images = collect($refund->images ?? [])->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'id' => $refund->id,
            'refund_number' => $refund->refund_number,
            'order_id' => $refund->order_id,
            'order_number' => $refund->order->order_number,
            'reason' => $refund->reason,
            'description' => $refund->description,
            'refund_amount' => number_format($refund->refund_amount, 2),
            'status' => $refund->status,
            'images' => $images,
            'requested_at' => $refund->requested_at->format('Y-m-d H:i:s'),
            'processed_at' => $refund->processed_at ? $refund->processed_at->format('Y-m-d H:i:s') : null,
            'admin_notes' => $refund->admin_notes
        ];
    }
}
