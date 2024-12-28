<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra nếu user đã đăng nhập và có quyền admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Nếu không phải admin, chuyển hướng người dùng về trang chủ hoặc trang không có quyền truy cập
        return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
    }
}
