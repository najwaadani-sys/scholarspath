<?php
session_start();
include 'includes/config.php';
include 'includes/navbar.php';

if (!isset($_GET['id'])) {
    echo "<p class='text-danger text-center mt-5'>Info tidak ditemukan.</p>";
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM info WHERE id = $id");
$info = mysqli_fetch_assoc($result);

if (!$info) {
    echo "<p class='text-danger text-center mt-5'>Info tidak ditemukan.</p>";
    exit;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    mysqli_query($conn, "INSERT INTO riwayat (user_id, info_id, tanggal) VALUES ($user_id, $id, NOW())");
}

$rekomendasi = mysqli_query($conn, "SELECT * FROM info WHERE id != $id ORDER BY RAND() LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title><?= $info['judul']; ?> | ScholarsPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/footer.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #2c3e50;
      color: #fff;
      padding-top: 96px;
    }

    .container {
      padding-top: 4rem;
    }

    .card-detail {
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      color: #2c3e50;
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
      border: 1px solid rgba(26,188,156,0.1);
      position: relative;
      overflow: hidden;
    }

    /* Favorite Button Styles */
    .favorite-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      background: rgba(255, 255, 255, 0.9);
      color: #e74c3c;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      z-index: 10;
    }

    .favorite-btn:hover {
      background: rgba(255, 255, 255, 1);
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .favorite-btn.favorited {
      background: #e74c3c;
      color: white;
    }

    .favorite-btn.favorited:hover {
      background: #c0392b;
    }

    /* Favorite notification */
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

    .card-detail::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #648DB3, #332D56, #129990, #5459AC);
      z-index: 1;
    }

    .card-detail h3 {
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
      line-height: 1.3;
    }

    .badge-custom {
      padding: 0.6em 1.2em;
      font-size: 0.85rem;
      border-radius: 25px;
      color: #fff;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.2);
      border: 2px solid rgba(255,255,255,0.3);
    }

    .Beasiswa { 
      background: linear-gradient(135deg, #52357B, #52357B);
      
    }
    .Lomba { 
      background: linear-gradient(135deg, #5459AC, #5459AC);
     
    }
    .Magang { 
      background: linear-gradient(135deg, #648DB3, #648DB3);
      
    }
    .Seminar { 
      background: linear-gradient(135deg, #129990, #129990);
      
    }

    .deadline-info {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      padding: 0.8rem 1.2rem;
      border-radius: 15px;
      border-left: 4px solid #1abc9c;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin: 1rem 0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .deadline-info i {
      color: #1abc9c;
      font-size: 1.1rem;
    }

    .deadline-info span {
      color: #2c3e50;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .info-thumb {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 12px 12px 0 0;
      transition: transform 0.3s ease;
    }

    .info-card {
      background: #ffffff;
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      border: 1px solid rgba(26,188,156,0.1);
      position: relative;
    }

    /* Favorite button for related items */
    .info-card .favorite-btn {
      top: 10px;
      right: 10px;
      width: 35px;
      height: 35px;
      font-size: 1rem;
    }

    .info-card:hover {
      background: #ffffff;
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .info-card:hover .info-thumb {
      transform: scale(1.05);
    }

    .info-card .card-body {
      padding: 1rem;
    }

    .info-card h6 {
      color: #2c3e50;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 0.8rem;
    }

    .info-card .badge-custom {
      font-size: 0.7rem;
      padding: 0.3em 0.8em;
    }

    .sidebar-right {
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      border-radius: 20px;
      padding: 1.5rem;
      color: #2c3e50;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      border: 1px solid rgba(26,188,156,0.1);
      position: sticky;
      top: 2rem;
    }

    .sidebar-right h5 {
      border-bottom: 3px solid #1abc9c;
      padding-bottom: 15px;
      margin-bottom: 1.5rem;
      font-weight: 700;
      color: #2c3e50;
      font-size: 1.2rem;
      position: relative;
    }

    .sidebar-right h5::after {
      content: '';
      position: absolute;
      bottom: -3px;
      left: 0;
      width: 50px;
      height: 3px;
      background: linear-gradient(90deg, #1abc9c, #3498db);
      border-radius: 2px;
    }

    .detail-image {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 15px;
      margin: 2rem 0;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .detail-image:hover {
      transform: scale(1.02);
    }

    .detail-description {
      color: #2c3e50;
      line-height: 1.8;
      font-size: 1rem;
      text-align: justify;
      margin: 2rem 0;
    }

    .meta-info {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      flex-wrap: wrap;
      margin-bottom: 2rem;
    }

    /* Container untuk tombol-tombol */
    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 1.5rem;
      margin: 2.5rem 0;
      flex-wrap: wrap;
    }

    /* Tombol Kunjungi Tautan yang Diperbaiki */
    .btn-visit-link {
      background: linear-gradient(135deg, #FFB823, #FFB823);
      color: #ffffff;
      border: none;
      border-radius: 50px;
      padding: 1rem 2.5rem;
      font-weight: 700;
      font-size: 1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
      transition: all 0.3s ease;
      box-shadow: 0 8px 25px #F5F0CD;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      min-width: 200px;
      height: 56px;
    }

    .btn-visit-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .btn-visit-link:hover::before {
      left: 100%;
    }

    .btn-visit-link:hover {
      background: linear-gradient(135deg, #FADA7A, #FADA7A);
      color: #ffffff;
      transform: translateY(-3px);
      box-shadow: 0 12px 35px #F5F0CD;
      text-decoration: none;
    }

    .btn-visit-link i {
      font-size: 1.2rem;
      transition: transform 0.3s ease;
    }

    .btn-visit-link:hover i {
      transform: rotate(15deg) scale(1.1);
    }

    /* Tombol Kembali yang Diperbaiki */
    .btn-back-new {
      background: transparent;
      border: 2px solid #1abc9c;
      color: #1abc9c;
      border-radius: 50px;
      padding: 1rem 2.5rem;
      font-weight: 700;
      font-size: 1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      min-width: 200px;
      height: 56px;
      position: relative;
      overflow: hidden;
    }

    .btn-back-new::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: #1abc9c;
      transition: left 0.3s ease;
      z-index: -1;
    }

    .btn-back-new:hover::before {
      left: 0;
    }

    .btn-back-new:hover {
      color: #ffffff;
      border-color: #1abc9c;
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(26, 188, 156, 0.3);
      text-decoration: none;
    }

    .btn-back-new i {
      font-size: 1.2rem;
      transition: transform 0.3s ease;
    }

    .btn-back-new:hover i {
      transform: translateX(-5px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .info-thumb {
        height: 110px;
      }
      
      .button-container {
        flex-direction: column;
        gap: 1rem;
      }
      
      .btn-visit-link,
      .btn-back-new {
        min-width: 100%;
        padding: 0.9rem 2rem;
        font-size: 0.9rem;
      }

      .favorite-btn {
        width: 35px;
        height: 35px;
        font-size: 1rem;
      }
    }

    @media (max-width: 576px) {
      .btn-visit-link,
      .btn-back-new {
        padding: 0.8rem 1.5rem;
        font-size: 0.85rem;
        min-width: 180px;
      }
    }
  </style>
</head>
<body>

<div class="container main-content">
  <div class="row g-4">
    <div class="col-md-8">
      <div class="card-detail">
        <!-- Favorite Button for main content -->
        <?php if (isset($_SESSION['username'])): ?>
          <button class="favorite-btn" onclick="toggleFavorite(<?= $info['id']; ?>, this)" title="Tambah ke Favorit" data-item-id="<?= $info['id']; ?>">
            <i class="fas fa-heart"></i>
          </button>
        <?php else: ?>
          <button class="favorite-btn" onclick="showLoginAlert()" title="Login untuk menambahkan favorit">
            <i class="fas fa-heart"></i>
          </button>
        <?php endif; ?>
        
        <h3><?= $info['judul']; ?></h3>
        <div class="meta-info">
          <span class="badge badge-custom <?= $info['kategori']; ?>"><?= $info['kategori']; ?></span>
          <div class="deadline-info">
            <i class="fa fa-calendar-alt"></i>
            <span>Deadline: <?= date('d F Y', strtotime($info['deadline'])); ?></span>
          </div>
        </div>
        <img src="uploads/<?= $info['gambar']; ?>" class="detail-image" alt="<?= $info['judul']; ?>">
        <div class="detail-description">
          <?= nl2br($info['deskripsi']); ?>
        </div>
        
        <!-- Bagian tombol yang diperbaiki -->
        <div class="button-container">
          <a href="javascript:history.back()" class="btn-back-new">
            <i class="fas fa-arrow-circle-left"></i>
            <span>Kembali</span>
          </a>
          
          <?php if (!empty($info['link'])): ?>
            <a href="<?= htmlspecialchars($info['link']); ?>" target="_blank" class="btn-visit-link">
              <i class="fas fa-rocket"></i>
              <span>Kunjungi Tautan</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="sidebar-right">
        <h5><i class="fas fa-lightbulb me-2"></i>Info Terkait</h5>
        <div class="row g-3">
          <?php while ($r = mysqli_fetch_assoc($rekomendasi)): ?>
            <div class="col-12">
              <a href="detail.php?id=<?= $r['id']; ?>" class="text-decoration-none text-dark">
                <div class="info-card">
                  <!-- Favorite Button for related items -->
                  <?php if (isset($_SESSION['username'])): ?>
                    <button class="favorite-btn" onclick="toggleFavorite(<?= $r['id']; ?>, this)" title="Tambah ke Favorit" data-item-id="<?= $r['id']; ?>">
                      <i class="fas fa-heart"></i>
                    </button>
                  <?php else: ?>
                    <button class="favorite-btn" onclick="showLoginAlert()" title="Login untuk menambahkan favorit">
                      <i class="fas fa-heart"></i>
                    </button>
                  <?php endif; ?>
                  
                  <img src="uploads/<?= $r['gambar']; ?>" alt="<?= $r['judul']; ?>" class="info-thumb w-100">
                  <div class="card-body">
                    <h6 class="mb-1"><?= $r['judul']; ?></h6>
                    <div class="d-flex align-items-center justify-content-between">
                      <span class="badge badge-custom <?= $r['kategori']; ?>"><?= $r['kategori']; ?></span>
                    </div>
                    <small class="text-muted mt-2 d-block">
                      <i class="fa fa-calendar-alt me-1"></i><?= date('d M Y', strtotime($r['deadline'])); ?>
                    </small>
                  </div>
                </div>
              </a>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
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
  // Get current favorites from localStorage
  let favorites = JSON.parse(localStorage.getItem('scholarsFavorites') || '[]');
  
  const isFavorited = favorites.includes(itemId);
  
  if (isFavorited) {
    // Remove from favorites
    favorites = favorites.filter(id => id !== itemId);
    button.classList.remove('favorited');
    button.title = 'Tambah ke Favorit';
    showNotification('<i class="fas fa-heart-broken me-2"></i>Dihapus dari favorit');
  } else {
    // Add to favorites
    favorites.push(itemId);
    button.classList.add('favorited');
    button.title = 'Hapus dari Favorit';
    showNotification('<i class="fas fa-heart me-2"></i>Ditambahkan ke favorit');
  }
  
  // Save to localStorage
  localStorage.setItem('scholarsFavorites', JSON.stringify(favorites));
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
  const favorites = JSON.parse(localStorage.getItem('scholarsFavorites') || '[]');
  
  // Mark favorited items
  document.querySelectorAll('.favorite-btn').forEach(button => {
    const itemId = parseInt(button.getAttribute('data-item-id'));
    if (favorites.includes(itemId)) {
      button.classList.add('favorited');
      button.title = 'Hapus dari Favorit';
    }
  });
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