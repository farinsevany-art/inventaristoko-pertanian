<?php
include __DIR__ . '/../templates/header.php';
$base_url = 'http://localhost/toko/public/';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Stok Etalase</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Stok Etalase</li>
            </ol>

            <?php if (empty($data)) : ?>
                <div class="alert alert-info">Belum ada stok etalase.</div>
            <?php else : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Stok Etalase
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Kadaluarsa</th>
                                    <th>Jumlah</th>
                                    <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $i => $row) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['jenis_barang'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['kadaluarsa_barang'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['total_stok_eta']) ?></td>
                                        <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="?url=stoketalase/edit/<?= urlencode($row['id_stok_etalase']) ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="?url=stoketalase/delete/<?= urlencode($row['id_stok_etalase']) ?>" onclick="return confirm('Hapus stok etalase ini?')">Hapus</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/assets/demo/chart-area-demo.js"></script>
<script src="<?= $base_url ?>admin/assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="<?= $base_url ?>admin/js/datatables-simple-demo.js"></script>

</body>
</html>
