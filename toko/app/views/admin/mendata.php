<?php
include __DIR__ . '/../templates/headeradmin.php';
$base_url = 'http://localhost/toko/public/';
?>

<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pendataan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Pendataan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Pendataan
        </div>
        <div class="card-body">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mendataList as $i => $m): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($m['nama_barang'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($m['jenis_barang'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($karyawanMap[$m['id_karyawan']] ?? '-') ?></td>
                        <td><?= htmlspecialchars($m['tgl_pendataan']) ?></td>
                        <td><?= htmlspecialchars($m['stok_gudang_masuk']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>

</div>
</main>
</div>
