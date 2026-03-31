<?php 
session_start();
include 'includes/config.php'; 
include 'includes/navbar.php';  

// Ambil kategori dari URL 
$kategori = isset($_GET['k']) ? $_GET['k'] : ''; 
?> 

<!DOCTYPE html> 
<html lang="id"> 
<head>   
  <meta charset="UTF-8" />   
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>   
  <title><?= htmlspecialchars($kategori); ?> - ScholarsPath</title>   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>   
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>   
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>   
  <link rel="stylesheet" href="assets/css/footer.css">   
  <style>     
    body {       
      font-family: 'Poppins', sans-serif;       
      background-image: url('assets/team 1.png');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      color: #fff;
      min-height: 100vh;
      padding-top: 96px;
    }
    
    /* Overlay untuk membuat teks lebih mudah dibaca */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(44, 62, 80, 0.7);
      z-index: -1;
    }

    .container {       
      padding-top: 4rem;       
      position: relative;
      z-index: 1;
    }      

    .section-title {       
      font-size: 2rem;       
      font-weight: 600;       
      color: #fff;       
      margin-bottom: 2rem;       
      text-align: center;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }      

    .card {       
      background-color: rgba(255, 255, 255, 0.95);       
      color: #2c3e50;       
      border-radius: 15px;       
      border: none;       
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);       
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      backdrop-filter: blur(10px);
      position: relative;
    }      

    .card:hover {       
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }      

    .card-img-top {       
      height: 180px;       
      object-fit: cover;       
      border-top-left-radius: 15px;       
      border-top-right-radius: 15px;       
    }      

    .badge-custom {       
      padding: 5px 12px;       
      border-radius: 10px;       
      font-size: 0.8rem;       
      color: #fff;       
    }      

    .Beasiswa { background-color: #332D56; }     
    .Lomba    { background-color: #5459AC; }     
    .Magang   { background-color: #648DB3; }     
    .Seminar  { background-color: #129990; }     
    
    /* Favorite Button Styles */
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

    .btn-detail {       
      margin-top: 1rem;       
    }
    
    .no-data-message {
      background: rgba(255, 255, 255, 0.9);
      color: #2c3e50;
      padding: 2rem;
      border-radius: 15px;
      text-shadow: none;
      backdrop-filter: blur(10px);
    }

    @media (max-width: 768px) {
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
  <h2 class="section-title">Kategori: <?= htmlspecialchars($kategori); ?></h2>    

  <div class="row g-4">     
    <?php     
    $sql = "SELECT * FROM info WHERE kategori=? ORDER BY tanggal_post DESC";     
    $stmt = $conn->prepare($sql);     
    $stmt->bind_param("s", $kategori);     
    $stmt->execute();     
    $result = $stmt->get_result();      

    if ($result->num_rows > 0):       
      while ($row = $result->fetch_assoc()):     
    ?>       
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
            <h5 class="card-title"><?= $row['judul']; ?></h5>             
            <small class="text-muted">Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?></small>             
            <div class="mt-2">               
              <span class="badge badge-custom <?= $row['kategori']; ?>"><?= $row['kategori']; ?></span>             
            </div>             
            <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary btn-sm btn-detail">Lihat Detail</a>           
          </div>         
        </div>       
      </div>     
    <?php endwhile; else: ?>       
      <div class="col-12 text-center">         
        <div class="no-data-message">
          <p class="mb-0">Belum ada data untuk kategori ini.</p>       
        </div>
      </div>     
    <?php endif; ?>   
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