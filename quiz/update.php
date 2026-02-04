<?php
// Koneksi ke database
include '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST
$id         = $_POST['id'];          // ID user
$pertanyaan   = $_POST['pertanyaan'];    // pert$pertanyaan
$pilihan_a      = $_POST['pilihan_a'];       // pi$pilihan_a
$pilihan_b      = $_POST['pilihan_b'];       // tipe_$pilihan_b (siswa, guru, dll)
$pilihan_c = $_POST['pilihan_c'];  // total poin
$pilihan_d = $_POST['pilihan_d'];
$jawaban_benar = $_POST['jawaban_benar'];
$penjelasan = $_POST['penjelasan'];
$tingkat_kesulitan = $_POST['tingkat_kesulitan'];
$satwa_id = $_POST['satwa_id'];

// Prepared statement 
$stmt = $conn->prepare("
    UPDATE quiz
    SET pertanyaan = ?, pilihan_a = ?, pilihan_b = ?, pilihan_c = ?, pilihan_d = ?, jawaban_benar = ?, tingkat_kesulitan = ?, satwa_id = ?
    WHERE id = ?
");

// s = string, i = integer
$stmt->bind_param(
    "sssii",
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

// Eksekusi
if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data user berhasil diperbarui",
        "data"    => [
            "id"         => $id,
            "pertanyaan"   => $pertanyaan,
            "pilihan_a"      => $pilihan_a,
            "pilihan_b"      => $pilihan_b,
            "pilihan_c" => $pilihan_c,
            "pilihan_d" => $pilihan_d,
            "jawaban_benar" => $jawaban_benar,
            "penjelasan" => $penjelasan,
            "tingkat_kesulitan" => $tingkat_kesulitan,
            "satwa_id" => $satwa_id,
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
