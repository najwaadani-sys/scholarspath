<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../includes/config.php';

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = $_POST['kategori'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $deadline = $_POST['deadline'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $lokasi = "../uploads/" . $gambar;
    move_uploaded_file($tmp, $lokasi);

    $sql = "INSERT INTO info (judul, kategori, deskripsi, link, deadline, gambar) 
            VALUES ('$judul', '$kategori', '$deskripsi', '$link', '$deadline', '$gambar')";
    if (mysqli_query($conn, $sql)) {
        $pesan = "Info berhasil ditambahkan!";
    } else {
        $pesan = "Gagal menambahkan info.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Info Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f9f8;
        }
        .container {
            max-width: 720px;
            margin: 40px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="mb-4">📝 Tambah Info Baru</h3>
    <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-select" required>
                <option value="Beasiswa">Beasiswa</option>
                <option value="Lomba">Lomba</option>
                <option value="Magang">Magang</option>
                <option value="Seminar">Seminar</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Link Pendaftaran</label>
            <input type="url" name="link" class="form-control">
        </div>
        <div class="mb-3">
            <label>Deadline</label>
            <input type="date" name="deadline" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar Poster</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Info</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
</body>
</html>
