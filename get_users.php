<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$q = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$data = [];

while ($row = mysqli_fetch_assoc($q)) {
  $data[] = $row;
}

echo json_encode([
  "success" => true,
  "users" => $data
]);
