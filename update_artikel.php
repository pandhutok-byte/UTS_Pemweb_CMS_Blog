<?php
header('Content-Type: application/json');
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'pesan' => 'Metode tidak diizinkan']);
    exit;
}

$id          = isset($_POST['id'])          ? (int)$_POST['id']          : 0;
$judul       = trim($_POST['judul']         ?? '');
$id_penulis  = isset($_POST['id_penulis'])  ? (int)$_POST['id_penulis']  : 0;
$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
$isi         = trim($_POST['isi']           ?? '');

if ($id <= 0 || $judul === '' || $id_penulis <= 0 || $id_kategori <= 0 || $isi === '') {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap']);
    exit;
}

// Ambil gambar lama
$stmt_lama = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt_lama->bind_param('i', $id);
$stmt_lama->execute();
$data_lama = $stmt_lama->get_result()->fetch_assoc();
$stmt_lama->close();

if (!$data_lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan']);
    exit;
}

$nama_gambar = $data_lama['gambar'];

// Proses upload gambar baru jika ada
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $file_tmp  = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];

    if ($file_size > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'pesan' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $finfo     = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file_tmp);
    $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime_type, $allowed)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Tipe file tidak diizinkan']);
        exit;
    }

    $ekstensi        = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $nama_gambar_baru = uniqid('artikel_', true) . '.' . strtolower($ekstensi);
    $tujuan           = __DIR__ . '/uploads_artikel/' . $nama_gambar_baru;

    if (!move_uploaded_file($file_tmp, $tujuan)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan gambar']);
        exit;
    }

    // Hapus gambar lama
    @unlink(__DIR__ . '/uploads_artikel/' . $nama_gambar);
    $nama_gambar = $nama_gambar_baru;
}

$stmt = $koneksi->prepare(
    "UPDATE artikel SET judul=?, id_penulis=?, id_kategori=?, isi=?, gambar=? WHERE id=?"
);
$stmt->bind_param('siissi', $judul, $id_penulis, $id_kategori, $isi, $nama_gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Artikel berhasil diperbarui']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui artikel: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
