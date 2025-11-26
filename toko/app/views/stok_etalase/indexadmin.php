<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Stok Etalase</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Stok Etalase</li>
            </ol>

           <form method="GET" class="row g-3 mb-3">

    <!-- INI YANG PALING PENTING -->
    <input type="hidden" name="url" value="stoketalase/index">

    <div class="col-md-3">
        <input type="text" name="nama_barang"
               class="form-control"
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
                        <option value="<?= $d ?>" <?= (isset($_GET['day']) && (int)$_GET['day'] === $d) ? 'selected' : '' ?>>
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
                        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni',
                        7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
                    ];
                    foreach ($months as $num => $name): ?>
                        <option value="<?= $num ?>" <?= (isset($_GET['month']) && (int)$_GET['month'] === $num) ? 'selected' : '' ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <input type="number" name="year"
                       class="form-control"
                       placeholder="Tahun"
                       value="<?= htmlspecialchars($_GET['year'] ?? '') ?>"
                       min="1900" max="2100" />
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Filter</button>

        <!-- Reset tetap aman untuk router -->
        <a href="?url=stoketalase/index" class="btn btn-secondary">Reset</a>
    </div>
</form>


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
                                    <!-- <th>ID Etalase</th> -->
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
                                        <!-- <td><?= htmlspecialchars($row['id_stok_etalase']) ?></td> -->
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
</div>
<!-- Footer tetap sama -->
</body>
</html>
