<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Thanh Toán</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f2f5;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        .logo {
            font-weight: bold;
            font-size: 24px;
        }
        .vnpay {
            color: #0066cc;
        }
        .v3an {
            color: #ff0000;
        }
        .timer {
            background-color: #333;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        .alert {
            background-color: #fff3cd;
            border-left: 4px solid #ffeeba;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.5;
        }
        .content {
            display: flex;
            gap: 30px;
        }
        .order-info, .qr-code {
            flex: 1;
        }
        h2 {
            color: #0066cc;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .amount {
            color: #0066cc;
            font-weight: bold;
            font-size: 18px;
        }
        .qr-code {
            text-align: center;
        }
        .qr-code img {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px;
        }
        .cancel-btn {
            background-color: #f0f0f0;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            border-radius: 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .cancel-btn:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <span class="vnpay">VNPAY</span>
                <span class="v3an">V3an</span>
            </div>
            <div>Giao dịch hết hạn sau <span class="timer" id="timer">14:51</span></div>
        </div>

        <div class="alert">
            Quý khách vui lòng không tắt trình duyệt cho đến khi nhận được kết quả giao dịch trên website. Trường hợp đã thanh toán nhưng chưa nhận kết quả giao dịch, vui lòng bấm "Tại đây" để nhận kết quả. Xin cảm ơn!
        </div>

        <div class="content">
            <div class="order-info">
                <h2>Thông tin đơn hàng (Test)</h2>
                <div class="info-row">
                    <span>Số tiền thanh toán</span>
                    <span class="amount">10.000<sup>VND</sup></span>
                </div>
                <div class="info-row">
                    <span>Giá trị đơn hàng</span>
                    <span>10.000<sup>VND</sup></span>
                </div>
                <div class="info-row">
                    <span>Phí giao dịch</span>
                    <span>0<sup>VND</sup></span>
                </div>
                <div class="info-row">
                    <span>Mã đơn hàng</span>
                    <span>208324</span>
                </div>
                <div class="info-row">
                    <span>Nhà cung cấp</span>
                    <span>MC CTT VNPAY (Test)</span>
                </div>
            </div>
            <div class="qr-code">
                <h2>Quét mã qua ứng dụng Ngân hàng/Ví điện tử</h2>
                <img src="https://via.placeholder.com/200" alt="QR Code">
                <button class="cancel-btn">Hủy thanh toán</button>
            </div>
        </div>
    </div>

    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }

        window.onload = function () {
            var fifteenMinutes = 60 * 15,
                display = document.querySelector('#timer');
            startTimer(fifteenMinutes, display);
        };
    </script>
</body>
</html>