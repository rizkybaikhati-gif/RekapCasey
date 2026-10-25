<?php
// Tampilan bersama untuk login.php dan setup_admin.php
?>
<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        font-family: "Segoe UI", Arial, sans-serif;
        background: rgb(253, 168, 191);
        color: #1e293b;
    }

    .kartu {
        width: 100%;
        max-width: 400px;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .kartu h1 {
        margin: 0 0 6px;
        font-size: 24px;
        color: rgb(96,77,83);
    }

    .kartu .sub {
        margin: 0 0 22px;
        color: #64748b;
        font-size: 14px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: bold;
        color: #475569;
    }

    input {
        width: 100%;
        padding: 11px;
        margin-bottom: 15px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        font-size: 14px;
        outline: none;
    }

    input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 7px;
        background: #2563eb;
        color: white;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
    }

    button:hover { background: #1d4ed8; }

    .pesan-error,
    .pesan-sukses {
        padding: 11px;
        border-radius: 7px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .pesan-error  { background: #fee2e2; color: #b91c1c; }
    .pesan-sukses { background: #dcfce7; color: #15803d; }

    .kecil {
        font-size: 12px;
        color: #64748b;
        margin: -8px 0 15px;
    }

    a { color: #2563eb; }
</style>
