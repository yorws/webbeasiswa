-- Skema Database Sistem Pendaftaran Beasiswa
-- Disediakan sebagai pemenuhan syarat, aplikasi utama menggunakan JSON storage.

CREATE DATABASE IF NOT EXISTS db_beasiswa;
USE db_beasiswa;

CREATE TABLE IF NOT EXISTS pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    semester INT NOT NULL,
    ipk DECIMAL(3,2) NOT NULL,
    pilihan_beasiswa VARCHAR(100) NOT NULL,
    berkas VARCHAR(255) NOT NULL,
    status_ajuan ENUM('Belum diverifikasi', 'Diterima', 'Ditolak') DEFAULT 'Belum diverifikasi',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
