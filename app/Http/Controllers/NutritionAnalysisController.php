<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NutritionAnalysisController extends Controller
{
    public function index()
{
    // Lấy id người dùng đã đăng nhập
    $userId = Auth::id();
    $oneWeekAgo = Carbon::now()->subWeek();
    
    // Truy vấn các hóa đơn hoàn thành trong vòng 1 tuần
    $orders = Order::where('user_id', $userId)
        ->where('status', 'completed')
        ->where('created_at', '>=', $oneWeekAgo)
        ->get();
    
    // Kiểm tra nếu không có hóa đơn nào trong 1 tuần
    if ($orders->isEmpty()) {
        return view('nutrition-analysis', ['message' => 'Không có dữ liệu trong vòng 1 tuần.']);
    }

    // Khởi tạo một mảng để lưu thông tin chi tiết các đơn hàng
    $orderDetails = [];
    $productsHandled = []; // Mảng để theo dõi sản phẩm đã xử lý
    $totalCalories = 0;
    $totalProtein = 0;
    $totalCarbs = 0;
    $totalFat = 0;
    $totalSugar = 0;
    $totalFiber = 0;

    // Lặp qua tất cả các hóa đơn
    foreach ($orders as $order) {
        // Truy vấn các chi tiết đơn hàng
        $orderDetailData = \DB::table('order_details')
            ->where('order_id', $order->id)
            ->get();
        
        // Lặp qua các chi tiết đơn hàng
        foreach ($orderDetailData as $orderDetail) {
            // Truy vấn thông tin sản phẩm tương ứng
            $product = \DB::table('products')->where('id', $orderDetail->product_id)->first();
            if ($product) {
                // Nếu sản phẩm đã được xử lý, bỏ qua
                if (in_array($product->id, $productsHandled)) {
                    continue;
                }

                // Truy vấn thành phần dinh dưỡng của sản phẩm, chỉ lấy các cột cần thiết
                $nutritionFact = \DB::table('nutrition_facts')
                    ->where('product_id', $product->id)
                    ->first(['calories', 'protein', 'fat', 'carbohydrate', 'sugar', 'fiber']);

                // Nếu có thành phần dinh dưỡng, thêm vào mảng
                if ($nutritionFact) {
                    $orderDetails[] = [
                        'product' => $product,
                        'nutritionFact' => $nutritionFact,
                    ];

                    // Cộng dồn vào tổng
                    $totalCalories += $nutritionFact->calories;
                    $totalProtein += $nutritionFact->protein;
                    $totalCarbs += $nutritionFact->carbohydrate;
                    $totalFat += $nutritionFact->fat;
                    $totalSugar += $nutritionFact->sugar;
                    $totalFiber += $nutritionFact->fiber;
                } else {
                    // Nếu sản phẩm chưa có thành phần dinh dưỡng, thêm thông báo
                    $orderDetails[] = [
                        'product' => $product,
                        'message' => 'Sản phẩm này chưa cập nhật thành phần dinh dưỡng.',
                    ];
                }

                // Đánh dấu sản phẩm đã được xử lý
                $productsHandled[] = $product->id;
            }
        }
    }

    // Trả về view với dữ liệu
    return view('nutrition-analysis', [
        'orderDetails' => $orderDetails,
        'totalCalories' => $totalCalories,
        'totalProtein' => $totalProtein,
        'totalCarbs' => $totalCarbs,
        'totalFat' => $totalFat,
        'totalSugar' => $totalSugar,
        'totalFiber' => $totalFiber,
    ]);
}

    
}
