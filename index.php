<?php 
session_start();
include 'includes/config.php';
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ScholarsPath - Temukan Beasiswa Terbaikmu!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      padding-top: 96px;
      font-family: 'Poppins', sans-serif;
      background-color: #2c3e50;
    }
 
    .hero {
      padding: 0;
      position: relative;
    }

    .carousel-inner img {
      width: 100%;
      height: auto;
      max-height: 550px;
      object-fit: cover;
    }

    .search-form {
      max-width: 600px;
      margin: 30px auto 0;
      position: relative;
      z-index: 3;
    }

    .search-form input,
    .search-form button {
      height: 50px;
      border-radius: 8px;
    }

    /* Enhanced Card Styles with Better Mobile Responsive */
    .card {
      border: none;
      border-radius: 12px;
      background-color: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      transform: translateY(0);
      animation: fadeInUp 0.6s ease-out;
    }

    /* Enhanced Hover Effects */
    .card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      transition: left 0.6s ease;
      z-index: 1;
    }

    .card:hover::before {
      left: 100%;
    }

    .card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 1;
    }

    .card:hover::after {
      opacity: 1;
    }

    /* Card Image Enhanced */
    .card-img-top {
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      height: 180px;
      object-fit: cover;
      transition: transform 0.4s ease;
      position: relative;
      z-index: 2;
    }

    .card:hover .card-img-top {
      transform: scale(1.05);
    }

    /* Card Body Enhanced */
    .card-body {
      position: relative;
      z-index: 2;
      padding: 1.5rem;
      transition: all 0.3s ease;
    }

    .card:hover .card-body {
      transform: translateY(-2px);
    }

    /* Card Title Enhanced */
    .card-title {
      transition: color 0.3s ease;
      position: relative;
    }

    .card:hover .card-title {
      color: #667eea;
    }

    /* Badge Enhanced */
    .badge-custom {
      font-size: 0.75rem;
      padding: 0.4em 0.8em;
      border-radius: 8px;
      color: white;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .badge-custom::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s ease;
    }

    .card:hover .badge-custom::before {
      left: 100%;
    }

    .Beasiswa { background-color: #332D56; }
    .Lomba { background-color: #5459AC; }
    .Magang { background-color: #648DB3; }
    .Seminar { background-color: #129990; }

    /* Button Enhanced */
    .card .btn {
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      z-index: 2;
    }

    .card .btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transition: all 0.4s ease;
      transform: translate(-50%, -50%);
      z-index: -1;
    }

    .card .btn:hover::before {
      width: 300px;
      height: 300px;
    }

    .card .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Enhanced Favorite Button */
    .favorite-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      background: rgba(255, 255, 255, 0.95);
      color: #e74c3c;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      z-index: 10;
      backdrop-filter: blur(10px);
    }

    .favorite-btn:hover {
      background: rgba(255, 255, 255, 1);
      transform: scale(1.15) rotate(5deg);
      box-shadow: 0 8px 25px rgba(231, 76, 60, 0.3);
    }

    .favorite-btn.favorited {
      background: linear-gradient(135deg, #e74c3c, #c0392b);
      color: white;
      animation: heartBeat 0.6s ease-in-out;
    }

    .favorite-btn.favorited:hover {
      background: linear-gradient(135deg, #c0392b, #a93226);
      transform: scale(1.15) rotate(-5deg);
    }

    @keyframes heartBeat {
      0% { transform: scale(1); }
      25% { transform: scale(1.2); }
      50% { transform: scale(1.1); }
      75% { transform: scale(1.15); }
      100% { transform: scale(1); }
    }

    .favorite-notification {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 15px 25px;
      border-radius: 25px;
      z-index: 9999;
      display: none;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      opacity: 0;
    }

    .favorite-notification.error {
      background: rgba(231, 76, 60, 0.9);
    }

    .section-title {
      color: white;
    }

    .content-wrapper {
      min-height: calc(100vh - 200px);
      padding-bottom: 2rem;
    }

    /* Enhanced Statistics Section */
    .statistics-section {
      background: #2c3e50;
      padding: 100px 0;
      margin-top: 60px;
      position: relative;
      overflow: hidden;
    }

    .statistics-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.03)"><polygon points="0,0 1000,0 1000,100 0,100"/></svg>');
      pointer-events: none;
    }

    .stats-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 25px;
      padding: 50px 30px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      transition: all 0.4s ease;
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(15px);
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .stats-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      transition: left 0.5s;
    }

    .stats-card:hover::before {
      left: 100%;
    }

    .stats-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
    }

    .stats-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 25px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }

    .stats-title {
      font-size: 1.4rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 20px;
      letter-spacing: -0.5px;
    }

    .stats-description {
      color: #6c757d;
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 0;
      font-weight: 400;
    }

    /* Enhanced Bottom Stats - FIXED RESPONSIVE */
    .bottom-stats {
      margin-top: 80px;
      padding: 0;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 30px;
      backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .bottom-stats::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }

    .bottom-stat-item {
      text-align: center;
      color: white;
      padding: 40px 15px;
      position: relative;
      transition: all 0.4s ease;
      cursor: pointer;
      border-radius: 20px;
      margin: 15px;
    }

    .bottom-stat-item:hover {
      background: rgba(255, 255, 255, 0.08);
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .bottom-stat-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
      border-radius: 20px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .bottom-stat-item:hover::before {
      opacity: 1;
    }

    .bottom-stat-number {
      display: block;
      font-size: 3.5rem;
      font-weight: 800;
      line-height: 1;
      margin-bottom: 15px;
      background: linear-gradient(135deg, #fff 0%, #e2e8f0 50%, #fff 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
      transition: all 0.3s ease;
      position: relative;
    }

    .bottom-stat-item:hover .bottom-stat-number {
      transform: scale(1.05);
      filter: drop-shadow(0 6px 12px rgba(0,0,0,0.2));
    }

    .bottom-stat-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.85);
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      transition: all 0.3s ease;
    }

    .bottom-stat-item:hover .bottom-stat-label {
      color: rgba(255, 255, 255, 1);
      transform: translateY(-2px);
    }

    .bottom-stat-item::after {
      content: '';
      position: absolute;
      bottom: 15px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 2px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
      border-radius: 1px;
      transition: all 0.3s ease;
    }

    .bottom-stat-item:hover::after {
      width: 70px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
    }

    /* Divider between stats - Desktop */
    .bottom-stat-item:not(:last-child) {
      border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Fix Bootstrap Grid Issues */
    .bottom-stats .row {
      --bs-gutter-x: 0;
      margin: 0;
    }

    .bottom-stats .col-6,
    .bottom-stats .col-md-3 {
      padding-left: 0;
      padding-right: 0;
    }

    /* Card Loading Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Stagger animation for multiple cards */
    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
    .card:nth-child(5) { animation-delay: 0.5s; }
    .card:nth-child(6) { animation-delay: 0.6s; }

    /* Enhanced Text Elements */
    .card .text-muted {
      transition: color 0.3s ease;
    }

    .card:hover .text-muted {
      color: #6c757d !important;
    }

    /* Performance Optimization */
    .card * {
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
    }

    /* Mobile Responsive Improvements */
    @media (max-width: 767.98px) {
      /* Reduce card image height on mobile */
      .card-img-top {
        height: 140px;
      }
      
      /* Reduce card body padding */
      .card-body {
        padding: 1rem;
      }
      
      /* Smaller favorite button on mobile */
      .favorite-btn {
        width: 35px;
        height: 35px;
        font-size: 1rem;
        top: 10px;
        right: 10px;
        min-height: 44px;
        min-width: 44px;
      }
      
      /* Adjust card title font size */
      .card-title {
        font-size: 1rem;
        line-height: 1.3;
      }
      
      /* Smaller badge */
      .badge-custom {
        font-size: 0.7rem;
        padding: 0.3em 0.6em;
      }
      
      /* Adjust button size */
      .card .btn {
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        min-height: 44px;
        min-width: 44px;
      }
      
      /* Reduce hover effects on mobile for better performance */
      .card:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
      }
      
      .card:hover .card-img-top {
        transform: scale(1.02);
      }

      .statistics-section {
        padding: 80px 0;
      }

      .bottom-stats {
        margin-top: 60px;
        border-radius: 25px;
      }

      .bottom-stat-item {
        padding: 35px 15px;
        margin: 12px;
      }

      .bottom-stat-number {
        font-size: 3rem;
      }

      .bottom-stat-label {
        font-size: 0.8rem;
        letter-spacing: 0.8px;
      }

      .stats-card {
        padding: 40px 25px;
        margin-bottom: 30px;
        border-radius: 20px;
      }

      .stats-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        margin-bottom: 20px;
      }

      .stats-title {
        font-size: 1.2rem;
        margin-bottom: 15px;
      }

      .stats-description {
        font-size: 0.9rem;
      }

      /* Remove right border, add bottom border for tablet */
      .bottom-stat-item:not(:last-child) {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .bottom-stat-item:last-child {
        border-bottom: none;
      }
    }

    @media (max-width: 575.98px) {
      /* Even smaller cards on very small screens */
      .card-img-top {
        height: 120px;
      }
      
      .card-body {
        padding: 0.8rem;
      }
      
      .favorite-btn {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
        top: 8px;
        right: 8px;
      }
      
      .card-title {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
      }
      
      .badge-custom {
        font-size: 0.65rem;
        padding: 0.25em 0.5em;
      }
      
      .card .btn {
        font-size: 0.8rem;
        padding: 0.35rem 0.7rem;
      }
      
      /* Minimal hover effects on very small screens */
      .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }
      
      .card:hover .card-img-top {
        transform: none;
      }

      .statistics-section {
        padding: 60px 0;
      }

      .bottom-stats {
        margin-top: 50px;
        padding: 0;
        border-radius: 20px;
      }

      .bottom-stat-item {
        padding: 30px 15px;
        margin: 10px;
      }

      .bottom-stat-number {
        font-size: 2.8rem;
        margin-bottom: 12px;
      }

      .bottom-stat-label {
        font-size: 0.75rem;
        letter-spacing: 0.8px;
      }

      .stats-card {
        padding: 30px 20px;
      }

      /* Stack all stats vertically on mobile */
      .bottom-stats .col-6 {
        flex: 0 0 100%;
        max-width: 100%;
      }

      /* Keep bottom borders for mobile stacked layout */
      .bottom-stat-item:not(:last-child) {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }
    }

    /* Tablet Responsive */
    @media (min-width: 768px) and (max-width: 991.98px) {
      .card-img-top {
        height: 160px;
      }
      
      .card-body {
        padding: 1.25rem;
      }
      
      .favorite-btn {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
      }

      .bottom-stats .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
      }
    }

    /* Large Desktop Enhancements */
    @media (min-width: 1200px) {
      .card-img-top {
        height: 200px;
      }
      
      .card-body {
        padding: 1.75rem;
      }
      
      .favorite-btn {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
      }
      
      .card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.18);
      }

      .bottom-stats {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
      }

      .bottom-stat-number {
        font-size: 4rem;
      }

      .bottom-stat-label {
        font-size: 0.9rem;
      }
    }

    /* Small Mobile */
    @media (max-width: 374.98px) {
      .bottom-stat-item {
        padding: 20px 8px;
        margin: 6px;
      }

      .bottom-stat-number {
        font-size: 1.8rem;
      }

      .bottom-stat-label {
        font-size: 0.65rem;
      }

      .bottom-stat-item::after {
        width: 40px;
      }

      .bottom-stat-item:hover::after {
        width: 55px;
      }

      .stats-card {
        padding: 25px 15px;
      }
    }

    /* Dark mode support (optional) */
    @media (prefers-color-scheme: dark) {
      .card {
        background-color: rgba(255, 255, 255, 0.95);
      }
      
      .card::after {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
      }
    }
  </style>
</head>
<body>

<div class="content-wrapper">
  <!-- Hero Section -->
  <section class="hero">
    <div id="carouselHero" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active"><img src="assets/slider1.jpg" class="d-block w-100" alt="slider1"></div>
        <div class="carousel-item"><img src="assets/slider2.jpg" class="d-block w-100" alt="slider2"></div>
        <div class="carousel-item"><img src="assets/slider3.jpg" class="d-block w-100" alt="slider3"></div>
        <div class="carousel-item"><img src="assets/slider4.jpg" class="d-block w-100" alt="slider4"></div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselHero" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselHero" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <div class="container">
      <form action="cari.php" method="get" class="search-form d-flex">
        <input type="text" name="q" class="form-control me-2" placeholder="Cari info beasiswa, lomba, magang...">
        <button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </section>

  <!-- Kategori Sections -->
  <?php
  $kategori_list = ['Beasiswa', 'Lomba', 'Magang', 'Seminar'];
  foreach ($kategori_list as $kategori):
  $query = mysqli_query($conn, "SELECT * FROM info WHERE kategori='".mysqli_real_escape_string($conn, $kategori)."' ORDER BY tanggal_post DESC LIMIT 3");  ?>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title"><?= $kategori; ?> Terbaru</h4>
        <a href="kategori.php?k=<?= $kategori; ?>" class="btn btn-outline-light btn-sm">Lihat Semua</a>
      </div>
      <div class="row g-4">
        <?php if (mysqli_num_rows($query) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="col-md-4">
              <div class="card h-100">
                <!-- Favorite Button -->
                <?php if (isset($_SESSION['username'])): ?>
                  <button class="favorite-btn" onclick="toggleFavorite(<?= $row['id']; ?>, this)" title="Tambah ke Favorit" data-item-id="<?= $row['id']; ?>">
                    <i class="fas fa-heart"></i>
                  </button>
                <?php else: ?>
                  <button class="favorite-btn" onclick="showLoginAlert()" title="Login untuk menambahkan favorit">
                    <i class="fas fa-heart"></i>
                  </button>
                <?php endif; ?>
                
                <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']); ?>">
                <div class="card-body">
                  <h5 class="card-title fw-semibold mb-1"><?= htmlspecialchars($row['judul']); ?></h5>
                  <small class="text-muted">Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?></small>
                  <div class="mt-2">
                    <span class="badge badge-custom <?= $row['kategori']; ?>"><?= $row['kategori']; ?></span>
                  </div>
                  <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail</a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle me-2"></i>
              Belum ada data <?= strtolower($kategori); ?> terbaru.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Enhanced Statistics Section -->
  <section class="statistics-section">
    <div class="container">
      <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
          <div class="stats-card">
            <div class="stats-icon icon-scholarship">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <h4 class="stats-title">Beasiswa Terlengkap</h4>
            <p class="stats-description">Temukan berbagai pilihan beasiswa dari dalam dan luar negeri yang sesuai dengan minat dan kemampuan Anda.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="stats-card">
            <div class="stats-icon icon-competition">
              <i class="fas fa-trophy"></i>
            </div>
            <h4 class="stats-title">Kompetisi Bergengsi</h4>
            <p class="stats-description">Ikuti lomba dan kompetisi nasional maupun internasional untuk mengasah kemampuan dan meraih prestasi.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="stats-card">
            <div class="stats-icon icon-internship">
              <i class="fas fa-briefcase"></i>
            </div>
            <h4 class="stats-title">Peluang Karir</h4>
            <p class="stats-description">Dapatkan pengalaman berharga melalui program magang dan seminar dari perusahaan terkemuka.</p>
          </div>
        </div>
      </div>

      <div class="bottom-stats">
        <div class="row">
          <div class="col-6 col-md-3">
            <div class="bottom-stat-item">
              <span class="bottom-stat-number">1000+</span>
              <div class="bottom-stat-label">Peluang Tersedia</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bottom-stat-item">
              <span class="bottom-stat-number">500+</span>
              <div class="bottom-stat-label">Pengguna Aktif</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bottom-stat-item">
              <span class="bottom-stat-number">50+</span>
              <div class="bottom-stat-label">Partner Terpercaya</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="bottom-stat-item">
              <span class="bottom-stat-number">24/7</span>
              <div class="bottom-stat-label">Update Informasi</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Favorite Notification -->
<div id="favoriteNotification" class="favorite-notification">
  <span id="favoriteMessage"></span>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Favorite functionality
function toggleFavorite(itemId, button) {
  // Tampilkan indikator loading
  const originalIcon = button.innerHTML;
  button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
  button.disabled = true;

  // Kirim permintaan AJAX ke server
  fetch('add_favorite.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `info_id=${itemId}&action=${button.classList.contains('favorited') ? 'remove' : 'add'}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Update tampilan tombol
      if (data.action === 'add') {
        button.classList.add('favorited');
        button.title = 'Hapus dari Favorit';
        showNotification('<i class="fas fa-heart me-2"></i>Ditambahkan ke favorit');
      } else {
        button.classList.remove('favorited');
        button.title = 'Tambah ke Favorit';
        showNotification('<i class="fas fa-heart-broken me-2"></i>Dihapus dari favorit');
      }
    } else {
      showNotification(`<i class="fas fa-exclamation-circle me-2"></i>${data.message}`, true);
    }
  })
  .catch(error => {
    showNotification('<i class="fas fa-exclamation-circle me-2"></i>Gagal menyimpan favorit', true);
    console.error('Error:', error);
  })
  .finally(() => {
    button.innerHTML = originalIcon;
    button.disabled = false;
  });
}

// Show login alert when not logged in
function showLoginAlert() {
  showNotification('<i class="fas fa-exclamation-circle me-2"></i>Silakan login terlebih dahulu', true);
  
  // Redirect to login page after 3 seconds
  setTimeout(() => {
    window.location.href = 'loginuser.php';
  }, 50);
}

// Load favorites on page load
document.addEventListener('DOMContentLoaded', function() {
  // Ambil data favorit dari server untuk user yang login
  <?php if (isset($_SESSION['user_id'])): ?>
    fetch('get_favorites.php')
      .then(response => response.json())
      .then(favorites => {
        // Mark favorited items
        document.querySelectorAll('.favorite-btn').forEach(button => {
          const itemId = parseInt(button.getAttribute('data-item-id'));
          if (favorites.includes(itemId)) {
            button.classList.add('favorited');
            button.title = 'Hapus dari Favorit';
          }
        });
      })
      .catch(error => {
        console.error('Error loading favorites:', error);
      });
  <?php endif; ?>
});

// Show notification function
function showNotification(message, isError = false) {
  const notification = document.getElementById('favoriteNotification');
  const messageElement = document.getElementById('favoriteMessage');
  
  messageElement.innerHTML = message;
  notification.className = isError ? 'favorite-notification error' : 'favorite-notification';
  notification.style.display = 'block';
  notification.style.opacity = '1';
  
  setTimeout(() => {
    notification.style.opacity = '0';
    setTimeout(() => {
      notification.style.display = 'none';
    }, 300);
  }, isError ? 3000 : 2000);
}
</script>

</body>
</html>