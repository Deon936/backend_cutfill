<?php
$host = 'db';
$user = 'root';
$pass = ']u]w4INoqQLpj!gZ';
$db   = 'cutfill_db';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Koneksi gagal']));
}
?>
