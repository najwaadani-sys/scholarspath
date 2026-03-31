<?php
session_start();
include 'includes/config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

// Validasi input
if (!isset($_POST['info_id']) || !is_numeric($_POST['info_id'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
    exit;
}

$user_id = $_SESSION['user_id'];
$info_id = (int)$_POST['info_id'];
$action = $_POST['action'] ?? 'add';

try {
    if ($action === 'add') {
        // Cek apakah sudah ada di favorit
        $check = mysqli_query($conn, "SELECT * FROM favorit WHERE user_id = $user_id AND info_id = $info_id");
        
        if (mysqli_num_rows($check) > 0) {
            echo json_encode(['success' => false, 'message' => 'Sudah ada di favorit']);
            exit;
        }
        
        // Tambahkan ke favorit
        $query = "INSERT INTO favorit (user_id, info_id) VALUES ($user_id, $info_id)";
        mysqli_query($conn, $query);
        
        echo json_encode(['success' => true, 'action' => 'add']);
    } else {
        // Hapus dari favorit
        $query = "DELETE FROM favorit WHERE user_id = $user_id AND info_id = $info_id";
        mysqli_query($conn, $query);
        
        echo json_encode(['success' => true, 'action' => 'remove']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem']);
}