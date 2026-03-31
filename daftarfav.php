<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginuser.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT info.* FROM favorit 
          JOIN info ON favorit.info_id = info.id 
          WHERE favorit.user_id = $user_id ORDER BY favorit.created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Favorit Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3 class="mb-4">Daftar Favorit Saya</h3>
    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top" alt="poster">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['judul']; ?></h5>
                        <small><?= $row['kategori']; ?> | Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?></small>
                        <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary btn-sm d-block mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
