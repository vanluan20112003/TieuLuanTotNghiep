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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
.coupons-users-container {
    display: flex;
    width: 100%;
    max-width: 1200px;
    gap: 20px;
}

.coupons-section, .users-section {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.header h2 {
    margin: 0;
    font-size: 18px;
}

.header input {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 60%;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
    overflow-y: auto;
    max-height: 300px;
}

ul li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 10px;
    border-bottom: 1px solid #f0f0f0;
}

ul li span {
    flex-grow: 1;
    font-size: 14px;
}

.more-options {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

.filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.filters button, #send {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color: #007bff;
    color: white;
    transition: 0.3s;
}

.filters button:hover, #send:hover {
    background-color: #0056b3;
}

.user-checkbox {
    margin-left: 10px;
}

#send {
    margin-top: 10px;
    align-self: flex-end;
    background-color: #28a745;
}

#send:hover {
    background-color: #218838;
}
.coupons-section {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
        }
        .coupons-section h2 {
            margin: 0 0 10px;
        }
        .coupons-section input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        #coupon-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #coupon-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        #coupon-list li:last-child {
            border-bottom: none;
        }
   
   
        .more-options {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
/* Căn chỉnh lại danh sách */
/* Phần danh sách */
#coupon-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border-bottom: 1px solid #f0f0f0;
}

/* Tên phiếu */
.coupon-name {
    flex: 1;
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

/* Trạng thái - chỉ chữ */
.status {
    font-size: 14px;
    font-weight: bold;
}

/* Màu chữ trạng thái */
.status.available {
    color: green; /* Màu xanh lá cho Available */
}

.status.unavailable {
    color: red; /* Màu đỏ cho Unavailable */
}

/* Nút tùy chọn */
.more-options {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

#coupon-list li.selected {
            background-color: yellow; /* Màu vàng khi được chọn */
        }
        /* Overlay mờ nền */
#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Mờ nền */
    z-index: 999;
}

/* Modal container */
#confirm-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Canh giữa */
    background: #ffffff;
    border-radius: 8px; /* Góc bo tròn */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Hiệu ứng đổ bóng */
    width: 400px; /* Chiều rộng modal */
    max-width: 90%; /* Responsive trên màn hình nhỏ */
    padding: 20px;
    z-index: 1000;
    font-family: Arial, sans-serif;
}

/* Tiêu đề modal */
#confirm-modal h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 0 0 15px 0; /* Khoảng cách dưới tiêu đề */
    color: #333333;
}

/* Nội dung modal */
#confirm-modal p {
    font-size: 14px;
    color: #555555;
    margin: 10px 0;
    line-height: 1.5;
}

/* Nội dung danh sách người dùng */
#confirm-modal p strong {
    color: #333333;
    font-weight: bold;
}

/* Container nút */
#confirm-modal div {
    text-align: right;
    margin-top: 20px;
}

/* Nút gửi */
#confirm-modal button#confirm-send {
    background: #28a745; /* Xanh lá */
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s ease;
}

#confirm-modal button#confirm-send:hover {
    background: #218838; /* Xanh lá đậm hơn */
}

/* Nút hủy */
#confirm-modal button#cancel-send {
    background: #dc3545; /* Đỏ */
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    margin-left: 10px;
    transition: background 0.3s ease;
}

#confirm-modal button#cancel-send:hover {
    background: #c82333; /* Đỏ đậm hơn */
}

/* Responsive */
@media (max-width: 768px) {
    #confirm-modal {
        width: 90%;
        padding: 15px;
    }

    #confirm-modal h3 {
        font-size: 16px;
    }

    #confirm-modal p {
        font-size: 13px;
    }

    #confirm-modal button {
        padding: 8px 12px;
        font-size: 13px;
    }
}
/* Căn chỉnh nút "more-options" */
.more-options {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

/* Menu dropdown căn chỉnh sang trái của nút */
.dropdown-menu {
    display: none; /* Ẩn menu mặc định */
    position: absolute;
    top: 100%; /* Hiển thị ngay dưới nút */
    left: 0; /* Căn chỉnh menu sang trái */
    transform: translateX(-100%); /* Dịch chuyển menu hoàn toàn sang trái nút */
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 0;
    margin: 0;
    list-style: none;
    z-index: 10;
    border-radius: 4px;
    overflow: hidden;
    min-width: 150px; /* Đặt chiều rộng tối thiểu */
}

/* Các item trong menu */
.dropdown-menu li {
    padding: 10px 15px;
    cursor: pointer;
    white-space: nowrap; /* Không cho dòng chữ xuống hàng */
}

.dropdown-menu li:hover {
    background-color: #f0f0f0;
}

/* Hiển thị menu khi dropdown có lớp "active" */
.dropdown.active .dropdown-menu {
    display: block;
}

/* Thêm padding cho nút cuối cùng và bỏ viền */
.dropdown-menu li:last-child {
    border-bottom: none; /* Không viền ở mục cuối */
}

/* Style cho nút đặc biệt (ví dụ: nút Dừng khuyến mãi) */
.dropdown-menu li.stop-discount {
    color: #dc3545; /* Màu đỏ cảnh báo */
}

.dropdown-menu li.stop-discount:hover {
    background-color: #f8d7da; /* Nền nhạt đỏ khi hover */
    color: #c82333; /* Màu chữ đỏ đậm hơn */
}
/* Nền mờ phía sau modal */
.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1001; /* Z-index cao hơn overlay */
    padding: 20px;
    display: block; /* Đảm bảo modal không bị ẩn */
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000; /* Overlay nằm phía dưới modal */
}
.modal-add-discount {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 600px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    padding: 20px;
}

.modal-overlay-add-discount {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Tiêu đề modal */
.modal-header-add-discount {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.modal-header-add-discount h3 {
    margin: 0;
    font-size: 18px;
}

/* Nút đóng modal */
.close-modal-add-discount {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

/* Nội dung modal */
.modal-body-add-discount {
    margin: 20px 0;
}

/* Form row */
.form-row-add-discount {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 15px;
}

/* Form group */
.form-group-add-discount {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.form-group-add-discount label {
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group-add-discount input,
.form-group-add-discount select,
.form-group-add-discount textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    width: 100%;
}

/* Footer modal */
.modal-footer-add-discount {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-add-discount {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    background: #007bff;
    color: #fff;
}

.btn-secondary-add-discount {
    background: #f5f5f5;
    color: #333;
}

.discount-stats-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .discount-stats-container {
            background-color: white;
            border-radius: 12px;
            width: 95%;
            max-width: 1200px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .discount-stats-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .discount-stats-filter {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .discount-stats-filter button {
            padding: 8px 16px;
            border: 1px solid #e0e0e0;
            background-color: #f9f9f9;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .discount-stats-filter button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .discount-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .discount-stats-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .discount-stats-card h3 {
            margin-bottom: 10px;
            color: #555;
            font-size: 1rem;
        }

        .discount-stats-card p {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .discount-stats-charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .discount-stats-close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #888;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .discount-stats-close-btn:hover {
            color: #333;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .discount-stats-charts {
                grid-template-columns: 1fr;
            }
        }

        /* Loading Spinner */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
    <h2>Quản Lý Khuyến Mãi</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>
    <div class="toolbar">
 <button class="toolbar-btn excel-export-btn add-discount-btn">
    <i class="fas fa-plus-circle"></i> Thêm phiếu giảm giá mới
</button>

<button id="exportBtn" class="toolbar-btn" onclick="exportToExcel()">
    <i class="fas fa-file-excel"></i> Xuất Excel
</button>
<button class="toolbar-btn" onclick="openDiscountStatsModal()">
        <i class="fas fa-chart-bar"></i> Thống kê
    </button>



</div>
        <div class="coupons-users-container">
            <!-- Danh sách phiếu khuyến mãi -->
            <div class="coupons-section">
        <div class="header">
            <h2>Danh sách Phiếu Khuyến Mãi</h2>
            <input type="text" id="search-coupons" placeholder="Tìm kiếm phiếu khuyến mãi...">
        </div>
        <ul id="coupon-list">
    <li>
        <span>Phiếu 1</span>
        <span class="status available">
            <span class="dot"></span>
            Available
        </span>
        <button class="more-options">⋮</button>
    </li>
    <li>
        <span>Phiếu 2</span>
        <span class="status unavailable">
            <span class="dot"></span>
            Unavailable
        </span>
        <button class="more-options">⋮</button>
    </li>
</ul>

    </div>


            <!-- Danh sách người dùng -->
            <div class="users-section">
                <div class="header">
                    <h2>Danh sách Người Dùng</h2>
                    <input type="text" id="search-users" placeholder="Tìm kiếm người dùng...">
                </div>
                <div class="filters">
                    <button id="select-all">Chọn tất cả</button>
                    <button id="select-customers">Khách Thường</button>
                    <button id="select-doctors">Bác Sĩ</button>
                </div>
                <ul id="user-list">
    <li>
        <input type="checkbox" class="user-checkbox" data-type="khách thường" data-id="1007">
        <span>LeVanLuan (Khách Thường)</span>
    </li>
    <li>
        <input type="checkbox" class="user-checkbox" data-type="khách thường" data-id="1008">
        <span>LeVanLuan (Khách Thường)</span>
    </li>
</ul>

                <button id="send">Gửi</button>
            </div>
        </div>
        <div id="discountStatsModal" class="discount-stats-modal">
        <div class="discount-stats-container">
            <div class="discount-stats-header">
                <h2>Thống Kê Khuyến Mãi</h2>
                <button class="discount-stats-close-btn" onclick="closeDiscountStatsModal()">&times;</button>
            </div>

            <div class="discount-stats-filter">
                <button onclick="fetchDiscountStats(7)" class="active">7 Ngày</button>
                <button onclick="fetchDiscountStats(30)">30 Ngày</button>
                <button onclick="fetchDiscountStats(90)">90 Ngày</button>
            </div>

            <div id="loadingSpinner" class="loading-spinner" style="display: none;">
                <div class="spinner"></div>
            </div>

            <div id="statsContent" style="display: none;">
                <div class="discount-stats-grid" id="statsContainer">
                    <div class="discount-stats-card">
                        <h3>Tổng Số Phiếu KM</h3>
                        <p id="totalDiscounts">0</p>
                        <small id="newDiscountsText">Phiếu mới trong 7 ngày</small>
                    </div>
                    <div class="discount-stats-card">
                        <h3>Phiếu KM Đã Sử Dụng</h3>
                        <p id="usedDiscounts">0</p>
                    </div>
                    <div class="discount-stats-card">
                        <h3>Tỷ Lệ Phiếu KM/Đơn Hàng</h3>
                        <p id="discountUsageRate">0%</p>
                    </div>
                </div>

                <div class="discount-stats-charts">
                    <div>
                        <canvas id="discountAddedChart"></canvas>
                    </div>
                    <div>
                        <canvas id="discountUsageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




       
   
    <script>
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
        // Sample data for the chart
        let discountAddedChart, discountUsageChart;

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
            const selectCustomersButton = document.getElementById('select-customers');
const selectDoctorsButton = document.getElementById('select-doctors');
const selectAllButton = document.getElementById('select-all');

// Lấy tất cả các checkbox
const checkboxes = document.querySelectorAll('.user-checkbox');

// Chọn tất cả checkbox



    document.getElementById('send').addEventListener('click', () => {
        const selectedUsers = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.nextElementSibling.textContent.trim());
        alert('Đã gửi đến các người dùng: ' + selectedUsers.join(', '));
    });
});
let allCoupons = []; 
  // Hàm tải dữ liệu phiếu khuyến mãi từ API
  function fetchDiscounts() {
    fetch('http://localhost/web_ban_banh_kem/public/api/discounts') // API lấy toàn bộ phiếu giảm giá
        .then(response => response.json())
        .then(data => {
            allCoupons = data; // Cập nhật allCoupons với dữ liệu từ API
            displayCoupons(allCoupons); 
            const couponList = document.getElementById('coupon-list');
            couponList.innerHTML = ''; // Xóa dữ liệu cũ

            data.forEach(discount => {
                const li = document.createElement('li');
                li.classList.add('coupon-item');
                li.dataset.id = discount.id; // Gắn ID phiếu giảm giá vào data attribute

                // Nội dung hiển thị mỗi phiếu
                li.innerHTML = `
                    <span class="coupon-name">${discount.name}</span>
                    <span class="status ${discount.status == 1 ? 'available' : 'unavailable'}">
                        ${discount.status == 1 ? 'Available' : 'Unavailable'}
                    </span>
                    <div class="dropdown">
                        <button class="more-options">⋮</button>
                        <ul class="dropdown-menu">
                           <li>
    <button class="edit-discount" style="color: white; background-color: #007bff; border: 1px solid #007bff; padding: 8px 12px; border-radius: 4px; font-size: 14px; cursor: pointer;">
        Sửa
    </button>
</li>
<li>
    <button class="stop-discount" style="color: white; background-color: #dc3545; border: 1px solid #dc3545; padding: 8px 12px; border-radius: 4px; font-size: 14px; cursor: pointer;">
        Dừng khuyến mãi
    </button>
</li>

                        </ul>
                    </div>
                `;
                couponList.appendChild(li); // Thêm vào danh sách
            });
        })
        .catch(error => console.error('Lỗi khi tải dữ liệu:', error));
}


        // Gọi hàm khi tải trang
        document.addEventListener('DOMContentLoaded', fetchDiscounts);

        let allUsers = [];
        function fetchUsers() {
    fetch('http://localhost/web_ban_banh_kem/public/discount/users') // Đường dẫn API
        .then(response => response.json())
        .then(data => {
            allUsers = data; // Lưu dữ liệu vào biến toàn cục
            displayUsers(allUsers); 
            const userList = document.getElementById('user-list');
            userList.innerHTML = ''; // Xóa dữ liệu cũ

            data.forEach(user => {
                const li = document.createElement('li');
                const userRole = user.role === 'bác sĩ' ? 'Bác Sĩ' : 'Khách Thường';

                li.innerHTML = `
                   
                    <span>${user.name}-${user.id} (${userRole})</span>
                     <input type="checkbox" class="user-checkbox" data-id="${user.id}" data-type="${user.role}">
                    
                `;
                userList.appendChild(li);
            });
        })
        .catch(error => console.error('Lỗi khi tải dữ liệu:', error));
}
document.getElementById('select-all').addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('.user-checkbox'); // Lấy danh sách mới mỗi lần
    checkboxes.forEach(checkbox => (checkbox.checked = true));
});

// Gắn sự kiện chọn người dùng "khách thường"
document.getElementById('select-customers').addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('.user-checkbox'); // Lấy danh sách mới mỗi lần
    checkboxes.forEach(checkbox => {
        checkbox.checked = checkbox.dataset.type === 'khách thường'; // So sánh chính xác
    });
});

// Gắn sự kiện chọn người dùng "bác sĩ"
document.getElementById('select-doctors').addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('.user-checkbox'); // Lấy danh sách mới mỗi lần
    checkboxes.forEach(checkbox => {
        checkbox.checked = checkbox.dataset.type === 'bác sĩ'; // So sánh chính xác
    });
});
document.getElementById('coupon-list').addEventListener('click', (event) => {
            const clickedElement = event.target.closest('.coupon-item'); // Tìm phần tử cha li

            if (clickedElement) {
                // Loại bỏ lớp "selected" khỏi tất cả các phần tử khác
                document.querySelectorAll('#coupon-list .coupon-item').forEach(item => {
                    item.classList.remove('selected');
                });

                // Thêm lớp "selected" vào phần tử được chọn
                clickedElement.classList.add('selected');

                // Lấy ID của phần tử được click
                const couponId = clickedElement.dataset.id;
                console.log('Coupon ID:', couponId);

                // Thực hiện các hành động khác nếu cần
            }
        });
        function displayCoupons(coupons) {
    const couponList = document.getElementById('coupon-list');
    couponList.innerHTML = ''; // Xóa danh sách cũ

    coupons.forEach(discount => {
        const li = document.createElement('li');
        li.classList.add('coupon-item');
        li.dataset.id = discount.id; // Gắn ID vào data attribute

        // Nội dung hiển thị phiếu
        li.innerHTML = `
            <span class="coupon-name">${discount.name}</span>
            <span class="status ${discount.status == 1 ? 'available' : 'unavailable'}">
                ${discount.status == 1 ? 'Available' : 'Unavailable'}
            </span>
               <div class="dropdown">
            <button class="more-options">⋮</button>
            <ul class="dropdown-menu">
                <li><button class="edit-discount">Sửa</button></li>
                <li><button class="stop-discount">Dừng khuyến mãi</button></li>
            </ul>
        </div>
        `;

        couponList.appendChild(li); // Thêm vào danh sách
    });
}

// Tìm kiếm phiếu khuyến mãi
document.getElementById('search-coupons').addEventListener('input', (event) => {
    const query = event.target.value.trim().toLowerCase(); // Lấy giá trị tìm kiếm, loại bỏ khoảng trắng
    const filteredCoupons = allCoupons.filter(coupon => {
        // Kiểm tra name hoặc id chứa từ khóa tìm kiếm
        return (
            coupon.name.toLowerCase().includes(query) || 
            coupon.id.toString().includes(query)
        );
    });

    // Hiển thị danh sách kết quả
    displayCoupons(filteredCoupons);
});
function displayUsers(users) {
    const userList = document.getElementById('user-list');
    userList.innerHTML = ''; // Xóa dữ liệu cũ

    users.forEach(user => {
        const li = document.createElement('li');
        const userRole = user.role === 'bác sĩ' ? 'Bác Sĩ' : 'Khách Thường';

        li.innerHTML = `
            <span>${user.user_name}-${user.id} (${userRole})</span>
            <input type="checkbox" class="user-checkbox" data-id="${user.id}" data-type="${user.role}">
        `;
        userList.appendChild(li);
    });
}

// Tìm kiếm người dùng
document.getElementById('search-users').addEventListener('input', (event) => {
    const query = event.target.value.trim().toLowerCase(); // Lấy giá trị tìm kiếm, loại bỏ khoảng trắng

    const filteredUsers = allUsers.filter(user => {
        const userName = user.user_name ? user.user_name.toLowerCase() : ''; // Xử lý null/undefined
        const userId = user.id ? user.id.toString() : ''; // Xử lý null/undefined
        const combinedField = `${userName}-${userId}`;

        // Kiểm tra user_name, id hoặc kết hợp chứa từ khóa tìm kiếm
        return (
            userName.includes(query) || 
            userId.includes(query) || 
            combinedField.includes(query)
        );
    });

    // Hiển thị danh sách kết quả
    displayUsers(filteredUsers);
});
// Gọi hàm fetchUsers khi trang được tải
document.addEventListener('DOMContentLoaded', fetchUsers);
document.getElementById('send').addEventListener('click', () => {
    // Lấy phiếu giảm giá được chọn
    const selectedCoupon = document.querySelector('#coupon-list .coupon-item.selected');
    if (!selectedCoupon) {
        alert('Vui lòng chọn một phiếu giảm giá!');
        return;
    }

    const couponId = selectedCoupon.dataset.id;
    const couponName = selectedCoupon.querySelector('.coupon-name').textContent;

    // Lấy danh sách người dùng được chọn
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(checkbox => {
        const userElement = checkbox.closest('li').querySelector('span');
        const userNameAndId = userElement.textContent.trim();
        const userId = checkbox.dataset.id;
        return { userNameAndId, userId };
    });

    if (selectedUsers.length === 0) {
        alert('Vui lòng chọn ít nhất một người dùng!');
        return;
    }

    // Hiển thị thông tin danh sách người dùng
    let userDetails = '';
    if (selectedUsers.length > 5) {
        const firstFiveUsers = selectedUsers.slice(0, 5).map(user => user.userNameAndId).join('<br>');
        userDetails = `
            ${firstFiveUsers}
            <br>...và ${selectedUsers.length - 5} người khác.
        `;
    } else {
        userDetails = selectedUsers.map(user => user.userNameAndId).join('<br>');
    }

    // Tạo hộp thoại xác nhận
    const confirmMessage = `
        <div id="confirm-modal" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: #fff; padding: 20px; border: 1px solid #ddd; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
            <h3>Xác nhận gửi phiếu</h3>
            <p><strong>Phiếu giảm giá:</strong> ${couponName} (ID: ${couponId})</p>
            <p><strong>Người nhận:</strong></p>
            <p>${userDetails}</p>
            <div style="text-align: right; margin-top: 20px;">
                <button id="confirm-send" style="margin-right: 10px;">Gửi</button>
                <button id="cancel-send">Hủy</button>
            </div>
        </div>
        <div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
    `;
    document.body.insertAdjacentHTML('beforeend', confirmMessage);

    // Xử lý sự kiện cho nút "Gửi" trong confirm
    document.getElementById('confirm-send').addEventListener('click', () => {
    const payload = {
        couponId: couponId,
        userIds: selectedUsers.map(user => user.userId),
    };

    fetch('http://localhost/web_ban_banh_kem/public/discount/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(payload),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Có lỗi xảy ra khi gửi phiếu khuyến mãi!');
        }
        return response.json();
    })
    .then(data => {
        alert(data.message); // Hiển thị thông báo thành công
        document.getElementById('confirm-modal').remove();
        document.getElementById('overlay').remove();
    })
    .catch(error => {
        console.error(error);
        alert('Không thể gửi phiếu khuyến mãi. Vui lòng thử lại!');
    });
});


    // Xử lý sự kiện cho nút "Hủy" trong confirm
    document.getElementById('cancel-send').addEventListener('click', () => {
        // Đóng modal
        document.getElementById('confirm-modal').remove();
        document.getElementById('overlay').remove();
    });
});
// Lắng nghe sự kiện click trên các nút "more-options"
document.addEventListener('click', (event) => {
    const target = event.target;

    // Kiểm tra nếu click vào nút "more-options"
    if (target.classList.contains('more-options')) {
        const dropdown = target.closest('.dropdown');
        
        // Đóng tất cả các dropdown khác
        document.querySelectorAll('.dropdown').forEach(d => {
            if (d !== dropdown) {
                d.classList.remove('active');
            }
        });

        // Hiển thị hoặc ẩn dropdown hiện tại
        dropdown.classList.toggle('active');
    } else {
        // Đóng dropdown nếu click ra ngoài
        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
    }
});

// Gắn sự kiện cho các nút trong dropdown
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('edit-discount')) {
        const couponId = event.target.closest('.coupon-item').dataset.id;
        console.log('Sửa khuyến mãi cho ID:', couponId);
        // Thực hiện logic sửa tại đây
    }

    if (event.target.classList.contains('stop-discount')) {
        const couponId = event.target.closest('.coupon-item').dataset.id;
        console.log('Dừng khuyến mãi cho ID:', couponId);
        // Thực hiện logic dừng khuyến mãi tại đây
    }
});
document.addEventListener('click', (event) => {
    const editButton = event.target.closest('.edit-discount');
    if (editButton) {
        const discountId = editButton.closest('.coupon-item').dataset.id; // Lấy ID phiếu giảm giá
        if (discountId) {
            fetch(`http://localhost/web_ban_banh_kem/public/api/getdiscounts/${discountId}`) // Gọi API chi tiết
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Không tìm thấy phiếu giảm giá');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showEditModal(data.data); // Hiển thị modal chỉnh sửa
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi tải dữ liệu chi tiết:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                });
        }
    }
});
function showEditModal(discount) {
    // HTML của modal
    const modalHTML = `
        <div class="modal-overlay" id="modal-overlay"></div>
        <div class="modal" id="edit-modal">
            <div class="modal-header">
                <h3>Chỉnh Sửa Phiếu Giảm Giá</h3>
                <button class="close-modal" id="close-modal">✖</button>
            </div>
            <div class="modal-body">
                <form id="edit-discount-form">
                    <div class="form-group">
                        <label>ID (Không sửa đổi):</label>
                        <input type="text" value="${discount.id}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tên:</label>
                        <input type="text" id="discount-name" value="${discount.name}">
                    </div>
                    <div class="form-group">
                        <label>Loại:</label>
                        <select id="discount-type">
                            <option value="purchase discount" ${discount.type === 'purchase discount' ? 'selected' : ''}>Purchase Discount</option>
                            <option value="special discount" ${discount.type === 'special discount' ? 'selected' : ''}>Special Discount</option>
                            <option value="event discount" ${discount.type === 'event discount' ? 'selected' : ''}>Event Discount</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Điều kiện tối thiểu:</label>
                        <input type="number" id="min-condition" value="${discount.minimum_condition}">
                    </div>
                    <div class="form-group">
                        <label>Điều kiện tối đa:</label>
                        <input type="number" id="max-condition" value="${discount.maximum_condition}">
                    </div>
                     <div class="form-group">
                        <label>Điều kiện dùng:</label>
                        <input type="number" id="max-condition" value="${discount.condition_use}">
                    </div>
                    <div class="form-group">
                        <label>Mô tả:</label>
                        <textarea id="discount-description">${discount.description}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" id="save-discount">Lưu</button>
                <button class="btn btn-secondary" id="cancel-modal">Hủy</button>
            </div>
        </div>
    `;

    // Chèn modal vào body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Sự kiện đóng modal
    document.getElementById('close-modal').addEventListener('click', closeModal);
    document.getElementById('cancel-modal').addEventListener('click', closeModal);

    function closeModal() {
        const modal = document.getElementById('edit-modal');
        const overlay = document.getElementById('modal-overlay');
        if (modal) modal.remove();
        if (overlay) overlay.remove();
    }
}
document.addEventListener('click', (event) => {
    const saveButton = event.target.closest('#save-discount');
    if (saveButton) {
        // Hiển thị xác nhận
        if (confirm('Bạn có chắc chắn muốn cập nhật phiếu giảm giá này?')) {
            // Lấy thông tin từ form
            const discountId = document.querySelector('#edit-discount-form input[readonly]').value;
            const name = document.getElementById('discount-name').value;
            const type = document.getElementById('discount-type').value;
            const minimumCondition = document.getElementById('min-condition').value;
            const maximumCondition = document.getElementById('max-condition').value;
            const conditionUse = document.getElementById('max-condition').value;
            const description = document.getElementById('discount-description').value;

            // Lấy CSRF Token từ meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Gửi dữ liệu lên server
            fetch(`http://localhost/web_ban_banh_kem/public/updateDiscount/${discountId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token, // Thêm token vào header
                },
                body: JSON.stringify({
                    name,
                    type,
                    minimum_condition: minimumCondition,
                    maximum_condition: maximumCondition,
                    condition_use: conditionUse,
                    description,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert('Cập nhật thành công!');
                        // Xóa modal và làm mới danh sách
                        document.getElementById('edit-modal').remove();
                        document.getElementById('modal-overlay').remove();
                        fetchDiscounts(); // Làm mới danh sách phiếu giảm giá
                    } else {
                        alert(data.message || 'Cập nhật thất bại!');
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi cập nhật:', error);
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                });
        }
    }
});
document.querySelector('.add-discount-btn').addEventListener('click', () => {
    showAddDiscountModal();

    // Đổi biểu tượng trên button
    const icon = document.querySelector('.add-discount-btn i');
    icon.classList.remove('fa-plus-circle');
    icon.classList.add('fa-times-circle');
});

function showAddDiscountModal() {
    const modalHTML = `
        <div class="modal-overlay-add-discount" id="modal-overlay-add-discount"></div>
        <div class="modal-add-discount" id="add-discount-modal">
            <div class="modal-header-add-discount">
                <h3>Thêm Phiếu Giảm Giá Mới</h3>
                <button class="close-modal-add-discount" id="close-modal-add-discount">✖</button>
            </div>
            <div class="modal-body-add-discount">
                <form id="add-discount-form">
                    <div class="form-row-add-discount">
                        <div class="form-group-add-discount">
                            <label>Tên phiếu:</label>
                            <input type="text" id="add-discount-name" placeholder="Nhập tên phiếu giảm giá">
                        </div>
                        <div class="form-group-add-discount">
                            <label>Loại phiếu:</label>
                            <select id="add-discount-type">
                                <option value="purchase discount">Purchase Discount</option>
                                <option value="special discount">Special Discount</option>
                                <option value="event discount">Event Discount</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row-add-discount">
                        <div class="form-group-add-discount">
                            <label>Điều kiện tối thiểu:</label>
                            <input type="number" id="add-min-condition" placeholder="Nhập điều kiện tối thiểu">
                        </div>
                        <div class="form-group-add-discount">
                            <label>Điều kiện tối đa:</label>
                            <input type="number" id="add-max-condition" placeholder="Nhập điều kiện tối đa">
                        </div>
                    </div>
                    <div class="form-row-add-discount">
                        <div class="form-group-add-discount">
                            <label>Điều kiện dùng:</label>
                            <input type="number" id="add-condition-use" placeholder="Nhập điều kiện dùng">
                        </div>
                        <div class="form-group-add-discount">
                            <label>Mô tả:</label>
                            <textarea id="add-description" placeholder="Nhập mô tả"></textarea>
                        </div>
                    </div>
                    <div class="form-row-add-discount">
                        <div class="form-group-add-discount">
                            <label>Giá trị giảm giá:</label>
                            <input type="number" id="add-discount-amount" placeholder="Nhập giá trị giảm giá (số tiền hoặc %)">
                        </div>
                        <div class="form-group-add-discount">
                            <label>Hạn dùng (số ngày):</label>
                            <input type="number" id="add-expiration-days" placeholder="Nhập số ngày hiệu lực">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-add-discount">
                <button class="btn-add-discount" id="save-adddiscount">Lưu</button>
                <button class="btn-secondary-add-discount" id="cancel-modal-add-discount">Hủy</button>
            </div>
        </div>
    `;

    // Thêm modal vào body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Hàm đóng modal
    function closeModal() {
        document.getElementById('modal-overlay-add-discount').remove();
        document.getElementById('add-discount-modal').remove();
    }

    // Sự kiện cho nút "✖"
    document.getElementById('close-modal-add-discount').addEventListener('click', closeModal);

    // Sự kiện cho nút "Hủy"
    document.getElementById('cancel-modal-add-discount').addEventListener('click', closeModal);

    // Sự kiện khi nhấp vào overlay
    document.getElementById('modal-overlay-add-discount').addEventListener('click', closeModal);

    // Sự kiện nút Lưu
    document.getElementById('save-adddiscount').addEventListener('click', () => {
        const name = document.getElementById('add-discount-name').value;
        const type = document.getElementById('add-discount-type').value;
        const minimumCondition = document.getElementById('add-min-condition').value;
        const maximumCondition = document.getElementById('add-max-condition').value;
        const discountAmount = document.getElementById('add-discount-amount').value;
        const expirationDays = document.getElementById('add-expiration-days').value;
        const description = document.getElementById('add-description').value;
        const conditionUse = document.getElementById('add-condition-use').value;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('http://localhost/web_ban_banh_kem/public/addDiscounts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name,
                type,
                minimum_condition: minimumCondition,
                maximum_condition: maximumCondition,
                discount_amount: discountAmount,
                expiration_days: expirationDays,
                description,
                condition_use: conditionUse
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi khi thêm phiếu giảm giá:', error));
    });
}

// Đóng modal khi bấm "Hủy" hoặc "X" trên modal




    function exportToExcel() {
        const apiUrl = 'http://localhost/web_ban_banh_kem/public/api/discounts';
        
        // Disable nút khi đang tải
        const exportBtn = document.getElementById('exportBtn');
        exportBtn.disabled = true;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tải...';

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể tải dữ liệu');
                }
                return response.json();
            })
            .then(data => {
                const worksheet = XLSX.utils.json_to_sheet(data);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Phiếu Giảm Giá');
                XLSX.writeFile(workbook, 'DanhSachPhieuGiamGia.xlsx');
                
                // Khôi phục nút
                exportBtn.disabled = false;
                exportBtn.innerHTML = '<i class="fas fa-file-excel"></i> Xuất Excel';
            })
            .catch(error => {
                console.error('Lỗi khi tải dữ liệu:', error);
                alert('Không thể tải danh sách phiếu giảm giá');
                
                // Khôi phục nút
                exportBtn.disabled = false;
                exportBtn.innerHTML = '<i class="fas fa-file-excel"></i> Xuất Excel';
            });
    }

    // Gán hàm toàn cục để sử dụng với onclick
    window.exportToExcel = exportToExcel;




function openDiscountStatsModal() {
    document.getElementById('discountStatsModal').style.display = 'flex';
    fetchDiscountStats(7);
}

function closeDiscountStatsModal() {
    document.getElementById('discountStatsModal').style.display = 'none';
}

async function fetchDiscountStats(days) {
    // Chuẩn bị giao diện
    document.getElementById('loadingSpinner').style.display = 'flex';
    document.getElementById('statsContent').style.display = 'none';

    // Cập nhật trạng thái nút
    document.querySelectorAll('.discount-stats-filter button').forEach(btn => {
        btn.classList.remove('active');
        if (parseInt(btn.textContent) === days) {
            btn.classList.add('active');
        }
    });

    try {
        // Gọi API từ Laravel backend
        const response = await fetch(`http://localhost/web_ban_banh_kem/public/discount-statistics/${days}`);
        const data = await response.json();

        // Cập nhật thống kê
        document.getElementById('totalDiscounts').textContent = data.totalDiscounts;
        document.getElementById('newDiscountsText').textContent = `Phiếu mới trong ${days} ngày`;
        document.getElementById('usedDiscounts').textContent = data.usedDiscounts;
        document.getElementById('discountUsageRate').textContent = `${data.discountUsageRate}%`;

        // Vẽ biểu đồ cột số phiếu KM theo tháng
        if (discountAddedChart) discountAddedChart.destroy();
        discountAddedChart = new Chart(document.getElementById('discountAddedChart'), {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
                datasets: [{
                    label: 'Phiếu KM Được Thêm',
                    data: data.monthlyDiscounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Số Phiếu Khuyến Mãi Theo Tháng'
                    }
                }
            }
        });

        // Vẽ biểu đồ tròn tỷ lệ sử dụng
        if (discountUsageChart) discountUsageChart.destroy();
discountUsageChart = new Chart(document.getElementById('discountUsageChart'), {
    type: 'pie',
    data: {
        labels: ['Đã Sử Dụng', 'Chưa Sử Dụng'],
        datasets: [{
            data: data.usageDistribution,
            backgroundColor: ['#36A2EB', '#FFCE56']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 1.5, // Điều chỉnh tỷ lệ này để thay đổi kích thước biểu đồ
        plugins: {
            title: {
                display: true,
                text: 'Tỷ Lệ Sử Dụng Phiếu Khuyến Mãi'
            }
        }
    }
});

        // Ẩn spinner, hiện nội dung
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('statsContent').style.display = 'block';

    } catch (error) {
        console.error('Lỗi tải thống kê:', error);
        alert('Không thể tải dữ liệu thống kê. Vui lòng thử lại.');
        document.getElementById('loadingSpinner').style.display = 'none';
    }
}

// Đóng modal khi click ngoài
window.onclick = function(event) {
    const modal = document.getElementById('discountStatsModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

    </script>
</body>
</html>