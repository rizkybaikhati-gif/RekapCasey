<?php
// =====================================================
// BUAT AKUN ADMIN PERTAMA
// Hanya bisa dipakai selama tabel admin masih kosong.
// Setelah akun dibuat, halaman ini otomatis terkunci.
// =====================================================

require __DIR__ . '/sesi.php';
require __DIR__ . '/koneksi.php';

$pesan    = '';
$nama     = '';
$username = '';
$terkunci = false;

try {

    $jumlahAdmin = (int) $pdo->query("SELECT COUNT(*) FROM admin")->fetchColumn();
    $terkunci = $jumlahAdmin > 0;

    if (!$terkunci && $_SERVER['REQUEST_METHOD'] === 'POST') {

        $nama       = trim($_POST['nama'] ?? '');
        $username   = trim($_POST['username'] ?? '');
        $password   = $_POST['password'] ?? '';
        $konfirmasi = $_POST['konfirmasi'] ?? '';

        if ($nama === '') {
            $pesan = 'Nama harus diisi.';
        } elseif (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
            $pesan = 'Username 3–50 karakter, hanya huruf, angka, dan garis bawah (_).';
        } elseif (strlen($password) < 6) {
            $pesan = 'Password minimal 6 karakter.';
        } elseif ($password !== $konfirmasi) {
            $pesan = 'Konfirmasi password tidak sama.';
        } else {

            // password_hash mengubah password jadi kode acak yang tidak bisa dibalik
            $stmt = $pdo->prepare("INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)");
            $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT)]);

            header('Location: login.php?baru=1');
            exit;
        }
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
    <title>Buat Akun Admin</title>
    <?php include __DIR__ . '/gaya_login.php'; ?>
</head>
<body>

<div class="kartu">

    <h1>👤 Buat Akun Admin</h1>

    <?php if ($terkunci): ?>

        <p class="sub">Akun admin sudah ada, jadi halaman ini dikunci.</p>
        <p><a href="login.php">Ke halaman login</a></p>

    <?php else: ?>

        <p class="sub">Akun pertama untuk masuk ke dashboard.</p>

        <?php if ($pesan): ?>
            <div class="pesan-error"><?= e($pesan) ?></div>
        <?php endif; ?>

        <form method="post">

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" placeholder="Contoh: Puput" required autofocus>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= e($username) ?>" placeholder="Contoh: admin" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <p class="kecil">Minimal 6 karakter.</p>

            <label for="konfirmasi">Ulangi Password</label>
            <input type="password" id="konfirmasi" name="konfirmasi" required>

            <button type="submit">Buat Akun</button>

        </form>

    <?php endif; ?>

</div>

</body>
</html>
