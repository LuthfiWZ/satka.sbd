<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Array hasil query
$data = [];

// Cek parameter GET (username atau id)
if (isset($_GET['username']) || isset($_GET['id'])) {

    // Cari berdasarkan username
    if (isset($_GET['username'])) {
        $username = $_GET['username'];

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE username = ?"
        );
        $stmt->bind_param("s", $username);

    } else {
        // Cari berdasarkan id
        $id = $_GET['id'];

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE id = ?"
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
    $sql = "SELECT * FROM users";
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
