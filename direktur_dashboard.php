<?php
require 'koneksi.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Fungsi bantu hitung data
function getCount($conn, $table, $where = '') {
    $sql = "SELECT COUNT(*) as total FROM $table";
    if ($where) $sql .= " WHERE $where";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        return (int) $data['total'];
    }
    return 0;
}

// Statistik
$total_users      = getCount($conn, 'users');
$total_kendaraan  = getCount($conn, 'vehicles');
$total_ritase     = getCount($conn, 'ritase_logs');
$total_bbm        = getCount($conn, 'bbm_logs');
$total_proyek     = getCount($conn, 'proyek', "status = 'aktif'");

// Riwayat aktivitas gabungan (10 terbaru)
$history = [];
$query = "
    (SELECT 'Input Ritase' AS aksi, u.name AS name, r.date AS date 
     FROM ritase_logs r
     JOIN users u ON r.user_id = u.id)
    UNION
    (SELECT 'Input BBM' AS aksi, u.name AS name, b.date AS date 
     FROM bbm_logs b
     JOIN users u ON b.user_id = u.id)
    ORDER BY date DESC
    LIMIT 10
";
$result = mysqli_query($conn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $row['date'] = date('d-m-Y H:i', strtotime($row['date']));
        $history[] = $row;
    }
}

// Output JSON
echo json_encode([
    "success" => true,
    "message" => "Dashboard Direktur",
    "statistik" => [
        "total_users"     => $total_users,
        "total_kendaraan" => $total_kendaraan,
        "total_ritase"    => $total_ritase,
        "total_bbm"       => $total_bbm,
        "total_proyek"    => $total_proyek
    ],
    "riwayat" => $history
]);
