<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Array hasil query
$data = [];

// Cek parameter GET (satwa_id atau id)
if (isset($_GET['satwa_id']) || isset($_GET['id'])) {

    // Cari berdasarkan satwa_id
    if (isset($_GET['satwa_id'])) {
        $satwa_id = $_GET['satwa_id'];

        $stmt = $conn->prepare(
            "SELECT * FROM satwa_kategori WHERE satwa_id = ?"
        );
        $stmt->bind_param("s", $satwa_id);

    } else {
        // Cari berdasarkan id
        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "SELECT * FROM satwa_kategori WHERE satwa_id = ?"
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
    $sql = "SELECT * FROM satwa_kategori";
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
