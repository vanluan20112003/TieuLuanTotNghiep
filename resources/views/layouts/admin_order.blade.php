<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.filters label {
    margin-right: 10px;
}

.filters input, .filters select {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.filters button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.filters button:hover {
    background-color: #45a049;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

/* Buttons */
button {
    padding: 10px 20px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-export {
    background-color: #007BFF;
    color: white;
}

.btn-export:hover {
    background-color: #0056b3;
}

.btn-close {
    background-color: #f44336;
    color: white;
}

.btn-close:hover {
    background-color: #d32f2f;
}

.orderstatic-modal {
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

.orderstatic-modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.orderstatic-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.orderstatic-modal-header h2 {
    margin: 0;
    font-size: 24px;
}

.orderstatic-close {
    background: none;
    border: none;
    font-size: 28px;
    font-weight: bold;
    color: #555;
    cursor: pointer;
}

.orderstatic-modal-body {
    margin-top: 20px;
}

.orderstatic-filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.orderstatic-input, .orderstatic-select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.orderstatic-btn {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.orderstatic-btn:hover {
    background-color: #0056b3;
}

.orderstatic-chart-container {
    margin: 20px 0;
    max-width: 100%;
    height: 300px; /* Điều chỉnh chiều cao để làm biểu đồ nhỏ hơn */
}

#orderChart {
    width: 100% !important;  /* Đảm bảo biểu đồ chiếm toàn bộ chiều rộng của container */
    height: 100% !important; /* Đảm bảo biểu đồ chiếm toàn bộ chiều cao của container */
}


.orderstatic-details ul {
    list-style: none;
    padding: 0;
}

.orderstatic-details ul li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.orderstatic-modal-footer {
    text-align: right;
    margin-top: 20px;
}

.orderstatic-btn-close {
    background-color: #dc3545;
}

.orderstatic-btn-close:hover {
    background-color: #a71d2a;
}
.history-modal {
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

.history-modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 70%;
    max-height: 80%;
    overflow-y: auto;
}

.history-modal-close-btn {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

.history-modal-filters {
    margin-bottom: 15px;
}

.history-modal-filters label {
    margin-right: 10px;
}

.history-modal-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.history-modal-table th,
.history-modal-table td {
    border: 1px solid #ddd;
    padding: 8px;
}
/* Định dạng modal nền */
#dateRangeModal {
    display: none; /* Ẩn modal khi chưa được hiển thị */
    position: fixed; /* Thay vì absolute, dùng fixed để căn giữa màn hình */
    top: 50%; /* Căn giữa theo chiều dọc */
    left: 50%; /* Căn giữa theo chiều ngang */
    transform: translate(-50%, -50%); /* Điều chỉnh modal hoàn toàn vào giữa */
    width: 300px; /* Chiều rộng của modal */
    padding: 15px; /* Khoảng cách trong modal */
    background-color: white; /* Nền của modal */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Đổ bóng cho modal */
    border-radius: 5px; /* Bo tròn góc */
    z-index: 9999; /* Đảm bảo modal nằm trên các phần tử khác */
}

/* Định dạng các nút bấm trong modal */
#dateRangeModal button {
    background-color: #4CAF50; /* Màu nền của nút */
    color: white; /* Màu chữ */
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px; /* Khoảng cách giữa các nút */
    width: 100%;
}

#dateRangeModal button:hover {
    background-color: #45a049; /* Màu nền khi hover */
}

/* Định dạng các trường nhập liệu */
#dateRangeModal input[type="date"] {
    padding: 8px;
    width: 100%;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Đảm bảo button Xuất báo cáo có margin để không bị lệch */
.toolbar-btn {
    display: inline-block;
    margin-bottom: 5px; /* Khoảng cách dưới button */
}
.modal-table-static-content {
    width: 80%;
    max-width: 900px; /* Giới hạn kích thước của modal */
    margin: auto;
    padding: 20px;
    overflow: auto; /* Đảm bảo không tràn */
}

.modal-table-static-charts {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.modal-table-static-charts canvas {
    width: 100% !important; /* Đảm bảo canvas chiếm hết chiều rộng */
    max-width: 400px; /* Giới hạn chiều rộng tối đa */
    height: auto; /* Đảm bảo tỷ lệ chiều cao và chiều rộng của canvas */
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
    <h2>Quản Lý Hóa Đơn</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
    <div class="toolbar">
  

<!-- Nút Xuất Excel -->
<!-- Nút Xuất Excel -->
<button class="toolbar-btn excel-export-btn">
    <i class="fas fa-file-excel"></i> Xuất Excel
</button>

<!-- Các nút lựa chọn xuất -->
<div class="excel-options" style="display: none;">
    <button id="exportAll">In tất cả</button>
    <button id="exportSelected">In đã chọn</button>
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



    <button class="toolbar-btn" onclick="openModalStatic()">
        <i class="fas fa-chart-bar"></i> Thống kê
    </button>

    <button class="toolbar-btn" onclick="openDateRangeModal()">
    <i class="fas fa-file-pdf"></i> Xuất báo cáo
</button>

<div id="dateRangeModal">
    <h3>Chọn khoảng thời gian</h3>
    <label for="dateFrom">Từ ngày:</label>
    <input type="date" id="dateFrom">
    <label for="dateTo">Đến ngày:</label>
    <input type="date" id="dateTo">
    <button onclick="generatePDF()">Xuất báo cáo</button>
    <button onclick="closeDateRangeModal()">Đóng</button>
</div>

    <!-- Thêm 2 nút mới -->

  <button class="toolbar-btn" onclick="openHistoryModal()">
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


    <!-- Table -->
    <table>
    <thead>
        <tr>
            <th class="checkbox-cell">
                <input type="checkbox" id="selectAll"> <!-- Ô checkbox cha -->
            </th>
            <th>STT</th>
            <th>Mã</th>
            <th>Tên người đặt</th>
            <th>Tổng chi phí</th>
            <th>Trạng thái đơn hàng</th>
            <th>Mã giảm giá được dùng</th>
            <th>Thông tin vận chuyển</th>
            <th>Thông tin thanh toán</th>
            <th>Thông tin chi tiết đơn hàng</th>
            <th>Chú thích thêm</th>
            <th>Ngày đặt</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="orderTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Chi tiết đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Mã SP</th>
                            <th>Tên SP</th>
                            <th>Số lượng</th>
                            <th>Tổng giá</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailsTable">
                        <!-- Nội dung sẽ được nạp động -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal để hiển thị chi tiết đơn hàng -->
<div id="orderDetailModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Chi tiết đơn hàng</h2>
        <div class="filters">
            <label for="orderStatus">Trạng thái:</label>
            <select id="orderStatus">
                <option value="">Tất cả</option>
                <option value="pending">Chờ xử lý</option>
                <option value="processing">Đang xử lý</option>
                <option value="cancelled">Đã hủy</option>
                <option value="completed">Hoàn thành</option>
            </select>

            <label for="startDate">Từ ngày:</label>
            <input type="date" id="startDate">

            <label for="endDate">Đến ngày:</label>
            <input type="date" id="endDate">

            <button id="applyFilters" class="btn-filter">Áp dụng lọc</button>
        </div>
        
        <table id="orderTable">
            <thead>
                <tr>
                    <th>ID Đơn hàng</th>
                    <th>Tổng chi phí</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Chú thích</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Dữ liệu đơn hàng sẽ được tải động ở đây -->
            </tbody>
        </table>
        
        <button id="exportExcelBtn" class="btn-export">Xuất Excel</button>
        <button id="closeModalBtn" class="btn-close">Đóng</button>
    </div>
</div>
<!-- Modal Thống kê -->
<div id="orderStaticModal" class="orderstatic-modal">
    <div class="orderstatic-modal-content">
        <div class="orderstatic-modal-header">
            <h2>Thống kê hóa đơn</h2>
            <button class="orderstatic-close" onclick="closeModalStatic()">&times;</button>
        </div>
        <div class="orderstatic-modal-body">
            <!-- Bộ lọc thống kê -->
            <div class="orderstatic-filters">
                <label for="startDate">Từ ngày:</label>
                <input type="date" id="startDate" class="orderstatic-input">

                <label for="endDate">Đến ngày:</label>
                <input type="date" id="endDate" class="orderstatic-input">

                <label for="statusFilter">Trạng thái:</label>
                <select id="statusFilter" class="orderstatic-select">
                    <option value="">Tất cả</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="pending">Đang xử lý</option>
                    <option value="cancelled">Đã hủy</option>
                </select>

                <button class="orderstatic-btn" onclick="applyFilters()">Lọc</button>
            </div>

            <!-- Khu vực biểu đồ -->
            <div class="orderstatic-chart-container">
                <div class="orderstatic-chart-header">
                    <label for="chartType">Loại biểu đồ:</label>
                    <select id="chartType" class="orderstatic-select" onchange="updateChartType()">
                        <option value="bar">Biểu đồ cột</option>
                        <option value="line">Biểu đồ đường</option>
                        <option value="pie">Biểu đồ tròn</option>
                    </select>
                </div>
                <canvas id="orderChart"></canvas>
                
            </div>

            <!-- Khu vực thống kê chi tiết -->
            <div class="orderstatic-details">
                <h3>Số liệu thống kê:</h3>
                <ul id="orderStatsList">
                    <!-- Thống kê sẽ được cập nhật động -->
                </ul>
            </div>
        </div>
        <div class="orderstatic-modal-footer">
            <button class="orderstatic-btn orderstatic-btn-close" onclick="closeModalStatic()">Đóng</button>
        </div>
    </div>
</div>
<div id="historyModal" class="history-modal">
    <div class="history-modal-content">
        <span class="history-modal-close-btn" onclick="closeHistoryModal()">&times;</span>
        <h2>Lịch sử đơn hàng</h2>

        <!-- Bộ lọc -->
        <div class="history-modal-filters">
            <label for="filterDateFrom">Từ ngày:</label>
            <input type="date" id="filterDateFrom">
            <label for="filterDateTo">Đến ngày:</label>
            <input type="date" id="filterDateTo">
            <label for="filterAction">Loại:</label>
            <select id="filterAction">
                <option value="all">Tất cả</option>
                <option value="update">Cập nhật</option>
                <option value="cancel">Hủy</option>
                <option value="delete">Xóa</option>
            </select>
            <button onclick="fetchHistory()">Lọc</button>
        </div>

        <!-- Bảng hiển thị lịch sử -->
        <table class="history-modal-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hành động</th>
                    <th>Nội dung</th>
                    <th>Admin ID</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody id="historyTableBody">
                <!-- Dữ liệu sẽ được tải động từ AJAX -->
            </tbody>
        </table>
    </div>
</div>

    </div>

<script>
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
        // Lấy dữ liệu từ API fetchOrders và hiển thị trong bảng
        fetchOrders();

        function fetchOrders() {
    const displayLimit = document.getElementById('displayLimit').value;
    const searchQuery = document.querySelector('.search-box').value.trim();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const sortOption = document.getElementById('sortOption').value;

    const url = new URL('http://localhost/web_ban_banh_kem/public/api/orders');
    url.searchParams.append('limit', displayLimit);
    url.searchParams.append('search', searchQuery);
    url.searchParams.append('status', categoryFilter);
    url.searchParams.append('sort', sortOption);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('orderTable');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            data.data.forEach((order, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="checkbox-cell"><input type="checkbox" value="${order.id}"></td>
                    <td>${index + 1}</td>
                    <td>${order.id || 'Không có'}</td>
                    <td>${order.user_name || 'Không có'}</td>
                    <td>${formatCurrency(order.total_amount) || 'Không có'}</td>
                    <td>${order.status || 'Không có'}</td>
                    <td>${order.discount || 'Không có'}</td>
                    <td>${order.shipping_info || 'Không có'}</td>
                    <td>${order.payment_method || 'Không có'}</td>
                    <td>
                        <button class="btn btn-info view-details" data-id="${order.id}">Xem</button>
                        <button class="btn btn-success export-invoice" data-id="${order.id}">Xuất hóa đơn</button>
                    </td>
                    <td>${order.notes || 'Không có'}</td>
                    <td>${order.created_at || 'Không có'}</td>
                    <td>
                        ${order.actions || 'Không có'}
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Gán sự kiện cho các nút tác vụ
            attachEventListeners();
        })
        .catch(error => console.error('Error fetching orders:', error));
}
function exportInvoice(orderId) {
    // Gửi request tới server để lấy dữ liệu đơn hàng
    fetch(`http://localhost/web_ban_banh_kem/public/api/report-order/${orderId}`)
        .then(response => response.json())
        .then(order => {
            // Cấu hình fonts chi tiết
            pdfMake.vfs = pdfMake.vfs || {};
            
            const docDefinition = {
                // Xóa phần fonts cũ và sử dụng cấu hình mặc định của pdfMake
                content: [
                    { 
                        text: 'HÓA ĐƠN MUA HÀNG', 
                        fontSize: 18, 
                        bold: true, 
                        alignment: 'center',
                        margin: [0, 10]
                    },
                    // Thông tin đơn hàng (giữ nguyên phần còn lại)
                    { 
                        text: `Mã Đơn Hàng: ${order.order_id}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Tên Khách Hàng: ${order.user_name}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Ngày Tạo: ${formatDateVN(order.created_at)}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Trạng Thái: ${formatOrderStatus(order.status)}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Phương Thức Thanh Toán: ${order.payment_method}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Nhân Viên Phục Vụ: ${order.admin}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },

                    // Đường phân tách
                    { text: ' ', border: [false, true, false, false], margin: [0, 10] },

                    // Chi tiết sản phẩm
                    { 
                        text: 'Chi Tiết Sản Phẩm', 
                        fontSize: 14, 
                        bold: true, 
                        alignment: 'center', 
                        margin: [0, 10]
                    },

                    // Tiêu đề cột
                    {
                        style: 'tableHeader',
                        table: {
                            widths: ['10%', '35%', '20%', '10%', '15%', '20%'],
                            body: [
                                ['STT', 'Tên Sản Phẩm', 'Mã SP', 'Số Lượng', 'Đơn Giá', 'Thành Tiền'],
                                ...order.products.map((item, index) => [
                                    index + 1,
                                    item.product_name,
                                    item.product_code,
                                    item.quantity,
                                    formatCurrencyVN(item.product_price),
                                    formatCurrencyVN(item.total_amount)
                                ])
                            ]
                        },
                        layout: 'lightHorizontalLines'
                    },

                    // Tổng kết
                    { text: ' ', border: [false, true, false, false], margin: [0, 10] },

                    // Tổng tiền
                   
                    { 
                        text: `Giảm Giá: ${formatCurrencyVN(order.discount || 0)}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Phí Vận Chuyển: ${formatCurrencyVN(order.shipping_fee || 0)}`, 
                        fontSize: 12, 
                        margin: [0, 5]
                    },
                    { 
                        text: `Tổng Tiền: ${formatCurrencyVN(order.total_amount)}`, 
                        fontSize: 12, 
                        bold: true, 
                        margin: [0, 5]
                    },
                ],
                defaultStyle: {
                    // Loại bỏ font cụ thể
                },
                styles: {
                    tableHeader: {
                        bold: true,
                        fontSize: 12,
                        alignment: 'center',
                        fillColor: '#f2f2f2'
                    }
                }
            };

            // Tạo và lưu PDF
            pdfMake.createPdf(docDefinition).download(`Hoadon_${order.order_id}.pdf`);
        })
        .catch(error => {
            console.error('Lỗi khi xuất hóa đơn:', error);
        });
}

// Giữ nguyên các hàm hỗ trợ như trước
function formatDateVN(dateString) {
    try {
        return new Date(dateString).toLocaleDateString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    } catch {
        return dateString;
    }
}

function formatCurrencyVN(amount) {
    try {
        // Kiểm tra nếu amount là 'No Discount' hoặc không phải số
        if (amount === 'No Discount' || isNaN(amount)) {
            return '0 VND'; // Trả về 0 nếu không có giảm giá hoặc giá trị không phải số
        }
        // Nếu amount là số, định dạng thành tiền tệ
        return new Intl.NumberFormat('vi-VN', { 
            style: 'currency', 
            currency: 'VND' 
        }).format(amount);
    } catch {
        return '0 VND'; // Trả về 0 nếu có lỗi trong quá trình xử lý
    }
}



function formatOrderStatus(status) {
    const statusMap = {
        'pending': 'Đang Chờ',
        'processing': 'Đang Xử Lý',
        'completed': 'Đã Hoàn Thành',
        'cancelled': 'Đã Hủy'
    };
    return statusMap[status] || status;
}

function calculateTotalPayment(order) {
    const total = order.total_amount - (order.discount || 0) + (order.shipping_fee || 0);
    return total;
}



        function attachEventListeners() {
            document.querySelectorAll('.change-status').forEach(button => {
                button.addEventListener('click', () => {
                    const orderId = button.dataset.id;
                    const newStatus = button.dataset.status;
                    changeOrderStatus(orderId, newStatus);
                });
            });

            document.querySelectorAll('.cancel-order').forEach(button => {
                button.addEventListener('click', () => {
                    const orderId = button.dataset.id;
                    const reason = prompt('Lý do hủy đơn hàng:');
                    if (reason) cancelOrder(orderId, reason);
                });
            });

            document.querySelectorAll('.delete-order').forEach(button => {
                button.addEventListener('click', () => {
                    const orderId = button.dataset.id;
                    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')) deleteOrder(orderId);
                });
            });
            document.querySelectorAll('.export-invoice').forEach(button => {
        button.addEventListener('click', () => {
            const orderId = button.dataset.id;
            exportInvoice(orderId);
        });
    });
    document.getElementById('selectAll').addEventListener('change', function () {
        const isChecked = this.checked; // Lấy trạng thái của checkbox cha
        const checkboxes = document.querySelectorAll('#orderTable .checkbox-cell input[type="checkbox"]');

        // Lặp qua tất cả checkbox con và thay đổi trạng thái
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });
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

        }

        function changeOrderStatus(orderId, status) {
    // Lấy CSRF token từ thẻ meta
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://localhost/web_ban_banh_kem/public/api/orders/change-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Thêm CSRF token vào header
        },
        body: JSON.stringify({ id: orderId, status })
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchOrders(); // Tải lại danh sách đơn hàng
        })
        .catch(error => console.error('Error changing status:', error));
}
document.getElementById('displayLimit').addEventListener('change', () => {
    console.log('Display limit changed');
    fetchOrders();
});

document.querySelector('.search-box').addEventListener('input', () => {
    console.log('Search input triggered');
    fetchOrders();
});

document.getElementById('categoryFilter').addEventListener('change', () => {
    console.log('Category filter changed');
    fetchOrders();
});

document.getElementById('sortOption').addEventListener('change', () => {
    console.log('Sort option changed');
    fetchOrders();
});




function cancelOrder(orderId, reason) {
    // Lấy CSRF Token từ thẻ meta
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('http://localhost/web_ban_banh_kem/public/api/orders/cancel', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Thêm token vào header
        },
        body: JSON.stringify({ id: orderId, reason })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        fetchOrders(); // Tải lại danh sách đơn hàng
    })
    .catch(error => console.error('Error cancelling order:', error));
}


        function deleteOrder(orderId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Lấy token từ thẻ meta

    fetch(`http://localhost/web_ban_banh_kem/public/api/orders/${orderId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token // Thêm token vào header
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể xóa đơn hàng. Vui lòng thử lại!');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            fetchOrders(); // Tải lại danh sách đơn hàng
        })
        .catch(error => console.error('Lỗi khi xóa đơn hàng:', error));
}

    });
    document.addEventListener('DOMContentLoaded', function () {
    // Sự kiện khi nhấn nút "Xem"
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('view-details')) {
            const orderId = e.target.dataset.id;

            // Gửi yêu cầu tới server để lấy chi tiết đơn hàng
            fetch(`http://localhost/web_ban_banh_kem/public/orders/${orderId}/details`)
                .then(response => response.json())
                .then(data => {
                    const detailsTable = document.getElementById('orderDetailsTable');
                    detailsTable.innerHTML = ''; // Xóa nội dung cũ

                    // Duyệt qua từng sản phẩm và thêm vào bảng
                    data.data.forEach(detail => {
                        const row = `
                            <tr>
                                <td><img src="http://localhost/web_ban_banh_kem/public/images/${detail.product_image}" alt="${detail.product_name}" style="width: 80px; height: 80px;"></td>
                                <td>${detail.product_code}</td>
                                <td>${detail.product_name}</td>
                                <td>${detail.quantity}</td>
                                <td>${formatCurrency(detail.amount)}</td>
                            </tr>
                        `;
                        detailsTable.insertAdjacentHTML('beforeend', row);
                    });

                    // Hiển thị modal
                    $('#orderDetailsModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    alert('Không thể tải chi tiết đơn hàng.');
                });
        }
    });
});
// Lắng nghe sự kiện khi nhấn vào nút "Xuất Excel"
document.querySelector('.excel-export-btn').addEventListener('click', function() {
    // Hiển thị các nút "In tất cả" và "In đã chọn"
    const excelOptions = document.querySelector('.excel-options');
    excelOptions.style.display = 'block';
});

// Lắng nghe sự kiện khi nhấn vào nút "In tất cả"
// Lắng nghe sự kiện khi nhấn vào nút "Xuất Excel"
document.querySelector('.excel-export-btn').addEventListener('click', function(event) {
    // Hiển thị các nút "In tất cả" và "In đã chọn"
    const excelOptions = document.querySelector('.excel-options');
    excelOptions.style.display = 'block';

    // Ngừng sự kiện click để tránh sự kiện này lan ra ngoài khi nhấn vào nút "Xuất Excel"
    event.stopPropagation();
});

// Lắng nghe sự kiện khi nhấn vào nút "In tất cả"
document.getElementById('exportAll').addEventListener('click', function() {
    const tableRows = document.querySelectorAll('#orderTable tr');
    let selectedData = [];

    tableRows.forEach(row => {
        const rowData = [];
        row.querySelectorAll('td').forEach((cell, index) => {
            // Loại bỏ cột "Thông tin chi tiết đơn hàng" ở đây (index = 9)
            if (index !== 9) {
                rowData.push(cell.textContent.trim() || 'Không có');
            }
        });
        selectedData.push(rowData);
    });

    if (selectedData.length === 0) {
        alert('Không có dữ liệu để xuất!');
        return;
    }

    const ws = XLSX.utils.aoa_to_sheet(selectedData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Dữ liệu đơn hàng");
    XLSX.writeFile(wb, 'DonHang.xlsx');

    // Ẩn các nút lựa chọn sau khi xuất
    document.querySelector('.excel-options').style.display = 'none';
});

// Lắng nghe sự kiện khi nhấn vào nút "In đã chọn"
document.getElementById('exportSelected').addEventListener('click', function() {
    const tableRows = document.querySelectorAll('#orderTable tr');
    let selectedData = [];

    tableRows.forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox && checkbox.checked) {
            const rowData = [];
            row.querySelectorAll('td').forEach((cell, index) => {
                // Loại bỏ cột "Thông tin chi tiết đơn hàng" ở đây (index = 9)
                if (index !== 9) {
                    rowData.push(cell.textContent.trim() || 'Không có');
                }
            });
            selectedData.push(rowData);
        }
    });

    if (selectedData.length === 0) {
        alert('Không có dữ liệu để xuất!');
        return;
    }

    const ws = XLSX.utils.aoa_to_sheet(selectedData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Dữ liệu đơn hàng");
    XLSX.writeFile(wb, 'DonHang.xlsx');

    // Ẩn các nút lựa chọn sau khi xuất
    document.querySelector('.excel-options').style.display = 'none';
});

// Lắng nghe sự kiện khi nhấn ra ngoài khu vực các nút "In tất cả" và "In đã chọn"
document.addEventListener('click', function(event) {
    const excelOptions = document.querySelector('.excel-options');
    const exportBtn = document.querySelector('.excel-export-btn');

    // Kiểm tra nếu nhấn ra ngoài khu vực các nút "In tất cả" và "In đã chọn"
    if (!excelOptions.contains(event.target) && event.target !== exportBtn) {
        excelOptions.style.display = 'none';  // Ẩn các nút khi nhấn ra ngoài
    }
});

// Lắng nghe sự kiện khi nhấn vào nút tra cứu
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
                openOrderDetailsModal(data.user_id);
            } else {
                alert('Không tìm thấy người dùng với mã QR này!');
            }
        })
        .catch(error => {
            console.error('Lỗi tìm kiếm mã QR:', error);
            alert('Đã có lỗi xảy ra khi tra cứu mã QR!');
        });
}

// Khi click vào tra cứu thẻ, mở modal
// Biến lưu trữ userId khi mở modal
let currentUserId = null;

// Hàm mở modal và lấy userId
function openOrderDetailsModal(userId) {
    
    currentUserId = userId;  // Lưu userId khi mở modal
    const dropdown = document.getElementById('dropdownContent');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    }
    document.getElementById('orderDetailModal').style.display = 'block';
    fetchOrders(currentUserId);  // Truyền userId vào hàm fetchOrders
    
}

// Lắng nghe sự kiện áp dụng bộ lọc
document.getElementById('applyFilters').addEventListener('click', function() {
    if (currentUserId) {
        fetchOrders(currentUserId);  // Sử dụng currentUserId để lấy đơn hàng
    } else {
        alert('Không có userId. Vui lòng thử lại.');
    }
});

// Hàm lấy các đơn hàng của userId với các bộ lọc
function fetchOrders(userId) {
    const status = document.getElementById('orderStatus').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    // Gọi API với user_id và các bộ lọc
    const url = `http://localhost/web_ban_banh_kem/public/api/order?user_id=${userId}&status=${status}&start_date=${startDate}&end_date=${endDate}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.orders) {
                const tableBody = document.getElementById('orderTableBody');
                tableBody.innerHTML = ''; // Xóa dữ liệu cũ

                // Duyệt qua các đơn hàng và hiển thị lên bảng
                data.orders.forEach(order => {
                    const row = document.createElement('tr');
                    const productDetails = order.order_details.map(detail => `
                        Mã SP: ${detail.product.id}<br>
                        Tên SP: ${detail.product.name}<br>
                        Số lượng: ${detail.quantity}<br>
                        Giá: ${formatCurrency(detail.product.price)}
                        <hr>
                    `).join('');

                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${formatCurrency(order.total_amount)}</td>
                        <td>${order.status}</td>
                        <td>${new Date(order.created_at).toLocaleDateString()}</td>
                        <td>${order.notes || 'Không có'}</td>
                        <td>${productDetails}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Lỗi khi lấy đơn hàng:', error));
}


// Hàm xuất Excel
document.getElementById('exportExcelBtn').addEventListener('click', function() {
    const table = document.getElementById('orderTable');
    const workbook = XLSX.utils.table_to_book(table, { sheet: "Orders" });
    XLSX.writeFile(workbook, 'orders.xlsx');
});

// Đóng modal
document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('orderDetailModal').style.display = 'none';
});
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}
let chart;

function openModalStatic() {
    document.getElementById('orderStaticModal').style.display = 'block';
    loadInitialStats();
}

function closeModalStatic() {
    document.getElementById('orderStaticModal').style.display = 'none';
}

function loadInitialStats() {
    // Tải dữ liệu thống kê ban đầu (ví dụ: doanh thu tổng, số hóa đơn,...)
    fetch('http://localhost/web_ban_banh_kem/public/api/initial-stats')
        .then(response => response.json())
        .then(data => {
            updateStatsList(data.stats);
            renderChart('bar', data.chartData);
        })
        .catch(error => console.error('Lỗi tải thống kê:', error));
}

function applyFilters() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const status = document.getElementById('statusFilter').value;

    const url = `http://localhost/web_ban_banh_kem/public/api/stats?start_date=${startDate}&end_date=${endDate}&status=${status}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            updateStatsList(data.stats);
            renderChart(document.getElementById('chartType').value, data.chartData);
        })
        .catch(error => console.error('Lỗi áp dụng bộ lọc:', error));
}

function updateStatsList(stats) {
    const statsList = document.getElementById('orderStatsList');
    statsList.innerHTML = '';
    stats.forEach(stat => {
        const li = document.createElement('li');
        li.textContent = `${stat.label}: ${stat.value}`;
        statsList.appendChild(li);
    });
}

function renderChart(type, data) {
    const ctx = document.getElementById('orderChart').getContext('2d');
    if (chart) chart.destroy();
    chart = new Chart(ctx, {
        type: type,
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
            },
        },
    });
}


function updateChartType() {
    const chartType = document.getElementById('chartType').value;
    applyFilters(); // Cập nhật dữ liệu và biểu đồ với loại biểu đồ mới
}
function openHistoryModal() {
    document.getElementById('historyModal').style.display = 'block';
    fetchHistory(); // Tải dữ liệu ban đầu
}

// Đóng modal
function closeHistoryModal() {
    document.getElementById('historyModal').style.display = 'none';
}

// Lấy dữ liệu lịch sử từ server
function fetchHistory() {
    const dateFrom = document.getElementById('filterDateFrom').value;
    const dateTo = document.getElementById('filterDateTo').value;
    const action = document.getElementById('filterAction').value;

    fetch('http://localhost/web_ban_banh_kem/public/orders/history', {
        method: 'POST', // Keep as POST if your backend expects POST
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json', // Add this to explicitly request JSON
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            date_from: dateFrom, 
            date_to: dateTo, 
            action: action 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const tableBody = document.getElementById('historyTableBody');
        tableBody.innerHTML = ''; 

        data.forEach(log => {
            const row = `
                <tr>
                    <td>${log.id}</td>
                    <td>${log.action}</td>
                    <td>${log.action_content}</td>
                    <td>${log.admin_id}</td>
                    <td>${log.created_at}</td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    })
    .catch(error => {
        console.error('Error fetching history:', error);
        // Optional: Add user-friendly error handling
        alert('Failed to fetch order history. Please try again.');
    });
}
function openDateRangeModal() {
        document.getElementById('dateRangeModal').style.display = 'block';
    }

    function closeDateRangeModal() {
        document.getElementById('dateRangeModal').style.display = 'none';
    }

    function generatePDF() {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;

    // Kiểm tra khoảng thời gian
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    const diffDays = Math.floor((toDate - fromDate) / (1000 * 3600 * 24));

    if (diffDays <= 15) {
        alert("Khoảng thời gian phải lớn hơn 15 ngày.");
        return;
    }

    // Gửi yêu cầu đến server để lấy báo cáo
    fetch(`http://localhost/web_ban_banh_kem/public/orders/report?date_from=${dateFrom}&date_to=${dateTo}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Tạo PDF với dữ liệu trả về
        const docDefinition = {
            content: [
                { text: `Báo cáo đơn hàng từ ${dateFrom} đến ${dateTo}`, fontSize: 18, bold: true },
                { text: `Tổng đơn hàng: ${data.total_orders}`, fontSize: 14 },
                { text: `Tổng doanh thu: ${data.total_amount.toLocaleString()} VNĐ`, fontSize: 14 },
                { text: `Số lượng sản phẩm bán ra: ${data.total_products_sold}`, fontSize: 14 },
                { text: `Khách hàng mới: ${data.new_customers}`, fontSize: 14 },
                
                { text: 'Thống kê theo trạng thái:', fontSize: 16, bold: true },
                {
                    table: {
                        headerRows: 1,
                        widths: ['*', '*'],
                        body: [
                            ['Trạng thái', 'Số lượng'],
                            ...Object.entries(data.status_stats).map(([status, count]) => [status || 'Không xác định', count || 0])
                        ]
                    }
                },
                
                { text: 'Thống kê theo phương thức thanh toán:', fontSize: 16, bold: true },
                {
                    table: {
                        headerRows: 1,
                        widths: ['*', '*'],
                        body: [
                            ['Phương thức thanh toán', 'Số lượng'],
                            ...Object.entries(data.payment_method_stats).map(([method, count]) => [method || 'Không xác định', count || 0])
                        ]
                    }
                },
                
                { text: 'Sản phẩm bán chạy nhất:', fontSize: 16, bold: true },
                {
                    table: {
                        headerRows: 1,
                        widths: ['*', '*'],
                        body: [
                            ['Sản phẩm', 'Số lượng bán'],
                            ...data.top_products.map(product => [
                                product.product_id || 'Không xác định', 
                                product.total_sold || 0
                            ])
                        ]
                    }
                },
                
                { text: 'Chi tiết đơn hàng:', fontSize: 16, bold: true },
                {
                    table: {
                        headerRows: 1,
                        widths: ['*', '*', '*', 'auto'],
                        body: [
                            ['Mã đơn hàng', 'Tổng tiền', 'Số lượng sản phẩm', 'Trạng thái'],
                            ...data.orders.map(order => [
                                order.id || 'N/A',
                                (order.total_amount ? order.total_amount.toLocaleString() : 'N/A') + ' VNĐ',
                                order.total_products_sold || 0,
                                order.status || 'Không xác định'
                            ])
                        ]
                    }
                }
            ]
        };

        // Tạo PDF và tải về
        pdfMake.createPdf(docDefinition).download('bao_cao_don_hang.pdf');
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        alert('Có lỗi xảy ra khi tải báo cáo');
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