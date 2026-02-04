<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Array hasil query
$data = [];

// Cek parameter GET (pertanyaan atau id)
if (isset($_GET['pertanyaan']) || isset($_GET['id'])) {

    // Cari berdasarkan pertanyaan
    if (isset($_GET['pertanyaan'])) {
        $pertanyaan = $_GET['pertanyaan'];

        $stmt = $conn->prepare(
            "SELECT * FROM quiz WHERE pertanyaan = ?"
        );
        $stmt->bind_param("p", $pertanyaan);

    } else {
        // Cari berdasarkan id
        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "SELECT * FROM quiz WHERE id = ?"
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
    $sql = "SELECT * FROM quiz";
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
