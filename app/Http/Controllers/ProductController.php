<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\NutritionFact;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\InventoryEntry;
use App\Models\LogProducts;

 

use App\Models\CommentProduct;

use App\Models\UserReact;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\search;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm từ query string
        $search = $request->get('search', ''); // Giá trị mặc định là chuỗi rỗng nếu không có 'search'
    
        // Lấy danh mục từ cơ sở dữ liệu
        $categories = Category::all();
        
        // Xử lý thời gian (tính theo khoảng thời gian người dùng chọn)
        $timeRange = $request->get('time-filter', 7); // Lấy khoảng thời gian, mặc định là 7 ngày
        $dateFrom = Carbon::now()->subDays($timeRange); // Lấy ngày bắt đầu dựa trên khoảng thời gian
        $dateTo = Carbon::now(); // Ngày kết thúc là hiện tại
    
        // Lấy sản phẩm và thống kê dữ liệu
        $products = Product::where('is_deleted', false) // Điều kiện loại bỏ sản phẩm bị xóa
        ->where('name', 'like', '%' . $search . '%') // Tìm kiếm theo tên sản phẩm
        ->paginate(10); // Phân trang
    
        // Lấy thống kê từ cơ sở dữ liệu trong khoảng thời gian đã chọn
        $stats = $this->getProductStats($timeRange, $dateFrom, $dateTo);
    
        // Lấy danh sách sản phẩm bán chạy
        $topProducts = $this->getTopSellingProducts($dateFrom, $dateTo);  // Hàm lấy top sản phẩm bán chạy
    
        // Truyền dữ liệu vào view
        return view('layouts.admin_product', compact('products', 'categories', 'stats', 'topProducts'));
    }
    
// Hàm lấy top sản phẩm bán chạy trong khoảng thời gian
private function getTopSellingProducts($dateFrom, $dateTo)
{
    return DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->select('products.name', 'products.category_id', 
                 DB::raw('SUM(order_details.quantity) as total_quantity'), 
                 DB::raw('SUM(order_details.quantity * products.price) as total_revenue'))  // Tham chiếu đến product->price
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->whereBetween('orders.created_at', [$dateFrom, $dateTo])
        ->groupBy('products.name', 'products.category_id')
        ->orderByDesc('total_quantity') // Sắp xếp theo số lượng bán
        ->limit(10)
        ->get()
        ->map(function ($product) {
            // Lấy tên danh mục từ category_id
            $category = Category::find($product->category_id);
            $product->category_name = $category ? $category->name : 'Không xác định';  // Gán tên danh mục
            return $product;
        });
}


    

// Hàm lấy thống kê sản phẩm trong khoảng thời gian
// Hàm lấy thống kê sản phẩm trong khoảng thời gian
private function getProductStats($timeRange, $dateFrom, $dateTo)
{
    // Lấy tổng số sản phẩm
    $totalProducts = Product::count();
    
    // Tính tổng doanh thu từ các đơn hàng trong khoảng thời gian
    $totalRevenue = Order::whereBetween('orders.created_at', [$dateFrom, $dateTo])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.id')  // Thêm join với bảng products
        ->sum(DB::raw('order_details.quantity * products.price'));  // Lấy giá từ bảng products

    // Tính tổng số sản phẩm đã bán
    $totalSold = Order::whereBetween('orders.created_at', [$dateFrom, $dateTo])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->sum('order_details.quantity');
    
    // Tính tồn kho từ bảng product
    $totalStock = Product::sum('quantity_in_stock');
    
    // Tính tổng lợi nhuận từ các chi tiết đơn hàng (Lấy giá từ bảng products và số lượng từ order_details)
    $totalProfit = Order::whereBetween('orders.created_at', [$dateFrom, $dateTo])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.id') // JOIN với bảng products để lấy giá sản phẩm
        ->sum(DB::raw('order_details.quantity * (products.price - IFNULL(products.purchase_price, 0))')); // Lợi nhuận từ từng đơn hàng, sử dụng IFNULL cho purchase_price

    // Lấy danh sách các mục nhập hàng trong khoảng thời gian
    $inventoryEntries = InventoryEntry::whereBetween('inventory_entries.created_at', [$dateFrom, $dateTo]) // Điều kiện thời gian
        ->join('products', 'inventory_entries.product_id', '=', 'products.id') // JOIN với bảng sản phẩm để lấy thông tin sản phẩm
        ->orderBy('inventory_entries.created_at', 'desc') // Sắp xếp theo thời gian từ cao đến thấp
        ->get(['inventory_entries.created_at', 'inventory_entries.product_id', 'inventory_entries.quantity', 'inventory_entries.purchase_price', 'inventory_entries.total_purchase_price']); // Lấy các cột cần thiết

    // Chuyển đổi dữ liệu để có định dạng chuẩn
    $inventoryStats = $inventoryEntries->map(function ($entry) {
        // Lấy thông tin sản phẩm từ bảng products
        $product = Product::find($entry->product_id); // Lấy sản phẩm dựa trên product_id
    
        return [
            'date' => $entry->created_at->format('Y-m-d H:i:s'), // Định dạng ngày tháng
            'product_name' => $product ? $product->name : 'Không tìm thấy', // Trả về tên sản phẩm hoặc 'Không tìm thấy' nếu không có
            'product_id' => $entry->product_id,
            'quantity' => $entry->quantity,
            'total_purchase_price' => $entry->total_purchase_price, // Trả về tổng giá trị nhập hàng
        ];
    });
    

    // Tính toán mức tăng trưởng so với tuần trước (hoặc thời gian tương ứng)
    $previousStats = $this->getPreviousStats($timeRange);

    $growthRevenue = $this->calculateGrowth($totalRevenue, $previousStats['revenue']);
    $growthSold = $this->calculateGrowth($totalSold, $previousStats['sold']);

    // Trả về các thống kê đã tính toán, bao gồm thống kê nhập hàng
    return [
        'total_products' => $totalProducts,
        'total_revenue' => $totalRevenue,
        'total_sold' => $totalSold,
        'total_stock' => $totalStock,
        'total_profit' => $totalProfit,
        'growth_revenue' => $growthRevenue,
        'growth_sold' => $growthSold,
        'inventoryStats' => $inventoryStats, // Trả về danh sách nhập hàng đã xử lý
    ];
}


// Hàm lấy dữ liệu thống kê từ tuần trước (hoặc thời gian tương ứng)
private function getPreviousStats($timeRange)
{
    $previousDateFrom = Carbon::now()->subDays($timeRange + 7); // Lùi lại 7 ngày so với thời gian hiện tại
    $previousDateTo = Carbon::now()->subDays(7); // Ngày kết thúc của tuần trước

    // Lấy doanh thu và số lượng bán từ bảng order_details trong tuần trước
    $previousRevenue = Order::whereBetween('orders.created_at', [$previousDateFrom, $previousDateTo])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.id') // JOIN với bảng products để lấy giá sản phẩm
        ->sum(DB::raw('order_details.quantity * products.price'));
    
    $previousSold = Order::whereBetween('orders.created_at', [$previousDateFrom, $previousDateTo])
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->sum('order_details.quantity');

    return [
        'revenue' => $previousRevenue,
        'sold' => $previousSold,
    ];
}

// Hàm tính toán mức tăng trưởng
private function calculateGrowth($currentValue, $previousValue)
{
    if ($previousValue == 0) {
        return 0; // Tránh chia cho 0
    }
    return (($currentValue - $previousValue) / $previousValue) * 100;
}
public function create()
{
    // Lấy danh sách các danh mục để hiển thị trong form
    $categories = Category::all();
    return view('layouts.create_product', compact('categories'));
}

    
public function store(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'productName' => 'required|string|max:255',
        'productCategory' => 'required|exists:categories,id',
        'importPrice' => 'required|numeric|min:0',
        'originalPrice' => 'required|numeric|min:0',
        'discountPercent' => 'required|numeric|min:0|max:100',
        'stockQuantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Thêm sản phẩm mới
        $product = new Product();
        $product->name = $request->input('productName');
        $product->category_id = $request->input('productCategory');
        $product->purchase_price = $request->input('importPrice');
        $product->original_price = $request->input('originalPrice');
        $product->discount = $request->input('discountPercent');
        $product->quantity_in_stock = $request->input('stockQuantity');
        $product->description = $request->input('description');
        $product->save();

        // Xử lý ảnh nếu có
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageName = $product->id . '_product.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
            $product->save();
        }

        // Ghi log vào bảng Log_Products
        $log = new LogProducts();
        $log->product_id = $product->id; // ID của sản phẩm mới
        $log->action = 'add'; // Hành động là "add"
        $log->action_content = 'Đã thêm mới sản phẩm: ' . $product->name . ' | Giá nhập: ' . $product->purchase_price . ' | Giá gốc: ' . $product->original_price . ' | Số lượng tồn: ' . $product->quantity_in_stock;
        $log->admin_id = Auth::id(); // ID của admin hiện tại
        $log->created_at = now(); // Thời gian tạo log
        $log->updated_at = now(); // Thời gian cập nhật log
        $log->save(); // Lưu log vào bảng

        // Trả về phản hồi thành công
        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm!']);
    } catch (\Exception $e) {
        // Trả về phản hồi lỗi
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    




  
    
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            // Xóa sản phẩm
            $product->delete();
    
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting product']);
        }
    }
    public function filterProducts(Request $request)
    {
        // Bắt đầu truy vấn sản phẩm, mặc định bỏ qua sản phẩm có is_deleted = true
        $query = Product::where('is_deleted', false);
    
        // Lọc theo loại sản phẩm
        if ($request->has('type')) {
            $types = $request->input('type');
            $query->whereIn('category_id', $types);
        }
    
        // Lọc theo số sao
        if ($request->has('rating')) {
            $ratings = $request->input('rating');
            $ratingConditions = [
                '4-5' => 4,
                '3-4' => 3,
                '2-3' => 2,
            ];
    
            // Thêm điều kiện cho rating
            $query->whereHas('comments', function ($q) use ($ratings, $ratingConditions) {
                $q->selectRaw('product_id, AVG(star_rating) as average_rating')
                  ->groupBy('product_id');
    
                // Dùng orHaving cho các rating
                if (!empty($ratings)) {
                    $q->having(function ($having) use ($ratings, $ratingConditions) {
                        foreach ($ratings as $rating) {
                            if (isset($ratingConditions[$rating])) {
                                $having->orHavingRaw('AVG(star_rating) >= ?', [$ratingConditions[$rating]]);
                            }
                        }
                    });
                }
            });
        }
    
        // Lọc theo giá
        if ($request->has('price')) {
            $prices = $request->input('price');
    
            // Sử dụng orWhere cho từng khoảng giá
            $query->where(function ($q) use ($prices) {
                foreach ($prices as $price) {
                    if ($price == '301000') {
                        $q->orWhere('price', '>=', 301000);
                    } else {
                        list($minPrice, $maxPrice) = explode('-', $price);
                        $q->orWhereBetween('price', [(int)$minPrice, (int)$maxPrice]);
                    }
                }
            });
        }
    
        // Sắp xếp theo giá
        if ($request->has('sort_price')) {
            $sortPrice = $request->input('sort_price');
            if ($sortPrice == 'asc') {
                $query->orderBy('price', 'asc'); // Sắp xếp giá tăng dần
            } elseif ($sortPrice == 'desc') {
                $query->orderBy('price', 'desc'); // Sắp xếp giá giảm dần
            }
        }
    
        // Sắp xếp theo chữ cái
        if ($request->has('sort_name')) {
            $sortName = $request->input('sort_name');
            if ($sortName == 'az') {
                $query->orderBy('name', 'asc'); // Sắp xếp theo tên A-Z
            } elseif ($sortName == 'za') {
                $query->orderBy('name', 'desc'); // Sắp xếp theo tên Z-A
            }
        }
    
        // Lấy sản phẩm cùng với comments để tính rating trung bình (nếu cần hiển thị)
        $latestProducts = $query->with('comments')->get();
    
        return response()->json($latestProducts);
    }
    
    
    

    
    
    
public function viewSearch(Request $request){
    $user = Auth::user();
    $cartQuantity = 0;
    $categories = Category::all();
    if ($user) {
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
        }
    }
    return view('search',compact('cartQuantity','categories'));
}
public function quickView($id) 
{
    // Lấy thông tin sản phẩm hiện tại
    $product = Product::find($id);

    // Kiểm tra nếu sản phẩm bị xóa (is_deleted = 1), quay lại trang trước
    if ($product && $product->is_deleted == 1) {
        return redirect()->back()->with('error', 'Sản phẩm không còn khả dụng.');
    }

    // Lấy thành phần nguyên liệu của sản phẩm
    $ingredients = $product->ingredients;

    // Kiểm tra nếu không có nguyên liệu cho sản phẩm
    if ($ingredients->isEmpty()) {
        $ingredientsMessage = "Sản phẩm này không có thành phần nguyên liệu.";
    } else {
        $ingredientsMessage = null; // Có nguyên liệu thì không cần thông báo
    }
    
    // Lấy thành phần dinh dưỡng của sản phẩm (nếu không có thì mặc định là 0)
    $nutritionFact = NutritionFact::where('product_id', $id)->first();
    
    if (!$nutritionFact) {
        // Tạo một bản ghi dinh dưỡng mặc định với giá trị = 0 nếu không có
        $nutritionFact = new NutritionFact([
            'calories' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrate' => 0,
            'sugar' => 0,
            'fiber' => 0
        ]);
    }
    
    // Kiểm tra xem sản phẩm có nguyên liệu là đường hay không
    $hasSugarInIngredients = $ingredients->contains(function ($ingredient) {
        return strtolower($ingredient->name) === 'Đường';  // Kiểm tra xem tên nguyên liệu có phải là "đường"
    });
    
    // Nếu có thành phần đường trong nguyên liệu, lấy giá trị đường từ nguyên liệu
    if ($hasSugarInIngredients) {
        $sugarInIngredients = $ingredients->filter(function ($ingredient) {
            return strtolower($ingredient->name) === 'Đường';  // Lọc nguyên liệu là đường
        });
    
        // Tính tổng lượng đường trong các nguyên liệu (giả sử mỗi nguyên liệu đường có một lượng nhất định)
        $sugarAmount = $sugarInIngredients->sum(function ($ingredient) {
            return $ingredient->pivot->quantity;  // Giả sử quantity lưu lượng đường trong nguyên liệu
        });
    
        // Cập nhật lại giá trị đường từ nguyên liệu
        $nutritionFact->sugar = $sugarAmount;  // Đường sẽ lấy từ nguyên liệu
    } else {
        // Nếu không có đường trong nguyên liệu, lấy đường từ cơ sở dữ liệu dinh dưỡng
        $nutritionFact->sugar = $nutritionFact->sugar;  // Đường sẽ lấy từ cơ sở dữ liệu (không thay đổi)
    }
    
    // Mức tiêu thụ khuyến cáo trong ngày cho các thành phần dinh dưỡng
    $recommendedDailyIntake = [
        'protein' => 50,   // Chất đạm: 50g
        'fat' => 70,       // Chất béo: 70g
        'carbohydrate' => 300, // Carbohydrate: 300g
        'sugar' => 25,     // Đường: 25g (lấy giá trị tối đa cho đường)
        'fiber' => 30      // Chất xơ: 30g
    ];
    

    // Tính tỷ lệ các thành phần dinh dưỡng so với mức tiêu thụ khuyến cáo
    $nutritionRatio = [
        'protein' => ($nutritionFact->protein / $recommendedDailyIntake['protein']) * 100,
        'fat' => ($nutritionFact->fat / $recommendedDailyIntake['fat']) * 100,
        'carbohydrate' => ($nutritionFact->carbohydrate / $recommendedDailyIntake['carbohydrate']) * 100,
        'sugar' => ($nutritionFact->sugar / $recommendedDailyIntake['sugar']) * 100,
        'fiber' => ($nutritionFact->fiber / $recommendedDailyIntake['fiber']) * 100
    ];

    // Lấy thông tin người dùng
    $user = Auth::user();
    $cartQuantity = 0;
    $isBlocked = false;
    $hasPurchased = 0;

    if ($user) {
        // Tính tổng số lượng sản phẩm trong giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
        }

        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $hasPurchased = OrderDetail::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('status', 'completed');
            })
            ->where('product_id', $id)
            ->exists() ? 1 : 0;
    }

    // Lấy sản phẩm liên quan theo danh mục và giá gần nhất
    $relatedProducts = Product::where('id', '!=', $product->id)
    ->where('is_deleted', 0)
    ->where(function($query) use ($product) {
        // Ưu tiên lấy sản phẩm cùng danh mục trước
        $query->where('category_id', $product->category_id)
              ->orWhereRaw('1=1'); // Fallback để lấy các sản phẩm khác nếu không đủ
    })
    ->orderByRaw('CASE 
        WHEN category_id = ? THEN 0 
        ELSE 1 
    END', [$product->category_id]) // Ưu tiên sắp xếp sản phẩm cùng danh mục lên trước
    ->orderByRaw('ABS(price - ?) ASC', [$product->price])
    ->limit(20)
    ->get();

    // Nếu vẫn chưa đủ 10 sản phẩm, lấy thêm ngẫu nhiên
    if ($relatedProducts->count() < 20) {
        $remainingCount = 20 - $relatedProducts->count();
        $existingIds = $relatedProducts->pluck('id')->push($product->id)->toArray();
        
        $additionalProducts = Product::where('is_deleted', 0)
            ->whereNotIn('id', $existingIds)
            ->inRandomOrder()
            ->limit($remainingCount)
            ->get();
        
        // Gộp collection
        $relatedProducts = $relatedProducts->concat($additionalProducts);
    }

    // Lấy comment cho sản phẩm
    $commentsQuery = $product->comments()
        ->with('user')
        ->where('is_block', false);

    if ($user) {
        $commentsQuery->orderByRaw('user_id = ? DESC', [$user->id]);
    }

    $commentsQuery->orderBy('created_at', 'desc');
    $comments = $commentsQuery->paginate(10);

    // Tính số sao trung bình
    $averageRating = $product->comments()->where('is_block', false)->avg('star_rating');

    return view('quick_view', compact('product', 'relatedProducts', 'comments', 'averageRating', 'cartQuantity', 'isBlocked', 'hasPurchased', 'nutritionRatio', 'nutritionFact', 'ingredients', 'ingredientsMessage'));
}







public function search(Request $request)
{
    $query = $request->input('query');
    
    // Tìm sản phẩm theo tên, giới hạn 5 kết quả, bỏ qua sản phẩm đã bị xóa
    $products = Product::where('name', 'LIKE', '%' . $query . '%')
                       ->where('is_deleted', 0)  // Bỏ qua sản phẩm đã bị xóa
                       ->get();

    if ($products->isEmpty()) {
        return response()->json(['status' => 'no_results']);
    }

    return response()->json([
        'status' => 'success',
        'products' => $products
    ]);
}

public function searchmenu(Request $request)
{
    $query = $request->input('query');

    // Kiểm tra nếu có từ khóa tìm kiếm, đồng thời cho phép tìm kiếm theo ID sản phẩm
    $products = Product::with('category')
        ->where('name', 'LIKE', "%$query%")
        ->where('is_deleted', 0)  // Bỏ qua sản phẩm đã bị xóa
        ->orWhere('id', 'LIKE', "%$query%") // Tìm kiếm theo ID sản phẩm
        ->orWhereHas('category', function($q) use ($query) {
            $q->where('name', 'LIKE', "%$query%"); // Tìm kiếm theo tên danh mục
        })
        ->get();

    return response()->json($products);
}



public function addOrUpdateComment(Request $request, Product $product) 
{
    try {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'star_rating' => 'required|integer|between:1,5'
        ]);

        // Kiểm tra user đã đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để bình luận'
            ], 401);
        }

        $user = Auth::user();
        
        // Tìm comment cũ
        $comment = CommentProduct::where('product_id', $product->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($comment) {
            // Cập nhật comment
            $comment->update([
                'content' => $validated['content'],
                'star_rating' => $validated['star_rating']
            ]);
            $message = 'Cập nhật bình luận thành công.';
        } else {
            // Tạo comment mới
            $comment = CommentProduct::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'content' => $validated['content'],
                'star_rating' => $validated['star_rating']
            ]);
            $message = 'Thêm bình luận mới thành công.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'userName' => $user->name,
            'content' => $comment->content,
            'star_rating' => $comment->star_rating,
            'created_at' => $comment->created_at
        ]);

    } catch (\Exception $e) {
       
        return response()->json([
            'status' => 'error',
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
        ], 500);
    }
}

public function like(Request $request)
{
    $request->validate(['comment_id' => 'required|exists:comment_products,id']);
    $userId = Auth::id();
    $commentId = $request->input('comment_id');

    // Tìm comment
    $comment = CommentProduct::find($commentId);
    
    // Kiểm tra phản hồi của người dùng
    $userReact = UserReact::where('user_id', $userId)
        ->where('react_comment_product_id', $commentId)
        ->first();

    if ($userReact) {
        if ($userReact->like) {
            // Nếu đã like rồi, chỉ cần giảm like
            $userReact->like = false;
            $comment->likes -= 1; // Giảm số lượng like
        } else {
            // Nếu đã dislike, giảm dislike rồi tăng like
            if ($userReact->dislike) {
                $userReact->dislike = false;
                $comment->dislikes -= 1; // Giảm số lượng dislike
            }
            $userReact->like = true;
            $comment->likes += 1; // Tăng số lượng like
        }
        $userReact->updated_at = now();
        $userReact->save();
    } else {
        // Nếu chưa có phản hồi, tạo mới
        UserReact::create([
            'user_id' => $userId,
            'react_comment_product_id' => $commentId,
            'like' => true,
            'dislike' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $comment->likes += 1; // Tăng số lượng like
    }

    $comment->save();

    return response()->json(['likes' => $comment->likes, 'dislikes' => $comment->dislikes]);
}

public function dislike(Request $request)
{
    $request->validate(['comment_id' => 'required|exists:comment_products,id']);
    $userId = Auth::id();
    $commentId = $request->input('comment_id');

    // Tìm comment
    $comment = CommentProduct::find($commentId);

    // Kiểm tra phản hồi của người dùng
    $userReact = UserReact::where('user_id', $userId)
        ->where('react_comment_product_id', $commentId)
        ->first();

    if ($userReact) {
        if ($userReact->dislike) {
            // Nếu đã dislike rồi, chỉ cần giảm dislike
            $userReact->dislike = false;
            $comment->dislikes -= 1; // Giảm số lượng dislike
        } else {
            // Nếu đã like, giảm like rồi tăng dislike
            if ($userReact->like) {
                $userReact->like = false;
                $comment->likes -= 1; // Giảm số lượng like
            }
            $userReact->dislike = true;
            $comment->dislikes += 1; // Tăng số lượng dislike
        }
        $userReact->updated_at = now();
        $userReact->save();
    } else {
        // Nếu chưa có phản hồi, tạo mới
        UserReact::create([
            'user_id' => $userId,
            'react_comment_product_id' => $commentId,
            'like' => false,
            'dislike' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $comment->dislikes += 1; // Tăng số lượng dislike
    }

    $comment->save();

    return response()->json(['likes' => $comment->likes, 'dislikes' => $comment->dislikes]);
}

public function showStatistics($productId)
{
    // Lấy thông tin sản phẩm
    $product = Product::find($productId);

    if (!$product) {
        return response()->json(['message' => 'Sản phẩm không tồn tại.'], 404);
    }

    // 1. Doanh số tháng này và mức tăng
    $currentMonth = Carbon::now()->startOfMonth();
    $previousMonth = Carbon::now()->subMonth()->startOfMonth();

    // Tính doanh số tháng này
    $currentMonthSales = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'products.id', '=', 'order_details.product_id')
        ->where('orders.status', 'completed')
        ->where('order_details.product_id', $productId)
        ->where('orders.created_at', '>=', $currentMonth)
        ->sum(DB::raw('order_details.quantity * products.price')); // Tính doanh thu

    // Tính doanh số tháng trước
    $previousMonthSales = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'products.id', '=', 'order_details.product_id')
        ->where('orders.status', 'completed')
        ->where('order_details.product_id', $productId)
        ->whereBetween('orders.created_at', [$previousMonth, $currentMonth->subDay()])
        ->sum(DB::raw('order_details.quantity * products.price'));

    // Tính mức độ tăng trưởng doanh thu
    if ($previousMonthSales == 0 && $currentMonthSales == 0) {
        $salesIncrease = 0;
    } elseif ($previousMonthSales == 0) {
        $salesIncrease = 100;
    } elseif ($currentMonthSales == 0) {
        $salesIncrease = -100;
    } else {
        $salesIncrease = round((($currentMonthSales - $previousMonthSales) / $previousMonthSales) * 100, 2);
    }

    // 2. Số lượng bán ra tháng này và tháng trước
    $currentMonthQuantity = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->where('orders.status', 'completed')
        ->where('order_details.product_id', $productId)
        ->where('orders.created_at', '>=', $currentMonth)
        ->sum('order_details.quantity'); // Số lượng bán ra tháng này

    $previousMonthQuantity = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->where('orders.status', 'completed')
        ->where('order_details.product_id', $productId)
        ->whereBetween('orders.created_at', [$previousMonth, $currentMonth->subDay()])
        ->sum('order_details.quantity'); // Số lượng bán ra tháng trước

    // Tính mức độ tăng trưởng số lượng bán ra
    if ($previousMonthQuantity == 0 && $currentMonthQuantity == 0) {
        $quantityIncrease = 0;
    } elseif ($previousMonthQuantity == 0) {
        $quantityIncrease = 100;
    } elseif ($currentMonthQuantity == 0) {
        $quantityIncrease = -100;
    } else {
        $quantityIncrease = round((($currentMonthQuantity - $previousMonthQuantity) / $previousMonthQuantity) * 100, 2);
    }

    // 3. Số lượng đã bán
    $quantitySold = $product->quantity_sold;

    // 4. Đánh giá trung bình
    $averageRating = CommentProduct::where('product_id', $productId)
        ->where('is_block', false) // Chỉ tính đánh giá hợp lệ
        ->avg('star_rating');
    $averageRating = round($averageRating, 1);

    // 5. Tồn kho
    $stockLeft = $product->quantity_in_stock;

    // 6. Biểu đồ doanh số (6 tháng gần nhất)
    $lastSixMonths = OrderDetail::join('orders', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'products.id', '=', 'order_details.product_id')
        ->where('orders.status', 'completed')
        ->where('order_details.product_id', $productId)
        ->where('orders.created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
        ->select(
            DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as month"),
            DB::raw("SUM(order_details.quantity * products.price) as total_sales")
        )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    // Format dữ liệu biểu đồ
    $chartData = [
        'labels' => $lastSixMonths->pluck('month'),
        'data' => $lastSixMonths->pluck('total_sales')
    ];

    // Trả về dữ liệu
    return response()->json([
        'product' => $product->name,
        'currentMonthSales' => $currentMonthSales,
        'previousMonthSales' => $previousMonthSales,
        'salesIncrease' => $salesIncrease,
        'currentMonthQuantity' => $currentMonthQuantity, // Số lượng bán ra tháng này
        'previousMonthQuantity' => $previousMonthQuantity, // Số lượng bán ra tháng trước
        'quantityIncrease' => $quantityIncrease, // Mức độ tăng trưởng số lượng
        'quantitySold' => $quantitySold,
        'averageRating' => $averageRating,
        'stockLeft' => $stockLeft,
        'chartData' => $chartData,
    ]);
}
public function fetchProducts(Request $request)
{
    // Lấy số lượng sản phẩm cần hiển thị từ query string
    $limit = $request->get('limit', 10); // Mặc định hiển thị 10 sản phẩm

    // Lấy danh sách sản phẩm chưa bị xóa
    $products = Product::with('category')
        ->where('is_deleted', false) // Bỏ qua sản phẩm bị xóa
        ->orderBy('created_at', 'desc')
        ->take($limit)
        ->get();

    return response()->json([
        'products' => $products
    ]);
}

public function filterAndSort(Request $request)
{
    $categoryId = $request->get('category', 'all');
    $sortOption = $request->get('sort', 'date_desc');

    // Tạo query sản phẩm, mặc định bỏ qua sản phẩm bị xóa
    $query = Product::where('is_deleted', false);

    // Lọc theo danh mục
    if ($categoryId !== 'all') {
        $query->where('category_id', $categoryId);
    }

    // Sắp xếp sản phẩm
    switch ($sortOption) {
        case 'date_asc':
            $query->orderBy('created_at', 'asc');
            break;
        case 'date_desc':
            $query->orderBy('created_at', 'desc');
            break;
        case 'rating_desc':
            $query->orderByDesc(
                CommentProduct::whereColumn('product_id', 'products.id')
                    ->selectRaw('AVG(star_rating)')
            );
            break;
        case 'rating_asc':
            $query->orderBy(
                CommentProduct::whereColumn('product_id', 'products.id')
                    ->selectRaw('AVG(star_rating)')
            );
            break;
        default:
            $query->orderBy('created_at', 'desc');
            break;
    }

    $products = $query->with('category')->get();

    // Tính điểm đánh giá trung bình cho từng sản phẩm
    foreach ($products as $product) {
        $averageRating = CommentProduct::where('product_id', $product->id)
            ->where('is_block', false)
            ->avg('star_rating');
        $product->average_rating = round($averageRating, 1);
    }

    return response()->json(['products' => $products]);
}

    public function searchProduct(Request $request)
    {
        $query = $request->get('query', ''); // Lấy từ khóa tìm kiếm

        // Tìm kiếm theo mã, tên, hoặc danh mục
        $products = Product::query()
       -> where('is_deleted', false)
            ->where('id', 'like', "%$query%") // Tìm theo mã sản phẩm
            ->orWhere('name', 'like', "%$query%") // Tìm theo tên sản phẩm
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%"); // Tìm theo tên danh mục
            })
            ->with('category') // Load quan hệ danh mục
            ->get();

        // Trả về kết quả
        return response()->json(['products' => $products]);
    }
    public function getStatistics(Request $request)
    {
        // Lấy tham số bộ lọc thời gian và mức tăng trưởng
        $time = $request->input('time', 'month'); // Mặc định thống kê theo tháng
        $growth = $request->input('growth', 'all'); // Mặc định không áp dụng bộ lọc tăng trưởng
    
        // Bộ lọc theo thời gian
        $query = Order::where('is_deleted', false)->where('status', 'completed');
        if ($time === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($time === 'year') {
            $query->whereYear('created_at', now()->year);
        }
    
        // Tổng doanh thu
        $totalRevenue = $query->sum('total_amount');
    
        // Tổng số lượng sản phẩm đã bán
        $productsSold = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.is_deleted', false)
            ->where('orders.status', 'completed')
            ->sum('order_details.quantity');
    
        // Doanh thu trung bình
        $averageRevenue = $totalRevenue / max($productsSold, 1);
    
        // Dữ liệu doanh số theo thời gian (cho biểu đồ)
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('is_deleted', false)
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total,
                ];
            });
    
        // Doanh thu theo danh mục sản phẩm
        $categoryData = Product::selectRaw('categories.name as category_name, SUM(order_details.quantity * products.price) as revenue')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.is_deleted', false)
            ->where('orders.status', 'completed')
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category_name,
                    'revenue' => $item->revenue,
                ];
            });
    
        // Sản phẩm bán chạy
        $topProductsData = Product::selectRaw('products.name, SUM(order_details.quantity) as total_sold')
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.is_deleted', false)
            ->where('orders.status', 'completed')
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(5) // Lấy top 5 sản phẩm
            ->get()
            ->map(function ($item) {
                return [
                    'product' => $item->name,
                    'total_sold' => $item->total_sold,
                ];
            });
    
        // Trả về kết quả JSON
        return response()->json([
            'totalRevenue' => $totalRevenue,
            'productsSold' => $productsSold,
            'averageRevenue' => round($averageRevenue, 2),
            'salesData' => $salesData,
            'categoryData' => $categoryData,
            'topProductsData' => $topProductsData,
        ]);
    }
    public function getChartsData(Request $request)
{
    // Dữ liệu cho biểu đồ doanh thu bán hàng
    $salesData = $this->getSalesData($request); // Hàm lấy doanh thu bán hàng

    // Dữ liệu cho biểu đồ phân bổ danh mục
    $categoryData = $this->getCategoryData($request); // Hàm lấy phân bổ danh mục

    return response()->json([
        'sales' => $salesData,
        'categories' => $categoryData
    ]);
}

// Lấy doanh thu bán hàng theo ngày
private function getSalesData(Request $request)
{
    return Order::selectRaw('DATE(orders.created_at) as date, SUM(order_details.quantity * products.price) as total') // Sử dụng products.price thay vì order_details.price
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.id') // Thêm join với bảng products
        ->whereBetween('orders.created_at', [Carbon::now()->subMonth(), Carbon::now()])
        ->groupBy('date')
        ->pluck('total', 'date');
}


// Lấy phân bổ doanh thu theo danh mục
// Lấy phân bổ doanh thu theo danh mục
private function getCategoryData(Request $request)
{
    return Product::join('categories', 'products.category_id', '=', 'categories.id')
        ->join('order_details', 'products.id', '=', 'order_details.product_id') // Thêm join với bảng order_details
        ->selectRaw('categories.name, SUM(order_details.quantity * products.price) as total') // Sử dụng price từ bảng products
        ->groupBy('categories.name')
        ->pluck('total', 'categories.name');
}

public function getRestockSuggestions(Request $request)
{
    // Số ngày để tính trung bình doanh số bán hàng
    $days = $request->input('days', 15);
    $dateFrom = Carbon::now()->subDays($days);
    $dateTo = Carbon::now();

    // Lấy dữ liệu sản phẩm và thống kê bán hàng
    $products = Product::with('category')
        ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
        ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
        ->select(
            'products.id',
            'products.name',
            'products.quantity_in_stock', // Số lượng tồn
            DB::raw("SUM(CASE WHEN orders.created_at BETWEEN '$dateFrom' AND '$dateTo' THEN order_details.quantity ELSE 0 END) as sold_15_days"), // Doanh số bán 15 ngày
            DB::raw("SUM(CASE WHEN orders.created_at BETWEEN '$dateFrom' AND '$dateTo' THEN order_details.quantity ELSE 0 END) / $days as avg_sold_per_day") // TB bán/ngày
        )
        ->groupBy('products.id', 'products.name', 'products.quantity_in_stock')
        ->get();

    // Xử lý tính toán
    $suggestions = $products->map(function ($product) use ($days) {
        $avgSoldPerDay = $product->avg_sold_per_day ?? 0;
        $daysToOutOfStock = ($avgSoldPerDay > 0) ? floor($product->quantity_in_stock / $avgSoldPerDay) : PHP_INT_MAX; // Ngày hết dự kiến

        // Gợi ý nhập và trạng thái
        $status = 'Bình thường';
        $restockSuggestion = 0;

        if ($daysToOutOfStock <= 3 && $product->quantity_in_stock <= 10) {
            $status = 'Cần nhập gấp';
        } elseif ($daysToOutOfStock <= 4 && $product->quantity_in_stock > 10 && $product->quantity_in_stock <= 20) {
            $status = 'Sắp hết hàng';
        } elseif ($daysToOutOfStock <= 5) {
            $status = 'Bình thường';
        }

        if ($daysToOutOfStock <= 5) {
            $restockSuggestion = ceil($avgSoldPerDay * 10); // Đề xuất nhập thêm 10 ngày tồn kho
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category->name ?? 'N/A', // Tham chiếu danh mục
            'stock' => $product->quantity_in_stock,
            'sold_15_days' => $product->sold_15_days,
            'avg_sold_per_day' => round($avgSoldPerDay, 2),
            'days_to_out_of_stock' => $daysToOutOfStock,
            'restock_suggestion' => $restockSuggestion,
            'status' => $status,
        ];
    });

    return response()->json($suggestions);
}

public function checkProducts(Request $request)
{
    // Lấy danh sách mã sản phẩm và tên sản phẩm từ yêu cầu
    $productCodes = $request->input('productCodes');
    $productNames = $request->input('productNames');  // Tên sản phẩm

    // Kiểm tra xem danh sách mã sản phẩm có hợp lệ không
    if (!$productCodes || !is_array($productCodes) || !$productNames || !is_array($productNames)) {
        return response()->json([
            'success' => false,
            'message' => 'Danh sách mã sản phẩm hoặc tên sản phẩm không hợp lệ',
        ], 400);
    }

    // Chuyển tất cả mã sản phẩm và tên sản phẩm về dạng chuỗi để so sánh
    $productCodes = array_map('strval', $productCodes);
    $productNames = array_map('strval', $productNames);

    // Truy vấn tìm các sản phẩm tồn tại trong CSDL
    $existingProducts = Product::whereIn('id', $productCodes)
        ->pluck('id') // Chỉ lấy danh sách mã sản phẩm tồn tại
        ->map(function ($id) {
            return (string) $id; // Chuyển mỗi ID về dạng chuỗi
        })
        ->toArray();

    // Phân loại mã sản phẩm hợp lệ và không hợp lệ
    $validProducts = array_intersect($productCodes, $existingProducts); // Các mã sản phẩm hợp lệ
    $invalidProducts = array_diff($productCodes, $existingProducts); // Các mã sản phẩm không hợp lệ

    // Kiểm tra tên sản phẩm và phân loại tên không khớp (đây không ảnh hưởng đến việc hợp lệ của sản phẩm)
    $nameMismatchProducts = [];
    foreach ($productCodes as $index => $code) {
        if (in_array($code, $validProducts) && isset($productNames[$index])) {
            // Kiểm tra tên sản phẩm từ client và trong cơ sở dữ liệu
            $product = Product::where('id', $code)->first();
            if ($product && $product->name !== $productNames[$index]) {
                $nameMismatchProducts[] = $code;  // Thêm mã sản phẩm nếu tên không khớp
            }
        }
    }

    // Trả về kết quả chi tiết
    return response()->json([
        'success' => true,
        'validProducts' => $validProducts,
        'invalidProducts' => $invalidProducts,
        'nameMismatchProducts' => $nameMismatchProducts,  // Thêm thông tin sản phẩm có tên không khớp
    ]);
}
public function importProducts(Request $request)
{
    $data = $request->input('selectedRows');  // Dữ liệu từ frontend (dữ liệu đã chọn)

    // Kiểm tra nếu không có sản phẩm nào được chọn
    if (empty($data)) {
        return response()->json(['success' => false, 'message' => 'No products selected']);
    }

    // Lấy admin_id từ Auth
    $adminId = Auth::id();

    // Duyệt qua từng sản phẩm được chọn để xử lý
    foreach ($data as $row) {
        $productId = $row['maSP'];
        $purchasePrice = $row['giaNhap'];
        $quantity = $row['soLuongNhap'];

        // Cập nhật giá nhập và số lượng vào bảng 'products'
        $product = Product::find($productId);
        if ($product) {
            $product->update([
                'purchase_price' => $purchasePrice,
                'quantity' => $product->quantity + $quantity,  // Cộng thêm số lượng nhập kho
            ]);
        }

        // Thêm bản ghi vào bảng 'inventory_entries'
        InventoryEntry::create([
            'product_id' => $productId,
            'purchase_price' => $purchasePrice,
            'quantity' => $quantity,
            'mode' => 'import',  // Hoặc 'online' tùy vào yêu cầu
        ]);

        // Thêm log vào bảng 'log_products'
        LogProducts::create([
            'product_id' => $productId,
            'action' => 'import',
            'action_content' => "Nhập hàng: Mã SP: {$productId}, Tên SP: {$row['tenSP']}, Số lượng: {$quantity}",
            'admin_id' => $adminId,
        ]);
    }

    // Trả về phản hồi thành công
    return response()->json([
        'success' => true,
        'message' => 'Import successful',
    ]);
}
public function getHistory(Request $request)
{
    $query = LogProducts::query();

    // Bộ lọc theo ngày bắt đầu
    if ($request->filled('dateFrom')) {
        $query->where('created_at', '>=', $request->input('dateFrom'));
    }

    // Bộ lọc theo ngày kết thúc
    if ($request->filled('dateTo')) {
        $query->where('created_at', '<=', $request->input('dateTo'));
    }

    // Bộ lọc theo hành động
    if ($request->filled('action')) {
        $query->where('action', $request->input('action'));
    }

    // Thực hiện join với bảng products và users để lấy tên sản phẩm và tên admin
    $logs = $query->with(['product', 'admin'])->get();

    return response()->json([
        'data' => $logs,
    ]);
}
public function validateMaspCategory(Request $request)
{
    $masp = $request->masp;
    $category = $request->category;

    // Kiểm tra mã sản phẩm
    $maspExists = Product::where('id', $masp)->exists();
    if ($maspExists) {
        return response()->json(['maspStatus' => 'duplicated'], 200);
    }

    // Kiểm tra danh mục
    $categoryExists = Category::where('name', $category)->exists();
    if (!$categoryExists) {
        return response()->json(['categoryStatus' => 'not_found'], 200);
    }

    // Kiểm tra định dạng dữ liệu (ví dụ: kiểm tra giá trị numeric cho các cột)
    // ...

    return response()->json(['maspStatus' => 'valid', 'categoryStatus' => 'valid'], 200);
}
public function storeMultiple(Request $request)
{
    $products = $request->input('products');
    if (!is_array($products) || empty($products)) {
        return response()->json(['success' => false, 'message' => 'Dữ liệu sản phẩm không hợp lệ!'], 400);
    }

    $errors = [];
    $addedProducts = [];
    $logDetails = []; // Mảng lưu thông tin log chi tiết

    foreach ($products as $productData) {
        try {
            // Tìm category_id dựa trên tên danh mục
            $category = Category::where('name', $productData['category'])->first();
            if (!$category) {
                throw new \Exception("Danh mục '{$productData['category']}' không tồn tại.");
            }

            // Tạo sản phẩm mới
            $product = Product::create([
                'name' => $productData['name'],
                'category_id' => $category->id,
                'purchase_price' => $productData['importPrice'],
                'original_price' => $productData['originalPrice'],
                'discount' => $productData['discountPercent'],
                'price' => $productData['finalPrice'],
                'quantity_in_stock' => $productData['stockQuantity'],
                'description' => $productData['description'],
                'image' => null, // Không có ảnh
                'posted_date' => now(),
                'quantity_sold' => 0,
                'created_at' => now(),
            ]);

            $addedProducts[] = $product->name;

            // Thêm thông tin sản phẩm mới vào log chi tiết
            $logDetails[] = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $category->name,
                'price' => $product->price,
                'stock' => $product->quantity_in_stock,
            ];
        } catch (\Exception $e) {
            $errors[] = [
                'product' => $productData['name'],
                'error' => $e->getMessage(),
            ];
        }
    }

    // Nếu có lỗi xảy ra, trả về phản hồi với thông tin lỗi
    if (!empty($errors)) {
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra trong quá trình thêm sản phẩm.',
            'errors' => $errors,
        ], 422);
    }

    // Ghi log vào bảng Log_Products
    $logContent = "Thêm nhiều sản phẩm: " . implode(", ", array_map(function ($product) {
        return "ID {$product['id']} - {$product['name']} (Danh mục: {$product['category']}, Giá: {$product['price']}, SL tồn: {$product['stock']})";
    }, $logDetails));

    LogProducts::create([
        'product_id' => null, // Không cần chỉ định một sản phẩm cụ thể
        'action' => 'store_multiple',
        'action_content' => $logContent,
        'admin_id' => Auth::id(),
        'created_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Thêm sản phẩm thành công!',
        'addedProducts' => $addedProducts,
    ]);
}

public function edit($id)
{
    // Tìm sản phẩm theo ID
    $product = Product::find($id);

    // Kiểm tra nếu sản phẩm không tồn tại
    if (!$product) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    // Trả về dữ liệu sản phẩm dưới dạng JSON
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'category_id' => $product->category_id,
        'created_at' => $product->created_at,
        'original_price' => $product->original_price,
        'discount' => $product->discount,
        'price' => $product->price,
        'quantity_in_stock' => $product->quantity_in_stock,
        'quantity_sold' => $product->quantity_sold,
        'description' => $product->description,
        'image' => $product->image, // Đường dẫn ảnh nếu có
    ]);
}



public function update(Request $request, $id)
{
    // Lấy sản phẩm cũ từ database
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    // Lưu giá trị cũ để so sánh với giá trị mới
    $oldProduct = $product->toArray();

    // Cập nhật thông tin sản phẩm với dữ liệu mới
    $product->name = $request->input('name');
    $product->category_id = $request->input('category_id');
    $product->original_price = $request->input('original_price');
    $product->discount = $request->input('discount');
    $product->price = $request->input('price');
    $product->quantity_in_stock = $request->input('quantity_in_stock');
    $product->quantity_sold = $request->input('quantity_sold');
    $product->description = $request->input('description');

    // Kiểm tra và xử lý ảnh nếu có thay đổi
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($product->image && File::exists(public_path('images/' . $product->image))) {
            File::delete(public_path('images/' . $product->image));
        }

        // Lưu ảnh mới
        $image = $request->file('image');
        $imageExtension = $image->getClientOriginalExtension();
        $imageName = $product->id . '.' . $imageExtension; // Đặt tên ảnh theo id sản phẩm

        // Lưu ảnh vào thư mục images
        $image->move(public_path('images'), $imageName);

        // Cập nhật trường 'image' trong database
        $product->image = $imageName;
    }

    // Kiểm tra xem có thay đổi gì không
    $productChanged = false;
    $changeLog = []; // Mảng để lưu log thay đổi

    // Duyệt qua các thuộc tính để kiểm tra sự thay đổi
    foreach ($product->getAttributes() as $key => $newValue) {
        $oldValue = $oldProduct[$key];

        if ($oldValue != $newValue) {
            // Nếu có sự thay đổi, ghi lại thông tin thay đổi
            $productChanged = true;
            $changeLog[] = ucfirst(str_replace('_', ' ', $key)) . ": Từ '$oldValue' thành '$newValue'";
        }
    }

    // Nếu không có thay đổi nào thì trả về thông báo
    if (!$productChanged) {
        return response()->json(['message' => 'Không có thay đổi nào được thực hiện'], 200);
    }

    // Lưu lại thông tin vào bảng products
    $product->save();

    // Thêm log vào bảng Log_Products
    LogProducts::create([
        'product_id' => $product->id,
        'action' => 'update',
        'action_content' => 'Cập nhật sản phẩm ' . $product->id . ': ' . implode(', ', $changeLog), // Ghi lại các thay đổi cụ thể
        'admin_id' => Auth::id(),  // Lấy id của admin từ Auth
        'created_at' => now(),
    ]);

    // Trả về thông báo thành công
    return response()->json(['message' => 'Sản phẩm đã được cập nhật thành công'], 200);
}

public function getProductHistory(Request $request, $productId)
{
    // Lấy lịch sử của sản phẩm dựa trên ID
    $query = LogProducts::where('product_id', $productId);

    // Nếu có bộ lọc ngày, áp dụng
    if ($request->has('date_start') && $request->date_start) {
        $query->whereDate('created_at', '>=', $request->date_start);
    }

    if ($request->has('date_end') && $request->date_end) {
        $query->whereDate('created_at', '<=', $request->date_end);
    }

    // Nếu có bộ lọc loại thao tác, áp dụng
    if ($request->has('actions') && is_array($request->actions) && count($request->actions) > 0) {
        $query->whereIn('action', $request->actions);
    }

    // Truy vấn lịch sử sản phẩm
    $logs = $query->orderBy('created_at', 'desc')->get();

    // Gắn thông tin admin vào mỗi log
    $logs->load('admin:id,name');

    return response()->json($logs, 200);
}

public function filterStats(Request $request)
{
    $category = $request->get('category');
    $timeRange = $request->get('time', 7);
    $dateFrom = $request->get('date_from');
    $dateTo = $request->get('date_to');

    // Nếu người dùng chọn "custom", sử dụng date_from và date_to
    if ($timeRange === 'custom' && $dateFrom && $dateTo) {
        $dateFrom = Carbon::parse($dateFrom);
        $dateTo = Carbon::parse($dateTo);
    } else {
        // Mặc định tính theo time range
        $dateFrom = Carbon::now()->subDays($timeRange);
        $dateTo = Carbon::now();
    }

    // Thống kê dữ liệu
    $stats = $this->getProductStats($timeRange, $dateFrom, $dateTo);
    $topProducts = $this->getTopSellingProducts($dateFrom, $dateTo);

    // Trả về dữ liệu dưới dạng JSON
    return response()->json([
        'stats' => $stats,
        'topProducts' => $topProducts,
    ]);
}
public function delete($id)
{
    $product = Product::findOrFail($id);

    // Đặt is_deleted thành true
    $product->is_deleted = true;
    $product->save();

    return response()->json(['message' => 'Sản phẩm đã được xóa thành công!'], 200);
}

public function getNutritionFact($productId)
{
    // Lấy thông tin dinh dưỡng của sản phẩm
    $nutritionFact = NutritionFact::where('product_id', $productId)->first();

    // Lấy tên sản phẩm
    $product = Product::find($productId);

    // Kiểm tra xem sản phẩm và thông tin dinh dưỡng có tồn tại không
    if ($nutritionFact && $product) {
        return response()->json([
            'productName' => $product->name,
            'calories' => $nutritionFact->calories,
            'protein' => $nutritionFact->protein,
            'fat' => $nutritionFact->fat,
            'carbohydrate' => $nutritionFact->carbohydrate,
            'sugar' => $nutritionFact->sugar,
            'fiber' => $nutritionFact->fiber,
        ]);
    }

    // Nếu không có thông tin dinh dưỡng, trả về null
    return response()->json(null);
}

    // Lưu thông tin dinh dưỡng
    public function saveNutritionFact(Request $request)
    {
        // Kiểm tra nếu bản ghi với product_id không tồn tại thì tạo mới
        $nutritionFact = NutritionFact::updateOrCreate(
            ['product_id' => $request->product_id], // Điều kiện để kiểm tra bản ghi
            $request->only(['calories', 'protein', 'fat', 'carbohydrate', 'sugar', 'fiber']) // Các trường cần cập nhật hoặc tạo mới
        );
    
        return response()->json([
            'message' => 'Lưu thành công!',
            'data' => $nutritionFact
        ]);
    }
    
}
