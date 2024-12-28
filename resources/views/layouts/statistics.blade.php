<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: row;
            margin: 0;
        }
        #sidebar {
            width: 250px;
            background-color: #343a40;
            padding: 15px;
            position: fixed;
            height: 100%;
        }
        #sidebar .nav-link {
            color: #ffffff;
        }
        #sidebar .nav-link.active {
            background-color: #495057;
        }
        #sidebar .nav-link:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }
        .chart-container {
            position: relative;
            height: 300px; /* Adjust as needed */
            margin-bottom: 20px;
        }
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="sidebar">
        <a class="navbar-brand" href="#"></a>
        <ul class="navbar-nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="managementMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-gear"></i> Management
                </a>
                <div class="dropdown-menu" aria-labelledby="managementMenu" id="managementSubmenu">
                    <a class="dropdown-item" href="{{ route('admin.product.index') }}">
                        <i class="bi bi-box"></i> Product
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.category.index') }}">
                        <i class="bi bi-tags"></i> Category
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.user.index') }}">
                    <i class="bi bi-person"></i> User Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-basket"></i> Order Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.statistics.index') }}">
                    <i class="bi bi-bar-chart"></i> Statistics
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <h1>Statistics</h1>

        <!-- Biểu đồ doanh thu -->
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>

        <!-- Biểu đồ sản phẩm bán chạy nhất -->
        <div class="chart-container">
            <canvas id="bestSellingChart"></canvas>
        </div>

        <!-- Biểu đồ doanh thu theo sản phẩm -->
        <div class="chart-container">
            <canvas id="productRevenueChart"></canvas>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dữ liệu từ Blade
            const dailyRevenueLabels = @json($dailyRevenue->pluck('date'));
            const dailyRevenueData = @json($dailyRevenue->pluck('revenue'));
            const bestSellingProductsLabels = @json($bestSellingProducts->pluck('name'));
            const bestSellingProductsData = @json($bestSellingProducts->pluck('quantity_sold'));
            const productRevenueLabels = @json($productRevenue->pluck('name'));
            const productRevenueData = @json($productRevenue->pluck('total_revenue'));

            // Biểu đồ doanh thu
            const revenueChartCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueChartCtx, {
                type: 'line',
                data: {
                    labels: dailyRevenueLabels,
                    datasets: [{
                        label: 'Revenue',
                        data: dailyRevenueData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ sản phẩm bán chạy nhất
            const bestSellingChartCtx = document.getElementById('bestSellingChart').getContext('2d');
            new Chart(bestSellingChartCtx, {
                type: 'bar',
                data: {
                    labels: bestSellingProductsLabels,
                    datasets: [{
                        label: 'Quantity Sold',
                        data: bestSellingProductsData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ doanh thu theo sản phẩm
            const productRevenueChartCtx = document.getElementById('productRevenueChart').getContext('2d');
            new Chart(productRevenueChartCtx, {
                type: 'bar',
                data: {
                    labels: productRevenueLabels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: productRevenueData,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
