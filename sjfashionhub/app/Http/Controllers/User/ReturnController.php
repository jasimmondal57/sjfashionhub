<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReturnController extends Controller
{
    /**
     * Show return request form
     */
    public function create(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        // Check if order is delivered
        if ($order->order_status !== 'delivered') {
            return redirect()->route('user.orders')->with('error', 'Only delivered orders can be returned.');
        }

        // Check if return period is still valid (7 days)
        $deliveredDays = $order->delivered_at ? $order->delivered_at->diffInDays(now()) : 999;
        if ($deliveredDays > 7) {
            return redirect()->route('user.orders')->with('error', 'Return period has expired. Returns are only allowed within 7 days of delivery.');
        }

        // Check if return request already exists
        $existingReturn = ReturnOrder::where('order_id', $order->id)->first();
        if ($existingReturn) {
            return redirect()->route('user.returns.show', $existingReturn)->with('info', 'Return request already exists for this order.');
        }

        $order->load('items.product');
        
        return view('user.returns.create', compact('order'));
    }

    /**
     * Store return request
     */
    public function store(Request $request, Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $request->validate([
            'return_reason' => 'required|string|max:255',
            'customer_notes' => 'nullable|string|max:1000',
            'return_items' => 'required|array',
            'return_items.*' => 'required|integer|exists:order_items,id',
            'return_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'refund_method' => 'required_if:payment_method,cod|in:bank_transfer',
            'bank_account_number' => 'required_if:refund_method,bank_transfer|string|max:20',
            'bank_ifsc_code' => 'required_if:refund_method,bank_transfer|string|max:11',
            'bank_account_holder' => 'required_if:refund_method,bank_transfer|string|max:100',
            'bank_name' => 'required_if:refund_method,bank_transfer|string|max:100'
        ]);

        // Calculate return amount
        $returnAmount = 0;
        $returnItems = [];
        
        foreach ($request->return_items as $itemId) {
            $orderItem = $order->items()->find($itemId);
            if ($orderItem) {
                $returnAmount += $orderItem->total_price;
                $returnItems[] = [
                    'order_item_id' => $orderItem->id,
                    'product_name' => $orderItem->product_name,
                    'quantity' => $orderItem->quantity,
                    'unit_price' => $orderItem->unit_price,
                    'total_price' => $orderItem->total_price
                ];
            }
        }

        // Handle image uploads
        $returnImages = [];
        if ($request->hasFile('return_images')) {
            foreach ($request->file('return_images') as $image) {
                $path = $image->store('returns', 'public');
                $returnImages[] = $path;
            }
        }

        // Prepare refund details for COD orders
        $refundDetails = null;
        if ($order->payment_method === 'cod' && $request->refund_method === 'bank_transfer') {
            $refundDetails = [
                'method' => 'bank_transfer',
                'bank_account_number' => $request->bank_account_number,
                'bank_ifsc_code' => $request->bank_ifsc_code,
                'bank_account_holder' => $request->bank_account_holder,
                'bank_name' => $request->bank_name
            ];
        }

        // Create return request
        $returnOrder = ReturnOrder::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'return_type' => 'refund',
            'return_reason' => $request->return_reason,
            'customer_notes' => $request->customer_notes,
            'return_items' => $returnItems,
            'return_amount' => $returnAmount,
            'return_images' => $returnImages,
            'refund_method' => $order->payment_method === 'cod' ? 'bank_transfer' : 'original_payment',
            'refund_details' => $refundDetails
        ]);

        // Generate return number
        $returnOrder->update([
            'return_number' => $returnOrder->generateReturnNumber()
        ]);

        return redirect()->route('user.returns.show', $returnOrder)->with('success', 'Return request submitted successfully. We will review your request and get back to you soon.');
    }

    /**
     * Show return request details
     */
    public function show(ReturnOrder $returnOrder)
    {
        // Ensure the return belongs to the authenticated user
        if ($returnOrder->user_id !== Auth::id()) {
            abort(404);
        }

        $returnOrder->load(['order.items.product', 'user']);
        
        return view('user.returns.show', compact('returnOrder'));
    }

    /**
     * List user's return requests
     */
    public function index()
    {
        $user = Auth::user();
        $returns = ReturnOrder::where('user_id', $user->id)
                             ->with(['order'])
                             ->latest()
                             ->paginate(10);

        return view('user.returns.index', compact('returns'));
    }

    /**
     * Cancel return request
     */
    public function cancel(ReturnOrder $returnOrder)
    {
        // Ensure the return belongs to the authenticated user
        if ($returnOrder->user_id !== Auth::id()) {
            abort(404);
        }

        // Check if return can be cancelled
        if ($returnOrder->status !== 'pending') {
            return back()->with('error', 'Return request cannot be cancelled at this stage.');
        }

        $returnOrder->update([
            'status' => 'cancelled',
            'admin_notes' => 'Cancelled by customer'
        ]);

        return back()->with('success', 'Return request cancelled successfully.');
    }
}
