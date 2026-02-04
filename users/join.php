<?php
// Koneksi ke database
include '../db.php'; // Sesuaikan path koneksi Anda

// Response JSON
header('Content-Type: application/json');

/**
 * QUERY PENJELASAN:
 * Kita menggabungkan 3 tabel:
 * 1. satwa (Data utama)
 * 2. satwa_kategori (Tabel penghubung / Pivot)
 * 3. kategori (Data nama kategori)
 */
$sql = "
    SELECT 
        s.id,
        s.nama_umum,
        s.nama_latin,
        s.status_konservasi,
        k.nama_kategori
    FROM satwa s
    JOIN satwa_kategori sk ON s.id = sk.satwa_id
    JOIN kategori k ON sk.kategori_id = k.id
    ORDER BY s.nama_umum ASC
";

$result = $conn->query($sql);
$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Data satwa berdasarkan kategori berhasil diambil",
        "count" => count($data),
        "data" => $data
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
}

$conn->close();
?>