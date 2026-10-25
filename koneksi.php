<?php
// =====================================================
// KONEKSI DATABASE (MySQL XAMPP)
// Sesuaikan kalau user/password MySQL Anda berbeda.
// =====================================================

$host     = "localhost";
$user     = "root";
$password = "";              // default XAMPP: kosong
$database = "db_penjualan";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Koneksi database gagal. Pastikan MySQL di XAMPP sudah Start '
                 . 'dan database db_penjualan sudah dibuat. (' . $e->getMessage() . ')'
    ]);
    exit;

}
