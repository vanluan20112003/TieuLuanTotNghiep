<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\TheDaNang;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
{
    // Nếu người dùng đã đăng nhập
    if (auth::check()) {
        // Quay lại trang trước đó hoặc trang mặc định
        return redirect('/')->with('error', 'Bạn đã đăng nhập rồi');
    }

    // Hiển thị trang đăng nhập nếu chưa đăng nhập
    return view('login');
}


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        // Kiểm tra xem input là email hay user_name
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
    
        // Tìm user bằng email hoặc user_name
        $user = User::where($fieldType, $request->email)->first();
    
        // Kiểm tra nếu tài khoản bị khóa
        if ($user && $user->is_block) {
            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với canteen để được giải quyết.'
            ], 403);
        }
    
        // Thực hiện đăng nhập bằng email hoặc user_name
        if (Auth::attempt([$fieldType => $request->email, 'password' => $request->password])) {
            // Lưu cookie đăng nhập trong 15 ngày
            Cookie::queue('last_login', now(), 60 * 24 * 15); // 15 ngày
    
            // Kiểm tra nếu người dùng là admin
            $redirectUrl = Auth::user()->is_admin ? route('admin.dashboard') : url('/');
    
            return response()->json([
                'message' => 'Login successful!',
                'redirect' => $redirectUrl // Điều hướng đến trang admin/dashboard nếu là admin
            ]);
        }
    
        // Đăng nhập thất bại
        return response()->json([
            'message' => 'Email hoặc mật khẩu không đúng.'
        ], 401);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    
}
