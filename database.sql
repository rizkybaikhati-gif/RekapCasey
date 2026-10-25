-- =====================================================
-- DATABASE DASHBOARD REKAP PENJUALAN
-- Jalankan sekali saja di phpMyAdmin (tab SQL)
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_penjualan
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE db_penjualan;

CREATE TABLE IF NOT EXISTS penjualan (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    tanggal          DATE         NOT NULL,
    pelanggan        VARCHAR(100) NOT NULL,
    no_hp            VARCHAR(20)  NOT NULL,
    produk           VARCHAR(100) NOT NULL,
    paket            VARCHAR(50)  NOT NULL,
    jumlah           INT          NOT NULL,
    modal            BIGINT       NOT NULL DEFAULT 0,
    harga_jual       BIGINT       NOT NULL,
    pendapatan       BIGINT       NOT NULL,
    profit           BIGINT       NOT NULL,
    masa_aktif       INT          NOT NULL,
    tanggal_berakhir DATE         NOT NULL,
    garansi          VARCHAR(20)  NOT NULL,
    dibuat_pada      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);
