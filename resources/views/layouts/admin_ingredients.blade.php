<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .stat-card {
            position: relative;
            
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .stat-card.blue { border-top: 4px solid #3498db; }
        .stat-card.green { border-top: 4px solid #2ecc71; }
        .stat-card.orange { border-top: 4px solid #f39c12; }
        .stat-card.red { border-top: 4px solid #e74c3c; }
        .stat-card.yellow { border-top: 4px solid #FFFF33; }
        .stat-card.pink { border-top: 4px solid #FFCCFF; }
        .stat-card.gray { border-top: 4px solid #888888; }
        .stat-card.LightCyan3 { border-top: 4px solid #B4CDCD; }




        .stat-value {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .chart-container {
            background: white;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .data-tables {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
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
        .main-content {
    padding: 20px;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}

/* Style cho toolbar buttons */
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
/* Modal Styles */
.modal {
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

.modal-content {
    background-color: #fefefe;
    margin: 10% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    border-radius: 10px;
    position: relative;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #333;
}

.close-btn:hover {
    color: #000;
}
.stats-grid {
    display: flex; /* Sử dụng Flexbox để bố trí ngang */
    justify-content: space-between; /* Cách đều các phần tử */
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 20px; /* Khoảng cách giữa các card */
    margin-bottom: 30px;
}

.stat-card {
    flex: 1; /* Cho phép mỗi card có độ rộng bằng nhau */
    min-width: 200px; /* Đảm bảo mỗi card có chiều rộng tối thiểu */
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-card h3 {
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
}

.stat-card .value {
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

.stat-card .trend {
    font-size: 12px;
    margin-top: 5px;
}

.stat-card .trend.negative {
    color: #dc3545; /* Màu đỏ */
}

.stat-card .trend.positive {
    color: #28a745; /* Màu xanh */
}

/* CSS cho xu hướng */
.trend {
    font-weight: bold;
    font-size: 16px;
    margin-top: 10px;
}

.trend.positive {
    color: #28a745; /* Màu xanh lá cho xu hướng tăng */
}

.trend.negative {
    color: #dc3545; /* Màu đỏ cho xu hướng giảm */
}

.trend.neutral {
    color: #6c757d; /* Màu xám cho xu hướng ổn định */
}

/* Thêm một số kiểu dáng cho các giá trị của sản phẩm */
.stat-card {
    background-color: #f8f9fc;
    border-radius: 8px;
    padding: 20px;
    margin: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
}

.value {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

.chart-container {
    margin-top: 30px;
}

.chart-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
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
.excel-options {
    position: absolute;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

.excel-options button {
    display: block;
    background: none;
    border: none;
    padding: 10px 20px;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.excel-options button:hover {
    background-color: #f5f5f5;
}
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

     /* Modal container */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3); /* Mờ nền */
    justify-content: center;
    align-items: center;
    padding: 20px;
    z-index: 9999;
    overflow: auto; /* Cho phép cuộn */
}

/* Modal content */
.modal-content {
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    width: 85%;
    max-width: 1200px;
    max-height: 90%; /* Giới hạn chiều cao modal */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow-y: auto; /* Cho phép cuộn dọc */
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Modal header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5em;
    color: #333;
    font-weight: 600;
}

/* Nút đóng */
.close-btn {
    font-size: 24px;
    background: none;
    border: none;
    color: #aaa;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #e74c3c; /* Màu đỏ khi hover */
}

/* Bộ lọc */
.filter-section {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    width: calc(33% - 20px);
}

.filter-group label {
    font-size: 1em;
    color: #333;
    margin-bottom: 8px;
    font-weight: 500;
}

.filter-group select, .filter-group input {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1em;
    width: 100%;
    box-sizing: border-box;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.filter-group select:focus, .filter-group input:focus {
    border-color: #3498db;
    background-color: #fff;
    outline: none;
}

/* Thống kê tổng quan */
.stats-row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    width: 23%;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #333;
}

.stat-card .value {
    font-size: 1.5em;
    font-weight: 600;
    color: #2d3e50;
    margin-bottom: 10px;
}

.trend-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1em;
    color: #27ae60;
}

.trend-indicator i {
    margin-right: 5px;
}

.trend-indicator.trend-down {
    color: #e74c3c;
}

/* Biểu đồ */
.charts-grid {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 40px;
}

.chart-container {
    flex: 1;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.chart-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.chart-container h3 {
    font-size: 1.2em;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}

.chart-tabs {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.chart-tab {
    background-color: #3498db;
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

.chart-tab:hover {
    background-color: #2980b9;
}

.chart-tab.active {
    background-color: #2980b9;
}

/* Sản phẩm bán chạy */
.top-products-section, .inventory-section {
    margin-bottom: 40px;
}

.top-products-table, .inventory-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.top-products-table th, .inventory-table th {
    background-color: #3498db;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
}

.top-products-table td, .inventory-table td {
    padding: 10px;
    border-top: 1px solid #f0f0f0;
}

.top-products-table tr:hover, .inventory-table tr:hover {
    background-color: #f5f5f5;
}

.top-products-table th, .inventory-table th {
    text-transform: uppercase;
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-group {
        width: 100%;
    }

    .stats-row, .charts-grid {
        flex-direction: column;
    }

    .stat-card {
        width: 100%;
    }

    .chart-container {
        margin-bottom: 20px;
    }
}
.suggestion-table {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .table-content {
            background-color: #fefefe;
            margin: 2% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .data-table th {
            background-color: #f4f4f4;
            position: sticky;
            top: 0;
        }

        .data-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .warning {
            background-color: #fff3cd !important;
        }

        .danger {
            background-color: #f8d7da !important;
        }

      

        .export-btn {
            float: right;
            margin: 10px;
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .filter-section select, .filter-section input {
            margin-right: 10px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

      

     

        .error {
            color: red;
            margin-top: 10px;
        }

        .checkbox-cell {
            text-align: center;
        }

        .import-btn {
            margin-top: 20px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .file-input {
            margin: 20px 0;
        }
        /* Modal Lịch sử */
#modalHistory {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
    padding-top: 60px;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Điều chỉnh chiều rộng modal */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Lọc thời gian và thao tác */
.history-filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.history-filters label {
    margin-right: 10px;
}

.history-filters input,
.history-filters select,
.history-filters button {
    padding: 8px;
}

/* Bảng lịch sử */
.history-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.history-table th, .history-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.history-table th {
    background-color: #f2f2f2;
}

.history-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.history-table tr:hover {
    background-color: #f1f1f1;
}

/* Button Lọc */
.btn-filter {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.btn-filter:hover {
    background-color: #45a049;
}
.addProductModal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.addProductModal .modal-content {
  background-color: white;
  margin: 10% auto;
  padding: 20px;
  border-radius: 10px;
  max-width: 500px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}

.addProductModal .modal-content h2 {
  text-align: center;
  margin-bottom: 20px;
}

.addProductModal .form-group {
  margin-bottom: 15px;
}

.addProductModal .form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.addProductModal .form-group input, 
.addProductModal .form-group select, 
.addProductModal .form-group textarea, 
.addProductModal .form-group button {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.addProductModal .form-group button {
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

.addProductModal .form-group button:hover {
  background-color: #0056b3;
}

.addProductModal .close {
  position: absolute;
  right: 20px;
  top: 20px;
  font-size: 24px;
  cursor: pointer;
}
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input, .form-group select, .form-group textarea, .form-group button {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.form-group button {
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

.form-group button:hover {
  background-color: #0056b3;
}

.close {
  position: absolute;
  right: 20px;
  top: 20px;
  font-size: 24px;
  cursor: pointer;
}
/* Modal container styling */
.addProductModal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.addProductModal .modal-content {
  background-color: white;
  margin: 5% auto;
  padding: 20px;
  border-radius: 10px;
  max-width: 800px; /* Tăng chiều rộng */
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.addProductModal .modal-body {
  display: flex;
  gap: 20px; /* Khoảng cách giữa cột trái và phải */
}

/* Cột bên trái */
.left-column {
  flex: 3; /* Chiếm 3 phần không gian */
}

/* Cột bên phải */
.right-column {
  flex: 1; /* Chiếm 1 phần không gian */
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  border-left: 1px solid #ddd; /* Đường chia cột */
  padding-left: 20px;
}

.right-column img {
  max-width: 100%;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-top: 10px;
}

/* Form styling */
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input, 
.form-group select, 
.form-group textarea, 
.form-group button {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.form-group button {
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
}

.form-group button:hover {
  background-color: #0056b3;
}

.addProductModal .close {
  position: absolute;
  right: 20px;
  top: 20px;
  font-size: 24px;
  cursor: pointer;
}
/* Modal hiển thị nội dung Excel */
.addProductExcelModal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.addProductExcelModal .modal-content {
  background-color: white;
  margin: 5% auto;
  padding: 20px;
  border-radius: 10px;
  max-width: 900px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
}

.addProductExcelModal table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.addProductExcelModal th, .addProductExcelModal td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
}

.addProductExcelModal th {
  background-color: #f9f9f9;
}

.addProductExcelModal input[type="checkbox"] {
  cursor: pointer;
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
            max-width: 800px;
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
            grid-template-columns: repeat(2, 1fr);
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
        .productHistory-modal {
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

        .productHistory-modal-content {
            background-color: #ffffff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 1000px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .productHistory-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .productHistory-filter-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .productHistory-filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .productHistory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .productHistory-table th, 
        .productHistory-table td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: left;
        }

        .productHistory-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .productHistory-action-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .productHistory-action-add { 
            background-color: #4CAF50; 
            color: white;
        }

        .productHistory-action-update { 
            background-color: #2196F3; 
            color: white;
        }

        .productHistory-action-import { 
            background-color: #FF9800; 
            color: white;
        }

        .productHistory-action-delete { 
            background-color: #F44336; 
            color: white;
        }

        .productHistory-action-store-multiple { 
            background-color: #9C27B0; 
            color: white;
        }

        .productHistory-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }

        .productHistory-pagination button {
            background-color: #f0f0f0;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .productHistory-pagination button:hover {
            background-color: #e0e0e0;
        }

        .productHistory-pagination button:disabled {
            background-color: #f0f0f0;
            cursor: not-allowed;
        }
        .productHistory-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Đảm bảo bảng có chiều rộng cố định */
}

.productHistory-table th,
.productHistory-table td {
    word-wrap: break-word; /* Tự động xuống dòng khi quá dài */
    overflow-wrap: break-word; /* Hỗ trợ các trình duyệt khác */
    white-space: normal; /* Cho phép xuống dòng */
    padding: 8px; /* Khoảng cách giữa nội dung và viền ô */
    text-align: left; /* Canh trái nội dung */
    border: 1px solid #ddd; /* Viền giữa các ô */
}

.productHistory-table th {
    background-color: #f4f4f4; /* Màu nền cho tiêu đề */
    font-weight: bold; /* In đậm tiêu đề */
}
.submenu {
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

.trash-button {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 18px;
    cursor: pointer;
    color: #d9534f;
}
.menu-item .arrow {
    position: absolute; /* Định vị mũi tên */
    right: 10px; /* Căn lề phải */
    top: 50%;
    transform: translateY(-50%); /* Căn giữa theo chiều dọc */
    font-size: 16px;
    color: #ffffff; /* Màu mũi tên */
    pointer-events: none; /* Không làm ảnh hưởng khi người dùng nhấp vào menu */
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
.food-suggest-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.food-suggest-modal-content {
    background-color: white;
    padding: 20px;
    margin: 50px auto;
    width: 80%;
    max-width: 1200px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.suggestion-part {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}

.product-list {
    width: 45%;
    padding: 10px;
    border-right: 2px solid #ddd;
}

.product-details {
    width: 45%;
    padding: 10px;
}

.product-list ul {
    list-style: none;
    padding: 0;
}

.product-list li {
    margin: 5px 0;
    cursor: pointer;
}

.product-list li:hover {
    text-decoration: underline;
}

button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.close-modal-btn {
    background-color: red;
    position: absolute;
    top: 10px;
    right: 10px;
}
.food-suggest-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền bán trong suốt */
    z-index: 9999;
}

.food-suggest-modal-content {
    background-color: white;
    width: 80%;
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.suggestion-part {
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.product-list {
    width: 45%;
    max-height: 400px;
    overflow-y: auto;
    border-right: 1px solid #ddd;
    padding-right: 20px;
}

.product-list h3 {
    text-align: center;
    margin-bottom: 20px;
}

.product-details {
    width: 50%;
    padding-left: 20px;
}

.product-details h3 {
    text-align: center;
    margin-bottom: 20px;
}

.product-details input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.close-modal-btn {
    padding: 10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.close-modal-btn:hover {
    background-color: darkred;
}
.product-list ul {
    list-style-type: none;
    padding: 0;
}

.product-list li {
    padding: 10px;
    margin: 10px 0;
    background-color: #f4f4f4;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.product-list li:hover {
    background-color: #e0e0e0;
}

.product-list li.selected {
    background-color: #4CAF50;
    color: white;
}

.no-suggestion {
    color: red;
    font-style: italic;
}

.product-details {
    width: 50%;
    padding-left: 20px;
}

.product-details h3 {
    text-align: center;
    margin-bottom: 20px;
}

.product-details input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.product-details .warning {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}





.close-modal-btn {
    padding: 10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.close-modal-btn:hover {
    background-color: darkred;
}

.excel-options {
    position: absolute;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

.excel-options button {
    display: block;
    background: none;
    border: none;
    padding: 10px 20px;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.excel-options button:hover {
    background-color: #f5f5f5;
}
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
/* Cài đặt cho toàn bộ modal */
.nutritionmodal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
    z-index: 9999; /* Đảm bảo modal xuất hiện trên các thành phần khác */
    align-items: center;
    justify-content: center;
}

/* Nội dung modal */
.nutritionmodal-content {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    position: relative;
}

/* Tiêu đề modal */
.nutritionmodal-content h4 {
    font-size: 20px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: bold;
}

/* Các ô nhập */
.input-field {
    margin-bottom: 15px;
}

.input-field label {
    font-weight: bold;
    color: #333;
}

.input-field input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.input-field input:focus {
    border-color: #007bff;
    outline: none;
}

/* Nút Lưu */
button.btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button.btn:hover {
    background-color: #0056b3;
}

/* Nút đóng */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #333;
    cursor: pointer;
}
 /* Đặt kiểu chung cho các nút */
 .btnIngredient-edit, .btnIngredient-delete {
        display: inline-block;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Nút "Sửa" */
    .btnIngredient-edit {
        background-color: #007bff; /* Màu xanh dương */
        color: #fff; /* Màu chữ trắng */
    }

    .btnIngredient-edit:hover {
        background-color: #0056b3; /* Màu xanh dương đậm hơn khi hover */
        box-shadow: 0 2px 6px rgba(0, 123, 255, 0.4);
    }

    /* Nút "Xóa" */
    .btnIngredient-delete {
        background-color: #dc3545; /* Màu đỏ */
        color: #fff; /* Màu chữ trắng */
    }

    .btnIngredient-delete:hover {
        background-color: #b02a37; /* Màu đỏ đậm hơn khi hover */
        box-shadow: 0 2px 6px rgba(220, 53, 69, 0.4);
    }

    /* Hiệu ứng khi nhấn nút */
    .btnIngredient-edit:active, .btnIngredient-delete:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }
.close:hover {
    color: #007bff;
}
/* Cài đặt cho toàn bộ modal */
.nutritionmodal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
    z-index: 9999; /* Đảm bảo modal xuất hiện trên các thành phần khác */
    align-items: center;
    justify-content: center;
}

/* Nội dung modal */
.nutritionmodal-content {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    position: relative;
    text-align: center;
}

/* Tiêu đề modal */
.nutritionmodal-content h4 {
    font-size: 20px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: bold;
}

/* Tên sản phẩm */
#productName {
    font-size: 18px;
    color: #333;
}

/* Các ô nhập */
.input-field {
    margin-bottom: 15px;
}

.input-field label {
    font-weight: bold;
    color: #333;
}

.input-field input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.input-field input:focus {
    border-color: #007bff;
    outline: none;
}

/* Nút Lưu */
button.btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button.btn:hover {
    background-color: #0056b3;
}

/* Nút đóng */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #333;
    cursor: pointer;
}

.close:hover {
    color: #007bff;
}
/* Modal nền */
.modal {
    display: none; /* Ẩn mặc định */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4); /* Màu nền mờ */
}

/* Nội dung modal */
.modal-content {
    background-color: #fff;
    margin: 10% auto; /* Canh giữa */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 400px; /* Độ rộng */
    position: relative;
}

/* Tiêu đề modal */
.modal-content h3 {
    margin-top: 0;
    color: #007bff;
}

/* Form và input */
.modal-content label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #333;
}

.modal-content input {
    width: calc(100% - 20px);
    padding: 8px 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Nút lưu và hủy */
.modal-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.modal-buttons button {
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
}

#saveIngredient {
    background-color: #007bff;
    color: #fff;
}

#saveIngredient:hover {
    background-color: #0056b3;
}

#cancelEdit {
    background-color: #dc3545;
    color: #fff;
}

#cancelEdit:hover {
    background-color: #b02a37;
}

/* Nút đóng modal */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}

.close:hover {
    color: #007bff;
}/* Nút Kích hoạt không sẵn sàng */
.btnIngredient-disable {
    background-color: #ff4d4d; /* Màu đỏ */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btnIngredient-disable:hover {
    background-color: #ff3333; /* Đổi màu khi hover */
}

/* Nút Kích hoạt sẵn sàng */
.btnIngredient-enable {
    background-color: #4CAF50; /* Màu xanh lá cây */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btnIngredient-enable:hover {
    background-color: #45a049; /* Đổi màu khi hover */
}

/* Modal */
/* Modal */
/* Modal */
.addingredient-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s ease;
}

.addingredient-modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 500px;
    position: relative;
    animation: slideIn 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.addingredient-close {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #666;
}

.addingredient-close:hover {
    color: #333;
}

.addingredient-form-group {
    margin-bottom: 15px;
}

.addingredient-form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.addingredient-form-group input,
.addingredient-form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.addingredient-buttons {
    margin-top: 20px;
    text-align: right;
}

.addingredient-save-btn,
.addingredient-cancel-btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    margin-left: 10px;
}

.addingredient-save-btn {
    background-color: #4CAF50;
    color: white;
}

.addingredient-cancel-btn {
    background-color: #f44336;
    color: white;
}

.addingredient-save-btn:hover {
    background-color: #45a049;
}

.addingredient-cancel-btn:hover {
    background-color: #da190b;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slideIn {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
/* Modal styling */
/* Cấu trúc của modal */
.addingredient-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Modal Content */
.addingredient-modal-content {
    position: relative;
    background-color: #fff;
    margin: 2% auto;
    width: 90%;
    max-width: 1200px;
    border-radius: 12px;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
    animation: slideDown 0.4s ease-out;
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Close Button */
.addingredient-close {
    position: absolute;
    right: 20px;
    top: 15px;
    font-size: 28px;
    font-weight: bold;
    color: #666;
    cursor: pointer;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.addingredient-close:hover {
    background-color: #f0f0f0;
    color: #333;
    transform: rotate(90deg);
}

/* Modal Header */
.addingredient-modal-content h2 {
    margin: 0;
    padding: 20px 25px;
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
    border-bottom: 1px solid #eee;
    background-color: #f8f9fa;
    border-radius: 12px 12px 0 0;
}

/* Modal Body */
.modal-body {
    display: flex;
    padding: 25px;
    gap: 30px;
    min-height: 400px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Product List */
.product-list {
    flex: 0 0 40%;
    border-right: 1px solid #e9ecef;
    padding-right: 20px;
    overflow-y: auto;
}

.product-list::-webkit-scrollbar {
    width: 6px;
}

.product-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.product-list::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

/* Ingredient Form */
.ingredient-form {
    flex: 0 0 60%;
    padding-left: 20px;
}

/* Modal Footer */
.modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background-color: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

/* Buttons */
/* Modal Container */
.addingredient-modal {
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

/* Modal Content */
.addingredient-modal-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    padding: 20px;
}

/* Close Button */
.addingredient-close {
    position: absolute;
    right: 20px;
    top: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    transition: color 0.3s ease;
}

.addingredient-close:hover {
    color: #333;
}

/* Modal Header */
.addingredient-modal-content h2 {
    margin: 0 0 20px 0;
    color: #333;
    font-size: 1.5rem;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}

/* Modal Body */
.modal-body {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

/* Product List Section */
.product-list {
    flex: 1;
    min-width: 250px;
    border-right: 1px solid #eee;
    padding-right: 20px;
    max-height: 500px;
    overflow-y: auto;
}

.product-item {
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
}

.product-item:hover {
    background-color: #e9ecef;
    transform: translateX(5px);
}

.product-item.unadded {
    border-color: #ffc107;
    background-color: #fff8e1;
}

.product-item small {
    color: #dc3545;
    font-size: 0.85em;
    display: block;
    margin-top: 5px;
}

/* Ingredient Form Section */
.ingredient-form {
    flex: 2;
    padding: 0 10px;
}

.ingredient-input {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 15px;
    padding: 12px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

.ingredient-input label {
    min-width: 150px;
    color: #495057;
}

.ingredient-input input[type="number"],
.ingredient-input select {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.ingredient-input input[type="number"]:focus,
.ingredient-input select:focus {
    outline: none;
    border-color: #80bdff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

/* Buttons */
.ingredient-input button,
.modal-footer button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.ingredient-input button {
    background-color: #dc3545;
    color: white;
}

.ingredient-input button:hover {
    background-color: #c82333;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.save-btn {
    background-color: #28a745;
    color: white;
}

.save-btn:hover {
    background-color: #218838;
}

.cancel-btn {
    background-color: #6c757d;
    color: white;
}

.cancel-btn:hover {
    background-color: #5a6268;
}

/* Scrollbar Styling */
.product-list::-webkit-scrollbar,
.addingredient-modal-content::-webkit-scrollbar {
    width: 8px;
}

.product-list::-webkit-scrollbar-track,
.addingredient-modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.product-list::-webkit-scrollbar-thumb,
.addingredient-modal-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.product-list::-webkit-scrollbar-thumb:hover,
.addingredient-modal-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.addingredient-modal {
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

/* Modal Content - Tăng kích thước tối đa */
.addingredient-modal-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 95%; /* Tăng từ 90% lên 95% */
    max-width: 1200px; /* Tăng từ 800px lên 1200px */
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    padding: 20px;
}
.product-item {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    cursor: pointer;
}

.product-item.selected {
    background-color: #4CAF50;  /* Màu nền khi chọn */
    color: white;  /* Màu chữ khi chọn */
}

.product-item.unadded {
    background-color: #f2f2f2;
}

.product-item:hover {
    background-color: #f1f1f1;
}
.product-item.unadded {
    color: red; /* Màu chữ cho sản phẩm chưa có nguyên liệu */
    background-color: #f8d7da; /* Màu nền cho sản phẩm chưa có nguyên liệu */
}

.product-item.selected {
    border: 2px solid blue; /* Đổi màu viền cho sản phẩm được chọn */
}
.search-input {
    width: 250px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
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
    <!-- Header với title và user info cùng hàng -->
    <div class="page-header">
    <div class="page-title">
    <h2>Quản Lý Nguyên Liệu</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
    <div class="toolbar">
    

    
    <!-- Thêm 2 nút mới -->
    <button class="toolbar-btn" onclick="openAddingredientModal()">
    <i class="fas fa-plus-circle"></i> Thêm nguyên liệu
  </button>
  <button class="toolbar-btn" onclick="openAddIngredientForProductModal()">
    <i class="fas fa-plus-circle"></i> Nguyên Liệu - Thực phẩm
  </button>
    <button class="toolbar-btn" onclick="openHistoryModal()">
        <i class="fas fa-history"></i> Lịch sử
    </button>
</div>


    <!-- Controls row với hiển thị và tìm kiếm cùng hàng -->
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
            <input type="text" class="search-box" placeholder="Tìm kiếm nguyên liệu...">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>

    <!-- Bộ điều khiển bên phải -->
    <div class="right-controls">
        <!-- Bộ lọc danh mục -->
        <div class="category-filter">
            <label>Danh mục:</label>
            <select id="categoryFilter">
                <option value="all">Tất cả</option>
                <option value="1">Gia vị</option>
                <option value="2">Nguyên liệu chính</option>
                <option value="3">Phụ gia</option>
            </select>
        </div>

        <!-- Bộ lọc sắp xếp -->
        <div class="sort-options">
            <label>Sắp xếp:</label>
            <select id="sortOption">
                <option value="date_desc">Ngày thêm (Mới nhất)</option>
                <option value="date_asc">Ngày thêm (Cũ nhất)</option>
                <option value="active">Sẵn sàng</option>
                <option value="inactive">Không sẵn sàng</option>
            </select>
        </div>
    </div>
</div>

<!-- Bảng -->
<table>
    <thead>
        <tr>
            <th class="checkbox-cell"><input type="checkbox"></th>
       
            <th>Mã</th>
            <th>Tên</th>
            <th>Đơn vị</th>
            <th>Trạng thái</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="ingredientTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>

<!-- Phân trang -->
<div id="pagination" class="pagination-controls">
    <!-- Nút phân trang sẽ được tạo động -->
</div>

<!-- Hiển thị phân trang -->

<!-- Modal chỉnh sửa thông tin gia vị -->
<div id="editIngredientModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Chỉnh sửa gia vị</h3>
        <form id="editIngredientForm">
            <label for="ingredientName">Tên gia vị:</label>
            <input type="text" id="ingredientName" name="ingredientName" placeholder="Nhập tên gia vị">
            
            <label for="ingredientUnit">Đơn vị:</label>
            <input type="text" id="ingredientUnit" name="ingredientUnit" placeholder="Nhập đơn vị gia vị">

            <div class="modal-buttons">
                <button type="button" id="saveIngredient">Lưu</button>
                <button type="button" id="cancelEdit">Hủy</button>
            </div>
        </form>
    </div>
</div>
<!-- Nút để mở Modal -->


<!-- Modal -->
<div id="addingredientModal" class="addingredient-modal">
    <div class="addingredient-modal-content">
        <span class="addingredient-close" onclick="closeAddingredientModal()">&times;</span>
        <h2>Thêm nguyên liệu</h2>
        <form id="addingredientForm">
            <div class="addingredient-form-group">
                <label for="addIngredientName">Tên nguyên liệu</label>
                <input type="text" id="addIngredientName" name="ingredientName" required>
            </div>

            <div class="addingredient-form-group">
                <label for="ingredientUnit">Đơn vị</label>
                <select id="addIngredientUnit" name="ingredientUnit" required>
    <option value="gram">Grams (gram)</option> <!-- Gram -->
    <option value="kg">Kilograms (kg)</option> <!-- Kilogram -->
    <option value="ml">Milliliters (ml)</option> <!-- Milliliters -->
    <option value="l">Liters (L)</option> <!-- Liter -->
    <option value="pcs">Pieces (pcs)</option> <!-- Piece -->
    <option value="mg">Milligrams (mg)</option> <!-- Milligram -->
    <option value="cl">Centiliters (cl)</option> <!-- Centiliter -->
    <option value="mL">Milliliters (mL)</option> <!-- Milliliters -->
    <option value="oz">Ounces (oz)</option> <!-- Ounces -->
    <option value="tbsp">Tablespoons (tbsp)</option> <!-- Tablespoons -->
    <option value="tsp">Teaspoons (tsp)</option> <!-- Teaspoon -->
</select>

            </div>

            <div class="addingredient-form-group">
                <label for="ingredientStatus">Trạng thái</label>
                <select id="ingredientStatus" name="ingredientStatus" required>
                    <option value="active">Sẵn sàng</option>
                    <option value="inactive">Không sẵn sàng</option>
                </select>
            </div>

            <div class="addingredient-buttons">
                <button type="submit" class="addingredient-save-btn">Lưu</button>
                <button type="button" class="addingredient-cancel-btn" onclick="closeAddingredientModal()">Hủy</button>
            </div>
        </form>
    </div>
</div>
<div id="addIngredientForProductModal" class="addingredient-modal">
    <div class="addingredient-modal-content">
        <span class="addingredient-close" onclick="closeAddIngredientForProductModal()">&times;</span>
        <h2>Thêm Nguyên Liệu Cho Sản Phẩm</h2>
        <input type="text" id="searchProductInput" placeholder="Tìm kiếm sản phẩm..." 
    onkeyup="searchProducts()" 
    style="width: 200px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; 
           box-sizing: border-box; transition: all 0.3s ease; outline: none;">


        <div class="modal-body">
            <!-- Ô tìm kiếm -->
           
            
            <!-- Danh sách sản phẩm -->
            <div id="productList" class="product-list">
            <input type="text" id="searchProductInput" placeholder="Tìm kiếm sản phẩm..." onkeyup="searchProducts()">
                <!-- Danh sách các sản phẩm sẽ được hiển thị ở đây -->
            </div>

            <!-- Hiển thị các ô nhập nguyên liệu cho sản phẩm -->
            <div id="ingredientForm" class="ingredient-form">
                <!-- Các ô nhập nguyên liệu sẽ được thêm vào ở đây -->
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="save-btn" onclick="saveIngredients()">Lưu</button>
            <button type="button" class="cancel-btn" onclick="closeAddIngredientForProductModal()">Hủy</button>
        </div>
    </div>
</div>


</div>
   
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
        })
      
   
        document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const sortOption = document.getElementById('sortOption');
    const searchBox = document.querySelector('.search-box');
    const displayLimit = document.getElementById('displayLimit');
    const ingredientTable = document.getElementById('ingredientTable');

    let currentPage = 1; // Theo dõi trang hiện tại

    function fetchIngredients() {
        const category = categoryFilter.value;
        const sort = sortOption.value;
        const search = searchBox.value.trim();
        const limit = displayLimit.value;

        // Gửi yêu cầu AJAX đến API
        fetch(`http://localhost/web_ban_banh_kem/public/api/ingredients?category=${category}&sort=${sort}&search=${search}&limit=${limit}&page=${currentPage}`)
            .then(response => response.json())
            .then(data => {
                // Xóa dữ liệu bảng cũ
                ingredientTable.innerHTML = '';

                // Duyệt qua danh sách nguyên liệu và thêm vào bảng
                data.data.forEach(ingredient => {
                    const row = document.createElement('tr');

                    // Dựa trên trạng thái, chọn nút phù hợp
                    const actionButton = ingredient.status === 'active'
                        ? `<button class="btnIngredient-disable" data-id="${ingredient.id}">Kích hoạt không sẵn sàng</button>`
                        : `<button class="btnIngredient-enable" data-id="${ingredient.id}">Kích hoạt sẵn sàng</button>`;

                    row.innerHTML = `
                        <td class="checkbox-cell"><input type="checkbox"></td>
                        <td>${ingredient.id || 'N/A'}</td>
                        <td>${ingredient.name}</td>
                        <td>${ingredient.unit}</td>
                        <td>${ingredient.status === 'active' ? 'Sẵn sàng' : 'Không sẵn sàng'}</td>
                        <td>
                            <button class="btnIngredient-edit" data-id="${ingredient.id}">Sửa</button>
                            ${actionButton}
                        </td>
                    `;

                    ingredientTable.appendChild(row);
                });

                // Cập nhật phân trang
                updatePagination(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    function updatePagination(data) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        // Tạo nút phân trang
        for (let i = 1; i <= data.last_page; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.className = i === data.current_page ? 'active' : '';
            button.addEventListener('click', () => {
                currentPage = i;
                fetchIngredients();
            });
            pagination.appendChild(button);
        }
    }

    // Lắng nghe sự kiện thay đổi trên các bộ lọc và tìm kiếm
    categoryFilter.addEventListener('change', fetchIngredients);
    sortOption.addEventListener('change', fetchIngredients);
    displayLimit.addEventListener('change', fetchIngredients);
    searchBox.addEventListener('input', () => {
        currentPage = 1; // Reset về trang đầu
        fetchIngredients();
    });

    // Lắng nghe sự kiện click cho các nút hành động
    ingredientTable.addEventListener('click', function (e) {
        const target = e.target;

        if (target.classList.contains('btnIngredient-disable')) {
            const ingredientId = target.dataset.id;

            // Gửi yêu cầu để chuyển trạng thái về không sẵn sàng
            fetch(`http://localhost/web_ban_banh_kem/public/ingredients/${ingredientId}/deactivate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Trạng thái đã chuyển thành không sẵn sàng.');
                        fetchIngredients(); // Cập nhật lại bảng
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                });
        } else if (target.classList.contains('btnIngredient-enable')) {
            const ingredientId = target.dataset.id;

            // Gửi yêu cầu để chuyển trạng thái về sẵn sàng
            fetch(`http://localhost/web_ban_banh_kem/public/ingredients/${ingredientId}/activate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Trạng thái đã chuyển thành sẵn sàng.');
                        fetchIngredients(); // Cập nhật lại bảng
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                });
        }
    });

    // Tải dữ liệu ban đầu
    fetchIngredients();
});


// Khi người dùng click nút "Sửa"
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('btnIngredient-edit')) {
        const row = e.target.closest('tr'); // Lấy hàng tương ứng
        const ingredientId = row.children[1].textContent; // Lấy ID từ cột thứ hai
        const ingredientName = row.children[2].textContent; // Lấy tên từ cột thứ ba
        const ingredientUnit = row.children[3].textContent; // Lấy đơn vị từ cột thứ tư

        // Hiển thị modal với thông tin gia vị
        const modal = document.getElementById('editIngredientModal');
        modal.style.display = 'block';

        // Điền thông tin gia vị vào form
        document.getElementById('ingredientName').value = ingredientName;
        document.getElementById('ingredientUnit').value = ingredientUnit;

        // Khi nhấn nút "Lưu"
        document.getElementById('saveIngredient').onclick = function () {
            const updatedName = document.getElementById('ingredientName').value;
            const updatedUnit = document.getElementById('ingredientUnit').value;

            // Lấy CSRF token từ meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Gửi API cập nhật
            fetch(`http://localhost/web_ban_banh_kem/public/ingredients/update/${ingredientId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào headers
                },
                body: JSON.stringify({
                    name: updatedName,
                    unit: updatedUnit,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Cập nhật thành công!');
                        // Cập nhật lại dữ liệu trên giao diện
                        row.children[2].textContent = updatedName;
                        row.children[3].textContent = updatedUnit;
                        modal.style.display = 'none'; // Đóng modal
                    } else {
                        alert('Cập nhật thất bại!');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        };

        // Khi nhấn nút "Hủy"
        document.getElementById('cancelEdit').onclick = function () {
            modal.style.display = 'none';
        };

        // Đóng modal khi nhấn vào nút "X"
        modal.querySelector('.close').onclick = function () {
            modal.style.display = 'none';
        };

        // Đóng modal khi click bên ngoài modal
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    }
});
// Mở modal thêm nguyên liệu
// Mở modal
function openAddingredientModal() {
    const modal = document.getElementById('addingredientModal');
    modal.style.display = 'block';  // Hiển thị modal
}

// Đóng modal
function closeAddingredientModal() {
    const modal = document.getElementById('addingredientModal');
    modal.style.display = 'none';  // Ẩn modal
}

// Đóng modal khi click bên ngoài modal
window.onclick = function(event) {
    const modal = document.getElementById('addingredientModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}


// Xử lý sự kiện khi nhấn nút "Lưu"
document.getElementById('addingredientForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Ngừng việc gửi form mặc định

    const ingredientName = document.getElementById('addIngredientName').value;
    const ingredientUnit = document.getElementById('addIngredientUnit').value;
    const ingredientStatus = document.getElementById('ingredientStatus').value;

    // Gửi dữ liệu qua API
    fetch('http://localhost/web_ban_banh_kem/public/add-ingredients', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: ingredientName,
            unit: ingredientUnit,
            status: ingredientStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thêm nguyên liệu thành công!');
            closeAddingredientModal(); // Đóng modal
            // Cập nhật lại danh sách nguyên liệu ở giao diện (nếu cần)
        } else {
            // Hiển thị thông báo chi tiết từ server
            alert(data.message); // Đây là thông báo lỗi từ server, ví dụ "Gia vị này đã tồn tại!"
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
});
// Hàm mở modal
function openAddIngredientForProductModal() {
    document.getElementById('addIngredientForProductModal').style.display = 'flex';
    fetchProducts();
}

// Hàm đóng modal
function closeAddIngredientForProductModal() {
    document.getElementById('addIngredientForProductModal').style.display = 'none';
}

// Mở Modal
// Fetch danh sách sản phẩm từ API và hiển thị
function fetchProducts() {
    fetch('http://localhost/web_ban_banh_kem/public/ingredient-products')
        .then(response => response.json())
        .then(products => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';  // Xóa dữ liệu cũ

            // Phân loại sản phẩm chưa có nguyên liệu và có nguyên liệu
            const noIngredients = products.filter(product => product.ingredients.length === 0);
            const withIngredients = products.filter(product => product.ingredients.length > 0);

            // Hiển thị sản phẩm chưa có nguyên liệu lên trên
            noIngredients.forEach(product => {
                const productItem = document.createElement('div');
                productItem.classList.add('product-item');
                productItem.classList.add('unadded'); // Thêm lớp cho sản phẩm chưa có nguyên liệu
                productItem.innerHTML = `<span>${product.name}</span>`;
                productItem.setAttribute('data-id', product.id); // Thêm data-id
                productItem.onclick = () => {
                    showIngredientForm(product.id);
                    highlightSelectedItem(productItem);  // Đổi màu khi chọn sản phẩm
                };
                productItem.innerHTML += `<small> - Chưa thêm nguyên liệu</small>`;
                productList.appendChild(productItem);
            });

            // Hiển thị sản phẩm có nguyên liệu
            withIngredients.forEach(product => {
                const productItem = document.createElement('div');
                productItem.classList.add('product-item');
                productItem.innerHTML = `<span>${product.name}</span>`;
                productItem.setAttribute('data-id', product.id); // Thêm data-id
                productItem.onclick = () => {
                    showIngredientForm(product.id);
                    highlightSelectedItem(productItem);  // Đổi màu khi chọn sản phẩm
                };
                productList.appendChild(productItem);
            });
        });
}

// Hàm thay đổi màu sắc sản phẩm được chọn
function highlightSelectedItem(productItem) {
    const allProductItems = document.querySelectorAll('.product-item');
    allProductItems.forEach(item => {
        item.classList.remove('selected');  // Gỡ bỏ lớp màu ở tất cả sản phẩm
    });

    // Thêm lớp màu cho sản phẩm được chọn
    productItem.classList.add('selected');
}


function searchProducts() {
    const searchTerm = document.getElementById('searchProductInput').value.toLowerCase();
    const productItems = document.querySelectorAll('.product-item');
    
    productItems.forEach(item => {
        const productName = item.querySelector('span').textContent.toLowerCase();
        const productId = item.getAttribute('data-id'); // Thêm data-id cho các sản phẩm

        if (productName.includes(searchTerm) || productId.includes(searchTerm)) {
            item.style.display = 'block';  // Hiển thị sản phẩm nếu tìm thấy
        } else {
            item.style.display = 'none';  // Ẩn sản phẩm nếu không tìm thấy
        }
    });
}

// Hàm hiển thị các ô nhập nguyên liệu cho sản phẩm
function showIngredientForm(productId) {
    const ingredientForm = document.getElementById('ingredientForm');
    ingredientForm.innerHTML = '';  // Xóa dữ liệu cũ

    // Fetch nguyên liệu của sản phẩm
    fetch(`http://localhost/web_ban_banh_kem/public/products/${productId}/ingredients`)
        .then(response => response.json())
        .then(data => {
            const ingredients = data.ingredients;
            
            // Nếu sản phẩm đã có nguyên liệu, hiển thị nguyên liệu hiện tại
            ingredients.forEach(ingredient => {
    const inputGroup = document.createElement('div');
    inputGroup.classList.add('ingredient-input');
    inputGroup.innerHTML = `
        <label>${ingredient.name} (${ingredient.unit})</label> <!-- Hiển thị tên và đơn vị -->
        <input type="number" placeholder="Số lượng" id="quantity-${ingredient.id}" value="${ingredient.pivot.quantity}">
       <button onclick="updateIngredient(${productId}, ${ingredient.id})" 
    style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; 
           font-size: 16px; cursor: pointer; transition: background-color 0.3s ease;">
    Cập nhật
</button>

        <button onclick="removeIngredient(${productId}, ${ingredient.id})">Xóa</button>
      
    `;
    ingredientForm.appendChild(inputGroup);
});


            // Hiển thị ô nhập nguyên liệu mới
            const addNewIngredientGroup = document.createElement('div');
            addNewIngredientGroup.classList.add('ingredient-input');
            addNewIngredientGroup.innerHTML = `
                <label>Chọn nguyên liệu mới</label>
                <select id="newIngredient">
                    <option value="">Chọn nguyên liệu...</option>
                    <!-- Các nguyên liệu có thể thêm vào sẽ được load ở đây -->
                </select>
                <input type="number" id="newQuantity" placeholder="Số lượng">
                <button onclick="addIngredientToProduct(${productId})">Thêm nguyên liệu</button>
            `;
            ingredientForm.appendChild(addNewIngredientGroup);

            // Fetch danh sách nguyên liệu có sẵn từ DB để hiển thị cho ô chọn nguyên liệu mới
            fetch('http://localhost/web_ban_banh_kem/public/list-ingredients')  // Lấy danh sách nguyên liệu
                .then(response => response.json())
                .then(data => {
                    const ingredientSelect = document.getElementById('newIngredient');
                    data.ingredients.forEach(ingredient => {
                        const option = document.createElement('option');
                        option.value = ingredient.id;
                        option.textContent = `${ingredient.name} (${ingredient.unit})`;  // Hiển thị tên và đơn vị
                        ingredientSelect.appendChild(option);
                    });
                });
        })
        .catch(error => {
            console.error('Error fetching product ingredients:', error);
        });
}

// Thêm nguyên liệu vào sản phẩm
function addIngredientToProduct(productId) {
    const newIngredientId = document.getElementById('newIngredient').value;
    const newQuantity = document.getElementById('newQuantity').value;  // Đảm bảo sử dụng đúng biến

    if (!newIngredientId || !newQuantity) {
        alert('Vui lòng chọn nguyên liệu và nhập số lượng.');
        return;
    }

    fetch(`http://localhost/web_ban_banh_kem/public/products/${productId}/add-productingredients`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ingredients: [{
                ingredientId: newIngredientId,
                quantity: newQuantity
            }]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thêm nguyên liệu thành công!');
            showIngredientForm(productId); // Cập nhật lại form nhập nguyên liệu
        } else {
            alert('Thêm nguyên liệu thất bại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}

// Xóa nguyên liệu khỏi sản phẩm
function removeIngredient(productId, ingredientId) {
    fetch(`http://localhost/web_ban_banh_kem/public/products/${productId}/remove-Productingredient/${ingredientId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Xóa nguyên liệu thành công!');
            showIngredientForm(productId); // Cập nhật lại form nhập nguyên liệu
        } else {
            alert('Xóa nguyên liệu thất bại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}

function updateIngredient(productId, ingredientId) {
    const quantity = document.getElementById(`quantity-${ingredientId}`).value;

    if (!quantity || isNaN(quantity) || quantity <= 0) {
        alert('Vui lòng nhập số lượng hợp lệ!');
        return;
    }

    // Gửi yêu cầu cập nhật số lượng nguyên liệu
    fetch(`http://localhost/web_ban_banh_kem/public/products/${productId}/add-productingredients`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cập nhật nguyên liệu thành công!');
            showIngredientForm(productId);  // Cập nhật lại form
        } else {
            alert('Cập nhật nguyên liệu thất bại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}
function updateIngredient(productId, ingredientId) {
    const quantity = document.getElementById(`quantity-${ingredientId}`).value;

    if (!quantity || isNaN(quantity) || quantity <= 0) {
        alert('Vui lòng nhập số lượng hợp lệ!');
        return;
    }

    fetch(`http://localhost/web_ban_banh_kem/public/products/${productId}/ingredients/${ingredientId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cập nhật nguyên liệu thành công!');
            showIngredientForm(productId);  // Cập nhật lại form
        } else {
            alert('Cập nhật nguyên liệu thất bại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
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