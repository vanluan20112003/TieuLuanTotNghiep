<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

   <meta name="csrf-token" content="{{ csrf_token() }}">
<style>.header {
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
/* Main Container Styles */
.contact {
    padding: 40px 0;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.container h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 40px;
    font-size: 2.5rem;
}

/* Table Grid Layout */
.table-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

/* Individual Table Styles */
.table {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    border: 2px solid transparent;
}

.table:not([style*="not-allowed"]):hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.table h2 {
    color: #34495e;
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.table p {
    color: #7f8c8d;
    margin: 5px 0;
}

/* Table Status Styles */
.table[style*="not-allowed"] {
    opacity: 0.7;
    background-color: #f3f4f6 !important;
}

.table[data-status="not_available"],
.table[data-status="reserved"] {
    background-color: #ffebee !important;
    cursor: not-allowed !important;
    border-color: #ffcdd2;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 30px;
    width: 80%;
    max-width: 800px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.close-btn {
    position: absolute;
    right: 20px;
    top: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.close-btn:hover {
    color: #333;
}

/* Form Styles */
#reservationForm {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#reservationForm label {
    color: #2c3e50;
    font-weight: 500;
}

#reservationForm input {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

#reservationForm input:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
}

/* Button Styles */
button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s;
}

button[type="submit"] {
    background-color: #2ecc71;
    color: white;
}

button[type="submit"]:hover {
    background-color: #27ae60;
}

button[type="button"] {
    background-color: #e74c3c;
    color: white;
}

button[type="button"]:hover {
    background-color: #c0392b;
}

/* Available Times List Styles */
.scrollable {
    border: 1px solid #eee;
    border-radius: 5px;
    padding: 10px;
}

#availableTimesList {
    list-style: none;
    padding: 0;
    margin: 0;
}

#availableTimesList li {
    padding: 8px;
    border-bottom: 1px solid #eee;
    color: #666;
}

#availableTimesList li:last-child {
    border-bottom: none;
}

/* Cancel Reservation Button */
.table button {
    margin-top: 10px;
    background-color: #e74c3c;
    color: white;
    padding: 8px 15px;
    font-size: 0.9rem;
}

.table button:hover {
    background-color: #c0392b;
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 10% auto;
        flex-direction: column;
    }
    
    .table-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}
/* Main Container Styles */
.contact {
    padding: 40px 0;
    background-color: #f8f9fa;
    min-height: 100vh;
    background-image: linear-gradient(to bottom right, #f8f9fa 0%, #e9ecef 100%);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.container h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 40px;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

/* Table Grid Layout */
.table-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    padding: 20px;
}

/* Enhanced Table Styles */
.table {
    background-color: #ffffff;
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    position: relative;
    border: 2px solid #e1e8ed;
    overflow: hidden;
}

/* Table Shape and Design */
.table::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 80%;
    height: 60%;
    background: #f8f9fa;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    border: 2px solid #e1e8ed;
}

/* Table Number Badge */
.table h2 {
    position: relative;
    color: #34495e;
    margin-bottom: 15px;
    font-size: 1.5rem;
    z-index: 1;
    background: #fff;
    display: inline-block;
    padding: 5px 15px;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Status Indicator */
.table p {
    position: relative;
    z-index: 1;
    color: #7f8c8d;
    margin: 8px 0;
    font-weight: 500;
}

/* Available Table Style */
.table:not([data-status="not_available"]):not([data-status="reserved"]):hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #3498db;
}

.table:not([data-status="not_available"]):not([data-status="reserved"])::after {
    content: '👆 Nhấn để đặt bàn';
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.9rem;
    color: #3498db;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.table:not([data-status="not_available"]):not([data-status="reserved"]):hover::after {
    opacity: 1;
}

/* Not Available Table Style */
.table[data-status="not_available"] {
    background-color: #fff5f5;
    border-color: #feb2b2;
    cursor: not-allowed;
}

.table[data-status="not_available"]::before {
    background-color: #fed7d7;
    border-color: #feb2b2;
}

.table[data-status="not_available"]::after {
    content: '⛔ Bàn không khả dụng';
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.9rem;
    color: #e53e3e;
}

/* Reserved Table Style */
.table[data-status="reserved"] {
    background-color: #ebf8ff;
    border-color: #90cdf4;
    cursor: not-allowed;
}

.table[data-status="reserved"]::before {
    background-color: #bee3f8;
    border-color: #90cdf4;
}

.table[data-status="reserved"]::after {
    content: '🕒 Đã được đặt';
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.9rem;
    color: #2b6cb0;
}

/* Your Current Reserved Table */
.table[style*="a8e6cf"] {
    background-color: #f0fff4 !important;
    border-color: #68d391 !important;
}

.table[style*="a8e6cf"]::before {
    background-color: #c6f6d5 !important;
    border-color: #68d391 !important;
}

.table[style*="a8e6cf"]::after {
    content: '✅ Bàn của bạn';
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.9rem;
    color: #2f855a;
}

/* Cancel Reservation Button */
.table button {
    position: relative;
    z-index: 1;
    margin-top: 15px;
    background-color: #e53e3e;
    color: white;
    padding: 8px 20px;
    font-size: 0.9rem;
    border-radius: 20px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.table button:hover {
    background-color: #c53030;
    transform: scale(1.05);
}

/* Reservation Time Display */
.table p:nth-of-type(2),
.table p:nth-of-type(3) {
    font-size: 0.9rem;
    color: #4a5568;
    background: rgba(255,255,255,0.8);
    padding: 4px 10px;
    border-radius: 12px;
    display: inline-block;
    margin: 3px 0;
}

/* Status Badge */
.table p:first-of-type {
    background: #edf2f7;
    display: inline-block;
    padding: 5px 15px;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: bold;
}

/* Modal Styles remain the same... */

/* Responsive Design */
@media (max-width: 768px) {
    .table-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    
    .table {
        padding: 20px;
    }
    
    .table::before {
        width: 70%;
        height: 50%;
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
   <h3>Đặt Bàn</h3>
   <p><a href="{{ url('/contact') }}">home </a> <span> / contact</span></p>
</div>

<section class="contact">
<div class="container">
    <h1>Danh Sách Bàn Ăn</h1>
    <div class="table-grid">
    @foreach($banAn as $table)
        @php
            // Kiểm tra nếu đây là bàn người dùng đang đặt
            $isCurrentReservation = isset($currentReservation) && $currentReservation->ban_an_id == $table->id;
        @endphp
       <div class="table" 
    data-status="{{ $table->status }}"
    id="table{{ $table->id }}" 
    style="background-color: {{ $isCurrentReservation ? '#a8e6cf' : ($currentReservation ? '#f3f4f6' : '#ffffff') }}; 
           cursor: {{ $table->status === 'not_available' || $table->status === 'reserved' ? 'not-allowed' : ($isCurrentReservation ? 'default' : 'pointer') }};"
    onclick="
        {{ $table->status === 'not_available' || $table->status === 'reserved' ? 'showAlert()' : ($isCurrentReservation ? "cancelReservation('{$currentReservation->id}')" : "openModal('{$table->id}')") }}
    ">
    <h2>{{ $table->ten_ban }}</h2>
    <p>Status: {{ ucfirst(str_replace('_', ' ', $table->status)) }}</p>
    @if ($isCurrentReservation)
        <p>{{ $currentReservation->thoi_gian_dat }}</p>
        <p>{{ $currentReservation->thoi_gian_roi }}</p>
        <button onclick="cancelReservation('{{ $currentReservation->id }}')">Hủy Đặt</button>
    @endif
</div>

    @endforeach
</div>

</div>



    <!-- Modal Form for Reservation -->
    <div class="modal" id="reservationModal">
    <div class="modal-content" style="display: flex;">
        <span class="close-btn" onclick="closeModal()">×</span>
        <div style="flex: 1;">
            <h2>Thông Tin Đặt Bàn</h2>
            <form id="reservationForm" onsubmit="submitForm(event)">
                <label for="name">Họ và Tên: </label>
                <input type="text" id="name" name="name" required placeholder="Nhập họ và tên của bạn" 
                       value="{{ Auth::check() ? Auth::user()->name : '' }}">

                <label for="reservationDate">Ngày Đặt Bàn:</label>
                <input type="date" id="reservationDate" name="reservationDate" required>

                <label for="startTime">Thời Gian Bắt Đầu:</label>
                <input type="time" id="startTime" name="startTime" required>

                <label for="endTime">Thời Gian Rời Đi:</label>
                <input type="time" id="endTime" name="endTime" required>

                <div style="display: flex; justify-content: space-between;">
                    <button type="submit">Đặt Bàn</button>
                    <button type="button" onclick="closeModal()">Hủy</button>
                </div>
            </form>
        </div>
        <div style="flex: 1; margin-left: 20px;">
            <h3>Thời Gian Khả Dụng</h3>
            <div class="scrollable" style="max-height: 300px; overflow-y: auto;">
                <ul id="availableTimesList"></ul> <!-- Danh sách thời gian khả dụng -->
            </div>
        </div>
    </div>
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
<script>
  const startTimeInput = document.getElementById("startTime");
const endTimeInput = document.getElementById("endTime");
const reservationDateInput = document.getElementById("reservationDate");

// Giới hạn ngày chỉ trong ngày hôm nay và hai ngày tiếp theo
const today = new Date();
const maxDate = new Date();
maxDate.setDate(today.getDate() + 2);

reservationDateInput.min = today.toISOString().split('T')[0];
reservationDateInput.max = maxDate.toISOString().split('T')[0];

// Kiểm tra thời gian bắt đầu khi người dùng chọn ngày
reservationDateInput.addEventListener("change", function() {
    validateStartTime();
});

// Thiết lập sự kiện thay đổi cho thời gian bắt đầu
startTimeInput.addEventListener("change", function() {
    validateStartTime();
});

function validateStartTime() {
    const selectedDate = new Date(reservationDateInput.value);
    const selectedStartTime = startTimeInput.value.split(':');
    const startHours = parseInt(selectedStartTime[0]);
    const startMinutes = parseInt(selectedStartTime[1]);

    // Thiết lập thời gian bắt đầu
    const selectedStartDateTime = new Date(selectedDate.setHours(startHours, startMinutes));

    // Kiểm tra thời gian hiện tại
    const currentDateTime = new Date();
    
    // Kiểm tra xem thời gian bắt đầu có trước thời gian hiện tại không
    const oneHourLater = new Date(currentDateTime.getTime() + 60 * 60 * 1000);
    if (selectedStartDateTime < oneHourLater) {
        alert("Vui lòng chọn thời gian bắt đầu sau thời gian hiện tại ít nhất 1 tiếng.");
        startTimeInput.value = '';
        endTimeInput.value = '';
        return;
    }

    // Thiết lập thời gian kết thúc tối thiểu và tối đa
    const minEndTime = new Date(selectedStartDateTime.getTime() + 15 * 60 * 1000);
    const maxEndTime = new Date(selectedStartDateTime.getTime() + 60 * 60 * 1000);

    const minEndTimeStr = minEndTime.toTimeString().slice(0, 5); // Chuyển sang HH:mm
    const maxEndTimeStr = maxEndTime.toTimeString().slice(0, 5); // Chuyển sang HH:mm

    endTimeInput.setAttribute("min", minEndTimeStr);
    endTimeInput.setAttribute("max", maxEndTimeStr);
    endTimeInput.value = minEndTimeStr;
}

// Giới hạn giờ bắt đầu trong khoảng từ 08:00 đến 19:00
startTimeInput.addEventListener("focus", function() {
    const minTime = "08:00";
    const maxTime = "19:00";
    this.setAttribute("min", minTime);
    this.setAttribute("max", maxTime);
});

// Cập nhật thời gian kết thúc theo thời gian bắt đầu
endTimeInput.addEventListener("focus", function() {
    this.setAttribute("min", startTimeInput.value);
});
let selectedTableId = null;


function openModal(tableId) {
    // Mở modal
    selectedTableId = tableId;
    console.log("Open modal for table: " + tableId);
    document.getElementById('reservationModal').style.display = 'flex';

    // Gửi yêu cầu để lấy thời gian khả dụng
    $.ajax({
        url: "{{ url('/available-times') }}/" + tableId,
        type: 'GET',
        success: function(data) {
            const availableTimesList = document.getElementById('availableTimesList');
            availableTimesList.innerHTML = ''; // Xóa danh sách cũ

            // Nhóm theo ngày
            const timesByDate = {};
            data.forEach(function(time) {
                const date = time.date;
                if (!timesByDate[date]) {
                    timesByDate[date] = [];
                }
                timesByDate[date].push(time);
            });

            // Hiển thị thời gian khả dụng theo ngày
            for (const date in timesByDate) {
                const dateHeader = document.createElement('h3');
                dateHeader.textContent = date; // Hiển thị ngày
                availableTimesList.appendChild(dateHeader);

                timesByDate[date].forEach(function(time) {
                    const li = document.createElement('li');
                    li.textContent = time.start_time + ' đến ' + time.end_time; // Hiển thị giờ
                    availableTimesList.appendChild(li);
                });
            }
        },
        error: function() {
            alert("Không thể tải thời gian khả dụng.");
        }
    });
}


    function closeModal() {
        document.getElementById('reservationModal').style.display = 'none';
        document.getElementById('reservationForm').reset();
    }
    function cancelReservation(reservationId) {
    if (confirm("Bạn có chắc chắn muốn hủy đặt bàn này không?")) {
        $.ajax({
            type: 'POST',
            url: "{{ url('/cancel-reservation') }}/" + reservationId, 
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    // Cập nhật lại danh sách bàn sau khi hủy
                    location.reload(); // Hoặc bạn có thể gọi lại phương thức fetchTables
                } else {
                    alert("Có lỗi xảy ra: " + response.message);
                }
            },
            error: function() {
                alert("Có lỗi xảy ra. Vui lòng thử lại.");
            }
        });
    }
}

    function showAlert() {
        // Hiển thị thông báo khi người dùng cố nhấp vào bàn khác
        alert("Bạn hiện có một bàn đã đặt rồi.");
    }
    function submitForm(event) {
    event.preventDefault();

    if (!selectedTableId) {
        alert("Vui lòng chọn bàn trước khi đặt.");
        return;
    }

    const reservationDate = document.getElementById('reservationDate').value;
    const startTime = document.getElementById('startTime').value;
    const endTime = document.getElementById('endTime').value;

    $.ajax({
        type: 'POST',
        url: "{{ route('dat-ban') }}",
        data: {
            ban_an_id: selectedTableId, // Đổi từ tableId sang ban_an_id
            thoi_gian_dat: reservationDate + ' ' + startTime, // Ghép ngày và giờ bắt đầu
            thoi_gian_roi: reservationDate + ' ' + endTime, // Ghép ngày và giờ kết thúc
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Kiểm tra xem phản hồi có báo lỗi hay không
            if (response.success === false) {
                // Thông báo cụ thể dựa vào loại lỗi
                if (response.message === 'Khoảng thời gian đặt bị trùng với thời gian đã có.') {
                    alert("Thông báo: " + response.message);
                } else {
                    alert("Có lỗi xảy ra: " + response.message);
                }
                return; // Không thực hiện thêm hành động nào nếu có lỗi
            }

            alert("Đặt bàn thành công!");

            // Lấy lại danh sách bàn ăn sau khi đặt thành công
            $.ajax({
                url: "{{ route('fetch-tables') }}",
                type: 'GET',
                success: function(data) {
                    let tableGridHtml = '';
                    data.banAn.forEach(function(table) {
                        const isCurrentReservation = data.currentReservation && data.currentReservation.ban_an_id === table.id;
                        const bgColor = isCurrentReservation ? '#a8e6cf' : (data.currentReservation ? '#f3f4f6' : '#ffffff'); // Màu xanh nhạt cho bàn đã đặt, xám nhạt cho bàn không thể đặt
                        const cursorStyle = isCurrentReservation ? 'default' : (data.currentReservation ? 'not-allowed' : 'pointer');
                        const onClickAction = isCurrentReservation ? '' : (data.currentReservation ? 'showAlert();' : `openModal('${table.id}')`);

                        tableGridHtml += `
                            <div class="table" 
                                 id="table${table.id}"
                                 style="background-color: ${bgColor}; cursor: ${cursorStyle};"
                                 onclick="${onClickAction}">
                                <h2>${table.ten_ban}</h2>
                                <p>Status: ${table.status.replace('_', ' ').charAt(0).toUpperCase() + table.status.slice(1)}</p>`;

                        if (isCurrentReservation) {
                            tableGridHtml += `
                                <p>${data.currentReservation.thoi_gian_dat}</p>
                                <p>${data.currentReservation.thoi_gian_roi}</p>
                                <button onclick="cancelReservation('${data.currentReservation.id}')">Hủy Đặt</button>`;
                        }

                        tableGridHtml += `</div>`;
                    });

                    $('.table-grid').html(tableGridHtml);
                },
                error: function() {
                    alert("Không thể tải lại danh sách bàn ăn.");
                }
            });

            closeModal();
        },
        error: function() {
            alert("Có lỗi xảy ra. Vui lòng thử lại.");
        }
    });
}

function showAlert() {
    alert('Bàn này hiện không khả dụng hoặc đã được đặt trước.');
}

</script>
































<script src="js/script.js"></script>
<div class="loader">
   <img src="images/loader.gif" alt="">
</div>
</body>
</html>