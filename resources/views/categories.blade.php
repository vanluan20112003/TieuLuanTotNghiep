<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- Swiper CSS -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.product-item {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    transition: transform 0.2s;
}

.product-item:hover {
    transform: scale(1.05);
}

   .box-container .box .price {
    font-size: 18px;
    color: #ff5722;
}

.box-container .box .discount-price {
    text-decoration: line-through;
    margin-left: 10px;
    color: #999;
}

.box-container .box .sale {
    margin-top: 10px;
    font-size: 16px;
    color: #4caf50;
    /* Đảm bảo rằng hình ảnh nằm trong khung của slide */
/* Đảm bảo rằng hình ảnh nằm trong khung của slide */
.swiper-slide .box {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.swiper-slide .image-container {
    width: 100px;  /* Kích thước mong muốn */
    height: 100px; /* Kích thước mong muốn */
    overflow: hidden; /* Ẩn phần hình ảnh vượt ra ngoài khung */
    margin: 0 auto; /* Căn giữa phần tử */
}

.swiper-slide .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Giữ tỷ lệ hình ảnh và lấp đầy khung */
}

.swiper-slide h3 {
    margin-top: 10px; /* Điều chỉnh khoảng cách giữa hình ảnh và tiêu đề */
}


}

.box-container .box .name {
    font-size: 20px;
    font-weight: bold;
}

.box-container .box .cat {
    font-size: 14px;
    color: #9c27b0;
    #user-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-avatar {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    object-fit: cover;
}

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
</style>
</head>
<body>
   
<header class="header">

   <section class="flex">

   <a href="{{ url('/') }}" class="logo">
    <img src="{{ asset('images/logocanteen.jpg') }}" alt="Logo" style="max-width: 30%; height: auto;">
</a>


      <nav class="navbar">
         <a href="{{ url('/') }}">Trang chủ</a>
         <a href="{{ url('/about') }}">Giới thiệu</a>
         <a href="{{ url('/menu') }}">Menu</a>
         <a href="{{ url('/orders') }}">Đơn hàng của bạn</a>
         <a href="{{ url('/contact') }}">Đặt bàn</a>
         <a href="{{ url('/post') }}">Các bài đăng</a>

      </nav>

      <div class="icons">
         <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
         <a href="{{ url('/cart') }}" id="cart-link">
        
         <i class="fas fa-shopping-cart"></i>
         <span>({{ $cartQuantity }})</span> 
        </a>
        <a href="{{ url('/notifications') }}" class="notification-link">
    <i class="fa-solid fa-bell"></i>
    <span class="dot" id="notificationDot"></span> <!-- Dấu chấm đỏ -->
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

</header>


<section class="products">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="title">{{ $category->name }}</h1>

    <div class="box-container">
        @foreach($products as $product)
            <form action="{{ route('add.to.cart') }}" method="post" class="box">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <a href="{{ url('/quick_view', $product->id) }}" class="fas fa-eye"></a>
                <button class="fas fa-shopping-cart" type="submit" name="add_to_cart"></button>
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                <a href="{{ url('/category', $product->category_id) }}" class="cat">{{ $product->category->name }}</a>
                <div class="name">{{ $product->name }}</div>
                <div class="flex">
                    <div class="price">
                        <span>{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                        <span class="discount-price">{{ number_format($product->original_price, 0, ',', '.') }} ₫</span>
                    </div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
                <div class="sale">
                    <h2>Sale Off: {{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%</h2>
                </div>
            </form>
        @endforeach
    </div>

    <div class="more-btn">
        <a href="{{ url('/menu') }}" class="btn">View All</a>
    </div>
</section>





<footer class="footer">

   <section class="box-container">

      <div class="box">
         <img src="{{ asset('images/email-icon.png') }}" alt="">
         <h3>Our Email</h3>
         <a href="mailto:shaikhanas@gmail.com">shaikhanas@gmail.com</a>
         <a href="mailto:anasbhai@gmail.com">anasbhai@gmail.com</a>
      </div>

      <div class="box">
         <img src="{{ asset('images/clock-icon.png') }}" alt="">
         <h3>Opening Hours</h3>
         <p>07:00 AM to 10:00 PM</p>
      </div>

      <div class="box">
         <img src="{{ asset('images/map-icon.png') }}" alt="">
         <h3>Our Address</h3>
         <a href="https://www.google.com/maps">Mumbai, India - 400104</a>
      </div>

      <div class="box">
         <img src="{{ asset('images/phone-icon.png') }}" alt="">
         <h3>Our Number</h3>
         <a href="tel:1234567890">+123-456-7890</a>
         <a href="tel:1112223333">+111-222-3333</a>
      </div>

   </section>

   <div class="credit">&copy; Copyright @ 2022 by <span>Mr. Web Designer</span> | All Rights Reserved!</div>

</footer>



<!-- Swiper JS -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Custom JS File Link -->
 
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var swiper = new Swiper(".home-slider", {
   loop: true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
});
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}

document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 2,
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    });
    $(document).on('click', '.add_to_cart', function(e) {
    e.preventDefault();

    let productId = $(this).data('product-id');
    let qty = $(this).data('quantity');

    $.ajax({
        url: '/add-to-cart',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId,
            qty: qty
        },
        success: function(response) {
            // Cập nhật giỏ hàng trên giao diện
            alert('Sản phẩm đã được thêm vào giỏ hàng!');
            // Ví dụ cập nhật số lượng giỏ hàng
            // $('#cart-item-count').text(response.cartItemCount);
        },
        error: function(response) {
            alert('Có lỗi xảy ra, vui lòng thử lại.');
        }
    });
});
$(document).ready(function() {
        $('#cart-link').on('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

            $.ajax({
                url: '{{ route("check.login") }}', // Tạo route kiểm tra đăng nhập
                type: 'GET',
                success: function(response) {
                    if (response.isLoggedIn) {
                        window.location.href = '{{ url("/cart") }}'; // Chuyển hướng đến trang giỏ hàng
                    } else {
                        alert('Bạn cần đăng nhập để xem giỏ hàng.');
                        window.location.href = '{{ url("/login") }}'; // Chuyển hướng đến trang đăng nhập
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });
    });


</script>

</body>
</html>
