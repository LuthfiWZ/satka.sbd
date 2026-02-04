<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
         // ID user
$satwa_id   = $_POST['satwa_id'];    // satwa_id$satwa_id
$kategori_id      = $_POST['kategori_id'];       // kategori_id


// Prepared statement 
$stmt = $conn->prepare("
    UPDATE satwa_kategori
    SET satwa_id = ?, kategori_id = ? 
    WHERE satwa_id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "si",
    $satwa_id,
    $kategori_id
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
       
            "satwa_id"   => $satwa_id,
            "kategori_id"      => $kategori_id
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
