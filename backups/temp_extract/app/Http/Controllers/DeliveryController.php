<?php

namespace App\Http\Controllers;

use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeliveryController extends Controller
{
    protected $shiprocketService;

    public function __construct(ShiprocketService $shiprocketService)
    {
        $this->shiprocketService = $shiprocketService;
    }

    /**
     * Check delivery availability for a pincode
     */
    public function checkPincode(Request $request)
    {
        $request->validate([
            'pincode' => 'required|digits:6',
            'weight' => 'nullable|numeric|min:0.1',
        ]);

        $pincode = $request->pincode;
        $weight = $request->weight ?? 0.5; // Default 0.5 kg

        // Store pincode in session for future use
        Session::put('delivery_pincode', $pincode);

        // Check delivery using Shiprocket
        $result = $this->shiprocketService->checkDelivery($pincode, $weight);

        if ($result['success'] && $result['available']) {
            return response()->json([
                'success' => true,
                'available' => true,
                'estimated_days' => $result['estimated_days'],
                'courier_name' => $result['courier_name'] ?? 'Standard',
                'cod_available' => $result['cod_available'] ?? false,
                'message' => "Delivery available in {$result['estimated_days']} days",
            ]);
        } elseif ($result['success'] && !$result['available']) {
            return response()->json([
                'success' => true,
                'available' => false,
                'message' => 'Sorry, delivery is not available to this pincode',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Unable to check delivery availability',
            ], 500);
        }
    }

    /**
     * Get stored pincode from session
     */
    public function getStoredPincode()
    {
        $pincode = Session::get('delivery_pincode');
        
        return response()->json([
            'pincode' => $pincode,
        ]);
    }
}

