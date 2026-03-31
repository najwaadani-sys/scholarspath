<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InfoMHS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-slate: #334155;
            --secondary-slate: #475569;
            --dark-slate: #1e293b;
            --darker-slate: #0f172a;
            --accent-orange: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--darker-slate) 0%, var(--dark-slate) 50%, var(--primary-slate) 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(71, 85, 105, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(30, 41, 59, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Home Button */
        .btn-home {
            color: var(--primary-slate);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-home:hover {
            color: var(--dark-slate);
            text-decoration: underline;
        }

        .btn-home i {
            font-size: 0.9rem;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-wrapper {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(51, 65, 85, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            padding: 3rem;
            background: rgba(30, 41, 59, 0.85);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            margin: 2rem;
        }

        .login-left h1 {
            color: var(--white);
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .login-left .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .login-left .features {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .login-left .features li {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .login-left .features li i {
            margin-right: 0.75rem;
            color: var(--accent-orange);
            font-size: 1.1rem;
        }

        .login-right {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--text-light);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            border: 2px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            padding-left: 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--gray-50);
        }

        .input-group .form-control:focus {
            border-color: var(--primary-slate);
            box-shadow: 0 0 0 3px rgba(51, 65, 85, 0.1);
            background: var(--white);
            outline: none;
        }

        .input-group .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            z-index: 2;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            z-index: 2;
            padding: 0.25rem;
        }

        .password-toggle:hover {
            color: var(--primary-slate);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .forgot-password {
            color: var(--primary-slate);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: var(--dark-slate);
            text-decoration: underline;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-slate) 0%, var(--dark-slate) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(51, 65, 85, 0.3);
            background: linear-gradient(135deg, var(--dark-slate) 0%, var(--darker-slate) 100%);
        }

        .register-link {
            text-align: center;
            color: var(--text-light);
        }

        .register-link a {
            color: var(--primary-slate);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            color: var(--dark-slate);
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-info {
            background: rgba(51, 65, 85, 0.1);
            color: #1e293b;
            border-left: 4px solid #334155;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-slate) 0%, var(--dark-slate) 100%);
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 2rem;
            border: none;
        }

        .modal-title {
            color: var(--white);
            font-weight: 600;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--gray-100);
        }

        /* Modal Register Form Styling */
        .login-link {
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-100);
        }

        .login-link a {
            color: var(--primary-slate);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: var(--dark-slate);
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                margin: 1rem;
            }
            
            .login-left {
                padding: 2rem;
                text-align: center;
                min-height: 300px;
            }

            .login-left-content {
                margin: 1rem;
                padding: 2rem;
            }
            
            .login-left h1 {
                font-size: 2rem;
            }
            
            .login-right {
                padding: 2rem;
            }
            
            .login-header h2 {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        .login-wrapper {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .login-left-content {
            animation: fadeInScale 0.8s ease-out 0.3s both;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .btn-home {
            animation: fadeIn 0.6s ease-out 0.2s both;
        }
    </style>
</head>
<body>
    <!-- Tombol Kembali ke Beranda -->

    <div class="login-container">
        <div class="login-wrapper">
            <!-- Left Side - Image with Overlay -->
            <div class="login-left">
                <div class="login-left-content">
                    <h1><i class="fas fa-graduation-cap"></i> ScholarsPath </h1>
                    <p class="subtitle">Sistem Informasi Mahasiswa Terpadu</p>
                    <ul class="features">
                        <li><i class="fas fa-check-circle"></i> Akses informasi akademik</li>
                        <li><i class="fas fa-check-circle"></i> Beasiswa dan lomba terbaru</li>
                        <li><i class="fas fa-check-circle"></i> Magang dan peluang karir</li>
                        <li><i class="fas fa-check-circle"></i> Komunitas mahasiswa aktif</li>
                    </ul>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-right">
                <div class="login-header">
                    <h2>Selamat Datang!</h2>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i> Berhasil mendaftar! Silakan login.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $_GET['error'] === 'UsernameSudahAda' ? 'Username sudah digunakan.' : 'Username atau password salah!' ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['logout'])): ?>
                    <div class="alert alert-info">
                        <?php if ($_GET['logout'] === 'admin'): ?>
                            <i class="fas fa-user-shield me-2"></i> Admin telah logout.
                        <?php else: ?>
                            <i class="fas fa-user me-2"></i> Anda telah logout.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form id="loginForm" method="POST" action="proses_login.php">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username Anda" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password Anda" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                        </div>
                        <a href="reset_password.php" class="forgot-password btn-reset-password">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Daftar sekarang</a>
                    <div class="mt-2 text-muted">
                        Atau
                    </div>
                    <a href="index.php" class="btn-home">
                        <i class="fas fa-home"></i>
                        <span>Kembali ke beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Daftar Akun Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_register.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="regNama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="regNama" name="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="regUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="regUsername" name="username" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="regEmail" class="form-label">Email (Opsional)</label>
                            <input type="email" class="form-control" id="regEmail" name="email" placeholder="contoh@email.com">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="regPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="regPassword" name="password" required minlength="6">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="role" value="user">
                        
                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </button>
                        </div>

                        <!-- Link ke login -->
                        <div class="login-link">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="#" data-bs-dismiss="modal">Masuk disini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div class="modal fade" id="modalResetPassword" tabindex="-1" aria-labelledby="modalResetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modalResetPasswordContent">
                <!-- Konten reset_password.php akan dimuat di sini -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            icon.classList.toggle('fa-eye-slash');
        }

        // Modal Reset Password AJAX
        $(document).on('click', '.btn-reset-password', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            $('#modalResetPasswordContent').html(`
                <div class="modal-body text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">Memuat...</p>
                </div>
            `);

            $('#modalResetPassword').modal('show');

            $.get(url, function(data) {
                $('#modalResetPasswordContent').html(data);
            }).fail(function() {
                $('#modalResetPasswordContent').html(`
                    <div class="modal-body text-center p-4">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <p>Gagal memuat halaman reset password.</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                `);
            });
        });

        // Form Animation
        $(document).ready(function() {
            $('.form-control').on('focus', function() {
                $(this).parent().addClass('focused');
            });
            
            $('.form-control').on('blur', function() {
                if ($(this).val() === '') {
                    $(this).parent().removeClass('focused');
                }
            });
        });
    </script>
</body>
</html>