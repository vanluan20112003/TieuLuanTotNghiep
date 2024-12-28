<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\InventoryEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Thêm dòng này
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;

class FinancialStatsController extends Controller
{
    // Lấy thống kê tài chính trong khoảng thời gian (mặc định 1 tháng)
    // FinancialStatsController.php
public function index(Request $request)
{
    $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
    $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

    // Dữ liệu thống kê cơ bản giữ nguyên
    $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
                        ->where('status', 'completed')
                        ->count();

    $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
                         ->where('status', 'completed')
                         ->sum('total_amount');

    $totalPurchaseCost = InventoryEntry::whereBetween('created_at', [$startDate, $endDate])
                                       ->sum(DB::raw('purchase_price * quantity'));

    $totalProfit = $totalRevenue - $totalPurchaseCost;

    // Thêm dữ liệu theo ngày cho biểu đồ
    $dailyStats = Order::whereBetween('created_at', [$startDate, $endDate])
        ->where('status', 'completed')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(total_amount) as revenue')
        )
        ->groupBy('date')
        ->get();

    // Lấy chi phí theo ngày
    $dailyCosts = InventoryEntry::whereBetween('created_at', [$startDate, $endDate])
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(purchase_price * quantity) as cost')
        )
        ->groupBy('date')
        ->get()
        ->pluck('cost', 'date')
        ->toArray();

    // Tính lợi nhuận theo ngày và format dữ liệu
    $chartData = [];
    foreach ($dailyStats as $stat) {
        $date = $stat->date;
        $cost = $dailyCosts[$date] ?? 0;
        $chartData[] = [
            'date' => $date,
            'revenue' => $stat->revenue,
            'cost' => $cost,
            'profit' => $stat->revenue - $cost,
            'orders' => $stat->order_count
        ];
    }

    $paymentMethods = Order::whereBetween('created_at', [$startDate, $endDate])
                           ->select('payment_method', DB::raw('count(*) as count'))
                           ->groupBy('payment_method')
                           ->pluck('count', 'payment_method');

    return response()->json([
        'status' => 'success',
        'data' => [
            'start_date' => $startDate,
            'end_date' => $endDate, 
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_purchase_cost' => $totalPurchaseCost,
            'total_profit' => $totalProfit,
            'payment_methods' => $paymentMethods,
            'daily_stats' => $chartData
        ]
    ]);
}
 // Đảm bảo thêm dòng này ở trên file của bạn

public function generateReport(Request $request)
{
    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();
    $userName = $user ? $user->name : 'Guest';  // Nếu không có người dùng thì lấy tên là "Guest"

    // Validate request
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ]);

    $startDate = Carbon::parse($request->start_date)->startOfDay();
    $endDate = Carbon::parse($request->end_date)->endOfDay();

    // 1. Tổng doanh thu
    $revenue = Order::whereBetween('created_at', [$startDate, $endDate])
        ->where('orders.status', 'completed') // Sửa lại phần này
        ->where('orders.is_deleted', false)   // Sửa lại phần này
        ->sum('total_amount');

    // 2. Chi tiết các đơn hàng và sản phẩm bán ra
    $orderDetails = OrderDetail::whereHas('order', function($query) use ($startDate, $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate])
              ->where('orders.status', 'completed')  // Sửa lại phần này
              ->where('orders.is_deleted', false);   // Sửa lại phần này
    })->with(['order', 'product'])
      ->get();

    // 3. Chi phí nhập hàng
    $inventoryCost = InventoryEntry::whereBetween('created_at', [$startDate, $endDate])
        ->where('mode', 'import')
        ->sum(DB::raw('purchase_price * quantity'));

    // 4. Chi phí vận chuyển
    $shippingCost = Order::whereBetween('created_at', [$startDate, $endDate])
        ->where('orders.status', 'completed')  // Sửa lại phần này
        ->where('orders.is_deleted', false)   // Sửa lại phần này
        ->join('shipping', 'orders.shipping_id', '=', 'shipping.id')
        ->sum('shipping.shipping_fee');

    // 5. Tổng giảm giá đã áp dụng
    $totalDiscounts = Order::whereBetween('created_at', [$startDate, $endDate])
        ->where('orders.status', 'completed') // Sửa lại phần này
        ->where('orders.is_deleted', false)   // Sửa lại phần này
        ->sum('discount_used');

    // 6. Phân tích lợi nhuận theo sản phẩm
    $productProfits = OrderDetail::whereHas('order', function($query) use ($startDate, $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate])
              ->where('orders.status', 'completed')  // Sửa lại phần này
              ->where('orders.is_deleted', false);   // Sửa lại phần này
    })->select(
        'product_id',
        DB::raw('SUM(quantity) as total_quantity'),
        DB::raw('SUM(amount) as total_revenue')
    )->with(['product' => function($query) {
        $query->select('id', 'name', 'purchase_price');
    }])->groupBy('product_id')
      ->get()
      ->map(function($item) {
          return [
              'product_name' => $item->product->name,
              'quantity_sold' => $item->total_quantity,
              'revenue' => $item->total_revenue,
              'cost' => $item->total_quantity * $item->product->purchase_price,
              'profit' => $item->total_revenue - ($item->total_quantity * $item->product->purchase_price)
          ];
      });

    // 7. Tính toán các chỉ số
    $grossProfit = $revenue - $inventoryCost;
    $netProfit = $grossProfit - $shippingCost - $totalDiscounts;
    $profitMargin = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0;

    return response()->json([
        'user_name' => $userName,  // Trả về tên người dùng
        'period' => [
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d')
        ],
        'summary' => [
            'total_revenue' => $revenue,
            'total_inventory_cost' => $inventoryCost,
            'total_shipping_cost' => $shippingCost,
            'total_discounts' => $totalDiscounts,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'profit_margin' => round($profitMargin, 2) . '%'
        ],
        'product_analysis' => $productProfits,
        'order_count' => $orderDetails->unique('order_id')->count(),
        'payment_methods' => Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed') // Sửa lại phần này
            ->where('orders.is_deleted', false)   // Sửa lại phần này
            ->select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->get()
    ]);
}

}
