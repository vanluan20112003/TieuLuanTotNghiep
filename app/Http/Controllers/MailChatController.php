<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mailbox;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\MailboxDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class MailChatController extends Controller
{
    /**
     * Lưu tin nhắn mới vào hộp thư.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $mailboxId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMessage(Request $request, $mailboxId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
    
        // Tạo tin nhắn mới
        $message = MailboxDetail::create([
            'mailbox_id' => $mailboxId,
            'content' => $request->input('content'),
            'created_at' => now(),
            'updated_at' => now(),
            'is_read_user' => true,
            'is_read_admin' => false,
            'sent_at' => now(),
            'is_deleted' => false,
            'is_user_send' => true, // Đánh dấu là tin nhắn của người dùng
        ]);
    
        // Trả về phản hồi JSON
        return response()->json(['success' => true]);
    }
    
   
    public function getMessages($mailboxId)
{
    $messages = MailboxDetail::where('mailbox_id', $mailboxId)
        ->orderBy('sent_at', 'asc')
        ->get();

    return view('home', compact('messages')); // Trả về view chứa danh sách tin nhắn
}
public function getChatUsers()
{
    // Lấy danh sách mailbox có thông tin chi tiết
    $mailboxes = Mailbox::with(['user', 'mailboxDetails' => function ($query) {
        $query->where('is_deleted', 0)
            ->orderBy('sent_at', 'desc'); // Sắp xếp theo thời gian gửi gần nhất
    }])->get();

    // Xử lý danh sách user
    $userList = $mailboxes->map(function ($mailbox) {
        $latestDetail = $mailbox->mailboxDetails->first(); // Tin nhắn mới nhất
        return [
            'user_id' => $mailbox->user->id,
            'user_name' => $mailbox->user->name,
            'avatar' => $mailbox->user->avatar ?? '/default-avatar.png', // Hình ảnh người dùng
            'last_message' => $latestDetail->content ?? 'Không có tin nhắn',
            'sent_at' => $latestDetail->sent_at ?? null,
            'is_read_admin' => $latestDetail->is_read_admin ?? 1,
        ];
    });

    // Sắp xếp danh sách theo is_read_admin và thời gian gửi
    $sortedUsers = $userList->sortBy([
        fn ($a, $b) => $a['is_read_admin'] <=> $b['is_read_admin'], // Ưu tiên is_read_admin = 0
        fn ($a, $b) => strtotime($b['sent_at']) <=> strtotime($a['sent_at']), // Sắp xếp theo thời gian gần nhất
    ]);

    return response()->json($sortedUsers->values());
}
// Trong MessageController.php
public function getMessagesChat($userId) {
    $messages = MailboxDetail::whereHas('mailbox', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->orderBy('sent_at', 'asc')
    ->get();

    // Lấy thông tin user
    $user = User::find($userId);

    return response()->json([
        'messages' => $messages,
        'user' => $user
    ]);
}
public function markAsRead($userId)
{
    try {
        // Lấy thông tin từ bảng mailbox
        $mailbox = DB::table('mailbox')
                    ->where('user_id', $userId)
                    ->first(); // Lấy ra một bản ghi duy nhất
        
        // Kiểm tra nếu mailbox tồn tại
        if ($mailbox) {
            $mailboxId = $mailbox->id;

            // Cập nhật trạng thái is_admin_read trong bảng mailbox_detail
            DB::table('mailbox_detail')
                ->where('mailbox_id', $mailboxId)
                ->update(['is_read_admin' => 1]);

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Mailbox not found']);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'content' => 'required|string',
            'is_user_send' => 'required|boolean',
        ]);

        try {
            // Lấy thông tin user_id và nội dung tin nhắn
            $userId = $request->input('user_id');
            $content = $request->input('content');
            $isUserSend = $request->input('is_user_send');

            // Tìm mailbox_id từ user_id
            $mailbox = DB::table('mailbox')
                         ->where('user_id', $userId)
                         ->first();

            if (!$mailbox) {
                return response()->json(['status' => 'error', 'message' => 'Mailbox not found']);
            }

            $mailboxId = $mailbox->id;

            // Insert tin nhắn vào bảng mailbox_detail
            $message = MailBoxDetail::create([
                'mailbox_id' => $mailboxId,
                'content' => $content,
                'is_read_user' => 0,  // Đánh dấu chưa đọc bởi user
                'is_read_admin' => 1, // Đánh dấu đã đọc bởi admin
                'sent_at' => Carbon::now(),  // Thời gian gửi
                'is_deleted' => 0,  // Không xóa
                'is_user_send' => $isUserSend, // Nếu admin gửi thì is_user_send = 0
            ]);

            return response()->json(['status' => 'success', 'message' => 'Message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function checkUnreadMessages()
    {
        // Kiểm tra số lượng tin nhắn chưa đọc
        $unreadCount =   MailboxDetail::where('is_read_admin', 0)->count();
    
        return response()->json([
            'unreadCount' => $unreadCount
        ]);
    }
    public function loadMessages()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Bạn cần đăng nhập để sử dụng tính năng này.'
            ], 401);
        }

        // Lấy user ID
        $userId = Auth::id();

        // Lấy mailbox của người dùng
        $mailbox = Mailbox::where('user_id', $userId)->first();

        // Nếu không tìm thấy mailbox, trả về mảng rỗng
        if (!$mailbox) {
            return response()->json([
                'messages' => []
            ]);
        }

        // Lấy chi tiết tin nhắn
        $messages = MailboxDetail::where('mailbox_id', $mailbox->id)
            ->orderBy('sent_at', 'asc')
            ->get(['content', 'is_user_send', 'sent_at']);

        return response()->json([
            'messages' => $messages
        ]);
    }
    public function getUnreadMessages()
{
    if (!Auth::check()) {
        return response()->json(['unread_count' => 0]);
    }

    $userId = Auth::id();
    $unreadCount = MailboxDetail::whereHas('mailbox', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->where('is_read_user', 0)
    ->count();

    return response()->json(['unread_count' => $unreadCount]);
}
public function markMessagesAsRead()
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    $userId = Auth::id();
    MailboxDetail::whereHas('mailbox', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->where('is_read_user', 0)
    ->update(['is_read_user' => 1]);

    return response()->json(['success' => true]);
}
public function sendAdminMessage(Request $request)
{
    // Lấy user hiện tại
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Bạn cần đăng nhập.'], 401);
    }

    // Tìm mailbox dựa trên user_id
    $mailbox = Mailbox::where('user_id', $user->id)->first();

    // Nếu không có mailbox, tạo mới
    if (!$mailbox) {
        $mailbox = Mailbox::create([
            'user_id' => $user->id,
        ]);
    }

    // Tạo tin nhắn trong MailboxDetail
    $mailboxDetail = MailboxDetail::create([
        'mailbox_id' => $mailbox->id,
        'content' => $request->input('content'),
        'is_read_user' => 1,
        'is_read_admin' => 0,
        'is_user_send' => 1,
    ]);

    return response()->json(['message' => 'Tin nhắn đã được gửi.', 'data' => $mailboxDetail], 201);
}
public function getAIResponse(Request $request)
{
    $userMessage = $request->input('message');
    try {
        $response = Http::withOptions([
            'verify' => false,  // Tắt kiểm tra SSL
        ])->withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
        ]);

        if ($response->failed()) {
            $errorMessage = $response->body();  // Log the full response body to understand the error
        
            return response()->json(['error' => 'OpenAI API Error: ' . $errorMessage], 500);
        }

        $aiReply = $response->json()['choices'][0]['message']['content'];

        return response()->json(['aiReply' => $aiReply]);

    } catch (\Exception $e) {
        // Log the exception with detailed error message
      
        return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
    }
}


}
