<?php

namespace App\Http\Controllers;
use App\Libraries\QrCodeGenerator;
use Illuminate\Http\Request;
use App\Models\TheDaNang;
use App\Models\Transaction;
use App\Models\Order;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TheDaNangController extends Controller
{
    // Hàm hiển thị thẻ đa năng
    public function index()
    {
        $userId = Auth::id(); // Lấy ID của user hiện tại
        $theDaNang = TheDaNang::where('user_id', $userId)->first(); // Tìm thẻ của user hiện tại

        // Trả về view với thông tin thẻ nếu có
        return view('profile', compact('theDaNang'));
    }

    // Hàm mở thẻ đa năng
    public function openCard(Request $request)
    {
        $request->validate([
            'pin_code' => 'required|digits:6', // Kiểm tra mã PIN có đúng định dạng không
        ]);
    
        $userId = Auth::id(); // Lấy ID user hiện tại
    
        // Kiểm tra nếu người dùng đã có thẻ thì không cho phép tạo thẻ mới
        $existingCard = TheDaNang::where('user_id', $userId)->first();
        if ($existingCard) {
            return response()->json(['success' => false, 'message' => 'Bạn đã có thẻ đa năng.']);
        }
    
        // Tạo QR code ngẫu nhiên gồm 8 ký tự
        $qrCode = Str::random(24);
    
        // Tạo thẻ đa năng mới cho người dùng
        TheDaNang::create([
            'user_id' => $userId,
            'qr_code' => $qrCode,
            'so_du' => 0, // Số dư mặc định là 0
            'pin_code' => $request->pin_code, // Lưu mã PIN vào cơ sở dữ liệu
        ]);
    
        return response()->json(['success' => true, 'message' => 'Thẻ đa năng đã được mở thành công.']);
    }
public function generateQRCode()
{
    // Kiểm tra nếu người dùng đã đăng nhập
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Bạn cần đăng nhập để tạo mã QR.');
    }

    // Lấy dữ liệu mã QR từ bảng
    $userId = Auth::id();
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    // Kiểm tra xem người dùng có thẻ đa năng không
    if (!$theDaNang) {
        return redirect()->back()->with('error', 'Không tìm thấy thẻ đa năng cho người dùng.');
    }

    // Tạo mã QR chứa dữ liệu của người dùng
    $qrCodeData = $theDaNang->qr_code; // Lấy qr_code từ đối tượng TheDaNang

    // Sử dụng dịch vụ bên ngoài để tạo mã QR
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($qrCodeData) . "&size=300x300";

    // Tải mã QR về
    $qrCodeImage = file_get_contents($qrCodeUrl); // Lấy nội dung hình ảnh từ URL

    if ($qrCodeImage === false) {
        return redirect()->back()->with('error', 'Không thể tạo mã QR.');
    }

    // Trả về mã QR dưới dạng hình ảnh PNG
    return response($qrCodeImage)
        ->header('Content-Type', 'image/png') // Đặt loại nội dung
        ->header('Content-Disposition', 'attachment; filename="qrcode.png"'); // Tải xuống với tên tệp
}
public function updateCard(Request $request)
{
    $data = $request->validate([
        'pp_thanh_toan_1' => 'required|string',
        'ma_the_1' => 'required|string',
        'pp_thanh_toan_2' => 'nullable|string',
        'ma_the_2' => 'nullable|string',
    ]);

    $userId = Auth::user()->id; // Lấy ID người dùng đã đăng nhập

    // Kiểm tra xem người dùng có sẵn trong cơ sở dữ liệu chưa
    $existingCard = TheDaNang::where('user_id', $userId)->first();

    if (!$existingCard) {
        // Nếu không có bản ghi nào, trả về thông báo lỗi
        return response()->json(['message' => 'Không có thẻ nào để cập nhật.'], 404);
    }

    // Nếu đã có bản ghi, kiểm tra cột pp_thanh_toan_1 và pp_thanh_toan_2
    if (empty($existingCard->pp_thanh_toan_1)) {
        // Nếu pp_thanh_toan_1 chưa có, cập nhật nó
        $existingCard->pp_thanh_toan_1 = $data['pp_thanh_toan_1'];
        $existingCard->ma_the_1 = $data['ma_the_1'];
    } elseif (empty($existingCard->pp_thanh_toan_2)) {
        // Kiểm tra nếu pp_thanh_toan_2 chưa có
        if ($data['pp_thanh_toan_1'] !== $existingCard->pp_thanh_toan_1 &&
            $data['ma_the_1'] !== $existingCard->ma_the_1) {
            // Nếu pp_thanh_toan_1 và ma_the_1 khác với pp_thanh_toan_2 và ma_the_2, thì cập nhật
            $existingCard->pp_thanh_toan_2 = $data['pp_thanh_toan_2'];
            $existingCard->ma_the_2 = $data['ma_the_2'];
        } else {
            return response()->json(['message' => 'Thông tin thẻ không được trùng lặp.'], 400);
        }
    } else {
        // Nếu cả hai cột đều đã có, trả về thông báo lỗi
        return response()->json(['message' => 'Thông tin thẻ đã đầy đủ, không thể thêm thêm nữa.'], 400);
    }

    // Cập nhật thông tin thẻ
    $existingCard->save();

    return response()->json(['message' => 'Thông tin thẻ đã được lưu thành công'], 200);
}

public function fetchTransactions(Request $request)
{
    $user = Auth::user();
    $theDaNang = TheDaNang::where('user_id', $user->id)->first();

    if ($theDaNang) {
        $transactions = Transaction::where('the_da_nang_id', $theDaNang->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return response()->json($transactions);
    }

    return response()->json([]);
}

public function showScanner()
{
    return view('qr_scanner');
}
public function fetchTransactionsSummary(Request $request)
{
    $user = Auth::user(); // Lấy thông tin người dùng hiện tại
    $theDaNang = TheDaNang::where('user_id', $user->id)->first(); // Lấy thẻ đa năng của người dùng

    if (!$theDaNang) {
        return response()->json(['error' => 'TheDaNang not found.'], 404);
    }

    $timeFrame = $request->input('timeFrame', 'week'); // Lấy khoảng thời gian, mặc định là 'tuần'

    // Lấy dữ liệu giao dịch dựa trên khoảng thời gian
    $startDate = null;
    switch ($timeFrame) {
        case 'month':
            $startDate = now()->subMonth();
            break;
        case 'quarter':
            $startDate = now()->subQuarter();
            break;
        case 'week':
        default:
            $startDate = now()->subWeek();
            break;
    }

    // Lấy các giao dịch theo khoảng thời gian đã chọn
    $transactions = Transaction::where('the_da_nang_id', $theDaNang->id)
        ->where('created_at', '>=', $startDate)
        ->get();

    // Log để kiểm tra các giao dịch
    

    // Tính toán số lượng nạp tiền, rút tiền và thanh toán
    $summary = [
        'deposit' => $transactions->where('loai_giao_dich', 'nap')->sum('so_tien'),
        'withdraw' => $transactions->where('loai_giao_dich', 'rut')->sum('so_tien'),
        'payment' => $transactions->where('loai_giao_dich', 'thanh_toan')->sum('so_tien'),
    ];

    return response()->json($summary); // Trả về dữ liệu thống kê
}

public function changePin(Request $request)
{
    $request->validate([
        'old_pin' => 'required|digits:6',
        'new_pin' => 'required|digits:6',
    ]);

    // Kiểm tra nếu mã PIN cũ và mới không phải là số
    if (!ctype_digit($request->old_pin) || !ctype_digit($request->new_pin)) {
        return response()->json(['success' => false, 'message' => 'Mã PIN phải là số.']);
    }

    $userId = auth::user()->id; // Lấy ID người dùng hiện tại
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    // Kiểm tra mã PIN cũ
    if ($theDaNang->pin_code !== $request->old_pin) {
        return response()->json(['success' => false, 'message' => 'Mã PIN cũ không chính xác.']);
    }

    // Kiểm tra mã PIN mới có giống với mã PIN cũ không
    if ($theDaNang->pin_code === $request->new_pin) {
        return response()->json(['success' => false, 'message' => 'Mã PIN mới không được trùng với mã PIN cũ.']);
    }

    // Cập nhật mã PIN mới
    $theDaNang->pin_code = $request->new_pin;
    $theDaNang->save();

    return response()->json(['success' => true, 'message' => 'Đổi mã PIN thành công.']);
}
public function removePaymentMethod($method)
{
    $userId = auth::user()->id;
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    if ($method == 1) {
        $theDaNang->pp_thanh_toan_1 = null;
        $theDaNang->ma_the_1 = null;
    } elseif ($method == 2) {
        $theDaNang->pp_thanh_toan_2 = null;
        $theDaNang->ma_the_2 = null;
    }

    $theDaNang->save();

    return response()->json(['success' => true, 'message' => 'Đã xóa phương thức thanh toán thành công.']);
}
// Kiểm tra xem user có thẻ đa năng hay không
public function checkCard(Request $request)
{
    // Lấy ID người dùng hiện tại từ Auth
    $userId = auth::user()->id;

    // Tạm thời kiểm tra giá trị của $userId
    if (!$userId) {
        return response()->json(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập.']);
    }

    // Kiểm tra xem người dùng có thẻ đa năng hay không
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    if ($theDaNang) {
        // Lấy số dư thẻ
        $soDu = $theDaNang->so_du;

        // Kiểm tra số tiền cần thanh toán (có thể truyền từ request)
        $soTienCanThanhToan = $request->input('so_tien');

        // Trả về thông tin về thẻ
        return response()->json([
            'has_card' => true,
            'balance' => $soDu,
            'status' => ($soDu >= $soTienCanThanhToan) ? 'success' : 'error',
            'message' => ($soDu >= $soTienCanThanhToan) ? 'Số dư đủ để thanh toán.' : 'Số dư không đủ.'
        ]);
    } else {
        return response()->json(['has_card' => false, 'status' => 'error', 'message' => 'Bạn không có thẻ đa năng.']);
    }
}


// Kiểm tra mã PIN
public function checkPin(Request $request)
{
    // Lấy ID người dùng hiện tại từ Auth
    $userId = auth::user()->id;

    // Kiểm tra xem người dùng có thẻ đa năng hay không
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    if ($theDaNang) {
        $inputPin = $request->input('pin'); // Mã PIN từ người dùng nhập
        $storedPin = $theDaNang->pin_code; // Mã PIN lưu trữ trong database

        // Kiểm tra xem mã PIN người dùng nhập có đúng không
        if ($inputPin === $storedPin) {
            return response()->json(['valid_pin' => true, 'message' => 'Mã PIN đúng.']);
        } else {
            return response()->json(['valid_pin' => false, 'message' => 'Mã PIN không đúng.']);
        }
    } else {
        return response()->json(['valid_pin' => false, 'message' => 'Bạn không có thẻ đa năng.']);
    }
}
public function checkQrCode(Request $request)
{
    // Validate dữ liệu gửi lên
    $request->validate([
        'qr_code' => 'required|string|max:255', // Mã QR không được rỗng
    ]);

    // Lấy QR code từ request
    $qrCode = $request->input('qr_code');

    // Tìm mã QR trong bảng the_da_nang
    $theDaNang = TheDaNang::where('qr_code', $qrCode)->first();

    if ($theDaNang) {
        // Tìm người dùng tương ứng với mã thẻ
        $user = $theDaNang->user;

        // Lấy thông tin đơn hàng
        $orders = Order::where('user_id', $user->id)->where('is_deleted', false)->get();

        // Tính toán thông tin đơn hàng
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $canceledOrders = $orders->where('status', 'cancelled')->count();
        $totalAmountSpent = $orders->sum('total_amount');

        // Trả về thông tin người dùng, thẻ đa năng và đơn hàng
        return response()->json([
            'success' => true,
            'message' => 'Mã QR hợp lệ.',
            'user' => [
                'user_id' => $theDaNang->user_id,
                'name' => $user->name ?? 'Chưa cập nhật',
                'email' => $user->email ?? 'Chưa cập nhật',
                'phone' => $user->phone_number ?? 'Chưa cập nhật',
                'ma_benh_nhan' => $user->ma_benh_nhan ?? 'Chưa cập nhật',
                'gioi_tinh' => $user->gioi_tinh ?? 'Chưa cập nhật',
                'ngay_sinh' => $user->ngay_sinh ?? 'Chưa cập nhật',
                'address' => $user->address ?? 'Chưa cập nhật',
                'special_offer' => $user->special_offer ?? 'Chưa cập nhật',
                'ngay_dang_ky' => $user->created_at->format('d/m/Y') ?? 'Chưa cập nhật',
                'role' => $user->role ?? 'Chưa cập nhật',
                'is_block' => $user->is_block ? 'Có' : 'Không',
                'loyalty_points' => $user->loyalty_points ?? 'Chưa cập nhật',
                'avatar' => $user->avatar ?? 'images/user-default.png', // Avatar mặc định nếu không có
            ],
            'the_da_nang' => [
                'card_id' => $theDaNang->id,
                'card_balance' => $theDaNang->so_du, // Số dư thẻ
                'payment_method_1' => $theDaNang->pp_thanh_toan_1, // Phương thức thanh toán 1
                'card_number_1' => $theDaNang->ma_the_1, // Mã thẻ 1
                'payment_method_2' => $theDaNang->pp_thanh_toan_2 ?? 'Chưa cập nhật', // Phương thức thanh toán 2
                'card_number_2' => $theDaNang->ma_the_2 ?? 'Chưa cập nhật', // Mã thẻ 2
            ],
            'orders' => [
                'total_orders' => $totalOrders,
                'completed_orders' => $completedOrders,
                'pending_orders' => $pendingOrders,
                'canceled_orders' => $canceledOrders,
                'total_amount_spent' => $totalAmountSpent,
            ],
        ]);
    } else {
        // Nếu không tìm thấy mã QR trong hệ thống
        return response()->json([
            'success' => false,
            'message' => 'Mã QR không tồn tại trong hệ thống.',
        ], 404);
    }
}
public function checkPinDraw(Request $request) {
    $validated = $request->validate([
        'card_id' => 'required|integer',
        'pin' => 'required|string',
    ]);

    $theDaNang = TheDaNang::find($validated['card_id']);

    if (!$theDaNang) {
        return response()->json(['valid' => false, 'message' => 'Thẻ không tồn tại.'], 404);
    }

    // Kiểm tra mã PIN
    if ($theDaNang->pin_code === $validated['pin']) {
        return response()->json(['valid' => true]);
    }

    return response()->json(['valid' => false, 'message' => 'Mã PIN không đúng.']);
}

public function topUp(Request $request)
{
    $request->validate([
        'card_id' => 'required|exists:the_da_nang,id', // card_id phải tồn tại trong bảng the_da_nang
        'amount' => 'required|numeric|min:1',          // số tiền phải hợp lệ và lớn hơn 0
    ]);

    $cardId = $request->card_id;
    $amount = $request->amount;

    // Lấy tài khoản thẻ đa năng
    $theDaNang = TheDaNang::find($cardId);

    if (!$theDaNang) {
        return response()->json(['error' => 'Không tìm thấy tài khoản thẻ đa năng.'], 404);
    }

    // Cập nhật số dư
    $theDaNang->so_du += $amount;
    $theDaNang->save();

    // Thêm giao dịch vào bảng transactions
    Transaction::create([
        'the_da_nang_id' => $cardId,
        'loai_giao_dich' => 'nap',
        'so_tien' => $amount,
    ]);

    return response()->json(['message' => 'Nạp tiền thành công!', 'new_balance' => $theDaNang->so_du]);
}
public function withdraw(Request $request)
{
    $request->validate([
        'card_id' => 'required|exists:the_da_nang,id', // card_id phải tồn tại trong bảng the_da_nang
        'amount' => 'required|numeric|min:1',          // số tiền phải hợp lệ và lớn hơn 0
    ]);

    $cardId = $request->card_id;
    $amount = $request->amount;

    // Lấy tài khoản thẻ đa năng
    $theDaNang = TheDaNang::find($cardId);

    if (!$theDaNang) {
        return response()->json(['error' => 'Không tìm thấy tài khoản thẻ đa năng.'], 404);
    }

    // Kiểm tra số dư có đủ để rút hay không
    if ($theDaNang->so_du < $amount) {
        return response()->json(['error' => 'Số dư không đủ để thực hiện giao dịch.'], 400);
    }

    // Cập nhật số dư
    $theDaNang->so_du -= $amount;
    $theDaNang->save();

    // Thêm giao dịch vào bảng transactions
    Transaction::create([
        'the_da_nang_id' => $cardId,
        'loai_giao_dich' => 'rut',
        'so_tien' => $amount,
    ]);

    return response()->json(['message' => 'Rút tiền thành công!', 'new_balance' => $theDaNang->so_du]);
}
public function traCuuThe(Request $request)
{
    $qrCode = $request->query('qr_code');
    
    if (!$qrCode) {
        return response()->json(['error' => 'Không có mã QR!'], 400);
    }

    // Tìm kiếm mã QR trong bảng the_da_nang
    $card = TheDaNang::where('qr_code', $qrCode)->first();
    
    if ($card) {
        // Lấy tất cả các đơn hàng của user_id này, chưa bị xóa (is_deleted = 0)
        $ordersQuery = Order::where('user_id', $card->user_id)
                            ->where('is_deleted', 0);
        
        // Lọc theo trạng thái đơn hàng
        $status = $request->query('status');
        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Lọc theo thời gian
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        if ($startDate && $endDate) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Lấy danh sách đơn hàng theo các filter
        $orders = $ordersQuery->orderByRaw("FIELD(status, 'pending') DESC, created_at DESC")->get();

        return response()->json([
            'user_id' => $card->user_id,
            'orders' => $orders
        ]);
    } else {
        return response()->json(['error' => 'Không tìm thấy mã QR trong hệ thống!'], 404);
    }
}
public function getTheDaNangList(Request $request)
{
    // Lấy danh sách thẻ từ cơ sở dữ liệu
    $theDaNangList = TheDaNang::with('user')->get();

    // Trả về JSON để sử dụng với JavaScript
    return response()->json([
        'status' => 'success',
        'data' => $theDaNangList
    ]);
}
public function getTransactions(Request $request, $cardId)
{
    // Lọc giao dịch dựa trên thời gian và loại giao dịch
    $query = Transaction::where('the_da_nang_id', $cardId);

    // Lọc theo thời gian
    if ($request->has('from_date') && $request->has('to_date')) {
        $query->whereBetween('created_at', [$request->input('from_date'), $request->input('to_date')]);
    }

    // Lọc theo loại giao dịch
    if ($request->has('loai_giao_dich')) {
        $query->where('loai_giao_dich', $request->input('loai_giao_dich'));
    }

    // Lấy danh sách giao dịch
    $transactions = $query->orderBy('created_at', 'desc')->get();

    // Trả về JSON
    return response()->json([
        'status' => 'success',
        'data' => $transactions
    ]);
}
public function updatePin(Request $request, $id)
    {
        // Lấy dữ liệu từ request
        $newPin = $request->input('pin');
        $confirmPin = $request->input('confirm_pin');

        // Kiểm tra mã PIN và xác nhận mã PIN có khớp không
        if ($newPin !== $confirmPin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã PIN và Xác nhận mã PIN không khớp. Vui lòng thử lại.'
            ], 400);
        }

        // Kiểm tra thẻ có tồn tại không
        $card = TheDaNang::find($id);
        if (!$card) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thẻ không tồn tại.'
            ], 404);
        }

        // Cập nhật mã PIN (không mã hóa)
        $card->pin_code = $newPin;
        $card->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Mã PIN đã được cập nhật thành công.'
        ]);
    }
    public function transaction(Request $request, $id)
    {
        $card = TheDaNang::find($id);
        if (!$card) {
            return response()->json(['status' => 'error', 'message' => 'Thẻ không tồn tại.'], 404);
        }
    
        $type = $request->input('type'); // 'deposit' hoặc 'withdraw'
        $amount = $request->input('amount');
    
        // Kiểm tra loại giao dịch và xử lý số dư
        if ($type === 'deposit') {
            $card->so_du += $amount;
        } elseif ($type === 'withdraw') {
            if ($card->so_du < $amount) {
                return response()->json(['status' => 'error', 'message' => 'Số dư không đủ để rút.'], 400);
            }
            $card->so_du -= $amount;
        } else {
            return response()->json(['status' => 'error', 'message' => 'Loại giao dịch không hợp lệ.'], 400);
        }
    
        // Lưu thay đổi số dư vào bảng TheDaNang
        $card->save();
    
        // Tạo một bản ghi mới trong bảng transactions
        $transaction = new Transaction([
            'the_da_nang_id' => $card->id,
            'loai_giao_dich' => $type === 'deposit' ? 'nap' : 'rut',
            'so_tien' => $amount,
        ]);
        $transaction->save();
    
        return response()->json(['status' => 'success', 'message' => 'Giao dịch thành công.']);
    }
    public function getCardDetails($userId)
    {
        // Tìm thẻ của người dùng
        $card = TheDaNang::where('user_id', $userId)->first();

        if (!$card) {
            return response()->json(['status' => 'error', 'message' => 'Thẻ không tồn tại.'], 404);
        }

        // Lấy lịch sử giao dịch của thẻ
        $transactions = Transaction::where('the_da_nang_id', $card->id)->get();

        // Trả về thông tin thẻ và lịch sử giao dịch
        return response()->json([
            'status' => 'success',
            'card' => $card,
            'transactions' => $transactions
        ]);
    }
}
