<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
 .post {
      display: flex;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .post .post-list {
      width: 30%;
      border-right: 1px solid #ddd;
      max-height: 500px;
      overflow-y: auto;
      background: #f9f9f9;
    }
    .post .post-list h3 {
      text-align: center;
      padding: 10px 0;
      background: #007bff;
      color: #fff;
      margin: 0;
    }
    .post .post-list ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .post .post-list ul li {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #ddd;
      transition: background-color 0.3s ease;
    }
    .post .post-list ul li:hover {
      background: #e9e9e9;
    }
    .post .post-content {
      flex-grow: 1;
      padding: 20px;
    }
    .post .post-content h3 {
      margin-top: 0;
      color: #007bff;
    }
    .post .post-content .details {
      margin-bottom: 20px;
    }
    .post .post-content .details p {
      margin: 5px 0;
    }
    .post .post-content img {
      max-width: 100%;
      height: auto;
      margin: 10px 0;
      border-radius: 8px;
    }
    .post .post-content .tab-comments {
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
    .post .post-content .tab-comments h4 {
      margin: 10px 0;
    }
    .post .post-content .tab-comments ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .post .post-content .tab-comments ul li {
      padding: 5px 0;
      border-bottom: 1px solid #ddd;
    }
     .post {
      display: flex;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .post .post-list {
      width: 30%;
      border-right: 1px solid #ddd;
      max-height: 500px;
      overflow-y: auto;
      background: #f9f9f9;
    }

    .post .post-list h3 {
      text-align: center;
      padding: 10px 0;
      background: #007bff;
      color: #fff;
      margin: 0;
    }

    .post .post-list ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .post .post-list ul li {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #ddd;
      transition: background-color 0.3s ease;
    }

    .post .post-list ul li:hover {
      background: #e9e9e9;
    }

    .post .post-content {
      flex-grow: 1;
      padding: 20px;
    }

    .post .post-content h3 {
      margin-top: 0;
      color: #007bff;
    }

    .post .post-content .details label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .post .post-content .details input,
    .post .post-content .details textarea,
    .post .post-content .details select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .post .post-content .details input[readonly] {
      background-color: #f9f9f9;
      cursor: not-allowed;
    }

    .post .post-content .details .image-upload input {
      padding: 0;
    }

    .post .post-content .details img {
      max-width: 100%;
      height: auto;
      margin-top: 10px;
      border-radius: 8px;
    }

    .post .post-content .details .save-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .post .post-content .details .save-button:hover {
      background-color: #218838;
    }

    .post .post-content .tab-comments {
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }

    .post .post-content .tab-comments ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .post .post-content .tab-comments ul li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ddd;
      position: relative;
    }

    .post .post-content .tab-comments ul li .options {
      position: absolute;
      right: 10px;
      display: none;
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
      z-index: 10;
    }

    .post .post-content .tab-comments ul li .options button {
      border: none;
      background: none;
      color: #dc3545;
      cursor: pointer;
      padding: 10px 20px;
      width: 100%;
      text-align: left;
    }

    .post .post-content .tab-comments ul li:hover .options {
      display: block;
    }

    .post .post-content .tab-comments ul li:hover .menu {
      cursor: pointer;
    }
    .post {
      width: 100%;
      overflow: hidden;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }

    /* Danh sách bài viết */
    .post-list {
      width: 25%;
      float: left;
      background: #f9f9f9;
      border-right: 1px solid #ddd;
      padding: 10px;
      box-sizing: border-box;
      max-height: 600px;
      overflow-y: auto;
    }

    .post-list h3 {
      text-align: center;
      background: #007bff;
      color: #fff;
      margin: 0 -10px 10px;
      padding: 10px;
    }

    .post-list ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .post-list ul li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .post-list ul li:hover {
      background: #e9e9e9;
    }

    /* Nội dung bài viết */
    .post-content {
      width: 40%;
      float: left;
      padding: 10px;
      box-sizing: border-box;
      border-right: 1px solid #ddd;
    }

    .post-content h3 {
      text-align: center;
      color: #007bff;
      margin-bottom: 10px;
    }

    .post-content label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .post-content input,
    .post-content textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .post-content input[readonly] {
      background: #f9f9f9;
      cursor: not-allowed;
    }

    .post-content .save-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .post-content .save-button:hover {
      background-color: #218838;
    }

    /* Bình luận */
    .post-comments {
      width: 35%;
      float: left;
      padding: 10px;
      box-sizing: border-box;
    }

    .post-comments h3 {
      text-align: center;
      color: #007bff;
      margin-bottom: 10px;
    }

    .post-comments ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .post-comments ul li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ddd;
      position: relative;
    }

    .post-comments ul li .menu {
      cursor: pointer;
      color: #999;
    }

    .post-comments ul li .menu:hover {
      color: #333;
    }

    .post-comments ul li .options {
      display: none;
      position: absolute;
      top: 100%;
      right: 10px;
      background: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

    .post-comments ul li:hover .options {
      display: block;
    }

    .post-comments ul li .options button {
      border: none;
      background: none;
      color: #dc3545;
      cursor: pointer;
      padding: 5px 10px;
      text-align: left;
      width: 100%;
    }

    /* Clearfix */
    .post::after {
      content: "";
      display: table;
      clear: both;
    }
    .post-content label {
  display: block;
  margin: 10px 0 5px;
  font-weight: bold;
}

.post-content input,
.post-content textarea {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

.post-content input[readonly] {
  background-color: #f4f4f4;
  color: #999;
}

.post-content input[type="file"] {
  margin-top: 5px;
}

.post-content img {
  border: 1px solid #ccc;
  border-radius: 4px;
}
/* Bình luận */
.post-comments {
  width: 35%;
  float: left;
  padding: 10px;
  box-sizing: border-box;
  background-color: #f9f9f9;
  border-left: 1px solid #ddd;
}

.post-comments h3 {
  text-align: center;
  color: #007bff;
  margin-bottom: 15px;
}

.post-comments ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.post-comments ul li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  margin-bottom: 8px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  position: relative;
}

.post-comments ul li:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
}

.post-comments ul li .menu {
  cursor: pointer;
  font-size: 18px;
  color: #999;
}

.post-comments ul li .menu:hover {
  color: #333;
}

/* Menu xóa (ẩn/hiện khi bấm dấu 3 chấm) */
.post-comments ul li .options {
  display: none;
  position: absolute;
  top: 40%;
  right: 10px;
  background: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  z-index: 10;
}

.post-comments ul li:hover .options {
  display: block;
}

.post-comments ul li .options button {
  display: block;
  padding: 5px 10px;
  color: #dc3545;
  background: none;
  border: none;
  text-align: left;
  width: 100%;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.post-comments ul li .options button:hover {
  background-color: #f8d7da;
}

/* Phần chữ bình luận */
.comment-text {
  flex: 1;
  color: #333;
  font-size: 14px;
  line-height: 1.5;
  margin-right: 10px;
  word-wrap: break-word;
}

/* Hiệu ứng cho dấu ba chấm */
.menu::before {
  content: "⋮";
  font-size: 20px;
  line-height: 1;
}
/* Bình luận tổng thể */
.post-comments {
  width: 35%;
  float: left;
  padding: 10px;
  box-sizing: border-box;
  background-color: #f9f9f9;
  border-left: 1px solid #ddd;
}

.post-comments h3 {
  text-align: center;
  color: #007bff;
  margin-bottom: 15px;
}

.post-comments ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.post-comments ul li {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 10px;
  margin-bottom: 8px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  position: relative;
}

.post-comments ul li:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
}

/* Thông tin người bình luận */
.comment-info {
  display: flex;
  justify-content: space-between;
  margin-bottom: 5px;
  font-size: 14px;
  color: #666;
}

.comment-user {
  font-weight: bold;
  color: #333;
}

.comment-time {
  font-style: italic;
  color: #999;
}

/* Nội dung bình luận */
.comment-text {
  color: #333;
  font-size: 14px;
  line-height: 1.5;
  word-wrap: break-word;
}

/* Dấu ba chấm */
.menu {
  cursor: pointer;
  font-size: 18px;
  color: #999;
  position: absolute;
  top: 10px;
  right: 10px;
}

.menu::before {
  content: "⋮";
}

.menu:hover {
  color: #333;
}

/* Menu xóa */
.options {
  display: none;
  position: absolute;
  top: 30px;
  right: 10px;
  background: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  z-index: 10;
}

.post-comments ul li:hover .options {
  display: block;
}

.options button {
  display: block;
  padding: 5px 10px;
  color: #dc3545;
  background: none;
  border: none;
  text-align: left;
  width: 100%;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.options button:hover {
  background-color: #f8d7da;
}
/* Modal tổng */
.addnewpost-modal {
  display: none; /* Ẩn modal mặc định */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
}

.addnewpost-modal-content {
  background: #fff;
  padding: 20px;
  width: 70%;
  max-width: 800px;
  border-radius: 8px;
  position: relative;
}

/* Nút đóng modal */
.addnewpost-close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 1.5rem;
  cursor: pointer;
}

/* Tiêu đề modal */
.addnewpost-header {
  text-align: center;
  margin-bottom: 20px;
}

/* Grid layout 2 cột */
.addnewpost-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.addnewpost-column label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.addnewpost-column input,
.addnewpost-column textarea,
.addnewpost-column select {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.addnewpost-image-preview {
  margin-top: 10px;
  text-align: center;
}

.addnewpost-buttons {
  text-align: center;
  margin-top: 20px;
}

.addnewpost-submit-btn,
.addnewpost-cancel-btn {
  padding: 10px 20px;
  margin: 5px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.addnewpost-submit-btn {
  background-color: #28a745;
  color: white;
}

.addnewpost-cancel-btn {
  background-color: #dc3545;
  color: white;
}
.delete-post-btn {
  background-color: #ff4d4d; /* Màu đỏ nổi bật */
  color: white; /* Chữ màu trắng */
  padding: 10px 20px; /* Khoảng cách bên trong */
  border: none; /* Bỏ viền mặc định */
  border-radius: 5px; /* Bo góc */
  font-size: 16px; /* Cỡ chữ */
  cursor: pointer; /* Hiển thị con trỏ như nút bấm */
  transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu khi hover */
}

.delete-post-btn:hover {
  background-color: #ff1a1a; /* Màu đỏ đậm khi hover */
}

.delete-post-btn:focus {
  outline: none; /* Bỏ outline khi nút được focus */
}

.delete-post-btn:active {
  background-color: #e60000; /* Màu đỏ khi nhấn */
}
.post-static-modal {
    display: none; /* Ẩn mặc định */
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

.post-static-modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 900px;
    position: relative;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
}

.post-static-modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    color: #333;
    cursor: pointer;
}

.post-static-modal-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.post-static-modal-filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.post-static-modal-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.post-static-modal-filter-btn {
    padding: 8px 12px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.post-static-modal-filter-btn:hover {
    background-color: #218838;
}

.post-static-modal-charts {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.post-static-modal-chart {
    width: 100%;
    height: 200px;
}
/* Modal container */
.post-static-modal {
    display: none; /* Ẩn mặc định */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Ẩn tràn ngoài modal */
}

.post-static-modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 900px;
    height: 80%;
    position: relative;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    overflow-y: auto; /* Cho phép scroll nếu nội dung quá dài */
}

.post-static-modal-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.post-static-modal-filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.post-static-modal-input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.post-static-modal-filter-btn {
    padding: 8px 12px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.post-static-modal-filter-btn:hover {
    background-color: #218838;
}

.post-static-modal-charts {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Hiển thị 2 biểu đồ mỗi hàng */
    gap: 20px;
    margin-top: 20px;
}

.post-static-modal-chart {
    width: 100%;
    height: 150px; /* Kích thước nhỏ hơn */
}
.post-static-modal-charts {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 cột trên mỗi hàng */
    gap: 10px; /* Khoảng cách nhỏ hơn */
    margin-top: 10px;
}

.post-static-modal-chart {
    width: 100%;
    height: 120px; /* Giảm chiều cao của biểu đồ */
    border: 1px solid #ddd;
    padding: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}
.post-static-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    overflow: auto;
}

.post-static-modal-content {
    background: #fff;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    width: 90%; /* Tăng kích thước modal */
    max-width: 1200px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

/* Nút đóng modal */
.post-static-modal-close {
    float: right;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
}

/* Tiêu đề */
.post-static-modal-title {
    text-align: center;
    margin-bottom: 20px;
}

/* Bộ lọc */
.post-static-modal-filters {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.post-static-modal-input {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.post-static-modal-filter-btn {
    padding: 5px 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Lưới biểu đồ */
.post-static-modal-charts {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Hiển thị 2 biểu đồ mỗi hàng */
    gap: 20px; /* Khoảng cách giữa các biểu đồ */
    margin-top: 10px;
}

.post-static-modal-chart {
    width: 100%;
    height: 300px; /* Đồng bộ chiều cao biểu đồ */
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
/* Kích thước Modal */
.post-static-modal-content {
    width: 90%; /* Chiều rộng modal lớn hơn */
    max-width: 1200px; /* Giới hạn chiều rộng tối đa */
    height: 90vh; /* Chiều cao modal là 90% viewport */
    overflow-y: auto; /* Scroll khi nội dung vượt quá */
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Định dạng biểu đồ */
.post-static-modal-charts {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Mỗi hàng chứa 2 cột */
    gap: 20px; /* Khoảng cách giữa các biểu đồ */
    margin-top: 20px;
}

.post-static-modal-chart {
    width: 100%; /* Chiếm toàn bộ không gian của cột */
    height: 200px; /* Chiều cao biểu đồ giảm đi gấp đôi */
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Định dạng tiêu đề Modal */
.post-static-modal-title {
    text-align: center;
    margin-bottom: 10px;
    font-size: 1.8rem;
    color: #333;
}
.post-static-modal-charts {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.chart-row {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.post-static-modal-chart {
    width: 48%; /* Để 2 biểu đồ nằm cạnh nhau */
    max-height: 300px; /* Giới hạn chiều cao */
}
.addnewpost-notification {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    font-size: 16px;
    color: #333;
}

/* Tùy chỉnh label của checkbox */
.addnewpost-checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
    gap: 10px; /* Khoảng cách giữa checkbox và text */
}

/* Tùy chỉnh ô checkbox */
.addnewpost-checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin: 0;
    appearance: none; /* Ẩn checkbox mặc định */
    border: 2px solid #007bff;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
    background-color: #fff;
}

/* Khi checkbox được chọn */
.addnewpost-checkbox-label input[type="checkbox"]:checked {
    background-color: #007bff;
    border-color: #007bff;
    position: relative;
}

/* Thêm dấu check khi checkbox được chọn */
.addnewpost-checkbox-label input[type="checkbox"]:checked::after {
    content: '✔';
    color: #fff;
    font-size: 14px;
    position: absolute;
    top: 0px;
    left: 3px;
    font-weight: bold;
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
/* Modal styles */
.radio-notification-modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
}

.radio-notification-content {
  background-color: #fefefe;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 1200px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.radio-notification-close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.radio-notification-close:hover {
  color: #555;
}

.radio-notification-container {
  display: flex;
  gap: 20px;
  margin-top: 20px;
}

/* List styles */
.radio-notification-list {
  flex: 1;
  border-right: 1px solid #ddd;
  padding-right: 20px;
}

.notification-items {
  max-height: 500px;
  overflow-y: auto;
}

.notification-item {
  padding: 10px;
  border: 1px solid #ddd;
  margin-bottom: 10px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.notification-item:hover {
  background-color: #f5f5f5;
}

.notification-item.expired {
  opacity: 0.6;
  background-color: #f8f8f8;
}

.notification-item.selected {
  background-color: #e3f2fd;
  border-color: #2196f3;
}

/* Detail form styles */
.radio-notification-detail {
  flex: 1.5;
  padding-left: 20px;
}

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
.form-group textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.form-group textarea {
  resize: vertical;
}

.form-buttons {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 20px;
}

.save-btn,
.delete-btn {
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.save-btn {
  background-color: #4CAF50;
  color: white;
}

.delete-btn {
  background-color: #f44336;
  color: white;
}

.save-btn:hover {
  background-color: #45a049;
}

.delete-btn:hover {
  background-color: #da190b;
}
/* Modal tạo mới thông báo */
.create-notification-modal {
  display: none; /* Ban đầu ẩn */
  position: fixed; /* Đặt vị trí cố định */
  top: 50%; /* Căn giữa theo chiều dọc */
  left: 50%; /* Căn giữa theo chiều ngang */
  transform: translate(-50%, -50%); /* Dịch chuyển modal để nó hoàn toàn căn giữa */
  width: 400px; /* Chiều rộng của modal */
  background-color: white; /* Màu nền modal */
  padding: 20px;
  border-radius: 8px; /* Viền bo góc */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng */
  z-index: 1000; /* Đảm bảo modal hiển thị trên các phần tử khác */
}

/* Background mờ */
.create-notification-modal::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
  z-index: -1; /* Đảm bảo background không che modal */
}

/* Nội dung của modal */
.create-notification-content {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Nút đóng modal */
.create-notification-close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  color: #333;
  cursor: pointer;
}

/* Style cho các form */
.create-notification-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

/* Nút Lưu thông báo */
.create-notification-modal .save-btn {
  background-color: #4CAF50; /* Màu xanh */
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.create-notification-modal .save-btn:hover {
  background-color: #45a049;
}

/* Nút hủy hoặc đóng */
.create-notification-modal .cancel-btn {
  background-color: #f44336; /* Màu đỏ */
  color: white;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.create-notification-modal .cancel-btn:hover {
  background-color: #e53935;
}
/* Style cho nút Tạo mới thông báo */
.create-btn {
  background-color: #4CAF50; /* Màu nền xanh lá cây */
  color: white; /* Màu chữ trắng */
  padding: 10px 20px; /* Khoảng cách giữa nội dung và viền */
  font-size: 16px; /* Kích thước chữ */
  border: none; /* Không có viền */
  border-radius: 5px; /* Bo góc cho nút */
  cursor: pointer; /* Con trỏ chuột thay đổi khi hover */
  transition: background-color 0.3s, transform 0.3s; /* Hiệu ứng chuyển đổi */
}

/* Khi người dùng hover vào nút */
.create-btn:hover {
  background-color: #45a049; /* Màu nền thay đổi khi hover */
  transform: scale(1.05); /* Tạo hiệu ứng phóng to */
}

/* Khi người dùng nhấn vào nút */
.create-btn:active {
  background-color: #388e3c; /* Màu nền thay đổi khi nhấn */
  transform: scale(1); /* Giảm hiệu ứng phóng to */
}
/* Modal */
/* Modal Styles */
.banner-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    overflow-y: auto; /* Enable scrolling on modal overlay */
}

.banner-modal-content {
    position: relative;
    background-color: #fff;
    margin: 2% auto;
    width: 90%;
    max-width: 1200px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    max-height: 96vh; /* Set maximum height */
    display: flex;
    flex-direction: column;
}

.banner-modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    border-radius: 8px 8px 0 0;
    position: sticky;
    top: 0;
    z-index: 10;
    background: white;
}

.banner-modal-body {
    flex: 1;
    overflow-y: auto; /* Enable scrolling for modal body */
    padding: 20px;
}

/* Container Layout */
.banner-container {
    display: flex;
    gap: 30px;
    min-height: 500px;
    height: calc(90vh - 100px); /* Adjust height for better scrolling */
}

/* Banner List Styles */
.banner-list {
    flex: 0 0 300px;
    border-right: 1px solid #eee;
    padding-right: 20px;
    overflow-y: auto; /* Enable scrolling for list */
    max-height: 100%;
}

#bannerList {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Banner Editor Styles */
.banner-editor {
    flex: 1;
    padding-left: 20px;
    overflow-y: auto; /* Enable scrolling for editor */
}

/* Scrollbar Styling */
.banner-modal-body::-webkit-scrollbar,
.banner-list::-webkit-scrollbar,
.banner-editor::-webkit-scrollbar {
    width: 8px;
}

.banner-modal-body::-webkit-scrollbar-track,
.banner-list::-webkit-scrollbar-track,
.banner-editor::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.banner-modal-body::-webkit-scrollbar-thumb,
.banner-list::-webkit-scrollbar-thumb,
.banner-editor::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.banner-modal-body::-webkit-scrollbar-thumb:hover,
.banner-list::-webkit-scrollbar-thumb:hover,
.banner-editor::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Rest of the styles remain the same */
.banner-modal-header h2 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.5rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    transition: color 0.3s;
}

.close-btn:hover {
    color: #dc3545;
}

.banner-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 10px;
    background-color: #f8f9fa;
    border-radius: 6px;
    transition: all 0.3s;
    cursor: pointer;
}

.banner-item:hover {
    background-color: #e9ecef;
    transform: translateX(5px);
}

/* Status Dots */
.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 10px;
    flex-shrink: 0;
}

.dot-green {
    background-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
}

.dot-red {
    background-color: #dc3545;
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
}

#bannerForm {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding-bottom: 20px;
}

/* Form Fields */
#bannerForm input[type="text"] {
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s;
}

#bannerForm input[type="text"]:focus {
    border-color: #80bdff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

/* Buttons */
.form-buttons {
    position: sticky;
    bottom: 0;
    background: white;
    padding: 15px 0;
    border-top: 1px solid #eee;
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .banner-container {
        flex-direction: column;
        height: auto;
    }
    
    .banner-list,
    .banner-editor {
        flex: none;
        width: 100%;
        max-height: 50vh;
    }
    
    .banner-list {
        border-right: none;
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }
    
    .banner-editor {
        padding-left: 0;
        margin-top: 20px;
    }
}

/* Button chung */
button {
    font-family: 'Arial', sans-serif;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Button "Lưu" */
.save-btn {
    background-color: #28a745;
    color: white;
}

.save-btn:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.save-btn:active {
    background-color: #1e7e34;
}

/* Button "Tắt Banner" */
#toggleBannerStatusBtn {
    background-color: #dc3545;
    color: white;
}

#toggleBannerStatusBtn:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

#toggleBannerStatusBtn:active {
    background-color: #bd2130;
}

/* Button "Thêm Banner Mới" */
.add-banner-btn {
    background-color: #007bff;
    color: white;
}

.add-banner-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.add-banner-btn:active {
    background-color: #004085;
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
    <h2>Quản Lý Bài Viết</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>

    <!-- Toolbar buttons -->
    <div class="toolbar">
   
  <button class="toolbar-btn post-static-modal-btn" onclick="openModalStatic()"> 
    <i class="fas fa-chart-bar"></i> Thống kê
</button>
<button class="toolbar-btn post-static-modal-btn" onclick="openModalRadioNotificationStatic()"> 
<i class="fas fa-volume-up"></i>  Thông báo phát thanh 
</button>
<button class="toolbar-btn post-static-modal-btn" onclick="openBannerModal() ">
   <i class="fas fa-volume-up"></i> Quản lý Slide
</button>
</div>
<div class="post">
  <!-- Danh sách bài viết -->
  <div class="post-list">
    <h3>Danh Sách Bài Viết</h3>
    <ul id="postList">
      <li data-id="1">Bài viết 1</li>
      <li data-id="2">Bài viết 2</li>
      <li data-id="3">Bài viết 3</li>
    </ul>
  </div>

  <!-- Nội dung bài viết -->
  <div class="post-content">
    <h3>Nội Dung Bài Viết</h3>

    <!-- ID - readonly -->
    <label for="postId">ID</label>
    <input type="text" id="postId" readonly>

    <input type="text" id="postDate" readonly>

    <!-- Tiêu Đề -->
    <label for="postTitle">Tiêu Đề</label>
    <input type="text" id="postTitle" placeholder="Nhập tiêu đề bài viết">

    <!-- Mô Tả -->
    <label for="postDescription">Mô Tả</label>
    <textarea id="postDescription" placeholder="Nhập mô tả bài viết"></textarea>

    <!-- Ảnh Bìa -->
    <label for="postCover">Ảnh Bìa</label>
    <input type="file" id="postCover" accept="image/*">
    <img id="coverPreview" src="#" alt="Ảnh bìa xem trước" style="width: 100%; height: auto; margin-top: 10px; display: none;">

    <!-- Thể Loại -->
    <label for="postCategory">Thể Loại</label>
    <input type="text" id="postCategory" placeholder="Nhập thể loại bài viết">

    <!-- Nội Dung -->
    <label for="postContent">Nội Dung</label>
    <textarea id="postContent" rows="6" placeholder="Nhập nội dung bài viết"></textarea>

    <!-- Lượt Xem - readonly -->
    <label for="postViews">Số Lượt Xem</label>
    <input type="text" id="postViews" readonly>

    <!-- Nút Xóa Bài Viết -->
    <button id="deletePostBtn" class="delete-post-btn">Xóa Bài Viết</button>
    <button class="save-button">Lưu</button>
  </div>

  <!-- Bình luận -->
  <div class="post-comments">
    <h3>Bình Luận</h3>
    <ul id="postComments">
      <p>Chọn một bài viết để xem chi tiết bình luận.</p>
    </ul>
  </div>
</div>

<!-- Modal Thêm Bài Viết Mới -->
<div id="addnewpostModal" class="addnewpost-modal">
  <div class="addnewpost-modal-content">
    <span class="addnewpost-close-btn" onclick="closeAddNewPostModal()">&times;</span>
    <h2 class="addnewpost-header">Thêm Bài Viết Mới</h2>
    <form id="addnewpostForm" enctype="multipart/form-data">
      <div class="addnewpost-grid">
        <!-- Cột 1 -->
        <div class="addnewpost-column">
          <label for="addnewpostTitle">Tiêu Đề:</label>
          <input type="text" id="addnewpostTitle" name="title" placeholder="Nhập tiêu đề" required>

          <label for="addnewpostDescription">Mô Tả:</label>
          <textarea id="addnewpostDescription" name="description" placeholder="Nhập mô tả"></textarea>

          <label for="addnewpostType">Loại Bài Viết:</label>
          <select id="addnewpostType" name="type">
            <option value="tin_tuc">Tin Tức</option>
            <option value="su_kien">Sự Kiện</option>
          </select>
        </div>

        <!-- Cột 2 -->
        <div class="addnewpost-column">
          <label for="addnewpostContent">Nội Dung:</label>
          <textarea id="addnewpostContent" name="content" rows="5" placeholder="Nhập nội dung"></textarea>

          <label for="addnewpostCoverImage">Ảnh Bìa:</label>
          <input type="file" id="addnewpostCoverImage" name="cover_image" accept="image/*" onchange="previewAddNewPostImage()">
          <div class="addnewpost-image-preview">
            <img id="addnewpostImagePreview" src="" alt="Xem trước ảnh bìa" style="display: none; max-width: 100%; height: auto;">
          </div>
        </div>
      </div>
      <div class="addnewpost-notification">
  <label for="sendNotification" class="addnewpost-checkbox-label">
    <input type="checkbox" id="sendNotification" name="send_notification" checked>
    Gửi thông báo đến tất cả người dùng
  </label>
</div>
      <!-- Nút Thêm -->
      <div class="addnewpost-buttons">
        <button type="submit" class="addnewpost-submit-btn">Thêm Bài Viết</button>
        <button type="button" class="addnewpost-cancel-btn" onclick="closeAddNewPostModal()">Hủy</button>
      </div>
    </form>
  </div>
</div>
<div id="postStaticModal" class="post-static-modal">
    <div class="post-static-modal-content">
        <span class="post-static-modal-close" onclick="closeModalStatic()">&times;</span>
        <h2 class="post-static-modal-title">Thống kê Bài Viết</h2>

        <!-- Bộ lọc -->
        <div class="post-static-modal-filters">
            <label for="filterStartDate">Từ ngày:</label>
            <input type="date" id="filterStartDate" class="post-static-modal-input">
            <label for="filterEndDate">Đến ngày:</label>
            <input type="date" id="filterEndDate" class="post-static-modal-input">
            <button class="post-static-modal-filter-btn" onclick="filterStatistics()">Lọc</button>
        </div>

        <!-- Biểu đồ -->
        <div class="post-static-modal-charts">
            <div class="chart-row">
                <canvas id="postViewsChart" class="post-static-modal-chart"></canvas>
                <canvas id="postCommentsChart" class="post-static-modal-chart"></canvas>
            </div>
            <div class="chart-row">
                <canvas id="postCreationChart" class="post-static-modal-chart"></canvas>
                <canvas id="commentsPerDayChart" class="post-static-modal-chart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Modal hiển thị thông báo -->
<div id="radioNotificationModal" class="radio-notification-modal">
  <div class="radio-notification-content">
    <span class="radio-notification-close" onclick="closeModalRadioNotification()">&times;</span>
    <h2>Thông Báo Phát Thanh</h2>
    <button class="create-btn" onclick="openCreateNotificationModal()">Tạo mới thông báo</button>
    <div class="radio-notification-container">
      <!-- Left side - Notification list -->
      <div class="radio-notification-list">
        <h3>Danh sách thông báo</h3>
        <div id="notificationList" class="notification-items">
          <!-- Các thông báo sẽ được thêm vào đây -->
        </div>
        <!-- Nút tạo mới thông báo -->
     
      </div>

      <!-- Right side - Notification detail -->
      <div class="radio-notification-detail">
        <h3>Chi tiết thông báo</h3>
        <form id="notificationForm">
          <div class="form-group">
            <label>Ngày tạo:</label>
            <input type="text" id="createdAt" disabled value="${new Date().toLocaleDateString()}">
          </div>

          <div class="form-group">
            <label>Mức độ thông báo:</label>
            <select id="notificationLevel">
              <option value="1">Bình thường</option>
              <option value="2">Quan trọng</option>
              <option value="3">Khẩn cấp</option>
            </select>
          </div>

          <div class="form-group">
            <label>Thời hạn (ngày):</label>
            <input type="number" id="expirationPeriod" min="1">
          </div>

          <div class="form-group">
            <label>Nội dung:</label>
            <textarea id="notificationContent" rows="4"></textarea>
          </div>

          <div class="form-buttons">
            <button type="button" class="save-btn" onclick="saveNotification()">Lưu</button>
            <button type="button" class="delete-btn" onclick="deleteNotification()">Xóa</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal tạo mới thông báo -->
<div id="createNotificationModal" class="create-notification-modal" style="display:none;">
  <div class="create-notification-content">
    <span class="create-notification-close" onclick="closeCreateNotificationModal()">&times;</span>
    <h2>Tạo Mới Thông Báo</h2>
    <form id="createNotificationForm">
      <div class="form-group">
        <label>Mức độ thông báo:</label>
        <select id="createNotificationLevel">
          <option value="1">Bình thường</option>
          <option value="2">Quan trọng</option>
          <option value="3">Khẩn cấp</option>
        </select>
      </div>

      <div class="form-group">
        <label>Thời hạn (ngày):</label>
        <input type="number" id="createExpirationPeriod" min="1">
      </div>

      <div class="form-group">
        <label>Nội dung:</label>
        <textarea id="createNotificationContent" rows="4"></textarea>
      </div>

      <div class="form-buttons">
        <button type="button" class="save-btn" onclick="saveNewNotification()">Lưu thông báo</button>
      </div>
    </form>
  </div>
</div>
<div id="bannerModal" class="banner-modal">
   <div class="banner-modal-content">
      <div class="banner-modal-header">
         <h2>Quản lý Banner</h2>
         <button class="close-btn" onclick="closeBannerModal()">&times;</button>
      </div>

      <div class="banner-modal-body">
         <div class="banner-container">
            <!-- Phần bên trái: Danh sách các banner -->
            <div class="banner-list">
               <h3>Danh sách Banner</h3>
               <ul id="bannerList">
                  <!-- Danh sách banner sẽ được tải động từ Controller -->
               </ul>
               <button class="add-banner-btn" onclick="createNewBanner()">+ Thêm Banner Mới</button>
            </div>

            <!-- Phần bên phải: Thông tin banner -->
            <div class="banner-editor">
    <h3>Chi tiết Banner</h3>
    <form id="bannerForm">
        <label for="bannerId">ID:</label>
        <input type="text" id="bannerId" name="id" readonly>

        <label for="content1">Nội dung 1:</label>
        <input type="text" id="content1" name="content_1">

        <label for="content2">Nội dung 2:</label>
        <input type="text" id="content2" name="content_2">

        <label for="content3">Nội dung 3:</label>
        <input type="text" id="content3" name="content_3">

        <label for="bannerImage">Ảnh:</label>
        <input type="file" id="bannerImage" name="image">

        <label for="bannerUrl">URL:</label>
<input type="url" id="bannerUrl" name="url" placeholder="Nhập URL" />


        <label>
            <input type="checkbox" id="isHeader" name="is_header"> Đặt làm ảnh bìa
        </label>

        <div class="form-buttons">
            <!-- Nút "Tạo Banner Mới" với lớp mới và sự kiện onclick khác -->
            <button type="button" class="create-new-banner-btn" onclick="createNewBannerConfirmed()" style="display: none;">Tạo Banner Mới</button>
            <!-- Nút Tắt Banner ban đầu -->
            <button type="button" id="toggleBannerStatusBtn" onclick="toggleBannerStatus()" style="display: none;">Tắt Banner</button>
            <!-- Nút Lưu -->
            <button type="button" id="saveBannerBtn" class="saveBanner-btn" onclick="saveBanner()" style="display: none;">Lưu</button>
        </div>
    </form>
</div>

         </div>
      </div>
   </div>
</div>

</div>
   
    <script>
        // Sample data for the chart
       
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
      


        const posts = [
      {
        id: 1,
        title: "Bài viết 1",
        description: "Mô tả bài viết 1",
        category: "Thể loại 1",
        content: "Nội dung bài viết 1",
        comments: ["Bình luận 1", "Bình luận 2"]
      },
      {
        id: 2,
        title: "Bài viết 2",
        description: "Mô tả bài viết 2",
        category: "Thể loại 2",
        content: "Nội dung bài viết 2",
        comments: ["Bình luận A", "Bình luận B"]
      },
    ];

    const postList = document.getElementById("postList");
    const postId = document.getElementById("postId");
    const postDate = document.getElementById("postDate");
    
    const postTitle = document.getElementById("postTitle");
    const postDescription = document.getElementById("postDescription");
    const postCategory = document.getElementById("postCategory");
    const postContent = document.getElementById("postContent");
    const postComments = document.getElementById("postComments");
    
    

    fetch('http://localhost/web_ban_banh_kem/public/posts')
  .then(response => response.json())
  .then(posts => {
    const postList = document.getElementById('postList');
    postList.innerHTML = ''; // Clear the list

    posts.forEach(post => {
      const li = document.createElement('li');
      li.dataset.id = post.id;
      li.innerText = post.title;
      
      // Khi người dùng click vào một bài viết, hiển thị chi tiết bài viết và bình luận
      li.addEventListener('click', () => fetchPostDetails(post.id));
      postList.appendChild(li);
    });
  })
  .catch(error => console.error('Error fetching posts:', error));

// 2. Lấy chi tiết bài viết khi người dùng chọn một bài viết
function fetchPostDetails(postId) {
  fetch(`http://localhost/web_ban_banh_kem/public/posts/${postId}`)
    .then(response => response.json())
    .then(data => {
      // Hiển thị thông tin chi tiết bài viết
      document.getElementById('postId').value = data.post.id;
      document.getElementById('postDate').value = formatDate(data.post.created_at);
      document.getElementById('postTitle').value = data.post.title;
      document.getElementById('postDescription').value = data.post.description;
      document.getElementById('postCategory').value = data.post.type;
      document.getElementById('postContent').value = data.post.content;
      document.getElementById('postViews').value = data.post.views;

      // Cập nhật ảnh bìa (nếu có)
      if (data.post.cover_image) {
        document.getElementById('coverPreview').style.display = 'block';
        document.getElementById('coverPreview').src = '/web_ban_banh_kem/public/' + data.post.cover_image;
      } else {
        document.getElementById('coverPreview').style.display = 'none';
      }

      // Thêm sự kiện xóa bài viết vào nút
      document.getElementById('deletePostBtn').onclick = function() {
        deletePost(data.post.id);
      };
    
      // 3. Hiển thị bình luận của bài viết
      const commentList = document.getElementById('postComments');
      commentList.innerHTML = ''; // Clear previous comments

      data.comments.forEach(comment => {
        const li = document.createElement('li');
        li.innerHTML = `
          <div class="comment-info">
            <strong class="comment-user">${comment.user_id}-${comment.user.name}</strong>
            <span class="comment-time">${formatCommentDate(comment.created_at)}</span>
          </div>
          <div class="comment-text">${comment.content}</div>
          <div class="menu"></div>
          <div class="options">
            <button onclick="deleteComment(${comment.id}, ${postId})">Xóa</button>
          </div>
        `;
        commentList.appendChild(li);
      });
    })
    .catch(error => console.error('Error fetching post details:', error));
}

// 4. Xóa bình luận (Tạo hàm để xử lý)
function deleteComment(commentId, postId) {
  if (confirm("Bạn có chắc muốn xóa bình luận này?")) {
    // Lấy CSRF token từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Gửi yêu cầu xóa bình luận
    fetch(`http://localhost/web_ban_banh_kem/public/posts/${postId}/comments/${commentId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Gửi token CSRF trong header
      },
    })
    .then(response => response.json())
    .then(data => {
      if (data.message === 'Bình luận đã được xóa') {
        // Sau khi xóa thành công, gọi lại hàm lấy chi tiết bài viết
        fetchPostDetails(postId);
        alert("Bình luận đã được xóa.");
      } else {
        alert("Có lỗi xảy ra: " + data.message);
      }
    })
    .catch(error => console.error('Error deleting comment:', error));
  }
}


// 5. Lưu thông tin bài viết khi người dùng chỉnh sửa
document.querySelector('.save-button').addEventListener('click', function () {
  const postId = document.getElementById('postId').value;
  const title = document.getElementById('postTitle').value;
  const description = document.getElementById('postDescription').value;
  const category = document.getElementById('postCategory').value;
  const content = document.getElementById('postContent').value;

  // Tạo FormData để gửi dữ liệu
  const formData = new FormData();
  formData.append('title', title);
  formData.append('description', description);
  formData.append('type', category);
  formData.append('content', content);

  // Kiểm tra xem có file ảnh bìa không
  const coverImage = document.getElementById('postCover').files[0];
  if (coverImage) {
    formData.append('cover_image', coverImage);
  }

  // Gửi yêu cầu POST thay vì PUT
  fetch(`http://localhost/web_ban_banh_kem/public/editPost/${postId}`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token
    },
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Bài viết đã được lưu thành công!');
      } else {
        alert('Có lỗi xảy ra, vui lòng thử lại.');
      }
    })
    .catch(error => {
      console.error('Error saving post:', error);
      alert('Đã xảy ra lỗi khi lưu bài viết.');
    });
});



// Hiển thị ảnh bìa xem trước khi tải file lên
const postCover = document.getElementById("postCover");
const coverPreview = document.getElementById("coverPreview");

postCover.addEventListener("change", function(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      coverPreview.src = e.target.result;
      coverPreview.style.display = "block";
    };
    reader.readAsDataURL(file);
  }
});
function formatDate(dateString) {
  const now = new Date();
  const date = new Date(dateString);
  
  const diffTime = now - date;
  const diffMinutes = Math.floor(diffTime / (1000 * 60)); // Chuyển đổi ra phút
  const diffHours = Math.floor(diffTime / (1000 * 60 * 60)); // Chuyển đổi ra giờ
  const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // Chuyển đổi ra ngày
  const diffMonths = Math.floor(diffDays / 30); // Chuyển đổi ra tháng

  if (diffMinutes < 60) {
    return `${diffMinutes} phút trước`;
  } else if (diffHours < 24) {
    return `${diffHours} giờ trước`;
  } else if (diffDays < 30) {
    return `${diffDays} ngày trước`;
  } else {
    return date.toLocaleDateString('en-GB'); // Định dạng dd/mm/yyyy
  }
}
function formatCommentDate(dateString) {
  const now = new Date();
  const date = new Date(dateString);
  
  const diffTime = now - date;
  const diffMinutes = Math.floor(diffTime / (1000 * 60)); // Chuyển đổi ra phút
  const diffHours = Math.floor(diffTime / (1000 * 60 * 60)); // Chuyển đổi ra giờ
  const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); // Chuyển đổi ra ngày
  const diffMonths = Math.floor(diffDays / 30); // Chuyển đổi ra tháng

  if (diffMinutes < 60) {
    return `${diffMinutes} phút trước`;
  } else if (diffHours < 24) {
    return `${diffHours} giờ trước`;
  } else if (diffDays < 30) {
    return `${diffDays} ngày trước`;
  } else {
    return date.toLocaleDateString('en-GB'); // Định dạng dd/mm/yyyy
  }
}
// Mở modal
function openAddNewPostModal() {
  document.getElementById('addnewpostModal').style.display = 'flex';
}

// Đóng modal
function closeAddNewPostModal() {
  document.getElementById('addnewpostModal').style.display = 'none';
  resetAddNewPostForm();
}

// Xem trước ảnh bìa
function previewAddNewPostImage() {
  const input = document.getElementById('addnewpostCoverImage');
  const preview = document.getElementById('addnewpostImagePreview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = '';
    preview.style.display = 'none';
  }
}

// Reset form sau khi đóng modal
function resetAddNewPostForm() {
  document.getElementById('addnewpostForm').reset();
  document.getElementById('addnewpostImagePreview').style.display = 'none';
  document.getElementById('addnewpostImagePreview').src = '';
}
document.getElementById('addnewpostForm').addEventListener('submit', function (e) {
  e.preventDefault(); // Ngăn form gửi đi mặc định

  // Lấy dữ liệu từ form
  const formData = new FormData();
  formData.append('title', document.getElementById('addnewpostTitle').value);
  formData.append('description', document.getElementById('addnewpostDescription').value);
  formData.append('type', document.getElementById('addnewpostType').value);
  formData.append('content', document.getElementById('addnewpostContent').value);

  // Lấy trạng thái checkbox gửi thông báo
  const sendNotification = document.getElementById('sendNotification').checked;
  formData.append('send_notification', sendNotification ? 1 : 0); // Gửi 1 nếu checked, 0 nếu không

  // Lấy file ảnh bìa (nếu có)
  const coverImage = document.getElementById('addnewpostCoverImage').files[0];
  if (coverImage) {
    formData.append('cover_image', coverImage);
  }

  // Gửi dữ liệu lên server
  fetch('http://localhost/web_ban_banh_kem/public/addPost', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken, // CSRF Token nếu dùng Laravel
    },
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Bài viết đã được thêm thành công!');
        closeAddNewPostModal();
      } else {
        alert('Có lỗi xảy ra: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Đã xảy ra lỗi khi thêm bài viết.');
    });
});

function deletePost(postId) {
  // Lấy CSRF token từ meta tag
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Gửi yêu cầu xóa bài viết tới server
  fetch(`http://localhost/web_ban_banh_kem/public/posts/delete/${postId}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,  // Thêm CSRF token vào headers
    },
    body: JSON.stringify({ postId: postId })  // Gửi ID của bài viết cần xóa
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Bài viết đã được xóa!');
      // Cập nhật giao diện sau khi xóa
      document.getElementById('postId').value = '';
      document.getElementById('postDate').value = '';
      document.getElementById('postTitle').value = '';
      document.getElementById('postDescription').value = '';
      document.getElementById('postCategory').value = '';
      document.getElementById('postContent').value = '';
      document.getElementById('postViews').value = '';
      document.getElementById('coverPreview').style.display = 'none';
    } else {
      alert('Lỗi khi xóa bài viết');
    }
  })
  .catch(error => console.error('Error deleting post:', error));
}
// Mở modal
function openModalStatic() {
    document.getElementById('postStaticModal').style.display = 'flex';
    renderCharts(); // Khởi tạo biểu đồ khi mở modal
}

// Đóng modal
function closeModalStatic() {
    document.getElementById('postStaticModal').style.display = 'none';
}

// Hàm lọc thống kê (placeholder - xử lý dữ liệu backend sau)
let postViewsChartInstance = null;
let postCommentsChartInstance = null;
let postCreationChartInstance = null;
let commentsPerDayChartInstance = null;

// Hàm mở modal và hiển thị dữ liệu mặc định
function openModalStatic() {
    document.getElementById('postStaticModal').style.display = 'block';
    fetchStatistics(); // Gọi API để lấy dữ liệu mặc định
}

function fetchStatistics(startDate = null, endDate = null) {
    const url = 'http://localhost/web_ban_banh_kem/public/postStatistics';

    // Dữ liệu gửi lên server
    const requestData = {
        start_date: startDate,
        end_date: endDate
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCharts(data);
        } else {
            console.error('Error fetching statistics');
        }
    })
    .catch(error => console.error('Error fetching statistics:', error));
}

// Hàm cập nhật biểu đồ
function updateCharts(data) {
    // Hủy biểu đồ cũ nếu tồn tại
    if (postViewsChartInstance) postViewsChartInstance.destroy();
    if (postCommentsChartInstance) postCommentsChartInstance.destroy();
    if (postCreationChartInstance) postCreationChartInstance.destroy();
    if (commentsPerDayChartInstance) commentsPerDayChartInstance.destroy();

    // Biểu đồ lượt xem bài viết
    const ctx1 = document.getElementById('postViewsChart').getContext('2d');
    postViewsChartInstance = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: data.views.map(v => v.title),
            datasets: [{
                label: 'Lượt Xem',
                data: data.views.map(v => v.views),
                backgroundColor: '#007bff',
            }]
        },
        options: { plugins: { title: { display: true, text: 'Lượt Xem Bài Viết' } } }
    });

    // Biểu đồ bình luận theo bài viết
    const ctx2 = document.getElementById('postCommentsChart').getContext('2d');
    postCommentsChartInstance = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: data.comments.map(c => 'Bài ID ' + c.post_id),
            datasets: [{
                label: 'Bình Luận',
                data: data.comments.map(c => c.total_comments),
                backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
            }]
        },
        options: { plugins: { title: { display: true, text: 'Bình Luận Theo Bài Viết' } } }
    });

    // Biểu đồ số bài viết theo ngày
    const ctx3 = document.getElementById('postCreationChart').getContext('2d');
    postCreationChartInstance = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: data.posts_per_day.map(p => p.date),
            datasets: [{
                label: 'Bài Đăng',
                data: data.posts_per_day.map(p => p.total_posts),
                borderColor: '#17a2b8',
                fill: false
            }]
        },
        options: { plugins: { title: { display: true, text: 'Số Bài Đăng Theo Ngày' } } }
    });

    // Biểu đồ số bình luận theo ngày
    const ctx4 = document.getElementById('commentsPerDayChart').getContext('2d');
    commentsPerDayChartInstance = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: data.comments_per_day.map(c => c.date),
            datasets: [{
                label: 'Bình Luận',
                data: data.comments_per_day.map(c => c.total_comments),
                borderColor: '#f39c12',
                fill: false
            }]
        },
        options: { plugins: { title: { display: true, text: 'Bình Luận Theo Ngày' } } }
    });
}

// Hàm lọc dữ liệu thống kê theo ngày
function filterStatistics() {
    const startDate = document.getElementById('filterStartDate').value;
    const endDate = document.getElementById('filterEndDate').value;
    fetchStatistics(startDate, endDate);
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
        let currentNotificationId = null;
let notifications = [];

// Open modal function
function openModalRadioNotificationStatic() {
  document.getElementById('radioNotificationModal').style.display = 'block';
  loadNotifications();
}

// Close modal function
function closeModalRadioNotification() {
  document.getElementById('radioNotificationModal').style.display = 'none';
  clearForm();
}

// Load notifications from server
async function loadNotifications() {
  try {
    const response = await fetch('http://localhost/web_ban_banh_kem/public/radio-notifications');
    notifications = await response.json();
    displayNotifications();
  } catch (error) {
    console.error('Error loading notifications:', error);
  }
}

// Display notifications in the list
// Hiển thị danh sách thông báo
function displayNotifications() {
  const listContainer = document.getElementById('notificationList');
  listContainer.innerHTML = '';

  // Sắp xếp thông báo: thông báo còn hạn trước, hết hạn sau
  const sortedNotifications = [...notifications].sort((a, b) => {
    const aExpired = isExpired(a);
    const bExpired = isExpired(b);
    if (aExpired === bExpired) return new Date(b.created_at) - new Date(a.created_at);
    return aExpired ? 1 : -1;
  });

  sortedNotifications.forEach(notification => {
    const isExpiredNotification = isExpired(notification);
    const div = document.createElement('div');
    div.className = `notification-item ${isExpiredNotification ? 'expired' : ''}`;
    if (notification.id === currentNotificationId) div.className += ' selected';
    
    // Hiển thị ID và 10 ký tự đầu của nội dung thông báo
    const shortContent = `${notification.id}-${notification.content.substring(0, 10)}...`;
    div.textContent = shortContent;
    
    div.onclick = () => selectNotification(notification.id);
    listContainer.appendChild(div);
  });
}

// Kiểm tra xem thông báo đã hết hạn chưa
function isExpired(notification) {
  // Tính thời gian hết hạn theo ngày
  const expirationTime = new Date(notification.created_at).getTime() + 
                        (notification.expiration_period * 24 * 60 * 60 * 1000); // Cộng thêm số ngày
  return Date.now() > expirationTime;
}

// Chọn và hiển thị chi tiết thông báo
function selectNotification(id) {
  currentNotificationId = id;
  const notification = notifications.find(n => n.id === id);
  
  document.getElementById('createdAt').value = new Date(notification.created_at)
    .toLocaleString('vi-VN');
  document.getElementById('notificationLevel').value = notification.level;
  document.getElementById('expirationPeriod').value = notification.expiration_period;
  document.getElementById('notificationContent').value = notification.content;
  
  displayNotifications(); // Refresh list để cập nhật phần chọn
}

// Lưu thay đổi thông báo
// Lưu thông báo
// Lấy CSRF token từ meta tag


// Lưu thông báo
async function saveNotification() {
  if (!currentNotificationId) return;

  const data = {
    level: document.getElementById('notificationLevel').value,
    content: document.getElementById('notificationContent').value,
    expiration_period: document.getElementById('expirationPeriod').value
  };

  try {
    const response = await fetch(`http://localhost/web_ban_banh_kem/public/radio-notifications/${currentNotificationId}`, {
      method: 'POST', // Đổi thành POST thay vì PUT
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào header
      },
      body: JSON.stringify(data)
    });

    if (response.ok) {
      await loadNotifications();
      alert('Lưu thành công!');
    } else {
      throw new Error('Failed to save');
    }
  } catch (error) {
    console.error('Error saving notification:', error);
    alert('Có lỗi xảy ra khi lưu thông báo!');
  }
}

// Xóa thông báo
async function deleteNotification() {
  if (!currentNotificationId || !confirm('Bạn có chắc muốn xóa thông báo này?')) return;

  try {
    const response = await fetch(`http://localhost/web_ban_banh_kem/public/radio-notifications/${currentNotificationId}`, {
      method: 'DELETE', // Giữ nguyên DELETE
      headers: {
        'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token vào header
      }
    });

    if (response.ok) {
      await loadNotifications();
      clearForm();
      alert('Xóa thành công!');
    } else {
      throw new Error('Failed to delete');
    }
  } catch (error) {
    console.error('Error deleting notification:', error);
    alert('Có lỗi xảy ra khi xóa thông báo!');
  }
}


// Xóa thông tin form
function clearForm() {
  currentNotificationId = null;
  document.getElementById('createdAt').value = '';
  document.getElementById('notificationLevel').value = '1';
  document.getElementById('expirationPeriod').value = '';
  document.getElementById('notificationContent').value = '';
}
// Mở modal tạo mới thông báo


// Lưu thông báo mới
function saveNewNotification() {
  const level = document.getElementById('notificationLevel').value;
  const content = document.getElementById('createNotificationContent').value;
  const expirationPeriod = document.getElementById('createExpirationPeriod').value;

  // Gửi yêu cầu POST tới server để lưu thông báo
  fetch('http://localhost/web_ban_banh_kem/public/radio-notification/save', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      level: level,
      content: content,
      expiration_period: expirationPeriod
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      alert(data.message);
      // Có thể cập nhật lại danh sách thông báo hoặc thực hiện các hành động khác.
    } else {
      alert(data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

// Đóng modal thông báo (modal chính)
function openCreateNotificationModal() {
  document.getElementById('createNotificationModal').style.display = 'block';
}

function closeCreateNotificationModal() {
  document.getElementById('createNotificationModal').style.display = 'none';
}
// Mở modal và tải dữ liệu banner
function openBannerModal() {
   document.getElementById('bannerModal').style.display = 'block';
   
   // Gọi AJAX để lấy dữ liệu banner
   fetchBanners();
}

// Đóng modal
function closeBannerModal() {
   document.getElementById('bannerModal').style.display = 'none';
}

// Lấy danh sách các banner từ controller
function fetchBanners() {
   fetch('http://localhost/web_ban_banh_kem/public/banners')
      .then(response => response.json())
      .then(data => {
         let bannerList = document.getElementById('bannerList');
         bannerList.innerHTML = ''; // Xóa dữ liệu cũ
         
         data.forEach(banner => {
            let statusDotClass = banner.status == 1 ? 'dot-green' : 'dot-red';
            let headerIcon = banner.is_header && banner.status == 1 ? '<i class="fas fa-star is-header-icon"></i>' : '';
            
            let bannerItem = `
               <li class="banner-item">
                  <span>${banner.content_1 || 'Banner không có tiêu đề'}</span>
                  <span class="dot ${statusDotClass}"></span>
                  ${headerIcon}
                  <button class="edit-btn" onclick="loadBannerData(${banner.id})">Chỉnh sửa</button>
               </li>
            `;
            bannerList.innerHTML += bannerItem;
         });
      })
      .catch(error => console.error('Error fetching banners:', error));
}

// Tải dữ liệu banner vào form để chỉnh sửa
function loadBannerData(bannerId) {
   fetch(`http://localhost/web_ban_banh_kem/public/banners/${bannerId}`)
      .then(response => response.json())
      .then(banner => {
         document.getElementById('bannerId').value = banner.id;
         
         document.getElementById('content1').value = banner.content_1;
         document.getElementById('content2').value = banner.content_2;
         document.getElementById('content3').value = banner.content_3;
         document.getElementById('isHeader').checked = banner.is_header == 1;
         
         // Load URL (nếu có)
         document.getElementById('bannerUrl').value = banner.url || '';  // Đảm bảo trường URL có giá trị mặc định là trống nếu không có URL

         // Process image from banner.image
         if (banner.image) {
            let preview = document.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'image-preview';
                document.getElementById('bannerImage').parentElement.appendChild(preview);
            }
            preview.src = `http://localhost/web_ban_banh_kem/public/images/${banner.image}`;
         }

         // Show "Save" and "Toggle Status" buttons
         document.getElementById('toggleBannerStatusBtn').innerText = banner.status == 1 ? 'Tắt Banner' : 'Bật Banner';
         
         // Show Save and Toggle Banner buttons, hide "Tạo Banner Mới"
         document.getElementById('saveBannerBtn').style.display = 'inline-block';
         document.getElementById('toggleBannerStatusBtn').style.display = 'inline-block';
         document.querySelector('.create-new-banner-btn').style.display = 'none'; // Hide "Tạo Banner Mới"
      })
      .catch(error => console.error('Error loading banner data:', error));
}


// Cập nhật banner
function saveBanner() {

   const form = document.getElementById('bannerForm');
   const formData = new FormData(form);

   // Log form data to the console
   for (let [key, value] of formData.entries()) {
       console.log(key + ": " + value);
   }

   fetch('http://localhost/web_ban_banh_kem/public/banner/update', {
      method: 'POST',
      headers: {
         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
      body: formData,
   })
   .then(response => response.json())
   .then(data => {
      alert(data.message);
      fetchBanners();  // Cập nhật lại danh sách banner sau khi lưu
      closeBannerModal();  // Đóng modal
   })
   .catch(error => console.error('Error saving banner:', error));
}




// Tắt/Bật banner
function toggleBannerStatus() {
   const bannerId = document.getElementById('bannerId').value;
   const status = document.getElementById('toggleBannerStatusBtn').innerText === 'Tắt Banner' ? 0 : 1;
   
   fetch('http://localhost/web_ban_banh_kem/public/banner/update', {
      method: 'POST',
      body: JSON.stringify({ id: bannerId, status: status }),
      headers: { 'Content-Type': 'application/json' }
   })
   .then(response => response.json())
   .then(data => {
      alert(data.message);
      fetchBanners();  // Cập nhật lại danh sách banner
      closeBannerModal();  // Đóng modal
   })
   .catch(error => console.error('Error toggling banner status:', error));
}
// Image preview functionality
document.getElementById('bannerImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.querySelector('.image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'image-preview';
                this.parentElement.appendChild(preview);
            }
            preview.src = e.target.result;
        }.bind(this);
        reader.readAsDataURL(file);
    }
});
function createNewBanner() {
    // Clear form data
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerId').value = '';
    
    // Ẩn ô nhập ID
    document.getElementById('bannerId').style.display = 'none';

    // Remove existing image preview
    const preview = document.querySelector('.image-preview');
    if (preview) {
        preview.remove();
    }
    
    // Clear the input fields for content
    document.getElementById('content1').value = '';
    document.getElementById('content2').value = '';
    document.getElementById('content3').value = '';
    
    // Show the "Tạo Banner Mới" button again
    document.querySelector('.create-new-banner-btn').style.display = 'inline-block'; // Show "Tạo Banner Mới"
    
    // Hide "Save" and "Toggle Banner" buttons
    document.getElementById('saveBannerBtn').style.display = 'none'; // Hide "Lưu"
    document.getElementById('toggleBannerStatusBtn').style.display = 'none'; // Hide "Tắt Banner"
    
    // Remove any image preview
    const previewElement = document.querySelector('.image-preview');
    if (previewElement) {
        previewElement.remove();
    }
}

// Optionally add logic for saving a new banner (This function will be triggered on the "Lưu" button click)
function saveBanner() {
    const bannerId = document.getElementById('bannerId').value;
    const content1 = document.getElementById('content1').value;
    const content2 = document.getElementById('content2').value;
    const content3 = document.getElementById('content3').value;
    const urlValue = document.getElementById('bannerUrl').value;
    const isHeader = document.getElementById('isHeader').checked ? 1 : 0;
    const imageInput = document.getElementById('bannerImage');
    const image = imageInput.files.length > 0 ? imageInput.files[0] : null; // Lấy ảnh từ input nếu có

    // Kiểm tra nếu không có ít nhất 1 ô content có dữ liệu
    if (!content1 && !content2 && !content3) {
        alert('Phải có ít nhất 1 ô nội dung có dữ liệu');
        return;
    }

    // Kiểm tra slide đã có header và status = 1 hay chưa
    fetch(`http://localhost/web_ban_banh_kem/public/check-header/${bannerId}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists && isHeader === 1) {
                alert('Slide id đang là header. Vui lòng tắt header!');
                return;
            }

            // Nếu không có vấn đề, gửi yêu cầu cập nhật Banner
            const formData = new FormData();
            formData.append('id', bannerId);
            formData.append('content_1', content1);
            formData.append('url', urlValue); 
            formData.append('content_2', content2);
            formData.append('content_3', content3);
            formData.append('is_header', isHeader);

            if (image) {
                formData.append('image', image);
            }

            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('http://localhost/web_ban_banh_kem/public/banner/update', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.message === 'Banner updated successfully') {
                    // Xử lý sau khi lưu thành công (e.g., đóng modal, làm mới danh sách)
                }
            })
            .catch(error => {
                console.error('Error saving banner:', error);
            });
        })
        .catch(error => {
            console.error('Error checking header:', error);
        });
}


// Optionally add logic for toggling banner status (This function will be triggered on the "Tắt Banner" button click)
function toggleBannerStatus() {
    // Lấy giá trị ID của Banner từ input (giả sử là trường id)

    const bannerId = document.getElementById('bannerId').value;
    // Xác nhận trước khi tắt banner
    var confirmAction = confirm("Bạn chắc chắn muốn tắt banner này?");
    if (confirmAction) {
        // Lấy token CSRF từ meta hoặc input
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Gửi yêu cầu Ajax để cập nhật trạng thái
        fetch('http://localhost/web_ban_banh_kem/public/banner/update-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Gửi token CSRF
            },
            body: JSON.stringify({
                id: bannerId,
                status: 0 // Đặt status = 0 để tắt banner
            })
        })
        .then(response => response.json())
        .then(data => {
            // Thông báo thành công
            alert(data.message);
            
            // Cập nhật giao diện nếu cần
            document.getElementById('toggleBannerStatusBtn').innerText = 'Tắt Banner'; // Hoặc thay đổi status nút
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function createNewBannerConfirmed() {
    // Lấy dữ liệu từ các ô nhập
    const content1 = document.getElementById('content1').value;
    const content2 = document.getElementById('content2').value;
    const content3 = document.getElementById('content3').value;
    const imageInput = document.getElementById('bannerImage').files[0];
    const url = document.getElementById('bannerUrl').value; //
    // Kiểm tra nếu ít nhất một ô nhập nội dung có dữ liệu
    if (!content1 && !content2 && !content3) {
        alert('Vui lòng nhập ít nhất một ô nội dung!');
        return;
    }

    // Kiểm tra nếu có ảnh được chọn
    if (!imageInput) {
        alert('Vui lòng chọn ảnh!');
        return;
    }

    // Xác nhận trước khi tạo slide
    if (confirm('Bạn có chắc chắn muốn tạo slide mới?')) {
        // Tiến hành lưu slide
        createBanner();
    }
}
function createBanner() {
    const formData = new FormData(document.getElementById('bannerForm'));

    fetch('http://localhost/web_ban_banh_kem/public/banner/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            // Không cần thêm Content-Type header khi dùng FormData
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Slide mới đã được tạo thành công!');
            // Có thể thêm code để reset form hoặc refresh trang
            document.getElementById('bannerForm').reset();
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        if (error.message) {
            alert(error.message);
        } else {
            alert('Có lỗi xảy ra khi tạo slide!');
        }
    });
}


// New function to handle the "Tạo Banner Mới" action


// Load banner image when selecting an item

    </script>
</body>
</html>