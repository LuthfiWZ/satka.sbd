<?php
include '../db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

// Ambil id dari JSON / POST / GET
$id = $data['id'] ?? $_POST['id'] ?? $_GET['id'] ?? null;

// Validasi YANG BENAR
if ($id === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter id tidak ditemukan"
    ]);
    exit;
}

$id = (int) $id;

// Delete
$stmt = $conn->prepare("DELETE FROM satwa WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Data satwa berhasil dihapus"
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
