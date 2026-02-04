<?php
// Koneksi database
include_once '../db.php';

// Response JSON
header('Content-Type: application/json');

// Ambil data dari POST atau JSON
$data = json_decode(file_get_contents("php://input"), true);

$username   = $_POST['username']   ?? $data['username']   ?? null;
$email      = $_POST['email']      ?? $data['email']      ?? null;
$peran      = $_POST['peran']      ?? $data['peran']      ?? null;
$poin_total = $_POST['poin_total'] ?? $data['poin_total'] ?? null;

// Validasi wajib
if (!$username || !$email || !$peran || $poin_total === null) {
    http_response_code(400);
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter tidak lengkap"
    ]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("
    INSERT INTO users (username, email, peran, poin_total)
    VALUES (?, ?, ?, ?)
");

// s = string, i = integer
$stmt->bind_param(
    "sssi",
    $username,
    $email,
    $peran,
    $poin_total
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
            "username"   => $username,
            "email"      => $email,
            "peran"      => $peran,
            "poin_total" => $poin_total
        ]
    ]);

} else {
    // Menangkap error jika terjadi duplikasi tanpa merusak struktur logika utama
    http_response_code(400); // Bad Request
    
    $error_msg = $stmt->error;
    if (str_contains($error_msg, 'Duplicate entry')) {
        $error_msg = "Username '$username' sudah digunakan, silakan pilih yang lain.";
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