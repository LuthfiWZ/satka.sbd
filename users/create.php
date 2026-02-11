<?php
// Koneksi database
include_once '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari JSON
$raw  = file_get_contents("php://input");
$data = json_decode($raw, true);

// Ambil dari JSON atau POST
$username   = $data['username']   ?? $_POST['username']   ?? null;
$email      = $data['email']      ?? $_POST['email']      ?? null;
$peran      = $data['peran']      ?? $_POST['peran']      ?? null;
$poin_total = $data['poin_total'] ?? $_POST['poin_total'] ?? null;

// VALIDASI (AMAN, TIDAK SALAH BACA ANGKA)
if (
    $username === null ||
    $email === null ||
    $peran === null ||
    $poin_total === null
) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Cast integer
$poin_total = (int) $poin_total;

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO users (username, email, peran, poin_total)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param(
    "sssi",
    $username,
    $email,
    $peran,
    $poin_total
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil ditambahkan",
        "data"    => [
            "id"         => $stmt->insert_id,
            "username"   => $username,
            "email"      => $email,
            "peran"      => $peran,
            "poin_total" => $poin_total
        ]
    ]);

} else {

    http_response_code(400);
    $error_msg = $stmt->error;

    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Username '$username' sudah digunakan.";
    }

    echo json_encode([
        "status"  => "error",
        "message" => $error_msg
    ]);
}

// Tutup koneksi
$stmt->close();
$conn->close();
