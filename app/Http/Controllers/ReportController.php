<?php

namespace App\Http\Controllers;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Notification;
use App\Models\UserReact;
use App\Models\User;


use App\Models\CommentProduct;

use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{
    public function reportComment(Request $request)
    {
        try {
            // Kiểm tra và lấy dữ liệu từ request
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id', // Kiểm tra user_id tồn tại trong bảng users
                'report_type' => 'required|in:comment', // Chỉ cho phép báo cáo kiểu comment
                'content' => 'required|string', // Kiểm tra nội dung báo cáo
                'reportable_id' => 'required|integer', // Kiểm tra reportable_id là số nguyên (Không cần kiểm tra sự tồn tại)
                'admin_check' => 'required|boolean', // Kiểm tra admin_check là boolean
            ]);
    
            // Tạo mới báo cáo
            $report = new Report();
            $report->user_id = $validated['user_id'];
            $report->report_type = $validated['report_type'];
            $report->content = $validated['content'];
            $report->reportable_id = $validated['reportable_id'];
            $report->admin_check = $validated['admin_check'];
            $report->save();
    
            // Trả về phản hồi thành công
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Trả về lỗi nếu có
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function reportOrder(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id', // Kiểm tra order_id tồn tại
                'reason' => 'required|string|max:255',   // Lý do báo cáo
            ]);

            // Lưu báo cáo vào cơ sở dữ liệu
            $report = Report::create([
                'user_id' => Auth::id(),              // ID người dùng hiện tại
                'report_type' => 'order',            // Loại báo cáo là đơn hàng
                'content' => 'Báo cáo đơn hàng: ' . $validated['reason'], // Nội dung báo cáo
                'reportable_id' => $validated['order_id'],               // ID của đơn hàng được báo cáo
                             // Model của đối tượng được báo cáo
                'admin_check' => 0,                 // Đánh dấu chưa kiểm tra
            ]);

            // Phản hồi thành công
            return response()->json(['success' => true, 'message' => 'Báo cáo của bạn đã được gửi. Chúng tôi sẽ phản hồi sớm nhất.']);
        } catch (\Exception $e) {
            // Phản hồi lỗi
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }    
    public function showProductReports()
    {
        // Lấy tất cả sản phẩm, có bình luận bị báo cáo chưa kiểm tra
        $products = Product::with(['comments' => function ($query) {
            $query->whereHas('reports', function ($q) {
                $q->where('report_type', 'comment')
                  ->where('admin_check', 0);  // Chỉ lấy những báo cáo chưa được kiểm duyệt
            });
        }])
        ->get()
        ->sortByDesc(function ($product) {
            // Sắp xếp sản phẩm có báo cáo bình luận lên đầu
            return $product->comments->some(function ($comment) {
                return $comment->reports->contains(function ($report) {
                    return $report->report_type === 'comment' && $report->admin_check == 0;
                });
            });
        });
    
        // Chuyển đổi dữ liệu thành mảng để trả về JSON
        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->name,
                'comments' => $product->comments->map(function ($comment) {
                    return [
                        'comment_id' => $comment->id,
                        'user_name' => $comment->user->name,
                        'content' => $comment->content,
                        'reports' => $comment->reports->where('report_type', 'comment')->where('admin_check', 0)->map(function ($report) {
                            return [
                                'report_content' => $report->content,  // Thêm nội dung báo cáo từ bảng reports
                            ];
                        }),
                        'has_report' => $comment->reports->where('report_type', 'comment')->where('admin_check', 0)->count() > 0
                    ];
                })
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($data);
    }
    
    
    public function getProductComments($productId)
    {
        try {
            // Lấy tất cả bình luận của sản phẩm, bao gồm user_name từ bảng users và báo cáo nếu có
            $comments = CommentProduct::where('product_id', $productId)
                ->with('user', 'reports') // Lấy dữ liệu user và reports
                ->get();
    
            // Trả về bình luận của sản phẩm
            return response()->json([
                'comments' => $comments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi lấy bình luận.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function deleteComment($commentId)
    {
        try {
            // Tìm bình luận theo ID
            $comment = CommentProduct::find($commentId);
    
            // Nếu không tìm thấy bình luận, trả về lỗi
            if (!$comment) {
                return response()->json([
                    'message' => 'Bình luận không tồn tại.',
                    'error' => 'Comment with the provided ID does not exist.'
                ], 404);
            }
    
            // Xóa bình luận
            $comment->delete();
    
            return response()->json([
                'message' => 'Bình luận đã được xóa thành công.'
            ], 200);
        } catch (\Illuminate\Database\QueryException $qe) {
            // Xử lý lỗi liên quan đến database, ví dụ ràng buộc khóa ngoại
            return response()->json([
                'message' => 'Lỗi cơ sở dữ liệu xảy ra khi xóa bình luận.',
                'error' => $qe->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // Xử lý các lỗi chung khác
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi xóa bình luận.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function completeReport($commentId)
    {
        try {
            // Tìm các báo cáo liên quan đến commentId
            $reports = Report::where('report_type', 'comment')
                ->where('reportable_id', $commentId)
                ->where('admin_check', 0)
                ->get();
    
            // Nếu không tìm thấy báo cáo nào
            if ($reports->isEmpty()) {
                return response()->json(['message' => 'Không có báo cáo nào cần hoàn thành.'], 404);
            }
    
            // Cập nhật admin_check = 1 cho các báo cáo liên quan
            foreach ($reports as $report) {
                $report->update(['admin_check' => 1]);
    
                // Xóa báo cáo sau khi đã hoàn thành
                $report->delete();
            }
    
            return response()->json(['message' => 'Báo cáo đã được đánh dấu hoàn thành và xóa khỏi hệ thống.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi hoàn thành báo cáo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Phương thức để lấy các câu trả lời của một bình luận
    public function getReplies($commentId)
    {
        try {
            $replies = UserReact::where('react_comment_product_id', $commentId)
                ->with('user') // Nếu muốn lấy thông tin người trả lời
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'replies' => $replies
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy câu trả lời: ' . $e->getMessage()
            ], 500);
        }
    }    
    
    public function replyComment(Request $request, $commentId)
    {
        try {
            // Validate request
            $request->validate([
                'content' => 'required|string|max:1000'
            ]);

            // Kiểm tra xem bình luận có tồn tại không
            $comment = CommentProduct::findOrFail($commentId);

            // Tạo bản ghi trả lời trong user_react
            $userReact = UserReact::create([
                'user_id' => auth::id(), // ID người dùng hiện tại
                'react_comment_product_id' => $commentId, // ID bình luận được trả lời
                'like' => 0,
                'dislike' => 0,
                'reply' => $request->input('content'), // Nội dung trả lời
                'created_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trả lời bình luận thành công',
                'reply' => $userReact
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi trả lời bình luận: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getOrderReports()
    {
        try {
            // Lấy danh sách báo cáo loại 'order'
            $reports = Report::where('report_type', 'order')
                ->with('user') // Lấy thông tin người báo cáo
                ->get();
    
            // Chuẩn bị dữ liệu trả về
            $data = $reports->map(function ($report) {
                // Truy vấn thông tin đơn hàng bằng reportable_id
                $order = Order::find($report->reportable_id);
    
                return [
                    'order_id' => $report->reportable_id, // ID đơn hàng
                    'order_details' => $order ? [
                        'notes' => $order->notes ?? 'Không có ghi chú',
                        'total_amount' => $order->total_amount ?? 0,
                        'payment_method' => $order->payment_method ?? 'Không rõ',
                        'status' => $order->status ?? 'Không rõ',
                    ] : null, // Nếu không tìm thấy đơn hàng
                    'report_content' => $report->content, // Nội dung báo cáo
                    'report_user' => $report->user->name ?? 'Unknown', // Người báo cáo
                    'report_user_id' => $report->user_id, // ID người báo cáo
                ];
            });
    
            return response()->json(['success' => true, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function processReport(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $orderId = $request->input('order_id');
            $content = $request->input('content');

            // Tìm đơn hàng dựa vào order_id
            $order = Order::find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy đơn hàng.'
                ], 404);
            }

            // Tạo thông báo mới
            Notification::create([
                'user_id' => $order->user_id, // Lấy user_id từ đơn hàng
                'content' => $content, // Nội dung được nhập từ người dùng
                'type' => 'notification', // Loại thông báo
                'is_user_read' => false, // Đánh dấu chưa đọc
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã xử lý báo cáo và tạo thông báo thành công.'
            ]);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function completeReportOrder(Request $request)
    {
        try {
            // Lấy dữ liệu từ request
            $orderId = $request->input('order_id');

            // Tìm báo cáo liên quan đến đơn hàng
            $report = Report::where('reportable_id', $orderId)
                            ->where('report_type', 'order')
                            ->first();

            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy báo cáo cho đơn hàng này.'
                ], 404);
            }

            // Cập nhật trường admin_check thành 1 (hoàn thành)
            $report->admin_check = 1;
            $report->save();

            // Xóa báo cáo sau khi hoàn thành
            $report->delete();

            return response()->json([
                'success' => true,
                'message' => 'Báo cáo đã được hoàn thành và xóa thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getUsers(Request $request)
    {
        $activeUsers = User::where('is_admin', 0)->where('is_block', 0)->get();
        $blockedUsers = User::where('is_admin', 0)->where('is_block', 1)->get();

        return response()->json([
            'success' => true,
            'active_users' => $activeUsers,
            'blocked_users' => $blockedUsers,
        ]);
    }

    public function toggleBlockUser(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::find($userId);

        if (!$user || $user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể thay đổi trạng thái người dùng.',
            ]);
        }

        $user->is_block = !$user->is_block;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái tài khoản đã được cập nhật.',
            'is_block' => $user->is_block,
        ]);
    }
}
