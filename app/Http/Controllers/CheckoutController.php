<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\CartDetail;
use App\Models\OrderDetail;
use App\Models\DiscountCode;
use App\Models\Discount;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\TheDaNang;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = [];
        $cartQuantity = 0;
        $specialOffer = 0;
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in .');
        }
        // Lấy danh sách mã giảm giá hợp lệ
        $discountCodes = DiscountCode::where('user_id', $user->id)
            ->where('quantity', '>', 0)
            ->whereHas('discount', function ($query) {
                $query->where('expiration_date', '>', now()); // Chỉ lấy các mã còn hiệu lực
            })
            ->with('discount') // Quan hệ để lấy thông tin discount
            ->get();
    
        // Lấy danh sách các tùy chọn vận chuyển
        $shippings = Shipping::where('status', true) // Chỉ lấy các vận chuyển còn hoạt động
            ->get();
    
        if ($user) {
            // Lấy giỏ hàng của người dùng hiện tại
            $cart = Cart::where('user_id', $user->id)->first();
    
            if ($cart) {
                // Lấy các sản phẩm trong giỏ hàng
                $cartItems = CartDetail::where('cart_id', $cart->id)->get();
                // Tính tổng tiền trước khi giảm giá
                $total = $cartItems->sum(function($item) {
                    return $item->price * $item->quantity;
                });
    
                // Lấy giá trị special_offer của người dùng
                $specialOffer = $user->special_offer ?? 0;
                // Tính số tiền giảm giá từ special_offer
                $specialOfferAmount = ($specialOffer / 100) * $total;
    
                // Tính tổng tiền sau giảm giá
                $totalAfterDiscount = $total - $specialOfferAmount;
            }
        }
    
        return view('checkout', [
            'user' => $user,
            'cartItems' => $cartItems,
            'cartQuantity' => $cartQuantity,
            'total' => $total ?? 0,
            'totalAfterDiscount' => $totalAfterDiscount ?? 0,
            'specialOffer' => $specialOffer,
            'specialOfferAmount' => $specialOfferAmount ?? 0,
            'discountCodes' => $discountCodes, // Truyền discountCodes vào view
            'shippings' => $shippings // Truyền danh sách vận chuyển vào view
        ]);
    }
    
    
    
    
    

    public function placeOrder(Request $request)
    {
        // Xác minh thông tin người dùng
        $user = Auth::user();
    
        // Kiểm tra thông tin cá nhân
        if (!$user->name || !$user->phone_number || !$user->email || !$user->address) {
            return back()->withErrors(['error' => 'Vui lòng hoàn thành thông tin cá nhân.'])->withInput();
        }
    
        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return back()->withErrors(['error' => 'Giỏ hàng của bạn đang trống.']);
        }
    
        // Lấy các chi tiết giỏ hàng
        $cartItems = CartDetail::where('cart_id', $cart->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['error' => 'Không có sản phẩm nào trong giỏ hàng để thực hiện đặt hàng.']);
        }
    
        // Kiểm tra số lượng tồn kho của từng sản phẩm trong giỏ hàng
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->quantity_in_stock) {
                return back()->withErrors([
                    'error' => 'Sản phẩm "' . $item->product->name . '" không đủ số lượng trong kho. Số lượng còn lại: ' . $item->product->quantity_in_stock
                ]);
            }
        }
    
        // Tính tổng tiền trước khi giảm giá
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
    
        // Tính giá trị giảm giá từ đặc quyền của người dùng
        $specialOffer = $user->special_offer ?? 0;
        $discountAmount = ($specialOffer / 100) * $total;
    
        // Lấy phí vận chuyển
        $shippingFee = 0;
        $shippingId = $request->input('shipping_id') ?: null;
        if ($shippingId) {
            $shipping = Shipping::find($shippingId);
            $shippingFee = $shipping->shipping_fee ?? 0;
        }
    
        // Tổng số tiền cần thanh toán
        $totalWithShipping = $total - $discountAmount + $shippingFee;
    
        // Kiểm tra phương thức thanh toán
        $paymentMethod = $request->input('method');
        if ($paymentMethod == 'Thẻ đa năng') {
            // Kiểm tra thẻ Đa Năng của người dùng
            $theDaNang = TheDaNang::where('user_id', $user->id)->first();
            if (!$theDaNang) {
                return back()->withErrors(['error' => 'Bạn chưa có thẻ Đa Năng.']);
            }
    
            // Kiểm tra số dư của thẻ Đa Năng
            if ($theDaNang->so_du < $totalWithShipping) {
                return back()->withErrors(['error' => 'Số dư trong thẻ Đa Năng không đủ để thực hiện thanh toán.']);
            }
    
            // Cập nhật số dư của thẻ Đa Năng
            $theDaNang->so_du -= $totalWithShipping;
            $theDaNang->save();
    
            // Ghi lại giao dịch thẻ Đa Năng
            Transaction::create([
                'the_da_nang_id' => $theDaNang->id,
                'loai_giao_dich' => 'thanh_toan',
                'so_tien' => $totalWithShipping,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Kiểm tra mã giảm giá
        $discountCodeId = $request->input('discount_code');
        $discountAmountFromCode = 0;
        if ($discountCodeId) {
            $discount = Discount::find($discountCodeId);
            if ($discount) {
                $discountAmountFromCode = $discount->discount_amount;
            }
        }
    
        $totalDiscountAmount = $discountAmount + $discountAmountFromCode;
        $totalAfterDiscount = $total - $totalDiscountAmount;
    
        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $user->id,
            'created_at' => now(),
            'notes' => $request->input('notes', 'Không có ghi chú'),
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'total_amount' => $totalAfterDiscount + $shippingFee,
            'discount_used' => $discountCodeId,
            'shipping_id' => $shippingId
        ]);
    
        // Tạo chi tiết đơn hàng và giảm số lượng tồn kho
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'amount' => $item->price * $item->quantity
            ]);
    
            // Giảm số lượng tồn kho của sản phẩm
           
        }
    
        // Xóa giỏ hàng sau khi đặt hàng thành công
        CartDetail::where('cart_id', $cart->id)->delete();
    
        return Redirect::route('orders.index')->with('success', 'Đặt hàng thành công!');
    }
    
    
    
    
    

    
    
    
}
