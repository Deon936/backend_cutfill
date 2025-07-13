<?php
$host = 'db';
$user = 'deon';
$pass = '12345';
$db   = 'cutfill_db';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Koneksi gagal']));
}
?>
