<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginuser.php");
    exit;
}
include '../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = mysqli_query($conn, "SELECT * FROM info WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = $_POST['kategori'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $deadline = $_POST['deadline'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$gambar");
    } else {
        $gambar = $data['gambar'];
    }

    $update = mysqli_query($conn, "UPDATE info SET 
        judul = '$judul', 
        kategori = '$kategori', 
        deskripsi = '$deskripsi', 
        link = '$link', 
        deadline = '$deadline', 
        gambar = '$gambar' 
        WHERE id = $id");

    if ($update) {
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            padding: 2rem;
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
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .container {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 24px;
            pointer-events: none;
        }
        
        h3 {
            background: linear-gradient(135deg, #1e293b, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }
        
        h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
        }
        
        .form-label {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            display: block;
            position: relative;
            padding-left: 1rem;
        }
        
        .form-label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 16px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
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
        
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
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
            margin: 0.5rem;
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
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #64748b, #475569);
            color: white;
            box-shadow: 0 8px 25px rgba(100, 116, 139, 0.3);
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #475569, #334155);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(100, 116, 139, 0.4);
        }
        
        .alert {
            border-radius: 16px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        
        .current-image-container {
            background: rgba(248, 250, 252, 0.5);
            border-radius: 16px;
            padding: 1.5rem;
            margin: 1rem 0;
            border: 2px dashed rgba(59, 130, 246, 0.2);
            text-align: center;
        }
        
        .current-image-container img {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .current-image-container img:hover {
            transform: scale(1.05);
        }
        
        .current-image-label {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
        }
        
        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }
        
        .form-group::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.2), transparent);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .container {
            animation: float 6s ease-in-out infinite;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 2rem;
                animation: none;
            }
            
            h3 {
                font-size: 1.6rem;
            }
            
            .btn {
                width: 100%;
                margin: 0.5rem 0;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h3>✏️ Edit Informasi</h3>

    <?php if (!$data): ?>
        <div class="alert alert-danger">
            <strong>❌ Oops!</strong> Data yang Anda cari tidak ditemukan!
        </div>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']); ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">🏷️ Kategori</label>
            <select name="kategori" class="form-select" required>
                <option value="Beasiswa" <?= $data['kategori'] == 'Beasiswa' ? 'selected' : '' ?>>Beasiswa</option>
                <option value="Lomba" <?= $data['kategori'] == 'Lomba' ? 'selected' : '' ?>>Lomba</option>
                <option value="Magang" <?= $data['kategori'] == 'Magang' ? 'selected' : '' ?>>Magang</option>
                <option value="Seminar" <?= $data['kategori'] == 'Seminar' ? 'selected' : '' ?>>Seminar</option>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Masukkan deskripsi lengkap..."><?= htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">🔗 Link Pendaftaran</label>
            <input type="url" name="link" class="form-control" value="<?= htmlspecialchars($data['link']); ?>" placeholder="https://...">
        </div>
        
        <div class="form-group">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control" value="<?= $data['deadline']; ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Gambar</label>
            <div class="current-image-container">
                <div class="current-image-label">Gambar Saat Ini:</div>
                <img src="../uploads/<?= $data['gambar']; ?>" width="200" class="mb-3 rounded">
                <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
                    Upload gambar baru jika ingin mengganti (opsional)
                </div>
                <input type="file" name="gambar" class="form-control" style="margin-bottom: 0;">
            </div>
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
    <?php endif; ?>
</div>
</body>
</html>