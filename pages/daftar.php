<?php
/**
 * Logika PHP untuk form submission
 */
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $nomor_hp = trim($_POST['nomor_hp']);
    $semester = (int) $_POST['semester'];
    $ipk = isset($_POST['ipk']) ? (float) $_POST['ipk'] : 0; // Mengambil nilai dari dropdown simulasi IPK
    $pilihan_beasiswa = isset($_POST['pilihan_beasiswa']) ? trim($_POST['pilihan_beasiswa']) : '';
    
    // Validasi server-side
    $errors = [];
    
    if (empty($nama)) $errors[] = "Nama tidak boleh kosong.";
    if (!validate_email($email)) $errors[] = "Format email tidak valid.";
    if (!validate_phone($nomor_hp)) $errors[] = "Nomor HP harus berupa angka.";
    
    // Validasi Logika IPK (Server side check)
    if ($ipk < 3.0) {
        $errors[] = "IPK Anda tidak memenuhi syarat minimal (3.00).";
    } else {
        if (empty($pilihan_beasiswa)) $errors[] = "Silakan pilih jenis beasiswa.";
        
        // Handle file upload
        $berkas_nama = '';
        if (isset($_FILES['berkas']) && $_FILES['berkas']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['berkas']['tmp_name'];
            $file_name = time() . '_' . basename($_FILES['berkas']['name']);
            $upload_dir = 'uploads/';
            
            // Cek apakah direktori uploads ada, jika tidak, buat
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
                $berkas_nama = $file_name;
            } else {
                $errors[] = "Gagal mengunggah berkas syarat.";
            }
        } else {
            $errors[] = "Berkas syarat wajib diunggah.";
        }
    }
    
    // Jika tidak ada error, simpan data
    if (empty($errors)) {
        $data_pendaftaran = [
            'id' => uniqid(),
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'nomor_hp' => htmlspecialchars($nomor_hp),
            'semester' => $semester,
            'ipk' => $ipk,
            'pilihan_beasiswa' => htmlspecialchars($pilihan_beasiswa),
            'berkas' => $berkas_nama
        ];
        
        if (save_registration($data_pendaftaran)) {
            $message = "Pendaftaran berhasil! Data Anda telah tersimpan.";
            $message_type = "success";
            
            // Generate IPK baru untuk simulasi pendaftar berikutnya (opsional)
            unset($_SESSION['simulated_ipk']);
        } else {
            $message = "Terjadi kesalahan saat menyimpan data.";
            $message_type = "danger";
        }
    } else {
        $message = implode("<br>", $errors);
        $message_type = "danger";
    }
}

// Simulasi mengambil nilai IPK
$simulated_ipk = get_ipk_simulation();
?>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        
        <div class="text-center mb-5">
            <h2 class="page-title">Form Registrasi</h2>
            <p class="page-subtitle">Isi data diri Anda dengan lengkap dan benar.</p>
        </div>
        
        <div class="custom-card">
            <div class="card-body-custom p-sm-5">
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-custom alert-<?= $message_type === 'danger' ? 'warning-custom' : 'success' ?> mb-4">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <form id="formBeasiswa" action="index.php?page=daftar" method="POST" enctype="multipart/form-data">
                    
                    <div class="row mb-4">
                        <div class="col-md-6 form-group-custom">
                            <label for="nama" class="form-label-custom">Nama Lengkap</label>
                            <input type="text" class="form-control-custom" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="col-md-6 form-group-custom">
                            <label for="email" class="form-label-custom">Alamat Email</label>
                            <input type="email" class="form-control-custom" id="email" name="email" placeholder="contoh@kampus.edu" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 form-group-custom">
                            <label for="nomor_hp" class="form-label-custom">Nomor HP</label>
                            <input type="text" class="form-control-custom" id="nomor_hp" name="nomor_hp" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6 form-group-custom">
                            <label for="semester" class="form-label-custom">Semester Saat Ini</label>
                            <select class="form-select-custom" id="semester" name="semester" required>
                                <option value="">-- Pilih Semester --</option>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>">Semester <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group-custom mb-4">
                        <label for="ipk" class="form-label-custom">Indeks Prestasi Kumulatif (IPK)</label>
                        <select class="form-select-custom" id="ipk" name="ipk" required>
                            <option value="3.4">3.4</option>
                            <option value="2.9">2.9</option>
                        </select>
                        <small class="text-muted mt-2 d-block">Pilih nilai untuk mensimulasikan nilai IPK yang ditarik dari sistem.</small>
                    </div>

                    <div class="form-group-custom mb-4">
                        <label for="pilihan_beasiswa" class="form-label-custom">Pilihan Beasiswa</label>
                        <select class="form-select-custom" id="pilihan_beasiswa" name="pilihan_beasiswa" required>
                            <option value="">-- Pilih Program Beasiswa --</option>
                            <option value="Beasiswa Akademik">Beasiswa Akademik</option>
                            <option value="Beasiswa Non-Akademik">Beasiswa Non-Akademik</option>
                        </select>
                    </div>

                    <div class="form-group-custom mb-5">
                        <label for="berkas" class="form-label-custom">Upload Berkas Syarat</label>
                        <input class="form-control-custom" type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png,.zip" required>
                    </div>

                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                        <a href="index.php?page=pilihan-beasiswa" class="btn btn-outline-custom btn-custom">Batal</a>
                        <button type="submit" name="submit" id="btnDaftar" class="btn btn-primary-custom btn-custom">Kirim Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
