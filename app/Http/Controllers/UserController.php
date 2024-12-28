<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\User; // Import model User
use App\Models\TheDaNang;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\DiscountCode;
use App\Models\SpinHistory;
use Carbon\Carbon;
use App\Models\DatBan;
use App\Models\LogUsers; // Import model LogUser

use App\Models\Admins;




use App\Models\Transaction; // Import model User
 // Import model User

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function showProfile(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
        }
    
        // Lấy người dùng hiện tại
        $user = Auth::user();
    
        // Giỏ hàng, thẻ Đà Nẵng và các giao dịch
        $cartQuantity = 0;
        $theDaNang = null; 
        $transactions = [];
    
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();
        $theDaNang = TheDaNang::where('user_id', $user->id)->first();
    
        if ($cart) {
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
        }
    
        if ($theDaNang) {
            // Lấy các giao dịch của thẻ Đà Nẵng
            $transactions = Transaction::where('the_da_nang_id', $theDaNang->id)
                ->orderBy('created_at', 'desc')
                ->paginate(3);
        }
    
        // Lấy danh sách đơn hàng và chi tiết
        $orders = Order::where('user_id', $user->id)
            ->where('is_deleted', false)
            ->with(['shipping', 'user']) // Lấy thêm thông tin shipping
            ->orderBy('created_at', 'desc')
            ->paginate(30);
    
        // Lấy chi tiết đơn hàng cho từng đơn hàng
        $orderDetails = [];
        foreach ($orders as $order) {
            $orderDetails[$order->id] = OrderDetail::where('order_id', $order->id)->get();
        }
    
        // Lấy danh sách mã giảm giá còn hạn sử dụng
        $currentDate = now(); // Ngày hiện tại
        $discountCodes = DiscountCode::where('user_id', $user->id)
            ->where('expiration_date', '>', $currentDate) // Chỉ lấy mã còn hạn
            ->where('quantity', '>', 0) // Mã có số lượng > 0
            ->with('discount') // Lấy thông tin từ bảng discount
            ->get();
    
        // Lấy lịch sử quay vòng quay yêu thương
        $spinHistory = SpinHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10) // Chỉ lấy 10 bản ghi gần nhất
            ->get();
    
        // Lấy lịch sử đặt bàn của người dùng
        $datBanHistory = DatBan::where('user_id', $user->id)
            ->with('banAn') // Lấy thông tin bàn ăn đã đặt
            ->orderBy('thoi_gian_dat', 'desc')
            ->get();
    
        // Trả về view và truyền dữ liệu
        return view('profile', compact(
            'user', 
            'cartQuantity', 
            'theDaNang', 
            'transactions', 
            'orders', 
            'orderDetails', 
            'discountCodes', 
            'spinHistory',
            'datBanHistory' // Thêm lịch sử đặt bàn vào
        ));
    }
    
    public function about(Request $request)
    {
      
    
        // Lấy người dùng hiện tại
        $user = Auth::user();
    
        // Giỏ hàng, thẻ Đà Nẵng và các giao dịch
        $cartQuantity = 0;
        $theDaNang = null; 
        $transactions = [];
    if($user){
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();
        $theDaNang = TheDaNang::where('user_id', $user->id)->first();
    
        if ($cart) {
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
        }
    
    }
    
        // Trả về view và truyền dữ liệu
        return view('about', compact(
         
            'cartQuantity', 
            // Thêm lịch sử đặt bàn vào
        ));
    }
    
    


    
    
    
    

    
    
    public function showUpdateProfile()
    {
        $user = Auth::user();
     
        $cartQuantity = 0;
    
        if ($user) {
            // Tìm giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                // Tính tổng số lượng sản phẩm trong giỏ hàng
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
            }
        }
        return view('update_profile', compact('user','cartQuantity'));
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);
    
        $user = Auth::user();
        $avatar = $request->file('avatar');
    
        // Generate a unique filename
        $filename = $user->id . '.' . $avatar->getClientOriginalExtension();
    
        // Store the file
        $path = $avatar->storeAs('images/avatar', $filename, 'public');
    
        // Update user avatar path in the database
        $user->avatar = 'storage/' . $path;
        /** @var \App\Models\User $user **/
        $user->save();
    
        // Trả về JSON response
        return response()->json(['message' => 'Avatar updated successfully!'], 200);
    }
    

    public function updateProfile(Request $request)
{
    // Xác thực dữ liệu nếu cần
    $request->validate([
        'name' => 'nullable|string|max:255',
        'ngay_sinh' => 'nullable|date',
        'gioi_tinh' => 'nullable|string',
        'phone_number' => 'nullable|string|max:15',
        'city' => 'nullable|string',
        'district' => 'nullable|string',
        'ward' => 'nullable|string',
        'flat' => 'nullable|string|max:50',
    ]);

    // Lấy người dùng hiện tại
    $user = auth()->user(); // Lấy đối tượng người dùng thay vì chỉ lấy ID

    // Cập nhật thông tin người dùng chỉ khi trường không rỗng
    if ($request->has('name')) {
        $user->name = $request->name;
    }
    if ($request->has('ngay_sinh')) {
        $user->ngay_sinh = $request->ngay_sinh;
    }
    if ($request->has('gioi_tinh')) {
        $user->gioi_tinh = $request->gioi_tinh;
    }
    if ($request->has('phone_number')) {
        $user->phone_number = $request->phone_number;
    }

    // Tạo địa chỉ từ các trường đã chọn nếu ít nhất một trường có dữ liệu
    if ($request->filled('flat') || $request->filled('ward') || $request->filled('district') || $request->filled('city')) {
        $addressParts = [];
        
        if ($request->filled('flat')) {
            $addressParts[] = $request->flat;
        }
        if ($request->filled('ward')) {
            $addressParts[] = $request->ward;
        }
        if ($request->filled('district')) {
            $addressParts[] = $request->district;
        }
        if ($request->filled('city')) {
            $addressParts[] = $request->city;
        }

        // Kết hợp các phần địa chỉ thành một chuỗi
        $user->address = trim(implode(', ', $addressParts)); // Cập nhật địa chỉ cho người dùng
    }

    // Lưu thông tin người dùng
    $user->save();

    return response()->json([
        'success' => true,
        'data' => [
            'name' => $user->name,
            'phone_number' => $user->phone_number,
            // Thêm các trường khác nếu cần
        ],
    ]);
}

    
   // Hiển thị form cập nhật địa chỉ
        public function showUpdateForm()
        {
            $user = Auth::user();
     
            $cartQuantity = 0;
        
            if ($user) {
                // Tìm giỏ hàng của người dùng
                $cart = Cart::where('user_id', $user->id)->first();
        
                if ($cart) {
                    // Tính tổng số lượng sản phẩm trong giỏ hàng
                    $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
                }
            }
            return view('update_address',compact('cartQuantity'));
        }
       
        // Xử lý việc cập nhật địa chỉ
        public function updateAddress(Request $request)
        {
            $user = Auth::user();
    
            // Xác thực dữ liệu đầu vào
            $validatedData = $request->validate([
                'city' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'flat' => 'required|max:50',
            ]);
    
            // Lấy tên từ các dropdown
            $cityName = $request->input('city');
            $districtName = $request->input('district');
            $wardName = $request->input('ward');
            $flat = $request->input('flat');
    
            // Tạo chuỗi địa chỉ
            $address = "{$flat}, {$wardName}, {$districtName}, {$cityName}, Việt Nam";
    
            // Cập nhật địa chỉ của người dùng
            if (!empty($cityName) && !empty($districtName) && !empty($wardName) && !empty($flat)) {
                $user->address = $address;
                 /** @var \App\Models\User $user **/
                $user->save();
                return redirect()->back()->with('status', 'Address updated successfully.');
            }
    
            return redirect()->back()->with('status', 'No changes to update.');
            
        }
        public function updatePassword(Request $request) {
            // Xác thực các trường dữ liệu
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:6|confirmed', // yêu cầu xác nhận mật khẩu
            ]);
        
            // Lấy người dùng hiện tại
            $user = auth()->user();
        
            // Kiểm tra mật khẩu cũ
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return response()->json(['success' => false, 'message' => 'Mật khẩu cũ không chính xác']);
            }
        
            // Cập nhật mật khẩu mới
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
        
            return response()->json(['success' => true, 'message' => 'Đổi mật khẩu thành công']);
        }
        
        public function updatePoints(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
    }

    $user = Auth::user();
    $pointsChange = $request->input('pointsChange', 0);

    // Kiểm tra nếu người dùng có đủ điểm
    if ($user->loyalty_points + $pointsChange < 0) {
        return response()->json(['success' => false, 'message' => 'Bạn không có đủ điểm.']);
    }

    // Cập nhật điểm tích lũy
    $user->loyalty_points += $pointsChange;
    $user->save();

    return response()->json(['success' => true, 'newPoints' => $user->loyalty_points]);
}
public function fetchUsers(Request $request)
{
    $query = User::query();

    // Lọc theo danh mục (vai trò người dùng)
    if ($request->has('category') && $request->category !== 'all') {
        $query->where('role', $request->category);
    }

    // Sắp xếp
    switch ($request->sort) {
        case 'date_asc':
            $query->orderBy('created_at', 'asc');
            break;
        case 'date_desc':
            $query->orderBy('created_at', 'desc');
            break;
        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    $users = $query->get();

    return response()->json(['users' => $users]);
}

public function deleteUser($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['success' => true, 'message' => 'User deleted successfully']);
}
public function searchUsers(Request $request)
{
    $query = $request->get('query', '');

    // Tìm kiếm trong các trường: mã, user_name, mã bệnh nhân, họ và tên, email, số điện thoại, vai trò
    $users = User::where('id', 'LIKE', "%$query%")
        ->orWhere('user_name', 'LIKE', "%$query%")
        ->orWhere('ma_benh_nhan', 'LIKE', "%$query%")
        ->orWhere('name', 'LIKE', "%$query%")
        ->orWhere('email', 'LIKE', "%$query%")
        ->orWhere('phone_number', 'LIKE', "%$query%")
        ->orWhere('role', 'LIKE', "%$query%")
        ->get();

    return response()->json(['users' => $users]);
}
 // Import Auth để lấy admin_id

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'user_name' => 'required|string|max:255',
        'ma_benh_nhan' => 'required|string|max:255',
        'gioi_tinh' => 'required|string',
        'ngay_sinh' => 'required|date',
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
        'phone_number' => 'required|string|max:15',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'nullable|string|max:255',
        'role' => 'required|string',
        'special_offer' => 'nullable|string|max:255',
    ]);

    // Kiểm tra trùng lặp các trường
    $errors = [];
    if (User::where('user_name', $request->user_name)->exists()) {
        $errors['user_name'] = 'Tên đăng nhập đã tồn tại.';
    }

    if (User::where('email', $request->email)->exists()) {
        $errors['email'] = 'Email đã tồn tại.';
    }

    if (User::where('ma_benh_nhan', $request->ma_benh_nhan)->exists()) {
        $errors['ma_benh_nhan'] = 'Mã bệnh nhân đã tồn tại.';
    }

    if (User::where('phone_number', $request->phone_number)->exists()) {
        $errors['phone_number'] = 'Số điện thoại đã tồn tại.';
    }

    // Nếu có lỗi, trả về phản hồi với danh sách lỗi
    if (!empty($errors)) {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], 422);
    }

    // Lưu người dùng
    $user = new User();
    $user->fill($request->except(['password', 'password_confirmation', 'avatar']));

    // Hash mật khẩu
    $user->password = Hash::make($request->password);

    // Xử lý upload avatar
    if ($request->hasFile('avatar')) {
        $fileName = time() . '.' . $request->file('avatar')->extension();
        $avatarPath = $request->file('avatar')->storeAs(
            'images/avatar/' . $user->id,
            $fileName,
            'public'
        );
        $user->avatar = 'storage/' . $avatarPath;
    }

    $user->save();

    // Tạo bản ghi log
    $adminId = Auth::id(); // Lấy ID admin đang đăng nhập
    LogUsers::create([
        'action' => 'add',
        'action_content' => 'Thêm 1 người dùng mới: ' .
            'ID: ' . $user->id . ', Tên đăng nhập: ' . $user->user_name .
            ', Mã bệnh nhân: ' . $user->ma_benh_nhan . 
            ', Email: ' . $user->email . 
            ', Số điện thoại: ' . $user->phone_number,
        'admin_id' => $adminId,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Người dùng được thêm thành công!',
        'user' => $user
    ]);
}

public function checkIfDataExists(Request $request)
{
    // Xác thực dữ liệu
    $validated = $request->validate([
        'user_name' => 'nullable|string|max:255',
        'email' => 'nullable|email',
        'phone_number' => 'nullable|string|max:15',
    ]);

    // Tạo truy vấn kiểm tra nếu user_name, email hoặc phone_number tồn tại
    $userExists = User::query();

    // Nếu có user_name, thêm điều kiện
    if ($validated['user_name']) {
        $userExists->orWhere('user_name', 'LIKE', '%' . trim($validated['user_name']) . '%');
    }

    // Nếu có email, thêm điều kiện
    if ($validated['email']) {
        $userExists->orWhere('email', 'LIKE', '%' . trim($validated['email']) . '%');
    }

    // Nếu có phone_number, thêm điều kiện
    if ($validated['phone_number']) {
        $userExists->orWhere('phone_number', 'LIKE', '%' . trim($validated['phone_number']) . '%');
    }

    // Kiểm tra sự tồn tại của dữ liệu và trả về true/false
    return response()->json(['exists' => $userExists->exists()]);
}
public function addUsers(Request $request)
{
    try {
        // Nhận dữ liệu người dùng từ request
        $users = $request->input('users'); // Lấy danh sách người dùng từ request

        // Kiểm tra dữ liệu
        if (empty($users)) {
            return response()->json(['error' => 'No users data provided'], 400);
        }

        // Danh sách chứa thông tin các user được thêm thành công
        $addedUsers = [];

        // Lặp qua từng người dùng để thêm vào cơ sở dữ liệu
        foreach ($users as $userData) {
            // Mã hóa mật khẩu
            $userData['password'] = bcrypt($userData['password']);

            // Thêm người dùng vào cơ sở dữ liệu
            $user = User::create($userData);

            // Lưu thông tin người dùng vào danh sách
            $addedUsers[] = "ID: {$user->id} - Username: {$user->user_name} - Mã bệnh nhân: {$user->ma_benh_nhan} - Email: {$user->email} - SĐT: {$user->phone_number}";
        }

        // Tạo log cho việc thêm nhiều user
        $adminId = Auth::id(); // Lấy ID admin hiện tại
        LogUsers::create([
            'action' => 'add_multiple',
            'action_content' => 'Thêm nhiều người dùng: ' . implode(', ', $addedUsers), // Nối danh sách user thành chuỗi
            'admin_id' => $adminId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Users added successfully',
            'added_users' => $addedUsers,
        ]);

    } catch (\Exception $e) {
        // Xử lý lỗi và trả về thông báo
        return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
    }
}

public function getUserStatistics(Request $request)
{
    // Lấy khoảng thời gian từ request hoặc mặc định
    $range = $request->input('range', 7); // Mặc định 7 ngày
    $startDate = $request->input('startDate')
        ? Carbon::parse($request->input('startDate'))->startOfDay()
        : Carbon::now()->subDays($range)->startOfDay();

    $endDate = $request->input('endDate')
        ? Carbon::parse($request->input('endDate'))->endOfDay()
        : Carbon::now()->endOfDay();

    // Khoảng thời gian mặc định cho biểu đồ (6 tháng gần nhất)
    $chartStartDate = Carbon::now()->subMonths(6)->startOfMonth();
    $chartEndDate = Carbon::now()->endOfMonth();

    // Thống kê stats (theo filter)
    $totalRegistrations = User::whereBetween('created_at', [$startDate, $endDate])->count();
    $totalCardOpenings = TheDanang::whereBetween('created_at', [$startDate, $endDate])->count();
    $totalCardUsages = Order::whereBetween('created_at', [$startDate, $endDate])->count();

    $cardUsageRate = $totalCardUsages > 0
        ? round(($totalCardOpenings / $totalCardUsages) * 100, 2)
        : 0;

    // Thống kê đăng ký và mở thẻ cho biểu đồ (6 tháng gần nhất)
    $registrations = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->whereBetween('created_at', [$chartStartDate, $chartEndDate])
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(fn($item) => [$item->month => $item->count]);

    $cardOpens = TheDanang::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->whereBetween('created_at', [$chartStartDate, $chartEndDate])
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(fn($item) => [$item->month => $item->count]);

    // Top 3 người chi tiêu nhiều nhất (theo filter)
    $topSpenders = Order::join('users', 'orders.user_id', '=', 'users.id')
        ->whereBetween('orders.created_at', [$startDate, $endDate])
        ->where('orders.status', 'completed') // Chỉ lấy đơn đã hoàn thành
        ->select('users.name', Order::raw('SUM(orders.total_amount) as total_spent'))
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('total_spent')
        ->limit(3)
        ->get();

    // Chuẩn hóa dữ liệu biểu đồ
    $months = collect();
    for ($date = Carbon::parse($chartStartDate); $date <= Carbon::parse($chartEndDate); $date->addMonth()) {
        $months->push($date->format('Y-m'));
    }

    $registrationData = $months->map(fn($month) => $registrations->get($month, 0))->toArray();
    $cardOpenData = $months->map(fn($month) => $cardOpens->get($month, 0))->toArray();

    return response()->json([
        'stats' => [
            'totalRegistrations' => $totalRegistrations,
            'totalCardOpenings' => $totalCardOpenings,
            'cardUsageRate' => $cardUsageRate,
        ],
        'charts' => [
            'labels' => $months->toArray(),
            'registrationData' => $registrationData,
            'cardOpenData' => $cardOpenData,
        ],
        'topSpenders' => $topSpenders,
    ]);
}

public function getUsers(Request $request)
{
    $query = User::query();

    // Nếu có từ khóa tìm kiếm
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where('user_name', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
    }

    // Lấy danh sách user
    $users = $query->select('id', 'role', 'user_name')
                   ->orderBy('id', 'desc')
                   ->get();

    return response()->json(['users' => $users]);
}
public function edit($id)
    {
        // Tìm kiếm người dùng theo ID
        $user = User::find($id);

        // Nếu không tìm thấy, trả về dữ liệu rỗng
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại',
                'data' => null
            ], 404);
        }

        // Trả về thông tin người dùng
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        // Tìm người dùng theo ID
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ], 404);
        }
    
        // Lấy tất cả dữ liệu từ request (trừ các field không cần cập nhật)
        $input = $request->except(['id', 'loyalty_points', 'created_at', 'updated_at', 'avatar']);
    
        // Kiểm tra trùng lặp
        $duplicateCheck = User::where(function ($query) use ($input) {
            if (isset($input['user_name'])) {
                $query->orWhere('user_name', $input['user_name']);
            }
            if (isset($input['email'])) {
                $query->orWhere('email', $input['email']);
            }
            if (isset($input['ma_benh_nhan'])) {
                $query->orWhere('ma_benh_nhan', $input['ma_benh_nhan']);
            }
            if (isset($input['phone_number'])) {
                $query->orWhere('phone_number', $input['phone_number']);
            }
        })->where('id', '!=', $id) // Loại trừ người dùng hiện tại
          ->exists();
    
        if ($duplicateCheck) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đã trùng với người dùng khác'
            ], 400);
        }
    
        // Kiểm tra sự thay đổi dữ liệu
        $changes = [];
        foreach ($input as $key => $value) {
            if ($user->{$key} != $value) {
                $changes[$key] = [
                    'old' => $user->{$key},
                    'new' => $value,
                ];
            }
        }
    
        // Nếu có file avatar được upload
        if ($request->hasFile('avatar')) {
            $fileName = time() . '.' . $request->file('avatar')->extension();
            $avatarPath = $request->file('avatar')->storeAs(
                'images/avatar/' . $user->id,
                $fileName,
                'public'
            );
            $changes['avatar'] = [
                'old' => $user->avatar,
                'new' => 'storage/' . $avatarPath,
            ];
            $user->avatar = 'storage/' . $avatarPath;
        }
    
        // Nếu không có thay đổi nào
        if (empty($changes)) {
            return response()->json([
                'success' => false,
                'message' => 'Không có thay đổi nào được thực hiện'
            ]);
        }
    
        // Cập nhật dữ liệu
        $user->fill($input);
        $user->save();
    
        // Tạo log ghi lại các thay đổi
        $adminId = Auth::id(); // ID của admin đang thực hiện
        $changeDetails = [];
        foreach ($changes as $field => $values) {
            $changeDetails[] = "$field: {$values['old']} -> {$values['new']}";
        }
    
        LogUsers::create([
            'action' => 'update',
            'action_content' => 'Cập nhật người dùng ID: ' . $id . ', Thay đổi: ' . implode(', ', $changeDetails),
            'admin_id' => $adminId,
        ]);
    
        // Trả về phản hồi thành công
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'data' => $user,
            'changes' => $changes,
        ]);
    }
    

    public function changePassword(Request $request)
    {
        // Lấy ID người dùng từ request
        $userId = $request->input('id');
        $newPassword = $request->input('password');
    
        // Tìm người dùng theo ID
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ], 404);
        }
    
        // Hash mật khẩu mới trước khi lưu
        $user->password = Hash::make($newPassword);  // Sử dụng Hash::make() để hash mật khẩu
    
        // Lưu mật khẩu mới vào database
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }
    
    public function getUserLog(Request $request)
    {
        $query = LogUsers::query();

        // Lọc theo loại thao tác
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Lọc theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Phân trang, 20 bản ghi mỗi lần
        $logs = $query->with('admin:id,name') // Lấy thông tin admin
                      ->orderBy('created_at', 'desc')
                      ->paginate(20);

        return response()->json([
            'logs' => $logs->items(),
            'has_more_pages' => $logs->hasMorePages(),
        ]);
    }
    public function getAdminInfo()
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        $admin = Admins::where('user_id', $user->id)->first(); // Lấy thông tin admin dựa trên user_id

        return response()->json([
            'user_name' => $user->name, // Trả về tên người dùng
            'admin_id' => $admin ? $admin->id : null, // Trả về admin_id, nếu có
            'role' => $admin ? $admin->role : null, // Trả về admin_id, nếu có

        ]);
    }
}
