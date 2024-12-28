<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RadioNotification;  // Sử dụng model RadioNotification
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class SpeechController extends Controller
{
    // Hàm để trả về thông báo ngẫu nhiên từ cơ sở dữ liệu  // Hàm để lấy các thông báo hợp lệ và phát âm
    public function getRandomAnnouncement()
    {
        // Lấy tất cả thông báo từ database
        $announcements = RadioNotification::all();
        
        // Lọc ra các thông báo không hết hạn
        $validAnnouncements = $announcements->filter(function($announcement) {
            // Kiểm tra xem thời gian hết hạn có lớn hơn thời gian hiện tại hay không
            $expirationDate = Carbon::parse($announcement->created_at)->addDays($announcement->expiration_period); // Dùng addDays để cộng thêm ngày
            return Carbon::now()->lessThanOrEqualTo($expirationDate);
        });

        // Nếu không có thông báo hợp lệ, trả về thông báo không có thông báo
        if ($validAnnouncements->isEmpty()) {
            return response()->json([
                'message' => 'Hiện tại không có thông báo phát thanh nào từ chúng tôi.'
            ]);
        }

        // Sắp xếp các thông báo theo cấp độ ưu tiên (level) giảm dần
        $validAnnouncements = $validAnnouncements->sortByDesc('level');

        // Tạo câu trả lời tự nhiên từ nội dung các thông báo
        $messages = $validAnnouncements->map(function($announcement) {
            return $this->generateNaturalResponse($announcement->content);
        });

        // Trả về các thông báo hợp lệ
        return response()->json([
            'messages' => $messages
        ]);
    }

    // Hàm tạo ra câu trả lời tự nhiên từ nội dung thông báo
    private function generateNaturalResponse($content)
    {
        // Câu trả lời tự nhiên dựa trên nội dung thông báo
        return "$content";
    }
    public function index()
    {
        // Lấy tất cả thông báo, sắp xếp theo thời gian tạo
        $notifications = RadioNotification::all()->map(function ($notification) {
            // Sử dụng addDays thay vì addHours để cộng số ngày
            $expirationDate = Carbon::parse($notification->created_at)->addDays($notification->expiration_period);
            $notification->expired = Carbon::now()->greaterThan($expirationDate);
            return $notification;
        });
    
        return response()->json($notifications);
    }
    

    // Lấy thông báo theo ID
    public function show($id)
    {
        $notification = RadioNotification::findOrFail($id);
        return response()->json($notification);
    }

    // Cập nhật thông báo
    public function update(Request $request, $id)
    {
        $notification = RadioNotification::findOrFail($id);
        $notification->update([
            'level' => $request->input('level'),
            'content' => $request->input('content'),
            'expiration_period' => $request->input('expiration_period')
        ]);

        return response()->json($notification);
    }

    // Xóa thông báo
    public function destroy($id)
    {
        $notification = RadioNotification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Thông báo đã được xóa.']);
    }
    

    public function saveNotification(Request $request)
    {
        try {
            // Kiểm tra dữ liệu nhận được từ request
        
    
            // Validating dữ liệu từ request
            $validated = $request->validate([
                'level' => 'required|integer|in:1,2,3',
                'content' => 'required|string|max:255',
                'expiration_period' => 'required|integer|min:1',
            ]);
    
            // Tạo mới thông báo phát thanh
            $notification = new RadioNotification();
            $notification->level = $validated['level'];
            $notification->content = $validated['content'];
            $notification->expiration_period = $validated['expiration_period'];
            $notification->created_at = now();
    
            // Lưu thông báo vào cơ sở dữ liệu
            if ($notification->save()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thông báo phát thanh đã được lưu thành công!'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
                ]);
            }
        } catch (\Exception $e) {
            // Ghi lỗi vào log để kiểm tra chi tiết
            Log::error('Error saving notification: ' . $e->getMessage());
    
            // Trả về thông báo lỗi
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.'
            ]);
        }
    }
    
}
