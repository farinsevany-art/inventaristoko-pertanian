<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tempatkan Stok ke Etalase</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="?url=stokgudang/index">Stok Gudang</a></li>
                <li class="breadcrumb-item active">Tempatkan ke Etalase</li>
            </ol>

            <?php if (empty($stok)) : ?>
                <div class="alert alert-danger">Stok tidak ditemukan.</div>
            <?php else : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-box-open me-1"></i>
                        Form Penempatan Stok ke Etalase
                    </div>
                    <div class="card-body">
                        <!-- Info Barang yang akan dipindahkan -->
                        <div class="mb-3 p-3 bg-light rounded">
                            <h6>Informasi Barang:</h6>
                            <p><strong>Nama:</strong> <?= htmlspecialchars($stok['nama_barang']) ?></p>
                            <p><strong>Jenis:</strong> <?= htmlspecialchars($stok['jenis_barang']) ?></p>
                            <p><strong>Kadaluarsa:</strong> <?= htmlspecialchars($stok['kadaluarsa_barang']) ?></p>
                            <p><strong>Stok Tersedia:</strong> <?= htmlspecialchars($stok['total_stok_gudang']) ?></p>
                        </div>

                        <form method="post" action="?url=stokgudang/placeStore">
                            <input type="hidden" name="id_stok_gudang" value="<?= htmlspecialchars($stok['id_stok_gudang']) ?>">

                            <div class="mb-3">
                                <label class="form-label">Pilih Etalase</label>
                                <?php if (empty($etalases)) : ?>
                                    <div class="alert alert-warning">Tidak ada etalase yang cocok untuk barang ini. Sistem akan membuat etalase baru.</div>
                                    <input type="hidden" name="buat_etalase_baru" value="1" id="buat_etalase_baru">
                                <?php else : ?>
                                    <select name="id_stok_etalase" class="form-select" id="id_stok_etalase" required>
                                        <option value="">-- Pilih Etalase --</option>
                                        <?php foreach ($etalases as $e) : ?>
                                            <option value="<?= htmlspecialchars($e['id_stok_etalase']) ?>">
                                                <?= htmlspecialchars(
                                                    $e['id_stok_etalase'] . ' - ' . 
                                                    ($e['nama_barang'] ?? 'Etalase') . ' | ' . 
                                                    ($e['jenis_barang'] ?? '') . ' | ' . 
                                                    'Stok: ' . $e['total_stok_eta']
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        Atau biarkan kosong untuk <strong>buat etalase baru</strong>
                                        <input type="hidden" name="buat_etalase_baru" value="0" id="buat_etalase_baru">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah yang Dipindah</label>
                                <input type="number" name="stok_gudang_keluar" class="form-control"
                                       min="1" max="<?= htmlspecialchars($stok['total_stok_gudang']) ?>" value="1" required>
                                <small class="form-text text-muted">Maksimal: <?= htmlspecialchars($stok['total_stok_gudang']) ?> unit</small>
                            </div>

                            <input type="hidden" name="tgl_penempatan" value="<?= date('Y-m-d') ?>">

                            <button class="btn btn-primary">Simpan Penempatan</button>
                            <a class="btn btn-secondary" href="?url=stokgudang/index">Batal</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/js/scripts.js"></script>

<script>
// JavaScript to toggle buat_etalase_baru based on dropdown selection
document.addEventListener('DOMContentLoaded', function() {
    const etalaseSelect = document.getElementById('id_stok_etalase');
    const buatEtalaseInput = document.getElementById('buat_etalase_baru');

    if (etalaseSelect && buatEtalaseInput) {
        etalaseSelect.addEventListener('change', function() {
            if (etalaseSelect.value === '') {
                // Blank selection, create new etalase
                buatEtalaseInput.value = '1';
                etalaseSelect.removeAttribute('required');
            } else {
                // Existing etalase selected
                buatEtalaseInput.value = '0';
                etalaseSelect.setAttribute('required', 'required');
            }
        });
    }
});
</script>
</body>
</html>
