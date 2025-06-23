<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'month'); // Default to monthly view
        $now = Carbon::now();

        // Determine date range based on selected period
        switch ($period) {
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
        }

        // Custom date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
        }

        // Get total revenue for completed orders in the date range
        $totalRevenue = Order::where('status', 'delivered')
            ->whereBetween('delivered_date', [$startDate, $endDate])
            ->sum('total');

        // Get revenue by product for the period
        $productRevenues = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.price * order_items.quantity) as revenue'),
                DB::raw('SUM(order_items.quantity) as units_sold')
            )
            ->where('orders.status', 'delivered')
            ->whereBetween('orders.delivered_date', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // Get daily revenue for chart
        $dailyRevenue = Order::where('status', 'delivered')
            ->whereBetween('delivered_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(delivered_date) as date'),
                DB::raw('SUM(total) as daily_total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data for charts
        $chartLabels = $dailyRevenue->pluck('date')->toJson();
        $chartData = $dailyRevenue->pluck('daily_total')->toJson();

        // Product revenue chart
        $productLabels = $productRevenues->pluck('name')->toJson();
        $productData = $productRevenues->pluck('revenue')->toJson();

        return view('admin.revenue.index', compact(
            'totalRevenue', 
            'productRevenues', 
            'period', 
            'startDate', 
            'endDate', 
            'chartLabels', 
            'chartData', 
            'productLabels', 
            'productData'
        ));
    }
}
