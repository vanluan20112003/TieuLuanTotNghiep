<?php

namespace App\Http\Controllers;

use App\Models\BanAn;
use App\Models\DatBan;
use App\Models\LogTables;
use App\Models\Cart;
use App\Models\CartDetail;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
class BanAnController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, điều hướng sang trang đăng nhập
            return redirect()->route('login');
        }
    
        $userId = Auth::id();
        $currentDateTime = Carbon::now();
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
    
        // Lấy thông tin đặt bàn của người dùng hiện tại với trạng thái không phải "confirmed" và "cancelled", có thời gian rời đi sau thời điểm hiện tại
        $currentReservation = DatBan::where('user_id', $userId)
            ->whereNotIn('trang_thai', ['confirmed', 'cancelled'])
            ->where('thoi_gian_roi', '>', $currentDateTime)
            ->first();
    
        // Lấy tất cả bàn ăn
        $banAn = BanAn::all();
    
        // Truyền dữ liệu bàn ăn và thông tin đặt bàn của người dùng vào view
        return view('contact', compact('banAn', 'currentReservation', 'cartQuantity'));
    }
    
    public function store(Request $request)
{
    $userId = Auth::id();

    // Lấy thông tin đặt bàn mới từ request
    $newReservationStart = $request->thoi_gian_dat;
    $newReservationEnd = $request->thoi_gian_roi;

    // Kiểm tra xem khoảng thời gian mới có bị trùng với bất kỳ đặt bàn nào đã có không
    $overlappingReservations = DatBan::where('ban_an_id', $request->ban_an_id)
        ->where('trang_thai', 'pending')
        ->where(function($query) use ($newReservationStart, $newReservationEnd) {
            $query->whereBetween('thoi_gian_dat', [$newReservationStart, $newReservationEnd])
                  ->orWhereBetween('thoi_gian_roi', [$newReservationStart, $newReservationEnd])
                  ->orWhere(function($query) use ($newReservationStart, $newReservationEnd) {
                      $query->where('thoi_gian_dat', '<=', $newReservationStart)
                            ->where('thoi_gian_roi', '>=', $newReservationEnd);
                  });
        })
        ->exists(); // Kiểm tra sự tồn tại

    if ($overlappingReservations) {
        return response()->json(['success' => false, 'message' => 'Khoảng thời gian đặt bị trùng với thời gian đã có.']);
    }

    // Nếu không có trùng lặp, tiến hành lưu đặt bàn mới
    $reservation = new DatBan([
        'ban_an_id' => $request->ban_an_id,
        'user_id' => $userId,
        'thoi_gian_dat' => $newReservationStart,
        'thoi_gian_roi' => $newReservationEnd,
        'trang_thai' => 'pending', // trạng thái mặc định là pending
    ]);

    if ($reservation->save()) {
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Không thể đặt bàn']);
    }
}

public function fetchTables()
{
    $userId = Auth::id();
    $currentDateTime = Carbon::now();

    // Lấy thông tin đặt bàn của người dùng hiện tại
    $currentReservation = DatBan::where('user_id', $userId)
        ->where('thoi_gian_roi', '>', $currentDateTime)
        ->whereNotIn('trang_thai', ['confirmed', 'cancelled'])
        ->first();

    // Lấy tất cả bàn ăn
    $banAn = BanAn::all();

    return response()->json([
        'banAn' => $banAn,
        'currentReservation' => $currentReservation
    ]);
}
public function cancelReservation(Request $request, $id)
{
    $reservation = DatBan::find($id);

    if (!$reservation || $reservation->trang_thai !== 'pending') {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy đặt bàn hoặc trạng thái không hợp lệ.']);
    }

    $reservation->trang_thai = 'cancelled';

    if ($reservation->save()) {
        return response()->json(['success' => true, 'message' => 'Đặt bàn đã được hủy thành công.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra trong quá trình hủy đặt bàn.']);
    }
}


public function getAvailableTimes($tableId)
{
    $currentDateTime = Carbon::now()->addHour();
    $endDateTime = Carbon::now()->addHours(48);
    $availableTimes = [];

    // Lấy tất cả các đặt bàn trong khoảng 48 giờ tới
    $reservations = DatBan::where('ban_an_id', $tableId)
        ->where('thoi_gian_roi', '>', $currentDateTime)
        ->where('thoi_gian_dat', '<', $endDateTime)
        ->where('trang_thai', 'pending')
        ->orderBy('thoi_gian_dat')
        ->get();

    // Lặp qua từng ngày trong khoảng 48 giờ
    $currentDate = $currentDateTime->copy()->startOfDay();
    while ($currentDate <= $endDateTime->copy()->startOfDay()) {
        $dayStart = $currentDate->copy()->setHour(8)->setMinute(0);
        $dayEnd = $currentDate->copy()->setHour(19)->setMinute(0);

        // Điều chỉnh thời gian bắt đầu nếu là ngày hiện tại
        if ($currentDate->isToday()) {
            $dayStart = max($dayStart, $currentDateTime);
        }

        // Điều chỉnh thời gian kết thúc nếu vượt quá 48 giờ
        if ($dayEnd > $endDateTime) {
            $dayEnd = $endDateTime;
        }

        // Bỏ qua nếu thời gian bắt đầu đã qua thời gian kết thúc của ngày
        if ($dayStart->lt($dayEnd)) {
            $dailySlots = $this->calculateDailySlots($dayStart, $dayEnd, $reservations);
            $availableTimes = array_merge($availableTimes, $dailySlots);
        }

        $currentDate->addDay();
    }

    return response()->json($availableTimes);
}

private function calculateDailySlots($dayStart, $dayEnd, $reservations)
{
    $slots = [];
    $currentTime = $dayStart;
    $minimumMinutes = 16; // Thời gian tối thiểu là 16 phút

    // Lọc các đặt bàn trong ngày
    $dayReservations = $reservations->filter(function ($reservation) use ($dayStart, $dayEnd) {
        $reservationStart = Carbon::parse($reservation->thoi_gian_dat);
        $reservationEnd = Carbon::parse($reservation->thoi_gian_roi);
        return $reservationStart->lt($dayEnd) && $reservationEnd->gt($dayStart);
    })->sortBy('thoi_gian_dat');

    foreach ($dayReservations as $reservation) {
        $reservationStart = Carbon::parse($reservation->thoi_gian_dat);
        $reservationEnd = Carbon::parse($reservation->thoi_gian_roi);

        // Kiểm tra và thêm khoảng trống trước đặt bàn nếu đủ 16 phút
        if ($currentTime->lt($reservationStart)) {
            $diffInMinutes = $currentTime->diffInMinutes($reservationStart);
            if ($diffInMinutes >= $minimumMinutes) {
                $slots[] = [
                    'date' => $currentTime->format('Y-m-d'),
                    'start_time' => $currentTime->format('H:i'),
                    'end_time' => $reservationStart->format('H:i')
                ];
            }
        }

        $currentTime = $reservationEnd;
    }

    // Kiểm tra và thêm khoảng trống cuối cùng của ngày nếu đủ 16 phút
    if ($currentTime->lt($dayEnd)) {
        $diffInMinutes = $currentTime->diffInMinutes($dayEnd);
        if ($diffInMinutes >= $minimumMinutes) {
            $slots[] = [
                'date' => $currentTime->format('Y-m-d'),
                'start_time' => $currentTime->format('H:i'),
                'end_time' => $dayEnd->format('H:i')
            ];
        }
    }

    return $slots;
}
public function getAllTables()
{
    // Lấy tất cả bàn ăn từ cơ sở dữ liệu
    $tables = BanAn::all();

    // Lấy lịch đặt cho mỗi bàn, chỉ lấy các lịch đặt có trạng thái 'pending' hoặc 'confirmed' và thời gian đặt trong tương lai
    $tablesWithSchedules = $tables->map(function ($table) {
        // Lấy các lịch đặt cho bàn này trong tương lai với trạng thái 'pending' hoặc 'confirmed'
        $schedules = DatBan::where('ban_an_id', $table->id)
            ->where('thoi_gian_dat', '>', now()) // Chỉ lấy các lịch đặt trong tương lai
            ->whereIn('trang_thai', ['pending', 'confirmed'])
            ->get();

        // Thêm thông tin lịch đặt vào bảng
        $table->schedules = $schedules;

        return $table;
    });

    // Trả về dữ liệu dưới dạng JSON
    return response()->json($tablesWithSchedules);
}

public function updateName(Request $request, $id): JsonResponse
{
    // Tìm bàn ăn theo ID
    $table = BanAn::find($id);

    if (!$table) {
        return response()->json(['message' => 'Bàn không tồn tại'], 404);
    }

    // Validate dữ liệu đầu vào
    $request->validate([
        'ten_ban' => 'required|string|max:255',
    ]);

    // Lưu lại tên bàn cũ
    $oldName = $table->ten_ban;

    // Cập nhật tên bàn mới
    $table->ten_ban = $request->input('ten_ban');
    $table->save();

    // Ghi log vào bảng log_tables
    LogTables::create([
        'action' => 'update', // Hành động là update
        'action_content' => 'Admin ' . Auth::id() . ' đã cập nhật tên bàn từ "' . $oldName . '" -> "' . $table->ten_ban . '"',
        'admin_id' => Auth::id(), // Lấy admin id từ Auth
    ]);

    // Trả về phản hồi thành công
    return response()->json([
        'message' => 'Tên bàn đã được cập nhật',
        'table' => $table,
    ]);
}
public function updateStatus(Request $request, $id): JsonResponse
{
    try {
        // Tìm bàn ăn theo ID
        $table = BanAn::findOrFail($id);
        
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'status' => 'required|in:available,not_available',
        ]);

        // Lưu trạng thái cũ
        $oldStatus = $table->status;

        // Cập nhật trạng thái mới
        $table->status = $validatedData['status'];
        $table->save();

        // Ghi log vào bảng log_tables
        LogTables::create([
            'action' => 'update', // Hành động là update
            'action_content' => 'Admin ' . Auth::id() . ' đã cập nhật trạng thái bàn từ "' . $oldStatus . '" -> "' . $table->status . '"',
            'admin_id' => Auth::id(), // Lấy admin id từ Auth
        ]);

        return response()->json([
            'message' => 'Trạng thái bàn đã được cập nhật',
            'table' => $table
        ]);
    } catch (\Exception $e) {
        // Log lỗi chi tiết
        return response()->json([
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}
// Lấy danh sách bàn ăn (API cho giao diện)
public function getSchedule($tableId)
{
    $currentDateTime = now();

    // Lấy lịch đặt hiện tại và trong tương lai của bàn với trạng thái là pending
    $upcomingSchedules = DatBan::where('ban_an_id', $tableId)
        ->where('thoi_gian_dat', '>', $currentDateTime)
        ->where('trang_thai', 'pending') // Lọc theo trạng thái pending
        ->get();

    // Lấy lịch sử đặt bàn đã có (tất cả các trạng thái) trong quá khứ
    $pastSchedules = DatBan::where('ban_an_id', $tableId)
        
        ->get();

    return response()->json([
        'upcomingSchedules' => $upcomingSchedules,
        'pastSchedules' => $pastSchedules,
    ]);
}
public function approveSchedule($scheduleId): JsonResponse
{
    // Tìm lịch đặt theo ID
    $schedule = DatBan::find($scheduleId);

    // Kiểm tra nếu không tìm thấy lịch đặt
    if (!$schedule) {
        return response()->json(['message' => 'Lịch đặt không tồn tại'], 404);
    }

    // Kiểm tra trạng thái của lịch đặt phải là pending mới có thể duyệt
    if ($schedule->trang_thai != 'pending') {
        return response()->json(['message' => 'Lịch đặt không ở trạng thái pending'], 400);
    }

    // Cập nhật trạng thái lịch đặt thành confirmed
    $schedule->trang_thai = 'confirmed';
    $schedule->save();

    // Ghi log vào bảng log_tables
    LogTables::create([
        'action' => 'approve', // Hành động là approve
        'action_content' => 'Admin ' . Auth::id() . ' đã phê duyệt đặt bàn ID ' . $schedule->id,
        'admin_id' => Auth::id(), // Lấy admin id từ Auth
    ]);

    return response()->json([
        'message' => 'Lịch đặt đã được duyệt',
        'schedule' => $schedule,
    ]);
}
// Không duyệt lịch đặt
public function rejectSchedule($scheduleId): JsonResponse
{
    // Tìm lịch đặt theo ID
    $schedule = DatBan::find($scheduleId);

    // Kiểm tra nếu không tìm thấy lịch đặt
    if (!$schedule) {
        return response()->json(['message' => 'Lịch đặt không tồn tại'], 404);
    }

    // Kiểm tra trạng thái của lịch đặt phải là pending mới có thể không duyệt
    if ($schedule->trang_thai != 'pending') {
        return response()->json(['message' => 'Lịch đặt không ở trạng thái pending'], 400);
    }

    // Cập nhật trạng thái lịch đặt thành cancelled
    $schedule->trang_thai = 'cancelled';
    $schedule->save();

    // Ghi log vào bảng log_tables
    LogTables::create([
        'action' => 'reject', // Hành động là reject
        'action_content' => 'Admin ' . Auth::id() . ' đã từ chối đặt bàn ID ' . $schedule->id,
        'admin_id' => Auth::id(), // Lấy admin id từ Auth
    ]);

    return response()->json([
        'message' => 'Lịch đặt đã không được duyệt',
        'schedule' => $schedule,
    ]);
}public function getBookedTables()
{
    $currentDateTime = now();

    // Lấy các lịch đặt có trạng thái pending hoặc confirmed và thời gian đặt sau thời điểm hiện tại
    $bookedTables = DatBan::whereIn('trang_thai', ['pending', 'confirmed'])
        ->where('thoi_gian_dat', '>', $currentDateTime)
        ->with('user') // Liên kết với bảng user để lấy thông tin người đặt
        ->get();

    // Trả về dữ liệu dưới dạng JSON
    return response()->json($bookedTables);
}
public function getTablesWithPendingBookings()
{
    $currentDateTime = now();

    // Lấy tất cả bàn ăn và kiểm tra lịch đặt của bàn trong tương lai
    $tables = BanAn::with(['datBan' => function($query) use ($currentDateTime) {
        $query->whereIn('trang_thai', ['pending', 'confirmed'])
              ->where('thoi_gian_dat', '>', $currentDateTime);
    }])->get();

    return response()->json($tables);
}
public function getSchedulesForExcel()
{
    // Lấy ngày hiện tại và ngày 30 ngày trước
    $today = Carbon::now();
    $thirtyDaysAgo = Carbon::now()->subDays(30);

    // Lấy tất cả các lịch sử đặt bàn trong vòng 30 ngày
    $schedules = DatBan::whereBetween('thoi_gian_dat', [$thirtyDaysAgo, $today])
        ->with('banAn') // Tải quan hệ 'banAn' (bàn ăn)
        ->get();

    // Chuyển đổi dữ liệu thành dạng cần thiết cho việc xuất Excel
    $exportData = $schedules->map(function ($schedule) {
        return [
            'ID Người Dùng' => $schedule->user_id,
            'Tên Bàn' => optional($schedule->banAn)->ten_ban, // Sử dụng optional để tránh lỗi nếu quan hệ là null
            'Thời Gian Đặt' => $schedule->thoi_gian_dat,
            'Thời Gian Trả' => $schedule->thoi_gian_roi,
            'Trạng Thái' => $schedule->trang_thai,
        ];
    });

    // Trả về dữ liệu dưới dạng JSON
    return response()->json($exportData);
}
public function getDatBanDetails($userId)
{
    // Lấy các lịch sử đặt bàn hiện tại hoặc tương lai với trạng thái là pending hoặc confirmed
    $currentAndFutureSchedules = DatBan::where('user_id', $userId)
        ->where(function ($query) {
            $query->where('trang_thai', 'pending')
                ->orWhere('trang_thai', 'confirmed');
        })
        ->where('thoi_gian_dat', '>=', Carbon::now())
        ->get();

    // Lấy tối đa 5 lịch sử đặt bàn trước đó
    $pastSchedules = DatBan::where('user_id', $userId)
        ->where('thoi_gian_dat', '<', Carbon::now())
        ->orderByDesc('thoi_gian_dat')
        ->take(5)
        ->get();

    // Trả về dữ liệu dưới dạng JSON
    return response()->json([
        'current_and_future_schedules' => $currentAndFutureSchedules,
        'past_schedules' => $pastSchedules,
    ]);
}
public function addTable(Request $request)
{
    // Kiểm tra nếu tên bàn đã tồn tại
    $existingTable = BanAn::where('ten_ban', $request->ten_ban)->first();
    if ($existingTable) {
        return response()->json([
            'success' => false,
            'message' => 'Tên bàn đã tồn tại!'
        ]);
    }

    // Tạo bàn mới
    $table = new BanAn();
    $table->ten_ban = $request->ten_ban;
    $table->status = $request->status;
    $table->save();

    // Ghi log vào bảng log_tables
    LogTables::create([
        'action' => 'add', // Hành động là add (thêm mới)
        'action_content' => 'Admin ' . Auth::id() . ' đã thêm bàn ăn: ' . $table->ten_ban,
        'admin_id' => Auth::id(), // Lấy admin id từ Auth
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Thêm bàn thành công!'
    ]);
}
public function getTableStatic(Request $request) {
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    $query = DatBan::query();
    if ($startDate && $endDate) {
        $query->whereBetween('thoi_gian_dat', [$startDate, $endDate]);
    }

    $reservations = $query->get();

    // Tính toán thống kê
    $totalTables = BanAn::count();
    $totalReservations = $reservations->count();
    $pendingReservations = $reservations->where('trang_thai', 'pending')->count();

    // Dữ liệu biểu đồ
    $groupedByDate = $reservations->groupBy(function ($item) {
        // Chuyển chuỗi thoi_gian_dat thành Carbon
        return Carbon::parse($item->thoi_gian_dat)->format('Y-m-d');
    });

    $chart1 = [
        'labels' => $groupedByDate->keys(), // Các ngày
        'values' => $groupedByDate->map->count() // Số lượng đặt bàn cho mỗi ngày
    ];

    $chart2 = [
        'labels' => ['Pending', 'Confirmed', 'Cancelled'],
        'values' => [
            $reservations->where('trang_thai', 'pending')->count(),
            $reservations->where('trang_thai', 'confirmed')->count(),
            $reservations->where('trang_thai', 'cancelled')->count()
        ]
    ];

    return response()->json([
        'totalTables' => $totalTables,
        'totalReservations' => $totalReservations,
        'pendingReservations' => $pendingReservations,
        'chart1' => $chart1,
        'chart2' => $chart2,
    ]);
}
public function getTableHistory(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $action = $request->input('action');

        // Khởi tạo query cơ bản để lấy tất cả lịch sử
        $query = LogTables::query();

        // Kiểm tra và áp dụng bộ lọc theo ngày bắt đầu
        if ($startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($startDate)->toDateString());
        }

        // Kiểm tra và áp dụng bộ lọc theo ngày kết thúc
        if ($endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($endDate)->toDateString());
        }

        // Kiểm tra và áp dụng bộ lọc theo hành động
        if ($action) {
            $query->where('action', $action);
        }

        // Lấy dữ liệu lịch sử, sắp xếp theo thời gian giảm dần
        $history = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'history' => $history
        ]);
    }
}
