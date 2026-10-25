<?php
// =====================================================
// API DATA PENJUALAN (versi MySQL)
//
// GET  api.php                                  -> ambil semua data
// POST api.php {"aksi":"tambah", "data":{...}}  -> tambah data
// POST api.php {"aksi":"edit",   "data":{...}}  -> edit data (data.id wajib)
// POST api.php {"aksi":"hapus",  "id":5}        -> hapus 1 data
// POST api.php {"aksi":"hapus_semua"}           -> hapus semua data
// =====================================================

header('Content-Type: application/json');

// Tolak semua permintaan dari yang belum login
require __DIR__ . '/sesi.php';
wajibLoginApi();

require __DIR__ . '/koneksi.php';
require __DIR__ . '/fungsi.php';


function balas($isi, $kode = 200)
{
    http_response_code($kode);
    echo json_encode($isi, JSON_UNESCAPED_UNICODE);
    exit;
}


try {

    // ---------------- AMBIL DATA ----------------

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $baris = $pdo->query("SELECT * FROM penjualan ORDER BY tanggal ASC, id ASC")->fetchAll();

        balas(array_map('ubahKeFormatJs', $baris));
    }


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        balas(['error' => 'Metode tidak diizinkan'], 405);
    }


    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        balas(['error' => 'Data yang dikirim tidak valid'], 400);
    }

    $aksi = $input['aksi'] ?? '';


    switch ($aksi) {

        // ---------------- TAMBAH ----------------

        case 'tambah':

            $data = siapkanData($input['data'] ?? []);

            if (is_string($data)) {
                balas(['error' => $data], 400);
            }

            tambahData($pdo, $data);

            balas(['status' => 'ok', 'id' => (int) $pdo->lastInsertId()]);


        // ---------------- EDIT ----------------

        case 'edit':

            $id = (int) ($input['data']['id'] ?? 0);

            $cek = $pdo->prepare("SELECT id FROM penjualan WHERE id = ?");
            $cek->execute([$id]);

            if (!$cek->fetch()) {
                balas(['error' => 'Data yang diedit tidak ditemukan (mungkin sudah dihapus).'], 404);
            }

            $data = siapkanData($input['data']);

            if (is_string($data)) {
                balas(['error' => $data], 400);
            }

            $data['id'] = $id;

            $sql = "UPDATE penjualan SET
                        tanggal = :tanggal,
                        pelanggan = :pelanggan,
                        no_hp = :no_hp,
                        produk = :produk,
                        paket = :paket,
                        jumlah = :jumlah,
                        modal = :modal,
                        harga_jual = :harga_jual,
                        pendapatan = :pendapatan,
                        profit = :profit,
                        masa_aktif = :masa_aktif,
                        tanggal_berakhir = :tanggal_berakhir,
                        garansi = :garansi
                    WHERE id = :id";

            $pdo->prepare($sql)->execute($data);

            balas(['status' => 'ok']);


        // ---------------- HAPUS 1 DATA ----------------

        case 'hapus':

            $hapus = $pdo->prepare("DELETE FROM penjualan WHERE id = ?");
            $hapus->execute([(int) ($input['id'] ?? 0)]);

            balas(['status' => 'ok']);


        // ---------------- HAPUS SEMUA ----------------

        case 'hapus_semua':

            $pdo->exec("DELETE FROM penjualan");

            balas(['status' => 'ok']);


        default:

            balas(['error' => 'Aksi tidak dikenal: ' . $aksi], 400);
    }

} catch (PDOException $e) {

    balas(['error' => 'Kesalahan database: ' . $e->getMessage()], 500);

}
