<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   <link rel="stylesheet" href="{{ asset('css/home.css') }}">
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    <title>Blog Travel và Astronomy</title>
    <style>
        :root {
   --yellow: #fed330;
   --red: #e74c3c;
   --white: #fff;
   --black: #222;
   --light-color: #777;
   --border: .2rem solid var(--black);
}
.delete-btn,
.btn {
   display: inline-block;
   margin-top: 1rem;
   padding: 1.3rem 3rem;
   cursor: pointer;
   font-size: 2rem;
   text-transform: capitalize;
}

.delete-btn {
   background-color: var(--red);
   color: var(--white);
}

.btn {
   background-color: var(--yellow);
   color: var(--black);
}

.delete-btn:hover,
.btn:hover {
   letter-spacing: .2rem;
}
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .nav a {
            margin-right: 10px;
            text-decoration: none;
            color: #333;
        }
        .search-bar {
            padding: 5px;
            width: 200px;
        }
        .blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 columns */
    gap: 20px; /* Space between the posts */
    margin-top: 20px;
}

.blog-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.2s;
}

.blog-card:hover {
    transform: scale(1.05); /* Slight zoom on hover */
}

.blog-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.blog-content {
    padding: 15px;
}

.blog-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.blog-excerpt {
    color: #666;
    margin-bottom: 15px;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #999;
}

.blog-tags {
    display: flex;
    gap: 10px;
}

.blog-tag {
    background-color: #f2f2f2;
    padding: 5px 10px;
    border-radius: 5px;
}

.read-more {
    display: inline-block;
    margin-top: 10
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
.quantity-selector {
    display: flex;
    align-items: center;
}
.search-container {
    position: relative;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    max-height: 300px;
    overflow-y: auto;
    z-index: 999;
}

.search-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.search-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin-right: 10px;
}

.search-item-details {
    flex: 1;
}

.search-item-details p {
    margin: 0;
    font-size: 14px;
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
/* Heading Section */
.heading {
    text-align: center;
    padding: 3rem 0;
    background: linear-gradient(to right, #f6f8fd, #f1f4f9);
    margin-bottom: 2rem;
}

.heading h3 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.heading p {
    color: #7f8c8d;
    font-size: 1rem;
}

.heading a {
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s ease;
}

.heading a:hover {
    color: #2980b9;
}

.heading span {
    color: #95a5a6;
}

/* Header Section */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    margin-bottom: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.nav {
    display: flex;
    gap: 1.5rem;
}

.nav a {
    text-decoration: none;
    color: #34495e;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.nav a:hover {
    background: #3498db;
    color: white;
}

.search-bar {
    padding: 0.8rem 1.5rem;
    border: 2px solid #eee;
    border-radius: 25px;
    width: 300px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.search-bar:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.1);
}

/* Blog Grid */
.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2.5rem;
    padding: 0 2rem;
}

.blog-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
}

.blog-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.blog-card:hover .blog-image {
    transform: scale(1.05);
}

.blog-content {
    padding: 1.5rem;
}

.blog-title {
    font-size: 1.4rem;
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.blog-excerpt {
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    color: #95a5a6;
    font-size: 0.9rem;
}

.blog-tag {
    background: #e3f2fd;
    color: #3498db;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.read-more {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.blog-icons {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.blog-icons .icon {
    display: flex;
    align-items: center;
    font-size: 1rem;
    color: #95a5a6;
}

.blog-icons .icon i {
    margin-right: 0.3rem;
    font-size: 1.2rem; /* Kích thước icon */
}

.blog-icons .count {
    font-size: 0.9rem; /* Kích thước chữ */
    color: #7f8c8d;
}

.read-more:hover {
    background: #2980b9;
    transform: translateX(5px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .search-bar {
        width: 100%;
    }

    .blog-grid {
        grid-template-columns: 1fr;
        padding: 0 1rem;
    }

    .heading h3 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .nav {
        flex-wrap: wrap;
        justify-content: center;
    }

    .blog-meta {
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
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
<div class="heading">
   <h3>Các Bài Viết</h3>
   <p><a href="{{ url('/') }}">home </a> <span> / post</span></p>
</div>
    <div class="header">
        <div class="nav">
            <a href="#">All</a>
            <a href="#">Travel</a>
            <a href="#">Astronomy</a>
        </div>
        <input type="text" class="search-bar" placeholder="Search...">
    </div>

    <div class="blog-grid"> 
    @foreach($posts as $post)
        <div class="blog-card">
            <a href="{{ route('post_detail', ['id' => $post->id]) }}">
                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="blog-image">
            </a>
            <div class="blog-content">
                <div class="blog-title">{{ $post->title }}</div>
                <div class="blog-excerpt">{{ Str::limit($post->description, 150) }}</div>
                <div class="blog-meta">
                    <div class="blog-icons">
                        <span class="icon">
                            <i class="fas fa-eye"></i> <!-- Icon lượt xem -->
                            <span class="count">{{ $post->views }}</span>
                        </span>
                        <span class="icon">
                            <i class="fas fa-comment"></i> <!-- Icon bình luận -->
                            <span class="count">{{ $post->comments_count }}</span> <!-- Số bình luận -->
                        </span>
                    </div>
                    <div>{{ $post->created_at->format('M d, Y') }}</div>
                </div>
                <a href="{{ route('post_detail', ['id' => $post->id]) }}" class="read-more">Read More</a>
            </div>
        </div>
    @endforeach
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
<div class="snowflakes" aria-hidden="true"></div>
<script src="http://localhost/web_ban_banh_kem/public/js/script.js"></script>
<script>const numberOfSnowflakes = 100;

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
}</script>
</body>
</html>