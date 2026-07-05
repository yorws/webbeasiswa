# Sistem Pendaftaran Beasiswa Online

Aplikasi web untuk pendaftaran beasiswa kampus secara online. Aplikasi ini menggunakan PHP Native, HTML, CSS, JavaScript (termasuk Bootstrap 5) dan menyimpan data dalam format JSON, sehingga dapat langsung dijalankan (zero configuration) di lingkungan XAMPP tanpa setup database MySQL. Skema database SQL juga disertakan sebagai pemenuhan syarat kelengkapan (BNSP).

## Struktur Folder & File

- `assets/` : Berisi file CSS (`assets/css/style.css`), JavaScript (`assets/js/script.js`), dan gambar jika ada.
- `includes/` : Berisi file-file pendukung PHP seperti `functions.php` (berisi kumpulan fungsi logika validasi dan manipulasi JSON).
- `pages/` : Berisi halaman-halaman utama yang di-include oleh router:
  - `pilihan-beasiswa.php`: Menampilkan daftar pilihan beasiswa.
  - `daftar.php`: Menampilkan form pendaftaran dengan logika disable/enable form berdasarkan IPK.
  - `hasil.php`: Menampilkan data hasil pendaftaran dari JSON beserta status ajuan.
- `uploads/` : Direktori tempat menyimpan berkas syarat pendaftaran yang diunggah oleh user.
- `index.php` : Sebagai file entry point (Router Utama) yang mengatur tata letak (navbar/header/footer) dan include konten halaman berdasarkan parameter URL (contoh: `?page=daftar`).
- `data.json` : File penyimpanan (pengganti database) yang memuat data seluruh pendaftar. Otomatis ter-generate jika belum ada.
- `database_schema.sql` : Skema struktur tabel jika aplikasi ini diimplementasikan menggunakan database MySQL.

## Fitur & Logika Bisnis Utama
1. **Validasi Input**: Validasi Email (format yang benar) dan Nomor HP (hanya angka). Dilakukan di sisi klien (JavaScript) dan diserver-side (PHP).
2. **Simulasi IPK**: IPK mahasiswa dimuat otomatis saat membuka form `daftar`.
3. **Logika Validasi IPK**: 
   - Jika `IPK < 3`, input Pilihan Beasiswa, Upload Berkas, dan Tombol Daftar dinonaktifkan (disabled).
   - Jika `IPK >= 3`, semua input aktif dan fokus otomatis ke dropdown "Pilihan Beasiswa".
4. **Status Ajuan**: Setiap pendaftaran yang berhasil akan disimpan dengan status default "Belum diverifikasi".

## Library & Teknologi (Open Source)
- **Bootstrap 5** (via CDN) : Digunakan untuk styling UI agar responsif dan terlihat profesional (Lisensi MIT).
- **PHP Native** : Pemrograman backend.
- **Vanilla JavaScript** : Menangani interaktivitas UI dan validasi frontend sederhana tanpa library eksternal JS lain.

## Cara Instalasi & Menjalankan (XAMPP)
1. Letakkan seluruh folder aplikasi ini di dalam direktori `htdocs` XAMPP (misal: `C:\xampp\htdocs\webwisuda\`).
2. Buka XAMPP Control Panel, pastikan **Apache** sudah berjalan (Start).
3. Buka browser, akses alamat: `http://localhost/webwisuda/`
4. Aplikasi akan otomatis menggunakan file `data.json` untuk penyimpanan pendaftaran. Tidak perlu koneksi MySQL.
