// Số lượng bông tuyết
const numberOfSnowflakes = 100;

// Lấy phần tử chứa bông tuyết
const snowflakesContainer = document.querySelector('.snowflakes');

// Tạo các bông tuyết ngẫu nhiên
for (let i = 0; i < numberOfSnowflakes; i++) {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.innerHTML = '❄'; // Biểu tượng bông tuyết

    // Đặt vị trí và kích thước ngẫu nhiên cho mỗi bông tuyết
    const size = Math.random() * 10 + 10 + 'px'; // Kích thước từ 10px đến 20px
    const leftPosition = Math.random() * 100 + 'vw'; // Vị trí ngang ngẫu nhiên
    const animationDuration = Math.random() * 5 + 5 + 's'; // Thời gian rơi ngẫu nhiên

    snowflake.style.fontSize = size;
    snowflake.style.left = leftPosition;
    snowflake.style.animationDuration = animationDuration;

    // Thêm bông tuyết vào container
    snowflakesContainer.appendChild(snowflake);
}
