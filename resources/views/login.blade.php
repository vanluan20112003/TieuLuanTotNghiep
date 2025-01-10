<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">

    <style>
        /* General container styling */
        .form-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            font-weight: 600;
        }

        .box {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out;
        }

        .box:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Styling for buttons */
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .close:hover {
            color: #555;
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            .modal-content {
                width: 100%;
            }
        }
        /* Container chính */
.form-container {
    min-height: 100vh;
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: #f8f9fa;
}

/* Style chung cho form */
form {
    flex: 1;
    min-width: 300px;
    max-width: 450px;
    background: white;
    padding: 2.5rem;
    border-radius: 1rem;
    box-shadow: 0 8px 24px rgba(149, 157, 165, 0.2);
    transition: transform 0.3s ease;
}

form:hover {
    transform: translateY(-5px);
}

/* Tiêu đề form */
h3 {
    font-size: 1.5rem;
    color: #2c3e50;
    text-align: center;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

/* Input fields */
.box {
    width: 100%;
    padding: 1rem;
    margin: 1rem 0;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    font-size: 1rem;
    color: #495057;
    transition: border-color 0.3s ease;
}

.box:focus {
    border-color: #0077b6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
}

/* Button styles */
.btn {
    width: 100%;
    padding: 0.8rem;
    margin: 1rem 0;
    background: #0077b6;
    color: white;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: background 0.3s ease;
}

.btn:hover {
    background: #023e8a;
}

/* Links */
a {
    color: #0077b6;
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover {
    color: #023e8a;
    text-decoration: underline;
}

/* Text alignment */
p {
    text-align: center;
    margin-top: 1rem;
    color: #6c757d;
}

/* File input container */
.input-container {
    margin: 1rem 0;
}

.input-container label {
    display: block;
    margin-bottom: 0.5rem;
    color: #495057;
    font-size: 0.9rem;
}

/* Modal styling */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background: white;
    margin: 5% auto;
    padding: 2rem;
    width: 90%;
    max-width: 600px;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.close {
    position: absolute;
    right: 1.5rem;
    top: 1rem;
    font-size: 2rem;
    cursor: pointer;
    color: #6c757d;
    transition: color 0.3s ease;
}

.close:hover {
    color: #343a40;
}

/* QR reader container */
#qr-reader {
    width: 100%;
    margin: 1rem 0;
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-container {
        padding: 1rem;
    }
    
    form {
        padding: 1.5rem;
        margin: 0.5rem;
    }
    
    .modal-content {
        margin: 10% auto;
        width: 95%;
    }
}
    </style>
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="{{ url('/') }}" class="logo">yum-yum 😋</a>
        <nav class="navbar">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/about') }}">About</a>
            <a href="{{ url('/menu') }}">Menu</a>
            <a href="{{ url('/orders') }}">Orders</a>
            <a href="{{ url('/contact') }}">Contact</a>
        </nav>
        <div class="icons">
            <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
           
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
    </section>
</header>

<section class="form-container">
    <!-- Form 1: Đăng nhập bằng email và mật khẩu -->
    <form id="loginForm">
        @csrf
        <h3>Đăng nhập với email</h3>
        <input type="text" required maxlength="50" name="email" placeholder="Enter your email or user_name" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" required maxlength="20" name="password" placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Login Now" class="btn" name="submit">
        <p>Chưa có tài khoản? <a href="{{ url('/register') }}">Đăng kí ngay</a></p>
    </form>

    <!-- Form 2: Đăng nhập bằng mã QR -->
    <form id="qrLoginForm" enctype="multipart/form-data">
        @csrf
        <h3>Đăng nhập với thẻ đa năng</h3>
        <input type="text" maxlength="50" name="qr_code" id="qr_code" placeholder="Nhập mã QR" class="box">
        <button type="button" id="cardLoginBtn" class="btn">Đăng nhập với thẻ đa năng</button>

        <!-- Tải tệp chứa mã QR -->
        <div class="input-container">
            <label>Tải mã qr của thẻ đa năng ở đây</label>
            <input type="file" id="qr_file_input" name="qr_file" class="box" accept=".txt,.png,.jpg,.jpeg">
        </div>

        <div>
            <button type="button" id="scanQrButton" class="btn">Quét mã thẻ đa năng</button>
        </div>
    </form>
</section>

<!-- Modal quét mã QR -->
<div class="modal" id="qrModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h4>Quét mã QR</h4>
        <div style="width: 100%; max-width: 500px; margin: auto;">
            <div id="qr-reader"></div>
            <div id="qr-reader-results"></div>
        </div>
    </div>
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
<script>
   const loginForm = document.getElementById('loginForm');
    const qrLoginForm = document.getElementById('qrLoginForm');
    const qr_code_input = document.getElementById('qr_code');
    const qrModal = document.getElementById('qrModal');
    const closeModal = document.getElementById('closeModal');
    let html5QrCode;

    // Xử lý đăng nhập bằng email và mật khẩu
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(loginForm);
        fetch("{{ route('login') }}", {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        })
        .catch(error => {
            alert('Có lỗi xảy ra: ' + error.message);
        });
    });

    // Mở modal quét mã QR
    document.getElementById('scanQrButton').addEventListener('click', function() {
        qrModal.style.display = 'flex';
        html5QrCode = new Html5Qrcode("qr-reader");

        // Bắt đầu quét mã QR
        html5QrCode.start(
            { facingMode: "environment" }, 
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText, decodedResult) => {
                qr_code_input.value = decodedText; // Hiển thị mã QR đã quét vào input
                html5QrCode.stop();
                qrModal.style.display = 'none';
            },
            (errorMessage) => {
                // Không làm gì cả
            })
        .catch(err => {
            console.error(err);
        });
    });

    // Đóng modal
    closeModal.addEventListener('click', function() {
        html5QrCode && html5QrCode.stop();
        qrModal.style.display = 'none';
    });

    // Xử lý đăng nhập bằng mã QR
    document.getElementById('cardLoginBtn').addEventListener('click', function() {
        const qrCodeValue = qr_code_input.value;
        if (qrCodeValue) {
            fetch("{{ url('/qr-code-login') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ qr_code: qrCodeValue })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                alert('Có lỗi xảy ra: ' + error.message);
            });
        } else {
            alert("Vui lòng nhập mã QR!");
        }
    });

    // Xử lý tải tệp chứa mã QR (nếu cần)
    document.getElementById('qr_file_input').addEventListener('change', function(event) {
        const input = event.target;
        if ('files' in input && input.files.length > 0) {
            const imageFile = input.files[0]; // Lấy đối tượng File từ input
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.scanFile(imageFile, true)
                .then(decodedText => {
                    qr_code_input.value = decodedText; // Hiển thị mã QR đã quét từ ảnh vào input
                    
                })
                .catch(err => {
                    alert(`Lỗi: ${err}`);
                });
        }
    });
</script>

</body>
</html>
