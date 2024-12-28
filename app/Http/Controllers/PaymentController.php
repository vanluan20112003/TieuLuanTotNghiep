<?php

namespace App\Http\Controllers;

use App\Models\TheDaNang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function showPaymentOptions()
    {
        // Lấy thông tin người dùng hiện tại
        $userId = Auth::id();
        $theDaNang = TheDaNang::where('user_id', $userId)->first();

        if (!$theDaNang || (empty($theDaNang->phuong_thuc_thanh_toan_1) && empty($theDaNang->phuong_thuc_thanh_toan_2))) {
            $message = "Bạn hiện chưa có phương thức thanh toán nào.";
            $paymentMethods = [];
        } else {
            $paymentMethods = [
                [
                    'method' => $theDaNang->pp_thanh_toan_1,
                    'card' => $theDaNang->ma_the_1
                ],
                [
                    'method' => $theDaNang->pp_thanh_toan_2,
                    'card' => $theDaNang->ma_the_2
                ]
            ];
            $message = null;
        }

        return view('link_payment', compact('paymentMethods', 'message', 'theDaNang'));
    }

    public function processPayment(Request $request)
    {
        // Xử lý thao tác nạp tiền hoặc rút tiền
        $action = $request->input('action'); // Có thể là 'nạp tiền' hoặc 'rút tiền'
        $method = $request->input('method'); // Phương thức thanh toán
        $amount = $request->input('amount'); // Số tiền để nạp hoặc rút

        // Logic xử lý nạp tiền hoặc rút tiền
        // (Chẳng hạn, cập nhật số dư trong bảng the_da_nang)
        
        // Trả về thông báo hoặc redirect sau khi xử lý
        return redirect()->back()->with('success', "Đã xử lý $action thành công với phương thức: $method.");
    }
    public function confirmTransaction(Request $request)
    {
        // Lấy thông tin từ yêu cầu
        $transactionType = $request->input('transactionType');
        $amount = $request->input('amount');
        $pin = $request->input('pin');
        
        // Tìm tài khoản TheDaNang của người dùng
        $theDaNang = TheDaNang::where('user_id', auth::user()->id)->first();
    
        if (!$theDaNang) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy tài khoản.']);
        }
    
        // Kiểm tra mã PIN
        if ($pin !== $theDaNang->pin_code) {
            return response()->json(['success' => false, 'message' => 'Mã PIN không chính xác.']);
        }
    
        // Xử lý nạp hoặc rút tiền
        if ($transactionType == 'nap') {
            $theDaNang->so_du += $amount;  // Nạp tiền
        } elseif ($transactionType == 'rut') {
            if ($theDaNang->so_du < $amount) {
                return response()->json(['success' => false, 'message' => 'Số dư không đủ.']);
            }
            $theDaNang->so_du -= $amount;  // Rút tiền
        } else {
            return response()->json(['success' => false, 'message' => 'Loại giao dịch không hợp lệ.']);
        }
    
        // Lưu thay đổi số dư
        $theDaNang->save();
    
        // Ghi lại giao dịch trong bảng transactions
        $transaction = new Transaction();
        $transaction->the_da_nang_id = $theDaNang->id;
        $transaction->loai_giao_dich = $transactionType;
        $transaction->so_tien = $amount;
        $transaction->save();
    
        return response()->json(['success' => true, 'message' => 'Giao dịch thành công!']);
    }
    public function checkPinCode(Request $request)
    {
        // Lấy thông tin mã PIN từ yêu cầu
        $pin = $request->input('pin');
        
        // Tìm tài khoản TheDaNang của người dùng hiện tại
        $theDaNang = TheDaNang::where('user_id', Auth::id())->first();
        
        // Kiểm tra mã PIN
        if ($theDaNang && $theDaNang->pin_code === $pin) {
            // Mã PIN chính xác
            return response()->json(['success' => true, 'message' => 'Mã PIN chính xác.']);
        } else {
            // Mã PIN không chính xác
            return response()->json(['success' => false, 'message' => 'Mã PIN không chính xác.']);
        }
    }
    
}
