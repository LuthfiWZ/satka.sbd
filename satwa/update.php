<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
$id         = $_POST['id'];          // ID user
$nama_latin   = $_POST['nama_latin'];    // pert$nama_latin
$nama_umum      = $_POST['nama_umum'];       // pi$nama_umum
$deskripsi      = $_POST['deskripsi'];       // tipe_$deskripsi (siswa, guru, dll)
$habitat = $_POST['habitat'];  // total poin
$makanan = $_POST['makanan'];
$status_konservasi = $_POST['status_konservasi'];
$ancaman = $_POST['ancaman'];
$upaya_konservasi = $_POST['upaya_konservasi'];
$gambar_url = $_POST['gambar_url'];
$created_at = $_POST['created_at'];
$updated_at = $_POST['updated_at'];

// Prepared statement 
$stmt = $conn->prepare("
    UPDATE quiz
    SET nama_latin = ?, nama_umum = ?, deskripsi = ?, habitat = ?, makanan = ?, status_konservasi = ?, upaya_konservasi = ?, gambar_url = ?, created_at =?, updated_at =?,
    WHERE id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "sssii",
    $nama_latin,
    $nama_umum,
    $deskripsi,
    $habitat,
    $makanan,
    $status_konservasi,
    $ancaman,
    $upaya_konservasi,
    $gambar_url,
    $created_at,
    $updated_at,
    $id
);

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
            "id"         => $id,
            "nama_latin"   => $nama_latin,
            "nama_umum"      => $nama_umum,
            "deskripsi"      => $deskripsi,
            "habitat" => $habitat,
            "makanan" => $makanan,
            "status_konservasi" => $status_konservasi,
            "ancaman" => $ancaman,
            "upaya_konservasi" => $upaya_konservasi,
            "gambar_url" => $gambar_url,
            "created_at" => $created_at,
            "updated_at" => $updated_at
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
