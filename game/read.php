<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Array hasil query
$data = [];

// Cek parameter GET (nama_game atau id)
if (isset($_GET['nama_game']) || isset($_GET['id'])) {

    // Cari berdasarkan nama_game
    if (isset($_GET['nama_game'])) {
        $nama_game = $_GET['nama_game'];

        $stmt = $conn->prepare(
            "SELECT * FROM game WHERE nama_game = ?"
        );
        $stmt->bind_param("n", $nama_game);

    } else {
        // Cari berdasarkan id
        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "SELECT * FROM game WHERE id = ?"
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
    $sql = "SELECT * FROM game";
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
