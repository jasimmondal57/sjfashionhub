<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'products_with_seo' => Product::whereNotNull('seo_title')->count(),
            'categories_with_seo' => Category::whereNotNull('seo_title')->count(),
        ];

        // Get recent products
        $recent_products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent categories
        $recent_categories = Category::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get low stock products (assuming stock_quantity < 10 is low)
        $low_stock_products = Product::where('stock_quantity', '<', 10)
            ->where('manage_stock', true)
            ->orderBy('stock_quantity', 'asc')
            ->limit(5)
            ->get();

        // Get recent orders
        $recent_orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'recent_products',
            'recent_categories',
            'low_stock_products',
            'recent_orders'
        ));
    }
}
