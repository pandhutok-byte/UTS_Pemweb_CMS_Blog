<?php
header('Content-Type: application/json');
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'pesan' => 'Metode tidak diizinkan']);
    exit;
}

$id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nama_depan    = trim($_POST['nama_depan']    ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name']     ?? '');
$password_baru = trim($_POST['password']      ?? '');

if ($id <= 0 || $nama_depan === '' || $nama_belakang === '' || $user_name === '') {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama untuk foto
$stmt_lama = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_lama->bind_param('i', $id);
$stmt_lama->execute();
$result_lama = $stmt_lama->get_result();
$data_lama   = $result_lama->fetch_assoc();
$stmt_lama->close();

if (!$data_lama) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak ditemukan']);
    exit;
}

$nama_foto = $data_lama['foto'];

// Proses upload foto baru jika ada
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_tmp  = $_FILES['foto']['tmp_name'];
    $file_size = $_FILES['foto']['size'];

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

    $ekstensi      = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nama_foto_baru = uniqid('penulis_', true) . '.' . strtolower($ekstensi);
    $tujuan         = __DIR__ . '/uploads_penulis/' . $nama_foto_baru;

    if (!move_uploaded_file($file_tmp, $tujuan)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan foto']);
        exit;
    }

    // Hapus foto lama jika bukan default
    if ($nama_foto !== 'default.png') {
        @unlink(__DIR__ . '/uploads_penulis/' . $nama_foto);
    }

    $nama_foto = $nama_foto_baru;
}

// Bangun query update
if ($password_baru !== '') {
    $password_hash = password_hash($password_baru, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $password_hash, $nama_foto, $id);
} else {
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $nama_foto, $id);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'sukses', 'pesan' => 'Data penulis berhasil diperbarui']);
} else {
    if ($koneksi->errno === 1062) {
        echo json_encode(['status' => 'error', 'pesan' => 'Username sudah digunakan']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal memperbarui data: ' . $stmt->error]);
    }
}

$stmt->close();
$koneksi->close();
