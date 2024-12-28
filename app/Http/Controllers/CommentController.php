<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserReact;
use App\Models\User;
use App\Models\Product;


use App\Models\CommentProduct;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function addOrUpdateComment(Request $request, Product $product) 
{
    try {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'star_rating' => 'required|integer|between:1,5'
        ]);

        // Kiểm tra user đã đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để bình luận'
            ], 401);
        }

        $user = Auth::user();
        
        // Tìm comment cũ
        $comment = CommentProduct::where('product_id', $product->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($comment) {
            // Cập nhật comment
            $comment->update([
                'content' => $validated['content'],
                'star_rating' => $validated['star_rating']
            ]);
            $message = 'Cập nhật bình luận thành công.';
        } else {
            // Tạo comment mới
            $comment = CommentProduct::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'content' => $validated['content'],
                'star_rating' => $validated['star_rating']
            ]);
            $message = 'Thêm bình luận mới thành công.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'userName' => $user->name,
            'content' => $comment->content,
            'star_rating' => $comment->star_rating,
            'created_at' => $comment->created_at
        ]);

    } catch (\Exception $e) {
       
        return response()->json([
            'status' => 'error',
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}
    // Lấy danh sách các reply của một bình luận
    public function getReplies($comment_id) 
    {
        // Tìm comment dựa trên ID
        $comment = CommentProduct::findOrFail($comment_id);
    
        // Lấy ID của người dùng hiện tại
        $currentUserId = Auth::id();
    
        // Lấy tất cả các reply thuộc comment này từ bảng user_react và kết hợp với bảng users
        $replies = UserReact::where('react_comment_product_id', $comment_id)
            ->whereNotNull('reply')
            ->join('users', 'user_react.user_id', '=', 'users.id') // Thực hiện join với bảng users
            ->select('user_react.*', 'users.is_admin', 'users.name', 'users.avatar') // Lấy thông tin admin, tên và avatar
            ->orderByRaw('CASE WHEN users.is_admin = 1 THEN 1 WHEN users.id = ? THEN 2 ELSE 3 END', [$currentUserId]) // Ưu tiên admin và người dùng hiện tại
            ->orderBy('user_react.updated_at', 'desc')
            ->paginate(2);
    
        // Trả về JSON cho Ajax
        return response()->json([
            'status' => 'success',
            'replies' => $replies,
            'userid'=> $currentUserId
        ]);
    }
    

    // Thêm một reply mới vào bình luận
    public function submitReply(Request $request, $comment_id)
{
    // Lấy ID người dùng hiện tại
    $currentUserId = Auth::id();

    // Kiểm tra xem phản hồi đã tồn tại hay chưa
    $reply = UserReact::where('react_comment_product_id', $comment_id)
                      ->where('user_id', $currentUserId)
                      ->first();

    if ($reply) {
        // Nếu tồn tại, cập nhật lại phản hồi
        $reply->reply = $request->input('reply_content');
        $reply->save();
    } else {
        // Nếu không tồn tại, tạo mới
        UserReact::create([
            'react_comment_product_id' => $comment_id,
            'user_id' => $currentUserId,
            'reply' => $request->input('reply_content'),
            'like' => 0,
            'dislike' => 0,
            
        ]);
    }

    // Trả về JSON cho Ajax
    return response()->json(['status' => 'success']);
}
public function getComments($product_id)
{
    // Lấy danh sách bình luận từ bảng comment_products theo product_id
    $comments = CommentProduct::where('product_id', $product_id)
        ->with('user') // Nạp thông tin người dùng liên quan
        ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
        ->paginate(2); // Phân trang, mỗi trang 5 bình luận

    // Trả về JSON cho Ajax
    return response()->json([
        'status' => 'success',
        'comments' => $comments->items(), // Chỉ lấy mảng bình luận
        'current_page' => $comments->currentPage(),
        'last_page' => $comments->lastPage(),
        'total' => $comments->total(),
    ]);
}

    // Xóa reply
    public function deleteReply($reply_id)
    {
        // Tìm reply theo ID trong bảng user_react
        $reply = UserReact::findOrFail($reply_id);

        // Kiểm tra xem người dùng có quyền xóa reply không
        if ($reply->user_id == auth::id() || auth::user()->is_admin) {
            $reply->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Reply deleted successfully.'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'You are not authorized to delete this reply.'
        ]);
    }
    public function like(Request $request)
{
    $request->validate(['comment_id' => 'required|exists:comment_products,id']);
    $userId = Auth::id();
    $commentId = $request->input('comment_id');

    // Tìm comment
    $comment = CommentProduct::find($commentId);
    
    // Kiểm tra phản hồi của người dùng
    $userReact = UserReact::where('user_id', $userId)
        ->where('react_comment_product_id', $commentId)
        ->first();

    if ($userReact) {
        if ($userReact->like) {
            // Nếu đã like rồi, chỉ cần giảm like
            $userReact->like = false;
            $comment->likes -= 1; // Giảm số lượng like
        } else {
            // Nếu đã dislike, giảm dislike rồi tăng like
            if ($userReact->dislike) {
                $userReact->dislike = false;
                $comment->dislikes -= 1; // Giảm số lượng dislike
            }
            $userReact->like = true;
            $comment->likes += 1; // Tăng số lượng like
        }
        $userReact->updated_at = now();
        $userReact->save();
    } else {
        // Nếu chưa có phản hồi, tạo mới
        UserReact::create([
            'user_id' => $userId,
            'react_comment_product_id' => $commentId,
            'like' => true,
            'dislike' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $comment->likes += 1; // Tăng số lượng like
    }

    $comment->save();

    return response()->json(['likes' => $comment->likes, 'dislikes' => $comment->dislikes]);
}

public function dislike(Request $request)
{
    $request->validate(['comment_id' => 'required|exists:comment_products,id']);
    $userId = Auth::id();
    $commentId = $request->input('comment_id');

    // Tìm comment
    $comment = CommentProduct::find($commentId);

    // Kiểm tra phản hồi của người dùng
    $userReact = UserReact::where('user_id', $userId)
        ->where('react_comment_product_id', $commentId)
        ->first();

    if ($userReact) {
        if ($userReact->dislike) {
            // Nếu đã dislike rồi, chỉ cần giảm dislike
            $userReact->dislike = false;
            $comment->dislikes -= 1; // Giảm số lượng dislike
        } else {
            // Nếu đã like, giảm like rồi tăng dislike
            if ($userReact->like) {
                $userReact->like = false;
                $comment->likes -= 1; // Giảm số lượng like
            }
            $userReact->dislike = true;
            $comment->dislikes += 1; // Tăng số lượng dislike
        }
        $userReact->updated_at = now();
        $userReact->save();
    } else {
        // Nếu chưa có phản hồi, tạo mới
        UserReact::create([
            'user_id' => $userId,
            'react_comment_product_id' => $commentId,
            'like' => false,
            'dislike' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $comment->dislikes += 1; // Tăng số lượng dislike
    }

    $comment->save();

    return response()->json(['likes' => $comment->likes, 'dislikes' => $comment->dislikes]);
}
}
