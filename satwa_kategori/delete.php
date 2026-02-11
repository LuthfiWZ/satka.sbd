<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil JSON
$data = json_decode(file_get_contents("php://input"), true);

// Ambil parameter
$satwa_id    = $data['satwa_id']    ?? $_POST['satwa_id']    ?? null;
$kategori_id = $data['kategori_id'] ?? $_POST['kategori_id'] ?? null;

// Validasi (BENAR)
if ($satwa_id === null || $kategori_id === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter satwa_id atau kategori_id tidak ditemukan"
    ]);
    exit;
}

// Cast integer
$satwa_id    = (int) $satwa_id;
$kategori_id = (int) $kategori_id;

// Delete
$stmt = $conn->prepare("
    DELETE FROM satwa_kategori 
    WHERE satwa_id = ? AND kategori_id = ?
");

$stmt->bind_param("ii", $satwa_id, $kategori_id);

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Relasi satwa–kategori berhasil dihapus"
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
