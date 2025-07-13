<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Koneksi DB gagal"]);
    exit;
}

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "JSON tidak valid",
        "input" => $rawInput,
        "json_error" => json_last_error_msg()
    ]);
    exit;
}

$user_id = intval($data['user_id'] ?? 0);
$vehicle_id = intval($data['vehicle_id'] ?? 0);
$rit_count = intval($data['rit_count'] ?? 0);
$weather = trim($data['weather_condition'] ?? '');
$bucket_volume = floatval($data['bucket_volume'] ?? 0);
$date = date('Y-m-d');

if ($user_id > 0 && $vehicle_id > 0 && $rit_count > 0) {
    $stmt = $conn->prepare("INSERT INTO ritase_logs (user_id, vehicle_id, date, rit_count, weather_condition, bucket_volume)
                            VALUES (?, ?, ?, ?, ?, ?)");
    
    // FIX: perhatikan urutan bind param — "iisisd"
    $stmt->bind_param("iiis sd", $user_id, $vehicle_id, $date, $rit_count, $weather, $bucket_volume);

    $exec = $stmt->execute();

    echo json_encode([
        "success" => $exec,
        "message" => $exec ? "Ritase berhasil dicatat" : "Gagal input ritase",
        "error" => $exec ? null : $stmt->error
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap atau tidak valid",
        "data" => $data
    ]);
}
