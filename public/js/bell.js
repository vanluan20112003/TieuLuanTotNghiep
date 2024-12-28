// Kiểm tra trạng thái đăng nhập
function checkLoginStatus() {
    return fetch('http://localhost/web_ban_banh_kem/public/check-login-status') // API kiểm tra trạng thái đăng nhập
        .then(response => response.json())
        .then(data => data.loggedIn);
}

// Kiểm tra thông báo chưa đọc
function checkNotifications() {
    fetch('http://localhost/web_ban_banh_kem/public/notifications/unread')  // API kiểm tra thông báo chưa đọc
        .then(response => response.json())
        .then(data => {
            if (data.unread_count > 0) {
                document.getElementById('notificationDot').classList.add('show'); // Hiển thị dấu chấm đỏ
            } else {
                document.getElementById('notificationDot').classList.remove('show'); // Ẩn dấu chấm đỏ
            }
        })
        .catch(error => console.error('Lỗi khi kiểm tra thông báo:', error));
}

// Kiểm tra trạng thái đăng nhập và thiết lập interval kiểm tra thông báo
checkLoginStatus().then(loggedIn => {
    if (loggedIn) {
        // Nếu đã đăng nhập, bắt đầu kiểm tra thông báo mỗi 20 giây
        setInterval(checkNotifications, 20000);
    } else {
        console.log('Bạn cần đăng nhập để nhận thông báo.');
    }
});
checkNotifications();