<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>Home</title>

   <!-- Swiper CSS -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/home.css') }}">
   <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
   <link rel="stylesheet" href="{{ asset('css/bell.css') }}">
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   <link rel="stylesheet" href="{{ asset('css/speech.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
   
 


<style>
    .box-container {
    display: flex;
    flex-wrap: wrap; /* Cho phép các box hiển thị trên nhiều dòng */
    gap: 20px; /* Khoảng cách giữa các box */
    padding: 20px; /* Padding cho container */
}

.box {
    background-color: #fff; /* Nền trắng cho sản phẩm */
    border: 1px solid #e0e0e0; /* Viền nhẹ cho sản phẩm */
    border-radius: 8px; /* Bo tròn góc */
    padding: 10px; /* Padding cho box */
    text-align: center; /* Căn giữa nội dung */
    transition: transform 0.3s; /* Hiệu ứng khi hover */
}

.box:hover {
    transform: scale(1.05); /* Tăng kích thước khi hover */
}

.product-image {
    max-width: 100%; /* Đảm bảo hình ảnh không vượt quá chiều rộng box */
    height: auto; /* Đảm bảo giữ tỷ lệ hình ảnh */
    border-radius: 5px; /* Bo tròn góc hình ảnh */
}

.product-details {
    margin-top: 10px; /* Khoảng cách giữa hình ảnh và thông tin sản phẩm */
}

.category {
    color: #00796b; /* Màu cho tên danh mục */
    text-decoration: none; /* Xóa gạch chân */
    font-weight: bold; /* Chữ đậm cho danh mục */
}

.name {
    font-size: 16px; /* Kích thước chữ cho tên sản phẩm */
    margin: 5px 0; /* Khoảng cách trên và dưới tên sản phẩm */
}

.price {
    margin: 10px 0; /* Khoảng cách trên và dưới giá sản phẩm */
}

.current-price {
    font-weight: bold; /* Chữ đậm cho giá hiện tại */
    color: #d32f2f; /* Màu đỏ cho giá hiện tại */
}

.original-price {
    text-decoration: line-through; /* Gạch chân giá gốc */
    color: #757575; /* Màu xám cho giá gốc */
}

.sale h2 {
    color: #388e3c; /* Màu xanh lá cho phần giảm giá */
    font-size: 14px; /* Kích thước chữ cho phần giảm giá */
    margin-top: 5px; /* Khoảng cách trên cho phần giảm giá */
}

.add-to-cart-btn {
    background-color: #00796b; /* Màu nền cho nút thêm vào giỏ hàng */
    color: white; /* Màu chữ trắng */
    border: none; /* Xóa viền */
    border-radius: 5px; /* Bo tròn góc */
    padding: 10px; /* Padding cho nút */
    cursor: pointer; /* Con trỏ chuột khi hover */
    transition: background-color 0.3s; /* Hiệu ứng chuyển màu nền */
}

.add-to-cart-btn:hover {
    background-color: #004d40; /* Màu nền khi hover */
}

body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
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

.logo {
    font-size: 24px;
    color: #4CAF50; /* Màu xanh lá */
    text-decoration: none; /* Bỏ gạch chân */
}

.navbar {
    display: flex;
    gap: 15px; /* Khoảng cách giữa các liên kết */
}

.navbar a {
    color: #333; /* Màu chữ liên kết */
    text-decoration: none; /* Bỏ gạch chân */
    padding: 8px 12px; /* Khoảng cách bên trong */
    border-radius: 4px; /* Bo tròn góc */
    transition: background-color 0.3s; /* Hiệu ứng chuyển màu */
}

.navbar a:hover {
    background-color: #f0f0f0; /* Màu nền khi hover */
}

.icons {
    display: flex;
    align-items: center; /* Canh giữa các biểu tượng */
    gap: 20px; /* Khoảng cách giữa các biểu tượng */
}

.icon {
    position: relative; /* Để có thể định vị các phần tử bên trong */
}

.notification-icon {
    cursor: pointer; /* Thay đổi con trỏ khi hover */
}

.notification-dropdown {
    display: none; /* Ẩn thông báo mặc định */
    position: absolute;
    background-color: white; /* Nền trắng cho dropdown */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho dropdown */
    right: 0;
    top: 40px; /* Đặt cách xa biểu tượng thông báo */
    padding: 10px; /* Khoảng cách bên trong */
    z-index: 10; /* Để dropdown ở trên */
}

.notification-icon:hover .notification-dropdown {
    display: block; /* Hiện dropdown khi hover */
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%; /* Bo tròn cho avatar */
    object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
}

.user-default {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #ddd; /* Màu nền cho avatar mặc định */
}

.profile {
    display: flex;
    flex-direction: column; /* Sắp xếp theo chiều dọc */
    align-items: flex-end; /* Canh bên phải */
}

.name {
    font-weight: bold; /* Chữ đậm cho tên người dùng */
}

.btn-header {
    background-color: #00FF00; /* Màu đỏ cho nút đăng xuất */
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer; /* Thay đổi con trỏ khi hover */
    transition: background-color 0.3s;
}


.delete-btn:hover {
    background-color: #e53935; /* Màu khi hover */
}
.snowflakes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1000;
}

.snowflake {
    position: absolute;
    color: white;
    font-size: 24px;
    opacity: 0.8;
    animation: fall linear infinite;
    user-select: none;
    pointer-events: none;
}

/* Hiệu ứng rơi */
@keyframes fall {
    0% {
        transform: translateY(-100px);
        opacity: 0.8;
    }
    100% {
        transform: translateY(100vh);
        opacity: 0.5;
    }
}
.cart-wrapper {
    position: relative;
    padding: 8px;
    cursor: pointer;
    z-index: 1000;
}

.cart-icon {
    position: relative;
    display: inline-block;
}

.cart-icon i {
    font-size: 24px;
    color: #2c3e50;
    transition: all 0.3s ease;
}

.cart-counter {
    position: absolute;
    top: -10px;
    right: -15px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Flying item animation */
.fly-item {
    position: fixed;
    pointer-events: none;
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    z-index: 9999;
    transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1);
}

/* Counter animation */
@keyframes countUpdate {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.3);
    }
    100% {
        transform: scale(1);
    }
}

.counter-animate {
    animation: countUpdate 0.3s ease-out;
}

/* Cart shake animation */
@keyframes cartShake {
    0%, 100% { transform: rotate(0); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
}

.cart-shake {
    animation: cartShake 0.4s ease-in-out;
}
<!-- HTML -->
<div class="notification-container">
    <a href="{{ url('/notifications') }}" class="notification-link">
        <i class="fa-solid fa-bell"></i>
        <span class="dot" id="notificationDot"></span>
    </a>
    <div class="notification-dropdown">
        <div class="notification-header">
            <h3>Thông báo</h3>
        </div>
        <div class="notification-list">
            <!-- Notifications will be dynamically inserted here -->
        </div>
        <div class="notification-footer">
            <a href="{{ url('/notifications') }}" class="view-all">Xem tất cả thông báo</a>
        </div>
    </div>
</div>

<style>
.notification-container {
    position: relative;
    display: inline-block;
}

.notification-link {
    color: #65676B;
    font-size: 20px;
    padding: 8px;
    border-radius: 50%;
    transition: background-color 0.3s;
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.notification-link:hover {
    background-color: #F0F2F5;
}

.dot {
    position: absolute;
    top: 0;
    right: 0;
    width: 8px;
    height: 8px;
    background-color: #FF0000;
    border-radius: 50%;
    display: none;
}

.notification-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: -10px;
    width: 360px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    display: none;
    z-index: 1000;
    max-height: 600px;
    overflow-y: auto;
}

.notification-header {
    padding: 16px;
    border-bottom: 1px solid #E4E6EB;
}

.notification-header h3 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #050505;
}

.notification-list {
    padding: 8px 0;
}

.notification-item {
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.notification-item:hover {
    background-color: #F0F2F5;
}

.notification-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    overflow: hidden;
}

.notification-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.notification-content {
    flex: 1;
}

.notification-text {
    margin: 0;
    font-size: 14px;
    color: #050505;
    line-height: 1.4;
}

.notification-time {
    font-size: 12px;
    color: #65676B;
    margin-top: 4px;
}

.notification-footer {
    padding: 16px;
    border-top: 1px solid #E4E6EB;
    text-align: center;
}

.view-all {
    color: #1877F2;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
}

.view-all:hover {
    text-decoration: underline;
}

/* Custom scrollbar */
.notification-dropdown::-webkit-scrollbar {
    width: 8px;
}

.notification-dropdown::-webkit-scrollbar-track {
    background: #F0F2F5;
}

.notification-dropdown::-webkit-scrollbar-thumb {
    background: #BCC0C4;
    border-radius: 4px;
}

.notification-dropdown::-webkit-scrollbar-thumb:hover {
    background: #A8ABAF;
}
/* Container cho mỗi thông báo */
.notification-item {
    display: flex;
    align-items: flex-start; /* Căn chỉnh các phần tử theo chiều dọc */
    margin-bottom: 15px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    background-color: #f9f9f9;
}

/* Phần avatar (hình ảnh) */
.notification-avatar {
    margin-right: 10px; /* Khoảng cách giữa avatar và nội dung */
}

/* Cấu trúc cho phần hình ảnh */
.notification-avatar img {
    width: 40px; /* Kích thước hình ảnh */
    height: 40px; /* Kích thước hình ảnh */
    border-radius: 50%; /* Để hình tròn */
    object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
}

/* Phần nội dung thông báo */
.notification-content {
    flex: 1; /* Chiếm toàn bộ không gian còn lại */
    display: flex;
    flex-direction: column; /* Đảm bảo các phần tử con trong nội dung xếp theo cột */
}

/* Nội dung chính của thông báo */
.notification-text {
    font-size: 14px;
    margin-bottom: 5px;
    word-wrap: break-word; /* Cho phép văn bản xuống dòng khi không đủ chỗ */
    line-height: 1.5;
}

/* Thời gian thông báo */
.notification-time {
    font-size: 12px;
    color: #777;
}

/* Điều chỉnh độ mờ của thông báo đã đọc */
.notification-item.read {
    opacity: 0.5; /* Giảm độ sáng của thông báo đã đọc */
}

/* Các phần tử giao diện cho phần dropdown */
.notification-dropdown {
    max-width: 400px;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    position: absolute;
    top: 50px;
    right: 0;
    z-index: 1000;
    display: none;
}

.notification-header {
    padding: 15px;
    background-color: #f5f5f5;
    border-bottom: 1px solid #ddd;
}

.notification-list {
    padding: 15px;
    max-height: 300px;
    overflow-y: auto;
}

.notification-footer {
    padding: 15px;
    text-align: center;
    background-color: #f5f5f5;
}

.notification-footer .view-all {
    color: #007bff;
    text-decoration: none;
}

.notification-footer .view-all:hover {
    text-decoration: underline;
}

</style>
   

</head>
<body>
   
<header class="header">

   <section class="flex">

   <a href="{{ Auth::check() && Auth::user()->is_admin == 1 ? url('/admin/dashboard') : url('/') }}" class="logo">
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
        
         <div class="cart-wrapper">
    <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-counter">
            <div class="counter-number" data-count="{{ $cartQuantity }}">{{ $cartQuantity }}</div>
        </div>
    </div>
</div>
        </a>
        <div class="notification-container">
    <a href="{{ url('/notifications') }}" class="notification-link">
        <i class="fa-solid fa-bell"></i>
        <span class="dot" id="notificationDot"></span>
    </a>
    <div class="notification-dropdown">
        <div class="notification-header">
            <h3>Thông báo</h3>
        </div>
        <div class="notification-list">
            <!-- Notifications will be dynamically inserted here -->
        </div>
        <div class="notification-footer">
            <a href="{{ url('/notifications') }}" class="view-all">Xem tất cả thông báo</a>
        </div>
    </div>
</div>

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

<div class="snowflakes" aria-hidden="true"></div>
<section class="home">

    <div class="swiper home-slider">

        <div class="swiper-wrapper">

            @foreach($slides as $slide)
                @if(!empty($slide->image) || !empty($slide->content_1) || !empty($slide->content_2) || !empty($slide->content_3))
                    <div class="swiper-slide slide">
                        <div class="content">
                            @if(!empty($slide->content_1))
                                <span>{{ $slide->content_1 }}</span>
                            @endif

                            @if(!empty($slide->content_2))
                                <h3>{{ $slide->content_2 }}</h3>
                            @endif

                            @if(!empty($slide->content_3))
                                <h2>{{ $slide->content_3 }}</h2>
                            @endif

                            <a href="{{ url($slide->url) }}" class="btn">Tìm hiểu thêm</a>
                        </div>
                        <div class="image">
                            @if(!empty($slide->image))
                                <img src="{{ asset('images/' . $slide->image) }}" alt="Slide Image">
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">

        <script>
            var swiper = new Swiper(".home-slider", {
    loop: true,
    grabCursor: true,
    effect: 'coverflow',
coverflowEffect: {
    rotate: 50, // Góc xoay của các slide
    stretch: 0, // Kéo dãn các slide
    depth: 100, // Chiều sâu
    modifier: 1, // Hệ số thay đổi
    slideShadows: true, // Bóng đổ
},
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 3000, // Set the delay between slides in milliseconds
        disableOnInteraction: false, // Continue autoplay even after user interaction
    },
});
        </script>

    </div>

</section>


<section class="category">
    <h1 class="title" style="text-align: center; font-size: 32px; color: #333; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 2px;">Danh Mục Sản Phẩm</h1>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <div class="swiper-slide">
                    <a href="{{ url('/category', $category->id) }}" class="box">
                        <div class="image-container">
                            <img src="{{ asset('images/' . $category->image) }}" alt="{{ $category->name }}">
                        </div>
                        <h3>{{ $category->name }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
<style> /* Style cho tiêu đề */
/* Style cho tiêu đề */
.category .title {
    font-family: 'Arial', sans-serif;
    font-weight: bold;
    color: #444;
    text-align: center;
    margin-bottom: 30px;
    text-transform: uppercase;
    letter-spacing: 2px;
}

/* Style cho container */
.category .swiper-container {
    padding: 20px 0;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Style cho từng danh mục */
.category .box {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    height: 300px;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #f9f9f9, #ececec);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.category .box:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

/* Style cho ảnh */
.category .image-container {
    width: 200px;
    height: 200px;
    overflow: hidden;
    margin-bottom: 10px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hiệu ứng mờ thay vì viền */
    transition: transform 0.3s ease;
}

.category .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category .box:hover .image-container {
    transform: scale(1.1); /* Phóng to nhẹ ảnh khi hover */
}

.category .box:hover img {
    transform: scale(1.2);
}

/* Style cho tên danh mục */
.category .box h3 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: color 0.3s ease;
}

.category .box:hover h3 {
    color: #FF5722; /* Đổi màu chữ khi hover */
}

/* Style cho Swiper */
.swiper-button-next,
.swiper-button-prev {
    color: #444; /* Màu nút điều hướng trung tính hơn */
    transition: color 0.3s ease;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    color: #FF5722; /* Màu cam khi hover */
}

.swiper-pagination-bullet {
    background: #888;
    opacity: 0.8;
}

.swiper-pagination-bullet-active {
    background: #FF5722; /* Màu cam cho pagination đang được chọn */
}

</style>

<section class="products">
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session("success") }}');
        });
    </script>
@endif

@if(session('error'))
<script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session("error") }}');
        });
    </script>
@endif

    <h1 class="title">Sản Phẩm Mới Nhất</h1>

    <div class="box-container">
    @foreach($latestProducts as $product)
    <div class="box">
        @csrf
        <input type="hidden" class="product-id" value="{{ $product->id }}">
        <button class="add-to-cart-btn fas fa-shopping-cart" type="button"></button>
        <a href="{{ url('/quick_view', $product->id) }}">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        </a>
        <div class="product-details">
            <a href="{{ url('/category', $product->category_id) }}" class="category">{{ $product->category->name }}</a>
            <div class="name">{{ $product->name }}</div>
            <div class="flex">
                <div class="price">
                    <span class="current-price">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @if($product->original_price)
                        <span class="original-price">{{ number_format($product->original_price, 0, ',', '.') }} ₫</span>
                    @endif
                </div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
            </div>
            <div class="sale">
                <h2>Sale Off: {{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%</h2>
            </div>
        </div>
    </div>
@endforeach

</div>
<h1 class="title">Sản Phẩm Bán Chạy Nhất</h1>
<div class="box-container">
  @foreach($bestSellingProducts as $product) <!-- Thay $latestProducts bằng $bestSellingProducts -->
    <div class="box">
        @csrf
        <input type="hidden" class="product-id" value="{{ $product->id }}">
        <button class="add-to-cart-btn fas fa-shopping-cart" type="button"></button>
        <a href="{{ url('/quick_view', $product->id) }}">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        </a>
        <div class="product-details">
            <a href="{{ url('/category', $product->category_id) }}" class="category">{{ $product->category->name }}</a>
            <div class="name">{{ $product->name }}</div>
            <div class="flex">
                <div class="price">
                    <span class="current-price">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @if($product->original_price)
                        <span class="original-price">{{ number_format($product->original_price, 0, ',', '.') }} ₫</span>
                    @endif
                </div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
            </div>
            <div class="sale">
                <h2>Sale Off: {{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%</h2>
            </div>
        </div>
    </div>
  @endforeach
</div>
<h1 class="title">Sản Phẩm Gợi Ý</h1>
<div class="box-container">
  @foreach($randomProducts as $product)
    <div class="box">
        @csrf
        <input type="hidden" class="product-id" value="{{ $product->id }}">
        <button class="add-to-cart-btn fas fa-shopping-cart" type="button"></button>
        <a href="{{ url('/quick_view', $product->id) }}">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        </a>
        <div class="product-details">
            <a href="{{ url('/category', $product->category_id) }}" class="category">{{ $product->category->name }}</a>
            <div class="name">{{ $product->name }}</div>
            <div class="flex">
                <div class="price">
                    <span class="current-price">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @if($product->original_price)
                        <span class="original-price">{{ number_format($product->original_price, 0, ',', '.') }} ₫</span>
                    @endif
                </div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
            </div>
            <div class="sale">
                <h2>Sale Off: {{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%</h2>
            </div>
        </div>
    </div>
  @endforeach
</div>
    <div class="more-btn">
        <a href="{{ url('/menu') }}" class="btn">View All</a>
    </div>

</section>


<div class="chat-popup">
    <button class="chat-button" id="chatToggle">
        💬
        <span class="unread-dot" id="unreadDot"></span>
    </button>
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <span>Hỗ trợ trực tuyến</span>
            <button id="chatClose">✖</button>
        </div>
        <div class="chat-messages" id="chatMessages"></div>
        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Nhập tin nhắn...">
            <button id="sendButton">➤</button>
        </div>
    </div>
</div>



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
<script src="js/chat.js"></script>
<script src="js/bell.js"></script>


<!--<script src="js/add_to_cart.js"></script>-->



<!-- Swiper JS -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="js/speech.js"></script>
<!-- Custom JS File Link -->
 


<script>
 
 

    // Swiper initialization

    // Confirm logout
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            document.getElementById('logout-form').submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.swiper-container', {
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
                640: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    });

    $(document).ready(function() {
    // Add to cart
    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();

        var button = $(this);
        var productId = button.closest('.box').find('.product-id').val();
        var qty = button.closest('.box').find('.qty').val();
        var imageUrl = button.closest('.box').find('.product-image').attr('src'); // Lấy đường dẫn hình ảnh của sản phẩm

        // Gửi yêu cầu AJAX
        $.ajax({
            url: '{{ route("add.to.cart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                qty: qty
            },
            success: function(response) {
              
                // Gọi hàm addToCart sau khi sản phẩm đã được thêm
                addToCart(productId, imageUrl, button[0], qty);
            },
            error: function(response) {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
});

    const numberOfSnowflakes = 100;

// Lấy phần tử chứa bông tuyết
const snowflakesContainer = document.querySelector('.snowflakes');

// Tạo các bông tuyết ngẫu nhiên
for (let i = 0; i < numberOfSnowflakes; i++) {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.innerHTML = '❄'; // Biểu tượng bông tuyết

    // Đặt vị trí và kích thước ngẫu nhiên cho mỗi bông tuyết
    const size = Math.random() * 10 + 10 + 'px'; // Kích thước từ 10px đến 20px
    const leftPosition = Math.random() * 100 + 'vw'; // Vị trí ngang ngẫu nhiên
    const animationDuration = Math.random() * 5 + 5 + 's'; // Thời gian rơi ngẫu nhiên

    snowflake.style.fontSize = size;
    snowflake.style.left = leftPosition;
    snowflake.style.animationDuration = animationDuration;

    // Thêm bông tuyết vào container
    snowflakesContainer.appendChild(snowflake);
}
function addToCart(productId, imageUrl, buttonElement, quantity) {
    // Get button position
    const button = buttonElement;
    const buttonRect = button.getBoundingClientRect();
    const startX = buttonRect.left + buttonRect.width / 2;
    const startY = buttonRect.top + buttonRect.height / 2;
    
    // Get cart position
    const cart = document.querySelector('.cart-icon');
    const cartRect = cart.getBoundingClientRect();
    const endX = cartRect.left + cartRect.width / 2;
    const endY = cartRect.top + cartRect.height / 2;
    
    // Create flying image
    const flyingImage = document.createElement('img');
    flyingImage.src = imageUrl;
    flyingImage.classList.add('fly-item');
    flyingImage.style.left = `${startX}px`;
    flyingImage.style.top = `${startY}px`;
    document.body.appendChild(flyingImage);
    
    // Start animation
    setTimeout(() => {
        flyingImage.style.left = `${endX}px`;
        flyingImage.style.top = `${endY}px`;
        flyingImage.style.transform = 'scale(0.1)';
        flyingImage.style.opacity = '0.7';
    }, 10);
    const quantityInt = parseInt(quantity, 10)
    // Update counter after animation
    setTimeout(() => {
        // Remove flying image
        flyingImage.remove();
        
        // Get the current count and increment by the quantity
        const counter = document.querySelector('.counter-number');
        const currentCount = parseInt(counter.dataset.count);
        const newCount = currentCount + quantityInt;
        counter.dataset.count = newCount;
        counter.textContent = newCount;
        counter.classList.add('counter-animate');
        
        
        // Shake cart
        const cartIcon = document.querySelector('.cart-icon');
        cartIcon.classList.add('cart-shake');
        
        // Remove animations after a short duration
        setTimeout(() => {
            counter.classList.remove('counter-animate');
            cartIcon.classList.remove('cart-shake');
        }, 300);
    }, 800);
}

document.addEventListener('DOMContentLoaded', function () {
    const notificationLink = document.querySelector('.notification-link');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const notificationDot = document.querySelector('#notificationDot');
    const notificationList = document.querySelector('.notification-list');
    const apiEndpoint = 'http://localhost/web_ban_banh_kem/public/get-notifications';
    const defaultImage = 'http://localhost/web_ban_banh_kem/public/images/Notification.png'; // Hình minh họa mặc định

    // Toggle dropdown
    notificationLink.addEventListener('click', function (e) {
        e.preventDefault();
        notificationDropdown.style.display = notificationDropdown.style.display === 'none' ? 'block' : 'none';
        notificationDot.style.display = 'none'; // Hide dot when opened

        // Load notifications
        loadNotifications();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!notificationDropdown.contains(e.target) && !notificationLink.contains(e.target)) {
            notificationDropdown.style.display = 'none';
        }
    });

    async function loadNotifications() {
        try {
            const response = await fetch(apiEndpoint);
            const notifications = await response.json();

            // Clear existing notifications
            notificationList.innerHTML = '';

            // Process notifications (limit to 10 notifications)
            notifications.slice(0, 10).forEach(notification => {
                const notificationItem = document.createElement('div');
                notificationItem.className = 'notification-item' + (notification.is_read ? ' read' : '');

                let contentHtml = `
                    <div class="notification-avatar">
                        <!-- Check if cover image exists, otherwise show a default image -->
                        <img src="${notification.cover_image || defaultImage}" alt="avatar">
                    </div>
                    <div class="notification-content">
                        <p class="notification-text">${notification.content}</p>
                        <p class="notification-time">${notification.created_at}</p>
                    </div>
                `;

                // Add link if available
                if (notification.link) {
                    contentHtml = `<a href="${notification.link}" target="_blank">${contentHtml}</a>`;
                }

                notificationItem.innerHTML = contentHtml;

                // Add click event to mark notification as read
                notificationItem.addEventListener('click', async function () {
                    try {
                        const markAsReadResponse = await fetch(`http://localhost/web_ban_banh_kem/public/notifications/${notification.id}/mark-as-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                        });

                        const data = await markAsReadResponse.json();

                        // Check if successful and apply visual changes
                        if (markAsReadResponse.ok) {
                            notificationItem.classList.add('read'); // Mark the item visually as read
                        } else {
                            alert(data.message); // Handle error message from backend
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                });

                notificationList.appendChild(notificationItem);
            });

        } catch (error) {
            console.error('Error loading notifications:', error);
            notificationList.innerHTML = '<p class="error">Không thể tải thông báo. Vui lòng thử lại sau.</p>';
        }
    }

    // Update notification dot visibility based on unread notifications
    async function updateNotificationDot() {
        try {
            const response = await fetch(apiEndpoint);
            const notifications = await response.json();
            const hasUnread = notifications.some(notification => notification.is_read === 0);
            notificationDot.style.display = hasUnread ? 'block' : 'none';
        } catch (error) {
            console.error('Error updating notification dot:', error);
        }
    }

    // Initial dot update
    updateNotificationDot();
});

</script>


</body>

</html>
