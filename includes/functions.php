<?php
/**
 * File: functions.php
 * Deskripsi: Kumpulan fungsi pembantu (helper) untuk validasi, simulasi nilai, dan penanganan data (JSON).
 * Author: Antigravity IDE
 * Versi/Tanggal: 1.0 / 2026-07-04
 */

define('JSON_FILE', __DIR__ . '/../data.json');

/**
 * Deskripsi: Memvalidasi format alamat email.
 * Initial State: Menerima string email dari input user.
 * Final State: Mengembalikan nilai true jika format valid, false jika tidak.
 * @param string $email
 * @return bool
 */
function validate_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

/**
 * Deskripsi: Memvalidasi bahwa nomor HP hanya berisi angka.
 * Initial State: Menerima string nomor HP dari input user.
 * Final State: Mengembalikan nilai true jika hanya mengandung angka, false jika tidak.
 * @param string $phone
 * @return bool
 */
function validate_phone($phone) {
    if (preg_match('/^[0-9]+$/', $phone)) {
        return true;
    }
    return false;
}

/**
 * Deskripsi: Mensimulasikan perolehan IPK dari sistem akademik kampus.
 * Initial State: Tidak menerima parameter, berfungsi saat form pendaftaran dimuat.
 * Final State: Mengembalikan nilai IPK float (misal 2.9 atau 3.4) secara acak untuk simulasi,
 * atau nilai statis berdasarkan sesi. Untuk keperluan demo uji, kita buat array acak atau gunakan session.
 * @return float
 */
function get_ipk_simulation() {
    // Agar nilai IPK konsisten saat reload halaman (kecuali di-reset), simpan di session.
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['simulated_ipk'])) {
        // Acak antara 2.5 hingga 4.0 dengan 1 angka desimal
        $simulated_values = [2.5, 2.8, 2.9, 3.0, 3.2, 3.4, 3.6, 3.8, 4.0];
        $random_key = array_rand($simulated_values);
        $_SESSION['simulated_ipk'] = $simulated_values[$random_key];
    }
    
    return $_SESSION['simulated_ipk'];
}

/**
 * Deskripsi: Menyimpan data pendaftaran baru ke dalam file JSON.
 * Initial State: Menerima array asosiatif berisi data formulir yang sudah divalidasi.
 * Final State: Menyimpan data ke `data.json` dan mengembalikan nilai boolean (true=sukses).
 * @param array $data
 * @return bool
 */
function save_registration($data) {
    $current_data = get_all_registrations();
    
    // Menambahkan field status_ajuan dengan nilai default sesuai spesifikasi
    $data['status_ajuan'] = "Belum diverifikasi";
    $data['created_at'] = date('Y-m-d H:i:s');
    
    $current_data[] = $data;
    
    $json_string = json_encode($current_data, JSON_PRETTY_PRINT);
    if (file_put_contents(JSON_FILE, $json_string)) {
        return true;
    }
    return false;
}

/**
 * Deskripsi: Mengambil seluruh data pendaftaran dari file JSON.
 * Initial State: Tidak menerima parameter. File JSON mungkin belum ada.
 * Final State: Mengembalikan array berisi seluruh riwayat pendaftaran. Jika file tidak ada, kembalikan array kosong.
 * @return array
 */
function get_all_registrations() {
    if (!file_exists(JSON_FILE)) {
        return [];
    }
    
    $json_content = file_get_contents(JSON_FILE);
    $data = json_decode($json_content, true);
    
    if (is_array($data)) {
        return $data;
    }
    return [];
}
?>
