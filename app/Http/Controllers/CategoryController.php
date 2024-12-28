<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\User;

use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Tìm kiếm theo tên
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->get();

        return view('layouts.category', compact('categories'));
    }
    public function show($id)
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
        // Lấy category và các sản phẩm của nó
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        
        // Truyền dữ liệu sang view
        return view('categories', compact('category', 'products','cartQuantity'));
    }
    public function create()
    {
        return view('layouts.create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->product_count = 0; // Khởi tạo với số lượng sản phẩm là 0

        $category->save(); // Lưu trước để có ID

        if ($request->hasFile('image')) {
            $imageName = $category->id . '_category.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Category added successfully');
    }
    public function edit(Category $category)
{
    return view('layouts.edit', compact('category'));
}
public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => [
            'required',
            Rule::unique('categories')->ignore($category->id), // Kiểm tra trùng tên, nhưng bỏ qua chính nó
        ],
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $category->name = $request->input('name');

    // Xử lý upload ảnh
    if ($request->hasFile('image')) {
        $imageName = $category->id . '_category.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $category->image = $imageName;
    }

    $category->save();

    return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
}
public function destroy($id)
{
    $category = Category::find($id);

    // Kiểm tra nếu có sản phẩm thuộc danh mục
    if ($category->product_count > 0) {
        return response()->json(['message' => 'Cannot delete category with products'], 400);
    }

    if ($category) {
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully',
            'redirect' => route('admin.category.index') // Trả về URL để điều hướng
        ]);
    }

    return response()->json(['message' => 'Category not found'], 404);
}
public function getCategory()
{
    // Lấy danh sách danh mục với số lượng sản phẩm
    $categories = Category::all()->map(function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'image' => $category->image,
            'product_count' => $category->products()->count(),
            'created_at' => $category->created_at,
        ];
    });

    return response()->json(['categories' => $categories], 200);
}

public function deleteCategory($id)
{
    $category = Category::find($id);
    if ($category) {
        $category->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
}
public function showCategory($id)
{
    $category = Category::find($id);
    if ($category) {
        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image,
                'product_count' => $category->products()->count(),
                'created_at' => $category->created_at,
            ],
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
}

public function updateCategory(Request $request, $id)
{
    $category = Category::find($id);

    if ($category) {
        // Cập nhật tên danh mục
        $category->name = $request->name;

        // Kiểm tra nếu có ảnh mới được tải lên
        if ($request->hasFile('image')) {
            // Lưu ảnh mới vào thư mục images/{id_category}
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension(); // Lấy phần mở rộng của ảnh
            $imageName = $category->id . '/category.' . $imageExtension; // Đặt tên ảnh theo id_category/category.extension

            // Lưu ảnh vào thư mục public/images/{id_category}
            $image->move(public_path('images/' . $category->id), 'category.' . $imageExtension); 

            // Cập nhật đường dẫn ảnh trong cơ sở dữ liệu
            $category->image = $category->id . '/category.' . $imageExtension; // Lưu đường dẫn ảnh vào DB
        }

        // Lưu lại danh mục đã cập nhật
        $category->save();

        return response()->json(['success' => true, 'message' => 'Danh mục đã được cập nhật thành công']);
    }

    return response()->json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
}

    // Phương thức trả về danh mục và danh sách sản phẩm
    public function viewCategoryProducts($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Danh mục không tồn tại'], 404);
        }

        // Lấy danh sách sản phẩm của danh mục
        $products = $category->products()->select('id', 'name', 'image')->get();

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
            'products' => $products
        ]);
    }
    public function Add(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
    
        // Tạo danh mục mới trước để lấy ID
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();
    
        // Xử lý lưu ảnh
        if ($request->hasFile('image')) {
            // Lấy ảnh từ request
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension(); // Lấy phần mở rộng của ảnh
            $imageName = $category->id . '/category.' . $imageExtension; // Đặt tên ảnh theo id_category/category.extension
    
            // Lưu ảnh vào thư mục public/images/{id_category}
            $image->move(public_path('images/' . $category->id), 'category.' . $imageExtension); 
    
            // Cập nhật trường 'image' trong database (chỉ lưu tên file không có tiền tố 'images/')
            $category->image = $category->id . '/category.' . $imageExtension; // Lưu theo định dạng id_category/category.extension
        }
    
        $category->save();
    
        return response()->json(['success' => true, 'message' => 'Danh mục đã được thêm thành công.']);
    }
    public function getCategoryStatistics(Request $request)
    {
        // Xác định khoảng thời gian (có thể gửi từ client hoặc mặc định là 1 tháng)
        $startDate = $request->start_date ?? Carbon::now()->subMonth(); // 1 tháng trước nếu không có start_date
        $endDate = $request->end_date ?? Carbon::now(); // Ngày hiện tại

        // Lấy danh sách các danh mục
        $categories = Category::with(['products' => function($query) use ($startDate, $endDate) {
            // Lọc sản phẩm trong khoảng thời gian
            $query->whereHas('orderDetails.order', function($query) use ($startDate, $endDate) {
                $query->whereBetween('orders.created_at', [$startDate, $endDate]) // Điều kiện thời gian
                      ->where('orders.status', 'completed'); // Giả sử trạng thái đơn hàng là 'completed'
            });
        }])->get();

        // Tính toán số liệu cho mỗi danh mục
        $statistics = $categories->map(function ($category) use ($startDate, $endDate) {
            // Tính số lượng sản phẩm trong danh mục
            $productCount = $category->products->count();

            // Tính tổng số lượng sản phẩm bán được trong tháng
            $totalSold = $category->products->sum('quantity_sold');

            // Tính tổng doanh thu từ các đơn hàng đã bán
            $totalRevenue = $category->products->sum(function($product) use ($startDate, $endDate) {
                // Lọc các đơn hàng đã hoàn thành trong khoảng thời gian
                return $product->orderDetails->filter(function($orderDetail) use ($startDate, $endDate) {
                    return $orderDetail->order->created_at->between($startDate, $endDate) 
                        && $orderDetail->order->status == 'completed';
                })->sum('amount');
            });

            return [
                'category_name' => $category->name,
                'product_count' => $productCount,
                'total_sold' => $totalSold,
                'total_revenue' => $totalRevenue,
            ];
        });

        // Trả về dữ liệu thống kê dưới dạng JSON
        return response()->json([
            'statistics' => $statistics,
            'message' => 'Thống kê danh mục trong khoảng thời gian'
        ]);
    }

}
