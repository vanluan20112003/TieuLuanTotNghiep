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

.dropdown-menu .btn:hover {
    background-color: #ddd; /* Màu nền khi hover vào các item */
}
/* CSS cho modal thêm danh mục */
.add-category-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
}

.add-category-modal .modal-content {
    background: white;
    padding: 20px;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.add-category-modal .modal-content h2 {
    margin-bottom: 20px;
    text-align: center;
}

.add-category-modal label {
    display: block;
    margin-bottom: 8px;
}

.add-category-modal input {
    width: 100%;
    padding: 8px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.add-category-modal .modal-actions {
    display: flex;
    justify-content: space-between;
}

.add-category-modal .modal-actions button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.add-category-modal .modal-actions button#cancel-category-btn {
    background-color: #dc3545;
}

.add-category-modal .modal-actions button:hover {
    background-color: #218838;
}

.add-category-modal .modal-actions button#cancel-category-btn:hover {
    background-color: #c82333;
}
.category-static-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    padding-top: 60px;
}

.category-static-modal-content {
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.category-static-close-btn {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
}

.category-static-close-btn:hover,
.category-static-close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.category-static-table th, .category-static-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
/* Modal Background */
.category-static-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    overflow: auto;
}

/* Modal Content */
.category-static-modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    width: 80%;
    max-width: 900px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
}

/* Close Button */
.category-static-close-btn {
    font-size: 30px;
    color: #333;
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
}

/* Table Scroll */
.category-static-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.category-static-table th, .category-static-table td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
}

.category-static-table th {
    background-color: #f4f4f4;
}
category-static-modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    width: 90%; /* Giảm xuống từ 80% */
    max-width: 800px; /* Giảm xuống từ 900px */
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
}

#categoryStaticChart {
    height: 300px; /* Chiều cao cố định */
    max-width: 100%;
    margin: 0 auto;
}
/* Ẩn modal mặc định */
.modal {
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

/* Nội dung của modal */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Button đóng */
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
/* Định dạng button */

/* Modal */
#maintenanceModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Lớp nền mờ */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

#maintenanceModal .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#maintenanceModal input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

#maintenanceModal button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 10px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    width: 100%;
}

#maintenanceModal button:hover {
    background-color: #0056b3;
}

#maintenanceModal p {
    font-size: 14px;
    margin-top: 10px;
    color: #666;
}

#maintenanceModal #generatedSecret {
    color: #333;
    font-weight: bold;
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
    <h2>Khôi phục dữ liệu</h2>
    <div class="user-info">
        Đang đăng nhập: <span id="admin_name">Đang tải...</span> <!-- Hiển thị tên admin -->
        <small id="admin_role">Vai trò: Đang tải...</small> <!-- Hiển thị vai trò admin -->
    </div>
</div>
    </div>
    <div class="toolbar">
   
   <!-- Button để mở modal -->
 
<!-- Modal Form để nhập mật khẩu bảo trì -->
<!-- Nút Bảo trì hệ thống -->
<button class="toolbar-btn post-static-modal-btn" id="startMaintenanceBtn" onclick="openStopSystem()"> 
    <i class="fas fa-wrench"></i> Bảo trì hệ thống
</button>


<!-- Nút Tắt bảo trì (ẩn khi không bảo trì) -->
<button class="toolbar-btn post-static-modal-btn" id="stopMaintenanceBtn" style="display: none;" onclick="stopMaintenance()"> 
    <i class="fas fa-stop-circle"></i> Tắt bảo trì
</button>

<!-- Modal Form để nhập mật khẩu bảo trì -->
<div id="maintenanceModal" style="display:none;">
    <div class="modal-content">
        <label for="password">Mật khẩu bảo trì:</label>
        <input type="password" id="password" placeholder="Nhập mật khẩu bảo trì">
        
        <button onclick="generateSecretKey()">Tạo Secret Key</button>
        
        <p id="generatedSecret" style="display:none;">Mã Secret: <span id="secretKeyDisplay"></span></p>
        
        <button onclick="startMaintenance()">Bắt đầu bảo trì</button>
    </div>
</div>





<!-- Modal nhập Secret Key -->
<div id="secretModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Nhập Secret Key để bảo trì</h2>
        <input type="text" id="secretKey" placeholder="Nhập secret key">
        <button onclick="startMaintenance()">Bắt đầu bảo trì</button>
    </div>
</div>


 </div>
    <div class="tabs-container">
        <!-- Tab navigation -->
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'restoreProductsTab')">Khôi phục dữ liệu sản phẩm</button>
            <button class="tab-btn" onclick="openTab(event, 'restoreOrdersTab')">Khôi phục dữ liệu đơn hàng</button>
        </div>

        <!-- Tab content -->
        <div id="restoreProductsTab" class="tab-content active">
            <div class="search-container">
                <input type="text" id="productSearch" placeholder="Tìm kiếm sản phẩm..." oninput="filterTable('productTable', this.value)">
            </div>
            <table id="productTable" class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Khôi phục</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Danh sách sản phẩm sẽ được render tại đây -->
                </tbody>
            </table>
        </div>

        <div id="restoreOrdersTab" class="tab-content">
            <div class="search-container">
                <input type="text" id="orderSearch" placeholder="Tìm kiếm đơn hàng..." oninput="filterTable('orderTable', this.value)">
            </div>
            <table id="orderTable" class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã đơn hàng</th>
                        <th>Người dùng</th>
                        <th>Ngày tạo</th>
                        <th>Khôi phục</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Danh sách đơn hàng sẽ được render tại đây -->
                </tbody>
            </table>
        </div>
    </div>
   
</div>
   
    <script>
        // Sample data for the chart
       

        document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggle-menu");
    const sidebar = document.querySelector(".sidebar");
    const mainContent = document.querySelector(".main-content");
    checkMaintenanceStatus(); 
    toggleButton.addEventListener("click", () => {
        const isHidden = sidebar.classList.toggle("hidden");
        mainContent.classList.toggle("full-width");
        toggleButton.textContent = isHidden ? "☰" : "✕";
    });
        })
      
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
        function openTab(event, tabId) {
        // Ẩn tất cả nội dung tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // Xóa trạng thái "active" của tất cả nút tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Hiển thị tab được chọn
        document.getElementById(tabId).classList.add('active');

        // Đánh dấu nút tab được chọn là "active"
        event.currentTarget.classList.add('active');
    }

    function filterTable(tableId, query) {
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tbody tr');
    query = query.toLowerCase();

    rows.forEach(row => {
        const idCell = row.querySelector('td:nth-child(2)');
        const nameCell = tableId === 'productTable' ? row.querySelector('td:nth-child(2)') : null; // Tên chỉ áp dụng với sản phẩm
        const match = tableId === 'productTable' 
            ? (idCell && idCell.textContent.toLowerCase().includes(query)) || 
              (nameCell && nameCell.textContent.toLowerCase().includes(query))
            : (idCell && idCell.textContent.toLowerCase().includes(query)); // Chỉ tìm theo mã đơn hàng cho order

        if (match) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

    document.addEventListener('DOMContentLoaded', function () {
    // Fetch deleted products
    fetch('http://localhost/web_ban_banh_kem/public/deleted-products')
        .then(response => response.json())
        .then(data => renderTable('productTable', data, 'product'));

    // Fetch deleted orders
    fetch('http://localhost/web_ban_banh_kem/public/deleted-orders')
        .then(response => response.json())
        .then(data => renderTable('orderTable', data, 'order'));
});

function renderTable(tableId, data, type) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    tableBody.innerHTML = '';

    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${type === 'product' ? item.name : item.id}</td>
            <td>${type === 'product' ? item.category.name : item.user.name}</td>
           <td>${type === 'product' ? item.price : formatDate(item.created_at)}</td>

            <td>
                <button class="restore-btn" data-id="${item.id}" data-type="${type}">Khôi phục</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Add event listeners to restore buttons
    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const type = this.dataset.type;
            restoreItem(type, id);
        });
    });
}
function formatDate(dateString) {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', options);
}


function restoreItem(type, id) {
    const confirmMessage = type === 'product' 
        ? 'Bạn có chắc chắn muốn khôi phục sản phẩm này không?' 
        : 'Bạn có chắc chắn muốn khôi phục đơn hàng này không?';

    if (confirm(confirmMessage)) {
        const url = type === 'product' 
            ? `http://localhost/web_ban_banh_kem/public/products/${id}/restore` 
            : `http://localhost/web_ban_banh_kem/public/orders/${id}/restore`;

        fetch(url, { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
            } 
        })
        .then(response => {
            if (response.ok) {
                alert('Khôi phục thành công!');
                location.reload();
            } else {
                alert('Đã xảy ra lỗi!');
            }
        });
    } else {
        alert('Hành động khôi phục đã bị hủy.');
    }
}
// Mở modal
function openStopSystem() {
    // Hiển thị modal khi bấm vào nút "Bảo trì hệ thống"
    document.getElementById("maintenanceModal").style.display = "flex";
}

function closeStopSystem() {
    // Đóng modal
    document.getElementById("maintenanceModal").style.display = "none";
}
window.onclick = function(event) {
    var modal = document.getElementById("maintenanceModal");
    // Kiểm tra nếu click ngoài modal thì đóng modal
    if (event.target == modal) {
        closeStopSystem();
    }
}

function generateSecretKey() {
    var randomSecret = Math.random().toString(36).substring(2, 18); // Tạo secret key ngẫu nhiên 16 kí tự
    document.getElementById("secretKeyDisplay").textContent = randomSecret;
    document.getElementById("generatedSecret").style.display = "block"; // Hiển thị mã secret
}

function startMaintenance() {
    var password = document.getElementById("password").value; // Lấy mật khẩu bảo trì
    var secretKey = document.getElementById("secretKeyDisplay").textContent; // Lấy mã secret

    // Gửi mật khẩu và mã secret tới server
    if (password && secretKey) {
        fetch('http://localhost/web_ban_banh_kem/public/start-maintenance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ password: password, secret: secretKey })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
    alert('Hệ thống đang bảo trì!');
    document.getElementById("startMaintenanceBtn").style.display = "none";  // Ẩn nút Bảo trì
    document.getElementById("stopMaintenanceBtn").style.display = "inline-flex";  // Hiển thị nút Tắt bảo trì
    closeStopSystem(); // Đóng modal khi thành công
    window.location.reload(); // Tải lại trang để cập nhật trạng thái
}
else {
                alert(data.message); // Hiển thị lỗi nếu không thành công
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Vui lòng nhập mật khẩu bảo trì và mã Secret!');
    }
}

function stopMaintenance() {
    // Khi tắt bảo trì, gửi request đến server để bật lại hệ thống
    fetch('http://localhost/web_ban_banh_kem/public/stop-maintenance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Hệ thống đã được bật lại!');
            document.getElementById("stopMaintenanceBtn").style.display = "none";  // Ẩn nút Tắt bảo trì
            document.getElementById("startMaintenanceBtn").style.display = "inline-flex";  // Hiển thị nút Bảo trì
        } else {
            alert('Không thể tắt bảo trì!');
        }
    })
    .catch(error => console.error('Error:', error));
}

   // Kiểm tra trạng thái bảo trì khi tải lại trang

   
function checkMaintenanceStatus() {
        fetch('http://localhost/web_ban_banh_kem/public/check-maintenance-status', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'maintenance') {
                // Nếu đang bảo trì, ẩn nút Bảo trì và hiển thị nút Tắt bảo trì
                document.getElementById("startMaintenanceBtn").style.display = "none";
                document.getElementById("stopMaintenanceBtn").style.display = "inline-flex";
            } else {
                // Nếu không phải bảo trì, hiển thị nút Bảo trì và ẩn nút Tắt bảo trì
                document.getElementById("startMaintenanceBtn").style.display = "inline-flex";
                document.getElementById("stopMaintenanceBtn").style.display = "none";
            }
        })
        .catch(error => console.error('Error:', error));
    }
      </script>
</body>
</html>