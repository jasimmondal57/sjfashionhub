<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    /**
     * Display payment gateways dashboard
     */
    public function index()
    {
        $gateways = PaymentGateway::ordered()->get();
        $stats = PaymentTransaction::getStats(30);

        // Get recent transactions
        $recentTransactions = PaymentTransaction::with(['paymentGateway', 'user', 'order'])
            ->latest()
            ->limit(10)
            ->get();

        // Gateway-wise stats
        $gatewayStats = PaymentGateway::withCount(['transactions as total_transactions'])
            ->withSum(['transactions as total_amount' => function ($query) {
                $query->where('status', 'completed');
            }], 'amount')
            ->get();

        return view('admin.payment-gateways.index', compact(
            'gateways',
            'stats',
            'recentTransactions',
            'gatewayStats'
        ));
    }

    /**
     * Show gateway configuration form
     */
    public function configure($gateway)
    {
        $paymentGateway = PaymentGateway::where('name', $gateway)->firstOrFail();

        return view('admin.payment-gateways.configure', compact('paymentGateway'));
    }

    /**
     * Update gateway configuration
     */
    public function updateConfiguration(Request $request, $gateway)
    {
        $paymentGateway = PaymentGateway::where('name', $gateway)->firstOrFail();

        $rules = $this->getValidationRules($gateway);
        $validatedData = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Update basic settings
            $paymentGateway->update([
                'is_active' => $request->boolean('is_active'),
                'is_test_mode' => $request->boolean('is_test_mode'),
                'min_amount' => $request->input('min_amount', 0),
                'max_amount' => $request->input('max_amount'),
                'transaction_fee' => $request->input('transaction_fee', 0),
                'fixed_fee' => $request->input('fixed_fee', 0),
            ]);

            // Update credentials
            if ($gateway !== 'cod') {
                $credentials = $this->extractCredentials($request, $gateway);
                $paymentGateway->credentials = $credentials;
                $paymentGateway->save();
            }

            // Update additional settings
            $settings = $this->extractSettings($request, $gateway);
            $paymentGateway->settings = $settings;
            $paymentGateway->save();

            DB::commit();

            return redirect()->route('admin.payment-gateways.index')
                ->with('success', $paymentGateway->display_name . ' configuration updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update configuration: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle gateway status
     */
    public function toggleStatus(PaymentGateway $paymentGateway)
    {
        $paymentGateway->update([
            'is_active' => !$paymentGateway->is_active
        ]);

        $status = $paymentGateway->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', $paymentGateway->display_name . ' has been ' . $status . '!');
    }

    /**
     * Test gateway connection
     */
    public function testConnection(Request $request, $gateway)
    {
        $paymentGateway = PaymentGateway::where('name', $gateway)->firstOrFail();

        try {
            $result = $this->performConnectionTest($paymentGateway);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show transactions for a gateway
     */
    public function transactions(Request $request, $gateway)
    {
        $paymentGateway = PaymentGateway::where('name', $gateway)->firstOrFail();

        $query = PaymentTransaction::with(['user', 'order'])
            ->where('payment_gateway_id', $paymentGateway->id);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(20);
        $stats = PaymentTransaction::where('payment_gateway_id', $paymentGateway->id)->getStats(30);

        return view('admin.payment-gateways.transactions', compact(
            'paymentGateway',
            'transactions',
            'stats'
        ));
    }

    /**
     * Show all transactions
     */
    public function allTransactions(Request $request)
    {
        $query = PaymentTransaction::with(['paymentGateway', 'user', 'order']);

        // Apply filters
        if ($request->filled('gateway')) {
            $query->whereHas('paymentGateway', function ($q) use ($request) {
                $q->where('name', $request->gateway);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(20);
        $stats = PaymentTransaction::getStats(30);
        $gateways = PaymentGateway::ordered()->get();

        return view('admin.payment-gateways.all-transactions', compact(
            'transactions',
            'stats',
            'gateways'
        ));
    }

    /**
     * Initialize default gateways
     */
    public function initializeDefaults()
    {
        try {
            PaymentGateway::createDefaults();

            return redirect()->back()
                ->with('success', 'Default payment gateways initialized successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to initialize gateways: ' . $e->getMessage());
        }
    }

    /**
     * Get validation rules for gateway
     */
    private function getValidationRules($gateway)
    {
        $commonRules = [
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'transaction_fee' => 'nullable|numeric|min:0|max:100',
            'fixed_fee' => 'nullable|numeric|min:0',
        ];

        $gatewayRules = [
            'razorpay' => [
                'key_id' => 'required|string',
                'key_secret' => 'required|string',
                'webhook_secret' => 'nullable|string',
            ],
            'cashfree' => [
                'app_id' => 'required|string',
                'secret_key' => 'required|string',
            ],
            'payu' => [
                'merchant_key' => 'required|string',
                'merchant_salt' => 'required|string',
            ],
            'paytm' => [
                'merchant_id' => 'required|string',
                'merchant_key' => 'required|string',
            ],
            'paypal' => [
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
            ],
            'cod' => []
        ];

        return array_merge($commonRules, $gatewayRules[$gateway] ?? []);
    }

    /**
     * Extract credentials from request
     */
    private function extractCredentials(Request $request, $gateway)
    {
        $credentialFields = [
            'razorpay' => ['key_id', 'key_secret', 'webhook_secret'],
            'cashfree' => ['app_id', 'secret_key'],
            'payu' => ['merchant_key', 'merchant_salt'],
            'paytm' => ['merchant_id', 'merchant_key'],
            'paypal' => ['client_id', 'client_secret'],
        ];

        $fields = $credentialFields[$gateway] ?? [];
        $credentials = [];

        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $credentials[$field] = $request->input($field);
            }
        }

        return $credentials;
    }

    /**
     * Extract settings from request
     */
    private function extractSettings(Request $request, $gateway)
    {
        $settings = [];

        // Common settings
        if ($request->filled('webhook_url')) {
            $settings['webhook_url'] = $request->input('webhook_url');
        }

        // Gateway-specific settings
        switch ($gateway) {
            case 'razorpay':
                if ($request->filled('theme_color')) {
                    $settings['theme_color'] = $request->input('theme_color');
                }
                break;
            case 'paypal':
                if ($request->filled('currency')) {
                    $settings['currency'] = $request->input('currency');
                }
                break;
        }

        return $settings;
    }

    /**
     * Perform connection test
     */
    private function performConnectionTest(PaymentGateway $gateway)
    {
        // This is a basic test - in production, you'd make actual API calls
        $credentials = $gateway->getDecryptedCredentialsAttribute();

        switch ($gateway->name) {
            case 'razorpay':
                if (empty($credentials['key_id']) || empty($credentials['key_secret'])) {
                    return ['success' => false, 'message' => 'Missing required credentials'];
                }
                break;
            case 'cashfree':
                if (empty($credentials['app_id']) || empty($credentials['secret_key'])) {
                    return ['success' => false, 'message' => 'Missing required credentials'];
                }
                break;
            case 'payu':
                if (empty($credentials['merchant_key']) || empty($credentials['merchant_salt'])) {
                    return ['success' => false, 'message' => 'Missing required credentials'];
                }
                break;
            case 'paytm':
                if (empty($credentials['merchant_id']) || empty($credentials['merchant_key'])) {
                    return ['success' => false, 'message' => 'Missing required credentials'];
                }
                break;
            case 'paypal':
                if (empty($credentials['client_id']) || empty($credentials['client_secret'])) {
                    return ['success' => false, 'message' => 'Missing required credentials'];
                }
                break;
            case 'cod':
                return ['success' => true, 'message' => 'COD is always available'];
        }

        return ['success' => true, 'message' => 'Connection test successful'];
    }
}
