<?php
$host     = 'localhost';
$user     = 'root';
$password = 'pandhu';
$database = 'db_blog';

$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'pesan' => 'Koneksi database gagal: ' . $koneksi->connect_error]);
    exit;
}

$koneksi->set_charset('utf8mb4');
