<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$result = mysqli_query($conn, "SELECT * FROM vehicles ORDER BY id DESC");

$kendaraan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $display = $row['vehicle_type'] . ' - ' . $row['plate_number'];

    $kendaraan[] = [
        "id" => $row['id'],
        "operator_name" => $row['operator_name'],
        "vehicle_type" => $row['vehicle_type'],
        "plate_number" => $row['plate_number'],
        "bucket_capacity" => $row['bucket_capacity'],
        "created_at" => $row['created_at'],
        "display" => $display
    ];
}

echo json_encode([
    "success" => true,
    "message" => "Data kendaraan ditemukan",
    "vehicles" => $kendaraan
]);
