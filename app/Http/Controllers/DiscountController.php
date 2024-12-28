<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\discount;
use App\Models\DiscountCode;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;


class DiscountController extends Controller
{
    //
    public function getDiscounts()
{
    $discounts = discount::select('id', 'name', 'status')
        ->where('id', '!=', 0) // Lọc bỏ các discount có id = 0
        ->get();

    return response()->json($discounts);
}
public function getUsers()
{
    $users = User::select('id','user_name', 'name', 'role', 'is_block')
        ->where('is_block', 0) // Lấy những người dùng không bị khóa
        ->get();

    return response()->json($users);
}
public function sendDiscount(Request $request)
{
    $couponId = $request->input('couponId');
    $userIds = $request->input('userIds');

    if (!$couponId || empty($userIds)) {
        return response()->json(['message' => 'Dữ liệu không hợp lệ!'], 400);
    }

    $expirationDate = Carbon::now()->addDays(7); // Thiết lập ngày hết hạn (7 ngày từ hiện tại)

    foreach ($userIds as $userId) {
        // Kiểm tra xem bản ghi đã tồn tại chưa
        $discountCode = DiscountCode::where('user_id', $userId)
            ->where('discount_id', $couponId)
            ->first();

        if ($discountCode) {
            // Nếu đã tồn tại, cập nhật số lượng và ngày hết hạn
            $discountCode->quantity += 1;
            $discountCode->expiration_date = $expirationDate;
            $discountCode->updated_at = now();
            $discountCode->save();
        } else {
            // Nếu chưa tồn tại, tạo bản ghi mới
            DiscountCode::create([
                'user_id' => $userId,
                'discount_id' => $couponId,
                'quantity' => 1,
                'expiration_date' => $expirationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return response()->json(['message' => 'Phiếu khuyến mãi đã được gửi thành công!'], 200);
}
public function getDiscountDetail($id)
{
    try {
        // Lấy phiếu giảm giá theo ID
        $discount = Discount::findOrFail($id);

        // Trả về dữ liệu chi tiết
        return response()->json([
            'success' => true,
            'data' => $discount
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Phiếu giảm giá không tồn tại hoặc đã bị xóa.'
        ], 404);
    }
}
public function updateDiscount(Request $request, $id)
{
    try {
        // Lấy thông tin discount
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['success' => false, 'message' => 'Phiếu giảm giá không tồn tại'], 404);
        }

        // Cập nhật thông tin
        $discount->name = $request->input('name');
        $discount->type = $request->input('type');
        $discount->minimum_condition = $request->input('minimum_condition');
        $discount->maximum_condition = $request->input('maximum_condition');
        $discount->condition_use = $request->input('condition_use');
        $discount->description = $request->input('description');

        $discount->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật phiếu giảm giá thành công']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật: ' . $e->getMessage()], 500);
    }
}
public function store(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|in:purchase discount,special discount,event discount',
        'minimum_condition' => 'required|numeric|min:0',
        'maximum_condition' => 'nullable|numeric|min:0',
        'discount_amount' => 'required|numeric|min:0', // Giá trị giảm giá
        'expiration_days' => 'nullable|numeric|min:0', // Hạn dùng
        'description' => 'nullable|string',
        'condition_use' => 'nullable|numeric|min:0', // Điều kiện sử dụng
    ]);

    try {
        // Tạo phiếu giảm giá mới
        $discount = Discount::create([
            'name' => $request->name,
            'type' => $request->type,
            'minimum_condition' => $request->minimum_condition,
            'maximum_condition' => $request->maximum_condition,
            'discount_amount' => $request->discount_amount,
            'duration' => $request->expiration_days, // Lưu hạn dùng
            'description' => $request->description,
            'condition_use' => $request->condition_use,
            'status' => 1, // Mặc định là "hoạt động"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Phiếu giảm giá đã được tạo thành công!',
            'data' => $discount
        ], 201);
    } catch (\Exception $e) {
        // Xử lý lỗi
        return response()->json([
            'success' => false,
            'message' => 'Đã xảy ra lỗi khi tạo phiếu giảm giá: ' . $e->getMessage()
        ], 500);
    }
}
public function getDiscountStatistics($days = 7)
{
    // Xác định khoảng thời gian
    $endDate = Carbon::now();
    $startDate = $endDate->copy()->subDays($days);

    // Tổng số phiếu khuyến mãi (có status = 1)
    $totalDiscounts = Discount::where('status', 1)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Số phiếu khuyến mãi được thêm trong khoảng thời gian
    $newDiscounts = Discount::where('status', 1)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Số phiếu khuyến mãi đã được sử dụng
    $usedDiscounts = Order::whereNotNull('discount_used')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Tổng số đơn hàng
    $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // Tỷ lệ sử dụng phiếu khuyến mãi
    $discountUsageRate = $totalOrders > 0 
        ? round(($usedDiscounts / $totalOrders) * 100, 2)
        : 0;

    // Thống kê số phiếu khuyến mãi theo tháng (6 tháng gần nhất)
    $monthlyDiscounts = $this->getMonthlyDiscountStats($days);

    // Phân phối sử dụng phiếu khuyến mãi
    $usageDistribution = [
        'used' => $usedDiscounts,
        'unused' => $totalOrders - $usedDiscounts
    ];

    return response()->json([
        'totalDiscounts' => $totalDiscounts,
        'newDiscounts' => $newDiscounts,
        'usedDiscounts' => $usedDiscounts,
        'discountUsageRate' => $discountUsageRate,
        'monthlyDiscounts' => $monthlyDiscounts,
        'usageDistribution' => [
            $usageDistribution['used'],
            $usageDistribution['unused']
        ]
    ]);
}

/**
 * Lấy thống kê số phiếu khuyến mãi theo tháng
 * 
 * @param int $days Số ngày muốn thống kê
 * @return array
 */
private function getMonthlyDiscountStats($days)
{
    // Lấy 6 tháng gần nhất
    $monthlyStats = Discount::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as discount_count')
    )
    ->where('status', 1)
    ->where('created_at', '>=', Carbon::now()->subMonths(6))
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('discount_count')
    ->toArray();

    // Đảm bảo luôn có 6 phần tử
    return array_pad($monthlyStats, 6, 0);
}

/**
 * Xuất báo cáo thống kê khuyến mãi
 * 
 * @param int $days Số ngày muốn thống kê
 * @return \Illuminate\Http\Response
 */
public function exportDiscountReport($days = 7)
{
    $statistics = $this->getDiscountStatistics($days)->getData();

    // Có thể mở rộng để xuất file Excel, PDF, etc.
    return response()->json($statistics);
}
}
