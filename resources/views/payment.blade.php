<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Phương Thức Thanh Toán</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">

</head>
<body>
    <div class="payment-container">
        <h2>Chọn phương thức thanh toán (Test)</h2>
        <div class="payment-method">
            <div class="method-item">
                <img src="https://via.placeholder.com/50?text=QR" alt="VNPay QR" class="method-icon">
                <span>Ứng dụng thanh toán hỗ trợ VNPay QR</span>
            </div>
            <div class="method-item">
                <img src="https://via.placeholder.com/50?text=Bank" alt="Ngân hàng" class="method-icon">
                <span>Thẻ nội địa và tài khoản ngân hàng</span>
            </div>
            <div class="method-item">
                <img src="https://via.placeholder.com/50?text=Card" alt="Thẻ quốc tế" class="method-icon">
                <span>Thẻ thanh toán quốc tế</span>
            </div>
            <div class="method-item">
                <img src="https://via.placeholder.com/50?text=Wallet" alt="VNPay Wallet" class="method-icon">
                <span>Ví điện tử VNPay</span>
            </div>
        </div>
        <div class="contact-info">
            <p><strong>Điện thoại:</strong> 1900.5555.77</p>
            <p><strong>Email:</strong> hotrovnpay@vnpay.vn</p>
        </div>
        <div class="secure-info">
            <p><img src="https://via.placeholder.com/20?text=Lock" alt="Secure" class="secure-icon"> Secure GlobalSign</p>
            <p><img src="https://via.placeholder.com/20?text=PCI" alt="PCI DSS" class="secure-icon"> PCI DSS Compliant</p>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
