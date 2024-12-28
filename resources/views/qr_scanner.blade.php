<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>

    <!-- Tải thư viện Html5Qrcode từ CDN -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>
    <h1>Quét mã QR</h1>

    <!-- Phần tử HTML để hiển thị camera -->
    <div style="width: 500px" id="qr-reader"></div>
    <div id="qr-reader-results"></div>

    <button id="start-scan">Quét bằng Camera</button>

    <!-- Form tải tệp ảnh chứa mã QR -->
    <h3>Hoặc tải tệp ảnh chứa mã QR</h3>
    <input type="file" id="qr-file" accept="image/*">
    <div id="file-reader-results"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let html5QrCode;
            let cameraStarted = false;

            // Bắt đầu quét bằng camera
            document.getElementById('start-scan').addEventListener('click', function() {
                if (!cameraStarted) {
                    html5QrCode = new Html5Qrcode("qr-reader");

                    html5QrCode.start(
                        { facingMode: "environment" }, // facingMode: "environment" sử dụng camera sau (nếu có)
                        {
                            fps: 10, // Số khung hình trên giây
                            qrbox: { width: 250, height: 250 }, // Khu vực quét
                        },
                        onScanSuccess, // Hàm callback khi quét thành công
                        onScanError // Hàm callback khi xảy ra lỗi
                    ).catch(err => {
                        console.error("Lỗi khi mở camera: ", err);
                        alert("Không thể mở camera. Kiểm tra quyền truy cập.");
                    });
                    
                    cameraStarted = true;
                    this.innerText = 'Dừng Quét';
                } else {
                    html5QrCode.stop().then(() => {
                        cameraStarted = false;
                        document.getElementById('start-scan').innerText = 'Quét bằng Camera';
                    });
                }
            });

            // Xử lý thành công quét mã QR
            function onScanSuccess(decodedText, decodedResult) {
                document.getElementById('qr-reader-results').innerText = `QR Code Đã Quét: ${decodedText}`;
                
                // Tắt camera sau khi quét thành công
                html5QrCode.stop().then(() => {
                    cameraStarted = false;
                    document.getElementById('start-scan').innerText = 'Quét lại';
                }).catch(err => {
                    console.error("Lỗi khi tắt camera: ", err);
                });
            }

            function onScanError(errorMessage) {
                // Không cần hiển thị lỗi mỗi lần không quét được mã
                console.warn("Lỗi quét mã QR: ", errorMessage);
            }

            // Quét mã QR từ tệp tải lên
            document.getElementById('qr-file').addEventListener('change', function(event) {
                const input = event.target;
                if ('files' in input && input.files.length > 0) {
                    const imageFile = input.files[0]; // Lấy đối tượng File từ input
                    html5QrCode = new Html5Qrcode("qr-reader");
                    html5QrCode.scanFile(imageFile, true)
                        .then(decodedText => {
                            document.getElementById('file-reader-results').innerText = `QR Code Đã Quét Từ Ảnh: ${decodedText}`;
                        })
                        .catch(err => {
                            document.getElementById('file-reader-results').innerText = `Lỗi: ${err}`;
                        });
                }
            });
        });
    </script>
</body>
</html>
