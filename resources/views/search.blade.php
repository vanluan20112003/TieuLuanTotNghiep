<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/search.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">


   <style>
    .category .box-container {
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(27rem, 1fr));
   gap: 1.5rem;
   align-items: flex-start;
}
.price-highlight {
    font-weight: bold;         
    color: #ff0000 !important; /* Màu vàng */
    font-size: 1.2em;          
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); 
}
.filter-subtitle {
    font-size: 16px;
    font-weight: bold;
    margin: 5px 0;
}
.filter-item input[type="radio"],
.filter-item input[type="checkbox"] {
    margin-right: 8px;
    accent-color: #007bff; /* Thay đổi màu của radio và checkbox */
}
.filter-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}
.category .box-container .box {
   border: var(--border);
   padding: 2rem;
   text-align: center;
}

.category .box-container .box img {
   width: 100%;
   height: 10rem;
   object-fit: contain;
}

.category .box-container .box h3 {
   margin-top: 2rem;
   font-size: 2rem;
   color: var(--black);
}

.category .box-container .box:hover {
   background-color: var(--black);
}

.category .box-container .box:hover img {
   filter: invert();
}

.category .box-container .box:hover h3 {
   color: var(--white);
}

.products .box-container {
   display: grid;
   grid-template-columns: repeat(3, 1fr);
   gap: 20px; /* Khoảng cách giữa các box */
   align-items: flex-start;
   justify-content: center;
  
     /* Tối đa 3 cột */
   
}

.products .box-container .box {
   position: relative;
   border: var(--border);
   padding: 2rem;
   overflow: hidden;
}



.products .box-container .box .fa-eye,
.products .box-container .box .fa-shopping-cart {
    position: absolute;
    top: 1rem;
    height: 4.5rem;
    width: 4.5rem;
    line-height: 4.5rem; /* Đảm bảo độ cao và căn giữa */
    font-size: 2rem;
    border: var(--border);
    background-color: var(--white);
    cursor: pointer;
    color: var(--black);
    text-align: center;
}


.products .box-container .box .fa-eye {
   left: -10rem;
}

.products .box-container .box .fa-shopping-cart {
   right: -10rem;
}

.products .box-container .box:hover .fa-eye {
   left: 1rem;
}

.products .box-container .box:hover .fa-shopping-cart {
   right: 1rem;
}

.products .box-container .box .fa-eye:hover,
.products .box-container .box .fa-shopping-cart:hover {
   background-color: var(--black);
   color: var(--white);
}

.products .box-container .box img {
   height: 25rem;
   width: 100%;
   object-fit: contain;
   margin-bottom: 1rem;
}

.products .box-container .box .cat {
   font-size: 1.7rem;
   color: var(--light-color);
}

.products .box-container .box .cat:hover {
   color: var(--yellow);
}

.products .box-container .box .name {
   font-size: 2rem;
   margin: 1rem 0;
   color: var(--black);
}

.products .box-container .box .flex {
   display: flex;
   align-items: center;
   gap: 1rem;
}

.products .box-container .box .flex .price {
   margin-right: auto;
   font-size: 2.5rem;
   color: var(--black);
}

.products .box-container .box .flex .price span {
   font-size: 1.8rem;
   color: var(--light-color);
}

.products .box-container .box .flex .qty {
   padding: 1rem;
   font-size: 1.8rem;
   border: var(--border);
   color: var(--black);
   width: 7rem;
}

.products .box-container .box .flex .fa-edit {
   width: 5rem;
   background-color: var(--yellow);
   color: var(--black);
   cursor: pointer;
   height: 4.5rem;
   font-size: 2rem;
   border: var(--border);
}

.products .box-container .box .flex .fa-edit:hover {
   background-color: var(--black);
   color: var(--white);
}

.products .box-container .box .sub-total {
   margin-top: 1rem;
   font-size: 1.7rem;
   color: var(--light-color);
}

.products .box-container .box .sub-total span {
   color: var(--black);
}

.products .box-container .box .fa-times {
   font-size: 2rem;
   background-color: var(--red);
   color: var(--white);
   height: 4.5rem;
   position: absolute;
   top: 1rem;
   right: 1rem;
   width: 4.5rem;
   line-height: 4.3rem;
   height: 4.5rem;
   cursor: pointer;
   border: var(--border);
}

.products .box-container .box .fa-times:hover {
   background-color: var(--black);
}

.products .more-btn {
   margin-top: 2rem;
   text-align: center;
}

.products .cart-total {
   border: var(--border);
   padding: 1rem 2rem;
   margin-top: 1rem;
   margin-bottom: 2rem;
   display: flex;
   flex-wrap: wrap;
   gap: 1.5rem;
   align-items: center;
}

.products .cart-total p {
   margin-right: auto;
   font-size: 2rem;
   color: var(--light-color);
}

.products .cart-total p span {
   color: var(--black);
}

.products .cart-total .btn {
   margin-top: 0;
}
       /* Style cho bộ lọc */
       .filter-container {
           width: 250px;
           padding: 20px;
           background-color: #fff;
           border-right: 1px solid #ccc;
           position: fixed;
           height: 100%;
           overflow-y: auto;
           box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
       }
       .filter-title {
           font-size: 20px;
           margin-bottom: 2px;
           font-weight: bold;
           color: #333;
       }
       .filter-category {
           margin-bottom: 5px;
           border-bottom: 1px solid #e0e0e0;
           padding-bottom: 10px;
       }
       .filter-category:last-child {
           border: none; /* Xóa border cho phần cuối cùng */
       }
       .filter-item {
           margin: 5px 0;
           display: flex;
           align-items: center;
           cursor: pointer;
       }
       .filter-item input {
           margin-right: 10px;
           accent-color: #e74c3c; /* Màu cho checkbox */
       }
       .filter-item label {
           font-size: 14px;
           color: #555;
       }

       /* Style cho khung tìm kiếm */
       .search-form {
           margin-left: 270px;
           padding: 20px;
       }
       .products {
    margin-left: 270px; /* Cùng kích thước với bộ lọc */
    padding: 20px;
    background-color: #f9f9f9;
    border-top: 1px solid #ccc;
    margin-top: 20px; /* Khoảng cách từ phần tìm kiếm */
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
.filter-container {
    max-height: 600px; /* Điều chỉnh chiều cao tối đa của bộ lọc */
    overflow-y: auto;  /* Thêm thanh cuộn dọc khi nội dung vượt quá chiều cao */
    padding-right: 15px; /* Thêm khoảng cách phải để tránh thanh cuộn chồng lên nội dung */
}

.filter-category {
    margin-bottom: 20px;
}

.filter-title, .filter-subtitle {
    font-weight: bold;
    margin-bottom: 10px;
}

.filter-item {
    margin-bottom: 5px;
}

#filter-form {
    padding: 20px;
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


<!-- Bộ lọc -->
<div class="filter-container">
    <div class="filter-title">Bộ lọc</div>

    <form id="filter-form">
    <div class="filter-category">
    <div class="filter-subtitle">Sắp xếp theo giá</div>
            <div class="filter-item">
                <label><input type="radio" name="sort_price" value="asc"> Giá tăng dần</label>
            </div>
            <div class="filter-item">
                <label><input type="radio" name="sort_price" value="desc"> Giá giảm dần</label>
            </div>

            <!-- Nhóm sắp xếp theo chữ cái -->
            <div class="filter-subtitle">Sắp xếp theo chữ cái</div>
            <div class="filter-item">
                <label><input type="radio" name="sort_name" value="az"> A - Z</label>
            </div>
            <div class="filter-item">
                <label><input type="radio" name="sort_name" value="za"> Z - A</label>
            </div>
    </div>
        <!-- Bộ lọc giá -->
        <div class="filter-category">
            <div class="filter-title">Giá</div>
            <div class="filter-item">
                <label><input type="checkbox" name="price[]" value="0-20000"> 0₫ - 20,000₫</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="price[]" value="20000-50000"> 20,000₫ - 50,000₫</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="price[]" value="50000-100000"> 50,000₫ - 100,000₫</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="price[]" value="100000-300000"> 100,000₫ - 300,000₫</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="price[]" value="301000"> 300,000₫ trở lên</label>
            </div>
        </div>

        <!-- Loại sản phẩm -->
        <div class="filter-category">
            <div class="filter-title">Loại sản phẩm</div>
            @foreach($categories as $category)
                <div class="filter-item">
                    <label>
                        <input type="checkbox" name="type[]" value="{{ $category->id }}"> {{ $category->name }} ({{ $category->product_count }})
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Số sao -->
        <div class="filter-category">
            <div class="filter-title">Số sao</div>
            <div class="filter-item">
                <label><input type="checkbox" name="rating[]" value="4-5"> 4 sao trở lên</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="rating[]" value="3-4"> 3 sao trở lên</label>
            </div>
            <div class="filter-item">
                <label><input type="checkbox" name="rating[]" value="2-3"> 2 sao trở lên</label>
            </div>
        </div>

        <button type="submit" id="filterButton">Lọc</button>

    </form>
</div>


<!-- Tìm kiếm và kết quả -->
<section class="search-form">
   <form id="search-form" method="get">
      <input type="text" class="box" name="query" placeholder="Search here..." maxlength="100" id="search-box" autocomplete="off">
      <div id="suggestions" class="suggestions-box" style="display: none;"></div>
   </form>
</section>
<section class="products">
    <div class="product-title">Kết quả tìm kiếm</div>
    <div class="product-container" id="product-container">
        <div class="box-container">
            <!-- Sản phẩm sẽ được thêm vào đây bằng AJAX -->
        </div>
    </div>
</section>

<!-- Custom CSS cho khung kết quả -->
<style>
 .search-form {
    position: relative; /* Đặt vị trí tương đối để các phần tử con có thể định vị tuyệt đối dựa trên nó */
}
#filterButton {
    background-color: #28a745; /* Màu nền xanh */
    color: white; /* Màu chữ trắng */
    border: none; /* Không viền */
    border-radius: 5px; /* Bo tròn góc */
    padding: 10px 20px; /* Kích thước padding */
    font-size: 16px; /* Kích thước chữ */
    cursor: pointer; /* Hiệu ứng con trỏ khi di chuột */
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu */
}

#filterButton:hover {
    background-color: #218838; /* Màu nền khi di chuột */
}

.suggestions-box {
    position: absolute;
    top: 100%; /* Đặt bảng ngay dưới ô input */
    left: 0;
    width: 100%;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.suggestions-box .suggestion-item {
    padding: 10px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
}

.suggestions-box .suggestion-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 10px;
}

.suggestions-box .suggestion-item .suggestion-info {
    flex-grow: 1;
}

.suggestions-box .suggestion-item .suggestion-info .suggestion-name {
    font-size: 14px;
    font-weight: bold;
}

.suggestions-box .suggestion-item .suggestion-info .suggestion-price {
    color: #e74c3c;
    font-size: 12px;
}

</style>

<script src="js/script.js"></script>
<!-- AJAX Script để tìm kiếm theo thời gian thực -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
$(document).ready(function() {
   var isLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";
    // Tìm kiếm sản phẩm
    $('#search-box').on('input', function() {
        const query = $(this).val().trim();
        
        if (query.length === 0) {
            $('#suggestions').hide();
            return;
        }

        $.ajax({
            url: '{{ route("search.products") }}',
            method: 'GET',
            data: { query: query },
            beforeSend: function() {
                $('#loading').show(); // Hiện spinner
            },
            success: function(data) {
                const suggestionsBox = $('#suggestions');
                suggestionsBox.empty(); // Xóa gợi ý cũ
                
                if (data.status === 'no_results') {
                    suggestionsBox.hide();
                } else {
                    suggestionsBox.show();
                    data.products.forEach(product => {
                        const productHtml = `
                            <div class="suggestion-item" onclick="window.location.href='http://localhost/web_ban_banh_kem/public/quick_view/${product.id}'">
                                <img src="images/${product.image}" alt="${product.name}">
                                <div class="suggestion-info">
                                    <div class="suggestion-name">${product.name}</div>
                                    <div class="suggestion-price">${product.price.toLocaleString()} ₫</div>
                                </div>
                            </div>`;
                        suggestionsBox.append(productHtml);
                    });
                }
            },
            error: function(xhr) {
                console.error('Error fetching search results:', xhr.responseText);
            },
            complete: function() {
                $('#loading').hide(); // Ẩn spinner
            }
        });
    });

    // Ẩn hộp gợi ý khi click ra ngoài
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#search-form').length) {
            $('#suggestions').hide(); // Ẩn hộp gợi ý
        }
    });

    // Lọc sản phẩm
    $('#filter-form').on('submit', function(e) {
    e.preventDefault(); // Ngăn chặn hành động mặc định

    // Lấy dữ liệu từ form
    const formData = $(this).serialize();

    $.ajax({
        url: '{{ route("products.filter") }}',
        method: 'GET',
        data: formData,
        beforeSend: function() {
            $('#loading').show(); // Hiện spinner
        },
        success: function(data) {
            let productContainer = $('.box-container');
            productContainer.empty(); // Xóa sản phẩm cũ

            if (data.length) {
                data.forEach(function(product) {
                    const productHtml = `
                    <div class="box">
                        <input type="hidden" class="product-id" value="${product.id}">
                        <div class="fas fa-eye" onclick="window.location.href='http://localhost/web_ban_banh_kem/public/quick_view/${product.id}'"></div>
                        <button class="fas fa-shopping-cart add-to-cart-btn" type="button"></button>
                        <img src="{{ asset('images/') }}/${product.image}" alt="${product.name}">
                        
                        <h3 class="name">${product.name}</h3>
                        <div class="flex">
                            <div class="price">
                                <span class="price-highlight">${new Intl.NumberFormat('vi-VN').format(product.price)} ₫</span>

                               <span class="original-price" style="text-decoration: line-through;">${new Intl.NumberFormat('vi-VN').format(product.original_price)} ₫</span>
                            </div>
                            <input type="number" name="qty" class="qty" min="1" max="99" value="1">
                        </div>
                        <div class="sub-total">
                            <span>Sale Off: ${parseFloat(product.discount).toFixed(2)}%</span>
                        </div>
                    </div>`;
                    productContainer.append(productHtml);
                });
            } else {
               productContainer.append('<div style="text-align: center;"><img src="{{ asset("images/cart_empty.gif") }}" alt="Giỏ hàng trống" style="max-width: 200px; height: auto;"></div>');
            }
        },
        error: function(xhr) {
            console.error('Error fetching products:', xhr.responseText);
        },
        complete: function() {
            $('#loading').hide(); // Ẩn spinner
        }
    });
});


    // Thêm sản phẩm vào giỏ hàng bằng Event Delegation
    $(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();  // Ngăn chặn hành động mặc định của button

    if (!isLoggedIn) {
        alert('Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        return;  // Dừng lại nếu chưa đăng nhập
    }

    var button = $(this);
    var productId = button.closest('.box').find('.product-id').val();  // Lấy ID sản phẩm
    var qty = button.closest('.box').find('.qty').val();  // Lấy số lượng sản phẩm
    var imageUrl = button.closest('.box').find('img').attr('src');  // Lấy ảnh sản phẩm từ thẻ <img>

    // Gửi AJAX request để thêm sản phẩm vào giỏ hàng
    $.ajax({
        url: '{{ route("add.to.cart") }}',  // URL để gửi yêu cầu
        method: 'POST',  // Phương thức gửi yêu cầu
        data: {
            _token: '{{ csrf_token() }}',  // CSRF token để bảo mật
            product_id: productId,  // ID sản phẩm
            qty: qty  // Số lượng sản phẩm
        },
        success: function(response) {
            // Hiển thị thông báo thành công
  

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $('#cart-count').text(response.cartItemCount);

            // Gọi hàm hiệu ứng hình ảnh bay (addToCart) với các tham số
            addToCart(productId, imageUrl, button[0], qty);
        },
        error: function(response) {
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        }
    });
});
});
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
</script>


</body>
</html>
