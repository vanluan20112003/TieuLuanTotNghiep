<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ngày hiện tại
        $today = Carbon::now();

        // Ngày 7 ngày trước
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Tính toán doanh thu trong ngày, tuần, tháng
        $todayRevenue = Order::whereDate('created_at', $today->toDateString())
                              ->sum('total_amount');
        $weeklyRevenue = Order::whereBetween('created_at', [$sevenDaysAgo, $today])
                               ->sum('total_amount');
        $monthlyRevenue = Order::whereMonth('created_at', $today->month)
                                ->sum('total_amount');
        
        // Tính toán số lượng người dùng đăng ký trong 7 ngày qua
        $weeklyUserRegistrations = User::whereBetween('created_at', [$sevenDaysAgo, $today])
            ->count();

        // Tính toán số lượng sản phẩm được thêm trong 7 ngày qua
        $weeklyProductAdditions = Product::whereBetween('created_at', [$sevenDaysAgo, $today])
                                         ->count();

        return view('layouts.dashboard', compact(
            'todayRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'weeklyUserRegistrations',
            'weeklyProductAdditions'
        ));
    }
}
