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

// Ambil nama gambar sebelum dihapus
$stmt_gambar = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_gambar->bind_param('i', $id);
$stmt_gambar->execute();
$data_gambar = $stmt_gambar->get_result()->fetch_assoc();
$stmt_gambar->close();

if (!$data_gambar) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan']);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    @unlink(__DIR__ . '/uploads_artikel/' . $data_gambar['gambar']);
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus artikel: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
