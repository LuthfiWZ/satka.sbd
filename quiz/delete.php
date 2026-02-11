<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

// Validasi
if ($id === null) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter id tidak ditemukan"
    ]);
    exit;
}

// Hapus data
$stmt = $conn->prepare("DELETE FROM quiz WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Data quiz berhasil dihapus"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
