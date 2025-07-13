<?php
require 'koneksi.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Cek koneksi
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Koneksi database gagal"]);
    exit;
}

// Ambil data POST
$log = [
    'operator_name' => $_POST['operator_name'] ?? null,
    'vehicle_type' => $_POST['vehicle_type'] ?? null,
    'plate_number' => $_POST['plate_number'] ?? null,
    'bucket_volume' => floatval($_POST['bucket_volume'] ?? 0),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data
    if ($log['operator_name'] && $log['vehicle_type'] && $log['plate_number'] && $log['bucket_volume'] > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO vehicles (operator_name, vehicle_type, plate_number, bucket_capacity, created_at) VALUES (?, ?, ?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "sssd", $log['operator_name'], $log['vehicle_type'], $log['plate_number'], $log['bucket_volume']);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo json_encode([
            "success" => $success,
            "message" => $success ? "Kendaraan berhasil disimpan." : "Gagal menyimpan ke database.",
            "error"   => $success ? null : mysqli_error($conn) // Optional untuk debug
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Data tidak lengkap atau tidak valid.",
            "debug_post" => $log
        ]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Method tidak diizinkan."]);
}
