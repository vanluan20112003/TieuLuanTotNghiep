<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use App\Models\User;
use App\Models\LogUsers;
use Illuminate\Support\Facades\DB;

use App\Models\LogAdmins;
use App\Models\LogProducts;

use App\Models\LogTables;

use App\Models\LogOrders;

use Illuminate\Support\Facades\Auth; 



class AdminController extends Controller
{
    // Lấy danh sách admin và quyền từ bảng admins
    public function getAdmins()
    {
        // Lấy tất cả các admin từ bảng admins chỉ khi user liên kết có is_admin = 1
        $admins = Admins::with(['user' => function ($query) {
            $query->where('is_admin', 1); // Lọc chỉ những user có is_admin = 1
        }])->whereHas('user', function ($query) {
            $query->where('is_admin', 1); // Đảm bảo admin chỉ liên kết với user có is_admin = 1
        })->get();
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($admins);
    }
    
    public function getNonAdminUsers()
    {
        // Lấy danh sách user có is_admin = 0
        $users = User::where('is_admin', 0)->get(['id', 'user_name', 'name']);
        return response()->json($users);
    }
    public function getAdminData($id)
    {
        // Tìm user trong bảng Admin dựa trên user_id
        $admin = Admins::where('user_id', $id)->first();

        if ($admin) {
            return response()->json([
                'exists' => true,
                'adminData' => $admin, // Trả về thông tin admin
            ]);
        } else {
            return response()->json([
                'exists' => false,
            ]);
        }
    }
    public function checkAdminExistence(Request $request)
{
    $userId = $request->input('user_id');

    // Kiểm tra xem user_id đã tồn tại trong bảng admins hay chưa
    $adminExists = Admins::where('user_id', $userId)->exists();

    return response()->json(['exists' => $adminExists]);
}
public function updateAdminStatus(Request $request) 
{
    try {
        // Kiểm tra dữ liệu đầu vào
        $userId = $request->input('user_id');
        $isAdmin = $request->input('is_admin');

        if (!$userId || !isset($isAdmin)) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin đầu vào: user_id hoặc is_admin'
            ], 400); // HTTP 400: Bad Request
        }

        // Tìm kiếm user
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng với ID: ' . $userId
            ], 404); // HTTP 404: Not Found
        }

        // Cập nhật trạng thái admin
        $user->is_admin = $isAdmin;
        $user->save();

        // Thêm log vào bảng log_admins
        LogAdmins::create([
            'action' => 'Update',
            'action_content' => 'Đã cập nhật quyền admin cho user: ' . $userId,
            'admin_id' => Auth::id(), // ID của admin đang thực hiện hành động
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái admin thành công'
        ], 200); // HTTP 200: Success
    } catch (\Exception $e) {
        // Log lỗi để debug

        // Trả về lỗi server
        return response()->json([
            'success' => false,
            'message' => 'Lỗi server: ' . $e->getMessage()
        ], 500); // HTTP 500: Internal Server Error
    }
}

public function addAdmin(Request $request)
{
    $userId = $request->input('user_id');
    $role = $request->input('role');
    $permissions = $request->input('permissions'); // Là một mảng quyền
    $staffId = $request->input('staff_id');
    $existingAdmin = Admins::find($staffId);
    if ($existingAdmin) {
        return response()->json([
            'success' => false,
            'message' => "ID nhân viên $staffId đã tồn tại trong bảng admins."
        ], 409); // HTTP 409: Conflict
    }
    // Thêm admin vào bảng admins
    $admin = new Admins();
    $admin->id = $staffId;
    $admin->user_id = $userId;
    $admin->role = $role;

    // Gán quyền cho admin
    foreach ($permissions as $permission) {
        $admin->$permission = true; // Set giá trị quyền thành true
    }

    $admin->save();

    return response()->json([
        'success' => true,
        'message' => 'Đã thêm admin thành công.'
    ], 201); // HTTP 201: Created
}
public function updatePermission(Request $request)
{
    $adminId = $request->input('admin_id');
    $permission = $request->input('permission');
    $status = filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN); // Chuyển đổi thành true/false

    // Tìm admin theo ID
    $admin = Admins::find($adminId);

    if (!$admin) {
        return response()->json(['message' => 'Admin không tồn tại'], 404);
    }

    // Kiểm tra quyền có tồn tại trong bảng
    if (array_key_exists($permission, $admin->getAttributes())) {
        // Kiểm tra trạng thái hiện tại
        $currentStatus = $admin->$permission;

        if ($currentStatus != $status) {
            // Chỉ lưu nếu trạng thái thay đổi
            $admin->$permission = $status ? 1 : 0; // Chuyển thành 1 hoặc 0
            $admin->save();

            // Lấy user_id của admin hiện tại
            $userId = $admin->user_id;

            // Thêm log vào bảng log_admins
            $actionContent = "Đã cập nhật quyền $permission của admin userId $userId từ " . 
                ($currentStatus ? 'có' : 'không') . " -> " . ($status ? 'có' : 'không');

            LogAdmins::create([
                'action' => 'Update',
                'action_content' => $actionContent,
                'admin_id' => Auth::id(), // ID của admin đang thực hiện hành động
            ]);

            return response()->json(['message' => 'Cập nhật quyền thành công']);
        } else {
            return response()->json(['message' => 'Trạng thái không thay đổi'], 200);
        }
    } else {
        return response()->json(['message' => 'Quyền không hợp lệ'], 400);
    }
}

public function checkDuplicateId(Request $request)
{
    $staffId = $request->input('staff_id');
    $excludeId = $request->input('exclude_id'); // Nhận ID của nhân viên đang sửa
    
    // Kiểm tra xem mã nhân viên đã tồn tại trong bảng chưa, bỏ qua chính nhân viên hiện tại
    $exists = Admins::where('id', $staffId)
                    ->where('id', '!=', $excludeId) // Bỏ qua nhân viên hiện tại
                    ->exists();

    return response()->json(['exists' => $exists]);
}


    // API cập nhật thông tin nhân viên
    public function updateStaff(Request $request)
    {
        $adminId = $request->input('admin_id'); // Mã nhân viên mới
        $role = $request->input('role');       // Chức vụ mới
        $excludeId = $request->input('exclude_id'); // ID của nhân viên cần cập nhật
    
        // Tìm admin theo ID
        $admin = Admins::find($excludeId);
    
        if (!$admin) {
            return response()->json(['message' => 'Admin không tồn tại'], 404);
        }
    
        // Lưu trạng thái ban đầu để so sánh thay đổi
        $originalAttributes = $admin->getOriginal();
    
        // Cập nhật thông tin
        $admin->id = $adminId;
        $admin->role = $role;
        $admin->save();
    
        // So sánh thay đổi và ghi log
        $changes = $admin->getChanges(); // Lấy các trường đã thay đổi (trừ created_at, updated_at)
    
        unset($changes['created_at'], $changes['updated_at']); // Loại bỏ cột created_at, updated_at
    
        if (!empty($changes)) {
            // Chuẩn bị nội dung log
            $actionContent = "Cập nhật admin ID: $excludeId. Thay đổi: ";
    
            foreach ($changes as $field => $newValue) {
                $oldValue = $originalAttributes[$field] ?? null;
                $actionContent .= "$field từ '$oldValue' -> '$newValue', ";
            }
    
            $actionContent = rtrim($actionContent, ', '); // Xóa dấu phẩy cuối cùng
    
            // Ghi log vào bảng log_admins
            LogAdmins::create([
                'action' => 'Update',
                'action_content' => $actionContent,
                'admin_id' => Auth::id(), // ID của admin đang thực hiện hành động
            ]);
        }
    
        return response()->json(['message' => 'Cập nhật nhân viên thành công']);
    }
    

    public function revokeAdmin(Request $request)
{
    $staffId = $request->input('staff_id'); // Nhận staff_id từ request

    // Tìm admin theo staff_id
    $admin = Admins::find($staffId);

    if (!$admin) {
        return response()->json(['message' => 'Admin không tồn tại'], 404);
    }

    // Lấy user_id từ bảng Admin
    $userId = $admin->user_id;

    // Tìm user theo user_id trong bảng Users
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'Người dùng không tồn tại'], 404);
    }

    // Cập nhật cột is_admin = 0 trong bảng Users
    $user->is_admin = 0;
    $user->save();

    // Xóa admin nếu cần thiết (nếu muốn xoá luôn bản ghi admin)


    // Ghi log vào bảng log_admins
    LogAdmins::create([
        'action' => 'Update',
        'action_content' => "Tắt quyền quản trị của admin: {$staffId}",
        'admin_id' => Auth::id(), // ID của admin thực hiện hành động
    ]);

    return response()->json(['message' => 'Đã tắt quyền quản trị thành công']);
}
public function getLogs(Request $request)
    {
        $query = LogAdmins::query();

        // Lọc theo loại thao tác
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Lọc theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Lấy dữ liệu (paginate nếu cần)
        $logs = $query->with('admin:id,name')  // Lấy thông tin admin
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);  // Giới hạn 10 bản ghi mỗi lần

        return response()->json($logs);
    }
    public function getStaffLogs($user_id, Request $request)
    {
        // Lấy các thông tin lọc từ request
        $action = $request->input('action');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Truy vấn từng bảng và áp dụng các bộ lọc
        $logAdmins = LogAdmins::query()
            ->where('admin_id', $user_id)
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->select('action', 'created_at', 'action_content', 'admin_id', DB::raw("'log_admins' AS log_type"));
    
        $logOrders = LogOrders::query()
            ->where('admin_id', $user_id)
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->select('action', 'created_at', 'action_content', 'admin_id', DB::raw("'log_orders' AS log_type"));
    
        $logProducts = LogProducts::query()
            ->where('admin_id', $user_id)
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->select('action', 'created_at', 'action_content', 'admin_id', DB::raw("'log_products' AS log_type"));
    
        $logTables = LogTables::query()
            ->where('admin_id', $user_id)
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->select('action', 'created_at', 'action_content', 'admin_id', DB::raw("'log_tables' AS log_type"));
    
        $logUsers = LogUsers::query()
            ->where('admin_id', $user_id)
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($startDate, fn($query) => $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('created_at', '<=', $endDate))
            ->select('action', 'created_at', 'action_content', 'admin_id', DB::raw("'log_users' AS log_type"));
    
        // Kết hợp các truy vấn bằng UNION
        $logs = $logAdmins
            ->union($logOrders)
            ->union($logProducts)
            ->union($logTables)
            ->union($logUsers)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian
            ->paginate(50);
    
        return response()->json($logs);
    }
    
    
    
}


