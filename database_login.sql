-- =====================================================
-- TABEL ADMIN UNTUK FITUR LOGIN
-- Jalankan sekali di phpMyAdmin (tab SQL)
-- Password TIDAK disimpan di sini: akun admin pertama
-- dibuat lewat halaman setup_admin.php supaya password
-- tersimpan dalam bentuk hash.
-- =====================================================

USE db_penjualan;

CREATE TABLE IF NOT EXISTS admin (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    dibuat_pada TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);
