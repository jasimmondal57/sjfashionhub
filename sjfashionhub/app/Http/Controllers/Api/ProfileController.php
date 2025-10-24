<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Update user information
     */
    public function updateInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $user->update($request->only([
                'name', 'email', 'phone', 'date_of_birth', 'gender',
                'address', 'city', 'state', 'country', 'postal_code'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $this->formatUser($user)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $photo = $request->file('photo');
            $filename = 'profile_photos/' . Str::random(40) . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('profile_photos', basename($filename), 'public');

            // Update user record
            $user->update(['profile_photo' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully',
                'data' => [
                    'profile_photo_url' => asset('storage/' . $path)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get customer data
     */
    public function getCustomerData(Request $request)
    {
        $user = $request->user();
        
        // Load relationships
        $user->load(['addresses', 'orders', 'wishlist', 'reviews']);

        $data = $this->formatUser($user);
        
        // Add additional customer data
        $data['statistics'] = [
            'total_orders' => $user->orders->count(),
            'completed_orders' => $user->orders->where('status', 'completed')->count(),
            'total_spent' => $user->orders->where('payment_status', 'completed')->sum('total_amount'),
            'wishlist_items' => $user->wishlist->count(),
            'reviews_given' => $user->reviews->count(),
            'member_since' => $user->created_at->format('Y-m-d')
        ];

        $data['preferences'] = [
            'newsletter_subscription' => $user->newsletter_subscription ?? true,
            'sms_notifications' => $user->sms_notifications ?? false,
            'email_notifications' => $user->email_notifications ?? true,
            'preferred_language' => $user->preferred_language ?? 'en',
            'preferred_currency' => $user->preferred_currency ?? 'USD'
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Format user data for API response
     */
    private function formatUser($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'date_of_birth' => $user->date_of_birth,
            'gender' => $user->gender,
            'address' => $user->address,
            'city' => $user->city,
            'state' => $user->state,
            'country' => $user->country,
            'postal_code' => $user->postal_code,
            'profile_photo_url' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
