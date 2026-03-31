<?php 
include 'includes/config.php'; 
include 'includes/navbar.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang Kami - ScholarsPath</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Background dengan gambar + overlay */
      background: 
        linear-gradient(rgba(44, 62, 80, 0.85), rgba(52, 73, 94, 0.85)),
        url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
      color: #f8f9fa;
      min-height: 100vh;
      padding-top: 96px;
    }

    /* Alternative background images - uncomment salah satu yang diinginkan */
    /*
    body {
      background: 
        linear-gradient(rgba(44, 62, 80, 0.8), rgba(52, 73, 94, 0.8)),
        url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
    }
    */
    
    /*
    body {
      background: 
        linear-gradient(rgba(44, 62, 80, 0.75), rgba(52, 73, 94, 0.75)),
        url('https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
    }
    */

    /* Hero Section */
    .hero-section {
      padding: 4rem 0;
      position: relative;
      overflow: hidden;
      /* Background khusus untuk hero section */
      background: 
        linear-gradient(rgba(26, 188, 156, 0.1), rgba(52, 152, 219, 0.1)),
        linear-gradient(rgba(44, 62, 80, 0.3), rgba(52, 73, 94, 0.3));
      backdrop-filter: blur(2px);
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(ellipse at center, rgba(26,188,156,0.15) 0%, transparent 70%);
      pointer-events: none;
    }

    .section-title {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #ffffff;
      text-shadow: 0 4px 20px rgba(0,0,0,0.6);
      animation: fadeInUp 1s ease-out;
    }

    .section-subtitle {
      font-size: 1.15rem;
      color: #ecf0f1;
      margin-bottom: 3rem;
      font-weight: 300;
      text-shadow: 0 2px 10px rgba(0,0,0,0.5);
      animation: fadeInUp 1s ease-out 0.2s both;
    }

    /* Main Content Section */
    .main-content {
      padding: 3rem 0;
      position: relative;
    }

    .content-card {
      background: linear-gradient(145deg, rgba(52, 73, 94, 0.95), rgba(44, 62, 80, 0.95));
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 
        0 20px 40px rgba(0,0,0,0.4),
        0 10px 20px rgba(0,0,0,0.3),
        inset 0 1px 0 rgba(255,255,255,0.1);
      transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      margin-bottom: 2rem;
      position: relative;
      animation: fadeInUp 1s ease-out both;
      backdrop-filter: blur(10px);
    }

    .content-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #1abc9c, #3498db, #e74c3c);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .content-card:hover::before {
      opacity: 1;
    }

    .content-card:hover {
      transform: translateY(-8px) scale(1.01);
      box-shadow: 
        0 30px 60px rgba(0,0,0,0.5),
        0 15px 30px rgba(0,0,0,0.4),
        inset 0 1px 0 rgba(255,255,255,0.15);
    }

    /* Left Content */
    .left-content {
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
    }

    .platform-badge {
      display: inline-block;
      background: linear-gradient(135deg, #1abc9c, #16a085);
      color: white;
      padding: 0.5rem 1.5rem;
      border-radius: 25px;
      font-size: 0.9rem;
      font-weight: 500;
      margin-bottom: 1.5rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 8px 20px rgba(26,188,156,0.4);
    }

    .content-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 1.5rem;
      line-height: 1.2;
      text-shadow: 0 2px 15px rgba(0,0,0,0.5);
    }

    .content-description {
      font-size: 1.1rem;
      color: #ecf0f1;
      line-height: 1.7;
      margin-bottom: 2rem;
      text-align: justify;
      text-shadow: 0 1px 5px rgba(0,0,0,0.3);
    }

    .enhanced-description {
      font-size: 1.05rem;
      color: #bdc3c7;
      line-height: 1.8;
      text-align: justify;
      background: rgba(255,255,255,0.08);
      padding: 1.5rem;
      border-radius: 15px;
      border-left: 4px solid #1abc9c;
      margin-top: 1rem;
      backdrop-filter: blur(5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Right Content - Image Grid */
    .right-content {
      padding: 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
      gap: 1rem;
    }

    .image-container {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 30px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .image-container:hover {
      transform: scale(1.05);
      box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .image-container:hover img {
      transform: scale(1.1);
    }

    .image-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(26,188,156,0.3), rgba(52,152,219,0.3));
      opacity: 0;
      transition: opacity 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .image-container:hover .image-overlay {
      opacity: 1;
    }

    .overlay-icon {
      color: white;
      font-size: 2rem;
      background: rgba(255,255,255,0.25);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(10px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* Updated layout - Main image at top, side images at bottom */
    .main-image {
      height: 250px;
      margin-bottom: 1rem;
    }

    .side-images {
      display: flex;
      gap: 1rem;
      align-items: stretch;
    }

    .side-image {
      flex: 1;
      height: 200px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .side-image:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }

    /* Why Choose Section - Updated to horizontal layout */
    .why-choose-section {
      padding: 4rem 0;
      background: 
        linear-gradient(rgba(52, 73, 94, 0.9), rgba(44, 62, 80, 0.9)),
        rgba(0,0,0,0.3);
      margin: 4rem 0;
      border-radius: 30px;
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .why-choose-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(ellipse at center, rgba(26,188,156,0.15) 0%, transparent 70%);
      pointer-events: none;
    }

    .why-choose-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: #ffffff;
      text-align: center;
      margin-bottom: 1rem;
      text-shadow: 0 4px 20px rgba(0,0,0,0.6);
    }

    .why-choose-subtitle {
      font-size: 1.1rem;
      color: #ecf0f1;
      text-align: center;
      margin-bottom: 4rem;
      font-weight: 300;
      text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    /* Updated features grid to horizontal layout */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .feature-card {
      background: linear-gradient(145deg, rgba(26,188,156,0.95), rgba(22,160,133,0.95));
      border-radius: 20px;
      padding: 2.5rem 1.5rem;
      text-align: center;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
      box-shadow: 0 20px 40px rgba(26,188,156,0.3);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="%23ffffff" opacity="0.05"><circle cx="50" cy="50" r="40"/><circle cx="20" cy="20" r="15"/><circle cx="80" cy="80" r="15"/></svg>');
      pointer-events: none;
    }

    .feature-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 30px 60px rgba(26,188,156,0.5);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: rgba(255,255,255,0.25);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2rem;
      color: white;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255,255,255,0.3);
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .feature-card:hover .feature-icon {
      background: rgba(255,255,255,0.35);
      transform: scale(1.1);
    }

    .feature-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: white;
      margin-bottom: 1rem;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .feature-description {
      color: rgba(255,255,255,0.95);
      line-height: 1.6;
      font-size: 0.95rem;
      text-align: justify;
      text-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    /* Team Section */
    .team-section {
      padding: 4rem 0;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }

    .team-card {
      background: linear-gradient(145deg, rgba(52, 73, 94, 0.95), rgba(44, 62, 80, 0.95));
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 25px;
      padding: 2.5rem;
      text-align: center;
      position: relative;
      transition: all 0.4s ease;
      box-shadow: 0 15px 30px rgba(0,0,0,0.3);
      backdrop-filter: blur(10px);
    }

    .team-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #1abc9c, #3498db);
      border-radius: 25px 25px 0 0;
    }

    .team-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 25px 50px rgba(0,0,0,0.4);
    }

    .team-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #1abc9c, #16a085);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2rem;
      color: white;
      box-shadow: 0 15px 30px rgba(26,188,156,0.4);
    }

    .team-title {
      font-size: 1.4rem;
      font-weight: 600;
      color: #1abc9c;
      margin-bottom: 1rem;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .team-description {
      color: #ecf0f1;
      line-height: 1.6;
      font-size: 1rem;
      text-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
      .features-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
      }
    }

    @media (max-width: 768px) {
      .section-title {
        font-size: 2rem;
      }

      .content-title {
        font-size: 1.8rem;
      }

      .left-content {
        padding: 2rem;
      }

      .right-content {
        padding: 1.5rem;
      }

      .side-images {
        flex-direction: column;
      }

      .side-image {
        height: 140px;
      }

      .main-image {
        height: 150px;
      }

      .features-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .team-grid {
        grid-template-columns: 1fr;
      }

      .team-card {
        padding: 2rem;
      }

      .why-choose-title {
        font-size: 2rem;
      }

      .feature-card {
        padding: 2rem 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .section-title {
        font-size: 1.8rem;
      }

      .content-title {
        font-size: 1.5rem;
      }

      .content-description {
        font-size: 1rem;
      }

      .left-content {
        padding: 1.5rem;
      }

      .why-choose-title {
        font-size: 1.8rem;
      }
    }

    /* Animations */
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
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container text-center">
    <h2 class="section-title">Tentang Kami</h2>
    <p class="section-subtitle">Platform Edukasi yang Menginspirasi Masa Depan Mahasiswa Indonesia</p>
  </div>
</section>

<!-- Why Choose ScholarsPath Section -->
<section class="container">
  <div class="why-choose-section">
    <h2 class="why-choose-title">Mengapa Memilih ScholarsPath?</h2>
    <p class="why-choose-subtitle">Kami menyediakan layanan terbaik untuk mendukung perjalanan akademik dan karir Anda</p>
    
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-search"></i>
        </div>
        <h4 class="feature-title">Pencarian Cerdas</h4>
        <p class="feature-description">
          Sistem pencarian canggih yang membantu Anda menemukan peluang sesuai minat, jurusan, dan kriteria spesifik dengan akurasi tinggi.
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h4 class="feature-title">Update Realtime</h4>
        <p class="feature-description">
          Informasi selalu terupdate dengan notifikasi otomatis untuk peluang baru yang sesuai dengan profil dan preferensi Anda.
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <h4 class="feature-title">Informasi Terpercaya</h4>
        <p class="feature-description">
          Semua informasi telah diverifikasi dan bersumber dari institusi resmi untuk memastikan kredibilitas dan keakuratan data.
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-comments"></i>
        </div>
        <h4 class="feature-title">Komunitas Aktif</h4>
        <p class="feature-description">
          Bergabung dengan ribuan mahasiswa lainnya, berbagi pengalaman, tips, dan saling mendukung untuk meraih kesuksesan.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Main Content Section -->
<section class="main-content">
  <div class="container">
    <div class="content-card">
      <div class="row g-0 align-items-center">
        <div class="col-lg-7">
          <div class="left-content">
            <span class="platform-badge">Platform Digital</span>
            <h2 class="content-title">ScholarsPath Menginspirasi Lebih Banyak</h2>
            <p class="content-description">
              Kami menciptakan ekosistem digital yang memungkinkan mahasiswa untuk mengakses berbagai peluang pengembangan diri. Dari beasiswa hingga program magang, semua tersedia dalam satu platform yang mudah digunakan.
            </p>
            <div class="enhanced-description">
              Dengan teknologi pencarian yang canggih dan antarmuka yang intuitif, ScholarsPath memudahkan mahasiswa menemukan peluang terbaik dalam satu platform. Kami tidak hanya menyediakan informasi, tetapi juga panduan lengkap untuk memaksimalkan setiap kesempatan yang ada.
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="right-content">
            <!-- Main image moved to top -->
            <div class="image-container main-image">
              <img src="assets/scholarspath-logo.png" alt="ScholarsPath Platform">
              <div class="image-overlay">
                <div class="overlay-icon">
                  <i class="fas fa-graduation-cap"></i>
                </div>
              </div>
            </div>
            <!-- Side images moved to bottom -->
            <div class="side-images">
              <div class="image-container side-image" onclick="scrollToTeamDeveloper()">
                <img src="assets/misi 1.png" alt="Tim Pengembang">
                <div class="image-overlay">
                  <div class="overlay-icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </div>
              <div class="image-container side-image" onclick="scrollToMission()">
                <img src="assets/misi 2.png" alt="Misi Kami">
                <div class="image-overlay">
                  <div class="overlay-icon">
                    <i class="fas fa-bullseye"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="team-section" id="team-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Tim & Visi Kami</h2>
      <p class="section-subtitle">Berkomitmen untuk menciptakan masa depan pendidikan yang lebih baik</p>
    </div>
    <div class="team-grid">
      <div class="team-card" id="team-developer">
        <div class="team-icon">
          <i class="fas fa-users"></i>
        </div>
        <h4 class="team-title">Tim Pengembang</h4>
        <p class="team-description">
          Website ini dikembangkan oleh tim mahasiswa Teknologi Informasi sebagai bagian dari tugas akhir. Kami berkomitmen untuk menciptakan solusi teknologi yang membantu mahasiswa dalam meraih peluang terbaik.
        </p>
      </div>
      <div class="team-card" id="mission">
        <div class="team-icon">
          <i class="fas fa-bullseye"></i>
        </div>
        <h4 class="team-title">Misi Kami</h4>
        <p class="team-description">
          Memberikan akses setara ke informasi berkualitas. ScholarsPath hadir sebagai jembatan antara mahasiswa dan berbagai kesempatan pengembangan diri dengan sistem yang mudah digunakan.
        </p>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Smooth scroll function for general sections
function scrollToSection(sectionId) {
  const section = document.getElementById(sectionId);
  if (section) {
    section.scrollIntoView({ 
      behavior: 'smooth',
      block: 'start'
    });
  }
}

// Specific scroll functions for team developer and mission
function scrollToTeamDeveloper() {
  const teamDeveloper = document.getElementById('team-developer');
  if (teamDeveloper) {
    teamDeveloper.scrollIntoView({ 
      behavior: 'smooth',
      block: 'center'
    });
    // Add highlight effect
    teamDeveloper.style.transform = 'scale(1.05)';
    teamDeveloper.style.boxShadow = '0 25px 50px rgba(26,188,156,0.4)';
    setTimeout(() => {
      teamDeveloper.style.transform = '';
      teamDeveloper.style.boxShadow = '';
    }, 2000);
  }
}

function scrollToMission() {
  const mission = document.getElementById('mission');
  if (mission) {
    mission.scrollIntoView({ 
      behavior: 'smooth',
      block: 'center'
    });
    // Add highlight effect
    mission.style.transform = 'scale(1.05)';
    mission.style.boxShadow = '0 25px 50px rgba(26,188,156,0.4)';
    setTimeout(() => {
      mission.style.transform = '';
      mission.style.boxShadow = '';
    }, 2000);
  }
}

// Intersection Observer for animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = 'running';
    }
  });
}, observerOptions);

// Observe elements
document.addEventListener('DOMContentLoaded', () => {
  const elementsToObserve = document.querySelectorAll('.content-card, .team-card, .feature-card');
  elementsToObserve.forEach(el => observer.observe(el));
});

// Add loading effect
window.addEventListener('load', () => {
  document.body.style.opacity = '0';
  document.body.style.transition = 'opacity 0.5s ease-in-out';
  setTimeout(() => {
    document.body.style.opacity = '1';
  }, 100);
});
</script>
</body>
</html>