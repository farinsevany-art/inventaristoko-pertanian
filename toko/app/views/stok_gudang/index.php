<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Stok Gudang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Stok Gudang</li>
                        </ol>
                        <?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
                        <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                            <p><a class="btn btn-success" href="?url=stokgudang/create">Tambah Stok Gudang</a></p>
                        <?php endif; ?>
                        <form method="GET" action="<?= $base_url ?>?url=stokgudang/index" class="row g-3 mb-3">

    <!-- INI PALING PENTING -->
    <input type="hidden" name="url" value="stokgudang/index">

    <div class="col-md-3">
        <input type="text" name="nama_barang" class="form-control"
               placeholder="Nama Barang"
               value="<?= htmlspecialchars($_GET['nama_barang'] ?? '') ?>">
    </div>

    <div class="col-md-3">
        <select name="jenis_barang" class="form-select">
            <option value="">Pilih Jenis Barang</option>
            <?php foreach ($jenisBarangList as $jb): ?>
                <option value="<?= htmlspecialchars($jb['jenis_barang']) ?>"
                    <?= (isset($_GET['jenis_barang']) && $_GET['jenis_barang'] === $jb['jenis_barang']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($jb['jenis_barang']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <div class="row g-1">
            <div class="col">
                <select name="day" class="form-select">
                    <option value="">Hari</option>
                    <?php for ($d = 1; $d <= 31; $d++): ?>
                        <option value="<?= $d ?>" 
                            <?= (isset($_GET['day']) && (int)$_GET['day'] === $d) ? 'selected' : '' ?>>
                            <?= $d ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="col">
                <select name="month" class="form-select">
                    <option value="">Bulan</option>
                    <?php
                    $months = [
                        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
                        5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
                        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
                    ];
                    foreach ($months as $num => $name): ?>
                        <option value="<?= $num ?>"
                            <?= (isset($_GET['month']) && (int)$_GET['month'] === $num) ? 'selected' : '' ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <input type="number" name="year" class="form-control"
                       placeholder="Tahun"
                       value="<?= htmlspecialchars($_GET['year'] ?? '') ?>"
                       min="1900" max="2100">
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Filter</button>

        <!-- RESET AMAN -->
        <a href="<?= $base_url ?>?url=stokgudang/index" class="btn btn-secondary">
            Reset
        </a>
    </div>
</form>


                        <?php if (empty($data)) : ?>
                            <div class="alert alert-info">Belum ada stok gudang.</div>
                        <?php else : ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Data Stok Gudang
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <!-- <th>ID Stok Gudang</th>
                                                <th>ID Barang</th> -->
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
                                                    <td><?= $i+1 ?></td>
                                                    <!-- <td>/?= htmlspecialchars($row['id_stok_gudang']) ?></td>
                                                    <td>/?= htmlspecialchars($row['id_barang'] ?? '-') ?></td> -->
                                                    <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($row['jenis_barang'] ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($row['kadaluarsa_barang'] ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($row['total_stok_gudang']) ?></td>
                                                    <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                                                        <td>
                                                            <a class="btn btn-sm btn-primary" href="?url=stokgudang/edit/<?= urlencode($row['id_stok_gudang']) ?>">Edit</a>
                                                            <a class="btn btn-sm btn-danger" href="?url=stokgudang/delete/<?= urlencode($row['id_stok_gudang']) ?>" onclick="return confirm('Hapus stok gudang ini?')">Hapus</a>
                                                            <a class="btn btn-sm btn-success" href="?url=stokgudang/place/<?= urlencode($row['id_stok_gudang']) ?>">Tempatkan ke Etalase</a>
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
