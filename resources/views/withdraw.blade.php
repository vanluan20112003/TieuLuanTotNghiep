<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nạp/Rút Tiền</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #22c55e;
            --danger: #ef4444;
            --background: #f8fafc;
            --card: #ffffff;
            --text: #334155;
            --border: #e2e8f0;
        }

        body {
            background: var(--background);
            background-image: linear-gradient(135deg, #f0f7ff 0%, #f8fafc 100%);
            min-height: 100vh;
            padding: 40px 20px;
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--card);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .payment-info {
            background: var(--background);
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 1px solid var(--border);
        }

        .payment-info h3 {
            color: var(--primary);
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-info h3::before {
            content: '';
            display: block;
            width: 4px;
            height: 24px;
            background: var(--primary);
            border-radius: 2px;
        }

        .bank-info {
            margin-bottom: 30px;
            padding: 20px;
            background: var(--card);
            border-radius: 8px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .bank-info:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transform: translateX(5px);
        }

        .bank-info strong {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .bank-info p {
            margin: 8px 0;
        }

        .momo-section {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-top: 20px;
        }

        .qr-code {
            width: 350px;
            height: 300px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: var(--secondary);
            border: 2px solid var(--border);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .qr-code::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }

        .form-group {
            margin-bottom: 25px;
        }

        .radio-group {
            display: flex;
            gap: 30px;
            margin: 15px 0;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 8px;
            background: var(--background);
            transition: all 0.3s ease;
        }

        .radio-label:hover {
            background: #eef2ff;
        }

        .radio-label input[type="radio"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--secondary);
            border-radius: 50%;
            margin: 0;
            position: relative;
            transition: all 0.2s ease;
        }

        .radio-label input[type="radio"]:checked {
            border-color: var(--primary);
        }

        .radio-label input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            animation: radioSelect 0.2s ease;
        }

        @keyframes radioSelect {
            from { transform: translate(-50%, -50%) scale(0); }
            to { transform: translate(-50%, -50%) scale(1); }
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: var(--text);
            font-weight: 500;
            font-size: 1.1rem;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--background);
            color: var(--text);
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        input[type="file"] {
            padding: 8px;
            background: var(--background);
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            background: var(--primary);
            color: white;
            cursor: pointer;
            margin-right: 16px;
            transition: all 0.3s ease;
        }

        input[type="file"]::file-selector-button:hover {
            background: var(--primary-dark);
        }

        button {
            background: var(--primary);
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        button:active {
            transform: translateY(0);
        }

        button::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        button:hover::after {
            left: 100%;
        }

        .hidden {
            display: none;
        }

        /* Animation cho messages */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .message.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .momo-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
        .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .toast.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .toast.hidden {
        display: none;
    }
    .copy-btn {
        border: none;
        background: #f0f0f0;
        color: #555;
        cursor: pointer;
        border-radius: 4px;
        padding: 5px 10px;
        font-size: 16px;
        transition: background-color 0.3s, color 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .copy-btn:hover {
        background: #ddd;
        color: #000;
    }

    .copy-btn i {
        font-size: 18px;
    }
    .note {
        background-color: #f9f9f9;
        border-left: 4px solid #007bff;
        padding: 10px 15px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #333;
    }

    .note strong {
        color: #007bff;
    }
    .card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 24px;
      width: 340px;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    .card-header {
      margin-bottom: 20px;
    }

    .card-id {
      color: #6b7280;
      font-size: 14px;
      margin-bottom: 4px;
    }

    .card-name {
      color: #111827;
      font-size: 24px;
      font-weight: bold;
      margin: 0;
    }

    .card-balance {
      background: #f3f4f6;
      border-radius: 12px;
      padding: 16px;
      margin-top: 16px;
    }

    .balance-label {
      color: #6b7280;
      font-size: 14px;
      margin-bottom: 4px;
    }

    .balance-amount {
      color: #047857;
      font-size: 28px;
      font-weight: bold;
      margin: 0;
    }

    .card-footer {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid #e5e7eb;
    }

    .last-updated {
      color: #6b7280;
      font-size: 12px;
      text-align: right;
    }
    /* Định dạng modal */
/* Định dạng modal */
/* Đảm bảo modal được hiển thị ở giữa */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền tối */
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}


.pin-inputs {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.pin-input {
    width: 40px;
    height: 40px;
    text-align: center;
    font-size: 24px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s;
    -webkit-text-security: disc; /* Ẩn nội dung nhập vào */
}

.pin-input:focus {
    border-color: #007bff;
}

.pin-input.correct {
    border-color: #28a745; /* Màu xanh khi đúng */
}

/* Hiệu ứng rung lắc */
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}

.pin-input.incorrect {
    border-color: #dc3545; /* Màu đỏ khi sai */
    animation: shake 1s ease; /* Áp dụng hiệu ứng rung lắc */
}


.submit-btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: inline-flex;
    align-items: center;
}

.submit-btn svg {
    margin-left: 8px;
}

.submit-btn:hover {
    background-color: #0056b3;
}

/* Định dạng nút và radio */
.form-group {
    margin-bottom: 20px;
}

.radio-group {
    display: flex;
    justify-content: space-around;
}

.radio-label {
    font-size: 16px;
}

input[type="number"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.pin-input.correct {
    border-color: #28a745; /* Màu xanh khi đúng */
}

.pin-input.incorrect {
    border-color: #dc3545; /* Màu đỏ khi sai */
}
.card-container {
    display: flex;
    justify-content: space-between;
    width: 100%;
    gap: 20px; /* Khoảng cách giữa card và pending transactions */
}/* Style for pending transactions section */
.pending-transactions {
    width: 320px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 24px;
    flex-shrink: 0; /* Đảm bảo phần pending transactions không bị co lại */
}

.pending-title {
    color: #111827;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 16px;
}

.transaction-list {
    list-style-type: none;
    padding: 0;
}

.transaction-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.transaction-type {
    color: #4a5568;
    font-size: 14px;
}

.transaction-amount {
    color: #e53e3e;
    font-size: 14px;
}

.no-transactions {
    color: #6b7280;
    font-size: 14px;
}
.pending-transactions {
    background-color: #f9fafb;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.pending-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
    color: #111827;
}

.transaction-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.transaction-item {
    background-color: white;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: transform 0.2s ease;
}

.transaction-item:hover {
    transform: translateY(-4px);
}

.transaction-info {
    display: flex;
    flex-direction: column;
    font-weight: 600;
}

.transaction-type {
    font-size: 16px;
    color: #047857;
}

.transaction-amount {
    font-size: 14px;
    color: #6b7280;
}

.transaction-details {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.transaction-status {
    font-size: 12px;
    color: #ff9800;
    margin-bottom: 8px;
}

.transaction-time {
    font-size: 12px;
    color: #6b7280;
}

.cancel-button {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 6px 14px;
    font-size: 12px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.cancel-button:hover {
    background-color: #d32f2f;
}

.no-transactions {
    font-size: 14px;
    color: #6b7280;
    text-align: center;
    margin-top: 20px;
}
.back-icon {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #666;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.back-icon:hover {
    color: #333;
}

.note {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 15px 15px 15px 40px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 10px;
}

.note p {
    margin: 0;
    line-height: 1.6;
    color: #495057;
}

.note strong {
    color: #007bff;
}
textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    textarea {
        resize: none;
    }
    </style>
</head>
<body>
<div class="container">
    <!-- Chú thích -->
    <div class="note-container">
    <i class="fas fa-arrow-left back-icon" onclick="history.back()"></i>
    <div class="note">
        <p>
            <strong>Chú ý:</strong> Nếu cần nạp tiền, vui lòng chuyển khoản vào số tài khoản dưới đây hoặc quét mã QR. Sau khi chuyển khoản, gửi minh chứng lại cho chúng tôi để kiểm tra. Thời gian kiểm duyệt tối đa là <strong>15 phút</strong>.
        </p>
    </div>
</div>

    <div class="payment-info">
        <h3>Thông tin thanh toán</h3>

        <!-- Ngân hàng Agribank -->
        <div class="bank-info">
            <p><strong>Ngân hàng Agribank:</strong></p>
            <p>
                Số tài khoản: 5506205313590
                <button class="copy-btn" onclick="copyToClipboard('5506205313590')">
                    <i class="fas fa-copy"></i>
                </button>
            </p>
            <p>Tên: LuanHospital</p>
           <div class="momo-section">
                    <div class="qr-code">
                    <img src="images/image.png" alt="QR Ngân hàng" class="qr-image">
                    </div>
                    <div>
                        <p>Quét mã QR để thanh toán nhanh qua ngân hàng </p>
                    </div>
                </div>
        </div>

        <!-- Ví Momo -->
        <div class="bank-info">
            <p><strong>Ví Momo:</strong></p>
            <p>
                Số điện thoại: 0352231271
                <button class="copy-btn" onclick="copyToClipboard('0352231271')">
                    <i class="fas fa-copy"></i>
                </button>
            </p>
            <p>Tên: LuanHospital</p>
           
        </div>
    </div>
    <div class="card-container">
    <div class="card">
        <div class="card-header">
            <!-- Hiển thị mã thẻ -->
            <div class="card-id">Mã thẻ: #{{ $theDaNang->id }}</div>
            <!-- Hiển thị tên người dùng -->
            <h2 class="card-name">{{ $userName }}</h2>
        </div>
        
        <div class="card-body">
            <div class="card-balance">
                <!-- Hiển thị nhãn số dư -->
                <div class="balance-label">Số dư hiện tại</div>
                <!-- Hiển thị số dư của thẻ -->
                <p class="balance-amount">{{ $theDaNang->formatted_balance }}</p>
            </div>
        </div>

        <div class="card-footer">
            <!-- Hiển thị thời gian cập nhật cuối -->
            <div class="last-updated">Cập nhật lúc: {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <!-- Giao dịch đang chờ -->
    <div class="pending-transactions">
    <h3 class="pending-title">Giao dịch đang chờ</h3>
    @if(count($pendingTransactions) > 0)
        <ul class="transaction-list">
            @foreach($pendingTransactions as $transaction)
                <li class="transaction-item">
                    <div class="transaction-info">
                        <span class="transaction-type">
                            <!-- Thêm icon cho loại giao dịch -->
                            @if($transaction->transaction_type == 'nap')
                                <i class="fa fa-arrow-down"></i> Nạp tiền
                            @else
                                <i class="fa fa-arrow-up"></i> Rút tiền
                            @endif
                        </span>
                        <span class="transaction-amount">{{ number_format($transaction->amount, 0) }} VND</span>
                    </div>
                    <div class="transaction-details">
                        <!-- Thay đổi trạng thái thành "Chờ duyệt" -->
                        <span class="transaction-status">
                            <i class="fa fa-clock"></i> Chờ duyệt
                        </span>
                        <span class="transaction-time">
                            {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <!-- Nút hủy giao dịch -->
                    <form action="" method="POST" class="cancel-form" style="display: inline;" data-id="{{ $transaction->id }}">
    @csrf
    @method('DELETE')
    <button type="button" class="cancel-button">
        <i class="fa fa-times"></i> Hủy
    </button>
</form>

                </li>
            @endforeach
        </ul>
    @else
        <p class="no-transactions">Không có giao dịch nào đang chờ.</p>
    @endif
</div>


</div>

    <!-- Form yêu cầu giao dịch -->
    <form id="paymentForm">
    <div class="form-group">
        <label>Loại giao dịch:</label>
        <div class="radio-group">
            <label class="radio-label">
                <input type="radio" name="transactionType" value="deposit" checked>
                Nạp tiền
            </label>
            <label class="radio-label">
                <input type="radio" name="transactionType" value="withdraw">
                Rút tiền
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Số tiền:</label>
        <input type="number" id="amount" required placeholder="Nhập số tiền">
    </div>
    <div id="bankInfoContainer" class="form-group hidden">
    <label>Thông tin ngân hàng:</label>
    <textarea id="bankInfo" rows="4" required placeholder="Nhập thông tin ngân hàng: 
Tên chủ tài khoản, số tài khoản, tên ngân hàng"></textarea>
</div>


    <div id="depositFields" class="form-group">
        <label>Minh chứng thanh toán:</label>
        <input type="file" id="proofUpload" accept="image/*" required>
    </div>

    <button type="button" class="submit-btn" id="openPinModal">
        Gửi yêu cầu
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
    </button>
</form>
</div>

    <div id="toast" class="toast hidden">Đã sao chép!</div>
 
  <!-- Modal nhập mã PIN -->
<div class="modal" id="pinModal">
    <div class="modal-content">
        <h2>Nhập mã PIN</h2>
        <div class="pin-inputs">
            <input type="password" maxlength="1" class="pin-input" id="pin1">
            <input type="password" maxlength="1" class="pin-input" id="pin2">
            <input type="password" maxlength="1" class="pin-input" id="pin3">
            <input type="password" maxlength="1" class="pin-input" id="pin4">
            <input type="password" maxlength="1" class="pin-input" id="pin5">
            <input type="password" maxlength="1" class="pin-input" id="pin6">
        </div>
    </div>
</div>

</div>
    <script>
        const form = document.getElementById('paymentForm');
        const depositFields = document.getElementById('depositFields');
        const radioButtons = document.getElementsByName('transactionType');

        // Xử lý hiện/ẩn trường upload file
        radioButtons.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'deposit') {
                    depositFields.classList.remove('hidden');
                    bankInfoContainer.classList.add('hidden');
                   
                } else {
                    depositFields.classList.add('hidden');
                    bankInfoContainer.classList.remove('hidden');
                }
            });
        });

        // Tạo message
        function showMessage(text, type) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}`;
            messageDiv.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    ${type === 'success' 
                        ? '<path d="M20 6L9 17l-5-5"/>' 
                        : '<path d="M18 6L6 18M6 6l12 12"/>'}
                </svg>
                ${text}
            `;
            form.insertBefore(messageDiv, form.firstChild);
            setTimeout(() => messageDiv.remove(), 3000);
        }

        // Xử lý submit form
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const transactionType = document.querySelector('input[name="transactionType"]:checked').value;
            const amount = document.getElementById('amount').value;
            const fileInput = document.getElementById('proofUpload');

            if (!amount) {
                showMessage('Vui lòng nhập số tiền', 'error');
                return;
            }

            if (transactionType === 'deposit' && !fileInput.files[0]) {
                showMessage('Vui lòng upload minh chứng thanh toán', 'error');
                return;
            }

            showMessage(`Đã gửi yêu cầu ${transactionType === 'deposit' ? 'nạp' : 'rút'} tiền: ${amount}đ thành công!`, 'success');
            form.reset();
        });
        function copyToClipboard(text) {
        // Tạo một phần tử input ẩn
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // Dành cho một số trình duyệt cũ
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        // Hiển thị toast
        showToast('Đã sao chép: ' + text);
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.add('visible');

        // Ẩn toast sau 3 giây
        setTimeout(() => {
            toast.classList.remove('visible');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300); // Thời gian trễ để đảm bảo hiệu ứng mượt
        }, 3000);
    }
    // Mở modal khi bấm vào nút "Gửi yêu cầu"
// Mở modal khi bấm vào nút "Gửi yêu cầu" (hoặc nút mở modal của bạn)
// Mở modal khi bấm vào nút "Gửi yêu cầu"
document.getElementById("openPinModal").addEventListener("click", function() {
    // Kiểm tra loại giao dịch đã chọn
    const transactionType = document.querySelector('input[name="transactionType"]:checked').value;
    const amount = document.getElementById("amount").value;

    // Kiểm tra các trường nhập liệu
    if (!amount || amount <= 0) {
        alert("Vui lòng nhập số tiền.");
        return;
    }

    if (transactionType === "deposit") {
        // Nếu là giao dịch nạp tiền, kiểm tra minh chứng thanh toán
        const proofFile = document.getElementById("proofUpload").files.length;
        if (proofFile === 0) {
            alert("Vui lòng tải lên hóa đơn thanh toán.");
            return;
        }
    }
    if (transactionType === "withdraw") {
        // Nếu là giao dịch nạp tiền, kiểm tra minh chứng thanh toán
        const bankInfo= document.getElementById("bankInfo");
        if ((!bankInfo.value || bankInfo.value.trim() === "")) {
            alert("Vui lòng nhập thông tin ngân hàng rút về, nếu muốn xuống căn tin nhận thì ghi 'không'.");
            return;
    }
}
    fetch('http://localhost/web_ban_banh_kem/public/check-transaction-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ transactionType: transactionType, amount: amount })
    })
    .then(response => response.json())
    .then(data => {
        // Kiểm tra kết quả trả về
        if (data.error) {
            alert(data.error); // Hiển thị thông báo lỗi
        } else {
            // Mở modal nhập mã PIN nếu không có lỗi
            document.getElementById("pinModal").style.display = "flex";
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
    });
});

// Đảm bảo chỉ nhập số vào các ô PIN
document.querySelectorAll(".pin-input").forEach((input, index) => {
    input.addEventListener("input", function (e) {
        // Nếu nhập không phải số, xóa nội dung
        if (!/^\d$/.test(e.target.value)) {
            e.target.value = "";
        }

        // Khi nhập đúng số, chuyển qua ô tiếp theo
        if (e.target.value && index < 5) {
            document.querySelector(`#pin${index + 2}`).focus();
        }

        // Khi đủ 6 số
        if (isPinComplete()) {
            const pin = [];
            document.querySelectorAll(".pin-input").forEach(input => {
                pin.push(input.value);
            });

            // Gửi mã PIN đến controller để kiểm tra
            fetch('http://localhost/web_ban_banh_kem/public/verify-pin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ pin: pin.join('') })
            })
                .then(response => response.json())
                .then(data => {
                    // Kiểm tra mã PIN hợp lệ
                    if (data.success) {
                        // Nếu đúng, làm viền các ô màu xanh
                        setPinValidity(true);
                        alert("Mã PIN hợp lệ!");
                        document.getElementById("pinModal").style.display = "none";

                        // Hiển thị hộp thoại xác nhận giao dịch
                        confirmTransaction();
                    } else {
                        // Nếu sai, làm viền các ô màu đỏ
                        setPinValidity(false);
                        alert("Mã PIN sai!");
                    }

                    // Trì hoãn 1.5 giây trước khi xóa hết các ô nhập
                    setTimeout(function () {
                        clearPinInputs();
                    }, 1500); // Thời gian trì hoãn là 1500ms (1.5 giây)
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                });
        }
    });
});


// Kiểm tra khi nhập đủ 6 ô
function isPinComplete() {
    return Array.from(document.querySelectorAll(".pin-input")).every(input => input.value !== "");
}

// Thay đổi viền các ô nhập vào theo kết quả đúng hay sai
function setPinValidity(isValid) {
    document.querySelectorAll(".pin-input").forEach((input, index) => {
        if (isValid) {
            input.classList.add("correct");
            input.classList.remove("incorrect");
        } else {
            input.classList.add("incorrect");
            input.classList.remove("correct");
        }
    });
}

// Xóa hết các ô nhập
function clearPinInputs() {
    document.querySelectorAll(".pin-input").forEach(input => {
        input.value = "";
        input.classList.remove("correct", "incorrect");
    });
}

// Đóng modal khi bấm ra ngoài
window.onclick = function(event) {
    if (event.target === document.getElementById("pinModal")) {
        document.getElementById("pinModal").style.display = "none";
    }
};
function confirmTransaction() {
    // Lấy thông tin giao dịch từ form
    const transactionType = document.querySelector('input[name="transactionType"]:checked').value; // 'deposit' hoặc 'withdraw'
    const amount = document.querySelector('#amount').value; // Số tiền
    const evidence = document.querySelector('#proofUpload'); // File minh chứng (chỉ dùng cho nạp tiền)
    const bankInfo = document.querySelector('#bankInfo').value;
    // Kiểm tra dữ liệu nhập vào
    if (!amount || amount <= 0) {
        alert("Vui lòng nhập số tiền hợp lệ.");
        return;
    }

    if (transactionType === 'deposit' && (!evidence.files || evidence.files.length === 0)) {
    alert("Vui lòng tải lên minh chứng thanh toán.");
    return;
} else if (transactionType === 'withdraw' && (!bankInfo || bankInfo.trim() === "")) {
    alert("Vui lòng nhập thông tin ngân hàng rút về, nếu muốn xuống căn tin nhận thì ghi 'không'.");
    return;
}


    // Xác nhận thông tin giao dịch
    let confirmMessage = `Loại giao dịch: ${transactionType === 'deposit' ? 'Nạp tiền' : 'Rút tiền'}\n`;
    confirmMessage += `Số tiền: ${amount} VND\n`;

    if (transactionType === 'deposit' && evidence.files.length > 0) {
        confirmMessage += `Minh chứng: ${evidence.files[0].name}\n`;
        
    }
    if (transactionType === 'withdraw' && bankInfo) {
        confirmMessage += `Thông tin ngân hàng nhận: ${bankInfo}\n`;
    }

    confirmMessage += "Bạn có chắc chắn muốn thực hiện giao dịch này không?";
    const userConfirmed = confirm(confirmMessage);

    if (userConfirmed) {
        // Nếu người dùng đồng ý, thực hiện giao dịch
        handleTransaction(transactionType, amount, evidence);
    }
}

function handleTransaction(transactionType, amount, evidence) {
    // Chuyển đổi giá trị transactionType
    const mappedTransactionType = transactionType === 'deposit' ? 'nap' : 'rut';

    const formData = new FormData();
    formData.append('transaction_type', mappedTransactionType); // Sử dụng giá trị đã chuyển đổi
    formData.append('amount', amount);

    if (mappedTransactionType === 'nap' && evidence.files.length > 0) {
        formData.append('evidence', evidence.files[0]);
    }
    if (mappedTransactionType === 'rut') {
    const bankInfoValue = bankInfo.value; // Loại bỏ khoảng trắng thừa
    if (bankInfoValue === "") {
        alert("Vui lòng nhập thông tin ngân hàng rút về, nếu muốn xuống căn tin nhận thì ghi 'không'.");
        return;
    }
    formData.append('bank_info', bankInfoValue); // Thêm thông tin ngân hàng vào FormData
}
    fetch('http://localhost/web_ban_banh_kem/public/handle-transaction', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: formData
})
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Hiển thị thông báo
            location.reload(); // Tải lại trang sau khi nhấn "OK"
        } else {
            alert("Đã xảy ra lỗi, vui lòng thử lại sau.");
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Đã xảy ra lỗi, vui lòng thử lại sau.");
    });

}
$(document).ready(function() {
        // Xử lý sự kiện click vào nút "Hủy"
        $('.cancel-button').click(function(e) {
            e.preventDefault();

            // Lấy form chứa nút bấm
            var form = $(this).closest('form');
            var transactionId = form.data('id');  // Lấy ID giao dịch từ data-id

            // Xác nhận hành động hủy
            if (confirm('Bạn có chắc chắn muốn hủy giao dịch này?')) {
                $.ajax({
                    url: 'http://localhost/web_ban_banh_kem/public/pending-transaction/' + transactionId, // URL của giao dịch
                    type: 'DELETE',
                    data: {
                        _token: $('input[name="_token"]').val(), // Lấy CSRF token từ form
                    },
                    success: function(response) {
                        // Xử lý nếu giao dịch được hủy thành công
                        alert(response.message); // Hiển thị thông báo thành công
                        form.closest('.transaction-item').remove(); // Xóa giao dịch khỏi danh sách
                    },
                    error: function(xhr, status, error) {
                        // Xử lý nếu có lỗi
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>