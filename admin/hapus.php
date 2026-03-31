<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($conn, "DELETE FROM info WHERE id = $id");

if ($query) {
    header("Location: dashboard.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
