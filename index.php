<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-size: 0.9rem; }

        /* Header */
        .app-header {
            background: #2c3e50;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }
        .app-header h5 { margin: 0; font-weight: 600; }
        .app-header small { opacity: 0.7; font-size: 0.75rem; }

        /* Layout */
        .main-wrapper { display: flex; min-height: calc(100vh - 56px); }

        /* Sidebar */
        .sidebar {
            width: 220px;
            min-width: 220px;
            background: #fff;
            border-right: 1px solid #dee2e6;
            padding: 20px 0;
        }
        .sidebar .menu-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 16px 8px;
        }
        .sidebar .nav-item { list-style: none; }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #495057;
            border-radius: 0;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover { background: #f8f9fa; color: #2c3e50; }
        .sidebar .nav-link.active {
            background: #e8f0fe;
            color: #1a73e8;
            border-left-color: #1a73e8;
            font-weight: 600;
        }

        /* Content area */
        .content-area { flex: 1; padding: 24px; overflow-x: auto; }

        /* Table styling */
        .table th { background: #f8f9fa; font-size: 0.8rem; text-transform: uppercase; color: #6c757d; letter-spacing: 0.5px; }
        .table td { vertical-align: middle; }
        .foto-thumb { width: 44px; height: 44px; object-fit: cover; border-radius: 8px; border: 2px solid #dee2e6; }
        .gambar-thumb { width: 60px; height: 44px; object-fit: cover; border-radius: 6px; }

        /* Badges */
        .badge-kategori { background: #e3f2fd; color: #1565c0; font-size: 0.75rem; padding: 4px 8px; border-radius: 12px; font-weight: 500; }

        /* Password mask */
        .pw-mask { font-family: monospace; letter-spacing: 2px; color: #6c757d; font-size: 0.8rem; }

        /* Toast */
        .toast-container { position: fixed; top: 70px; right: 20px; z-index: 9999; }

        /* Modal footer */
        .modal-footer .btn { min-width: 100px; }

        /* Loading */
        .loading-spinner { text-align: center; padding: 40px; color: #6c757d; }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="app-header">
    <i class="bi bi-pencil-square fs-5"></i>
    <div>
        <h5>Sistem Manajemen Blog (CMS)</h5>
        <small>Blog Keren</small>
    </div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="menu-label">Menu Utama</div>
        <ul class="nav flex-column p-0">
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="loadMenu('penulis', this)">
                    <i class="bi bi-person-circle"></i> Kelola Penulis
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="loadMenu('artikel', this)">
                    <i class="bi bi-file-earmark-text"></i> Kelola Artikel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="loadMenu('kategori', this)">
                    <i class="bi bi-bookmark"></i> Kelola Kategori
                </a>
            </li>
        </ul>
    </nav>

    <!-- CONTENT AREA -->
    <main class="content-area" id="konten-utama">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2">Memuat data...</p>
        </div>
    </main>

</div>

<!-- ============================================================ -->
<!-- MODAL PENULIS - TAMBAH -->
<!-- ============================================================ -->
<div class="modal fade" id="modalTambahPenulis" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Tambah Penulis</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Nama Depan</label>
                        <input type="text" id="tp-nama-depan" class="form-control" placeholder="Ahmad">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" id="tp-nama-belakang" class="form-control" placeholder="Fauzi">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Username</label>
                        <input type="text" id="tp-username" class="form-control" placeholder="ahmad_f">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input type="password" id="tp-password" class="form-control" placeholder="••••••••••••">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" id="tp-foto" class="form-control" accept="image/*">
                        <div class="form-text">JPG/PNG/GIF/WEBP, maks. 2 MB. Kosongkan untuk foto default.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanPenulis()">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENULIS - EDIT -->
<div class="modal fade" id="modalEditPenulis" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Edit Penulis</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ep-id">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Nama Depan</label>
                        <input type="text" id="ep-nama-depan" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" id="ep-nama-belakang" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Username</label>
                        <input type="text" id="ep-username" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password Baru <span class="text-muted">(kosongkan jika tidak diganti)</span></label>
                        <input type="password" id="ep-password" class="form-control" placeholder="••••••••••••">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Foto Profil <span class="text-muted">(kosongkan jika tidak diganti)</span></label>
                        <input type="file" id="ep-foto" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updatePenulis()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL ARTIKEL - TAMBAH -->
<!-- ============================================================ -->
<div class="modal fade" id="modalTambahArtikel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Tambah Artikel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Judul</label>
                        <input type="text" id="ta-judul" class="form-control" placeholder="Judul artikel...">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Penulis</label>
                        <select id="ta-penulis" class="form-select"></select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Kategori</label>
                        <select id="ta-kategori" class="form-select"></select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Isi Artikel</label>
                        <textarea id="ta-isi" class="form-control" rows="5" placeholder="Tulis isi artikel di sini..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gambar</label>
                        <input type="file" id="ta-gambar" class="form-control" accept="image/*">
                        <div class="form-text">JPG/PNG/GIF/WEBP, maks. 2 MB. Wajib diisi.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanArtikel()">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ARTIKEL - EDIT -->
<div class="modal fade" id="modalEditArtikel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Edit Artikel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ea-id">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Judul</label>
                        <input type="text" id="ea-judul" class="form-control">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Penulis</label>
                        <select id="ea-penulis" class="form-select"></select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Kategori</label>
                        <select id="ea-kategori" class="form-select"></select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Isi Artikel</label>
                        <textarea id="ea-isi" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gambar <span class="text-muted">(kosongkan jika tidak diganti)</span></label>
                        <input type="file" id="ea-gambar" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateArtikel()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL KATEGORI - TAMBAH -->
<!-- ============================================================ -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Tambah Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" id="tk-nama" class="form-control" placeholder="Nama kategori...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea id="tk-keterangan" class="form-control" rows="3" placeholder="Deskripsi kategori..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanKategori()">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KATEGORI - EDIT -->
<div class="modal fade" id="modalEditKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold">Edit Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ek-id">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" id="ek-nama" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea id="ek-keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateKategori()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL KONFIRMASI HAPUS -->
<!-- ============================================================ -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body py-4">
                <div class="mb-3">
                    <i class="bi bi-trash3 text-danger" style="font-size: 2.5rem;"></i>
                </div>
                <h6 class="fw-bold mb-1">Hapus data ini?</h6>
                <p class="text-muted small mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btn-konfirmasi-hapus">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- TOAST NOTIFIKASI -->
<div class="toast-container">
    <div id="notif-toast" class="toast align-items-center border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-semibold" id="notif-pesan"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ============================================================
// UTILITAS
// ============================================================
function esc(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function tampilNotif(pesan, tipe = 'success') {
    const toastEl = document.getElementById('notif-toast');
    const pesanEl = document.getElementById('notif-pesan');
    toastEl.className = `toast align-items-center border-0 text-bg-${tipe}`;
    pesanEl.textContent = pesan;
    const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
    toast.show();
}

function loadMenu(menu, el) {
    document.querySelectorAll('.sidebar .nav-link').forEach(a => a.classList.remove('active'));
    el.classList.add('active');
    if (menu === 'penulis') loadPenulis();
    else if (menu === 'artikel') loadArtikel();
    else if (menu === 'kategori') loadKategori();
}

function setLoading() {
    document.getElementById('konten-utama').innerHTML = `
        <div class="loading-spinner">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2 text-muted">Memuat data...</p>
        </div>`;
}

// ============================================================
// PENULIS
// ============================================================
function loadPenulis() {
    setLoading();
    fetch('ambil_penulis.php')
        .then(r => r.json())
        .then(res => {
            let rows = '';
            if (res.data && res.data.length > 0) {
                res.data.forEach(p => {
                    const foto = p.foto ? `uploads_penulis/${esc(p.foto)}` : `uploads_penulis/default.png`;
                    const pwMask = p.password ? p.password.substring(0, 12) + '....' : '—';
                    rows += `<tr>
                        <td><img src="${foto}" class="foto-thumb" onerror="this.src='uploads_penulis/default.png'"></td>
                        <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
                        <td><code>${esc(p.user_name)}</code></td>
                        <td><span class="pw-mask">${esc(pwMask)}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="bukaEditPenulis(${p.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="konfirmasiHapus('penulis', ${p.id})">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = `<tr><td colspan="5" class="text-center text-muted py-4">Belum ada data penulis</td></tr>`;
            }
            document.getElementById('konten-utama').innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">Data Penulis</h6>
                    <button class="btn btn-primary btn-sm" onclick="bukaTambahPenulis()">
                        <i class="bi bi-plus-lg"></i> Tambah Penulis
                    </button>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>FOTO</th><th>NAMA</th><th>USERNAME</th>
                                    <th>PASSWORD</th><th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                </div>`;
        })
        .catch(() => tampilNotif('Gagal memuat data penulis', 'danger'));
}

function bukaTambahPenulis() {
    ['tp-nama-depan','tp-nama-belakang','tp-username','tp-password'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('tp-foto').value = '';
    new bootstrap.Modal(document.getElementById('modalTambahPenulis')).show();
}

function simpanPenulis() {
    const fd = new FormData();
    fd.append('nama_depan',    document.getElementById('tp-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('tp-nama-belakang').value.trim());
    fd.append('user_name',     document.getElementById('tp-username').value.trim());
    fd.append('password',      document.getElementById('tp-password').value.trim());
    const fotoFile = document.getElementById('tp-foto').files[0];
    if (fotoFile) fd.append('foto', fotoFile);

    fetch('simpan_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalTambahPenulis')).hide();
                tampilNotif(res.pesan);
                loadPenulis();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        })
        .catch(() => tampilNotif('Terjadi kesalahan', 'danger'));
}

function bukaEditPenulis(id) {
    fetch(`ambil_satu_penulis.php?id=${id}`)
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                const p = res.data;
                document.getElementById('ep-id').value          = p.id;
                document.getElementById('ep-nama-depan').value  = p.nama_depan;
                document.getElementById('ep-nama-belakang').value = p.nama_belakang;
                document.getElementById('ep-username').value    = p.user_name;
                document.getElementById('ep-password').value    = '';
                document.getElementById('ep-foto').value        = '';
                new bootstrap.Modal(document.getElementById('modalEditPenulis')).show();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

function updatePenulis() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ep-id').value);
    fd.append('nama_depan',    document.getElementById('ep-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('ep-nama-belakang').value.trim());
    fd.append('user_name',     document.getElementById('ep-username').value.trim());
    fd.append('password',      document.getElementById('ep-password').value.trim());
    const fotoFile = document.getElementById('ep-foto').files[0];
    if (fotoFile) fd.append('foto', fotoFile);

    fetch('update_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalEditPenulis')).hide();
                tampilNotif(res.pesan);
                loadPenulis();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

// ============================================================
// ARTIKEL
// ============================================================
function loadArtikel() {
    setLoading();
    fetch('ambil_artikel.php')
        .then(r => r.json())
        .then(res => {
            let rows = '';
            if (res.data && res.data.length > 0) {
                res.data.forEach(a => {
                    rows += `<tr>
                        <td><img src="uploads_artikel/${esc(a.gambar)}" class="gambar-thumb" onerror="this.style.display='none'"></td>
                        <td>${esc(a.judul)}</td>
                        <td><span class="badge-kategori">${esc(a.nama_kategori)}</span></td>
                        <td>${esc(a.nama_penulis)}</td>
                        <td><small class="text-muted">${esc(a.hari_tanggal)}</small></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="bukaEditArtikel(${a.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="konfirmasiHapus('artikel', ${a.id})">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = `<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data artikel</td></tr>`;
            }
            document.getElementById('konten-utama').innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">Data Artikel</h6>
                    <button class="btn btn-primary btn-sm" onclick="bukaTambahArtikel()">
                        <i class="bi bi-plus-lg"></i> Tambah Artikel
                    </button>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>GAMBAR</th><th>JUDUL</th><th>KATEGORI</th>
                                    <th>PENULIS</th><th>TANGGAL</th><th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                </div>`;
        })
        .catch(() => tampilNotif('Gagal memuat data artikel', 'danger'));
}

function bukaTambahArtikel() {
    ['ta-judul','ta-isi'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('ta-gambar').value = '';
    // Isi dropdown penulis & kategori
    isiDropdown('ambil_penulis.php',  'ta-penulis',  'penulis');
    isiDropdown('ambil_kategori.php', 'ta-kategori', 'kategori');
    new bootstrap.Modal(document.getElementById('modalTambahArtikel')).show();
}

function isiDropdown(url, elId, tipe, selectedId = null) {
    fetch(url)
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById(elId);
            sel.innerHTML = '';
            if (res.data) {
                res.data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    if (tipe === 'penulis') {
                        opt.textContent = `${item.nama_depan} ${item.nama_belakang}`;
                    } else {
                        opt.textContent = item.nama_kategori;
                    }
                    if (selectedId && item.id == selectedId) opt.selected = true;
                    sel.appendChild(opt);
                });
            }
        });
}

function simpanArtikel() {
    const fd = new FormData();
    fd.append('judul',       document.getElementById('ta-judul').value.trim());
    fd.append('id_penulis',  document.getElementById('ta-penulis').value);
    fd.append('id_kategori', document.getElementById('ta-kategori').value);
    fd.append('isi',         document.getElementById('ta-isi').value.trim());
    const gambarFile = document.getElementById('ta-gambar').files[0];
    if (gambarFile) fd.append('gambar', gambarFile);

    fetch('simpan_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalTambahArtikel')).hide();
                tampilNotif(res.pesan);
                loadArtikel();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

function bukaEditArtikel(id) {
    fetch(`ambil_satu_artikel.php?id=${id}`)
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                const a = res.data;
                document.getElementById('ea-id').value    = a.id;
                document.getElementById('ea-judul').value = a.judul;
                document.getElementById('ea-isi').value   = a.isi;
                document.getElementById('ea-gambar').value = '';
                isiDropdown('ambil_penulis.php',  'ea-penulis',  'penulis',  a.id_penulis);
                isiDropdown('ambil_kategori.php', 'ea-kategori', 'kategori', a.id_kategori);
                new bootstrap.Modal(document.getElementById('modalEditArtikel')).show();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

function updateArtikel() {
    const fd = new FormData();
    fd.append('id',          document.getElementById('ea-id').value);
    fd.append('judul',       document.getElementById('ea-judul').value.trim());
    fd.append('id_penulis',  document.getElementById('ea-penulis').value);
    fd.append('id_kategori', document.getElementById('ea-kategori').value);
    fd.append('isi',         document.getElementById('ea-isi').value.trim());
    const gambarFile = document.getElementById('ea-gambar').files[0];
    if (gambarFile) fd.append('gambar', gambarFile);

    fetch('update_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalEditArtikel')).hide();
                tampilNotif(res.pesan);
                loadArtikel();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

// ============================================================
// KATEGORI
// ============================================================
function loadKategori() {
    setLoading();
    fetch('ambil_kategori.php')
        .then(r => r.json())
        .then(res => {
            let rows = '';
            if (res.data && res.data.length > 0) {
                res.data.forEach(k => {
                    rows += `<tr>
                        <td><span class="badge-kategori">${esc(k.nama_kategori)}</span></td>
                        <td>${esc(k.keterangan) || '<span class="text-muted">—</span>'}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="bukaEditKategori(${k.id})">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="konfirmasiHapus('kategori', ${k.id})">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = `<tr><td colspan="3" class="text-center text-muted py-4">Belum ada data kategori</td></tr>`;
            }
            document.getElementById('konten-utama').innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold">Data Kategori Artikel</h6>
                    <button class="btn btn-primary btn-sm" onclick="bukaTambahKategori()">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
                    </button>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr><th>NAMA KATEGORI</th><th>KETERANGAN</th><th>AKSI</th></tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                </div>`;
        })
        .catch(() => tampilNotif('Gagal memuat data kategori', 'danger'));
}

function bukaTambahKategori() {
    document.getElementById('tk-nama').value        = '';
    document.getElementById('tk-keterangan').value  = '';
    new bootstrap.Modal(document.getElementById('modalTambahKategori')).show();
}

function simpanKategori() {
    const fd = new FormData();
    fd.append('nama_kategori', document.getElementById('tk-nama').value.trim());
    fd.append('keterangan',    document.getElementById('tk-keterangan').value.trim());

    fetch('simpan_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalTambahKategori')).hide();
                tampilNotif(res.pesan);
                loadKategori();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

function bukaEditKategori(id) {
    fetch(`ambil_satu_kategori.php?id=${id}`)
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                document.getElementById('ek-id').value          = res.data.id;
                document.getElementById('ek-nama').value        = res.data.nama_kategori;
                document.getElementById('ek-keterangan').value  = res.data.keterangan || '';
                new bootstrap.Modal(document.getElementById('modalEditKategori')).show();
            }
        });
}

function updateKategori() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ek-id').value);
    fd.append('nama_kategori', document.getElementById('ek-nama').value.trim());
    fd.append('keterangan',    document.getElementById('ek-keterangan').value.trim());

    fetch('update_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.status === 'sukses') {
                bootstrap.Modal.getInstance(document.getElementById('modalEditKategori')).hide();
                tampilNotif(res.pesan);
                loadKategori();
            } else {
                tampilNotif(res.pesan, 'danger');
            }
        });
}

// ============================================================
// KONFIRMASI HAPUS (universal)
// ============================================================
function konfirmasiHapus(tipe, id) {
    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();

    const urlMap = {
        penulis:  'hapus_penulis.php',
        artikel:  'hapus_artikel.php',
        kategori: 'hapus_kategori.php'
    };

    const loadMap = {
        penulis:  loadPenulis,
        artikel:  loadArtikel,
        kategori: loadKategori
    };

    document.getElementById('btn-konfirmasi-hapus').onclick = function () {
        const fd = new FormData();
        fd.append('id', id);

        fetch(urlMap[tipe], { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                modal.hide();
                if (res.status === 'sukses') {
                    tampilNotif(res.pesan);
                    loadMap[tipe]();
                } else {
                    tampilNotif(res.pesan, 'danger');
                }
            });
    };
}

// ============================================================
// INIT - load penulis pertama kali
// ============================================================
document.addEventListener('DOMContentLoaded', () => loadPenulis());
</script>
</body>
</html>
