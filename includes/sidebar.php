<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | ScholarsPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }
    .sidebar {
      height: 100vh;
      background-color: #2c3e50;
      padding: 2rem 1rem;
      color: white;
      position: fixed;
      width: 250px;
    }
    .sidebar a {
      color: white;
      display: block;
      margin-bottom: 1rem;
      text-decoration: none;
    }
    .sidebar a:hover {
      text-decoration: underline;
    }
    .content {
      margin-left: 260px;
      padding: 2rem;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h4 class="mb-4">👤 <?= $_SESSION['nama']; ?></h4>
    <a href="dashboard.php">Edit Profil</a>
    <a href="favorit.php">Favorit</a>
    <a href="dashboard.php#riwayat">Riwayat Aktivitas</a>
    <a href="logoutuser.php">Logout</a>
  </div>
</body>