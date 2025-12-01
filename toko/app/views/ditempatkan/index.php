<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <h3 class="mt-4">Data Penempatan Stok Etalase</h3>
            
<form method="GET" action="<?= $base_url ?>?url=ditempatkan/index" class="row g-3 mb-3">
        <input type="hidden" name="url" value="ditempatkan/index">

                <div class="col-md-3">
                    <input type="text" name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?= htmlspecialchars($_GET['nama_barang'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <select name="jenis_barang" class="form-select">
                        <option value="">Pilih Jenis Barang</option>
                        <?php foreach ($data['jenisBarangList'] as $jb): ?>
                            <option value="<?= htmlspecialchars($jb['jenis_barang']) ?>" <?= (isset($_GET['jenis_barang']) && $_GET['jenis_barang'] === $jb['jenis_barang']) ? 'selected' : '' ?>><?= htmlspecialchars($jb['jenis_barang']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="row g-1">
                        <div class="col">
                            <select name="day" class="form-select">
                                <option value="">Hari</option>
                                <?php for ($d=1; $d<=31; $d++): ?>
                                    <option value="<?= $d ?>" <?= (isset($_GET['day']) && (int)$_GET['day'] === $d) ? 'selected' : '' ?>><?= $d ?></option>
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
                                    <option value="<?= $num ?>" <?= (isset($_GET['month']) && (int)$_GET['month'] === $num) ? 'selected' : '' ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" name="year" class="form-control" placeholder="Tahun" value="<?= htmlspecialchars($_GET['year'] ?? '') ?>" min="1900" max="2100" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="?url=ditempatkan/index" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-arrow-right-arrow-left me-1"></i>
                    Riwayat Penempatan Stok
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead class="table table-bordered">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Tanggal</th>
                                <th>Gudang Keluar</th>
                                <th>Etalase Masuk</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($data['ditempatkan'] as $row): ?>
                            <tr>
                                <td><?= $row['nama_barang']; ?></td>
                                <td><?= $row['jenis_barang']; ?></td>
                                <td><?= $row['tgl_penempatan']; ?></td>
                                <td><?= $row['stok_gudang_keluar']; ?></td>
                                <td><?= $row['stok_etalase_masuk']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                    </div>

                </div>
            </div>

        </div>
    </main>
</div>
