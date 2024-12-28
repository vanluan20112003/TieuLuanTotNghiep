<?php
// app/Http/Controllers/AdminStatisticsController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminStatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Thống kê doanh thu 10 ngày gần nhất
        $dailyRevenue = Order::whereBetween('created_at', [now()->subDays(10), now()])
                            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                            ->groupBy('date')
                            ->get();

        // Thống kê doanh thu theo tháng
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
                            ->groupBy('month')
                            ->get();

        // Thống kê sản phẩm bán chạy nhất
        $bestSellingProducts = Product::orderBy('quantity_sold', 'desc')
                                     ->take(10)
                                     ->get();

        // Thống kê doanh thu sản phẩm
        $productRevenue = Product::selectRaw('name, quantity_sold * price as total_revenue')
                                 ->orderBy('total_revenue', 'desc')
                                 ->take(10)
                                 ->get();

        return view('layouts.statistics', compact('dailyRevenue', 'monthlyRevenue', 'bestSellingProducts', 'productRevenue'));
    }
}

