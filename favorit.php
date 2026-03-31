<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: loginuser.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "
    SELECT info.* FROM favorit 
    JOIN info ON favorit.info_id = info.id 
    WHERE favorit.user_id = $user_id
    ORDER BY favorit.tanggal_disimpan DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-top: 96px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            margin: 2rem auto;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-title {
            background: linear-gradient(135deg, #64748b, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            animation: fadeInUp 0.8s ease-out;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #64748b, #94a3b8);
            border-radius: 2px;
        }

        .favorite-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .favorite-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .favorite-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #64748b, #94a3b8);
            z-index: 1;
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: all 0.4s ease;
            position: relative;
        }

        .favorite-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
            position: relative;
        }

        .card-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
            line-height: 1.4;
        }

        .deadline-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .deadline-badge i {
            margin-right: 0.5rem;
        }

        .detail-btn {
            background: linear-gradient(135deg, #475569, #64748b);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.3s ease;
        }

        .detail-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(71, 85, 105, 0.4);
            color: white;
        }

        .detail-btn:hover::before {
            left: 100%;
        }

        .detail-btn i {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .detail-btn:hover i {
            transform: translateX(3px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(255, 255, 255, 0.8);
            animation: fadeIn 0.8s ease-out;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.6;
        }

        .empty-state h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .floating-hearts {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .heart {
            position: absolute;
            color: rgba(148, 163, 184, 0.3);
            font-size: 1.5rem;
            animation: float 6s ease-in-out infinite;
        }

        .remove-favorite {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-favorite:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .remove-favorite i {
            font-size: 0.8rem;
        }

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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0;
            }
            50% {
                transform: translateY(-100vh) rotate(180deg);
                opacity: 1;
            }
        }

        /* Staggered animation delays for cards */
        .favorite-card:nth-child(1) { animation-delay: 0.1s; }
        .favorite-card:nth-child(2) { animation-delay: 0.2s; }
        .favorite-card:nth-child(3) { animation-delay: 0.3s; }
        .favorite-card:nth-child(4) { animation-delay: 0.4s; }
        .favorite-card:nth-child(5) { animation-delay: 0.5s; }
        .favorite-card:nth-child(6) { animation-delay: 0.6s; }

        /* Smooth slide up animation for remaining cards */
        @keyframes slideUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        /* Enhanced responsiveness */
        .row {
            transition: all 0.3s ease;
        }

        .col-md-6, .col-lg-4 {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading state for remove button */
        .remove-favorite:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .remove-favorite .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .card-img-top {
                height: 200px;
            }

            .detail-btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            .remove-favorite {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .deadline-badge {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding-top: 80px;
            }

            .page-title {
                font-size: 1.8rem;
                margin-bottom: 1.5rem;
            }

            .main-container {
                margin: 0.5rem;
                padding: 1rem;
            }

            .card-img-top {
                height: 180px;
            }

            .mt-auto.d-flex {
                flex-direction: column;
                gap: 0.5rem;
            }

            .detail-btn, .remove-favorite {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .detail-btn {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Bookmarks Animation -->
    <div class="floating-hearts">
        <i class="fas fa-bookmark heart" style="left: 10%; animation-delay: 0s;"></i>
        <i class="fas fa-bookmark heart" style="left: 20%; animation-delay: 1s;"></i>
        <i class="fas fa-bookmark heart" style="left: 30%; animation-delay: 2s;"></i>
        <i class="fas fa-bookmark heart" style="left: 40%; animation-delay: 3s;"></i>
        <i class="fas fa-bookmark heart" style="left: 50%; animation-delay: 4s;"></i>
        <i class="fas fa-bookmark heart" style="left: 60%; animation-delay: 5s;"></i>
        <i class="fas fa-bookmark heart" style="left: 70%; animation-delay: 6s;"></i>
        <i class="fas fa-bookmark heart" style="left: 80%; animation-delay: 7s;"></i>
        <i class="fas fa-bookmark heart" style="left: 90%; animation-delay: 8s;"></i>
    </div>

    <?php include 'includes/navbar.php'; ?>

    <div class="container">
        <div class="main-container">
            <h1 class="page-title">
                <i class="fas fa-bookmark me-3"></i>Favorit Saya
            </h1>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card favorite-card h-100">
                                <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                                    class="card-img-top" 
                                    alt="<?= htmlspecialchars($row['judul']); ?>"
                                    loading="lazy">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($row['judul']); ?></h5>
                                    
                                    <div class="deadline-badge">
                                        <i class="fas fa-calendar-alt"></i>
                                        Deadline: <?= date('d F Y', strtotime($row['deadline'])); ?>
                                    </div>
                                    
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <a href="detail.php?id=<?= $row['id']; ?>" class="detail-btn">
                                            Lihat Detail
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm remove-favorite" data-id="<?= $row['id']; ?>">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-bookmark"></i>
                    <h4>Belum Ada Favorit</h4>
                    <p>Anda belum menambahkan item apapun ke favorit. Mulai eksplorasi dan tambahkan item favorit Anda!</p>
                    <a href="index.php" class="detail-btn mt-3">
                        <i class="fas fa-search me-2"></i>
                        Jelajahi Sekarang
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth scroll and additional animations
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for animation triggers
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Observe all cards
            document.querySelectorAll('.favorite-card').forEach(card => {
                observer.observe(card);
            });

            // Add parallax effect to background
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelector('body::before');
                if (parallax) {
                    const speed = scrolled * 0.5;
                    parallax.style.transform = `translateY(${speed}px)`;
                }
            });
        });

        // Handle remove favorite with smooth animations
        function attachRemoveFavoriteListeners() {
            document.querySelectorAll('.remove-favorite').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const cardContainer = this.closest('.col-md-6, .col-lg-4, .col-12');
                    const card = this.closest('.favorite-card');
                    
                    // Show confirmation
                    if (confirm('Apakah Anda yakin ingin menghapus dari favorit?')) {
                        // Disable button to prevent double clicks
                        this.disabled = true;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
                        
                        // Send AJAX request
                        fetch('remove_favorite.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `info_id=${itemId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Add fade out and slide animation
                                card.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                                card.style.opacity = '0';
                                card.style.transform = 'translateY(-30px) scale(0.9)';
                                
                                // Animate container height
                                cardContainer.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                                cardContainer.style.opacity = '0';
                                cardContainer.style.transform = 'translateX(100px)';
                                
                                setTimeout(() => {
                                    // Remove the entire column container
                                    cardContainer.remove();
                                    
                                    // Animate remaining cards to fill the space
                                    const remainingCards = document.querySelectorAll('.favorite-card');
                                    remainingCards.forEach((remainingCard, index) => {
                                        remainingCard.style.animation = `slideUp 0.3s ease-out ${index * 0.1}s forwards`;
                                    });
                                    
                                    // Check if no more favorites
                                    if (remainingCards.length === 0) {
                                        // Smooth transition to empty state
                                        const mainContainer = document.querySelector('.main-container');
                                        mainContainer.style.transition = 'all 0.5s ease';
                                        mainContainer.style.opacity = '0';
                                        
                                        setTimeout(() => {
                                            location.reload(); // Reload to show empty state
                                        }, 500);
                                    }
                                }, 500);
                            } else {
                                // Re-enable button on error
                                this.disabled = false;
                                this.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                                alert('Gagal menghapus favorit: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Re-enable button on error
                            this.disabled = false;
                            this.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                            alert('Terjadi kesalahan saat menghapus favorit');
                        });
                    }
                });
            });
        }
        
        // Initialize remove favorite listeners
        attachRemoveFavoriteListeners();
    </script>
</body>
</html>