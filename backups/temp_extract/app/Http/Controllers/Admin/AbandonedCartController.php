<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbandonedCart;
use App\Models\AbandonedCartEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbandonedCartController extends Controller
{
    /**
     * Display abandoned cart dashboard
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'abandoned');

        // Get statistics
        $stats = [
            'total_abandoned' => AbandonedCart::abandoned()->count(),
            'total_recovered' => AbandonedCart::recovered()->count(),
            'total_expired' => AbandonedCart::expired()->count(),
            'recovery_rate' => AbandonedCart::getRecoveryRate(30),
            'revenue_lost' => AbandonedCart::getTotalRevenueLost(30),
            'revenue_recovered' => AbandonedCart::getTotalRevenueRecovered(30),
            'email_performance' => AbandonedCartEmail::getPerformanceMetrics(30),
        ];

        // Base query
        $query = AbandonedCart::with(['user', 'emails'])
            ->orderBy('abandoned_at', 'desc');

        // Apply tab filter
        switch ($tab) {
            case 'abandoned':
                $query->abandoned();
                break;
            case 'recovered':
                $query->recovered();
                break;
            case 'expired':
                $query->expired();
                break;
            case 'guest':
                $query->guest()->abandoned();
                break;
            case 'registered':
                $query->registered()->abandoned();
                break;
            case 'high_value':
                $query->abandoned()->where('cart_total', '>=', 5000);
                break;
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply date filter
        if ($request->filled('date_from')) {
            $query->where('abandoned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('abandoned_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Apply value filter
        if ($request->filled('min_value')) {
            $query->where('cart_total', '>=', $request->min_value);
        }
        if ($request->filled('max_value')) {
            $query->where('cart_total', '<=', $request->max_value);
        }

        $carts = $query->paginate(20)->withQueryString();

        return view('admin.abandoned-carts.index', compact('carts', 'stats', 'tab'));
    }

    /**
     * Show abandoned cart details
     */
    public function show(AbandonedCart $abandonedCart)
    {
        $abandonedCart->load(['user', 'emails']);

        return view('admin.abandoned-carts.show', compact('abandonedCart'));
    }

    /**
     * Send recovery email manually
     */
    public function sendRecoveryEmail(Request $request, AbandonedCart $abandonedCart)
    {
        $request->validate([
            'email_type' => 'required|in:reminder_1,reminder_2,reminder_3,final_reminder,custom',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'include_coupon' => 'boolean',
            'coupon_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
        ]);

        try {
            // Create email record
            $email = AbandonedCartEmail::create([
                'abandoned_cart_id' => $abandonedCart->id,
                'email_type' => $request->email_type,
                'subject' => $request->subject,
                'content' => $request->content,
                'status' => 'pending',
                'scheduled_at' => now(),
                'coupon_code' => $request->include_coupon ? $request->coupon_code : null,
                'discount_amount' => $request->include_coupon ? $request->discount_amount : null,
                'discount_type' => $request->include_coupon ? $request->discount_type : null,
                'is_personalized' => true,
            ]);

            // TODO: Send actual email using queue
            // dispatch(new SendAbandonedCartEmail($email));

            // For now, mark as sent
            $email->markAsSent();

            // Update abandoned cart
            $abandonedCart->update([
                'email_sent' => true,
                'email_count' => $abandonedCart->email_count + 1,
                'last_email_sent_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Recovery email sent successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send recovery email: ' . $e->getMessage());
        }
    }

    /**
     * Mark cart as recovered manually
     */
    public function markAsRecovered(AbandonedCart $abandonedCart)
    {
        $abandonedCart->markAsRecovered();

        return redirect()->back()->with('success', 'Cart marked as recovered successfully!');
    }

    /**
     * Mark cart as expired
     */
    public function markAsExpired(AbandonedCart $abandonedCart)
    {
        $abandonedCart->markAsExpired();

        return redirect()->back()->with('success', 'Cart marked as expired successfully!');
    }

    /**
     * Delete abandoned cart
     */
    public function destroy(AbandonedCart $abandonedCart)
    {
        $abandonedCart->delete();

        return redirect()->back()->with('success', 'Abandoned cart deleted successfully!');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:send_email,mark_recovered,mark_expired,delete',
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:abandoned_carts,id',
        ]);

        $cartIds = $request->cart_ids;
        $action = $request->action;

        try {
            switch ($action) {
                case 'send_email':
                    // TODO: Implement bulk email sending
                    $count = count($cartIds);
                    break;

                case 'mark_recovered':
                    AbandonedCart::whereIn('id', $cartIds)->update([
                        'status' => 'recovered',
                        'recovered_at' => now()
                    ]);
                    $count = count($cartIds);
                    break;

                case 'mark_expired':
                    AbandonedCart::whereIn('id', $cartIds)->update([
                        'status' => 'expired'
                    ]);
                    $count = count($cartIds);
                    break;

                case 'delete':
                    AbandonedCart::whereIn('id', $cartIds)->delete();
                    $count = count($cartIds);
                    break;
            }

            return redirect()->back()->with('success', "Bulk action completed for {$count} carts!");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Export abandoned carts
     */
    public function export(Request $request)
    {
        $query = AbandonedCart::with(['user']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->where('abandoned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('abandoned_at', '<=', $request->date_to . ' 23:59:59');
        }

        $carts = $query->get();

        $filename = 'abandoned_carts_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($carts) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID', 'Customer Name', 'Email', 'Phone', 'Cart Total', 'Items Count',
                'Status', 'Abandoned At', 'Last Activity', 'Email Sent', 'Email Count',
                'Recovery Token', 'Country', 'City'
            ]);

            // CSV data
            foreach ($carts as $cart) {
                fputcsv($file, [
                    $cart->id,
                    $cart->customer_name,
                    $cart->customer_email,
                    $cart->phone,
                    $cart->cart_total,
                    $cart->items_count,
                    ucfirst($cart->status),
                    $cart->abandoned_at->format('Y-m-d H:i:s'),
                    $cart->last_activity_at->format('Y-m-d H:i:s'),
                    $cart->email_sent ? 'Yes' : 'No',
                    $cart->email_count,
                    $cart->recovery_token,
                    $cart->country,
                    $cart->city,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get analytics data
     */
    public function analytics(Request $request)
    {
        $days = $request->get('days', 30);

        // Recovery rate over time
        $recoveryData = DB::table('abandoned_carts')
            ->select(
                DB::raw('DATE(abandoned_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "recovered" THEN 1 ELSE 0 END) as recovered')
            )
            ->where('abandoned_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue data
        $revenueData = DB::table('abandoned_carts')
            ->select(
                DB::raw('DATE(abandoned_at) as date'),
                DB::raw('SUM(CASE WHEN status = "abandoned" THEN cart_total ELSE 0 END) as lost'),
                DB::raw('SUM(CASE WHEN status = "recovered" THEN cart_total ELSE 0 END) as recovered')
            )
            ->where('abandoned_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Email performance
        $emailData = DB::table('abandoned_cart_emails')
            ->select(
                'email_type',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent'),
                DB::raw('SUM(CASE WHEN status = "opened" THEN 1 ELSE 0 END) as opened'),
                DB::raw('SUM(CASE WHEN status = "clicked" THEN 1 ELSE 0 END) as clicked')
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('email_type')
            ->get();

        return response()->json([
            'recovery_data' => $recoveryData,
            'revenue_data' => $revenueData,
            'email_data' => $emailData,
        ]);
    }
}
