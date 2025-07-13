<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");



// Ambil JSON
$json = file_get_contents("php://input");
file_put_contents("debug_input.txt", $json);
$data = json_decode($json, true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "JSON tidak bisa dibaca.",
        "debug" => $json
        
    ]);
    exit;
}

// Ambil dan validasi data
$user_id     = intval($data['user_id'] ?? 0);
$vehicle_id  = intval($data['vehicle_id'] ?? 0);
$bbm_liter   = floatval($data['bbm_liter'] ?? 0);

if ($user_id <= 0 || $vehicle_id <= 0 || $bbm_liter <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap atau tidak valid.",
        "debug" => $data
    ]);
    exit;
}

require_once '../config/koneksi.php';

$query = "INSERT INTO bbm_logs (user_id, vehicle_id, date, bbm_liter)
          VALUES (?, ?, CURDATE(), ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iid", $user_id, $vehicle_id, $bbm_liter);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Data BBM berhasil ditambahkan."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan data.",
        "error" => $stmt->error
    ]);
}
?>
