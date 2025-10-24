<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Get user addresses
     */
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', $request->user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($address) {
                return $this->formatAddress($address);
            });

        return response()->json([
            'success' => true,
            'data' => $addresses
        ]);
    }

    /**
     * Store new address
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:home,office,other',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'nullable|boolean'
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
            
            // If this is set as default, remove default from other addresses
            if ($request->boolean('is_default')) {
                Address::where('user_id', $user->id)
                    ->update(['is_default' => false]);
            }

            $address = Address::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'name' => $request->name,
                'phone' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'is_default' => $request->boolean('is_default')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Address added successfully',
                'data' => $this->formatAddress($address)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update address
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:home,office,other',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        try {
            // If this is set as default, remove default from other addresses
            if ($request->boolean('is_default')) {
                Address::where('user_id', $request->user()->id)
                    ->where('id', '!=', $id)
                    ->update(['is_default' => false]);
            }

            $address->update($request->only([
                'type', 'name', 'phone', 'address_line_1', 'address_line_2',
                'city', 'state', 'country', 'postal_code'
            ]));

            if ($request->has('is_default')) {
                $address->update(['is_default' => $request->boolean('is_default')]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
                'data' => $this->formatAddress($address)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete address
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::where('id', $request->address_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }

    /**
     * Set default billing address
     */
    public function setDefaultBilling(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::where('id', $request->address_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        // Update user's default billing address
        $request->user()->update(['default_billing_address_id' => $address->id]);

        return response()->json([
            'success' => true,
            'message' => 'Default billing address updated successfully'
        ]);
    }

    /**
     * Set default shipping address
     */
    public function setDefaultShipping(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:addresses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::where('id', $request->address_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ], 404);
        }

        // Update user's default shipping address
        $request->user()->update(['default_shipping_address_id' => $address->id]);

        return response()->json([
            'success' => true,
            'message' => 'Default shipping address updated successfully'
        ]);
    }

    /**
     * Format address data for API response
     */
    private function formatAddress($address)
    {
        return [
            'id' => $address->id,
            'type' => $address->type,
            'name' => $address->name,
            'phone' => $address->phone,
            'address_line_1' => $address->address_line_1,
            'address_line_2' => $address->address_line_2,
            'city' => $address->city,
            'state' => $address->state,
            'country' => $address->country,
            'postal_code' => $address->postal_code,
            'is_default' => $address->is_default,
            'full_address' => $this->getFullAddress($address),
            'created_at' => $address->created_at->format('Y-m-d H:i:s')
        ];
    }

    /**
     * Get formatted full address
     */
    private function getFullAddress($address)
    {
        $parts = [
            $address->address_line_1,
            $address->address_line_2,
            $address->city,
            $address->state,
            $address->country,
            $address->postal_code
        ];

        return implode(', ', array_filter($parts));
    }
}
