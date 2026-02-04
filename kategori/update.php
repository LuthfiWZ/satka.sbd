<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil POST
$id            = $_POST['id'] ?? null;
$nama_kategori = $_POST['nama_kategori'] ?? null;
$deskripsi     = $_POST['deskripsi'] ?? null;

// Validasi wajib
if (!$id || !$nama_kategori) {
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

// Bind parameter (2 string, 1 integer)
$stmt->bind_param(
    "ssi",
    $nama_kategori,
    $deskripsi,
    $id
);

// Eksekusi
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
?>