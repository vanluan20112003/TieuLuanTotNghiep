<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>my cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/footer.css">

   <style>
      /* CSS cho nút Xóa tất cả */
.more-btn {
    margin-top: 20px; /* Khoảng cách trên */
    text-align: center; /* Căn giữa */
}
.empty-cart {
    text-align: center; /* Căn giữa hình ảnh */
    margin-top: 20px; /* Khoảng cách trên */
}

.empty-cart img {
    max-width: 100%; /* Đảm bảo hình ảnh không vượt quá chiều rộng của container */
    height: auto; /* Đảm bảo tỉ lệ khung hình không bị thay đổi */
}

.delete-all-btn {
    background-color: #ff0000; /* Màu nền đỏ */
    color: #fff; /* Màu chữ trắng */
    padding: 10px 20px; /* Padding bên trong */
    font-size: 16px; /* Kích thước chữ */
    text-decoration: none; /* Bỏ gạch chân */
    border-radius: 5px; /* Bo tròn các góc */
    display: inline-block; /* Định dạng kiểu inline-block */
    cursor: pointer; /* Con trỏ tay khi hover */
}

.delete-all-btn:hover {
    background-color: #cc0000; /* Màu nền đỏ đậm khi hover */
}

/* CSS cho nút Xóa trong giỏ hàng */
.delete-item-btn {
    background-color: #ff0000; /* Màu nền đỏ */
    color: #fff; /* Màu chữ trắng */
    border: none; /* Không có viền */
    padding: 5px; /* Padding bên trong */
    font-size: 16px; /* Kích thước chữ */
    cursor: pointer; /* Con trỏ tay khi hover */
    border-radius: 3px; /* Bo tròn các góc */
}

.delete-item-btn:hover {
    background-color: #cc0000; /* Màu nền đỏ đậm khi hover */
}
.header {
    background-color: #fff; /* Màu nền sáng */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
    padding: 10px 20px; /* Khoảng cách bên trong */
    background-color: #e0f7fa; /* Màu xanh nhạt dễ chịu */
}

.header .flex {
    display: flex;
    align-items: center; /* Canh giữa theo chiều dọc */
    justify-content: space-between; /* Tách đều giữa các phần tử */
}
.products {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

/* Title styling */
.title {
    font-size: 2rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 2rem;
    font-weight: 600;
}

/* Cart total section */
.cart-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.cart-total p {
    font-size: 1.3rem;
    color: #2c3e50;
}

#grand-total {
    color: #e74c3c;
    font-weight: 600;
}

/* Checkout button */
.btn {
    padding: 0.8rem 1.5rem;
    background: #2ecc71;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    background: #27ae60;
    transform: translateY(-2px);
}

/* Container for cart items */
.box-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

/* Individual cart item */
.box {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    position: relative;
    transition: all 0.3s ease;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

/* Quick view icon */
.box .fa-eye {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2c3e50;
    text-decoration: none;
    transition: all 0.3s ease;
}

.box .fa-eye:hover {
    background: white;
    transform: scale(1.1);
}

/* Delete button */
.delete-item-btn {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(231, 76, 60, 0.9);
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 1;
}

.delete-item-btn:hover {
    background: #c0392b;
    transform: scale(1.1);
}

/* Product image */
.box img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 1rem;
    transition: transform 0.3s ease;
}

.box img:hover {
    transform: scale(1.05);
}

/* Product name */
.name {
    font-size: 1.2rem;
    color: #2c3e50;
    margin: 1rem 0;
    font-weight: 500;
}

/* Flex container for price and quantity */
.flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 1rem 0;
    gap: 1rem;
}

/* Price styling */
.price {
    color: #e74c3c;
    font-size: 1.3rem;
    font-weight: 600;
}

/* Quantity input */
.qty {
    width: 70px;
    text-align: center;
    padding: 0.5rem;
    border: 1px solid #dfe4ea;
    border-radius: 6px;
    font-size: 1rem;
}

/* Edit button */
.edit-item-btn {
    background: #f1f2f6;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 6px;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
}

.edit-item-btn:hover {
    background: #dfe4ea;
}

/* Subtotal section */
.sub-total {
    font-size: 1.1rem;
    color: #2c3e50;
    padding-top: 1rem;
    border-top: 1px solid #f1f2f6;
    margin-top: 1rem;
}

.sub-total-amount {
    color: #e74c3c;
    font-weight: 600;
}

/* Empty cart styling */
.empty-cart {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
}

.empty-cart img {
    max-width: 250px;
    margin-bottom: 2rem;
}

.empty-cart h2 {
    color: #2c3e50;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

/* Delete all button container */
.more-btn {
    text-align: center;
    margin-top: 2rem;
}

.delete-all-btn {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.delete-all-btn:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

/* Alert styling */
.alert {
    background: #fff3cd;
    color: #856404;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    text-align: center;
}

.alert a {
    color: #533f03;
    text-decoration: underline;
}

/* Responsive design */
@media (max-width: 768px) {
    .cart-total {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .box-container {
        grid-template-columns: 1fr;
    }

    .box {
        margin: 1rem 0;
    }
}
/* Quick view icon - moved to top right */
.box .fa-eye {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2c3e50;
    text-decoration: none;
    transition: all 0.3s ease;
    z-index: 2; /* Ensure it's above other elements */
}

.box .fa-eye:hover {
    background: white;
    transform: scale(1.1);
    color: #3498db; /* Blue color on hover */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Delete button - stays at top left */
.delete-item-btn {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: rgba(231, 76, 60, 0.9);
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 2; /* Ensure it's above other elements */
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-item-btn:hover {
    background: #c0392b;
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Ensure the box has proper padding for the absolute positioned elements */
.box {
    position: relative;
    padding-top: 3rem; /* Increased top padding to accommodate the buttons */
}

/* Hide the inline form display */
.delete-form {
    display: contents !important; /* Override inline style while maintaining form functionality */
}
.empty-cart {
    text-align: center;
    margin-top: 50px;
    animation: fadeIn 1s ease-in-out;
}

.empty-cart-image {
    width: 150px;
    height: auto;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
}

.empty-cart-text {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
}

.shop-now-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.shop-now-button:hover {
    background-color: #0056b3;
}

/* Hiệu ứng fadeIn */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Hiệu ứng bounce */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

   </style>
</head>
<body>
   
<header class="header">

   <section class="flex">

   <a href="{{ url('/') }}" class="logo">
    <img src="{{ asset('images/logocanteen.jpg') }}" alt="Logo" style="max-width: 30%; height: auto;">
</a>

      <nav class="navbar">
         <a href="{{ url('/') }}">Home</a>
         <a href="{{ url('/about') }}">About</a>
         <a href="{{ url('/menu') }}">Menu</a>
         <a href="{{ url('/orders') }}">Orders</a>
         <a href="{{ url('/contact') }}">Contact</a>
         <a href="{{ url('/post') }}">Post</a>

      </nav>

      <div class="icons">
         <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
         <a href="{{ url('/cart') }}" id="cart-link">
        
         <i class="fas fa-shopping-cart"></i>
         <span>({{ $cartQuantity }})</span> 
        </a>
        <a href="{{ url('/notifications') }}"><i class="fa-solid fa-bell"></i></a>
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

</header>

<div class="heading">
   <h3>shopping cart</h3>
   <p><a href="{{ url('/') }}">home </a> <span> / cart</span></p>
</div>

<section class="products">
    <h1 class="title">Giỏ Hàng</h1>

    @if (Auth::check()) <!-- Kiểm tra người dùng đã đăng nhập -->
        <div class="cart-total">
            <p>Tổng cộng: <span id="grand-total">₫{{ number_format($grandTotal, 0, ',', '.') }}</span></p>
            @if($cartDetails->count() > 0)
                <a href="{{ url('/checkout') }}" id="checkout-btn" class="btn">Check Out</a>
            @endif
        </div>

        <div class="box-container">
            @forelse($cartDetails as $detail)
                <div class="box" data-detail-id="{{ $detail->id }}">
                <a href="{{ url('quick_view/' . $detail->product_id) }}" class="fas fa-eye"></a>
                    <form class="delete-form" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="fas fa-times delete-item-btn" type="button" data-detail-id="{{ $detail->id }}"></button>
                    </form>
                    <a href="{{ url('quick_view/' . $detail->product_id) }}" >
                    <img src="{{ asset('images/' . $detail->product->image) }}" alt="{{ $detail->product->name }}">
                    <div class="name">{{ $detail->product->name }}</div>
                    </a>
                    <div class="flex">
                        <div class="price">{{ number_format($detail->price, 0, ',', '.') }}<span>₫</span></div>
                        <input type="number" name="qty" class="qty" min="0" max="99" value="{{ $detail->quantity }}">
                        <button type="button" class="fas fa-edit edit-item-btn"></button>
                    </div>
                    <div class="sub-total">Tổng cộng: <span class="sub-total-amount">₫{{ number_format($detail->total_amount, 0, ',', '.') }}</span></div>
                </div>
            @empty
                <div class="empty-cart">
                    <img src="{{ asset('images/cart_empty.gif') }}" alt="Giỏ hàng trống">
                    <h2>Bạn chưa có gì trong giỏ hàng</h2>
                </div>
            @endforelse
        </div>

        @if($cartDetails->count() > 0)
            <div class="more-btn">
                <a href="#" class="delete-all-btn">Xóa tất cả</a>
            </div>
        @endif

    @else
        <div class="alert alert-warning">
            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để xem giỏ hàng của bạn.</p>
        </div>
    @endif
</section>



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

<script src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    $('.edit-item-btn').on('click', function() {
        let box = $(this).closest('.box');
        let detailId = box.data('detail-id');
        let qty = box.find('.qty').val();

        $.ajax({
            url: '{{ route("cart.update") }}',  // Sử dụng route helper để đảm bảo đúng URL
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                detail_id: detailId,
                qty: qty
            },
            success: function(response) {
                if (response.success) {
                    if (qty == 0) {
                        box.remove();  // Xóa sản phẩm khỏi giỏ hàng
                    } else {
                        box.find('.sub-total-amount').text(`₫${response.newTotal}`);
                    }
                    $('#grand-total').text(`₫${response.grandTotal}`);
                    checkEmptyCart();  // Kiểm tra giỏ hàng có trống không
                }
            },
            error: function(xhr) {
                let errorMessage = 'Có lỗi xảy ra, vui lòng thử lại.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    });

    // Xóa một sản phẩm trong giỏ hàng
    $('.delete-item-btn').on('click', function() {
        if (confirm('Xóa sản phẩm này?')) {
            let box = $(this).closest('.box');
            let detailId = box.data('detail-id');

            $.ajax({
                url: '{{ route("cart.delete") }}',  // Sử dụng route helper để đảm bảo đúng URL
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    detail_id: detailId
                },
                success: function(response) {
                    if (response.success) {
                        box.remove();
                        $('#grand-total').text(`₫${response.grandTotal}`);
                        checkEmptyCart();  // Kiểm tra giỏ hàng có trống không
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Có lỗi xảy ra, vui lòng thử lại.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    });

    // Xóa tất cả sản phẩm trong giỏ hàng
    $('.delete-all-btn').on('click', function(e) {
        e.preventDefault();
        if (confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?')) {
            $.ajax({
                url: '{{ route("cart.deleteAll") }}',  // Sử dụng route helper để đảm bảo đúng URL
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('.box-container').empty();
                        $('#grand-total').text('₫0');
                        checkEmptyCart();  // Kiểm tra giỏ hàng có trống không
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Có lỗi xảy ra, vui lòng thử lại.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }
    });

    // Kiểm tra nếu giỏ hàng trống khi nhấn nút Checkout
    $('#checkout-btn').on('click', function(e) {
        var cartItemCount = $('.box').length;  // Đếm số lượng sản phẩm trong giỏ hàng

        if (cartItemCount === 0) {
            e.preventDefault(); // Ngăn không cho chuyển hướng
            alert('Bạn chưa có gì trong giỏ hàng.');
        }
    });

    // Hàm kiểm tra giỏ hàng có trống không
    function checkEmptyCart() {
    if ($('.box').length === 0) {
        $('.box-container').html(`
            <div class="empty-cart">
                <img src="http://localhost/web_ban_banh_kem/public/images/empty-cart.png" alt="Giỏ hàng trống" class="empty-cart-image">
                <p class="empty-cart-text">Giỏ hàng của bạn hiện tại đang trống!</p>
                <a href="http://localhost/web_ban_banh_kem/public/menu" class="shop-now-button">Mua sắm ngay</a>
            </div>
        `);
        $('#checkout-btn').hide();  // Ẩn nút Checkout khi giỏ hàng trống
    } else {
        $('#checkout-btn').show();  // Hiển thị nút Checkout khi có sản phẩm
    }
}


    // Kiểm tra giỏ hàng khi trang tải lần đầu
    checkEmptyCart();
});
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
</script>




</body>
</html>