<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
$id         = $_POST['id'];          // ID user
$nama_kategori   = $_POST['nama_kategori$nama_kategori'];    // nama_kategori$nama_kategori
$deskripsi      = $_POST['deskripsi'];       // deskripsi


// Prepared statement 
$stmt = $conn->prepare("
    UPDATE kategori
    SET nama_kategori$nama_kategori = ?, deskripsi = ? 
    WHERE id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "sssii",
    $nama_kategori,
    $deskripsi
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
            "id"         => $id,
            "nama_kategori$nama_kategori"   => $nama_kategori,
            "deskripsi"      => $deskripsi
        ]
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => $stmt->error
    ]);

}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
