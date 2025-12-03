<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Stok Etalase</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="?url=stoketalase/index">Stok Etalase</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus me-1"></i>
                    Form Tambah Stok Etalase
                </div>
                <div class="card-body">
                    <form method="post" action="?url=stoketalase/store">
                        <!-- ID Stok Etalase akan dibuat otomatis -->
                        <div class="mb-3">
                            <label class="form-label">Total</label>
                            <input class="form-control" name="total_stok_eta" type="number" min="0" required />
                        </div>

                            <div class="mb-3">
                                <label class="form-label">Rak</label>
                                <input class="form-control" name="rak" type="text" placeholder="Masukkan rak, mis. R1-A" />
                            </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a class="btn btn-secondary" href="?url=stoketalase/index">Batal</a>
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

<!-- <div class="container mt-4">
    <h2>Tambah Stok Etalase</h2>
    <form method="post" action="?url=stoketalase/store">
        <div class="form-group">
            <label>Total</label>
            <input class="form-control" name="total_stok_eta" type="number" min="0" required />
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="?url=stoketalase/index">Batal</a>
    </form>
</div> -->
