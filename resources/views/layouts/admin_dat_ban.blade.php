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
    <h2>Quản Lý Đặt Bàn</h2>
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
<button class="toolbar-btn" onclick="openAddNewTableModal()"> 
    <i class="fas fa-plus-circle"></i> Thêm bàn mới
</button>
<button class="toolbar-btn" onclick="openModalTableStatic()"> 
    <i class="fas fa-chart-bar"></i> Thống kê
</button>
    <!-- Thêm 2 nút mới -->
    
    <button class="toolbar-btn" onclick="openTableHistoryModal()">
        <i class="fas fa-history"></i> Lịch sử
    </button>
</div>
<div class="container">
        <div class="tabs">
            <div class="tab active" data-tab="all-tables">Tất Cả Bàn</div>
            <div class="tab" data-tab="booked-tables">Bàn Đã Đặt</div>
        </div>

        <div id="all-tables" class="tab-content active">
            <div class="table-grid">
                <div class="table-item">
                    <div class="table-rectangular">Bàn 1</div>
                    <div class="table-status status-available"></div>
                </div>
                <div class="table-item">
                    <div class="table-rectangular">Bàn 2</div>
                    <div class="table-status status-occupied"></div>
                </div>
                <div class="table-item">
                    <div class="table-rectangular">Bàn 3</div>
                    <div class="table-status status-available"></div>
                </div>
                <div class="table-item">
                    <div class="table-rectangular">Bàn 4</div>
                    <div class="table-status status-occupied"></div>
                </div>
                <!-- Thêm nhiều bàn khác -->
            </div>
        </div>

        <div id="booked-tables" class="tab-content">
            <div class="table-grid">
                <div class="table-item">
                    <div class="table-rectangular">Bàn 2</div>
                    <div class="table-status status-occupied"></div>
                    <p>Đặt bởi: Nguyễn Văn A</p>
                    <p>Giờ đặt: 19:30</p>
                </div>
                <div class="table-item">
                    <div class="table-rectangular">Bàn 4</div>
                    <div class="table-status status-occupied"></div>
                    <p>Đặt bởi: Trần Thị B</p>
                    <p>Giờ đặt: 20:00</p>
                </div>
            </div>
        </div>
    </div>




    <!-- Table -->
   
<!-- Modal Đặt Bàn -->
<!-- Modal Đặt Bàn -->
<div id="modalDatBanDetails" class="modal-datban">
    <div class="modal-content-datban">
        <span class="close-btn-datban" onclick="closeModalDatBan()">&times;</span>
        <h2>Chi Tiết Đặt Bàn</h2>

        <h3>Lịch Đặt Bàn Hiện Có</h3>
        <div id="current-future-schedules-datban"></div>

        <h3>Lịch Sử Đặt Bàn Trước Đó</h3>
        <div id="past-schedules-datban"></div>

        <button class="btn-close-datban" onclick="closeModalDatBan()">Đóng</button>
    </div>
</div>

<div id="addNewTableModal" class="add-new-table-modal">
    <div class="add-new-table-modal-content">
        <span class="add-new-table-close" onclick="closeAddNewTableModal()">&times;</span>
        <h2>Thêm Bàn Mới</h2>
        <form id="addNewTableForm">
            <label for="table-name">Tên Bàn:</label>
            <input type="text" id="table-name" name="table-name" required>

            <label for="status">Trạng Thái:</label>
            <select id="status" name="status" required>
                <option value="available">Có Sẵn</option>
                <option value="not_available">Không Có Sẵn</option>
            </select>

            <button type="submit" class="add-new-table-submit-btn">Thêm Bàn</button>
        </form>
    </div>
</div>
<div id="tableStaticModal" class="modal-table-static">
    <div class="modal-table-static-content">
        <span class="modal-table-static-close" onclick="closeModalTableStatic()">&times;</span>
        <h2>Thống kê bàn ăn và đặt bàn</h2>

        <!-- Bộ lọc -->
        <div class="modal-table-static-filters">
            <label for="filterStartDate">Từ ngày:</label>
            <input type="date" id="filterStartDate" class="filter-table-static-date">
            <label for="filterEndDate">Đến ngày:</label>
            <input type="date" id="filterEndDate" class="filter-table-static-date">
            <button onclick="applyTableStaticFilters()" class="btn-table-static-apply">Lọc</button>
        </div>

        <!-- Khu vực hiển thị thống kê -->
        <div class="modal-table-static-stats">
            <div id="totalTables" class="stat-table-static-item">
                <h3>Tổng số bàn</h3>
                <p id="totalTablesValue">0</p>
            </div>
            <div id="totalReservations" class="stat-table-static-item">
                <h3>Tổng số đặt bàn</h3>
                <p id="totalReservationsValue">0</p>
            </div>
            <div id="pendingReservations" class="stat-table-static-item">
                <h3>Đang chờ duyệt</h3>
                <p id="pendingReservationsValue">0</p>
            </div>
        </div>

        <!-- Khu vực hiển thị biểu đồ -->
        <div class="modal-table-static-charts">
            <canvas id="tableStaticChart1"></canvas>
            <canvas id="tableStaticChart2"></canvas>
        </div>
    </div>
</div>
<div id="tableHistoryModal" class="modal-table-history">
    <div class="modal-table-history-content">
        <span class="modal-table-history-close" onclick="closeTableHistoryModal()">&times;</span>
        <h2>Lịch sử thao tác bàn ăn</h2>

        <!-- Bộ lọc -->
        <div class="modal-table-history-filters">
            <label for="filterStartDate">Từ ngày:</label>
            <input type="date" id="filterStartDate" class="filter-table-history-date">
            <label for="filterEndDate">Đến ngày:</label>
            <input type="date" id="filterEndDate" class="filter-table-history-date">
            <label for="filterAction">Loại thao tác:</label>
            <select id="filterAction" class="filter-table-history-action">
                <option value="">Tất cả</option>
                <option value="add">Thêm bàn</option>
                <option value="update">Cập nhật bàn</option>
                <option value="delete">Xóa bàn</option>
            </select>
            <button onclick="applyTableHistoryFilters()" class="btn-table-history-apply">Lọc</button>
        </div>

        <!-- Khu vực hiển thị lịch sử -->
        <div class="modal-table-history-log">
            <table id="tableHistoryLog" class="table-history-log">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Loại thao tác</th>
                        <th>Nội dung</th>
                        <th>Admin ID</th>
                    </tr>
                </thead>
                <tbody id="tableHistoryLogBody">
                    <!-- Lịch sử sẽ được điền ở đây -->
                </tbody>
            </table>
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
      
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.getAttribute('data-tab');

                // Loại bỏ active của tab và nội dung cũ
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(tc => tc.classList.remove('active'));

                // Thêm active cho tab và nội dung mới
                tab.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
            
        });
  

        document.addEventListener('DOMContentLoaded', function () {
            const tableGrid = document.querySelector('.table-grid');

// Gọi API để lấy danh sách bàn ăn
fetch('http://localhost/web_ban_banh_kem/public/api/tables')
    .then(response => response.json())
    .then(data => {
        // Xóa nội dung cũ (nếu có)
        tableGrid.innerHTML = '';

        // Lặp qua từng bàn ăn và tạo HTML
        data.forEach(table => {
            const tableItem = document.createElement('div');
            tableItem.classList.add('table-item');
            tableItem.setAttribute('data-id', table.id);

            // Hiển thị tên bàn
            const tableRectangular = document.createElement('div');
            tableRectangular.classList.add('table-rectangular');
            tableRectangular.textContent = table.ten_ban;

            // Kiểm tra xem có lịch đặt nào có trạng thái 'pending'
            let pendingAlert = '';
            if (table.schedules && table.schedules.some(schedule => schedule.trang_thai === 'pending')) {
                pendingAlert = '<div class="pending-alert">Có yêu cầu đặt bàn chưa duyệt</div>';
            }
       
            // Hiển thị trạng thái bàn
            const tableStatus = document.createElement('div');
            tableStatus.classList.add(
                'table-status',
                table.status === 'available' ? 'status-available' : 'status-occupied'
            );

            // Gắn sự kiện nhấp vào bàn
            tableItem.addEventListener('click', function (event) {
                event.stopPropagation();
                const tableId = tableItem.getAttribute('data-id');
                showTableOptions(tableItem, tableId, table.ten_ban, table.status);
            });

            // Thêm các phần tử vào bàn ăn
            tableItem.appendChild(tableRectangular);
            tableItem.appendChild(tableStatus);
            tableGrid.appendChild(tableItem);

            // Hiển thị thông báo 'pending' nếu có
            if (pendingAlert) {
                const alertDiv = document.createElement('div');
                alertDiv.classList.add('pending-alert-container');
                alertDiv.innerHTML = pendingAlert;
                tableItem.appendChild(alertDiv);
            }
        });
    })
    .catch(error => console.error('Error fetching tables:', error));

});

// Hàm hiển thị hộp thoại lựa chọn
function showTableOptions(tableElement, tableId, tableName, tableStatus) {
    // Xóa hộp thoại cũ (nếu có)
    const existingOptions = document.querySelector('.table-options');
    if (existingOptions) existingOptions.remove();

    // Tạo hộp thoại
    const optionsBox = document.createElement('div');
    optionsBox.classList.add('table-options');

    // Nút "Xem lịch đặt"
    const viewScheduleButton = document.createElement('button');
    viewScheduleButton.textContent = 'Xem lịch đặt';
    viewScheduleButton.addEventListener('click', function () {
        // Gọi API để lấy lịch đặt của bàn
        fetch(`http://localhost/web_ban_banh_kem/public/api/tables/${tableId}/schedule`)
            .then(response => response.json())
            .then(data => {
                optionsBox.remove(); // Tắt hộp thoại hiện tại
                showScheduleInfo(tableElement, data.upcomingSchedules, data.pastSchedules);
            })
            .catch(error => console.error('Error fetching schedule:', error));
    });

    // Nút "Xem thông tin bàn ăn"
    const viewInfoButton = document.createElement('button');
    viewInfoButton.textContent = 'Xem thông tin bàn ăn';
    viewInfoButton.addEventListener('click', function () {
        optionsBox.remove(); // Tắt hộp thoại hiện tại
        showTableInfo(tableElement, tableId, tableName, tableStatus); // Hiển thị hộp thoại thông tin bàn ăn
    });

    // Gắn các nút vào hộp thoại
    optionsBox.appendChild(viewScheduleButton);
    optionsBox.appendChild(viewInfoButton);

    // Hiển thị hộp thoại bên phải bàn ăn
    const rect = tableElement.getBoundingClientRect();
    optionsBox.style.top = `${rect.top + window.scrollY}px`;
    optionsBox.style.left = `${rect.right + 10}px`;

    document.body.appendChild(optionsBox);

    // Đóng hộp thoại khi click bên ngoài
    function handleClickOutside(event) {
        if (!optionsBox.contains(event.target) && event.target !== tableElement) {
            optionsBox.remove();
            document.removeEventListener('click', handleClickOutside);
        }
    }

    // Trì hoãn để tránh sự kiện click lan ra
    setTimeout(() => {
        document.addEventListener('click', handleClickOutside);
    }, 0);
}

// Hiển thị thông tin lịch đặt
function showScheduleInfo(tableElement, upcomingSchedules, pastSchedules) {
    // Tạo hộp thoại mới
    const scheduleBox = document.createElement('div');
    scheduleBox.classList.add('schedule-info-box');

    // Tạo các tab
    const tabs = document.createElement('div');
    tabs.classList.add('tabs');

    const upcomingTab = document.createElement('button');
    upcomingTab.textContent = 'Lịch Đặt Đang Đợi';
    upcomingTab.classList.add('tab-button');
    const historyTab = document.createElement('button');
    historyTab.textContent = 'Lịch Sử Đặt';
    historyTab.classList.add('tab-button');

    tabs.appendChild(upcomingTab);
    tabs.appendChild(historyTab);

    // Thêm các tab vào hộp thoại
    scheduleBox.appendChild(tabs);

    // Tạo nội dung cho từng tab
    const upcomingContent = document.createElement('div');
    upcomingContent.classList.add('tab-content');
    upcomingSchedules.forEach(schedule => {
        const scheduleItem = document.createElement('div');
        scheduleItem.classList.add('schedule-item');
        scheduleItem.id = `schedule-item-${schedule.id}`; // Thêm ID cho phần tử

        scheduleItem.textContent = `ID Người Dùng: ${schedule.user_id} - Thời gian đặt: ${schedule.thoi_gian_dat}`;

        if (schedule.trang_thai === 'pending') {
            const approveButton = document.createElement('button');
            approveButton.textContent = 'Duyệt';
            approveButton.classList.add('approve-button');
            approveButton.addEventListener('click', () => approveSchedule(schedule.id));

            const rejectButton = document.createElement('button');
            rejectButton.textContent = 'Không Duyệt';
            rejectButton.classList.add('reject-button');
            rejectButton.addEventListener('click', () => rejectSchedule(schedule.id));

            scheduleItem.appendChild(approveButton);
            scheduleItem.appendChild(rejectButton);
        }

        upcomingContent.appendChild(scheduleItem);
    });

    const historyContent = document.createElement('div');
    historyContent.classList.add('tab-content');
    pastSchedules.forEach(schedule => {
        const scheduleItem = document.createElement('div');
        scheduleItem.classList.add('schedule-item');
        scheduleItem.textContent = `ID Người Dùng: ${schedule.user_id} - Thời gian đặt: ${schedule.thoi_gian_dat} - Trạng thái: ${schedule.trang_thai}`;
        historyContent.appendChild(scheduleItem);
    });

    scheduleBox.appendChild(upcomingContent);
    scheduleBox.appendChild(historyContent);

    // Lập sự kiện chuyển đổi giữa các tab
    upcomingTab.addEventListener('click', () => {
        upcomingContent.style.display = 'block';
        historyContent.style.display = 'none';
        upcomingTab.classList.add('active');
        historyTab.classList.remove('active');
    });

    historyTab.addEventListener('click', () => {
        historyContent.style.display = 'block';
        upcomingContent.style.display = 'none';
        historyTab.classList.add('active');
        upcomingTab.classList.remove('active');
    });

    // Mặc định tab lịch đặt đang chờ được chọn
    upcomingTab.classList.add('active');
    upcomingContent.style.display = 'block';
    historyContent.style.display = 'none';

    // Hiển thị hộp thoại kế bên bàn ăn
    const rect = tableElement.getBoundingClientRect();
    scheduleBox.style.top = `${rect.top + window.scrollY}px`;
    scheduleBox.style.left = `${rect.right + 10}px`;

    document.body.appendChild(scheduleBox);

    // Đóng hộp thoại khi click ra ngoài
    function handleClickOutside(event) {
        if (!scheduleBox.contains(event.target) && event.target !== tableElement) {
            scheduleBox.remove();
            document.removeEventListener('click', handleClickOutside);
        }
    }

    // Lắng nghe sự kiện click toàn trang
    document.addEventListener('click', handleClickOutside);
}



// Duyệt lịch đặt
// Duyệt lịch đặt
// Duyệt lịch đặt
// Duyệt lịch đặt
function approveSchedule(scheduleId) {
    fetch(`http://localhost/web_ban_banh_kem/public/schedules/${scheduleId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Thêm token CSRF vào header
        },
    })
    .then(response => response.json())
    .then(data => {
        alert(`Lịch đặt ID ${scheduleId} đã được duyệt.`);
        console.log(data);

        // Tìm và ẩn phần tử lịch đặt đã duyệt
        const scheduleItem = document.querySelector(`#schedule-item-${scheduleId}`);
        if (scheduleItem) {
            scheduleItem.style.display = 'none'; // Ẩn lịch đặt đã duyệt
        }

        // Tìm và ẩn thông báo "Có yêu cầu đặt bàn"
        const pendingAlert = document.querySelector(`#pending-alert-${scheduleId}`);
        if (pendingAlert) {
            pendingAlert.style.display = 'none'; // Ẩn thông báo "Có yêu cầu đặt bàn"
        }

        // Cập nhật giao diện sau khi duyệt
        // Bạn có thể thêm mã để cập nhật lại trạng thái giao diện tại đây
    })
    .catch(error => console.error('Error:', error));
}

// Không duyệt lịch đặt
function rejectSchedule(scheduleId) {
    fetch(`http://localhost/web_ban_banh_kem/public/schedules/${scheduleId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Thêm token CSRF vào header
        },
    })
    .then(response => response.json())
    .then(data => {
        alert(`Lịch đặt ID ${scheduleId} đã không được duyệt.`);
        console.log(data);

        // Tìm và ẩn phần tử lịch đặt đã không duyệt
        const scheduleItem = document.querySelector(`#schedule-item-${scheduleId}`);
        if (scheduleItem) {
            scheduleItem.style.display = 'none'; // Ẩn lịch đặt đã không duyệt
        }

        // Tìm và ẩn thông báo "Có yêu cầu đặt bàn"
        const pendingAlert = document.querySelector(`#pending-alert-${scheduleId}`);
        if (pendingAlert) {
            pendingAlert.style.display = 'none'; // Ẩn thông báo "Có yêu cầu đặt bàn"
        }

        // Cập nhật giao diện sau khi không duyệt
        // Bạn có thể thêm mã để cập nhật lại trạng thái giao diện tại đây
    })
    .catch(error => console.error('Error:', error));
}

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Hàm hiển thị hộp thoại thông tin bàn ăn
function showTableInfo(tableElement, tableId, tableName, tableStatus) {
    // Xóa hộp thoại cũ (nếu có)
    const existingInfoBox = document.querySelector('.table-info-box');
    if (existingInfoBox) existingInfoBox.remove();

    // Tạo hộp thoại mới
    const infoBox = document.createElement('div');
    infoBox.classList.add('table-info-box');

    // Hiển thị ID
    const idField = document.createElement('p');
    idField.textContent = `ID: ${tableId}`;

    // Hiển thị và chỉnh sửa tên bàn
    const nameField = document.createElement('div');
    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.value = tableName;
    const saveNameButton = document.createElement('button');
    saveNameButton.textContent = 'Lưu';
    saveNameButton.addEventListener('click', function () {
        fetch(`http://localhost/web_ban_banh_kem/public/api/tables/${tableId}/update-name`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Thêm token CSRF vào header
            },
            body: JSON.stringify({ ten_ban: nameInput.value }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Tên bàn đã được cập nhật') {
                    alert('Tên bàn đã được đổi thành: ' + nameInput.value);
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    nameField.appendChild(nameInput);
    nameField.appendChild(saveNameButton);

    // Hiển thị trạng thái và nút chuyển đổi
    const statusField = document.createElement('p');
    statusField.textContent = `Trạng thái: ${tableStatus === 'available' ? 'Sẵn sàng' : 'Không sẵn sàng'}`;

    const toggleStatusButton = document.createElement('button');
    toggleStatusButton.textContent = tableStatus === 'available' ? 'Chuyển sang không sẵn sàng' : 'Chuyển sang sẵn sàng';
    toggleStatusButton.addEventListener('click', function () {
        const newStatus = tableStatus === 'available' ? 'not_available' : 'available';
      // Lấy CSRF token từ meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch(`http://localhost/web_ban_banh_kem/public/api/tables/${tableId}/update-status`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json' // Thêm header này
    },
    body: JSON.stringify({ 
        status: newStatus 
    })
})
.then(response => {
    // Kiểm tra trạng thái response
    if (!response.ok) {
        // Nếu response không thành công, throw error
        return response.text().then(text => {
            throw new Error(text);
        });
    }
    return response.json();
})
.then(data => {
    // Xử lý response thành công
    alert(`Trạng thái bàn đã chuyển thành: ${newStatus}`);
    statusField.textContent = `Trạng thái: ${newStatus === 'available' ? 'Sẵn sàng' : 'Không sẵn sàng'}`;
    toggleStatusButton.textContent = newStatus === 'available' ? 'Chuyển sang không sẵn sàng' : 'Chuyển sang sẵn sàng';
    tableStatus = newStatus;
})
.catch(error => {
    // Log chi tiết lỗi
    console.error('Error details:', error);
    alert('Có lỗi xảy ra: ' + error.message);
});
    });

    // Gắn tất cả các phần tử vào hộp thoại
    infoBox.appendChild(idField);
    infoBox.appendChild(nameField);
    infoBox.appendChild(statusField);
    infoBox.appendChild(toggleStatusButton);

    // Hiển thị hộp thoại bên phải bàn ăn
    const rect = tableElement.getBoundingClientRect();
    infoBox.style.top = `${rect.top + window.scrollY}px`;
    infoBox.style.left = `${rect.right + 10}px`;

    document.body.appendChild(infoBox);

    // Đóng hộp thoại khi click bên ngoài
    function handleClickOutside(event) {
        if (!infoBox.contains(event.target) && event.target !== tableElement) {
            infoBox.remove();
            document.removeEventListener('click', handleClickOutside);
        }
    }

    // Trì hoãn để tránh sự kiện click lan ra
    setTimeout(() => {
        document.addEventListener('click', handleClickOutside);
    }, 0);
}

function displayBookedTables(bookedTables) {
    const bookedTablesContainer = document.getElementById('booked-tables');
    const tableGrid = bookedTablesContainer.querySelector('.table-grid');
    
    // Xóa tất cả các mục trong bảng
    tableGrid.innerHTML = '';

    bookedTables.forEach(table => {
        const tableItem = document.createElement('div');
        tableItem.classList.add('table-item');

        // Thêm thông tin bàn
        const tableRectangular = document.createElement('div');
        tableRectangular.classList.add('table-rectangular');
        tableRectangular.textContent = `Bàn ${table.ban_an_id}`;

        // Thêm trạng thái bàn
        const tableStatus = document.createElement('div');
        tableStatus.classList.add('table-status');
        tableStatus.classList.add(table.trang_thai === 'pending' ? 'status-pending' : 'status-confirmed');

        // Thêm thông tin người đặt và giờ đặt
        const userInfo = document.createElement('p');
        userInfo.textContent = `Đặt bởi: ${table.user ? table.user.name : 'Không xác định'}`;

        const bookingTime = document.createElement('p');
        bookingTime.textContent = `Giờ đặt: ${table.thoi_gian_dat}`;

        const returnTime = document.createElement('p');
        returnTime.textContent = `Giờ trả: ${table.thoi_gian_roi}`;

        const status = document.createElement('p');
        status.textContent = `Trạng thái: ${table.trang_thai}`;

        // Gắn các phần tử vào tableItem
        tableItem.appendChild(tableRectangular);
        tableItem.appendChild(tableStatus);
        tableItem.appendChild(userInfo);
        tableItem.appendChild(bookingTime);
        tableItem.appendChild(returnTime);
        tableItem.appendChild(status);


        // Thêm tableItem vào bảng
        tableGrid.appendChild(tableItem);
    });
}

// Gọi API để lấy danh sách bàn đã đặt và hiển thị chúng
fetch('http://localhost/web_ban_banh_kem/public/api/tables/booked', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Thêm CSRF token nếu cần
    }
})
    .then(response => response.json())
    .then(data => {
        displayBookedTables(data);
    })
    .catch(error => console.error('Error:', error));
    document.querySelector('.excel-export-btn').addEventListener('click', function() {
        // Lấy ngày hiện tại và ngày 30 ngày trước
        const today = new Date();
        const thirtyDaysAgo = new Date(today);
        thirtyDaysAgo.setDate(today.getDate() - 30);

        // Gọi API để lấy tất cả lịch sử đặt bàn
        fetch('http://localhost/web_ban_banh_kem/public/schedules/excel')
    .then(response => response.json())
    .then(data => {
        // Lấy ngày hiện tại và ngày 30 ngày trước
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30); // Tính ngày 30 ngày trước

        // Lọc các lịch sử đặt bàn trong vòng 30 ngày
        const filteredSchedules = data.filter(schedule => {
            const thoiGianDat = new Date(schedule['Thời Gian Đặt']); // Chuyển đổi thơi gian thành đối tượng Date
            return thoiGianDat >= thirtyDaysAgo && thoiGianDat <= today;
        });

        // Dữ liệu để xuất ra Excel
        const exportData = filteredSchedules.map(schedule => ({
            'ID Người Dùng': schedule['ID Người Dùng'],
            'Tên Bàn': schedule['Tên Bàn'],
            'Thời Gian Đặt': schedule['Thời Gian Đặt'],
            'Thời Gian Trả': schedule['Thời Gian Trả'],
            'Trạng Thái': schedule['Trạng Thái']
        }));

        // Kiểm tra xem dữ liệu đã được lọc chưa
        console.log('Filtered Data:', exportData);

        // Tạo workbook và worksheet từ dữ liệu đã lọc
        const ws = XLSX.utils.json_to_sheet(exportData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Lịch Sử Đặt Bàn');

        // Xuất file Excel
        XLSX.writeFile(wb, 'lich_su_dat_ban.xlsx');
    })
    .catch(error => {
        console.error('Error fetching schedules:', error);
    });

    });
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
                openDatBanDetailsModal(data.user_id);
            } else {
                alert('Không tìm thấy người dùng với mã QR này!');
            }
        })
        .catch(error => {
            console.error('Lỗi tìm kiếm mã QR:', error);
            alert('Đã có lỗi xảy ra khi tra cứu mã QR!');
        });
}
function openDatBanDetailsModal(userId) {
    fetch(`http://localhost/web_ban_banh_kem/public/api/dat-ban-details/${userId}`)
        .then(response => response.json())
        .then(data => {
            // Hiển thị lịch đặt bàn hiện tại và tương lai
            const currentFutureSchedules = data.current_and_future_schedules;
            const pastSchedules = data.past_schedules;

            // Lọc lịch đặt bàn hiện tại và tương lai
            const currentFutureHTML = currentFutureSchedules.map(schedule => {
                return `
                    <div class="schedule-item ${schedule.trang_thai}">
                        <p><strong>Tên Bàn:</strong> ${schedule.ban_an_id}</p>
                        <p><strong>Thời Gian Đặt:</strong> ${schedule.thoi_gian_dat}</p>
                        <p><strong>Thời Gian Trả:</strong> ${schedule.thoi_gian_roi}</p>
                        <p><strong>Trạng Thái:</strong> ${schedule.trang_thai}</p>
                    </div>
                `;
            }).join('');

            // Hiển thị lịch sử đặt bàn trước đó
            const pastSchedulesHTML = pastSchedules.map(schedule => {
                return `
                    <div class="schedule-item">
                        <p><strong>Tên Bàn:</strong> ${schedule.ban_an_id}</p>
                        <p><strong>Thời Gian Đặt:</strong> ${schedule.thoi_gian_dat}</p>
                        <p><strong>Thời Gian Trả:</strong> ${schedule.thoi_gian_roi}</p>
                        <p><strong>Trạng Thái:</strong> ${schedule.trang_thai}</p>
                    </div>
                `;
            }).join('');

            // Gắn HTML vào modal
            document.getElementById('current-future-schedules-datban').innerHTML = currentFutureHTML;
            document.getElementById('past-schedules-datban').innerHTML = pastSchedulesHTML;
            const dropdown = document.getElementById('dropdownContent');
            dropdown.style.display = 'none';
            // Mở modal
            document.getElementById('modalDatBanDetails').style.display = "block";
        })
        .catch(error => {
            console.error('Lỗi khi lấy chi tiết đặt bàn:', error);
            alert('Đã có lỗi khi lấy chi tiết đặt bàn!');
        });
}

function closeModalDatBan() {
    document.getElementById('modalDatBanDetails').style.display = "none";
}
function openAddNewTableModal() {
    document.getElementById('addNewTableModal').style.display = "block";
}

// Đóng modal thêm bàn
function closeAddNewTableModal() {
    document.getElementById('addNewTableModal').style.display = "none";
}

// Sự kiện submit form thêm bàn
document.getElementById('addNewTableForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const tableName = document.getElementById('table-name').value;
    const status = document.getElementById('status').value;

    // Gửi request đến API để thêm bàn
    fetch('http://localhost/web_ban_banh_kem/public/api/add-table', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Đảm bảo đã truyền CSRF Token hợp lệ
        },
        body: JSON.stringify({
            ten_ban: tableName,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thêm bàn thành công!');
            closeAddNewTableModal(); // Đóng modal sau khi thêm bàn
            location.reload(); // Tải lại trang nếu cần
        } else {
            alert(data.message || 'Đã có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Lỗi khi thêm bàn:', error);
        alert('Đã có lỗi xảy ra khi thêm bàn!');
    });
});
function openModalTableStatic() {
    document.getElementById('tableStaticModal').style.display = 'flex';
    fetchTableStaticData(); // Gọi API lần đầu để lấy dữ liệu
}

function closeModalTableStatic() {
    document.getElementById('tableStaticModal').style.display = 'none';
}


function applyTableStaticFilters() {
    const startDate = document.getElementById('filterStartDate').value;
    const endDate = document.getElementById('filterEndDate').value;

    fetchTableStaticData(startDate, endDate);
}

function fetchTableStaticData(startDate = '', endDate = '') {
    fetch(`http://localhost/web_ban_banh_kem/public/api/table-static?start_date=${startDate}&end_date=${endDate}`)
        .then(response => response.json())
        .then(data => {
            // Cập nhật thống kê
            document.getElementById('totalTablesValue').textContent = data.totalTables ?? 0;
            document.getElementById('totalReservationsValue').textContent = data.totalReservations ?? 0;
            document.getElementById('pendingReservationsValue').textContent = data.pendingReservations ?? 0;

            // Vẽ biểu đồ
            drawTableStaticChart1(data.chart1);
            drawTableStaticChart2(data.chart2);
        })
        .catch(error => console.error('Lỗi khi lấy dữ liệu thống kê:', error));
}

// Biểu đồ số lượt đặt bàn theo ngày
function drawTableStaticChart1(chartData) {
    // Nếu biểu đồ đã tồn tại, hủy trước khi vẽ mới
    if (window.tableStaticChart1 instanceof Chart) {
        window.tableStaticChart1.destroy();
    }

    // Lấy context của canvas
    const ctx = document.getElementById('tableStaticChart1').getContext('2d');

    // Vẽ biểu đồ mới
    window.tableStaticChart1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Số lượng đặt bàn theo ngày',
                data: chartData.values,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,  // Đảm bảo biểu đồ phản hồi với kích thước container
            maintainAspectRatio: false, // Cho phép thay đổi tỷ lệ
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                },
            }
        }
    });
}

function drawTableStaticChart2(chartData) {
    // Nếu biểu đồ đã tồn tại, hủy trước khi vẽ mới
    if (window.tableStaticChart2 instanceof Chart) {
        window.tableStaticChart2.destroy();
    }

    // Lấy context của canvas
    const ctx = document.getElementById('tableStaticChart2').getContext('2d');

    // Vẽ biểu đồ mới
    window.tableStaticChart2 = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Trạng thái đặt bàn',
                data: chartData.values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,  // Đảm bảo biểu đồ phản hồi với kích thước container
            maintainAspectRatio: false, // Cho phép thay đổi tỷ lệ
        }
    });
}
// Mở modal lịch sử
function openTableHistoryModal() {
    document.getElementById('tableHistoryModal').style.display = 'block';
}

// Đóng modal lịch sử
function closeTableHistoryModal() {
    document.getElementById('tableHistoryModal').style.display = 'none';
}

// Áp dụng bộ lọc
function applyTableHistoryFilters() {
    const startDate = document.getElementById('filterStartDate').value;
    const endDate = document.getElementById('filterEndDate').value;
    const action = document.getElementById('filterAction').value;

    fetchTableHistoryData(startDate, endDate, action);
}

// Lấy dữ liệu lịch sử từ server với bộ lọc
function fetchTableHistoryData(startDate, endDate, action) {
    fetch(`http://localhost/web_ban_banh_kem/public/table-history?start_date=${startDate}&end_date=${endDate}&action=${action}`)
        .then(response => response.json())
        .then(data => {
            const logTableBody = document.getElementById('tableHistoryLogBody');
            logTableBody.innerHTML = ''; // Clear previous data
            data.history.forEach(log => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${log.created_at}</td>
                    <td>${log.action}</td>
                    <td>${log.action_content}</td>
                    <td>${log.admin_id}</td>
                `;
                logTableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Lỗi khi lấy dữ liệu lịch sử:', error);
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