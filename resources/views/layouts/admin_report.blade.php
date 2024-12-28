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
.report-management {
    font-family: Arial, sans-serif;
    padding: 20px;
  }

  .tabs {
    display: flex;
    margin-bottom: 20px;
  }

  .tab-btn {
    padding: 10px 20px;
    border: none;
    background: #f0f0f0;
    cursor: pointer;
    margin-right: 10px;
    border-radius: 5px;
    position: relative;
    font-size: 16px;
  }

  .tab-btn.active {
    background: #007bff;
    color: white;
  }

  .dot {
    height: 10px;
    width: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-left: 10px;
    background: transparent;
  }

  .dot.red {
    background: red;
  }

  .tab-content {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    background: #fff;
  }

  .tab-pane {
    display: none;
  }

  .tab-pane.active {
    display: block;
  }

  .list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .list-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
  }

  .list-item:hover {
    background: #f9f9f9;
  }

  .comment-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }

  .no-comments {
    color: #888;
  }

  .comment-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.comment-item strong {
    font-weight: bold;
    margin-right: 10px;
}

.comment-item p {
    margin: 0;
    color: #555;
}

.comment-item .report-content {
    font-size: 0.9rem;
    color: #d9534f;
    margin-top: 5px;
}

.comment-item .comment-buttons {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
}

.comment-item .comment-buttons button {
    background-color: #0275d8;
    color: white;
    border: none;
    padding: 5px 10px;
    margin: 2px 0;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem;
}

.comment-item .comment-buttons button.delete {
    background-color: #d9534f;
}

.comment-item .comment-buttons button.complete {
    background-color: #5bc0de;
}

.comment-item .comment-buttons button:hover {
    opacity: 0.8;
}

.comment-item.no-comments {
    text-align: center;
    font-style: italic;
    color: #777;
}

.comment-item .content-wrapper {
    flex: 1;
}

.comment-item .content-wrapper p {
    margin: 5px 0;
}

.reply-box {
    position: absolute; /* Định vị tuyệt đối */
    left: 0;
    right: 0;
    margin-top: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    background-color: #f9f9f9;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    z-index: 10; /* Đảm bảo hiển thị trên các phần tử khác */
}

.comment-item {
    position: relative; /* Để reply-box được định vị tương đối với phần tử này */
}

.reply-textarea {
    width: 100%;
    min-height: 100px;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
}

.reply-action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.send-reply, .cancel-reply {
    padding: 8px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.send-reply {
    background-color: #4CAF50;
    color: white;
}

.cancel-reply {
    background-color: #f44336;
    color: white;
}

.send-reply:hover {
    background-color: #45a049;
}

.cancel-reply:hover {
    background-color: #d32f2f;
}
.list-item {
  padding: 10px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.list-item:hover {
  background-color: #f5f5f5;
}

.list-item.highlighted {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}
.block-user-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    width: 80%;
    max-width: 800px;
    z-index: 1000;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none;
}

.block-user-modal.hidden {
    display: none;
}

.modal-body {
    display: flex;
    gap: 20px;
}

.user-list {
    flex: 1;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    max-height: 400px;
    overflow-y: auto;
}

.search-box {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.modal-close-btn {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.block-user-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    width: 80%;
    max-width: 800px;
    z-index: 1000;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: none; /* Mặc định không hiển thị */
}

.block-user-modal.hidden {
    display: none; /* Ẩn khi có class "hidden" */
}

.block-user-modal:not(.hidden) {
    display: block; /* Hiển thị khi không có class "hidden" */
}
/* Tổng thể modal */
.block-user-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    border-radius: 10px;
    width: 80%;
    max-width: 1000px;
    z-index: 1000;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
    padding: 20px;
    display: none;
    flex-direction: column;
    gap: 20px;
}

.block-user-modal:not(.hidden) {
    display: flex;
}

/* Modal header */
.block-user-modal h2 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin: 0;
    color: #333;
}

/* Modal body */
.modal-body {
    display: flex;
    gap: 20px;
    justify-content: space-between;
}

/* Phần danh sách người dùng */
.user-section {
    display: flex;
    width: 100%;
    justify-content: space-between;
}

.user-list {
    width: 48%; /* Chiều rộng mỗi danh sách */
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    max-height: 400px;
    overflow-y: auto;
}

/* Tiêu đề */
.user-list h3 {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
    text-align: center;
    color: #555;
}

/* Search box */
.search-box {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    font-size: 14px;
}

/* Danh sách người dùng */
.user-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.user-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.user-list li:last-child {
    border-bottom: none;
}

.user-list button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.user-list button:hover {
    background-color: #0056b3;
}

/* Close button */
.modal-close-btn {
    align-self: flex-end;
    background-color: #dc3545;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.modal-close-btn:hover {
    background-color: #b02a37;
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
    <!-- Header với title và user info cùng hàng -->
    <div class="page-header">
    <div class="page-title">
    <h2>Quản Lý Báo Cáo</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
    <div class="toolbar">
    <button class="toolbar-btn excel-export-btn" id="block-user-btn">
    <i class="fas fa-users-slash"></i> Quản lí chặn người dùng
</button>
    
</div>
<div class="report-management">
    <!-- Tab Navigation -->
    <div class="tabs">
      <button class="tab-btn active" data-tab="product-reports">
        Báo cáo bình luận sản phẩm
        <span class="dot red"></span>
      </button>
      <button class="tab-btn" data-tab="order-reports">
        Báo cáo đơn hàng
        <span class="dot red"></span>
      </button>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
      <!-- Product Reports Tab -->
      <div id="product-reports" class="tab-pane active">
  <div class="product-reports" style="display: flex; gap: 20px;">
    <!-- Danh sách sản phẩm -->
    <div class="product-list" style="flex: 1;">
      <h3>Danh sách sản phẩm</h3>
      <ul class="list" id="product-list">
        <!-- Sản phẩm sẽ được thêm vào đây qua JavaScript -->
        <li class="list-item no-products">Đang tải danh sách sản phẩm...</li>
      </ul>
    </div>

    <!-- Danh sách bình luận -->
    <div class="comment-list" style="flex: 2;">
      <h3>Bình luận</h3>

      <!-- Bình luận bị báo cáo -->
      <h4>Bình luận bị báo cáo</h4>
      <ul class="comments" id="reported-comments">
        <li class="comment-item no-comments">Chọn sản phẩm để xem bình luận bị báo cáo</li>
      </ul>

      <!-- Tất cả bình luận -->
      <h4>Tất cả bình luận</h4>
      <ul class="comments" id="all-comments">
        <li class="comment-item no-comments">Chọn sản phẩm để xem tất cả bình luận</li>
      </ul>
    </div>
  </div>
</div>





      <!-- Order Reports Tab -->
      <div id="order-reports" class="tab-pane">
        <div class="order-reports" style="display: flex; gap: 20px;">
          <!-- Order List -->
          <div class="order-list" style="flex: 1;">
            <h3>Danh sách báo cáo đơn hàng</h3>
            <ul class="list">
              <li class="list-item">
                <span class="order-id">Đơn hàng #1234</span>
                <span class="dot red"></span>
              </li>
              <li class="list-item">
                <span class="order-id">Đơn hàng #5678</span>
                <span class="dot"></span>
              </li>
            </ul>
          </div>

          <!-- Order Details -->
          <div class="order-details" style="flex: 2;">
            <h3>Chi tiết đơn hàng</h3>
            <div class="details-content">
              <p>Vui lòng chọn một đơn hàng để xem chi tiết.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div id="blockUserModal" class="block-user-modal hidden">
    <h2>Quản lý chặn người dùng</h2>
    <div class="modal-body">
        <!-- Danh sách người dùng -->
        <div class="user-list active-users">
            <h3>Danh sách người dùng</h3>
            <input type="text" class="search-box" id="active-user-search" placeholder="Tìm kiếm người dùng...">
            <ul id="active-users">
                <!-- Danh sách người dùng sẽ được render tại đây -->
            </ul>
        </div>

        <!-- Danh sách người dùng bị khóa -->
        <div class="user-list blocked-users">
            <h3>Danh sách người dùng bị khóa</h3>
            <input type="text" class="search-box" id="blocked-user-search" placeholder="Tìm kiếm người dùng bị khóa...">
            <ul id="blocked-users">
                <!-- Danh sách người dùng bị khóa sẽ được render tại đây -->
            </ul>
        </div>
    </div>
    <button class="modal-close-btn" id="close-block-user-modal">Đóng</button>
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
      
        document.querySelectorAll('.tab-btn').forEach(button => {
    button.addEventListener('click', () => {
      const tabId = button.getAttribute('data-tab');

      // Remove active class from all buttons and tabs
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));

      // Add active class to the clicked button and corresponding tab
      button.classList.add('active');
      document.getElementById(tabId).classList.add('active');
    });
  });


  fetch('http://localhost/web_ban_banh_kem/public/admin/api/products/reports')
  .then(response => response.json())
  .then(data => {
    const productList = document.getElementById('product-list');
    const reportedCommentsList = document.getElementById('reported-comments');
    const allCommentsList = document.getElementById('all-comments');
    const replyModal = document.getElementById('replyModal'); // Modal trả lời bình luận
    const replyContent = document.getElementById('replyContent'); // Textarea trong modal
    let currentCommentId = null; // Biến lưu id bình luận hiện tại để trả lời

    // Clear previous lists
    productList.innerHTML = '';
    reportedCommentsList.innerHTML = '';
    allCommentsList.innerHTML = '';

    if (data) {
      console.log(data);  // Debug: kiểm tra cấu trúc dữ liệu

      const sortedProducts = Object.keys(data).map(productId => data[productId]).sort((a, b) => {
        const hasReportA = a.comments.some(comment => comment.has_report);
        const hasReportB = b.comments.some(comment => comment.has_report);
        return hasReportB - hasReportA; // Đưa sản phẩm có báo cáo lên trên
      });

      sortedProducts.forEach(product => {
        const productItem = document.createElement('li');
        productItem.classList.add('list-item');
        productItem.dataset.productId = product.id;

        const productName = document.createElement('span');
        productName.classList.add('product-name');
        productName.textContent = product.product_name;

        const dot = document.createElement('span');
        dot.classList.add('dot');
        if (product.comments.some(comment => comment.has_report)) {
          dot.classList.add('red');
        }

        productItem.appendChild(productName);
        productItem.appendChild(dot);
        productList.appendChild(productItem);

        productItem.addEventListener('click', () => {
          // Clear the comments list
          document.querySelectorAll('.list-item').forEach(item => {
    item.classList.remove('highlighted');
  });

  // 2. Thêm highlight cho mục hiện tại
  productItem.classList.add('highlighted');
          reportedCommentsList.innerHTML = '';
          allCommentsList.innerHTML = '';

          // Lấy danh sách bình luận của sản phẩm từ API
          fetch(`http://localhost/web_ban_banh_kem/public/admin/api/products/${product.id}/comments`)
            .then(response => response.json())
            .then(commentsData => {
              if (commentsData.comments && commentsData.comments.length > 0) {
                commentsData.comments.forEach(comment => {
                  const commentItem = document.createElement('li');
                  commentItem.classList.add('comment-item');

                  const contentWrapper = document.createElement('div');
                  contentWrapper.classList.add('content-wrapper');

                  const userName = document.createElement('strong');
                  userName.textContent = comment.user_id + " - " + comment.user.name + ": ";

                  const content = document.createElement('p');
                  content.textContent = comment.content;

                  // Hiển thị lý do báo cáo nếu có
                  if (comment.reports.length > 0) {
    const reportContent = document.createElement('p');
    reportContent.classList.add('report-content');
    reportContent.textContent = "Lý do báo cáo: " + comment.reports.map(report => report.content).join(', ');

    contentWrapper.appendChild(userName);
    contentWrapper.appendChild(content);
    contentWrapper.appendChild(reportContent);
} else {
    contentWrapper.appendChild(userName);
    contentWrapper.appendChild(content);
}

// Tạo nút xóa, trả lời và hoàn thành báo cáo
const buttons = document.createElement('div');
buttons.classList.add('comment-buttons');


               

                  const completeButton = document.createElement('button');
                  completeButton.classList.add('complete');
                  completeButton.textContent = "Hoàn thành báo cáo";

                  
const deleteButton = document.createElement('button');
deleteButton.classList.add('delete');
deleteButton.textContent = "Xóa";

const replyButton = document.createElement('button');
replyButton.classList.add('reply');
replyButton.textContent = "Trả lời";

// Tạo div chứa hộp thoại trả lời
const replyBox = document.createElement('div');
replyBox.classList.add('reply-box');
replyBox.style.display = 'none'; // Ẩn ban đầu

// Tạo textarea để nhập câu trả lời
const replyTextarea = document.createElement('textarea');
replyTextarea.classList.add('reply-textarea');
replyTextarea.placeholder = 'Nhập câu trả lời...';

// Tạo nút gửi trả lời
const sendReplyButton = document.createElement('button');
sendReplyButton.classList.add('send-reply');
sendReplyButton.textContent = 'Gửi';

// Tạo nút hủy
const cancelReplyButton = document.createElement('button');
cancelReplyButton.classList.add('cancel-reply');
cancelReplyButton.textContent = 'Hủy';

// Tạo div chứa các nút
const replyActionButtons = document.createElement('div');
replyActionButtons.classList.add('reply-action-buttons');
replyActionButtons.appendChild(sendReplyButton);
replyActionButtons.appendChild(cancelReplyButton);

// Thêm textarea và nút vào replyBox
replyBox.appendChild(replyTextarea);
replyBox.appendChild(replyActionButtons);

// Sự kiện khi bấm nút trả lời
replyButton.addEventListener('click', () => {
    // Ẩn các hộp trả lời khác
    document.querySelectorAll('.reply-box').forEach(box => {
        box.style.display = 'none';
    });

    // Hiển thị hộp trả lời của bình luận hiện tại
    if (replyBox.style.display === 'none') {
        replyBox.style.display = 'block';
        replyTextarea.focus();
    } else {
        replyBox.style.display = 'none';
    }
});

// Sự kiện hủy trả lời
cancelReplyButton.addEventListener('click', () => {
    replyBox.style.display = 'none';
    replyTextarea.value = ''; // Xóa nội dung textarea
});

// Sự kiện gửi trả lời
sendReplyButton.addEventListener('click', () => {
    const replyText = replyTextarea.value.trim();
    if (replyText) {
        // Gửi câu trả lời 
        fetch(`http://localhost/web_ban_banh_kem/public/admin/comments/${comment.id}/reply`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content: replyText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Câu trả lời đã được gửi.');
                replyBox.style.display = 'none';
                replyTextarea.value = '';
            } else {
                alert('Đã xảy ra lỗi. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        });
    } else {
        alert('Vui lòng nhập nội dung trả lời.');
    }
});

// Thêm nút và replyBox vào commentItem
const buttonContainer = buttons;
buttonContainer.appendChild(replyButton);
commentItem.appendChild(buttonContainer);
commentItem.appendChild(replyBox);

// Chỉ tạo và thêm nút hoàn thành báo cáo khi có báo cáo
if (comment.reports.length > 0) {
    const completeButton = document.createElement('button');
    completeButton.classList.add('complete');
    completeButton.textContent = "Hoàn thành báo cáo";

    
    buttons.appendChild(completeButton);
    completeButton.addEventListener('click', () => {
                    fetch(`http://localhost/web_ban_banh_kem/public/admin/api/reports/${comment.id}/complete`, {
                      method: 'POST',
                      headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                      },
                    })
                    .then(response => {
                      if (response.ok) {
                        commentItem.remove();
                        if (reportedCommentsList.childNodes.length === 0) {
                          reportedCommentsList.innerHTML = '<li class="comment-item no-comments">Không có bình luận bị báo cáo</li>';
                        }
                      } else {
                        alert('Không thể hoàn thành báo cáo. Vui lòng thử lại.');
                      }
                    })
                    .catch(error => {
                      alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    });
                  });
}
buttons.appendChild(deleteButton);
buttons.appendChild(replyButton);
                  commentItem.appendChild(contentWrapper);
                  commentItem.appendChild(buttons);

                  // Sự kiện xóa bình luận
                  deleteButton.addEventListener('click', () => {
                    const confirmDelete = confirm("Bạn có chắc muốn xóa bình luận này không?");
                    if (confirmDelete) {
                      fetch(`http://localhost/web_ban_banh_kem/public/admin/comments/${comment.id}`, {
                        method: 'DELETE',
                        headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                          'Content-Type': 'application/json',
                        },
                      })
                      .then(response => response.json())
                      .then(data => {
                        if (data.message === 'Bình luận đã được xóa thành công.') {
                          commentItem.remove();
                          alert('Bình luận đã được xóa.');
                        } else {
                          alert(data.message || 'Đã xảy ra lỗi. Vui lòng thử lại.');
                        }
                      })
                      .catch(error => {
                        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                      });
                    }
                  });

                  // Sự kiện hoàn thành báo cáo
                 

                  // Mở modal trả lời bình luận
                  replyButton.addEventListener('click', () => {
                    currentCommentId = comment.id;  // Lưu lại id bình luận để trả lời
                    replyModal.style.display = 'block';  // Hiển thị modal trả lời
                  });

                  // Thêm bình luận vào danh sách tất cả bình luận hoặc bình luận bị báo cáo
                  if (comment.reports.length > 0) {
                    reportedCommentsList.appendChild(commentItem);
                  } else {
                    allCommentsList.appendChild(commentItem);
                  }
                });
              } else {
                allCommentsList.innerHTML = '<li class="comment-item no-comments">Không có bình luận nào</li>';
              }
            })
            .catch(error => {
              console.error('Lỗi khi lấy bình luận: ', error);
              allCommentsList.innerHTML = '<li class="comment-item no-comments">Đã xảy ra lỗi khi lấy bình luận</li>';
            });
        });
      });
    } else {
      productList.innerHTML = '<li class="list-item no-products">Không có sản phẩm nào có báo cáo bình luận</li>';
    }
  })
  .catch(error => {
    console.error("Có lỗi xảy ra khi lấy dữ liệu sản phẩm: ", error);
  });

// Hàm đóng modal trả lời
function closeModal() {
  replyModal.style.display = 'none';
  replyContent.value = '';  // Xóa nội dung textarea
}

// Hàm gửi câu trả lời
function submitReply() {
  const replyText = replyContent.value.trim();
  if (!replyText) {
    alert('Vui lòng nhập câu trả lời.');
    return;
  }

  fetch(`http://localhost/web_ban_banh_kem/public/admin/comments/${currentCommentId}/reply`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ content: replyText })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Câu trả lời đã được gửi.');
      closeModal();
    } else {
      alert('Đã xảy ra lỗi. Vui lòng thử lại.');
    }
  })
  .catch(error => {
    alert('Đã xảy ra lỗi. Vui lòng thử lại.');
  });
}
fetch('http://localhost/web_ban_banh_kem/public/admin/api/order-reports')
  .then(response => response.json())
  .then(data => {
    const orderList = document.querySelector('.order-list .list');
    const orderDetails = document.querySelector('.order-details .details-content');

    // Xóa danh sách cũ
    orderList.innerHTML = '';

    if (data.success && data.data.length > 0) {
      data.data.forEach(order => {
        const orderItem = document.createElement('li');
        orderItem.classList.add('list-item');
        orderItem.dataset.orderId = order.order_id;

        // Thông tin hóa đơn
        const orderIdSpan = document.createElement('span');
        orderIdSpan.classList.add('order-id');
        orderIdSpan.textContent = `Đơn hàng #${order.order_id}`;

        // Dot màu đỏ
        const dot = document.createElement('span');
        dot.classList.add('dot', 'red');

        // Thêm vào danh sách
        orderItem.appendChild(orderIdSpan);
        orderItem.appendChild(dot);
        orderList.appendChild(orderItem);

        // Sự kiện click để hiển thị chi tiết
        orderItem.addEventListener('click', () => {
          // Highlight mục được chọn
          document.querySelectorAll('.list-item').forEach(item => item.classList.remove('highlighted'));
          orderItem.classList.add('highlighted');

          // Hiển thị thông tin chi tiết hóa đơn
          orderDetails.innerHTML = `
            <h4>Chi tiết đơn hàng #${order.order_id}</h4>
            
            <p><strong>Người báo cáo:</strong> ${order.report_user_id} - ${order.report_user}</p>
            <p><strong>Nội dung báo cáo:</strong> ${order.report_content}</p>
            <p><strong>Ghi chú đơn hàng:</strong> ${order.order_details.notes || 'Không có'}</p>
            <p><strong>Tổng tiền:</strong> ${order.order_details.total_amount} VND</p>
            <p><strong>Phương thức thanh toán:</strong> ${order.order_details.payment_method}</p>
            <p><strong>Trạng thái:</strong> ${order.order_details.status}</p>
            <div class="order-actions" style="margin-top: 20px;">
              <textarea id="report-content" placeholder="Nhập nội dung xử lý báo cáo..." rows="4" style="width: 100%;"></textarea>
              <button id="send-report" style="margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; cursor: pointer;">
                Gửi
              </button>
              <button id="complete-report" style="margin-top: 10px; padding: 10px 20px; background-color: #28a745; color: #fff; border: none; cursor: pointer;">
                Hoàn thành báo cáo
              </button>
            </div>
          `;

          // Thêm xử lý sự kiện cho nút "Gửi" và "Hoàn thành"
          const sendReportButton = document.querySelector('#send-report');
          const completeReportButton = document.querySelector('#complete-report');

          // Xử lý gửi báo cáo
          sendReportButton.addEventListener('click', () => {
            const content = document.querySelector('#report-content').value;
            if (!content.trim()) {
              alert('Nội dung không được để trống.');
              return;
            }

            // Gửi nội dung xử lý lên server
            fetch('http://localhost/web_ban_banh_kem/public/admin/api/process-report', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              body: JSON.stringify({ order_id: order.order_id, content }),
            })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  alert('Nội dung xử lý đã được gửi thành công.');
                  document.querySelector('#report-content').value = '';
                } else {
                  alert('Lỗi khi gửi nội dung xử lý.');
                }
              })
              .catch(error => {
                console.error('Lỗi khi gửi nội dung xử lý:', error);
              });
          });

          // Xử lý hoàn thành báo cáo
          completeReportButton.addEventListener('click', () => {
  fetch('http://localhost/web_ban_banh_kem/public/admin/api/complete-report', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify({ order_id: order.order_id }),  // Gửi order_id
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(`Báo cáo cho đơn hàng #${order.order_id} đã được hoàn thành.`);
        // Ẩn đơn hàng khỏi danh sách (tùy ý)
        orderItem.remove();
        orderDetails.innerHTML = '<p>Vui lòng chọn một đơn hàng để xem chi tiết.</p>';
      } else {
        alert('Lỗi khi hoàn thành báo cáo.');
      }
    })
    .catch(error => {
      console.error('Lỗi khi hoàn thành báo cáo:', error);
    });
});
        });
      });
    } else {
      orderList.innerHTML = '<li class="list-item no-orders">Không có báo cáo đơn hàng nào</li>';
      orderDetails.innerHTML = '<p>Không có báo cáo để hiển thị.</p>';
    }
  })
  .catch(error => {
    console.error('Lỗi khi lấy dữ liệu báo cáo đơn hàng:', error);
  });

  document.addEventListener('DOMContentLoaded', () => {
    const blockUserBtn = document.getElementById('block-user-btn');
    const closeModalBtn = document.getElementById('close-block-user-modal');
    const modal = document.getElementById('blockUserModal');

    if (blockUserBtn && modal) {
        blockUserBtn.addEventListener('click', () => {
            modal.classList.toggle('hidden');
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }
});

document.getElementById('close-block-user-modal').addEventListener('click', () => {
    document.getElementById('blockUserModal').classList.add('hidden');
});
// Khi mở modal, tải danh sách người dùng
document.getElementById('block-user-btn').addEventListener('click', () => {
    fetch('http://localhost/web_ban_banh_kem/public/admin/api/users')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const activeUserList = document.getElementById('active-users');
                const blockedUserList = document.getElementById('blocked-users');

                activeUserList.innerHTML = '';
                blockedUserList.innerHTML = '';

                data.active_users.forEach(user => {
                    const li = document.createElement('li');
                    li.textContent = `${user.id} - ${user.name} (${user.email})`;
                    const button = document.createElement('button');
                    button.textContent = 'Khóa tài khoản';
                    button.addEventListener('click', () => toggleBlockUser(user.id, li));
                    li.appendChild(button);
                    activeUserList.appendChild(li);
                });

                data.blocked_users.forEach(user => {
                    const li = document.createElement('li');
                    li.textContent = `${user.id} - ${user.name} (${user.email})`;
                    const button = document.createElement('button');
                    button.textContent = 'Mở khóa tài khoản';
                    button.addEventListener('click', () => toggleBlockUser(user.id, li));
                    li.appendChild(button);
                    blockedUserList.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Lỗi khi tải danh sách người dùng:', error));
});

document.getElementById('active-user-search').addEventListener('input', function () {
    filterUserList('active-users', this.value);
});

document.getElementById('blocked-user-search').addEventListener('input', function () {
    filterUserList('blocked-users', this.value);
});

function filterUserList(listId, query) {
    const userList = document.getElementById(listId);
    const users = userList.querySelectorAll('li');
    query = query.toLowerCase();

    users.forEach(user => {
        const text = user.textContent.toLowerCase();
        if (text.includes(query)) {
            user.style.display = '';
        } else {
            user.style.display = 'none';
        }
    });
}



function toggleBlockUser(userId, listItem) {
    fetch('http://localhost/web_ban_banh_kem/public/admin/api/toggle-block-user', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ user_id: userId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                listItem.remove(); // Xóa user khỏi danh sách hiện tại
            } else {
                alert('Lỗi khi thay đổi trạng thái người dùng.');
            }
        })
        .catch(error => console.error('Lỗi khi thay đổi trạng thái người dùng:', error));
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