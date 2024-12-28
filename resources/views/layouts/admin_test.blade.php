<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
.stat-title {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 2em;
    margin-bottom: 10px;
}

.tooltip {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    font-size: 1em;
    z-index: 10;
}

.stat-card:hover .tooltip {
    display: block;
}

.dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-right: 10px;
    border-radius: 50%;
}

.blue { background-color: #007bff; }
.green { background-color: #28a745; }
.orange { background-color: #fd7e14; }
.red { background-color: #dc3545; }
.yellow { background-color: #ffc107; }
.pink { background-color: #e83e8c; }
.gray { background-color: #6c757d; }
.LightCyan3 { background-color: #7FDBFF; }
 .toggle-button {
    position: fixed;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    z-index: 10;
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 0 4px 4px 0;
    font-size: 16px;
    opacity: 0.3; /* Mờ khi không tương tác */
    transition: opacity 0.3s ease, background-color 0.3s ease;
}

.toggle-button:hover,
.toggle-button:focus {
    opacity: 1; /* Hiện rõ khi di chuột hoặc nhấn */
    background-color: #1d6fa5; /* Thay đổi màu sắc khi tương tác */
}
.sidebar.hidden {
    transform: translateX(-250px);
}
.main-content.full-width {
    margin-left: 0;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #3498db;
        }

        body {
            display: flex;
            background-color: #f5f6fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            color: white;
            padding: 20px;
        }

        .sidebar .logo {
            padding: 10px;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
        }

        .header {
            height: var(--header-height);
            background-color: white;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            position: relative;
            
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .stat-card.blue { border-top: 4px solid #3498db; }
        .stat-card.green { border-top: 4px solid #2ecc71; }
        .stat-card.orange { border-top: 4px solid #f39c12; }
        .stat-card.red { border-top: 4px solid #e74c3c; }
        .stat-card.yellow { border-top: 4px solid #FFFF33; }
        .stat-card.pink { border-top: 4px solid #FFCCFF; }
        .stat-card.gray { border-top: 4px solid #888888; }
        .stat-card.LightCyan3 { border-top: 4px solid #B4CDCD; }




        .stat-value {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .chart-container {
            background: white;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .data-tables {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
        }

        .data-table {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
        }
        a {
    text-decoration: none; /* Bỏ gạch chân mặc định của thẻ <a> */
    color: inherit; /* Kế thừa màu sắc từ phần tử cha */
}

a:hover {
    color: inherit; /* Giữ màu sắc khi hover */
}
.sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            color: white;
            padding: 20px;
            padding: 10px;
    display: flex;
    flex-direction: column;
   
   
        }
        

        .menu-item {
    margin: 10px 0;
    cursor: pointer;
    padding: 10px;
   /* Màu nền menu chính */
    border-radius: 4px;
    position: relative;
}

.menu-item:hover {
    background-color: #505050; /* Màu khi hover */
}
        .sidebar .logo {
            padding: 10px;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }.submenu {
    position: absolute;
    top: 0;
    left: 100%; /* Hiển thị bên phải của sidebar */
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
    display: none; /* Ẩn submenu mặc định */
    z-index: 10;
    width: 200px; /* Độ rộng của submenu */
    padding: 10px 0;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    white-space: nowrap; /* Giữ nội dung không xuống dòng */
}

.submenu-item:hover {
    background-color: #f4f4f4;
}

.trash-button {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 18px;
    cursor: pointer;
    color: #d9534f;
}
.submenu {
    display: none; /* Ẩn submenu mặc định */
    background-color: #1f1f1f; /* Màu tối cho submenu */
    margin-top: 5px;
    padding: 5px 0;
    border-radius: 4px;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover menu chính */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    
    color: #ffffff;
    white-space: nowrap; /* Không xuống dòng */
}

.submenu-item:hover {
    background-color: #505050; /* Màu nền khi hover submenu */
}
/* Submenu Item chính */
.submenu-item {
    position: relative; /* Định vị để submenu con bám theo submenu-item */
    padding: 10px 15px;
    cursor: pointer;
    color: #ffffff;
    background-color: #333;
    white-space: nowrap; /* Không xuống dòng */
    z-index: 100; /* Ưu tiên hiển thị trên các phần tử khác */
}

/* Hover để thay đổi nền */
.submenu-item:hover {
    background-color: #505050; /* Màu nền khi hover */
}

/* Submenu con */
.submenu {
    position: absolute; /* Hiển thị submenu trên các phần tử khác */
   
    left: 0;
    background-color: #444; /* Nền tối */
    color: #fff;
    padding: 10px 0;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Đổ bóng để tạo chiều sâu */
    z-index: 9999; /* Rất cao để đảm bảo luôn trên các phần tử khác */
    display: none; /* Mặc định ẩn */
}

/* Hiển thị submenu khi hover */
.submenu-item:hover .submenu {
    display: block; /* Hiển thị submenu */
}

/* Submenu Item con */
.submenu .submenu-item {
    padding: 10px 15px;
    background-color: transparent;
    color: #fff;
    white-space: nowrap;
    cursor: pointer;
    z-index: 10000; /* Cao hơn để tránh bị che */
}

/* Hover trên submenu con */
.submenu .submenu-item:hover {
    background-color: #505050; /* Đổi màu khi hover submenu con */
}


    </style>
</head>
<body>
@if(session('error'))
<script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('{{ session("error") }}');
        });
    </script>
@endif
<button id="toggle-menu" class="toggle-button">☰</button>
<div class="sidebar">
<a href="http://localhost/web_ban_banh_kem/public/" >

    <div class="logo">Luân Hospital</div>
   </a>
   <a href="http://localhost/web_ban_banh_kem/public/admin/dashboard">
    <div class="menu-item">
        <i class="fas fa-home"></i> Trang Chủ
    </div>
</a>

    <div class="menu-item">
        📝 Quản lý sản phẩm
        <span class="arrow">></span>
        <div class="submenu">
        <a href="http://localhost/web_ban_banh_kem/public/admin_product" ><div class="submenu-item">📦 Quản lý sản phẩm</div></a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/category"><div class="submenu-item">📂 Quản lý danh mục</div></a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/ingredient">
  <div class="submenu-item">
    <i class="fas fa-blender"></i> Quản lý nguyên liệu 
  </div>
</a>
        </div>
    </div>
    <a href="http://localhost/web_ban_banh_kem/public/admin/order">
    <div class="menu-item">
        📦 Quản lý đơn hàng
    </div>
    </a>
    <a href="http://localhost/web_ban_banh_kem/public/admin/finance">
    <div class="menu-item">
        💰 Quản lý tài chính
    </div>
</a>

    <div class="menu-item">
        👤 Quản lý người dùng
        <span class="arrow">></span>
        <div class="submenu">
            <a href="http://localhost/web_ban_banh_kem/public/admin/user">
                <div class="submenu-item">👥 Quản lý user</div>
            </a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/staff">
            <div class="submenu-item">🧑‍💼 Quản lý nhân viên</div>
            </a>
        </div>
    </div>
    
    <div class="menu-item">
        📋 Quản lý kiểm duyệt
        <span class="arrow">></span>
        <div class="submenu">
        <a href="http://localhost/web_ban_banh_kem/public/admin/post">
            <div class="submenu-item">📝 Quản lý bài viết</div>
        </a>
        <a href="http://localhost/web_ban_banh_kem/public/admin/report">
            <div class="submenu-item">🚩 Quản lý báo cáo</div>
            </a>
        </div>
    </div>
    <a href="http://localhost/web_ban_banh_kem/public/admin/discount">
    <div class="menu-item">🎁 Quản lý khuyến mãi</div>
    </a>
    <a href="http://localhost/web_ban_banh_kem/public/admin/datban">
    <div class="menu-item">🍽️ Quản lý đặt bàn</div>
    </a>
    
    <!-- Nút thùng rác ở góc dưới cùng -->
    <a href="http://localhost/web_ban_banh_kem/public/admin/restore">
    <!-- Nút thùng rác ở góc dưới cùng -->
    <div class="trash-button">
        🗑️
    </div>
    </a>
</div>

    <div class="main-content">
    <div class="header">
    <h2>Trang chính</h2>
    <div class="user-info">
        <span id="user_name">Đang tải...</span> <!-- Đặt mặc định là "Đang tải..." -->
        <span id="admin_id">Admin ID: </span> <!-- Đặt mặc định là "Admin ID: " -->
    </div>
</div>

        <div class="stats-container">
    <!-- Tổng doanh thu -->
    <div class="stat-card blue">
        <div class="stat-title">Tổng doanh thu</div>
        <div class="stat-value" id="total-revenue">{{ number_format($totalRevenue) }} VNĐ</div>
        <div class="tooltip" id="tooltip-revenue">
            <p><span class="dot blue"></span> Doanh thu hôm nay: {{ number_format($revenueToday) }} VNĐ</p>
            <p><span class="dot blue"></span> Doanh thu tuần này: {{ number_format($revenueThisWeek) }} VNĐ</p>
            <p><span class="dot blue"></span> Doanh thu tháng này: {{ number_format($revenueThisMonth) }} VNĐ</p>
            <p><span class="dot blue"></span> Doanh thu quý này: {{ number_format($revenueThisQuarter) }} VNĐ</p>
            <p><span class="dot blue"></span> Doanh thu năm nay: {{ number_format($revenueThisYear) }} VNĐ</p>
        </div>
    </div>

    <!-- Tổng số sản phẩm -->
    <div class="stat-card green">
        <div class="stat-title">Tổng số sản phẩm</div>
        <div class="stat-value" id="total-products">{{ $totalProducts }}</div>
        <div class="tooltip" id="tooltip-products">
            <p><span class="dot green"></span> Sản phẩm thêm trong tuần: {{ $productsAddedThisWeek }}</p>
            <p><span class="dot green"></span> Sản phẩm thêm trong tháng: {{ $productsAddedThisMonth }}</p>
            <p><span class="dot green"></span> Sản phẩm thêm trong quý: {{ $productsAddedThisQuarter }}</p>
            <p><span class="dot green"></span> Sản phẩm còn hàng: {{ $productsInStock }}</p>
            <p><span class="dot green"></span> Sản phẩm hết hàng: {{ $productsOutOfStock }}</p>
        </div>
    </div>

    <!-- Tổng số người dùng -->
    <div class="stat-card orange">
        <div class="stat-title">Tổng số người dùng</div>
        <div class="stat-value" id="total-users">{{ $totalUsers }}</div>
        <div class="tooltip" id="tooltip-users">
            <p><span class="dot orange"></span> Đăng ký mới hôm nay: {{ $usersRegisteredToday }}</p>
            <p><span class="dot orange"></span> Đăng ký mới tuần này: {{ $usersRegisteredThisWeek }}</p>
            <p><span class="dot orange"></span> Đăng ký mới tháng này: {{ $usersRegisteredThisMonth }}</p>
            <p><span class="dot orange"></span> Đăng ký mới quý này: {{ $usersRegisteredThisQuarter }}</p>
        </div>
    </div>

    <!-- Tổng số đơn hàng -->
    <div class="stat-card red">
        <div class="stat-title">Tổng số đơn hàng</div>
        <div class="stat-value" id="total-orders">{{ $totalOrders }}</div>
        <div class="tooltip" id="tooltip-orders">
            <p><span class="dot red"></span> Đơn hàng hôm nay: {{ $ordersToday }}</p>
            <p><span class="dot red"></span> Đơn hàng thành công hôm nay: {{ $ordersCompletedToday }}</p>
            <p><span class="dot red"></span> Đơn hàng đã hủy hôm nay: {{ $ordersCancelledToday }}</p>
            <p><span class="dot red"></span> Đơn hàng tuần này: {{ $ordersThisWeek }}</p>
            <p><span class="dot red"></span> Đơn hàng thành công tuần này: {{ $ordersCompletedThisWeek }}</p>
            <p><span class="dot red"></span> Đơn hàng đã hủy tuần này: {{ $ordersCancelledThisWeek }}</p>
            <p><span class="dot red"></span> Đơn hàng tháng này: {{ $ordersThisMonth }}</p>
            <p><span class="dot red"></span> Đơn hàng thành công tháng này: {{ $ordersCompletedThisMonth }}</p>
            <p><span class="dot red"></span> Đơn hàng đã hủy tháng này: {{ $ordersCancelledThisMonth }}</p>
        </div>
    </div>

    <!-- Tổng số bài viết -->
    <div class="stat-card yellow">
        <div class="stat-title">Tổng số bài viết</div>
        <div class="stat-value" id="total-posts">{{ $totalPosts }}</div>
        <div class="tooltip" id="tooltip-posts">
            <p><span class="dot yellow"></span> Bài viết thêm trong tuần: {{ $postsAddedThisWeek }}</p>
            <p><span class="dot yellow"></span> Bài viết thêm trong tháng: {{ $postsAddedThisMonth }}</p>
        </div>
    </div>

    <!-- Tỉ lệ mở thẻ đa năng -->
    <div class="stat-card pink">
        <div class="stat-title">Tỉ lệ mở thẻ đa năng</div>
        <div class="stat-value" id="spin-rate">{{ $spinRate }}%</div>
        <div class="tooltip" id="tooltip-spin-rate">
            <p><span class="dot pink"></span> Số lượng người đã mở thẻ đa năng: {{ $usersWithCards }}</p>
        </div>
    </div>

    <!-- Tổng số mã giảm giá -->
    <div class="stat-card gray">
        <div class="stat-title">Tổng số mã giảm giá</div>
        <div class="stat-value" id="total-discounts">{{ $totalDiscounts }}</div>
        <div class="tooltip" id="tooltip-discounts">
            <p><span class="dot gray"></span> Mã giảm giá purchase discount: {{ $purchaseDiscounts }}</p>
            <p><span class="dot gray"></span> Mã giảm giá special discount: {{ $specialDiscounts }}</p>
            <p><span class="dot gray"></span> Mã giảm giá event discount: {{ $eventDiscounts }}</p>
        </div>
    </div>

    <!-- Tổng số bàn -->
    <div class="stat-card LightCyan3">
        <div class="stat-title">Tổng số bàn</div>
        <div class="stat-value" id="total-tables">{{ $totalTables }}</div>
        <div class="tooltip" id="tooltip-tables">
            <p><span class="dot LightCyan3"></span> Đặt bàn hôm nay: {{ $ordersTodayTables }}</p>
            <p><span class="dot LightCyan3"></span> Đặt bàn tuần này: {{ $ordersThisWeekTables }}</p>
            <p><span class="dot LightCyan3"></span> Đặt bàn tháng này: {{ $ordersThisMonthTables }}</p>
        </div>
    </div>
</div>





        <div class="chart-container">
            <h3>Thống kê doanh số</h3>
            <canvas id="accessChart"></canvas>
        </div>

        <div class="data-table">
    <h3>Sản phẩm được mua nhiều nhất</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên Sản Phẩm</th>
                <th>Lượt Mua</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px;">

                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity_sold ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="data-table">
    <h3>Người mua nhiều nhất</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên người dùng</th>
                <th>Tổng số tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topBuyers as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ $user->avatar ? asset($user->avatar) : asset('default-avatar.png') }}" alt="{{ $user->name }}" style="width: 50px; height: 50px;">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ number_format($user->total_spent ?? 0, 0, ',', '.') }} ₫</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // Sample data for the chart
       

        document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggle-menu");
    const sidebar = document.querySelector(".sidebar");
    const mainContent = document.querySelector(".main-content");

    toggleButton.addEventListener("click", () => {
        const isHidden = sidebar.classList.toggle("hidden");
        mainContent.classList.toggle("full-width");
        toggleButton.textContent = isHidden ? "☰" : "✕";
    });
    function animateCountUp(elementId, startValue, endValue, duration, multiplier = 1, formatType = '') {
    let startTime = null;
    let start = parseFloat(startValue);
    let end = parseFloat(endValue);
    let current = start;
    let range = end - start;
    let step = range / (duration / 10);

    if (multiplier > 1) {
        step *= multiplier;
    }

    function formatValue(value, type) {
        if (type === 'currency') {
            // Định dạng số thành tiền VND
            return new Intl.NumberFormat('vi-VN', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value) + ' VNĐ';
        }

        // Nếu là tỉ lệ spin-rate, thêm dấu %
        if (elementId === 'spin-rate') {
            return value.toFixed(0) + '%'; // Đảm bảo chỉ hiển thị số nguyên và thêm %
        }

        return value.toLocaleString();
    }

    function stepAnimation(timestamp) {
        if (!startTime) startTime = timestamp;
        let progress = timestamp - startTime;
        current = Math.min(start + step * (progress / 10), end);

        // Set the current value với định dạng phù hợp
        document.getElementById(elementId).innerText = formatValue(current, formatType);

        if (current < end) {
            window.requestAnimationFrame(stepAnimation);
        } else {
            // Đảm bảo giá trị cuối cùng được định dạng chính xác
            document.getElementById(elementId).innerText = formatValue(end, formatType);
        }
    }

    window.requestAnimationFrame(stepAnimation);
}


// Get all element IDs and their corresponding values
let totalRevenue = "{{ number_format($totalRevenue) }}";
let totalProducts = "{{ $totalProducts }}";
let totalUsers = "{{ $totalUsers }}";
let totalOrders = "{{ $totalOrders }}";
let totalPosts = "{{ $totalPosts }}";
let spinRate = "{{ $spinRate }}";
let totalDiscounts = "{{ $totalDiscounts }}";
let totalTables = "{{ $totalTables }}";
let totalRevenueRaw = "{{ $totalRevenue }}";

// Xử lý chuỗi totalRevenueRaw để đảm bảo là số
totalRevenueRaw = parseFloat(totalRevenueRaw.replace(/[^0-9.-]+/g, ''));

// Animate the counters
animateCountUp('total-revenue', 0, totalRevenueRaw, 2000, totalRevenueRaw > 10000000 ? 5 : 1, 'currency');
animateCountUp('total-products', 0, totalProducts, 2000);
animateCountUp('total-users', 0, totalUsers, 2000);
animateCountUp('total-orders', 0, totalOrders, 2000);
animateCountUp('total-posts', 0, totalPosts, 2000);
animateCountUp('spin-rate', 0, spinRate, 2000);
animateCountUp('total-discounts', 0, totalDiscounts, 2000);
animateCountUp('total-tables', 0, totalTables, 2000);
const statCards = document.querySelectorAll('.stat-card');

    statCards.forEach(card => {
        const tooltip = card.querySelector('.tooltip');

        // Hiển thị tooltip khi hover vào
        card.addEventListener('mouseover', function() {
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = 1;
        });

        // Ẩn tooltip khi bỏ chuột ra
        card.addEventListener('mouseout', function() {
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = 0;
        });
    });
    
});
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('accessChart').getContext('2d');
    
    // Lấy dữ liệu từ backend
    const labels = @json($dates);
    const data =@json($revenues);

    const accessData = {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VND)',
            data: data,
            borderColor: '#3498db',
            backgroundColor: 'rgba(52, 152, 219, 0.2)',
            tension: 0.4,
            fill: true
        }]
    };

    new Chart(ctx, {
        type: 'line',
        data: accessData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Thống kê doanh thu 15 ngày gần nhất'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ngày'
                    }
                }
            }
        }
    });
});
fetch('http://localhost/web_ban_banh_kem/public/admin-info')
        .then(response => response.json())
        .then(data => {
            // Cập nhật thông tin người dùng và admin vào các phần tử HTML
            document.getElementById('user_name').textContent = data.user_name || 'Không có tên người dùng';
            document.getElementById('admin_id').textContent = data.admin_id ? `- Admin ID: ${data.admin_id} - Vai Trò: ${data.role}` : 'Không có Admin ID';
        })
        .catch(error => {
            console.error('Có lỗi khi lấy dữ liệu:', error);
        });

    </script>
</body>
</html>