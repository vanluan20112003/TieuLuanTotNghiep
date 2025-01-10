<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Cart;
use App\Models\User;
use App\Models\Notification;


use App\Models\CartDetail;
use App\Models\PostComment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PostController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index()
    {
        $cartQuantity = 0;
    
        $user = Auth::user();
        if ($user) {
            // Tìm giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                // Tính tổng số lượng sản phẩm trong giỏ hàng
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
            }
        }
    
        // Lấy danh sách bài viết và đếm số lượng bình luận cho mỗi bài
        $posts = Post::where('is_deleted', false)
            ->withCount('comments') // Đếm số lượng bình luận
            ->orderBy('created_at', 'desc') // Sắp xếp theo `created_at` giảm dần
            ->get();
    
        return view('post', compact('posts', 'cartQuantity')); // Trả về view với biến $posts
    }
    


    // Hiển thị form tạo bài viết
    public function create()
    {
        return view('posts.create');
    }
    public function show($id)
    {
        $user = Auth::user();
        $cartQuantity = 0;
    
        // Nếu người dùng đã đăng nhập, tính số lượng sản phẩm trong giỏ hàng
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
            }
        }
    
        // Lấy bài viết hiện tại theo ID và tăng lượt xem lên 1
        $post = Post::findOrFail($id); 
        $post->views = $post->views + 1;  // Tăng lượt xem
        $post->save();  // Lưu lại bài viết
    
        // Lấy 5 bài viết có lượt xem cao nhất, ngoại trừ bài viết hiện tại
        $suggestedPosts = Post::where('id', '!=', $id)  // Không lấy bài viết hiện tại
                              ->orderBy('views', 'desc') // Sắp xếp theo lượt xem giảm dần
                              ->take(5)  // Lấy tối đa 5 bài viết
                              ->get();
    
        return view('post_detail', compact('post', 'cartQuantity', 'suggestedPosts'));
    }
    
    
    
    // Lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string', // Nếu bạn sử dụng upload, thay đổi điều kiện này
            'content' => 'required|string',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được tạo thành công!');
    }

    // Hiển thị bài viết
   
    // Hiển thị form chỉnh sửa bài viết
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string', // Nếu bạn sử dụng upload, thay đổi điều kiện này
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    // Xóa bài viết (đánh dấu xóa)
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->is_deleted = true;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
    public function getComments($postId)
    {
        $loggedInUserId = auth::id();
    
        $comments = PostComment::where('post_id', $postId)
            ->with('user') // Lấy thông tin người dùng
            ->orderBy('created_at', 'desc') // Sắp xếp bình luận mới nhất lên đầu
            ->get();
    
        return response()->json([
            'comments' => $comments,
            'loggedInUserId' => $loggedInUserId,
        ]);
    }
    

    // Thêm bình luận
    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
    
        // Kiểm tra nếu người dùng đã bình luận bài viết này
        $hasCommented = PostComment::where('post_id', $postId)
                                   ->where('user_id', Auth::id())
                                   ->exists();
    
        if ($hasCommented) {
            return response()->json(['error' => 'Bạn đã bình luận bài viết này rồi!'], 400);
        }
    
        // Lưu bình luận mới
        $comment = new PostComment();
        $comment->post_id = $postId;
        $comment->user_id = Auth::id(); // Lấy ID của người dùng hiện tại
        $comment->content = $request->content;
        $comment->save();
    
        return response()->json($comment);
    }
    
    public function editComment(Request $request, $commentId)
    {
        // Lấy thông tin người dùng hiện tại
        $userId = Auth::id();

        // Tìm bình luận theo ID
        $comment = PostComment::find($commentId);

        // Kiểm tra nếu bình luận không tồn tại
        if (!$comment) {
            return response()->json([
                'success' => false,
                'message' => 'Bình luận không tồn tại.'
            ], 404);
        }

        // Kiểm tra quyền chỉnh sửa (chỉ chủ sở hữu bình luận mới được sửa)
        if ($comment->user_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền chỉnh sửa bình luận này.'
            ], 403);
        }

        // Validate dữ liệu từ request
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Cập nhật nội dung bình luận
        $comment->content = $validatedData['content'];
        $comment->updated_at = now();
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Bình luận đã được cập nhật thành công.',
            'comment' => $comment
        ]);
    }
    public function getPosts()
    {
        // Lấy tất cả bài viết chưa xóa
        $posts = Post::where('is_deleted', false)->get();

        return response()->json($posts);
    }

    // Lấy chi tiết bài viết và bình luận
    public function getPostDetail($id)
    {
        // Lấy bài viết theo ID
        $post = Post::findOrFail($id);

        // Lấy các bình luận của bài viết
        $comments = PostComment::where('post_id', $id)
            ->with('user')  // Lấy thông tin người dùng liên quan
            ->get();

        // Trả về dữ liệu bài viết và bình luận dưới dạng JSON
        return response()->json([
            'post' => $post,
            'comments' => $comments,
        ]);
    }
    public function destroyComment($postId, $commentId)
    {
        // Tìm bình luận theo postId và commentId
        $comment = PostComment::where('post_id', $postId)
                              ->where('id', $commentId)
                              ->first();

        if ($comment) {
            // Xóa bình luận
            $comment->delete();
            return response()->json(['message' => 'Bình luận đã được xóa']);
        }

        return response()->json(['message' => 'Bình luận không tồn tại'], 404);
    }
    public function updatePost(Request $request, $postId)
    {
        // Lấy bài viết từ CSDL
        $post = Post::find($postId);
    
        if (!$post) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
    
        // Cập nhật các trường dữ liệu bài viết
        $post->title = $request->input('title', $post->title);
        $post->description = $request->input('description', $post->description);
        $post->type = $request->input('type', $post->type);
        $post->content = $request->input('content', $post->content);
    
        // Xử lý ảnh bìa mới nếu có
        if ($request->hasFile('cover_image')) {
            // Lấy file ảnh từ request
            $coverImage = $request->file('cover_image');
    
            // Đặt tên file ảnh mới
            $imageName = 'post_' . $postId . '.' . $coverImage->getClientOriginalExtension();
    
            // Đường dẫn lưu file trong thư mục public/images
            $coverImagePath = 'images/' . $imageName;
    
            // Xóa ảnh cũ nếu có
            if ($post->cover_image && file_exists(public_path($post->cover_image))) {
                unlink(public_path($post->cover_image));
            }
    
            // Lưu ảnh mới vào thư mục public/images
            $coverImage->move(public_path('images'), $imageName);
    
            // Cập nhật đường dẫn ảnh bìa mới vào DB
            $post->cover_image = $coverImagePath;
        }
    
        // Lưu thay đổi vào CSDL
        $post->save();
    
        // Trả về phản hồi JSON thành công
        return response()->json(['success' => true, 'message' => 'Bài viết đã được lưu!']);
    }
    public function addPost(Request $request)
    {
        try {
            // Bước 1: Tạo bản ghi mới trong database để lấy post_id
            $post = new Post();
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->type = $request->input('type');
            $post->content = $request->input('content');
            $post->save();
    
            // Bước 2: Lưu ảnh bìa nếu có
            if ($request->hasFile('cover_image')) {
                // Lấy file ảnh từ request
                $coverImage = $request->file('cover_image');
    
                // Đặt tên file ảnh mới (post_id)
                $imageName = 'post_' . $post->id . '.' . $coverImage->getClientOriginalExtension();
    
                // Đường dẫn lưu file trong thư mục public/images
                $coverImagePath = 'images/' . $imageName;
    
                // Xóa ảnh cũ nếu có
                if ($post->cover_image && file_exists(public_path($post->cover_image))) {
                    unlink(public_path($post->cover_image));
                }
    
                // Lưu ảnh mới vào thư mục public/images
                $coverImage->move(public_path('images'), $imageName);
    
                // Cập nhật đường dẫn ảnh bìa mới vào DB
                $post->cover_image = $coverImagePath;
            }
    
            $post->save();
    
            // Bước 3: Gửi thông báo đến tất cả người dùng nếu checkbox được chọn
            if ($request->input('send_notification') == 1) {
                $users = User::all(); // Lấy tất cả user từ database
    
                foreach ($users as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'content' => 'LuanHospital vừa đăng một bài viết mới: ' . $post->title,
                        'type' => 'notification', // Loại thông báo
                        'is_user_read' => 0, // Mặc định chưa đọc
                    ]);
                }
            }
    
            // Trả về kết quả thành công
            return response()->json(['success' => true, 'message' => 'Bài viết đã được thêm thành công!']);
        } catch (\Exception $e) {
            // Trả về lỗi nếu có
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function deletePost($postId, Request $request)
    {
        // Tìm bài viết theo ID
        $post = Post::find($postId);

        // Kiểm tra nếu bài viết tồn tại
        if (!$post) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại.']);
        }

        // Cập nhật trường is_delete thành 1
        $post->is_deleted = 1;
        $post->save();

        // Trả về kết quả thành công
        return response()->json(['success' => true, 'message' => 'Bài viết đã bị xóa.']);
    }
    public function getPostStatistics(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()); // Mặc định 1 tháng trước
        $endDate = $request->input('end_date', Carbon::now());

        // Lấy thống kê lượt xem
        $postViews = Post::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('title, views')
            ->orderBy('views', 'desc')
            ->get();

        // Lấy thống kê số lượng bình luận theo bài viết
        $postComments = PostComment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('post_id, COUNT(*) as total_comments')
            ->groupBy('post_id')
            ->orderByDesc('total_comments')
            ->get();

        // Lấy thống kê số lượng bài viết theo ngày
        $postsPerDay = Post::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_posts')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Lấy thống kê số lượng bình luận theo ngày
        $commentsPerDay = PostComment::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_comments')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'success' => true,
            'views' => $postViews,
            'comments' => $postComments,
            'posts_per_day' => $postsPerDay,
            'comments_per_day' => $commentsPerDay
        ]);
    }
}
