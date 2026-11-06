<?php
/**
 * File: serve-file.php
 * Deskripsi: Menyajikan berkas secara aman dengan header inline untuk mencegah unduhan otomatis di browser.
 */

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = __DIR__ . '/uploads/' . $file;

    if (file_exists($filepath) && is_file($filepath)) {
        // Tentukan MIME type berdasarkan ekstensi secara eksplisit untuk keandalan maksimal
        $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'pdf':
                $mime = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $mime = 'image/jpeg';
                break;
            case 'png':
                $mime = 'image/png';
                break;
            case 'gif':
                $mime = 'image/gif';
                break;
            case 'zip':
                $mime = 'application/zip';
                break;
            case 'rar':
                $mime = 'application/x-rar-compressed';
                break;
            default:
                $mime = mime_content_type($filepath);
                break;
        }

        // Atur header HTTP
        header("Content-Type: " . $mime);
        
        // Jika file PDF atau gambar, tampilkan inline (di browser/iframe)
        // Jika file ZIP/RAR atau tidak dikenal, atur sebagai attachment (download)
        if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
            header("Content-Disposition: inline; filename=\"" . $file . "\"");
        } else {
            header("Content-Disposition: attachment; filename=\"" . $file . "\"");
        }
        
        header("Content-Length: " . filesize($filepath));
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Bersihkan buffer output PHP untuk menghindari korupsi file
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Baca dan keluarkan file
        readfile($filepath);
        exit;
    }
}

// Jika berkas tidak ditemukan
header("HTTP/1.0 404 Not Found");
echo "Berkas tidak ditemukan.";
?>
