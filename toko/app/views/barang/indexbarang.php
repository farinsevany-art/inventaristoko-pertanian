
<?php 
include __DIR__ . '/../templates/header.php';
$base_url = 'http://localhost/toko/public/';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Daftar Barang</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Barang</li>
            </ol>

            <?php
            require_once __DIR__ . '/../../models/Barang.php';
            $barangModel = new Barang();

            $filters = [
                'nama_barang' => $_GET['nama_barang'] ?? null,
                'jenis_barang' => $_GET['jenis_barang'] ?? null,
                'day' => $_GET['day'] ?? null,
                'month' => $_GET['month'] ?? null,
                'year' => $_GET['year'] ?? null,
            ];

            $barangs = $barangModel->getAll($filters);
            ?>

            <?php if (empty($barangs)) : ?>
                <div class="alert alert-info">Belum ada data barang.</div>
            <?php else : ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Barang
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Kadaluarsa</th>
                                    <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($barangs as $i => $row) : ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['jenis_barang']) ?></td>
                                        <td><?= htmlspecialchars($row['kadaluarsa_barang']) ?></td>

                                        <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                                            <td>
                                                <a class="btn btn-sm btn-primary" 
                                                   href="?url=barang/edit/<?= urlencode($row['id_barang']) ?>">
                                                   Edit
                                                </a>

                                                <a class="btn btn-sm btn-danger" 
                                                   href="?url=barang/delete/<?= urlencode($row['id_barang']) ?>" 
                                                   onclick="return confirm('Hapus barang ini?')">
                                                   Hapus
                                                </a>
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
