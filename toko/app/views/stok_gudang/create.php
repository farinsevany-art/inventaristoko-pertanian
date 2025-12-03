<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Stok Gudang</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus me-1"></i>
                    Form Tambah Stok Gudang
                </div>
                <div class="card-body">
                    <form method="post" action="?url=stokgudang/store">
                        <div class="mb-3">
                            <label class="form-label">Pilih Barang</label>
                            <?php require_once __DIR__ . '/../../models/Barang.php'; $bm = new Barang(); $allB = $bm->getAll(); ?>
                            <select class="form-select" name="id_barang" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($allB as $b): ?>
                                    <option value="<?= htmlspecialchars($b['id_barang']) ?>"><?= htmlspecialchars($b['id_barang'] . ' - ' . $b['nama_barang'] . ' | ' . $b['jenis_barang']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label">Kadaluarsa Barang</label>
                            <input type="date" class="form-control" name="kadaluarsa_barang" required />
                        </div> -->
                        <div class="mb-3">
                            <label class="form-label">Total Stok Gudang</label>
                            <input class="form-control" name="total_stok_gudang" type="number" min="0" required />
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                        <a class="btn btn-secondary" href="?url=stokgudang/index">Batal</a>
                    </form>
                </div>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/assets/demo/chart-area-demo.js"></script>
<script src="<?= $base_url ?>admin/assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/js/datatables-simple-demo.js"></script>

</body>
</html>
