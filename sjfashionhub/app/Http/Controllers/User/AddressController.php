<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display user addresses
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        return view('user.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address
     */
    public function create()
    {
        return view('user.addresses.create');
    }

    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:shipping,billing,both',
            'label' => 'nullable|string|max:50',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $address = Auth::user()->addresses()->create($request->all());

        if ($request->is_default) {
            $address->setAsDefault();
        }

        return redirect()->route('user.addresses.index')
            ->with('success', 'Address added successfully!');
    }

    /**
     * Show the form for editing an address
     */
    public function edit(UserAddress $address)
    {
        // Ensure user can only edit their own addresses
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address
     */
    public function update(Request $request, UserAddress $address)
    {
        // Ensure user can only update their own addresses
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:shipping,billing,both',
            'label' => 'nullable|string|max:50',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $address->update($request->all());

        if ($request->is_default) {
            $address->setAsDefault();
        }

        return redirect()->route('user.addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    /**
     * Remove the specified address
     */
    public function destroy(UserAddress $address)
    {
        // Ensure user can only delete their own addresses
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('user.addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Set an address as default
     */
    public function setDefault(UserAddress $address)
    {
        // Ensure user can only modify their own addresses
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->setAsDefault();

        return redirect()->route('user.addresses.index')
            ->with('success', 'Default address updated successfully!');
    }

    /**
     * Get addresses for AJAX requests (for checkout)
     */
    public function getAddresses()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        
        return response()->json([
            'addresses' => $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'label' => $address->label,
                    'full_name' => $address->full_name,
                    'phone' => $address->phone,
                    'address_line_1' => $address->address_line_1,
                    'address_line_2' => $address->address_line_2,
                    'city' => $address->city,
                    'state' => $address->state,
                    'pincode' => $address->pincode,
                    'country' => $address->country,
                    'is_default' => $address->is_default,
                    'formatted_address' => $address->formatted_address,
                ];
            })
        ]);
    }
}
