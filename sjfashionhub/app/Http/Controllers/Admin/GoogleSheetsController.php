<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoogleSheetsSetting;
use App\Models\GoogleSheetsSyncLog;
use App\Models\Order;
use App\Models\ReturnOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoogleSheetsController extends Controller
{
    /**
     * Display Google Sheets integration dashboard
     */
    public function index()
    {
        $settings = GoogleSheetsSetting::with(['syncLogs' => function($query) {
            $query->latest()->limit(5);
        }])->get()->keyBy('sheet_type');

        $recentLogs = GoogleSheetsSyncLog::with('googleSheetsSetting')
            ->latest()
            ->limit(10)
            ->get();

        $stats = GoogleSheetsSyncLog::getRecentStats(30);

        return view('admin.google-sheets.index', compact('settings', 'recentLogs', 'stats'));
    }

    /**
     * Show configuration form for a specific sheet type
     */
    public function configure($sheetType)
    {
        $validTypes = ['orders', 'returns', 'users', 'newsletters'];

        if (!in_array($sheetType, $validTypes)) {
            return redirect()->route('admin.google-sheets.index')
                ->with('error', 'Invalid sheet type');
        }

        $setting = GoogleSheetsSetting::where('sheet_type', $sheetType)->first();
        $defaultMapping = GoogleSheetsSetting::getDefaultColumnMapping($sheetType);

        return view('admin.google-sheets.configure', compact('setting', 'sheetType', 'defaultMapping'));
    }

    /**
     * Store or update Google Sheets configuration
     */
    public function store(Request $request, $sheetType)
    {
        $validator = Validator::make($request->all(), [
            'sheet_name' => 'required|string|max:255',
            'spreadsheet_id' => 'required|string|max:255',
            'web_app_url' => 'required|url',
            'auto_sync' => 'boolean',
            'real_time_sync' => 'boolean',
            'sync_frequency' => 'required|in:hourly,daily,weekly',
            'column_mapping' => 'required|array',
            'service_account_json' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $setting = GoogleSheetsSetting::updateOrCreate(
                ['sheet_type' => $sheetType],
                [
                    'sheet_name' => $request->sheet_name,
                    'spreadsheet_id' => $request->spreadsheet_id,
                    'sheet_id' => $request->sheet_id,
                    'web_app_url' => $request->web_app_url,
                    'service_account_json' => $request->service_account_json,
                    'column_mapping' => $request->column_mapping,
                    'auto_sync' => $request->has('auto_sync'),
                    'real_time_sync' => $request->has('real_time_sync'),
                    'sync_frequency' => $request->sync_frequency,
                    'sync_filters' => $request->sync_filters ?? [],
                    'notes' => $request->notes,
                    'is_active' => true,
                ]
            );

            return redirect()->route('admin.google-sheets.index')
                ->with('success', ucfirst($sheetType) . ' sheet configuration saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save configuration: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Test connection to Google Sheets
     */
    public function testConnection($sheetType)
    {
        $setting = GoogleSheetsSetting::where('sheet_type', $sheetType)->first();

        if (!$setting) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ]);
        }

        $result = $setting->testConnection();
        return response()->json($result);
    }

    /**
     * Manual sync data to Google Sheets
     */
    public function manualSync(Request $request, $sheetType)
    {
        $setting = GoogleSheetsSetting::where('sheet_type', $sheetType)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            return redirect()->back()
                ->with('error', 'Sheet configuration not found or inactive');
        }

        try {
            $data = $this->getDataForSync($sheetType, $request->get('limit', 100));

            if (empty($data)) {
                return redirect()->back()
                    ->with('info', 'No data found to sync');
            }

            $result = $setting->bulkSync($data);

            if ($result) {
                return redirect()->back()
                    ->with('success', 'Manual sync completed successfully! Synced ' . count($data) . ' records.');
            } else {
                return redirect()->back()
                    ->with('error', 'Manual sync failed. Check sync logs for details.');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Get data for syncing based on sheet type
     */
    private function getDataForSync($sheetType, $limit = 100)
    {
        switch ($sheetType) {
            case 'orders':
                return Order::with(['user', 'orderItems.product'])
                    ->latest()
                    ->limit($limit)
                    ->get()
                    ->map(function ($order) {
                        return [
                            'order_id' => $order->id,
                            'customer_name' => $order->user?->name ?? $order->billing_first_name . ' ' . $order->billing_last_name,
                            'customer_email' => $order->user?->email ?? $order->billing_email,
                            'customer_phone' => $order->user?->phone ?? $order->billing_phone,
                            'total_amount' => $order->total_amount,
                            'status' => $order->status,
                            'payment_status' => $order->payment_status,
                            'shipping_address' => $order->shipping_address_line_1 . ', ' . $order->shipping_city,
                            'order_date' => $order->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
                            'items_count' => $order->orderItems->count(),
                            'shipping_method' => $order->shipping_method,
                            'tracking_number' => $order->tracking_number,
                            'notes' => $order->notes,
                        ];
                    })->toArray();

            case 'returns':
                return ReturnOrder::with(['order', 'order.user'])
                    ->latest()
                    ->limit($limit)
                    ->get()
                    ->map(function ($return) {
                        return [
                            'return_id' => $return->id,
                            'order_id' => $return->order_id,
                            'customer_name' => $return->order->user?->name ?? 'Guest',
                            'customer_email' => $return->order->user?->email ?? $return->order->billing_email,
                            'return_reason' => $return->reason,
                            'return_status' => $return->status,
                            'refund_amount' => $return->refund_amount,
                            'return_date' => $return->created_at->format('Y-m-d H:i:s'),
                            'approved_date' => $return->approved_at?->format('Y-m-d H:i:s'),
                            'refund_date' => $return->refunded_at?->format('Y-m-d H:i:s'),
                            'quality_check' => $return->quality_check_status,
                            'admin_notes' => $return->admin_notes,
                            'tracking_number' => $return->return_tracking_number,
                        ];
                    })->toArray();

            case 'users':
                return User::withCount('orders')
                    ->withSum('orders', 'total_amount')
                    ->latest()
                    ->limit($limit)
                    ->get()
                    ->map(function ($user) {
                        return [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'role' => $user->role,
                            'status' => $user->status,
                            'registration_date' => $user->created_at->format('Y-m-d H:i:s'),
                            'last_login' => $user->last_login_at?->format('Y-m-d H:i:s'),
                            'total_orders' => $user->orders_count,
                            'total_spent' => $user->orders_sum_total_amount ?? 0,
                            'address' => $user->address,
                            'city' => $user->city,
                            'state' => $user->state,
                            'country' => $user->country,
                        ];
                    })->toArray();

            default:
                return [];
        }
    }

    /**
     * View sync logs
     */
    public function syncLogs(Request $request)
    {
        $query = GoogleSheetsSyncLog::with(['googleSheetsSetting', 'triggeredByUser'])
            ->latest();

        // Apply filters
        if ($request->filled('sheet_type')) {
            $query->whereHas('googleSheetsSetting', function($q) use ($request) {
                $q->where('sheet_type', $request->sheet_type);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sync_type')) {
            $query->where('sync_type', $request->sync_type);
        }

        if ($request->filled('date_from')) {
            $query->where('started_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('started_at', '<=', $request->date_to . ' 23:59:59');
        }

        $logs = $query->paginate(20)->withQueryString();
        $stats = GoogleSheetsSyncLog::getRecentStats(30);

        return view('admin.google-sheets.logs', compact('logs', 'stats'));
    }

    /**
     * Delete a sheet configuration
     */
    public function destroy($sheetType)
    {
        $setting = GoogleSheetsSetting::where('sheet_type', $sheetType)->first();

        if (!$setting) {
            return redirect()->back()
                ->with('error', 'Configuration not found');
        }

        $setting->delete();

        return redirect()->route('admin.google-sheets.index')
            ->with('success', ucfirst($sheetType) . ' sheet configuration deleted successfully!');
    }

    /**
     * Toggle sheet configuration active status
     */
    public function toggleStatus($sheetType)
    {
        $setting = GoogleSheetsSetting::where('sheet_type', $sheetType)->first();

        if (!$setting) {
            return redirect()->back()
                ->with('error', 'Configuration not found');
        }

        $setting->update(['is_active' => !$setting->is_active]);

        $status = $setting->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', ucfirst($sheetType) . ' sheet configuration ' . $status . ' successfully!');
    }

    /**
     * Export sync logs
     */
    public function exportLogs(Request $request)
    {
        $query = GoogleSheetsSyncLog::with('googleSheetsSetting');

        // Apply filters
        if ($request->filled('sheet_type')) {
            $query->whereHas('googleSheetsSetting', function($q) use ($request) {
                $q->where('sheet_type', $request->sheet_type);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('started_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('started_at', '<=', $request->date_to . ' 23:59:59');
        }

        $logs = $query->get();

        $filename = 'google_sheets_sync_logs_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID', 'Sheet Type', 'Sync Type', 'Operation', 'Status',
                'Records Processed', 'Records Success', 'Records Failed',
                'Started At', 'Completed At', 'Duration', 'Triggered By', 'Error Message'
            ]);

            // CSV data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->googleSheetsSetting->sheet_type,
                    $log->sync_type_label,
                    $log->operation_label,
                    ucfirst($log->status),
                    $log->records_processed,
                    $log->records_success,
                    $log->records_failed,
                    $log->started_at->format('Y-m-d H:i:s'),
                    $log->completed_at?->format('Y-m-d H:i:s') ?? 'N/A',
                    $log->formatted_duration,
                    $log->triggered_by ?? 'System',
                    $log->error_message ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Transform newsletter subscribers data for Google Sheets
     */
    private function transformNewslettersData($subscribers)
    {
        return $subscribers->map(function ($subscriber) {
            return [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
                'name' => $subscriber->name ?? '',
                'status' => ucfirst($subscriber->status),
                'subscribed_at' => $subscriber->subscribed_at?->format('Y-m-d H:i:s') ?? '',
                'unsubscribed_at' => $subscriber->unsubscribed_at?->format('Y-m-d H:i:s') ?? '',
                'source' => $subscriber->source ?? '',
                'ip_address' => $subscriber->ip_address ?? '',
                'user_agent' => $subscriber->user_agent ?? '',
                'preferences' => $subscriber->preferences ? json_encode($subscriber->preferences) : '',
                'created_at' => $subscriber->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $subscriber->updated_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    /**
     * Get data for specific sheet type
     */
    private function getSheetData($sheetType, $limit = null)
    {
        switch ($sheetType) {
            case 'orders':
                $query = \App\Models\Order::with(['user', 'orderItems'])
                    ->latest('created_at');
                break;

            case 'returns':
                $query = \App\Models\ReturnOrder::with(['order', 'order.user'])
                    ->latest('created_at');
                break;

            case 'users':
                $query = \App\Models\User::withCount('orders')
                    ->withSum('orders', 'total_amount')
                    ->latest('created_at');
                break;

            case 'newsletters':
                $query = \App\Models\NewsletterSubscriber::latest('subscribed_at');
                break;

            default:
                return collect();
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Transform data based on sheet type
     */
    private function transformDataForSheet($data, $sheetType)
    {
        switch ($sheetType) {
            case 'newsletters':
                return $this->transformNewslettersData($data);

            case 'orders':
                return $this->transformOrdersData($data);

            case 'returns':
                return $this->transformReturnsData($data);

            case 'users':
                return $this->transformUsersData($data);

            default:
                return [];
        }
    }

    /**
     * Transform orders data for Google Sheets
     */
    private function transformOrdersData($orders)
    {
        return $orders->map(function ($order) {
            return [
                'order_id' => $order->id,
                'customer_name' => $order->user->name ?? 'Guest',
                'customer_email' => $order->user->email ?? $order->email,
                'customer_phone' => $order->user->phone ?? $order->phone,
                'total_amount' => number_format($order->total_amount, 2),
                'status' => ucfirst($order->status),
                'payment_status' => ucfirst($order->payment_status ?? 'pending'),
                'shipping_address' => $order->shipping_address ?? '',
                'order_date' => $order->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
                'items_count' => $order->orderItems->count(),
                'shipping_method' => $order->shipping_method ?? '',
                'tracking_number' => $order->tracking_number ?? '',
                'notes' => $order->notes ?? '',
            ];
        })->toArray();
    }

    /**
     * Transform returns data for Google Sheets
     */
    private function transformReturnsData($returns)
    {
        return $returns->map(function ($return) {
            return [
                'return_id' => $return->id,
                'order_id' => $return->order_id,
                'customer_name' => $return->order->user->name ?? 'Guest',
                'customer_email' => $return->order->user->email ?? '',
                'return_reason' => $return->reason ?? '',
                'return_status' => ucfirst($return->status),
                'refund_amount' => number_format($return->refund_amount ?? 0, 2),
                'return_date' => $return->created_at->format('Y-m-d H:i:s'),
                'approved_date' => $return->approved_at?->format('Y-m-d H:i:s') ?? '',
                'refund_date' => $return->refunded_at?->format('Y-m-d H:i:s') ?? '',
                'quality_check' => $return->quality_check_status ?? '',
                'admin_notes' => $return->admin_notes ?? '',
                'tracking_number' => $return->tracking_number ?? '',
            ];
        })->toArray();
    }

    /**
     * Transform users data for Google Sheets
     */
    private function transformUsersData($users)
    {
        return $users->map(function ($user) {
            return [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'role' => ucfirst($user->role ?? 'customer'),
                'status' => ucfirst($user->status ?? 'active'),
                'registration_date' => $user->created_at->format('Y-m-d H:i:s'),
                'last_login' => $user->last_login_at?->format('Y-m-d H:i:s') ?? '',
                'total_orders' => $user->orders_count ?? 0,
                'total_spent' => number_format($user->orders_sum_total_amount ?? 0, 2),
                'address' => $user->address ?? '',
                'city' => $user->city ?? '',
                'state' => $user->state ?? '',
                'country' => $user->country ?? '',
            ];
        })->toArray();
    }
}
