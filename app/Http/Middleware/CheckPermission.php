<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admins;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();
    
        // Kiểm tra nếu người dùng không đăng nhập hoặc không phải admin
        if (!$user || !$user->is_admin) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }
    
        // Lấy quyền admin
        $admin = Admins::where('user_id', $user->id)->first();
    
        // Debug để kiểm tra
   
    
        // Kiểm tra quyền cụ thể
        if (!$admin || !$admin->hasPermission($permission)) {
            return redirect()->route('admin.dashboard')
                ->with('error', "Bạn không có quyền thực hiện thao tác này.");
        }
    
        return $next($request);
    }
}

