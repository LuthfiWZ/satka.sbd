<?php
// Koneksi database
include_once '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$pertanyaan   = $_POST['pertanyaan']   ?? $data['pertanyaan']   ?? null;
$pilihan_a      = $_POST['pilihan_a']      ?? $data['pilihan_a']      ?? null;
$pilihan_b      = $_POST['pilihan_b']      ?? $data['pilihan_b']      ?? null;
$pilihan_c      = $_POST['pilihan_c']      ?? $data['pilihan_c']      ?? null;
$pilihan_d      = $_POST['pilihan_d']      ?? $data['pilihan_d']      ?? null;
$jawaban_benar      = $_POST['jawaban_benar']      ?? $data['jawaban_benar']      ?? null;
$penjelasan = $_POST['penjelasan'] ?? $data['penjelasan'] ?? null;
$tingkat_kesulitan      = $_POST['tingkat_kesulitan']      ?? $data['tingkat_kesulitan']      ?? null;
$satwa_id      = $_POST['satwa_id']      ?? $data['satwa_id']      ?? null;

// Validasi wajib
if (!$pertanyaan || !$pilihan_a || !$pilihan_b || !$pilihan_c || !$pilihan_d || !$jawaban_benar || $penjelasan || !$tingkat_kesulitan || !$satwa_id === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO quiz (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar, penjelasan, tingkat_kesulitan, satwa_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// s = string, i = integer
$stmt->bind_param(
    "sssi",
    $pertanyaan,
    $pilihan_a,
    $pilihan_b,
    $pilihan_c,
    $pilihan_d,
    $jawaban_benar,
    $penjelasan,
    $tingkat_kesulitan,
    $satwa_id
);

// Eksekusi
// Logika tetap sama: mencoba eksekusi langsung
if ($stmt->execute()) {

    $last_id = $stmt->insert_id;

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil ditambahkan",
        "data"    => [
            "id"         => $last_id,
            "pertanyaan"   => $pertanyaan,
            "pilihan_a"      => $pilihan_a,
            "pilihan_b"      => $pilihan_b,
            "pilihan_c"      => $pilihan_c,
            "pilihan_d"      => $pilihan_d,
            "jawaban_benar"      => $jawaban_benar,
            "penjelasan" => $penjelasan,
            "tingkat_kesulitan" => $tingkat_kesulitan,
            "satwa_id" => $satwa_id,
        ]
    ]);

} else {
    // Menangkap error jika terjadi duplikasi tanpa merusak struktur logika utama
    http_response_code(400); // Bad Request
    
    $error_msg = $stmt->error;
    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Username '$pertanyaan' sudah digunakan, silakan pilih yang lain.";
    }

    echo json_encode([
        "status"  => "error",
        "message" => $error_msg
    ]);
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>