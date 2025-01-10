<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/speech.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">


    <style>
        .quantity-selector {
    display: flex;
    align-items: center;
}
.search-container {
    position: relative;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    max-height: 300px;
    overflow-y: auto;
    z-index: 999;
}

.search-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.search-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin-right: 10px;
}

.search-item-details {
    flex: 1;
}

.search-item-details p {
    margin: 0;
    font-size: 14px;
}
.quantity-selector button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

.quantity-selector input {
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

        .product-link {
    text-decoration: none;
    color: inherit; /* Giữ nguyên màu chữ từ phần tử cha */
}

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .search-form {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }
        .search-input {
            width: 70%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #45a049;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
        }
        .product-grid {
    margin: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    transform: translateX(-50px); /* Dịch toàn bộ lưới sang trái */
}

.product-card {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    flex-direction: column;
}

        .product-image {
            width: 100%;
            height: 150px;
            background-color: #eee;
            margin-bottom: 10px;
        }
        .product-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-price {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-status {
            font-size: 0.9em;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: auto;
        }
        .add-button, .remove-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-button {
            background-color: #2ecc71;
            color: white;
        }
        .remove-button {
            background-color: #e74c3c;
            color: white;
        }
        .existing-products {
    position: absolute; /* Chuyển từ fixed sang absolute để có thể di chuyển */
    top: 200px;
    right: 0px;
    max-height: 400px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 250px;
    padding: 15px;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}



.existing-product {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 5px 0;
    border-bottom: 1px solid #f0f0f0;
}
.existing-product-name {
    font-weight: bold;
    font-size: 14px;
}

.existing-product-price {
    color: #e74c3c;
    font-weight: bold;
    font-size: 14px;
}

.total-section {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding-top: 10px;
    border-top: 2px solid #ddd;
}

.total-label {
    font-weight: bold;
    font-size: 16px;
}

.total-price {
    color: #27ae60;
    font-weight: bold;
    font-size: 16px;
}

.checkout-button {
    display: block;
    width: 100%;
    margin-top: 20px;
    padding: 10px 0;
    background-color: #2ecc71;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}

.checkout-button:hover {
    background-color: #27ae60;
}
.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.product-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.product-name {
    font-weight: bold;
    font-size: 1.2em;
    margin-top: 10px;
    text-align: center;
}

.product-price {
    color: #f56a00;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
}

.quantity-control {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
}

.quantity-control button {
    background-color: #f56a00;
    color: #fff;
    border: none;
    padding: 5px 10px;
    font-size: 16px;
    cursor: pointer;
}

.quantity-control input {
    width: 50px;
    text-align: center;
    border: 1px solid #ddd;
    margin: 0 5px;
    border-radius: 4px;
}

.quantity-control button:focus {
    outline: none;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 15px; /* Khoảng cách giữa các phần tử */
    margin-top: 10px;
    justify-content: space-between; /* Giữ nút giỏ hàng và nút "X" không bị chen lấn */
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f7f7f7;
    padding: 5px;
}

.quantity-control button {
    background-color: transparent;
    border: none;
    font-size: 18px;
    color: #555;
    padding: 5px;
    cursor: pointer;
}

.quantity-control button:hover {
    color: #007bff;
}

.quantity-control input {
    width: 40px;
    text-align: center;
    border: none;
    background-color: transparent;
    font-size: 16px;
}

.add-to-cart-btn, .remove-from-cart-btn {
    background-color: transparent;
    border: none;
    color: #333;
    font-size: 20px;
    cursor: pointer;
    padding: 5px;
}

.add-to-cart-btn:hover, .remove-from-cart-btn:hover {
    color: #007bff;
}

.add-to-cart-btn i, .remove-from-cart-btn i {
    font-size: 22px;
}
.product-image img {
    max-width: 100%;  /* Giới hạn kích thước tối đa của ảnh */
    max-height: 100%; /* Đảm bảo ảnh không bị vượt quá khung */
    object-fit: cover; /* Ảnh sẽ bao phủ toàn bộ khung và cắt những phần không cần thiết */
}
.ai-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    z-index: 1000;
}

.ai-button i {
    font-size: 24px;
}

/* Modal hiển thị bên trái button microphone */
.ai-modal {
    display: none;
    position: fixed; /* Chuyển sang fixed để cố định modal */
    bottom: 20px; /* Đặt cùng vị trí với button */
    right: calc(20px + 60px); /* Đặt modal cách nút 60px (kích thước button + khoảng cách) */
    width: 300px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1001;
}

.ai-modal-content {
    text-align: center;
}

.close-ai-modal-btn {
    padding: 10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.close-ai-modal-btn:hover {
    background-color: darkred;
}
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

.bounce {
    animation: bounce 1s ease infinite;
}

/* Speech Bubble */
.speech-bubble {
    position: fixed; /* Đổi từ absolute sang fixed */
    right: 80px; /* Căn chỉnh bong bóng cách nút AI */
    bottom: 40px; /* Căn chỉnh bong bóng ở dưới nút AI */
    background: white;
    padding: 10px 15px;
    border-radius: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    font-size: 14px;
    color: #333;
    white-space: nowrap;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}


.speech-bubble::after {
    content: '';
    position: absolute;
    right: -10px;
    bottom: 15px;
    border-width: 10px 0 10px 10px;
    border-style: solid;
    border-color: transparent transparent transparent white;
}

.speech-bubble.show {
    opacity: 1;
    transform: translateX(0);
}

/* Ripple Effect */
.ripple {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transform: scale(0);
    animation: ripple 1s linear infinite;
}

@keyframes ripple {
    0% {
        transform: scale(1);
        opacity: 0.4;
    }
    100% {
        transform: scale(1.5);
        opacity: 0;
    }
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
.existing-products {
    position: fixed; /* Đảm bảo luôn hiển thị cố định khi cuộn */
    top: 200px;
    right: 0px;
    max-height: 400px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 250px;
    padding: 15px;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    cursor: grab; /* Con trỏ mặc định */
    transition: box-shadow 0.2s; /* Hiệu ứng hover */
}

.existing-products:active {
    cursor: grabbing; /* Con trỏ khi đang kéo */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Hiệu ứng khi kéo */
}

.existing-product {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 5px 0;
    border-bottom: 1px solid #f0f0f0;
}
.snowflakes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1000;
}

.snowflake {
    position: absolute;
    color: white;
    font-size: 24px;
    opacity: 0.8;
    animation: fall linear infinite;
    user-select: none;
    pointer-events: none;
}

/* Hiệu ứng rơi */
@keyframes fall {
    0% {
        transform: translateY(-100px);
        opacity: 0.8;
    }
    100% {
        transform: translateY(100vh);
        opacity: 0.5;
    }
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




#mic-button {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #95a5a6;
    font-size: 18px;
    transition: all 0.3s ease;
    padding: 8px;
}

#mic-button:hover {
    color: #3498db;
    transform: translateY(-50%) scale(1.1);
}

/* Product Grid Styling */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-image {
    position: relative;
    padding-top: 75%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-name {
    padding: 15px;
    font-size: 1.1em;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
    height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-price {
    padding: 0 15px;
    color: #e74c3c;
    font-weight: bold;
    font-size: 1.2em;
}

.product-status {
    padding: 5px 15px;
    margin: 10px 15px;
    display: inline-block;
    border-radius: 15px;
    font-size: 0.9em;
    font-weight: 500;
}

.product-status:contains('Còn hàng') {
    background: #e8f5e9;
    color: #2e7d32;
}

.product-status:contains('Hết hàng') {
    background: #ffebee;
    color: #c62828;
}

/* Action Buttons Styling */
.action-buttons {
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}

.quantity-control {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.quantity-control button {
    border: none;
    background: none;
    color: #3498db;
    width: 30px;
    height: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-control button:hover {
    background: #3498db;
    color: white;
}

.quantity-control input {
    width: 40px;
    border: none;
    text-align: center;
    font-weight: bold;
    -moz-appearance: textfield;
}

.quantity-control input::-webkit-outer-spin-button,
.quantity-control input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.add-to-cart-btn, .remove-from-cart-btn {
    border: none;
    border-radius: 20px;
    padding: 8px 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn {
    background: #3498db;
    color: white;
    flex: 1;
}

.add-to-cart-btn:hover {
    background: #2980b9;
    transform: scale(1.05);
}

.remove-from-cart-btn {
    background: #e74c3c;
    color: white;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-from-cart-btn:hover {
    background: #c0392b;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        padding: 15px;
    }

    .product-name {
        font-size: 1em;
        height: 50px;
    }

    .action-buttons {
        flex-wrap: wrap;
    }

    .quantity-control {
        width: 100%;
        margin-bottom: 10px;
    }
}
.search-form {
    position: relative;
    max-width: 800px;
    margin: 20px auto;
    padding: 0 20px;
}

.search-input-container {
    position: relative;
    width: 100%;
}

.search-input {
    width: 100%;
    height: 50px;
    padding: 10px 50px 10px 20px;
    border: 2px solid #e1e1e1;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.search-input:focus {
    border-color: #3498db;
    box-shadow: 0 4px 15px rgba(52,152,219,0.2);
    outline: none;
}

#mic-button {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #95a5a6;
    font-size: 18px;
    transition: all 0.3s ease;
    padding: 8px;
}

#mic-button:hover {
    color: #3498db;
    transform: translateY(-50%) scale(1.1);
}

/* Search Results Styling */
.search-results {
    position: absolute;
    top: 60px;
    left: 20px;
    right: 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    z-index: 1000;
    max-height: 400px;
    overflow-y: auto;
    display: none;
}

.search-results.active {
    display: block;
}

.search-result-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #eee;
    transition: all 0.2s ease;
    text-decoration: none;
    color: inherit;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-item:hover {
    background: #f8f9fa;
}

.search-result-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 15px;
}

.search-result-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.search-result-info {
    flex: 1;
}

.search-result-name {
    font-weight: 600;
    margin-bottom: 5px;
    color: #2c3e50;
}

.search-result-price {
    color: #e74c3c;
    font-weight: 500;
}

/* Product Grid Styling */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.product-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-link {
    text-decoration: none;
    color: inherit;
}

.product-image {
    position: relative;
    padding-top: 75%;
    height: 250px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-image img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: translate(-50%, -50%) scale(1.08);
}

.product-info {
    padding: 20px;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
    line-height: 1.4;
    height: 3em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-price {
    color: #e74c3c;
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.product-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.product-status:contains('Còn hàng') {
    background: #e8f5e9;
    color: #2e7d32;
}

.product-status:contains('Hết hàng') {
    background: #ffebee;
    color: #c62828;
}

/* Action Buttons */
.action-buttons {
    padding: 15px 20px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-control {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 25px;
    border: 1px solid #e1e1e1;
    overflow: hidden;
}

.quantity-control button {
    width: 35px;
    height: 35px;
    border: none;
    background: none;
    color: #3498db;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-control button:hover {
    background: #3498db;
    color: white;
}

.quantity-control input {
    width: 40px;
    height: 35px;
    border: none;
    text-align: center;
    font-size: 1rem;
    font-weight: 600;
    -moz-appearance: textfield;
}

.add-to-cart-btn,
.remove-from-cart-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn {
    background: #3498db;
    color: white;
    flex: 1;
}

.remove-from-cart-btn {
    background: #e74c3c;
    color: white;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
    }

    .product-image {
        height: 300px;
    }

    .action-buttons {
        flex-wrap: wrap;
    }

    .quantity-control {
        width: 100%;
        justify-content: center;
        margin-bottom: 10px;
    }
}
/* Main container */
.product-grid {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

/* Individual product card */
.product-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    position: relative;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
}

/* Product image container */
.product-image {
    margin-bottom: 1rem;
    overflow: hidden;
    border-radius: 10px;
}

.product-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image img:hover {
    transform: scale(1.05);
}

/* Product details */
.product-name {
    font-size: 1.2rem;
    color: #2c3e50;
    margin: 1rem 0;
    font-weight: 500;
}

.product-price {
    color: #e74c3c;
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0.5rem 0;
}

.product-status {
    color: #2c3e50;
    font-size: 1rem;
    margin: 0.5rem 0;
}

/* Action buttons section */
.action-buttons {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    gap: 1rem;
}

/* Quantity control */
.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-control button {
    background: #f1f2f6;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 6px;
    color: #2c3e50;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-control button:hover {
    background: #dfe4ea;
}

.quantity-control .qty {
    width: 70px;
    text-align: center;
    padding: 0.5rem;
    border: 1px solid #dfe4ea;
    border-radius: 6px;
    font-size: 1rem;
}

/* Cart buttons */
.add-to-cart-btn,
.remove-from-cart-btn {
    background: #2ecc71;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-to-cart-btn:hover {
    background: #27ae60;
}

.remove-from-cart-btn {
    background: #e74c3c;
}

.remove-from-cart-btn:hover {
    background: #c0392b;
}

/* Product link */
.product-link {
    text-decoration: none;
    color: inherit;
}

/* Responsive design */
@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: 1fr;
    }

    .product-card {
        margin: 1rem 0;
    }
}
.filter-select:hover {
    border-color: #007bff;
}

.apply-filter:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .filter-section {
        padding: 10px;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .filter-select {
        width: 100%;
    }
}
/* Container Styles */
.search-and-filter-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Search Form Styles */
.search-form {
    margin-bottom: 20px;
    text-align: center;
}

.search-input {
    width: 50%;
    height: 50px;
    padding: 10px 45px 10px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.search-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 3px 8px rgba(0,123,255,0.2);
}

#mic-button {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
    font-size: 18px;
    transition: color 0.3s ease;
}

#mic-button:hover {
    color: #007bff;
}

/* Filter Section Styles */
.filter-section {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    border-radius: 15px;
    padding: 25px;
    margin: 20px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
}

.filter-group {
    flex: 1;
    min-width: 250px;
    margin: 10px;
}

.filter-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    display: block;
    font-size: 15px;
}

.filter-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    background-color: white;
    font-size: 15px;
    color: #444;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
}

.filter-select:hover, .filter-select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 2px 5px rgba(0,123,255,0.2);
}

.apply-filter {
    padding: 12px 30px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.apply-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    background: linear-gradient(45deg, #0056b3, #004494);
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-input {
        width: 90%;
    }
    
    .filter-section > div {
        flex-direction: column;
    }
    
    .filter-group {
        width: 100%;
        margin: 10px 0;
    }
    
    .apply-filter {
        width: 100%;
        margin-top: 15px;
    }
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

    <div class="heading">
        <h3>Menu Của Chúng Tôi</h3>
        <p><a href="{{ url('/') }}">home</a> <span> / menu</span></p>
    </div>
    
    <div class="container">
    <div class="search-container">
    <form action="#" method="GET" class="search-form">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Thư viện Font Awesome -->





</div>
        <div class="existing-products" id="existingProducts">
    @if(auth()->check()) <!-- Kiểm tra người dùng có đăng nhập hay không -->
        @if($cartItems->isEmpty())
            <div class="no-products">Giỏ hàng của bạn trống.</div>
        @else
            @foreach($cartItems as $item)
                <div class="existing-product">
                    <span class="existing-product-name">{{ $item->product->name }}</span>
                    <span class="existing-product-quantity"> x {{ $item->quantity }}</span>
                    <span class="existing-product-price">{{ number_format($item->total_amount, 0, ',', '.') }}đ</span>
                </div>
            @endforeach
            <div class="total-section">
                <span class="total-label">Tổng cộng:</span>
                <span class="total-price">{{ number_format($totalAmount, 0, ',', '.') }}đ</span>
            </div>
            <button class="checkout-button"><a href="http://localhost/web_ban_banh_kem/public/checkout"> Thanh toán</a></button>
        @endif
    @else
        <div class="no-login">Vui lòng đăng nhập để xem giỏ hàng của bạn.</div> <!-- Thông báo nếu chưa đăng nhập -->
    @endif
</div>

<form action="#" method="GET" class="search-form">
    <div style="position: relative; display: inline-block; width: 50%;">
        <input type="text" name="query" placeholder="Tìm kiếm sản phẩm..." class="search-input" id="search-input" style="width: 100%; padding-right: 40px; height: 40px; border: 1px solid #ccc; border-radius: 5px;">
        <button type="button" id="mic-button" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #555;">
            <i class="fas fa-microphone"></i> <!-- Icon mic -->
        </button>
    </div>
</form>
<div class="filter-section" style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px;">
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <!-- Categories Filter -->
        <div class="filter-group">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Danh mục:</label>
            <select class="filter-select" id="category-filter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Departments Filter -->
        <div class="filter-group">
            <label style="font-weight: bold; display: block; margin-bottom: 8px;">Khoa đề xuất:</label>
            <select class="filter-select" id="department-filter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; min-width: 200px;">
                <option value="">Tất cả khoa</option>
                @foreach ($departments as $department)
                    <option value="{{ $department }}">{{ $department }}</option>
                @endforeach
            </select>
        </div>

        <!-- Apply Filter Button -->
        <div class="filter-group" style="display: flex; align-items: flex-end;">
            <button id="apply-filter" class="apply-filter" style="padding: 8px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Áp dụng
            </button>
        </div>
    </div>
</div>
<!-- Thêm nút chuyển đổi view -->
<div class="view-controls">
    <button class="view-btn grid-view active" data-view="grid">
        <i class="fas fa-th"></i> Dạng lưới
    </button>
    <button class="view-btn list-view" data-view="list">
        <i class="fas fa-list"></i> Dạng danh sách
    </button>
    <button class="view-btn table-view" data-view="table">
        <i class="fas fa-table"></i> Dạng bảng
    </button>
</div>

<!-- Giữ nguyên HTML gốc, thay đổi cách hiển thị trong CSS và JavaScript -->
<div id="product-grid" class="product-grid">
    @foreach($products as $product)
    <div class="product-card" data-product-id="{{ $product->id }}" data-detail-id="{{ $product->cartDetail->id ?? '' }}">
        <a href="http://localhost/web_ban_banh_kem/public/quick_view/{{ $product->id }}" class="product-link">
            <div class="product-image">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height:250px; object-fit:cover;">
            </div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">Giá: {{ number_format($product->price, 0, ',', '.') }}đ</div>
            <div class="product-status">{{ $product->quantity_in_stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</div>
        </a>
        
        <div class="action-buttons">
            <div class="quantity-control">
                <button class="decrement">-</button>
                <input type="number" class="qty" value="1" min="1" max="10">
                <button class="increment">+</button>
            </div>
            
            <button class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <button class="remove-from-cart-btn" data-product-id="{{ $product->id }}">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endforeach
</div>


<style>
:root {
    --primary-color: #005e8a;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --border-color: #e9ecef;
    --background: #f8f9fa;
}

/* Nút chuyển đổi view */
.view-controls {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.view-btn {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
}

.view-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Grid view - giữ nguyên style cũ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 10px;
}

/* List view styles */
.product-grid.list-view {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.list-view .product-card {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 10px;
    background: white;
}

.list-view .product-link {
    display: flex;
    align-items: center;
    flex: 1;
    text-decoration: none;
    color: inherit;
}

.list-view .product-image {
    width: 250px; /* Chiều rộng cố định */
    height: 80px; /* Chiều cao cố định */
    margin-right: 15px;
    display: flex; /* Đảm bảo bố cục ảnh hiển thị chính xác */
    align-items: center;
    justify-content: center;
    overflow: hidden; /* Cắt bỏ phần thừa nếu hình ảnh quá lớn */
}

.list-view .product-image img {
    width: 100%; /* Chiều rộng tự động co giãn */
    height: 100%; /* Phủ kín container */
    object-fit: cover; /* Cắt hình ảnh theo chiều container mà không bị méo */
    border-radius: 4px; /* Bo góc */
}

.list-view .product-info-wrapper {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.list-view .product-name {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 5px;
}

.list-view .product-price {
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 5px;
}

.list-view .product-status {
    font-size: 0.875rem;
    color: var(--success-color);
}

.list-view .action-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: 15px;
    padding-left: 15px;
    border-left: 1px solid var(--border-color);
}

.list-view .quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.list-view .quantity-control button {
    width: 28px;
    height: 28px;
    border: none;
    background: white;
    cursor: pointer;
}

.list-view .qty {
    width: 40px;
    text-align: center;
    border: none;
    padding: 4px;
}

.list-view .add-to-cart-btn,
.list-view .remove-from-cart-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-view .add-to-cart-btn {
    background: var(--primary-color);
    color: white;
}

.list-view .remove-from-cart-btn {
    background: var(--danger-color);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .list-view .product-card {
        flex-wrap: wrap;
    }
    
    .list-view .product-link {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .list-view .action-buttons {
        width: 100%;
        margin-left: 0;
        padding-left: 0;
        border-left: none;
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }
}

@media (max-width: 480px) {
    .list-view .product-link {
        flex-wrap: wrap;
    }
    
    .list-view .product-image {
        width: 80px;
        height: 80px;
    }
}
.product-grid.table-view {
    display: table;
    width: 100%;
    border-collapse: collapse;
}

.product-grid.table-view .product-card {
    display: table-row;
    border: 1px solid var(--border-color);
    background: white;
}

.product-grid.table-view .product-card .product-link {
    display: table-cell;
    padding: 10px;
    text-decoration: none;
    color: inherit;
}

.product-grid.table-view .product-image {
    width: 100px; /* Kích thước nhỏ hơn để phù hợp với bảng */
    height: 100px;
    margin-right: 10px;
}

.product-grid.table-view .product-info-wrapper {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.product-grid.table-view .product-name,
.product-grid.table-view .product-price,
.product-grid.table-view .product-status {
    font-size: 0.875rem;
}

.product-grid.table-view .action-buttons {
    display: table-cell;
    text-align: center;
    padding: 10px;
}

.product-grid.table-view .quantity-control {
    display: flex;
    justify-content: center;
}

.product-grid.table-view .add-to-cart-btn,
.product-grid.table-view .remove-from-cart-btn {
    display: inline-block;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    text-align: center;
    margin: 0 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const productGrid = document.getElementById('product-grid');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const view = this.getAttribute('data-view');
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Thêm hoặc loại bỏ các lớp tương ứng với từng chế độ xem
            productGrid.classList.remove('grid-view', 'list-view', 'table-view');
            productGrid.classList.add(`${view}-view`);
        });
    });
});

</script>






<!-- Pagination links -->

    <div class="ai-button-container">
    <button id="ai-button" class="ai-button">
        <i class="fa-solid fa-robot"></i>
        <div class="ripple"></div>
    </button>
    <div class="speech-bubble">Bạn cần hỗ trợ?</div>
</div>


<!-- Modal để hiển thị kết quả của API Speech -->

<!-- Modal để hiển thị kết quả của API Speech -->
<div id="ai-modal" class="ai-modal">
    <div class="ai-modal-content">
        <p id="ai-message">Xin chào! Bạn đang điều trị tại khoa nào?</p>
        <button id="close-ai-modal" class="close-ai-modal-btn">Đóng</button>
    </div>
</div>
<div id="speechButton" class="speech-button draggable">
    <i class="fas fa-volume-up"></i> <!-- Hình loa -->
    <span id="notificationCount" class="notification-count">0</span> <!-- Số lượng thông báo chưa hết hạn -->
</div>
<div class="snowflakes" aria-hidden="true"></div>
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
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="http://localhost/web_ban_banh_kem/public/js/script.js"></script>
<script>
$(document).ready(function(){
    // Bắt sự kiện khi nhấn vào nút thêm vào giỏ hàng
    $(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();
    
    var button = $(this);
    var productId = button.data('product-id'); // Lấy giá trị từ thuộc tính data
    var qty = button.siblings('.quantity-control').find('.qty').val(); // Lấy số lượng từ ô input
    var imageUrl = button.closest('.product-card').find('img').attr('src'); // Lấy đường dẫn hình ảnh của sản phẩm
    var productDetailId = button.closest('.product-card').data('detail-id'); // Lấy ID chi tiết sản phẩm nếu có
    
    // Gửi yêu cầu AJAX
    $.ajax({
        url: '{{ route("add.to.cart") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId,
            qty: qty
        },
        success: function(response) {
            
            loadCartItems();
            // Gọi hàm addToCart sau khi sản phẩm đã được thêm
            addToCart(productId, imageUrl, button[0], parseInt(qty));
        },
        error: function(response) {
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        }
    });
});


    // Tăng giảm số lượng
    $('.increment').click(function() {
        var input = $(this).siblings('.qty');
        var currentVal = parseInt(input.val());
        if (currentVal < 10) {
            input.val(currentVal + 1);
        }
    });

    $('.decrement').click(function() {
        var input = $(this).siblings('.qty');
        var currentVal = parseInt(input.val());
        if (currentVal > 1) {
            input.val(currentVal - 1);
        }
    });
    // Xử lý khi bấm vào nút "X" để xóa sản phẩm
    $(document).on('click', '.remove-from-cart-btn', function() { 
    let button = $(this);
    let box = button.closest('.product-card'); // Lấy box sản phẩm
    let detailId = button.data('detail-id'); // Lấy ID chi tiết sản phẩm
    let productId = button.data('product-id'); // Lấy ID sản phẩm
    let imageUrl = box.find('.product-image img').attr('src'); // Lấy URL ảnh sản phẩm

    // Lấy số lượng hiện tại của sản phẩm từ giỏ hàng
    let quantity = parseInt(box.find('.existing-product-quantity').text().replace('x ', '').trim()) || 1;

    // Lấy vị trí của giỏ hàng
    const cart = $('.cart-icon');
    const cartRect = cart[0].getBoundingClientRect();
    const endX = cartRect.left + cartRect.width / 2;
    const endY = cartRect.top + cartRect.height / 2;

    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        // Thực hiện Ajax để xóa sản phẩm
        $.ajax({
            url: '{{ route("cart.remove") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                detail_id: detailId || productId // Sử dụng detail_id, nếu không có thì dùng product_id
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật giỏ hàng sau khi xóa
                  // Hàm này phải được định nghĩa để cập nhật giỏ hàng

                    // Hiệu ứng bay ngược từ giỏ hàng
                    const flyingImage = $('<img>', {
                        src: imageUrl,
                        class: 'fly-item'
                    }).css({
                        position: 'absolute',
                        top: box.offset().top + box.height() / 2 + 'px',
                        left: box.offset().left + box.width() / 2 + 'px',
                        width: '50px',
                        height: '50px',
                        zIndex: 1000
                    }).appendTo('body');

                    // Bắt đầu hiệu ứng bay
                    setTimeout(() => {
                        flyingImage.css({
                            left: endX + 'px',
                            top: endY + 'px',
                            transform: 'scale(0.1)',
                            opacity: '0.7'
                        });
                    }, 10);

                    // Cập nhật lại số lượng trong giỏ hàng
                    setTimeout(() => {
                        const counter = $('.counter-number');
                        let currentCount = parseInt(counter.data('count')) || 0;
                        currentCount = Math.max(0, currentCount - quantity); // Trừ đi số lượng tương ứng
                        counter.data('count', currentCount);
                        counter.text(currentCount);
                        counter.addClass('counter-animate');

                        // Hiệu ứng lắc giỏ hàng
                        cart.addClass('cart-shake');
                    }, 800);

                    // Xóa hiệu ứng sau một thời gian
                    setTimeout(() => {
                        flyingImage.remove();
                        counter.removeClass('counter-animate');
                        cart.removeClass('cart-shake');
                    }, 1200);
                    loadCartItems(); 
                    console.log("Sản phẩm đã được xóa khỏi giỏ hàng.");
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Có lỗi xảy ra, vui lòng thử lại.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
                console.error("Chi tiết lỗi:", errorMessage);
            }
        });
    } else {
        console.log("Người dùng đã hủy thao tác xóa.");
    }
});

 // Tìm kiếm tự động khi gõ vào ô input
 $('.search-input').on('input', function () {
    let query = $(this).val().trim();

    if (query.length > 0) {
        // Gửi yêu cầu AJAX tìm kiếm
        $.ajax({
            url: "{{ route('products.searchmenu') }}",
            method: 'GET',
            data: { query: query },
            success: function (response) {
                if (response.length > 0) {
                    // Tạo HTML sản phẩm từ dữ liệu phản hồi
                    let productHtml = response.map(product => `
                        <div class="product-card" data-product-id="${product.id}" data-detail-id="${product.id}">
                            <a href="{{ url('quick_view') }}/${product.id}" class="product-link">
                                <div class="product-image">
                                    <img src="{{ asset('images') }}/${product.image}" alt="${product.name}" style="width:100%; height:250px; object-fit:cover;">
                                </div>
                                <div class="product-name">${product.name}</div>
                                <div class="product-price">Giá: ${new Intl.NumberFormat('vi-VN').format(product.price)}đ</div>
                                <div class="product-status">${product.quantity_in_stock > 0 ? 'Còn hàng' : 'Hết hàng'}</div>
                            </a>
                            <div class="action-buttons">
                                <div class="quantity-control">
                                    <button class="decrement">-</button>
                                    <input type="number" class="qty" value="1" min="1" max="${product.quantity_in_stock}">
                                    <button class="increment">+</button>
                                </div>
                                <button class="add-to-cart-btn" data-product-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="remove-from-cart-btn" data-product-id="${product.id}" data-detail-id="${product.id}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');

                    // Hiển thị sản phẩm vào grid
                    $('.product-grid').html(productHtml).show();
                } else {
                    // Hiển thị thông báo không có sản phẩm
                    showNoProductsMessage(document.querySelector('.product-grid'));
                }
            },
            error: function () {
                console.error('Lỗi khi lấy dữ liệu tìm kiếm.');
            }
        });
    } else {
        // Xóa danh sách nếu ô tìm kiếm trống
        $('.product-grid').html('');
    }
});

// Hàm hiển thị thông báo khi không có sản phẩm
function showNoProductsMessage(container) {
    const messageHtml = `
        <div class="no-products-message">
            <style>
                .no-products-message {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    padding: 40px 20px;
                    animation: fadeInUp 0.5s ease-out;
                    height: 100%;
                }
                .no-products-icon {
                    font-size: 60px;
                    color: #ffd700;
                    margin-bottom: 20px;
                    animation: bounce 2s infinite;
                }
                .no-products-text {
                    font-size: 1.5rem;
                    color: #666;
                    margin-bottom: 15px;
                }
                .no-products-subtext {
                    color: #888;
                    font-size: 1rem;
                }
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes bounce {
                    0%, 20%, 50%, 80%, 100% {
                        transform: translateY(0);
                    }
                    40% {
                        transform: translateY(-30px);
                    }
                    60% {
                        transform: translateY(-15px);
                    }
                }
            </style>
            <div class="no-products-icon">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div class="no-products-text">
                Oops! Không tìm thấy sản phẩm nào 🍰
            </div>
            <div class="no-products-subtext">
                Hãy thử tìm kiếm với từ khóa khác!
            </div>
        </div>
    `;

    container.innerHTML = messageHtml;
    container.style.display = 'flex';
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';
    container.style.height = '100%';
}

// Đóng kết quả tìm kiếm khi click ra ngoài
$(document).click(function (e) {
    if (!$(e.target).closest('.search-container').length) {
        $('.search-results').hide();
    }
});
function showNoProductsMessage(container) {
    const messageHtml = `
        <div class="no-products-message">
            <style>
                .no-products-message {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    padding: 40px 20px;
                    animation: fadeInUp 0.5s ease-out;
                    height: 100%; /* Đảm bảo chiều cao chiếm toàn bộ container */
                }
                .no-products-icon {
                    font-size: 60px;
                    color: #ffd700;
                    margin-bottom: 20px;
                    animation: bounce 2s infinite;
                }
                .no-products-text {
                    font-size: 1.5rem;
                    color: #666;
                    margin-bottom: 15px;
                }
                .no-products-subtext {
                    color: #888;
                    font-size: 1rem;
                }
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes bounce {
                    0%, 20%, 50%, 80%, 100% {
                        transform: translateY(0);
                    }
                    40% {
                        transform: translateY(-30px);
                    }
                    60% {
                        transform: translateY(-15px);
                    }
                }
            </style>
            <div class="no-products-icon">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div class="no-products-text">
                Oops! Không tìm thấy sản phẩm nào 🍰
            </div>
            <div class="no-products-subtext">
                Hãy thử tìm kiếm với bộ lọc khác nhé!
            </div>
        </div>
    `;

    container.innerHTML = messageHtml;
    container.style.display = 'flex';
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';
    container.style.height = '100%';
}
});

function confirmLogout() {
    if (confirm('Bạn có chắc chắn muốn đăng xuất không?')) {
        document.getElementById('logout-form').submit();
    }
}
function loadCartItems() {
    $.ajax({
        url: '{{ route("cart.info") }}',
        method: 'GET',
        success: function(response) {
            var existingProducts = $('#existingProducts');
            existingProducts.empty(); // Xóa thông tin giỏ hàng cũ

            if (response.cartItems.length === 0) {
                existingProducts.append('<div class="no-products">Giỏ hàng của bạn trống.</div>');
            } else {
                $.each(response.cartItems, function(index, item) {
                    existingProducts.append(
                        '<div class="existing-product">' +
                            '<span class="existing-product-name">' + item.product.name + '</span>' +
                            '<span class="existing-product-quantity"> x ' + item.quantity + '</span>' +
                            '<span class="existing-product-price">' + number_format(item.total_amount, 0, ',', '.') + 'đ</span>' +
                        '</div>'
                    );
                });
                existingProducts.append(
    '<div class="total-section">' +
        '<span class="total-label">Tổng cộng:</span>' +
        '<span class="total-price">' + number_format(response.totalAmount, 0, ',', '.') + 'đ</span>' +
    '</div>' +
    '<a href="http://localhost/web_ban_banh_kem/public/checkout">' + 
        '<button class="checkout-button">Thanh toán</button>' +
    '</a>'
);

            }
        },
        error: function() {
            alert('Có lỗi xảy ra khi tải giỏ hàng.');
        }
    });
}

// Gọi hàm này sau khi thêm sản phẩm vào giỏ hàng
$('.add-to-cart-btn').click(function(e) {
    // ... Mã AJAX để thêm sản phẩm vào giỏ hàng ...

    // Gọi hàm để tải lại thông tin giỏ hàng
    loadCartItems();
});
function number_format(number, decimals, dec_point, thousands_sep) {
    // Xử lý các tham số mặc định
    decimals = decimals || 0;
    dec_point = dec_point || '.';
    thousands_sep = thousands_sep || ',';

    // Chuyển số thành chuỗi và tách phần nguyên và phần thập phân
    number = parseFloat(number).toFixed(decimals).toString();
    let parts = number.split('.');
    let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep); // Thêm dấu phân cách ngàn

    // Kết hợp phần nguyên và phần thập phân lại
    return parts.length > 1 ? integerPart + dec_point + parts[1] : integerPart;
}
// Lấy phần tử
// Lấy phần tử mic và ô input
const micButton = document.getElementById('mic-button');
const searchInput = document.getElementById('search-input');

// Kiểm tra hỗ trợ Web Speech API
if ('webkitSpeechRecognition' in window) {
    const recognition = new webkitSpeechRecognition();
    recognition.lang = 'vi-VN'; // Ngôn ngữ Tiếng Việt
    recognition.continuous = false; // Không liên tục
    recognition.interimResults = false; // Kết quả cuối cùng

    // Bắt đầu nhận diện khi nhấn nút mic
    micButton.addEventListener('click', () => {
        recognition.start();
    });

    // Khi nhận diện thành công
    recognition.onresult = (event) => {
        const transcript = event.results[0][0].transcript; // Kết quả giọng nói
        searchInput.value = transcript; // Điền văn bản vào ô input
        $(searchInput).trigger('input'); // Kích hoạt sự kiện input
    };

    // Xử lý lỗi
    recognition.onerror = (event) => {
        console.error('Lỗi nhận diện giọng nói:', event.error);
        alert('Không thể nhận diện giọng nói, vui lòng thử lại.');
    };
} else {
    micButton.addEventListener('click', () => {
        alert('Trình duyệt của bạn không hỗ trợ nhận diện giọng nói.');
    });
}

// Xử lý sự kiện input trong ô tìm kiếm
$('.search-input').on('input', function () {
    let query = $(this).val();

    if (query.length > 0) {
        $.ajax({
            url: "{{ route('products.searchmenu') }}",
            method: 'GET',
            data: { query: query },
            success: function (response) {
                let searchResults = $('.search-results');
                searchResults.html(''); // Xóa kết quả trước đó

                if (response.length > 0) {
                    searchResults.show(); // Hiển thị kết quả tìm kiếm

                    response.forEach(function (product) {
                        // Cập nhật lại HTML cho từng sản phẩm trong kết quả tìm kiếm
                        searchResults.append(`
                            <div class="product-card" data-product-id="${product.id}">
                                <a href="http://localhost/web_ban_banh_kem/public/quick_view/${product.id}" class="product-link">
                                    <div class="product-image">
                                        <img src="http://localhost/web_ban_banh_kem/public/images/${product.image}" alt="${product.name}" style="width:100%; height:250px; object-fit:cover;">
                                    </div>
                                    <div class="product-name">${product.name}</div>
                                    <div class="product-price">Giá: ${new Intl.NumberFormat().format(product.price)}đ</div>
                                    <div class="product-status">${product.quantity_in_stock > 0 ? 'Còn hàng' : 'Hết hàng'}</div>
                                </a>
                                <div class="action-buttons">
                                    <div class="quantity-control">
                                        <button class="decrement">-</button>
                                        <input type="number" class="qty" value="1" min="1" max="10">
                                        <button class="increment">+</button>
                                    </div>
                                    <button class="add-to-cart-btn" data-product-id="${product.id}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <button class="remove-from-cart-btn" data-product-id="${product.id}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    // Nếu không có kết quả, hiển thị thông báo không có sản phẩm
                    searchResults.append(`
                        <div class="no-products-message">Không tìm thấy sản phẩm nào!</div>
                    `);
                }

                // Cập nhật lại sản phẩm chính trong grid
                let productGrid = $('.product-grid');
                productGrid.html(''); // Xóa sản phẩm cũ
                response.forEach(function (product) {
                    productGrid.append(`
                        <div class="product-card" data-product-id="${product.id}">
                            <a href="http://localhost/web_ban_banh_kem/public/quick_view/${product.id}" class="product-link">
                                <div class="product-image">
                                    <img src="http://localhost/web_ban_banh_kem/public/images/${product.image}" alt="${product.name}">
                                </div>
                                <div class="product-name">${product.name}</div>
                                <div class="product-price">Giá: ${new Intl.NumberFormat().format(product.price)}đ</div>
                                <div class="product-status">${product.quantity_in_stock > 0 ? 'Còn hàng' : 'Hết hàng'}</div>
                            </a>

                            <div class="action-buttons">
                                <div class="quantity-control">
                                    <button class="decrement">-</button>
                                    <input type="number" class="qty" value="1" min="1" max="10">
                                    <button class="increment">+</button>
                                </div>
                                
                                <button class="add-to-cart-btn" data-product-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="remove-from-cart-btn" data-product-id="${product.id}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `);
                });
            }
        });
    } else {
        // Ẩn kết quả khi không có dữ liệu trong ô tìm kiếm
        $('.search-results').hide();
    }
});

const draggableElement = document.querySelector('.existing-products');
let isDragging = false;
let offsetX, offsetY;

// Khi bắt đầu giữ chuột
draggableElement.addEventListener('mousedown', function (e) {
    isDragging = true;
    offsetX = e.clientX - draggableElement.getBoundingClientRect().left;
    offsetY = e.clientY - draggableElement.getBoundingClientRect().top;

    // Thêm lớp để biểu thị trạng thái kéo
    draggableElement.style.cursor = 'grabbing';
});

// Khi di chuyển chuột
document.addEventListener('mousemove', function (e) {
    if (isDragging) {
        let left = e.clientX - offsetX;
        let top = e.clientY - offsetY;

        // Cập nhật vị trí của phần tử
        draggableElement.style.left = `${left}px`;
        draggableElement.style.top = `${top}px`;
        draggableElement.style.position = 'fixed'; // Luôn hiển thị cố định
    }
});

// Khi thả chuột
document.addEventListener('mouseup', function () {
    if (isDragging) {
        isDragging = false;

        // Đặt lại con trỏ
        draggableElement.style.cursor = 'grab';
    }
});

// Đặt con trỏ thành "grab" mặc định
draggableElement.style.cursor = 'grab';
const aiButton = document.getElementById('ai-button');
    const aiMessage = document.getElementById('ai-message');
    const aiModal = document.getElementById('ai-modal');
    const closeAiModalBtn = document.getElementById('close-ai-modal');

    // Danh sách các câu chào ngẫu nhiên
    const greetingMessages = [
        "Xin chào! Bạn đang điều trị tại khoa nào?",
        "Chào bạn! Hãy cho tôi biết bạn đang ở khoa nào.",
        "Xin chào! Bạn có thể cho tôi biết khoa bạn đang điều trị không?",
        "Chào bạn, bạn đang điều trị tại khoa nào hiện tại?"
    ];

    aiButton.addEventListener('click', () => {
        aiModal.style.display = 'block';
        sayRandomGreeting();
    });

    let currentDepartment = '';
let recognition = null;
let currentProduct = null;
function getRandomVoice() {
    const voices = window.speechSynthesis.getVoices();
    const femaleVoices = voices.filter(voice => voice.name.includes('Vietnamese') && voice.gender === 'female');
    const maleVoices = voices.filter(voice => voice.name.includes('Vietnamese') && voice.gender === 'male');

    // Chọn ngẫu nhiên giọng nam hoặc nữ
    return Math.random() > 0.5 ? femaleVoices[0] : maleVoices[0];
}

// Hàm nói văn bản với giọng ngẫu nhiên
function speakTextWithRandomVoice(text) {
    const speechSynthesis = window.speechSynthesis;
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'vi-VN';
    utterance.voice = getRandomVoice(); // Áp dụng giọng ngẫu nhiên
    speechSynthesis.speak(utterance);
}
closeAiModalBtn.addEventListener('click', () => {
    aiModal.style.display = 'none';
    if (recognition) {
        recognition.stop();
    }
    window.speechSynthesis.cancel();
    aiMessage.innerHTML = "Đã đóng modal.";
});

function startSpeechRecognition(step = 'department') {
    recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'vi-VN';
    recognition.start();

    recognition.onstart = function () {
        console.log(`Speech recognition started for step: ${step}`);
        if (step === 'feedback') {
            aiMessage.innerHTML = 'Đang lắng nghe phản hồi của bạn...';
        } else if (step === 'department') {
            aiMessage.innerHTML = 'Đang lắng nghe khoa bạn điều trị...';
        } else if (step === 'disease') {
            aiMessage.innerHTML = 'Đang lắng nghe vấn đề của bạn...';
        } else {
            aiMessage.innerHTML = 'Đang lắng nghe...';
        }
    };

    recognition.onresult = function (event) {
        const transcript = event.results[0][0].transcript.trim();
        console.log(`Transcript received: ${transcript}`);
        
        if (step === 'department') {
            currentDepartment = transcript;
            aiMessage.innerHTML = `Tôi vừa ghi nhận câu trả lời của bạn là: ${currentDepartment}.`;
            recognition.stop();
            console.log(`Current department: ${currentDepartment}`);
            checkDepartment(currentDepartment);
        } else if (step === 'disease') {
            aiMessage.innerHTML = `Tôi vừa ghi nhận câu trả lời của bạn là: ${transcript}.`;
            recognition.stop();
            console.log(`Disease transcript: ${transcript}`);
            checkDisease(transcript);
        } else if (step === 'feedback') {
            recognition.stop();
            console.log(`Feedback transcript: ${transcript}`);
            handleFeedback(transcript);
        }
    };

    recognition.onerror = function (event) {
        console.error("Speech recognition error:", event.error);
        aiMessage.innerHTML = "Không nhận diện được giọng nói. Vui lòng thử lại.";
        speakTextWithCallback("Không nhận diện được giọng nói. Vui lòng thử lại.");
    };
}

function speakTextWithCallback(text, callback = null) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'vi-VN';
    utterance.voice = getRandomVoice(); // Áp dụng giọng ngẫu nhiên
    
    utterance.onend = function() {
        if (callback) callback();
    };
    
    window.speechSynthesis.speak(utterance);
}
function handleApiResponse(response) {
    if (response.status === 'success' || response.status === 'partial') {
        aiMessage.innerHTML = response.message;
        currentProduct = response.product_id;
        speakTextWithCallback(response.message, () => {
            if (response.ask_feedback) {
                setTimeout(() => startFeedbackCollection(), 1000);
            }
        });
    } else if (response.status === 'error') {
        aiMessage.innerHTML = response.message;
        speakTextWithCallback(response.message);
    }
}

function startFeedbackCollection() {
    recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'vi-VN';
    
    recognition.onstart = function () {
        aiMessage.innerHTML = 'Đang lắng nghe phản hồi của bạn...';
    };

    recognition.onresult = function(event) {
        const feedback = event.results[0][0].transcript.trim().toLowerCase();
        handleFeedback(feedback);
    };

    recognition.onerror = function(event) {
        aiMessage.innerHTML = "Không nhận diện được giọng nói. Vui lòng thử lại.";
        speakTextWithCallback("Không nhận diện được giọng nói. Vui lòng thử lại.", () => {
            setTimeout(startFeedbackCollection, 1000);
        });
    };

    speakTextWithCallback("Bạn có hài lòng với sản phẩm không? Vui lòng nói 'có' hoặc 'không'.", () => {
        setTimeout(() => recognition.start(), 500);
    });
}


function handleFeedback(feedback) {
    recognition.stop();

    if (feedback.includes('không') || feedback.includes('chưa') || feedback.includes('không hài lòng')) {
    const negativeResponse = "Xin lỗi vì sản phẩm chưa phù hợp. Tôi sẽ đề xuất thêm cho bạn vài sản phẩm khác.";
    aiMessage.innerHTML = negativeResponse;
    speakTextWithCallback(negativeResponse, () => {
        suggestAlternativeProducts();
    });
} 
else if (feedback.includes('có') || feedback.includes('hài lòng') || feedback.includes('tốt')) {
    const positiveResponse = "Cảm ơn bạn đã đánh giá. Rất vui được giúp đỡ bạn!";
    aiMessage.innerHTML = positiveResponse;
    speakTextWithCallback(positiveResponse);
}

    else {
        const unclearResponse = "Xin lỗi, tôi không hiểu rõ phản hồi của bạn. Vui lòng nói 'có' hoặc 'không'.";
        aiMessage.innerHTML = unclearResponse;
        speakTextWithCallback(unclearResponse, () => {
            setTimeout(startFeedbackCollection, 1000);
        });
    }
}

function suggestAlternativeProducts() {
    fetch('http://localhost/web_ban_banh_kem/public/get-alternative-products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            current_product_id: currentProduct,
            department: currentDepartment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.products && data.products.length > 0) {
            let suggestions = "Đây là các sản phẩm thay thế phù hợp với bạn:";
            data.products.forEach((product, index) => {
                suggestions += `\n${index + 1}. ${product.name} - Hương vị: ${product.flavor} - Lợi ích: ${product.benefits}. Để mua sản phẩm, bạn hãy nhập vào ô tìm kiếm tên sản phẩm là "${product.name}" hoặc ID sản phẩm là "${product.product_id}".`;
            });
            
            aiMessage.innerHTML = suggestions.replace(/\n/g, '<br>'); // Hiển thị xuống dòng trong HTML
            speakTextWithCallback(suggestions);
        } else {
            const noSuggestionMessage = "Rất tiếc, tôi không tìm thấy sản phẩm thay thế phù hợp.";
            aiMessage.innerHTML = noSuggestionMessage;
            speakTextWithCallback(noSuggestionMessage);
        }
    })
    .catch(error => {
        console.error('Error in suggestAlternativeProducts:', error);
        const errorMessage = "Có lỗi xảy ra khi tìm sản phẩm thay thế.";
        aiMessage.innerHTML = errorMessage;
        speakTextWithCallback(errorMessage);
    });
}


function checkDisease(disease) {
    fetch('http://localhost/web_ban_banh_kem/public/api/check-disease', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            department: currentDepartment,
            disease: disease
        })
    })
    .then(response => response.json())
    .then(data => handleApiResponse(data));
}

// Hàm kiểm tra khoa
function checkDepartment(department) {
    fetch('http://localhost/web_ban_banh_kem/public/check-department', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ department: department }),
    })
    .then(response => response.json())
    .then(data => {
        aiMessage.innerHTML = data.message;
        speakTextWithCallback(data.message, () => {
            if (data.status === 'success') {
                setTimeout(() => startSpeechRecognition('disease'), 1000);
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        aiMessage.innerHTML = "Có lỗi xảy ra khi xử lý yêu cầu.";
        speakTextWithCallback("Có lỗi xảy ra khi xử lý yêu cầu.");
    });
}

// Hàm kiểm tra bệnh
function checkDisease(disease) {
    fetch('http://localhost/web_ban_banh_kem/public/check-disease', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ 
            department: currentDepartment, 
            disease: disease,
            prev_product: currentProduct
        }),
    })
    .then(response => response.json())
    .then(data => {
        aiMessage.innerHTML = data.message;
        if (data.product_id) {
            currentProduct = data.product_id;
        }
        speakTextWithCallback(data.message, () => {
            if (data.ask_feedback) {
                setTimeout(() => startSpeechRecognition('feedback'), 1000);
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        aiMessage.innerHTML = "Có lỗi xảy ra khi xử lý yêu cầu.";
        speakTextWithCallback("Có lỗi xảy ra khi xử lý yêu cầu.");
    });
}


    // Sử dụng Speech Synthesis API để nói văn bản ra
    function speakText(text) {
        const speechSynthesis = window.speechSynthesis;
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'vi-VN';
        speechSynthesis.speak(utterance);
    }

    // Khi mở modal, chọn câu ngẫu nhiên để nói
    function sayRandomGreeting() {
        const randomGreeting = greetingMessages[Math.floor(Math.random() * greetingMessages.length)];
        aiMessage.innerHTML = randomGreeting;
        speakText(randomGreeting);

        // Sau khi câu hỏi đã được nói, bắt đầu ghi giọng nói của người dùng
        setTimeout(() => {
            startSpeechRecognition();
        }, 3000); // Đợi 3 giây để câu hỏi hoàn thành trước khi bắt đầu ghi giọng nói
    }
    let isPlaying = false;

// Hàm gọi API Laravel để lấy thông báo hợp lệ


// Hàm gọi API Laravel để lấy thông báo hợp lệ
function getRandomAnnouncement() {
    fetch('http://localhost/web_ban_banh_kem/public/api/random-announcement') // Đảm bảo URL API là đúng
        .then(response => response.json())
        .then(data => {
            const messages = data.messages; // Nhận đối tượng các thông báo theo cấp độ
            const sortedMessages = sortMessagesByLevel(messages); // Sắp xếp thông báo theo cấp độ
            updateNotificationCount(sortedMessages.length); // Cập nhật số lượng thông báo chưa hết hạn
            if (sortedMessages.length > 0) {
                speak(sortedMessages.join(' ')); // Phát tất cả các thông báo
            } else {
                speak("Hiện tại không có thông báo phát thanh nào từ chúng tôi.");
            }
        })
        .catch(error => console.error('Error fetching announcement:', error));
}

// Hàm sắp xếp thông báo theo cấp độ
function sortMessagesByLevel(messages) {
    // Chuyển đối tượng thành mảng các thông báo kèm cấp độ
    const messageArray = Object.entries(messages).map(([level, message]) => ({ level: parseInt(level), message }));

    // Sắp xếp theo cấp độ giảm dần (cấp độ cao hơn sẽ được ưu tiên phát trước)
    messageArray.sort((a, b) => b.level - a.level);

    // Trả về mảng các thông báo đã sắp xếp
    return messageArray.map(item => item.message);
}

// Cập nhật số lượng thông báo chưa hết hạn
function updateNotificationCount(count) {
    const countElement = document.getElementById('notificationCount');
    if (count > 0) {
        countElement.classList.add('visible'); // Hiển thị số lượng
        countElement.textContent = count; // Cập nhật số lượng
    } else {
        countElement.classList.remove('visible'); // Ẩn số lượng
    }
}

// Hàm phát âm thanh
function speak(message) {
    const speech = new SpeechSynthesisUtterance();
    speech.text = message;
    speech.lang = 'vi-VN'; // Giọng nữ tiếng Việt
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1.2; // Cài đặt giọng nữ
    speechSynthesis.speak(speech);
}

// Hàm để xử lý click vào button
const speechButton = document.getElementById('speechButton');
speechButton.addEventListener('click', () => {
    if (isPlaying) {
        speechSynthesis.cancel();  // Dừng phát nếu đang phát
        isPlaying = false;
        speechButton.style.backgroundColor = '#f1c40f'; // Màu nền mặc định
    } else {
        getRandomAnnouncement(); // Lấy thông báo hợp lệ
        isPlaying = true;
        speechButton.style.backgroundColor = '#e67e22'; // Màu nền khi đang phát
    }
});

// Di chuyển button
speechButton.addEventListener('mousedown', function (e) {
    let offsetX = e.clientX - speechButton.getBoundingClientRect().left;
    let offsetY = e.clientY - speechButton.getBoundingClientRect().top;

    function onMouseMove(e) {
        speechButton.style.left = (e.clientX - offsetX) + 'px';
        speechButton.style.top = (e.clientY - offsetY) + 'px';
    }

    function onMouseUp() {
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
    }

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
});

// Số lượng bông tuyết
const numberOfSnowflakes = 100;

// Lấy phần tử chứa bông tuyết
const snowflakesContainer = document.querySelector('.snowflakes');

// Tạo các bông tuyết ngẫu nhiên
for (let i = 0; i < numberOfSnowflakes; i++) {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.innerHTML = '❄'; // Biểu tượng bông tuyết

    // Đặt vị trí và kích thước ngẫu nhiên cho mỗi bông tuyết
    const size = Math.random() * 10 + 10 + 'px'; // Kích thước từ 10px đến 20px
    const leftPosition = Math.random() * 100 + 'vw'; // Vị trí ngang ngẫu nhiên
    const animationDuration = Math.random() * 5 + 5 + 's'; // Thời gian rơi ngẫu nhiên

    snowflake.style.fontSize = size;
    snowflake.style.left = leftPosition;
    snowflake.style.animationDuration = animationDuration;

    // Thêm bông tuyết vào container
    snowflakesContainer.appendChild(snowflake);
}
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
$(document).on('click', '#checkout-link', function(e) {
    console.log("Redirecting to checkout");
    // Kiểm tra nếu giỏ hàng có sản phẩm
    if (response.totalAmount > 0) {
        // Chuyển hướng đến trang thanh toán
        window.location.href = $(this).attr('href');
    } else {
        e.preventDefault(); // Ngừng hành động mặc định nếu giỏ hàng trống
        alert('Giỏ hàng của bạn đang trống.');
    }
});
document.addEventListener('DOMContentLoaded', function() { 
    const aiButton = document.getElementById('ai-button');
    const speechBubble = document.querySelector('.speech-bubble');
    let animationInterval;

    // Mảng chứa các mẹo về y tế và sức khỏe
    const healthTips = [
        "Uống đủ nước mỗi ngày để duy trì sức khỏe!",
        "Ăn nhiều rau củ quả để có một cơ thể khỏe mạnh.",
        "Hãy ngủ đủ 7-8 giờ mỗi ngày để phục hồi năng lượng.",
        "Tập thể dục ít nhất 30 phút mỗi ngày để giữ cơ thể dẻo dai.",
        "Đừng quên rửa tay thường xuyên để ngừa bệnh tật.",
        "Thực hiện kiểm tra sức khỏe định kỳ để phát hiện bệnh sớm."
    ];

    // Function to get a random health tip
    function getRandomHealthTip() {
        const randomIndex = Math.floor(Math.random() * healthTips.length);
        return healthTips[randomIndex];
    }

    // Function to start the animation sequence
    function startAnimationSequence() {
        aiButton.classList.add('bounce');
        setTimeout(() => {
            speechBubble.textContent = getRandomHealthTip(); // Hiển thị mẹo ngẫu nhiên
            speechBubble.classList.add('show');
        }, 2000); // Mở bong bóng sau 2 giây

        // Remove classes after animation
        setTimeout(() => {
            aiButton.classList.remove('bounce');
            speechBubble.classList.remove('show');
        }, 7000); // Đóng bong bóng sau 7 giây
    }

    // Initial delay before starting animations
    setTimeout(() => {
        // Start the first animation
        startAnimationSequence();

        // Set interval for recurring animations every 10 seconds (tăng thời gian giữa mỗi lần)
        animationInterval = setInterval(startAnimationSequence, 20000); // Repeat every 10 seconds
    }, 3000); // Start after 3 seconds

    // Optional: Stop animations on hover (if you still want this feature)
    aiButton.addEventListener('mouseenter', () => {
        clearInterval(animationInterval);
        aiButton.classList.remove('bounce');
        speechBubble.textContent = getRandomHealthTip(); // Hiển thị mẹo ngẫu nhiên ngay khi hover
        speechBubble.classList.add('show');
    });

    aiButton.addEventListener('mouseleave', () => {
        speechBubble.classList.remove('show');
        // Restart the interval after leaving hover
        animationInterval = setInterval(startAnimationSequence, 10000); // Lúc hover, thời gian sẽ dài hơn
    });
});

document.getElementById('apply-filter').addEventListener('click', function() {
    var category = document.getElementById('category-filter').value;
    var department = document.getElementById('department-filter').value;

    // Gửi yêu cầu AJAX
    fetch("{{ route('apply.filters') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: category,
            department: department
        })
    })
    .then(response => response.json())
    .then(data => {
        // Kiểm tra xem có sản phẩm không
        if (data.products.length > 0) {
            // Xây dựng HTML cho sản phẩm
            let productHtml = '';
            data.products.forEach(product => {
                productHtml += `
                    <div class="product-card" data-product-id="${product.id}" data-detail-id="${product.cartDetail?.id ?? ''}">
                        <a href="{{ url('quick_view') }}/${product.id}" class="product-link">
                            <div class="product-image">
                                <img src="{{ asset('images') }}/${product.image}" alt="${product.name}" style="width:100%; height:250px; object-fit:cover;">
                            </div>
                            <div class="product-name">${product.name}</div>
                            <div class="product-price">Giá: ${new Intl.NumberFormat('vi-VN').format(product.price)}đ</div>
                            <div class="product-status">${product.quantity_in_stock > 0 ? 'Còn hàng' : 'Hết hàng'}</div>
                        </a>
                        <div class="action-buttons">
                            <div class="quantity-control">
                                <button class="decrement">-</button>
                                <input type="number" class="qty" value="1" min="1" max="10">
                                <button class="increment">+</button>
                            </div>
                            <button class="add-to-cart-btn" data-product-id="${product.id}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button class="remove-from-cart-btn" data-product-id="${product.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            });

            // Cập nhật lại nội dung sản phẩm
            document.getElementById('product-grid').innerHTML = productHtml;
        } else {
            showNoProductsMessage(document.querySelector('.product-grid'));
        }
    })
    .catch(error => console.log('Error:', error));
});
function showNoProductsMessage(container) {
    const messageHtml = `
        <div class="no-products-message">
            <style>
                .no-products-message {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    padding: 40px 20px;
                    animation: fadeInUp 0.5s ease-out;
                    height: 100%; /* Đảm bảo chiều cao chiếm toàn bộ container */
                }
                .no-products-icon {
                    font-size: 60px;
                    color: #ffd700;
                    margin-bottom: 20px;
                    animation: bounce 2s infinite;
                }
                .no-products-text {
                    font-size: 1.5rem;
                    color: #666;
                    margin-bottom: 15px;
                }
                .no-products-subtext {
                    color: #888;
                    font-size: 1rem;
                }
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes bounce {
                    0%, 20%, 50%, 80%, 100% {
                        transform: translateY(0);
                    }
                    40% {
                        transform: translateY(-30px);
                    }
                    60% {
                        transform: translateY(-15px);
                    }
                }
            </style>
            <div class="no-products-icon">
                <i class="fas fa-cookie-bite"></i>
            </div>
            <div class="no-products-text">
                Oops! Không tìm thấy sản phẩm nào 🍰
            </div>
            <div class="no-products-subtext">
                Hãy thử tìm kiếm với bộ lọc khác nhé!
            </div>
        </div>
    `;

    container.innerHTML = messageHtml;
    container.style.display = 'flex'; // Thêm CSS để căn giữa
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';
    container.style.height = '100%'; // Đảm bảo chiều cao container đầy đủ
}


</script>



</body>
</html>
