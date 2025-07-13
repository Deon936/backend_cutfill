<?php
// Wajib di paling atas sebelum ada output
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Koneksi ke DB
require 'koneksi.php';

// Ambil base URL
$baseUrl = (
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http"
) . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';

// Respon JSON API info
$response = [
    "status" => "sukses",
    "message" => "Pemantauan API Cut & Fill aktif",
    "versi" => "1.0.0",
    "titik_akhir" => [
        // Auth
        "POST {$baseUrl}login.php"               => "Login pengguna",
        "POST {$baseUrl}register.php"            => "Daftar pengguna baru",

        // Ritase & BBM
        "POST {$baseUrl}input_ritase.php"        => "Input data ritase harian",
        "POST {$baseUrl}bbm.php"                 => "Input konsumsi BBM harian",

        // Kendaraan
        "GET  {$baseUrl}get_kendaraan.php"       => "Ambil data kendaraan",
        "POST {$baseUrl}kendaraan.php"           => "Tambah kendaraan",
        "POST {$baseUrl}delete_kendaraan.php"    => "Hapus kendaraan",

        // Pengguna
        "GET  {$baseUrl}get_users.php"           => "Ambil data pengguna",
        "POST {$baseUrl}delete_user.php"         => "Hapus pengguna",

        // Statistik dashboard
        "GET  {$baseUrl}admin_dashboard.php"     => "Statistik untuk admin",
        "GET  {$baseUrl}direktur_dashboard.php"  => "Statistik untuk direktur",

        // Proyek
        "GET  {$baseUrl}data_proyek.php"         => "Ambil data proyek",
        "POST {$baseUrl}tambah_proyek.php"       => "Tambah proyek baru"
    ]
];

// Output JSON
echo json_encode($response, JSON_PRETTY_PRINT);
