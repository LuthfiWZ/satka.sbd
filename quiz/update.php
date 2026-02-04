<?php
include '../db.php';
header('Content-Type: application/json');

// Ambil POST dengan aman
$id                 = $_POST['id'] ?? null;
$pertanyaan         = $_POST['pertanyaan'] ?? null;
$pilihan_a          = $_POST['pilihan_a'] ?? null;
$pilihan_b          = $_POST['pilihan_b'] ?? null;
$pilihan_c          = $_POST['pilihan_c'] ?? null;
$pilihan_d          = $_POST['pilihan_d'] ?? null;
$jawaban_benar      = $_POST['jawaban_benar'] ?? null;
$penjelasan         = $_POST['penjelasan'] ?? null;
$tingkat_kesulitan  = $_POST['tingkat_kesulitan'] ?? null;
$satwa_id           = $_POST['satwa_id'] ?? null;

// Validasi WAJIB
if (!$id) {
    echo json_encode([
        "status" => "error",
        "message" => "ID quiz wajib dikirim"
    ]);
    exit;
}

$stmt = $conn->prepare("
    UPDATE quiz
    SET pertanyaan = ?,
        pilihan_a = ?,
        pilihan_b = ?,
        pilihan_c = ?,
        pilihan_d = ?,
        jawaban_benar = ?,
        penjelasan = ?,
        tingkat_kesulitan = ?,
        satwa_id = ?
    WHERE id = ?
");

$stmt->bind_param(
    "ssssssssii",
    $pertanyaan,
    $pilihan_a,
    $pilihan_b,
    $pilihan_c,
    $pilihan_d,
    $jawaban_benar,
    $penjelasan,
    $tingkat_kesulitan,
    $satwa_id,
    $id
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Quiz berhasil diperbarui"
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