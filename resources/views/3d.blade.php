<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Căn tin Bệnh viện 3D</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fa;
            overflow-x: hidden;
        }

        .header {
            background: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .dietary-filters {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .filter-btn {
            padding: 5px 15px;
            border: 1px solid #2196f3;
            border-radius: 20px;
            background: white;
            color: #2196f3;
            cursor: pointer;
        }

        .filter-btn.active {
            background: #2196f3;
            color: white;
        }

        .scene {
            margin-top: 80px;
            perspective: 1000px;
            padding: 20px;
        }

        .store {
            transform-style: preserve-3d;
            transform: rotateX(10deg);
            transition: transform 0.5s;
        }

        .section {
            margin-bottom: 40px;
            transform-style: preserve-3d;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        .products-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            transform-style: preserve-3d;
        }

        .product {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform-style: preserve-3d;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .product:hover {
            transform: translateZ(20px);
        }

        .product img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-info {
            margin-top: 15px;
        }

        .product-name {
            font-weight: bold;
            color: #333;
        }

        .product-tags {
            display: flex;
            gap: 5px;
            margin: 5px 0;
            flex-wrap: wrap;
        }

        .tag {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .tag-diet { background: #e3f2fd; color: #1565c0; }
        .tag-allergy { background: #ffebee; color: #c62828; }
        .tag-health { background: #e8f5e9; color: #2e7d32; }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            display: none;
            z-index: 1000;
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .nutrition-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 15px 0;
        }

        .nutrition-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
        }

        .recommendations {
            margin-top: 15px;
            padding: 15px;
            background: #f1f8e9;
            border-radius: 8px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            z-index: 999;
        }

        .schedule-info {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .products-row {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Căn tin Bệnh viện</h1>
        <div class="dietary-filters">
            <button class="filter-btn" data-filter="all">Tất cả</button>
            <button class="filter-btn" data-filter="low-sodium">Ít muối</button>
            <button class="filter-btn" data-filter="diabetic">Tiểu đường</button>
            <button class="filter-btn" data-filter="vegetarian">Chay</button>
            <button class="filter-btn" data-filter="soft-diet">Thức ăn mềm</button>
        </div>
    </header>

    <div class="scene">
        <div class="store">
            <section class="section">
                <h2 class="section-title">Thực đơn hôm nay (Phù hợp cho bệnh nhân)</h2>
                <div class="products-row" id="patient-menu">
                    <!-- Products will be dynamically added here -->
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">Thực đơn cho nhân viên & khách</h2>
                <div class="products-row" id="staff-menu">
                    <!-- Products will be dynamically added here -->
                </div>
            </section>
        </div>
    </div>

    <div class="schedule-info">
        <strong>Giờ phục vụ:</strong>
        <p>Sáng: 6:30 - 8:30</p>
        <p>Trưa: 11:00 - 13:30</p>
        <p>Chiều: 17:00 - 19:00</p>
    </div>

    <div class="modal" id="product-modal">
        <div class="modal-header">
            <h2 id="modal-product-name"></h2>
            <button class="btn-secondary" onclick="closeModal()">&times;</button>
        </div>
        <div id="modal-content">
            <img id="modal-image" style="width: 100%; border-radius: 10px;">
            <div class="nutrition-info" id="modal-nutrition"></div>
            <div class="recommendations" id="modal-recommendations"></div>
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="orderNow()">Đặt món</button>
                <button class="btn btn-secondary" onclick="scheduleOrder()">Đặt trước</button>
            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <script>
        // Sample data structure
        const menuItems = {
            patient: [
                {
                    id: 1,
                    name: "Cháo cá hồi",
                    image: "/images/salmon-porridge.jpg",
                    price: "45.000₫",
                    tags: ["Mềm", "Giàu protein", "Ít muối"],
                    nutrition: {
                        calories: "250 kcal",
                        protein: "15g",
                        sodium: "120mg",
                        carbs: "35g"
                    },
                    restrictions: ["Tiểu đường", "Huyết áp"],
                    recommendations: "Phù hợp cho bệnh nhân sau phẫu thuật, người cao tuổi"
                },
                // More items...
            ],
            staff: [
                {
                    id: 101,
                    name: "Cơm gà sốt nấm",
                    image: "/images/chicken-rice.jpg",
                    price: "55.000₫",
                    tags: ["Đầy đủ dinh dưỡng", "Nhiều protein"],
                    nutrition: {
                        calories: "450 kcal",
                        protein: "25g",
                        sodium: "400mg",
                        carbs: "60g"
                    }
                },
                // More items...
            ]
        };

        // Initialize the interface
        function initializeMenu() {
            renderMenu('patient-menu', menuItems.patient);
            renderMenu('staff-menu', menuItems.staff);
            initializeFilters();
        }

        function renderMenu(containerId, items) {
            const container = document.getElementById(containerId);
            container.innerHTML = items.map(item => createProductCard(item)).join('');
        }

        function createProductCard(item) {
            return `
                <div class="product" onclick="showProductDetails(${item.id})">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="product-info">
                        <div class="product-name">${item.name}</div>
                        <div class="product-tags">
                            ${item.tags.map(tag => `
                                <span class="tag tag-health">${tag}</span>
                            `).join('')}
                        </div>
                        <div class="product-price">${item.price}</div>
                    </div>
                </div>
            `;
        }

        function showProductDetails(id) {
            const item = [...menuItems.patient, ...menuItems.staff]
                .find(item => item.id === id);

            document.getElementById('modal-product-name').textContent = item.name;
            document.getElementById('modal-image').src = item.image;
            
            // Render nutrition info
            const nutritionHtml = Object.entries(item.nutrition)
                .map(([key, value]) => `
                    <div class="nutrition-item">
                        <span>${key}:</span>
                        <span>${value}</span>
                    </div>
                `).join('');
            document.getElementById('modal-nutrition').innerHTML = nutritionHtml;

            // Render recommendations if available
            if (item.recommendations) {
                document.getElementById('modal-recommendations').innerHTML = `
                    <h3>Khuyến nghị:</h3>
                    <p>${item.recommendations}</p>
                `;
            }

            showModal();
        }

        function showModal() {
            document.getElementById('modal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function orderNow() {
            // Implement order logic
            alert('Đơn hàng của bạn đã được ghi nhận!');
            closeModal();
        }

        function scheduleOrder() {
            // Implement schedule order logic
            alert('Chức năng đặt trước sẽ được cập nhật sớm!');
        }

        // Initialize filters
        function initializeFilters() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    filterMenu(button.dataset.filter);
                });
            });
        }

        function filterMenu(filter) {
            // Implement filter logic
            console.log('Filtering by:', filter);
        }

        // Initialize the interface when page loads
        document.addEventListener('DOMContentLoaded', initializeMenu);
    </script>
</body>
</html>