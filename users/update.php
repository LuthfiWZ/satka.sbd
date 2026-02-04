<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
$id         = $_POST['id'];          // ID user
$username   = $_POST['username'];    // username
$email      = $_POST['email'];       // email
$peran      = $_POST['peran'];       // peran (siswa, guru, dll)
$poin_total = $_POST['poin_total'];  // total poin

// Prepared statement 
$stmt = $conn->prepare("
    UPDATE users
    SET username = ?, email = ?, peran = ?, poin_total = ?
    WHERE id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "sssii",
    $username,
    $email,
    $peran,
    $poin_total,
    $id
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
            "id"         => $id,
            "username"   => $username,
            "email"      => $email,
            "peran"      => $peran,
            "poin_total" => $poin_total
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
