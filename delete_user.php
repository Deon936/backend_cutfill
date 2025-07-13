<?php
require 'koneksi.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
  $del = mysqli_query($conn, "DELETE FROM users WHERE id = $id");
  echo json_encode(["success" => $del, "message" => $del ? "User dihapus" : "Gagal hapus user"]);
} else {
  echo json_encode(["success" => false, "message" => "ID tidak valid"]);
}
