<?php
// =====================================================
// MIGRASI: pindahkan data lama dari data.json ke MySQL
// Buka sekali saja: http://localhost/penjualan/migrasi.php
// Setelah berhasil, file ini boleh dihapus.
// =====================================================

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/koneksi.php';
require __DIR__ . '/fungsi.php';

$file = __DIR__ . '/data.json';

echo "<h2>Migrasi data.json ke MySQL</h2>";

if (!file_exists($file)) {
    echo "<p>File <b>data.json</b> tidak ditemukan. Tidak ada data yang perlu dipindahkan.</p>";
    exit;
}

// Cegah data masuk dua kali
$jumlahDiDatabase = (int) $pdo->query("SELECT COUNT(*) FROM penjualan")->fetchColumn();

if ($jumlahDiDatabase > 0) {
    echo "<p>Tabel <b>penjualan</b> sudah berisi $jumlahDiDatabase data, jadi migrasi dibatalkan "
       . "supaya data tidak dobel.</p>";
    exit;
}

$lama = json_decode(file_get_contents($file), true);

if (!is_array($lama)) {
    echo "<p>Isi data.json tidak bisa dibaca (format JSON rusak).</p>";
    exit;
}

$berhasil = 0;
$gagal    = [];

$pdo->beginTransaction();

foreach ($lama as $i => $item) {

    $data = siapkanData($item);

    if (is_string($data)) {
        $gagal[] = "Data ke-" . ($i + 1) . " (" . htmlspecialchars($item['pelanggan'] ?? '-') . "): $data";
        continue;
    }

    tambahData($pdo, $data);
    $berhasil++;
}

$pdo->commit();

echo "<p>✅ Berhasil memindahkan <b>$berhasil</b> data ke MySQL.</p>";

if ($gagal) {
    echo "<p>⚠️ Data yang dilewati:</p><ul><li>" . implode("</li><li>", $gagal) . "</li></ul>";
}

echo "<p><a href='index.html'>Kembali ke dashboard</a></p>";
