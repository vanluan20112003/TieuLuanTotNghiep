<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giới Thiệu - LuanHospital</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
      <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/home.css') }}">
   <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
   <link rel="stylesheet" href="{{ asset('css/bell.css') }}">
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>
   <link rel="stylesheet" href="{{ asset('css/speech.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap');

        :root {
            --primary: #005f73;
            --secondary: #0a9396;
            --accent: #ee9b00;
            --light: #e9ecef;
            --dark: #001219;
            --gradient: linear-gradient(120deg, #005f73, #0a9396);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
        }

        .hero {
            min-height: 100vh;
            background: var(--gradient);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px;
            color: white;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path fill="%23ffffff20" d="M43.2,-68.1C57.9,-61.8,73,-52.9,80.1,-39.7C87.2,-26.4,86.4,-8.8,83.1,7.4C79.8,23.6,74,38.4,64.1,49.9C54.1,61.3,40.1,69.4,25.2,73.7C10.3,78,-5.4,78.5,-19.6,73.8C-33.8,69.2,-46.5,59.4,-56.8,47.3C-67.1,35.2,-75,20.8,-77.7,5C-80.4,-10.8,-77.9,-28,-69.2,-41.2C-60.5,-54.4,-45.6,-63.6,-31.1,-70.1C-16.6,-76.7,-2.5,-80.6,8.8,-75.8C20,-71,28.5,-74.5,43.2,-68.1Z" transform="translate(100 100)"/></svg>') no-repeat center;
            opacity: 0.1;
            animation: rotate 60s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4em;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        .statistics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding: 50px 5%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-top: 50px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
            height: 50px;
            width: 1px;
            background: #ddd;
        }

        .stat-item h3 {
            font-size: 2.5em;
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .departments {
            padding: 100px 5%;
            background: var(--light);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 50px;
            color: var(--primary);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--accent);
        }

        .department-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .department-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .department-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .department-card:hover::before {
            transform: scaleX(1);
        }

        .department-card i {
            font-size: 2.5em;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .schedule-section {
            padding: 100px 5%;
            background: white;
            position: relative;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .schedule-card {
            background: var(--light);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .schedule-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .schedule-card i {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8em;
            opacity: 0.1;
            color: var(--primary);
            transition: all 0.3s ease;
        }

        .schedule-card:hover i {
            transform: scale(1.2);
        }

        .contact-section {
            padding: 100px 5%;
            background: var(--gradient);
            color: white;
            position: relative;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .contact-info {
            text-align: center;
            padding: 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.2);
        }

        .contact-info i {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .map {
            margin-top: 50px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .statistics {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stat-item:nth-child(2)::after {
                display: none;
            }
            
            .hero h1 {
                font-size: 3em;
            }
        }

        @media (max-width: 480px) {
            .statistics {
                grid-template-columns: 1fr;
            }
            
            .stat-item::after {
                display: none;
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
.hero {
    min-height: 100vh;
    background: var(--gradient);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 100px 20px;
    overflow: hidden;
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 800px;
}

/* Thêm màu trắng cho tất cả text trong hero section */
.hero, 
.hero p,
.hero h1,
.hero .statistics,
.hero .stat-item p,
.hero .stat-item h3 {
    color: white;
}

/* Tăng độ tương phản cho text */
.hero p {
    font-size: 1.2em;
    margin-bottom: 30px;
    animation: fadeInUp 1s ease 0.2s backwards;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}

/* Điều chỉnh statistics để nổi bật hơn */
.statistics {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-item p {
    font-weight: 500;
    opacity: 0.9;
}

.stat-item h3 {
    font-weight: 700;
}

/* Thêm hover effect cho stat items */
.stat-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transition: background 0.3s ease;
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
    </style>
</head>
<body>
<div class="snowflakes" aria-hidden="true"></div>
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
    <section class="hero">
        <div class="hero-content">
            <h1>LuanHospital</h1>
            <p>Chăm sóc sức khỏe tận tâm - Nâng tầm cuộc sống</p>
            
            <div class="statistics">
                <div class="stat-item">
                    <h3>15+</h3>
                    <p>Năm Kinh Nghiệm</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Bác Sĩ Chuyên Khoa</p>
                </div>
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Bệnh Nhân/Ngày</p>
                </div>
                <div class="stat-item">
                    <h3>98%</h3>
                    <p>Khách Hàng Hài Lòng</p>
                </div>
            </div>
        </div>
    </section>

    <section class="departments">
        <h2 class="section-title">Các Khoa Phòng</h2>
        <div class="department-grid">
            <div class="department-card">
                <i class="fas fa-heartbeat"></i>
                <h3>Khoa Tim Mạch</h3>
                <p>Chẩn đoán và điều trị các bệnh lý tim mạch với công nghệ hiện đại nhất</p>
            </div>
            <div class="department-card">
                <i class="fas fa-brain"></i>
                <h3>Khoa Thần Kinh</h3>
                <p>Điều trị các bệnh lý về não và hệ thần kinh bởi đội ngũ chuyên gia hàng đầu</p>
            </div>
            <div class="department-card">
                <i class="fas fa-baby"></i>
                <h3>Khoa Sản - Nhi</h3>
                <p>Chăm sóc toàn diện cho mẹ và bé với dịch vụ cao cấp</p>
            </div>
            <div class="department-card">
                <i class="fas fa-bone"></i>
                <h3>Khoa Chấn Thương</h3>
                <p>Điều trị các ca chấn thương, phẫu thuật với kỹ thuật tiên tiến</p>
            </div>
        </div>
    </section>

    <section class="schedule-section">
        <h2 class="section-title">Lịch Làm Việc</h2>
        <div class="schedule-grid">
            <div class="schedule-card">
                <i class="fas fa-clock"></i>
                <h3>Giờ Làm Việc</h3>
                <p>Thứ 2 - Thứ 6: 7:00 - 20:00</p>
                <p>Thứ 7 - Chủ Nhật: 7:00 - 17:00</p>
            </div>
            <div class="schedule-card">
                <i class="fas fa-ambulance"></i>
                <h3>Cấp Cứu 24/7</h3>
                <p>Đội ngũ cấp cứu chuyên nghiệp</p>
                <p>Sẵn sàng phục vụ mọi lúc</p>
            </div>
            <div class="schedule-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Đặt Lịch Khám</h3>
                <p>Đặt lịch trực tuyến 24/7</p>
                <p>Tổng đài: 1900 xxxx</p>
            </div>
        </div>
    </section>

    <section class="contact-section">
        <h2 class="section-title" style="color: white;">Liên Hệ</h2>
        <div class="contact-grid">
            <div class="contact-info">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Địa Chỉ</h3>
                <p>123 Đường ABC, Quận XYZ</p>
                <p>TP. Hồ Chí Minh</p>
            </div>
            <div class="contact-info">
                <i class="fas fa-phone-alt"></i>
                <h3>Điện Thoại</h3>
                <p>Tổng đài: 1900 xxxx</p>
                <p>Cấp cứu: 115</p>
            </div>
            <div class="contact-info">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>info@luanhospital.com</p>
                <p>support@luanhospital.com</p>
            </div>
        </div>
        <div class="map" style="display: flex; justify-content: space-between; gap: 10px;">
    <!-- Google Maps -->
    <div style="display: flex; width: 100%; height: 450px;">
    <!-- Google Maps -->
    <iframe 
        src="https://www.youtube.com/embed/eU0A0cy9ABE" 
        style="width: 50%; height: 100%; border: 0;" 
        title="KHAI TRƯƠNG CANTEEN I FAMILY HOSPITAL" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        allowfullscreen>
    </iframe>
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6558196267665!2d106.68001927480469!3d10.760986789386834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b8e6575c3%3A0x48d253bde1931e59!2zxJDhuqFpIEjhu41jIFPGsCBQaOG6oW0gLSAyODAgQW4gRMawxqFuZyBWxrDGoW5n!5e0!3m2!1svi!2s!4v1735094175800!5m2!1svi!2s" 
        style="width: 50%; height: 100%; border: 0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>

    <!-- YouTube Video -->
    
</div>



    </section>
    <script>    const numberOfSnowflakes = 100;

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
</script>
</body>
</html>