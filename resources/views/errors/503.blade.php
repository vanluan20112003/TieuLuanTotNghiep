<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảo trì hệ thống</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #1a1a1a, #2c3e50);
            font-family: Arial, sans-serif;
            color: #fff;
            overflow: hidden;
        }

        .container {
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .gear {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: #e74c3c;
            border-radius: 50%;
            animation: rotate 10s linear infinite;
        }

        .gear::before {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            background: #1a1a1a;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .gear::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            background: conic-gradient(from 0deg,
                transparent 0deg 15deg,
                #e74c3c 15deg 45deg,
                transparent 45deg 75deg,
                #e74c3c 75deg 105deg,
                transparent 105deg 135deg,
                #e74c3c 135deg 165deg,
                transparent 165deg 195deg,
                #e74c3c 195deg 225deg,
                transparent 225deg 255deg,
                #e74c3c 255deg 285deg,
                transparent 285deg 315deg,
                #e74c3c 315deg 345deg,
                transparent 345deg 360deg
            );
            border-radius: 50%;
        }

        .small-gear {
            position: absolute;
            width: 60px;
            height: 60px;
            background: #3498db;
            border-radius: 50%;
            animation: rotate-reverse 7s linear infinite;
        }

        .small-gear.left {
            top: 30%;
            left: 20%;
        }

        .small-gear.right {
            bottom: 30%;
            right: 20%;
        }

        .small-gear::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #1a1a1a;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .small-gear::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background: conic-gradient(from 0deg,
                transparent 0deg 15deg,
                #3498db 15deg 45deg,
                transparent 45deg 75deg,
                #3498db 75deg 105deg,
                transparent 105deg 135deg,
                #3498db 135deg 165deg,
                transparent 165deg 195deg,
                #3498db 195deg 225deg,
                transparent 225deg 255deg,
                #3498db 255deg 285deg,
                transparent 285deg 315deg,
                #3498db 315deg 345deg,
                transparent 345deg 360deg
            );
            border-radius: 50%;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #e74c3c;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #ecf0f1;
        }

        .status {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(231, 76, 60, 0.2);
            border: 2px solid #e74c3c;
            border-radius: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotate-reverse {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="particles">
        <script>
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                document.querySelector('.particles').appendChild(particle);
            }
        </script>
    </div>
    <div class="container">
        <div class="gear"></div>
        <div class="small-gear left"></div>
        <div class="small-gear right"></div>
        <h1>503 - Hệ thống đang bảo trì</h1>
        <p>Chúng tôi đang nâng cấp hệ thống để mang đến trải nghiệm tốt hơn.</p>
        <div class="status">Vui lòng quay lại sau!</div>
    </div>
</body>
</html>