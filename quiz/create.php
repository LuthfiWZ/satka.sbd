<?php
include_once '../db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$pertanyaan        = $_POST['pertanyaan']        ?? $data['pertanyaan']        ?? null;
$pilihan_a         = $_POST['pilihan_a']         ?? $data['pilihan_a']         ?? null;
$pilihan_b         = $_POST['pilihan_b']         ?? $data['pilihan_b']         ?? null;
$pilihan_c         = $_POST['pilihan_c']         ?? $data['pilihan_c']         ?? null;
$pilihan_d         = $_POST['pilihan_d']         ?? $data['pilihan_d']         ?? null;
$jawaban_benar     = $_POST['jawaban_benar']     ?? $data['jawaban_benar']     ?? null;
$penjelasan        = $_POST['penjelasan']        ?? $data['penjelasan']        ?? null;
$tingkat_kesulitan = $_POST['tingkat_kesulitan'] ?? $data['tingkat_kesulitan'] ?? null;
$satwa_id          = $_POST['satwa_id']          ?? $data['satwa_id']          ?? null;

/* VALIDASI */
if (
    empty($pertanyaan) ||
    empty($pilihan_a) ||
    empty($pilihan_b) ||
    empty($pilihan_c) ||
    empty($pilihan_d) ||
    empty($jawaban_benar) ||
    empty($penjelasan) ||
    empty($tingkat_kesulitan) ||
    $satwa_id === null
) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

/* VALIDASI ENUM (WAJIB BIAR AMAN) */
$allowed = ['mudah', 'sedang', 'sulit'];
if (!in_array($tingkat_kesulitan, $allowed)) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Tingkat kesulitan tidak valid"
    ]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO quiz 
    (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar, penjelasan, tingkat_kesulitan, satwa_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

/*
  8 STRING + 1 INTEGER
*/
$stmt->bind_param(
    "ssssssssi",
    $pertanyaan,
    $pilihan_a,
    $pilihan_b,
    $pilihan_c,
    $pilihan_d,
    $jawaban_benar,
    $penjelasan,
    $tingkat_kesulitan, // ENUM = STRING ✅
    $satwa_id
);

if ($stmt->execute()) {
    echo json_encode([
        "status"  => "success",
        "message" => "Quiz berhasil ditambahkan",
        "id"      => $stmt->insert_id
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
