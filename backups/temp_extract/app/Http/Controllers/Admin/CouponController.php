<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Coupon::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active()->valid();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'expired':
                    $query->where('expires_at', '<', Carbon::now());
                    break;
                case 'scheduled':
                    $query->where('starts_at', '>', Carbon::now());
                    break;
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $coupons = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::select('id', 'name', 'sku')->get();

        return view('admin.coupons.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:starts_at',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'excluded_products' => 'nullable|array',
            'excluded_categories' => 'nullable|array',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'stackable' => 'boolean',
            'first_order_only' => 'boolean',
            'priority' => 'nullable|integer|min:0'
        ]);

        // Custom validation for percentage type
        if ($request->type === 'percentage' && $request->value > 100) {
            $validator->after(function ($validator) {
                $validator->errors()->add('value', 'Percentage discount cannot exceed 100%.');
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['code'] = strtoupper($data['code']);
        $data['created_by'] = auth()->user()->name ?? 'Admin';

        // Convert date strings to Carbon instances
        if ($data['starts_at']) {
            $data['starts_at'] = Carbon::parse($data['starts_at']);
        }
        if ($data['expires_at']) {
            $data['expires_at'] = Carbon::parse($data['expires_at']);
        }

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')
                        ->with('success', 'Coupon created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        // Load applicable products and categories from JSON fields
        $applicableProducts = collect();
        $applicableCategories = collect();

        if ($coupon->applicable_products) {
            $applicableProducts = Product::whereIn('id', $coupon->applicable_products)->get();
        }

        if ($coupon->applicable_categories) {
            $applicableCategories = Category::whereIn('id', $coupon->applicable_categories)->get();
        }

        return view('admin.coupons.show', compact('coupon', 'applicableProducts', 'applicableCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $categories = Category::all();
        $products = Product::select('id', 'name', 'sku')->get();

        return view('admin.coupons.edit', compact('coupon', 'categories', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'excluded_products' => 'nullable|array',
            'excluded_categories' => 'nullable|array',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'stackable' => 'boolean',
            'first_order_only' => 'boolean',
            'priority' => 'nullable|integer|min:0'
        ]);

        // Custom validation for percentage type
        if ($request->type === 'percentage' && $request->value > 100) {
            $validator->after(function ($validator) {
                $validator->errors()->add('value', 'Percentage discount cannot exceed 100%.');
            });
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['code'] = strtoupper($data['code']);

        // Convert date strings to Carbon instances
        if ($data['starts_at']) {
            $data['starts_at'] = Carbon::parse($data['starts_at']);
        }
        if ($data['expires_at']) {
            $data['expires_at'] = Carbon::parse($data['expires_at']);
        }

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')
                        ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
                        ->with('success', 'Coupon deleted successfully!');
    }

    /**
     * Toggle coupon status
     */
    public function toggle(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);

        $status = $coupon->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Coupon {$status} successfully!");
    }

    /**
     * Generate random coupon code
     */
    public function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Coupon::where('code', $code)->exists());

        return response()->json(['code' => $code]);
    }

    /**
     * Validate coupon code (for frontend use)
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_amount' => 'nullable|numeric|min:0'
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.'
            ], 404);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon is no longer valid.'
            ], 400);
        }

        $orderAmount = $request->order_amount ?? 0;
        if (!$coupon->canBeUsedBy(null, $orderAmount)) {
            $message = 'This coupon cannot be applied to your order.';
            if ($coupon->minimum_amount && $orderAmount < $coupon->minimum_amount) {
                $message = "Minimum order amount of ₹{$coupon->minimum_amount} required.";
            }

            return response()->json([
                'valid' => false,
                'message' => $message
            ], 400);
        }

        $discount = $coupon->calculateDiscount($orderAmount);

        return response()->json([
            'valid' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'formatted_value' => $coupon->formatted_value,
                'discount_amount' => $discount
            ],
            'message' => "Coupon applied! You save ₹{$discount}"
        ]);
    }
}
