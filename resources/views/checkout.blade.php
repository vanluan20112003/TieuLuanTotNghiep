<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
<style>
    .original-price {
    color: #ff9800; /* Ví dụ: màu cam sáng */
    font-weight: bold;
    font-size: 1.2em; /* Tăng kích thước chữ */
}
.cart-items {
    position: fixed; /* Cố định ngay cả khi cuộn */
    top: 190px; /* Vị trí ban đầu */
    left: 100px; /* Vị trí ban đầu */
    width: 400px;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    padding: 20px;
    border-radius: 8px;
    cursor: grab; /* Con trỏ mặc định */
    transition: box-shadow 0.2s ease; /* Hiệu ứng hover */
}

.cart-items:active {
    cursor: grabbing; /* Con trỏ khi đang kéo */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); /* Hiệu ứng khi kéo */
}


/* CSS cho hộp thoại */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 300px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.pin-inputs {
    display: flex; /* Sắp xếp các ô nhập nằm ngang */
    justify-content: space-between; /* Khoảng cách giữa các ô */
    margin-bottom: 20px; /* Khoảng cách dưới các ô */
}

.pin-box {
    width: 40px; /* Chiều rộng của mỗi ô */
    height: 40px; /* Chiều cao của mỗi ô */
    text-align: center; /* Căn giữa văn bản */
    font-size: 24px; /* Kích thước chữ */
    border: 1px solid #ccc; /* Đường viền */
    border-radius: 5px; /* Bo tròn góc */
}

.pin-box:focus {
    outline: none; /* Bỏ outline khi ô được chọn */
    border-color: #007bff; /* Màu viền khi ô được chọn */
}
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

   .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .btn {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
   .empty-cart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin: 20px 0;
}

.empty-cart-container img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.empty-cart {
    font-size: 1.2em;
    color: #555;
}

</style>
</head>
<body>
   
<header class="header">

   <section class="flex">

      <a href="{{ url('/') }}" class="logo">yum-yum 😋</a>

      <nav class="navbar">
         <a href="{{ url('/') }}">Home</a>
         <a href="{{ url('/about') }}">About</a>
         <a href="{{ url('/menu') }}">Menu</a>
         <a href="{{ url('/orders') }}">Orders</a>
         <a href="{{ url('/contact') }}">Contact</a>
         
      </nav>

      <div class="icons">
         <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
         <a href="{{ url('/cart') }}" id="cart-link">
   
    <i class="fas fa-shopping-cart"></i><span>{{$cartQuantity}}</span>
</a>
         <div id="user-btn">
    @auth
        @if(auth()->user()->avatar)
            <img src="{{ asset(auth()->user()->avatar) }}" alt="User Avatar" class="user-avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
        @else
            <div class="fas fa-user" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #ddd;"></div>
        @endif
    @else
        <div class="fas fa-user" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background-color: #ddd;"></div>
    @endauth
</div>

</div>

         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
    <p class="name">
        @if(Auth::check())
            {{ Auth::user()->name }}
        @else
            Guest
        @endif
    </p>
    <div class="flex">
        @if(Auth::check())
            <a href="{{ url('/profile') }}" class="btn">Profile</a>
            <button class="delete-btn" onclick="confirmLogout()">Logout</button>
            
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ url('/login') }}" class="btn">Login</a>
            <a href="{{ url('/register') }}" class="btn">Register</a>
        @endif
    </div>
</div>


   </section>
<!-- Hộp thoại nhập mã PIN -->
<div id="pinModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Nhập mã PIN để xác nhận</h2>
        <div class="pin-inputs">
            <input type="password" maxlength="1" class="pin-box" />
            <input type="password" maxlength="1" class="pin-box" />
            <input type="password" maxlength="1" class="pin-box" />
            <input type="password" maxlength="1" class="pin-box" />
            <input type="password" maxlength="1" class="pin-box" />
            <input type="password" maxlength="1" class="pin-box" />
        </div>
        <button id="confirmPinBtn" class="btn">Xác nhận</button>
    </div>
</div>

</header>

<div class="heading">
   <h3>checkout</h3>
   <p><a href="{{ url('/') }}">home </a> <span> / checkout</span></p>
</div>
<section class="checkout">
    <h1 class="title">Order Summary</h1>
 <!-- Thông báo lỗi -->
 @if ($errors->any())
    <script>
        alert('Lỗi: {{ $errors->first() }}');
    </script>
@endif

<!-- Thông báo thành công -->
@if (session('success'))
    <script>
        alert('Thành công: {{ session("success") }}');
    </script>
@endif


    @if($cartItems->isEmpty())
        <div class="empty-cart-container">
            <img src="{{ asset('images/cart_empty.gif') }}" alt="Giỏ hàng trống">
            <p class="empty-cart">Bạn chưa có sản phẩm để thanh toán.</p>
        </div>
    @else
        <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="post">
            @csrf

            <div class="cart-items">
                <h3>Cart Items</h3>
                @foreach($cartItems as $item)
                    <p>
                        <span class="name">{{ $item->product->name }}</span>
                        <span class="quantity" style="color: yellow;">x{{ $item->quantity }}</span>
                        <span class="price">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫
                        </span>
                    </p>
                @endforeach
                <p class="discount-info">
                    <span class="name">Special Offer for {{ $user->role }}:</span>
                    <span class="price">{{ $specialOffer }}%</span>
                </p>
                @php
$shippingFee = isset($shippingFee) ? $shippingFee : 0; // Đặt giá trị mặc định
@endphp

<p class="shipping">
    <span class="name">Phí vận chuyển:</span>
    <span class="price" id="shipping-fee">{{ $shippingFee }} ₫</span>
</p>


<p class="original-price">
    <span class="name">Giá trước khi giảm:</span>
    <span id="original-price">{{ $total }} ₫</span>
</p>

                <p class="discount-amount">
    <span class="name">Tổng Giảm Giá:</span>
    <span id="discount-amount" class="price">{{ number_format($specialOfferAmount, 0, ',', '.') }} ₫</span>
</p>
                <p class="grand-total">
                    <span class="name">Total After Discount:</span>
                    <span id="grand-total-price" class="price">
                        {{ number_format($totalAfterDiscount, 0, ',', '.') }} ₫
                    </span>
                </p>
                <a href="{{ route('cart.show') }}" class="btn">View Cart</a>
            </div>

            <div class="user-info">
                <h3>Your Info</h3>
                <p><i class="fas fa-user"></i> <span>{{ $user->name }}</span></p>
                <p><i class="fas fa-phone"></i> <span>{{ $user->phone_number }}</span></p>
                <p><i class="fas fa-envelope"></i> <span>{{ $user->email }}</span></p>
                <a href="{{ route('update.profile') }}" class="btn">Update Info</a>

                <h3>Select Shipping Method</h3>
<select id="shipping-select" name="shipping_id" class="box" required>
    <option value="" data-shipping-fee="0">Xuống căn tin nhận trực tiếp</option>
    @foreach($shippings as $shipping)
        <option value="{{ $shipping->id }}" data-shipping-fee="{{ $shipping->shipping_fee }}">
            {{ $shipping->room_name }} - Tầng: {{ $shipping->floor }} - Tòa: {{ $shipping->building }} - Phí Ship: {{ number_format($shipping->shipping_fee, 0, ',', '.') }} ₫
        </option>
    @endforeach
</select>


                <a href="{{ route('update.address.form') }}" class="btn">Update Address</a>

                <h3>Select a Payment Method</h3>
                <select name="method" class="box" required>
                    <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                    <option value="Thẻ đa năng">Thanh toán bằng thẻ đa năng</option>
                    
                    
                </select>

                <h3>Select Discount Code</h3>
                <select name="discount_code" class="box" id="discount-code-select">
    <option value="">Select Discount Code</option>
    @foreach($discountCodes as $code)
        <option value="{{ $code->discount_id }}"
                data-discount-amount="{{ $code->discount->discount_amount }}"
                data-use-condition="{{ $code->discount->condition_use }}"
                {{ $total < $code->discount->condition_use ? 'disabled' : '' }}>
            {{ $code->discount->name }} 
            (Yêu cầu hoá đơn trên {{ number_format($code->discount->condition_use, 0, ',', '.') }}₫)
        </option>
    @endforeach
</select>




                <div class="note-section">
                    <h3>Additional Notes</h3>
                    <textarea name="notes" rows="4" placeholder="Enter any additional notes here..."></textarea>
                </div>
            </div>
            @if(empty($user->address))
                <div id="address-warning" class="alert alert-danger">
                    Vui lòng cập nhật thêm thông tin địa chỉ.
                </div>
            @else
                <input type="button" id="placeOrderBtn" value="Place Order" class="btn order-btn" " />
            @endif
        </form>
    @endif
</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>




</script>


<footer class="footer">

   <section class="box-container">

      <div class="box">
         <img src="images/email-icon.png" alt="">
         <h3>our email</h3>
         <a href="mailto:shaikhanas@gmail.com">shaikhanas@gmail.com</a>
         <a href="mailto:anasbhai@gmail.com">anasbhai@gmail.com</a>
      </div>

      <div class="box">
         <img src="images/clock-icon.png" alt="">
         <h3>opening hours</h3>
         <p>00:07am to 00:10pm </p>
      </div>

      <div class="box">
         <img src="images/map-icon.png" alt="">
         <h3>our address</h3>
         <a href="https://www.google.com/maps">mumbai, india - 400104</a>
      </div>

      <div class="box">
         <img src="images/phone-icon.png" alt="">
         <h3>our number</h3>
         <a href="tel:1234567890">+123-456-7890</a>
         <a href="tel:1112223333">+111-222-3333</a>
      </div>

   </section>

   <div class="credit">&copy; copyright @ 2022 by <span>mr. web designer</span> | all rights reserved!</div>

</footer>

<div class="loader">
   <img src="images/Animation - 1735092558904.gif" alt="">
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>
<script>
$(document).ready(function() {
    document.getElementById('placeOrderBtn').addEventListener('click', function (e) {
    e.preventDefault(); // Ngăn chặn submit form tự động
  
    const paymentMethod = document.querySelector('select[name="method"]').value;

    if (paymentMethod === 'Thanh toán khi nhận hàng') {
        confirmOrder();
    } else if (paymentMethod === 'Thẻ đa năng') {
   
        // Kiểm tra xem người dùng có thẻ đa năng không
        fetch("{{ route('check.card') }}", { // Sử dụng route() để tạo URL
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ user_id: "{{ Auth::user()->id }}" })
        })
        .then(response => response.json())
        .then(data => {
           
            if (data.has_card) {
                if (data.balance >= "{{ $totalAfterDiscount }}") {
                    // Nếu số dư đủ, hiển thị hộp thoại nhập mã PIN
                    document.getElementById('pinModal').style.display = 'flex';

                    document.getElementById('confirmPinBtn').addEventListener('click', function () {
                        let pin = '';
                        document.querySelectorAll('.pin-box').forEach(input => {
                            pin += input.value;
                        });
                        
                        // Kiểm tra mã PIN
                        fetch('{{ route("check.pin") }}', { // Thay thế check-pin bằng route()
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ user_id: "{{ Auth::user()->id }}", pin: pin })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.valid_pin) {
                                document.getElementById('checkout-form').submit();
                            } else {
                                alert('Mã PIN không hợp lệ. Vui lòng thử lại.');
                                return;
                            }
                        })
                        .catch(error => {
                            alert('Lỗi kiểm tra mã PIN: ' + error.message);
                            return;
                        });
                    });
                } else {
                    alert('Số dư không đủ để thanh toán.');
                    return;
                }
            } else {
                alert('Bạn không có thẻ đa năng.');
                return;
            }
        })
        .catch(error => {
            console.error('Lỗi kiểm tra thẻ:', error);
            alert('Lỗi kiểm tra thẻ: ' + error.message);
            return;
        });
    }
});

    // Đóng hộp thoại khi nhấn dấu "X"
    document.querySelector('.close').addEventListener('click', function () {
        document.getElementById('pinModal').style.display = 'none';
    });
    let total = parseFloat("{{ $total }}"); // Giá trị tổng ban đầu
    let specialOffer = parseFloat("{{ $specialOffer }}"); // Giá trị special_offer
    let shippingFee = parseFloat("{{ $shippingFee ?? 0 }}"); // Giá trị phí vận chuyển

    // Tính toán discount từ special_offer
    let specialDiscountAmount = (specialOffer / 100) * total;

    // Hiển thị discount amount ban đầu
    $('#discount-amount').text(specialDiscountAmount.toLocaleString() + ' ₫');
    $('#grand-total-price').text(total.toLocaleString() + ' ₫'); // Hiển thị tổng ban đầu
    $('#shipping-fee').text(shippingFee.toLocaleString() + ' ₫'); // Hiển thị phí vận chuyển ban đầu

    function updateGrandTotal() {
        // Tính tổng tiền mới bao gồm phí vận chuyển và các khoản giảm giá
        let totalAfterDiscount = total - specialDiscountAmount; // Tổng sau khi giảm
        let totalWithShipping = totalAfterDiscount + shippingFee; // Cộng phí vận chuyển

        // Cập nhật hiển thị tổng tiền mới
        $('#grand-total-price').text(totalWithShipping.toLocaleString() + ' ₫');
    }

    // Kiểm tra và disable các mã giảm giá không đủ điều kiện
    $('#discount-code-select option').each(function() {
        let useCondition = parseFloat($(this).data('condition_use')) || 0;

        if (total < useCondition) {
            $(this).attr('disabled', true); // Disable nếu tổng < điều kiện
        }
    });

    $('#discount-code-select').change(function() {
        let selectedOption = $(this).find(':selected');

        // Kiểm tra nếu mã giảm giá đã bị disable
        if (selectedOption.prop('disabled')) {
            alert('Hóa đơn của bạn không đủ điều kiện để áp dụng mã giảm giá này.');
            $(this).val(''); // Xóa lựa chọn
            return; // Không tiếp tục xử lý
        }

        // Lấy giá trị của phiếu giảm giá được chọn
        let discountAmount = selectedOption.data('discount-amount') || 0;

        // Cập nhật tổng tiền sau giảm giá
        specialDiscountAmount = (specialOffer / 100) * total + discountAmount; // Cập nhật tổng giảm giá

        // Cập nhật hiển thị
        $('#discount-amount').text(specialDiscountAmount.toLocaleString() + ' ₫'); // Cập nhật tổng giảm giá
        
        // Gọi hàm cập nhật tổng tiền
        updateGrandTotal();
    });

    // Cập nhật tổng khi chọn phương thức giao hàng
    $('#shipping-select').change(function() {
        // Lấy phí vận chuyển
        shippingFee = $(this).val() ? parseFloat($(this).find(':selected').data('shipping-fee')) : 0;

        // Cập nhật hiển thị phí vận chuyển
        $('#shipping-fee').text(shippingFee.toLocaleString() + ' ₫');
        
        // Gọi hàm cập nhật tổng tiền
        updateGrandTotal();
    });
    document.querySelectorAll('.pin-box').forEach((input, index, inputs) => {
    input.addEventListener('input', function () {
        // Nếu có giá trị nhập vào, di chuyển tới ô tiếp theo
        if (input.value.length >= input.maxLength) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        }
    });

    // Sự kiện nhấn phím Enter
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Ngăn chặn hành động mặc định
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            } else {
                // Nếu là ô cuối cùng, có thể thực hiện hành động xác nhận
                document.getElementById('confirmPinBtn').click();
            }
        }
    });
});
const pinModal = document.getElementById('pinModal');

// Sự kiện khi nhấn bên ngoài modal
window.addEventListener('click', function (event) {
    if (event.target === pinModal) {
        pinModal.style.display = 'none'; // Đóng modal
    }
});

});



function confirmOrder() {
    if (confirm('Are you sure you want to place this order?')) {
        document.getElementById('checkout-form').submit();
    }
}
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
// Thêm tính năng kéo thả cho .cart-items
const cartElement = document.querySelector('.cart-items');
let isCartDragging = false;
let cartOffsetX, cartOffsetY;

// Khi bắt đầu giữ chuột
cartElement.addEventListener('mousedown', function (e) {
    isCartDragging = true;
    cartOffsetX = e.clientX - cartElement.getBoundingClientRect().left;
    cartOffsetY = e.clientY - cartElement.getBoundingClientRect().top;

    // Thay đổi con trỏ chuột thành "grabbing"
    cartElement.style.cursor = 'grabbing';
});

// Khi di chuyển chuột
document.addEventListener('mousemove', function (e) {
    if (isCartDragging) {
        let left = e.clientX - cartOffsetX;
        let top = e.clientY - cartOffsetY;

        // Cập nhật vị trí của phần tử
        cartElement.style.left = `${left}px`;
        cartElement.style.top = `${top}px`;
        cartElement.style.position = 'fixed'; // Đảm bảo cố định khi di chuyển
    }
});

// Khi thả chuột
document.addEventListener('mouseup', function () {
    if (isCartDragging) {
        isCartDragging = false;

        // Đặt lại con trỏ chuột
        cartElement.style.cursor = 'grab';
    }
});

// Đặt con trỏ chuột mặc định là "grab"
cartElement.style.cursor = 'grab';
</script>
</body>
</html>