<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use App\Models\Order; // Thay đổi nếu bạn sử dụng mô hình khác
use App\Models\OrderDetail; // Thay đổi nếu bạn sử dụng mô hình khác
use App\Models\Discount; // Thay đổi nếu bạn sử dụng mô hình khác
use App\Models\Notification; // Thay đổi nếu bạn sử dụng mô hình khác
use App\Models\LogOrders; // Thay đổi nếu bạn sử dụng mô hình khác

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
   // app/Http/Controllers/OrderController.php
   public function index()
{
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in to view your orders.');
    }

    $userId = Auth::user()->id;

    // Lấy tối đa 4 đơn hàng gần nhất, sắp xếp theo thời gian tạo mới nhất, và kiểm tra is_deleted = false
    $orders = Order::where('user_id', $userId)
                   ->where('is_deleted', false) // Thêm điều kiện này để không lấy các đơn hàng bị xóa
                   ->with('user')
                   ->orderBy('created_at', 'desc')
                   ->paginate(4); // Phân trang với 4 đơn hàng mỗi trang

    // Lấy chi tiết đơn hàng cho từng đơn hàng
    $orderDetails = [];
    foreach ($orders as $order) {
        $orderDetails[$order->id] = OrderDetail::where('order_id', $order->id)->get();
    }

    $user = Auth::user();
    $cartQuantity = 0;

    // Tìm giỏ hàng của người dùng
    $cart = Cart::where('user_id', $user->id)->first();

    if ($cart) {
        // Tính tổng số lượng sản phẩm trong giỏ hàng
        $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
    }

    return view('orders', compact('orders', 'orderDetails', 'cartQuantity'));
}
public function filterOrders(Request $request)
{
    $searchTerm = $request->get('search'); // ID hóa đơn
    $startDate = $request->get('start');
    $endDate = $request->get('end');
    $status = $request->get('status');

    $query = Order::query();

    // Tìm kiếm theo ID hóa đơn
    if ($searchTerm) {
        $query->where('id', $searchTerm);
    }

    // Lọc theo ngày tạo hóa đơn
    if ($startDate) {
        $query->where('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    // Lọc theo trạng thái
    if ($status) {
        $query->where('status', $status);
    }

    $orders = $query->get(); // Hoặc paginate() nếu cần phân trang

    return response()->json(['orders' => $orders]);
}

public function getOrderDetails($orderId)
{
    // Lấy thông tin đơn hàng
    $order = Order::where('id', $orderId)->first();

    // Lấy chi tiết đơn hàng và sản phẩm liên quan
    $orderDetails = OrderDetail::where('order_id', $orderId)
                    ->with('product') // Lấy thông tin sản phẩm từ bảng product
                    ->get();

    return response()->json([
        'order' => $order,
        'orderDetails' => $orderDetails
    ]);
}


   
public function cancelOrder($id)
{
    $order = Order::findOrFail($id);

    if ($order->status === 'pending') {
        $order->status = 'cancelled';
        $order->save();

        return response()->json(['status' => 'success', 'message' => 'Order has been canceled.']);
    }

    return response()->json(['status' => 'error', 'message' => 'Order cannot be canceled.']);
}



public function completeOrder($id)
{
    $order = Order::findOrFail($id);

    // Chỉ cho phép đánh dấu hoàn thành nếu trạng thái hiện tại là 'processing'
    if ($order->status === 'processing') {
        $order->status = 'completed'; // Cập nhật trạng thái thành 'completed'
        $order->save();

        return response()->json(['status' => 'success', 'message' => 'Order marked as completed.']);
    }

    return response()->json(['status' => 'error', 'message' => 'Order cannot be marked as completed.']);
}

public function softDelete($orderId)
{
    // Tìm order theo id
    $order = Order::find($orderId);

    // Kiểm tra nếu order tồn tại và chưa bị xóa
    if ($order && $order->is_deleted == false) {
        // Cập nhật is_deleted thành true
        $order->is_deleted = true;
        $order->save();

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Order has been deleted successfully.');
    }

    // Nếu order không tồn tại hoặc đã bị xóa, trả về lỗi
    return redirect()->back()->with('error', 'Order not found or already deleted.');
}
public function getExpenseData(Request $request)
{
    if (!auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $userId = auth::user()->id; // Giả định bạn có hệ thống xác thực user
    $period = $request->input('period', 'week'); // Lấy thời gian từ request

    $query = DB::table('orders')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
        ->where('user_id', $userId)
        ->where('status', '!=', 'cancelled') // Bỏ qua các đơn bị hủy
        ->groupBy(DB::raw('DATE(created_at)'));

    // Tùy chỉnh khoảng thời gian
    if ($period == 'week') {
        $query->where('created_at', '>=', Carbon::now()->subWeek());
    } elseif ($period == 'month') {
        $query->where('created_at', '>=', Carbon::now()->subMonth());
    } elseif ($period == 'quarter') {
        $query->where('created_at', '>=', Carbon::now()->subMonths(3));
    }

    $expenses = $query->get();

    return response()->json($expenses);
}
public function fetchOrders(Request $request)
{
    // Lấy tham số từ request
    $limit = $request->input('limit', 10); // Hiển thị mặc định 10
    $search = $request->input('search', '');
    $status = $request->input('status', 'all');
    $sort = $request->input('sort', 'date_desc'); // Sắp xếp mặc định: Ngày mới nhất

    // Khởi tạo query
    $query = Order::where('is_deleted', 0)->with(['user', 'shipping']);

    // Lọc theo trạng thái
    if ($status !== 'all') {
        $query->where('status', $status);
    }

    // Lọc theo từ khóa tìm kiếm (tìm theo id, user_id, hoặc user->name)
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('id', $search) // Tìm theo mã đơn hàng (id)
                ->orWhere('user_id', $search) // Tìm theo mã người dùng (user_id)
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%'); // Tìm theo tên người dùng
                });
        });
    }

    // Sắp xếp theo trạng thái ưu tiên "pending" lên đầu
    $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END");

    // Sắp xếp theo tham số
    if ($sort === 'date_asc') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Phân trang và lấy dữ liệu
    $orders = $query->paginate($limit);

    // Format dữ liệu trả về
    $data = $orders->map(function ($order) {
        return [
            'id' => $order->id,
            'user_name' => $order->user->name,
            'total_amount' => $order->total_amount,
            'status' => $this->mapStatus($order->status),
            'discount' => $order->discount_used ? Discount::find($order->discount_used)->name : '-',
            'shipping_info' => $order->shipping ? $order->shipping->room_name : 'Lấy hàng trực tiếp tại căn teen',
            'payment_method' => $order->payment_method,
            'notes' => $order->notes,
            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            'actions' => $this->generateActions($order),
        ];
    });

    return response()->json([
        'data' => $data,
        'total' => $orders->total(), // Tổng số đơn hàng
        'current_page' => $orders->currentPage(), // Trang hiện tại
        'last_page' => $orders->lastPage() // Trang cuối
    ]);
}



// Hàm chuyển đổi trạng thái
private function mapStatus($status)
{
    switch ($status) {
        case 'pending':
            return 'Đang chờ';
        case 'processing':
            return 'Đang vận chuyển';
        case 'cancelled':
            return 'Bị hủy';
        case 'completed':
            return 'Đã hoàn thành';
        default:
            return '-';
    }
}

// Hàm tạo nút tác vụ
private function generateActions($order)
{
    $actions = '';

    if ($order->status == 'pending') {
        $actions .= "<button class='btn btn-primary change-status' data-id='{$order->id}' data-status='processing'>Chuyển sang Đang vận chuyển</button>";
        $actions .= "<button class='btn btn-danger cancel-order' data-id='{$order->id}'>Hủy đơn hàng</button>";
    } elseif ($order->status == 'processing') {
        $actions .= "<button class='btn btn-success change-status' data-id='{$order->id}' data-status='completed'>Hoàn thành</button>";
    }

    if (in_array($order->status, ['completed', 'cancelled'])) {
        $actions .= "<button class='btn btn-danger delete-order' data-id='{$order->id}'>Xóa</button>";
    }

    return $actions;
}

// Thay đổi trạng thái đơn hàng
public function changeStatus(Request $request)
{
    $order = Order::findOrFail($request->id);

    // Lưu trạng thái cũ và trạng thái mới
    $oldStatus = $order->status;
    $newStatus = $request->status;

    // Cập nhật trạng thái đơn hàng
    $order->status = $newStatus;
    $order->save();

    // Xác định trạng thái chuyển đổi
    $statusMapping = [
        'processing' => $oldStatus === 'pending' ? 'pending -> processing' : 'unknown',
        'completed' => $oldStatus === 'processing' ? 'processing -> completed' : 'unknown',
        'cancelled' => $oldStatus === 'pending' ? 'pending -> cancelled' : 'unknown',
    ];

    $statusChange = $statusMapping[$newStatus] ?? 'unknown';

    // Thêm log hành động
    LogOrders::create([
        'action' => 'update',
        'action_content' => "Admin ID: " . auth::id() . " đã thay đổi trạng thái đơn hàng #{$order->id} từ {$statusChange}",
        'admin_id' => auth::id(),
    ]);

    return response()->json(['message' => 'Cập nhật trạng thái thành công!']);
}


// Hủy đơn hàng
public function cancelOrderAdmin(Request $request)
{
    $order = Order::findOrFail($request->id);

    // Lưu lý do hủy nếu có
    $reason = $request->reason ?: 'Chưa có lý do';

    // Thực hiện hủy đơn hàng
    $order->status = 'cancelled';
    $order->save();

    // Tạo thông báo cho người dùng
    $notification = new Notification();
    $notification->user_id = $order->user_id;
    $notification->content = "Đơn hàng #{$order->id} của bạn đã bị hủy vì lý do: {$reason}";
    $notification->type = 'notification';  // Loại thông báo là 'order'
    $notification->is_user_read = 0;  // Mặc định là chưa đọc
    $notification->save();

    // Ghi log hủy đơn hàng
    LogOrders::create([
        'action' => 'cancel',
        'action_content' => "Admin ID: " . auth::id() . " đã hủy đơn hàng #{$order->id} với lý do: {$reason}",
        'admin_id' => auth::id(),
    ]);

    return response()->json(['message' => 'Hủy đơn hàng và thông báo thành công!']);
}


// Xóa đơn hàng
public function deleteOrder($id)
{
    $order = Order::findOrFail($id);

    // Đánh dấu đơn hàng là đã xóa
    $order->is_deleted = 1;
    $order->save();

    // Ghi log xóa đơn hàng
    LogOrders::create([
        'action' => 'delete',
        'action_content' => "Admin ID: " . auth::id() . " đã xóa đơn hàng #{$order->id}",
        'admin_id' => auth::id(),
    ]);

    return response()->json(['message' => 'Xóa đơn hàng thành công!']);
}


// Hiển thị chi tiết đơn hàng
public function fetchOrderDetails($orderId)
{
    $orderDetails = OrderDetail::where('order_id', $orderId)
        ->with(['product'])
        ->get();

    $data = $orderDetails->map(function ($detail) {
        return [
            'product_image' => $detail->product->image, // Cột ảnh từ bảng sản phẩm
            'product_code' => $detail->product->id,
            'product_name' => $detail->product->name,
            'quantity' => $detail->quantity,
            'amount' => $detail->amount,
        ];
    });

    return response()->json(['data' => $data]);
}

public function getReportOrder($orderId)
{
    // Lấy đơn hàng theo orderId
    $order = Order::with(['shipping', 'orderDetails.product'])->find($orderId);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    // Lấy thông tin discount, nếu có
    $discount = null;
    if ($order->discount_used) {
        $discount = Discount::find($order->discount_used);
    }

    // Lấy thông tin shipping, nếu có
    $shipping = $order->shipping;

    // Lấy chi tiết đơn hàng
    $orderDetails = $order->orderDetails;

    $products = [];
    foreach ($orderDetails as $orderDetail) {
        $product = $orderDetail->product;
        $products[] = [
            'product_code' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => $orderDetail->quantity,
            'total_amount' => $orderDetail->amount
        ];
    }

    // Cấu trúc dữ liệu trả về
    $data = [
        'order_id' => $order->id,
        'user_name' => $order->user->name,
        'total_amount' => $order->total_amount,
        'status' => $order->status,
        'payment_method' => $order->payment_method,
        'discount' => $discount ? $discount->name . " - " . $discount->discount_amount : 'No Discount',
        'shipping_fee' => $shipping ? $shipping->shipping_fee : 0,
        'shipping_room' => $shipping ? $shipping->room_name : 'Not Provided',
        'products' => $products,
        'created_at' => $order->created_at,
        'admin' => auth::user()->name,
    ];

    return response()->json($data);
}
public function traCuuDonHang(Request $request)
{
    $userId = $request->query('user_id');
    $status = $request->query('status');
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    // Xây dựng truy vấn để lọc theo user_id và các bộ lọc
    $query = Order::where('user_id', $userId)->where('is_deleted', 0);

    // Lọc theo trạng thái nếu có
    if ($status) {
        $query->where('status', $status);
    }

    // Lọc theo ngày nếu có
    if ($startDate || $endDate) {
        if ($startDate && !$endDate) {
            $query->where('created_at', '>=', $startDate);
        } elseif (!$startDate && $endDate) {
            $query->where('created_at', '<=', $endDate);
        } else {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    // Lấy các đơn hàng của người dùng, bao gồm cả chi tiết hóa đơn và tên sản phẩm
    $orders = $query->orderBy('created_at', 'asc')
                    ->with(['orderDetails.product']) // Nạp trước orderDetails và product
                    ->get();

    return response()->json(['orders' => $orders]);
}

public function getInitialStats() 
{
    $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $cancelledOrders = Order::where('status', 'cancelled')->count();

    // Tính tỉ lệ thanh toán bằng thẻ
    $totalCardPayments = Order::where('payment_method', 'Thẻ đa năng')->count();
    $cardPaymentRate = $totalCardPayments / $totalOrders * 100;

    // Tỉ lệ hủy đơn
    $cancelledOrderRate = $cancelledOrders / $totalOrders * 100;

    // Tỉ lệ hoàn thành đơn
    $completedOrderRate = ($totalOrders - $pendingOrders - $cancelledOrders) / $totalOrders * 100;

    // Tỉ lệ đơn hàng đang xử lý
    $pendingOrderRate = $pendingOrders / $totalOrders * 100;

    // Số lượng đơn hàng trung bình mỗi ngày
    $minCreatedAt = Order::min('created_at');
    $totalDays = $minCreatedAt ? \Carbon\Carbon::parse($minCreatedAt)->diffInDays(\Carbon\Carbon::now()) : 0;
    
    // Tránh trường hợp chia cho 0 hoặc số ngày âm
    if ($totalDays <= 0) {
        $totalDays = 1; // Mặc định là 1 nếu không có đơn hàng hoặc thời gian không hợp lệ
    }
    
    $avgOrdersPerDay = $totalOrders / $totalDays; // Tính trung bình số đơn hàng mỗi ngày

    // Chuẩn bị dữ liệu biểu đồ
    $chartData = $this->prepareChartData();

    return response()->json([
        'stats' => [
            ['label' => 'Tổng doanh thu', 'value' => $totalRevenue],
            ['label' => 'Tổng số đơn hàng', 'value' => $totalOrders],
            ['label' => 'Đơn hàng đang xử lý', 'value' => $pendingOrders],
            ['label' => 'Đơn hàng đã hủy', 'value' => $cancelledOrders],
            ['label' => 'Tỉ lệ thanh toán thẻ', 'value' => number_format($cardPaymentRate, 2) . '%'],
            ['label' => 'Tỉ lệ hủy đơn', 'value' => number_format($cancelledOrderRate, 2) . '%'],
            ['label' => 'Tỉ lệ hoàn thành', 'value' => number_format($completedOrderRate, 2) . '%'],
            ['label' => 'Tỉ lệ đơn hàng đang xử lý', 'value' => number_format($pendingOrderRate, 2) . '%'],
            ['label' => 'Đơn hàng trung bình mỗi ngày', 'value' => number_format($avgOrdersPerDay, 2)],
        ],
        'chartData' => $chartData,
    ]);
}


// API: Lọc dữ liệu thống kê
public function filterStats(Request $request)
{
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');
    $status = $request->query('status');

    $query = Order::query();

    if ($startDate) {
        $query->where('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    if ($status) {
        $query->where('status', $status);
    }

    $filteredOrders = $query->get();

    // Thống kê
    $totalRevenue = $filteredOrders->where('status', 'completed')->sum('total_amount');
    $totalOrders = $filteredOrders->count();
    $pendingOrders = $filteredOrders->where('status', 'pending')->count();
    $cancelledOrders = $filteredOrders->where('status', 'cancelled')->count();

    // Chuẩn bị dữ liệu biểu đồ
    $chartData = $this->prepareChartData($filteredOrders);

    return response()->json([
        'stats' => [
            ['label' => 'Tổng doanh thu', 'value' => $totalRevenue],
            ['label' => 'Tổng số đơn hàng', 'value' => $totalOrders],
            ['label' => 'Đơn hàng đang xử lý', 'value' => $pendingOrders],
            ['label' => 'Đơn hàng đã hủy', 'value' => $cancelledOrders],
        ],
        'chartData' => $chartData,
    ]);
}

// Hàm chuẩn bị dữ liệu biểu đồ
private function prepareChartData($orders = null)
{
    if (is_null($orders)) {
        $orders = Order::all();
    }

    $dataByMonth = $orders->groupBy(function ($order) {
        return \Carbon\Carbon::parse($order->created_at)->format('Y-m');
    });

    $labels = $dataByMonth->keys()->toArray();
    $data = $dataByMonth->map(function ($orders) {
        return $orders->sum('total_amount');
    })->values()->toArray();

    return [
        'labels' => $labels,
        'datasets' => [
            [
                'label' => 'Doanh thu theo tháng',
                'data' => $data,
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
            ],
        ],
    ];
}
public function fetchOrderHistory(Request $request)
{
    // Lấy các tham số lọc
    $dateFrom = $request->input('date_from');
    $dateTo = $request->input('date_to');
    $action = $request->input('action', 'all');

    // Khởi tạo query
    $query = LogOrders::query();

    // Lọc theo ngày
    if (!empty($dateFrom)) {
        $query->whereDate('created_at', '>=', $dateFrom);
    }
    if (!empty($dateTo)) {
        $query->whereDate('created_at', '<=', $dateTo);
    }

    // Lọc theo loại hành động
    if ($action !== 'all') {
        $query->where('action', $action);
    }

    // Lấy dữ liệu
    $logs = $query->orderBy('created_at', 'desc')->get();

    // Định dạng ngày tháng và chuẩn bị dữ liệu trả về
    $formattedLogs = $logs->map(function ($log) {
        return [
            'id' => $log->id,
            'action' => $log->action,
            'action_content' => $log->action_content,
            'admin_id' => $log->admin_id,
            'created_at' => \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s'), // Định dạng ngày
            'updated_at' => \Carbon\Carbon::parse($log->updated_at)->format('d-m-Y H:i:s')  // Định dạng ngày
        ];
    });

    // Trả về JSON
    return response()->json($formattedLogs);
}


public function generateOrderReport(Request $request)
{
    // Lấy các tham số từ request
    $dateFrom = $request->input('date_from');
    $dateTo = $request->input('date_to');

    // Kiểm tra khoảng thời gian
    $fromDate = Carbon::parse($dateFrom);
    $toDate = Carbon::parse($dateTo);
    $diffDays = $fromDate->diffInDays($toDate);

    // Kiểm tra nếu date_to lớn hơn ngày hôm nay
    if ($toDate->gt(Carbon::today())) {
        return response()->json(['error' => 'Ngày kết thúc không hợp lệ, không được lớn hơn ngày hôm nay'], 400);
    }

    // Kiểm tra nếu khoảng thời gian nhỏ hơn 15 ngày
    if ($diffDays <= 15) {
        return response()->json(['error' => 'Khoảng thời gian phải lớn hơn 15 ngày'], 400);
    }

    // Kiểm tra nếu khoảng thời gian lớn hơn 90 ngày
    if ($diffDays >= 90) {
        return response()->json(['error' => 'Khoảng thời gian phải nhỏ hơn 90 ngày'], 400);
    }

    // Lọc đơn hàng trong khoảng thời gian
    $orders = Order::whereBetween('created_at', [$dateFrom, $dateTo])
                   ->where('is_deleted', 0)
                   ->with(['orderDetails', 'user', 'shipping'])
                   ->get();

    // Tính tổng tiền và số lượng sản phẩm
    $totalOrders = $orders->count();
    $totalAmount = $orders->sum('total_amount');
    $totalProductsSold = $orders->sum(function ($order) {
        return $order->orderDetails->sum('quantity');
    });

    // Thống kê theo trạng thái
    $statusStats = $orders->groupBy('status')->map(function ($group) {
        return $group->count();
    });

    // Thống kê theo phương thức thanh toán
    $paymentMethodStats = $orders->groupBy('payment_method')->map(function ($group) {
        return $group->count();
    });

    // Thống kê số lượng sản phẩm bán chạy nhất
    $topProducts = OrderDetail::whereIn('order_id', $orders->pluck('id'))
        ->groupBy('product_id')
        ->selectRaw('product_id, sum(quantity) as total_sold')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->get();

    // Thống kê số lượng khách hàng mới (khách hàng lần đầu tiên mua)
    $newCustomers = $orders->where('user_id', '!=', null)
        ->groupBy('user_id')
        ->count();

    // Dữ liệu cho báo cáo
    $reportData = [
        'total_orders' => $totalOrders,
        'total_amount' => $totalAmount,
        'total_products_sold' => $totalProductsSold,
        'status_stats' => $statusStats,
        'payment_method_stats' => $paymentMethodStats,
        'top_products' => $topProducts,
        'new_customers' => $newCustomers,
        'orders' => $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'total_amount' => $order->total_amount,
                'total_products_sold' => $order->orderDetails->sum('quantity'),
                'status' => $order->status,
            ];
        })
    ];

    return response()->json($reportData);
}


}

