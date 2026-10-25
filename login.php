<?php
// =====================================================
// HALAMAN LOGIN ADMIN
// =====================================================

require __DIR__ . '/sesi.php';

// Sudah login? langsung ke dashboard
if (sudahLogin()) {
    header('Location: index.php');
    exit;
}

require __DIR__ . '/koneksi.php';

$pesan    = '';
$username = '';

try {

    // Belum ada akun admin sama sekali? buat dulu
    $jumlahAdmin = (int) $pdo->query("SELECT COUNT(*) FROM admin")->fetchColumn();

    if ($jumlahAdmin === 0) {
        header('Location: setup_admin.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        // password_verify mencocokkan password dengan hash di database
        if ($admin && password_verify($password, $admin['password'])) {

            session_regenerate_id(true);   // cegah pembajakan sesi

            $_SESSION['admin_id']   = (int) $admin['id'];
            $_SESSION['admin_nama'] = $admin['nama'];

            header('Location: index.php');
            exit;
        }

        sleep(1);   // perlambat percobaan tebak password
        $pesan = 'Username atau password salah.';
    }

} catch (PDOException $e) {

    $pesan = 'Tabel admin belum ada. Jalankan database_login.sql di phpMyAdmin dulu.';

}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Rekap Penjualan</title>
    <?php include __DIR__ . '/gaya_login.php'; ?>
</head>
<body>

<div class="kartu">

    <h1> Login Sayangku Cintaku Puput</h1>
    <p class="sub">Punya Cewek Kidut Only</p>

    <?php if (isset($_GET['baru'])): ?>
        <div class="pesan-sukses">Akun admin berhasil dibuat. Silakan login.</div>
    <?php endif; ?>

    <?php if (isset($_GET['keluar'])): ?>
        <div class="pesan-sukses">Anda sudah keluar.</div>
    <?php endif; ?>

    <?php if ($pesan): ?>
        <div class="pesan-error"><?= e($pesan) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="on">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= e($username) ?>" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Masuk</button>

    </form>

</div>

</body>
</html>
