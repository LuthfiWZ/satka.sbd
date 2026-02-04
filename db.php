<?php
// Header CORS (aman untuk Postman & frontend)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Konfigurasi database (DISAMAKAN DENGAN DATABASE KAMU)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "satka_db"; // <<< database kamu

// Koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "status" => false,
        "message" => "Koneksi database gagal",
        "error" => $conn->connect_error
    ]);
    exit;
}
?>
