<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str; // Đảm bảo bạn đã import lớp Str để sử dụng Str::random

class MaintenanceController extends Controller
{
    // Phương thức để khởi động bảo trì
    public function startMaintenance(Request $request)
    {
        // Kiểm tra mật khẩu bảo trì (thay thế bằng mật khẩu bạn muốn)
        $validPassword = 'luan20112003';

        // Kiểm tra nếu mật khẩu bảo trì hợp lệ
        if ($request->password !== $validPassword) {
            return response()->json(['success' => false, 'message' => 'Mật khẩu bảo trì không đúng!']);
        }

        // Kiểm tra secret key hợp lệ (sử dụng key từ frontend)
        $validSecretKey = $request->secret;

        // Kiểm tra nếu secret key hợp lệ
        if ($validSecretKey) {
            // Xóa đi các secret key cũ trong session
            session()->forget('secret_token');  // Xóa secret token trong session nếu có

            // Lưu secret key mới vào session
            session(['secret_token' => $validSecretKey]);  // Lưu secret key mới vào session

            // Chạy lệnh bảo trì
            Artisan::call('down', ['--secret' => $validSecretKey]);

            return response()->json(['success' => true, 'message' => 'Hệ thống đang bảo trì!']);
        }

        // Nếu secret key không đúng, trả về lỗi
        return response()->json(['success' => false, 'message' => 'Secret key không đúng!']);
    }

    public function stopMaintenance()
    {
        Artisan::call('up');  // Tắt chế độ bảo trì
        return response()->json(['success' => true, 'message' => 'Hệ thống đã được bật lại!']);
    }
    public function checkMaintenanceStatus()
    {
        $status = file_exists(storage_path('framework/down')) ? 'maintenance' : 'not_maintenance';
        return response()->json(['status' => $status]);
    }
    
}
