<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DiscountCode;
use App\Models\TheDaNang;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpinController extends Controller
{
    // Hàm cập nhật phần thưởng cho người dùng sau khi quay
    public function updatePrize(Request $request)
    {
        $userId = $request->input('user_id');
        $prize = $request->input('prize');  // Phần thưởng từ vòng quay

        if ($prize === "Vé giảm giá 10k") {
            $this->handleDiscount($userId, 4, 10);
        } elseif ($prize === "Vé giảm giá 20k") {
            $this->handleDiscount($userId, 5, 20);
        } elseif ($prize === "Vé giảm giá 50k") {
            $this->handleDiscount($userId, 6, 50);
        } elseif ($prize === "Vé giảm giá 100k") {
            $this->handleDiscount($userId, 7, 100);
        } elseif (strpos($prize, "Tiền thẻ đa năng") !== false) {
            $this->handleTheDaNangPrize($userId, $this->extractPrizeAmount($prize));
        }

        return response()->json(['success' => true, 'message' => 'Phần thưởng đã được cập nhật!']);
    }

    // Hàm xử lý các loại discount code
    private function handleDiscount($userId, $discountId, $discountAmount)
    {
        $duration = 30;  // Giả định mã giảm giá có thời hạn 30 ngày
        $expirationDate = Carbon::now()->addDays($duration);

        // Kiểm tra nếu user đã có mã giảm giá đó
        $existingCode = DiscountCode::where('user_id', $userId)
            ->where('discount_id', $discountId)
            ->first();

        if ($existingCode) {
            // Cập nhật số lượng và ngày hết hạn
            $existingCode->update([
                'quantity' => $existingCode->quantity + 1,
                'expiration_date' => $expirationDate,
            ]);
        } else {
            // Tạo mã giảm giá mới
            DiscountCode::create([
                'user_id' => $userId,
                'discount_id' => $discountId,
                'expiration_date' => $expirationDate,
                'quantity' => 1,
            ]);
        }
    }

    // Hàm xử lý phần thưởng là tiền thẻ đa năng
// Hàm xử lý phần thưởng là tiền thẻ đa năng
private function handleTheDaNangPrize($userId, $amount)
{
    // Tìm thẻ đa năng của người dùng
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    if ($theDaNang) {
        // Nếu người dùng có thẻ, cập nhật số dư
        DB::transaction(function () use ($theDaNang, $amount) {
            $theDaNang->so_du += $amount;
            $theDaNang->save();

            // Tạo giao dịch mới
            Transaction::create([
                'the_da_nang_id' => $theDaNang->id,
                'loai_giao_dich' => 'phan_thuong_vong_quay_yeu_thuong',
                'so_tien' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    } else {
        // Nếu không có thẻ đa năng, kiểm tra số tiền và thông báo cho người dùng
        if ($amount === 1000000) {
            return response()->json([
                'success' => false,
                'message' => "Bạn chưa có thẻ đa năng. Vui lòng liên hệ với canteen để nhận giải thưởng trị giá 1 triệu."
            ]);
        } else {
            // Quy đổi phần thưởng thành mã giảm giá cho các giá trị khác
            $this->convertToDiscount($userId, $amount);
        }
    }
}


    // Hàm quy đổi tiền thẻ đa năng thành mã giảm giá
    private function convertToDiscount($userId, $amount)
    {
        $discountId = $this->getDiscountIdFromAmount($amount);
        if ($discountId) {
            $this->handleDiscount($userId, $discountId, $amount);
        }

        // Thông báo người dùng rằng phần thưởng đã được quy đổi
        return response()->json([
            'success' => true,
            'message' => "Bạn chưa có thẻ đa năng, phần thưởng đã được quy đổi thành mã giảm giá tương ứng!",
        ]);
    }

    // Lấy discount ID dựa trên số tiền thẻ đa năng
    private function getDiscountIdFromAmount($amount)
    {
        switch ($amount) {
            case 10000:
                return 4;  // ID của mã giảm giá 10k
            case 20000:
                return 5;  // ID của mã giảm giá 20k
            case 50000:
                return 6;  // ID của mã giảm giá 50k
            case 100000:
                return 7;  // ID của mã giảm giá 100k
            default:
                return null;
        }
    }

    // Hàm để lấy số tiền từ tên phần thưởng (ví dụ: "Tiền thẻ đa năng 10k")
    private function extractPrizeAmount($prize)
    {
        preg_match('/(\d+)/', $prize, $matches);
        return isset($matches[1]) ? (int)$matches[1] * 1000 : 0;
    }
}
