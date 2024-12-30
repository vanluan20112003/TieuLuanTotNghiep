<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Kết Thanh Toán</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
   .remove-button {
    background-color: #ff4d4d; /* Màu nền đỏ */
    color: white; /* Màu chữ trắng */
    border: none; /* Không viền */
    border-radius: 5px; /* Bo góc */
    padding: 5px 10px; /* Khoảng cách bên trong */
    cursor: pointer; /* Con trỏ chuột thành bàn tay */
    font-size: 12px; /* Kích thước chữ nhỏ */
    margin-top: 10px; /* Khoảng cách phía trên */
}

.remove-button:hover {
    background-color: #ff1a1a; /* Đổi màu khi hover */
}
     
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }
  
  .modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
  }

  .pin-container {
    margin: 20px 0;
  }

  .pin-box {
    text-align: center;
    font-size: 24px;
    width: 100%;
    letter-spacing: 10px;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  .modal-buttons {
    display: flex;
    justify-content: space-around;
  }
        body {
            background-color: #e0f7fa; /* Màu nền xanh nhạt */
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .step-container {
            display: none;
        }
        .btn-secondary {
    width: 100px; /* Đặt chiều rộng cho nút */
}

.suggestion-buttons {
    margin: 10px 0;
}

.btn-outline-primary {
    flex: 1; /* Chiếm đều chiều rộng trong hàng */
}
        .step-container.active {
            display: block;
        }
        .step-box {
            background-color: #ffffff;
            border: 1px solid #00796b;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .step-box:hover {
            background-color: #00796b;
            color: #fff;
            transform: scale(1.05);
        }
        .step-box .plus-icon {
            font-size: 50px;
            color: #00796b;
        }
        .step-header {
            margin-bottom: 30px;
            color: #00796b;
            text-align: center;
        }
        .card-types img {
            width: 100px;
            cursor: pointer;
            margin: 10px;
            transition: transform 0.3s ease;
        }
        .card-types img:hover {
            transform: scale(1.1);
        }
        .bank-list img {
            width: 120px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .bank-list img:hover {
            transform: scale(1.1);
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .bank-logo {
            float: right;
            width: 150px;
        }
        .btn-back {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #004d40;
        }
        .btn-primary {
            background-color: #00796b;
            border-color: #00796b;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #004d40;
            border-color: #004d40;
        }
        
    </style>
</head>
<body>

    <!-- Bước 1: Chọn phương thức thanh toán -->
    <div id="step-1" class="step-container active">
    <h2 class="step-header">Bước 1: Chọn Phương Thức Thanh Toán</h2>
    <div class="row">
    <div class="col-md-6">
        <div class="step-box" onclick="selectPaymentMethod(1)">
            @if(!empty($theDaNang->pp_thanh_toan_1))
                <p>{{ $theDaNang->pp_thanh_toan_1 }}</p>
                <p>Mã thẻ: {{ $theDaNang->ma_the_1 }}</p>
                <button class="remove-button" onclick="removePaymentMethod(1, event)">Loại bỏ</button>
            @else
                <p>Phương thức thanh toán 1</p>
                <p>Bạn chưa có phương thức thanh toán nào.</p>
                <span class="plus-icon">+</span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="step-box" onclick="selectPaymentMethod(2)">
            @if(!empty($theDaNang->pp_thanh_toan_2))
                <p>{{ $theDaNang->pp_thanh_toan_2 }}</p>
                <p>Mã thẻ: {{ $theDaNang->ma_the_2 }}</p>
                <button class="remove-button" onclick="removePaymentMethod(2, event)">Loại bỏ</button>
            @else
                <p>Phương thức thanh toán 2</p>
                <p>Bạn chưa có phương thức thanh toán nào.</p>
                <span class="plus-icon">+</span>
            @endif
        </div>
    </div>
</div>

</div>



    <!-- Bước 2: Chọn loại thẻ -->
    <div id="step-2" class="step-container">
        <h2 class="step-header">Bước 2: Chọn Loại Thẻ</h2>
        <div class="card-types text-center">
            <img src="images/napas.png" alt="Napas" onclick="goToStep(3)">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" data-bank="Visa" onclick="handleBankSelection(this)">

        </div>
        <button class="btn btn-back mt-3" onclick="goBack(1)">Trở về</button>
    </div>

    <!-- Bước 3: Chọn ngân hàng (chỉ hiện khi chọn Napas) -->
    <div id="step-3" class="step-container">
    <h2 class="step-header">Bước 3: Chọn Ngân Hàng</h2>
    <div class="bank-list text-center">
        <img src="images/agribank.png" alt="Bank 1" data-bank="Agribank" onclick="selectBank(this)">
        <img src="images/BIDV.png" alt="Bank 2" data-bank="BIDV" onclick="selectBank(this)">
        <!-- Thêm các ngân hàng tương tự -->
    </div>
    <button class="btn btn-back mt-3" onclick="goBack(2)">Trở về</button>
</div>


    <!-- Bước 4: Nhập thông tin thẻ -->
    <div id="step-4" class="step-container">
    <h2 class="step-header">Bước 4: Nhập Thông Tin Thẻ</h2>
    <div class="row" style="align-items: center;"> <!-- Căn giữa các phần tử -->
        <div class="col-md-8">
            <div class="form-container">
                <form>
                    <div class="form-group">
                        <label for="cardholder-name">Tên Chủ Thẻ:</label>
                        <input type="text" class="form-control" id="cardholder-name" required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Số Thẻ:</label>
                        <input type="text" class="form-control" id="card-number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry-date">Ngày Phát Hành:</label>
                        <input type="text" class="form-control" id="expiry-date" required placeholder="mm/yy">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onclick="confirmCardInfo()">Xác Nhận</button>

                </form>
            </div>
        </div>
        <div class="" style="margin-left: -20px;"> <!-- Đưa logo ngân hàng sát hơn -->
            <img id="bank-logo" class="bank-logo" src="bank1.png" alt="Bank Logo" style="width: 300px; height: 200px;"> <!-- Giữ kích thước hình ảnh 100% -->
        </div>
    </div>
    <button class="btn btn-back mt-3" onclick="goBack(3)">Trở về</button>
</div>








<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

function confirmTransaction() {
    // Hiển thị hộp thoại nhập mã PIN
    const amount = document.getElementById('amount').value;
    const amountError = document.getElementById('amount-error');
    if (amount === '' || amount <= 0) {
        amountError.style.display = 'block';
        return; // Dừng lại nếu số tiền không hợp lệ
    } else {
        amountError.style.display = 'none'; // Ẩn lỗi nếu số tiền hợp lệ
    }
    const pin = prompt("Vui lòng nhập mã PIN (6 chữ số):");
   
    // Kiểm tra mã PIN có hợp lệ không (chỉ cho phép nhập 6 chữ số)
    if (pin && /^\d{6}$/.test(pin)) {
        // Gửi yêu cầu AJAX để kiểm tra mã PIN
        checkPinCode(pin)
        .then(isPinValid => {
            if (isPinValid) {
                // Mã PIN hợp lệ, tiếp tục hiển thị chi tiết giao dịch
                const transactionType = document.querySelector('input[name="transactionType"]:checked').value;
                const amount = document.getElementById('amount').value;
                const paymentMethod = document.getElementById('pp_thanh_toan').value;

                if (amount > 0) {
                    const confirmMessage = `
                        Bạn đang thực hiện giao dịch: ${transactionType === 'nap' ? 'Nạp tiền' : 'Rút tiền'}\n
                        Tài khoản nguồn: ${paymentMethod}\n
                        Số tiền: ${amount}\n
                        Bạn có muốn tiếp tục?
                    `;
                    
                    // Xác nhận lần cuối từ người dùng
                    if (confirm(confirmMessage)) {
                        // Gửi yêu cầu xác nhận đến server để xử lý giao dịch
                        submitTransaction(transactionType, amount, pin);
                    }
                } else {
                    alert("Vui lòng nhập số tiền hợp lệ.");
                }
            } else {
                alert("Mã PIN không chính xác. Vui lòng thử lại.");
            }
        })
        .catch(error => {
            console.error("Lỗi khi kiểm tra mã PIN:", error);
            alert("Đã xảy ra lỗi khi kiểm tra mã PIN. Vui lòng thử lại sau.");
        });
    } else {
        alert("Mã PIN không hợp lệ. Vui lòng nhập lại.");
    }
}

function checkPinCode(pin) {
    // Hàm gửi AJAX để kiểm tra mã PIN từ server
    return fetch('http://localhost/web_ban_banh_kem/public/transaction/check-pin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ pin: pin })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            return true;  // Mã PIN đúng
        } else {
            return false; // Mã PIN sai
        }
    })
    .catch(error => {
        console.error('Lỗi khi kiểm tra mã PIN:', error);
        throw error;
    });
}

function submitTransaction(transactionType, amount, pin) {
    // Gửi yêu cầu AJAX đến server để xử lý giao dịch
    fetch('http://localhost/web_ban_banh_kem/public/transaction/confirm', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            transactionType: transactionType,
            amount: amount,
            pin: pin
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Giao dịch thành công!");
            // Có thể chuyển hướng hoặc cập nhật thông tin trên giao diện
        } else {
            alert("Giao dịch thất bại: " + data.message);
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
}

    function confirmCardInfo() {
    // Lấy giá trị từ các trường nhập liệu
    const cardholderName = $('#cardholder-name').val();
    const cardNumber = $('#card-number').val();
    const expiryDate = $('#expiry-date').val();

    // Xác nhận thông tin ngân hàng đã chọn
    const paymentMethod = selectedBank; // Tên ngân hàng đã chọn

    // Dữ liệu gửi lên máy chủ
    const data = {
        qr_code: "", // Nếu có giá trị QR code, bạn có thể thêm vào đây
        so_du: 0, // Giá trị mặc định hoặc giá trị từ phiên làm việc
        pp_thanh_toan_1: paymentMethod,
        ma_the_1: cardNumber,
        pp_thanh_toan_2:paymentMethod, // Hoặc bạn có thể để trống
        ma_the_2: cardNumber,
        pin_code: "", // Nếu có pin code, bạn có thể thêm vào đây
        created_at: new Date(),
        updated_at: new Date()
    };

    // Lấy mã thông báo CSRF từ meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Gửi yêu cầu AJAX
    $.ajax({
        url: "http://localhost/web_ban_banh_kem/public/update_card",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': csrfToken // Thêm mã thông báo CSRF vào tiêu đề
        },
        success: function(response) {
            // Hiển thị thông báo thành công
            alert("Thông tin thẻ đã được lưu thành công!");
            // Tải lại trang link_payment
            window.location.reload(); // Hoặc sử dụng: window.location.href = 'http://localhost/web_ban_banh_kem/public/link_payment';
        },
        error: function(xhr, status, error) {
            console.error("Lỗi khi lưu thông tin thẻ:", xhr.responseText);
            alert("Có lỗi xảy ra khi lưu thông tin thẻ. Vui lòng thử lại."); // Thông báo lỗi
        }
    });
}


let selectedBank = '';

function handleBankSelection(element) {
    selectBank(element); // Gọi hàm selectBank
    goToStep(4); // Sau đó chuyển sang bước 4
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    // Cho phép nhập số từ 0 đến 9 và dấu gạch chéo '/'
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 47) {
        return false;
    }
    return true;
}

function selectBank(element) {
    selectedBank = element.getAttribute('data-bank'); // Lấy giá trị ngân hàng đã chọn
    goToStep(4); // Chuyển sang bước 4
}

function goToStep(step) {
    document.querySelectorAll('.step-container').forEach(function (el) {
        el.classList.remove('active');
    });

    if (step === 4||step===5) {
        // Thay đổi logo ngân hàng dựa trên giá trị đã chọn
        const bankLogo = document.getElementById('bank-logo');
        
        // Cập nhật đường dẫn logo theo ngân hàng đã chọn
        switch(selectedBank) {
            case 'Agribank':
                bankLogo.src = 'images/agribank-card.png';
                break;
            case 'BIDV':
                bankLogo.src = 'images/BIDV-card.png';
                break;
            // Thêm các ngân hàng khác ở đây
            case 'Visa':
                bankLogo.src = 'images/visa-card.png';
                break;
            default:
                bankLogo.src = ''; // Không có logo mặc định
                break;
        }

        // Hiển thị logo ngân hàng
        if (bankLogo.src) {
            bankLogo.style.display = 'block'; // Hiện logo nếu có
        } else {
            bankLogo.style.display = 'none'; // Ẩn logo nếu không có
        }

        console.log("Ngân hàng đã chọn: " + selectedBank); // Bạn có thể sử dụng giá trị này theo ý muốn
    }
    
    document.getElementById('step-' + step).classList.add('active');
}

function goBack(step) {
    goToStep(step);
}

let selectedPayment = {}; // Biến để lưu thông tin phương thức thanh toán

function selectPaymentMethod(paymentMethod) {
    // Kiểm tra phương thức thanh toán và chuyển đến bước tương ứng
    if (paymentMethod === 1 && '{{ !empty($theDaNang->pp_thanh_toan_1) }}') {
        selectedPayment = {
            pp_thanh_toan: '{{ $theDaNang->pp_thanh_toan_1 }}',
            ma_the: '{{ $theDaNang->ma_the_1 }}'
        };
        updatePaymentInfo(); // Cập nhật thông tin ngay
        goToStep(5); // Nếu có phương thức thanh toán 1, chuyển đến bước 5
    } else if (paymentMethod === 2 && '{{ !empty($theDaNang->pp_thanh_toan_2) }}') {
        selectedPayment = {
            pp_thanh_toan: '{{ $theDaNang->pp_thanh_toan_2 }}',
            ma_the: '{{ $theDaNang->ma_the_2 }}'
        };
        updatePaymentInfo(); // Cập nhật thông tin ngay
        goToStep(5); // Nếu có phương thức thanh toán 2, chuyển đến bước 5
    } else {
        goToStep(2); // Nếu không có phương thức thanh toán, chuyển đến bước 2
    }
}

function updatePaymentInfo() {
    const paymentMethod = document.getElementById('pp_thanh_toan');
    const cardCode = document.getElementById('ma_the');
    
    // Cập nhật giá trị cho pp_thanh_toan và ma_the
    paymentMethod.value = selectedPayment.pp_thanh_toan || 'Chưa có thông tin';
    cardCode.value = selectedPayment.ma_the || 'Chưa có mã thẻ';
}

// Hàm để chọn hành động nạp hoặc rút
function selectAction(action) {
    actionType = action; // Lưu loại hành động
    console.log(`Chọn hành động: ${actionType}`);
    updatePaymentInfo(); // Cập nhật thông tin mỗi khi hành động được chọn
}

function suggestAmount(amount) {
    // Lấy ô nhập số tiền
    const amountInput = document.getElementById('amount');
    
    // Đặt giá trị ô nhập thành số tiền đã chọn
    amountInput.value = amount; // Ghi đè giá trị ô nhập với số tiền đã chọn
}
function removePaymentMethod(methodNumber, event) {
    event.stopPropagation(); // Ngăn chặn sự kiện onclick của step-box

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Xác nhận trước khi xóa
    if (confirm("Bạn có chắc chắn muốn xóa phương thức thanh toán này?")) {
        $.ajax({
            url: `http://localhost/web_ban_banh_kem/public/remove-payment-method/${methodNumber}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Thêm CSRF token vào headers
            },
            success: function(response) {
                // Cập nhật giao diện sau khi xóa
                alert(response.message); // Thông báo thành công
                location.reload(); // Làm mới trang hoặc cập nhật lại giao diện
            },
            error: function(xhr) {
                // Kiểm tra lỗi cụ thể
                if (xhr.status === 404) {
                    alert('Không tìm thấy phương thức thanh toán.');
                } else if (xhr.status === 419) {
                    alert('Phiên làm việc đã hết hạn. Vui lòng làm mới trang.');
                } else {
                    alert('Có lỗi xảy ra khi xóa phương thức thanh toán.');
                }
            }
        });
    }
}



    </script>

</body>
</html>
