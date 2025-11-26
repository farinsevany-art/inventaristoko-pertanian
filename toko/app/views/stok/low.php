<?php include __DIR__ . '/../templates/headeradmin.php'; ?>

<div id="layoutSidenav_content">
<main class="container-fluid px-4">

    <h1 class="mt-4">Stok Menipis</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Stok &lt; 10</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            Daftar Stok Menipis (Gudang & Etalase)
        </div>
        <div class="card-body">
            
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Lokasi</th>
                        <th>Sisa Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($lowGudang as $item): ?>
                        <tr>
                            <td><?= $item['nama_barang'] ?></td>
                            <td>Gudang</td>
                            <td><?= $item['total_stok_gudang'] ?></td>
                            <td><span class="badge bg-warning">Menipis</span></td>
                        </tr>
                    <?php endforeach ?>

                    <?php foreach ($lowEtalase as $item): ?>
                        <tr>
                            <td><?= $item['nama_barang'] ?? 'Tidak diketahui' ?></td>
                            <td>Etalase</td>
                            <td><?= $item['total_stok_eta'] ?></td>
                            <td><span class="badge bg-warning">Menipis</span></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>

        </div>
    </div>
</main>
</div>
