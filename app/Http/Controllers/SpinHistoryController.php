<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpinHistory;
use Illuminate\Support\Facades\Auth;

class SpinHistoryController extends Controller
{
    public function store(Request $request)
    {
        // Lưu thông tin lịch sử quay
        $spinHistory = SpinHistory::create([
            'user_id' => Auth::id(),
            'result' => $request->result,
        ]);

        if ($spinHistory) {
            return response()->json(['success' => true, 'message' => 'Lịch sử quay đã được lưu.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Lưu lịch sử quay thất bại.']);
        }
    }
}
