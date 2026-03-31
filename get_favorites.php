<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil daftar favorit user
$query = "SELECT info_id FROM favorit WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

$favorites = [];
while ($row = mysqli_fetch_assoc($result)) {
    $favorites[] = $row['info_id'];
}

echo json_encode($favorites);