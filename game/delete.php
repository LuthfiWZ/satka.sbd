<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data POST & JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $_POST['id'] ?? $data['id'] ?? null;

// Validasi id
if ($id === null || $id === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Parameter id tidak ditemukan"
    ]);
    exit;
}

// Delete
$stmt = $conn->prepare("DELETE FROM game WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Data game berhasil dihapus"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
