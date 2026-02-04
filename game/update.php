<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil POST dengan aman
$id         = $_POST['id'] ?? null;
$nama_game  = $_POST['nama_game'] ?? null;
$deskripsi  = $_POST['deskripsi'] ?? null;
$tipe_game  = $_POST['tipe_game'] ?? null;
$url_game   = $_POST['url_game'] ?? null;

// Validasi WAJIB
if (!$id || !$nama_game || !$tipe_game) {
    echo json_encode([
        "status" => "error",
        "message" => "ID, Nama Game, dan Tipe Game wajib diisi"
    ]);
    exit;
}

// Prepare
$stmt = $conn->prepare("
    UPDATE game
    SET nama_game = ?,
        deskripsi = ?,
        tipe_game = ?,
        url_game = ?
    WHERE id = ?
");

$stmt->bind_param(
    "ssssi",
    $nama_game,
    $deskripsi,
    $tipe_game,
    $url_game,
    $id
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Data game berhasil diperbarui",
        "data" => [
            "id" => $id,
            "nama_game" => $nama_game,
            "deskripsi" => $deskripsi,
            "tipe_game" => $tipe_game,
            "url_game" => $url_game
        ]
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