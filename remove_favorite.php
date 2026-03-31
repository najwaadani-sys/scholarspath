<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
    exit;
}

if (!isset($_POST['info_id']) || empty($_POST['info_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID informasi tidak valid']);
    exit;
}

$user_id = $_SESSION['user_id'];
$info_id = intval($_POST['info_id']);

// Hapus dari tabel favorit
$query = "DELETE FROM favorit WHERE user_id = ? AND info_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $info_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Berhasil menghapus dari favorit']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus dari favorit']);
}

mysqli_stmt_close($stmt);
?>