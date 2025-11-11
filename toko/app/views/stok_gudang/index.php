<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Stok Gudang</h2>
    <?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
    <?php if (!empty($_SESSION['admin_logged_in'])): ?>
        <p><a class="btn btn-success" href="?url=stokgudang/create">Tambah Stok Gudang</a></p>
    <?php endif; ?>

    <?php if (empty($data)) : ?>
        <div class="alert alert-info">Belum ada stok gudang.</div>
    <?php else : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Stok Gudang</th>
                    <th>ID Barang</th>
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
                        <td><?= htmlspecialchars($row['id_stok_gudang']) ?></td>
                        <td><?= htmlspecialchars($row['id_barang'] ?? '-') ?></td>
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
    <?php endif; ?>
<style>
.header_section {
  position: relative;
  z-index: 9999;
}
</style>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
