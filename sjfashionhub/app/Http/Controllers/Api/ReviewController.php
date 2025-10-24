<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Get items waiting for review
     */
    public function waitingForReview(Request $request)
    {
        $user = $request->user();
        
        // Get delivered order items that haven't been reviewed
        $orderItems = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('delivery_status', 'delivered');
            })
            ->whereDoesntHave('review')
            ->with(['product.images', 'order', 'variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $this->formatOrderItemForReview($item);
            });

        return response()->json([
            'success' => true,
            'data' => $orderItems
        ]);
    }

    /**
     * Get user's reviews
     */
    public function myReviews(Request $request)
    {
        $user = $request->user();
        
        $reviews = Review::where('user_id', $user->id)
            ->with(['product.images', 'orderItem.order'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $formattedReviews = $reviews->getCollection()->map(function ($review) {
            return $this->formatReview($review);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedReviews,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ]
        ]);
    }

    /**
     * Submit a review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
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

        $user = $request->user();
        
        // Verify order item belongs to user and is delivered
        $orderItem = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('delivery_status', 'delivered');
            })
            ->where('id', $request->order_item_id)
            ->first();

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found or not eligible for review'
            ], 404);
        }

        // Check if already reviewed
        if ($orderItem->review) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this item'
            ], 400);
        }

        try {
            // Handle image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('review_images', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Create review
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $orderItem->product_id,
                'order_item_id' => $orderItem->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'images' => $imagePaths,
                'status' => 'approved' // Auto-approve for now
            ]);

            // Update product rating
            $this->updateProductRating($orderItem->product_id);

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully',
                'data' => $this->formatReview($review->load(['product.images', 'orderItem.order']))
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a review
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
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

        $review = Review::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        try {
            // Handle image uploads
            $imagePaths = $review->images ?? [];
            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($imagePaths as $oldPath) {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // Upload new images
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('review_images', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Update review
            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'images' => $imagePaths,
                'status' => 'approved' // Auto-approve for now
            ]);

            // Update product rating
            $this->updateProductRating($review->product_id);

            return response()->json([
                'success' => true,
                'message' => 'Review updated successfully',
                'data' => $this->formatReview($review->load(['product.images', 'orderItem.order']))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format order item for review
     */
    private function formatOrderItemForReview($orderItem)
    {
        $product = $orderItem->product;
        $images = $product->images->pluck('image_path')->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'order_item_id' => $orderItem->id,
            'order_id' => $orderItem->order->id,
            'order_number' => $orderItem->order->order_number,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'variant_name' => $orderItem->variant ? $orderItem->variant->name : null,
            'image' => $images[0] ?? null,
            'quantity' => $orderItem->quantity,
            'price' => number_format($orderItem->price, 2),
            'delivered_at' => $orderItem->order->delivered_at ? $orderItem->order->delivered_at->format('Y-m-d H:i:s') : null,
            'days_since_delivery' => $orderItem->order->delivered_at ? $orderItem->order->delivered_at->diffInDays(now()) : null
        ];
    }

    /**
     * Format review data for API response
     */
    private function formatReview($review)
    {
        $product = $review->product;
        $images = $product->images->pluck('image_path')->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        $reviewImages = collect($review->images ?? [])->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'id' => $review->id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'images' => $reviewImages,
            'status' => $review->status,
            'created_at' => $review->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $review->updated_at->format('Y-m-d H:i:s'),
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $images[0] ?? null
            ],
            'order' => [
                'id' => $review->orderItem->order->id,
                'order_number' => $review->orderItem->order->order_number,
                'delivered_at' => $review->orderItem->order->delivered_at ? $review->orderItem->order->delivered_at->format('Y-m-d H:i:s') : null
            ]
        ];
    }

    /**
     * Update product rating based on reviews
     */
    private function updateProductRating($productId)
    {
        $averageRating = Review::where('product_id', $productId)
            ->where('status', 'approved')
            ->avg('rating');

        \App\Models\Product::where('id', $productId)
            ->update(['rating' => round($averageRating, 1)]);
    }
}
