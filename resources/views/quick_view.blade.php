<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View - {{ $product->name }}</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

   <link rel="stylesheet" href="{{ asset('css/quickview.css') }}">
<style>
    .pagination {
    display: flex; /* Sử dụng flexbox để dễ dàng căn giữa */
    justify-content: center; /* Căn giữa các nút */
    margin-top: 15px; /* Khoảng cách trên nút phân trang */
}

.pagination a {
    text-decoration: none; /* Xóa gạch chân khỏi liên kết */
    color: #007bff; /* Màu chữ cho liên kết */
    padding: 8px 12px; /* Khoảng cách bên trong nút */
    margin: 0 5px; /* Khoảng cách giữa các nút */
    border: 1px solid #007bff; /* Đường viền cho nút */
    border-radius: 4px; /* Bo tròn góc */
    transition: background-color 0.3s, color 0.3s; /* Hiệu ứng chuyển màu */
}

.pagination a:hover {
    background-color: #007bff; /* Màu nền khi hover */
    color: white; /* Màu chữ khi hover */
}

.pagination .active {
    background-color: #007bff; /* Màu nền cho nút đang được chọn */
    color: white; /* Màu chữ cho nút đang được chọn */
    border: 1px solid #007bff; /* Đường viền cho nút đang được chọn */
}

   .review {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-top: 30px;
}
.like-dislike {
    margin-top: 10px;
}
.report-menu {
    position: absolute;
    right: 10px; /* Đặt nó cách bên phải một khoảng cách */
    top: 10px; /* Đặt nó ở vị trí mong muốn */
    display: inline-block;
    cursor: pointer;
}
.report-btn {
    font-size: 24px; /* Tăng kích thước chữ */
    color: #FF5733; /* Màu sắc nổi bật, bạn có thể thay đổi màu này */
    cursor: pointer; /* Chỉ thị rằng đây là một nút có thể nhấn */
    padding: 5px; /* Thêm khoảng cách xung quanh */
    transition: color 0.3s ease; /* Hiệu ứng chuyển màu khi di chuột */
}

.report-btn:hover {
    color: #C70039; /* Màu khi di chuột vào */
}


.report-options {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 1;
    margin-top: 5px;
    width: 200px; /* Độ rộng menu */
}

.report-option {
    padding: 8px 12px; /* Thêm padding để dễ nhấn */
    cursor: pointer;
}

.report-option:hover {
    background-color: #f0f0f0; /* Hiệu ứng hover */
}
.like-btn,
.dislike-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 5px 10px;
    cursor: pointer;
    margin-right: 5px;
    transition: background-color 0.3s;
}
.user-image {
    width: 50px; /* Kích thước avatar */
    height: 50px; /* Kích thước avatar */
    border-radius: 50%; /* Làm tròn avatar */
    position: absolute; /* Đặt vị trí tuyệt đối */
    top: 15px; /* Khoảng cách từ đỉnh của review-card */
    left: 15px; /* Khoảng cách từ bên trái của review-card */
}

.like-btn:hover,
.dislike-btn:hover {
    background-color: #0056b3;
}

.admin-reply {
    margin-left: 20px; /* Thụt vào */
    padding: 10px;
    background-color: #f9f9f9;
    border-left: 4px solid #007bff;
    border-radius: 5px;
    margin-top: 10px;
}
.review-title {
    font-size: 24px;
    margin-bottom: 10px;
}

.star-rating i {
    font-size: 24px;
    cursor: pointer;
    color: #ddd;
}

.star-rating i.checked {
    color: #FFD700;
}

.comment-box {
    margin-top: 15px;
}

.comment-box textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.comment-box .btn {
    margin-top: 10px;
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.all-reviews {
    margin-top: 30px;
}

.review-card {
    position: relative; /* Để các phần tử con có thể dùng vị trí tuyệt đối */
    padding: 15px; /* Khoảng cách bên trong */
    border: 1px solid #ccc; /* Đường viền (tùy chọn) */
    margin-bottom: 20px; /* Khoảng cách giữa các bình luận */
    background: #fff; /* Màu nền (tùy chọn) */
    border-radius: 5px; /* Bo góc */
}

.review-card .user-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}
.review-info {
    margin-left: 75px; /* Đảm bảo không bị che bởi ảnh */
}
.review-card .review-info {
    flex-grow: 1;
}

.review-card .user-name {
    font-weight: bold;
    margin-bottom: 5px;
}

.review-card .star-rating.static i {
    color: #FFD700;
}

.review-card .user-comment {
    margin-top: 5px;
    font-size: 14px;
    color: #555;
}
.user-replies {
    margin-top: 10px;
    padding-left: 20px;
}

.user-reply {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}
.reply-box {
    margin-top: 10px;
}

.reply-text {
    width: 100%;
    height: 50px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 5px;
}

.submit-reply-btn {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-reply-btn:hover {
    background-color: #45a049;
}

.reply-btn {
    background-color: #007BFF; /* Màu nền xanh */
    color: white; /* Màu chữ trắng */
    border: none; /* Loại bỏ viền */
    padding: 8px 12px; /* Đệm trong nút */
    border-radius: 5px; /* Bo góc nút */
    font-size: 14px; /* Cỡ chữ */
    cursor: pointer; /* Con trỏ dạng tay khi hover */
    margin-top: 10px; /* Khoảng cách phía trên */
}

.reply-btn:hover {
    background-color: #0056b3; /* Màu nền đậm hơn khi hover */
}
.user-reply {
    display: flex; /* Sắp xếp theo hàng */
    flex-direction: column; /* Cho phép nội dung có thể chồng lên nhau */
    margin: 10px 0; /* Khoảng cách giữa các reply */
    padding: 10px; /* Padding cho các reply */
    border: 1px solid #e0e0e0; /* Đường viền cho các reply */
    border-radius: 5px; /* Bo góc */
    background-color: #f9f9f9; /* Màu nền */
}

.user-info {
    display: flex; /* Sắp xếp theo hàng */
    align-items: center; /* Căn giữa theo chiều dọc */
    margin-bottom: 5px; /* Khoảng cách giữa user-info và reply content */
}

.user-avatar {
    width: 30px; /* Kích thước ảnh */
    height: 30px; /* Kích thước ảnh */
    border-radius: 50%; /* Hình tròn */
    margin-right: 10px; /* Khoảng cách giữa ảnh và tên */
}

.user-name {
    font-weight: bold; /* Chữ đậm cho tên người dùng */
    font-size: 1.1em; /* Kích thước chữ lớn hơn */
}

.reply-content {
    margin: 5px 0; /* Khoảng cách giữa nội dung reply và thời gian */
    font-size: 1em; /* Kích thước chữ bình thường */
}

.reply-date {
    color: gray; /* Màu chữ cho thời gian */
    font-size: 0.8em; /* Kích thước chữ nhỏ hơn */
    margin-top: 5px; /* Khoảng cách trên cho thời gian */
}

.admin-reply {
    background-color: #fff8c4; /* Màu vàng nhạt cho admin */
    border-left: 4px solid #f1c40f; /* Đường viền vàng bên trái */
}
.toggle-comments-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    margin-bottom: 15px;
    font-size: 16px;
    border-radius: 5px;
}

.toggle-comments-btn:hover {
    background-color: #0056b3;
}

#speak-button {
    font-size: 18px;
    color: #555;
    cursor: pointer;
    transition: color 0.3s ease;
}

#speak-button:hover {
    color: #27ae60;
}

#speaker-icon {
    font-size: 20px;
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

.tag {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    padding: 5px 12px;
    border-radius: 20px;
    text-transform: capitalize;
    display: inline-block;
    background-color: #f1f1f1;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.tag:hover {
    background-color: #FFEB3B; /* Màu vàng dễ chịu khi hover */
    transform: scale(1.1);
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
         <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-counter">
            <div class="counter-number" data-count="{{ $cartQuantity }}">{{ $cartQuantity }}</div>
        </div>
        </div>
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
<div class="quick-view-container" style="display: flex; gap: 20px; align-items: flex-start; width: 100%; max-width: 1400px;">

    <!-- Chi tiết sản phẩm -->
    <div class="product-container" style="width: 80%; padding: 20px;">
    <!-- Phần trên chia 2 cột -->
    <div class="top-section" style="display: flex; gap: 30px; margin-bottom: -10px;">
        <!-- Cột trái - Ảnh sản phẩm -->
        <div class="left-column" style="flex: 0 0 45%;">
            <div class="product-image">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" 
                    style="width: 100%; height: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            </div>
        </div>

        <!-- Cột phải - Thông tin sản phẩm và giá -->
        <div class="right-column" style="flex: 0 0 55%;">
    <h2 class="product-name" style="margin: 0 0 15px 0; font-size: 32px; color: #333;">
        <i class="fas fa-box"></i> {{ $product->name }}
        <button id="speak-button" style="background: none; border: none; cursor: pointer; margin-left: 10px;">
            <i id="speaker-icon" class="fas fa-volume-up"></i>
        </button>
    </h2>

    <div class="tag-list" style="margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
        <!-- Thêm các tag dinh dưỡng dựa trên giá trị thành phần -->
        @if($nutritionRatio['sugar'] < 10)
            <span class="tag" style="background-color: #4CAF50;">Ít đường</span>
        @endif

        @if($nutritionRatio['protein'] > 30)
            <span class="tag" style="background-color: #FFC107;">Nhiều protein</span>
        @endif

        @if($nutritionRatio['fiber'] > 20)
            <span class="tag" style="background-color: #8BC34A;">Chất xơ cao</span>
        @endif

        @if($nutritionRatio['fat'] < 10)
            <span class="tag" style="background-color: #03A9F4;">Ít chất béo</span>
        @endif

        @if($nutritionFact->carbohydrate < 100)
            <span class="tag" style="background-color: #FFEB3B;">Ít Carbs</span>
        @endif

        <!-- Các tag dinh dưỡng khác -->
        @if($nutritionFact->calories < 200)
            <span class="tag" style="background-color: #FF5722;">Ít calo</span>
        @endif

        @if($nutritionFact->fiber >= 30)
            <span class="tag" style="background-color: #8BC34A;">Rất nhiều chất xơ</span>
        @endif

        @if($nutritionFact->protein < 20)
            <span class="tag" style="background-color: #FF9800;">Thấp protein</span>
        @endif

        @if($nutritionFact->fat >= 15)
            <span class="tag" style="background-color: #F44336;">Nhiều chất béo</span>
        @endif

        @if($nutritionFact->sugar >= 15)
            <span class="tag" style="background-color: #E91E63;">Nhiều đường</span>
        @endif
    </div>

    <div class="rating-price" style="margin-bottom: 20px;">
        <div class="average-rating" style="margin-bottom: 15px;">
            <div class="star-rating" style="margin-bottom: 5px;">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($averageRating))
                        <i class="fas fa-star checked" style="color: #FFD700; font-size: 20px;"></i>
                    @else
                        <i class="fas fa-star" style="color: #ddd; font-size: 20px;"></i>
                    @endif
                @endfor
            </div>
            <p class="average-text" style="color: #666; margin: 0;">
                Trung bình {{ number_format($averageRating, 1) }} sao / 5
            </p>
        </div>

        <div class="price-info" style="margin-bottom: 15px;">
            <span class="current-price" style="font-size: 36px; font-weight: bold; color: #e53935; display: block;">
                {{ number_format($product->price, 0, ',', '.') }} ₫
            </span>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="discount-price" style="color: #888; text-decoration: line-through; font-size: 16px;">
                    {{ number_format($product->original_price, 0, ',', '.') }} ₫
                </span>
                <span style="color: #FF5722; font-weight: 500;">
                    -{{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%
                </span>
            </div>
        </div>
    </div>

    <p class="description" style="margin-bottom: 25px; line-height: 1.8; color: #444; font-size: 18px;">
        <i class="fas fa-info-circle"></i> {{ $product->description }}
    </p>

    <div class="purchase-actions" style="display: flex; align-items: center; gap: 20px;">
        <div class="quantity" style="display: flex; align-items: center;">
            <label for="qty" style="font-weight: 500; color: #444;">
                <i class="fas fa-cubes"></i> Số lượng:
            </label>
            <input type="number" id="qty" class="qty" min="1" max="99" value="1" 
                style="width: 80px; margin-left: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px;">
        </div>

        @if($product->quantity_in_stock > 0)
            <button class="add-to-cart-btn" data-product-id="{{ $product->id }}" style="background-color: #007BFF; color: white; border: none; border-radius: 5px; padding: 12px 30px; cursor: pointer; font-size: 16px; font-weight: 500; transition: all 0.3s; flex-grow: 1;">
                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
            </button>
        @else
            <p class="out-of-stock" style="color: #FF5722; font-weight: bold; margin: 0;">
                <i class="fas fa-exclamation-circle"></i> Xin lỗi, sản phẩm hiện đã hết hàng.
            </p>
        @endif
    </div>
</div>

    </div>

    <!-- Phần dưới - Thông tin dinh dưỡng và thành phần -->
<!-- Phần dưới - Thông tin dinh dưỡng và thành phần -->
<div class="bottom-section" style="max-width: 100%; margin-top: 30px; padding: 0 20px; display: flex; gap: 30px;">
    <!-- Bảng dinh dưỡng -->
    <div class="nutrition-info" style="flex: 1; background-color: #f8f9fa; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="color: #28a745; margin: 0 0 20px 0; font-size: 20px;">
            <i class="fas fa-leaf"></i> Thông tin dinh dưỡng
        </h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 2px solid #dee2e6;">
                <th style="text-align: left; padding: 12px; color: #444; font-weight: 600;">Thành phần</th>
                <th style="text-align: right; padding: 12px; color: #444; font-weight: 600;">Giá trị</th>
                <th style="text-align: right; padding: 12px; color: #444; font-weight: 600;">%RDA*</th>
            </tr>
            <!-- Example dynamic data for nutrition facts -->
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 12px;">Calories</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->calories) }} kcal</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionFact->calories > 800 ? 'red' : ($nutritionFact->calories > 600 ? 'yellow' : 'black') }};">
                    {{ number_format(($nutritionFact->calories / 2000) * 100, 1) }}%
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 12px;">Chất đạm</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->protein) }}g</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionRatio['protein'] > 60 ? 'red' : ($nutritionRatio['protein'] > 40 ? 'yellow' : 'black') }};">
                    {{ number_format($nutritionRatio['protein'], 1) }}%
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 12px;">Chất béo</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->fat) }}g</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionRatio['fat'] > 60 ? 'red' : ($nutritionRatio['fat'] > 40 ? 'yellow' : 'black') }};">
                    {{ number_format($nutritionRatio['fat'], 1) }}%
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 12px;">Carbohydrate</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->carbohydrate) }}g</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionRatio['carbohydrate'] > 60 ? 'red' : ($nutritionRatio['carbohydrate'] > 40 ? 'yellow' : 'black') }};">
                    {{ number_format($nutritionRatio['carbohydrate'], 1) }}%
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #dee2e6;">
                <td style="padding: 12px;">Đường</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->sugar) }}g</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionRatio['sugar'] > 60 ? 'red' : ($nutritionRatio['sugar'] > 40 ? 'yellow' : 'black') }};">
                    {{ number_format($nutritionRatio['sugar'], 1) }}%
                </td>
            </tr>
            <tr>
                <td style="padding: 12px;">Chất xơ</td>
                <td style="text-align: right; padding: 12px;">{{ number_format($nutritionFact->fiber) }}g</td>
                <td style="text-align: right; padding: 12px; color: {{ $nutritionRatio['fiber'] > 60 ? 'red' : ($nutritionRatio['fiber'] > 40 ? 'yellow' : 'black') }};">
                    {{ number_format($nutritionRatio['fiber'], 1) }}%
                </td>
            </tr>
        </table>
        <p style="font-size: 13px; color: #666; margin: 15px 0 0 0; font-style: italic;">
            *RDA: Giá trị dinh dưỡng khuyến nghị hàng ngày dựa trên chế độ ăn 2000 calories.
        </p>
    </div>

    <!-- Thành phần nguyên liệu -->
    <div class="ingredients-info" style="flex: 1; background-color: #f1f1f1; padding: 25px; margin-top: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <h3 style="color: #007bff; margin: 0 0 20px 0; font-size: 20px;">
        <i class="fas fa-cogs"></i> Thành phần nguyên liệu
    </h3>

    @if ($ingredients->isEmpty()) 
        <p>Thành phần chưa được cập nhật.</p>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 2px solid #dee2e6;">
                <th style="text-align: left; padding: 12px; color: #444; font-weight: 600;">Thành phần</th>
                <th style="text-align: left; padding: 12px; color: #444; font-weight: 600;">Số lượng</th>
            </tr>
            @foreach ($ingredients as $ingredient)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">{{ $ingredient->name }}</td>
                    <td style="text-align: left; padding: 12px;">{{ $ingredient->pivot->quantity }} {{ $ingredient->unit }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

</div>


</div>






    <!-- Sản phẩm liên quan -->
    <div class="related-products" style="width: 20%; padding-left: 20px; max-height: 600px; overflow-y: auto;">
        <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Sản phẩm liên quan</h3>
        @foreach ($relatedProducts as $relatedProduct)
            <div class="related-product-item" style="margin-bottom: 25px; display: flex; align-items: flex-start; gap: 15px; border-bottom: 1px solid #ddd; padding-bottom: 15px;">
                <img src="{{ asset('images/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                <div class="product-info">
                    <h4 style="font-size: 14px; font-weight: bold; margin: 0; color: #333;">{{ $relatedProduct->name }}</h4>
                    <p style="color: #888; margin: 5px 0;">{{ number_format($relatedProduct->price, 0, ',', '.') }} ₫</p>
                    <a href="{{ url('quick_view/' . $relatedProduct->id) }}" style="text-decoration: none; color: #007BFF; font-size: 14px; font-weight: bold;">Xem chi tiết</a>
                </div>
            </div>
        @endforeach
    </div>
</div>



<section class="review">
    <h1 class="review-title">Đánh giá sản phẩm</h1>

    @auth
    @if (!$hasPurchased)
        <div class="alert alert-warning">
            Bạn cần mua sản phẩm để có thể đánh giá và bình luận.
        </div>
    @elseif ($isBlocked)
        <div class="alert alert-warning">
            Bạn đã bị khóa comment cho sản phẩm này.
        </div>
    @else
        <!-- Rating Stars -->
        <div class="star-rating">
            <i class="fas fa-star" data-value="1"></i>
            <i class="fas fa-star" data-value="2"></i>
            <i class="fas fa-star" data-value="3"></i>
            <i class="fas fa-star" data-value="4"></i>
            <i class="fas fa-star" data-value="5"></i>
        </div>

        <!-- Comment Box -->
        <div class="comment-box">
            <textarea id="userComment" placeholder="Viết đánh giá của bạn..." rows="4"></textarea>
            <button id="submitReview" class="btn">Gửi đánh giá</button>
        </div>
    @endif
@else
    <p class="login-prompt">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.</p>
@endauth



    <!-- All Reviews -->
    <div class="all-reviews"> 
    <h2>Mọi người đánh giá</h2>

<!-- Nút Xem các bình luận -->
<button id="toggle-comments-btn" class="toggle-comments-btn">Ẩn các bình luận</button>

<!-- Phần chứa tất cả các bình luận, mặc định là ẩn -->
<div id="all-comments" ">
    @foreach ($comments as $comment)
        <div class="review-card">
            <img src="{{ asset($comment->user->avatar ?? 'images/user-default.png') }}" alt="User Image" class="user-image">

            <div class="review-info">
                <p class="user-name">{{ $comment->user->name }}</p>
                <p class="user-date">{{ $comment->created_at->format('d/m/Y - H:i:s') }}</p>

                <div class="star-rating static">
                    @for ($i = 1; $i <= 5; $i++)
                        @if($i <= $comment->star_rating)
                            <i class="fas fa-star checked"></i>
                        @else
                            <i class="fas fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="report-menu">
                        <span class="report-btn">⋮</span>
                        <div class="report-options" style="display: none;">
                            <p class="report-option" data-reason="Không phù hợp">Không phù hợp</p>
                            <p class="report-option" data-reason="Ngôn từ thô tục">Ngôn từ thô tục</p>
                            <p class="report-option" data-reason="Quảng cáo">Quảng cáo</p>
                        </div>
                    </div>

                <p class="user-comment">{{ $comment->content ?? 'Chưa có bình luận.' }}</p>

                <!-- Hiển thị số lượng Like và Dislike -->
                <div class="like-dislike">
                    <button class="like-btn" data-comment-id="{{ $comment->id }}">👍 Like <span class="like-count">{{ $comment->likes }}</span></button>
                    <button class="dislike-btn" data-comment-id="{{ $comment->id }}">👎 Dislike <span class="dislike-count">{{ $comment->dislikes }}</span></button>
                </div>

                <button class="reply-btn" data-comment-id="{{ $comment->id }}">Trả lời</button>

                <!-- Hộp thoại trả lời ẩn ban đầu -->
                <div class="reply-box" id="reply-box-{{ $comment->id }}" style="display:none;">
                    <textarea placeholder="Nhập phản hồi của bạn..." class="reply-text" id="reply-text-{{ $comment->id }}"></textarea>
                    <button class="submit-reply-btn" data-comment-id="{{ $comment->id }}">Gửi phản hồi</button>
                </div>

                <!-- Danh sách các câu trả lời của user -->
                <div class="user-replies" id="replies-{{ $comment->id }}">
                    <!-- Các reply sẽ được load vào đây -->
                    <div class="reply-list" id="reply-list-{{ $comment->id }}">
                        <!-- Các reply sẽ được load vào đây -->
                    </div>
                    <div class="pagination" id="pagination-{{ $comment->id }}">
                        <!-- Các link phân trang sẽ được thêm vào đây -->
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>





    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $comments->links() }}
    </div>
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


</div>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/quickview.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<div class="loader">
   <img src="{{ asset('images/Animation - 1735092558904.gif') }}" alt="">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleCommentsBtn = document.getElementById('toggle-comments-btn');
    const allCommentsDiv = document.getElementById('all-comments');

    toggleCommentsBtn.addEventListener('click', function() {
        // Kiểm tra trạng thái hiển thị của danh sách bình luận
        if (allCommentsDiv.style.display === 'none') {
            // Nếu danh sách đang ẩn, thì hiển thị nó
            allCommentsDiv.style.display = 'block';
            toggleCommentsBtn.textContent = 'Ẩn các bình luận'; // Đổi tên nút
        } else {
            // Nếu danh sách đang hiển thị, thì ẩn nó
            allCommentsDiv.style.display = 'none';
            toggleCommentsBtn.textContent = 'Xem các bình luận'; // Đổi tên nút
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submitReview').addEventListener('click', function(event) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của nút submit

    const content = $('#userComment').val(); // Lấy nội dung bình luận
    const starRating = $('.star-rating .fas.fa-star.checked').length; // Đếm số sao đã chọn

    // Kiểm tra xem người dùng đã chọn số sao hay chưa
    if (starRating === 0) {
        alert('Vui lòng chọn số sao trước khi gửi đánh giá.'); // Thông báo yêu cầu chọn số sao
        return; // Ngừng thực hiện nếu chưa chọn số sao
    }

    // Kiểm tra xem người dùng đã đăng nhập chưa
    let isLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
    let userName = "{{ Auth::user() ? Auth::user()->name : '' }}"; // Lấy tên người dùng nếu đã đăng nhập

    if (!isLoggedIn) {
        alert('Bạn phải đăng nhập để bình luận.'); // Thông báo yêu cầu đăng nhập
        return; // Ngừng thực hiện nếu người dùng chưa đăng nhập
    }

    // Gửi yêu cầu Ajax nếu đã đăng nhập và chọn số sao
    $.ajax({
        type: 'POST',
        url: '{{ route("product.comment", ["product" => $product->id]) }}',
        data: {
            content: content,
            star_rating: starRating,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
    if (response.status === 'success') {
        alert(response.message); // Thông báo thành công

        // Tạo đối tượng bình luận mới từ phản hồi server
        const newComment = {
            user: { name: response.userName }, // Lấy tên người dùng từ phản hồi
            content: response.content,
            star_rating: response.star_rating,
            created_at: response.created_at // Dữ liệu chính xác từ server
        };

        // Thêm bình luận mới vào giao diện
        $('#commentsContainer').prepend(`
            <div class="comment">
                <strong>${newComment.user.name}</strong>
                <p>${newComment.content}</p>
                <p class="star-rating">${renderStars(newComment.star_rating)}</p>
                <p class="comment-date">${new Date(newComment.created_at).toLocaleString()}</p>
            </div>
        `);

        // Reset nội dung bình luận và số sao
        $('#userComment').val(''); 
        $('.star-rating .fas.fa-star').removeClass('checked'); 
    } else {
        alert('Không thể thêm bình luận.'); // Thông báo nếu không thành công
    }
},

       
    });
});


    function renderStars(starRating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += i <= starRating ? '<i class="fas fa-star checked"></i>' : '<i class="fas fa-star"></i>';
        }
        return starsHtml;
    }

    function loadComments() {
    $.ajax({
        type: 'GET',
        url: '{{ route("product.comments", ["product" => $product->id]) }}',
        success: function(data) {
            console.log(data); // Kiểm tra dữ liệu trả về
            if (data.status === 'success') { // Kiểm tra trạng thái trả về
                $('#commentsContainer').html(''); // Xóa nội dung cũ
                data.comments.forEach(function(comment) { // Sử dụng data.comments để duyệt qua các bình luận
                    $('#commentsContainer').append(`
                        <div class="comment">
                            <strong>${comment.user.name}</strong>
                            <p>${comment.content}</p>
                            <p class="star-rating">${renderStars(comment.star_rating)}</p>
                            <p class="comment-date">${new Date(comment.created_at).toLocaleString()}</p>
                        </div>
                    `);
                });
            } else {
                alert('Có lỗi khi tải bình luận.'); // Thông báo lỗi
            }
        },
        error: function() {
            alert('Có lỗi khi tải bình luận.');
        }
    });
}


    document.querySelectorAll('.user-replies').forEach(function(repliesContainer) {
        const commentId = repliesContainer.id.split('-')[1];
        loadReplies(commentId, 1);
    });

    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const replyBox = document.getElementById(`reply-box-${commentId}`);
            replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.submit-reply-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const replyContent = document.getElementById(`reply-text-${commentId}`).value;

            $.ajax({
                url: `http://localhost/web_ban_banh_kem/public/comments/${commentId}/replies`,
                method: 'POST',
                data: {
                    reply_content: replyContent,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        document.getElementById(`reply-text-${commentId}`).value = '';
                        loadReplies(commentId);
                    } else {
                        alert('Có lỗi khi gửi reply.');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    alert('Có lỗi xảy ra khi gửi reply. Vui lòng thử lại sau.');
                }
            });
        });
    });

    function loadReplies(commentId, page) {
    $.ajax({
        url: `http://localhost/web_ban_banh_kem/public/comments/${commentId}/replies?page=${page}`,
        type: 'GET',
        success: function(data) {
            if (data.status === 'success') {
                let repliesHtml = '';
                
                data.replies.data.forEach(reply => {
                    // Kiểm tra nếu reply là của admin
                    const isAdmin = reply.is_admin ? 'Admin: ' : ''; 
                    const replyClass = reply.is_admin ? 'admin-reply' : ''; // Class đặc biệt cho admin
                    
                    // Lấy avatar và tên người dùng từ dữ liệu phản hồi
                    const userAvatar = reply.avatar ? `http://localhost/web_ban_banh_kem/public/${reply.avatar}` : 'http://localhost/web_ban_banh_kem/public/images/user-default.png';
                    const userName = reply.name;

                    repliesHtml += `
                        <div class="user-reply ${replyClass}">
                            <div class="user-info">
                                <img src="${userAvatar}" alt="${userName}" class="user-avatar" />
                                <strong class="user-name">${isAdmin}${userName}</strong>
                            </div>
                            <p class="reply-content">${reply.reply}</p>
                            <p class="reply-date">${new Date(reply.updated_at).toLocaleString()}</p>
                        </div>
                    `;
                });

                const replyList = document.getElementById(`reply-list-${commentId}`);
                replyList.innerHTML = repliesHtml;

                // Xử lý phân trang
                const pagination = document.getElementById(`pagination-${commentId}`);
                pagination.innerHTML = '';
                for (let i = 1; i <= data.replies.last_page; i++) {
                    pagination.innerHTML += `<a href="#" class="pagination-link" data-comment-id="${commentId}" data-page="${i}">${i}</a> `;
                }

                document.querySelectorAll(`.pagination-link[data-comment-id="${commentId}"]`).forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.dataset.page;
                        loadReplies(commentId, page);
                    });
                });
            } else {
                alert('Không thể tải replies.');
            }
        },
        error: function() {
            alert('Lỗi khi load replies');
        }
    });
}

});

   document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating i');
    let selectedRating = 0;

    // Add click event to stars
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            if (value === selectedRating) {
                // Deselect star
                selectedRating = 0;
                stars.forEach(s => s.classList.remove('checked'));
            } else {
                // Select stars up to the clicked one
                selectedRating = value;
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-value')) <= value) {
                        s.classList.add('checked');
                    } else {
                        s.classList.remove('checked');
                    }
                });
            }
        });
    });

    // Handle comment submission (just for demo, would need backend integration)
    document.getElementById('submitReview').addEventListener('click', function() {
        const comment = document.getElementById('userComment').value;
        if (selectedRating === 0) {
            alert('Vui lòng chọn số sao trước khi gửi đánh giá.');
            return;
        }

       

        alert(`Cảm ơn bạn đã gửi đánh giá ${selectedRating} sao!`);
    });
});


    function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('form');
            if (form) {
                const qtyInput = form.querySelector('.qty');
                if (qtyInput && qtyInput.value >= 1) {
                    form.submit(); // Submit the form if quantity is valid
                } else {
                    alert('Vui lòng nhập số lượng hợp lệ.');
                }
            }
        });
    }
   
    $('.add-to-cart-btn').click(function(e) {
    e.preventDefault();

    var productId = $(this).data('product-id'); // Lấy product_id từ data attribute
    var qty = $('#qty').val();

    console.log('Product ID:', productId);
    console.log('Quantity:', qty);

    $.ajax({
        url: '{{ route("add.to.cart") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId,
            qty: qty
        },
        beforeSend: function() {
            console.log('Form Data Sent:', {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                qty: qty
            });
        },
        success: function(response) {
            console.log('Response:', response);
            addToCart();
        },
        error: function(xhr) {
            console.error('Error Response:', xhr);
            alert('Có lỗi xảy ra, vui lòng thử lại.');
        }
    });
});


    // Ẩn menu khi nhấp ra ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.report-menu').length) {
            $('.report-options').hide();
        }
    });
    $('.like-btn').click(function() {
    let commentId = $(this).data('comment-id');
    let reviewCard = $(this).closest('.review-card'); // Tìm phần tử cha review-card

    // Kiểm tra trạng thái like và dislike
    let isLiked = reviewCard.find('.like-btn').hasClass('active');
    let isDisliked = reviewCard.find('.dislike-btn').hasClass('active');

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!"{{ Auth::check() }}") {
        alert('Vui lòng đăng nhập để thực hiện hành động này.');
        return;
    }

    if (isLiked) {
        // Nếu đã like, không làm gì thêm
        return;
    }

    // Nếu đang dislike, chuyển về 0
    if (isDisliked) {
        reviewCard.find('.dislike-btn').removeClass('active'); // Xóa active class
        reviewCard.find('.dislike-count').text(parseInt(reviewCard.find('.dislike-count').text()) - 1); // Giảm số lượng dislike
    }

    $.ajax({
        url: '{{ route("comments.like") }}',
        method: 'POST',
        data: {
            comment_id: commentId,
            _token: '{{ csrf_token() }}' // Token CSRF
        },
        success: function(response) {
            // Cập nhật số lượng like
            reviewCard.find('.like-count').text(response.likes);
            reviewCard.find('.dislike-count').text(response.dislikes);
            reviewCard.find('.like-btn').addClass('active'); // Thêm active class
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
});

$('.dislike-btn').click(function() {
    let commentId = $(this).data('comment-id');
    let reviewCard = $(this).closest('.review-card'); // Tìm phần tử cha review-card

    // Kiểm tra trạng thái like và dislike
    let isLiked = reviewCard.find('.like-btn').hasClass('active');
    let isDisliked = reviewCard.find('.dislike-btn').hasClass('active');

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!"{{ Auth::check() }}") {
        alert('Vui lòng đăng nhập để thực hiện hành động này.');
        return;
    }

    if (isDisliked) {
        // Nếu đã dislike, không làm gì thêm
        return;
    }

    // Nếu đang liked, chuyển về 0
    if (isLiked) {
        reviewCard.find('.like-btn').removeClass('active'); // Xóa active class
        reviewCard.find('.like-count').text(parseInt(reviewCard.find('.like-count').text()) - 1); // Giảm số lượng like
    }

    $.ajax({
        url: '{{ route("comments.dislike") }}',
        method: 'POST',
        data: {
            comment_id: commentId,
            _token: '{{ csrf_token() }}' // Token CSRF
        },
        success: function(response) {
            // Cập nhật số lượng dislike
            reviewCard.find('.like-count').text(response.likes);
            reviewCard.find('.dislike-count').text(response.dislikes);
            reviewCard.find('.dislike-btn').addClass('active'); // Thêm active class
        },
        error: function(xhr) {
            console.error(xhr);
        }
    });
});

});
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện click trên mỗi nút báo cáo (sử dụng jQuery)
    $('.report-btn').on('click', function() {
        $(this).siblings('.report-options').toggle(); // Hiển thị/ẩn menu báo cáo
    });

    // Lắng nghe sự kiện click vào các tùy chọn báo cáo (sử dụng jQuery)
    $('.report-option').on('click', function() {
        const reason = $(this).data('reason');
        const commentId = $(this).closest('.review-card').find('.like-btn').data('comment-id');
        const userId = '{{ auth()->id() }}'; // Lấy user_id của người dùng đã đăng nhập

        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!userId) {
            alert('Vui lòng đăng nhập để báo cáo!');
            return; // Dừng việc gửi báo cáo nếu chưa đăng nhập
        }

        // Kiểm tra nếu lý do báo cáo không hợp lệ
        if (!reason || reason.trim() === '') {
            alert('Vui lòng chọn lý do báo cáo!');
            return; // Dừng việc gửi báo cáo nếu không có lý do
        }

        // Kiểm tra nếu commentId không hợp lệ
        if (!commentId || commentId.toString().trim() === '') {
            alert('Có lỗi xảy ra, không tìm thấy bình luận để báo cáo!');
            return; // Dừng việc gửi báo cáo nếu không có commentId
        }

        // Kiểm tra nếu userId không hợp lệ
        if (!userId || userId.trim() === '') {
            alert('Có lỗi xảy ra, không tìm thấy người dùng để báo cáo!');
            return; // Dừng việc gửi báo cáo nếu không có userId
        }

        // In ra console các dữ liệu để kiểm tra
        console.log('User ID:', userId);
        console.log('Report reason:', reason);
        console.log('Comment ID:', commentId);
        console.log('Data prepared for submission:', {
            user_id: userId,
            report_type: 'comment',
            content: reason,
            reportable_id: commentId,
            admin_check: 0
        });

        // Gửi dữ liệu báo cáo lên server
        fetch('{{ route("report.comment") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',  // CSRF Token của Laravel
            },
            body: JSON.stringify({
                user_id: userId,
                report_type: 'comment',  // Loại báo cáo là comment
                content: reason,  // Nội dung báo cáo
                reportable_id: commentId,  // ID của comment cần báo cáo
                admin_check: 0,  // Mặc định là chưa kiểm tra
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Báo cáo đã được gửi thành công!');
            } else {
                alert('Có lỗi xảy ra khi gửi báo cáo.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi gửi báo cáo.');
        });

        // Ẩn menu báo cáo sau khi chọn
        $(this).parent().hide();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const speakButton = document.getElementById('speak-button');
    const speakerIcon = document.getElementById('speaker-icon');
    const productName = "{{ $product->name }}";
    const productDescription = "{{ $product->description }}";
    const productPrice = "{{ number_format($product->price, 0, ',', '.') }} ₫";
    const saleOff = "{{ rtrim(rtrim(number_format($product->discount, 2), '0'), '.') }}%";
    
    // Lấy các giá trị dinh dưỡng và tính toán % RDA
    const calories = {{ number_format($nutritionFact->calories) }};
    const protein = {{ number_format($nutritionFact->protein) }};
    const fat = {{ number_format($nutritionFact->fat) }};
    const carbohydrate = {{ number_format($nutritionFact->carbohydrate) }};
    const sugar = {{ number_format($nutritionFact->sugar) }};
    const fiber = {{ number_format($nutritionFact->fiber) }};
    
    const caloriePercentage = (calories / 2000) * 100;
    const proteinPercentage = {{ number_format($nutritionRatio['protein'], 1) }};
    const fatPercentage = {{ number_format($nutritionRatio['fat'], 1) }};
    const carbohydratePercentage = {{ number_format($nutritionRatio['carbohydrate'], 1) }};
    const sugarPercentage = {{ number_format($nutritionRatio['sugar'], 1) }};
    const fiberPercentage = {{ number_format($nutritionRatio['fiber'], 1) }};
    
    // Tạo nội dung cho phần đọc
    let healthAdvice = "";
    
    // Kiểm tra nếu các chỉ số vượt ngưỡng và thêm lời khuyên
    if (caloriePercentage > 60) {
        healthAdvice += "Chú ý: Sản phẩm này có năng lượng cao, có thể gây tăng cân. Nếu bạn có vấn đề về cân nặng hoặc tiểu đường, hãy tham khảo ý kiến bác sĩ.\n";
    }
    if (proteinPercentage > 60) {
        healthAdvice += "Chú ý: Sản phẩm này chứa nhiều protein, nên thận trọng nếu bạn có vấn đề về thận.\n";
    }
    if (fatPercentage > 60) {
        healthAdvice += "Chú ý: Chất béo trong sản phẩm này khá cao, có thể ảnh hưởng đến người bị bệnh tim mạch hoặc cholesterol cao.\n";
    }
    if (carbohydratePercentage > 60) {
        healthAdvice += "Chú ý: Lượng carbohydrate cao, có thể không phù hợp cho người bị tiểu đường hoặc béo phì.\n";
    }
    if (sugarPercentage > 60) {
        healthAdvice += "Chú ý: Lượng đường cao, có thể ảnh hưởng đến người mắc bệnh tiểu đường hoặc có vấn đề về chuyển hóa đường.\n";
    }
    if (fiberPercentage < 2) {
        healthAdvice += "Chú ý: Chất xơ trong sản phẩm thấp. Bạn nên bổ sung thêm chất xơ từ rau củ và trái cây.\n";
    }

    const speechContent = `Tên sản phẩm: ${productName}. Mô tả: ${productDescription}. Giá hiện tại: ${productPrice}. Giảm giá: ${saleOff}. ${healthAdvice}`;

    let isSpeaking = false;
    const synth = window.speechSynthesis;

    speakButton.addEventListener('click', function () {
        if (isSpeaking) {
            synth.cancel(); // Dừng nói
            isSpeaking = false;
            speakerIcon.classList.remove('fa-volume-mute');
            speakerIcon.classList.add('fa-volume-up');
        } else {
            const utterance = new SpeechSynthesisUtterance(speechContent);
            utterance.lang = 'vi-VN'; // Tiếng Việt
            synth.speak(utterance);
            isSpeaking = true;
            speakerIcon.classList.remove('fa-volume-up');
            speakerIcon.classList.add('fa-volume-mute');

            // Dừng chế độ nói khi đọc xong
            utterance.onend = function () {
                isSpeaking = false;
                speakerIcon.classList.remove('fa-volume-mute');
                speakerIcon.classList.add('fa-volume-up');
            };
        }
    });
});
function addToCart() {
    // Lấy button và vị trí của nó
    const button = document.querySelector('.add-to-cart-btn'); // Lấy nút có class là .add-to-cart-btn
    const buttonRect = button.getBoundingClientRect();
    const startX = buttonRect.left + buttonRect.width / 2;
    const startY = buttonRect.top + buttonRect.height / 2;
    
    // Lấy vị trí giỏ hàng
    const cart = document.querySelector('.cart-icon');
    const cartRect = cart.getBoundingClientRect();
    const endX = cartRect.left + cartRect.width / 2;
    const endY = cartRect.top + cartRect.height / 2;
    
    // Lấy số lượng từ input
    const quantityInput = document.querySelector('#qty'); // Lấy giá trị từ input #qty
    const quantity = parseInt(quantityInput.value, 10) || 1; // Nếu không có giá trị, mặc định là 1
    
    // Tạo hình ảnh bay
    const flyingImage = document.createElement('img');
    flyingImage.src = 'http://localhost/web_ban_banh_kem/public/images/cat-2.png'; // Sử dụng ảnh mặc định hoặc lấy từ dữ liệu sản phẩm
    flyingImage.classList.add('fly-item');
    flyingImage.style.left = `${startX}px`;
    flyingImage.style.top = `${startY}px`;
    document.body.appendChild(flyingImage);
    
    // Bắt đầu hoạt ảnh bay
    setTimeout(() => {
        flyingImage.style.left = `${endX}px`;
        flyingImage.style.top = `${endY}px`;
        flyingImage.style.transform = 'scale(0.1)';
        flyingImage.style.opacity = '0.7';
    }, 10);
    
    // Cập nhật số lượng sau khi hoàn thành hoạt ảnh
    setTimeout(() => {
        // Xóa hình ảnh bay
        flyingImage.remove();
        
        // Lấy số lượng hiện tại và tăng thêm số lượng từ input
        const counter = document.querySelector('.counter-number');
        let currentCount = parseInt(counter.dataset.count, 10) || 0;
        currentCount += quantity; // Thêm số lượng từ input vào giỏ hàng
        counter.dataset.count = currentCount;
        counter.textContent = currentCount;
        counter.classList.add('counter-animate');
        
        // Lắc giỏ hàng
        const cartIcon = document.querySelector('.cart-icon');
        cartIcon.classList.add('cart-shake');
        
        // Xóa hoạt ảnh sau khi hoàn thành
        setTimeout(() => {
            counter.classList.remove('counter-animate');
            cartIcon.classList.remove('cart-shake');
        }, 300);
    }, 800);
}


</script>
</body>
</html>
