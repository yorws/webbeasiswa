<?php
session_start();
require_once 'includes/functions.php';

// Routing sederhana berdasarkan parameter 'page'
$page = isset($_GET['page']) ? $_GET['page'] : 'pilihan-beasiswa';

// Menentukan judul halaman
$title = "Sistem Pendaftaran Beasiswa Online";
if ($page == 'pilihan-beasiswa') $title = "Pilihan Beasiswa - Beasiswa Online";
if ($page == 'daftar') $title = "Daftar Beasiswa - Beasiswa Online";
if ($page == 'hasil') $title = "Hasil Pendaftaran - Beasiswa Online";
if ($page == 'view') $title = "Lihat Berkas - Beasiswa Online";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <div class="brand-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <span>BeasiswaKU</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'pilihan-beasiswa') ? 'active' : '' ?>" href="index.php?page=pilihan-beasiswa">Pilihan Beasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'daftar') ? 'active' : '' ?>" href="index.php?page=daftar">Daftar Sekarang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page == 'hasil') ? 'active' : '' ?>" href="index.php?page=hasil">Hasil Seleksi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container main-content min-vh-100">
        <?php
        $file_path = "pages/{$page}.php";
        if (file_exists($file_path)) {
            include $file_path;
        } else {
            echo "<div class='alert alert-danger custom-alert'>Halaman tidak ditemukan.</div>";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer class="custom-footer mt-auto">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Sistem Pendaftaran Beasiswa Kampus. Built for Excellence.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
</body>
</html>
