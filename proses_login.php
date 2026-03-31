<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        header("Location: loginuser.php?error=1");
        exit;
    }

    // Ambil user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verifikasi password
        $db_password = $user['password'];
        $isHashed = strlen($db_password) > 20 && preg_match('/^\$2[ayb]\$/', $db_password);
        $passwordValid = $isHashed ? password_verify($password, $db_password) : $password === $db_password;

        if ($passwordValid) {
            // Simpan session
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            $_SESSION['nama']     = $user['nama'];

            // Arahkan sesuai role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }

    // Jika gagal login
    header("Location: loginuser.php?error=1");
    exit;
}
?>
