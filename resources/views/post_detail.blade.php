<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/post_detail.css') }}">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .post-container {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.main-content {
    flex: 3;
    padding-right: 30px;
}

.suggested-articles {
    flex: 1;
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
}

.suggested-article {
    margin-bottom: 15px;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 15px;
}

.suggested-article:last-child {
    border-bottom: none;
}

.suggested-article img {
    max-width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 10px;
}

.suggested-article h4 {
    margin: 0 0 10px 0;
    font-size: 16px;
}

.suggested-article p {
    color: #666;
    font-size: 14px;
}

/* Responsive design */
@media (max-width: 768px) {
    .post-container {
        flex-direction: column;
    }

    .main-content,
    .suggested-articles {
        flex: none;
        width: 100%;
        padding: 10px;
    }
}
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
.edit-comment-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    float: right;
}

.edit-comment-btn:hover {
    background-color: #0056b3;
}
#collapse-comments {
    background-color: #6c757d; /* Màu xám */
    color: white;
    margin-left: 10px; /* Thêm khoảng cách giữa hai nút */
}

#collapse-comments:hover {
    background-color: #5a6268; /* Màu xám đậm hơn khi hover */
}

/* Tùy chọn căn chỉnh nút */
#show-more-comments, 
#collapse-comments {
    display: inline-block; /* Đặt các nút nằm ngang */
    margin-top: 10px; /* Khoảng cách trên cho nút */
}
button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Nút "Xem thêm" */
#show-more-comments {
    background-color: #007bff; /* Màu xanh lam */
    color: white;
}

#show-more-comments:hover {
    background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
}
/* Các bình luận */
.comment {
    background-color: #f9f9f9;
    border: 1px solid #eee;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 14px;
}

/* Tên người bình luận */
.comment p strong {
    font-size: 16px;
    color: #333;
}
/* Kiểu dáng cho chế độ sáng (Light Mode) */
.post-content {
    color: #000; /* Màu chữ đen */
    background-color: #fff; /* Màu nền sáng */
}

/* Kiểu dáng cho chế độ tối (Dark Mode) */
body.dark-mode .post-content {
    color: #fff; /* Màu chữ trắng */
    background-color: #333; /* Màu nền tối */
}

/* Nếu muốn thay đổi màu nội dung khi trong chế độ tối, bạn có thể áp dụng thêm các thuộc tính khác */
.dark-content {
    color: #ccc; /* Màu chữ khi ở chế độ tối */
}

/* Nội dung bình luận */
.comment p {
    margin: 5px 0;
    color: #555;
}

/* Nút sửa bình luận */
.edit-comment-btn {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    margin-top: 5px;
}

.edit-comment-btn:hover {
    background-color: #45a049;
}

/* Làm nổi bật bình luận của người dùng hiện tại */
.comment.current-user {
    background-color: #e0f7fa; /* Màu nền nổi bật */
    border-color: #26c6da;
    border-width: 2px;
}

.comment.current-user p {
    font-weight: bold;
}

.comment.current-user .edit-comment-btn {
    background-color: #ff9800; /* Nút sửa bình luận màu cam cho người dùng hiện tại */
}

.comment.current-user .edit-comment-btn:hover {
    background-color: #fb8c00;
}
/* Ô nhập bình luận */
#comment-content {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    box-sizing: border-box;
    margin-top: 10px;
}

#comment-content:focus {
    border-color: #4caf50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
    outline: none;
}

#comment-content::placeholder {
    color: #888;
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
         <a href="{{ url('/') }}">Home</a>
         <a href="{{ url('/about') }}">About</a>
         <a href="{{ url('/menu') }}">Menu</a>
         <a href="{{ url('/orders') }}">Orders</a>
         <a href="{{ url('/contact') }}">Contact</a>
         <a href="{{ url('/post') }}">Post</a>

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
    <div class="post-container">
    <div class="main-content">
        <div class="post-header">
            <h1 id="post-title">{{ $post->title }}</h1>
            <p id="post-date">Posted on: {{ $post->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="post-image">
    <img src="{{ url($post->cover_image) }}" alt="Post Cover Image" id="post-cover">
</div>


        <div class="post-content" id="post-content">
            <p>{{ $post->content }}</p>
        </div>

        <div class="post-settings">
            <label for="color-scheme">Change Color Scheme: </label>
            <select id="color-scheme">
                <option value="default">Default</option>
                <option value="dark">Dark Mode</option>
                <option value="light">Light Mode</option>
                <option value="blue">Blue Theme</option>
            </select>

            <label for="text-size">Adjust Text Size: </label>
            <input type="range" id="text-size" min="12" max="24" value="16">
        </div>

        <div class="comments-section">
            <h3>Comments</h3>

            <div id="comments-list">
                <div class="comment">
                    <p><strong>John Doe</strong></p>
                    <p>This is a sample comment. Very informative post!</p>
                </div>

                <div class="comment">
                    <p><strong>Jane Smith</strong></p>
                    <p>I love the layout of this blog. Keep up the good work!</p>
                </div>
            </div>
            <button id="show-more-comments" style="display: none;" onclick="loadMoreComments()">Xem thêm</button>
            <button id="collapse-comments" style="display: none;" onclick="collapseComments()">Thu gọn</button>
            <div class="comment-form">
                <textarea id="new-comment" placeholder="Add your comment..."></textarea>
                <button id="add-comment">Post Comment</button>
            </div>
        </div>
        </div>
        <div class="suggested-articles">
    <h1>Bài viết gợi ý</h1>
    
    @forelse ($suggestedPosts as $suggestedPost)
    <div class="suggested-article">
    <a href="http://localhost/web_ban_banh_kem/public/post_detail/{{ $suggestedPost->id }}">
        <img src="http://localhost/web_ban_banh_kem/public/{{ $suggestedPost->cover_image }}" alt="{{ $suggestedPost->title }}">
        <h4>{{ $suggestedPost->title }}</h4>
        <p>{{ Str::limit($suggestedPost->description, 100) }}</p>
        <p><small>Posted on {{ $suggestedPost->created_at->format('F d, Y') }}</small></p>
    </a>
</div>

    @empty
        <p>Hiện tại chưa có bài viết phù hợp.</p>
    @endforelse
</div>

    </div>

    <script src="http://localhost/web_ban_banh_kem/public/js/script.js"></script>

    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const postContent = document.getElementById('post-content');
            const textSizeSlider = document.getElementById('text-size');
            const colorSchemeSelect = document.getElementById('color-scheme');
            const commentsList = document.getElementById('comments-list');
            const newCommentField = document.getElementById('new-comment');
            const addCommentButton = document.getElementById('add-comment');

            // Update text size
            textSizeSlider.addEventListener('input', function () {
                postContent.style.fontSize = `${this.value}px`;
            });

            // Change color scheme
            colorSchemeSelect.addEventListener('change', function () {
                document.body.className = '';
                const scheme = this.value;

                // Kiểm tra chế độ hiện tại và áp dụng chế độ dark hoặc light
                if (scheme === 'dark') {
    document.body.classList.add('dark-mode');
    document.getElementById('post-content').classList.add('dark-content');
    document.body.classList.remove('light-mode', 'blue-theme'); // Xóa các class không phù hợp
} else if (scheme === 'light') {
    document.body.classList.add('light-mode');
    document.body.classList.remove('dark-mode', 'blue-theme');
    document.getElementById('post-content').classList.remove('dark-content');
} else if (scheme === 'blue') {
    document.body.classList.add('blue-theme');
    document.body.classList.remove('dark-mode', 'light-mode');
    document.getElementById('post-content').classList.remove('dark-content');
}

            });

            // Add new comment
            addCommentButton.addEventListener('click', function () {
        const commentText = newCommentField.value.trim();

        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!loggedInUserId) {
            alert('Vui lòng đăng nhập để bình luận!');
            return;
        }

        // Kiểm tra nếu người dùng đã bình luận bài viết này
        const hasCommented = commentsData.some(comment => comment.user.id === loggedInUserId);
        if (hasCommented) {
            alert('Bạn đã bình luận bài viết này rồi!');
            return;
        }

        if (commentText === '') return; // Không cho phép bình luận trống

        // Tạo bình luận mới
        const newComment = document.createElement('div');
        newComment.classList.add('comment');
        newComment.innerHTML = `
            <p><strong>You</strong></p>
            <p>${commentText}</p>
        `;

        // Thêm bình luận vào danh sách
        commentsList.appendChild(newComment);

        // Xóa nội dung đã nhập trong ô nhập bình luận
        newCommentField.value = '';

        // Gửi bình luận lên server
        fetch(`http://localhost/web_ban_banh_kem/public/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ content: commentText })
        })
        .then(response => response.json())
        .then(data => {
            loadComments(); // Cập nhật lại danh sách bình luận sau khi thêm
        })
        .catch(error => console.error('Error adding comment:', error));
    });
        });
        const postId = '{{ $post->id }}';

// Hàm hiển thị bình luận
let commentsData = []; // Lưu trữ dữ liệu bình luận
let commentsDisplayed = 0; // Số bình luận đã hiển thị
const commentsPerPage = 5; // Số bình luận hiển thị mỗi lần
let loggedInUserId = null; // ID người dùng đăng nhập (gán từ server-side)

function loadComments() {
    fetch(`http://localhost/web_ban_banh_kem/public/posts/${postId}/comments`)
        .then(response => response.json())
        .then(data => {
            // Gán dữ liệu bình luận và user ID
            commentsData = data.comments;
            loggedInUserId = data.loggedInUserId; // Lấy user ID từ response

            // Ưu tiên bình luận của người dùng đăng nhập lên đầu
            if (loggedInUserId) {
                commentsData.sort((a, b) => {
                    if (a.user.id === loggedInUserId) return -1; // Bình luận của người dùng lên đầu
                    if (b.user.id === loggedInUserId) return 1;
                    return 0;
                });
            }

            commentsDisplayed = Math.min(commentsPerPage, commentsData.length); // Hiển thị tối đa 5 bình luận ban đầu
            renderComments(); // Hiển thị bình luận
        })
        .catch(error => console.error('Error loading comments:', error));
}

function renderComments() {
    const commentsList = document.getElementById('comments-list');
    const showMoreButton = document.getElementById('show-more-comments');
    const collapseButton = document.getElementById('collapse-comments');

    commentsList.innerHTML = ''; // Xóa tất cả bình luận cũ

    // Hiển thị các bình luận theo số lượng đã chọn
    for (let i = 0; i < commentsDisplayed; i++) {
        const comment = commentsData[i];
        const commentElement = document.createElement('div');
        commentElement.classList.add('comment');

        // Nếu bình luận của người dùng hiện tại, thêm lớp 'current-user'
        if (comment.user.id === loggedInUserId) {
            commentElement.classList.add('current-user');
        }

        commentElement.innerHTML = `
            <p><strong>${comment.user.name}</strong></p>
            <p>${comment.content}</p>
            ${
                comment.user.id === loggedInUserId
                    ? `<button class="edit-comment-btn" onclick="editComment(${comment.id})">Sửa</button>`
                    : ''
            }
        `;
        commentsList.appendChild(commentElement);
    }

    // Hiển thị hoặc ẩn nút "Xem thêm"
    if (commentsDisplayed < commentsData.length) {
        showMoreButton.style.display = 'block';
    } else {
        showMoreButton.style.display = 'none';
    }

    // Hiển thị hoặc ẩn nút "Thu gọn"
    if (commentsDisplayed > commentsPerPage) {
        collapseButton.style.display = 'block';
    } else {
        collapseButton.style.display = 'none';
    }
}


function loadMoreComments() {
    // Hiển thị thêm 5 bình luận nếu còn
    commentsDisplayed = Math.min(commentsDisplayed + commentsPerPage, commentsData.length);
    renderComments();
}

function collapseComments() {
    // Giảm số lượng bình luận hiển thị, nhưng không ít hơn 5
    commentsDisplayed = Math.max(commentsDisplayed - commentsPerPage, commentsPerPage);
    renderComments();
}

function editComment(commentId) {
    const content = prompt('Nhập nội dung mới cho bình luận:');
    if (content) {
        fetch(`http://localhost/web_ban_banh_kem/public/comments/${commentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ content }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Bình luận đã được cập nhật!');
                    loadComments();
                } else {
                    alert('Cập nhật bình luận thất bại!');
                }
            })
            .catch(error => console.error('Error updating comment:', error));
    }
}

// Tải bình luận ban đầu khi load trang
document.addEventListener('DOMContentLoaded', loadComments);

// Hàm gửi bình luận mới
function addComment() {
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!loggedInUserId) {
        alert('Vui lòng đăng nhập để bình luận!');
        return;
    }

    // Kiểm tra nếu người dùng đã bình luận bài viết này rồi
    const hasCommented = commentsData.some(comment => comment.user.id === loggedInUserId);
    if (hasCommented) {
        alert('Bạn đã bình luận bài viết này rồi!');
        return;
    }

    const content = document.getElementById('comment-content').value;

    if (!content) {
        alert('Vui lòng nhập nội dung bình luận!');
        return;
    }

    fetch(`http://localhost/web_ban_banh_kem/public/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ content: content })
    })
    .then(response => response.json())
    .then(data => {
        loadComments(); // Cập nhật lại danh sách bình luận sau khi thêm
        document.getElementById('comment-content').value = ''; // Xóa nội dung đã nhập
    })
    .catch(error => console.error('Error adding comment:', error));
}

// Gọi hàm loadComments khi trang được tải
window.onload = loadComments;
    </script>
</body>
</html>
