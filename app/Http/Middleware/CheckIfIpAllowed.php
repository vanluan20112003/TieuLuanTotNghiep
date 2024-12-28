<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class CheckIfIpAllowed
{
    public function handle(Request $request, Closure $next)
    {
        // Cấp quyền cho IP cụ thể
        $allowedIps = ['192.168.12.106']; // Thêm các IP bạn muốn cấp quyền

        if (App::isDownForMaintenance() && !in_array($request->ip(), $allowedIps)) {
            abort(503);
        }

        return $next($request);
    }
}
