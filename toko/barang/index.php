<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Daftar Barang</h2>
    <p><a class="btn btn-success" href="?url=barang/create">Tambah Barang</a></p>
    <?php
    require_once __DIR__ . '/../../models/Barang.php';
    $barangModel = new Barang();
    $barangs = $barangModel->getAll();
    ?>
    <?php if (empty($barangs)) : ?>
        <div class="alert alert-info">Belum ada data barang.</div>
    <?php else : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Kadaluarsa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barangs as $i => $row) : ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($row['id_barang']) ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_barang']) ?></td>
                        <td><?= htmlspecialchars($row['kadaluarsa_barang']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
