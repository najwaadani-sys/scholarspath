<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../loginuser.php");
    exit;
}

$query = "SELECT * FROM info ORDER BY deadline ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            padding: 2rem;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .container {
            max-width: 1200px;
            margin: auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 24px;
            pointer-events: none;
        }
        
        h3 {
            background: linear-gradient(135deg, #1e293b, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .welcome-text {
            background: linear-gradient(135deg, #64748b, #1e293b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .section-title {
            color: #1e293b;
            font-weight: 600;
            font-size: 1.4rem;
            margin: 2rem 0 1.5rem 0;
            position: relative;
            padding-left: 1rem;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
        }
        
        /* Search Section Styles */
        .search-section {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(59, 130, 246, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .search-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
        }
        
        .search-container {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 4rem;
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 50px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 8px 25px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }
        
        .search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus ~ .search-icon {
            color: #3b82f6;
        }
        
        .search-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 0.5rem 1.5rem;
            border: 2px solid rgba(59, 130, 246, 0.2);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.8);
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .search-results-info {
            text-align: center;
            margin: 1rem 0;
            color: #64748b;
            font-size: 0.95rem;
            padding: 0.75rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }
        
        .form-control, .form-select {
            border-radius: 16px;
            border: 2px solid rgba(59, 130, 246, 0.1);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }
        
        .btn {
            border-radius: 16px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #ef4444, #f97316);
            color: white;
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626, #ea580c);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.4);
        }
        
        .table {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: none;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: #1e293b;
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.95rem;
        }
        
        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: scale(1.01);
        }
        
        .table tbody tr.hidden {
            display: none;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            margin: 0 0.25rem;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            transform: translateY(-1px);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
        }
        
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.3), transparent);
            margin: 2.5rem 0;
        }
        
        .text-muted {
            color: #64748b !important;
            font-style: italic;
            text-align: center;
            padding: 2rem;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 12px;
            border: 2px dashed rgba(148, 163, 184, 0.3);
        }
        
        .form-row {
            background: rgba(248, 250, 252, 0.3);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.5);
            margin: 1.5rem 0;
        }
        
        .no-results {
            text-align: center;
            padding: 3rem 2rem;
            color: #64748b;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
            border-radius: 16px;
            border: 2px dashed rgba(59, 130, 246, 0.2);
        }
        
        .no-results i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .container {
            animation: float 6s ease-in-out infinite;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 2rem;
                animation: none;
            }
            
            h3 {
                font-size: 1.8rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .search-filters {
                gap: 0.5rem;
            }
            
            .filter-btn {
                font-size: 0.8rem;
                padding: 0.4rem 1rem;
            }
            
            .table-responsive {
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h3>✨ Dashboard Admin Mahasiswa</h3>
    <p class="welcome-text">Selamat datang, <strong><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></strong> 👋</p>

    <hr>
    <h5 class="section-title">🚀 Tambah Informasi Baru</h5>
    <div class="form-row">
        <form action="tambah.php" method="post" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="judul" class="form-control" placeholder="Judul" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" required>
            </div>
            <div class="col-md-6">
                <input type="date" name="deadline" class="form-control" required>
            </div>
            <div class="col-md-6">
                <input type="url" name="link" class="form-control" placeholder="https://...">
            </div>
            <div class="col-md-6">
                <select name="kategori" class="form-select" required>
                    <option disabled selected>-- Pilih Kategori --</option>
                    <option value="Beasiswa">Beasiswa</option>
                    <option value="Lomba">Lomba</option>
                    <option value="Magang">Magang</option>
                    <option value="Seminar">Seminar</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="file" name="gambar" class="form-control" required>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Tambah Info</button>
                <a href="logout.php" class="btn btn-logout">Logout</a>
            </div>
        </form>
    </div>

    <hr class="mt-4">
    <h5 class="section-title">🔍 Kelola Informasi</h5>
    
    <!-- Search Section -->
    <div class="search-section">
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari berdasarkan judul, kategori, atau deadline...">
            <i class="fas fa-search search-icon"></i>
        </div>
        
        <div class="search-filters">
            <button class="filter-btn active" data-category="all">
                <i class="fas fa-th-large"></i> Semua
            </button>
            <button class="filter-btn" data-category="Beasiswa">
                <i class="fas fa-graduation-cap"></i> Beasiswa
            </button>
            <button class="filter-btn" data-category="Lomba">
                <i class="fas fa-trophy"></i> Lomba
            </button>
            <button class="filter-btn" data-category="Magang">
                <i class="fas fa-briefcase"></i> Magang
            </button>
            <button class="filter-btn" data-category="Seminar">
                <i class="fas fa-chalkboard-teacher"></i> Seminar
            </button>
        </div>
    </div>

    <div id="searchResults" class="search-results-info" style="display: none;">
        Menampilkan <span id="resultCount">0</span> hasil
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table class="table mt-3" id="dataTable">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr data-judul="<?= strtolower(htmlspecialchars($row['judul'])); ?>" 
                            data-kategori="<?= strtolower($row['kategori']); ?>" 
                            data-deadline="<?= $row['deadline']; ?>">
                            <td><?= htmlspecialchars($row['judul']); ?></td>
                            <td>
                                <span class="badge bg-primary"><?= $row['kategori']; ?></span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($row['deadline'])); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <div id="noResults" class="no-results" style="display: none;">
            <i class="fas fa-search"></i>
            <h5>Tidak ada hasil ditemukan</h5>
            <p>Coba gunakan kata kunci yang berbeda atau ubah filter kategori</p>
        </div>
    <?php else: ?>
        <p class="text-muted">Belum ada informasi yang ditambahkan.</p>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const tableRows = document.querySelectorAll('#dataTable tbody tr');
    const searchResults = document.getElementById('searchResults');
    const resultCount = document.getElementById('resultCount');
    const noResults = document.getElementById('noResults');
    const dataTable = document.getElementById('dataTable');
    
    let currentCategory = 'all';
    
    // Search functionality
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;
        
        tableRows.forEach(row => {
            const judul = row.dataset.judul;
            const kategori = row.dataset.kategori;
            const deadline = row.dataset.deadline;
            
            const matchesSearch = !searchTerm || 
                judul.includes(searchTerm) || 
                kategori.includes(searchTerm) || 
                deadline.includes(searchTerm);
            
            const matchesCategory = currentCategory === 'all' || 
                kategori === currentCategory.toLowerCase();
            
            const isVisible = matchesSearch && matchesCategory;
            
            if (isVisible) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        
        // Update results info
        if (searchTerm || currentCategory !== 'all') {
            searchResults.style.display = 'block';
            resultCount.textContent = visibleCount;
        } else {
            searchResults.style.display = 'none';
        }
        
        // Show/hide no results message
        if (visibleCount === 0 && tableRows.length > 0) {
            noResults.style.display = 'block';
            dataTable.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            dataTable.style.display = 'table';
        }
    }
    
    // Search input event
    searchInput.addEventListener('input', performSearch);
    
    // Category filter events
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update current category
            currentCategory = this.dataset.category;
            
            // Perform search with new filter
            performSearch();
        });
    });
    
    // Clear search when clicking on search icon
    document.querySelector('.search-icon').addEventListener('click', function() {
        if (searchInput.value) {
            searchInput.value = '';
            performSearch();
            searchInput.focus();
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
        }
        
        // Escape to clear search
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.value = '';
            performSearch();
        }
    });
    
    // Auto-focus search on page load
    searchInput.focus();
});
</script>
</body>
</html>