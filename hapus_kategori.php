<?php
header('Content-Type: application/json');
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'pesan' => 'Metode tidak diizinkan']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'ID tidak valid']);
    exit;
}

// Cek apakah kategori masih dipakai artikel
$stmt_cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_kategori = ?");
$stmt_cek->bind_param('i', $id);
$stmt_cek->execute();
$hasil_cek = $stmt_cek->get_result()->fetch_assoc();
$stmt_cek->close();

if ($hasil_cek['jumlah'] > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Kategori tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Kategori berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus kategori: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
