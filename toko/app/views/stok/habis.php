<?php include __DIR__ . '/../templates/headeradmin.php'; ?>

<div id="layoutSidenav_content">
<main class="container-fluid px-4">

    <h1 class="mt-4">Stok Habis</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Stok = 0</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            Daftar Stok Habis
        </div>
        <div class="card-body">

            <div class="table-responsive">
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

                    <?php foreach ($zeroGudang as $item): ?>
                        <tr>
                            <td><?= $item['nama_barang'] ?></td>
                            <td>Gudang</td>
                            <td>0</td>
                            <td><span class="badge bg-danger">Habis</span></td>
                        </tr>
                    <?php endforeach ?>

                    <?php foreach ($zeroEtalase as $item): ?>
                        <tr>
                            <td><?= $item['nama_barang'] ?? 'Tidak diketahui' ?></td>
                            <td>Etalase</td>
                            <td>0</td>
                            <td><span class="badge bg-danger">Habis</span></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
            </div>

        </div>
    </div>

</main>
</div>
