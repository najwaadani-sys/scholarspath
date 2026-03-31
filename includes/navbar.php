<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>



<style>
  .navbar {
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 90px;
    padding: 0.5rem 0;
}


  .dropdown-menu {
    z-index: 9999 !important;
    position: absolute !important;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-top: 0.2rem;
  }

  .navbar-brand {
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 0rem 0 4rem;
  }

  .navbar-brand img {
    width: 130px;
    height: auto;
    display: block;
}


  .navbar-nav .nav-link {
    padding: 0.5rem 1rem;
    font-weight: 500;
    color: #495057;
    transition: color 0.3s ease;
  }

  .navbar-nav .nav-link:hover {
    color: #007bff;
  }

  .btn-outline-primary {
    border-radius: 20px;
    padding: 0.4rem 1.2rem;
    font-weight: 500;
    border-width: 1.5px;
  }

  .btn-outline-secondary {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
  }

  .user-greeting {
    color: #20c997 !important;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .user-greeting a {
    color: #20c997 !important;
    font-weight: 600;
    text-decoration: none;
  }

  .user-greeting a:hover {
    color: #17a085 !important;
  }

  /* Responsive Design */
  @media (max-width: 991px) {
    .navbar {
      min-height: 80px;
    }
    
    .navbar-brand {
      /* padding: 0 1.5rem 0 2rem; */
    }

    .navbar-brand img {
      max-height: 75px;
    }

    .navbar-collapse {
      padding-top: 1rem;
    }

    .navbar-nav .nav-item {
      margin-bottom: 0.5rem;
    }

    .user-greeting {
      margin-top: 0.5rem;
    }

    .btn-outline-secondary {
      margin-top: 0.5rem;
    }
  }

  @media (max-width: 576px) {
    .navbar {
      min-height: 70px;
    }

    .navbar-brand {
      padding: 0 1rem 0 1.5rem;
      margin-right: 0.5rem;
    }

    .navbar-brand img {
      max-height: 65px;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top"> 
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/logo.png" alt="ScholarsPath Logo">
    </a>

    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation Menu -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <!-- Beranda -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Beranda</a>
        </li>

        <!-- Kategori Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownKategori" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownKategori">
            <li><a class="dropdown-item" href="kategori.php?k=Beasiswa">
              <i class="fas fa-graduation-cap me-2"></i>Beasiswa
            </a></li>
            <li><a class="dropdown-item" href="kategori.php?k=Lomba">
              <i class="fas fa-trophy me-2"></i>Lomba
            </a></li>
            <li><a class="dropdown-item" href="kategori.php?k=Magang">
              <i class="fas fa-briefcase me-2"></i>Magang
            </a></li>
            <li><a class="dropdown-item" href="kategori.php?k=Seminar & Webinar">
              <i class="fas fa-users me-2"></i>Seminar & Webinar
            </a></li>
          </ul>
        </li>

        <!-- Tentang Kami -->
        <li class="nav-item">
          <a class="nav-link" href="tentang.php">Tentang Kami</a>
        </li>

        <!-- User Authentication Section -->
        <?php if (isset($_SESSION['nama'])): ?>
<!-- dashboard.php -->
<li class="nav-item">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
        </a>
    </li>
          <!-- User Greeting -->
          <li class="nav-item d-flex align-items-center ms-3">
            <span class="user-greeting">
              Halo, <a href="#"><?php echo htmlspecialchars($_SESSION['nama']); ?></a>
              <i class="fas fa-user-circle"></i>
            </span>
          </li>
          
          <!-- Logout Button -->
          <li class="nav-item ms-2">
            <a href="logout.php" class="btn btn-outline-secondary" title="Logout">
              <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
        <?php else: ?>
          <!-- Login Button -->
          <li class="nav-item ms-3">
            <a class="btn btn-outline-primary" href="loginuser.php" style="margin-right: 3rem;">
              <i class="fas fa-sign-in-alt me-1"></i>Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>