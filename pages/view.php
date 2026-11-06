<?php
/**
 * Halaman untuk menampilkan berkas syarat pendaftaran secara inline di web.
 */

// Mencegah akses langsung tanpa index.php
if (!defined('JSON_FILE')) {
    define('JSON_FILE', __DIR__ . '/../data.json');
}

$file = isset($_GET['file']) ? basename($_GET['file']) : '';
$filepath = 'uploads/' . $file;
$file_exists = !empty($file) && file_exists($filepath);

// Ekstensi file
$ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

// Mendeteksi data pendaftaran terkait berkas ini (opsional, untuk info detail di page)
$owner_name = '';
$beasiswa_choice = '';
if ($file_exists) {
    if (file_exists(JSON_FILE)) {
        $json_content = file_get_contents(JSON_FILE);
        $registrations = json_decode($json_content, true);
        if (is_array($registrations)) {
            foreach ($registrations as $reg) {
                if (($reg['berkas'] ?? '') === $file) {
                    $owner_name = $reg['nama'] ?? '';
                    $beasiswa_choice = $reg['pilihan_beasiswa'] ?? '';
                    break;
                }
            }
        }
    }
}
?>

<div class="row mb-4 justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="page-title">Pratinjau Berkas</h2>
                <p class="page-subtitle mb-0">
                    <?php if (!empty($owner_name)): ?>
                        Dokumen milik <strong><?= htmlspecialchars($owner_name) ?></strong> &bull; <?= htmlspecialchars($beasiswa_choice) ?>
                    <?php else: ?>
                        Melihat dokumen lampiran pendaftaran beasiswa
                    <?php endif; ?>
                </p>
            </div>
            <div>
                <a href="index.php?page=hasil" class="btn btn-outline-custom btn-custom d-flex align-items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="custom-card mb-5">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="card-header-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    </div>
                    <span class="card-header-title text-truncate" style="max-width: 300px;"><?= htmlspecialchars($file) ?></span>
                </div>
                
                <?php if ($file_exists): ?>
                    <div>
                        <a href="serve-file.php?file=<?= urlencode($file) ?>" download class="btn btn-primary-custom btn-sm py-2 px-3" style="border-radius: 8px; font-size: 0.85rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Unduh Berkas
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="card-body-custom p-3 bg-light d-flex justify-content-center align-items-center" style="min-height: 400px;">
                <?php if (!$file_exists): ?>
                    <div class="text-center py-5 w-100">
                        <div class="alert alert-danger custom-alert mx-auto d-inline-flex align-items-center gap-2 mb-3">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <span>Berkas tidak ditemukan atau nama berkas tidak valid.</span>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (in_array($ext, ['pdf'])): ?>
                        <div class="w-100" style="height: 75vh; min-height: 600px;">
                            <iframe src="serve-file.php?file=<?= urlencode($file) ?>#toolbar=0" width="100%" height="100%" style="border: none; border-radius: var(--radius-sm);" allow="fullscreen"></iframe>
                        </div>
                    <?php elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <div class="text-center p-2 w-100">
                            <img src="serve-file.php?file=<?= urlencode($file) ?>" class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;" alt="Pratinjau Berkas">
                        </div>
                    <?php elseif (in_array($ext, ['zip', 'rar'])): ?>
                        <div class="text-center py-5 w-100">
                            <div class="p-4 bg-white rounded shadow-sm mx-auto" style="max-width: 500px; border: 1px solid var(--border-color);">
                                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <h5 class="fw-bold mb-2">Berkas Kompresi (<?= strtoupper($ext) ?>)</h5>
                                <p class="text-muted small mb-4">Berkas ini tidak dapat dipratinjau langsung di web browser. Silakan unduh berkas untuk melihat isinya.</p>
                                <a href="serve-file.php?file=<?= urlencode($file) ?>" download class="btn btn-primary-custom btn-custom btn-sm">
                                    Unduh Berkas Sekarang
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 w-100">
                            <div class="p-4 bg-white rounded shadow-sm mx-auto" style="max-width: 500px; border: 1px solid var(--border-color);">
                                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <h5 class="fw-bold mb-2">Format Berkas Tidak Didukung</h5>
                                <p class="text-muted small mb-4">Jenis berkas (<?= strtoupper($ext) ?>) tidak dapat dipratinjau langsung. Silakan unduh secara manual.</p>
                                <a href="serve-file.php?file=<?= urlencode($file) ?>" download class="btn btn-primary-custom btn-custom btn-sm">
                                    Unduh Berkas
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
