<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard</title>
    <style>
        a {
    text-decoration: none; /* Bỏ gạch chân mặc định của thẻ <a> */
    color: inherit; /* Kế thừa màu sắc từ phần tử cha */
}

a:hover {
    color: inherit; /* Giữ màu sắc khi hover */
}
.stat-title {
    .button-container {
    display: flex;
    gap: 10px;
}

.TheDaNangbtn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.TheDaNangbtn:hover {
    background-color: #45a049;
}

    font-size: 1.5em;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 2em;
    margin-bottom: 10px;
}

.tooltip {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    font-size: 1em;
    z-index: 10;
}

.stat-card:hover .tooltip {
    display: block;
}

.dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-right: 10px;
    border-radius: 50%;
}

.blue { background-color: #007bff; }
.green { background-color: #28a745; }
.orange { background-color: #fd7e14; }
.red { background-color: #dc3545; }
.yellow { background-color: #ffc107; }
.pink { background-color: #e83e8c; }
.gray { background-color: #6c757d; }
.LightCyan3 { background-color: #7FDBFF; }
 .toggle-button {
    position: fixed;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    z-index: 10;
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 0 4px 4px 0;
    font-size: 16px;
    opacity: 0.3; /* Mờ khi không tương tác */
    transition: opacity 0.3s ease, background-color 0.3s ease;
}

.toggle-button:hover,
.toggle-button:focus {
    opacity: 1; /* Hiện rõ khi di chuột hoặc nhấn */
    background-color: #1d6fa5; /* Thay đổi màu sắc khi tương tác */
}
.sidebar.hidden {
    transform: translateX(-250px);
}
.main-content.full-width {
    margin-left: 0;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #3498db;
        }

        body {
            display: flex;
            background-color: #f5f6fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            color: white;
            padding: 20px;
        }

        .sidebar .logo {
            padding: 10px;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
        }

        .header {
            height: var(--header-height);
            background-color: white;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 20px;
}

.page-title h2 {
    margin: 0;
}

.user-info {
    color: #666;
    font-size: 14px;
}
    
.main-content {
    padding: 20px;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}
.toolbar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.toolbar-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    color: #333;
}

.toolbar-btn:hover {
    background: #f0f0f0;
}

.toolbar-btn i {
    font-size: 16px;
}

/* Style cho search box cải tiến */
.search-container {
    position: relative;
    width: 300px;
}

.search-box {
    width: 100%;
    padding: 8px 35px 8px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

/* Style cho dropdown menu */
.action-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    min-width: 160px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 4px;
}

.dropdown-content a {
    color: #333;
    padding: 8px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f5f5f5;
}

.show {
    display: block;
}

.dropdown-btn {
    display: flex;
    align-items: center;
    gap: 5px;
}
.main-content {
    padding: 20px;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}

/* Header styles */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 20px;
}

.page-title h2 {
    margin: 0;
}

.user-info {
    color: #666;
    font-size: 14px;
}

/* Controls row styles */
.controls-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    background: white;
    padding: 10px;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.left-controls {
    display: flex;
    align-items: center;
    gap: 20px;
}

.display-options {
    display: flex;
    align-items: center;
    gap: 10px;
}

.display-options select {
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 70px;
}

.search-container {
    position: relative;
}

.search-box {
    width: 250px;
    padding: 6px 35px 6px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

/* Toolbar styles */
.toolbar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.toolbar-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    color: #333;
}

.toolbar-btn:hover {
    background: #f0f0f0;
}  
.controls-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.left-controls, .right-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.display-options label,
.search-container input,
.sort-options label,
.category-filter label {
    font-size: 14px;
    font-weight: bold;
    color: #495057;
}

.display-options select,
.search-box,
.sort-options select,
.category-filter select {
    padding: 5px 10px;
    font-size: 14px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.display-options select:hover,
.search-box:focus,
.sort-options select:hover,
.category-filter select:hover {
    border-color: #007bff;
}

.search-container {
    display: flex;
    align-items: center;
    position: relative;
}

.search-box {
    width: 250px;
    padding: 5px 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    outline: none;
}
.unread-dot {
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
    position: absolute;
    top: 5px;
    right: 5px;
    display: none; /* Ẩn mặc định */
}

.search-icon {
    position: absolute;
    right: 10px;
    color: #6c757d;
    cursor: pointer;
}

.sort-options select,
.category-filter select {
    width: 180px;
}
.data-table {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
        }
        table {
    width: 100%;
    border-collapse: collapse; /* Đảm bảo đường viền không bị chồng chéo */
    text-align: left;
    margin-top: 10px;
}

thead tr {
    background-color: #f2f2f2; /* Màu nền cho tiêu đề */
}

thead th, tbody td {
    border: 1px solid #ddd; /* Đường viền giữa các ô */
    padding: 8px; /* Khoảng cách giữa nội dung và viền ô */
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9; /* Màu nền xen kẽ */
}

tbody tr:hover {
    background-color: #f1f1f1; /* Màu nền khi hover vào hàng */
}

.image-cell img {
    display: block;
    max-width: 50px;
    max-height: 50px;
    border-radius: 50%; /* Làm tròn ảnh đại diện */
    object-fit: cover;
}

th {
    font-weight: bold;
    border: 1px solid #ddd;
    text-align: center;
    padding: 10px;
}

td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center; /* Canh giữa nội dung */
}
.action-select {
    width: 100%;
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    appearance: none; /* Loại bỏ giao diện mặc định */
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray"><path fill-rule="evenodd" d="M10 3a1 1 0 01.894.553l5 10a1 1 0 01-.894 1.447H5a1 1 0 01-.894-1.447l5-10A1 1 0 0110 3zm0 2.236L6.618 12h6.764L10 5.236z" clip-rule="evenodd" /></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 14px;
    cursor: pointer;
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.action-select:focus {
    border-color: #4caf50;
    box-shadow: 0 0 4px rgba(76, 175, 80, 0.6);
}

.action-select option {
    padding: 8px;
    font-size: 14px;
}

.action-select option[value="chat"] {
    background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/svgs/solid/comment-dots.svg') no-repeat left center;
    padding-left: 30px;
}

.action-select option[value="edit"] {
    background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/svgs/solid/edit.svg') no-repeat left center;
    padding-left: 30px;
}

.action-select option[value="delete"] {
    background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/svgs/solid/trash-alt.svg') no-repeat left center;
    padding-left: 30px;
}

.action-select option[value="view"] {
    background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/svgs/solid/eye.svg') no-repeat left center;
    padding-left: 30px;
}
/* Container của nút và dropdown */
.export-container {
    position: relative;
    display: inline-block;
}

/* Dropdown ẩn mặc định */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%; /* Hiển thị ngay dưới nút */
    left: 0;
    background-color: white;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    width: 200px;
}

/* Nút bên trong dropdown */
.dropdown-menu .btn {
    display: block;
    width: 100%;
    margin: 5px 0;
    padding: 10px;
    text-align: center;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

.dropdown-menu .btn:hover {
    background-color: #218838;
}

/* Dropdown mở */
.export-container .dropdown-menu.show {
    display: block;
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: #ffffff; /* Màu nền trắng */
    border: 1px solid #ddd; /* Đường viền mờ nhạt */
    border-radius: 8px; /* Bo góc drop-down */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hiệu ứng bóng */
    z-index: 10;
    min-width: 320px;
    padding: 15px;
}

/* Label cho từng mục */
.dropdown-content label {
    font-weight: bold;
    font-size: 14px;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

/* Input nhập mã thẻ */
.dropdown-content input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    color: #555;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    transition: border-color 0.3s ease;
}

.dropdown-content input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
}

/* Input tải ảnh QR */
.dropdown-content input[type="file"] {
    display: block;
    font-size: 14px;
    color: #555;
    margin-top: 8px;
    cursor: pointer;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.dropdown-content input[type="file"]:hover {
    background-color: #f1f1f1;
    border-color: #007bff;
}

/* Hiệu ứng hover trên drop-down */
.dropdown-content input:hover {
    border-color: #007bff;
}

/* Thu gọn phần tử của drop-down để không bị sát nhau */
.dropdown-content > * {
    margin-bottom: 10px;
}

.dropdown-content > *:last-child {
    margin-bottom: 0;
}
/* Hiệu ứng xuất hiện drop-down */
.dropdown-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

/* Modal Content */
.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
}

/* User Info */
.user-info, .card-info {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 10px;
    margin-bottom: 20px;
}

/* Modal Header */
h2, h3 {
    text-align: center;
    color: #333;
}

/* Close Modal Button */
.close-btn {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 10px 15px;
    text-align: center;
    cursor: pointer;
    margin-top: 20px;
    display: block;
    width: 100%;
    border-radius: 5px;
}
.modal-content {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-content h2 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .info-column {
            flex: 1;
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .info-column h3 {
            color: #007bff;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .info-column div {
            margin-bottom: 8px;
            color: #555;
        }

        .info-column strong {
            color: #333;
            margin-right: 5px;
        }
        .user-avatar {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-bottom: 15px;
}
/* Dropdown container for user */
.user-dropdown {
    position: relative;
    display: inline-block;
}

/* Main button */




/* Dropdown menu */
.user-dropdown-menu {
    display: none;
    position: absolute;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    padding: 10px;
    z-index: 1000;
    min-width: 200px;
    top: 100%; /* Hiển thị ngay dưới nút */
    left: 0;
}

/* Dropdown item */
.user-dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    gap: 8px;
    cursor: pointer;
    color: #333;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
    font-size: 14px;
}

.user-dropdown-menu .dropdown-item:hover {
    background-color: #f0f0f0;
}

/* File upload style */
.upload-file-input {
    display: none;
}
/* Modal Container */
.addUser-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.addUser-modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 70%;
    max-width: 800px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.addUser-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 10px;
}

.addUser-modal-body {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 20px 0;
}

.addUser-form-group {
    display: flex;
    flex-direction: column;
}

.addUser-form-group label {
    margin-bottom: 5px;
    font-weight: bold;
}

.addUser-form-group input,
.addUser-form-group select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.addUser-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    border-top: 1px solid #e0e0e0;
    padding-top: 15px;
}

.addUser-btn-save {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.addUser-btn-cancel {
    background-color: #f44336;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}
.addUser-avatar-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 10px;
    text-align: center;
}

#addUser-avatar-img {
    max-width: 150px;
    max-height: 150px;
    object-fit: cover;
    margin-top: 10px;
}

#addUser-avatar-placeholder {
    color: #888;
    font-size: 14px;
}
/* Modal styles */
.addUser-modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.addUser-modal-content {
    background: #fff;
    width: 600px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.3s;
}

/* Header styles */
.addUser-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.addUser-modal-header h2 {
    margin: 0;
    font-size: 20px;
}

/* Form groups */
.addUser-form-group {
    margin-bottom: 15px;
}

.addUser-form-group label {
    font-size: 14px;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.addUser-form-group input,
.addUser-form-group select {
    width: 100%;
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.addUser-form-group input:focus {
    border-color: #007bff;
    outline: none;
}

/* Password eye toggle */
.password-toggle {
    position: relative;
}

.password-toggle i {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}

/* Error message styles */
.error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}

/* Buttons */
.addUser-btn-save {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.addUser-btn-cancel {
    background-color: #dc3545;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.addUser-btn-save:hover,
.addUser-btn-cancel:hover {
    opacity: 0.9;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
/* Phong cách chú thích */
.excel-note {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
    display: block;
    max-width: 500px;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 600px;
    z-index: 1000;
}

.modal-content {
    padding: 20px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
}

.modal-header h2 {
    margin: 0;
    font-size: 20px;
}

.modal-body {
    margin-top: 20px;
    overflow-y: auto;
    max-height: 300px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-cancel, .btn-save {
    padding: 10px 15px;
    margin-left: 10px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.btn-cancel {
    background-color: #f5f5f5;
    color: #333;
}

.btn-save {
    background-color: #4caf50;
    color: #fff;
}
/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 90%; /* Mở rộng chiều rộng modal */
    max-width: 1200px; /* Đảm bảo không quá rộng */
    z-index: 1000;
}

.modal-content {
    padding: 20px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
}

.modal-header h2 {
    margin: 0;
    font-size: 20px;
}

.modal-body {
    margin-top: 20px;
    overflow-x: auto; /* Để xử lý trường hợp dữ liệu dài */
    overflow-y: auto;
    max-height: 500px; /* Giới hạn chiều cao để tránh chiếm quá nhiều màn hình */
}

/* Bảng hiển thị nội dung Excel */
.excel-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Đảm bảo cột có kích thước cố định */
}

.excel-table th,
.excel-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Hiển thị dấu "..." nếu nội dung vượt quá giới hạn */
    max-width: 100px; /* Đảm bảo nội dung trong mỗi cột không quá dài */
}

.excel-table th {
    background-color: #f5f5f5;
    font-weight: bold;
}

.excel-table td {
    max-width: 10ch; /* Giới hạn mỗi ô hiển thị tối đa 10 ký tự */
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-cancel, .btn-save {
    padding: 10px 15px;
    margin-left: 10px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.btn-cancel {
    background-color: #f5f5f5;
    color: #333;
}

.btn-save {
    background-color: #4caf50;
    color: #fff;
}
/* Định dạng hàng lỗi */
.invalid-row {
    background-color: #f8d7da; /* Màu đỏ nhạt */
    color: #721c24;
}

.row-checkbox:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.userStatisticsModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 1200px;
            max-height: 80%;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .closestatic-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .filterstatic-section {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .filterstatic-item {
            display: flex;
            flex-direction: column;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .chart-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .top-spenders {
            margin-top: 20px;
        }

        .top-spender-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .filterstatic-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f4f4f4;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .filterstatic-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filterstatic-item label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .filterstatic-item input[type="date"] {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .filterstatic-item input[type="date"]:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
    }

    .filterstatic-item button {
        padding: 10px 20px;
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 22px;
    }

    .filterstatic-item button:hover {
        background-color: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .filterstatic-item button:active {
        transform: translateY(0);
        box-shadow: 0 2px 3px rgba(0,0,0,0.1);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .filterstatic-section {
            flex-direction: column;
            gap: 15px;
        }

        .filterstatic-item {
            width: 100%;
        }

        .filterstatic-item button {
            width: 100%;
            margin-top: 0;
        }
    }
    .filterstatic-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            gap: 15px;
        }

        .filterstatic-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .filterstatic-item label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .filterstatic-item select,
        .filterstatic-item input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .filterstatic-item select:focus,
        .filterstatic-item input[type="date"]:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
        }

        .filterstatic-item button {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 22px;
        }

        .date-inputs {
            display: flex;
            gap: 10px;
        }

        .date-inputs input {
            flex-grow: 1;
        }

        #dateRangeSelect {
            width: 100%;
        }

        .custom-date-section {
            display: none;
        }

        .custom-date-section.active {
            display: flex;
            gap: 10px;
        }
        .filterstatic-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            gap: 15px;
        }

        .filterstatic-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .filterstatic-item label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .filterstatic-item select,
        .filterstatic-item input[type="date"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .filterstatic-item select:focus,
        .filterstatic-item input[type="date"]:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
        }

        .filterstatic-item button {
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 22px;
        }

        .date-inputs {
            display: flex;
            gap: 10px;
        }

        .date-inputs input {
            flex-grow: 1;
        }

        #dateRangeSelect {
            width: 100%;
        }

        .custom-date-section {
            display: none;
        }

        .custom-date-section.active {
            display: flex;
            gap: 10px;
        }
        .chat-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .chat-container {
            width: 90%;
            max-width: 1200px;
            height: 90vh;
            background-color: white;
            border-radius: 10px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .user-list {
            width: 30%;
            border-right: 1px solid #e0e0e0;
            background-color: #f9f9f9;
        }
        .search-box {
            padding: 10px;
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
        }
        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        .user-list-content {
            height: calc(90vh - 100px);
            overflow-y: auto;
        }
        .user-item {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .user-item:hover {
            background-color: #f0f0f0;
        }
        .user-item img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .chat-content {
            width: 70%;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
        }
        .chat-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .messages-container {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f0f2f5;
        }
        .message {
            max-width: 70%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            clear: both;
        }
        .message.sent {
            background-color: #0084ff;
            color: white;
            float: right;
            margin-left: 30%;
        }
        .message.received {
            background-color: #e5e5ea;
            color: black;
            float: left;
            margin-right: 30%;
        }
        .chat-input {
            display: flex;
            padding: 10px;
            background-color: white;
            border-top: 1px solid #e0e0e0;
        }
        .chat-input input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 10px;
        }
        .chat-input button {
            background-color: #0084ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }
        .closeChat-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }
        .user-item {
    position: relative;
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

        .user-item .notification-dot {
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
    position: absolute;
    top: 10px;
    right: 10px;
}
.user-item.selected {
    background-color: #007bff; /* Màu xanh đậm cho user được chọn */
    color: white; /* Chữ màu trắng để dễ đọc */
    border: 2px solid #0056b3; /* Đường viền đậm */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hiệu ứng đổ bóng */
    font-weight: bold; /* Làm chữ đậm hơn */
    transform: scale(1.02); /* Phóng to nhẹ khi được chọn */
}
.unread-dot {
    width: 10px; /* Kích thước dot */
    height: 10px;
    background-color: red;
    border-radius: 50%; /* Làm tròn dot */
    position: absolute; /* Định vị tương đối so với button */
    top: 5px; /* Cách mép trên của button */
    right: 5px; /* Cách mép phải của button */
    display: none; /* Ẩn dot mặc định */
    z-index: 1; /* Hiển thị trên cùng */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Hiệu ứng nổi */
}
.notificationModal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .notificationModal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .notificationModal-body {
            display: flex;
            gap: 20px;
        }

        .notificationModal-section {
            flex: 1;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        .notificationModal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding: 15px;
            background-color: #f4f4f4;
            border-radius: 0 0 10px 10px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .quick-select-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .selected-users-list {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .selected-user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
            background-color: #f1f1f1;
            margin-bottom: 5px;
            border-radius: 3px;
        }

        .notificationUser-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .notificationUser-list-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }

        .notificationUser-list-item:hover {
            background-color: #f5f5f5;
        }

        .notificationClose-btn {
            color: #ff4d4d;
            cursor: pointer;
        }

        .no-users {
            text-align: center;
            color: #888;
            padding: 20px;
        }
        
        .notification-type {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .notification-type label {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .editProduct-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .editProduct-modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 70%;
            max-width: 1000px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .editProduct-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .editProduct-modal-body {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            padding: 20px 0;
        }

        .editProduct-form-group {
            display: flex;
            flex-direction: column;
        }

        .editProduct-form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .editProduct-form-group input, 
        .editProduct-form-group select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .editProduct-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        .editProduct-btn-save {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .editProduct-btn-cancel {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Các trường bị khóa */
        .editProduct-form-group.locked input {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
        .editProduct-modal-body {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .editProduct-form-column {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

        .editProduct-image-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
        }

        .editProduct-image-preview {
            max-width: 250px;
            max-height: 250px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .editProduct-image-placeholder {
            width: 200px;
            height: 200px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .editProduct-image-input {
            display: none;
        }

        .editProduct-image-label {
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
        }
        /* Popup Đổi Mật Khẩu */
/* Chế độ nền mờ cho popup */
.editPassword-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Nền tối mờ */
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease-in-out;
}

/* Hiệu ứng hiển thị modal */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Nội dung popup */
.editPassword-modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    transform: translateY(-50px);
    animation: slideUp 0.5s ease-out;
}

/* Hiệu ứng slide lên */
@keyframes slideUp {
    from {
        transform: translateY(50px);
    }
    to {
        transform: translateY(0);
    }
}

/* Header của popup */
.editPassword-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.editPassword-modal-header h2 {
    font-size: 1.5rem;
    color: #333;
    margin: 0;
}

.editPassword-modal-header button {
    background-color: transparent;
    border: none;
    font-size: 1.5rem;
    color: #888;
    cursor: pointer;
}

.editPassword-modal-header button:hover {
    color: #f00;
}

/* Nhóm input mật khẩu */
.editPassword-form-group {
    position: relative;
    margin-bottom: 20px;
}

.editPassword-form-group label {
    font-size: 1rem;
    color: #555;
    margin-bottom: 5px;
    display: block;
}

.editPassword-form-group input {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    outline: none;
    transition: border-color 0.3s ease;
}

.editPassword-form-group input:focus {
    border-color: #007bff;
    background-color: #fff;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    cursor: pointer;
    color: #007bff;
}

.toggle-password:hover {
    color: #0056b3;
}

/* Nút Lưu Thay Đổi */
.editPassword-modal-body button {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.editPassword-modal-body button:hover {
    background-color: #0056b3;
}
/* Kiểu cho modal */
.pin-modal {
    position: fixed; /* Chắc chắn rằng modal được cố định */
    top: 50%; /* Căn giữa theo chiều dọc */
    left: 50%; /* Căn giữa theo chiều ngang */
    transform: translate(-50%, -50%); /* Đẩy modal về giữa */
    width: 300px; /* Độ rộng của modal */
    background-color: rgba(0, 0, 0, 0.7); /* Màu nền mờ cho vùng xung quanh modal */
    display: none; /* Modal ẩn khi chưa được mở */
    justify-content: center; /* Căn giữa nội dung modal */
    align-items: center; /* Căn giữa nội dung modal */
    z-index: 1000; /* Đảm bảo modal nổi bật hơn các phần tử khác */
}

/* Nội dung modal */
.pin-modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
}

/* Các hành động trong modal */
.pin-modal-actions {
    margin-top: 20px;
}

/* Trường nhập mã PIN */
.pin-modal input {
    width: 80%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

/* Các nút trong modal */
.pin-modal button {
    padding: 10px 20px;
    margin: 5px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Hiệu ứng hover cho các nút */
.pin-modal button:hover {
    background-color: #45a049;
}

.money-modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    width: 300px;
    text-align: center;
}

.money-modal h3 {
    margin-bottom: 20px;
}

.money-modal input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.money-modal .amount-buttons {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.money-modal .amount-buttons button {
    padding: 10px;
    width: 70px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.money-modal button.submit-btn {
    padding: 10px;
    width: 100%;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.TheDaNangbtn {
    background-color: #007bff; /* Màu xanh lam chủ đạo */
    color: #ffffff; /* Màu chữ trắng */
    border: none; /* Bỏ viền nút */
    border-radius: 5px; /* Góc bo tròn */
    padding: 10px 20px; /* Khoảng cách nội dung nút */
    font-size: 16px; /* Kích thước chữ */
    font-weight: bold; /* Chữ đậm */
    cursor: pointer; /* Con trỏ hiển thị "pointer" */
    transition: all 0.3s ease; /* Hiệu ứng chuyển đổi */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
    margin: 5px; /* Khoảng cách giữa các nút */
}

.TheDaNangbtn:hover {
    background-color: #0056b3; /* Màu xanh lam đậm khi hover */
    transform: translateY(-2px); /* Hiệu ứng nhấc lên */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); /* Tăng đổ bóng khi hover */
}

.TheDaNangbtn:active {
    background-color: #004085; /* Màu xanh tối khi bấm */
    transform: translateY(0); /* Trả lại trạng thái */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Giảm đổ bóng khi bấm */
}

/* Responsive Design */
@media (max-width: 768px) {
    .TheDaNangbtn {
        font-size: 14px; /* Giảm kích thước chữ trên màn hình nhỏ */
        padding: 8px 16px; /* Giảm padding */
    }
}
.main-content.full-width {
    margin-left: 0;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #3498db;
        }

        body {
            display: flex;
            background-color: #f5f6fa;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #2c3e50;
            height: 100vh;
            position: fixed;
            color: white;
            padding: 20px;
            padding: 10px;
    display: flex;
    flex-direction: column;
   
   
        }
        

        .menu-item {
    margin: 10px 0;
    cursor: pointer;
    padding: 10px;
   /* Màu nền menu chính */
    border-radius: 4px;
    position: relative;
}

.menu-item:hover {
    background-color: #505050; /* Màu khi hover */
}
        .sidebar .logo {
            padding: 10px;
            font-size: 18px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar .menu-item {
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }.submenu {
    position: absolute;
    top: 0;
    left: 100%; /* Hiển thị bên phải của sidebar */
    background-color: #ffffff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
    display: none; /* Ẩn submenu mặc định */
    z-index: 10;
    width: 200px; /* Độ rộng của submenu */
    padding: 10px 0;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    white-space: nowrap; /* Giữ nội dung không xuống dòng */
}

.submenu-item:hover {
    background-color: #f4f4f4;
}

.trash-button {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 18px;
    cursor: pointer;
    color: #d9534f;
}
.submenu {
    display: none; /* Ẩn submenu mặc định */
    background-color: #1f1f1f; /* Màu tối cho submenu */
    margin-top: 5px;
    padding: 5px 0;
    border-radius: 4px;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover menu chính */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    color: #ffffff;
    white-space: nowrap; /* Không xuống dòng */
}

.submenu-item:hover {
    background-color: #505050; /* Màu nền khi hover submenu */
}

.submenu {
    position: absolute; /* Hiển thị submenu trên các phần tử khác */
   
    left: 0;
    background-color: #444; /* Nền tối */
    color: #fff;
    padding: 10px 0;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Đổ bóng để tạo chiều sâu */
    z-index: 9999; /* Rất cao để đảm bảo luôn trên các phần tử khác */
    display: none; /* Mặc định ẩn */
}

/* Hiển thị submenu khi hover */
.submenu-item:hover .submenu {
    display: block; /* Hiển thị submenu */
}

/* Submenu Item con */
.submenu .submenu-item {
    padding: 10px 15px;
    background-color: transparent;
    color: #fff;
    white-space: nowrap;
    cursor: pointer;
    z-index: 10000; /* Cao hơn để tránh bị che */
}

/* Hover trên submenu con */
.submenu .submenu-item:hover {
    background-color: #505050; /* Đổi màu khi hover submenu con */
}
/* Modal Container */
.userhistory-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.userhistory-modal.hidden {
    display: none;
}

/* Modal Content */
.userhistory-modal-content {
    background: white;
    width: 50%;
    max-height: 80%;
    overflow-y: auto;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    padding: 20px;
    position: relative;
}

/* Modal Header */
.userhistory-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.userhistory-modal-header h3 {
    margin: 0;
}

.closehistory-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

/* Filters */
.userhistory-modal-filters {
    margin: 20px 0;
    display: flex;
    gap: 10px;
}

/* History Items */
.userhistory-item {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

    </style>
</head>
<body>
<button id="toggle-menu" class="toggle-button">☰</button>
<div class="sidebar">
<a href="http://localhost/web_ban_banh_kem/public/" >

    <div class="logo">Luân Hospital</div>
   </a>
   <a href="http://localhost/web_ban_banh_kem/public/admin/dashboard">
    <div class="menu-item">
        <i class="fas fa-home"></i> Trang Chủ
    </div>
</a>

    <div class="menu-item">
        📝 Quản lý sản phẩm
        <span class="arrow">></span>
        <div class="submenu">
        <a href="http://localhost/web_ban_banh_kem/public/admin_product" ><div class="submenu-item">📦 Quản lý sản phẩm</div></a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/category"><div class="submenu-item">📂 Quản lý danh mục</div></a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/ingredient">
  <div class="submenu-item">
    <i class="fas fa-blender"></i> Quản lý nguyên liệu 
  </div>
</a>
        </div>
    </div>
    <a href="http://localhost/web_ban_banh_kem/public/admin/order">
    <div class="menu-item">
        📦 Quản lý đơn hàng
    </div>
    </a>
    <a href="http://localhost/web_ban_banh_kem/public/admin/finance">
    <div class="menu-item">
        💰 Quản lý tài chính
    </div>
</a>

    <div class="menu-item">
        👤 Quản lý người dùng
        <span class="arrow">></span>
        <div class="submenu">
            <a href="http://localhost/web_ban_banh_kem/public/admin/user">
                <div class="submenu-item">👥 Quản lý user</div>
            </a>
            <a href="http://localhost/web_ban_banh_kem/public/admin/staff">
            <div class="submenu-item">🧑‍💼 Quản lý nhân viên</div>
            </a>
        </div>
    </div>
    
    <div class="menu-item">
        📋 Quản lý kiểm duyệt
        <span class="arrow">></span>
        <div class="submenu">
        <a href="http://localhost/web_ban_banh_kem/public/admin/post">
            <div class="submenu-item">📝 Quản lý bài viết</div>
        </a>
        <a href="http://localhost/web_ban_banh_kem/public/admin/report">
            <div class="submenu-item">🚩 Quản lý báo cáo</div>
            </a>
        </div>
    </div>
    <a href="http://localhost/web_ban_banh_kem/public/admin/discount">
    <div class="menu-item">🎁 Quản lý khuyến mãi</div>
    </a>
    <a href="http://localhost/web_ban_banh_kem/public/admin/datban">
    <div class="menu-item">🍽️ Quản lý đặt bàn</div>
    </a>
    
    <!-- Nút thùng rác ở góc dưới cùng -->
    <a href="http://localhost/web_ban_banh_kem/public/admin/restore">
    <!-- Nút thùng rác ở góc dưới cùng -->
    <div class="trash-button">
        🗑️
    </div>
    </a>
</div>

    <div class="main-content">
    <div class="page-header">
    <div class="page-title">
    <h2>Quản Lý Người Dùng</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>
    <div class="toolbar">
    <div class="export-container">
    <button class="toolbar-btn excel-export-btn">
        <i class="fas fa-file-excel"></i> Xuất Excel
    </button>

    <!-- Modal nhỏ -->
    <div id="exportDropdown" class="dropdown-menu">
        <p>Chọn dữ liệu cần xuất:</p>
        <button id="exportAllBtn" class="btn">In tất cả</button>
        <button id="exportSelectedBtn" class="btn">In đã chọn</button>
    </div>
</div>
    <div class="excel-options" style="display: none;">
        <button id="exportAll">In tất cả</button>
        <button id="exportSelected">In đã chọn</button>
    </div>
   <!-- Nút Tra cứu thông tin -->
   <div class="dropdown-container" style="position: relative; display: inline-block;">
    <button class="toolbar-btn look-up-btn">
    <i class="fas fa-credit-card"></i>
    Tra cứu thẻ
    </button>

    <!-- Drop-down hiển thị khi bấm -->
    <div id="dropdownContent" class="dropdown-content" style="display: none; position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); padding: 10px; border-radius: 5px; z-index: 10; min-width: 300px;">
        <label for="cardCode" style="font-weight: bold; display: block; margin-bottom: 8px;">Nhập mã thẻ đa năng:</label>
        <input type="text" id="cardCode" placeholder="Nhập mã thẻ..." style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="qrUpload" style="font-weight: bold; display: block; margin-bottom: 8px;">Hoặc tải mã QR thẻ tại đây:</label>
        <input type="file" id="qrUpload" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">

        <!-- Nút tra cứu -->
        <button  id="lookupBtn" style="width: 100%; padding: 10px; background: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Tra cứu
        </button>
    </div>
</div>



<div class="dropdown user-dropdown">
    <button class="toolbar-btn addUserBtn">
        <i class="fas fa-users"></i> Thêm người dùng
    </button>
    <div class="dropdown-menu user-dropdown-menu">
        <button class="dropdown-item add-single-user">
            <i class="fas fa-user-plus"></i> Thêm một người dùng
        </button>
        <label class="dropdown-item upload-multiple-users">
    <i class="fas fa-file-upload"></i> Thêm nhiều người dùng
    <input type="file" accept=".xls, .xlsx" class="upload-file-input" hidden onchange="handleUploadExcel(event)">
</label>
<small class="excel-note">
    <strong>Chú thích:</strong> File Excel cần có đầy đủ các trường và theo thứ tự sau:
    <br />
    User name, Mã bệnh nhân, Giới tính, Ngày sinh, Họ và tên, Email, Số điện thoại, Địa chỉ, Vai trò, Khuyến mãi đặc biệt, Mật khẩu.
</small>

    </div>
</div>

    <button class="toolbar-btn" onclick="openModalStatic()">
        <i class="fas fa-chart-bar"></i> Thống kê
    </button>

    <!-- Thêm 2 nút mới -->
    <button class="toolbar-btn" onclick="openChatModal()" style="position: relative;">
    <i class="fas fa-paper-plane"></i> Chat
    <div id="unreadDot" class="unread-dot" style="display: none;"></div>
</button>


<button class="toolbar-btn notification-btn" onclick="openNotificationModal()" style="position: relative;">
    <i class="fas fa-bell"></i> Thông báo
    
</button>

    <button class="toolbar-btn"onclick="openUserHistoryModal() ">
        <i class="fas fa-history"></i> Lịch sử
    </button>
</div>
<div class="controls-row">
    <!-- Bộ điều khiển bên trái -->
    <div class="left-controls">
        <!-- Bộ chọn hiển thị số lượng -->
        <div class="display-options">
            <label>Hiển thị:</label>
            <select id="displayLimit">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>

        <!-- Ô tìm kiếm -->
        <div class="search-container">
    <input type="text" class="search-box" id="userSearch" placeholder="Tìm kiếm người dùng...">
    <i class="fas fa-search search-icon"></i>
</div>
    </div>

    <!-- Bộ điều khiển bên phải -->
    <div class="right-controls">
        <!-- Bộ sắp xếp -->
        <div class="category-filter">
            <label>Danh mục:</label>
            <select id="categoryFilter">
                <option value="all">Tất cả</option>
                <option value="khách thường">Khách thường</option>
                <option value="bác sĩ">Bác sĩ</option>
            </select>
        </div>

        <!-- Bộ lọc theo sắp xếp -->
        <div class="sort-options">
            <label>Sắp xếp:</label>
            <select id="sortOption">
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Ngày thêm (Mới nhất)</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Ngày thêm (Cũ nhất)</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>A -> Z</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Z -> A</option>
            </select>
        </div>

    </div>
</div>
<table>
    <thead>
        <tr>
        <th class="checkbox-cell">
                <input type="checkbox" id="selectAllCheckbox">
            </th>
            <th class="image-cell">Ảnh</th>
            <th>Mã</th>
            <th>User Name</th>
            <th>Mã bệnh nhân</th>
            <th>Họ và tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="userTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>
<div id="addUserModal" class="addUser-modal" style="display: none;">

    <div class="addUser-modal-content">
        <div class="addUser-modal-header">
            <h2>Thêm Người Dùng</h2>
            <button onclick="closeAddUserModal()">&times;</button>
        </div>

        <form id="addUserForm">
            <div class="addUser-modal-body">
                <!-- Form Columns -->
                <div class="addUser-form-column">
                    <!-- Personal Information -->
                    <div class="addUser-form-group">
                        <label for="addUser-name">Họ Tên</label>
                        <input type="text" id="addUser-name" name="name" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-username">Tên Đăng Nhập</label>
                        <input type="text" id="addUser-username" name="user_name" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-ma-benh-nhan">Mã Bệnh Nhân</label>
                        <input type="text" id="addUser-ma-benh-nhan" name="ma_benh_nhan" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-gioi-tinh">Giới Tính</label>
                        <select id="addUser-gioi-tinh" name="gioi_tinh" required>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-ngay-sinh">Ngày Sinh</label>
                        <input type="date" id="addUser-ngay-sinh" name="ngay_sinh" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-email">Email</label>
                        <input type="email" id="addUser-email" name="email" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-phone-number">Số Điện Thoại</label>
                        <input type="text" id="addUser-phone-number" name="phone_number" required>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-address">Địa Chỉ</label>
                        <input type="text" id="addUser-address" name="address">
                    </div>
                </div>

                <!-- Password Section -->
                <div class="addUser-form-column">
                <div class="addUser-form-group password-toggle">
    <label for="addUser-password">Mật Khẩu</label>
    <input type="password" id="addUser-password" name="password" required>
    <i class="fa fa-eye" onclick="togglePasswordVisibility('addUser-password')"></i>
</div>

<div class="addUser-form-group password-toggle">
    <label for="addUser-password-confirm">Nhập Lại Mật Khẩu</label>
    <input type="password" id="addUser-password-confirm" name="password_confirmation" required>
    <i class="fa fa-eye" onclick="togglePasswordVisibility('addUser-password-confirm')"></i>
</div>


                    <div class="addUser-form-group">
                        <label for="addUser-role">Vai Trò</label>
                        <select id="addUser-role" name="role">
                            <option value="khách thường">Khách thường</option>
                            <option value="bác sĩ">bác sĩ</option>
                        </select>
                    </div>

                    <div class="addUser-form-group">
                        <label for="addUser-special-offer">Khuyến Mãi Đặc Biệt</label>
                        <input type="text" id="addUser-special-offer" name="special_offer">
                    </div>


                    <!-- Avatar Upload Section -->
                    <div class="addUser-form-group">
                        <label for="addUser-avatar">Ảnh Đại Diện</label>
                        <input 
                            type="file" 
                            id="addUser-avatar" 
                            name="avatar" 
                            accept="image/*"
                            onchange="previewAvatar(event)"
                        >
                    </div>

                    <!-- Avatar Preview -->
                    <div class="addUser-avatar-preview" id="addUser-avatar-preview">
                        <img id="addUser-avatar-img" src="" alt="Ảnh đại diện" style="display:none; max-width: 100%; height: auto; border: 1px solid #ccc; border-radius: 4px; padding: 5px;">
                        <span id="addUser-avatar-placeholder">Chưa có ảnh</span>
                    </div>
                </div>
            </div>

            <div class="addUser-modal-footer">
                <button type="button" class="addUser-btn-cancel" onclick="closeAddUserModal()">Hủy</button>
                <button type="submit" class="addUser-btn-save">Thêm Người Dùng</button>
            </div>
        </form>
    </div>
</div>
<div id="readAddUserExcelModal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nội dung file Excel</h2>
            <button onclick="closeReadAddUserExcelModal()">&times;</button>
        </div>
        <div class="modal-body">
            <table id="excelDataPreview" class="excel-table">
                <!-- Nội dung file Excel sẽ được thêm tại đây -->
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeReadAddUserExcelModal()">Đóng</button>
            <button class="btn-save" onclick="processExcelData()">Xác nhận thêm</button>
        </div>
    </div>
</div>
<div id="userStatisticsModal" class="userStatisticsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Thống Kê Người Dùng</h2>
                <span class="closestatic-btn" onclick="closeModalStatic()">&times;</span>
            </div>


    <div class="filterstatic-section">
        <div class="filterstatic-item">
            <label>Khoảng Thời Gian:</label>
            <select id="dateRangeSelect" onchange="handleDateRangeChange()">
                <option value="7">7 Ngày</option>
                <option value="30">30 Ngày</option>
                <option value="90">90 Ngày</option>
                <option value="custom">Tùy Chỉnh</option>
            </select>
        </div>
        
        <div class="filterstatic-item custom-date-section" id="customDateSection">
            <div class="date-inputs">
                <input type="date" id="startDate" placeholder="Từ Ngày">
                <input type="date" id="endDate" placeholder="Đến Ngày">
            </div>
        </div>
        
        <div class="filterstatic-item">
            <button onclick="applyFilter()">Áp Dụng</button>
        </div>
    </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Người Đăng Ký</h3>
                    <p id="registrationCount">1,234</p>
                </div>
                <div class="stat-card">
                    <h3>Thẻ Đa Năng Mở</h3>
                    <p id="cardOpenCount">456</p>
                </div>
                <div class="stat-card">
                    <h3>Tỷ Lệ Sử Dụng Thẻ</h3>
                    <p id="cardUsageRate">75%</p>
                </div>
            </div>

            <div class="chart-section">
                <div>
                    <canvas id="registrationLineChart"></canvas>
                </div>
                <div>
                    <canvas id="cardUsageBarChart"></canvas>
                </div>
            </div>

            <div class="top-spenders">
                <h3>Top 3 Người Chi Tiêu Nhiều Nhất</h3>
                <div class="top-spender-item">
                    <span>Nguyễn Văn A</span>
                    <span>50,000,000 VNĐ</span>
                </div>
                <div class="top-spender-item">
                    <span>Trần Thị B</span>
                    <span>45,000,000 VNĐ</span>
                </div>
                <div class="top-spender-item">
                    <span>Lê Văn C</span>
                    <span>40,000,000 VNĐ</span>
                </div>
            </div>
        </div>
    </div>
    <div id="chatModal" class="chat-modal">
        <div class="chat-container">
            <button class="closeChat-btn" onclick="closeChatModal()">&times;</button>
            <div class="user-list">
                <div class="search-box">
                    <input type="text" placeholder="Tìm kiếm người dùng..." id="userSearchInput" onkeyup="filterUsers()">
                </div>
                <div class="user-list-content" id="userList">
                    <div class="user-item" onclick="selectUser('user1')">
                        <img src="/api/placeholder/50/50" alt="User Avatar">
                        <div>
                            <strong>Nguyễn Văn A</strong>
                            
                        </div>
                    </div>
                    <div class="user-item" onclick="selectUser('user2')">
                        <img src="/api/placeholder/50/50" alt="User Avatar">
                        <div>
                            <strong>Trần Thị B</strong>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-content">
                <div class="chat-header">
                    <img src="/api/placeholder/40/40" alt="User Avatar" id="selectedUserAvatar">
                    <div>
                        <strong id="selectedUserName">Chọn người dùng để chat</strong>
                      
                    </div>
                </div>
                <div class="messages-container" id="messagesContainer">
                        <h3>Hãy chọn 1 user để bắt đầu chat</h3>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Nhập tin nhắn..." id="messageInput">
                    <button onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i> Gửi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="notificationModal" class="notificationModal">
        <div class="notificationModal-content">
            <div class="notificationModal-body">
                <!-- Phần 1: Tạo Thông Báo -->
                <div class="notificationModal-section">
                    <h3>Tạo Thông Báo</h3>
                    <div class="notification-type">
                    <label>
                        <input type="radio" name="notificationType" value="discount" checked>
                        <i class="fas fa-tag" style="color: #27ae60;"></i> Khuyến Mãi
                    </label>
                    <label>
                        <input type="radio" name="notificationType" value="notification">
                        <i class="fas fa-info-circle" style="color: #3498db;"></i> Thông Báo
                    </label>
                    <label>
                        <input type="radio" name="notificationType" value="warning">
                        <i class="fas fa-exclamation-triangle" style="color: #e74c3c;"></i> Cảnh Báo
                    </label>
                </div>

                    <select id="templateSelect" class="form-control">
                        <option value="">Chọn nội dung mẫu</option>
                        <option value="warning-speech">Cảnh báo phát ngôn</option>
                        <option value="general-notice">Thông báo chung</option>
                        <option value="special-promotion">Khuyến mãi đặc biệt</option>
                    </select>
                    <textarea id="notificationContent" class="form-control" rows="5" placeholder="Nhập nội dung thông báo"></textarea>
                </div>

                <!-- Phần 2: Danh Sách Người Dùng -->
                <div class="notificationModal-section">
                    <h3>Danh Sách Người Dùng</h3>
                    
                    <div class="quick-select-buttons">
                        <button onclick="selectUserGroup('khách thường')" class="btn btn-secondary">
                            <i class="fas fa-users"></i> Khách Thường
                        </button>
                        <button onclick="selectUserGroup('bác sĩ')" class="btn btn-secondary">
                            <i class="fas fa-user-md"></i> Bác Sĩ
                        </button>
                        <button onclick="selectUserGroup('all')" class="btn btn-secondary">
    <i class="fas fa-check-double"></i> Tất cả
</button>

                    </div>

                    <input type="text" class="form-control" placeholder="Tìm kiếm người dùng">
                    
                    <div class="notificationUser-list" id="notificationUserList">
    <!-- Danh sách người dùng sẽ được tải động -->
</div>
                </div>

                <!-- Phần 3: Người Dùng Được Chọn -->
                <div class="notificationModal-section">
                    <h3>Người Dùng Được Chọn</h3>
                    <button onclick="deselectAllUsers()" class="btn btn-secondary">
    <i class="fas fa-times-circle"></i> Bỏ chọn tất cả
</button>

                    <div id="selectedUsersList" class="selected-users-list">
                        <div class="no-users">Chưa có người dùng nào được chọn</div>
                    </div>
                </div>
            </div>

            <div class="notificationModal-footer">
                <button class="btn btn-secondary" onClick="closeNotificationModal()">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button class="btn btn-primary" onclick="sendNotification()">
    <i class="fas fa-paper-plane"></i> Gửi Thông Báo
</button>

            </div>
        </div>
    </div>
    <div id="editProductModal" class="editProduct-modal">
        <div class="editProduct-modal-content">
            <div class="editProduct-modal-header">
                <h2>Chỉnh Sửa Người Dùng</h2>
                <button onclick="closeEditProductModal()">&times;</button>
            </div>
            
            <form id="editUserForm">
    <div class="editProduct-modal-body">
        <div class="editProduct-form-column">
            <!-- ID (Locked) -->
            <div class="editProduct-form-group locked">
                <label for="editUser-id">ID</label>
                <input type="text" id="editUserId" name="id" readonly>
            </div>

            <!-- User Name -->
            <div class="editProduct-form-group">
                <label for="editUser-user-name">User Name</label>
                <input type="text" id="editUserName" name="user_name" required>
            </div>

            <!-- Mã Bệnh Nhân -->
            <div class="editProduct-form-group">
                <label for="editUser-ma-benh-nhan">Mã Bệnh Nhân</label>
                <input type="text" id="editMaBenhNhan" name="ma_benh_nhan" required>
            </div>

            <!-- Giới Tính -->
            <div class="editProduct-form-group">
                <label for="editUser-gioi-tinh">Giới Tính</label>
                <select id="editGioiTinh" name="gioi_tinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>

            <!-- Ngày Sinh -->
            <div class="editProduct-form-group">
                <label for="editUser-ngay-sinh">Ngày Sinh</label>
                <input type="date" id="editNgaySinh" name="ngay_sinh" required>
            </div>

            <!-- Email -->
            <div class="editProduct-form-group">
                <label for="editUser-email">Email</label>
                <input type="email" id="editEmail" name="email" required>
            </div>

            <!-- Phone Number -->
            <div class="editProduct-form-group">
                <label for="editUser-phone-number">Số Điện Thoại</label>
                <input type="text" id="editPhoneNumber" name="phone_number" required>
            </div>

            

            <!-- Address -->
            <div class="editProduct-form-group">
                <label for="editUser-address">Địa Chỉ</label>
                <input type="text" id="editAddress" name="address">
            </div>

            <!-- Role -->
            <div class="editProduct-form-group">
                <label for="editUser-role">Vai Trò</label>
                <select id="editRole" name="role" required>
                    <option value="khách Thường">Khách Thường</option>
                    <option value="bác Sĩ">Bác Sĩ</option>
                </select>
            </div>

            <!-- Special Offer -->
            <div class="editProduct-form-group">
                <label for="editUser-special-offer">Ưu Đãi Đặc Biệt</label>
                <input type="text" id="editSpecialOffer" name="special_offer">
            </div>

            <!-- Loyalty Points (Locked) -->
            <div class="editProduct-form-group locked">
                <label for="editUser-loyalty-points">Điểm Tích Lũy</label>
                <input type="text" id="editLoyaltyPoints" name="loyalty_points" readonly>
            </div>

         
            <!-- Is Block -->
            <div class="editProduct-form-group">
                <label for="editUser-is-block">Bị Khóa</label>
                <select id="editIsBlock" name="is_block">
                    <option value="0">Không</option>
                    <option value="1">Có</option>
                </select>
            </div>
            <div class="editProduct-form-group">
    <label for="editUser-avatar">Avatar</label>
    <input type="file" id="editAvatar" name="avatar" accept="image/*" onchange="previewImage(event)">
</div>

<div class="editProduct-image-section">
    <div id="editProduct-image-placeholder" class="editProduct-image-placeholder">
        <!-- Phần này hiển thị ảnh nếu đã chọn, hoặc thông báo "Chưa có ảnh" -->
        <img id="editProduct-image-preview" class="editProduct-image-preview" src="" alt="Xem trước ảnh" style="display:none;">
        <span id="editProduct-no-image">Chưa có ảnh</span>
    </div>

    <input 
        type="file" 
        id="editProduct-image" 
        name="image" 
        accept="image/*" 
        class="editProduct-image-input"
        onchange="previewImage(event)"
    >
    <label for="editProduct-image" class="editProduct-image-label">
        Chọn Ảnh
    </label>
</div>

        </div>
    </div>

    <div class="editProduct-modal-footer">
 <!-- Nút Đổi Mật Khẩu -->
<button type="button" class="editPassWord" onclick="EditPassWordUser()">Đổi Mật Khẩu</button>

<!-- Popup đổi mật khẩu -->
<div id="editPasswordModal" class="editPassword-modal" style="display:none;">
    <div class="editPassword-modal-content">
        <div class="editPassword-modal-header">
            <h2>Đổi Mật Khẩu</h2>
            <button onclick="closeEditPasswordModal()">&times;</button>
        </div>
        <div class="editPassword-modal-body">
            <form id="editPasswordForm">
                <!-- Mật khẩu mới -->
                <div class="editPassword-form-group">
                    <label for="newPassword">Mật khẩu mới</label>
                    <input type="password" id="newPassword" name="new_password" required>
                    <span id="toggleNewPassword" class="toggle-password" onclick="togglePasswordVisibility('newPassword')">&#x1F441;</span>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="editPassword-form-group">
                    <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirmPassword" name="confirm_password" required>
                    <span id="toggleConfirmPassword" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')">&#x1F441;</span>
                </div>

                <button type="submit">Lưu Thay Đổi</button>
            </form>
        </div>
    </div>
</div>


<!-- Popup đổi mật khẩu -->


        <button type="button" class="editProduct-btn-cancel" onclick="closeEditProductModal()">Hủy</button>
        <button type="submit" class="editProduct-btn-save">Lưu Thay Đổi</button>
    </div>
</form>

        </div>
    </div>
   <!-- Modal -->
<div id="userHistoryModal" class="userhistory-modal hidden">
    <div class="userhistory-modal-content">
        <div class="userhistory-modal-header">
            <h3>Lịch sử người dùng</h3>
            <button class="closehistory-btn" onclick="closeUserHistoryModal()">&times;</button>
        </div>
        <div class="userhistory-modal-filters">
            <select id="actionFilter" onchange="fetchUserHistory()">
                <option value="">-- Loại thao tác --</option>
                <option value="add">Add</option>
                <option value="add_multiple">Add Multiple</option>
                <option value="update">Update</option>
            </select>
            <input type="date" id="dateFilter" onchange="fetchUserHistory()">
        </div>
        <div id="userHistoryContent" class="userhistory-modal-body">
            <!-- Lịch sử sẽ được load ở đây -->
        </div>
    </div>
</div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        // Sample data for the chart
       

        document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggle-menu");
    const sidebar = document.querySelector(".sidebar");
    const mainContent = document.querySelector(".main-content");

    toggleButton.addEventListener("click", () => {
        const isHidden = sidebar.classList.toggle("hidden");
        mainContent.classList.toggle("full-width");
        toggleButton.textContent = isHidden ? "☰" : "✕";
    });
        });

        document.addEventListener('DOMContentLoaded', function () {
    const userTable = document.getElementById('userTable');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortOption = document.getElementById('sortOption');

    // Hàm tải dữ liệu người dùng
    function fetchUsers() {
    const category = categoryFilter.value;
    const sort = sortOption.value;

    fetch(`http://localhost/web_ban_banh_kem/public/fetch-users?category=${category}&sort=${sort}`)
        .then(response => response.json())
        .then(data => {
            userTable.innerHTML = data.users.map(user => {
                // Hàm kiểm tra giá trị null và thay thế bằng "Chưa cập nhật"
                const checkValue = (value) => value ? value : 'Chưa cập nhật';

                // Xử lý địa chỉ (tối đa 10 ký tự và thêm "...")
                const address = user.address 
                    ? (user.address.length > 10 ? user.address.substring(0, 10) + '...' : user.address)
                    : 'Chưa cập nhật';

                // Xử lý avatar, dùng ảnh mặc định nếu không có avatar
                const avatar = user.avatar 
                    ? `http://localhost/web_ban_banh_kem/public/${user.avatar}`
                    : 'http://localhost/web_ban_banh_kem/public/images/user-default.png';

                return `
                    <tr data-id="${user.id}">
                        <td><input type="checkbox"></td>
                        <td class="image-cell">
                            <img src="${avatar}" alt="${checkValue(user.name)}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                        </td>
                        <td>${checkValue(user.id)}</td>
                        <td>${checkValue(user.user_name)}</td>
                        <td>${checkValue(user.ma_benh_nhan)}</td>
                        <td>${checkValue(user.name)}</td>
                        <td>${checkValue(user.gioi_tinh)}</td>
                        <td>${checkValue(user.ngay_sinh)}</td>
                        <td>${checkValue(user.email)}</td>
                        <td>${checkValue(user.phone_number)}</td>
                        <td>${address}</td>
                        <td>${checkValue(user.role)}</td>
                        <td>
                           <select class="action-select" data-id="${user.id}">
    <option value="">Chọn tác vụ</option>
    <option value="chat" >💬 Chat</option>
    <option value="edit">✏️ Sửa</option>
    <option value="delete">🗑️ Xóa</option>
    <option value="view">👁️ Xem</option>
</select>

                        </td>
                    </tr>
                `;
            }).join('');
        });
}

    // Gọi lần đầu khi tải trang
    fetchUsers();

    // Lắng nghe sự kiện thay đổi bộ lọc và sắp xếp
    categoryFilter.addEventListener('change', fetchUsers);
    sortOption.addEventListener('change', fetchUsers);

    // Xử lý tác vụ
    userTable.addEventListener('change', function (e) {
    if (e.target.classList.contains('action-select')) {
        const userId = e.target.dataset.id; // Lấy ID người dùng
        const action = e.target.value; // Lấy action từ dropdown

        if (action === 'delete') {
            if (confirm('Bạn có muốn xóa người dùng này không?')) {
                fetch(`/delete-user/${userId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Xóa thành công');
                            fetchUsers();
                        } else {
                            alert('Xóa không thành công');
                        }
                    });
            }
        } else if (action === 'edit') {
            openEditUserModal(userId);
            alert(`Sửa người dùng ID: ${userId}`);
        } else if (action === 'view') {
            alert(`Xem người dùng ID: ${userId}`);
        } else if (action === 'chat') {
            // Chat logic: mở modal, chọn user và tải tin nhắn
            openChatModal(); // Hiển thị modal chat
            selectUser(userId); // Chọn người dùng và hiển thị tin nhắn
        }

        // Reset select box
        e.target.value = '';
    }
});
});
document.getElementById('userSearch').addEventListener('input', function () {
    const searchValue = this.value.trim().toLowerCase(); // Lấy giá trị tìm kiếm và loại bỏ khoảng trắng thừa

    fetch(`http://localhost/web_ban_banh_kem/public/search-users?query=${encodeURIComponent(searchValue)}`)
        .then(response => response.json())
        .then(data => {
            const userTable = document.getElementById('userTable');
            userTable.innerHTML = data.users.map(user => {
                // Hàm kiểm tra giá trị null và thay thế bằng "Chưa cập nhật"
                const checkValue = (value) => value ? value : 'Chưa cập nhật';

                // Xử lý địa chỉ: Rút gọn tối đa 10 ký tự, thêm "..."
                const address = user.address 
                    ? (user.address.length > 10 ? user.address.substring(0, 10) + '...' : user.address) 
                    : 'Chưa cập nhật';

                // Xử lý avatar: Dùng ảnh mặc định nếu không có avatar
                const avatar = user.avatar 
                    ? `http://localhost/web_ban_banh_kem/public/${user.avatar}` 
                    : 'http://localhost/web_ban_banh_kem/public/images/user-default.png';

                return `
                    <tr data-id="${user.id}">
                        <td><input type="checkbox"></td>
                        <td class="image-cell">
                            <img src="${avatar}" 
                                alt="${checkValue(user.name)}" 
                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                        </td>
                        <td>${checkValue(user.id)}</td>
                        <td>${checkValue(user.user_name)}</td>
                        <td>${checkValue(user.ma_benh_nhan)}</td>
                        <td>${checkValue(user.name)}</td>
                        <td>${checkValue(user.gioi_tinh)}</td>
                        <td>${checkValue(user.ngay_sinh)}</td>
                        <td>${checkValue(user.email)}</td>
                        <td>${checkValue(user.phone_number)}</td>
                        <td>${address}</td>
                        <td>${checkValue(user.role)}</td>
                        <td>
                            <select class="action-select" data-id="${user.id}">
                                <option value="">Chọn tác vụ</option>
                                <option value="chat">Chat</option>
                                <option value="edit">Sửa</option>
                                <option value="delete">Xóa</option>
                                <option value="view">Xem</option>
                            </select>
                        </td>
                    </tr>
                `;
            }).join('');

            // Gắn sự kiện cho các ô tác vụ (nếu cần)
            attachActionEvents();
        })
        .catch(error => console.error('Lỗi khi tìm kiếm:', error));
});

document.getElementById('selectAllCheckbox').addEventListener('change', function () {
    const isChecked = this.checked; // Trạng thái của checkbox chính
    const checkboxes = document.querySelectorAll('#userTable input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked; // Đặt trạng thái cho tất cả checkbox
    });
});


document.getElementById('userTable').addEventListener('change', function (e) {
    if (e.target.type === 'checkbox') {
        const allCheckboxes = document.querySelectorAll('#userTable input[type="checkbox"]');
        const checkedCheckboxes = document.querySelectorAll('#userTable input[type="checkbox"]:checked');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');

        // Nếu tất cả checkbox con được chọn, thì checkbox chính cũng được chọn
        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
    }
});

// Hiển thị modal
const excelExportBtn = document.querySelector('.excel-export-btn');
const exportDropdown = document.getElementById('exportDropdown');

// Hiển thị/ẩn dropdown khi nhấn nút Xuất Excel
excelExportBtn.addEventListener('click', function () {
    exportDropdown.classList.toggle('show');
});

// Ẩn dropdown khi nhấp ra ngoài
document.addEventListener('click', function (event) {
    if (!excelExportBtn.contains(event.target) && !exportDropdown.contains(event.target)) {
        exportDropdown.classList.remove('show');
    }
});

// Xử lý "In tất cả"
document.getElementById('exportAllBtn').addEventListener('click', function () {
    fetch('http://localhost/web_ban_banh_kem/public/fetch-users')
        .then(response => response.json())
        .then(data => {
            exportToExcel(data.users, 'Tat_ca_user');
        })
        .catch(error => console.error('Lỗi khi xuất Excel:', error));
    exportDropdown.classList.remove('show'); // Đóng dropdown
});

// Xử lý "In đã chọn"
document.getElementById('exportSelectedBtn').addEventListener('click', function () {
    const selectedUsers = [];
    const checkboxes = document.querySelectorAll('#userTable input[type="checkbox"]:checked');
    checkboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        selectedUsers.push({
            id: row.dataset.id,
            user_name: row.querySelector('td:nth-child(4)').textContent,
            ma_benh_nhan: row.querySelector('td:nth-child(5)').textContent,
            name: row.querySelector('td:nth-child(6)').textContent,
            gioi_tinh: row.querySelector('td:nth-child(7)').textContent,
            ngay_sinh: row.querySelector('td:nth-child(8)').textContent,
            email: row.querySelector('td:nth-child(9)').textContent,
            phone_number: row.querySelector('td:nth-child(10)').textContent,
            address: row.querySelector('td:nth-child(11)').textContent,
            role: row.querySelector('td:nth-child(12)').textContent
        });
    });

    if (selectedUsers.length > 0) {
        exportToExcel(selectedUsers, 'User_da_chon');
    } else {
        alert('Bạn chưa chọn người dùng nào!');
    }
    exportDropdown.classList.remove('show'); // Đóng dropdown
});

// Hàm xuất Excel sử dụng SheetJS (CDN: https://cdn.sheetjs.com/)
function exportToExcel(data, fileName) {
    // Lọc các cột cần xuất
    const filteredData = data.map(user => ({
        "Mã": user.id,
        "User Name": user.user_name,
        "Mã bệnh nhân": user.ma_benh_nhan,
        "Họ và tên": user.name,
        "Giới tính": user.gioi_tinh,
        "Ngày sinh": user.ngay_sinh,
        "Email": user.email,
        "Số điện thoại": user.phone_number,
        "Địa chỉ": user.address,
        "Vai trò": user.role
    }));

    // Tạo worksheet từ dữ liệu đã lọc
    const ws = XLSX.utils.json_to_sheet(filteredData);

    // Tạo workbook và thêm sheet vào
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Users');

    // Xuất file Excel
    XLSX.writeFile(wb, `${fileName}.xlsx`);
}

// Sự kiện click để hiển thị/ẩn drop-down
document.querySelector('.look-up-btn').addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdownContent');

    // Hiển thị hoặc ẩn drop-down
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }

    // Ngăn chặn sự kiện click lan ra ngoài
    event.stopPropagation();
});

// Ngăn việc click bên trong drop-down làm tắt drop-down
document.getElementById('dropdownContent').addEventListener('click', function (event) {
    event.stopPropagation();
});

// Ẩn drop-down khi click ra ngoài
document.addEventListener('click', function () {
    const dropdown = document.getElementById('dropdownContent');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    }
});

document.getElementById('lookupBtn').addEventListener('click', function () {
    const cardCode = document.getElementById('cardCode').value;
    const qrFile = document.getElementById('qrUpload').files[0];

    if (cardCode) {
        // Gửi mã thẻ qua API để kiểm tra
        sendQrCodeToApi(cardCode);
    } else if (qrFile) {
        // Đọc mã QR từ file ảnh
        const reader = new FileReader();
        reader.onload = function (event) {
            const image = new Image();
            image.src = event.target.result;

            image.onload = function () {
                // Tạo canvas để xử lý ảnh
                const canvas = document.createElement('canvas');
                canvas.width = image.width;
                canvas.height = image.height;
                const context = canvas.getContext('2d');
                context.drawImage(image, 0, 0, canvas.width, canvas.height);

                // Lấy dữ liệu ảnh từ canvas và đọc mã QR
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const qrCodeData = jsQR(imageData.data, canvas.width, canvas.height);

                if (qrCodeData) {
                    // Gửi nội dung mã QR qua API để kiểm tra
                    sendQrCodeToApi(qrCodeData.data);
                } else {
                    alert('Không tìm thấy mã QR trong tệp.');
                }
            };
        };
        reader.readAsDataURL(qrFile); // Đọc file ảnh dưới dạng URL
    } else {
        alert('Vui lòng nhập mã thẻ hoặc tải mã QR.');
    }
});

/**
 * Gửi mã QR (hoặc mã thẻ) đến API để kiểm tra.
 * @param {string} qrCode
 */
function sendQrCodeToApi(qrCode) {
    fetch('http://localhost/web_ban_banh_kem/public/check-qr-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Laravel CSRF token
        },
        body: JSON.stringify({ qr_code: qrCode }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
            alert(`Mã QR hợp lệ. User ID: ${data.user.user_id}`);
            // Đóng dropdown
            document.getElementById('dropdownContent').style.display = 'none';

            // Hiển thị modal với thông tin người dùng và thẻ đa năng
            showUserInfoModal(data.user, data.the_da_nang, data.orders);
        } else {
            alert(data.message);
        }
    })
    .catch((error) => {
        console.error('Lỗi:', error);
        alert('Có lỗi xảy ra khi tra cứu.');
    });
}

/**
 * Hiển thị modal thông tin người dùng và thẻ đa năng
 *  @param {object} user
 * @param {object} theDaNang
 * @param {object} orders
 */
let  card_id =0;
function showUserInfoModal(user, theDaNang,orders) {
    // Tạo nội dung modal
    card_id = theDaNang.card_id;
    const modalContent = `
    <div class="modal-content">
        <h2>Thông tin người dùng</h2>

        <div class="info-container">
         <div id="pinModal" class="pin-modal" style="display:none;">
    <div class="pin-modal-content">
        <h2>Nhập Mã PIN</h2>
        <label for="pin">Mã PIN:</label>
        <input type="password" id="pin" name="pin" required>
        <div class="pin-modal-actions">
            <button type="button" onclick="confirmPin()">Xác Nhận</button>
            <button type="button" onclick="closePinModal()">Hủy</button>
        </div>
    </div>
</div>
            <div class="info-column">
                <h3>Thông tin cá nhân</h3>
                <div>
                    <img src="http://localhost/web_ban_banh_kem/public/${user.avatar}" alt="Avatar" class="user-avatar">
                </div>
                <div><strong>Tên người dùng:</strong> ${user.name}</div>
                <div><strong>Email:</strong> ${user.email}</div>
                <div><strong>Số điện thoại:</strong> ${user.phone}</div>
                <div><strong>Mã bệnh nhân:</strong> ${user.ma_benh_nhan}</div>
                <div><strong>Giới tính:</strong> ${user.gioi_tinh}</div>
                <div><strong>Ngày sinh:</strong> ${user.ngay_sinh}</div>
                <div><strong>Địa chỉ:</strong> ${user.address}</div>
                <div><strong>Khuyến mãi đặc biệt:</strong> ${user.special_offer}</div>
                <div><strong>Ngày đăng ký:</strong> ${user.ngay_dang_ky}</div>
                <div><strong>Vai trò:</strong> ${user.role}</div>
                <div><strong>Bị khóa:</strong> ${user.is_block}</div>
                <div><strong>Điểm tích lũy:</strong> ${user.loyalty_points}</div>
            </div>

            <div class="info-column">
                <h3>Thông tin thẻ đa năng</h3>
                
                <div><strong>Mã thẻ:</strong> ${theDaNang.card_id}</div>
                <div><strong>Số dư:</strong> ${formatCurrency(Number(theDaNang.card_balance))}</div>
                <div><strong>Liên kết thanh toán 1:</strong> ${theDaNang.payment_method_1}-${theDaNang.card_number_1}</div>
                <div><strong>Liên kết thanh toán 2:</strong> ${theDaNang.payment_method_2}-${theDaNang.card_number_2}</div>
                
                <!-- Các nút Nạp tiền, Rút tiền, Đổi mã PIN -->
                <div class="button-container">
                    <button type="button" class="TheDaNangbtn" onclick="topUp()">Nạp Tiền</button>
                    <button type="button" class="TheDaNangbtn" onclick="withdraw()">Rút Tiền</button>
                    <button type="button" class="TheDaNangbtn" onclick="changePin()">Đổi Mã PIN</button>
                </div>
            </div>

            <div class="info-column">
                <h3>Thông tin đơn hàng</h3>
                <div><strong>Tổng số đơn hàng:</strong> ${orders.total_orders}</div>
                <div><strong>Đơn hàng đã thành công:</strong> ${orders.completed_orders}</div>
                <div><strong>Đơn hàng đang chờ:</strong> ${orders.pending_orders}</div>
                <div><strong>Đơn hàng đã hủy:</strong> ${orders.canceled_orders}</div>
                <div><strong>Tổng số tiền đã chi tiêu:</strong> ${formatCurrency(Number(orders.total_amount_spent))}</div>
            </div>
        </div>
    </div>
`;
   
    // Thêm modal vào body
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.innerHTML = modalContent;
    document.body.appendChild(modal);

    // Hiển thị modal
    modal.style.display = 'block';

    // Đóng modal khi bấm ngoài
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            modal.remove();
        }
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}
// Chỉ áp dụng logic cho dropdown có định danh "user-dropdown"
document.querySelector('.user-dropdown .addUserBtn').addEventListener('click', (e) => {
    const dropdownMenu = document.querySelector('.user-dropdown-menu');
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    
    // Ngăn chặn sự kiện lan ra ngoài
    e.stopPropagation();
});

// Ẩn menu khi bấm ra ngoài (chỉ cho dropdown này)
document.addEventListener('click', (event) => {
    const dropdownMenu = document.querySelector('.user-dropdown-menu');
    if (dropdownMenu && !dropdownMenu.contains(event.target)) {
        dropdownMenu.style.display = 'none';
    }
});

// Open Add User Modal
function openAddUserModal() {
    document.getElementById("addUserModal").style.display = "block";
}

// Close Add User Modal
function closeAddUserModal() {
    document.getElementById("addUserModal").style.display = "none";
}

// Event Listener for "Thêm một người dùng"
document.querySelector('.add-single-user').addEventListener('click', openAddUserModal);

function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('editProduct-image-preview');
    const placeholder = document.getElementById('editProduct-image-placeholder');
    const noImage = document.getElementById('editProduct-no-image');

    if (file) {
        // Hiển thị ảnh mới và ẩn thông báo "Chưa có ảnh"
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;  // Cập nhật ảnh xem trước
            preview.style.display = 'block';  // Hiển thị ảnh
            noImage.style.display = 'none';  // Ẩn thông báo "Chưa có ảnh"
        };
        reader.readAsDataURL(file);  // Đọc file ảnh
    } else {
        // Nếu không có ảnh thì hiển thị lại thông báo "Chưa có ảnh"
        preview.style.display = 'none';
        noImage.style.display = 'block';
    }
}

document.getElementById('addUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Clear existing errors
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validate form inputs
    const name = document.getElementById('addUser-name');
    const username = document.getElementById('addUser-username');
    const email = document.getElementById('addUser-email');
    const password = document.getElementById('addUser-password');
    const confirmPassword = document.getElementById('addUser-password-confirm');
    let hasError = false;

    // Name validation
    if (!name.value.trim()) {
        showError(name, 'Họ tên không được để trống.');
        hasError = true;
    }

    // Username validation
    if (!username.value.trim()) {
        showError(username, 'Tên đăng nhập không được để trống.');
        hasError = true;
    }

    // Email validation
    if (!validateEmail(email.value)) {
        showError(email, 'Email không hợp lệ.');
        hasError = true;
    }

    // Password validation
    if (password.value.length < 6) {
        showError(password, 'Mật khẩu phải có ít nhất 6 ký tự.');
        hasError = true;
    }

    // Confirm password validation
    if (password.value !== confirmPassword.value) {
        showError(confirmPassword, 'Mật khẩu nhập lại không khớp.');
        hasError = true;
    }

    // Nếu có lỗi, dừng form submit
    if (hasError) {
        return;
    }

    // Nếu không có lỗi, tiếp tục gửi form qua AJAX
    const formData = new FormData(this);

    fetch('http://localhost/web_ban_banh_kem/public/users', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                // Nếu mã trạng thái là 422, lấy dữ liệu lỗi
                if (response.status === 422) {
                    return response.json().then(data => {
                        if (data.errors) {
                            for (const [key, message] of Object.entries(data.errors)) {
                                const input = document.querySelector(`[name="${key}"]`);
                                if (input) {
                                    showError(input, message);
                                }
                            }
                        }
                    });
                }
                throw new Error('Đã xảy ra lỗi không xác định.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeAddUserModal();
                // Cập nhật giao diện hoặc load lại trang nếu cần
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra! Vui lòng thử lại.');
        });
});

// Show error message below the input field
function showError(input, message) {
    const error = document.createElement('div');
    error.className = 'error-message';
    error.innerText = message;
    input.parentElement.appendChild(error);
}

// Email validation regex
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
document.querySelectorAll('.password-toggle i').forEach(icon => {
    icon.addEventListener('click', function () {
        const input = this.parentElement.querySelector('input');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
});

function handleUploadExcel(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Kiểm tra định dạng file
    const fileType = file.name.split('.').pop();
    if (fileType !== 'xls' && fileType !== 'xlsx') {
        alert('Vui lòng tải lên file Excel đúng định dạng (.xls, .xlsx).');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        // Lấy sheet đầu tiên
        const sheetName = workbook.SheetNames[0];
        const sheet = workbook.Sheets[sheetName];

        // Chuyển đổi dữ liệu sheet thành JSON
        const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        // Kiểm tra trường hợp thiếu cột bắt buộc
        const requiredHeaders = [
            "User name",
            "Mã bệnh nhân",
            "Giới tính",
            "Ngày sinh",
            "Họ và tên",
            "Email",
            "Số điện thoại",
            "Địa chỉ",
            "Vai trò",
            "Khuyến mãi đặc biệt",
            "Mật khẩu",
        ];
        const headers = jsonData[0] || [];

        if (headers.length !== requiredHeaders.length || !requiredHeaders.every((h, i) => h === headers[i])) {
            alert('File Excel không đúng định dạng hoặc thiếu các trường bắt buộc.');
            return;
        }

        // Thêm giá trị "Không có" vào các ô bị null hoặc undefined
        const sanitizedData = jsonData.map((row, index) => {
            // Nếu là tiêu đề, giữ nguyên
            if (index === 0) return row;

            // Duyệt qua từng ô và thay null/undefined/thông tin trống bằng "Không có"
            return headers.map((_, colIndex) => {
                const cell = row[colIndex];
                return cell === null || cell === undefined || cell === "" ? "Không có" : cell;
            });
        });

        // Hiển thị dữ liệu trong modal
        displayExcelData(sanitizedData);
    };

    reader.readAsArrayBuffer(file);
}


async function checkIfDataExists(row) {
    const data = {
        user_name: row[0],        // User name
        ma_benh_nhan: row[1],     // Mã bệnh nhân
        email: row[5],            // Email
        phone_number: row[6]      // Số điện thoại
    };

    console.log("Sending data:", data); // Log dữ liệu gửi lên

    try {
        const response = await fetch('http://localhost/web_ban_banh_kem/public/check-if-data-exists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        console.log("Response status:", response.status); // Log status code

        // Kiểm tra nếu phản hồi không phải JSON
        if (!response.ok) {
            const errorText = await response.text();
            console.error("Server error response:", errorText); // Log phản hồi lỗi từ server
            throw new Error('Lỗi server: ' + response.statusText);
        }

        const result = await response.json();
        console.log("Response JSON:", result); // Log dữ liệu JSON nhận được từ server
        return result.exists;
    } catch (error) {
        console.error('Lỗi khi gửi yêu cầu:', error);
        return false; // Hoặc xử lý lỗi khác
    }
}



function displayExcelData(data) {
    const table = document.getElementById('excelDataPreview');
    table.innerHTML = '';

    // Thêm chú thích

    // Thêm hàng tiêu đề
    const headerRow = document.createElement('tr');
    const selectAllCheckbox = document.createElement('th');
    selectAllCheckbox.innerHTML = `
        <input type="checkbox" id="selectAllCheckbox" onclick="toggleAllCheckboxes(this)">
    `;
    headerRow.appendChild(selectAllCheckbox);

    data[0].forEach(header => {
        const th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });
    table.appendChild(headerRow);

    // Thêm dữ liệu từ hàng thứ 2 trở đi
    data.slice(1).forEach(async (row, rowIndex) => {
        const tr = document.createElement('tr');
        tr.dataset.rowIndex = rowIndex + 1; // Gán index để xử lý lỗi

        // Kiểm tra nếu dữ liệu đã tồn tại trong CSDL
        const isDataExists = await checkIfDataExists(row);

        // Thêm checkbox đầu hàng
        const checkboxTd = document.createElement('td');
        checkboxTd.innerHTML = `
            <input type="checkbox" class="row-checkbox" ${isDataExists ? 'disabled' : ''}>
        `;
        tr.appendChild(checkboxTd);

        // Thêm các cột dữ liệu
        row.forEach(cell => {
            const td = document.createElement('td');
            td.textContent = cell; // Hiển thị đầy đủ dữ liệu
            tr.appendChild(td);
        });

        // Nếu dữ liệu đã tồn tại, đổi màu hàng thành vàng
        if (isDataExists) {
            tr.style.backgroundColor = 'yellow';
        }

        table.appendChild(tr);
    });

    openReadAddUserExcelModal();
    adjustTableColumns(); // Điều chỉnh cột sau khi thêm dữ liệu
}


// Kiểm tra định dạng của từng hàng
function validateRow(row) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{10,15}$/;
    const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
    const genderValues = ['nam', 'nữ', 'khác'];
    const roleValues = ['khách thường', 'bác sĩ'];

    // Hàm hỗ trợ kiểm tra giá trị và chuyển về chữ thường
    const toLowerCaseIfString = (value) =>
        typeof value === 'string' ? value.toLowerCase() : value;

    // Kiểm tra các trường quan trọng (không được là "Không có")
    if (!row[0] || toLowerCaseIfString(row[0]) === "không có") return false; // User name
    if (!row[1] || toLowerCaseIfString(row[1]) === "không có") return false; // Mã bệnh nhân
    if (!row[10] || toLowerCaseIfString(row[10]) === "không có") return false; // Mật khẩu

    // Kiểm tra email nếu có và không phải "Không có"
    if (row[5] && toLowerCaseIfString(row[5]) !== "không có" && !emailRegex.test(row[5])) {
        return false; // Email
    }

    // Kiểm tra số điện thoại nếu có và không phải "Không có"
    if (row[6] && toLowerCaseIfString(row[6]) !== "không có" && !phoneRegex.test(row[6])) {
        return false; // Số điện thoại
    }

    // Kiểm tra giới tính nếu có và không phải "Không có"
    if (row[2] && toLowerCaseIfString(row[2]) !== "không có" && !genderValues.includes(toLowerCaseIfString(row[2]))) {
        return false; // Giới tính
    }

    // Kiểm tra vai trò nếu có và không phải "Không có"
    if (row[8] && toLowerCaseIfString(row[8]) !== "không có" && !roleValues.includes(toLowerCaseIfString(row[8]))) {
        return false; // Vai trò
    }

    // Kiểm tra ngày sinh nếu có và không phải "Không có"
    if (row[3] && toLowerCaseIfString(row[3]) !== "không có" && !dateRegex.test(row[3])) {
        return false; // Ngày sinh
    }

    return true; // Nếu tất cả kiểm tra đều hợp lệ
}

// Toggle "Check All"
function toggleAllCheckboxes(selectAllCheckbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox:not(:disabled)');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function openReadAddUserExcelModal() {
    document.getElementById('readAddUserExcelModal').style.display = 'block';
}

function closeReadAddUserExcelModal() {
    document.getElementById('readAddUserExcelModal').style.display = 'none';
}

async function processExcelData() { 
    const selectedRows = Array.from(document.querySelectorAll('.row-checkbox:checked'))
        .map(checkbox => checkbox.closest('tr').dataset.rowIndex);

    if (selectedRows.length === 0) {
        alert('Vui lòng chọn ít nhất một hàng để xử lý.');
        return;
    }

    // Hàm chuyển đổi ngày sinh từ dd/mm/yyyy sang yyyy-mm-dd
    function convertDateFormat(dateString) {
        const parts = dateString.split('/');
        if (parts.length === 3) {
            const [day, month, year] = parts;
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }
        return dateString; // Trả về ngày gốc nếu không đúng định dạng
    }

    // Thu thập dữ liệu của các người dùng được chọn
    const usersToAdd = selectedRows.map(rowIndex => {
        const row = document.querySelector(`tr[data-row-index="${rowIndex}"]`);
        return {
            user_name: row.children[1].textContent.trim(),   // User Name (Cột 1)
            ma_benh_nhan: row.children[2].textContent.trim(), // Mã bệnh nhân (Cột 2)
            gioi_tinh: row.children[3].textContent.trim(),    // Giới tính (Cột 3)
            ngay_sinh: convertDateFormat(row.children[4].textContent.trim()), // Chuyển đổi định dạng Ngày sinh (Cột 4)
            name: row.children[5].textContent.trim(),         // Họ và tên (Cột 5)
            email: row.children[6].textContent.trim() === 'Không có' ? null : row.children[6].textContent.trim(), // Kiểm tra Email (Cột 6)
            phone_number: row.children[7].textContent.trim() === 'Không có' ? null : row.children[7].textContent.trim(), // Kiểm tra Số điện thoại (Cột 7)
            address: row.children[8].textContent.trim(),      // Địa chỉ (Cột 8)
            role: row.children[9].textContent.trim(),         // Vai trò (Cột 9)
            special_offer: row.children[10].textContent.trim(), // Khuyến mãi đặc biệt (Cột 10)
            password: row.children[11].textContent.trim()     // Mật khẩu (Cột 11)
        };
    });

    // Log dữ liệu gửi lên
    console.log('Dữ liệu gửi lên server:', usersToAdd);

    // Gửi yêu cầu tới server để insert người dùng vào CSDL
    const response = await fetch('http://localhost/web_ban_banh_kem/public/add-users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ users: usersToAdd })  // usersToAdd là mảng các đối tượng người dùng
    });

    // Kiểm tra mã trạng thái HTTP
    if (!response.ok) {
        const errorText = await response.text();  // Nhận thông báo lỗi từ server
        console.error('Error response:', errorText);
        alert('Có lỗi xảy ra khi thêm người dùng.');
        return;
    }

    const result = await response.json();
    console.log('Kết quả từ server:', result);
    alert('Thêm người dùng thành công.');
    closeReadAddUserExcelModal();
}




function adjustTableColumns() {
    const table = document.querySelector(".excel-table");
    const modal = document.querySelector(".modal-body");

    if (table && modal) {
        const columnCount = table.querySelector("tr").children.length; // Đếm số cột
        const columnWidth = modal.offsetWidth / columnCount; // Chia đều không gian modal cho các cột
        Array.from(table.querySelectorAll("th, td")).forEach(cell => {
            cell.style.width = `${columnWidth}px`;
        });
    }
}
async function openModalStatic() {
    document.getElementById('userStatisticsModal').style.display = 'block';

    try {
        // Gọi API để lấy dữ liệu mặc định 6 tháng gần nhất
        const response = await fetch('http://localhost/web_ban_banh_kem/public/get-user-statistics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const data = await response.json();

            // Cập nhật giao diện
            updateStats(data.stats);
            updateCharts(data.charts);
            updateTopSpenders(data.topSpenders);
        } else {
            alert('Có lỗi xảy ra khi tải dữ liệu thống kê!');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi tải dữ liệu thống kê!');
    }
}
function closeModalStatic() {
    document.getElementById('userStatisticsModal').style.display = 'none';
}


      

        function renderRegistrationChart() {
            var ctx = document.getElementById('registrationLineChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                    datasets: [{
                        label: 'Số Lượng Đăng Ký',
                        data: [120, 190, 300, 250, 210, 350],
                        borderColor: 'blue',
                        tension: 0.1
                    }]
                }
            });
        }

        function renderCardUsageChart() {
            var ctx = document.getElementById('cardUsageBarChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Mở Thẻ', 'Sử Dụng Thanh Toán'],
                    datasets: [{
                        label: 'Thống Kê Thẻ Đa Năng',
                        data: [456, 342],
                        backgroundColor: ['green', 'orange']
                    }]
                }
            });
        }

        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('userStatisticsModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        function handleDateRangeChange() {
            const select = document.getElementById('dateRangeSelect');
            const customDateSection = document.getElementById('customDateSection');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            // Reset inputs
            startDateInput.value = '';
            endDateInput.value = '';

            if (select.value === 'custom') {
                customDateSection.classList.add('active');
                startDateInput.disabled = false;
                endDateInput.disabled = false;
            } else {
                customDateSection.classList.remove('active');
                startDateInput.disabled = true;
                endDateInput.disabled = true;

                // Automatically set dates based on selection
                const today = new Date();
                const days = parseInt(select.value);
                const pastDate = new Date(today);
                pastDate.setDate(today.getDate() - days);

                startDateInput.value = formatDate(pastDate);
                endDateInput.value = formatDate(today);
            }
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        async function applyFilter() {
    const select = document.getElementById('dateRangeSelect');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    const range = select.value;
    const startDate = range === 'custom' ? startDateInput.value : null;
    const endDate = range === 'custom' ? endDateInput.value : null;

    try {
        const response = await fetch('http://localhost/web_ban_banh_kem/public/get-user-statistics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ range, startDate, endDate }),
        });

        if (response.ok) {
            const data = await response.json();

            // Cập nhật giao diện
            updateStats(data.stats);
            updateCharts(data.charts);
            updateTopSpenders(data.topSpenders);
        } else {
            alert('Có lỗi xảy ra khi áp dụng bộ lọc!');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi áp dụng bộ lọc!');
    }
}

function updateStats(stats) {
    document.getElementById('registrationCount').innerText = stats.totalRegistrations;
    document.getElementById('cardOpenCount').innerText = stats.totalCardOpenings;
    document.getElementById('cardUsageRate').innerText = `${stats.cardUsageRate}%`;
}


// Biến lưu các instance của biểu đồ
let registrationChartInstance = null;
let cardUsageChartInstance = null;

// Hàm cập nhật biểu đồ
function updateCharts(data) {
    // Destroy biểu đồ cũ nếu tồn tại
    if (registrationChartInstance) {
        registrationChartInstance.destroy();
    }
    if (cardUsageChartInstance) {
        cardUsageChartInstance.destroy();
    }

    // Biểu đồ đăng ký
    const registrationCtx = document.getElementById('registrationLineChart').getContext('2d');
    registrationChartInstance = new Chart(registrationCtx, {
        type: 'line',
        data: {
            labels: data.labels, // Tháng
            datasets: [{
                label: 'Số lượng đăng ký',
                data: data.registrationData, // Số liệu đăng ký
                borderColor: 'blue',
                tension: 0.1,
            }],
        },
    });

    // Biểu đồ mở thẻ
    const cardUsageCtx = document.getElementById('cardUsageBarChart').getContext('2d');
    cardUsageChartInstance = new Chart(cardUsageCtx, {
        type: 'bar',
        data: {
            labels: data.labels, // Tháng
            datasets: [{
                label: 'Số lượng mở thẻ',
                data: data.cardOpenData, // Số liệu mở thẻ
                backgroundColor: 'green',
            }],
        },
    });
}

function updateTopSpenders(topSpenders) {
    const topSpendersContainer = document.querySelector('.top-spenders');
    topSpendersContainer.innerHTML = `
        <h3>Top 3 Người Chi Tiêu Nhiều Nhất</h3>
        ${topSpenders.map(spender => `
            <div class="top-spender-item">
                <span>${spender.name}</span>
                <span>${formatCurrency(Number(spender.total_spent))} VNĐ</span>
            </div>
        `).join('')}
    `;
}

async function fetchUserList() {
    try {
        const response = await fetch('http://localhost/web_ban_banh_kem/public/chat-users', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        });

        if (response.ok) {
            const users = await response.json();
            updateUserList(users);
        } else {
            console.error('Failed to fetch user list.');
        }
    } catch (error) {
        console.error('Error fetching user list:', error);
    }
}

// Cập nhật danh sách người dùng
function updateUserList(users) { 
    const userListContainer = document.getElementById('userList');
    userListContainer.innerHTML = ''; // Xóa danh sách hiện tại

    const selectedUserId = document.querySelector('.user-item.selected strong')?.textContent.split(' - ')[1];

    users.forEach(user => {
        const avatarPath = user.avatar && user.avatar.trim() !== '' 
            ? `http://localhost/web_ban_banh_kem/public/${user.avatar}`
            : 'http://localhost/web_ban_banh_kem/public/images/user-default.png';

        const userItem = document.createElement('div');
        userItem.className = 'user-item';

        // Nếu user được chọn trước đó, thêm lớp 'selected'
        if (selectedUserId == user.user_id) {
            userItem.classList.add('selected');
        }

        // Thêm sự kiện click vào user
        userItem.onclick = () => {
            selectUser(user.user_id);
            removeNotificationDot(user.user_id);  // Ẩn dot đỏ khi bấm vào user
        };

        userItem.innerHTML = `
            <img src="${avatarPath}" alt="User Avatar">
            <div>
                <strong>${user.user_name} - ${user.user_id}</strong>
                <p>${user.last_message || 'Chưa có tin nhắn'}</p>
            </div>
            ${user.is_read_admin === 0 ? '<div class="notification-dot"></div>' : ''}
        `;

        userListContainer.appendChild(userItem);
    });
}

// Hàm ẩn dot đỏ khi bấm vào user
function removeNotificationDot(userId) {
    const userItems = document.querySelectorAll('.user-item');
    userItems.forEach(userItem => {
        const userIdInItem = userItem.querySelector('strong').textContent.split(' - ')[1];  // Lấy user_id từ tên
        if (userIdInItem == userId) {
            const dot = userItem.querySelector('.notification-dot');
            if (dot) {
                dot.style.display = 'none';  // Ẩn dot đỏ
            }
        }
    });

    // Gửi yêu cầu API để cập nhật is_admin_read = 1 cho tất cả tin nhắn của user đó
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`http://localhost/web_ban_banh_kem/public/markAsRead/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Successfully marked as read for user:', userId);
        } else {
            console.error('Failed to mark as read:', data.message);
        }
    })
    .catch(error => {
        console.error('Error updating read status:', error);
    });
}


// Mở modal chat
function openChatModal() {
    document.getElementById('chatModal').style.display = 'flex';
    fetchUserList(); // Lấy danh sách người dùng từ API
}

// Đóng modal chat
function closeChatModal() {
    document.getElementById('chatModal').style.display = 'none';
}

// Chọn user và hiển thị cuộc trò chuyện
function selectUser(userId) {
    console.log('Selected user:', userId);

    // Loại bỏ lớp 'selected' khỏi tất cả các thẻ .user-item
    const userItems = document.querySelectorAll('.user-item');
    userItems.forEach(item => item.classList.remove('selected'));

    // Thêm lớp 'selected' cho thẻ của user hiện tại
    const selectedItem = Array.from(userItems).find(item => {
        const userIdInItem = item.querySelector('strong').textContent.split(' - ')[1];
        return userIdInItem == userId;
    });

    if (selectedItem) {
        selectedItem.classList.add('selected');
    }

    // Gọi API để lấy tin nhắn giữa admin và user
    fetch(`http://localhost/web_ban_banh_kem/public/getMessages/${userId}`)
        .then(response => response.json())
        .then(data => {
            displayMessages(data.messages);  // Hiển thị tin nhắn trong phần chat-content
            updateChatHeader(data.user);  // Cập nhật thông tin user trong header
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
}


// Cập nhật thông tin user trong header
function updateChatHeader(user) {
   
    const userName = user.user_name ? user.user_name : 'Chưa có user name';  // Nếu không có user_name thì hiển thị 'Chưa có user name'

document.getElementById('selectedUserName').innerText = `${userName} - ${user.id}`;

    document.getElementById('selectedUserName').setAttribute('data-user-id', user.id);  // Lưu ID người dùng vào thuộc tính data-id
    document.getElementById('selectedUserAvatar').src = `http://localhost/web_ban_banh_kem/public/${user.avatar || 'images/user-default.png'}`;
}


// Hiển thị tin nhắn trong phần chat-content
function displayMessages(messages) {
    const messagesContainer = document.getElementById('messagesContainer');
    messagesContainer.innerHTML = ''; // Xóa tất cả tin nhắn cũ

    messages.forEach(message => {
        const messageDiv = document.createElement('div');
        const timeDiv = document.createElement('div'); // Thẻ chứa thời gian
        const messageContentDiv = document.createElement('div'); // Thẻ chứa nội dung tin nhắn

        // Format thời gian (giả sử `message.created_at` là định dạng ISO string)
        const time = new Date(message.created_at).toLocaleString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });

        // Kiểm tra xem tin nhắn do user hay admin gửi
        if (message.is_user_send === 1) {
            messageDiv.classList.add('message', 'received');
        } else {
            messageDiv.classList.add('message', 'sent');
        }

        // Nội dung tin nhắn
        messageContentDiv.innerText = message.content;
        messageContentDiv.classList.add('message-content');

        // Thời gian
        timeDiv.innerText = time;
        timeDiv.classList.add('message-time');

        // Thêm các phần tử vào messageDiv
        messageDiv.appendChild(messageContentDiv);
        messageDiv.appendChild(timeDiv);

        // Thêm messageDiv vào container
        messagesContainer.appendChild(messageDiv);
    });

    // Cuộn đến tin nhắn mới nhất
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Tìm kiếm người dùng
function filterUsers() {
    const input = document.getElementById('userSearchInput').value.toLowerCase();
    const userItems = document.querySelectorAll('.user-item');

    userItems.forEach(item => {
        const name = item.querySelector('strong').innerText.toLowerCase();
        item.style.display = name.includes(input) ? 'flex' : 'none';
    });
}

// Gửi tin nhắn
// Gửi tin nhắn
// Gửi tin nhắn
function sendMessage() {
    const input = document.getElementById('messageInput');
    const container = document.getElementById('messagesContainer');
    const selectedUserName = document.getElementById('selectedUserName');
    const userId = selectedUserName ? selectedUserName.getAttribute('data-user-id') : null;  // Lấy user ID từ data-id

    if (!userId) {
        console.error('User ID not found!');
        return;  // Nếu không tìm thấy user ID, dừng việc gửi tin nhắn
    }

    if (input.value.trim() !== '') {
        const messageContent = input.value;

        // In ra console để kiểm tra dữ liệu trước khi gửi
        console.log('Sending message with the following data:');
        console.log('User ID:', userId);
        console.log('Message Content:', messageContent);

        // Lấy token CSRF
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('CSRF Token:', token);  // In CSRF Token ra console để kiểm tra

        // Gửi yêu cầu đến API để thêm tin nhắn vào cơ sở dữ liệu
        fetch(`http://localhost/web_ban_banh_kem/public/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                user_id: userId,  // ID của người dùng bạn đang chat
                content: messageContent,
                is_user_send: 0,  // Admin gửi tin nhắn
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server returned an error: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data);  // In ra response từ server để kiểm tra

            if (data.status === 'success') {
                // Sau khi gửi thành công, hiển thị tin nhắn
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', 'sent');
                messageDiv.innerText = messageContent;
                container.appendChild(messageDiv);

                input.value = '';
                container.scrollTop = container.scrollHeight;
            } else {
                console.error('Failed to send message:', data.message);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    }
}




// Add event listener for Enter key in message input
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});
function checkUnreadMessages() {
    // Gọi API để kiểm tra tin nhắn chưa đọc
    fetch('http://localhost/web_ban_banh_kem/public/checkUnreadMessages')
        .then(response => response.json())
        .then(data => {
            const unreadDot = document.getElementById('unreadDot');

            if (data.unreadCount > 0) {
                unreadDot.style.display = 'block'; // Hiển thị dot
            } else {
                unreadDot.style.display = 'none'; // Ẩn dot
            }
        })
        .catch(error => {
            console.error('Error checking unread messages:', error);
        });
}

        // Khởi tạo ban đầu
        handleDateRangeChange();
        checkUnreadMessages();
        
// Kiểm tra tin nhắn chưa đọc mỗi 10 giây
setInterval(checkUnreadMessages, 10000); 
setInterval(fetchUserList, 10000);
const templates = {
            'warning-speech': 'Kính nhắc quý khách: Vui lòng sử dụng ngôn từ văn minh, tôn trọng trong quá trình giao tiếp.',
            'general-notice': 'Thông báo: Hệ thống sẽ tiến hành bảo trì vào lúc 22:00 tối nay.',
            'special-promotion': 'KHUYẾN MÃI ĐẶC BIỆT: Giảm ngay 50% cho tất cả dịch vụ.'
        };

        document.getElementById('templateSelect').addEventListener('change', function() {
            const selectedTemplate = this.value;
            const contentTextarea = document.getElementById('notificationContent');
            
            contentTextarea.value = selectedTemplate ? templates[selectedTemplate] : '';
        });

        let selectedUsers = [];

        function toggleUserSelection(element) {
            const checkbox = element.querySelector('.user-checkbox');
            checkbox.checked = !checkbox.checked;
            
            const userName = element.textContent.trim();
            
            if (checkbox.checked) {
                if (!selectedUsers.includes(userName)) {
                    selectedUsers.push(userName);
                }
            } else {
                selectedUsers = selectedUsers.filter(user => user !== userName);
            }

            updateSelectedUsersList();
        }

        function updateSelectedUsersList() {
            const selectedUsersList = document.getElementById('selectedUsersList');
            
            if (selectedUsers.length === 0) {
                selectedUsersList.innerHTML = '<div class="no-users">Chưa có người dùng nào được chọn</div>';
            } else {
                selectedUsersList.innerHTML = selectedUsers.map(user => `
                    <div class="selected-user-item">
                        ${user}
                        <span class="notificationClose-btn" onclick="removeUser('${user}')">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                `).join('');
            }
        }

        function removeUser(userName) {
            selectedUsers = selectedUsers.filter(user => user !== userName);
            
            const userListItems = document.querySelectorAll('.user-list-item');
            userListItems.forEach(item => {
                if (item.textContent.trim() === userName) {
                    item.querySelector('.user-checkbox').checked = false;
                }
            });

            updateSelectedUsersList();
        }
        function deselectAllUsers() {
    // Làm rỗng danh sách người dùng đã chọn
    selectedUsers = [];

    // Bỏ chọn tất cả các checkbox
    const userListItems = document.querySelectorAll('.user-checkbox');
    userListItems.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Cập nhật giao diện danh sách người dùng được chọn
    updateSelectedUsersList();
}

        function selectUserGroup(group) {
    const userListItems = document.querySelectorAll('.notificationUser-list-item');
    
    userListItems.forEach(item => {
        const checkbox = item.querySelector('.user-checkbox');
        const userName = item.textContent.trim();

        if (group === 'all' || item.dataset.group === group) {
            checkbox.checked = true;

            // Thêm vào danh sách người dùng được chọn nếu chưa có
            if (!selectedUsers.includes(userName)) {
                selectedUsers.push(userName);
            }
        }
    });

    updateSelectedUsersList();
}


        function openNotificationModal() {
            document.getElementById('notificationModal').style.display = 'block';
        }

        function closeNotificationModal() {
            document.getElementById('notificationModal').style.display = 'none';
        }

        // Đóng modal khi click ngoài
        window.onclick = function(event) {
            const modal = document.getElementById('notificationModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
       
       

// Gọi hàm khi trang tải


// Tìm kiếm người dùng
document.querySelector('.form-control[placeholder="Tìm kiếm người dùng"]').addEventListener('input', function (e) {
    fetchNotificationUsers(e.target.value);
});
function fetchNotificationUsers(search = '') {
    fetch(`http://localhost/web_ban_banh_kem/public/api/users?search=${search}`)
        .then(response => response.json())
        .then(data => {
            const userList = document.getElementById('notificationUserList');
            userList.innerHTML = ''; // Xóa danh sách cũ

            // Kiểm tra nếu không có người dùng
            if (!data.users || data.users.length === 0) {
                userList.innerHTML = `
                    <div class="notificationUser-list-item">
                        Không tìm thấy người dùng nào.
                    </div>
                `;
                return;
            }

            // Duyệt qua danh sách người dùng và tạo các phần tử HTML
            data.users.forEach(user => {
                const userName = user.user_name || 'No name'; // Nếu không có user_name thì hiển thị 'No name'
                const role = user.role.charAt(0).toUpperCase() + user.role.slice(1); // Viết hoa chữ cái đầu role

                const userItem = document.createElement('div');
                userItem.classList.add('notificationUser-list-item');
                userItem.setAttribute('data-group', user.role);
                userItem.setAttribute('onclick', 'toggleUserSelection(this)');

                userItem.innerHTML = `
                    <input type="checkbox" class="user-checkbox" value="${user.id}">
                    ${role} - ${userName} - ${user.id}
                `;

                userList.appendChild(userItem);
            });
        })
        .catch(error => {
            console.error('Lỗi khi lấy danh sách người dùng:', error);
        });
}
fetchNotificationUsers();
function sendNotification() {
    // Lấy tất cả các item trong danh sách người dùng đã chọn
    const selectedUserItems = document.querySelectorAll('#selectedUsersList .selected-user-item');

    // Tạo mảng chứa các userId của người dùng đã chọn
    const selectedUserIds = [];
    selectedUserItems.forEach(item => {
        const userInfo = item.textContent.trim(); // Lấy toàn bộ thông tin người dùng (bao gồm cả tên, vai trò và ID)
        
        // Tách chuỗi theo dấu gạch ngang và lấy phần tử cuối cùng (ID)
        const userId = parseInt(userInfo.split(' - ')[2]); // Chuyển ID về dạng int
        selectedUserIds.push(userId);
    });

    // Kiểm tra nếu có người dùng được chọn
    if (selectedUserIds.length === 0) {
        alert('Chưa có người dùng nào được chọn.');
        return;
    }

    // Lấy loại thông báo
    const notificationType = document.querySelector('input[name="notificationType"]:checked').value;

    // Lấy nội dung thông báo
    const notificationContent = document.getElementById('notificationContent').value;

    // Kiểm tra nếu nội dung thông báo trống
    if (notificationContent.trim() === '') {
        alert('Vui lòng nhập nội dung thông báo.');
        return;
    }

    // Hiển thị xác nhận trước khi gửi thông báo
    const confirmation = confirm('Bạn có chắc chắn muốn gửi thông báo này đến các người dùng đã chọn?');
    if (!confirmation) {
        return;
    }

    // Lấy CSRF token từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Gửi thông báo (sử dụng fetch API để POST thông tin)
    const data = {
        user_ids: selectedUserIds, // Danh sách các user_id
        content: notificationContent, // Nội dung thông báo
        type: notificationType, // Loại thông báo
        is_user_read: 0, // Đánh dấu người dùng chưa đọc thông báo
    };

    fetch('http://localhost/web_ban_banh_kem/public/send-notification', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào header
        },
        body: JSON.stringify(data), // Chuyển đổi dữ liệu thành JSON
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Thông báo đã được gửi thành công!');
            closeNotificationModal(); // Đóng modal nếu gửi thành công
        } else {
            alert('Có lỗi xảy ra khi gửi thông báo. Vui lòng thử lại.');
        }
    })
    .catch(error => {
        console.error('Lỗi khi gửi thông báo:', error);
        alert('Có lỗi xảy ra khi gửi thông báo. Vui lòng thử lại.');
    });
}
document.getElementById('editProduct-image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('editProduct-image-preview');
            const noImageText = document.getElementById('editProduct-no-image');

            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    noImageText.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                noImageText.style.display = 'block';
            }
        });

        let currentProductId = null; // Khai báo biến toàn cục để lưu trữ id của sản phẩm

        function openEditUserModal(userId) {
    const modal = document.getElementById('editProductModal');
    modal.style.display = 'block';

    // Gửi yêu cầu lấy dữ liệu người dùng
    fetch(`http://localhost/web_ban_banh_kem/public/users/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Đổ dữ liệu vào các trường trong form
                document.getElementById('editUserId').value = data.data.id || '';
                document.getElementById('editUserName').value = data.data.user_name || '';
                document.getElementById('editMaBenhNhan').value = data.data.ma_benh_nhan || '';
                document.getElementById('editGioiTinh').value = data.data.gioi_tinh || '';
                document.getElementById('editNgaySinh').value = data.data.ngay_sinh || '';
                document.getElementById('editEmail').value = data.data.email || '';
                document.getElementById('editPhoneNumber').value = data.data.phone_number || '';
                document.getElementById('editAddress').value = data.data.address || '';
                document.getElementById('editRole').value = data.data.role || 'Khách Thường';
                document.getElementById('editSpecialOffer').value = data.data.special_offer || '';
                document.getElementById('editLoyaltyPoints').value = data.data.loyalty_points || '';
                document.getElementById('editIsBlock').value = data.data.is_block ? '1' : '0';

                // Hiển thị ảnh avatar nếu có
                const avatarPreview = document.getElementById('editProduct-image-preview');
                const noImageText = document.getElementById('editProduct-no-image');
                if (data.data.avatar) {
                    avatarPreview.src = `http://localhost/web_ban_banh_kem/public/${data.data.avatar}`; // Thay đổi đường dẫn theo thực tế
                    avatarPreview.style.display = 'block';
                    noImageText.style.display = 'none';
                } else {
                    avatarPreview.style.display = 'none';
                    noImageText.style.display = 'block';
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function closeEditProductModal() {
            const modal = document.getElementById('editProductModal');
            modal.style.display = 'none';
        }
        document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Ngăn chặn reload trang

    // Hiển thị hộp thoại xác nhận
    if (!confirm('Bạn có chắc chắn muốn lưu các thay đổi này không?')) {
        return; // Nếu người dùng chọn "Hủy", dừng thực hiện
    }

    const formData = new FormData(this);
    const userId = document.getElementById('editUserId').value;

    fetch(`http://localhost/web_ban_banh_kem/public/users/${userId}/update`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeEditProductModal(); // Đóng modal nếu thành công
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
// Hiện popup đổi mật khẩu
// Hiển thị popup đổi mật khẩu
function EditPassWordUser() {
    document.getElementById('editPasswordModal').style.display = 'flex';
}

// Đóng popup
function closeEditPasswordModal() {
    document.getElementById('editPasswordModal').style.display = 'none';
}

// Kiểm tra mật khẩu và gửi về server
// Hàm để gửi yêu cầu đổi mật khẩu
function changePassword() {
    const userId = document.getElementById('editUserId').value; // Lấy ID người dùng
    const newPassword = document.getElementById('newPassword').value; // Lấy mật khẩu mới
    const confirmPassword = document.getElementById('confirmPassword').value; // Lấy mật khẩu xác nhận

    // Kiểm tra xem mật khẩu và xác nhận mật khẩu có khớp không
    if (newPassword !== confirmPassword) {
        alert('Mật khẩu và xác nhận mật khẩu không khớp');
        return;
    }

    // Lấy CSRF token từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Gửi yêu cầu đổi mật khẩu tới backend
    const formData = new FormData();
    formData.append('id', userId);
    formData.append('password', newPassword); // Thêm mật khẩu mới vào form data

    fetch('http://localhost/web_ban_banh_kem/public/admin/change-password', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,  // Thêm CSRF token vào header
        },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Đổi mật khẩu thành công');
            closeEditPasswordModal(); // Đóng popup
        } else {
            alert('Đã có lỗi xảy ra');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Hàm mở modal đổi mật khẩu
function EditPassWordUser() {
    document.getElementById('editPasswordModal').style.display = 'block'; // Hiện popup đổi mật khẩu
}

// Hàm đóng popup đổi mật khẩu
function closeEditPasswordModal() {
    document.getElementById('editPasswordModal').style.display = 'none';
}
function togglePasswordVisibility(id) {
    const passwordField = document.getElementById(id);
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;
}



window.onclick = function(event) {
    const modal = document.getElementById('editPasswordModal');
    if (event.target === modal) {
        closeEditPasswordModal();
    }
};
let action = ''; // Biến lưu hành động (nạp tiền, rút tiền)

function topUp() {
    action = 'topUp'; // Lưu hành động nạp tiền
    openPinModal();
}

function withdraw() {
    action = 'withdraw'; // Lưu hành động rút tiền
    openPinModal();
}

function changePin() {
    action = 'changePin'; // Lưu hành động đổi mã PIN
    openPinModal();
}

// Mở modal nhập mã PIN
function openPinModal() {
    const modal = document.getElementById('pinModal');
    modal.style.display = 'block';
}

// Đóng modal nhập mã PIN
function closePinModal() {
    const modal = document.getElementById('pinModal');
    modal.style.display = 'none';
}
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Xác nhận mã PIN và thực hiện hành động
async function confirmPin() {
    const pin = document.getElementById('pin').value;
   

    // Kiểm tra mã PIN thực tế từ máy chủ
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Lấy CSRF token

        const response = await fetch('http://localhost/web_ban_banh_kem/public/api/check-pin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào header
            },
            body: JSON.stringify({
                card_id: card_id, // Mã thẻ
                pin: pin,         // Mã PIN nhập vào
            }),
        });

        const result = await response.json();

        if (response.ok && result.valid) {
            alert('Mã PIN hợp lệ! Thực hiện hành động: ' + action);
            closePinModal();
            document.getElementById('pin').value = ''; // Xóa mã PIN sau khi nhập đúng

            // Hiển thị modal nạp/rút tiền
            if (action === 'topUp' || action === 'withdraw') {
                openMoneyModal(action);
            } else if (action === 'changePin') {
                console.log('Đổi mã PIN...');
            }
        } else {
            alert('Mã PIN không hợp lệ! Vui lòng thử lại.');
        }
    } catch (error) {
        console.error('Lỗi khi xác thực mã PIN:', error);
        alert('Đã xảy ra lỗi khi xác thực mã PIN. Vui lòng thử lại sau.');
    }
}


function openMoneyModal(action) {
    // Tạo modal nạp/rút tiền
    const modalContent = `
        <h3>${action === 'topUp' ? 'Nạp Tiền' : 'Rút Tiền'}</h3>
        <input type="number" id="amount" placeholder="Nhập số tiền" />
        ${
            action === 'withdraw'
                ? `
            <div class="amount-buttons">
                <button onclick="selectAmount(50000)">50.000</button>
                <button onclick="selectAmount(100000)">100.000</button>
                <button onclick="selectAmount(300000)">300.000</button>
                <button onclick="selectAmount(500000)">500.000</button>
            </div>
            `
                : ''
        }
        <button class="submit-btn" onclick="submitMoney('${action}')">Xác nhận</button>
    `;

    const modal = document.createElement('div');
    modal.classList.add('money-modal');
    modal.innerHTML = modalContent;

    document.body.appendChild(modal);
    modal.style.display = 'block';

    // Đóng modal khi bấm ra ngoài
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.remove();
        }
    });
}

function selectAmount(amount) {
    document.getElementById('amount').value = amount; // Gán số tiền vào ô nhập
}

async function submitMoney(action) {
    const amount = parseFloat(document.getElementById('amount').value);

    // Kiểm tra số tiền hợp lệ
    if (!amount || amount <= 0) {
        alert('Vui lòng nhập số tiền hợp lệ!');
        return;
    }

    // Lấy `card_id` từ biến đã được khai báo bên ngoài
     // Đảm bảo biến này đã được khởi tạo đúng cách

    try {
        // Xác định URL endpoint dựa trên hành động
        const endpoint = action === 'topUp' 
            ? '/top-up' 
            : '/withdraw';

        // Gửi yêu cầu đến API
        const response = await fetch(`http://localhost/web_ban_banh_kem/public${endpoint}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                card_id: card_id,
                amount: amount,
            }),
        });

        const result = await response.json();

        if (response.ok) {
            alert(`${action === 'topUp' ? 'Nạp tiền' : 'Rút tiền'} thành công! Số dư mới: ${result.new_balance}`);
        } else {
            alert(result.error || 'Đã xảy ra lỗi khi thực hiện giao dịch.');
        }
    } catch (error) {
        console.error('Lỗi khi thực hiện giao dịch:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    }

    // Đóng modal sau khi hoàn thành
    const modal = document.querySelector('.money-modal');
    if (modal) modal.remove();
}
function openUserHistoryModal() {
    document.getElementById('userHistoryModal').classList.remove('hidden');
    fetchUserHistory(); // Tải dữ liệu lịch sử khi mở modal
}

function closeUserHistoryModal() {
    document.getElementById('userHistoryModal').classList.add('hidden');
}

async function fetchUserHistory(page = 1) {
    const actionFilter = document.getElementById('actionFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;

    // Gọi API để lấy dữ liệu từ server
    const response = await fetch(`http://localhost/web_ban_banh_kem/public/log-users?page=${page}&action=${actionFilter}&date=${dateFilter}`);
    const data = await response.json();

    const contentElement = document.getElementById('userHistoryContent');
    contentElement.innerHTML = ''; // Reset nội dung cũ

    data.logs.forEach(log => {
        const logItem = document.createElement('div');
        logItem.classList.add('userhistory-item');
        logItem.innerHTML = `
            <p><strong>Hành động:</strong> ${log.action}</p>
            <p><strong>Nội dung:</strong> ${log.action_content}</p>
            <p><strong>Người thực hiện:</strong> ${log.admin_id}</p>
            <p><strong>Thời gian:</strong> ${log.created_at}</p>
        `;
        contentElement.appendChild(logItem);
    });

    // Thêm nút điều hướng nếu có nhiều trang
    if (data.has_more_pages) {
        const loadMoreButton = document.createElement('button');
        loadMoreButton.textContent = 'Tải thêm';
        loadMoreButton.onclick = () => fetchUserHistory(page + 1);
        contentElement.appendChild(loadMoreButton);
    }
}
fetch('http://localhost/web_ban_banh_kem/public/admin-info')
        .then(response => response.json())
        .then(data => {
            // Cập nhật thông tin admin vào HTML
            document.getElementById('admin_name').textContent = data.user_name +' - '+ data.admin_id;
            document.getElementById('admin_role').textContent = `Vai trò: ${data.role}`;
        })
        .catch(error => {
            console.error('Có lỗi khi lấy dữ liệu admin:', error);
        });
    </script>
</body>
</html>