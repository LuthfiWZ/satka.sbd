<?php
include_once '../db.php';

header('Content-Type: application/json');

// Ambil JSON
$data = json_decode(file_get_contents("php://input"), true);

// Ambil dari JSON atau POST
$satwa_id    = $data['satwa_id']    ?? $_POST['satwa_id']    ?? null;
$kategori_id = $data['kategori_id'] ?? $_POST['kategori_id'] ?? null;

// VALIDASI YANG BENAR
if ($satwa_id === null || $kategori_id === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Cast ke integer
$satwa_id    = (int) $satwa_id;
$kategori_id = (int) $kategori_id;

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO satwa_kategori (satwa_id, kategori_id)
    VALUES (?, ?)
");

$stmt->bind_param("ii", $satwa_id, $kategori_id);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil ditambahkan",
        "data"    => [
            "satwa_id"    => $satwa_id,
            "kategori_id" => $kategori_id
        ]
    ]);

} else {
    http_response_code(400);
    $error_msg = $stmt->error;

    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Data sudah ada (duplikat).";
    }

    echo json_encode([
        "status"  => "error",
        "message" => $error_msg
    ]);
}

$stmt->close();
$conn->close();
