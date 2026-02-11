<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil data POST
$id                = $_POST['id'] ?? null;
$nama_latin        = $_POST['nama_latin'] ?? null;
$nama_umum         = $_POST['nama_umum'] ?? null;
$deskripsi         = $_POST['deskripsi'] ?? null;
$habitat           = $_POST['habitat'] ?? null;
$makanan           = $_POST['makanan'] ?? null;
$status_konservasi = $_POST['status_konservasi'] ?? null;
$ancaman           = $_POST['ancaman'] ?? null;
$upaya_konservasi  = $_POST['upaya_konservasi'] ?? null;
$gambar_url        = $_POST['gambar_url'] ?? null;

// Validasi ID wajib ada
if (!$id) {
    echo json_encode([
        "status" => "error",
        "message" => "ID wajib dikirim"
    ]);
    exit;
}

// Prepare statement
$stmt = $conn->prepare("
    UPDATE satwa
    SET nama_latin = ?,
        nama_umum = ?,
        deskripsi = ?,
        habitat = ?,
        makanan = ?,
        status_konservasi = ?,
        ancaman = ?,
        upaya_konservasi = ?,
        gambar_url = ?,
        updated_at = NOW()
    WHERE id = ?
");

// Bind parameter (9 string + 1 integer)
$stmt->bind_param(
    "sssssssssi",
    $nama_latin,
    $nama_umum,
    $deskripsi,
    $habitat,
    $makanan,
    $status_konservasi,
    $ancaman,
    $upaya_konservasi,
    $gambar_url,
    $id
);

// Eksekusi
if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Data satwa berhasil diperbarui"
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
