<?php
// Koneksi database
include_once '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$nama_latin   = $_POST['nama_latin']   ?? $data['nama_latin']   ?? null;
$nama_umum      = $_POST['nama_umum']      ?? $data['nama_umum']      ?? null;
$deskripsi      = $_POST['deskripsi']      ?? $data['deskripsi']      ?? null;
$habitat      = $_POST['habitat']      ?? $data['habitat']      ?? null;
$status_konservasi      = $_POST['status_konservasi']      ?? $data['status_konservasi']      ?? null;
$upaya_konservasi      = $_POST['upaya_konservasi']      ?? $data['upaya_konservasi']      ?? null;
$gambar_url = $_POST['gambar_url'] ?? $data['gambar_url'] ?? null;
$created_at      = $_POST['created_at']      ?? $data['created_at']      ?? null;
$updated_at      = $_POST['updated_at']      ?? $data['updated_at']      ?? null;

// Validasi wajib
if (!$nama_latin || !$nama_umum || !$deskripsi || !$habitat || !$status_konservasi || !$upaya_konservasi || $gambar_url || !$created_at || !$updated_at === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO satwa (nama_latin, nama_umum, deskripsi, habitat, status_konservasi, upaya_konservasi, gambar_url, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// s = string, i = integer
$stmt->bind_param(
    "sssi",
    $nama_latin,
    $nama_umum,
    $deskripsi,
    $habitat,
    $status_konservasi,
    $upaya_konservasi,
    $gambar_url,
    $created_at,
    $updated_at
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
            "nama_latin"   => $nama_latin,
            "nama_umum"      => $nama_umum,
            "deskripsi"      => $deskripsi,
            "habitat"      => $habitat,
            "status_konservasi"      => $status_konservasi,
            "upaya_konservasi"      => $upaya_konservasi,
            "gambar_url" => $gambar_url,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
        ]
    ]);

} else {
    // Menangkap error jika terjadi duplikasi tanpa merusak struktur logika utama
    http_response_code(400); // Bad Request
    
    $error_msg = $stmt->error;
    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Username '$nama_latin' sudah digunakan, silakan pilih yang lain.";
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