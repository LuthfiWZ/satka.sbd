<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Array hasil query
$data = [];

// Cek parameter GET (nama_kategori atau id)
if (isset($_GET['nama_kategori']) || isset($_GET['id'])) {

    // Cari berdasarkan nama_kategori
    if (isset($_GET['nama_kategori'])) {
        $nama_kategori = $_GET['nama_kategori'];

        $stmt = $conn->prepare(
            "SELECT * FROM kategori WHERE nama_kategori = ?"
        );
        $stmt->bind_param("n", $nama_kategori);

    } else {
        // Cari berdasarkan id
        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "SELECT * FROM kategori WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
    }

    // Eksekusi & ambil hasil
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();

} else {

    // Ambil semua data user
    $sql = "SELECT * FROM kategori";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Response akhir
echo json_encode([
    "status"  => "success",
    "message" => count($data) > 0 ? "Data ditemukan" : "Data kosong",
    "data"    => $data
]);

$conn->close();
?>
