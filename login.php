<?php
require_once 'koneksi.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Ambil data dari $_POST (form)
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Jika kosong, coba dari JSON
if (empty($email) || empty($password)) {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
}

// Validasi input
if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Email dan password harus diisi"]);
    exit;
}

// Query aman pakai prepared statement
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login berhasil",
            "data" => [
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Password salah"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
}
