let isPlaying = false;

// Hàm gọi API Laravel để lấy thông báo hợp lệ


// Hàm gọi API Laravel để lấy thông báo hợp lệ
function getRandomAnnouncement() {
    fetch('http://localhost/web_ban_banh_kem/public/api/random-announcement') // Đảm bảo URL API là đúng
        .then(response => response.json())
        .then(data => {
            const messages = data.messages; // Nhận đối tượng các thông báo theo cấp độ
            const sortedMessages = sortMessagesByLevel(messages); // Sắp xếp thông báo theo cấp độ
            updateNotificationCount(sortedMessages.length); // Cập nhật số lượng thông báo chưa hết hạn
            if (sortedMessages.length > 0) {
                speak(sortedMessages.join(' ')); // Phát tất cả các thông báo
            } else {
                speak("Hiện tại không có thông báo phát thanh nào từ chúng tôi.");
            }
        })
        .catch(error => console.error('Error fetching announcement:', error));
}

// Hàm sắp xếp thông báo theo cấp độ
function sortMessagesByLevel(messages) {
    // Chuyển đối tượng thành mảng các thông báo kèm cấp độ
    const messageArray = Object.entries(messages).map(([level, message]) => ({ level: parseInt(level), message }));

    // Sắp xếp theo cấp độ giảm dần (cấp độ cao hơn sẽ được ưu tiên phát trước)
    messageArray.sort((a, b) => b.level - a.level);

    // Trả về mảng các thông báo đã sắp xếp
    return messageArray.map(item => item.message);
}

// Cập nhật số lượng thông báo chưa hết hạn
function updateNotificationCount(count) {
    const countElement = document.getElementById('notificationCount');
    if (count > 0) {
        countElement.classList.add('visible'); // Hiển thị số lượng
        countElement.textContent = count; // Cập nhật số lượng
    } else {
        countElement.classList.remove('visible'); // Ẩn số lượng
    }
}

// Hàm phát âm thanh
function speak(message) {
    const speech = new SpeechSynthesisUtterance();
    speech.text = message;
    speech.lang = 'vi-VN'; // Giọng nữ tiếng Việt
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1.2; // Cài đặt giọng nữ
    speechSynthesis.speak(speech);
}

// Hàm để xử lý click vào button
const speechButton = document.getElementById('speechButton');
speechButton.addEventListener('click', () => {
    if (isPlaying) {
        speechSynthesis.cancel();  // Dừng phát nếu đang phát
        isPlaying = false;
        speechButton.style.backgroundColor = '#f1c40f'; // Màu nền mặc định
    } else {
        getRandomAnnouncement(); // Lấy thông báo hợp lệ
        isPlaying = true;
        speechButton.style.backgroundColor = '#e67e22'; // Màu nền khi đang phát
    }
});

// Di chuyển button
speechButton.addEventListener('mousedown', function (e) {
    let offsetX = e.clientX - speechButton.getBoundingClientRect().left;
    let offsetY = e.clientY - speechButton.getBoundingClientRect().top;

    function onMouseMove(e) {
        speechButton.style.left = (e.clientX - offsetX) + 'px';
        speechButton.style.top = (e.clientY - offsetY) + 'px';
    }

    function onMouseUp() {
        document.removeEventListener('mousemove', onMouseMove);
        document.removeEventListener('mouseup', onMouseUp);
    }

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
});
