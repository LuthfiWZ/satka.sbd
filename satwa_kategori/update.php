<?php
include '../db.php';
header('Content-Type: application/json');

$satwa_id   = $_POST['satwa_id'];
$kategori_id = $_POST['kategori_id'];

$stmt = $conn->prepare("
    UPDATE satwa_kategori
    SET kategori_id = ?
    WHERE satwa_id = ?
");

$stmt->bind_param("ii", $kategori_id, $satwa_id);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Kategori berhasil diperbarui"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
