<?php
// =====================================================
// KELUAR (LOGOUT)
// =====================================================

require __DIR__ . '/sesi.php';

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

session_destroy();

header('Location: login.php?keluar=1');
exit;
