<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Post;
use App\Models\Discount;
use App\Models\BanAn; // 'ban_an'
use App\Models\TheDaNang; // 'ban_an'
use App\Models\DatBan; // 'ban_an'
use Carbon\Carbon;

class AdminDashBoardController extends Controller
{
    public function index() {
        // Tổng doanh thu
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $revenueToday = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $revenueThisWeek = Order::where('status', 'completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $revenueThisMonth = Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_amount');
        $revenueThisQuarter = Order::where('status', 'completed')->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()])->sum('total_amount');
        $revenueThisYear = Order::where('status', 'completed')->whereYear('created_at', now()->year)->sum('total_amount');
    
        // Tổng sản phẩm
        $totalProducts = Product::count();
        $productsAddedThisWeek = Product::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $productsAddedThisMonth = Product::whereMonth('created_at', now()->month)->count();
        $productsAddedThisQuarter = Product::whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()])->count();
        $productsInStock = Product::where('quantity_in_stock', '>', 0)->count();
        $productsOutOfStock = Product::where('quantity_in_stock', 0)->count();
    
        // Người dùng
        $totalUsers = User::count();
        $usersRegisteredToday = User::whereDate('created_at', today())->count();
        $usersRegisteredThisWeek = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $usersRegisteredThisMonth = User::whereMonth('created_at', now()->month)->count();
        $usersRegisteredThisQuarter = User::whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()])->count();
    
        // Đơn hàng
        $totalOrders = Order::count();
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersCompletedToday = Order::whereDate('created_at', today())->where('status', 'completed')->count();
        $ordersCancelledToday = Order::whereDate('created_at', today())->where('status', 'cancelled')->count();
        $ordersThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $ordersCompletedThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('status', 'completed')->count();
        $ordersCancelledThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->where('status', 'cancelled')->count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $ordersCompletedThisMonth = Order::whereMonth('created_at', now()->month)->where('status', 'completed')->count();
        $ordersCancelledThisMonth = Order::whereMonth('created_at', now()->month)->where('status', 'cancelled')->count();
    
        // Bài viết
        $totalPosts = Post::count();
        $postsAddedThisWeek = Post::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $postsAddedThisMonth = Post::whereMonth('created_at', now()->month)->count();
    
        // Thẻ đa năng
        $usersWithCards = TheDaNang::distinct('user_id')->count('user_id');
        $spinRate = $totalUsers > 0 ? round(($usersWithCards / $totalUsers) * 100) : 0;
    
        // Mã giảm giá
        $totalDiscounts = Discount::count();
        $purchaseDiscounts = Discount::where('type', 'purchase discount')->count();
        $specialDiscounts = Discount::where('type', 'special discount')->count();
        $eventDiscounts = Discount::where('type', 'event discount')->count();
    
        // Bàn
        $totalTables = BanAn::count(); // Tổng số bàn
    $ordersTodayTables = DatBan::whereDate('thoi_gian_dat', today())->count(); // Đặt bàn hôm nay
    $ordersThisWeekTables = DatBan::whereBetween('thoi_gian_dat', [now()->startOfWeek(), now()->endOfWeek()])->count(); // Đặt bàn tuần này
    $ordersThisMonthTables = DatBan::whereMonth('thoi_gian_dat', now()->month)->count(); // Đặt bàn tháng này
    
    $topProducts = Product::orderBy('quantity_sold', 'desc')
    ->take(3) // Lấy top 3 sản phẩm bán chạy
    ->get();

    $dates = collect(range(0, 14))->map(function ($day) {
        return Carbon::today()->subDays(14 - $day)->format('d/m'); // Đảo thứ tự ngày
    });
    
    $revenues = collect(range(0, 14))->map(function ($day) {
        $date = Carbon::today()->subDays(14 - $day); // Đảo thứ tự ngày
        return Order::where('status', 'completed')
            ->whereDate('created_at', $date)
            ->sum('total_amount');
    });
    
    $topBuyers = User::withSum(['orders as total_spent' => function ($query) {
        $query->where('status', 'completed'); // Chỉ tính đơn hàng hoàn thành
    }], 'total_amount')
    ->orderBy('total_spent', 'desc')
    ->take(3) // Lấy top 3 người dùng
    ->get();
        $usersWithCards = TheDaNang::distinct('user_id')->count('user_id'); // Tính số lượng người dùng đã mở thẻ đa năng
        $spinRate = $totalUsers > 0 ? round(($usersWithCards / $totalUsers) * 100) : 0;
        return view('layouts.admin_test', compact(
            'totalRevenue', 
            'totalProducts', 
            'totalUsers', 'topProducts',  'topBuyers',
            'totalOrders', 
            'totalPosts', 
            'totalDiscounts', 
            'totalTables',
            'spinRate',
            'revenueToday', 'revenueThisWeek', 'revenueThisMonth', 'revenueThisQuarter', 'revenueThisYear','usersWithCards',
            'productsAddedThisWeek', 'productsAddedThisMonth', 'productsAddedThisQuarter', 'productsInStock', 'productsOutOfStock',
            'usersRegisteredToday', 'usersRegisteredThisWeek', 'usersRegisteredThisMonth', 'usersRegisteredThisQuarter',
            'ordersToday', 'ordersCompletedToday', 'ordersCancelledToday', 'ordersThisWeek', 'ordersCompletedThisWeek', 'ordersCancelledThisWeek',
            'ordersThisMonth', 'ordersCompletedThisMonth', 'ordersCancelledThisMonth','dates',
            'revenues',
            'postsAddedThisWeek', 'postsAddedThisMonth',
            'purchaseDiscounts', 'specialDiscounts', 'eventDiscounts',
            'ordersTodayTables', 'ordersThisWeekTables', 'ordersThisMonthTables'
        ));
    }
    
}