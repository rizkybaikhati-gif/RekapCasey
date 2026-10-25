<?php
// Halaman ini hanya bisa dibuka setelah login
require __DIR__ . '/sesi.php';
wajibLogin();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Rekap Penjualan</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: "Segoe UI", Arial, sans-serif;
            background: rgb(253, 168, 191);
            color: #1e293b;
        }

        .container {
            max-width: 1500px;
            margin: auto;
        }

        /* ================= HEADER ================= */

        .header {
            background: rgb(255, 219, 219);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgb(96,77,83);
            font-weight: bold;
        }

        .btn-logout {
            padding: 9px 16px;
            border-radius: 7px;
            background: rgb(96,77,83);
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-logout:hover {
            background: rgb(70,55,60);
        }

        .header h1 {
            margin: 0;
            font-size: 27px;
            color: rgb(96,77,83);
        }

        .header p {
            margin: 8px 0 0;
            color: #64748b;
        }

        /* ================= DASHBOARD ================= */

        .dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 15px;
            margin-bottom: 10px;
            color: #64748b;
        }

        .card-value {
            font-size: 28px;
            font-weight: bold;
            color: rgb(96,77,83);
        }

        .pendapatan { background: rgb(250, 248, 242); }
        .order      { background: rgb(247, 249, 234); }
        .profit     { background: rgb(221, 236, 217); }

        /* ================= BOX ================= */

        .box {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .box h2 {
            margin-top: 0;
            color: #334155;
            font-size: 20px;
        }

        /* ================= FORM ================= */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: bold;
            color: #475569;
        }

        input,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
        }

        .button-add {
            margin-top: 20px;
            padding: 12px 22px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .button-add:hover {
            background: #1d4ed8;
        }

        /* ================= FILTER ================= */

        .filter {
            display: flex;
            gap: 10px;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-item label {
            font-size: 13px;
            font-weight: bold;
        }

        .button-filter,
        .button-reset {
            padding: 11px 18px;
            border: none;
            border-radius: 7px;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .button-filter { background: #475569; }
        .button-reset  { background: #94a3b8; }

        /* ================= TABLE ================= */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1650px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .profit-text {
            color: #15803d;
            font-weight: bold;
        }

        /* ================= STATUS MASA AKTIF ================= */

        .aktif,
        .akan-expired,
        .expired {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .aktif        { background: #dcfce7; color: #15803d; }
        .akan-expired { background: #fef3c7; color: #b45309; }
        .expired      { background: #fee2e2; color: #dc2626; }

        /* ================= WHATSAPP ================= */

        .btn-whatsapp {
            display: inline-block;
            margin-top: 5px;
            padding: 5px 8px;
            border-radius: 5px;
            background: #22c55e;
            color: white;
            text-decoration: none;
            font-size: 11px;
            font-weight: bold;
        }

        /* ================= DELETE ================= */

        .btn-delete {
            padding: 7px 10px;
            border: none;
            border-radius: 5px;
            background: #ef4444;
            color: white;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        /* ================= EDIT ================= */

        .btn-edit {
            padding: 7px 10px;
            border: none;
            border-radius: 5px;
            background: #f59e0b;
            color: white;
            cursor: pointer;
            font-size: 12px;
            margin-right: 4px;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .button-cancel {
            margin-top: 20px;
            margin-left: 8px;
            padding: 12px 22px;
            border: none;
            border-radius: 7px;
            background: #94a3b8;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .button-cancel:hover {
            background: #64748b;
        }

        /* Form diberi garis oranye saat mode edit */
        .form-box.mode-edit {
            outline: 3px solid #f59e0b;
        }

        /* Baris yang sedang diedit */
        tr.sedang-diedit td {
            background: #fef3c7;
        }

        td.kolom-aksi {
            white-space: nowrap;
        }

        /* ================= EMPTY ================= */

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        /* ================= BUTTON BAWAH ================= */

        .bottom-button {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-print,
        .btn-clear {
            padding: 11px 18px;
            border: none;
            border-radius: 7px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-print { background: #64748b; }
        .btn-clear { background: #ef4444; }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 900px) {
            .dashboard { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 600px) {
            body { padding: 10px; }
            .form-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 21px; }
        }

        /* ================= PRINT ================= */

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .form-box,
            .filter-box,
            .header-user,
            .bottom-button,
            .btn-edit,
            .btn-delete,
            .btn-whatsapp {
                display: none !important;
            }

            table {
                min-width: 100%;
            }

        }

    </style>

</head>


<body>

<div class="container">

    <!-- ================= HEADER ================= -->

    <div class="header">

        <div>
            <h1>Dashboard Rekap Penjualan</h1>
            <p>Pelanggan Punya Pute</p>
        </div>

        <div class="header-user">
            <span>👤 <?= e($_SESSION['admin_nama'] ?? 'Admin') ?></span>
            <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin keluar?')">Keluar</a>
        </div>

    </div>


    <!-- ================= DASHBOARD ================= -->

    <div class="dashboard">

        <div class="card pendapatan">
            <div class="card-title">💰 Total Pendapatan</div>
            <div class="card-value" id="totalPendapatan">Rp 0</div>
        </div>

        <div class="card order">
            <div class="card-title">🛒 Total Orderan</div>
            <div class="card-value" id="totalOrder">0</div>
        </div>

        <div class="card profit">
            <div class="card-title">📈 Total Profit</div>
            <div class="card-value" id="totalProfit">Rp 0</div>
        </div>

    </div>


    <!-- ================= FORM TAMBAH PENJUALAN ================= -->

    <div class="box form-box">

        <h2 id="judulForm">Tambah Penjualan</h2>

        <div class="form-grid">

            <div class="form-group">
                <label>Tanggal Order</label>
                <input type="date" id="tanggal">
            </div>

            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" id="pelanggan" placeholder="Contoh: Puput">
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input type="tel" id="noHp" placeholder="08123456789" inputmode="numeric">
            </div>

            <div class="form-group">
                <label>Produk</label>
                <input type="text" id="produk" placeholder="Contoh: Netflix">
            </div>

            <!-- PERBAIKAN: value setiap paket sekarang sama dengan labelnya -->
            <div class="form-group">
                <label>Paket</label>
                <select id="paket">
                    <option value="">-- Pilih Paket --</option>
                    <option value="1P 1U">1P 1U</option>
                    <option value="1P 2U">1P 2U</option>
                    <option value="Sharing 8U">Sharing 8U</option>
                    <option value="Sharing 5U">Sharing 5U</option>
                    <option value="Sharing 4U">Sharing 4U</option>
                    <option value="Sharing 3U">Sharing 3U</option>
                    <option value="Sharing 2U">Sharing 2U</option>
                    <option value="Semi Private">Semi Private</option>
                    <option value="Private">Private</option>
                    <option value="Life Time">Life Time</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Order</label>
                <input type="number" id="jumlah" min="1" value="1">
            </div>

            <div class="form-group">
                <label>Harga Modal / Unit</label>
                <input type="number" id="modal" min="0" placeholder="Contoh: 15000">
            </div>

            <div class="form-group">
                <label>Harga Jual / Unit</label>
                <input type="number" id="hargaJual" min="0" placeholder="Contoh: 20000">
            </div>

            <!-- PERBAIKAN: value (jumlah hari) sekarang sesuai labelnya -->
            <div class="form-group">
                <label>Masa Aktif Buyer</label>
                <select id="masaAktif">
                    <option value="1">1 Hari</option>
                    <option value="3">3 Hari</option>
                    <option value="5" selected>5 Hari</option>
                    <option value="7">7 Hari</option>
                    <option value="30">1 Bulan</option>
                    <option value="60">2 Bulan</option>
                    <option value="90">3 Bulan</option>
                    <option value="180">6 Bulan</option>
                    <option value="365">1 Tahun</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status Garansi</label>
                <select id="garansi">
                    <option value="Ada">🟢 Ada Garansi</option>
                    <option value="Tidak Ada">❌ Tidak Ada Garansi</option>
                </select>
            </div>

        </div>

        <button class="button-add" id="btnSimpan" onclick="tambahPenjualan()">
            + Tambah Order
        </button>

        <button class="button-cancel" id="btnBatal" onclick="batalEdit()" style="display: none;">
            Batal Edit
        </button>

    </div>


    <!-- ================= FILTER ================= -->

    <div class="box filter-box">

        <h2>🔎 Filter Penjualan</h2>

        <div class="filter">

            <div class="filter-item">
                <label>Pilih Tanggal</label>
                <input type="date" id="filterTanggal">
            </div>

            <button class="button-filter" onclick="filterTanggal()">Tampilkan</button>
            <button class="button-reset" onclick="resetFilter()">Semua Data</button>

        </div>

    </div>


    <!-- ================= TABEL ================= -->

    <div class="box">

        <h2>📋 Riwayat Penjualan</h2>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Order</th>
                        <th>Pelanggan</th>
                        <th>No. HP</th>
                        <th>Produk</th>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Modal</th>
                        <th>Harga Jual</th>
                        <th>Pendapatan</th>
                        <th>Profit</th>
                        <th>Masa Aktif</th>
                        <th>Mulai</th>
                        <th>Berakhir</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabelPenjualan">
                    <tr><td colspan="17" class="empty">Memuat data...</td></tr>
                </tbody>

            </table>

        </div>

        <div class="bottom-button">
            <button class="btn-print" onclick="window.print()">🖨️ Cetak Laporan</button>
            <button class="btn-clear" onclick="hapusSemua()">🗑️ Hapus Semua</button>
        </div>

    </div>

</div>


<script>

    // =====================================================
    // DATA PENJUALAN
    // Data disimpan di database MySQL lewat api.php.
    // dataPenjualan hanya salinan untuk ditampilkan.
    // =====================================================

    let dataPenjualan = [];
    let dataTampil = [];

    // id data yang sedang diedit (null = mode tambah)
    let editId = null;


    // =====================================================
    // MUAT DATA DARI DATABASE
    // =====================================================

    async function muatData() {

        try {

            const res = await fetch("api.php");

            if (res.status === 401) {
                sesiHabis();
                return;
            }

            const hasil = await res.json();

            if (!res.ok) {
                throw new Error(hasil.error || ("Server error " + res.status));
            }

            dataPenjualan = hasil;

        } catch (e) {

            alert(
                "Gagal memuat data dari server.\n\n" +
                e.message + "\n\n" +
                "Pastikan Apache dan MySQL di XAMPP menyala, dan halaman dibuka lewat\n" +
                "http://localhost/penjualan/ (bukan double-click file)."
            );

        }

        // Pertahankan filter tanggal kalau sedang dipakai
        const filter = document.getElementById("filterTanggal").value;

        dataTampil = filter
            ? dataPenjualan.filter(item => item.tanggal === filter)
            : [...dataPenjualan];

        tampilkanData();

    }


    // =====================================================
    // SESI HABIS -> kembali ke halaman login
    // =====================================================

    function sesiHabis() {

        alert("Sesi login Anda sudah habis. Silakan login lagi.");

        window.location.href = "login.php";

    }


    // =====================================================
    // KIRIM PERINTAH KE SERVER (tambah / edit / hapus)
    // Hasil: true kalau berhasil, false kalau gagal.
    // =====================================================

    async function kirim(aksi, isi = {}) {

        try {

            const res = await fetch("api.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ aksi: aksi, ...isi })
            });

            if (res.status === 401) {
                sesiHabis();
                return false;
            }

            const hasil = await res.json();

            if (!res.ok) {
                alert("Gagal: " + (hasil.error || ("Server error " + res.status)));
                return false;
            }

            return true;

        } catch (e) {

            alert("Gagal terhubung ke server! Perubahan belum tersimpan.");
            return false;

        }

    }


    // =====================================================
    // FORMAT RUPIAH
    // =====================================================

    function rupiah(angka) {

        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0
        }).format(angka);

    }


    // =====================================================
    // FORMAT TANGGAL
    // =====================================================

    function formatTanggal(tanggal) {

        if (!tanggal) {
            return "-";
        }

        const date = new Date(tanggal + "T00:00:00");

        return date.toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric"
        });

    }


    function formatTanggalInput(date) {

        const tahun = date.getFullYear();
        const bulan = String(date.getMonth() + 1).padStart(2, "0");
        const hari  = String(date.getDate()).padStart(2, "0");

        return tahun + "-" + bulan + "-" + hari;

    }


    // =====================================================
    // HITUNG TANGGAL BERAKHIR
    // =====================================================

    function hitungTanggalBerakhir(tanggalMulai, jumlahHari) {

        const tanggal = new Date(tanggalMulai + "T00:00:00");

        tanggal.setDate(tanggal.getDate() + Number(jumlahHari) - 1);

        return formatTanggalInput(tanggal);

    }


    // =====================================================
    // HITUNG SISA HARI
    // =====================================================

    function hitungSisaHari(tanggalMulai, tanggalBerakhir) {

        const sekarang = new Date();
        sekarang.setHours(0, 0, 0, 0);

        const mulai = new Date(tanggalMulai + "T00:00:00");
        const akhir = new Date(tanggalBerakhir + "T00:00:00");

        if (sekarang < mulai) {
            return { hari: 0, status: "Belum Mulai", className: "akan-expired" };
        }

        if (sekarang > akhir) {
            return { hari: 0, status: "🔴 Expired", className: "expired" };
        }

        const selisih = akhir.getTime() - sekarang.getTime();
        const hari = Math.floor(selisih / (1000 * 60 * 60 * 24)) + 1;

        if (hari <= 3) {
            return { hari: hari, status: "🟠 Akan Berakhir", className: "akan-expired" };
        }

        return { hari: hari, status: "🟢 Aktif", className: "aktif" };

    }


    // =====================================================
    // TAMBAH PENJUALAN
    // =====================================================

    async function tambahPenjualan() {

        const tanggal   = document.getElementById("tanggal").value;
        const pelanggan = document.getElementById("pelanggan").value.trim();
        const noHp      = document.getElementById("noHp").value.trim();
        const produk    = document.getElementById("produk").value.trim();
        const paket     = document.getElementById("paket").value;
        const jumlah    = Number(document.getElementById("jumlah").value);
        const modal     = Number(document.getElementById("modal").value);
        const hargaJual = Number(document.getElementById("hargaJual").value);
        const masaAktif = Number(document.getElementById("masaAktif").value);
        const garansi   = document.getElementById("garansi").value;


        // VALIDASI

        if (!tanggal)                { alert("Tanggal order harus diisi!"); return; }
        if (!pelanggan)              { alert("Nama pelanggan harus diisi!"); return; }
        if (!noHp)                   { alert("Nomor HP harus diisi!"); return; }
        if (!/^[0-9]+$/.test(noHp))  { alert("Nomor HP hanya boleh berisi angka!"); return; }
        if (!produk)                 { alert("Produk harus diisi!"); return; }
        if (!paket)                  { alert("Silakan pilih paket!"); return; }
        if (jumlah <= 0)             { alert("Jumlah order harus lebih dari 0!"); return; }
        if (modal < 0)               { alert("Harga modal tidak valid!"); return; }
        if (hargaJual <= 0)          { alert("Harga jual tidak valid!"); return; }


        // DATA
        // Pendapatan, profit, dan tanggal berakhir dihitung di server (fungsi.php)

        const data = {
            tanggal: tanggal,
            pelanggan: pelanggan,
            noHp: noHp,
            produk: produk,
            paket: paket,
            jumlah: jumlah,
            modal: modal,
            hargaJual: hargaJual,
            masaAktif: masaAktif,
            garansi: garansi
        };

        const tadiEdit = editId !== null;

        let berhasil;

        if (tadiEdit) {
            berhasil = await kirim("edit", { data: { ...data, id: editId } });
        } else {
            berhasil = await kirim("tambah", { data: data });
        }

        // Kalau gagal, isi form tidak dihapus supaya tidak perlu mengetik ulang
        if (!berhasil) {
            return;
        }

        resetForm();

        await muatData();

        if (tadiEdit) {
            alert("Perubahan berhasil disimpan.");
        }

    }


    // =====================================================
    // RESET FORM (kembali ke mode tambah)
    // =====================================================

    function resetForm() {

        editId = null;

        setTanggalHariIni();
        document.getElementById("pelanggan").value = "";
        document.getElementById("noHp").value = "";
        document.getElementById("produk").value = "";
        document.getElementById("paket").value = "";
        document.getElementById("jumlah").value = 1;
        document.getElementById("modal").value = "";
        document.getElementById("hargaJual").value = "";
        document.getElementById("masaAktif").value = "5";
        document.getElementById("garansi").value = "Ada";

        document.getElementById("judulForm").innerText = "Tambah Penjualan";
        document.getElementById("btnSimpan").innerText = "+ Tambah Order";
        document.getElementById("btnBatal").style.display = "none";
        document.querySelector(".form-box").classList.remove("mode-edit");

    }


    // =====================================================
    // ISI DROPDOWN
    // Kalau nilainya tidak ada di pilihan (data lama),
    // tambahkan pilihan baru supaya tetap bisa tampil.
    // =====================================================

    function isiSelect(idSelect, nilai, label) {

        const select = document.getElementById(idSelect);

        const ada = [...select.options].some(opt => opt.value === String(nilai));

        if (!ada) {
            const opsi = document.createElement("option");
            opsi.value = nilai;
            opsi.textContent = label;
            select.appendChild(opsi);
        }

        select.value = String(nilai);

    }


    // =====================================================
    // EDIT DATA
    // =====================================================

    function editData(id) {

        const item = dataPenjualan.find(data => data.id === id);

        if (!item) {
            alert("Data tidak ditemukan.");
            return;
        }

        editId = id;

        // Masukkan data ke form
        document.getElementById("tanggal").value = item.tanggal || "";
        document.getElementById("pelanggan").value = item.pelanggan || "";
        document.getElementById("noHp").value = item.noHp || "";
        document.getElementById("produk").value = item.produk || "";
        document.getElementById("jumlah").value = item.jumlah || 1;
        document.getElementById("modal").value = item.modal ?? "";
        document.getElementById("hargaJual").value = item.hargaJual ?? "";

        isiSelect("paket", item.paket || "", item.paket || "-- Pilih Paket --");
        isiSelect("masaAktif", item.masaAktif || 5, (item.masaAktif || 5) + " Hari");
        isiSelect("garansi", item.garansi || "Ada", item.garansi || "Ada");

        // Ubah tampilan form ke mode edit
        document.getElementById("judulForm").innerText = "✏️ Edit Penjualan - " + item.pelanggan;
        document.getElementById("btnSimpan").innerText = "💾 Simpan Perubahan";
        document.getElementById("btnBatal").style.display = "inline-block";
        document.querySelector(".form-box").classList.add("mode-edit");

        tampilkanData();

        // Gulir ke form
        document.querySelector(".form-box").scrollIntoView({ behavior: "smooth" });

    }


    // =====================================================
    // BATAL EDIT
    // =====================================================

    function batalEdit() {

        resetForm();

        tampilkanData();

    }


    // =====================================================
    // TAMPILKAN DATA
    // =====================================================

    function tampilkanData() {

        const tbody = document.getElementById("tabelPenjualan");

        tbody.innerHTML = "";

        let totalPendapatan = 0;
        let totalOrder = 0;
        let totalProfit = 0;

        if (dataTampil.length === 0) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="17" class="empty">Belum ada data penjualan.</td>
                </tr>
            `;

            updateDashboard(0, 0, 0);

            return;

        }

        dataTampil.forEach((item, index) => {

            totalPendapatan += Number(item.pendapatan || 0);
            totalOrder      += Number(item.jumlah || 0);
            totalProfit     += Number(item.profit || 0);


            // WHATSAPP

            let nomorWhatsApp = item.noHp || "";

            if (nomorWhatsApp.startsWith("0")) {
                nomorWhatsApp = "62" + nomorWhatsApp.substring(1);
            }

            const linkWhatsApp = `https://wa.me/${nomorWhatsApp}`;


            // MASA AKTIF

            let informasiAktif;

            if (item.tanggalBerakhir) {
                informasiAktif = hitungSisaHari(item.tanggalMulai || item.tanggal, item.tanggalBerakhir);
            } else {
                informasiAktif = { hari: 0, status: "Belum Ada Data", className: "akan-expired" };
            }


            // BUAT BARIS

            const row = document.createElement("tr");

            if (item.id === editId) {
                row.classList.add("sedang-diedit");
            }

            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${formatTanggal(item.tanggal)}</td>
                <td>${escapeHTML(item.pelanggan)}</td>
                <td>
                    ${escapeHTML(item.noHp)}
                    <br>
                    <a href="${linkWhatsApp}" target="_blank" class="btn-whatsapp">💬 WhatsApp</a>
                </td>
                <td>${escapeHTML(item.produk)}</td>
                <td>${escapeHTML(item.paket)}</td>
                <td>${item.jumlah}</td>
                <td>${rupiah(item.modal)}</td>
                <td>${rupiah(item.hargaJual)}</td>
                <td>${rupiah(item.pendapatan)}</td>
                <td class="profit-text">${rupiah(item.profit)}</td>
                <td><strong>${item.masaAktif || "-"}</strong> Hari</td>
                <td>${formatTanggal(item.tanggalMulai || item.tanggal)}</td>
                <td>${item.tanggalBerakhir ? formatTanggal(item.tanggalBerakhir) : "-"}</td>
                <td>${informasiAktif.hari > 0 ? informasiAktif.hari + " hari" : "-"}</td>
                <td><span class="${informasiAktif.className}">${informasiAktif.status}</span></td>
                <td class="kolom-aksi">
                    <button class="btn-edit" onclick="editData(${item.id})">Edit</button>
                    <button class="btn-delete" onclick="hapusData(${item.id})">Hapus</button>
                </td>
            `;

            tbody.appendChild(row);

        });

        updateDashboard(totalPendapatan, totalOrder, totalProfit);

    }


    // =====================================================
    // DASHBOARD
    // =====================================================

    function updateDashboard(pendapatan, order, profit) {

        document.getElementById("totalPendapatan").innerText = rupiah(pendapatan);
        document.getElementById("totalOrder").innerText = order;
        document.getElementById("totalProfit").innerText = rupiah(profit);

    }


    // =====================================================
    // FILTER
    // =====================================================

    function filterTanggal() {

        const tanggal = document.getElementById("filterTanggal").value;

        if (!tanggal) {
            alert("Silakan pilih tanggal terlebih dahulu.");
            return;
        }

        dataTampil = dataPenjualan.filter(item => item.tanggal === tanggal);

        tampilkanData();

    }


    function resetFilter() {

        document.getElementById("filterTanggal").value = "";

        dataTampil = [...dataPenjualan];

        tampilkanData();

    }


    // =====================================================
    // HAPUS DATA
    // =====================================================

    async function hapusData(id) {

        if (!confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
            return;
        }

        if (!(await kirim("hapus", { id: id }))) {
            return;
        }

        if (id === editId) {
            resetForm();
        }

        await muatData();

    }


    async function hapusSemua() {

        if (dataPenjualan.length === 0) {
            alert("Belum ada data penjualan.");
            return;
        }

        const yakin = confirm(
            "PERINGATAN!\n\n" +
            "Semua data penjualan akan dihapus.\n\n" +
            "Apakah Anda yakin?"
        );

        if (!yakin) {
            return;
        }

        if (!(await kirim("hapus_semua"))) {
            return;
        }

        resetForm();

        await muatData();

    }


    // =====================================================
    // KEAMANAN HTML
    // =====================================================

    function escapeHTML(text) {

        const div = document.createElement("div");

        div.textContent = text || "";

        return div.innerHTML;

    }


    // =====================================================
    // TANGGAL HARI INI
    // =====================================================

    function setTanggalHariIni() {

        document.getElementById("tanggal").value = formatTanggalInput(new Date());

    }


    // =====================================================
    // TOMBOL ENTER
    // PERBAIKAN: Enter di form tambah -> tambah order,
    // Enter di kolom filter -> tampilkan filter.
    // =====================================================

    document.addEventListener("keydown", function(event) {

        if (event.key !== "Enter") {
            return;
        }

        const aktif = document.activeElement;

        if (aktif.closest(".form-box")) {
            event.preventDefault();
            tambahPenjualan();
        }
        else if (aktif.closest(".filter-box")) {
            event.preventDefault();
            filterTanggal();
        }

    });


    // =====================================================
    // JALANKAN SISTEM
    // =====================================================

    setTanggalHariIni();

    muatData();

</script>

</body>

</html>
