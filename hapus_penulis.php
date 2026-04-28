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

// Cek apakah penulis masih punya artikel
$stmt_cek = $koneksi->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$stmt_cek->bind_param('i', $id);
$stmt_cek->execute();
$hasil_cek = $stmt_cek->get_result()->fetch_assoc();
$stmt_cek->close();

if ($hasil_cek['jumlah'] > 0) {
    echo json_encode(['status' => 'error', 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

// Ambil nama foto sebelum dihapus
$stmt_foto = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_foto->bind_param('i', $id);
$stmt_foto->execute();
$data_foto = $stmt_foto->get_result()->fetch_assoc();
$stmt_foto->close();

if (!$data_foto) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan']);
    exit;
}

// Hapus data dari database
$stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file foto jika bukan default
    if ($data_foto['foto'] !== 'default.png') {
        @unlink(__DIR__ . '/uploads_penulis/' . $data_foto['foto']);
    }
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal menghapus data: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
