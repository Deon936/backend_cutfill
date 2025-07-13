<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek koneksi
if (!$conn) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Gagal koneksi ke database"]);
    exit;
}

// Helper function
function getTotal($conn, $table) {
    $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM $table");
    if (!$query) return 0;
    $result = mysqli_fetch_assoc($query);
    return intval($result['total'] ?? 0);
}

// Statistik
$response = [
    "success" => true,
    "message" => "Dashboard Admin Overview",
    "statistik" => [
        "total_kendaraan" => getTotal($conn, 'vehicles'),
        "total_ritase"    => getTotal($conn, 'ritase_logs'),
        "total_bbm"       => getTotal($conn, 'bbm_logs'),
        "total_user"      => getTotal($conn, 'users')
    ],
    "fitur" => [
        "Input Kendaraan",
        "Cek Data Kendaraan",
        "Profile",
        "Settings"
    ]
];

echo json_encode($response, JSON_PRETTY_PRINT);
