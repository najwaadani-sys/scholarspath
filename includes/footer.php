<!-- Footer CSS -->
<style>
/* Footer Styles */
footer {
  background: linear-gradient(rgba(44, 62, 80, 0.3), rgba(52, 73, 94, 0.4)), url('assets/footer4.png');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  padding: 3rem 0 2rem;
  margin-top: 5rem;
  border-top: 1px solid rgba(255,255,255,0.1);
  position: relative;
  overflow: hidden;
  color: #fff;
}

footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, #1abc9c, #3498db, #1abc9c, transparent);
  z-index: 2;
}

footer::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(44, 62, 80, 0.1);
  z-index: 1;
}

.footer-content {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
  position: relative;
  z-index: 3;
}

.footer-section h5 {
  color: #1abc9c;
  font-weight: 600;
  margin-bottom: 1.5rem;
  font-size: 1.1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.footer-section h5 i {
  font-size: 1.2rem;
}

.footer-section p {
  color: #bdc3c7;
  line-height: 1.6;
  margin-bottom: 1rem;
  font-size: 0.9rem;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section ul li {
  margin-bottom: 0.8rem;
}

.footer-section ul li a {
  color: #ecf0f1;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: color 0.3s ease;
  font-size: 0.9rem;
}

.footer-section ul li a:hover {
  color: #1abc9c;
}

.footer-section ul li a i {
  font-size: 0.9rem;
  width: 16px;
}

.social-links {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.social-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 50%;
  color: #ecf0f1;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 1.1rem;
}

.social-link:hover {
  background: #1abc9c;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(26,188,156,0.3);
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
  color: #ecf0f1;
  font-size: 0.9rem;
}

.contact-item i {
  color: #1abc9c;
  width: 16px;
  font-size: 0.9rem;
}

.footer-bottom {
  border-top: 1px solid rgba(255,255,255,0.2);
  padding-top: 2rem;
  display: flex;
  justify-content: center; /* ⬅️ dari space-between ke center */
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  position: relative;
  z-index: 3;
  background: rgba(44, 62, 80, 0.3);
  backdrop-filter: blur(10px);
  margin: 0 -15px;
  padding-left: 15px;
  padding-right: 15px;
}


.footer-bottom p {
  margin: 0;
  color: #bdc3c7;
  font-size: 0.9rem;
}

.footer-bottom .made-with {
  color: #ecf0f1;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.3rem;
}

.footer-bottom .made-with i {
  color: #e74c3c;
  font-size: 1rem;
}


/* Responsive Design */
@media (max-width: 768px) {
  .footer-content {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }

  .footer-bottom {
    flex-direction: column;
    text-align: center;
  }
}

@media (max-width: 576px) {
  .footer-content {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .social-links {
    justify-content: center;
  }
}
</style>

<!-- Footer HTML -->
<footer>
  <div class="container">
    <div class="footer-content">
      <!-- ScholarsPath Section -->
      <div class="footer-section">
        <h5><i class="fas fa-graduation-cap"></i> ScholarsPath</h5>
        <p>Platform digital terdepan untuk mahasiswa Indonesia dalam mencari informasi beasiswa, lomba, magang, dan seminar terbaik dari seluruh nusantara.</p>
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Indonesia</span>
        </div>
      </div>

      <!-- Navigasi Cepat Section -->
      <div class="footer-section">
        <h5><i class="fas fa-compass"></i> Navigasi Cepat</h5>
        <ul>
          <li><a href="index.php"><i class="fas fa-home"></i> Beranda</a></li>
          <li><a href="kategori.php?k=Beasiswa"><i class="fas fa-graduation-cap"></i> Beasiswa</a></li>
          <li><a href="kategori.php?k=Lomba"><i class="fas fa-trophy"></i> Lomba</a></li>
          <li><a href="kategori.php?k=Magang"><i class="fas fa-briefcase"></i> Magang</a></li>
          <li><a href="kategori.php?k=Seminar"><i class="fas fa-calendar-alt"></i> Seminar</a></li>
          <li><a href="tentang.php"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
        </ul>
      </div>

      <!-- Akun Section -->
      <div class="footer-section">
        <h5><i class="fas fa-user"></i> Akun</h5>
        <ul>
          <?php if (isset($_SESSION['nama'])): ?>
            <li><a href="logoutuser.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          <?php else: ?>
            <li><a href="loginuser.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li><a href="loginuser.php"><i class="fas fa-user-plus"></i> Daftar</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Hubungi Kami Section -->
      <div class="footer-section">
        <h5><i class="fas fa-envelope"></i> Hubungi Kami</h5>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span>info@scholarspath.ac.id</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+62 812-3456-7890</span>
        </div>
        <h6 style="color: #1abc9c; margin: 1.5rem 0 1rem 0; font-size: 1rem;">Ikuti Kami</h6>
        <div class="social-links">
          <a href="#" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook"></i></a>
          <a href="#" class="social-link" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="social-link" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; <?= date('Y'); ?> ScholarsPath — Untuk Masa Depan yang Gemilang</p>
      </div>
    </div>
  </div>
</footer>