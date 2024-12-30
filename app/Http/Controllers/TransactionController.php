<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TheDaNang;
use App\Models\Transaction;

use App\Models\Notification;

use App\Models\PendingTransaction;
class TransactionController extends Controller
{
    public function withdraw()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập trước.');
        }
    
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();
    
        // Kiểm tra người dùng đã có thẻ đa năng chưa
        $theDaNang = TheDaNang::where('user_id', $user->id)->first();
    
        if (!$theDaNang) {
            return redirect('/profile')->with('error', 'Bạn chưa đăng ký thẻ đa năng. Vui lòng đăng ký trước.');
        }
    
        // Lấy các giao dịch đang chờ (pending transactions) của thẻ đa năng
        $pendingTransactions = PendingTransaction::where('the_da_nang_id', $theDaNang->id)
            ->where('status', 'pending')  // Sử dụng trạng thái 'pending' thay vì STATUS_PENDING
            ->get();
    
        // Trả về view với thông tin thẻ, tên người dùng và các giao dịch đang chờ
        return view('withdraw', [
            'userName' => $user->name,
            'theDaNang' => $theDaNang,
            'pendingTransactions' => $pendingTransactions, // Gửi dữ liệu giao dịch đang chờ tới view
        ]);
    }
    
 public function verifyPin(Request $request)
{
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập trước.']);
    }

    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();

    // Kiểm tra người dùng đã có thẻ đa năng chưa
    $theDaNang = TheDaNang::where('user_id', $user->id)->first();

    if (!$theDaNang) {
        return response()->json(['success' => false, 'message' => 'Bạn chưa đăng ký thẻ đa năng.']);
    }

    // Lấy mã PIN nhập vào từ frontend
    $pin = $request->input('pin');

    // Kiểm tra mã PIN với giá trị trong cơ sở dữ liệu (ví dụ, so sánh với cột 'so_du' hoặc cột 'pin')
    if ($pin === $theDaNang->pin_code) {
        return response()->json(['success' => true, 'message' => 'Mã PIN hợp lệ.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Mã PIN sai.']);
    }
}
public function checkTransactionStatus(Request $request)
{
    // Kiểm tra người dùng đã đăng nhập chưa
    if (!Auth::check()) {
        return response()->json(['error' => 'Vui lòng đăng nhập trước.']);
    }

    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();

    // Lấy thẻ đa năng của người dùng
    $theDaNang = TheDaNang::where('user_id', $user->id)->first();

    if (!$theDaNang) {
        return response()->json(['error' => 'Bạn chưa đăng ký thẻ đa năng. Vui lòng đăng ký trước.']);
    }

    // Kiểm tra giao dịch đang ở trạng thái chờ
    $pendingTransaction = PendingTransaction::where('the_da_nang_id', $theDaNang->id)
    ->where('status', 'pending')  // Kiểm tra trạng thái 'pending'
    ->first();


    if ($pendingTransaction) {
        return response()->json(['error' => 'Bạn đang có một giao dịch đang chờ duyệt. Vui lòng chờ để chúng tôi xử lý.']);
    }

    // Kiểm tra loại giao dịch được chọn và số tiền
    $transactionType = $request->input('transactionType');
    $amount = $request->input('amount');

    if ($transactionType === 'withdraw') {
        // Kiểm tra số dư của thẻ người dùng
        if ($theDaNang->so_du < $amount) {
            return response()->json(['error' => 'Số dư không đủ để thực hiện giao dịch rút tiền.']);
        }
    }

    // Nếu không có giao dịch đang chờ và số dư đủ
    return response()->json(['success' => 'Giao dịch có thể thực hiện.']);
}
public function handleTransaction(Request $request)
{
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!auth::check()) {
        return redirect()->route('home'); // Nếu chưa đăng nhập, chuyển về trang home
    }

    // Lấy thông tin người dùng
    $userId = auth::id();

    // Lấy thông tin thẻ đa năng của người dùng từ bảng TheDaNang
    $theDaNang = TheDaNang::where('user_id', $userId)->first();

    // Kiểm tra nếu người dùng không có thẻ đa năng
    if (!$theDaNang) {
        return response()->json(['message' => 'Bạn chưa có thẻ đa năng.'], 400);
    }

    // Lấy thông tin từ yêu cầu
    $transactionType = $request->input('transaction_type'); // Loại giao dịch: 'nap' hoặc 'rut'
    $amount = $request->input('amount'); // Số tiền giao dịch
    $evidence = $request->file('evidence'); // File minh chứng (chỉ cho nạp tiền)
    $bankInfo =$request->input('bank_info');
    // Kiểm tra loại giao dịch
    if ($transactionType === 'rut') {
        // Giao dịch rút tiền
        // Kiểm tra số dư của thẻ có đủ hay không
        if ($theDaNang->so_du < $amount) {
            return response()->json(['message' => 'Số dư của bạn không đủ để thực hiện giao dịch này.'], 400);
        }

        // Tạo đối tượng PendingTransaction cho giao dịch rút tiền
        $pendingTransaction = PendingTransaction::create([
            'transaction_type' => 'rut',
            'the_da_nang_id' => $theDaNang->id, // Sử dụng ID của thẻ đa năng
            'amount' => $amount,
            'bank_info'=>$bankInfo,
            'status' => PendingTransaction::STATUS_PENDING,
        ]);

        return response()->json(['message' => 'Yêu cầu rút tiền đã được tạo. Chờ xử lý.'], 200);
    } elseif ($transactionType === 'nap') {
        // Giao dịch nạp tiền
        if (!$evidence) {
            return response()->json(['message' => 'Vui lòng cung cấp minh chứng cho giao dịch nạp tiền.'], 400);
        }

        // Tạo đối tượng PendingTransaction trước để lấy ID
        $pendingTransaction = PendingTransaction::create([
            'transaction_type' => 'nap',
            'the_da_nang_id' => $theDaNang->id, // Sử dụng ID của thẻ đa năng
            'amount' => $amount,
            'status' => PendingTransaction::STATUS_PENDING,
        ]);

        // Lưu file minh chứng
        $fileName = $pendingTransaction->id . '_PendingTransaction.' . $evidence->getClientOriginalExtension();
        $evidence->move(public_path('images'), $fileName);

        // Cập nhật đường dẫn file minh chứng vào đối tượng giao dịch
        $pendingTransaction->update([
            'evidence' => $fileName,
        ]);

        return response()->json(['message' => 'Yêu cầu nạp tiền đã được tạo. Chờ xử lý.'], 200);
    } else {
        return response()->json(['message' => 'Loại giao dịch không hợp lệ.'], 400);
    }
}
public function cancelTransaction($id)
{
    // Kiểm tra xem giao dịch có tồn tại không
    $transaction = PendingTransaction::find($id);

    if (!$transaction) {
        return response()->json(['message' => 'Giao dịch không tồn tại.'], 404);
    }

    // Kiểm tra trạng thái giao dịch có phải "pending" không
    if ($transaction->status != 'pending') {
        return response()->json(['message' => 'Giao dịch không thể hủy.'], 400);
    }

    // Thực hiện hủy giao dịch
    $transaction->delete();

    return response()->json(['message' => 'Giao dịch đã được hủy.']);
}
public function checkPendingTransactions()
{
    // Lấy tất cả giao dịch có trạng thái 'pending'
    $pendingTransactions = PendingTransaction::where('status', 'pending')->get();

    // Kiểm tra xem có giao dịch nào hay không
    $hasPending = $pendingTransactions->isNotEmpty();

    // Trả về kết quả (true nếu có giao dịch pending, false nếu không)
    return response()->json(['hasPending' => $hasPending]);
}
public function renderPendingTransactionList()
{
    // Lấy tất cả các giao dịch có trạng thái pending
    $pendingTransactions = PendingTransaction::where('status', 'pending') // Lọc theo status = 'pending'
                                             ->get();

    // Trả về dữ liệu dưới dạng JSON cho frontend
    return response()->json([
        'pendingTransactions' => $pendingTransactions
    ]);
}

    // Phương thức hiển thị chi tiết giao dịch pending
    public function showPendingTransactionDetails($id)
    {
        // Lấy giao dịch có trạng thái 'pending' với ID tương ứng
        $transaction = PendingTransaction::find($id);
    
        if (!$transaction) {
            return response()->json(['message' => 'Giao dịch không tồn tại.'], 404);
        }
    
        // Lấy thông tin chi tiết thẻ đa năng (the_da_nang)
        $theDaNang = $transaction->theDaNang;
    
        // Lấy thông tin người dùng (card holder) từ bảng Users nếu cần
        $user = $theDaNang ? $theDaNang->user : null;
    
        // Trả về thông tin chi tiết giao dịch
        return response()->json([
            'transaction' => [
                'id' => $transaction->id,
                'type' => $transaction->transaction_type, // 'nap' hoặc 'rút'
                'bank_info' => $transaction->bank_info, // 'nap' hoặc 'rút'
                'cardNumber' => $transaction->theDaNang->id, // Số thẻ
                'cardHolder' => $user ? $user->name : 'Không có thông tin', // Chủ thẻ
                'user_id' => $user ? $user->id : null, // Thêm thông tin user_id
                'balance' => $theDaNang ? $theDaNang->getFormattedBalanceAttribute() : 'N/A', // Số dư
                'raw_amount' => $transaction->amount, // Số tiền chưa định dạng (dưới dạng số)
                'amount' => number_format($transaction->amount, 0, ',', '.') . ' ₫', // Số tiền
                'timestamp' => $transaction->created_at->format('d/m/Y H:i'), // Thời gian giao dịch
                'proofImage' => $transaction->evidence, // Minh chứng nếu có
            ]
        ]);
    }
    



    public function doneTransaction(Request $request, $id)
    {
        // Tìm giao dịch cần xử lý
        $transaction = PendingTransaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Giao dịch không tồn tại.'], 404);
        }

        // Chỉ xử lý giao dịch đang ở trạng thái 'pending'
        if ($transaction->status !== 'pending') {
            return response()->json(['message' => 'Giao dịch này đã được xử lý.'], 400);
        }

        $action = $request->input('action'); // 'approve' hoặc 'reject'

        if ($action === 'reject') {
            // Kiểm tra lý do từ chối
            $reason = $request->input('reason');
            if (!$reason) {
                return response()->json(['message' => 'Vui lòng cung cấp lý do từ chối.'], 400);
            }

            // Cập nhật trạng thái thành 'rejected'
            $transaction->status = 'rejected';
            $transaction->save();

            // Ghi thông báo vào bảng notifications
            Notification::create([
                'user_id' => $transaction->theDaNang->user_id, // Liên kết user từ thẻ
                'content' => "Yêu cầu nạp/rút tiền của bạn đã bị từ chối vì lý do: $reason",
                'type' => 'notification',
                'is_user_read' => false,
            ]);

            return response()->json(['message' => 'Giao dịch đã bị từ chối.'], 200);
        }

        if ($action === 'approve') {
            // Phê duyệt giao dịch
            $transaction->status = 'approved';
            $transaction->save();

            // Tùy chỉnh logic nếu cần (VD: Cập nhật số dư...)
            return response()->json(['message' => 'Giao dịch đã được phê duyệt.'], 200);
        }

        return response()->json(['message' => 'Hành động không hợp lệ.'], 400);
    }
    public function updateStatus($id, Request $request)
    {
        $transaction = PendingTransaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();
    
        return response()->json(['message' => 'Cập nhật trạng thái thành công']);
    }
    public function updateBalance($id, Request $request)
    {
        $theDaNang = TheDaNang::findOrFail($id);
        $theDaNang->so_du += $request->amount; // Trừ tiền nếu số âm
        $theDaNang->save();
    
        return response()->json(['message' => 'Cập nhật số dư thành công']);
    }
    public function sendNotification($userId, Request $request)
    {
        $notification = new Notification();
        $notification->user_id = $userId;
        $notification->content = $request->content;
        $notification->type = $request->type;
        $notification->save();
    
        return response()->json(['message' => 'Thông báo đã được gửi']);
    }
    public function createTransaction(Request $request)
    {
        $transaction = new Transaction();
        $transaction->the_da_nang_id = $request->the_da_nang_id;
        $transaction->loai_giao_dich = $request->loai_giao_dich;
        $transaction->so_tien = $request->so_tien;
        $transaction->save();
    
        return response()->json(['message' => 'Giao dịch mới đã được tạo']);
    }
                
}
