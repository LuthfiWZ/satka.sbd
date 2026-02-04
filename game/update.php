<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
$id         = $_POST['id'];          // ID user
$nama_game   = $_POST['nama_game'];    // nama_game
$deskripsi      = $_POST['deskripsi'];       // deskripsi
$tipe_game      = $_POST['tipe_game'];       // tipe_$tipe_game (siswa, guru, dll)
$url_game = $_POST['url_game'];  // total poin

// Prepared statement 
$stmt = $conn->prepare("
    UPDATE game
    SET nama_game = ?, deskripsi = ?, tipe_game = ?, url_game = ?
    WHERE id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "sssii",
    $nama_game,
    $deskripsi,
    $tipe_game,
    $url_game,
    $id
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
            "id"         => $id,
            "nama_game"   => $nama_game,
            "deskripsi"      => $deskripsi,
            "tipe_game"      => $tipe_game,
            "url_game" => $url_game
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
