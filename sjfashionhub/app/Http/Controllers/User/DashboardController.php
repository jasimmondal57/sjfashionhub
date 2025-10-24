<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class DashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Get dashboard statistics
        $stats = [
            'total_orders' => $user->orders()->count(),
            'cart_items' => $user->carts()->count(),
            'wishlist_items' => $user->wishlists()->count(),
            'total_spent' => $user->orders()->where('payment_status', 'completed')->sum('total_amount'),
        ];

        return view('user.dashboard.index', compact('user', 'stats'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.dashboard.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'regex:/^[+][0-9]{10,15}$/', 'unique:users,phone,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Show user orders
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['items.product', 'items.productVariant'])->latest()->paginate(10);

        return view('user.dashboard.orders', compact('orders'));
    }

    /**
     * Show order details
     */
    public function orderDetails(\App\Models\Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        $order->load(['items.product', 'items.productVariant']);

        return view('user.dashboard.order-details', compact('order'));
    }



    /**
     * Cancel an order
     */
    public function cancelOrder(Request $request, \App\Models\Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        // Check if order can be cancelled
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:255'
        ]);

        $order->update([
            'order_status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_at' => now()
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Show user wishlist
     */
    public function wishlist()
    {
        $user = Auth::user();
        $wishlistItems = $user->wishlists()->with('product')->latest()->paginate(12);

        return view('user.dashboard.wishlist', compact('wishlistItems'));
    }
}
