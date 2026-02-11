<?php
include_once '../db.php';
header('Content-Type: application/json');

// Ambil JSON
$data = json_decode(file_get_contents("php://input"), true);

// Ambil dari JSON atau POST
$nama_latin         = $data['nama_latin']         ?? $_POST['nama_latin']         ?? null;
$nama_umum          = $data['nama_umum']          ?? $_POST['nama_umum']          ?? null;
$deskripsi          = $data['deskripsi']          ?? $_POST['deskripsi']          ?? null;
$habitat            = $data['habitat']            ?? $_POST['habitat']            ?? null;
$status_konservasi  = $data['status_konservasi']  ?? $_POST['status_konservasi']  ?? null;
$upaya_konservasi   = $data['upaya_konservasi']   ?? $_POST['upaya_konservasi']   ?? null;
$gambar_url         = $data['gambar_url']         ?? $_POST['gambar_url']         ?? null;
$created_at         = $data['created_at']         ?? $_POST['created_at']         ?? null;
$updated_at         = $data['updated_at']         ?? $_POST['updated_at']         ?? null;

// VALIDASI YANG BENAR
if (
    $nama_latin === null ||
    $nama_umum === null ||
    $deskripsi === null ||
    $habitat === null ||
    $status_konservasi === null ||
    $upaya_konservasi === null ||
    $gambar_url === null ||
    $created_at === null ||
    $updated_at === null
) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO satwa
    (nama_latin, nama_umum, deskripsi, habitat, status_konservasi, upaya_konservasi, gambar_url, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssssss",
    $nama_latin,
    $nama_umum,
    $deskripsi,
    $habitat,
    $status_konservasi,
    $upaya_konservasi,
    $gambar_url,
    $created_at,
    $updated_at
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data satwa berhasil ditambahkan",
        "data"    => [
            "id" => $stmt->insert_id,
            "nama_latin" => $nama_latin,
            "nama_umum" => $nama_umum,
            "deskripsi" => $deskripsi,
            "habitat" => $habitat,
            "status_konservasi" => $status_konservasi,
            "upaya_konservasi" => $upaya_konservasi,
            "gambar_url" => $gambar_url,
            "created_at" => $created_at,
            "updated_at" => $updated_at
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
