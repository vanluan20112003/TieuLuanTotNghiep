
</php>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/footer.css">
<style>
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
.form-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f6f9fc 0%, #ecf3f9 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

#registerForm {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#registerForm h3 {
    color: #2d3748;
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    letter-spacing: -0.5px;
}

.box {
    width: 100%;
    padding: 1rem 1.2rem;
    margin-bottom: 1.2rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8fafc;
}

.box:focus {
    outline: none;
    border-color: #3182ce;
    background: white;
    box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.1);
}

.box::placeholder {
    color: #a0aec0;
}

/* Remove spinner from number input */
.box[type="number"]::-webkit-inner-spin-button,
.box[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.btn {
    width: 100%;
    padding: 1rem;
    background: #3182ce;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.btn:hover {
    background: #2c5282;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(49, 130, 206, 0.3);
}

.btn:active {
    transform: translateY(0);
}

p {
    text-align: center;
    margin-top: 1.5rem;
    color: #4a5568;
    font-size: 0.95rem;
}

a {
    color: #3182ce;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
}

a:hover {
    color: #2c5282;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-container {
        padding: 1rem;
    }
    
    #registerForm {
        padding: 2rem;
    }
    
    #registerForm h3 {
        font-size: 1.75rem;
    }
}

@media (max-width: 480px) {
    #registerForm {
        padding: 1.5rem;
    }
    
    .box {
        padding: 0.8rem 1rem;
    }
    
    #registerForm h3 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
}

</style>
</head>
<body>
   
<header class="header">

   <section class="flex">

   <a href="{{ url('/') }}" class="logo">yum-yum 😋</a>

<nav class="navbar">
    <a href="{{ url('/') }}">home</a>
    <a href="{{ url('/about') }}">about</a>
    <a href="{{ url('/menu') }}">menu</a>
    <a href="{{ url('/orders') }}">orders</a>
    <a href="{{ url('/contact') }}">contact</a>
</nav>

      <div class="icons">
         <a href="search.html"><i class="fas fa-search"></i></a>
         <a href="cart.html"><i class="fas fa-shopping-cart"></i><span>(3)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <p class="name">shaikh anas</p>
         <div class="flex">
            <a href="profile.html" class="btn">profile</a>
            <a href="#" class="delete-btn">logout</a>
         </div>
         <p class="account"><a href="login.html">login</a> or <a href="register.html">register</a></p>
      </div>

   </section>

</header>


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
      
        <button id="redirectButton" class="btn btn-success">OK</button>
    </div>
@endif
<script>
        document.getElementById('redirectButton').addEventListener('click', function() {
            window.location.href = "{{ url('/login') }}";
        });
    </script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="form-container">
    <form id="registerForm">
        @csrf
        <h3>Register Now</h3>
        <input type="text" required maxlength="20" name="name" placeholder="Enter your name" class="box" value="{{ old('name') }}">
        <input type="text" required maxlength="10" name="user_name" placeholder="Enter your user name" class="box" value="{{ old('user_name') }}">
        <input type="email" required maxlength="50" name="email" placeholder="Enter your email" class="box" value="{{ old('email') }}">
        <input type="number" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" placeholder="Enter your number" required class="box" name="phone_number" value="{{ old('phone_number') }}">
        
        <input type="password" required maxlength="20" name="pass" placeholder="Enter your password" class="box">
        <input type="password" required maxlength="20" name="cpass" placeholder="Confirm your password" class="box">
        <input type="submit" value="Register Now" class="btn" name="submit">
        <p>Already have an account? <a href="{{ url('/login') }}">Login now</a></p>
    </form>
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

<div class="loader">
   <img src="images/loader.gif" alt="">
</div>

<script src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Khôi phục dữ liệu biểu mẫu từ session storage
    const formData = JSON.parse(sessionStorage.getItem('registerFormData'));
    if (formData) {
        $.each(formData, function(key, value) {
            $(`[name=${key}]`).val(value);
        });
    }

    // Lưu dữ liệu biểu mẫu vào session storage khi thay đổi
    $('#registerForm').on('input change', function() {
        const formData = $(this).serializeArray();
        const formObject = {};
        $.each(formData, function() {
            formObject[this.name] = this.value;
        });
        sessionStorage.setItem('registerFormData', JSON.stringify(formObject));
    });

    // Xử lý gửi biểu mẫu qua AJAX
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ url('/register') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                alert(response.message);
                sessionStorage.removeItem('registerFormData'); // Xóa session storage khi đăng ký thành công
                setTimeout(function() {
                    window.location.href = '{{ url("/login") }}';
                }, 2000); // Điều hướng sau 2 giây
            },
            error: function(response) {
                alert('Lỗi: ' + response.responseJSON.message);
            }
        });
    });

    // Xóa session storage khi người dùng điều hướng ra ngoài
    window.addEventListener('beforeunload', function() {
        sessionStorage.removeItem('registerFormData');
    });
});


</script>

</body>
</html>