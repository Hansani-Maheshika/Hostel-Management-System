<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.8)),
                        url('img2.avif') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            padding: 2rem;
        }

        .logo-container {
            margin-bottom: 2rem;
            animation: fadeInDown 1s ease-out;
        }

        .logo {
            font-size: 4rem;
            color: #fff;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .login-buttons {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.9s both;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            min-width: 180px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .login-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .login-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .login-card h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .admin-card {
            border-top: 4px solid var(--accent-color);
        }

        .admin-card i {
            color: var(--accent-color);
        }

        .warden-card {
            border-top: 4px solid var(--success-color);
        }

        .warden-card i {
            color: var(--success-color);
        }

        .student-card {
            border-top: 4px solid var(--warning-color);
        }

        .student-card i {
            color: var(--warning-color);
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .footer-info {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            opacity: 0.8;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.1rem;
            }
            
            .login-buttons {
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }
            
            .login-card {
                min-width: 250px;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 1rem;
            }
            
            .main-title {
                font-size: 2rem;
            }
            
            .logo {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="floating-elements">
            <i class="fas fa-building floating-element" style="font-size: 4rem;"></i>
            <i class="fas fa-users floating-element" style="font-size: 3rem;"></i>
            <i class="fas fa-bed floating-element" style="font-size: 3.5rem;"></i>
        </div>

        <div class="hero-content">
            <div class="logo-container">
                <i class="fas fa-home logo"></i>
            </div>
            
            <h1 class="main-title">Hostel Management System</h1>
            <p class="subtitle">Streamlined accommodation management for modern hostels</p>
            
            <div class="login-buttons">
                <a href="login_admin.php" class="login-card admin-card">
                    <i class="fas fa-user-shield"></i>
                    <h3>Administrator</h3>
                </a>
                
                <a href="login_warden.php" class="login-card warden-card">
                    <i class="fas fa-user-tie"></i>
                    <h3>Warden</h3>
                </a>
                
                <a href="login_student.php" class="login-card student-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Student</h3>
                </a>
            </div>
        </div>

        <div class="footer-info">
            <p><i class="fas fa-shield-alt"></i> Secure • Reliable • Efficient</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>