<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Post;


class NotificationController extends Controller
{
    // Function to show notifications
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Bạn cần đăng nhập để xem thông báo.']);
        }
        $user = Auth::user();
        $cartItems = []; // Khởi tạo mảng chứa thông tin giỏ hàng
        $totalAmount = 0; // Khởi tạo biến tổng tiền
        $cartQuantity = 0;
        

        if ($user) {
            // Tìm giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                // Lấy thông tin chi tiết giỏ hàng
                $cartItems = $cart->cartDetails()->with('product')->get();
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
                // Tính tổng số tiền
                foreach ($cartItems as $item) {
                    $totalAmount += $item->total_amount; // Sử dụng trường total_amount của CartDetail
                }
            }
        }
        // Lấy thông báo của người dùng, các thông báo chưa đọc ở trên cùng, sắp xếp theo created_at
        $notifications = Notification::where('user_id', auth::user()->id)
            ->orderBy('is_user_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('notification', compact('notifications','cartQuantity'));
    }
    

    // Function to mark a notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        // Đảm bảo chỉ chủ sở hữu thông báo mới được đánh dấu
        if ($notification->user_id == auth::id()) {
            $notification->update(['is_user_read' => true]);

            return response()->json(['message' => 'Thông báo đã được đánh dấu đã đọc'], 200);
        }

        return response()->json(['message' => 'Không có quyền truy cập'], 403);
    }
    public function sendNotification(Request $request)
{
    $request->validate([
        'user_ids' => 'required|array',
        'content' => 'required|string',
        'type' => 'required|string',
    ]);

    // Lưu thông báo cho từng user_id đã chọn
    foreach ($request->user_ids as $userId) {
        Notification::create([
            'user_id' => $userId,
            'content' => $request->content,
            'type' => $request->type,
            'is_user_read' => 0, // Người dùng chưa đọc
        ]);
    }

    return response()->json(['success' => true]);
}
public function getUnreadCount(Request $request)
{
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!auth::check()) {
        return response()->json([
            'error' => 'Unauthorized', 
            'message' => 'You must be logged in to view unread notifications.'
        ], 401); // Trả về lỗi 401 nếu chưa đăng nhập
    }

    // Lấy user_id từ người dùng hiện tại
    $userId = $request->user()->id;

    // Đếm số lượng thông báo chưa đọc của người dùng
    $unreadCount = Notification::where('user_id', $userId)
        ->where('is_user_read', 0)
        ->count();

    // Trả về số lượng thông báo chưa đọc dưới dạng JSON
    return response()->json([
        'unread_count' => $unreadCount
    ]);
}
public function markAllAsRead()
{
    Notification::where('user_id', auth::id())
        ->where('is_user_read', false)
        ->update(['is_user_read' => true]);

    return response()->json(['message' => 'Tất cả thông báo đã được đánh dấu đã đọc'], 200);
}

public function deleteNotification($id)
{
    $notification = Notification::findOrFail($id);

    if ($notification->user_id == auth::id()) {
        $notification->delete();
        return response()->json(['message' => 'Thông báo đã được xóa'], 200);
    }

    return response()->json(['message' => 'Không có quyền'], 403);
}

public function deleteAllReadNotifications()
{
    Notification::where('user_id', auth::id())
        ->where('is_user_read', true)
        ->delete();

    return response()->json(['message' => 'Tất cả thông báo đã đọc đã được xóa'], 200);
}
public function getNotifications()
{
    if (!auth::check()) {
        return response()->json([
            'message' => 'Bạn cần đăng nhập để xem thông báo.'
        ], 403);
    }

    $userId = auth::id();

    // Lấy thông báo tối đa 10 cái, ưu tiên chưa đọc, sắp xếp theo thời gian mới nhất
    $notifications = Notification::where('user_id', $userId)
        ->orderBy('is_user_read', 'asc') // Chưa đọc lên trước
        ->orderBy('created_at', 'desc') // Mới nhất lên trước
        ->take(10)
        ->get();

    $result = $notifications->map(function ($notification) {
        $content = strtolower($notification->content); // Chuyển nội dung về chữ thường để dễ phân tích
        $link = null;
        $coverImage = null;

        if (strpos($content, 'giảm ngay') !== false) {
            $link = route('home'); // Link đến trang chủ
            $coverImage = 'http://localhost/web_ban_banh_kem/public/images/sale.png';
        } elseif (strpos($content, 'đơn hàng') !== false) {
            $link = route('orders'); // Link đến trang đơn hàng
            $coverImage = 'http://localhost/web_ban_banh_kem/public/images/order.png';
        } elseif (strpos($content, 'chúng tôi sẽ sớm') !== false) {
            
            $coverImage = 'http://localhost/web_ban_banh_kem/public/images/Respone.png';
        } 
        elseif (strpos($content, 'bạn đã nhận') !== false) {
            
            $coverImage = 'http://localhost/web_ban_banh_kem/public/images/Discount.png';
        } elseif (strpos($content, 'bài viết mới') !== false) {
            // Tách lấy tiêu đề sau dấu ":"
            if (preg_match('/bài viết mới:\s*(.*?)$/i', $notification->content, $matches)) {
                $title = trim($matches[1]); // Bỏ khoảng trắng dư thừa
                
                $post = Post::where('title', 'LIKE', '%' . $title . '%')->first();
                
                if ($post) {
                    $link = route('post_detail', ['id' => $post->id]);
                    $coverImage = $post->cover_image;
                }
            }
        }

        return [
            'id' => $notification->id,
            'content' => $notification->content,
            'is_read' => $notification->is_user_read,
            'created_at' => $notification->created_at->format('H:i d/m/Y'),
            'link' => $link,
            'cover_image' => $coverImage,
        ];
    });

    return response()->json($result);
}

public function markAsRead1($id) 
{
    if (!auth::check()) {
        return response()->json(['message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'], 403);
    }

    $notification = Notification::find($id);

    if (!$notification || $notification->user_id != auth::id()) {
        return response()->json(['message' => 'Thông báo không tồn tại hoặc bạn không có quyền.'], 404);
    }

    // Đánh dấu thông báo là đã đọc
    $notification->update(['is_user_read' => 1]);

    return response()->json(['message' => 'Thông báo đã được đánh dấu là đã đọc.']);
}
}
