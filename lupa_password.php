<?php
// lupa_password.php
session_start();
include 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit;
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
<div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
    <h4 class="mb-3 text-center">Lupa Password</h4>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center"> <?= $error; ?> </div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Masukkan Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Lanjut</button>
        <p class="mt-3 text-center"><a href="loginuser.php">Kembali ke Login</a></p>
    </form>
</div>
</body>
</html>
