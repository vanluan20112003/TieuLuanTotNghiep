<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Center</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
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
.notification-box {
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
}

.notification-box.unread {
    background-color: #f8f9fa;
    border-left: 5px solid #007bff;
}

.notification-box.read {
    background-color: #e9ecef;
    border-left: 5px solid #6c757d;
}

.btn-mark-read {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}
/* Nút Action (Chung cho các thao tác như "Đánh dấu tất cả là đã đọc" và "Xóa tất cả thông báo đã đọc") */
.btn-action {
    padding: 10px 15px;
    border: none;
    background-color: #28a745; /* Màu xanh lá cho nút action */
    color: white;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
}

.btn-action:hover {
    background-color: #218838; /* Hiệu ứng hover cho nút action */
}

/* Nút Đánh dấu đã đọc */
.btn-mark-read {
    padding: 10px 15px;
    border: none;
    background-color: #007bff; /* Màu xanh dương cho nút đánh dấu đã đọc */
    color: white;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
}

.btn-mark-read:hover {
    background-color: #0056b3; /* Hiệu ứng hover cho nút đánh dấu đã đọc */
}

/* Nút Xóa */
.btn-delete-read {
    padding: 10px 15px;
    border: none;
    background-color: #dc3545; /* Màu đỏ cho nút xóa */
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

.btn-delete-read:hover {
    background-color: #c82333; /* Hiệu ứng hover cho nút xóa */
}

.btn-delete-read {
    background-color: #dc3545;
}

.btn-action:hover, .btn-mark-read:hover, .btn-delete-read:hover {
    opacity: 0.8;
}

.notification-box {
    margin-bottom: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.notification-box.read {
    background-color: #e9ecef;
}

.btn-mark-read:hover {
    background-color: #0056b3;
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
<section class="notification-section">
    <h1 class="title">Trung Tâm Thông Báo</h1>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-button active" data-tab="all">Tất cả</button>
        <button class="tab-button" data-tab="promotion">Khuyến mãi</button>
        <button class="tab-button" data-tab="notification">Thông báo</button>
        <button class="tab-button" data-tab="warning">Cảnh báo</button>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-action" onclick="markAllAsRead()">Đánh dấu tất cả là đã đọc</button>
        <button class="btn-action" onclick="deleteAllReadNotifications()">Xóa tất cả thông báo đã đọc</button>
    </div>

    <!-- Notifications -->
    <div class="notification-content">
        @if (Auth::check())
            @if ($notifications->isEmpty())
                <div class="no-notifications">
                    <p>Chưa có thông báo nào.</p>
                </div>
            @else
                @foreach ($notifications as $notification)
                    <div class="notification-box 
                        {{ $notification->type }} 
                        {{ $notification->is_user_read ? 'read' : 'unread' }}" 
                        id="notification-{{ $notification->id }}">

                        <i class="fas 
                            {{ $notification->type == 'discount' ? 'fa-tag' : ($notification->type == 'warning' ? 'fa-exclamation-triangle' : 'fa-bell') }}"></i>

                        <p>{{ $notification->content }}</p>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>

                        @if(!$notification->is_user_read)
                            <button class="btn-mark-read" 
                                    onclick="markAsRead('{{ $notification->id }}')">Đánh dấu đã đọc</button>
                        @else
                            <button class="btn-delete-read" 
                                    onclick="deleteNotification('{{ $notification->id }}')">Xóa</button>
                        @endif
                    </div>
                @endforeach
            @endif
        @else
            <div class="notification-box alert">
                <p>Bạn cần đăng nhập để xem thông báo.</p>
            </div>
        @endif
    </div>
</section>


<script src="http://localhost/web_ban_banh_kem/public/js/script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll('.tab-button');
    const notifications = document.querySelectorAll('.notification-box');

    // Khi bấm vào tab
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Loại bỏ class active khỏi tất cả các tab
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const selectedTab = this.getAttribute('data-tab');

            // Lặp qua tất cả các thông báo và kiểm tra loại
            notifications.forEach(notification => {
                // Hiển thị tất cả thông báo nếu chọn "Tất cả"
                if (selectedTab === 'all') {
                    notification.style.display = 'flex';
                }
                // Hiển thị các thông báo promotion ở tab "Promotion" và "All"
                else if (selectedTab === 'promotion' && notification.classList.contains('discount')) {
                    notification.style.display = 'flex';
                }
                // Hiển thị thông báo theo đúng loại ở tab tương ứng
                else if (selectedTab === notification.classList[1]) {
                    notification.style.display = 'flex';
                } 
                // Ẩn các thông báo không phù hợp
                else {
                    notification.style.display = 'none';
                }
            });
        });
    });
});
function markAsRead(notificationId) {
        fetch(`http://localhost/web_ban_banh_kem/public/notifications/read/${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Bảo mật CSRF
            }
        })
        .then(response => {
            if (response.ok) {
                // Cập nhật UI cho thông báo đã đọc
                const notificationElement = document.getElementById(`notification-${notificationId}`);
                if (notificationElement) {
                    notificationElement.classList.remove('unread');
                    notificationElement.classList.add('read');
                    const button = notificationElement.querySelector('.btn-mark-read');
                    if (button) {
                        button.remove(); // Xóa nút "Đánh dấu đã đọc"
                    }
                }
            } else {
                console.error('Đánh dấu thất bại.');
            }
        })
        .catch(error => console.error('Lỗi khi gửi yêu cầu:', error));
    }
    function markAllAsRead() {
    fetch(`{{ url('/notifications/read-all') }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            document.querySelectorAll('.notification-box.unread').forEach(el => {
                el.classList.remove('unread');
                el.classList.add('read');
                const markButton = el.querySelector('.btn-mark-read');
                if (markButton) markButton.remove();

                // Thêm nút xóa cho thông báo đã đọc
                const deleteButton = document.createElement('button');
                deleteButton.className = 'btn-delete-read';
                deleteButton.textContent = 'Xóa';
                deleteButton.onclick = () => deleteNotification(el.id.split('-')[1]);
                el.appendChild(deleteButton);
            });
        } else {
            console.error('Đánh dấu tất cả thất bại.');
        }
    });
}

function deleteNotification(notificationId) {
    fetch(`{{ url('http://localhost/web_ban_banh_kem/public/notifications/delete') }}/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            const notificationElement = document.getElementById(`notification-${notificationId}`);
            if (notificationElement) notificationElement.remove();
        } else {
            console.error('Xóa thông báo thất bại.');
        }
    });
}

function deleteAllReadNotifications() {
    fetch(`{{ url('http://localhost/web_ban_banh_kem/public/notifications/delete-read') }}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            document.querySelectorAll('.notification-box.read').forEach(el => {
                el.remove();
            });
        } else {
            console.error('Xóa tất cả thông báo đã đọc thất bại.');
        }
    });
}
</script>
</body>
</html>
