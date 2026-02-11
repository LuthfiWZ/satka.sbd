<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$id            = $_POST['id']            ?? $data['id']            ?? null;
$nama_kategori = $_POST['nama_kategori'] ?? $data['nama_kategori'] ?? null;
$deskripsi     = $_POST['deskripsi']     ?? $data['deskripsi']     ?? null;

// VALIDASI
if ($id === null || empty($nama_kategori)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "ID dan Nama Kategori wajib diisi"
    ]);
    exit;
}

// Prepare query
$stmt = $conn->prepare("
    UPDATE kategori
    SET nama_kategori = ?,
        deskripsi = ?
    WHERE id = ?
");

// Bind parameter
$stmt->bind_param("ssi", $nama_kategori, $deskripsi, $id);

// Execute
if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "message" => "Kategori berhasil diperbarui"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
