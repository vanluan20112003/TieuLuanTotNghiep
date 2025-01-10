<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân Tích Dinh Dưỡng</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #27ae60;
            --warning-color: #e74c3c;
            --light-bg: #f8f9fa;
            --card-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f6f8fb 0%, #f1f4f8 100%);
            color: var(--primary-color);
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05'/%3E%3C/svg%3E");
            z-index: 0;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .dashboard {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-bg);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .food-list {
            list-style: none;
            display: grid;
            gap: 1rem;
        }

        .food-item {
            background: var(--light-bg);
            border-radius: 0.8rem;
            padding: 1rem;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .food-item:hover {
            background: #edf2f7;
        }

        .food-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .nutrition-facts {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.9rem;
            color: #666;
        }

        .nutrition-tag {
            background: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: 0.8rem;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--secondary-color);
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        .chart-container {
            margin: 2rem 0;
            padding: 1rem;
            background: white;
            border-radius: 0.8rem;
            box-shadow: var(--card-shadow);
        }

        .recommendations {
            background: white;
            border-radius: 0.8rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .recommendation-item {
            padding: 1rem;
            border-left: 4px solid var(--accent-color);
            background: var(--light-bg);
            margin-bottom: 1rem;
            border-radius: 0 0.8rem 0.8rem 0;
        }

        .recommendation-item.warning {
            border-left-color: var(--warning-color);
        }

        footer {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
        }

        @media (max-width: 1024px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    
    <header>
        <h1>
            <i class="fas fa-chart-pie"></i>
            Phân Tích Dinh Dưỡng
        </h1>
        <p>Báo cáo chi tiết về chế độ dinh dưỡng của bạn trong 1 tuần vừa qua</p>
    </header>

    <div class="dashboard">
        <!-- Danh sách món ăn -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-utensils"></i>
                Món Ăn Đã Chọn
            </div>
            <ul class="food-list">
            @if(empty($orderDetails) || !isset($orderDetails) )
    <p>No order details available.</p>
@else
    @foreach ($orderDetails as $detail)
        <li class="food-item">
            <div>
                <div class="food-name">{{ $detail['product']->name }}</div>
                <div class="nutrition-facts">
                    <span class="nutrition-tag">
                        <i class="fas fa-fire"></i>
                        {{ $detail['nutritionFact']->calories }} cal
                    </span>
                    <span class="nutrition-tag">
                        <i class="fas fa-drumstick-bite"></i>
                        {{ $detail['nutritionFact']->protein }}g
                    </span>
                    <span class="nutrition-tag">
                        <i class="fas fa-bread-slice"></i>
                        {{ $detail['nutritionFact']->carbohydrate }}g
                    </span>
                    <span class="nutrition-tag">
                        <i class="fas fa-oil-can"></i>
                        {{ $detail['nutritionFact']->fat }}g
                    </span>
                </div>
            </div>
        </li>
    @endforeach
@endif

            </ul>
        </div>

        <!-- Phân tích dinh dưỡng -->
        @if(!empty($orderDetails) && isset($orderDetails))
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chart-bar"></i>
            Tổng Quan Dinh Dưỡng
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-fire"></i>
                <div class="stat-value">{{ $totalCalories }}</div>
                <div class="stat-label">Calo</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-drumstick-bite"></i>
                <div class="stat-value">{{ $totalProtein }}g</div>
                <div class="stat-label">Protein</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-bread-slice"></i>
                <div class="stat-value">{{ $totalCarbs }}g</div>
                <div class="stat-label">Tinh bột</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-oil-can"></i>
                <div class="stat-value">{{ $totalFat }}g</div>
                <div class="stat-label">Chất béo</div>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="nutritionChart"></canvas>
        </div>

        <div class="recommendations">
            <h3><i class="fas fa-lightbulb"></i> Lời Khuyên Dinh Dưỡng</h3>
            @if ($totalCalories < 14000)
            <div class="recommendation-item">
                <strong>Calories:</strong> Bạn đang tiêu thụ ít calo hơn mức khuyến nghị. Hãy bổ sung thêm thực phẩm giàu calo như trái cây, hạt, ngũ cốc nguyên hạt.
            </div>
            @endif
            
            @if ($totalProtein < 350)
            <div class="recommendation-item warning">
                <strong>Protein:</strong> Bạn đang thiếu protein. Hãy bổ sung thêm thịt nạc, cá, trứng, đậu và các sản phẩm từ sữa.
            </div>
            @endif
            
            @if ($totalCarbs < 2100)
            <div class="recommendation-item">
                <strong>Carbs:</strong> Bạn đang thiếu carbohydrates. Thêm ngũ cốc nguyên hạt, khoai tây và gạo vào chế độ ăn.
            </div>
            @endif
            
            @if ($totalFat < 490)
            <div class="recommendation-item">
                <strong>Fat:</strong> Hãy bổ sung thêm chất béo lành mạnh như dầu ô liu, các loại hạt và quả bơ.
            </div>
            @endif
            
            @if ($totalFiber < 210)
            <div class="recommendation-item">
                <strong>Fiber:</strong> Bạn đang thiếu chất xơ. Hãy ăn nhiều rau quả, đậu và ngũ cốc nguyên hạt.
            </div>
            @endif
            
            @if ($totalSugar < 350)
            <div class="recommendation-item">
                <strong>Sugar:</strong> Bạn đang tiêu thụ ít đường hơn mức khuyến nghị. Hãy hạn chế thực phẩm có đường thêm vào chế độ ăn của bạn.
            </div>
            @endif
        </div>
    </div>
@endif

    </div>

    <footer>
        <p>&copy; 2025 Căn Tin Bệnh Viện XYZ - Chăm sóc sức khỏe từ bữa ăn của bạn</p>
    </footer>
    <script>
    // Kiểm tra các biến PHP trước khi sử dụng trong JavaScript
    const totalCalories = {{ isset($totalCalories) && is_numeric($totalCalories) ? $totalCalories : 0 }};
    const totalProtein = {{ isset($totalProtein) && is_numeric($totalProtein) ? $totalProtein : 0 }};
    const totalCarbs = {{ isset($totalCarbs) && is_numeric($totalCarbs) ? $totalCarbs : 0 }};
    const totalFat = {{ isset($totalFat) && is_numeric($totalFat) ? $totalFat : 0 }};
    const totalFiber = {{ isset($totalFiber) && is_numeric($totalFiber) ? $totalFiber : 0 }};
    const totalSugar = {{ isset($totalSugar) && is_numeric($totalSugar) ? $totalSugar : 0 }};

    const ctx = document.getElementById('nutritionChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Calories', 'Protein', 'Carbs', 'Fat', 'Fiber', 'Sugar'],
            datasets: [{
                label: 'Thực tế',
                data: [
                    totalCalories, 
                    totalProtein, 
                    totalCarbs, 
                    totalFat,
                    totalFiber,
                    totalSugar
                ],                    
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(52, 152, 219, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(52, 152, 219, 1)'
            }, {
                label: 'Khuyến nghị',
                data: [
                    14000,  // Calories in a week
                    350,    // Protein in a week
                    2100,   // Carbs in a week
                    490,    // Fat in a week
                    210,    // Fiber in a week
                    350     // Sugar in a week
                ],
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                borderColor: 'rgba(46, 204, 113, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(46, 204, 113, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(46, 204, 113, 1)'
            }]
        },
        options: {
            responsive: true,
            scale: {
                ticks: {
                    beginAtZero: true,
                    max: 2000,
                },
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + (tooltipItem.datasetIndex === 0 ? 'g' : ' cal');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
