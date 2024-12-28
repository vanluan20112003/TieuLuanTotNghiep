<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng Quan Tài Khoản</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- Font Awesome CDN Link -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

 
    <style>
         .prize-legend {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .legend-item {
            padding: 5px 0;
        }

        h4 {
            margin-bottom: 10px;
            color: #333; /* Màu sắc của tiêu đề */
        }
     /* Modal overlay (phần nền modal) */
#modal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Nền tối phía sau modal */
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Đảm bảo modal hiển thị trên các phần tử khác */
    transition: opacity 0.3s ease; /* Hiệu ứng mờ khi hiển thị modal */
}

/* Nội dung modal */
#modal-content {
    background: white;
    padding: 30px; /* Tăng padding cho nội dung thoải mái hơn */
    border-radius: 10px; /* Bo tròn nhẹ các góc */
    text-align: center;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4); /* Đổ bóng để modal nổi bật */
    max-width: 400px; /* Giới hạn chiều rộng tối đa */
    width: 90%; /* Chiếm 90% chiều rộng màn hình cho thiết bị nhỏ hơn */
    animation: slideIn 0.4s ease; /* Hiệu ứng xuất hiện khi modal mở */
}

/* Hiệu ứng slide-in cho modal */
@keyframes slideIn {
    from {
        transform: translateY(-50px); /* Modal xuất hiện từ phía trên */
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Văn bản trong modal */
#modal-content p {
    font-size: 18px; /* Kích thước chữ lớn, dễ đọc */
    color: #2c3e50; /* Màu tối vừa phải */
    font-weight: 500; /* Độ đậm của chữ */
    line-height: 1.6; /* Khoảng cách dòng giúp văn bản thoáng hơn */
    margin-bottom: 20px; /* Tạo khoảng cách giữa các đoạn văn */
}

/* Nút đóng modal */
#modal-content button {
    background-color: #3498db; /* Màu xanh nổi bật */
    color: white; /* Chữ trắng trên nền xanh */
    padding: 12px 24px; /* Tăng padding để nút lớn hơn */
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease; /* Hiệu ứng khi hover */
}

/* Hiệu ứng hover cho nút */
#modal-content button:hover {
    background-color: #2980b9; /* Tối màu xanh khi hover */
}

/* Responsive cho màn hình nhỏ */
@media screen and (max-width: 500px) {
    #modal-content {
        padding: 20px; /* Giảm padding trên màn hình nhỏ */
    }
    
    #modal-content p {
        font-size: 16px; /* Chữ nhỏ hơn cho màn hình nhỏ */
    }
}

        /* Định dạng cho danh sách tab */
.promotion-tabs {
    list-style-type: none; /* Loại bỏ dấu chấm đầu dòng */
    padding: 0;
    display: flex; /* Hiển thị các tab trong hàng */
    border-bottom: 2px solid #00bcd4; /* Đường viền dưới cho tab */
}

/* Định dạng cho mỗi tab */
.promotion-tab {
    padding: 10px 20px; /* Đệm cho tab */
    cursor: pointer; /* Con trỏ khi di chuột vào tab */
    transition: background 0.3s; /* Hiệu ứng chuyển tiếp cho nền */
}

/* Định dạng cho tab đang hoạt động */
.promotion-tab.active {
    background: #00bcd4; /* Màu nền cho tab đang được chọn */
    color: white; /* Màu chữ cho tab đang được chọn */
    border-bottom: 2px solid transparent; /* Đường viền dưới cho tab đang hoạt động */
}

/* Định dạng cho nội dung của tab */
.promotion-tab-item {
    display: none; /* Ẩn nội dung tab khi không được chọn */
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

        .points-display {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            padding: 10px;
            background: #ecf0f1;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .wheel-container {
            position: relative;
            width: 400px;
            height: 400px;
            margin: 30px auto;
        }

        .wheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 8px solid #000;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            transition: transform 4s cubic-bezier(0.17, 0.67, 0.12, 0.99);
            transform: rotate(0deg);  /* Added initial rotation */
        }

        .wheel-center {
            position: absolute;
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 8px solid #FF4444;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .spiral {
            width: 100%;
            height: 100%;
            background: conic-gradient(from 0deg, #FF4444 0%, white 100%);
            animation: spin 2s linear infinite;
        }

        /* Modified pointer style */
        .pointer {
            position: absolute;
            top: -20px; /* Adjusted position */
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 50px; /* Made longer */
            background: #FF4444;
            clip-path: polygon(0% 0%, 100% 0%, 50% 100%); /* Modified shape */
            z-index: 3;
        }

        .wheel-item {
            position: absolute;
            width: 50%;
            height: 50%;
            transform-origin: 100% 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .prize-legend {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 20px auto;
            max-width: 600px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            padding: 5px;
        }

        .color-box {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 1px solid #000;
        }

        /* Rest of the styles remain the same */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .result-message {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
            font-weight: bold;
            min-height: 30px;
            color: #2c3e50;
            padding: 10px;
            border-radius: 5px;
            background: #ecf0f1;
        }

        .wheel-center.disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }
/* Hiển thị nội dung của tab đang hoạt động */
.promotion-tab-item.active {
    display: block; /* Hiển thị nội dung của tab đang được chọn */
}

/* Định dạng cho bảng danh sách mã khuyến mãi */
table {
    width: 100%; /* Đặt chiều rộng của bảng */
    border-collapse: separate; /* Cho phép cách xa các ô */
    border-spacing: 10px; /* Khoảng cách giữa các ô */
    margin-top: 20px; /* Khoảng cách trên của bảng */
}

th, td {
    padding: 15px; /* Khoảng cách bên trong các ô */
    border: 1px solid #ddd; /* Đường viền cho ô */
    text-align: left; /* Căn chỉnh văn bản bên trái */
    background-color: #f9f9f9; /* Màu nền cho ô */
}

th {
    background-color: #EEEEEE; /* Màu nền cho tiêu đề bảng */
    color: blue; /* Màu chữ cho tiêu đề */
}

tbody tr:hover {
    background-color: #f1f1f1; /* Màu nền cho hàng khi di chuột */
}


/* Định dạng cho nội dung vòng quay yêu thương */
.love-wheel-details {
    margin-top: 20px; /* Khoảng cách phía trên */
    padding: 15px; /* Đệm cho phần nội dung */
    border: 1px solid #00bcd4; /* Đường viền cho nội dung vòng quay yêu thương */
    border-radius: 5px; /* Bo tròn các góc */
    background-color: #f9f9f9; /* Màu nền cho nội dung */
}


        .hospital-icon {
            font-size: 30px;
            color: #e74c3c;
        }

        .result-message {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
            color: #2c3e50;
        }
        .progress-bar {
    display: flex;
    justify-content: space-around;
    margin-top: 10px;
}

.progress-bar span {
    padding: 10px;
    background-color: #ccc;
    border-radius: 20px;
    font-size: 12px;
    color: white;
}

.progress-bar .active {
    background-color: #00c3ff;
}

        .order-details-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màn đen mờ khi mở modal */
}

.order-details-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close-modal-btn {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 24px;
    cursor: pointer;
}

.order-item {
    margin-bottom: 15px;
}

.product-image {
    width: 60px;
    height: 60px;
    margin-right: 15px;
    float: left;
}

.order-item p {
    margin: 5px 0;
}
        .btn {
    padding: 6px 12px; /* Giảm kích thước padding */
    margin: 5px;
    border-radius: 5px; /* Bo góc mềm mại */
    border: none;
    cursor: pointer;
    font-size: 14px; /* Kích thước font vừa phải */
    transition: all 0.3s ease; /* Thêm hiệu ứng chuyển động */
}

.btn:hover {
    transform: scale(1.05); /* Tăng kích thước khi hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hiệu ứng đổ bóng */
}

.cancel-order-btn {
    background-color: #ff4d4d; /* Màu đỏ cho hủy đơn */
    color: white;
}

.cancel-order-btn:hover {
    background-color: #e04343; /* Màu đỏ đậm hơn khi hover */
}

.confirm-receipt-btn {
    background-color: #4CAF50; /* Màu xanh cho xác nhận */
    color: white;
}

.confirm-receipt-btn:hover {
    background-color: #45a049; /* Xanh đậm hơn khi hover */
}

.report-order-btn {
    background-color: #ff9933; /* Màu cam cho báo cáo */
    color: white;
}

.report-order-btn:hover {
    background-color: #e68a00; /* Cam đậm hơn khi hover */
}

        .filter-btn {
    background-color: #ff9800;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 15px;
}

.filter-btn:hover {
    background-color: #e68900;
}
        .filter-section {
    margin-bottom: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.search-box input, .filter-box input, .filter-box select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
}

.export-btn {
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.export-btn:hover {
    background-color: #45a049;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-table th, .order-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.order-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.view-details-btn, .action-btn {
    background-color: #007bff;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.view-details-btn:hover, .action-btn:hover {
    background-color: #0056b3;
}

@media screen and (max-width: 768px) {
    .filter-section {
        flex-direction: column;
    }

    .order-table th, .order-table td {
        padding: 8px;
    }
}
        .password-form-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Overlay tối mờ */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999; /* Hiển thị trên cùng */
}

.password-form-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    max-width: 100%;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.password-form-container h2 {
    margin-bottom: 20px;
}

.password-form-container label {
    display: block;
    margin-bottom: 8px;
    text-align: left;
}

.password-form-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
}

.form-buttons .btn {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

.form-buttons .cancel-btn {
    background-color: #dc3545;
}

/* Nút Đổi mật khẩu */
.change-password-btn {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    background-color: #28a745;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
      /* Cấu trúc và hiển thị form */
.edit-form-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Mờ nền để làm nổi bật form */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    
}
.edit-form-container .gender-options {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.edit-form-container {
    background: white;
    padding: 20px;
    border-radius: 15px;
    width: 500px; /* Form rộng hơn */
    max-width: 90%; /* Đảm bảo form vẫn hiển thị tốt trên màn hình nhỏ */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Đổ bóng tạo chiều sâu */
    margin-bottom: 2px;
}

/* Tiêu đề form */
.edit-form-container h2 {
    margin-bottom: 5px;
    text-align: center;
    font-size: 24px; /* Kích thước tiêu đề lớn hơn */
    color: #333; /* Màu sắc trung tính */
}

/* Cấu trúc của form */
.edit-form-container label {
    font-weight: bold;
    margin-top: 15px;
    margin-bottom: 5px;
    display: block;
    color: #555;
    font-size: 16px;
}

.edit-form-container input[type="text"],
.edit-form-container input[type="date"],
.edit-form-container select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
    background-color: #f9f9f9;
    box-sizing: border-box; /* Đảm bảo kích thước không thay đổi */
}

.edit-form-container input[type="radio"] {
    margin-right: 5px;
}

/* Các nút bấm */
.form-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 2px;
}

.form-buttons .btn {
    width: 48%;
    padding: 12px 0;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Nút Lưu */
.form-buttons .btn {
    background-color: #4CAF50; /* Xanh lá cây */
    color: white;
}

.form-buttons .btn:hover {
    background-color: #45a049; /* Màu xanh đậm hơn khi hover */
}

/* Nút Hủy */
.cancel-btn {
    background-color: #f44336; /* Đỏ */
    color: white;
}

.cancel-btn:hover {
    background-color: #d32f2f; /* Đỏ đậm hơn khi hover */
}

/* Nút radio cho giới tính */
.edit-form-container div {
    margin-bottom: 15px;
}

.edit-form-container div label {
    margin-right: 20px;
    font-size: 14px;
}

/* Điều chỉnh cho màn hình nhỏ */
@media (max-width: 768px) {
    .edit-form-container {
        width: 90%;
        padding: 20px;
    }

    .edit-form-container h2 {
        font-size: 20px;
    }

    .form-buttons .btn {
        font-size: 14px;
        padding: 10px;
    }
}


    .cancel-btn {
        background-color: red;
        color: white;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-left: 20px; /* Thêm khoảng cách sang bên phải */
    }

    .info-label {
        font-weight: bold;
        width: 150px; /* Đảm bảo nhãn có chiều rộng cố định */
    }

    .info-item span {
        margin-left: 20px; /* Khoảng cách giữa nhãn và nội dung */
    }

    /* Nếu cần điều chỉnh phần khác của trang */
    .profile-header,
    .profile-stats,
    .info-section {
        padding-left: 300px; /* Đẩy toàn bộ phần này sang phải */
    }
    .profile-info {
    margin-left: 70px; /* Điều chỉnh giá trị này để dịch sang trái nhiều hơn hoặc ít hơn */
}
.prize-legend {
    padding: 15px; /* Thêm khoảng đệm xung quanh phần thưởng */
    border: 1px solid #ddd; /* Đường viền nhẹ quanh phần thưởng */
    border-radius: 8px; /* Bo góc cho phần thưởng */
    background-color: #f9f9f9; /* Màu nền nhẹ */
}

.prize-legend h4 {
    margin-bottom: 10px; /* Khoảng cách giữa tiêu đề và danh sách phần thưởng */
    font-size: 18px; /* Kích thước chữ cho tiêu đề */
    color: #333; /* Màu sắc cho tiêu đề */
}

.legend {
    display: flex;
    flex-direction: column; /* Sắp xếp các item phần thưởng theo chiều dọc */
}

.legend-item {
    margin-top: 5px; /* Thay đổi từ margin-bottom thành margin-top cho item đầu tiên */
    margin-bottom: 5px; /* Khoảng cách giữa các item phần thưởng */
    font-size: 14px; /* Kích thước chữ cho phần thưởng */
}

.legend-item.large-prize {
    font-size: 16px; /* Kích thước chữ lớn hơn cho giải thưởng lớn */
    color: red; /* Màu sắc nổi bật cho giải thưởng lớn */
    font-weight: bold; /* Chữ đậm */
}
.report-dialog {
    position: fixed;
    top: 20%;
    right: 10%;
    background-color: white;
    border: 1px solid #ccc;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}
.report-options label {
    display: block;
    margin-bottom: 10px;
}
textarea {
    width: 100%;
    height: 60px;
    margin-top: 10px;
}


.report-options label {
    display: block;
    margin: 10px 0;
    font-size: 14px;
    color: #555;
    cursor: pointer;
}

.report-options input[type="radio"] {
    margin-right: 8px;
}

textarea#other-reason-details {
    width: calc(100% - 20px);
    height: 60px;
    margin-top: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px;
    font-size: 14px;
    color: #333;
    resize: none;
}

button {
    display: inline-block;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 4px;
    border: none;
    cursor: pointer;
}

button#submit-report-btn {
    background-color: #007bff;
    color: white;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

button#submit-report-btn:hover {
    background-color: #0056b3;
}

button#close-report-dialog {
    background-color: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
    transition: background-color 0.3s ease;
}

button#close-report-dialog:hover {
    background-color: #ddd;
}
:root {
   --yellow: #fed330;
   --red: #e74c3c;
   --white: #fff;
   --black: #222;
   --light-color: #777;
   --border: .2rem solid var(--black);
}
.delete-btn,
.btn {
   display: inline-block;
   margin-top: 1rem;
   padding: 1.3rem 3rem;
   cursor: pointer;
   font-size: 2rem;
   text-transform: capitalize;
}

.delete-btn {
   background-color: var(--red);
   color: var(--white);
}


.delete-btn:hover,
.btn:hover {
   letter-spacing: .2rem;
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
</style>

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
         <a href="{{ url('/post') }}">Post</a>

      </nav>

      <div class="icons">
         <a href="{{ url('/search') }}"><i class="fas fa-search"></i></a>
         <a href="{{ url('/cart') }}" id="cart-link">
        
         <i class="fas fa-shopping-cart"></i>
         <span>({{ $cartQuantity }})</span> 
        </a>
        <a href="{{ url('/notifications') }}"><i class="fa-solid fa-bell"></i></a>
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
    <div class="container">
        <div class="sidebar">
            <h2>Thành viên</h2>
            <ul class="tabs">
                <li class="active">Tổng Quan</li>
                <li>Thông Tin Cá Nhân</li>
                <li>Lịch Sử Đơn Hàng</li>
                <li>Lịch Sử Đặt Bàn</li>
                <li>Khuyến mãi</li>
            </ul>
        </div>
        <div class="content">
            <!-- Tab Tổng Quan -->
            <div class="tab-content active">
            @section('content')
            <div class="summary">
    <h2>My Cards</h2>
 

    @if($theDaNang)
    <div class="card-container">
    <div class="card">
    <div class="card-details">
    <h3>Balance</h3>
    <div class="balance-wrapper">
        <p id="balanceText">********</p> <!-- Ban đầu ẩn số dư bằng dấu * -->
        <i id="toggleBalance" class="fas fa-eye-slash"></i> <!-- Biểu tượng con mắt -->
    </div>
    <h4>CARD HOLDER</h4>
    <p>{{ $user->name }}</p>
    <h4>Ngày tạo</h4>
    <p>{{ $theDaNang->created_at }}</p>

    <!-- Hiển thị mã QR nếu người dùng đã đăng nhập -->
    @if(auth()->check())
        <a href="{{ route('generate.qrcode') }}">
            <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" class="qr-code-icon">
        </a>
    @endif
</div>

    </div>

    <!-- Các hành động như Nạp/Rút tiền và Đổi Mã PIN -->
    <div class="card-actions">
        <a href="{{ url('/link_payment') }}" class="btn btn-primary">Nạp/Rút Tiền</a>
        <a href="#" class="btn btn-tertiary" id="change-pin-btn">Đổi Mã PIN</a>

        <!-- Hộp thoại đổi mã PIN -->
        <div class="modal" id="change-pin-modal">
        <div class="modal" id="change-pin-modal">
        <div class="modal-content">
    <span class="close" id="close-modal">&times;</span>
    <h2>Đổi Mã PIN</h2>
    <form id="change-pin-form" action="{{ route('change.pin') }}" method="POST">
        @csrf
        <div class="input-group">
            <label for="old-pin">Mã PIN cũ:</label>
            <input type="password" id="old-pin" name="old_pin" maxlength="6" pattern="\d{6}" required>
        </div>
        <div class="input-group">
            <label for="new-pin">Mã PIN mới:</label>
            <input type="password" id="new-pin" name="new_pin" maxlength="6" pattern="\d{6}" required>
        </div>
        <div class="input-group">
            <label for="confirm-new-pin">Nhập lại Mã PIN mới:</label>
            <input type="password" id="confirm-new-pin" name="confirm_new_pin" maxlength="6" pattern="\d{6}" required>
        </div>
        <button type="submit" class="btn">Xác Nhận</button>
    </form>
    <div id="result-message"></div> <!-- Thêm phần này để hiển thị thông báo -->
</div>

</div>
    </div>
</div>
    @else
        @if(auth()->check()) <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
        <button id="moTheBtn" class="btn btn-primary" onclick="showConfirmModal()">Mở thẻ đa năng</button>
            
        @else
            <p>Bạn cần đăng nhập để mở thẻ đa năng.</p> <!-- Thông báo nếu chưa đăng nhập -->
        @endif
    @endif

    <!-- Modal xác nhận mở thẻ -->
   <!-- Hộp thoại xác nhận mở thẻ -->
<div id="confirmModal" style="display: none;">
    <p>Bạn có chắc chắn muốn mở thẻ đa năng không?</p>
    <button id="confirmYes" class="btn btn-success">OK</button>
    <button id="confirmNo" class="btn btn-danger">Cancel</button>
</div>

<!-- Hộp thoại nhập mã PIN -->
<div id="pinModal" style="display: none;">
    <p>Nhập mã PIN (6 chữ số):</p>
    <div id="pinInputs">
        <input type="password" maxlength="1" class="pin-input" />
        <input type="password" maxlength="1" class="pin-input" />
        <input type="password" maxlength="1" class="pin-input" />
        <input type="password" maxlength="1" class="pin-input" />
        <input type="password" maxlength="1" class="pin-input" />
        <input type="password" maxlength="1" class="pin-input" />
    </div>
    <p>Nhập lại mã PIN:</p>
    <div id="pinInputsConfirm">
        <input type="password" maxlength="1" class="pin-input-confirm" />
        <input type="password" maxlength="1" class="pin-input-confirm" />
        <input type="password" maxlength="1" class="pin-input-confirm" />
        <input type="password" maxlength="1" class="pin-input-confirm" />
        <input type="password" maxlength="1" class="pin-input-confirm" />
        <input type="password" maxlength="1" class="pin-input-confirm" />
    </div>
    <button id="pinConfirmYes" class="btn btn-success">OK</button>
    <button id="pinConfirmNo" class="btn btn-danger">Cancel</button>
</div>

</div>



@if ($theDaNang)
    <div class="recent-transactions">
        <h2>Recent Transactions</h2>
        <ul id="transaction-list">
        @foreach ($transactions as $transaction)
    <li>
        @if ($transaction->loai_giao_dich == 'nap')
            Nạp tiền vào tài khoản
            + {{ number_format($transaction->so_tien, 0, ',', '.') }}đ
        @elseif ($transaction->loai_giao_dich == 'rut')
            Rút tiền từ tài khoản
            - {{ number_format($transaction->so_tien, 0, ',', '.') }}đ
        @elseif ($transaction->loai_giao_dich == 'thanh_toan')
            Thanh toán mua hàng
            - {{ number_format($transaction->so_tien, 0, ',', '.') }}đ
        @elseif ($transaction->loai_giao_dich == 'phan_thuong_vong_quay_yeu_thuong')
            Phần thưởng từ vòng quay yêu thương
            + {{ number_format($transaction->so_tien, 0, ',', '.') }}đ   
        @else
            Giao dịch không xác định
        @endif
        <span>{{ $transaction->created_at->format('d F Y') }}</span>
    </li>
@endforeach

        </ul>

        <!-- Pagination -->
        <div class="pagination-container">
            <ul class="pagination">
                <li class="{{ $transactions->hasMorePages() ? '' : 'disabled' }}">
                    <a href="#" class="page-link" data-page="{{ $transactions->currentPage() - 1 }}">«</a>
                </li>

                @foreach ($transactions->links()->elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="{{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                <a href="#" class="page-link" data-page="{{ $page }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @else
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif
                @endforeach

                <li class="{{ $transactions->hasMorePages() ? '' : 'disabled' }}">
                    <a href="#" class="page-link" data-page="{{ $transactions->currentPage() + 1 }}">»</a>
                </li>
            </ul>
            
            <!-- Nút xuất nằm bên phải -->
            <a href="{{ url('export-transactions') }}" class="btn-export">Xuất Excel</a>
        </div>
    </div>
@else
    <p>Bạn chưa có thẻ Đa Năng. Vui lòng tạo thẻ trước khi thực hiện giao dịch.</p>
@endif





<div class="time-selection">
    <h2>Weekly Activity</h2>
    <div>
        <label>
            <input type="radio" name="timeFrame" value="week" checked> Tuần
        </label>
        <label>
            <input type="radio" name="timeFrame" value="month"> Tháng
        </label>
        <label>
            <input type="radio" name="timeFrame" value="quarter"> Quý
        </label>
    </div>
    <div class="chart">
        <canvas id="myChart"></canvas>
    </div>
</div>



                <div class="expense-statistics">
    <h2>Expense Statistics</h2>

    <!-- Thêm radio buttons để chọn khoảng thời gian -->
    <div class="time-selection">
        <input type="radio" id="week" name="time-period" value="week" checked>
        <label for="week">Theo Tuần</label>
        
        <input type="radio" id="month" name="time-period" value="month">
        <label for="month">Theo Tháng</label>
        
        <input type="radio" id="quarter" name="time-period" value="quarter">
        <label for="quarter">Theo Quý</label>
    </div>
    
    <div class="area-chart">
        <canvas id="expenseAreaChart"></canvas>
    </div>
</div>


            </div>
            </div>

            <!-- Tab Thông Tin Cá Nhân -->
            <div class="tab-content">
            <div class="container">
            <div class="profile">
    <div class="cover-photo"></div>
    <div class="profile-header">
    <div class="profile-pic-container">
    <img src="{{ $user->avatar ?? 'https://via.placeholder.com/150' }}" alt="Profile Picture" class="profile-pic" id="profile-pic">
    <label for="profile-pic-input" class="edit-profile-pic">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
        </svg>
    </label>
    <input type="file" id="profile-pic-input" accept="image/*" style="display: none;">
</div>
        <div class="profile-info">
    <h1 class="profile-name">{{ $user->name ?? 'Chưa cập nhật' }}</h1>
    <p class="profile-status">{{ '@' . $user->user_name ?? 'Chưa cập nhật' }} • {{ $user->created_at ? $user->created_at->format('M Y') : 'Chưa cập nhật' }}</p>
        </div>
        

    </div>

 

    <div class="info-section"> 
    <div class="info-header">
        <h2 class="info-title">Thông tin chung</h2>
        <button class="edit-btn" onclick="openEditForm()">Chỉnh sửa</button>
    </div>
    <div class="info-item">
        <span class="info-label">Họ và tên</span>
        <span>{{ $user->name ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Tên người dùng</span>
        <span>{{ $user->user_name ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Mã bệnh nhân</span>
        <span>{{ $user->ma_benh_nhan ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Ngày sinh</span>
        <span>{{ $user->ngay_sinh ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Giới tính</span>
        <span>{{ $user->gioi_tinh ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Số điện thoại</span>
        <span>{{ $user->phone_number ?? 'Chưa cập nhật' }}</span>
    </div>
    <div class="info-item">
        <span class="info-label">Địa chỉ</span>
        <span>{{ $user->address ?? 'Chưa cập nhật' }}</span>
    </div>

    <!-- Nút Đổi mật khẩu -->
    <button class="change-password-btn" onclick="openPasswordForm()">Đổi mật khẩu</button>
</div>

<!-- Form ẩn Đổi mật khẩu -->
<div class="password-form-overlay" id="password-form-overlay" style="display: none;">
    <div class="password-form-container">
        <form id="change-password-form">
            <h2>Đổi mật khẩu</h2>
            
            <!-- Mật khẩu cũ -->
            <label for="old_password">Mật khẩu cũ:</label>
            <input type="password" id="old_password" name="old_password" required>
            
            <!-- Mật khẩu mới -->
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <!-- Xác nhận mật khẩu mới -->
            <label for="new_password_confirmation">Xác nhận mật khẩu mới:</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>

            <!-- Nút Lưu -->
            <div class="form-buttons">
                <button type="submit" class="btn">Đổi mật khẩu</button>
                <button type="button" class="btn cancel-btn" onclick="closePasswordForm()">Hủy</button>
            </div>
        </form>
    </div>
    
</div>


<!-- Form ẩn để chỉnh sửa thông tin -->
<div class="edit-form-overlay" id="edit-form-overlay" style="display: none;">
    <div class="edit-form-container">
        <form id="edit-profile-form">
            <h2>Chỉnh sửa thông tin</h2>

            <!-- Họ và tên -->
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" value="{{ $user->name ?? '' }}" required>

            <!-- Ngày sinh -->
            <label for="ngay_sinh">Ngày sinh:</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" value="{{ $user->ngay_sinh ?? '' }}" >

            <!-- Giới tính -->
            <label>Giới tính:</label>
<div class="gender-options">
    <input type="radio" id="male" name="gioi_tinh" value="Nam" {{ $user->gioi_tinh == 'Nam' ? 'checked' : '' }}>
    <label for="male">Nam</label>

    <input type="radio" id="female" name="gioi_tinh" value="Nữ" {{ $user->gioi_tinh == 'Nữ' ? 'checked' : '' }}>
    <label for="female">Nữ</label>
</div>

            <!-- Số điện thoại -->
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number ?? '' }}">

            <!-- Địa chỉ -->
            <label>Địa chỉ:</label>
            <select id="city" name="city" >
                <option value="">Chọn Tỉnh</option>
                <!-- Options populated by JavaScript -->
            </select>
            <select id="district" name="district" >
                <option value="">Chọn Quận/Huyện</option>
                <!-- Options populated by JavaScript -->
            </select>
            <select id="ward" name="ward" >
                <option value="">Chọn Phường/Xã</option>
                <!-- Options populated by JavaScript -->
            </select>
            <input type="text" maxlength="50" placeholder="Nhập số nhà" class="box" name="flat">

            <!-- Nút lưu -->
            <div class="form-buttons">
                <button type="submit" class="btn">Lưu thông tin</button>
                <button type="button" class="btn cancel-btn" onclick="closeEditForm()">Hủy</button>
            </div>
        </form>
    </div>
</div>

   
</div>

<div class="sidebar">
    <h2>Complete Your Profile</h2>
    <div class="progress-circle" id="progress-circle">
        <div class="progress-inner" id="progress-percentage">0%</div>
    </div>
</div>


            </div>
            </div>

            <!-- Tab Lịch Sử Đơn Hàng -->
            <div class="tab-content">
    <h2>Lịch Sử Đơn Hàng</h2>

    
    <!-- Search and Filter Section -->
    <div class="filter-section">
    <div class="search-box">
        <input type="text" id="search-input" placeholder="Tìm kiếm theo ID hóa đơn...">
    </div>

    <div class="filter-box">
        <label for="start-date">Từ ngày:</label>
        <input type="date" id="start-date">

        <label for="end-date">Đến ngày:</label>
        <input type="date" id="end-date">

        <label for="status-filter">Trạng thái:</label>
        <select id="status-filter">
            <option value="">Tất cả</option>
            <option value="pending">Đang chờ</option>
            <option value="processing">Đang xử lý</option>
            <option value="completed">Đã hoàn thành</option>
            <option value="cancelled">Đã hủy</option>
        </select>
        <button class="filter-btn">Lọc</button>
        <button class="export-btn">Xuất</button>
    </div>
</div>


    <!-- Order Table -->
    <table class="order-table">

    <thead>
        <tr>
            <th>Mã đặt hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Thông tin vận chuyển</th>
            <th>Ghi chú</th>
            <th>Hành động</th>
            <th>Chi tiết đơn hàng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->phone_number }}</td>
                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                <td>{{ $order->payment_method }}</td>
                <td>{{ $order->shipping_id?? 'Không có' }}</td>
                <td>{{ $order->notes }}</td>
                <td>
                    @if ($order->status == 'pending')
                        <button class="btn cancel-order-btn" onclick="cancelOrder('{{ $order->id }}')">Hủy đơn</button>
                    @elseif ($order->status == 'processing')
                        <button class="btn confirm-receipt-btn" onclick="confirmReceipt('{{ $order->id }}')">Xác nhận nhận hàng</button>
                    @elseif ($order->status == 'cancelled' || $order->status == 'completed')
                        <button class="btn report-order-btn" onclick="reportOrder('{{ $order->id }}')">Báo cáo </button>
                    @endif
                </td>
                <td><button class="view-details-btn" onclick="viewOrderDetails('{{ $order->id }}')">Xem chi tiết</button></td>
            </tr>
        @endforeach
    </tbody>
</table>


<!-- Modal chi tiết đơn hàng -->
<div id="order-details-modal" class="order-details-modal">
    <div class="order-details-content">
        <span class="close-modal-btn" onclick="closeOrderDetails()">&times;</span>
        <h2>Chi tiết đơn hàng</h2>
        <div id="order-details-container"style="width: 100%; max-width: 800px; margin: 0 auto;">
            <!-- Nội dung chi tiết đơn hàng sẽ được load ở đây -->
        </div>
    </div>
</div>
</table>
<div id="report-dialog" class="report-dialog" style="display: none;">
    <h3>Báo cáo vấn đề với đơn hàng</h3>
    <div class="report-options">
        <label>
            <input type="radio" name="report-reason" value="Chưa nhận được hàng"> Chưa nhận được hàng
        </label>
        <label>
            <input type="radio" name="report-reason" value="Hàng bị hư hỏng"> Hàng bị hư hỏng
        </label>
        <label>
            <input type="radio" name="report-reason" value="Nhận không đúng mặt hàng"> Nhận không đúng mặt hàng
        </label>
        <label>
            <input type="radio" name="report-reason" value="Khác" id="other-reason"> Khác
        </label>
        <textarea id="other-reason-details" style="display: none;" placeholder="Vui lòng nhập chi tiết lý do..."></textarea>
    </div>
    <button id="submit-report-btn">Gửi báo cáo</button>
    <button id="close-report-dialog">Đóng</button>
</div>

</div>


            <!-- Tab Lịch Sử Đặt Bàn -->
            <div class="tab-content">
    <h2>Lịch Sử Đặt Bàn</h2>
    <p>Danh sách đặt bàn đã thực hiện.</p>

    @if($datBanHistory->isEmpty())
        <p>Không có lịch sử đặt bàn nào.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tên Bàn</th>
                    <th>Thời gian Đặt</th>
                    <th>Thời gian Rời</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datBanHistory as $datBan)
                    <tr>
                        <td>{{ $datBan->banAn->ten_ban }}</td>
                        <td>{{ \Carbon\Carbon::parse($datBan->thoi_gian_dat)->format('d-m-Y H:i') }}</td>
                        <td>{{ $datBan->thoi_gian_roi ? \Carbon\Carbon::parse($datBan->thoi_gian_roi)->format('d-m-Y H:i') : 'Chưa rời' }}</td>
                        <td>{{ $datBan->trang_thai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

            <div class="tab-content">
    <h2>Khuyến mãi</h2>
 

    <ul class="promotion-tabs">
        <li class="promotion-tab active" data-tab="existing-discount-codes-content">Danh sách mã khuyến mãi đã có</li>
        <li class="promotion-tab" data-tab="love-wheel-content">Vòng quay yêu thương</li>
    </ul>
    
    <div id="existing-discount-codes-content" class="promotion-tab-item active">
    <h3>Danh sách mã khuyến mãi đã có</h3>
    <p>Danh sách các mã khuyến mãi hiện có sẽ được hiển thị ở đây.</p>
    <table>
        <thead>
            <tr>
                <th>Mã</th>
                <th>Giảm giá (%)</th>
                <th>Số lượng có</th>
                <th>Thời gian hết hạn</th>
                <th>Điều kiện tối thiểu</th>
                <th>Điều kiện tối đa</th>
                <th>Điều kiện dùng</th>


                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            @if ($discountCodes->isEmpty())
                <tr>
                    <td colspan="5">Không có mã khuyến mãi còn hạn.</td>
                </tr>
            @else
            @foreach ($discountCodes as $code)
    <tr>
        <td>{{ $code->discount->name }}</td> <!-- Hiển thị tên mã giảm giá -->
        <td>{{ $code->discount->discount_amount }}</td> <!-- Hiển thị phần trăm giảm giá -->
        <td>{{ $code->quantity }}</td> <!-- Hiển thị số lượng -->
        <td>{{ \Carbon\Carbon::parse($code->expiration_date)->format('d/m/Y') }}</td> <!-- Hiển thị thời gian hết hạn -->
        
        @if ($code->discount->type === 'special discount')
            <td>Nhận từ vòng quay yêu thương</td> <!-- Hiển thị thông điệp thay thế -->
            <td>Nhận từ vòng quay yêu thương</td> <!-- Hiển thị thông điệp thay thế -->
        @else
            <td>{{ number_format($code->discount->minimum_condition, 0, ',', '.') }} VND</td> <!-- Hiển thị điều kiện tối thiểu -->
            <td>{{ number_format($code->discount->maximum_condition, 0, ',', '.') }} VND</td><!-- Hiển thị điều kiện tối đa -->
        @endif
        
        <td>{{ $code->discount->condition_use }}</td> <!-- Hiển thị mô tả giảm giá -->
        <td>{{ $code->discount->description }}</td> <!-- Hiển thị mô tả giảm giá -->
    </tr>
@endforeach

            @endif
        </tbody>
    </table>
</div>


<div id="love-wheel-content" class="promotion-tab-item">
    <h3>Vòng quay yêu thương</h3>
    <div class="points-display" id="points-display">
        Điểm tích lũy: <span id="points">{{ $user->loyalty_points }}</span>
    </div>
    <div class="love-wheel-details">
        <p>Mỗi lần quay cần 20 điểm tích lũy</p>
    </div>
    <div class="wheel-container">
        <div class="pointer"></div>
        <div class="wheel" id="wheel"></div>
        <div class="wheel-center" id="wheel-center" onclick="tryToSpin()">
            <div class="spiral"></div>
        </div>
    </div>
    <div class="prize-legend" id="prize-legend">
    <h4>Các phần thưởng:</h4> <!-- Tiêu đề cho phần thưởng -->
    <div id="legend" class="legend"></div> <!-- Nơi hiển thị phần thưởng -->
</div>
    <div class="result-message" id="spin-result-message"></div>
  
    <h3>Lịch sử quay vòng quay yêu thương</h3>
    <table id="spin-history-table">
        <thead>
            <tr>
                <th>Kết quả</th>
                <th>Ngày quay</th>
            </tr>
        </thead>
        <tbody>
            @if($spinHistory->isEmpty())
            <tr>
                <td colspan="2">Không có lượt quay nào.</td>
            </tr>
            @else
            @foreach ($spinHistory as $history)
            <tr>
                <td>{{ $history->result }}</td>
                <td>{{ \Carbon\Carbon::parse($history->created_at)->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>


    <div id="modal" onclick="closeModal(event)">
    <div id="modal-content">
        <p id="modal-result"></p>
        <button onclick="closeModal(event)">Đóng</button>
    </div>
</div>

</div>
        </div>
    </div>
    
   <script src="{{ asset('js/script.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        document.getElementById('logout-form').submit();
    }
}
           document.addEventListener('DOMContentLoaded', function () {
        const openCardButton = document.getElementById('moTheBtn');
        const confirmModal = document.getElementById('confirmModal');
        const pinModal = document.getElementById('pinModal');
        const confirmYesButton = document.getElementById('confirmYes');
        const confirmNoButton = document.getElementById('confirmNo');
        const pinConfirmYesButton = document.getElementById('pinConfirmYes');
        const pinConfirmNoButton = document.getElementById('pinConfirmNo');
        const pinInputs = document.querySelectorAll('.pin-input');
        const pinInputsConfirm = document.querySelectorAll('.pin-input-confirm');

        // Modal thay đổi mã PIN
        const modal = document.getElementById("change-pin-modal");
        const changePinBtn = document.getElementById("change-pin-btn");
        const closeModal = document.getElementById("close-modal");

        // Mở modal khi nhấn nút
        if (changePinBtn) {
            changePinBtn.onclick = function() {
                modal.style.display = "block";
            }
        }

        // Đóng modal khi nhấn vào nút đóng
        if (closeModal) {
            closeModal.onclick = function() {
                modal.style.display = "none";
            }
        }

        // Đóng modal khi nhấn bên ngoài
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // Ngăn không cho nhập ký tự không phải số
        document.querySelectorAll('input[type="password"]').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault(); // Ngăn không cho nhập ký tự không phải số
                }
            });
        });

        // Sự kiện cho nút mở thẻ
        if (openCardButton) {
            openCardButton.onclick = showConfirmModal;
        }

        // Hiển thị modal xác nhận
        function showConfirmModal() {
            if (confirmModal) {
                confirmModal.style.display = 'block'; // Mở modal
            } else {
                console.error('Modal không tồn tại.');
            }
        }

        // Ẩn modal xác nhận
        function hideConfirmModal() {
            if (confirmModal) {
                confirmModal.style.display = 'none'; 
            }
        }
        window.onload = function() {
    modal.style.display = "none"; // Đảm bảo modal đóng khi tải trang
}
        // Sự kiện cho nút OK trong modal xác nhận
        if (confirmYesButton) {
            confirmYesButton.onclick = function() {
                hideConfirmModal(); // Ẩn modal xác nhận
                showPinModal(); // Hiển thị modal nhập mã PIN
            };
        }

        // Sự kiện cho nút Cancel trong modal xác nhận
        if (confirmNoButton) {
            confirmNoButton.onclick = hideConfirmModal;
        }

        // Hiển thị modal nhập mã PIN
        function showPinModal() {
            if (pinModal) {
                pinModal.style.display = 'block'; 
            }
        }

        // Ẩn modal nhập mã PIN
        function hidePinModal() {
            if (pinModal) {
                pinModal.style.display = 'none'; 
                pinInputs.forEach(input => input.value = ''); // Xóa giá trị nhập
                pinInputsConfirm.forEach(input => input.value = ''); // Xóa giá trị nhập
            }
        }

        // Sự kiện cho nút OK trong modal nhập mã PIN
        if (pinConfirmYesButton) {
            pinConfirmYesButton.onclick = function() {
                const pinCode = Array.from(pinInputs).map(input => input.value).join('');
                const pinCodeConfirm = Array.from(pinInputsConfirm).map(input => input.value).join(''); // Lấy mã PIN xác nhận

                // Kiểm tra nếu mã PIN hợp lệ (6 chữ số) và giống nhau
                if (pinCode.length === 6 && pinCodeConfirm.length === 6 && pinCode === pinCodeConfirm) {
                    moTheDaNang(pinCode); // Gọi hàm với mã PIN
                    hidePinModal(); // Ẩn hộp thoại PIN sau khi xác nhận
                } else {
                    alert('Mã PIN không hợp lệ hoặc không khớp. Vui lòng nhập lại.'); // Thông báo nếu mã PIN không hợp lệ
                }
            };
        }

        // Sự kiện cho nút Cancel trong modal nhập mã PIN
        if (pinConfirmNoButton) {
            pinConfirmNoButton.onclick = hidePinModal;
        }

        // Hàm để mở thẻ đa năng
        function moTheDaNang(pinCode) {
            fetch("{{ route('open.card') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ pin_code: pinCode }) // Gửi mã PIN
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Tải lại trang sau khi mở thẻ thành công
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Tự động chuyển ô nhập PIN
        pinInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.match(/^[0-9]$/)) {
                    if (index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus(); // Chuyển sang ô tiếp theo
                    }
                } else {
                    this.value = ''; // Nếu không phải số, xóa ô
                }
            });
            
            // Xử lý nhấn Enter để chuyển ô
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn chặn hành vi mặc định
                    if (index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus(); // Chuyển sang ô tiếp theo
                    }
                }
            });
        });

        // Tự động chuyển ô nhập mã PIN xác nhận
        pinInputsConfirm.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.match(/^[0-9]$/)) {
                    if (index < pinInputsConfirm.length - 1) {
                        pinInputsConfirm[index + 1].focus(); // Chuyển sang ô tiếp theo
                    }
                } else {
                    this.value = ''; // Nếu không phải số, xóa ô
                }
            });

            // Xử lý nhấn Enter để chuyển ô
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Ngăn chặn hành vi mặc định
                    if (index < pinInputsConfirm.length - 1) {
                        pinInputsConfirm[index + 1].focus(); // Chuyển sang ô tiếp theo
                    }
                }
            });
        });
 

     $(document).ready(function () {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('#edit-profile-form').on('submit', function(e) {
        e.preventDefault(); // Ngăn form reload trang

        // Lấy dữ liệu từ form
        let formData = $(this).serialize(); // Serialize tất cả các input trong form

        $.ajax({
            url: '{{ route("update.profile.submit") }}', // Sử dụng route name
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken // Thêm CSRF token vào header
            },
            success: function(response) {
                // Kiểm tra phản hồi từ server
                if (response.success) {
                    alert('Thông tin cập nhật thành công!'); // Hiển thị thông báo thành công
                    closeEditForm(); // Đóng form chỉnh sửa
                    // Cập nhật nội dung trên trang mà không cần tải lại
                    $('#user-name').text(response.data.name); // Cập nhật tên người dùng (nếu có phần tử tương ứng)
                    $('#user-phone').text(response.data.phone_number); // Cập nhật số điện thoại (nếu có phần tử tương ứng)
                    // Cập nhật thêm các trường khác nếu cần
                } else {
                    alert('Cập nhật không thành công: ' + response.message); // Thông báo lỗi từ server
                }
            },
            error: function(xhr) {
                // Xử lý lỗi nếu có vấn đề trong quá trình gọi AJAX
                if (xhr.status === 419) {
                    alert('Lỗi xác thực. Vui lòng làm mới trang và thử lại.'); // CSRF token lỗi
                } else {
                    alert('Đã xảy ra lỗi, vui lòng thử lại!'); // Thông báo lỗi chung
                }
            }
        });
    });
    // Gọi hàm để vẽ biểu đồ ngay khi trang được tải
    fetchTransactionsSummary('week'); // Gọi với khoảng thời gian mặc định là tuần

    $('input[name="timeFrame"]').on('change', function () {
        var selectedTimeFrame = $(this).val();
        fetchTransactionsSummary(selectedTimeFrame);
    });

    function fetchTransactionsSummary(timeFrame) {
        $.ajax({
            url: 'http://localhost/web_ban_banh_kem/public/fetch-transactions-summary',
            type: 'GET',
            data: { timeFrame: timeFrame },
            success: function (summary) {
                drawChart(summary);
            },
            error: function (error) {
                console.error('Error fetching transactions summary:', error);
            }
        });
    }

    let myChart; // Biến toàn cục cho chart

    function drawChart(summary) {
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // Hủy chart cũ nếu tồn tại
        if (myChart) {
            myChart.destroy();
        }

        // Dữ liệu biểu đồ
        myChart = new Chart(ctx, {
            type: 'pie', // Hoặc kiểu biểu đồ bạn muốn
            data: {
                labels: ['Nạp tiền', 'Rút tiền', 'Thanh toán'],
                datasets: [{
                    label: 'Tổng giao dịch',
                    data: [summary.deposit, summary.withdraw, summary.payment],
                    backgroundColor: ['#36a2eb', '#ff6384', '#ffce56'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    }
    const host = "https://provinces.open-api.vn/api/";

function callAPI(api, select, key) {
    return axios.get(api)
        .then((response) => {
            const data = key ? response.data[key] : response.data;
            renderData(data, select);
        })
        .catch((error) => {
            console.error(`Error fetching data from ${api}:`, error);
        });
}

function renderData(array, select) {
    let row = '<option value="">Chọn</option>';
    array.forEach(element => {
        row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`;
    });
    $(`#${select}`).html(row);
}

callAPI(`${host}?depth=1`, 'city');

$('#city').change(function () {
    const provinceCode = $(this).find(':selected').data('id');
    if (provinceCode) {
        callAPI(`${host}p/${provinceCode}?depth=2`, 'district', 'districts');
        $('#ward').html('<option value="">Chọn phường xã</option>'); 
    } else {
        $('#district').html('<option value="">Chọn quận huyện</option>');
        $('#ward').html('<option value="">Chọn phường xã</option>');
    }
});

$('#district').change(function () {
    const districtCode = $(this).find(':selected').data('id');
    if (districtCode) {
        callAPI(`${host}d/${districtCode}?depth=2`, 'ward', 'wards');
    } else {
        $('#ward').html('<option value="">Chọn phường xã</option>');
    }
});
});



$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    var page = $(this).data('page');
   

// Gỡ bỏ lớp active khỏi tất cả các nút
$('.pagination li').removeClass('active');

// Thêm lớp active cho nút hiện tại
$(this).parent().addClass('active');
    $.ajax({
        url: `http://localhost/web_ban_banh_kem/public/fetch-transactions?page=` + page,
        type: 'GET',
        success: function (data) {
            if (data.error) {
                console.error('Error fetching transactions:', data.error);
                return; // Nếu có lỗi, không làm gì thêm
            }

            // Cập nhật danh sách giao dịch
            var transactionList = $('#transaction-list');
            transactionList.empty(); // Xóa danh sách giao dịch hiện tại

            $.each(data.data, function (index, transaction) {
    var transactionType;
    var amount;
    
    // Xác định loại giao dịch
    switch (transaction.loai_giao_dich) {
        case 'nap':
            transactionType = 'Nạp tiền vào tài khoản';
            amount = '+ ' + transaction.so_tien.toLocaleString() + 'đ';
            break;
        case 'rut':
            transactionType = 'Rút tiền từ tài khoản';
            amount = '- ' + transaction.so_tien.toLocaleString() + 'đ';
            break;
        case 'thanh_toan':
            transactionType = 'Thanh toán mua hàng';
            amount = '- ' + transaction.so_tien.toLocaleString() + 'đ';
            break;
        case 'phan_thuong_vong_quay_yeu_thuong':
            transactionType = 'Phần thưởng từ vòng quay yêu thương';
            amount = '+ ' + transaction.so_tien.toLocaleString() + 'đ';
            break;
        default:
            transactionType = 'Giao dịch không xác định';
            amount = '';
    }

    // Định dạng ngày
    var date = new Date(transaction.created_at).toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });

    // Thêm vào danh sách giao dịch
    transactionList.append(`<li>${transactionType} ${amount} <span>${date}</span></li>`);
});


            // Cập nhật phân trang
            $('#pagination-container').html(data.links);
        },
        error: function (error) {
            console.error('Error fetching transactions:', error);
        }
    });
});

       // Hàm để hiển thị hộp thoại xác nhận


// Tự động chuyển ô nhập PIN
pinInputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value.match(/^[0-9]$/)) {
            if (index < pinInputs.length - 1) {
                pinInputs[index + 1].focus(); // Chuyển sang ô tiếp theo
            }
        } else {
            this.value = ''; // Nếu không phải số, xóa ô
        }
    });
});

// Tự động chuyển ô nhập mã PIN xác nhận
pinInputsConfirm.forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value.match(/^[0-9]$/)) {
            if (index < pinInputsConfirm.length - 1) {
                pinInputsConfirm[index + 1].focus(); // Chuyển sang ô tiếp theo
            }
        } else {
            this.value = ''; // Nếu không phải số, xóa ô
        }
    });
});

// Hiển thị modal xác nhận
function showConfirmModal() {
    const confirmModal = document.getElementById('confirmModal');
    if (confirmModal) {
        confirmModal.style.display = 'block'; // Mở modal
    } else {
        console.error('Modal không tồn tại.');
    }
}
// Ẩn modal xác nhận
function hideConfirmModal() {
    confirmModal.style.display = 'none'; 
}

// Hiển thị modal nhập mã PIN
function showPinModal() {
    pinModal.style.display = 'block'; 
}

// Ẩn modal nhập mã PIN
function hidePinModal() {
    pinModal.style.display = 'none'; 
    pinInputs.forEach(input => input.value = ''); // Xóa giá trị nhập
    pinInputsConfirm.forEach(input => input.value = ''); // Xóa giá trị nhập
}

// Gọi hàm mở thẻ đa năng
function moTheDaNang(pinCode) {
    fetch("{{ route('open.card') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
        },
        body: JSON.stringify({ pin_code: pinCode }) // Gửi mã PIN
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload(); // Tải lại trang sau khi mở thẻ thành công
        }
    })
    .catch(error => console.error('Error:', error));
}

// Sự kiện cho nút mở thẻ
if (openCardButton) {
    openCardButton.onclick = showConfirmModal;
}

// Sự kiện cho nút OK trong modal xác nhận
confirmYesButton.onclick = function() {
    hideConfirmModal(); // Ẩn modal xác nhận
    showPinModal(); // Hiển thị modal nhập mã PIN
};

// Sự kiện cho nút Cancel trong modal xác nhận
confirmNoButton.onclick = hideConfirmModal;

// Sự kiện cho nút OK trong modal nhập mã PIN
pinConfirmYesButton.onclick = function() {
    const pinCode = Array.from(pinInputs).map(input => input.value).join('');
    const pinCodeConfirm = Array.from(pinInputsConfirm).map(input => input.value).join(''); // Lấy mã PIN xác nhận

    // Kiểm tra nếu mã PIN hợp lệ (6 chữ số) và giống nhau
    if (pinCode.length === 6 && pinCodeConfirm.length === 6 && pinCode === pinCodeConfirm) {
        moTheDaNang(pinCode); // Gọi hàm với mã PIN
        hidePinModal(); // Ẩn hộp thoại PIN sau khi xác nhận
    } else {
        alert('Mã PIN không hợp lệ hoặc không khớp. Vui lòng nhập lại.'); // Thông báo nếu mã PIN không hợp lệ
    }
};

// Sự kiện cho nút Cancel trong modal nhập mã PIN
pinConfirmNoButton.onclick = hidePinModal;

// Xử lý tab (nếu cần)
const tabs = document.querySelectorAll('.tabs li');
const tabContents = document.querySelectorAll('.tab-content');
// ... (tiếp tục xử lý tab nếu có)

// Hàm để chuyển đổi giữa các tab
function switchTab(event) {
    const targetIndex = Array.from(tabs).indexOf(event.target); // Lấy chỉ số của tab được nhấn

    // Xóa class active khỏi tất cả các tab và nội dung tab
    tabs.forEach(tab => tab.classList.remove('active'));
    tabContents.forEach(content => content.classList.remove('active'));

    // Thêm class active cho tab và nội dung tương ứng
    event.target.classList.add('active');
    tabContents[targetIndex].classList.add('active');
}

// Lắng nghe sự kiện click trên từng tab
tabs.forEach(tab => {
    tab.addEventListener('click', switchTab);
});
    // Biểu đồ Expense Statistics
    const ctx = document.getElementById('expenseAreaChart').getContext('2d');
    let expenseAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Nhãn sẽ được cập nhật từ dữ liệu API
            datasets: [{
                label: 'Expenses',
                data: [], // Dữ liệu sẽ được cập nhật từ API
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'category', // Nếu không sử dụng time, sử dụng loại này
                    title: {
                        display: true,
                        text: 'Ngày' // Tiêu đề cho trục x
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Tổng Chi Tiêu' // Tiêu đề cho trục y
                    }
                }
            }
        }
    });

    // Hàm để cập nhật biểu đồ
    function updateChart(period) {
        fetch(`http://localhost/web_ban_banh_kem/public/expense-data?period=${period}`)

            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Xóa dữ liệu cũ
                expenseAreaChart.data.labels = [];
                expenseAreaChart.data.datasets[0].data = [];

                // Thêm dữ liệu mới
                data.forEach(item => {
                    expenseAreaChart.data.labels.push(item.date); // Ngày
                    expenseAreaChart.data.datasets[0].data.push(item.total); // Tổng chi tiêu
                });

                // Cập nhật biểu đồ
                expenseAreaChart.update();
            })
            .catch(error => console.error('Error fetching expense data:', error));
    }

    // Lắng nghe sự thay đổi của radio buttons
    document.querySelectorAll('input[name="time-period"]').forEach((input) => {
        input.addEventListener('change', (event) => {
            updateChart(event.target.value);
        });
    });

    // Khởi động với dữ liệu mặc định (theo tuần)
    updateChart('week');
    document.getElementById('change-pin-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn chặn hành động mặc định của form

    // Lấy giá trị từ các trường nhập
    const oldPin = document.getElementById('old-pin').value;
    const newPin = document.getElementById('new-pin').value;
    const confirmNewPin = document.getElementById('confirm-new-pin').value;

    // Kiểm tra mã PIN cũ
    if (!/^\d{6}$/.test(oldPin)) {
        alert('Mã PIN cũ phải là 6 ký tự số.');
        return;
    }

    // Kiểm tra mã PIN mới
    if (!/^\d{6}$/.test(newPin)) {
        alert('Mã PIN mới phải là 6 ký tự số.');
        return;
    }

    // Kiểm tra mã PIN xác nhận
    if (!/^\d{6}$/.test(confirmNewPin)) {
        alert('Mã PIN xác nhận phải là 6 ký tự số.');
        return;
    }

    // Kiểm tra mã PIN mới có khớp với mã PIN xác nhận không
    if (newPin !== confirmNewPin) {
        alert('Mã PIN mới và mã PIN xác nhận không khớp.');
        return;
    }

    // Nếu tất cả các điều kiện hợp lệ, gửi form qua AJAX
    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => response.json())
    .then(data => {
        const resultMessage = document.getElementById('result-message');
        resultMessage.innerHTML = ''; // Xóa thông báo cũ

        if (data.success) {
            resultMessage.innerHTML = `<p style="color: green;">${data.message}</p>`;
            
            // Reset giá trị của các ô nhập
            document.getElementById('old-pin').value = '';
            document.getElementById('new-pin').value = '';
            document.getElementById('confirm-new-pin').value = '';
        } else {
            // Kiểm tra xem data.errors có phải là một mảng hay không
            if (Array.isArray(data.errors)) {
                for (const error of data.errors) {
                    resultMessage.innerHTML += `<p style="color: red;">${error}</p>`;
                }
            } else {
                // Nếu không, hiển thị thông báo lỗi chung
                resultMessage.innerHTML += `<p style="color: red;">${data.message || 'Đã có lỗi xảy ra.'}</p>`;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
});


});
function updateProgressCircle(percentage) { 
    const circle = document.querySelector('#progress-circle');
    const degrees = (percentage / 100) * 360;
    circle.style.background = `conic-gradient(#4CAF50 ${degrees}deg, #E0E0E0 ${degrees}deg)`;
    
    // Cập nhật phần trăm hiển thị
    const percentageElement = document.getElementById('progress-percentage');
    percentageElement.textContent = `${percentage}%`;
}

// Tính toán phần trăm từ thông tin của người dùng
function calculateProfileCompletion(user) {
    let completedFields = 0;
    const totalFields = 9; // Tổng số trường thông tin cần hoàn thành
    
    // Kiểm tra các trường thông tin
    if (user.name) completedFields++;
    if (user.user_name) completedFields++;
    if (user.email) completedFields++;
    if (user.phone_number) completedFields++;
    if (user.address) completedFields++;
    if (user.ma_benh_nhan) completedFields++;
    if (user.gioi_tinh) completedFields++;
    if (user.ngay_sinh) completedFields++;
    if (user.avatar) completedFields++;

    // Tính phần trăm hoàn thành hồ sơ và làm tròn đến số tự nhiên
    const percentage = Math.round((completedFields / totalFields) * 100);
    updateProgressCircle(percentage);
}

// Giả sử bạn đã lấy thông tin người dùng từ server
const user = {
    name: '{{ $user->name }}',
    user_name: '{{ $user->user_name }}',
    email: '{{ $user->email }}',
    phone_number: '{{ $user->phone_number }}',
    address: '{{ $user->address }}',
    ma_benh_nhan: '{{ $user->ma_benh_nhan }}',
    gioi_tinh: '{{ $user->gioi_tinh }}',
    ngay_sinh: '{{ $user->ngay_sinh }}',
    avatar: '{{ $user->avatar }}'
};

// Tính toán và cập nhật tiến trình
calculateProfileCompletion(user);


        // Call the function with the initial percentage
       
        document.getElementById('profile-pic-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-pic').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        document.getElementById('toggleBalance').addEventListener('click', function() {
    const balanceText = document.getElementById('balanceText');
    const icon = document.getElementById('toggleBalance');
    const actualBalance = "{{ $theDaNang ? $theDaNang->getFormattedBalanceAttribute() : '' }}"; // Kiểm tra và lấy số dư từ backend

    // Kiểm tra xem có thẻ đa năng không
    if (!actualBalance) {
        alert('Chưa có thẻ đa năng.');
        return;
    }

    // Kiểm tra trạng thái hiện tại của số dư
    if (balanceText.textContent === '********') {
        balanceText.textContent = actualBalance; // Hiển thị số dư thực
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        balanceText.textContent = '********'; // Ẩn số dư
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
});

document.getElementById('profile-pic-input').addEventListener('change', function() {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    const formData = new FormData();
    const avatarInput = document.getElementById('profile-pic-input');

    if (avatarInput.files.length > 0) {
        formData.append('avatar', avatarInput.files[0]);

        axios.post("{{ route('update.avatar') }}", formData, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            // Cập nhật ảnh đại diện trong giao diện
            const profilePic = document.getElementById('profile-pic');
            profilePic.src = URL.createObjectURL(avatarInput.files[0]);

            // Hiển thị thông báo thành công
            alert(response.data.message); // Thay thế bằng thông báo từ controller
        })
        .catch(error => {
            console.error(error);
            alert('Cập nhật ảnh đại diện không thành công.'); // Thông báo lỗi
        });
    }
});
function openEditForm() {
        document.getElementById('edit-form-overlay').style.display = 'flex';
    }

    function closeEditForm() {
        document.getElementById('edit-form-overlay').style.display = 'none';
    }
    function openPasswordForm() {
    document.getElementById('password-form-overlay').style.display = 'flex'; // Hiển thị form ẩn
}

function closePasswordForm() {
    document.getElementById('password-form-overlay').style.display = 'none'; // Đóng form ẩn
}

// Xử lý sự kiện submit form đổi mật khẩu
$('#change-password-form').on('submit', function(e) {
    e.preventDefault(); // Ngăn reload trang

    let formData = $(this).serialize(); // Serialize tất cả các input trong form
    console.log(formData); // In ra dữ liệu của form

    $.ajax({
        url: '{{ route("user.update.password") }}', // Route xử lý đổi mật khẩu
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            if (response.success) {
                alert('Đổi mật khẩu thành công!');
                // Thiết lập lại giá trị các ô nhập
                $('#old_password').val('');
                $('#new_password').val('');
                $('#new_password_confirmation').val('');
                closePasswordForm(); // Đóng form sau khi thành công
            } else {
                alert('Đổi mật khẩu thất bại: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Đã xảy ra lỗi, vui lòng thử lại!');
        }
    });
});
function viewOrderDetails(orderId) {
    const url = "{{ route('order.details', ':id') }}".replace(':id', orderId);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('order-details-container');
            container.innerHTML = '';
            
            let orderStatus = data.order.status;
            let shippingId = data.order.shipping_id;

            // CSS cho thanh tiến trình
            const styleElement = document.createElement('style');
            styleElement.textContent = `
                .progress-track {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    position: relative;
                    margin: 40px 0;
                    padding: 0 20px;
                }

                .progress-track::before {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 0;
                    right: 0;
                    height: 2px;
                    background: #e0e0e0;
                    z-index: 1;
                }

                .progress-step {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    position: relative;
                    z-index: 2;
                }

                .progress-icon {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background: white;
                    border: 2px solid #e0e0e0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 8px;
                }

                .progress-icon i {
                    color: #e0e0e0;
                    font-size: 20px;
                }

                .progress-text {
                    font-size: 12px;
                    color: #757575;
                    text-align: center;
                    max-width: 80px;
                }

                .progress-step.active .progress-icon {
                    border-color: #00bcd4;
                    background: #00bcd4;
                }

                .progress-step.active .progress-icon i {
                    color: white;
                }

                .progress-step.active .progress-text {
                    color: #00bcd4;
                    font-weight: bold;
                }

                .progress-line {
                    position: absolute;
                    height: 2px;
                    background: #00bcd4;
                    top: 20px;
                    left: 0;
                    transition: width 0.5s ease;
                }
            `;
            document.head.appendChild(styleElement);

            // Render thanh tiến trình
            let progressHtml = `
                <div class="progress-track">
                    <div class="progress-step${orderStatus ? ' active' : ''}">
                        <div class="progress-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="progress-text">Đã đặt hàng</span>
                    </div>`;

            if (orderStatus === 'cancelled') {
                progressHtml += `
                    <div class="progress-step active">
                        <div class="progress-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <span class="progress-text">Đã hủy</span>
                    </div>`;
            } else {
                progressHtml += `
                    <div class="progress-step${orderStatus === 'processing' || orderStatus === 'completed' ? ' active' : ''}">
                        <div class="progress-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <span class="progress-text">Đang nấu</span>
                    </div>
                    <div class="progress-step${orderStatus === 'shipping' || orderStatus === 'completed' ? ' active' : ''}">
                        <div class="progress-icon">
                            <i class="fas fa-${shippingId ? 'truck' : 'clock'}"></i>
                        </div>
                        <span class="progress-text">${shippingId ? 'Đang vận chuyển' : 'Chờ nhận hàng'}</span>
                    </div>
                    <div class="progress-step${orderStatus === 'completed' ? ' active' : ''}">
                        <div class="progress-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="progress-text">Đã giao hàng</span>
                    </div>`;
            }

            progressHtml += `</div>`;
            container.innerHTML = progressHtml;

            // Render chi tiết đơn hàng
            data.orderDetails.forEach(detail => {
                container.innerHTML += `
                    <div class="order-item">
                        <img src="images/${detail.product.image}" alt="${detail.product.name}" class="product-image">
                        <p>Sản phẩm: ${detail.product.name}</p>
                        <p>Số lượng: ${detail.quantity}</p>
                        <p>Giá: ${detail.amount} VND</p>
                    </div>
                `;
            });

            document.getElementById('order-details-modal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
        });
}


    // Hàm đóng modal khi click ra ngoài
    function closeOrderDetails() {
        document.getElementById('order-details-modal').style.display = 'none';
    }

    // Đóng modal khi click ngoài khung chi tiết
    window.onclick = function(event) {
        const modal = document.getElementById('order-details-modal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    document.querySelector('.filter-btn').addEventListener('click', function() {
    const searchTerm = document.getElementById('search-input').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const status = document.getElementById('status-filter').value;

    // Gọi hàm để tải dữ liệu
    loadFilteredData(searchTerm, startDate, endDate, status);
});

const filterOrdersUrl = "{{ route('filter.orders') }}";

function loadFilteredData(searchTerm, startDate, endDate, status) {
    const url = `${filterOrdersUrl}?search=${encodeURIComponent(searchTerm)}&start=${startDate}&end=${endDate}&status=${encodeURIComponent(status)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi khi tải dữ liệu.');
            }
            return response.json();
        })
        .then(data => {
            // Cập nhật bảng dữ liệu tại đây
            updateOrderTable(data.orders);
        })
        .catch(error => {
            console.error('Đã xảy ra lỗi:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
}

function updateOrderTable(orders) {
    const orderTableBody = document.querySelector('.order-table tbody');
    orderTableBody.innerHTML = ''; // Xóa bảng cũ

    if (orders.length === 0) {
        orderTableBody.innerHTML = '<tr><td colspan="10" style="text-align:center;">Không có đơn hàng nào được tìm thấy.</td></tr>';
        return;
    }

    orders.forEach(order => {
        const userName = order.user ? order.user.name : 'Không có';
        const userPhone = order.user ? order.user.phone_number : 'Không có';
        const shippingRoomName = order.shipping ? order.shipping.room_name : 'Không có';

        let orderRow = `
            <tr>
                <td>${order.id}</td>
                <td>${new Date(order.created_at).toLocaleDateString()}</td>
                <td>${userName}</td>
                <td>${userPhone}</td>
                <td>${new Intl.NumberFormat().format(order.total_amount)} VND</td>
                <td>${order.payment_method}</td>
                <td>${shippingRoomName}</td>
                <td>${order.notes || ''}</td>
                <td>
                    ${order.status === 'pending' ? `<button class="btn cancel-order-btn" onclick="cancelOrder(${order.id})">Hủy đơn</button>` : ''}
                    ${order.status === 'processing' ? `<button class="btn confirm-receipt-btn" onclick="confirmReceipt(${order.id})">Xác nhận nhận hàng</button>` : ''}
                    ${['cancelled', 'completed'].includes(order.status) ? `<button class="btn report-order-btn" onclick="reportOrder(${order.id})">Báo cáo</button>` : ''}
                </td>
                <td><button class="view-details-btn" onclick="viewOrderDetails(${order.id})">Xem chi tiết</button></td>
            </tr>
        `;
        orderTableBody.innerHTML += orderRow;
    });
}
document.querySelector('.export-btn').addEventListener('click', function() {
    const searchTerm = document.getElementById('search-input').value;
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;
    const status = document.getElementById('status-filter').value;

    // Gọi hàm để tải dữ liệu
    loadFilteredDataForExport(searchTerm, startDate, endDate, status);
});

function loadFilteredDataForExport(searchTerm, startDate, endDate, status) {
    const url = `${filterOrdersUrl}?search=${encodeURIComponent(searchTerm)}&start=${startDate}&end=${endDate}&status=${encodeURIComponent(status)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi khi tải dữ liệu cho xuất file.');
            }
            return response.json();
        })
        .then(data => {
            // Xuất dữ liệu thành file CSV
            exportToCSV(data.orders);
        })
        .catch(error => {
            console.error('Đã xảy ra lỗi:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
        });
}

function exportToCSV(orders) {
    if (orders.length === 0) {
        alert('Không có đơn hàng nào để xuất.');
        return;
    }

    const csvRows = [];
    const headers = ['Mã đặt hàng', 'Ngày đặt hàng', 'Tên khách hàng', 'Số điện thoại', 'Tổng tiền', 'Phương thức thanh toán', 'Thông tin vận chuyển', 'Ghi chú', 'Trạng thái'];
    csvRows.push(headers.join(',')); // Thêm tiêu đề

    orders.forEach(order => {
        const row = [
            order.id,
            new Date(order.created_at).toLocaleDateString('vi-VN'), // Định dạng ngày theo kiểu Việt Nam
            order.user ? order.user.name : 'Không có',
            order.user ? order.user.phone_number : 'Không có',
            new Intl.NumberFormat('vi-VN').format(order.total_amount) + ' VND', // Định dạng tiền tệ Việt Nam
            order.payment_method || 'Không có',
            order.shipping ? order.shipping.room_name : 'Không có', // Kiểm tra nếu có thông tin vận chuyển
            order.notes || '',
            order.status // Lấy trạng thái đơn hàng
        ];
        csvRows.push(row.join(',')); // Thêm hàng dữ liệu
    });

    // Tạo file CSV và tải về
    const csvString = '\ufeff' + csvRows.join('\n'); // Thêm BOM để đảm bảo UTF-8
    const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', 'don_hang_cua_ban.csv'); // Tên file
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
function cancelOrder(orderId) {
    if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
        return;
    }

    const url = "{{ route('order.cancel', ':id') }}".replace(':id', orderId);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload(); // Tải lại trang để cập nhật trạng thái đơn hàng
        } else {
            alert(data.message); // Hiển thị thông báo lỗi nếu không thể hủy đơn hàng
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi khi hủy đơn hàng');
    });
}
function confirmReceipt(orderId) {
    if (!confirm('Bạn có chắc chắn đã nhận được hàng?')) {
        return;
    }

    const url = "{{ route('order.complete', ':id') }}".replace(':id', orderId);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload(); // Tải lại trang để cập nhật trạng thái đơn hàng
        } else {
            alert(data.message); // Hiển thị thông báo lỗi nếu không thể đánh dấu là đã nhận hàng
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi khi xác nhận nhận hàng');
    });
}
document.querySelectorAll('.promotion-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        // Xóa lớp active khỏi tất cả các tab và tab content
        document.querySelectorAll('.promotion-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.promotion-tab-item').forEach(item => item.classList.remove('active'));

        // Thêm lớp active vào tab đã nhấp và tab content tương ứng
        tab.classList.add('active');
        const tabContentId = tab.getAttribute('data-tab');
        const tabContent = document.getElementById(tabContentId);
        tabContent.classList.add('active');
    });
});
const prizes = [
            { name: "Chúc bạn may mắn lần sau", probability: 40, color: "#FF6B6B" },
            { name: "Vé giảm giá 10k", probability: 30, color: "#4ECDC4" },
            { name: "Vé giảm giá 20k", probability: 7, color: "#45B7D1" },
            { name: "Vé giảm giá 50k", probability: 2, color: "#96CEB4" },
            { name: "Vé giảm giá 100k", probability: 0.5, color: "#FFEEAD" },
            { name: "Tiền thẻ đa năng 10k", probability: 16.4, color: "#D4A5A5" },
            { name: "Tiền thẻ đa năng 20k", probability: 3, color: "#9DC8C8" },
            { name: "Tiền thẻ đa năng 50k", probability: 1, color: "#58C9B9" },
            { name: "Tiền thẻ đa năng 100k", probability: 0.09, color: "#519D9E" },
            { name: "Tiền thẻ đa năng 1 triệu", probability: 0.01, color: "#FF9999" }
        ];

        let points = "{{ $user->loyalty_points }}";
        console.log("Điểm tích lũy hiện tại:", points);

        const pointsPerSpin = 20;
        const wheel = document.getElementById('wheel');
        const pointsDisplay = document.getElementById('points');
        const wheelCenter = document.getElementById('wheel-center');
        const legend = document.getElementById('prize-legend');
        let isSpinning = false;
        let currentRotation = 0; // Track current rotation

        // Create wheel segments and legend (unchanged)
        prizes.forEach((prize, index) => {
            const segment = document.createElement('div');
            segment.className = 'wheel-item';
            segment.style.transform = `rotate(${index * 36}deg)`;
            segment.style.backgroundColor = prize.color;
            wheel.appendChild(segment);
        });

        prizes.forEach(prize => { 
    // Kiểm tra nếu phần thưởng không phải là "Chúc bạn may mắn lần sau"
    if (!prize.name.includes('Chúc bạn may mắn lần sau')) {
        const legendItem = document.createElement('div');
        legendItem.className = 'legend-item' + (prize.name.includes('1 triệu') ? ' large-prize' : ''); // Thêm lớp cho giải thưởng lớn
        legendItem.innerHTML = `
            <span>${prize.name}</span>
        `;
        legend.appendChild(legendItem);
    }
});


        function updatePoints() {
            document.getElementById('points').textContent = points;
            if (points < pointsPerSpin) {
                wheelCenter.classList.add('disabled');
            } else {
                wheelCenter.classList.remove('disabled');
            }
        }

        function tryToSpin() {
            if (isSpinning) return;

            if (points < pointsPerSpin) {
                document.getElementById('result').innerHTML = 
                    `Bạn cần ${pointsPerSpin} điểm để quay. Hiện tại bạn có ${points} điểm.`;
                return;
            }

            points -= pointsPerSpin;
            updatePoints();
            spin();
        }

        function spin() {
    isSpinning = true;

    // Reset the wheel's rotation before starting a new spin
    wheel.style.transition = 'none';  // Disable transition to reset instantly
    wheel.style.transform = 'rotate(0deg)';  // Reset rotation to 0 degrees

    // Use setTimeout to ensure the reset happens before the new rotation
    setTimeout(() => {
        wheel.style.transition = 'transform 4s cubic-bezier(0.17, 0.67, 0.12, 0.99)';  // Reapply transition
        const random = Math.random() * 100;
        let cumulative = 0;
        let selectedPrize;

        // Find the selected prize based on probability
        for (const prize of prizes) {
            cumulative += prize.probability;
            if (random <= cumulative) {
                selectedPrize = prize;
                break;
            }
        }

        const segments = prizes.length;
        const prizeIndex = prizes.indexOf(selectedPrize);
        
        // Calculate the rotation angle
        const rotation = 1440 + (360 * prizeIndex / segments) + (360 / segments / 2); // Adjust rotation to ensure landing in the middle of the prize segment

        wheel.style.transform = `rotate(${rotation}deg)`;  // Apply the new rotation

        // Simulate the spinning delay
        setTimeout(() => {
            isSpinning = false;

            // Gán nội dung vào modal
            const resultMessage = selectedPrize.name === "Chúc bạn may mắn lần sau" 
                ? "Chúc bạn may mắn lần sau! 🍀" 
                : `Chúc mừng! Bạn đã trúng: ${selectedPrize.name} 🎉`;

            document.getElementById('modal-result').innerHTML = resultMessage;

            // Hiển thị modal với kết quả
            document.getElementById('modal').style.display = 'flex'; 

            // Cập nhật tạm thời lịch sử quay
            updateSpinHistoryTable(selectedPrize.name);

            // Gửi yêu cầu lưu lịch sử quay vào cơ sở dữ liệu
            saveSpinHistory(resultMessage);

            // Gửi yêu cầu cập nhật phần thưởng vào cơ sở dữ liệu
            updatePrizeInDatabase(selectedPrize.name);

            // Gửi yêu cầu cập nhật điểm tích lũy
            updatePointsInDatabase(-20);

        }, 4000);  // Small delay to allow reset before applying new rotation
    }, 50);
}
const userId = "{{ $user->id }}";  // Lấy user_id từ đối tượng user
const updatePrizeUrl = "{{ route('spin.updatePrize') }}";  
function updatePrizeInDatabase(prizeName) {
    fetch(updatePrizeUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Bảo mật CSRF Token
        },
        body: JSON.stringify({
            user_id: userId,  // Dùng biến userId đã được truyền từ Blade
            prize: prizeName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Phần thưởng đã được cập nhật thành công.');

            // Hiển thị thông báo nếu phần thưởng được quy đổi
            if (data.message.includes("quy đổi")) {
                alert(data.message);  // Hiển thị thông báo quy đổi
            }
            
            // Kiểm tra thông báo cho trường hợp không có thẻ đa năng
            if (data.message.includes("liên hệ với canteen")) {
                alert(data.message);  // Hiển thị thông báo liên hệ với canteen
            }
        } else {
            console.error('Lỗi khi cập nhật phần thưởng:', data.message);
            alert('Đã xảy ra lỗi khi cập nhật phần thưởng.');
        }
    })
    .catch(error => {
        console.error('Lỗi kết nối:', error);
        alert('Lỗi kết nối với máy chủ.');
    });
}


// Hàm để cập nhật lịch sử quay
function updateSpinHistoryTable(result) {
    const spinHistoryTableBody = document.querySelector('#spin-history-table tbody');

    // Tạo một hàng mới cho kết quả vừa quay
    const newRow = document.createElement('tr');

    // Tạo các ô cho kết quả và thời gian quay
    const resultCell = document.createElement('td');
    resultCell.textContent = result;  // Thêm kết quả vào ô
    const dateCell = document.createElement('td');
    dateCell.textContent = new Date().toLocaleString('vi-VN');  // Thêm thời gian hiện tại vào ô

    // Thêm các ô vào hàng mới
    newRow.appendChild(resultCell);
    newRow.appendChild(dateCell);

    // Thêm hàng mới vào đầu bảng lịch sử
    spinHistoryTableBody.prepend(newRow);
}



function saveSpinHistory(result) {
    $.ajax({
        url: "{{ route('spin.history.store') }}",  // Sử dụng tên route
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',  // Đảm bảo CSRF token được gửi kèm
            result: result
        },
        success: function(response) {
            if (response.success) {
                console.log(response.message);
            } else {
                console.log('Lưu lịch sử quay thất bại.');
            }
        },
        error: function(xhr) {
            console.log('Đã xảy ra lỗi: ' + xhr.responseText);
        }
    });
}


// Hàm gửi yêu cầu AJAX cập nhật điểm tích lũy
function updatePointsInDatabase(pointsChange) {
    // Sử dụng URL từ route name
    const url = "{{ route('updatePoints') }}"; // Chèn tên route vào đây

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            pointsChange: pointsChange // Trừ 20 điểm
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật lại số điểm tích lũy trên giao diện
            points = data.newPoints; // Cập nhật biến points từ server
            updatePoints(); // Gọi hàm updatePoints để cập nhật giao diện
        } else {
            console.error('Cập nhật điểm thất bại:', data.message);
        }
    })
    .catch(error => {
        console.error('Lỗi khi gửi yêu cầu cập nhật điểm:', error);
    });
}
function closeModal(event) {
        if (event.target.id === 'modal' || event.target.tagName === 'BUTTON') {
            document.getElementById('modal').style.display = 'none'; // Ẩn modal
        }
    }

        // Initialize points display
        updatePoints();
        function reportOrder(orderId) {
    const reportDialog = document.getElementById('report-dialog');
    reportDialog.style.display = 'block'; // Hiển thị hộp thoại

    // Lưu lại orderId để sử dụng khi gửi báo cáo
    reportDialog.setAttribute('data-order-id', orderId);
}

// Đóng hộp thoại
document.getElementById('close-report-dialog').addEventListener('click', function () {
    document.getElementById('report-dialog').style.display = 'none';
});

// Hiển thị ô nhập chi tiết nếu chọn lý do "Khác"
document.getElementById('other-reason').addEventListener('change', function () {
    const otherReasonDetails = document.getElementById('other-reason-details');
    otherReasonDetails.style.display = this.checked ? 'block' : 'none';
});

// Gửi báo cáo
document.getElementById('submit-report-btn').addEventListener('click', function () {
    const reportDialog = document.getElementById('report-dialog');
    const orderId = reportDialog.getAttribute('data-order-id');
    const selectedReason = document.querySelector('input[name="report-reason"]:checked');
    const otherReasonDetails = document.getElementById('other-reason-details').value;

    if (!selectedReason) {
        alert('Vui lòng chọn lý do báo cáo.');
        return;
    }

    let reason = selectedReason.value;
    if (reason === 'Khác') {
        if (!otherReasonDetails.trim()) {
            alert('Vui lòng nhập chi tiết lý do.');
            return;
        }
        reason = otherReasonDetails;
    }

    // Dữ liệu báo cáo
    const reportData = {
        order_id: orderId,
        reason: reason,
    };

    console.log('Data prepared for submission:', reportData);

    // Gửi báo cáo đến server qua fetch
    fetch('http://localhost/web_ban_banh_kem/public/report/order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(reportData),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message); // Thông báo từ server
                reportDialog.style.display = 'none'; // Đóng hộp thoại
            } else {
                alert('Có lỗi xảy ra khi gửi báo cáo: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi gửi báo cáo.');
        });
});

</script>


</body>
</html>
