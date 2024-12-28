<?php

// app/Http/Controllers/Admin/AuthController.php


namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Google2FA;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Trang đăng nhập
    }

    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Giữ yêu cầu này để có thể test chức năng, nhưng không sử dụng nó
        ]);
    
        $admin = Admin::where('email', $request->email)->first();
    
        // Kiểm tra nếu tài khoản admin bị khóa
        if ($admin && $admin->is_block) {
            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ với quản trị viên để được giải quyết.'
            ], 403);
        }
    
        // Kiểm tra xem admin có tồn tại không
        if (!$admin) {
            return response()->json([
                'message' => 'Email không tồn tại trong hệ thống.'
            ], 404);
        }
    
        // Bỏ qua kiểm tra mật khẩu để tiếp tục với 2FA
        Auth::guard('admin')->login($admin); // Đăng nhập admin
    
        // Kiểm tra nếu chưa kích hoạt 2FA
        if ($admin->google2fa_secret === null) {
            // Lưu admin ID vào session để tiếp tục kích hoạt 2FA
            $request->session()->put('2fa:admin:id', $admin->id);
    
            // Đăng xuất để tránh bỏ qua bảo mật
            Auth::guard('admin')->logout();
    
            // Chuyển hướng tới trang kích hoạt 2FA
            return redirect()->route('2fa.setup');
        }
    
        // Chuyển hướng tới trang yêu cầu nhập mã OTP
        return redirect()->route('2fa.enter');
    }
    
    
    
    
    public function show2faSetup(Request $request)
    {
        // Lấy admin ID từ session
        $adminId = $request->session()->get('2fa:admin:id');

        // Nếu không có session, chuyển hướng về trang đăng nhập
        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        // Tạo mã bí mật cho 2FA
        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();

        // Lưu mã bí mật vào cơ sở dữ liệu
        $admin = Admin::find($adminId);
        $admin->google2fa_secret = $secret;
        $admin->save();

        // Tạo URL QR Code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $admin->email,
            $secret
        );

        return view('admin.2fa_setup', compact('qrCodeUrl'));
    }

    public function setup2fa(Request $request)
    {
        // Xử lý nếu cần thêm logic setup 2FA
        return redirect()->route('admin.login');
    }

    public function show2faEnter()
    {
        return view('admin.2fa_enter'); // Trang nhập mã OTP
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required',
        ]);
    
        // Lấy admin đang đăng nhập
        $admin = Auth::guard('admin')->user();
    
        // Kiểm tra mã OTP
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($admin->google2fa_secret, $request->one_time_password);
    
        if ($valid) {
            // Đăng nhập thành công
            return redirect()->route('admin.dashboard'); // Chuyển hướng đến dashboard của admin
        }
    
        return back()->withErrors(['one_time_password' => 'Mã OTP không đúng.']);
    }
    
}


