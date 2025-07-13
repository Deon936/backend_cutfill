<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Cek koneksi database
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit;
}

// Jalankan query
$q = mysqli_query($conn, "SELECT * FROM vehicles ORDER BY id DESC");

if (!$q) {
    echo json_encode(["success" => false, "message" => "Query gagal dijalankan"]);
    exit;
}

// Ambil hasil
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
}

// Output JSON
echo json_encode([
    "success" => true,
    "kendaraan" => $data
]);
