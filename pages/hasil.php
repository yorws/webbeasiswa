<?php
/**
 * Menampilkan data pendaftaran yang telah tersimpan.
 */
$registrations = get_all_registrations();
?>

<div class="row mb-5 justify-content-center text-center">
    <div class="col-md-8">
        <h2 class="page-title">Hasil Seleksi Pendaftaran</h2>
        <p class="page-subtitle">Daftar mahasiswa yang telah mengajukan pendaftaran beasiswa dan status verifikasinya.</p>
    </div>
</div>

<div class="table-wrapper">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="15%">Nama Lengkap</th>
                    <th width="15%">Email</th>
                    <th width="12%">No HP</th>
                    <th width="10%" class="text-center">Semester</th>
                    <th width="8%" class="text-center">IPK</th>
                    <th width="15%">Pilihan Beasiswa</th>
                    <th width="10%" class="text-center">Berkas</th>
                    <th width="10%" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($registrations)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                <span>Belum ada data pendaftaran yang masuk.</span>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($registrations as $reg): ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $no++ ?></td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($reg['nama'] ?? '') ?></td>
                            <td class="text-muted"><?= htmlspecialchars($reg['email'] ?? '') ?></td>
                            <td class="text-muted"><?= htmlspecialchars($reg['nomor_hp'] ?? '') ?></td>
                            <td class="text-center"><?= htmlspecialchars($reg['semester'] ?? '') ?></td>
                            <td class="text-center fw-bold text-primary"><?= htmlspecialchars($reg['ipk'] ?? '') ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($reg['pilihan_beasiswa'] ?? '') ?></td>
                            <td class="text-center">
                                <?php if (!empty($reg['berkas'])): ?>
                                    <a href="index.php?page=view&file=<?= urlencode($reg['berkas']) ?>" target="_blank" class="btn btn-outline-custom btn-sm" style="padding: 0.25rem 0.75rem; border-radius: 6px;">Buka</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $status = $reg['status_ajuan'] ?? 'Belum diverifikasi';
                                    $badge_class = 'badge-warning-custom';
                                    if ($status == 'Diterima') $badge_class = 'badge-success-custom';
                                    if ($status == 'Ditolak') $badge_class = 'badge-danger-custom';
                                ?>
                                <span class="badge-custom <?= $badge_class ?>"><?= htmlspecialchars($status) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
