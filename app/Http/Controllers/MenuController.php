<?php

// app/Http/Controllers/MenuController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;


use App\Models\CartDetail;
use App\Models\Product; // Đảm bảo bạn đã có model Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use App\Models\FoodSuggestion;
class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $user = Auth::user();
        $cartItems = [];
        $totalAmount = 0;
        $cartQuantity = 0;
        $products = collect(); // Khởi tạo một collection rỗng cho sản phẩm
        $departments = FoodSuggestion::all()->pluck('department_suggestion')->toArray();
        $departments = $this->processDepartments($departments);
    
        if ($user) {
            // Lấy giỏ hàng của người dùng
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                // Lấy thông tin chi tiết giỏ hàng
                $cartItems = $cart->cartDetails()->with('product')->get();
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
    
                // Tính tổng số tiền
                foreach ($cartItems as $item) {
                    $totalAmount += $item->total_amount;
                }
            }
    
            // Ưu tiên các sản phẩm mà người dùng đã mua nhiều nhất
            $products = Product::where('is_deleted', 0)
                ->where('quantity_in_stock', '>', 0)
                ->whereHas('orderDetails.order', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->withCount(['orderDetails as total_quantity_sold' => function ($query) {
                    $query->select(\DB::raw('SUM(quantity)'));
                }])
                ->orderByDesc('total_quantity_sold')
                ->take(20) // Lấy tối đa 20 sản phẩm ưu tiên
                ->get();
    
            // Nếu không có sản phẩm được ưu tiên, lấy sản phẩm mới nhất
            if ($products->isEmpty()) {
                $products = Product::where('is_deleted', 0)
                    ->where('quantity_in_stock', '>', 0)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
            }
        } else {
            // Nếu người dùng chưa đăng nhập, hiển thị sản phẩm mới nhất
            $products = Product::where('is_deleted', 0)
                ->where('quantity_in_stock', '>', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
    
        // Trả về view menu với biến dữ liệu
        return view('menu', compact('products', 'cartItems', 'categories', 'totalAmount', 'cartQuantity', 'departments'));
    }
    
    
    private function processDepartments($departments)
    {
        $processedDepartments = [];
    
        foreach ($departments as $department) {
            // Tách các khoa ra nếu chúng được lưu dưới dạng chuỗi (ví dụ "khoa a, khoa b, khoa c")
            $departmentList = explode(',', $department);
    
            // Loại bỏ khoảng trắng thừa và thêm tiền tố "khoa" nếu chưa có
            foreach ($departmentList as $dept) {
                $dept = trim($dept);
                // Nếu khoa không có tiền tố "khoa", thêm vào
                if (strpos($dept, 'Khoa') !== 0) {
                    $dept = 'Khoa ' . $dept;  // Thêm tiền tố "Khoa"
                }
                $processedDepartments[] = $dept;
            }
        }
    
        // Loại bỏ các phần tử trùng lặp
        return array_unique($processedDepartments);
    }
    public function applyFilters(Request $request)
    {
        // Lấy các giá trị từ yêu cầu (AJAX)
        $categoryId = $request->input('category');
        $department = $request->input('department');
    
        // Xử lý để loại bỏ "Khoa" khỏi trường department và so sánh không phân biệt chữ hoa chữ thường
        $department = $department ? strtolower(str_replace('khoa', '', $department)) : null;
    
        // Bắt đầu truy vấn với bảng Product
        $query = Product::query();
    
        // Lọc theo category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        // Nếu có filter department
        if ($department) {
            // Truy vấn bảng FoodSuggestion để lấy department_suggestion
            $query->whereIn('id', function($subQuery) use ($department) {
                $subQuery->select('product_id')
                         ->from('food_suggestions') // Bảng chứa gợi ý thực phẩm
                         ->whereRaw('LOWER(department_suggestion) LIKE ?', ['%' . $department . '%']);
            });
        }
    
        // Lấy danh sách sản phẩm
        $products = $query->get();
    
        // Trả về dữ liệu dưới dạng JSON (các sản phẩm và các thông tin cần thiết)
        return response()->json([
            'products' => $products
        ]);
    }
    

    
}
