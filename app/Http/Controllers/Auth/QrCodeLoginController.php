<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TheDaNang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QrCodeLoginController extends Controller
{
    // Xử lý đăng nhập cho cả ba trường hợp
    public function login(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string|max:50',
    ]);

    // Kiểm tra xem qr_code có tồn tại trong bảng the_da_nang không
    $card = TheDaNang::where('qr_code', $request->qr_code)->first();

    if ($card) {
        // Lấy user_id từ bảng the_da_nang và đăng nhập người dùng
        Auth::loginUsingId($card->user_id);

        // Kiểm tra nếu người dùng là admin
        $user = Auth::user();
        if ($user->is_admin == 1) {
            return response()->json([
                'message' => 'Đăng nhập thành công!',
                'redirect' => url('/admin/dashboard') // Điều hướng đến trang admin
            ]);
        }

        // Nếu không phải admin, điều hướng về trang chủ
        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'redirect' => url('/') // Điều hướng về trang chủ
        ]);
    }

    return response()->json([
        'message' => 'Mã QR không hợp lệ.'
    ], 401);
}

}
