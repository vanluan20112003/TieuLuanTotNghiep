<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Mailbox;
use App\Models\MailboxDetail;
use App\Models\Slide;



use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index() 
{
    // Lấy tất cả các category từ cơ sở dữ liệu
    $categories = Category::all();
    
    // Lấy 6 sản phẩm mới nhất (chưa bị xóa)
    $latestProducts = Product::where('is_deleted', 0)
                              ->orderBy('created_at', 'desc')
                              ->take(6)
                              ->get();
    
    // Lấy 6 sản phẩm bán chạy nhất (chưa bị xóa)
    $bestSellingProducts = Product::where('is_deleted', 0)
                                  ->orderBy('quantity_sold', 'desc')
                                  ->take(6)
                                  ->get();

    // Lấy 6 sản phẩm ngẫu nhiên (chưa bị xóa)
    $randomProducts = Product::where('is_deleted', 0)
                             ->inRandomOrder()
                             ->take(6)
                             ->get();

    // Lấy tất cả các slide có trạng thái status = 1
    $slides = Slide::where('status', 1)
               ->orderBy('is_header', 'desc') // Ưu tiên slide có is_header = 1
               ->orderBy('created_at', 'desc') // Sắp xếp theo ngày mới nhất
               ->get();


    // Kiểm tra xem người dùng đã đăng nhập chưa
    $user = Auth::user();
    $cartQuantity = 0;
    $mailboxes = [];
    $unreadMessagesCount = 0; // Biến để lưu số lượng tin nhắn chưa đọc

    if ($user) {
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
        }

        // Lấy tất cả các hộp thư của người dùng nếu có
        $mailboxes = Mailbox::where('user_id', $user->id)->get();

        // Kiểm tra xem hộp thư có dữ liệu không trước khi xử lý
        if ($mailboxes->isNotEmpty()) {
            // Lấy chi tiết tin nhắn cho mỗi hộp thư
            foreach ($mailboxes as $mailbox) {
                $messages = MailboxDetail::where('mailbox_id', $mailbox->id)
                    ->orderBy('sent_at', 'asc')
                    ->get();
                
                // Đếm số lượng tin nhắn chưa đọc
                $unreadMessagesCount += $messages->where('is_read_user', false)->count();
                
                // Gán tin nhắn vào hộp thư
                $mailbox->messages = $messages;
            }
        }
    }

    // Truyền biến vào view
    return view('home', compact(
        'categories', 
        'latestProducts', 
        'bestSellingProducts', 
        'randomProducts', 
        'slides', 
        'cartQuantity', 
        'mailboxes', 
        'unreadMessagesCount'
    ));
}

    
    public function testEmail()
    {
        $name = 'test name for email ';
        
        // Tắt xác thực chứng chỉ SSL khi gửi email
        $response = Http::withoutVerifying()->post('https://your-api-endpoint.com/send-email', [
            'email' => 'vanluan.9a9@gmail.com',
            'name' => $name,
        ]);

        if ($response->successful()) {
            Mail::send('verify', compact('name'), function($email) {
                $email->to('vanluan.9a9@gmail.com', 'Đồ đồng nát');
            });
        }
    }
 
}
