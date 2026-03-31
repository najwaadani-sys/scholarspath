<?php
include 'includes/config.php';
include 'includes/navbar.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$q_safe = mysqli_real_escape_string($conn, $q);
$query = "SELECT * FROM info WHERE judul LIKE '%$q_safe%' OR deskripsi LIKE '%$q_safe%' ORDER BY tanggal_post DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pencarian - ScholarsPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('assets/cari 1.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center center;
      color: #ecf0f1;
      min-height: 100vh;
      padding-top: 96px;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(44, 62, 80, 0.7);
      z-index: -1;
    }

    .search-heading {
      margin-top: 3rem;
      padding: 2rem 0;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      backdrop-filter: blur(5px);
    }

    .search-heading h3 {
      font-size: 2rem;
      font-weight: 700;
      color: #ffffff;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      margin-bottom: 0;
    }

    .card {
      border: none;
      border-radius: 12px;
      background-color: rgba(255, 255, 255, 0.95);
      color: #000;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(10px);
      position: relative;
    }

    .card:hover {
      transform: translateY(-5px);
      transition: 0.3s;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      height: 180px;
      object-fit: cover;
    }

    .badge-custom {
      font-size: 0.75rem;
      padding: 0.4em 0.8em;
      border-radius: 8px;
      color: white;
    }

    .Beasiswa { background-color: #332D56; }
    .Lomba    { background-color: #5459AC; }
    .Magang   { background-color: #648DB3; }
    .Seminar  { background-color: #129990; }

    .favorite-btn {
      position: absolute;
      top: 15px;
      right: 15px;
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
    }

    .favorite-btn.favorited {
      background: #e74c3c;
      color: white;
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
    }

    .no-results {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
      .search-heading h3 {
        font-size: 1.5rem;
      }
      .search-heading {
        padding: 1.5rem 0;
        margin-top: 2rem;
      }
      .favorite-btn {
        width: 35px;
        height: 35px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="search-heading">
    <h3>Hasil Pencarian: "<?= htmlspecialchars($q); ?>"</h3>
  </div>

  <div class="row g-4">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="col-md-3">
          <div class="card h-100">
            <?php if (isset($_SESSION['username'])): ?>
              <button class="favorite-btn" onclick="toggleFavorite(<?= $row['id']; ?>, this)" 
                      title="Tambah ke Favorit" data-item-id="<?= $row['id']; ?>">
                <i class="fas fa-heart"></i>
              </button>
            <?php else: ?>
              <button class="favorite-btn" onclick="showLoginAlert()" title="Login untuk menambahkan favorit">
                <i class="fas fa-heart"></i>
              </button>
            <?php endif; ?>
            
            <img src="uploads/<?= $row['gambar']; ?>" class="card-img-top" alt="Poster">
            <div class="card-body">
              <h6 class="card-title fw-bold"><?= $row['judul']; ?></h6>
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
        <div class="no-results">
          <p class="text-muted mb-0">Tidak ditemukan hasil untuk pencarian tersebut.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<div id="favoriteNotification" class="favorite-notification">
  <span id="favoriteMessage"></span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleFavorite(itemId, button) {
  let favorites = JSON.parse(localStorage.getItem('scholarsFavorites') || '[]');
  const isFavorited = favorites.includes(itemId);
  
  if (isFavorited) {
    favorites = favorites.filter(id => id !== itemId);
    button.classList.remove('favorited');
    button.title = 'Tambah ke Favorit';
    showNotification('<i class="fas fa-heart-broken me-2"></i>Dihapus dari favorit');
  } else {
    favorites.push(itemId);
    button.classList.add('favorited');
    button.title = 'Hapus dari Favorit';
    showNotification('<i class="fas fa-heart me-2"></i>Ditambahkan ke favorit');
  }
  
  localStorage.setItem('scholarsFavorites', JSON.stringify(favorites));
}

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

function showLoginAlert() {
  showNotification('<i class="fas fa-exclamation-circle me-2"></i>Silakan login terlebih dahulu', true);
  setTimeout(() => {
    window.location.href = 'loginuser.php';
  }, 50);
}

document.addEventListener('DOMContentLoaded', function() {
  const favorites = JSON.parse(localStorage.getItem('scholarsFavorites') || '[]');
  
  document.querySelectorAll('.favorite-btn').forEach(button => {
    const itemId = parseInt(button.getAttribute('data-item-id'));
    if (favorites.includes(itemId)) {
      button.classList.add('favorited');
      button.title = 'Hapus dari Favorit';
    }
  });
});
</script>

</body>
</html>