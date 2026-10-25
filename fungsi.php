<?php
// =====================================================
// FUNGSI BANTU (dipakai api.php dan migrasi.php)
// =====================================================


// -----------------------------------------------------
// Cek & rapikan data dari form.
// Hasil: array data siap simpan, ATAU string pesan error.
// Pendapatan, profit, dan tanggal berakhir dihitung di
// server supaya nilainya selalu benar.
// -----------------------------------------------------

function siapkanData($d)
{
    $tanggal   = trim($d['tanggal']   ?? '');
    $pelanggan = trim($d['pelanggan'] ?? '');
    $noHp      = trim($d['noHp']      ?? '');
    $produk    = trim($d['produk']    ?? '');
    $paket     = trim($d['paket']     ?? '');
    $jumlah    = (int) ($d['jumlah']    ?? 0);
    $modal     = (int) ($d['modal']     ?? 0);
    $hargaJual = (int) ($d['hargaJual'] ?? 0);
    $masaAktif = (int) ($d['masaAktif'] ?? 0);
    $garansi   = trim($d['garansi']   ?? 'Ada');

    $tgl = DateTime::createFromFormat('Y-m-d', $tanggal);

    if (!$tgl || $tgl->format('Y-m-d') !== $tanggal) return "Tanggal order tidak valid.";
    if ($pelanggan === '')                           return "Nama pelanggan harus diisi.";
    if (!preg_match('/^[0-9]+$/', $noHp))            return "Nomor HP hanya boleh berisi angka.";
    if ($produk === '')                              return "Produk harus diisi.";
    if ($paket === '')                               return "Paket harus dipilih.";
    if ($jumlah <= 0)                                return "Jumlah order harus lebih dari 0.";
    if ($modal < 0)                                  return "Harga modal tidak valid.";
    if ($hargaJual <= 0)                             return "Harga jual tidak valid.";
    if ($masaAktif <= 0)                             return "Masa aktif tidak valid.";
    if (!in_array($garansi, ['Ada', 'Tidak Ada']))   return "Status garansi tidak valid.";

    $pendapatan = $jumlah * $hargaJual;
    $profit     = $pendapatan - ($jumlah * $modal);

    $berakhir = clone $tgl;
    $berakhir->modify('+' . ($masaAktif - 1) . ' day');

    return [
        'tanggal'          => $tanggal,
        'pelanggan'        => $pelanggan,
        'no_hp'            => $noHp,
        'produk'           => $produk,
        'paket'            => $paket,
        'jumlah'           => $jumlah,
        'modal'            => $modal,
        'harga_jual'       => $hargaJual,
        'pendapatan'       => $pendapatan,
        'profit'           => $profit,
        'masa_aktif'       => $masaAktif,
        'tanggal_berakhir' => $berakhir->format('Y-m-d'),
        'garansi'          => $garansi
    ];
}


// -----------------------------------------------------
// Ubah 1 baris database (nama kolom snake_case) ke format
// yang dipakai JavaScript (camelCase), supaya tampilan
// tabel di index.html tidak perlu diubah.
// -----------------------------------------------------

function ubahKeFormatJs($r)
{
    return [
        'id'              => (int) $r['id'],
        'tanggal'         => $r['tanggal'],
        'pelanggan'       => $r['pelanggan'],
        'noHp'            => $r['no_hp'],
        'produk'          => $r['produk'],
        'paket'           => $r['paket'],
        'jumlah'          => (int) $r['jumlah'],
        'modal'           => (int) $r['modal'],
        'hargaJual'       => (int) $r['harga_jual'],
        'pendapatan'      => (int) $r['pendapatan'],
        'profit'          => (int) $r['profit'],
        'masaAktif'       => (int) $r['masa_aktif'],
        'tanggalMulai'    => $r['tanggal'],
        'tanggalBerakhir' => $r['tanggal_berakhir'],
        'garansi'         => $r['garansi']
    ];
}


// -----------------------------------------------------
// Simpan data baru (INSERT)
// -----------------------------------------------------

function tambahData($pdo, $data)
{
    $sql = "INSERT INTO penjualan
                (tanggal, pelanggan, no_hp, produk, paket, jumlah, modal,
                 harga_jual, pendapatan, profit, masa_aktif, tanggal_berakhir, garansi)
            VALUES
                (:tanggal, :pelanggan, :no_hp, :produk, :paket, :jumlah, :modal,
                 :harga_jual, :pendapatan, :profit, :masa_aktif, :tanggal_berakhir, :garansi)";

    $pdo->prepare($sql)->execute($data);
}
