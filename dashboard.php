<?php
session_start();
include 'includes/config.php';
include 'auth_check.php';
checkRole('user'); // Hanya user yang bisa akses
?>

<?php
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: loginuser.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user dengan prepared statement untuk keamanan
$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Jika user tidak ditemukan, redirect ke login
if (!$user) {
    session_destroy();
    header("Location: loginuser.php");
    exit;
}

// Proses update profil jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $minat = isset($_POST['minat']) && is_array($_POST['minat']) ? implode(',', $_POST['minat']) : '';
}
    // Validasi input
    if (empty($nama) || empty($email)) {
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format email tidak valid!";
    } else {
        // Cek apakah kolom minat ada di tabel
        $check_column = mysqli_query($conn, "SHOW COLUMNS FROM user LIKE 'minat'");
        
        if (mysqli_num_rows($check_column) > 0) {
            // Jika kolom minat ada, update dengan minat
            $stmt = mysqli_prepare($conn, "UPDATE user SET nama = ?, email = ?, minat = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $minat, $user_id);
        } else {
            // Jika kolom minat tidak ada, update tanpa minat
            $stmt = mysqli_prepare($conn, "UPDATE user SET nama = ?, email = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $nama, $email, $user_id);
        }
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['nama'] = $nama;
            header("Location: dashboard.php"); // reload agar rekomendasi langsung muncul
            exit;
        } else {
            $error_message = "Gagal memperbarui profil!";
        }

}

// Ambil minat yang dipilih user
$minat_terpilih = isset($user['minat']) && !empty($user['minat']) ? explode(',', $user['minat']) : [];
$opsi_kategori = ['Beasiswa', 'Lomba', 'Magang', 'Seminar'];

// Ambil rekomendasi berdasarkan minat
$rekomendasi = false;
if (!empty($minat_terpilih)) {
    // Cek apakah tabel info ada
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'info'");
    if (mysqli_num_rows($check_table) > 0) {
        $placeholders = str_repeat('?,', count($minat_terpilih) - 1) . '?';
        $stmt = mysqli_prepare($conn, "SELECT * FROM info WHERE kategori IN ($placeholders) ORDER BY tanggal_post DESC LIMIT 6");
        
        if ($stmt) {
            $types = str_repeat('s', count($minat_terpilih));
            mysqli_stmt_bind_param($stmt, $types, ...$minat_terpilih);
            mysqli_stmt_execute($stmt);
            $rekomendasi = mysqli_stmt_get_result($stmt);
        }
    }
}

// Ambil riwayat aktivitas
$riwayat = false;
$check_riwayat = mysqli_query($conn, "SHOW TABLES LIKE 'riwayat'");
if (mysqli_num_rows($check_riwayat) > 0) {
    $stmt = mysqli_prepare($conn, "SELECT info.* FROM riwayat JOIN info ON riwayat.info_id = info.id WHERE riwayat.user_id = ? ORDER BY riwayat.tanggal DESC");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $riwayat = mysqli_stmt_get_result($stmt);
    }
}

// Cek apakah user sedang mengedit profil
$editProfil = isset($_GET['edit']) && $_GET['edit'] == '1';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= htmlspecialchars($user['nama'] ?? 'User'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0px, 0px) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            z-index: 1000;
            padding-top: 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar .user-info {
            text-align: center;
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            position: relative;
        }
        
        .sidebar .user-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #4282AA);
            border-radius: 1px;
        }
        
        .sidebar .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4282AA);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto 15px;
            font-size: 28px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .sidebar .user-avatar:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
        }
        
        .sidebar .user-info h6 {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #f8fafc;
        }
        
        .sidebar .user-info small {
            color: #94a3b8;
            font-size: 0.85rem;
        }
        
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 15px 25px;
            border-radius: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            margin: 2px 0;
            font-weight: 500;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            transition: width 0.3s ease;
            z-index: -1;
        }
        
        .sidebar .nav-link:hover::before {
            width: 100%;
        }
        
        .sidebar .nav-link:hover {
            color: #f8fafc;
            border-left-color: #3b82f6;
            transform: translateX(10px);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
            color: #f8fafc;
            border-left-color: #3b82f6;
            box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.1);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card {
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }
        
        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: all 0.4s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.1);
        }
        
        .welcome-card {
            background: linear-gradient(135deg,  
                #4282AA 50%,
                #FFEDA2 100%);
            color: white;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 150%;
            height: 150%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        }
        
        .welcome-card .card-body {
            position: relative;
            z-index: 2;
            padding: 40px;
        }
        
        .welcome-card h2 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .section-title i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .badge {
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge.bg-primary {
            background: linear-gradient(135deg, #4282AA, #FFEDA2) !important;
            border: none;
        }
        
        .badge.bg-secondary {
            background: linear-gradient(135deg, #64748b, #475569) !important;
            border: none;
        }
        
        .btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4282AA);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #4282AA);
        }
        
        .btn-outline-primary {
            border: 2px solid;
            border-image: linear-gradient(135deg, #4282AA, #FFEDA2) 1;
            background: transparent;
            color: #3b82f6;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
        }
        
        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn-light:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }
        
        .alert {
            border: none;
            border-radius: 15px;
            padding: 20px 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.9), rgba(21, 128, 61, 0.9));
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(185, 28, 28, 0.9));
            color: white;
        }
        
        .no-content {
            text-align: center;
            padding: 60px 40px;
            color: #64748b;
        }
        
        .no-content i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.6;
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .no-content h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: #1e293b;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            padding: 12px 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
            background: rgba(255, 255, 255, 1);
        }
        
        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .welcome-card h2 {
                font-size: 1.8rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }
        
        .mobile-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: none;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .mobile-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        
        /* Loading animation for cards */
        .card {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(6) { animation-delay: 0.6s; }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Glassmorphism effect for form */
        .card-header {
            background: linear-gradient(135deg, #4282AA, #FFEDA2) !important;
            backdrop-filter: blur(20px);
            border: none !important;
            color: white;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #4282AA, #FFEDA2);
        }
    </style>
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h6 class="mb-0"><?= htmlspecialchars($user['nama']); ?></h6>
            <small><?= htmlspecialchars($user['email']); ?></small>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="nav-link" href="?edit=1">
                <i class="fas fa-user-edit"></i> Edit Profil
            </a>
            <a class="nav-link" href="#riwayat">
                <i class="fas fa-history"></i> Riwayat Aktivitas
            </a>
            <a class="nav-link" href="favorit.php">
                <i class="fas fa-heart"></i> Favorit
            </a>
            <a class="nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Alert Messages -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Card -->
        <div class="card welcome-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Selamat Datang, <?= htmlspecialchars($user['nama']); ?>!</h2>
                        <p class="mb-0 opacity-75">Temukan peluang terbaik untuk masa depan Anda</p>
                    </div>
                    <?php if (!$editProfil): ?>
                        <a href="?edit=1" class="btn btn-light">
                            <i class="fas fa-edit me-1"></i> Edit Profil
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form edit profil -->
        <?php if ($editProfil): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profil</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" class="form-control" 
                                       value="<?= htmlspecialchars($user['nama']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minat/Kategori</label>
                            <div class="row">
                                <?php foreach ($opsi_kategori as $kategori): ?>
                                    <div class="col-md-3 col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="minat[]" value="<?= htmlspecialchars($kategori); ?>" 
                                                   id="minat_<?= htmlspecialchars($kategori); ?>"
                                                   <?= in_array($kategori, $minat_terpilih) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="minat_<?= htmlspecialchars($kategori); ?>">
                                                <?= htmlspecialchars($kategori); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Rekomendasi Section -->
        <div class="mb-5">
            <h3 class="section-title">
                <i class="fas fa-star text-warning"></i>
                Rekomendasi Untuk Anda
            </h3>
            <?php if ($rekomendasi && mysqli_num_rows($rekomendasi) > 0): ?>
                <div class="row g-4">
                    <?php while ($row = mysqli_fetch_assoc($rekomendasi)): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <?php if (!empty($row['gambar']) && file_exists("uploads/" . $row['gambar'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                                         class="card-img-top" alt="<?= htmlspecialchars($row['judul']); ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                         style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); height: 220px;">
                                        <i class="fas fa-image text-white" style="font-size: 3rem; opacity: 0.7;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold mb-2">
                                        <?= htmlspecialchars($row['judul']); ?>
                                    </h5>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?>
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge bg-primary">
                                            <?= htmlspecialchars($row['kategori']); ?>
                                        </span>
                                    </div>
                                    <div class="mt-auto">
                                        <a href="detail.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body no-content">
                        <i class="fas fa-lightbulb"></i>
                        <h5>Belum Ada Rekomendasi</h5>
                        <?php if (empty($minat_terpilih)): ?>
                            <p>Silakan edit profil dan pilih minat Anda untuk mendapatkan rekomendasi yang sesuai.</p>
                            <a href="?edit=1" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit Profil Sekarang
                            </a>
                        <?php else: ?>
                            <p>Belum ada informasi yang sesuai dengan minat Anda saat ini. Coba lagi nanti!</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Riwayat Section -->
        <div id="riwayat">
            <h3 class="section-title">
                <i class="fas fa-history text-info"></i>
                Riwayat Aktivitas
            </h3>
            <?php if ($riwayat && mysqli_num_rows($riwayat) > 0): ?>
                <div class="row g-4">
                    <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <?php if (!empty($row['gambar']) && file_exists("uploads/" . $row['gambar'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                                         class="card-img-top" alt="<?= htmlspecialchars($row['judul']); ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center" 
                                         style="background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); height: 220px;">
                                        <i class="fas fa-image text-white" style="font-size: 3rem; opacity: 0.7;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold mb-2">
                                        <?= htmlspecialchars($row['judul']); ?>
                                    </h5>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?>
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($row['kategori']); ?>
                                        </span>
                                    </div>
                                    <div class="mt-auto">
                                        <a href="detail.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i> Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-body no-content">
                        <i class="fas fa-clipboard-list"></i>
                        <h5>Belum Ada Riwayat</h5>
                        <p>Mulai jelajahi informasi untuk melihat riwayat aktivitas Anda di sini.</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Jelajahi Sekarang
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation on page load
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>