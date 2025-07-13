<?php
require 'koneksi.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$response = [
    "success" => false,
    "data" => [],
    "message" => ""
];

$query = "
    SELECT 
        id, 
        nama_proyek, 
        lokasi, 
        status, 
        tanggal_mulai, 
        tanggal_selesai,
        created_at
    FROM proyek 
    ORDER BY id DESC
";

$result = mysqli_query($conn, $query);

if ($result) {
    $proyek = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // Format tanggal (opsional, tergantung frontend)
        $row['tanggal_mulai'] = $row['tanggal_mulai'] ?? '-';
        $row['tanggal_selesai'] = $row['tanggal_selesai'] ?? '-';
        $row['lokasi'] = $row['lokasi'] ?? '-';

        $proyek[] = $row;
    }

    $response["success"] = true;
    $response["data"] = $proyek;
    $response["message"] = "Data proyek berhasil diambil.";
} else {
    $response["message"] = "Query gagal dijalankan.";
}

echo json_encode($response);
