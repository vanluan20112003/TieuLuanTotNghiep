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
   <link rel="stylesheet" href="css/footer.css">
   


<style>
    .original-price {
    color: #ff9800; /* Ví dụ: màu cam sáng */
    font-weight: bold;
    font-size: 1.2em; /* Tăng kích thước chữ */
}
.cart-items {
    position: fixed; /* Cố định ngay cả khi cuộn */
    top: 400px; /* Vị trí ban đầu */
    left: 950px; /* Vị trí ban đầu */
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
:root {
    --primary: #2563eb;
    --success: #16a34a;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-700: #334155;
    --gray-900: #0f172a;
}



.checkout-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.page-title {
    font-size: 2.25rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: var(--gray-900);
}

.checkout-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 2rem;
}

.card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    padding: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: var(--gray-900);
}

/* Cart Items Styling */
.cart-items {
    margin-bottom: 2rem;
}

.cart-item {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--gray-200);
}

.item-image {
    width: 80px;
    height: 80px;
    background: var(--gray-100);
    border-radius: 0.5rem;
}

.item-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.item-name {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.item-quantity {
    color: var(--gray-700);
    font-size: 0.875rem;
}

.item-price {
    font-weight: 600;
    color: var(--gray-900);
    align-self: center;
}

/* Price Summary */
.price-summary {
    background: var(--gray-50);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-top: 2rem;
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    color: var(--gray-700);
}

.price-row:not(:last-child) {
    border-bottom: 1px solid var(--gray-200);
}

.grand-total {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 2px solid var(--gray-200);
}

/* Form Controls */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--gray-700);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--gray-200);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* User Info Card */
.user-info-card {
    background: var(--gray-50);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.user-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-700);
}

.info-item i {
    color: var(--primary);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
}

.btn-success {
    background: var(--success);
    color: white;
    width: 100%;
    padding: 1rem;
    font-size: 1.125rem;
    margin-top: 1rem;
}

.btn-success:hover {
    background: #15803d;
}

.btn-outline {
    border: 1px solid var(--gray-200);
    color: var(--gray-700);
}

.btn-outline:hover {
    background: var(--gray-50);
}

/* Alert */
.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
    
    .user-info-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .cart-item {
        grid-template-columns: 1fr auto;
    }
    
    .item-image {
        display: none;
    }
    
    .page-title {
        font-size: 1.875rem;
    }
}
.item-image {
    width: 100px; /* Chiều rộng ô ảnh */
    height: 100px; /* Chiều cao ô ảnh */
    overflow: hidden; /* Ẩn phần ảnh vượt ra ngoài */
    border: 1px solid #ddd; /* Viền ô ảnh */
    border-radius: 8px; /* Bo góc ô ảnh */
    display: flex; /* Đảm bảo căn giữa nội dung bên trong */
    align-items: center; /* Căn giữa dọc */
    justify-content: center; /* Căn giữa ngang */
    background-color: #f9f9f9; /* Màu nền nhạt để nổi bật ảnh */
}

.item-image img {
    width: 100%; /* Chiều rộng ảnh đầy đủ ô chứa */
    height: 100%; /* Chiều cao ảnh đầy đủ ô chứa */
    object-fit: cover; /* Đảm bảo ảnh vừa khít ô mà không bị méo */
    border-radius: 8px; /* Bo góc ảnh khớp với ô chứa */
}
.cart-items {
    position: fixed; /* Gắn cố định ở một vị trí */
    bottom: 10px; /* Cách đáy màn hình 10px */
    right: 10px; /* Cách mép phải màn hình 10px */
    width: 300px; /* Độ rộng của khung hiển thị */
    max-height: calc(3 * 100px + 20px); /* Tối đa hiển thị 3 sản phẩm với mỗi sản phẩm cao 100px + khoảng cách giữa chúng */
    padding: 10px;
    background-color: #fff; /* Màu nền khung */
    border: 1px solid #ddd; /* Viền khung */
    border-radius: 8px; /* Bo góc khung */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng khung */
    overflow-y: auto; /* Kích hoạt cuộn dọc */
    z-index: 1000; /* Hiển thị trên các phần tử khác */
}

/* Các sản phẩm trong giỏ hàng */
.cart-item {
    display: flex; /* Dùng flex để căn chỉnh */
    align-items: center; /* Căn giữa dọc */
    justify-content: space-between; /* Khoảng cách giữa các phần tử */
    margin-bottom: 10px; /* Khoảng cách giữa các sản phẩm */
    padding: 10px;
    background-color: #f9f9f9; /* Màu nền mỗi sản phẩm */
    border-radius: 8px; /* Bo góc mỗi sản phẩm */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Đổ bóng mỗi sản phẩm */
}

.cart-item:last-child {
    margin-bottom: 0; /* Bỏ khoảng cách dưới sản phẩm cuối */
}

/* Hình ảnh sản phẩm */
.item-image {
    width: 50px; /* Kích thước ô chứa ảnh */
    height: 50px;
   
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

<div class="checkout-container">
    <h1 class="page-title">Checkout</h1>
    
    <div class="checkout-grid">
        <!-- Form Section -->
        <div class="card">
            <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="post">
                @csrf
                
                <div class="form-group">
                    <h2 class="section-title">Thông tin người đặt</h2>
                    <div class="user-info-card">
                        <div class="user-info-grid">
                            <div class="info-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $user->name }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $user->phone_number }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $user->email }}</span>
                            </div>
                            <a href="{{ route('update.profile') }}" class="btn btn-outline">
                                <i class="fas fa-edit"></i>
                                Cập nhật thông tin
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Chọn phương thức vận chuyển</label>
                    <select id="shipping-select" name="shipping_id" class="form-control" required>
                        <option value="" data-shipping-fee="0">Xuống căn tin nhận trực tiếp</option>
                        @foreach($shippings as $shipping)
                        <option value="{{ $shipping->id }}" data-shipping-fee="{{ $shipping->shipping_fee }}">
                            {{ $shipping->room_name }} - Tầng {{ $shipping->floor }} - Tòa {{ $shipping->building }}
                            ({{ number_format($shipping->shipping_fee, 0, ',', '.') }} ₫)
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select name="method" class="form-control" required>
                        <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                        <option value="Thẻ đa năng">Thanh toán bằng thẻ đa năng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Mã giảm giá</label>
                    <select name="discount_code" class="form-control" id="discount-code-select">
                        <option value="">Chọn mã giảm giá</option>
                        @foreach($discountCodes as $code)
                        <option value="{{ $code->discount_id }}"
                                data-discount-amount="{{ $code->discount->discount_amount }}"
                                data-use-condition="{{ $code->discount->condition_use }}"
                                {{ $total < $code->discount->condition_use ? 'disabled' : '' }}>
                            {{ $code->discount->name }}
                            (Đơn tối thiểu {{ number_format($code->discount->condition_use, 0, ',', '.') }}₫)
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Ghi chú đơn hàng</label>
                    <textarea name="notes" class="form-control" rows="4" 
                              placeholder="Nhập ghi chú đặc biệt về đơn hàng của bạn..."></textarea>
                </div>

                @if(empty($user->address))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    Vui lòng cập nhật thông tin địa chỉ trước khi đặt hàng.
                </div>
                @else
                <button type="button" id="placeOrderBtn" class="btn btn-success">
                    <i class="fas fa-check-circle"></i>
                    Xác nhận đặt hàng
                </button>
                @endif
            </form>
        </div>

        <!-- Order Summary -->
        <div class="card">
            <h2 class="section-title">Đơn hàng của bạn</h2>
            
            <div class="cart-items">
                @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="item-image">   <img src="{{ asset('images/' . $item->product->image) }}" alt="{{ $item->product->name }}"></div>
                    <div class="item-details">
                        <span class="item-name">{{ $item->product->name }}</span>
                        <span class="item-quantity">Số lượng: {{ $item->quantity }}</span>
                    </div>
                    <span class="item-price">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</span>
                </div>
                @endforeach
            </div>

            <div class="price-summary">
    <div class="price-row">
        <span>Tạm tính:</span>
        <span id="subtotal">{{ number_format($total, 0, ',', '.') }} ₫</span>
    </div>
    <div class="price-row">
        <span>Giảm giá :</span>
        <span id="discount-amount">-{{ number_format($specialOfferAmount, 0, ',', '.') }} ₫</span>
    </div>
    @php
$shippingFee = isset($shippingFee) ? $shippingFee : 0; // Đặt giá trị mặc định
@endphp
    <div class="price-row">
        <span>Phí vận chuyển:</span>
        <span id="shipping-fee">{{ number_format($shippingFee, 0, ',', '.') }} ₫</span>
    </div>
    <div class="grand-total">
        <span>Tổng thanh toán:</span>
        <span id="final-total">{{ number_format($totalAfterDiscount, 0, ',', '.') }} ₫</span>
    </div>
</div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>




</script>


<footer class="footer">
    <div class="footer-content">
        <!-- Thông tin liên hệ -->
        <div class="footer-section">
            <h3>Liên Hệ</h3>
            <p><i class="fas fa-hospital"></i> Căn tin Luan Hospital</p>
            <p><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận X, TP.HCM</p>
            <p><i class="fas fa-phone"></i> Hotline: 03522312710352231271</p>
            <p><i class="fas fa-envelope"></i> Email: levanluan20112003@gmail.comcom</p>
            <p><i class="fas fa-clock"></i> Giờ mở cửa: 6:00 - 20:00</p>
        </div>

        <!-- Dịch vụ -->
        <div class="footer-section">
            <h3>Dịch Vụ</h3>
            <ul>
                <li><a href="/menu">Thực đơn hàng ngày</a></li>
                <li><a href="/menu">Đặt món trực tuyến</a></li>
                
            </ul>
        </div>

        <!-- Hỗ trợ -->
        <div class="footer-section">
            <h3>Hỗ Trợ</h3>
            <ul>
                <li><a href="#">Hướng dẫn đặt món</a></li>
                <li><a href="#">Chính sách & Quy định</a></li>
                <li><a href="#">Phản hồi & Góp ý</a></li>
                <li><a href="#">Câu hỏi thường gặp</a></li>
                <li><a href="#">Bảo mật thông tin</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div class="footer-section">
            <h3>Đăng Ký Nhận Tin</h3>
            <p>Nhận thông tin về thực đơn và khuyến mãi mới nhất</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Email của bạn" required>
                <button type="submit">Đăng ký</button>
            </form>
            <div class="social-links">
                <a href="https://www.facebook.com/vanluan.le.52056"><i class="fab fa-facebook"></i></a>
                <a href="https://www.youtube.com/@vanluanle5796"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

   

    <!-- Copyright -->
    <div class="footer-bottom">
        <p>© 2024 Căn tin Luan HospitalHospital. Tất cả quyền được bảo lưu.</p>
    </div>
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
    // Lấy tổng tiền sau giảm giá từ frontend
    const totalAfterDiscount = parseFloat("{{ $totalAfterDiscount }}");

    // Gọi API kiểm tra thẻ đa năng
    fetch("{{ route('check.card') }}", { // Sử dụng route() để tạo URL
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ 
            user_id: "{{ Auth::user()->id }}",
            so_tien: totalAfterDiscount // Truyền tổng tiền cần thanh toán
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('API Response:', data); // Debug giá trị trả về từ API

        if (data.has_card) {
            const balance = parseFloat(data.balance); // Chuyển số dư về dạng số
            console.log('Balance:', balance); // Debug số dư
            console.log('Total after discount:', totalAfterDiscount); // Debug tổng tiền

            if (balance >= totalAfterDiscount) {
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
                        body: JSON.stringify({ 
                            user_id: "{{ Auth::user()->id }}", 
                            pin: pin 
                        })
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
    let total = parseFloat("{{ $total }}"); // Tổng tiền ban đầu
let specialOffer = parseFloat("{{ $specialOffer }}"); // Giảm giá %
let shippingFee = parseFloat("{{ $shippingFee ?? 0 }}"); // Phí vận chuyển mặc định
let specialDiscountAmount = (specialOffer / 100) * total; // Giảm giá từ vai trò user

// Hàm định dạng tiền tệ
function formatCurrency(amount) {
    return amount.toLocaleString('vi-VN') + ' ₫';
}

// Hàm cập nhật tổng thanh toán
function updatePriceSummary() {
    // Tính toán tổng tiền sau giảm giá và phí vận chuyển
    let totalAfterDiscount = total - specialDiscountAmount;
    let finalTotal = totalAfterDiscount + shippingFee;

    // Cập nhật hiển thị
    $('#subtotal').text(formatCurrency(total));
    $('#discount-amount').text('-' + formatCurrency(specialDiscountAmount));
    $('#shipping-fee').text(formatCurrency(shippingFee));
    $('#final-total').text(formatCurrency(finalTotal));
}

// Xử lý khi thay đổi mã giảm giá
$('#discount-code-select').change(function() {
    let selected = $(this).find(':selected');
    if (!selected.prop('disabled')) {
        let additionalDiscount = parseFloat(selected.data('discount-amount')) || 0;
        specialDiscountAmount = (specialOffer / 100) * total + additionalDiscount;
        updatePriceSummary();
    }
});

// Xử lý khi thay đổi phương thức vận chuyển
$('#shipping-select').change(function() {
    let selected = $(this).find(':selected');
    shippingFee = selected.val() ? parseFloat(selected.data('shipping-fee')) : 0;
    updatePriceSummary();
});

// Cập nhật tổng thanh toán lần đầu khi tải trang
updatePriceSummary();
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