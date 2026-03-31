<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        header("Location: loginuser.php?error=UsernameSudahAda");
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO user (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nama, $username, $email, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: loginuser.php?success=1");
        exit;
    } else {
        header("Location: loginuser.php?error=GagalMendaftar");
        exit;
    }
}
?>
