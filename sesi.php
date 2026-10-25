<?php
// =====================================================
// SESI LOGIN
// Di-include di setiap halaman yang butuh login.
// =====================================================

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'httponly' => true,     // cookie sesi tidak bisa dibaca JavaScript
        'samesite' => 'Lax'     // cookie tidak terkirim dari website lain
    ]);

    session_start();
}


function sudahLogin()
{
    return isset($_SESSION['admin_id']);
}


// Untuk halaman: kalau belum login, pindahkan ke login.php
function wajibLogin()
{
    if (!sudahLogin()) {
        header('Location: login.php');
        exit;
    }
}


// Untuk API: kalau belum login, balas error 401 (JSON)
function wajibLoginApi()
{
    if (!sudahLogin()) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Sesi habis, silakan login lagi.']);
        exit;
    }
}


// Amankan teks sebelum ditampilkan di HTML
function e($teks)
{
    return htmlspecialchars($teks ?? '', ENT_QUOTES, 'UTF-8');
}
