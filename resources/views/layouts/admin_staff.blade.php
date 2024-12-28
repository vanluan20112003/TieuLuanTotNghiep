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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard</title>
    <style>
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
.permission-group {
    margin-bottom: 10px;
}

.permission-group label {
    margin-right: 10px;
}

/* Switch styles */
.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 50px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 12px;
    width: 12px;
    border-radius: 50px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}

input:checked + .slider {
    background-color: #4CAF50;
}

input:checked + .slider:before {
    transform: translateX(14px);
}

/* Mở rộng phần quyền */
.permission-toggle {
    cursor: pointer;
    color: #007bff;
    font-weight: bold;
    margin-bottom: 10px;
}

.toggle-arrow {
    margin-left: 10px;
    transition: transform 0.3s ease;
}

.permission-details {
    margin-left: 20px;
    margin-top: 10px;
}

/* Đảo chiều mũi tên khi mở rộng */
.permission-toggle.open .toggle-arrow {
    transform: rotate(90deg);
}
/* Style cho nút tác vụ */
.action-dropdown {
    position: relative;
    display: inline-block;
}

.action-button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.action-button i {
    color: #333;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    min-width: 100px;
    padding: 10px 0;
    border-radius: 5px;
}

.dropdown-menu a {
    color: black;
    padding: 8px 12px;
    text-decoration: none;
    display: block;
}

.dropdown-menu a:hover {
    background-color: #ddd;
}

/* Hiển thị menu khi hover */
.action-dropdown:hover .dropdown-menu {
    display: block;
}
:root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-light: #f7f9fc;
            --text-color: #333;
        }
.staff-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .staff-modal-container {
            background: white;
            width: 900px;
            max-height: 80vh;
            display: flex;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .staff-modal-left {
            width: 40%;
            padding: 30px;
            background: var(--background-light);
            border-right: 1px solid #e1e4e8;
        }

        .staff-modal-right {
            width: 60%;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .staff-input-group {
            margin-bottom: 15px;
        }

        .staff-input-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 600;
        }

        .staff-input-group input, 
        .staff-input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .staff-input-group input:focus, 
        .staff-input-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .staff-permissions-section {
            background: white;
            border-radius: 8px;
            border: 1px solid #e1e4e8;
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
        }

        .staff-permission-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f5;
        }

        .staff-permission-item:last-child {
            border-bottom: none;
        }

        .staff-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .staff-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .staff-switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .staff-switch-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .staff-switch input:checked + .staff-switch-slider {
            background-color: var(--secondary-color);
        }

        .staff-switch input:checked + .staff-switch-slider:before {
            transform: translateX(26px);
        }

        .staff-user-search {
            display: flex;
            margin-bottom: 15px;
        }

        .staff-search-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px 0 0 6px;
        }

        .staff-search-button {
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .staff-search-button:hover {
            background-color: #2980b9;
        }

        .staff-user-list {
            border: 1px solid #ddd;
            border-radius: 8px;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .staff-user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f1f3f5;
            transition: background-color 0.3s ease;
        }

        .staff-user-item:hover {
            background-color: #f1f3f5;
        }

        .staff-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            color: #888;
            font-size: 24px;
        }
        .staff-modal-footer {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}

.staff-modal-close-btn, .staff-modal-save-btn {
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
}

.staff-modal-save-btn {
    background-color: #4CAF50;
    color: white;
}

.staff-modal-close-btn {
    background-color: #f44336;
    color: white;
}
.staff-user-item:hover {
    background-color: #f1f1f1;
}

.staff-user-item.selected {
    background-color: #4CAF50; /* Màu xanh lá khi được chọn */
    color: #ffffff;
    font-weight: bold;
}
/* Overlay */
.editstaff-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

/* Modal Content */
.editstaff-modal-content {
    background-color: #fff;
    border-radius: 8px;
    width: 400px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.3s ease-in-out;
}

/* Header */
.editstaff-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.editstaff-modal-header h2 {
    font-size: 20px;
    margin: 0;
    color: #333;
}

.editstaff-close-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #333;
    transition: color 0.3s;
}

.editstaff-close-btn:hover {
    color: #ff0000;
}

/* Form */
.editstaff-form-group {
    margin-bottom: 15px;
}

.editstaff-form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.editstaff-input,
.editstaff-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
}

.editstaff-input:focus,
.editstaff-select:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
}

/* Footer Buttons */
.editstaff-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.editstaff-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.editstaff-save {
    background-color: #007bff;
    color: #fff;
    transition: background-color 0.3s;
}

.editstaff-save:hover {
    background-color: #0056b3;
}

.editstaff-close {
    background-color: #f5f5f5;
    color: #333;
    transition: background-color 0.3s;
}

.editstaff-close:hover {
    background-color: #ddd;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

a {
    text-decoration: none; /* Bỏ gạch chân mặc định của thẻ <a> */
    color: inherit; /* Kế thừa màu sắc từ phần tử cha */
}

a:hover {
    color: inherit; /* Giữ màu sắc khi hover */
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
/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Filter buttons */
.filters {
    margin-bottom: 20px;
}

.filters select, .filters input {
    padding: 5px;
    margin-right: 10px;
}

.filters .btn-filter {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.filters .btn-filter:hover {
    background-color: #0056b3;
}

/* Log item */
.log-list {
    margin-top: 20px;
}

.log-item {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.log-item p {
    margin: 5px 0;
}

.log-item strong {
    font-weight: bold;
}
/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Filter buttons */
.filters {
    margin-bottom: 20px;
}

.filters select, .filters input {
    padding: 5px;
    margin-right: 10px;
}

.filters .btn-filter {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.filters .btn-filter:hover {
    background-color: #0056b3;
}

/* Log item */
.log-list {
    margin-top: 20px;
}

.log-item {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.log-item p {
    margin: 5px 0;
}

.log-item strong {
    font-weight: bold;
}
/* Modal */
.staff-detail-history-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.staff-detail-history-modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Close Button */
.staff-detail-history-close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.staff-detail-history-close:hover,
.staff-detail-history-close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Filters */
.staff-detail-history-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.staff-detail-history-filters label {
    font-weight: bold;
}

.staff-detail-history-filters input,
.staff-detail-history-filters select {
    padding: 5px;
    margin-left: 10px;
    width: 200px;
}

.staff-detail-history-btn-filter {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Logs List */
.staff-detail-history-list {
    margin-top: 20px;
}

.staff-detail-history-log-item {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    border-radius: 4px;
    background-color: #f9f9f9;
}

.staff-detail-history-log-item p {
    margin: 5px 0;
}
/* Modal container */
.staff-detail-history-modal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    z-index: 1000; /* Đảm bảo modal luôn ở trên cùng */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Cho phép cuộn nếu nội dung dài */
    background-color: rgba(0, 0, 0, 0.5); /* Hiệu ứng overlay */
}

/* Modal content */
.staff-detail-history-modal-content {
    background-color: #fff;
    margin: 5% auto; /* Căn giữa theo chiều dọc */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 80%; /* Chiều rộng modal */
    max-width: 600px; /* Đặt chiều rộng tối đa */
    max-height: 80%; /* Đặt chiều cao tối đa */
    overflow-y: auto; /* Cho phép cuộn theo chiều dọc nếu nội dung dài */
}

/* Close button */
.staff-detail-history-close {
    color: #333;
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

.staff-detail-history-close:hover,
.staff-detail-history-close:focus {
    color: #ff0000; /* Đổi màu khi hover hoặc focus */
}

/* Title */
.staff-detail-history-modal-content h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 1.5em;
    font-weight: bold;
}

/* Filters section */
.staff-detail-history-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    align-items: center;
    justify-content: center;
}

.staff-detail-history-filters label {
    font-weight: bold;
    color: #555;
}

.staff-detail-history-filters input[type="date"],
.staff-detail-history-filters select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.staff-detail-history-btn-filter {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.staff-detail-history-btn-filter:hover {
    background-color: #0056b3;
}

/* Logs content section */
.staff-detail-history-list {
    max-height: 60vh; /* Giới hạn chiều cao của danh sách */
    overflow-y: auto; /* Cuộn theo chiều dọc */
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.staff-detail-history-log-item {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    font-size: 14px;
    color: #333;
}

.staff-detail-history-log-item:last-child {
    border-bottom: none;
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
    <h2>Quản Lý Nhân Viên</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
    <div class="toolbar">
    <button class="toolbar-btn excel-export-btn">
        <i class="fas fa-file-excel"></i> Xuất Excel
    </button>
    <div class="excel-options" style="display: none;">
        <button id="exportAll">In tất cả</button>
        <button id="exportSelected">In đã chọn</button>
    </div>
    <button class="toolbar-btn importBtn">
        <i class="fas fa-clipboard-list"></i> Thêm nhân viên mới
    </button>
   
    <button class="toolbar-btn" onclick="openModalStatic()">
        <i class="fas fa-chart-bar"></i> Thống kê
    </button>

    <!-- Thêm 2 nút mới -->
  
    <button class="toolbar-btn" onclick="openStaffHistoryModal()">
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
            <input type="text" class="search-box" placeholder="Tìm kiếm sản phẩm...">
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
                <option value="NV">Nhân Viên</option>
                <option value="QL">Nhân Viên</option>
                <option value="AD">Admin</option>

            </select>
        </div>

        <!-- Bộ lọc theo sắp xếp -->
        <div class="sort-options">
            <label>Sắp xếp:</label>
            <select id="sortOption">
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Ngày thêm (Mới nhất)</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Ngày thêm (Cũ nhất)</option>
                <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Đánh giá (Cao nhất)</option>
                <option value="rating_asc" {{ request('sort') == 'rating_asc' ? 'selected' : '' }}>Đánh giá (Thấp nhất)</option>
            </select>
        </div>

    </div>
</div>


    <!-- Table -->
   
   <table>
    <thead>
        <tr>
            <th class="checkbox-cell"><input type="checkbox"></th>
            <th class="image-cell">Ảnh</th>
            <th>Mã nhân viên</th>
            <th>Tên nhân viên</th>
            <th>Chức vụ </th>
            <th>Các quyền đã cấp</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="adminTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>
<div class="staff-modal-overlay">
    <div class="staff-modal-container">
        <!-- Close Button -->
        <span class="staff-modal-close">&times;</span>

        <!-- Left Side -->
        <div class="staff-modal-left">
            <div class="staff-input-group">
                <label>Mã Nhân Viên</label>
                <input type="text" id="staff-id" placeholder="Nhập mã nhân viên" required>
            </div>
            
            <div class="staff-input-group">
                <label>Vai Trò</label>
                <select id="staff-role">
                    <option value="NV">Nhân Viên</option>
                    <option value="QL">Quản Lý</option>
                    <option value="Ad">Admin</option>
                </select>
            </div>

            <div class="staff-permissions-section">
                <div class="staff-permission-item">
                    <span>Quản lý sản phẩm</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_products">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý người dùng</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_users">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý nhân viên</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_staff">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý khuyến mãi</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_promotions">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý bài viết</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_posts">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý đơn hàng</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_orders">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý đặt bàn</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_reservations">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý tài chính</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_finance">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
                <div class="staff-permission-item">
                    <span>Quản lý hệ thống</span>
                    <label class="staff-switch">
                        <input type="checkbox" data-permission="manage_system">
                        <span class="staff-switch-slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="staff-modal-right">
            <div class="staff-user-search">
                <input type="text" class="staff-search-input" placeholder="Tìm kiếm nhân viên...">
                <button class="staff-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="staff-user-list">
                <!-- User list will be dynamically populated -->
                <div class="staff-user-item">
                    <span>NV001 - Nguyễn Văn A</span>
                    <span>Nhân Viên</span>
                </div>
                <div class="staff-user-item">
                    <span>QL002 - Trần Thị B</span>
                    <span>Quản Lý</span>
                </div>
            </div>
            <div class="staff-modal-footer">
    <button class="staff-modal-close-btn">Close</button>
    <button class="staff-modal-save-btn">Lưu</button>
</div>
        </div>

        <!-- Footer with Save Button -->
     
          
    
    </div>
    
</div>
<!-- Modal -->
<div id="editstaff-modal" class="editstaff-modal">
    <div class="editstaff-modal-content">
        <div class="editstaff-modal-header">
            <h2>Chỉnh sửa nhân viên</h2>
            <button class="editstaff-close-btn">&times;</button>
        </div>
        <div class="editstaff-modal-body">
            <form id="editstaff-form">
                <!-- Mã nhân viên -->
                <div class="editstaff-form-group">
                    <label for="editstaff-id">Mã nhân viên</label>
                    <input type="text" id="editstaff-id" class="editstaff-input" placeholder="Nhập mã nhân viên" required />
                </div>
                <!-- Chức vụ -->
                <div class="editstaff-form-group">
                    <label for="editstaff-role">Chức vụ</label>
                    <select id="editstaff-role" class="editstaff-select">
                        <option value="NV">Nhân Viên</option>
                        <option value="QL">Quản Lí</option>
                        <option value="Ad">Admin</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="editstaff-modal-footer">
            <button id="editstaff-save-btn" class="editstaff-btn editstaff-save">Lưu</button>
            <button id="editstaff-close-btn" class="editstaff-btn editstaff-close">Đóng</button>
            <!-- Thêm nút Tắt quyền Admin -->
            <button id="editstaff-revoke-admin-btn" class="editstaff-btn editstaff-revoke-admin">Tắt quyền quản trị</button>
        </div>
    </div>
</div>
<div id="staffHistoryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeStaffHistoryModal()">&times;</span>
        <h2>Lịch sử Hoạt Động Admin</h2>

        <!-- Filters -->
        <div class="filters">
            <label for="actionFilter">Chọn thao tác:</label>
            <select id="actionFilter">
                <option value="">Tất cả</option>
                <option value="add">Thêm</option>
                <option value="update">Cập nhật</option>
                <option value="delete">Xóa</option>
            </select>

            <label for="dateFilter">Chọn ngày:</label>
            <input type="date" id="dateFilter">

            <button class="btn-filter" onclick="fetchLogs()">Lọc</button>
        </div>

        <!-- Logs Content -->
        <div id="logList" class="log-list">
            <!-- Logs sẽ được hiển thị ở đây -->
        </div>
    </div>
</div>
<div id="staffDetailHistoryModal" class="staff-detail-history-modal">
    <div class="staff-detail-history-modal-content">
        <span class="staff-detail-history-close" onclick="closeStaffDetailHistoryModal()">&times;</span>
        <h2>Lịch sử Thao Tác Admin</h2>

        <!-- Filters -->
        <div class="staff-detail-history-filters">
            <label for="actionFilter">Chọn thao tác:</label>
            <select id="actionDetailFilter">
    <option value="">Tất cả</option>
    <option value="add">Thêm</option>
    <option value="update">Cập nhật</option>
    <option value="delete">Xóa</option>
</select>

            <label for="startDateFilter">Chọn ngày bắt đầu:</label>
            <input type="date" id="startDateFilter">

            <label for="endDateFilter">Chọn ngày kết thúc:</label>
            <input type="date" id="endDateFilter">

            <button class="staff-detail-history-btn-filter" onclick="fetchStaffDetailHistory1()">Lọc</button>
        </div>

        <!-- Logs Content -->
        <div id="staffDetailHistoryList" class="staff-detail-history-list">
            <!-- Logs sẽ được hiển thị ở đây -->
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
      


// Toggle dropdown menu
function toggleDropdown(button) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => {
        if (dropdown !== button.nextElementSibling) {
            dropdown.classList.remove('show');
        }
    });
    button.nextElementSibling.classList.toggle('show');
}

function togglePermissions(element) {
    const details = element.nextElementSibling; // Lấy phần quyền chi tiết
    const isOpen = details.style.display === 'block';

    // Ẩn/hiện phần quyền
    details.style.display = isOpen ? 'none' : 'block';
    
    // Đảo chiều mũi tên
    if (isOpen) {
        element.classList.remove('open');
    } else {
        element.classList.add('open');
    }
}

$(document).ready(function () {
    // Gọi API để lấy dữ liệu admin
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/api/admins',
        method: 'GET',
        success: function (data) {
            const tableBody = $('#adminTable');
            tableBody.empty();

            // Hiển thị dữ liệu admin vào bảng
            $.each(data, function (index, admin) {
                let permissionsHtml = `
                    <div class="permission-toggle" onclick="togglePermissions(this)">
                        <span>Các quyền đã cấp</span>
                        <span class="toggle-arrow">&#x25B6;</span>
                    </div>
                    <div class="permission-details" style="display:none;">`;

                const permissions = [
                    { name: 'Quản lý sản phẩm', value: admin.manage_products },
                    { name: 'Quản lý người dùng', value: admin.manage_users },
                    { name: 'Quản lý nhân viên', value: admin.manage_staff },
                    { name: 'Quản lý khuyến mãi', value: admin.manage_promotions },
                    { name: 'Quản lý bài viết', value: admin.manage_posts },
                    { name: 'Quản lý đơn hàng', value: admin.manage_orders },
                    { name: 'Quản lý đặt bàn', value: admin.manage_reservations },
                    { name: 'Quản lý tài chính', value: admin.manage_finance },

                    { name: 'Quản lý hệ thống', value: admin.manage_system }
                ];

                $.each(permissions, function (i, permission) {
                    permissionsHtml += `
                        <div class="permission-group">
                            <label>${permission.name}</label>
                            <label class="switch">
                                <input type="checkbox" ${permission.value ? 'checked' : ''}>
                                <span class="slider round"></span>
                            </label>
                        </div>`;
                });

                permissionsHtml += `</div>`;

                tableBody.append(`
                    <tr>
                        <td><input type="checkbox" class="main-checkbox"></td>
                        <td><img src="http://localhost/web_ban_banh_kem/public/${admin.user.avatar}" width="50"></td>
                        <td>${admin.id}</td>
                        <td>${admin.user.name}</td>
                        <td>${admin.role}</td>
                        <td>${permissionsHtml}</td>
                           <td>
                            <div class="action-dropdown">
                                <button class="action-button" onclick="toggleDropdown(this)">
                                    <i class="fas fa-ellipsis-v"></i> <!-- Icon 3 dấu chấm -->
                                </button>
                                <div class="dropdown-menu">
                                   
                            <button class="editstaff-edit-btn" onclick="openEditStaffModal('${admin.id}')">
    <i class="fas fa-edit"></i> Sửa
</button>
                                    
                                    <button class="toolbar-btn" onclick="openStaffDetailHistoryModal(${admin.user_id})">
    <i class="fas fa-history"></i> Lịch sử
</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            });
            attachCheckboxEvents() ;
            attachSwitchEvents();
              // Đóng modal khi nhấn vào dấu X
    $('.staff-modal-close').on('click', function () {
        $('.staff-modal-overlay').hide();  // Ẩn modal
    });

    // Đóng modal khi nhấn vào nút Close ở Footer
    $('.staff-modal-close-btn').on('click', function () {
        $('.staff-modal-overlay').hide();  // Ẩn modal
    });

    // Xử lý lưu thông tin khi nhấn nút "Lưu"
    $('.staff-modal-save-btn').on('click', function () {
    const staffId = $('#staff-id').val();  // Mã nhân viên (staffId) vẫn lấy từ input
    const staffRole = $('#staff-role').val();
    const permissions = [];
    
    // Lấy các quyền được chọn
    $('.staff-switch input:checked').each(function () {
        permissions.push($(this).data('permission'));
    });

    // Sử dụng user_id từ biến đã có sẵn thay vì lấy từ input
    const userId = user_id; // user_id được lấy từ biến
    console.log(userId); // Kiểm tra userId
    console.log(permissions);
    console.log(staffId );
    // Kiểm tra xem user_id đã có trong bảng admin chưa
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/admins/check-existence', // Đường dẫn API để kiểm tra
        method: 'GET',
        data: { user_id: userId },
        success: function (response) {
            if (response.exists) {
                // Nếu admin đã tồn tại, hỏi người dùng có muốn khôi phục chức năng admin không
                const confirmRestore = confirm("Admin đã tồn tại, bạn có muốn khôi phục chức năng admin cho user này?");
                if (confirmRestore) {
                    // Cập nhật bảng users, set is_admin = 1
                    $.ajax({
    url: 'http://localhost/web_ban_banh_kem/public/users/update-admin-status',
    method: 'POST',
    data: { user_id: userId, is_admin: 1 },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (updateResponse) {
        alert(updateResponse.message || "Cập nhật thành công.");
        // Cập nhật bảng admin với các quyền hạn
        updateAdminPermissions(staffId, permissions);
    },
    error: function (xhr) {
        // Hiển thị lỗi cụ thể từ server (nếu có)
        if (xhr.responseJSON && xhr.responseJSON.message) {
            alert("Lỗi: " + xhr.responseJSON.message);
        } else {
            alert("Có lỗi xảy ra khi cập nhật trạng thái admin.");
        }
        console.error("Error updating user admin status:", xhr);
    }
});


                }
            } else {
                let roleValue = '';

switch (staffRole) {
    case 'QL':
        roleValue = 'Quản Lý';
        break;
    case 'NV':
        roleValue = 'Nhân Viên';
        break;
    case 'Ad':
        roleValue = 'Admin';
        break;
    default:
        roleValue = ''; // Nếu không có giá trị phù hợp
}
                // Nếu user_id chưa có, thêm mới admin
                $.ajax({
    url: 'http://localhost/web_ban_banh_kem/public/admins/add', // Đường dẫn API để thêm admin
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Lấy CSRF token từ meta tag và thêm vào header
    },
    data: {
        staff_id: staffId, // Truyền staff_id
        user_id: userId, // Sử dụng userId để thêm mới admin
        role: roleValue,
        permissions: permissions
    },
    success: function (addResponse) {
        // Kiểm tra trạng thái thành công từ response
        if (addResponse.success) {
            // Cập nhật bảng users, set is_admin = 1
            $.ajax({
                url: 'http://localhost/web_ban_banh_kem/public/users/update-admin-status', // Cập nhật is_admin cho user
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Lấy CSRF token từ meta tag
                },
                data: { user_id: userId, is_admin: 1 },
                success: function () {
                    alert("Đã thêm Admin mới.");
                    $('.staff-modal-overlay').hide(); // Ẩn modal
                },
                error: function (error) {
                    console.error("Error updating user admin status:", error);
                    if (error.responseJSON && error.responseJSON.message) {
                        alert("Lỗi khi cập nhật trạng thái admin: " + error.responseJSON.message);
                    } else {
                        alert("Lỗi không xác định khi cập nhật trạng thái admin.");
                    }
                }
            });
        } else {
            alert("Không thể thêm admin: " + addResponse.message);
        }
    },
    error: function (error) {
        console.error("Error adding admin:", error);
        if (error.responseJSON && error.responseJSON.message) {
            alert("Lỗi: " + error.responseJSON.message); // Hiển thị thông báo lỗi cụ thể từ API
        } else {
            alert("Có lỗi xảy ra khi thêm admin.");
        }
    }
});

            }
        },
        error: function (error) {
            console.error('Error checking admin existence:', error);
        }
    });
});

// Hàm cập nhật quyền cho admin trong bảng admin
function updateAdminPermissions(userId, permissions) {
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/admins/update-permissions', // Đường dẫn API để cập nhật quyền cho admin
        method: 'POST',
        data: {
            user_id: userId, // Sử dụng userId thay vì staffId
            permissions: permissions
        },
        success: function (response) {
            alert("Quyền admin đã được cập nhật.");
            $('.staff-modal-overlay').hide(); // Ẩn modal
        },
        error: function (error) {
            console.error('Error updating permissions:', error);
        }
    });
}



    // Hiển thị menu tùy chọn xuất Excel
    $('.excel-export-btn').on('click', function (e) {
        e.stopPropagation();
        $('.excel-options').toggle();
    });

    // Ẩn menu khi nhấn ra ngoài
    $(document).on('click', function () {
        $('.excel-options').hide();
    });

    // Ngăn menu bị ẩn khi nhấn vào chính nó
    $('.excel-options').on('click', function (e) {
        e.stopPropagation();
    });

    // Xử lý xuất Excel
    $('#exportAll').on('click', function () {
        exportToExcel(getTableData());
    });

    $('#exportSelected').on('click', function () {
    const selectedData = getTableData(true);
    
    // Kiểm tra nếu không có dữ liệu nào được chọn
    if (selectedData.length === 0) {
        alert('Vui lòng chọn ít nhất một hàng để xuất!');
        return; // Dừng lại nếu không có dữ liệu được chọn
    }
    
    exportToExcel(selectedData);
});

function attachCheckboxEvents() {
        // Sự kiện khi checkbox lớn được thay đổi
        $('.checkbox-cell input[type="checkbox"]').on('change', function () {
            const isChecked = $(this).is(':checked'); // Kiểm tra trạng thái của checkbox lớn
            // Cập nhật tất cả các checkbox nhỏ trong bảng theo trạng thái checkbox lớn
            $('#adminTable input[type="checkbox"]').prop('checked', isChecked);
        });

        // Sự kiện khi bất kỳ checkbox nhỏ nào được thay đổi
        $('#adminTable').on('change', '.main-checkbox', function () {
            const allCheckboxes = $('#adminTable .main-checkbox'); // Lấy tất cả checkbox nhỏ
            const allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length; // Kiểm tra nếu tất cả đều được chọn
            // Cập nhật trạng thái của checkbox lớn
            $('.checkbox-cell input[type="checkbox"]').prop('checked', allChecked);
        });

    }
    // Lấy dữ liệu từ bảng
  // Lấy dữ liệu từ bảng
function getTableData(selectedOnly = false) {
    const rows = [];
    $('#adminTable tr').each(function () {
        const checkbox = $(this).find('.main-checkbox');
        if (selectedOnly && !checkbox.is(':checked')) return; // Bỏ qua nếu không được chọn
        
        const rowData = {
            id: $(this).find('td:nth-child(3)').text(),
            name: $(this).find('td:nth-child(4)').text(),
            role: $(this).find('td:nth-child(5)').text() // Lấy chức vụ từ cột chức vụ
        };
        rows.push(rowData);
    });
    return rows;
}

    // Xuất dữ liệu ra Excel
// Xuất dữ liệu ra Excel
function exportToExcel(data) {
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Danh sách nhân viên');

    // Thêm tiêu đề
    worksheet.columns = [
        { header: 'ID', key: 'id', width: 10 },
        { header: 'Họ và Tên', key: 'name', width: 30 },
        { header: 'Chức vụ', key: 'role', width: 30 } // Thêm cột chức vụ
    ];

    // Thêm dữ liệu
    data.forEach(row => worksheet.addRow(row));

    // Tải xuống file
    workbook.xlsx.writeBuffer().then(buffer => {
        saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'DanhSachNhanVien.xlsx');
    });
}
        }
});
});


// Hàm bật/tắt dropdown
function toggleDropdown(button) {
    // Lấy phần tử dropdown-menu liên quan đến nút bấm
    const dropdown = button.nextElementSibling;

    // Đóng tất cả các dropdown khác
    document.querySelectorAll('.dropdown-menu').forEach((menu) => {
        if (menu !== dropdown) {
            menu.style.display = 'none';
        }
    });

    // Bật/tắt dropdown hiện tại
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
}

// Đóng dropdown khi bấm ra ngoài màn hình
document.addEventListener('click', function (event) {
    const isClickInsideDropdown = event.target.closest('.action-dropdown');

    // Nếu bấm bên ngoài, ẩn tất cả dropdowns
    if (!isClickInsideDropdown) {
        document.querySelectorAll('.dropdown-menu').forEach((menu) => {
            menu.style.display = 'none';
        });
    }
});
const modalOverlay = document.querySelector('.staff-modal-overlay');
        const importBtn = document.querySelector('.importBtn');
        const closeBtn = document.querySelector('.staff-modal-close');
        const staffIdInput = document.getElementById('staff-id');
        const staffRoleSelect = document.getElementById('staff-role');
        const permissionCheckboxes = document.querySelectorAll('.staff-permission-item input[type="checkbox"]');

        // Modal Toggle
        importBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'flex';
            loadAndHandleUsers()
            

        });

        // Close Modal
        closeBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });

        // Staff ID Validation and Formatting
        staffRoleSelect.addEventListener('change', function() {
            // Reset ID prefix based on role
            switch(this.value) {
                case 'NV':
                    staffIdInput.value = staffIdInput.value.replace(/^(QL|Ad)/, 'NV');
                    if (!staffIdInput.value.startsWith('NV')) {
                        staffIdInput.value = 'NV' + staffIdInput.value;
                    }
                    // Auto-enable specific permissions for Nhân Viên
                    ['manage_products', 'manage_users', 'manage_promotions', 'manage_orders', 'manage_reservations']
                        .forEach(perm => {
                            const checkbox = document.querySelector(`input[data-permission="${perm}"]`);
                            checkbox.checked = true;
                        });
                    break;
                case 'QL':
                    staffIdInput.value = staffIdInput.value.replace(/^(NV|Ad)/, 'QL');
                    if (!staffIdInput.value.startsWith('QL')) {
                        staffIdInput.value = 'QL' + staffIdInput.value;
                    }
                    // Enable all permissions for Quản Lý except system management
                    permissionCheckboxes.forEach(checkbox => {
                        checkbox.checked = checkbox.dataset.permission !== 'manage_system';
                    });
                    break;
                case 'Ad':
                    staffIdInput.value = staffIdInput.value.replace(/^(NV|QL)/, 'Ad');
                    if (!staffIdInput.value.startsWith('Ad')) {
                        staffIdInput.value = 'Ad' + staffIdInput.value;
                    }
                    // Enable only post management for Admin
                    permissionCheckboxes.forEach(checkbox => {
                        checkbox.checked = checkbox.dataset.permission === 'manage_posts';
                    });
                    break;
            }
        });

        // Search Functionality
        const searchInput = document.querySelector('.staff-search-input');
        const searchButton = document.querySelector('.staff-search-button');
        const userList = document.querySelector('.staff-user-list');

        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase();
            const userItems = userList.querySelectorAll('.staff-user-item');
            
            userItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }
        $(document).ready(function () {
    // Gọi API để lấy danh sách user
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/api/users', // Đường dẫn API danh sách user
        method: 'GET',
        success: function (data) {
            const userList = $('.staff-user-list');
            userList.empty(); // Xóa danh sách cũ

            // Lọc và hiển thị những user có is_admin = 0
            data.forEach(function (user) {
                if (user.is_admin === 0) {
                    const userItem = `
                        <div class="staff-user-item">
                            <span>${user.id}-${user.user_name}-${user.name}</span>
                        </div>
                    `;
                    userList.append(userItem);
                }
            });
        },
        error: function (error) {
            console.error('Error fetching users:', error);
        }
    });
});
let user_id=0;


function loadAndHandleUsers() {
    // Gọi API để lấy danh sách user
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/users/non-admin', // API danh sách user
        method: 'GET',
        success: function (data) {
            const userList = $('.staff-user-list');
            userList.empty(); // Xóa danh sách cũ

            // Duyệt qua danh sách user và hiển thị
            data.forEach(function (user) {
                const userItem = `
                    <div class="staff-user-item" data-user-id="${user.id}">
                        <span>${user.id}-${user.user_name}-${user.name}</span>
                    </div>
                `;
                userList.append(userItem);
            });

            // Thêm sự kiện click vào các item vừa được render
            $('.staff-user-item').on('click', function () {
                // Bỏ chọn tất cả các ô khác
                $('.staff-user-item').removeClass('selected');

                // Đánh dấu ô được chọn
                $(this).addClass('selected');

                // Lấy user_id của ô được chọn
                const userId = $(this).data('user-id');
                console.log('Selected User ID:', userId);
                user_id = userId; // Lưu giá trị user_id để sử dụng nếu cần

                // Gọi API kiểm tra user trong bảng admin
                $.ajax({
                    url: `http://localhost/web_ban_banh_kem/public/users/admin-data/${userId}`,
                    method: 'GET',
                    success: function (response) {
                        if (response.exists) {
                            // Nếu user tồn tại trong bảng admin
                            const adminData = response.adminData;

                            // Điền thông tin vào form
                            $('#staff-id').val(adminData.id).prop('disabled', true); // Lock input mã nhân viên

                            // Xử lý role
                            let roleValue = '';
                            switch (adminData.role) {
                                case 'Nhân Viên':
                                    roleValue = 'NV';
                                    break;
                                case 'Quản Lý':
                                    roleValue = 'QL';
                                    break;
                                case 'Admin':
                                    roleValue = 'Ad';
                                    break;
                                default:
                                    roleValue = ''; // Nếu không có giá trị phù hợp
                            }
                            $('#staff-role').val(roleValue); // Thiết lập giá trị cho dropdown

                            // Cập nhật trạng thái các switch dựa trên quyền
                            $('.staff-switch input').each(function () {
                                const permission = $(this).data('permission');
                                $(this).prop('checked', adminData[permission]);
                            });
                        } else {
                            // Nếu user không tồn tại trong bảng admin
                            $('#staff-id').val(userId).prop('disabled', false); // Unlock input mã nhân viên
                            $('#staff-role').val('NV'); // Reset role về default
                            $('.staff-switch input').prop('checked', false); // Reset tất cả switch
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching admin data:', error);
                    }
                });
            });
        },
        error: function (error) {
            console.error('Error fetching users:', error);
        }
    });
}
function attachSwitchEvents() {
    // Lắng nghe sự kiện change trên tất cả các switch
    $('.permission-group .switch input[type="checkbox"]').on('change', function () {
        const adminId = $(this).closest('tr').find('td:nth-child(3)').text().trim(); // Lấy ID admin từ cột thứ 3
        const permissionName = $(this).closest('.permission-group').find('label:first-child').text().trim(); // Lấy tên quyền
        const isChecked = $(this).is(':checked'); // Lấy trạng thái switch (true/false)

        // Map tên quyền sang tên cột trong database
        const permissionMapping = {
            'Quản lý sản phẩm': 'manage_products',
            'Quản lý người dùng': 'manage_users',
            'Quản lý nhân viên': 'manage_staff',
            'Quản lý khuyến mãi': 'manage_promotions',
            'Quản lý bài viết': 'manage_posts',
            'Quản lý đơn hàng': 'manage_orders',
            'Quản lý đặt bàn': 'manage_reservations',
            'Quản lý tài chính': 'manage_finance',
            'Quản lý hệ thống': 'manage_system',
        };

        const permissionKey = permissionMapping[permissionName];

        if (!permissionKey) {
            console.error('Không tìm thấy quyền tương ứng:', permissionName);
            return;
        }
        console.log({
    admin_id: adminId,
    permission: permissionKey,
    status: isChecked
});
        // Gửi AJAX để cập nhật trạng thái switch trong database
        $.ajax({
            url: 'http://localhost/web_ban_banh_kem/public/admins/update-permission', // API cập nhật quyền
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token
            },
            data: {
                admin_id: adminId,
                permission: permissionKey,
                status: isChecked // Trạng thái mới
            },
            success: function (response) {
                console.log('Cập nhật quyền thành công:', response.message);
            },
            error: function (error) {
                console.error('Lỗi khi cập nhật quyền:', error);
                alert('Cập nhật quyền thất bại!');
            }
        });
    });
}
let StaffEdit =0;
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("editstaff-modal");
    const openBtn = document.querySelector(".editstaff-edit-btn");
    const closeBtns = document.querySelectorAll(".editstaff-close-btn, .editstaff-close");

    // Mở modal
    window.openEditStaffModal = function(adminId) {
        // Chuyển adminId vào modal
        const staffIdField = document.getElementById("editstaff-id");
        const roleSelect = document.getElementById("editstaff-role");
        StaffEdit=adminId;
        staffIdField.value = adminId; // Set mã nhân viên vào input
        modal.style.display = "flex";  // Mở modal

        // Nếu cần, bạn có thể thêm logic để lấy thông tin chi tiết của admin theo adminId
        console.log(`Admin ID: ${adminId}-`);
    };

    // Đóng modal
    closeBtns.forEach((btn) =>
        btn.addEventListener("click", function () {
            modal.style.display = "none";
        })
    );

    // Bấm ngoài modal để đóng
    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Lưu dữ liệu
    const saveBtn = document.getElementById("editstaff-save-btn");
   saveBtn.addEventListener("click", function () {
    const staffId = document.getElementById("editstaff-id").value;
    const role = document.getElementById("editstaff-role").value;

    const originalStaffId = staffId; // Lưu mã nhân viên ban đầu
    const originalRole = role; // Lưu chức vụ ban đầu
   
    console.log(`Lưu: Mã nhân viên = ${staffId}, Chức vụ = ${role}`);
    
    // Kiểm tra xem có thay đổi mã nhân viên hoặc chức vụ không
     

    // Gửi AJAX để kiểm tra mã nhân viên có bị trùng không
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/admins/check-duplicate-id', // API kiểm tra trùng mã nhân viên
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            staff_id: staffId // Gửi mã nhân viên để kiểm tra
        },
        success: function(response) {
            if (response.exists) {
                alert('Mã nhân viên đã tồn tại!');
            } else {
                // Chuyển đổi chức vụ
                let roleName = '';
                switch (role) {
                    case 'QL':
                        roleName = 'Quản Lí';
                        break;
                    case 'NV':
                        roleName = 'Nhân Viên';
                        break;
                    case 'Ad':
                        roleName = 'Admin';
                        break;
                    default:
                        roleName = 'Nhân Viên'; // Mặc định là Nhân Viên
                        break;
                }

                // Cập nhật thông tin
                $.ajax({
                    url: 'http://localhost/web_ban_banh_kem/public/admins/update-staff', // API cập nhật nhân viên
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        exclude_id:StaffEdit ,
                        admin_id: staffId,
                        role: roleName // Cập nhật chức vụ sau khi đổi tên
                    },
                    success: function(response) {
                        alert('Cập nhật thành công!');
                        modal.style.display = "none"; // Đóng modal sau khi lưu
                    },
                    error: function(error) {
                        console.error('Lỗi khi cập nhật nhân viên:', error);
                        alert('Không thể cập nhật nhân viên!');
                    }
                });
            }
        },
        error: function(error) {
            console.error('Lỗi khi kiểm tra mã nhân viên:', error);
            alert('Không thể kiểm tra mã nhân viên!');
        }
    });
});

});

document.getElementById("editstaff-revoke-admin-btn").addEventListener("click", function () {
    // Lấy staff_id từ modal (được truyền khi mở modal)
    const staffId = document.getElementById("editstaff-id").value;

    // Hiển thị confirm để người dùng xác nhận
    const confirmRevoke = confirm("Bạn có chắc chắn muốn tắt quyền quản trị của nhân viên này?");
    if (!confirmRevoke) {
        return; // Dừng nếu người dùng không đồng ý
    }
    console.log("staffedit:",StaffEdit);
    // Gửi AJAX request để thực hiện tắt quyền quản trị
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/admins/revoke-admin', // Route xử lý tắt quyền quản trị
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Thêm CSRF token
        },
        data: {
            staff_id: StaffEdit // Truyền staff_id đến server
        },
        success: function (response) {
            alert(response.message); // Thông báo thành công
            modal.style.display = "none"; // Đóng modal
        },
        error: function (error) {
            console.error("Lỗi khi tắt quyền quản trị:", error);
            alert("Không thể tắt quyền quản trị! Vui lòng thử lại.");
        }
    });
});

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
        function openStaffHistoryModal() {
    document.getElementById("staffHistoryModal").style.display = "block";
    fetchLogs();  // Gọi API khi mở modal
}

// Đóng modal
function closeStaffHistoryModal() {
    document.getElementById("staffHistoryModal").style.display = "none";
}

// Lấy dữ liệu logs từ API và hiển thị
function fetchLogs() {
    let action = document.getElementById('actionFilter').value;
    let date = document.getElementById('dateFilter').value;

    // Gọi API để lấy dữ liệu logs
    fetch(`http://localhost/web_ban_banh_kem/public/log-admins?action=${action}&date=${date}`)
        .then(response => response.json())
        .then(data => {
            let logList = document.getElementById('logList');
            logList.innerHTML = '';  // Xóa dữ liệu cũ

            data.data.forEach(log => {
                let logItem = document.createElement('div');
                logItem.classList.add('log-item');
                logItem.innerHTML = `
                    <p><strong>Thao tác:</strong> ${log.action}</p>
                    <p><strong>Admin:</strong> ${log.admin.name}</p>
                    <p><strong>Ngày:</strong> ${new Date(log.created_at).toLocaleString()}</p>
                    <p><strong>Nội dung:</strong> ${log.action_content}</p>
                `;
                logList.appendChild(logItem);
            });
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu:', error);
        });
}
// Mở modal
let currentUserId = null; 
function openStaffDetailHistoryModal(user_id) {
    // Mở modal
    currentUserId = user_id;
    document.getElementById('staffDetailHistoryModal').style.display = 'block';
    
    // Gọi fetch để lấy dữ liệu logs
    fetchStaffDetailHistory(user_id);
}

// Đóng modal
function closeStaffDetailHistoryModal() {
    document.getElementById('staffDetailHistoryModal').style.display = 'none';
}

// Lấy dữ liệu logs và hiển thị
function fetchStaffDetailHistory(user_id) {
    let action = document.getElementById('actionDetailFilter').value;
    let startDate = document.getElementById('startDateFilter').value;
    let endDate = document.getElementById('endDateFilter').value;

    // Gọi API để lấy dữ liệu logs
fetch(`http://localhost/web_ban_banh_kem/public/staff-logs/${user_id}?action=${action}&start_date=${startDate}&end_date=${endDate}`)
    .then(response => response.json())
    .then(data => {
        let staffDetailHistoryList = document.getElementById('staffDetailHistoryList');
        staffDetailHistoryList.innerHTML = '';  // Xóa dữ liệu cũ

        if (data.data.length === 0) {
            staffDetailHistoryList.innerHTML = '<p>Không có dữ liệu lịch sử thao tác.</p>';
        } else {
            data.data.forEach(log => {
                let logItem = document.createElement('div');
                logItem.classList.add('staff-detail-history-log-item');
                
                let adminId = log.admin_id; // Hiển thị admin_id
                
                logItem.innerHTML = `
                    <p><strong>Thao tác:</strong> ${log.action}</p>
                    <p><strong>Admin ID:</strong> ${adminId}</p>
                    <p><strong>Ngày:</strong> ${new Date(log.created_at).toLocaleString()}</p>
                    <p><strong>Nội dung:</strong> ${log.action_content}</p>
                `;
                staffDetailHistoryList.appendChild(logItem);
            });
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu:', error);
    });

}
function fetchStaffDetailHistory1() {
    if (currentUserId === null) {
        console.error('User ID is not set!');
        return;
    }

    let action = document.getElementById('actionDetailFilter').value;
    let startDate = document.getElementById('startDateFilter').value;
    let endDate = document.getElementById('endDateFilter').value;

    // Gọi API để lấy dữ liệu logs
    fetch(`http://localhost/web_ban_banh_kem/public/staff-logs/${currentUserId}?action=${action}&start_date=${startDate}&end_date=${endDate}`)
    .then(response => response.json())
    .then(data => {
        let staffDetailHistoryList = document.getElementById('staffDetailHistoryList');
        staffDetailHistoryList.innerHTML = '';  // Xóa dữ liệu cũ

        if (data.data.length === 0) {
            staffDetailHistoryList.innerHTML = '<p>Không có dữ liệu lịch sử thao tác.</p>';
        } else {
            data.data.forEach(log => {
                let logItem = document.createElement('div');
                logItem.classList.add('staff-detail-history-log-item');
                
                let adminId = log.admin_id; // Hiển thị admin_id
                
                logItem.innerHTML = `
                    <p><strong>Thao tác:</strong> ${log.action}</p>
                    <p><strong>Admin ID:</strong> ${adminId}</p>
                    <p><strong>Ngày:</strong> ${new Date(log.created_at).toLocaleString()}</p>
                    <p><strong>Nội dung:</strong> ${log.action_content}</p>
                `;
                staffDetailHistoryList.appendChild(logItem);
            });
        }
    })
    .catch(error => {
        console.error('Lỗi khi tải dữ liệu:', error);
    });
}

    </script>
</body>
</html>