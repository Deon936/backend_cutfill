<?php
require_once 'koneksi.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Ambil input JSON
$input = json_decode(file_get_contents("php://input"), true);

// Validasi format JSON
if (!is_array($input)) {
    echo json_encode([
        "success" => false,
        "message" => "Format JSON tidak valid"
    ]);
    exit;
}

// Ambil nilai dari input
$name     = trim($input['name'] ?? '');
$email    = trim($input['email'] ?? '');
$password = $input['password'] ?? '';
$role     = trim($input['role'] ?? '');

// Validasi semua input
if (empty($name) || empty($email) || empty($password) || empty($role)) {
    echo json_encode([
        "success" => false,
        "message" => "Semua field wajib diisi"
    ]);
    exit;
}

// Cek apakah email sudah digunakan
$check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($check, "s", $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email sudah digunakan"
    ]);
    mysqli_stmt_close($check);
    exit;
}
mysqli_stmt_close($check);

// Hash password sebelum disimpan
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Simpan ke database
$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPassword, $role);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "success" => true,
        "message" => "Registrasi berhasil"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal registrasi"
    ]);
}

mysqli_stmt_close($stmt);
