<?php
include_once '../db.php';
header('Content-Type: application/json');

// Ambil data JSON / POST
$data = json_decode(file_get_contents("php://input"), true);

$nama_kategori = $_POST['nama_kategori'] ?? $data['nama_kategori'] ?? null;
$deskripsi     = $_POST['deskripsi']     ?? $data['deskripsi']     ?? null;

// VALIDASI (BENAR)
if (empty($nama_kategori) || empty($deskripsi)) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepare
$stmt = $conn->prepare("
    INSERT INTO kategori (nama_kategori, deskripsi)
    VALUES (?, ?)
");

// Bind (BENAR)
$stmt->bind_param("ss", $nama_kategori, $deskripsi);

// Execute
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data kategori berhasil ditambahkan",
        "data"    => [
            "id"            => $stmt->insert_id,
            "nama_kategori" => $nama_kategori,
            "deskripsi"     => $deskripsi
        ]
    ]);

} else {

    http_response_code(400);
    $error_msg = $stmt->error;

    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Nama kategori sudah digunakan";
    }

    echo json_encode([
        "status"  => "error",
        "message" => $error_msg
    ]);
}

$stmt->close();
$conn->close();
