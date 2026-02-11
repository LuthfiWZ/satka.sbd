<?php
include_once '../db.php';
header('Content-Type: application/json');

// Ambil data POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$nama_game = $_POST['nama_game'] ?? $data['nama_game'] ?? null;
$deskripsi = $_POST['deskripsi'] ?? $data['deskripsi'] ?? null;
$tipe_game = $_POST['tipe_game'] ?? $data['tipe_game'] ?? null;
$url_game  = $_POST['url_game']  ?? $data['url_game']  ?? null;

// VALIDASI
if (
    empty($nama_game) ||
    empty($deskripsi) ||
    empty($tipe_game) ||
    empty($url_game)
) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepare
$stmt = $conn->prepare("
    INSERT INTO game (nama_game, deskripsi, tipe_game, url_game)
    VALUES (?, ?, ?, ?)
");

// Bind (SEMUA STRING)
$stmt->bind_param(
    "ssss",
    $nama_game,
    $deskripsi,
    $tipe_game,
    $url_game
);

// Execute
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data game berhasil ditambahkan",
        "data"    => [
            "id"         => $stmt->insert_id,
            "nama_game"  => $nama_game,
            "deskripsi"  => $deskripsi,
            "tipe_game"  => $tipe_game,
            "url_game"   => $url_game
        ]
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
