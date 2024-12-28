<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;

class CartController extends Controller
{
    public function showCart()
    {
        $userId = Auth::id();
        $cartQuantity = 0; // Đặt số lượng giỏ hàng mặc định là 0
    
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if ($userId) {
            // Lấy giỏ hàng của người dùng
            $cart = Cart::where('user_id', $userId)->first();
            
            if (!$cart) {
                $cartDetails = [];
                $grandTotal = 0; // Đặt tổng giỏ hàng về 0 nếu không có giỏ hàng
            } else {
                // Lấy chi tiết giỏ hàng
                $cartDetails = CartDetail::where('cart_id', $cart->id)->with('product')->get();
                
                // Kiểm tra sự tồn tại của sản phẩm và cập nhật số lượng nếu cần
                foreach ($cartDetails as $key => $cartDetail) {
                    if (!$cartDetail->product) {
                        // Nếu sản phẩm không tồn tại, xóa cart_detail
                        $cartDetail->delete();
                        unset($cartDetails[$key]); // Xóa khỏi mảng $cartDetails
                    } else {
                        // Nếu số lượng trong cart_detail vượt quá số lượng tồn kho, cập nhật lại
                        if ($cartDetail->quantity > $cartDetail->product->quantity_in_stock) {
                            $cartDetail->quantity = $cartDetail->product->quantity_in_stock;
                            $cartDetail->total_amount = $cartDetail->quantity * $cartDetail->price; // Cập nhật lại tổng tiền
                            $cartDetail->save(); // Lưu thay đổi
                        }
                    }
                }
    
                // Tính tổng số lượng sản phẩm trong giỏ hàng
                $cartQuantity = CartDetail::where('cart_id', $cart->id)->sum('quantity');
    
                // Cập nhật tổng giá trị giỏ hàng sau khi thực hiện các điều chỉnh
                $grandTotal = CartDetail::where('cart_id', $cart->id)->sum('total_amount');
                $cart->total = $grandTotal;
                $cart->save();
            }
        } else {
            // Nếu chưa đăng nhập, đặt cartDetails và grandTotal về 0
            $cartDetails = [];
            $grandTotal = 0; // Đặt tổng giỏ hàng về 0
        }
    
        return view('cart', compact('cartDetails', 'grandTotal', 'cartQuantity')); // Đảm bảo truyền biến $grandTotal tới view
    }
    
    
    
    public function addToCart(Request $request)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }
    
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $quantity = $request->input('qty');
    
        // Kiểm tra nếu quantity là null
        if (is_null($quantity)) {
            return redirect()->back()->with('error', 'Bạn chưa lựa chọn số lượng sản phẩm.');
        }
    
        // Tìm sản phẩm
        $product = Product::findOrFail($productId);
    
        // Tìm hoặc tạo giỏ hàng mới cho người dùng hiện tại
        $cart = Cart::firstOrCreate([
            'user_id' => $userId
        ]);
    
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartDetail = CartDetail::where('cart_id', $cart->id)
                                ->where('product_id', $productId)
                                ->first();
    
        $currentQuantityInCart = $cartDetail ? $cartDetail->quantity : 0;
    
        // Kiểm tra nếu tổng số lượng vượt quá số lượng còn lại trong kho
        if ($currentQuantityInCart + $quantity > $product->quantity_in_stock) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm vượt quá số lượng còn lại trong kho.');
        }
    
        if ($cartDetail) {
            // Nếu có, cập nhật số lượng
            $cartDetail->quantity += $quantity;
            $cartDetail->total_amount = $cartDetail->quantity * $product->price;
            $cartDetail->save();
        } else {
            // Nếu không có, tạo mới
            CartDetail::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
                'total_amount' => $quantity * $product->price,
            ]);
        }
    
        // Cập nhật tổng giá trị của giỏ hàng
        $cart->total = CartDetail::where('cart_id', $cart->id)->sum('total_amount');
        $cart->save();
    
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    
    public function update(Request $request)
    {
        $detail = CartDetail::findOrFail($request->input('detail_id'));
        $qty = $request->input('qty');
    
        if ($qty == 0) {
            $detail->delete();
        } else {
            $detail->quantity = $qty;
            $detail->total_amount = $qty * $detail->price;
            $detail->save();
        }
    
        $cart = Cart::findOrFail($detail->cart_id);
        $cart->calculateTotal(); // Sử dụng phương thức calculateTotal() đã định nghĩa
    
        return response()->json([
            'success' => true,
            'newTotal' => $detail->total_amount,
            'grandTotal' => $cart->total, // Đảm bảo sử dụng thuộc tính total đã cập nhật
        ]);
    }
    

    public function delete(Request $request)
    {
        $detail = CartDetail::findOrFail($request->input('detail_id'));
        $cart = Cart::findOrFail($detail->cart_id);
    
        $detail->delete();
        $cart->calculateTotal(); // Sử dụng phương thức calculateTotal() đã định nghĩa
    
        return response()->json([
            'success' => true,
            'grandTotal' => $cart->total, // Đảm bảo sử dụng thuộc tính total đã cập nhật
        ]);
    }
    
    public function removeItem(Request $request)
    {
        // Kiểm tra xem người dùng đã xác thực chưa
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Người dùng chưa đăng nhập.'], 401);
        }
    
        // Lấy ID sản phẩm từ yêu cầu
        $productId = $request->input('detail_id');
        
        // Lấy ID người dùng hiện tại
        $userId = Auth::id();
        
        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $userId)->first();
    
        // Kiểm tra xem giỏ hàng có tồn tại không
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng không tồn tại.'], 404);
        }
    
        // Tìm chi tiết giỏ hàng theo ID sản phẩm và ID giỏ hàng
        $detail = CartDetail::where('cart_id', $cart->id)
                             ->where('product_id', $productId)
                             ->first();
    
        // Kiểm tra xem chi tiết có tồn tại không
        if (!$detail) {
            return response()->json(['success' => false, 'message' => 'Chi tiết giỏ hàng không tồn tại.'], 404);
        }
    
        // Xóa chi tiết giỏ hàng
        $detail->delete();
    
        // Cập nhật tổng số tiền trong giỏ hàng
        $cart->calculateTotal();
    
        // Kiểm tra giỏ hàng có rỗng không
        $isEmpty = $cart->cartDetails()->count() === 0;
    
        return response()->json([
            'success' => true,
            'grandTotal' => $cart->total, // Sử dụng thuộc tính total đã cập nhật
            'isEmpty' => $isEmpty, // Trả về trạng thái giỏ hàng
        ]);
    }
    
    public function deleteAll(Request $request)
    {
        $cart = Cart::where('user_id', auth::id())->firstOrFail();
        $cart->cartDetails()->delete(); // Sử dụng phương thức cartDetails() đã định nghĩa
        $cart->total = 0; // Đặt tổng giỏ hàng về 0
        $cart->save();
    
        return response()->json(['success' => true]);
    }
    public function getCartInfo()
{
    // Lấy user_id từ phiên làm việc
    $userId = auth::user()->id; 

    // Lấy các sản phẩm trong giỏ hàng của người dùng
    $cartItems = CartDetail::with('product')
        ->whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->get();

    // Tính tổng số tiền
    $totalAmount = $cartItems->sum('total_amount');

    return response()->json([
        'cartItems' => $cartItems,
        'totalAmount' => $totalAmount,
    ]);
}

    
}
