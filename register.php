<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    // Cek apakah username sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO user (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $email, $password, $role);
        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($conn);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Arahkan ke dashboard sesuai role
            if ($role === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Gagal mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - InfoMHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
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
                radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .register-container {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }
        
        .card-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            border: none;
        }
        
        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .card-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin: 0;
        }
        
        .card-body {
            padding: 2.5rem;
            position: relative;
            z-index: 1;
        }
        
        .form-label {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control, .form-select {
            border-radius: 16px;
            border: 2px solid rgba(59, 130, 246, 0.1);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            margin-bottom: 1.5rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }
        
        .form-control::placeholder {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
        .btn {
            border-radius: 16px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            width: 100%;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            margin-bottom: 1rem;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
        }
        
        .btn-outline-secondary {
            background: transparent;
            color: #64748b;
            border: 2px solid rgba(100, 116, 139, 0.3);
            box-shadow: none;
        }
        
        .btn-outline-secondary:hover {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            border-color: #64748b;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(100, 116, 139, 0.3);
        }
        
        .alert {
            border-radius: 16px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        
        .login-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(226, 232, 240, 0.5);
        }
        
        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .login-link a:hover {
            color: #2563eb;
            text-decoration: none;
        }
        
        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: width 0.3s ease;
        }
        
        .login-link a:hover::after {
            width: 100%;
        }
        
        .role-selection {
            background: rgba(248, 250, 252, 0.5);
            border-radius: 16px;
            padding: 1.5rem;
            border: 2px solid rgba(59, 130, 246, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .role-selection h6 {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .role-option {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .role-option:hover {
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.1);
        }
        
        .role-option input[type="radio"] {
            margin-right: 0.75rem;
            transform: scale(1.2);
        }
        
        .role-option label {
            font-weight: 500;
            color: #1e293b;
            margin: 0;
            cursor: pointer;
            flex: 1;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .register-container {
            animation: float 6s ease-in-out infinite;
        }
        
        @media (max-width: 768px) {
            .register-container {
                max-width: 95%;
                padding: 1rem;
                animation: none;
            }
            
            .card-header {
                padding: 1.5rem;
            }
            
            .card-header h1 {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <h1>Daftar Akun Baru</h1>
                <p>Bergabunglah dengan InfoMHS untuk mendapatkan informasi terkini</p>
            </div>
            
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert">
                        <strong>Error!</strong> <?= $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Pilih username unik" required>
                        </div>
                    </div>
                    
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="contoh@email.com">
                    
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
                    
                    <div class="role-selection">
                        <h6>Pilih Tipe Akun</h6>
                        <div class="role-option">
                            <input type="radio" id="user" name="role" value="user" checked>
                            <label for="user">
                                <strong>Mahasiswa</strong><br>
                                <small class="text-muted">Akses untuk melihat informasi beasiswa, lomba, dan kegiatan</small>
                            </label>
                        </div>
                        <div class="role-option">
                            <input type="radio" id="admin" name="role" value="admin">
                            <label for="admin">
                                <strong>Administrator</strong><br>
                                <small class="text-muted">Akses penuh untuk mengelola semua informasi</small>
                            </label>
                        </div>
                    </div>
                    
                                    <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Daftar
                    </button>
                </div>
                <div class="login-link text-center">
                <span class="text-muted">Sudah punya akun? <a href="loginuser.php" class="text-primary">Masuk disini</a></span>
                <div class="my-2 fw-semibold">atau</div>
                <a href="index.php" class="text-decoration-none text-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>