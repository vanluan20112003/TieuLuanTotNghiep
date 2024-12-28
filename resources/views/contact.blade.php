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
}</style>
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
             id="table{{ $table->id }}" 
             style="background-color: {{ $isCurrentReservation ? '#a8e6cf' : ($currentReservation ? '#f3f4f6' : '#ffffff') }}; cursor: {{ $isCurrentReservation ? 'default' : ($currentReservation ? 'not-allowed' : 'pointer') }};"
             onclick="{{ $isCurrentReservation ? 'cancelReservation(\'' . $currentReservation->id . '\')' : ($currentReservation ? 'showAlert();' : "openModal('{$table->id}')") }}">
            <h2>{{ $table->ten_ban }}</h2>
            <p>Status: {{ ucfirst(str_replace('_', ' ', $table->status)) }}</p>
            @if ($isCurrentReservation)
                <p> {{ $currentReservation->thoi_gian_dat }}</p>
                <p> {{ $currentReservation->thoi_gian_roi }}</p>
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


</script>


</section>


























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
   <img src="images/loader.gif" alt="">
</div>

<script src="js/script.js"></script>

</body>
</html>