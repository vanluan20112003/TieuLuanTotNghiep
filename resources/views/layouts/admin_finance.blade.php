<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <title>Admin Dashboard</title>
    <style>
        .pending-alert-container {
    background-color: #ffcc00;
    color: #fff;
    padding: 5px;
    font-weight: bold;
    margin-top: 5px;
    border-radius: 5px;
    text-align: center;
}

.pending-alert {
    font-size: 12px;
}

        .table-options {
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    position: absolute;
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 150px;
    z-index: 1000;
}

.table-options button {
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    font-size: 14px;
}

.table-options button:hover {
    background-color: #0056b3;
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
    z-index: 1001;
    width: 200px; /* Độ rộng của submenu */
    padding: 10px 0;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    z-index: 1001;
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
    z-index: 1001;
}

.menu-item:hover .submenu {
    display: block; /* Hiển thị submenu khi hover menu chính */
}

.submenu-item {
    padding: 10px 15px;
    cursor: pointer;
    z-index: 1001;
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
.container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .tabs {
            display: flex;
            background-color: #2c3e50;
            color: white;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .tab:hover {
            background-color: #34495e;
        }

        .tab.active {
            background-color: #3498db;
        }

        .tab-content {
            display: none;
            padding: 20px;
        }

        .tab-content.active {
            display: block;
        }

        .table-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .table-item {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .table-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-round {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto;
            background-color: #3498db;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-rectangular {
            width: 120px;
            height: 80px;
            border-radius: 10px;
            margin: 0 auto;
            background-color: #2ecc71;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-status {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-available {
            background-color: #2ecc71;
        }

        .status-occupied {
            background-color: #e74c3c;
        }
        .table-options,
.table-info-box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 200px;
}

.table-info-box input {
    width: calc(100% - 50px);
    margin-right: 5px;
}
.table-options, .table-info-box {
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 250px;
            z-index: 1000;
        }

        .table-options button, 
        .table-info-box button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .table-options button:hover, 
        .table-info-box button:hover {
            background-color: #2980b9;
        }

        .table-info-box input {
            width: 70%;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .table-info-box p {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .table-options {
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
/* Phần CSS cho hộp thoại */
.table-options, .schedule-info-box {
    position: absolute;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    width: 280px;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    z-index: 1000;
    max-height: 500px;
    overflow-y: auto;
    transition: all 0.3s ease-in-out;
}

/* Tab container */
.tabs {
    display: flex;
    justify-content: space-evenly;
    margin-bottom: 15px;
    border-bottom: 2px solid #f1f1f1;
}

/* Button style for tabs */
.tab-button {
    padding: 10px 15px;
    font-size: 14px;
    font-weight: bold;
    background-color: #f5f5f5;
    color: #555;
    border: 2px solid #ddd;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
    outline: none;
}

/* Hover effect for tabs */
.tab-button:hover {
    background-color: #f1f1f1;
    color: #007bff;
}

/* Active tab */
.tab-button.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

/* Content area for tabs */
.tab-content {
    display: none;
    font-size: 14px;
    color: #333;
}

.tab-content.active {
    display: block;
}

/* Schedule item box */
.schedule-item {
    margin: 15px 0;
    padding: 12px;
    background-color: #fafafa;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: transform 0.3s ease;
}

/* Hover effect for schedule items */
.schedule-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Buttons for approving and rejecting schedules */
.schedule-item button {
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 20px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 10px;
}

.schedule-item .approve-button {
    background-color: #4CAF50;
    color: white;
}

.schedule-item .reject-button {
    background-color: #f44336;
    color: white;
}

/* Hover effects for approve/reject buttons */
.schedule-item .approve-button:hover {
    background-color: #388E3C;
    transform: scale(1.05);
}

.schedule-item .reject-button:hover {
    background-color: #d32f2f;
    transform: scale(1.05);
}

/* Tab content scroll bar styling */
.schedule-info-box {
    max-width: 320px;
    overflow-y: auto;
    max-height: 400px;
}

/* Hiển thị hộp thoại kế bên bàn ăn */
.table-options, .schedule-info-box {
    top: 50%; /* Hiển thị tại vị trí giữa của bàn ăn */
    left: calc(100% + 15px); /* Hiển thị bên phải bàn ăn */
    transform: translateY(-50%); /* Căn giữa theo chiều dọc */
}

/* Mở hộp thoại với hiệu ứng */
.table-options, .schedule-info-box {
    opacity: 0;
    animation: fadeIn 0.3s ease forwards;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

/* Tối ưu cho những màn hình nhỏ */
@media (max-width: 768px) {
    .schedule-info-box, .table-options {
        width: 100%;
        left: 0;
        top: 10px;
        transform: translateY(0);
    }
}
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
/* Modal Styles */
.modal-datban {
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

.modal-content-datban {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
}

.close-btn-datban {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-btn-datban:hover,
.close-btn-datban:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

h2, h3 {
    color: #333;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 20px;
}

button:hover {
    background-color: #45a049;
}

#current-future-schedules-datban, #past-schedules-datban {
    margin-top: 20px;
}

.schedule-item {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    border-radius: 5px;
}

.schedule-item.pending {
    background-color: #ffeb3b;
}

.schedule-item.confirmed {
    background-color: #4caf50;
}

.schedule-item p {
    margin: 5px 0;
}
.add-new-table-modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .add-new-table-modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }

    .add-new-table-close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 36px;
        cursor: pointer;
    }

    .add-new-table-close:hover,
    .add-new-table-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .add-new-table-submit-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        width: 100%;
    }

    .add-new-table-submit-btn:hover {
        background-color: #45a049;
    }
/* Modal container */
.modal-table-static {
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

/* Modal content */
.modal-table-static-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

/* Close button */
.modal-table-static-close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

/* Close button hover */
.modal-table-static-close:hover,
.modal-table-static-close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Filters */
.modal-table-static-filters {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
    align-items: center;
}

.filter-table-static-date {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn-table-static-apply {
    padding: 8px 12px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-table-static-apply:hover {
    background-color: #218838;
}

/* Stats section */
.modal-table-static-stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-table-static-item {
    text-align: center;
    flex: 1;
    padding: 10px;
    background-color: #f8f9fa;
    margin: 0 10px;
    border-radius: 10px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

.stat-table-static-item h3 {
    margin-bottom: 10px;
}

.stat-table-static-item p {
    font-size: 1.5rem;
    color: #007bff;
}

/* Charts section */
.modal-table-static-charts {
    display: flex;
    gap: 20px;
    justify-content: space-between;
}

.modal-table-static-charts canvas {
    flex: 1;
    max-height: 400px;
}
/* Cập nhật modal để đảm bảo không tràn */
.modal-table-static-content {
    width: 80%;
    max-width: 900px;  /* Giới hạn chiều rộng tối đa của modal */
    margin: auto;
    padding: 20px;
    overflow: hidden; /* Tránh nội dung bị tràn */
}

/* Khu vực chứa các biểu đồ */
.modal-table-static-charts {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    max-height: 400px; /* Giới hạn chiều cao tối đa của phần biểu đồ */
    overflow: auto; /* Thêm thanh cuộn nếu nội dung quá lớn */
    flex-wrap: wrap; /* Nếu không đủ chỗ sẽ bẻ xuống dòng */
}

/* Kích thước của canvas để biểu đồ không bị tràn */
.modal-table-static-charts canvas {
    width: 100% !important; /* Đảm bảo canvas chiếm hết chiều rộng */
    max-width: 400px; /* Giới hạn chiều rộng tối đa của mỗi biểu đồ */
    height: 250px !important; /* Giới hạn chiều cao của canvas */
    flex: 1; /* Tự động co giãn để phù hợp với container */
}

/* Thêm một số kiểu dáng cho các mục thống kê */
.modal-table-static-stats {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.modal-table-history {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto;
}

.modal-table-history-content {
    position: relative;
    margin: 10% auto;
    background-color: white;
    padding: 20px;
    width: 80%;
    max-width: 800px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-table-history-close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
}

.modal-table-history-filters {
    margin-bottom: 20px;
}

.modal-table-history-filters label {
    margin-right: 10px;
}

.modal-table-history-filters input,
.modal-table-history-filters select {
    margin-right: 15px;
    padding: 5px;
    font-size: 16px;
}

.table-history-log {
    width: 100%;
    border-collapse: collapse;
}

.table-history-log th,
.table-history-log td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.table-history-log th {
    background-color: #f2f2f2;
}
/* Style cho modal */
.modal-table-history {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    overflow: auto;
}

/* Nội dung của modal */
.modal-table-history-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    max-width: 900px;
    max-height: 80%; /* Giới hạn chiều cao của modal */
    overflow: hidden;
    border-radius: 8px;
}

/* Nút đóng modal */
.modal-table-history-close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    color: #000;
    cursor: pointer;
}

/* Tiêu đề */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Bộ lọc */
.modal-table-history-filters {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.filter-table-history-date,
.filter-table-history-action {
    padding: 5px;
    font-size: 14px;
}

/* Khu vực hiển thị lịch sử */
.modal-table-history-log {
    max-height: 60vh; /* Giới hạn chiều cao khu vực lịch sử */
    overflow-y: auto; /* Thêm cuộn dọc */
}

/* Bảng hiển thị lịch sử */
.table-history-log {
    width: 100%;
    border-collapse: collapse;
}

.table-history-log th, .table-history-log td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table-history-log th {
    background-color: #f4f4f4;
}

/* Button lọc */
.btn-table-history-apply {
    padding: 8px 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    border-radius: 5px;
}

.btn-table-history-apply:hover {
    background-color: #45a049;
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
.edit-category-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    transition: opacity 0.3s ease;
}

.edit-category-modal.hidden {
    display: none;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.modal-content h2 {
    margin-bottom: 20px;
    text-align: center;
}

.modal-content label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.modal-content input[type="text"],
.modal-content input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.modal-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.modal-actions button {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
}

#save-category-btn {
    background-color: #4CAF50;
    color: white;
}

#cancel-category-btn {
    background-color: #f44336;
    color: white;
}
/* Modal container */
.view-category-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    transition: opacity 0.3s ease;
}

.view-category-modal.hidden {
    display: none;
}

/* Modal content */
.modal-content {
    background: #fff;
    padding: 20px;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.modal-content h2 {
    margin-bottom: 20px;
    text-align: center;
    font-size: 18px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    text-align: center;
    padding: 10px;
}

table th {
    background-color: #f4f4f4;
    color: #333;
}

table img {
    display: block;
    margin: 0 auto;
}

.close-modal-btn {
    display: block;
    margin: 0 auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.close-modal-btn:hover {
    background-color: #0056b3;
}
/* Container chứa nút xuất Excel và dropdown */
.export-container {
    position: relative; /* Để dropdown xuất hiện dưới nút */
    display: inline-block; /* Hiển thị theo dạng inline-block */
}



/* Định dạng dropdown menu */
.dropdown-menu {
    display: none; /* Ẩn mặc định */
    position: absolute; /* Đặt nó ở vị trí tuyệt đối */
    top: 100%; /* Đưa menu xuống dưới nút */
    left: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Đảm bảo dropdown nằm trên các phần tử khác */
    width: 200px;
    padding: 10px;
}

/* Hiển thị dropdown khi người dùng hover vào nút */
.export-container:hover .dropdown-menu {
    display: block;
}

/* Style cho các button trong dropdown */
.dropdown-menu .btn {
    width: 100%;
    padding: 8px;
    text-align: left;
    background-color: #f1f1f1;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 5px 0;
}

.transaction-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.transaction-modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 70%;
    max-height: 80%;
    overflow-y: auto;
    position: relative;
}

.transaction-close-button {
    position: absolute;
    top: 10px;
    right: 20px;
    cursor: pointer;
    font-size: 20px;
    color: #333;
}

.transaction-filter-container {
    margin-bottom: 20px;
}

.transaction-filter-container input,
.transaction-filter-container select,
.transaction-filter-container button {
    margin-right: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th,
table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #f4f4f4;
    font-weight: bold;
}
.transaction-modal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Lớp phủ mờ */
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc */
    z-index: 1000; /* Đảm bảo modal luôn ở trên các thành phần khác */
}

.transaction-modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 70%; /* Chiều rộng của modal */
    max-width: 800px; /* Đảm bảo modal không quá lớn */
    max-height: 80%; /* Giới hạn chiều cao modal */
    overflow-y: auto; /* Cuộn dọc nếu nội dung vượt quá chiều cao */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Hiệu ứng đổ bóng */
    position: relative;
}
/* Hộp thoại sửa mã PIN */
.edit-pin-box {
    background: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin-top: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
    max-width: 300px; /* Giới hạn chiều rộng */
}

/* Input mã PIN */
.pin-input {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Nút lưu và hủy */
.edit-pin-box .btn {
    margin-right: 5px;
    padding: 5px 10px;
    font-size: 14px;
}
/* Modal background */
.transactioncard-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* Modal content */
.transactioncard-modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    text-align: center;
}

/* Close button */
.transactioncard-modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    cursor: pointer;
}

/* Form inputs and buttons */
.transactioncard-input {
    width: calc(100% - 20px);
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.transactioncard-options label {
    margin-right: 15px;
    font-size: 16px;
    cursor: pointer;
}

.transactioncard-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
}

.transactioncard-submit {
    background-color: #28a745;
    color: white;
}

.transactioncard-submit:hover {
    background-color: #218838;
}
.card-details-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.card-details-modal-content {
    background-color: #fff;
    border-radius: 8px;
    width: 70%;
    padding: 20px;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card-details-modal-close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
}

.card-details-tabs {
    display: flex;
    border-bottom: 2px solid #ccc;
    margin-bottom: 20px;
}

.tab-button {
    flex: 1;
    padding: 10px 20px;
    text-align: center;
    cursor: pointer;
    border: none;
    background-color: #f1f1f1;
    outline: none;
    transition: background-color 0.3s ease;
}

.tab-button.active {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.transaction-history-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.transaction-history-table th, 
.transaction-history-table td {
    border: 1px solid #ddd;
    text-align: left;
    padding: 8px;
}

.transaction-history-table th {
    background-color: #f4f4f4;
}

.card-details-btn {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.card-details-btn:hover {
    background-color: #218838;
}
/* Modal */
.card-details-modal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Nền mờ */
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

/* Nội dung modal */
.card-details-modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    overflow-y: auto;
}

/* Đóng modal */
.card-details-modal-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

/* Tabs */
.card-details-tabs {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 10px;
}

.tab-link {
    padding: 10px;
    cursor: pointer;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    margin-right: 5px;
    border-radius: 5px;
}

.tab-link.active {
    background-color: #007bff;
    color: white;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}
/* Modal */
.card-details-modal {
    display: none; /* Ẩn modal mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Nền mờ */
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

/* Nội dung modal */
.card-details-modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 600px;
    max-height: 80%; /* Đảm bảo modal không vượt quá 80% chiều cao màn hình */
    overflow-y: auto; /* Cho phép cuộn toàn bộ modal nếu nội dung dài */
    position: relative;
}

/* Đóng modal */
.card-details-modal-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
}

/* Tabs */
.card-details-tabs {
    display: flex;
    justify-content: flex-start;
    margin-bottom: 10px;
}

.tab-link {
    padding: 10px;
    cursor: pointer;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    margin-right: 5px;
    border-radius: 5px;
}

.tab-link.active {
    background-color: #007bff;
    color: white;
}

.tab-content {
    display: none;
}

/* Cho phép cuộn cho phần lịch sử giao dịch */
#transactionTab {
    max-height: 300px; /* Giới hạn chiều cao phần lịch sử giao dịch */
    overflow-y: auto;  /* Cho phép cuộn nếu quá nhiều giao dịch */
}

.tab-content.active {
    display: block;
}
.financeStatic-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
    }

    .financeStatic-modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 1000px;
      max-height: 90vh;
      overflow-y: auto;
      z-index: 1001;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .financeStatic-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #eee;
    }

    .financeStatic-close-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #666;
    }

    .financeStatic-filter {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 6px;
    }

    .financeStatic-stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .financeStatic-card {
      background: #fff;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      border: 1px solid #eee;
    }

    .financeStatic-card h3 {
      margin: 0;
      color: #666;
      font-size: 0.9rem;
    }

    .financeStatic-value {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2c3e50;
      margin-top: 5px;
    }

    .financeStatic-charts {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-top: 20px;
    }

    .financeStatic-chart-box {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      border: 1px solid #eee;
    }

    .financeStatic-input {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .financeStatic-btn {
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
      padding: 8px 12px;
      border-radius: 4px;
    }

    .financeStatic-btn:hover {
      background: #0056b3;
    }
    .finance-modal {
    display: none;
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

.finance-modal input[type="date"] {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.finance-modal .btn {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

.finance-modal .btn-primary {
    background-color: #007bff;
    color: white;
}

.finance-modal .btn-secondary {
    background-color: #6c757d;
    color: white;
    margin-right: 5px;
}

.error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}

.modal-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.3);
    z-index: 999;
}
.toolbar-btn {
    position: relative; /* Đặt vị trí của button ở dạng relative để chứa chấm đỏ */
    padding: 10px 20px;

    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.dot {
    position: absolute; /* Đặt vị trí của dot ở trong button */
    top: 5px;           /* Khoảng cách từ phía trên của button */
    right: 5px;         /* Khoảng cách từ phía phải của button */
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
    display: none; /* Ẩn mặc định */
    z-index: 10;    /* Đảm bảo chấm đỏ hiển thị trên các phần tử khác trong button */
}
.PendingTransaction-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    overflow: auto; /* Thêm dòng này để trang có thể cuộn nếu modal lớn hơn viewport */
}

.PendingTransaction-modalContent {
    position: relative;
    background-color: #fff;
    margin: 2% auto;
    padding: 20px;
    width: 90%;
    max-width: 1200px;
    max-height: 90vh; /* Giới hạn chiều cao modal */
    overflow-y: auto; /* Cho phép cuộn dọc nếu nội dung vượt quá chiều cao */
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    animation: PendingTransactionFadeIn 0.3s;
}

.PendingTransaction-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.PendingTransaction-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.PendingTransaction-closeBtn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #666;
}

.PendingTransaction-body {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    height: 70vh;
}

.PendingTransaction-list {
    flex: 1;
    overflow-y: auto;
    padding-right: 15px;
    border-right: 1px solid #eee;
}

.PendingTransaction-item {
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.PendingTransaction-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.PendingTransaction-item.active {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.PendingTransaction-details {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

.PendingTransaction-detailsGroup {
    margin-bottom: 15px;
}

.PendingTransaction-detailsLabel {
    font-weight: bold;
    color: #666;
    margin-bottom: 5px;
}

.PendingTransaction-detailsValue {
    color: #333;
    font-size: 1.1rem;
}

.PendingTransaction-proofImage {
    max-width: 200px;
    cursor: pointer;
    border-radius: 4px;
    transition: transform 0.2s;
}

.PendingTransaction-proofImage:hover {
    transform: scale(1.05);
}

.PendingTransaction-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.PendingTransaction-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.2s;
}

.PendingTransaction-btnApprove {
    background-color: #28a745;
    color: white;
}

.PendingTransaction-btnReject {
    background-color: #dc3545;
    color: white;
}

.PendingTransaction-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.PendingTransaction-imageModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    z-index: 2000;
    justify-content: center;
    align-items: center;
}

.PendingTransaction-imageModal img {
    max-width: 90%;
    max-height: 90vh;
    object-fit: contain;
}

@keyframes PendingTransactionFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.PendingTransaction-emptyDetails {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #666;
}

.PendingTransaction-emptyDetails i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #ddd;
}
    </style>
</head>
<div>
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
    <a href="http://localhost/web_ban_banh_kem/public/admin/user">
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
    <h2>Quản Lý Tài Chính</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
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

<div class="dropdown-container" style="position: relative; display: inline-block;">
    <button class="toolbar-btn look-up-btn">
        <i class="fas fa-credit-card"></i> Tra cứu thẻ
    </button>

    <!-- Drop-down hiển thị khi bấm -->
    <div id="dropdownContent" class="dropdown-content" style="display: none; position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); padding: 10px; border-radius: 5px; z-index: 10; min-width: 300px;">
        <label for="cardCode" style="font-weight: bold; display: block; margin-bottom: 8px;">Nhập mã thẻ đa năng:</label>
        <input type="text" id="cardCode" placeholder="Nhập mã thẻ..." style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="qrUpload" style="font-weight: bold; display: block; margin-bottom: 8px;">Hoặc tải mã QR thẻ tại đây:</label>
        <input type="file" id="qrUpload" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px;">

        <!-- Nút tra cứu -->
        <button id="lookupBtn" style="width: 100%; padding: 10px; background: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
            Tra cứu
        </button>
    </div>
</div>

<button class="toolbar-btn" onclick="openFinanceStaticModal()"> 
    <i class="fas fa-chart-bar"></i> Thống kê
</button>
    <!-- Thêm 2 nút mới -->
    <button class="toolbar-btn" onclick="openReportFinanceModal()"> 
    <i class="fas fa-chart-bar"></i> Báo Cáo Tài Chính
</button>
<button class="toolbar-btn" onclick="openPendingTransactionModal()"> 
    <i class="fas fa-chart-bar"></i> Yêu cầu nạp/rút
    <span id="pending-dot" class="dot"></span> <!-- Chấm đỏ sẽ hiển thị nếu có giao dịch pending -->
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
                <option value="pending">Đang chờ duyệt</option>
                <option value="processing">Đang vận chuyển</option>
                <option value="completed">Đã hoàn thành</option>
                <option value="cancelled">Đã bị hủy</option>

            </select>
        </div>

        <!-- Bộ lọc theo sắp xếp -->
        <div class="sort-options">
            <label>Sắp xếp:</label>
            <select id="sortOption">
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Ngày thêm (Mới nhất)</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Ngày thêm (Cũ nhất)</option>
            </select>
        </div>

    </div>
</div>
<table>
    <thead>
        <tr>
            <th class="checkbox-cell"><input type="checkbox" id="check-all"></th>
            <th>Mã</th>
            <th>Người dùng</th>
            <th>Ngày tạo thẻ</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="CateogoryTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>
<div id="transactionModal" class="transaction-modal">
    <div class="transaction-modal-content">
        <span class="transaction-close-button" onclick="closeModal()">&times;</span>
        <h3>Lịch sử giao dịch</h3>

        <!-- Bộ lọc -->
        <div class="transaction-filter-container">
            <label for="fromDate">Từ ngày:</label>
            <input type="date" id="fromDate">

            <label for="toDate">Đến ngày:</label>
            <input type="date" id="toDate">

            <label for="loaiGiaoDich">Loại giao dịch:</label>
            <select id="loaiGiaoDich">
                <option value="">Tất cả</option>
                <option value="nap">Nạp</option>
                <option value="rut">Rút</option>
                <option value="thanh_toan">Thanh toán</option>
                <option value="phan_thuong_vong_quay_yeu_thuong">Phần thưởng</option>
            </select>

            <button id="filterButton">Lọc</button>
        </div>

        <!-- Bảng giao dịch -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Loại giao dịch</th>
                    <th>Số tiền</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody id="transactionTableBody">
                <!-- Dữ liệu giao dịch sẽ được tải tại đây -->
            </tbody>
        </table>
    </div>
</div>
<div id="transactionCardModal" class="transactioncard-modal" style="display: none;">
    <div class="transactioncard-modal-content">
        <span class="transactioncard-modal-close" onclick="closeTransactionModal()">&times;</span>
        <h3 id="transactionLabel">Giao dịch cho mã thẻ ...</h3>
        <form id="transactionForm">
            <label for="transactionAmount">Số tiền:</label>
            <input 
                type="text" 
                id="transactionAmount" 
                class="transactioncard-input" 
                placeholder="Nhập số tiền" 
                required 
                oninput="formatCurrency(this)">
            
            <div class="transactioncard-denominations">
                <button type="button" class="transactioncard-btn denomination-btn" onclick="setAmount(50000)">50,000</button>
                <button type="button" class="transactioncard-btn denomination-btn" onclick="setAmount(100000)">100,000</button>
                <button type="button" class="transactioncard-btn denomination-btn" onclick="setAmount(200000)">200,000</button>
                <button type="button" class="transactioncard-btn denomination-btn" onclick="setAmount(500000)">500,000</button>
            </div>
            
            <div class="transactioncard-options">
                <label>
                    <input type="radio" name="transactionType" value="deposit" checked> Nạp
                </label>
                <label>
                    <input type="radio" name="transactionType" value="withdraw"> Rút
                </label>
            </div>
            
            <button type="button" class="transactioncard-btn transactioncard-submit" onclick="handleTransaction()">Giao dịch</button>
        </form>
    </div>
</div>
<div id="cardDetailsModal" class="card-details-modal" style="display: none;">
    <div class="card-details-modal-content">
        <span class="card-details-modal-close" onclick="closeCardDetailsModal()">&times;</span>
        <h3 id="cardDetailsLabel">Thông tin thẻ</h3>

        <div class="card-details-tabs">
            <button class="tab-link active" onclick="openTab(event, 'infoTab')">Thông Tin</button>
            <button class="tab-link" onclick="openTab(event, 'transactionTab')">Lịch Sử Giao Dịch</button>
        </div>

        <div id="infoTab" class="tab-content">
            <!-- Tab Thông Tin -->
            <h4>Thông tin thẻ</h4>
            <!-- Thêm các thông tin về thẻ ở đây -->
            <p>Ví dụ: Mã thẻ: 1234, Số dư: 1,000,000 VND</p>
            <button onclick="openTransactionModal()">Nạp/Rút</button>
        </div>

        <div id="transactionTab" class="tab-content" style="display: none;">
            <!-- Tab Lịch Sử Giao Dịch -->
            <h4>Lịch sử giao dịch</h4>
            <!-- Thêm lịch sử giao dịch ở đây -->
            <p>Giao dịch 1: Nạp 500,000 VND</p>
            <p>Giao dịch 2: Rút 200,000 VND</p>
        </div>
    </div>
</div>



<div id="financeStaticModal" class="financeStatic-overlay">
    <div class="financeStatic-modal">
      <div class="financeStatic-header">
        <h2>Thống kê tài chính</h2>
        <button class="financeStatic-close-btn" onclick="closeFinanceStaticModal()">&times;</button>
      </div>

      <div class="financeStatic-filter">
        <input type="date" id="financeStatic-start-date" class="financeStatic-input" onchange="updateStats()">
        <input type="date" id="financeStatic-end-date" class="financeStatic-input" onchange="updateStats()">
        <button class="financeStatic-btn" onclick="updateStats()">Áp dụng</button>
      </div>

      <div class="financeStatic-stats-grid">
        <div class="financeStatic-card">
          <h3>Tổng số đơn hàng</h3>
          <div class="financeStatic-value" id="financeStatic-total-orders">0</div>
        </div>
        <div class="financeStatic-card">
          <h3>Tổng doanh thu</h3>
          <div class="financeStatic-value" id="financeStatic-total-revenue">0 ₫</div>
        </div>
        <div class="financeStatic-card">
          <h3>Chi phí nhập hàng</h3>
          <div class="financeStatic-value" id="financeStatic-total-cost">0 ₫</div>
        </div>
        <div class="financeStatic-card">
          <h3>Lợi nhuận</h3>
          <div class="financeStatic-value" id="financeStatic-total-profit">0 ₫</div>
        </div>
      </div>

      <div class="financeStatic-charts">
  <div class="financeStatic-chart-box">
    <canvas id="financeStatic-revenue-chart"></canvas>
  </div>
  <div class="financeStatic-chart-box">
    <canvas id="financeStatic-payment-chart"></canvas>
  </div>
  <div class="financeStatic-chart-box">
    <canvas id="financeStatic-daily-revenue-chart"></canvas>
  </div>
  <div class="financeStatic-chart-box">
    <canvas id="financeStatic-daily-orders-chart"></canvas>
  </div>
  <button class="financeStatic-print-btn" onclick="printCharts()">In Biểu Đồ</button> <!-- Thêm nút in -->
</div>
    </div>
    </div>
 

<div class="modal-backdrop" id="modalBackdrop"></div>
<div class="finance-modal" id="financeModal">
    <h4>Chọn khoảng thời gian báo cáo</h4>
    <div>
        <label>Từ ngày:</label>
        <input type="date" id="startDate">
    </div>
    <div>
        <label>Đến ngày:</label>
        <input type="date" id="endDate">
    </div>
    <div class="error-message" id="errorMessage"></div>
    <div style="text-align: right; margin-top: 10px;">
        <button class="btn btn-secondary" onclick="closeFinanceModal()">Đóng</button>
        <button class="btn btn-primary" onclick="generateReport()">Xuất báo cáo</button>
    </div>
    </div>
    <div id="PendingTransactionModal" class="PendingTransaction-modal">
    <div class="PendingTransaction-modalContent">
        <div class="PendingTransaction-header">
            <h2 class="PendingTransaction-title">Yêu cầu nạp/rút tiền</h2>
            <button class="PendingTransaction-closeBtn" onclick="closePendingTransactionModal()">&times;</button>
        </div>
        <div class="PendingTransaction-body">
            <div class="PendingTransaction-list" id="PendingTransactionList">
                <!-- Transaction items will be inserted here -->
            </div>
            <div class="PendingTransaction-details" id="PendingTransactionDetails">
                <div class="PendingTransaction-emptyDetails">
                    <i class="fas fa-inbox"></i>
                    <p>Chọn một giao dịch để xem chi tiết</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="PendingTransactionImageModal" class="PendingTransaction-imageModal" onclick="closePendingTransactionImageModal()">
    <img id="PendingTransactionEnlargedImage" src="" alt="Proof of transaction">
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
    fetchCategories();
});
function loadTheDaNangData() {
    const tableBody = document.getElementById('CateogoryTable');

    // Gửi request tới API
    fetch('http://localhost/web_ban_banh_kem/public/the-da-nang-list') // Đường dẫn tới API
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const items = data.data;

                // Xóa nội dung cũ của bảng
                tableBody.innerHTML = '';

                // Duyệt qua danh sách và tạo hàng mới cho mỗi thẻ
                items.forEach(item => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td class="checkbox-cell"><input type="checkbox" value="${item.id}"></td>
                        <td>${item.id}</td>
            
                        <td>${item.user_id}</td>
                        <td>${new Date(item.created_at).toLocaleDateString('vi-VN')}</td>
                        <td>
                           <button class="btn btn-primary" onclick="toggleEditPin(${item.id})">Sửa</button>
                    <div id="editPinBox-${item.id}" class="edit-pin-box" style="display: none;">
    <input type="password" id="pinInput-${item.id}" class="form-control pin-input" placeholder="Nhập mã PIN" 
           maxlength="6" pattern="\d{6}" title="Mã PIN phải gồm 6 chữ số" oninput="this.value = this.value.replace(/\D/g, '')">
    <input type="password" id="confirmPinInput-${item.id}" class="form-control pin-input" placeholder="Xác nhận mã PIN" 
           maxlength="6" pattern="\d{6}" title="Mã PIN phải gồm 6 chữ số" oninput="this.value = this.value.replace(/\D/g, '')">
    <button class="btn btn-success" onclick="savePin(${item.id})">Lưu</button>
    <button class="btn btn-secondary" onclick="cancelEditPin(${item.id})">Hủy</button>
</div>


                            <button class="btn btn-danger" onclick="ViewCard(${item.id})">Xem</button>
                            <button class="btn btn-success" onclick="openTransactionModal(${item.id})">Nạp/Rút</button>

                        </td>
                    `;

                    tableBody.appendChild(row);
                });
            } else {
                alert('Không thể tải dữ liệu thẻ đa năng!');
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải danh sách thẻ:', error);
            alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
        });
}

// Hàm gọi khi tải trang
document.addEventListener('DOMContentLoaded', loadTheDaNangData);
function ViewCard(cardId) {
    // Hiển thị modal
    const modal = document.getElementById('transactionModal');
    modal.style.display = 'flex';

    // Tải dữ liệu giao dịch từ API
    loadTransactionData(cardId);

    // Đăng sự kiện cho nút lọc
    const filterButton = document.getElementById('filterButton');
    filterButton.onclick = () => {
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        const loaiGiaoDich = document.getElementById('loaiGiaoDich').value;

        // Tải lại dữ liệu với bộ lọc
        loadTransactionData(cardId, fromDate, toDate, loaiGiaoDich);
    };
}

// Hàm tải dữ liệu giao dịch từ API
function loadTransactionData(cardId, fromDate = null, toDate = null, loaiGiaoDich = null) {
    const tableBody = document.getElementById('transactionTableBody');
    tableBody.innerHTML = '';

    // API URL
    let url = `http://localhost/web_ban_banh_kem/public/transactions/${cardId}`;
    const params = new URLSearchParams();

    if (fromDate) params.append('from_date', fromDate);
    if (toDate) params.append('to_date', toDate);
    if (loaiGiaoDich) params.append('loai_giao_dich', loaiGiaoDich);

    url += `?${params.toString()}`;

    // Fetch dữ liệu
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const transactions = data.data;

                // Hiển thị giao dịch trong bảng
                transactions.forEach(transaction => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${transaction.id}</td>
                        <td>${transaction.loai_giao_dich}</td>
                        <td>${transaction.so_tien.toLocaleString('vi-VN')} VND</td>
                        <td>${new Date(transaction.created_at).toLocaleString('vi-VN')}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="4">Không có giao dịch nào.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu giao dịch:', error);
        });
}

// Đóng modal
function closeModal() {
    document.getElementById('transactionModal').style.display = 'none';
}
function toggleEditPin(cardId) {
    const pinBox = document.getElementById(`editPinBox-${cardId}`);
    pinBox.style.display = pinBox.style.display === 'none' ? 'block' : 'none';
}

// Lưu mã PIN sau khi nhập
function savePin(cardId) {
    const pin = document.getElementById(`pinInput-${cardId}`).value;
    const confirmPin = document.getElementById(`confirmPinInput-${cardId}`).value;

    // Kiểm tra xem mã PIN có chỉ chứa số không
    if (!/^\d+$/.test(pin)) {
        alert("Mã PIN chỉ được phép chứa các chữ số. Vui lòng thử lại.");
        return;
    }

    // Kiểm tra xem mã PIN và xác nhận mã PIN có khớp không
    if (pin === confirmPin) {
        // Hiển thị hộp thoại xác nhận
        const isConfirmed = confirm("Bạn có chắc chắn muốn lưu mã PIN này?");
        if (isConfirmed) {
            // Gửi API để cập nhật mã PIN
            fetch(`http://localhost/web_ban_banh_kem/public/cards/${cardId}/update-pin`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    pin: pin,
                    confirm_pin: confirmPin
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    toggleEditPin(cardId); // Ẩn hộp thoại sau khi lưu thành công
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert("Đã xảy ra lỗi khi cập nhật mã PIN. Vui lòng thử lại.");
            });
        }
    } else {
        alert("Mã PIN và Xác nhận mã PIN không khớp. Vui lòng thử lại.");
    }
}


// Hủy sửa mã PIN
function cancelEditPin(cardId) {
    toggleEditPin(cardId);
}
document.getElementById("check-all").addEventListener("change", function () {
        const isChecked = this.checked; // Trạng thái của checkbox "check-all"
        const checkboxes = document.querySelectorAll("#CateogoryTable .checkbox-cell input[type='checkbox']");

        // Cập nhật trạng thái của tất cả checkbox con
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });
    // Hàm xuất Excel
function exportToExcel(data, fileName = 'ExportedData.xlsx') {
    const worksheet = XLSX.utils.json_to_sheet(data); // Chuyển đổi dữ liệu JSON sang sheet
    const workbook = XLSX.utils.book_new(); // Tạo workbook mới
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1'); // Thêm sheet vào workbook
    XLSX.writeFile(workbook, fileName); // Xuất file Excel
}

// Lấy danh sách tất cả dữ liệu
document.getElementById('exportAllBtn').addEventListener('click', () => {
    fetch('http://localhost/web_ban_banh_kem/public/the-da-nang-list')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const allItems = data.data.map(item => ({
                    'Mã': item.id,
                    'Người dùng': item.user_id,
                    'Ngày tạo': new Date(item.created_at).toLocaleDateString('vi-VN')
                }));
                exportToExcel(allItems, 'TatCaDuLieu.xlsx');
            } else {
                alert('Không thể tải dữ liệu thẻ đa năng!');
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải danh sách thẻ:', error);
            alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
        });
});

// Lấy danh sách dữ liệu đã chọn
document.getElementById('exportSelectedBtn').addEventListener('click', () => {
    const selectedCheckboxes = document.querySelectorAll('#CateogoryTable .checkbox-cell input[type="checkbox"]:checked');
    const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

    if (selectedIds.length === 0) {
        alert('Vui lòng chọn ít nhất một mục để xuất!');
        return;
    }

    fetch('http://localhost/web_ban_banh_kem/public/the-da-nang-list')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const selectedItems = data.data
                    .filter(item => selectedIds.includes(item.id.toString()))
                    .map(item => ({
                        'Mã': item.id,
                        'Người dùng': item.user_id,
                        'Ngày tạo': new Date(item.created_at).toLocaleDateString('vi-VN')
                    }));
                exportToExcel(selectedItems, 'DuLieuDaChon.xlsx');
            } else {
                alert('Không thể tải dữ liệu thẻ đa năng!');
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải danh sách thẻ:', error);
            alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
        });
});
function openTransactionModal(cardId) {
    // Hiển thị modal
    const modal = document.getElementById('transactionCardModal');
    modal.style.display = 'flex';
    
    // Cập nhật tiêu đề với mã thẻ
    const transactionLabel = document.getElementById('transactionLabel');
    transactionLabel.textContent = `Giao dịch cho mã thẻ ${cardId}`;
    
    // Lưu cardId vào modal để sử dụng sau
    modal.setAttribute('data-card-id', cardId);
}

function closeTransactionModal() {
    // Đóng modal
    const modal = document.getElementById('transactionCardModal');
    modal.style.display = 'none';
}

// Định dạng số tiền nhập vào
function formatCurrency(input) {
    // Loại bỏ các ký tự không phải số
    let value = input.value.replace(/\D/g, '');
    if (!value) {
        input.value = '';
        return;
    }

    // Định dạng lại thành kiểu 000.000
    input.value = parseInt(value, 10).toLocaleString('vi-VN');
}

// Đặt giá trị cho ô số tiền
function setAmount(amount) {
    const input = document.getElementById('transactionAmount');
    input.value = amount.toLocaleString('vi-VN');
}


function handleTransaction() {
    const modal = document.getElementById('transactionCardModal');
    const cardId = modal.getAttribute('data-card-id'); // Lấy mã thẻ từ modal
    const rawAmount = document.getElementById('transactionAmount').value; // Giá trị gốc từ ô nhập
    const amount = parseInt(rawAmount.replace(/\./g, ''), 10); // Loại bỏ dấu chấm và chuyển sang số nguyên
    const transactionType = document.querySelector('input[name="transactionType"]:checked').value;
    const transactionTypeText = transactionType === 'deposit' ? 'Nạp' : 'Rút';

    // Kiểm tra số tiền hợp lệ
    if (!amount || isNaN(amount) || amount < 10000 || amount > 10000000) {
        alert('Số tiền giao dịch phải nằm trong khoảng từ 10,000 đến 10,000,000.');
        return;
    }

    // Hiển thị hộp thoại xác nhận
    const isConfirmed = confirm(
        `Bạn có chắc chắn muốn ${transactionTypeText.toLowerCase()} số tiền ${amount.toLocaleString('vi-VN')} VNĐ cho mã thẻ ${cardId}?`
    );
    if (!isConfirmed) {
        return; // Hủy giao dịch nếu người dùng không xác nhận
    }

    // Gửi API để thực hiện giao dịch
    fetch(`http://localhost/web_ban_banh_kem/public/cards/${cardId}/transaction`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            type: transactionType,
            amount: amount // Gửi số tiền đã được xử lý
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                closeTransactionModal(); // Đóng modal sau khi giao dịch thành công
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi khi thực hiện giao dịch. Vui lòng thử lại.');
        });
}
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
document.getElementById('lookupBtn').addEventListener('click', function() {
    const cardCode = document.getElementById('cardCode').value.trim();
    const qrUpload = document.getElementById('qrUpload').files[0];
    
    if (!cardCode && !qrUpload) {
        alert('Vui lòng nhập mã thẻ hoặc tải lên mã QR!');
        return;
    }

    // Nếu có mã QR được tải lên, đọc mã QR từ ảnh
    if (qrUpload) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.src = event.target.result;

            img.onload = function() {
                const qrCode = decodeQRCode(img);
                if (qrCode) {
                    searchQRCode(qrCode);
                } else {
                    alert('Không phát hiện được mã QR trong ảnh!');
                }
            };
        };
        reader.readAsDataURL(qrUpload);
    }

    // Nếu có mã thẻ nhập, thực hiện tra cứu
    if (cardCode) {
        searchQRCode(cardCode);
    }
});

// Hàm giải mã QR từ ảnh sử dụng jsQR
function decodeQRCode(img) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0);

    // Lấy dữ liệu ảnh từ canvas
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    
    // Dùng jsQR để giải mã mã QR
    const qrCode = jsQR(imageData.data, canvas.width, canvas.height);
    
    if (qrCode) {
        return qrCode.data;  // Trả về dữ liệu mã QR
    } else {
        return null;  // Không tìm thấy mã QR
    }
}

// Hàm tìm kiếm mã QR trong cơ sở dữ liệu
function searchQRCode(qrCode) {
    fetch(`http://localhost/web_ban_banh_kem/public/api/tra-cuu-the?qr_code=${qrCode}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.user_id) {
                alert(`Mã QR này trùng với người dùng có ID: ${data.user_id}`);
                // Mở modal và hiển thị chi tiết các đơn hàng của người dùng
                openCardDetailsModal(data.user_id);
            } else {
                alert('Không tìm thấy người dùng với mã QR này!');
            }
        })
        .catch(error => {
            console.error('Lỗi tìm kiếm mã QR:', error);
            alert('Đã có lỗi xảy ra khi tra cứu mã QR!');
        });
}
// Mở modal chi tiết thẻ
function openCardDetailsModal(userId) {
    const modal = document.getElementById('cardDetailsModal');
    modal.style.display = 'flex'; // Hiển thị modal

    // Lấy thông tin thẻ từ API
    fetch(`http://localhost/web_ban_banh_kem/public/cards/user/${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const card = data.card;
                const transactions = data.transactions;

                // Cập nhật thông tin thẻ
                document.getElementById('cardDetailsLabel').innerText = `Giao dịch cho mã thẻ ${card.id}`;
                document.getElementById('infoTab').innerHTML = `
                    <h4>Thông tin thẻ</h4>
                    <p>Mã thẻ: ${card.id}</p>
                    <p>Người dùng: ${card.user_id}</p>

                      <p>Số dư: ${formatCurrency(card.so_du)} VND</p>
                    <button onclick="openTransactionModal(${card.id})">Nạp/Rút</button>
                `;

                // Cập nhật lịch sử giao dịch
                let transactionsHtml = '<h4>Lịch sử giao dịch</h4>';
                transactions.forEach(transaction => {
    const transactionDate = new Date(transaction.created_at).toLocaleDateString('vi-VN', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    transactionsHtml += `
        <p>Giao dịch ${transaction.id}: ${transaction.loai_giao_dich === 'nap' ? 'Nạp' : 'Rút'} ${transaction.so_tien.toLocaleString('vi-VN')} VND vào ngày ${transactionDate}</p>
    `;
});

                document.getElementById('transactionTab').innerHTML = transactionsHtml;
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi khi tải thông tin thẻ.');
        });

    // Mở tab thông tin mặc định
    openTab(null, 'infoTab');
}

// Mở tab
function openTab(evt, tabName) {
    const tabContents = document.querySelectorAll('.tab-content');
    const tabLinks = document.querySelectorAll('.tab-link');

    // Ẩn tất cả các tab
    tabContents.forEach(content => {
        content.style.display = 'none';
    });

    // Loại bỏ lớp active ở tất cả các tab
    tabLinks.forEach(link => {
        link.classList.remove('active');
    });

    // Hiển thị tab được chọn
    document.getElementById(tabName).style.display = 'block';

    // Thêm lớp active vào tab hiện tại
    if (evt) {
        evt.currentTarget.classList.add('active');
    }
}

// Đóng modal
function closeCardDetailsModal() {
    const modal = document.getElementById('cardDetailsModal');
    modal.style.display = 'none';
}


function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    document.querySelectorAll('.tab-button').forEach(tabBtn => {
        tabBtn.classList.remove('active');
    });
    document.getElementById(tabId).style.display = 'block';
    document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
}
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}
document.addEventListener('click', function () {
    const dropdown = document.getElementById('dropdownContent');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    }
});
function openFinanceStaticModal() {
      document.getElementById('financeStaticModal').style.display = 'block';
      updateStats();
    }

    function closeFinanceStaticModal() {
      document.getElementById('financeStaticModal').style.display = 'none';
    }

    function formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
      }).format(amount);
    }

    let revenueChart, paymentChart, dailyRevenueChart, dailyOrdersChart;

    function updateStatCards(data) {
  document.getElementById('financeStatic-total-orders').textContent = data.total_orders;
  document.getElementById('financeStatic-total-revenue').textContent = formatCurrency(data.total_revenue);
  document.getElementById('financeStatic-total-cost').textContent = formatCurrency(data.total_purchase_cost);
  document.getElementById('financeStatic-total-profit').textContent = formatCurrency(data.total_profit);
}
let charts = {
      revenue: null,
      payment: null,
      dailyRevenue: null,
      dailyOrders: null
    };

    function updateStats() {
      const startDate = document.getElementById('financeStatic-start-date').value;
      const endDate = document.getElementById('financeStatic-end-date').value;

      fetch(`http://localhost/web_ban_banh_kem/public/finance/static?start_date=${startDate}&end_date=${endDate}`)
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            updateAllCharts(data.data);
            updateStatCards(data.data);
          }
        });
    }

    function formatCurrency(value) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
      }).format(value);
    }

    function destroyCharts() {
      Object.values(charts).forEach(chart => {
        if (chart) chart.destroy();
      });
    }

    function updateAllCharts(data) {
      destroyCharts();
      
      charts.revenue = createRevenueChart(data);
      charts.payment = createPaymentChart(data.payment_methods);
      charts.dailyRevenue = createDailyRevenueChart(data.daily_stats);
      charts.dailyOrders = createDailyOrdersChart(data.daily_stats);
    }

    function createRevenueChart(data) {
      const ctx = document.getElementById('financeStatic-revenue-chart').getContext('2d');
      return new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Doanh thu', 'Chi phí', 'Lợi nhuận'],
          datasets: [{
            label: 'Tổng quan tài chính',
            data: [data.total_revenue, data.total_purchase_cost, data.total_profit],
            backgroundColor: [
              'rgba(54, 162, 235, 0.5)',
              'rgba(255, 99, 132, 0.5)',
              'rgba(75, 192, 192, 0.5)'
            ],
            borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: `Tổng quan tài chính (${data.start_date} - ${data.end_date})`
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return formatCurrency(context.raw);
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return formatCurrency(value);
                }
              }
            }
          }
        }
      });
    }

    function createPaymentChart(paymentData) {
      const ctx = document.getElementById('financeStatic-payment-chart').getContext('2d');
      return new Chart(ctx, {
        type: 'pie',
        data: {
          labels: Object.keys(paymentData),
          datasets: [{
            data: Object.values(paymentData),
            backgroundColor: [
              'rgba(255, 99, 132, 0.5)',
              'rgba(54, 162, 235, 0.5)',
              'rgba(255, 206, 86, 0.5)',
              'rgba(75, 192, 192, 0.5)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Phương thức thanh toán theo thời gian'
            },
            legend: {
              position: 'right'
            }
          }
        }
      });
    }

    function createDailyRevenueChart(dailyStats) {
      const ctx = document.getElementById('financeStatic-daily-revenue-chart').getContext('2d');
      return new Chart(ctx, {
        type: 'line',
        data: {
          labels: dailyStats.map(stat => stat.date),
          datasets: [
            {
              label: 'Doanh thu',
              data: dailyStats.map(stat => stat.revenue),
              borderColor: 'rgba(54, 162, 235, 1)',
              backgroundColor: 'rgba(54, 162, 235, 0.1)',
              fill: true
            },
            {
              label: 'Chi phí',
              data: dailyStats.map(stat => stat.cost),
              borderColor: 'rgba(255, 99, 132, 1)',
              backgroundColor: 'rgba(255, 99, 132, 0.1)',
              fill: true
            },
            {
              label: 'Lợi nhuận',
              data: dailyStats.map(stat => stat.profit),
              borderColor: 'rgba(75, 192, 192, 1)',
              backgroundColor: 'rgba(75, 192, 192, 0.1)',
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Biến động tài chính theo ngày'
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return formatCurrency(context.raw);
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return formatCurrency(value);
                }
              }
            }
          }
        }
      });
    }

    function createDailyOrdersChart(dailyStats) {
      const ctx = document.getElementById('financeStatic-daily-orders-chart').getContext('2d');
      return new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dailyStats.map(stat => stat.date),
          datasets: [{
            label: 'Số đơn hàng',
            data: dailyStats.map(stat => stat.orders),
            backgroundColor: 'rgba(153, 102, 255, 0.5)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Số lượng đơn hàng theo ngày'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          }
        }
      });
    }

    // Khởi tạo khi trang tải xong
    document.addEventListener('DOMContentLoaded', () => {
      const today = new Date();
      const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
      
      document.getElementById('financeStatic-start-date').value = firstDay.toISOString().split('T')[0];
      document.getElementById('financeStatic-end-date').value = today.toISOString().split('T')[0];
      
      updateStats();
    });
    function openReportFinanceModal() {
    const button = document.querySelector('.toolbar-btn');
    const modal = document.getElementById('financeModal');
    const backdrop = document.getElementById('modalBackdrop');
    const rect = button.getBoundingClientRect();
    
    modal.style.display = 'block';
    modal.style.top = rect.bottom + 'px';
    modal.style.left = rect.left + 'px';
    backdrop.style.display = 'block';
}

function closeFinanceModal() {
    document.getElementById('financeModal').style.display = 'none';
    document.getElementById('modalBackdrop').style.display = 'none';
    document.getElementById('errorMessage').style.display = 'none';
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

function generateReport() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate) {
        showError('Vui lòng chọn đầy đủ khoảng thời gian');
        return;
    }

    if (new Date(endDate) < new Date(startDate)) {
        showError('Ngày kết thúc phải sau ngày bắt đầu');
        return;
    }

    // Gọi API để lấy dữ liệu báo cáo
    fetch('http://localhost/web_ban_banh_kem/public/financial-report', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate })
    })
    .then(response => response.json())
    .then(data => {
        const currentDate = new Date().toLocaleDateString('vi-VN');
        
        // Tạo nội dung PDF
        const docDefinition = {
            content: [
                { text: 'BÁO CÁO TÀI CHÍNH', style: 'header' },
                { text: `Ngày xuất báo cáo: ${currentDate}`, margin: [0, 5, 0, 20] },
                { text: `Khoảng thời gian: ${new Date(startDate).toLocaleDateString('vi-VN')} - ${new Date(endDate).toLocaleDateString('vi-VN')}`, margin: [0, 0, 0, 20] },
                { text: `Người in: ${data.user_name}`, margin: [0, 5, 0, 20] }, 
                { text: 'TỔNG QUAN', style: 'subheader' },
                {
                    ul: [
                        `Tổng doanh thu: ${formatCurrency(data.summary.total_revenue)}`,
                        `Chi phí nhập hàng: ${formatCurrency(data.summary.total_inventory_cost)}`,
                        `Chi phí vận chuyển: ${formatCurrency(data.summary.total_shipping_cost)}`,
                        `Tổng giảm giá: ${formatCurrency(data.summary.total_discounts)}`,
                        `Lợi nhuận gộp: ${formatCurrency(data.summary.gross_profit)}`,
                        `Lợi nhuận ròng: ${formatCurrency(data.summary.net_profit)}`,
                        `Tỷ suất lợi nhuận: ${data.summary.profit_margin}`
                    ]
                },

                { text: 'PHÂN TÍCH SẢN PHẨM', style: 'subheader', margin: [0, 20, 0, 10] },
                {
                    table: {
                        headerRows: 1,
                        widths: ['*', 'auto', 'auto', 'auto', 'auto'],
                        body: [
                            ['Sản phẩm', 'Số lượng', 'Doanh thu', 'Chi phí', 'Lợi nhuận'],
                            ...data.product_analysis.map(product => [
                                product.product_name,
                                product.quantity_sold,
                                formatCurrency(product.revenue),
                                formatCurrency(product.cost),
                                formatCurrency(product.profit)
                            ])
                        ]
                    }
                }
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 10]
                },
                subheader: {
                    fontSize: 14,
                    bold: true,
                    margin: [0, 10, 0, 5]
                }
            }
        };

        // Tạo và tải xuống PDF
        pdfMake.createPdf(docDefinition).download('bao-cao-tai-chinh.pdf');
        closeFinanceModal();
    })
    .catch(error => {
        showError('Có lỗi xảy ra khi tạo báo cáo');
        console.error('Error:', error);
    });
}
function printCharts() {
  // Lấy tất cả các canvas
  const charts = [
    document.getElementById('financeStatic-revenue-chart'),
    document.getElementById('financeStatic-payment-chart'),
    document.getElementById('financeStatic-daily-revenue-chart'),
    document.getElementById('financeStatic-daily-orders-chart')
  ];

  // Tạo một cửa sổ mới để in
  const printWindow = window.open('', '', 'height=600,width=800');

  // Tạo HTML cho cửa sổ in
  let printContent = '<html><head><title>In Biểu Đồ</title></head><body>';
  printContent += '<h2>Biểu Đồ Tài Chính</h2>';

  // Thêm từng biểu đồ vào cửa sổ in
  charts.forEach(chart => {
    const img = chart.toDataURL(); // Chuyển canvas thành hình ảnh Base64
    printContent += `<img src="${img}" style="max-width: 100%; margin-bottom: 20px;">`;
  });

  printContent += '</body></html>';

  // Đưa nội dung vào cửa sổ in và gọi lệnh in
  printWindow.document.write(printContent);
  printWindow.document.close();
  printWindow.print();
}

// Đóng modal khi click ra ngoài
document.getElementById('modalBackdrop').addEventListener('click', closeFinanceModal);
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
        // Giả sử bạn đã có một API hoặc một phương thức để lấy danh sách các giao dịch pending
        function checkPendingTransactions() {
    fetch('http://localhost/web_ban_banh_kem/public/api/check-pending-transactions')  // Đảm bảo rằng API trả về `hasPending`
        .then(response => response.json())
        .then(data => {
            // Kiểm tra nếu có giao dịch pending
            if (data.hasPending) {
                document.getElementById('pending-dot').style.display = 'inline-block'; // Hiển thị chấm đỏ
            } else {
                document.getElementById('pending-dot').style.display = 'none'; // Ẩn chấm đỏ
            }
        })
        .catch(error => {
            console.error("Lỗi khi kiểm tra giao dịch pending:", error);
        });
}

// Gọi hàm kiểm tra trạng thái giao dịch khi tải trang
checkPendingTransactions();
setInterval(checkPendingTransactions, 10000);
const pendingTransactions = [];

function openPendingTransactionModal() {
    document.getElementById('PendingTransactionModal').style.display = 'block';
    renderPendingTransactionList();
}

function closePendingTransactionModal() {
    document.getElementById('PendingTransactionModal').style.display = 'none';
}

function renderPendingTransactionList() {
    const listContainer = document.getElementById('PendingTransactionList');
    
    // Gửi yêu cầu GET đến API
    fetch('http://localhost/web_ban_banh_kem/public/api/pending-transactions')
        .then(response => response.json())
        .then(data => {
            const pendingTransactions = data.pendingTransactions;
            
            listContainer.innerHTML = pendingTransactions.map(transaction => `
                <div class="PendingTransaction-item" onclick="showPendingTransactionDetails(${transaction.id})">
                    <div style="font-weight: bold; color: ${transaction.transaction_type === 'deposit' ? '#28a745' : '#dc3545'}">
                        ${transaction.transaction_type === 'nap' ? 'Nạp tiền' : 'Rút tiền'}
                    </div>
                    <div>Id thẻ:  ${transaction.the_da_nang_id}</div>
                    <div>Số tiền giao dịch: ${transaction.amount}</div>
                    <div style="font-size: 0.9em; color: #666;">
                        ${new Date(transaction.created_at).toLocaleString()}
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error("Lỗi khi lấy giao dịch đang chờ:", error);
        });
}

// Gọi hàm khi trang web được tải



function showPendingTransactionDetails(id) {
    // Gửi yêu cầu AJAX để lấy thông tin chi tiết giao dịch
    fetch(`http://localhost/web_ban_banh_kem/public/pending-transaction/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.transaction) {
                const transaction = data.transaction;
                const detailsContainer = document.getElementById('PendingTransactionDetails');
                
                // Hide the empty details message
                document.querySelector('.PendingTransaction-emptyDetails').style.display = 'none';
                
                // Hiển thị chi tiết giao dịch
                detailsContainer.innerHTML = `
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Loại giao dịch</div>
                        <div class="PendingTransaction-detailsValue">${transaction.type === 'nap' ? 'Nạp tiền' : 'Rút tiền'}</div>
                    </div>
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Số thẻ</div>
                        <div class="PendingTransaction-detailsValue">${transaction.cardNumber}</div>
                    </div>
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Chủ thẻ</div>
                        <div class="PendingTransaction-detailsValue">${transaction.cardHolder}</div>
                    </div>
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Số dư hiện tại</div>
                        <div class="PendingTransaction-detailsValue">${transaction.balance}</div>
                    </div>
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Số tiền ${transaction.type === 'nap' ? 'nạp' : 'rút'}</div>
                        <div class="PendingTransaction-detailsValue">${transaction.amount}</div>
                    </div>
                      ${transaction.type === 'rut' ? `
                    <div class="PendingTransaction-detailsGroup">
                          <div class="PendingTransaction-detailsLabel">Thông tin ngân hàng nhận tiền: </div>
                        <div class="PendingTransaction-detailsValue">${transaction.bank_info}</div>
                    </div>
                    ` : ''}
                    ${transaction.type === 'nap' ? `
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Số tiền nạp xác minh</div>
                        <div class="PendingTransaction-detailsValue">
                            <input 
                                type="number" 
                                id="rawAmount" 
                                class="PendingTransaction-amountInput" 
                                value="${transaction.raw_amount || transaction.amount}"
                                min="0"
                            >
                        </div>
                    </div>
                    ` : ''}
                    ${transaction.proofImage ? `
                    <div class="PendingTransaction-detailsGroup">
                        <div class="PendingTransaction-detailsLabel">Minh chứng</div>
                        <img src="http://localhost/web_ban_banh_kem/public/images/${transaction.proofImage}" class="PendingTransaction-proofImage" onclick="showPendingTransactionImage('${transaction.proofImage}')" alt="Proof of transaction">
                    </div>
                    ` : ''}
                    <div class="PendingTransaction-actions">
                        <button class="PendingTransaction-btn PendingTransaction-btnApprove" onclick="handlePendingTransaction(${transaction.id}, 'approve')">
                            ${transaction.type === 'nap' ? 'Xác nhận nạp' : 'Xác nhận rút'} 
                        </button>
                        <button class="PendingTransaction-btn PendingTransaction-btnReject" onclick="handlePendingTransaction(${transaction.id}, 'reject')">Từ chối</button>
                    </div>
                `;
            } else {
                alert("Không tìm thấy giao dịch.");
            }
        })
        .catch(error => {
            console.error("Lỗi khi lấy chi tiết giao dịch:", error);
            alert("Đã xảy ra lỗi khi lấy thông tin chi tiết.");
        });
}

function showPendingTransactionImage(imageSrc) {
    const imageModal = document.getElementById('PendingTransactionImageModal');
    const enlargedImage = document.getElementById('PendingTransactionEnlargedImage');
    enlargedImage.src = `http://localhost/web_ban_banh_kem/public/images/${imageSrc}`;

    imageModal.style.display = 'flex';
}

function closePendingTransactionImageModal() {
    document.getElementById('PendingTransactionImageModal').style.display = 'none';
}
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function handlePendingTransaction(id, action) { 
    let reason = null;

    if (action === 'reject') {
        reason = prompt("Nhập lý do từ chối:");
        if (!reason) {
            alert("Bạn phải nhập lý do từ chối.");
            return;
        }
    }

    fetch(`http://localhost/web_ban_banh_kem/public/pending-transactions/${id}/handle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào headers
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: action, reason: reason }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);

        if (action === 'approve') {
            // Gọi API để lấy chi tiết giao dịch
            fetch(`http://localhost/web_ban_banh_kem/public/pending-transaction/${id}`)
                .then(response => response.json())
                .then(transactionData => {
                    const transaction = transactionData.transaction;

                    // Kiểm tra loại giao dịch
                    if (transaction.type === 'rut' || transaction.type === 'nap') {
                        // Cập nhật trạng thái giao dịch thành "approved"
                        fetch(`http://localhost/web_ban_banh_kem/public/pending-transactions/${id}/update-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ status: 'approved' })
                        })
                        .then(response => response.json())
                        .then(updateData => {
                            const amount = transaction.type === 'nap' 
                                ? parseFloat(document.getElementById('rawAmount').value) 
                                : -transaction.raw_amount;

                            // Cập nhật số dư thẻ đa năng
                            fetch(`http://localhost/web_ban_banh_kem/public/the-da-nang/${transaction.cardNumber}/update-balance`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ amount: amount }) // Cộng/Trừ số tiền
                            })
                            .then(balanceUpdate => {
                                const notificationContent = transaction.type === 'nap'
                                    ? 'Yêu cầu nạp tiền của bạn đã được chấp thuận. Vui lòng vào thẻ đa năng kiểm tra.'
                                    : 'Yêu cầu rút tiền của bạn đã được chấp nhận. Vui lòng đến căn tin nhận tiền hoặc chat với chúng tôi để chuyển khoản.';
                                
                                // Gửi thông báo cho người dùng
                                fetch(`http://localhost/web_ban_banh_kem/public/users/${transaction.user_id}/send-notification`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        content: notificationContent,
                                        type: 'notification',
                                    })
                                });

                                // Tạo một giao dịch mới với loại tương ứng
                                fetch('http://localhost/web_ban_banh_kem/public/transactions', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        the_da_nang_id: transaction.cardNumber,
                                        loai_giao_dich: transaction.type,
                                        so_tien: Math.abs(amount)
                                    })
                                })
                                .then(() => {
                                    // Load lại danh sách giao dịch
                                    renderPendingTransactionList();
                                    document.getElementById('PendingTransactionDetails').innerHTML = `
                                        <div class="PendingTransaction-emptyDetails">
                                            <i class="fas fa-inbox"></i>
                                            <p>Chọn một giao dịch để xem chi tiết</p>
                                        </div>
                                    `;
                                })
                                .catch(error => {
                                    console.error('Lỗi khi tạo giao dịch mới:', error);
                                });
                            })
                            .catch(error => {
                                console.error('Lỗi khi cập nhật số dư thẻ đa năng:', error);
                            });
                        })
                        .catch(error => {
                            console.error('Lỗi khi cập nhật trạng thái giao dịch:', error);
                        });
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi lấy chi tiết giao dịch:", error);
                    alert("Đã xảy ra lỗi khi lấy thông tin chi tiết.");
                });
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Đã xảy ra lỗi khi xử lý giao dịch.");
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('PendingTransactionModal');
    if (event.target === modal) {
        closePendingTransactionModal();
    }
}

</script>
</script>
</body>
</html>