<?php
// Koneksi database
include_once '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$nama_kategori   = $_POST['nama_kategori']   ?? $data['nama_kategori']   ?? null;
$deskripsi      = $_POST['deskripsi']      ?? $data['deskripsi']      ?? null;


// Validasi wajib
if (!$nama_kategori || !$deskripsi === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO kategori (nama_kategori, deskripsi)
    VALUES (?, ?)
");

// s = string, i = integer
$stmt->bind_param(
    "sssi",
    $nama_kategori,
    $deskripsi
    
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
            "nama_kategori"   => $nama_kategori,
            "deskripsi"      => $deskripsi
        ]
    ]);

} else {
    // Menangkap error jika terjadi duplikasi tanpa merusak struktur logika utama
    http_response_code(400); // Bad Request
    
    $error_msg = $stmt->error;
    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Username '$nama_kategori' sudah digunakan, silakan pilih yang lain.";
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