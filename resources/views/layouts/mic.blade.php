<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Text Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .mic-button {
            background-color: #ff5722;
            border: none;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .mic-button img {
            width: 40px;
            height: 40px;
        }
        .output {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Speech to Text</h1>
    <button class="mic-button" id="micButton">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/microphone.png" alt="Mic">
    </button>
    <div class="output" id="output">Nhấn vào micro và bắt đầu nói...</div>

    <script>
        // Kiểm tra nếu trình duyệt hỗ trợ Web Speech API
        if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();

            // Thiết lập ngôn ngữ (tiếng Việt)
            recognition.lang = 'vi-VN';
            recognition.interimResults = false; // Kết quả cuối cùng

            const micButton = document.getElementById('micButton');
            const output = document.getElementById('output');

            micButton.addEventListener('click', () => {
                recognition.start(); // Bắt đầu nghe
                output.textContent = 'Đang nghe...';
            });

            // Khi nhận được kết quả
            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript; // Văn bản từ giọng nói
                output.textContent = `Bạn vừa nói: "${transcript}"`;
            };

            // Khi kết thúc nhận diện
            recognition.onend = () => {
                output.textContent += ' (Kết thúc)';
            };

            // Khi xảy ra lỗi
            recognition.onerror = (event) => {
                output.textContent = `Lỗi: ${event.error}`;
            };
        } else {
            document.getElementById('output').textContent = 'Trình duyệt của bạn không hỗ trợ Web Speech API';
        }
    </script>
</body>
</html>
