const botReplies = {
    "Tư vấn sản phẩm": [
        "Chúng tôi có nhiều sản phẩm phù hợp với nhu cầu của bạn. Bạn quan tâm đến loại sản phẩm nào?",
        "Rất vui được tư vấn sản phẩm. Bạn có thể mô tả thêm về nhu cầu của mình không?"
    ],
    "Hỗ trợ kỹ thuật": [
        "Chúng tôi sẽ hỗ trợ kỹ thuật ngay. Vui lòng cho biết chi tiết vấn đề bạn gặp phải.",
        "Đội ngũ kỹ thuật của chúng tôi sẵn sàng giúp đỡ. Bạn có thể cung cấp thêm thông tin không?"
    ],
    "Thắc mắc về đơn hàng": [
        "Để tra cứu đơn hàng, bạn vui lòng cung cấp mã đơn hàng để chúng tôi hỗ trợ.",
        "Chúng tôi luôn sẵn sàng giải đáp các thắc mắc về đơn hàng của bạn."
    ],
    "Giá cả": [
        "Chúng tôi có nhiều chương trình ưu đãi giá. Bạn quan tâm sản phẩm nào?",
        "Giá cả luôn linh hoạt và cạnh tranh nhất thị trường. Chúng tôi có thể trao đổi chi tiết."
    ]
};

let shouldScroll = true;
let hasScrolledInitially = false;

// Lấy các phần tử DOM
const chatToggle = document.getElementById('chatToggle');
const chatWindow = document.getElementById('chatWindow');
const chatClose = document.getElementById('chatClose');
const chatMessages = document.getElementById('chatMessages');
const messageInput = document.getElementById('messageInput');
const unreadDot = document.getElementById('unreadDot');
const sendButton = document.getElementById('sendButton');

// Trạng thái hiển thị chat
let isChatOpen = false;
function checkLoginStatus() {
    return fetch('http://localhost/web_ban_banh_kem/public/check-login-status') // API kiểm tra trạng thái đăng nhập
        .then(response => response.json())
        .then(data => data.loggedIn);
}

// Bật/tắt chat
// Bật/tắt chat
chatToggle.addEventListener('click', async () => {
    const loggedIn = await checkLoginStatus();

    if (!loggedIn) {
        // Nếu chưa đăng nhập, hiển thị thông báo và không mở chat
        alert("Bạn cần đăng nhập để chat.");
        chatWindow.style.display = 'none'; // Ẩn cửa sổ chat nếu chưa đăng nhập
        return;
    }

    chatWindow.style.display = isChatOpen ? 'none' : 'flex';
    isChatOpen = !isChatOpen;

    if (isChatOpen) {
        unreadDot.style.display = 'none'; // Ẩn dấu chấm đỏ
        markMessagesAsRead(); // Đánh dấu tin nhắn là đã đọc
        loadChatMessages(); // Tải tin nhắn vào cửa sổ chat
        hasScrolledInitially = false; // Reset biến scroll
        shouldScroll = false; // Dừng cuộn tự động
    } else {
        shouldScroll = true; // Kích hoạt lại cuộn tự động khi đóng
        hasScrolledInitially = false; // Reset lại biến scroll
    }
});


// Đóng chat
chatClose.addEventListener('click', () => {
    chatWindow.style.display = 'none';
    isChatOpen = false;
    chatToggle.textContent = '💬';
});

// Hàm thêm tin nhắn
// Hàm thêm tin nhắn
function addMessage(text, type, timestamp = null) {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', `${type}-message`);

    // Tạo nội dung hiển thị
    const messageContent = document.createElement('div');
    messageContent.classList.add('message-content');
    messageContent.textContent = text;

    // Tạo phần hiển thị thời gian
    const messageTime = document.createElement('div');
    messageTime.classList.add('message-time');

    // Nếu có thời gian từ API, sử dụng thời gian đó
    const time = timestamp ? new Date(timestamp) : new Date();

    // Định dạng ngày và giờ, bao gồm thứ, ngày, tháng, năm, giờ và phút
    const options = {
        weekday: 'short',  // Chỉ lấy chữ tắt thứ
        day: '2-digit',    // Ngày dạng 2 chữ số
        month: '2-digit',  // Tháng dạng 2 chữ số
        year: 'numeric',   // Năm đầy đủ
        hour: '2-digit',   // Giờ 2 chữ số
        minute: '2-digit'  // Phút 2 chữ số
    };

    const formattedTime = time.toLocaleDateString('vi-VN', options);
    messageTime.textContent = formattedTime;

    // Gắn nội dung và thời gian vào tin nhắn
    messageDiv.appendChild(messageContent);
    messageDiv.appendChild(messageTime);

    // Thêm tin nhắn vào vùng chat
    chatMessages.appendChild(messageDiv);

    // Cuộn xuống cuối nếu cần
    if (shouldScroll) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Xử lý tin nhắn nhanh
function handleQuickReply(reply) {
    addMessage(reply, 'user');

    // Tìm câu trả lời phù hợp
    const matchedReplies = botReplies[reply] || [
        "Cảm ơn bạn đã quan tâm. Chúng tôi sẽ hỗ trợ bạn ngay.",
        "Chúng tôi đang xử lý yêu cầu của bạn."
    ];

    const botReply = matchedReplies[Math.floor(Math.random() * matchedReplies.length)];
    setTimeout(() => {
        addMessage(botReply, 'bot');
    }, 500);
}

// Gửi tin nhắn
function sendMessage() {
    const loggedIn = checkLoginStatus();

    if (!loggedIn) {
        // Nếu chưa đăng nhập, hiển thị thông báo và không mở chat
        alert("Bạn cần đăng nhập để chat.");
        chatWindow.style.display = 'none'; // Ẩn cửa sổ chat nếu chưa đăng nhập
        return;
    }
    const message = messageInput.value.trim();

    if (message) {
        // Hiển thị tin nhắn của người dùng trong giao diện
        addMessage(message, 'user');
        messageInput.value = ''; // Xóa nội dung trong input

        // Cuộn xuống cuối khi gửi
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Gửi tin nhắn đến API
        fetch('http://localhost/web_ban_banh_kem/public/chat/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                content: message // Nội dung tin nhắn
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không thể gửi tin nhắn.');
                }
                return response.json();
            })
            .then(data => {
                console.log('Tin nhắn đã được lưu:', data);

                // Giả lập bot trả lời tự động
                setTimeout(() => {
                    const botReplies = [
                        "Cảm ơn bạn đã nhắn tin. Chúng tôi sẽ phản hồi sớm nhất.",
                        "Rất vui được hỗ trợ bạn!",
                        "Xin chào, cảm ơn bạn đã liên hệ."
                    ];
                    const botReply = botReplies[Math.floor(Math.random() * botReplies.length)];
                    addMessage(botReply, 'bot');
                    chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
                }, 1000);
            })
            .catch(error => console.error('Lỗi gửi tin nhắn:', error));
    }
}


// Sự kiện gửi tin nhắn
sendButton.addEventListener('click', sendMessage);
messageInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendMessage();
});

// Tin nhắn chào mừng ban đầu
addMessage("Chào bạn! Tôi có thể giúp gì cho bạn?", 'bot');

// Kiểm tra trạng thái cuộn
chatMessages.addEventListener('scroll', () => {
    const atBottom = chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight;
    shouldScroll = atBottom; // Cập nhật trạng thái cuộn
});

// Hàm tải tin nhắn
function loadChatMessages() {
    if (!isChatOpen || !shouldScroll) return; // Không tải nếu chat đóng hoặc người dùng không ở cuối

    fetch('http://localhost/web_ban_banh_kem/public/chat/messages')
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    alert("Bạn cần đăng nhập để xem tin nhắn.");
                }
                throw new Error("Không thể tải tin nhắn.");
            }
            return response.json();
        })
        .then(data => {
            if (data.messages) {
                chatMessages.innerHTML = ""; // Xóa nội dung cũ
                data.messages.forEach(message => {
                    const type = message.is_user_send ? "user" : "bot";
                    const timestamp = message.sent_at; // Lấy thời gian sent_at từ API
                    addMessage(message.content, type, timestamp); // Truyền timestamp vào hàm addMessage
                });

                // Chỉ scroll xuống một lần đầu tiên khi mở chat
                if (!hasScrolledInitially) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                    hasScrolledInitially = true;
                }
            }
        })
        .catch(error => console.error(error));
}

// Kiểm tra tin nhắn chưa đọc
// Kiểm tra tin nhắn chưa đọc
function checkUnreadMessages() {
    checkLoginStatus().then(loggedIn => {
        if (!loggedIn) return; // Nếu chưa đăng nhập, không kiểm tra tin nhắn chưa đọc

        if (isChatOpen) return; // Không kiểm tra nếu chat đang mở

        fetch('http://localhost/web_ban_banh_kem/public/chat/unread-messages')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Lỗi khi kiểm tra tin nhắn chưa đọc');
                }
                return response.json();
            })
            .then(data => {
                if (data.unread_count && data.unread_count > 0) {
                    unreadDot.style.display = 'block'; // Hiển thị dấu chấm đỏ
                } else {
                    unreadDot.style.display = 'none'; // Ẩn dấu chấm đỏ
                }
            })
            .catch(error => console.error('Lỗi khi kiểm tra tin nhắn chưa đọc:', error));
    });
}


// Đánh dấu tin nhắn là đã đọc
function markMessagesAsRead() {
    fetch('http://localhost/web_ban_banh_kem/public/chat/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể đánh dấu tin nhắn đã đọc.');
            }
            console.log('Tin nhắn đã được đánh dấu là đã đọc.');
        })
        .catch(error => console.error('Lỗi khi đánh dấu tin nhắn đã đọc:', error));
}

// Kiểm tra lần đầu khi tải trang
checkUnreadMessages();
setInterval(() => {
    if (isChatOpen && shouldScroll) {
        loadChatMessages(); // Chỉ tải nếu chat mở và cuộn ở cuối
    }
}, 5000);

setInterval(() => {
    checkLoginStatus().then(loggedIn => {
        if (!loggedIn) return; // Nếu chưa đăng nhập, không kiểm tra tin nhắn chưa đọc

        if (!isChatOpen) {
            checkUnreadMessages(); // Chỉ kiểm tra nếu chat tắt
        }
    });
}, 20000);
