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
    <h2>Quản Lý Sản Phẩm</h2>
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
        <button id="exportAll" class=" btn-success">In tất cả</button>
        <button id="exportSelected"class=" btn-success">In đã chọn</button>
    </div>
    <button class="toolbar-btn" onclick="openModal()">
        <i class="fas fa-warehouse"></i>
        Nhập kho
    </button>
    <button class="toolbar-btn importBtn">
        <i class="fas fa-clipboard-list"></i>
        Đề xuất nhập
    </button>
    <button class="toolbar-btn" onclick="openModalStatic()">
        <i class="fas fa-chart-bar"></i> Thống kê
    </button>
    <button class="toolbar-btn" onclick="openFoodSuggestStatic()">
    <i class="fas fa-utensils"></i> Đề xuất thực phẩm cho khoa
</button>
    <!-- Thêm 2 nút mới -->
    <button class="toolbar-btn" onclick="openAddProductModal()">
    <i class="fas fa-plus-circle"></i> Thêm sản phẩm
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
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
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
            <th>Mã</th>
            <th>Tên</th>
            <th>Danh mục</th>
            <th>Ngày thêm</th>
            <th>Giá gốc</th>
            <th>Khuyến mãi</th>
            <th>Giá bán ra</th>
            <th>Số lượng đã bán</th>
            <th>Số lượng tồn</th>
            <th>SL cảnh báo tồn</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody id="productTable">
        <!-- Dữ liệu sẽ được tải động qua AJAX -->
    </tbody>
</table>
<!-- Hiển thị phân trang -->
<div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
<!-- Modal Thống Kê -->
<div id="statisticsModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModalProduct()">&times;</span>
        <div class="container">
            <div class="header">
                <h1>Thống kê sản phẩm</h1>
                <p id="productName">Sản phẩm</p>
            </div>

            <div class="stats-grid">
                <!-- Các thông số thống kê sẽ được điền vào đây -->
                <div class="stat-card">
                    <h3>Doanh số tháng này</h3>
                    <div class="value" id="monthlySales">23.5M</div>
                    <div class="trend" id="monthlyTrend">↑ 12.3%</div>
                </div>

                <div class="stat-card">
                    <h3>Số lượng đã bán</h3>
                    <div class="value" id="quantitySold">142</div>
                    <div class="trend" id="quantityTrend">↑ 8.7%</div>
                </div>

                <div class="stat-card">
                    <h3>Đánh giá trung bình</h3>
                    <div class="value" id="averageRating">4.8/5</div>
                    <div class="trend" id="ratingTrend">↑ 0.2</div>
                </div>

                <div class="stat-card">
                    <h3>Tồn kho</h3>
                    <div class="value" id="stockLeft">45</div>
                    <div class="trend" id="stockTrend">↓ 15%</div>
                </div>
            </div>

            <div class="chart-container">
                <h2 class="chart-title">Biểu đồ doanh số 6 tháng gần nhất</h2>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="statsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Thống kê tất cả sản phẩm </h2>
            <button class="close-btn" onclick="closeModalStatic()">&times;</button>
        </div>

        <!-- Bộ lọc -->
        <div class="filter-section">
            <div class="filter-group">
                <label for="category-filter">Danh mục</label>
                <select id="category-filter">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="time-filter">Thời gian</label>
                <select id="time-filter">
                    <option value="7">7 ngày qua</option>
                    <option value="30">30 ngày qua</option>
                    <option value="90">90 ngày qua</option>
                    <option value="custom">Tùy chỉnh</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="date-from">Từ ngày</label>
                <input type="date" id="date-from" disabled>
            </div>
            <div class="filter-group">
                <label for="date-to">Đến ngày</label>
                <input type="date" id="date-to" disabled>
            </div>
        </div>

        <!-- Thống kê -->
        <div class="stats-row" id="stats-summary">
            <!-- Sẽ được điền động bằng JavaScript -->
        </div>

        <!-- Biểu đồ -->
        <div class="charts-grid">
    <div class="chart-container">
        <h3>Doanh số bán hàng</h3>
        <div class="chart-tabs">
            <button class="chart-tab active" data-type="line">Đường</button>
            <button class="chart-tab" data-type="bar">Cột</button>
        </div>
        <canvas id="sales-chart"></canvas>
    </div>
    <div class="chart-container">
        <h3>Phân bổ danh mục</h3>
        <div class="chart-tabs">
            <button class="chart-tab active" data-type="pie">Tròn</button>
            <button class="chart-tab" data-type="doughnut">Vòng</button>
        </div>
        <canvas id="category-chart"></canvas>
    </div>
</div>




        <!-- Sản phẩm bán chạy -->
        <div class="top-products-section">
            <h3>Top sản phẩm bán chạy</h3>
            <table class="top-products-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Số lượng bán</th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody id="top-products-table">
                    <!-- Sẽ được điền động -->
                </tbody>
            </table>
        </div>
        <div class="inventory-section">
                <h3>Thống kê nhập hàng</h3>
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Tổng giá trị</th>
                           
                        </tr>
                    </thead>
                    <tbody id="inventory-table">
                        <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
                    </tbody>
                </table>
            </div>
    </div>
</div>



            <!-- Thống kê nhập hàng -->
            
        </div>
    </div>
    <div id="suggestionTable" class="suggestion-table">
        <div class="table-content">
            <span class="close">&times;</span>
            <h2>Đề xuất nhập hàng tự động</h2>
            
            <div class="filter-section">
                <select id="filterWarning">
                    <option value="all">Tất cả sản phẩm</option>
                    <option value="warning">Sắp hết hàng</option>
                    <option value="danger">Cần nhập gấp</option>
                </select>
                <input type="number" id="daysPredict" min="1" value="15" placeholder="Số ngày dự đoán">
                <button onclick="updateTable()">Cập nhật</button>
            </div>

            <button class="export-btn" onclick="exportToExcel()">Xuất Excel</button>
            
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên sản phẩm</th>
                        <th>Tồn kho</th>
                        <th>Đã bán (15 ngày)</th>
                        <th>TB bán/ngày</th>
                        <th>Ngày hết dự kiến</th>
                        <th>Gợi ý nhập</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <div id="importModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Import dữ liệu từ Excel</h2>
            
            <input type="file" id="excelFile" accept=".xlsx, .xls" class="file-input">
            <div id="error" class="error"></div>
            
            <div id="tableContainer"></div>
            
            <button id="importBtn" class="import-btn" style="display: none;">
                Import dữ liệu đã chọn
            </button>
        </div>
    

    </div>

  <!-- Modal Lịch sử -->
<div id="modalHistory" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModalHistory()">&times;</span>
        <h2>Lịch sử</h2>
        
        <!-- Bộ lọc thời gian và thao tác -->
        <div class="history-filters">
            <label for="filterDateFrom">Từ ngày:</label>
            <input type="date" id="filterDateFrom">
            
            <label for="filterDateTo">Đến ngày:</label>
            <input type="date" id="filterDateTo">
            
            <label for="filterAction">Thao tác:</label>
            <select id="filterAction">
                <option value="">Tất cả</option>
                <option value="import">Nhập hàng</option>
                <option value="update">Cập nhật</option>
                <option value="delete">Xóa</option>
            </select>
            
            <button class="btn-filter" onclick="applyFilters()">Lọc</button>
        </div>
        
        <!-- Bảng lịch sử -->
        <table id="historyTable" class="history-table">
            <thead>
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Thao tác</th>
                    <th>Nội dung</th>
                    <th>Quản trị viên</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                </tr>
            </thead>
            <tbody id="historyTableBody">
                <!-- Dữ liệu sẽ được chèn vào đây -->
            </tbody>
        </table>
    </div>
</div>
<div id="addProductModal" class="addProductModal">
<div class="modal-content">
    <span class="close" onclick="closeAddProductModal()">&times;</span>
    <h2>Thêm sản phẩm</h2>
    <div class="modal-body">
  <!-- Cột bên trái -->
  <div class="left-column">
    <form id="addProductForm">
      <div class="form-group">
        <label for="productCode">Mã sản phẩm:</label>
        <input type="text" id="productCode" name="productCode" required>
      </div>
      <div class="form-group">
        <label for="productName">Tên sản phẩm:</label>
        <input type="text" id="productName1" name="productName" required>
      </div>
      <div class="form-group">
        <label for="productCategory">Danh mục:</label>
        <select id="productCategory" name="productCategory" required>
          <option value="">Chọn danh mục</option>
          @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="importPrice">Giá nhập:</label>
        <input type="number" id="importPrice" name="importPrice" required>
      </div>
      <div class="form-group">
        <label for="originalPrice">Giá gốc:</label>
        <input type="number" id="originalPrice" name="originalPrice" required>
      </div>
      <div class="form-group">
        <label for="discountPercent">Khuyến mãi (%):</label>
        <input type="number" id="discountPercent" name="discountPercent" min="0" max="100" required>
      </div>
      <div class="form-group">
        <label for="finalPrice">Giá bán:</label>
        <input type="number" id="finalPrice" name="finalPrice" readonly required>
      </div>
      <div class="form-group">
        <label for="stockQuantity">Số lượng tồn:</label>
        <input type="number" id="stockQuantity" name="stockQuantity" required>
      </div>
      <div class="form-group">
        <label for="description">Giới thiệu:</label>
        <textarea id="description" name="description" rows="3"></textarea>
      </div>
     
    </form>
  </div>

  <!-- Cột bên phải -->
  <div class="right-column">
    <div class="form-group">
      <label for="productImage">Ảnh sản phẩm:</label>
      <input type="file" id="productImage" name="productImage" accept="image/*" onchange="previewImage(event)">
      <img id="imagePreview" src="#" alt="Xem trước ảnh" style="display: none; max-width: 100%; margin-top: 10px;">
    </div>
  </div>
</div>
<div class="form-group">
  <button type="button" id="saveProductButton">Lưu sản phẩm</button>
</div>
<div class="form-group">
  <label for="excelFileInput">Nhập file Excel:</label>
  <div style="display: flex; align-items: center; gap: 10px;">
    <input type="file" id="excelFileInput" accept=".xlsx, .xls" onchange="handleExcelUpload(event)">
    <button type="button" id="clearFileButton" onclick="clearExcelFile()">Xóa file</button>
  </div>
</div>


  </div>
  </div>
  <div class="addProductExcelModal" style="display: none;">
  <div class="modal-content">
    <span class="close" onclick="closeExcelModal()">&times;</span>
    <h2>Thêm nhiều sản phẩm từ Excel</h2>
    <!-- Chú thích màu sắc -->
    <div>
      <p><strong>Chú thích:</strong></p>
      <ul>
        <li style="color: yellow;">Màu vàng: Mã sản phẩm bị trùng hoặc danh mục không tồn tại</li>
        <li style="color: red;">Màu đỏ: Dữ liệu không đúng định dạng</li>
      </ul>
    </div>
    <table id="excelTable">
      <thead>
        <tr>
          <th><input type="checkbox" id="checkAll" onclick="toggleCheckAll(this)"></th>
          <th>Mã sản phẩm</th>
          <th>Tên sản phẩm</th>
          <th>Danh mục</th>
          <th>Giá nhập</th>
          <th>Giá gốc</th>
          <th>Khuyến mãi (%)</th>
          <th>Giá bán</th>
          <th>Số lượng tồn</th>
          <th>Giới thiệu</th>
        </tr>
      </thead>
      <tbody>
        <!-- Nội dung sẽ được tạo động qua JavaScript -->
      </tbody>
    </table>
    <div class="form-group">
      <button onclick="addSelectedProducts()">Thêm nhiều sản phẩm</button>
    </div>
  </div>
</div>
<!-- Modal Edit Product -->

<div id="editProductModal" class="editProduct-modal">
        <div class="editProduct-modal-content">
            <div class="editProduct-modal-header">
                <h2>Chỉnh Sửa Sản Phẩm</h2>
                <button onclick="closeEditProductModal()">&times;</button>
            </div>
            
            <form id="editProductForm">
                <div class="editProduct-modal-body">
                    <div class="editProduct-form-column">
                        <div class="editProduct-form-group">
                            <label for="editProduct-name">Tên Sản Phẩm</label>
                            <input type="text" id="editProduct-name" name="name" required>
                        </div>

                        <div class="editProduct-form-group">
                            <label for="editProduct-category">Danh Mục</label>
                            <select id="editProduct-category" name="category_id">
                            @foreach ($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
                            </select>
                        </div>

                        <div class="editProduct-form-group locked">
                            <label for="editProduct-posted-date">Ngày Thêm</label>
                            <input type="date" id="editProduct-posted-date" name="posted_date" readonly>
                        </div>

                        <div class="editProduct-form-group">
                            <label for="editProduct-original-price">Giá Gốc</label>
                            <input type="number" id="editProduct-original-price" name="original_price" required>
                        </div>

                        <div class="editProduct-form-group">
                            <label for="editProduct-discount">Giảm Giá (%)</label>
                            <input type="number" id="editProduct-discount" name="discount" min="0" max="100">
                        </div>

                        <div class="editProduct-form-group locked">
                            <label for="editProduct-price">Giá Bán</label>
                            <input type="text" id="editProduct-price" name="price" readonly>
                        </div>

                        <div class="editProduct-form-group">
                            <label for="editProduct-quantity">Số Lượng Tồn</label>
                            <input type="number" id="editProduct-quantity" name="quantity_in_stock" min="0">
                        </div>

                        <div class="editProduct-form-group locked">
                            <label for="editProduct-quantity-sold">Số Lượng Đã Bán</label>
                            <input type="number" id="editProduct-quantity-sold" name="quantity_sold" readonly>
                        </div>

                        <div class="editProduct-form-group" style="grid-column: span 2;">
                            <label for="editProduct-description">Mô Tả</label>
                            <textarea id="editProduct-description" name="description" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="editProduct-image-section">
                        <div id="editProduct-image-placeholder" class="editProduct-image-placeholder">
                            <img id="editProduct-image-preview" class="editProduct-image-preview" src="" alt="Xem trước ảnh" style="display:none;">
                            <span id="editProduct-no-image">Chưa có ảnh</span>
                        </div>

                        <input 
                            type="file" 
                            id="editProduct-image" 
                            name="image" 
                            accept="image/*" 
                            class="editProduct-image-input"
                        >
                        <label for="editProduct-image" class="editProduct-image-label">
                            Chọn Ảnh
                        </label>
                    </div>
                </div>

                <div class="editProduct-modal-footer">
                    <button type="button" class="editProduct-btn-cancel" onclick="closeEditProductModal()">Hủy</button>
                    <button type="submit" class="editProduct-btn-save">Lưu Thay Đổi</button>
                </div>
            </form>
        </div>
    </div>
    <div id="productHistoryModal" class="productHistory-modal" style="display: none;">
    <div class="productHistory-modal-content">
        <div class="productHistory-modal-header">
            <h2>Lịch Sử Sản Phẩm</h2>
            <button onclick="closeProductHistoryModal()">&times;</button>
        </div>

        <div class="productHistory-filter-section">
            <div class="productHistory-filter-group">
                <label for="productHistory-date-start">Từ ngày:</label>
                <input type="date" id="productHistory-date-start">
                
                <label for="productHistory-date-end">Đến ngày:</label>
                <input type="date" id="productHistory-date-end">
            </div>

            <div class="productHistory-filter-group">
                <label for="productHistory-action-filter">Loại thao tác:</label>
                <select id="productHistory-action-filter" multiple>
                    <option value="add">Thêm mới</option>
                    <option value="update">Cập nhật</option>
                    <option value="import">Nhập khẩu</option>
                    <option value="delete">Xóa</option>
                    <option value="store-multiple">Thêm nhiều</option>
                </select>
            </div>
        </div>

        <table class="productHistory-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thời Gian</th>
                    <th>Loại Thao Tác</th>
                    <th>Nội Dung</th>
                    <th>Quản Trị Viên</th>
                </tr>
            </thead>
            <tbody id="productHistory-table-body">
                <!-- Dữ liệu sẽ được điền động -->
            </tbody>
        </table>

        <div class="productHistory-pagination">
            <button id="productHistory-prev-btn" onclick="changePage(-1)">Trước</button>
            <span id="productHistory-page-info">Trang 1/1</span>
            <button id="productHistory-next-btn" onclick="changePage(1)">Sau</button>
        </div>
    </div>
</div>
<div id="food-suggest-modal" class="food-suggest-modal">
    <div class="food-suggest-modal-content">
        <div class="suggestion-part">
            <!-- Danh sách sản phẩm -->
            <div class="product-list">
                <h3>Danh sách sản phẩm</h3>
                <ul id="product-list">
                    <!-- Các sản phẩm sẽ được hiển thị ở đây -->
                </ul>
            </div>
            
            <!-- Thông tin chi tiết sản phẩm -->
            <div class="product-details">
                <h3>Chi tiết sản phẩm</h3>
                <form id="product-details-form">
                    <div>
                        <label for="department-suggestion">Khoa gợi ý:</label>
                        <input type="text" id="department-suggestion" name="department-suggestion" placeholder="Nhập khoa gợi ý">
                    </div>
                    <div>
                        <label for="disease-suggestion">Bệnh gợi ý:</label>
                        <input type="text" id="disease-suggestion" name="disease-suggestion" placeholder="Nhập bệnh gợi ý">
                    </div>
                    <div>
                        <label for="flavor">Hương vị:</label>
                        <input type="text" id="flavor" name="flavor" placeholder="Nhập hương vị">
                    </div>
                    <div>
                        <label for="benefits">Công dụng:</label>
                        <input type="text" id="benefits" name="benefits" placeholder="Nhập công dụng">
                    </div>
                    <div>
                        <label for="meal-time">Buổi ăn:</label>
                        <input type="text" id="meal-time" name="meal-time" placeholder="Nhập buổi ăn">
                    </div>
                    <button type="button" onclick="saveProductSuggestion()">Lưu</button>
                </form>
            </div>
        </div>
        <button id="close-food-suggest-modal" class="close-modal-btn" onclick="closeFoodSuggestModal()">Đóng</button>
    </div>
</div>
<!-- Modal -->
<!-- Modal -->
<div id="nutritionModal" class="nutritionmodal">
    <div class="nutritionmodal-content">
        <!-- Nút đóng modal -->
        <span onclick="closeNutritionModal()" class="close">&times;</span>

        <!-- Tên sản phẩm -->
        <h4 id="productNameNutiral" style="text-align: center; font-weight: bold; margin-bottom: 20px;"></h4>

        <h4>Thông tin thành phần dinh dưỡng</h4>
        <form id="nutritionForm">
            <input type="hidden" id="product_id" name="product_id">
            <div class="input-field">
                <label for="calories">Calorie (Năng lượng)</label>
                <input type="number" id="calories" name="calories" value="0">
            </div>
            <div class="input-field">
                <label for="protein">Chất đạm</label>
                <input type="number" id="protein" name="protein" value="0">
            </div>
            <div class="input-field">
                <label for="fat">Chất béo</label>
                <input type="number" id="fat" name="fat" value="0">
            </div>
            <div class="input-field">
                <label for="carbohydrate">Carbohydrate</label>
                <input type="number" id="carbohydrate" name="carbohydrate" value="0">
            </div>
            <div class="input-field">
                <label for="sugar">Đường</label>
                <input type="number" id="sugar" name="sugar" value="0">
            </div>
            <div class="input-field">
                <label for="fiber">Chất xơ</label>
                <input type="number" id="fiber" name="fiber" value="0">
            </div>
            <button type="submit" class="btn">Lưu</button>
        </form>
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

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.dropdown-btn') && !event.target.matches('.fa-chevron-down')) {
        const dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }
}

// Initial render


// Search functionality (giữ nguyên code cũ)
document.querySelector('.search-box').addEventListener('input', (e) => {
    // ... giữ nguyên code search ...
});
// Mở modal
let chartInstance = null; // Biến toàn cục để lưu instance của biểu đồ

function openModalProduct(productId) {
    // Gọi API để lấy dữ liệu thống kê cho sản phẩm
    fetch(`http://localhost/web_ban_banh_kem/public/product/${productId}/statistics`)
        .then(response => response.json())
        .then(data => {
            // Cập nhật thông tin vào modal
            document.getElementById('productName').textContent = data.product;
            document.getElementById('monthlySales').textContent = formatCurrency(Number(data.currentMonthSales)||0);
            document.getElementById('quantitySold').textContent = data.quantitySold;
            document.getElementById('averageRating').textContent = data.averageRating;
            document.getElementById('stockLeft').textContent = data.stockLeft;

            // Tạo thông tin về xu hướng
            updateTrend('monthlyTrend', data.salesIncrease);
            updateTrend('quantityTrend', data.quantityIncrease);
            updateTrend('ratingTrend', data.ratingTrend);
            updateTrend('stockTrend', data.stockTrend);

            // Lấy ngữ cảnh của biểu đồ
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Nếu đã có biểu đồ trước đó, hủy nó
            if (chartInstance) {
                chartInstance.destroy(); // Hủy biểu đồ cũ
            }

            // Dữ liệu biểu đồ mới
            const chartData = {
                labels: data.chartData.labels,
                datasets: [{
                    label: 'Doanh số',
                    data: data.chartData.data,
                    fill: true,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    tension: 0.4
                }]
            };

            // Tạo biểu đồ mới và lưu vào biến chartInstance
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: chartData
            });

            // Hiển thị modal
            document.getElementById('statisticsModal').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
}

function updateTrend(elementId, trend) {
    const trendElement = document.getElementById(elementId);

    // Kiểm tra xu hướng và thay đổi nội dung + kiểu dáng
    if (trend > 0) {
        trendElement.innerHTML = `↑ ${trend}%`;
        trendElement.className = 'trend positive';
    } else if (trend < 0) {
        trendElement.innerHTML = `↓ ${Math.abs(trend)}%`;
        trendElement.className = 'trend negative';
    } else {
        trendElement.innerHTML = '--';
        trendElement.className = 'trend neutral';
    }
}


function closeModalProduct() {
    // Hủy biểu đồ nếu có
    if (chartInstance) {
        chartInstance.destroy(); // Hủy biểu đồ
        chartInstance = null; // Đặt lại instance
    }

    // Ẩn modal
    document.getElementById('statisticsModal').style.display = 'none';
}


$(document).ready(function () {
    // Hàm tải dữ liệu sản phẩm
    function loadProducts(limit) {
        $.ajax({
            url: `http://localhost/web_ban_banh_kem/public/products?limit=${limit}`, // URL API lấy sản phẩm
            method: 'GET',
            success: function (data) {
                const productTable = $('#productTable');
                productTable.empty(); // Xóa bảng hiện tại

                // Kiểm tra nếu có dữ liệu
                if (data.products && data.products.length > 0) {
                    // Tạo hàng cho từng sản phẩm
                    data.products.forEach(function (product) {
                        productTable.append(`
                            <tr class="product-row" data-id="${product.id}">
                                <td class="checkbox-cell"><input type="checkbox"></td>

                                <td class="image-cell">
                                    <img src="http://localhost/web_ban_banh_kem/public/images/${product.image}" alt="${product.name}" style="width: 50px; height: 50px;">
                                </td>
                                 <td>${product.id}</td>
        <td>${product.name}</td>
        <td>${product.category ? product.category.name : 'Không có danh mục'}</td>
        <td>${formatDate(product.created_at)}</td> <!-- Định dạng ngày thêm -->
    <td>${formatCurrency(Number(product.original_price) || 0)}</td> <!-- Giá gốc -->
            <td>${product.discount ? `${product.discount}%` : '0%'}</td> <!-- Khuyến mãi (dưới dạng %) -->
            <td>${formatCurrency(Number(product.price) || 0)}</td> <!-- Giá bán ra -->

        <td>${product.quantity_sold}</td> <!-- Số lượng đã bán -->
        <td>${product.quantity_in_stock}</td> <!-- Số lượng tồn -->
        <td>${product.stock_warning ? product.stock_warning : 'Không'}</td> <!-- Số lượng cảnh báo tồn -->
                                <td>
                                    <div class="action-dropdown">
                                        <button class="action-btn dropdown-btn" onclick="toggleDropdown(this)">
                                            Tác vụ
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="javascript:void(0);" onclick="openEditProductModal(${product.id})" class="edit-product-link">
    <i class="fas fa-edit"></i> Sửa
</a>
                                           <a href="javascript:void(0);" onclick="confirmDeleteProduct(${product.id}, '${product.name}')" class="delete-product-link">
    <i class="fas fa-trash"></i> Xóa
</a>
                                            <a href="javascript:void(0);" onclick="openNutritionModal(${product.id })" class="nutrition-fact-link">
  <i class="fa-brands fa-nutritionix"></i> Dinh dưỡng
</a>
                                            <a href="javascript:void(0);" onclick="openModalProduct(${product.id})"><i class="fas fa-chart-bar"></i> Thống kê sản phẩm</a>
                  <a href="javascript:void(0);" 
   onclick="openProductHistoryModal(${product.id})" 
   class="product-history-link">
    <i class="fas fa-history"></i> Lịch sử
</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    productTable.append('<tr><td colspan="13">Không có sản phẩm nào.</td></tr>');
                }
            },
            error: function () {
                $('#productTable').html('<tr><td colspan="13">Đã xảy ra lỗi khi tải sản phẩm.</td></tr>');
            }
        });
    }

    // Gọi lần đầu với giá trị mặc định (10 sản phẩm)
    loadProducts(10);

    // Lắng nghe sự kiện thay đổi trên dropdown
    $('#displayLimit').change(function () {
        const selectedLimit = $(this).val(); // Lấy giá trị được chọn
        loadProducts(selectedLimit); // Gọi lại hàm loadProducts
    });
});
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    });
}
function formatCurrency(amount) {
    return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
$(document).ready(function () {
    // Hàm để tải sản phẩm dựa trên các bộ lọc
    function fetchFilteredProducts() {
        const category = $('#categoryFilter').val(); // Lấy giá trị danh mục
        const sort = $('#sortOption').val(); // Lấy giá trị sắp xếp

        $.ajax({
            url: 'http://localhost/web_ban_banh_kem/public/api/products/filter', // API xử lý lọc và sắp xếp
            method: 'GET',
            data: {
                category: category,
                sort: sort,
            },
            success: function (response) {
                const productTable = $('#productTable');
                productTable.empty(); // Xóa bảng hiện tại

                // Kiểm tra dữ liệu sản phẩm
                if (response.products && response.products.length > 0) {
                    // Hiển thị danh sách sản phẩm
                    response.products.forEach(function (product) {
                        productTable.append(`
                            <tr class="product-row" data-id="${product.id}">
                                <td class="checkbox-cell"><input type="checkbox"></td>

                                <td class="image-cell">
                                    <img src="http://localhost/web_ban_banh_kem/public/images/${product.image}" alt="${product.name}" style="width: 50px; height: 50px;">
                                </td>
                                <td>${product.id}</td>
                                <td>${product.name}</td>
                                <td>${product.category ? product.category.name : 'Không có danh mục'}</td>
                                <td>${formatDate(product.created_at)}</td>
                             <td>${formatCurrency(Number(product.original_price) || 0)}</td> <!-- Giá gốc -->
            <td>${product.discount ? `${product.discount}%` : '0%'}</td> <!-- Khuyến mãi (dưới dạng %) -->
            <td>${formatCurrency(Number(product.price) || 0)}</td> <!-- Giá bán ra -->
                                <td>${product.quantity_sold}</td>
                                <td>${product.quantity_in_stock}</td>
                                <td>${product.stock_warning ? product.stock_warning : 'Không'}</td>
                                <td>
                                    <div class="action-dropdown">
                                        <button class="action-btn dropdown-btn" onclick="toggleDropdown(this)">
                                            Tác vụ
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                           <a href="javascript:void(0);" onclick="openEditProductModal(${product.id})" class="edit-product-link">
    <i class="fas fa-edit"></i> Sửa
</a>
                                             <a href="javascript:void(0);" onclick="confirmDeleteProduct(${product.id}, '${product.name}')" class="delete-product-link">
    <i class="fas fa-trash"></i> Xóa
    <a href="javascript:void(0);" onclick="openNutritionModal(${product.id })" class="nutrition-fact-link">
    <i class="fa-brands fa-nutritionix"></i> Dinh dưỡng
                                           <a href="javascript:void(0);" onclick="openModalProduct(${product.id})"><i class="fas fa-chart-bar"></i> Thống kê sản phẩm</a>
                                          <a href="javascript:void(0);" 
   onclick="openProductHistoryModal(${product.id})" 
   class="product-history-link">
    <i class="fas fa-history"></i> Lịch sử
</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    productTable.append('<tr><td colspan="13">Không có sản phẩm nào.</td></tr>');
                }
            },
            error: function () {
                $('#productTable').html('<tr><td colspan="13">Đã xảy ra lỗi khi tải sản phẩm.</td></tr>');
            },
        });
    }

    // Lắng nghe sự kiện thay đổi từ các bộ lọc
    $('#categoryFilter').on('change', fetchFilteredProducts);
    $('#sortOption').on('change', fetchFilteredProducts);

    // Gọi hàm để hiển thị sản phẩm ban đầu
    fetchFilteredProducts();
});

$(document).ready(function () {
    // Hàm tìm kiếm sản phẩm
    function searchProducts(query) {
        $.ajax({
            url: 'http://localhost/web_ban_banh_kem/public/api/products/search', // API tìm kiếm
            method: 'GET',
            data: {
                query: query, // Gửi giá trị tìm kiếm
            },
            success: function (response) {
                const productTable = $('#productTable');
                productTable.empty(); // Xóa dữ liệu hiện tại

                // Hiển thị danh sách sản phẩm nếu có dữ liệu
                if (response.products && response.products.length > 0) {
                    response.products.forEach(function (product) {
                        productTable.append(`
                            <tr class="product-row" data-id="${product.id}">
                                <td class="checkbox-cell"><input type="checkbox"></td>

                                <td class="image-cell">
                                    <img src="http://localhost/web_ban_banh_kem/public/images/${product.image}" alt="${product.name}" style="width: 50px; height: 50px;">
                                </td>
                                <td>${product.id}</td>
                                <td>${product.name}</td>
                                <td>${product.category ? product.category.name : 'Không có danh mục'}</td>
                                <td>${formatDate(product.created_at)}</td>
          <td>${formatCurrency(Number(product.original_price) || 0)}</td> <!-- Giá gốc -->
            <td>${product.discount ? `${product.discount}%` : '0%'}</td> <!-- Khuyến mãi (dưới dạng %) -->
            <td>${formatCurrency(Number(product.price) || 0)}</td> <!-- Giá bán ra -->
                                <td>${product.quantity_sold}</td>
                                <td>${product.quantity_in_stock}</td>
                                <td>${product.stock_warning ? product.stock_warning : 'Không'}</td>
                                <td>
                                    <div class="action-dropdown">
                                        <button class="action-btn dropdown-btn" onclick="toggleDropdown(this)">
                                            Tác vụ
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="javascript:void(0);" onclick="openEditProductModal(${product.id})" class="edit-product-link">
    <i class="fas fa-edit"></i> Sửa
</a>
                                           <a href="javascript:void(0);" onclick="confirmDeleteProduct(${product.id}, '${product.name}')" class="delete-product-link">
    <i class="fas fa-trash"></i> Xóa
    <a href="javascript:void(0);" onclick="openNutritionModal(${product.id })" class="nutrition-fact-link">
    <i class="fa-brands fa-nutritionix"></i>Dinh dưỡng
                                             <a href="javascript:void(0);" onclick="openModalProduct(${product.id})"><i class="fas fa-chart-bar"></i> Thống kê sản phẩm</a>
                                            <a href="javascript:void(0);" 
   onclick="openProductHistoryModal(${product.id})" 
   class="product-history-link">
    <i class="fas fa-history"></i> Lịch sử
</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    productTable.append('<tr><td colspan="13">Không tìm thấy sản phẩm.</td></tr>');
                }
            },
            error: function () {
                $('#productTable').html('<tr><td colspan="13">Đã xảy ra lỗi khi tìm kiếm.</td></tr>');
            }
        });
    }

    // Lắng nghe sự kiện nhập liệu trên ô tìm kiếm
    $('.search-box').on('input', function () {
        const query = $(this).val().trim(); // Lấy giá trị tìm kiếm
        searchProducts(query); // Gọi hàm tìm kiếm
    });
});
$(document).ready(function () {
    // Lắng nghe sự kiện click trên checkbox ở tiêu đề
    $('.checkbox-cell input[type="checkbox"]').on('click', function () {
        const isChecked = $(this).is(':checked'); // Kiểm tra trạng thái của checkbox
        // Cập nhật trạng thái của tất cả các checkbox trong bảng
        $('#productTable .checkbox-cell input[type="checkbox"]').prop('checked', isChecked);
    });

    // Lắng nghe sự kiện click trên từng checkbox trong bảng
    $('#productTable').on('click', '.checkbox-cell input[type="checkbox"]', function () {
        const allCheckboxes = $('#productTable .checkbox-cell input[type="checkbox"]');
        const allChecked = allCheckboxes.length === allCheckboxes.filter(':checked').length;
        // Cập nhật trạng thái của checkbox tiêu đề nếu tất cả checkbox được chọn
        $('.checkbox-cell input[type="checkbox"]').first().prop('checked', allChecked);
    });
});
$(document).ready(function () {
    $('.excel-export-btn').on('click', function (e) {
        e.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        $('.excel-options').toggle();
    });

    // Ẩn menu khi click ra ngoài
    $(document).on('click', function () {
        $('.excel-options').hide();
    });
    // Gọi API xuất tất cả sản phẩm
    $('#exportAll').on('click', function () {
        window.location.href = "http://localhost/web_ban_banh_kem/public/export-excel?type=all";
    });

    // Gọi API xuất các sản phẩm đã chọn
    $('#exportSelected').on('click', function () {
    const selectedIds = [];
    // Lấy ID từ các hàng được chọn
    $('#productTable .checkbox-cell input[type="checkbox"]:checked').each(function () {
        const rowId = $(this).closest('tr').data('id'); // Lấy giá trị data-id
        if (rowId) {
            selectedIds.push(rowId); // Thêm vào mảng selectedIds
        }
    });

    // Kiểm tra nếu không có sản phẩm nào được chọn
    if (selectedIds.length === 0) {
        alert('Vui lòng chọn ít nhất một sản phẩm để xuất.');
        return;
    }

    // Gọi API xuất file Excel với danh sách ID
    const url = `http://localhost/web_ban_banh_kem/public/export-excel?type=selected&ids=${selectedIds.join(',')}`;
    window.location.href = url;
});

});
function openModalStatic() {
            document.getElementById('statsModal').style.display = 'flex';
        }

        function closeModalStatic() {
            document.getElementById('statsModal').style.display = 'none';
        }

        let salesChart = null;
let categoryChart = null;
let salesData = {};  // Biến lưu trữ dữ liệu doanh thu bán hàng
let categoryData = {};  // Biến lưu trữ dữ liệu phân bổ danh mục

// Hàm gọi API để lấy dữ liệu biểu đồ
function fetchChartData() {
    $.ajax({
        url: 'http://localhost/web_ban_banh_kem/public/api/charts-data',  // Đảm bảo đường dẫn đúng
        method: 'GET',
        success: function(data) {
            // Lưu trữ dữ liệu vào các biến toàn cục
            salesData = data.sales;
            categoryData = data.categories;

            // Cập nhật biểu đồ
            updateSalesChart(salesData);
            updateCategoryChart(categoryData);
        }
    });
}

// Cập nhật biểu đồ doanh thu bán hàng
function updateSalesChart(salesData) {
    if (salesChart) {
        salesChart.destroy();  // Hủy biểu đồ hiện tại trước khi tạo biểu đồ mới
    }

    const ctx = document.getElementById('sales-chart').getContext('2d');
    salesChart = new Chart(ctx, {
        type: 'line',  // Loại biểu đồ mặc định là Line
        data: {
            labels: Object.keys(salesData),  // Ngày (từ salesData)
            datasets: [{
                label: 'Doanh số bán hàng',
                data: Object.values(salesData),  // Tổng doanh thu (từ salesData)
                backgroundColor: 'rgba(0,123,255,0.5)',  // Màu nền của các điểm
                borderColor: 'rgba(0,123,255,1)',  // Màu đường viền
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,  // Biểu đồ phản hồi khi thay đổi kích thước
            plugins: {
                legend: { position: 'top' }  // Vị trí của legend
            }
        }
    });
}

// Cập nhật biểu đồ phân bổ danh mục
function updateCategoryChart(categoryData) {
    if (categoryChart) {
        categoryChart.destroy();  // Hủy biểu đồ hiện tại trước khi tạo biểu đồ mới
    }

    const ctx = document.getElementById('category-chart').getContext('2d');
    categoryChart = new Chart(ctx, {
        type: 'pie',  // Loại biểu đồ mặc định là Pie
        data: {
            labels: Object.keys(categoryData),  // Tên danh mục
            datasets: [{
                label: 'Phân bổ danh mục',
                data: Object.values(categoryData),  // Doanh thu theo từng danh mục
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
}

// Hủy biểu đồ cũ trước khi vẽ lại
function destroyChart(chart) {
    if (chart) {
        chart.destroy();  // Hủy biểu đồ cũ
    }
}

// Lắng nghe sự kiện thay đổi loại biểu đồ
$(document).on('click', '.chart-tab', function() {
    const chartType = $(this).data('type');
    const chartId = $(this).closest('.chart-container').find('canvas').attr('id');

    // Thay đổi loại biểu đồ cho doanh thu bán hàng
    if (chartId === 'sales-chart') {
        updateSalesChartType(chartType);
    } 
    // Thay đổi loại biểu đồ cho phân bổ danh mục
    else if (chartId === 'category-chart') {
        updateCategoryChartType(chartType);
    }
});

// Cập nhật loại biểu đồ doanh thu bán hàng
function updateSalesChartType(type) {
    if (salesChart) {
        salesChart.destroy();  // Hủy biểu đồ cũ
    }

    const ctx = document.getElementById('sales-chart').getContext('2d');
    salesChart = new Chart(ctx, {
        type: type,  // Thay đổi loại biểu đồ
        data: {
            labels: Object.keys(salesData),  // Ngày
            datasets: [{
                label: 'Doanh số bán hàng',
                data: Object.values(salesData),  // Tổng doanh thu
                backgroundColor: 'rgba(0,123,255,0.5)',
                borderColor: 'rgba(0,123,255,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
}

// Cập nhật loại biểu đồ phân bổ danh mục
function updateCategoryChartType(type) {
    if (categoryChart) {
        categoryChart.destroy();  // Hủy biểu đồ cũ
    }

    const ctx = document.getElementById('category-chart').getContext('2d');
    categoryChart = new Chart(ctx, {
        type: type,  // Thay đổi loại biểu đồ
        data: {
            labels: Object.keys(categoryData),  // Danh mục
            datasets: [{
                label: 'Phân bổ danh mục',
                data: Object.values(categoryData),  // Doanh thu theo danh mục
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
}

// Khi trang tải, lấy dữ liệu biểu đồ
$(document).ready(function() {
    fetchChartData();
});



        // Hàm tính toán các chỉ số
        function calculateMetrics(product, days = 15) {
    // Đổi tên biến để phù hợp với API response
    const averagePerDay = parseFloat(product.avg_sold_per_day) || 0; 
    const daysUntilEmpty = product.days_to_out_of_stock;
    const suggestedOrder = product.restock_suggestion || 0;

    return {
        ...product,
        averagePerDay: averagePerDay.toFixed(1),
        daysUntilEmpty: daysUntilEmpty === 9.223372036854776e+18 ? 'Không xác định' : Math.ceil(daysUntilEmpty),
        suggestedOrder: Math.max(0, suggestedOrder),
    };
}

// Hàm xác định trạng thái
function getStatus(product) {
    const { stock, days_to_out_of_stock: daysUntilEmpty } = product;

    // Kiểm tra các điều kiện riêng rẽ
    if (stock < 10 || daysUntilEmpty <= 3) return 'danger';
    if ((stock >= 10 && stock < 20) || (daysUntilEmpty > 3 && daysUntilEmpty <= 5)) return 'warning';
    return 'normal';
}

// Hàm cập nhật bảng
// Hàm cập nhật bảng
// Hàm cập nhật bảng
function updateTable(data, options = { filter: 'all' }) { // Đặt giá trị mặc định cho options.filter
    const tbody = document.getElementById('productTableBody');
    tbody.innerHTML = '';

    if (!data || data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9">Không có dữ liệu để hiển thị</td></tr>';
        return;
    }

    // Không cần check filterValue nếu là 'all'
    data.forEach(product => {
        const calculatedProduct = calculateMetrics(product);
        const status = getStatus(calculatedProduct);

        // Chỉ lọc nếu không phải 'all'
        if (options.filter !== 'all' && status !== options.filter) {
            return;
        }

        const tr = document.createElement('tr');
        tr.className = status.toLowerCase();

        tr.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            
            <td>${product.stock}</td>
            <td>${product.sold_15_days || 0}</td>
            <td>${calculatedProduct.averagePerDay}</td>
            <td>${typeof calculatedProduct.daysUntilEmpty === 'number' ? 
                calculatedProduct.daysUntilEmpty + ' ngày' : 
                calculatedProduct.daysUntilEmpty}</td>
            <td>${calculatedProduct.suggestedOrder}</td>
            <td>${status === 'normal' ? 'Bình thường' : 
                status === 'warning' ? 'Sắp hết hàng' : 
                'Cần nhập gấp'}</td>
        `;

        tbody.appendChild(tr);
    });
}

// Hàm fetch dữ liệu từ API
function fetchDataAndUpdateTable() {
    const days = document.getElementById('daysPredict').value || 15;
    const filter = document.getElementById('filterWarning').value || 'all'; // Mặc định 'all' nếu không có giá trị
    const apiUrl = 'http://localhost/web_ban_banh_kem/public/api/restock-suggestions';

    $.ajax({
        url: apiUrl,
        method: 'GET',
        data: { days },
        success: function(response) {
            if (response && response.length > 0) {
                updateTable(response, { filter }); // Truyền filter vào
            } else {
                console.warn('No data received from API');
                updateTable([], { filter });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            updateTable([], { filter });
        }
    });
}

// Sửa lại phần khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', function() {
    // Reset select filter về 'all'
    document.getElementById('filterWarning').value = 'all';
    
    // Gọi API lấy dữ liệu lần đầu
    fetchDataAndUpdateTable();

    // Thiết lập các event listeners
    const modal = document.getElementById('suggestionTable');
    const btn = document.querySelector('.importBtn');
    const span = document.getElementsByClassName('close')[0];

    // Sự kiện cho nút đề xuất nhập
    if (btn) {
        btn.onclick = function() {
            modal.style.display = 'block';
            fetchDataAndUpdateTable(); // Gọi lại API khi mở modal
        }
    }

    // Sự kiện đóng modal
    if (span) {
        span.onclick = function() {
            modal.style.display = 'none';
        }
    }

    // Sự kiện click ngoài modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});

// Sự kiện khi thay đổi bộ lọc
document.getElementById('filterWarning').addEventListener('change', function() {
    fetchDataAndUpdateTable();
});

// Hàm xuất Excel (để mở rộng)
// Hàm xuất CSV
// Hàm xuất CSV với mã hóa UTF-8
function exportToCSV(filename = 'table_data.csv') {
    const table = document.getElementById('productTableBody'); // Lấy nội dung của tbody
    if (!table || table.rows.length === 0) {
        alert('Không có dữ liệu để xuất');
        return;
    }

    const rows = table.querySelectorAll('tr'); // Lấy tất cả các hàng (tr)
    let csvContent = '';

    // Thêm tiêu đề cột (header)
    const headers = [
        'ID',
        'Tên sản phẩm',
        'Tồn kho',
        'Đã bán 15 ngày',
        'Trung bình/ngày',
        'Ngày dự đoán hết',
        'Đề xuất nhập',
        'Trạng thái'
    ];
    csvContent += headers.join(',') + '\n';

    // Thêm dữ liệu từng dòng
    rows.forEach(row => {
        const cols = row.querySelectorAll('td'); // Lấy từng cột (td) trong hàng
        const rowData = Array.from(cols).map(col => `"${col.textContent.trim()}"`); // Xử lý dữ liệu cột
        csvContent += rowData.join(',') + '\n'; // Ghép thành chuỗi CSV
    });

    // Tạo blob với mã hóa UTF-8
    const blob = new Blob([csvContent], { type: 'text/csv;charset=UTF-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.href = url;
    link.download = filename;
    link.style.display = 'none';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    console.log('CSV exported successfully with UTF-8 encoding.');
}
// Hàm xuất CSV với mã hóa UTF-8
function exportToCSV(filename = 'table_data.csv') {
    const table = document.getElementById('productTableBody'); // Lấy nội dung của tbody
    if (!table || table.rows.length === 0) {
        alert('Không có dữ liệu để xuất');
        return;
    }

    const rows = table.querySelectorAll('tr'); // Lấy tất cả các hàng (tr)
    let csvContent = '';

    // Thêm tiêu đề cột (header)
    const headers = [
        'ID',
        'Tên sản phẩm',
        'Tồn kho',
        'Đã bán 15 ngày',
        'Trung bình/ngày',
        'Ngày dự đoán hết',
        'Đề xuất nhập',
        'Trạng thái'
    ];
    csvContent += headers.join(',') + '\n';

    // Thêm dữ liệu từng dòng
    rows.forEach(row => {
        const cols = row.querySelectorAll('td'); // Lấy từng cột (td) trong hàng
        const rowData = Array.from(cols).map(col => `"${col.textContent.trim()}"`); // Xử lý dữ liệu cột
        csvContent += rowData.join(',') + '\n'; // Ghép thành chuỗi CSV
    });

    // Tạo blob với mã hóa UTF-8
    const blob = new Blob([csvContent], { type: 'text/csv;charset=UTF-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.href = url;
    link.download = filename;
    link.style.display = 'none';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    console.log('CSV exported successfully with UTF-8 encoding.');
}
// Hàm xuất CSV với mã hóa UTF-8
// Hàm xuất CSV với mã hóa UTF-8
function exportToExcel(filename = 'table_data.csv') {
    const table = document.getElementById('productTableBody');
    if (!table || table.rows.length === 0) {
        alert('Không có dữ liệu để xuất');
        return;
    }

    const rows = table.querySelectorAll('tr');
    
    // Thêm BOM cho UTF-8
    let csvContent = '\ufeff';

    // Thêm tiêu đề cột (header)
    const headers = [
        'ID',
        'Tên sản phẩm',
        'Tồn kho',
        'Đã bán 15 ngày',
        'Trung bình/ngày', 
        'Ngày dự đoán hết',
        'Đề xuất nhập',
        'Trạng thái'
    ];
    csvContent += headers.join(',') + '\n';

    // Thêm dữ liệu từng dòng
    rows.forEach(row => {
        const cols = row.querySelectorAll('td');
        // Thêm dấu ngoặc kép cho mỗi giá trị và escape các ký tự đặc biệt
        const rowData = Array.from(cols).map(col => {
            const value = col.textContent.trim();
            return `"${value.replace(/"/g, '""')}"`;
        });
        csvContent += rowData.join(',') + '\n';
    });

    // Tạo blob với encoding UTF-8 with BOM
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.href = url;
    link.download = filename;
    link.style.display = 'none';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

const modal = document.getElementById('importModal');
        const fileInput = document.getElementById('excelFile');
        const errorDiv = document.getElementById('error');
        const tableContainer = document.getElementById('tableContainer');
        const importBtn = document.getElementById('importBtn');

        function openModal() {
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
            fileInput.value = '';
            errorDiv.textContent = '';
            tableContainer.innerHTML = '';
            importBtn.style.display = 'none';
        }

        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
    const file = event.target.files[0];
    errorDiv.textContent = ''; // Xóa thông báo lỗi cũ

    if (!file) {
        errorDiv.textContent = 'Vui lòng chọn một file.';
        return;
    }

    // Kiểm tra định dạng file
    const validFileTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (!validFileTypes.includes(file.type)) {
        errorDiv.textContent = 'Vui lòng chọn file Excel hợp lệ (.xlsx hoặc .xls).';
        return;
    }

    // Kiểm tra file trống
    if (file.size === 0) {
        errorDiv.textContent = 'File Excel không chứa dữ liệu.';
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        try {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            
            // Kiểm tra nếu không có sheet nào
            if (workbook.SheetNames.length === 0) {
                throw new Error('File Excel không chứa sheet nào.');
            }

            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            const jsonData = XLSX.utils.sheet_to_json(firstSheet);

            if (!jsonData || jsonData.length === 0) {
                throw new Error('Sheet đầu tiên không chứa dữ liệu.');
            }

            validateAndDisplayData(jsonData);
        } catch (error) {
            errorDiv.textContent = error.message || 'Lỗi khi đọc file Excel.';
        }
    };

    reader.readAsArrayBuffer(file);
}


async function validateAndDisplayData(data) {
    const requiredColumns = ['maSP', 'tenSP', 'giaNhap', 'soLuongNhap'];
    const headers = Object.keys(data[0] || {});
    const missingColumns = requiredColumns.filter(col => !headers.includes(col));

    // Kiểm tra các cột bắt buộc
    if (missingColumns.length > 0) {
        console.log('File thiếu các cột:', missingColumns);
        errorDiv.textContent = `File thiếu các cột: ${missingColumns.join(', ')}`;
        return;
    }

    console.log('Tất cả các cột hợp lệ.');

    // Chú thích màu sắc
    const legend = `
        <p>
            <strong>Chú thích:</strong> 
            <span style="color: red;">Dòng màu đỏ:</span> Dữ liệu không đúng định dạng. 
            <span style="color: orange;">Dòng màu cam:</span> Sản phẩm không tồn tại trong hệ thống.
            <span style="color: blue;">Dòng màu xanh dương:</span> Mã sản phẩm hợp lệ nhưng tên không khớp.
        </p>
    `;
    tableContainer.innerHTML = legend;

    // Tạo bảng hiển thị dữ liệu
    const table = document.createElement('table');
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');
    const headerRow = document.createElement('tr');
    headerRow.innerHTML = `
        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th>
        <th>Mã SP</th>
        <th>Tên SP</th>
        <th>Giá nhập</th>
        <th>Số lượng nhập</th>
        <th>Ngày nhập</th>
    `;
    thead.appendChild(headerRow);

    const today = new Date().toISOString().split('T')[0];

    // Kiểm tra sản phẩm trong CSDL qua API
    const productNames = data.map(row => row.tenSP);  // Lấy tên sản phẩm từ dữ liệu
    const { validProducts, invalidProducts, nameMismatchProducts } = await fetchExistingProducts(data.map(row => row.maSP), productNames);

    console.log('Sản phẩm hợp lệ:', validProducts);
    console.log('Sản phẩm không hợp lệ:', invalidProducts);
    console.log('Sản phẩm tên không khớp:', nameMismatchProducts);

    // Chuyển invalidProducts thành mảng nếu là đối tượng
    const invalidProductsArray = Array.isArray(invalidProducts) ? invalidProducts : Object.values(invalidProducts);
    const nameMismatchProductsArray = Array.isArray(nameMismatchProducts) ? nameMismatchProducts : Object.values(nameMismatchProducts);

    // Tạo bảng dữ liệu và đánh dấu màu sắc theo tính hợp lệ
    data.forEach((row, index) => {
        const tr = document.createElement('tr');
        let isValid = true;

        // Kiểm tra kiểu dữ liệu (giaNhap và soLuongNhap phải là số)
        if (isNaN(parseFloat(row.giaNhap)) || isNaN(parseInt(row.soLuongNhap))) {
            tr.style.color = 'red'; // Màu đỏ nếu sai định dạng
            console.log(`Dòng ${index + 1}: Dữ liệu không đúng định dạng.`);
            isValid = false;
        }

        // Kiểm tra mã sản phẩm có tồn tại trong CSDL (invalidProducts) và không bị lỗi
        if (invalidProductsArray.includes(String(row.maSP))) {
            tr.style.color = 'orange'; // Màu cam nếu sản phẩm không tồn tại trong CSDL
            console.log(`Dòng ${index + 1}: Mã sản phẩm "${row.maSP}" không tồn tại trong hệ thống.`);
            isValid = false;
        } else if (validProducts.includes(String(row.maSP))) {
            // Kiểm tra tên sản phẩm có trùng khớp không
            if (nameMismatchProductsArray.includes(String(row.maSP))) {
                tr.style.color = 'blue'; // Màu xanh dương nếu tên sản phẩm không trùng
                console.log(`Dòng ${index + 1}: Mã sản phẩm "${row.maSP}" hợp lệ nhưng tên không khớp.`);
            } else {
                tr.style.color = ''; // Màu mặc định cho sản phẩm hợp lệ
                console.log(`Dòng ${index + 1}: Mã sản phẩm "${row.maSP}" hợp lệ.`);
            }
        }

        // Tạo dòng dữ liệu cho bảng
        tr.innerHTML = `
            <td class="checkbox-cell">
                <input type="checkbox" class="row-checkbox" data-index="${index}" ${!isValid ? 'disabled' : ''}>
            </td>
            <td>${row.maSP}</td>
            <td>${row.tenSP}</td>
            <td>${row.giaNhap}</td>
            <td>${row.soLuongNhap}</td>
            <td>${today}</td>
        `;
        tbody.appendChild(tr);
    });

    table.appendChild(thead);
    table.appendChild(tbody);
    tableContainer.appendChild(table);
    importBtn.style.display = 'block';
}


async function fetchExistingProducts(productCodes, productNames) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    console.log("Dữ liệu gửi đi:", { productCodes, productNames });

    try {
        const response = await fetch('http://localhost/web_ban_banh_kem/public/check-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ productCodes, productNames }),  // Gửi thêm tên sản phẩm
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log("Kết quả từ server:", result);

        // Chuyển đổi validProducts thành mảng
        const validProductsArray = result.validProducts 
            ? Object.values(result.validProducts).filter(item => typeof item === 'string')
            : [];
        
        // Chuyển đổi invalidProducts thành mảng
        const invalidProductsArray = result.invalidProducts
            ? Object.values(result.invalidProducts)
            : [];

        // Chuyển đổi nameMismatchProducts thành mảng
        const nameMismatchProductsArray = result.nameMismatchProducts
            ? Object.values(result.nameMismatchProducts)
            : [];

        console.log("Sản phẩm hợp lệ (validProducts):", validProductsArray);
        console.log("Sản phẩm không hợp lệ (invalidProducts):", invalidProductsArray);
        console.log("Sản phẩm tên không khớp (nameMismatchProducts):", nameMismatchProductsArray);

        return {
            validProducts: validProductsArray,
            invalidProducts: invalidProductsArray,
            nameMismatchProducts: nameMismatchProductsArray,  // Trả về sản phẩm tên không khớp
        };
    } catch (error) {
        console.error('Lỗi khi kiểm tra sản phẩm trong CSDL:', error);
        return { validProducts: [], invalidProducts: productCodes, nameMismatchProducts: [] };
    }
}



function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.getElementsByClassName('row-checkbox');

    Array.from(rowCheckboxes).forEach(checkbox => {
        const row = checkbox.closest('tr');

        // Kiểm tra xem dòng này có phải là màu đỏ (lỗi) hoặc màu vàng (không tồn tại)
        const isInvalidRow = row.style.color === 'red' || row.style.color === 'orange';

        // Nếu là dòng không hợp lệ thì không check được
        if (!isInvalidRow) {
            checkbox.checked = selectAllCheckbox.checked;
        } else {
            checkbox.checked = false; // Đảm bảo các dòng không hợp lệ không thể được chọn
        }
    });
}


importBtn.addEventListener('click', async function() {
    const selectedRows = [];
    const checkboxes = document.getElementsByClassName('row-checkbox');

    Array.from(checkboxes).forEach(checkbox => {
        if (checkbox.checked) {
            const row = checkbox.closest('tr');
            const rowData = {
                maSP: row.cells[1].textContent,
                tenSP: row.cells[2].textContent,
                giaNhap: row.cells[3].textContent,
                soLuongNhap: row.cells[4].textContent,
                ngayNhap: row.cells[5].textContent
            };
            selectedRows.push(rowData);
        }
    });

    if (selectedRows.length > 0) {
        // Tạo chuỗi mô tả sản phẩm được chọn
        let productList = selectedRows.map(row => `Mã: ${row.maSP}, Tên: ${row.tenSP}`).join('\n');
        
        // Hiển thị thông báo xác nhận
        const confirmMessage = `Bạn có muốn nhập kho các sản phẩm sau?\n\n${productList}`;
        
        if (confirm(confirmMessage)) {
            // Gửi dữ liệu đã chọn đến server để xử lý
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch('http://localhost/web_ban_banh_kem/public/import-products', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ selectedRows })
                });

                const result = await response.json();
                if (result.success) {
                    alert(result.message);  // Thông báo thành công
                    closeModal();
                } else {
                    alert('Có lỗi xảy ra trong quá trình nhập hàng.');
                }
            } catch (error) {
                console.error('Lỗi khi gửi dữ liệu:', error);
                alert('Lỗi khi gửi dữ liệu đến server.');
            }
        } else {
            alert('Quá trình import đã bị hủy.');
        }
    } else {
        alert('Vui lòng chọn ít nhất một dòng dữ liệu để import!');
    }
});



        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
        function openAddProductModal() {
    // Mở modal thêm sản phẩm
    console.log("Mở modal thêm sản phẩm");
    // Thực hiện các bước mở modal hoặc tải trang thêm sản phẩm
}

// Mở modal Lịch sử
function openHistoryModal() {
    document.getElementById("modalHistory").style.display = "block";
    fetchHistoryData();
}

// Đóng modal Lịch sử
function closeModalHistory() {
    document.getElementById("modalHistory").style.display = "none";
}

// Lấy dữ liệu lịch sử từ server (hoặc có thể lấy từ CSDL)
async function fetchHistoryData() {
    const filterDateFrom = document.getElementById('filterDateFrom').value;
    const filterDateTo = document.getElementById('filterDateTo').value;
    const filterAction = document.getElementById('filterAction').value;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    try {
        const response = await fetch('http://localhost/web_ban_banh_kem/public/get-history', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                dateFrom: filterDateFrom,
                dateTo: filterDateTo,
                action: filterAction
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        renderHistoryTable(result.data);
    } catch (error) {
        console.error('Error fetching history data:', error);
    }
}

// Hiển thị dữ liệu vào bảng
function renderHistoryTable(data) {
    const tableBody = document.getElementById("historyTableBody");
    tableBody.innerHTML = ""; // Xóa bảng hiện tại

    if (data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='5'>Không có dữ liệu lịch sử.</td></tr>";
        return;
    }

    data.forEach(item => {
        const row = document.createElement("tr");
        const productName = item.product ? item.product.name : 'Không có tên'; // Lấy tên sản phẩm
        const adminName = item.admin ? item.admin.name : 'Không xác định'; // Lấy tên quản trị viên
        row.innerHTML = `
             <td>${productName}</td>
            <td>${item.action}</td>
            <td>${item.action_content}</td>
            <td>${adminName}</td>
            <td>${item.created_at}</td>
            <td>${item.updated_at}</td>

        `;

        tableBody.appendChild(row);
    });
}

// Áp dụng bộ lọc
function applyFilters() {
    fetchHistoryData();
}
function openAddProductModal() {
  document.getElementById('addProductModal').style.display = 'block';
}

function closeAddProductModal() {
  document.getElementById('addProductModal').style.display = 'none';
}

function previewImage(event) {
  const image = document.getElementById('imagePreview');
  image.src = URL.createObjectURL(event.target.files[0]);
  image.style.display = 'block';
}

function uploadExcel() {
  alert('Tính năng nhập file Excel đang được phát triển!');
}
// Tự động tính giá bán dựa trên giá gốc và % khuyến mãi
const originalPriceInput = document.getElementById('originalPrice');
const discountPercentInput = document.getElementById('discountPercent');
const finalPriceInput = document.getElementById('finalPrice');

// Lắng nghe thay đổi giá gốc và % khuyến mãi để cập nhật giá bán
function calculateFinalPrice() {
  const originalPrice = parseFloat(originalPriceInput.value);
  const discountPercent = parseFloat(discountPercentInput.value);

  if (!isNaN(originalPrice) && !isNaN(discountPercent) && discountPercent >= 0 && discountPercent <= 100) {
    const finalPrice = originalPrice * (1 - discountPercent / 100);
    finalPriceInput.value = finalPrice.toFixed(2); // Giữ lại 2 chữ số thập phân
  } else {
    finalPriceInput.value = '';
  }
}

// Gắn sự kiện tính giá bán khi nhập giá gốc hoặc % khuyến mãi
originalPriceInput.addEventListener('input', calculateFinalPrice);
discountPercentInput.addEventListener('input', calculateFinalPrice);

// Import thư viện SheetJS (xlsx) để xử lý file Excel
function handleExcelUpload(event) {
  const file = event.target.files[0];

  // Kiểm tra định dạng file
  if (!file.name.endsWith('.xlsx') && !file.name.endsWith('.xls')) {
    alert('Vui lòng tải lên file Excel có định dạng .xlsx hoặc .xls');
    return;
  }

  // Đọc file Excel
  const reader = new FileReader();
  reader.onload = async function (e) {
    const data = new Uint8Array(e.target.result);
    const workbook = XLSX.read(data, { type: 'array' });

    // Lấy sheet đầu tiên
    const sheetName = workbook.SheetNames[0];
    const sheet = workbook.Sheets[sheetName];

    // Chuyển sheet thành JSON
    const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });
    await validateExcelData(jsonData);  // Gọi async validate
  };
  reader.readAsArrayBuffer(file);
}


// Kiểm tra và xử lý dữ liệu Excel
async function validateExcelData(data) {
  const headers = [
    'Mã sản phẩm',
    'Tên sản phẩm',
    'Danh mục',
    'Giá nhập',
    'Giá gốc',
    'Khuyến mãi (%)',
    'Số lượng tồn',
    'Giới thiệu',
  ];
  const requiredFields = [0, 1, 2, 3, 4, 5, 6]; // Các cột bắt buộc

  console.log('Tiêu đề trong file Excel:', data[0]);

  // Kiểm tra tiêu đề cột
  const fileHeaders = data[0];
  for (let i = 0; i < requiredFields.length; i++) {
    if (fileHeaders[requiredFields[i]] !== headers[requiredFields[i]]) {
      console.error(`File Excel thiếu cột: ${headers[requiredFields[i]]}`);
      alert(`File Excel thiếu cột: ${headers[requiredFields[i]]}`);
      return;
    }
  }
  console.log('Tiêu đề cột hợp lệ.');

  // Lấy các dòng dữ liệu (bỏ hàng tiêu đề)
  const rows = data.slice(1);
  console.log('Dữ liệu các dòng:', rows);

  try {
    const validationResults = await checkMaspAndCategory(rows); // Gửi kiểm tra mã SP và danh mục lên server
    console.log('Kết quả kiểm tra từ server:', validationResults);

    populateExcelTable(rows, validationResults); // Hiển thị kết quả trong bảng
  } catch (error) {
    console.error('Lỗi khi kiểm tra mã sản phẩm và danh mục:', error);
  }
}

async function checkMaspAndCategory(rows) {
  const results = [];

  for (const row of rows) {
    const masp = row[0];  // Mã sản phẩm
    const category = row[2];  // Danh mục

    console.log(`Kiểm tra dòng: Mã sản phẩm = ${masp}, Danh mục = ${category}`);

    try {
      // Gửi yêu cầu kiểm tra lên server
      const response = await fetch('http://localhost/web_ban_banh_kem/public/validate-masp-category', {
        method: 'POST',
        body: JSON.stringify({ masp, category }),
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      });

      const result = await response.json();
      console.log('Kết quả từ server:', result);

      results.push(result); // Lưu kết quả kiểm tra
    } catch (error) {
      console.error(`Lỗi khi kiểm tra dòng (Mã sản phẩm: ${masp}, Danh mục: ${category}):`, error);
      results.push({ maspStatus: 'error', categoryStatus: 'error', formatStatus: 'error' });
    }
  }

  return results;
}

function populateExcelTable(rows, validationResults) {
  const tableBody = document.querySelector('#excelTable tbody');
  tableBody.innerHTML = ''; // Xóa dữ liệu cũ

  rows.forEach((row, index) => {
    const tr = document.createElement('tr');
    const validationResult = validationResults[index]; // Lấy kết quả kiểm tra của dòng hiện tại

    console.log(`Dòng ${index + 1}:`, row);
    console.log(`Kết quả kiểm tra:`, validationResult);
    
    console.log(`dfsfsfds:`, row[7]);
    
    // Kiểm tra trạng thái và thay đổi màu sắc cho toàn bộ dòng
    if (validationResult.maspStatus === 'duplicated' || validationResult.categoryStatus === 'not_found') {
      tr.style.backgroundColor = 'yellow';  // Mã sản phẩm bị trùng hoặc danh mục không tồn tại
      console.warn(`Dòng ${index + 1}: Lỗi mã sản phẩm hoặc danh mục`);
    } else if (validationResult.formatStatus === 'invalid'||row[7]===undefined||row[0]===undefined||row[1]===undefined||row[2]===undefined||row[3]===undefined||row[4]===undefined||row[5]===undefined||row[6]===undefined) {
      tr.style.backgroundColor = 'red';  // Dữ liệu không đúng định dạng
      console.warn(`Dòng ${index + 1}: Dữ liệu không đúng định dạng`);
    } else {
      tr.style.backgroundColor = 'white';  // Dòng hợp lệ
      console.log(`Dòng ${index + 1}: Hợp lệ`);
    }

    // Không cho phép chọn checkbox nếu dòng bị lỗi
    const checkboxTd = document.createElement('td');
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.className = 'rowCheckbox';

    // Nếu dòng có màu vàng hoặc đỏ, không cho phép chọn checkbox
    if (tr.style.backgroundColor === 'yellow' || tr.style.backgroundColor === 'red') {
      checkbox.disabled = true;
    }

    checkboxTd.appendChild(checkbox);
    tr.appendChild(checkboxTd);

    // Tính toán giá bán dựa trên giá gốc và khuyến mãi
    const originalPrice = parseFloat(row[4]); // Cột Giá gốc
    const discountPercent = parseFloat(row[5]); // Cột Khuyến mãi (%)
    const stockQuantity = parseInt(row[6])
    // Kiểm tra nếu giá gốc và % khuyến mãi hợp lệ
    if (!isNaN(originalPrice) && !isNaN(discountPercent)) {
      const finalPrice = originalPrice * (1 - discountPercent / 100);
      row[6] = finalPrice.toFixed(2);  // Cập nhật giá bán vào cột Giá bán (cột 7)
    } else {
      row[6] = '';  // Nếu có lỗi trong giá gốc hoặc % khuyến mãi, để trống
    }
    const description = row[7] || '';
    // Lấy và điền "Số lượng tồn" vào cột đúng
      // Chỉnh lại chỉ số cột (Số lượng tồn nằm ở cột 6)
    row[7] = stockQuantity || ''; // Đảm bảo giá trị không bị null hay undefined

    // Lấy dữ liệu cho cột "Giới thiệu" (cột 7) và kiểm tra lỗi
    row[8]=description || ''; // Cột Giới thiệu, đảm bảo có giá trị mặc định nếu không có dữ liệu

    // Thêm dữ liệu từng cột vào dòng
    row.forEach((cell, cellIndex) => {
      const td = document.createElement('td');
      td.textContent = cell || ''; // Đảm bảo không có giá trị null hay undefined

      // Tô màu cho ô nếu có lỗi (vàng hoặc đỏ)
      if (tr.style.backgroundColor === 'yellow' || tr.style.backgroundColor === 'red') {
        td.style.backgroundColor = tr.style.backgroundColor;
      }

      tr.appendChild(td);
    });

    // Thêm dòng vào bảng
    tableBody.appendChild(tr);
  });

  console.log('Hoàn thành việc hiển thị dữ liệu vào bảng.');
  document.querySelector('.addProductExcelModal').style.display = 'block'; // Hiển thị modal
}



function closeExcelModal() {
  document.querySelector('.addProductExcelModal').style.display = 'none';
}

function toggleCheckAll(checkbox) {
  const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
  const rows = document.querySelectorAll('#excelTable tbody tr');
  
  rowCheckboxes.forEach((cb, index) => {
    const row = rows[index];
    const rowBackgroundColor = row.style.backgroundColor;

    // Chỉ chọn checkbox nếu dòng không có màu vàng hoặc đỏ
    if (rowBackgroundColor !== 'yellow' && rowBackgroundColor !== 'red') {
      cb.checked = checkbox.checked;
    } else {
      cb.checked = false;  // Đảm bảo bỏ chọn checkbox nếu dòng bị lỗi
    }
  });
}


function addSelectedProducts() {
  const checkedRows = document.querySelectorAll('.rowCheckbox:checked');
  if (checkedRows.length === 0) {
    alert('Vui lòng chọn ít nhất một sản phẩm để thêm!');
    return;
  }

  const addedProducts = [];
  checkedRows.forEach((checkbox) => {
    const row = checkbox.closest('tr');
    const cells = row.querySelectorAll('td');
    const product = {
      code: cells[1].textContent.trim(),
      name: cells[2].textContent.trim(),
      category: cells[3].textContent.trim(),
      importPrice: parseFloat(cells[4].textContent.trim()) || 0,
      originalPrice: parseFloat(cells[5].textContent.trim()) || 0,
      discountPercent: parseFloat(cells[6].textContent.trim()) || 0,
      finalPrice: parseFloat(cells[7].textContent.trim()) || 0, // Giá bán
      stockQuantity: parseInt(cells[8].textContent.trim()) || 0,
      description: cells[9].textContent.trim(),
    };
    addedProducts.push(product);
  });

  // Gửi dữ liệu qua AJAX
  fetch('http://localhost/web_ban_banh_kem/public/store-multiple', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify({ products: addedProducts }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert('Thêm sản phẩm thành công!');
        console.log('Sản phẩm đã thêm:', data.addedProducts);
        location.reload(); // Reload lại để cập nhật giao diện
      } else {
        alert('Có lỗi xảy ra khi thêm sản phẩm.');
        console.error('Lỗi:', data.errors || data.message);
      }
    })
    .catch((error) => {
      alert('Không thể gửi dữ liệu lên server.');
      console.error('Lỗi hệ thống:', error);
    });
}


document.getElementById('saveProductButton').addEventListener('click', function () {
  console.log('Bắt đầu xử lý nút Lưu sản phẩm.');

  const form = document.getElementById('addProductForm');
  const formData = new FormData(form);

  // Hiển thị thông báo xác nhận
  const productName = document.getElementById('productName1').value;
  const categoryText = document.getElementById('productCategory').selectedOptions[0]?.text || 'Chưa chọn';
  const importPrice = document.getElementById('importPrice').value;
  const stockQuantity = document.getElementById('stockQuantity').value;

  console.log('Dữ liệu thu thập từ form:');
  console.log('Tên sản phẩm:', productName);
  console.log('Danh mục:', categoryText);
  console.log('Giá nhập:', importPrice);
  console.log('Số lượng tồn:', stockQuantity);

  // Lấy file ảnh từ input và thêm vào FormData
  const productImage = document.getElementById('productImage').files[0];
  if (productImage) {
    console.log('Đã chọn ảnh sản phẩm:', productImage.name);
    formData.append('productImage', productImage); // Thêm ảnh vào FormData
  } else {
    console.log('Chưa chọn ảnh sản phẩm.');
  }

  const confirmMessage = `
Bạn có chắc chắn muốn thêm sản phẩm này không?
Tên sản phẩm: ${productName}
Danh mục: ${categoryText}
Giá nhập: ${importPrice}
Số lượng tồn: ${stockQuantity}
  `;

  if (!confirm(confirmMessage.trim())) {
    console.log('Người dùng đã hủy hành động.');
    return;
  }

  console.log('Người dùng đã xác nhận, chuẩn bị gửi dữ liệu qua AJAX.');

  // Gửi dữ liệu qua AJAX
  fetch('{{ route("admin.product.store") }}', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: formData,
  })
    .then((response) => {
      console.log('Phản hồi từ server nhận được:', response);
      if (!response.ok) throw new Error('Có lỗi xảy ra khi gửi yêu cầu!');
      return response.json();
    })
    .then((data) => {
      console.log('Dữ liệu phản hồi từ server:', data);

      if (data.success) {
        alert('Sản phẩm đã được thêm thành công!');
        console.log('Sản phẩm đã thêm thành công.');
        location.reload(); // Tải lại trang để hiển thị dữ liệu mới
      } else {
        console.log('Lỗi từ server:', data.message);
        alert(`Lỗi: ${data.message}`);
      }
    })
    .catch((error) => {
      console.error('Lỗi xảy ra trong quá trình gửi dữ liệu:', error);
      alert('Đã xảy ra lỗi khi thêm sản phẩm.');
    });
});

function clearExcelFile() {
  const fileInput = document.getElementById('excelFileInput');

  // Đặt lại giá trị của input file
  fileInput.value = '';

  // Bạn có thể thực hiện thêm các hành động khác (nếu cần)
  console.log('Đã xóa file Excel');
  alert('File Excel đã được xóa.');
}

// Xem trước ảnh khi tải lên
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

function openEditProductModal(productId) {
    const modal = document.getElementById('editProductModal');
    modal.style.display = 'block';

    // Reset preview
    const preview = document.getElementById('editProduct-image-preview');
    const noImageText = document.getElementById('editProduct-no-image');
    preview.style.display = 'none';
    noImageText.style.display = 'block';

    // Gọi AJAX để lấy chi tiết sản phẩm
    fetch(`http://localhost/web_ban_banh_kem/public/product/${productId}/edit`)
        .then(response => response.json())
        .then(product => {
            // Lưu id sản phẩm vào biến toàn cục
            currentProductId = product.id;  // Lưu id vào biến global

            // Điền dữ liệu vào form
            document.getElementById('editProduct-name').value = product.name;
            document.getElementById('editProduct-category').value = product.category_id;

            // Chuyển đổi và hiển thị ngày theo định dạng yyyy-mm-dd
            const createdAtDate = new Date(product.created_at);
            const formattedDate = createdAtDate.toISOString().split('T')[0]; // "2024-08-25"
            document.getElementById('editProduct-posted-date').value = formattedDate;

            document.getElementById('editProduct-original-price').value = product.original_price;
            document.getElementById('editProduct-discount').value = product.discount;
            document.getElementById('editProduct-price').value = product.price;
            document.getElementById('editProduct-quantity').value = product.quantity_in_stock;
            document.getElementById('editProduct-quantity-sold').value = product.quantity_sold;
            document.getElementById('editProduct-description').value = product.description;

            // Hiển thị ảnh hiện tại
            if (product.image) {
                preview.src = `http://localhost/web_ban_banh_kem/public/images/${product.image}`;
                preview.style.display = 'block';
                noImageText.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Không thể tải thông tin sản phẩm');
        });
}

// Bạn có thể truy cập `currentProductId` ở bất cứ đâu trong mã của bạn sau khi dữ liệu đã được tải
// Ví dụ, nếu muốn dùng id để thực hiện một hành động khác:
function doSomethingWithProductId() {
    if (currentProductId !== null) {
        console.log("ID sản phẩm hiện tại là:", currentProductId);
        // Xử lý với ID sản phẩm tại đây
    } else {
        console.log("Chưa có ID sản phẩm.");
    }
}


        function closeEditProductModal() {
            const modal = document.getElementById('editProductModal');
            modal.style.display = 'none';
        }

        // Tự động tính giá bán khi thay đổi giá gốc hoặc giảm giá
        document.getElementById('editProduct-original-price').addEventListener('input', calculatePrice);
        document.getElementById('editProduct-discount').addEventListener('input', calculatePrice);

        function calculatePrice() {
            const originalPrice = parseFloat(document.getElementById('editProduct-original-price').value);
            const discount = parseFloat(document.getElementById('editProduct-discount').value);
            
            const price = originalPrice * (1 - discount / 100);
            document.getElementById('editProduct-price').value = price.toLocaleString('vi-VN');
        }

        document.getElementById('editProductForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Tạo FormData từ form
    const formData = new FormData(this);

    // Lấy id sản phẩm từ biến toàn cục currentProductId
    const productId = currentProductId; // Sử dụng biến toàn cục currentProductId

    // Thêm ID sản phẩm vào formData
    formData.append('id', productId);

    // Log dữ liệu trong formData trước khi gửi
    formData.forEach((value, key) => {
        if (value instanceof File) {
            console.log(key + ": " + value.name + ", Type: " + value.type + ", Size: " + value.size + " bytes");
        } else {
            console.log(key + ": " + value);
        }
    });

    // Cập nhật URL để truyền `productId` vào trong đường dẫn
    fetch(`http://localhost/web_ban_banh_kem/public/updateproduct/${productId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(result => {
        // Kiểm tra xem có thông báo thành công hoặc không có thay đổi nào
        if (result.message === 'Sản phẩm đã được cập nhật thành công') {
            alert('Cập nhật sản phẩm thành công!');
            closeEditProductModal();
            // Refresh danh sách sản phẩm nếu cần thiết
            location.reload(); // Ví dụ: tải lại trang
        } else if (result.message === 'Không có thay đổi nào được thực hiện') {
            alert('Không có thay đổi nào được thực hiện!');
        } else {
            alert('Cập nhật sản phẩm thất bại!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi!');
    });
});
let productHistoryData = [];
let currentPage = 1;
const itemsPerPage = 10;

function openProductHistoryModal(productId) {
    currentProductId = productId; // Đặt biến toàn cục cho sản phẩm hiện tại
    const modal = document.getElementById('productHistoryModal');
    modal.style.display = 'block';

    fetchProductHistory(productId);
}

function fetchProductHistory(productId) {
    // Lấy giá trị từ các bộ lọc
    const dateStart = document.getElementById('productHistory-date-start').value;
    const dateEnd = document.getElementById('productHistory-date-end').value;
    const actionFilter = Array.from(
        document.getElementById('productHistory-action-filter').selectedOptions
    ).map(option => option.value);

    // Xây dựng query string
    const queryParams = new URLSearchParams();
    if (dateStart) queryParams.append('date_start', dateStart);
    if (dateEnd) queryParams.append('date_end', dateEnd);
    if (actionFilter.length > 0) {
        actionFilter.forEach(action => queryParams.append('actions[]', action));
    }

    // Gọi API với phương thức GET
    fetch(`http://localhost/web_ban_banh_kem/public/product/${productId}/history?${queryParams.toString()}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            productHistoryData = data; // Lưu dữ liệu lịch sử sản phẩm
            currentPage = 1;          // Reset lại trang đầu tiên
            renderProductHistoryTable(); // Hiển thị dữ liệu
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Không thể tải lịch sử sản phẩm');
        });
}


function renderProductHistoryTable() {
    const tableBody = document.getElementById('productHistory-table-body');
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageData = productHistoryData.slice(startIndex, endIndex);

    if (pageData.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center;">Không có dữ liệu</td></tr>`;
        return;
    }

    tableBody.innerHTML = pageData.map((history, index) => `
        <tr>
            <td>${startIndex + index + 1}</td>
            <td>${formatDate(history.created_at)}</td>
            <td>
                <span class="productHistory-action-badge productHistory-action-${history.action}">
                    ${getActionLabel(history.action)}
                </span>
            </td>
            <td>${formatActionContent(history.action_content)}</td>
            <td>${history.admin?.name || 'Không xác định'}</td>
        </tr>
    `).join('');

    updatePagination();
}
function formatActionContent(content) {
    const changes = content.split(', '); // Tách các thay đổi bằng dấu phẩy
    const formattedChanges = changes.map(change => {
        const parts = change.split(': Từ ');
        if (parts.length === 2) {
            const field = parts[0].replace('Cập nhật sản phẩm ', '').trim();
            const values = parts[1].split(' thành ');
            if (values.length === 2) {
                return `<strong>${field}:</strong> '${values[0].trim()}' ➡ '${values[1].trim()}'`;
            }
        }
        return change;
    });

    return `<ul>${formattedChanges.map(item => `<li>${item}</li>`).join('')}</ul>`;
}


function updatePagination() {
    const totalPages = Math.ceil(productHistoryData.length / itemsPerPage);
    const pageInfo = document.getElementById('productHistory-page-info');
    const prevBtn = document.getElementById('productHistory-prev-btn');
    const nextBtn = document.getElementById('productHistory-next-btn');

    pageInfo.textContent = `Trang ${currentPage}/${totalPages}`;
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages;
}

function changePage(delta) {
    const totalPages = Math.ceil(productHistoryData.length / itemsPerPage);
    currentPage = Math.max(1, Math.min(totalPages, currentPage + delta));
    renderProductHistoryTable();
}

function closeProductHistoryModal() {
    const modal = document.getElementById('productHistoryModal');
    modal.style.display = 'none';
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString('vi-VN');
}

function getActionLabel(action) {
    const labels = {
        'add': 'Thêm mới',
        'update': 'Cập nhật',
        'import': 'Nhập khẩu',
        'delete': 'Xóa',
        'store-multiple': 'Thêm nhiều'
    };
    return labels[action] || action;
}

// Bộ lọc tự động cập nhật
document.getElementById('productHistory-date-start').addEventListener('change', () => {
    if (currentProductId) fetchProductHistory(currentProductId);
});

document.getElementById('productHistory-date-end').addEventListener('change', () => {
    if (currentProductId) fetchProductHistory(currentProductId);
});

document.getElementById('productHistory-action-filter').addEventListener('change', () => {
    if (currentProductId) fetchProductHistory(currentProductId);
});
document.addEventListener("DOMContentLoaded", () => {
    const categoryFilter = document.getElementById("category-filter");
    const timeFilter = document.getElementById("time-filter");
    const dateFromInput = document.getElementById("date-from");
    const dateToInput = document.getElementById("date-to");

    const statsSummary = document.getElementById("stats-summary");
    const topProductsTable = document.getElementById("top-products-table");
    const inventoryBody = document.getElementById('inventory-table');
    // Khi thay đổi filter
    [categoryFilter, timeFilter, dateFromInput, dateToInput].forEach((filter) =>
        filter.addEventListener("change", updateStats)
    );

    // Bật tắt date filter khi chọn "Tùy chỉnh"
    timeFilter.addEventListener("change", () => {
        if (timeFilter.value === "custom") {
            dateFromInput.disabled = false;
            dateToInput.disabled = false;
        } else {
            dateFromInput.disabled = true;
            dateToInput.disabled = true;
            dateFromInput.value = "";
            dateToInput.value = "";
        }
    });

// Hàm cập nhật thông tin thống kê nhập hàng
// Hàm cập nhật các thống kê vào modal
function updateStats() {
    const category = document.getElementById('category-filter').value;
    const time = document.getElementById('time-filter').value;
    const dateFrom = document.getElementById('date-from').value;
    const dateTo = document.getElementById('date-to').value;

    // Gửi request đến server để lấy dữ liệu thống kê
    fetch(`http://localhost/web_ban_banh_kem/public/admin/product-stats?category=${category}&time=${time}&date_from=${dateFrom}&date_to=${dateTo}`)
        .then(response => response.json())
        .then(data => {
            // Cập nhật thống kê tổng quan
            document.getElementById('stats-summary').innerHTML = `
                <div class="stat-card"><h3>Tổng sản phẩm</h3><div class="value">${data.stats.total_products}</div></div>
                <div class="stat-card"><h3>Doanh thu</h3><div class="value">${formatCurrency(data.stats.total_revenue)}</div></div>
                <div class="stat-card"><h3>Đã bán</h3><div class="value">${data.stats.total_sold}</div></div>
                <div class="stat-card"><h3>Tồn kho</h3><div class="value">${data.stats.total_stock}</div></div>
                <div class="stat-card"><h3>Lợi nhuận</h3><div class="value">${formatCurrency(data.stats.total_profit)}</div></div>
            `;

            // Cập nhật bảng top sản phẩm bán chạy
            const topProductsTable = document.getElementById('top-products-table');
            topProductsTable.innerHTML = data.topProducts.map(product => `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.category_name}</td>
                    <td>${product.total_quantity}</td>
                    <td>${formatCurrency(product.total_revenue)}</td>
                </tr>
            `).join('');

            // Cập nhật thống kê nhập hàng
            const inventoryBody = document.getElementById('inventory-table');
            inventoryBody.innerHTML = data.stats.inventoryStats.map(entry => `
                <tr>
                    <td>${entry.date}</td>
                    <td>${entry.product_name}</td>
                    <td>${entry.quantity}</td>
                    <td>${formatCurrency(entry.total_purchase_price)}</td>
               
                </tr>
            `).join('');
        })
        .catch(error => console.error('Error fetching stats:', error));
}

// Hàm formatCurrency để định dạng tiền tệ
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}





});


function confirmDeleteProduct(productId, productName) {
    // Hiển thị hộp thoại xác nhận
    const isConfirmed = confirm(`Bạn có muốn xóa sản phẩm "${productName}" không?`);
    
    if (isConfirmed) {
        // Gửi yêu cầu cập nhật is_deleted cho server
        fetch(`http://localhost/web_ban_banh_kem/public/admin/products/${productId}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Nếu dùng Laravel
            },
            body: JSON.stringify({ is_deleted: true })
        })
        .then(response => {
            if (response.ok) {
                alert("Sản phẩm đã được xóa thành công!");
                // Cập nhật giao diện hoặc tải lại danh sách sản phẩm
                document.querySelector(`tr[data-id="${productId}"]`).remove();
            } else {
                return response.json().then(data => {
                    throw new Error(data.message || 'Có lỗi xảy ra!');
                });
            }
        })
        .catch(error => {
            console.error('Lỗi khi xóa sản phẩm:', error);
            alert('Không thể xóa sản phẩm. Vui lòng thử lại sau.');
        });
    }
}

function openFoodSuggestStatic() {
    // Lấy danh sách sản phẩm từ backend
    fetch('http://localhost/web_ban_banh_kem/public/api/food-suggestions') // URL API của bạn
        .then(response => response.json())
        .then(data => {
            if (data.products && data.products.length > 0) {
                const productList = document.getElementById('product-list');
                productList.innerHTML = ''; // Xóa danh sách sản phẩm cũ

                // Thêm các sản phẩm vào danh sách
                data.products.forEach(product => {
                    const productItem = document.createElement('li');
                    productItem.textContent = `${product.name} - Hương vị: ${product.flavor}`;

                    // Gán data-product-id cho mỗi sản phẩm
                    productItem.dataset.productId = product.id;

                    productItem.onclick = () => showProductDetails(product, productItem);
                    productList.appendChild(productItem);
                });

                document.getElementById('food-suggest-modal').style.display = 'block';
            }
        });
}

function showProductDetails(product, productItem) {
    // Hiển thị chi tiết sản phẩm vào form
    document.getElementById('department-suggestion').value = product.department_suggestion || '';
    document.getElementById('disease-suggestion').value = product.disease_suggestion || '';
    document.getElementById('flavor').value = product.flavor || '';
    document.getElementById('benefits').value = product.benefits || '';
    document.getElementById('meal-time').value = product.meal_time || '';

    // Thêm product_id vào dữ liệu form (nếu chưa có)
    let productIdInput = document.querySelector('input[name="product_id"]');
    if (!productIdInput) {
        productIdInput = document.createElement('input');
        productIdInput.type = 'hidden';
        productIdInput.name = 'product_id';
        productIdInput.value = product.id; // Thêm product_id vào form
        document.getElementById('product-details-form').appendChild(productIdInput);
    }

    // Thêm màu sắc khi chọn sản phẩm
    const productListItems = document.querySelectorAll('.product-list li');
    productListItems.forEach(item => item.classList.remove('selected'));
    productItem.classList.add('selected');

    // Kiểm tra nếu sản phẩm không có gợi ý và hiển thị thông báo
    const warningMessage = document.querySelector('.warning');
    if (!product.department_suggestion && !product.disease_suggestion && !product.flavor && !product.benefits && !product.meal_time) {
        if (!warningMessage) {
            const warning = document.createElement('div');
            warning.classList.add('warning');
            warning.textContent = 'Sản phẩm này chưa có gợi ý.';
            document.querySelector('.product-details').appendChild(warning);
        }
    } else {
        const existingWarning = document.querySelector('.warning');
        if (existingWarning) {
            existingWarning.remove();
        }
    }
}


function saveProductSuggestion() {
    const form = document.getElementById('product-details-form');
    const formData = new FormData(form);
    
    // Lấy token CSRF từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Chuyển formData thành object để dễ dàng kiểm tra trong console
    const formDataObject = {};

    // Lặp qua formData và chuyển tất cả các key từ "-" thành "_"
    formData.forEach((value, key) => {
        // Thay thế "-" bằng "_"
        const newKey = key.replace(/-/g, '_');
        formDataObject[newKey] = value;
    });

    // In ra console dữ liệu gửi đi
    console.log('Dữ liệu gửi đi:', formDataObject);

    // Tạo một formData mới từ formDataObject sau khi đã chuyển đổi
    const newFormData = new FormData();
    for (const key in formDataObject) {
        newFormData.append(key, formDataObject[key]);
    }

    fetch('http://localhost/web_ban_banh_kem/public/api/save-product-suggestion', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken, // Thêm token CSRF vào header
        },
        body: newFormData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Gợi ý sản phẩm đã được lưu thành công!');
            closeFoodSuggestModal();
        } else {
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        }
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




function closeFoodSuggestModal() {
    document.getElementById('food-suggest-modal').style.display = 'none';
}
// Mở modal và điền thông tin sản phẩm vào form
// Mở modal và điền thông tin sản phẩm vào form
function openNutritionModal(productId, productName) {
    // Lấy thông tin dinh dưỡng của sản phẩm
    fetch(`http://localhost/web_ban_banh_kem/public/nutrition-facts/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Nếu có thông tin dinh dưỡng, điền vào form
                document.getElementById('calories').value = data.calories || 0;
                document.getElementById('protein').value = data.protein || 0;
                document.getElementById('fat').value = data.fat || 0;
                document.getElementById('carbohydrate').value = data.carbohydrate || 0;
                document.getElementById('sugar').value = data.sugar || 0;
                document.getElementById('fiber').value = data.fiber || 0;
                document.getElementById('productNameNutiral').textContent = data.productName;
            } else {
                // Nếu không có thông tin, để các ô là 0
                document.getElementById('calories').value = 0;
                document.getElementById('protein').value = 0;
                document.getElementById('fat').value = 0;
                document.getElementById('carbohydrate').value = 0;
                document.getElementById('sugar').value = 0;
                document.getElementById('fiber').value = 0;
            }

            // Đặt ID sản phẩm vào form
            document.getElementById('product_id').value = productId;
            
            // Hiển thị tên sản phẩm
       

            // Mở modal
            document.getElementById('nutritionModal').style.display = 'flex';
        });
}

// Đóng modal
function closeNutritionModal() {
    document.getElementById('nutritionModal').style.display = 'none';
}

// Đóng modal
function closeNutritionModal() {
    document.getElementById('nutritionModal').style.display = 'none';
}
document.getElementById('nutritionForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Lấy CSRF token từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Tạo đối tượng FormData và thêm CSRF token
    let formData = new FormData(this);
    formData.append('_token', csrfToken); // Thêm token vào formData

    fetch('http://localhost/web_ban_banh_kem/public/nutrition-facts/save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Thông báo thành công
        closeNutritionModal(); // Đóng modal
    })
    .catch(error => {
        console.error('Có lỗi xảy ra:', error);
    });
});

    </script>
</body>
</html>