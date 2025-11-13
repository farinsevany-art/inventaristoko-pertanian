<?php
require_once __DIR__ . '/../app/models/DitempatkanModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';
require_once __DIR__ . '/../app/models/StokEtalaseModel.php';

$d = new DitempatkanModel();
$list = $d->getAllDitempatkan();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Penempatan</title>
    <link rel="stylesheet" href="../public/css/crud.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<div class="crud-container">
    <h1>Daftar Penempatan</h1>
    <div class="top-actions">
        <a class="btn btn-success" href="create_ditempatkan.php">Tambah Penempatan</a>
        <a class="btn btn-primary" href="../public/stok">Kembali ke Stok</a>
    </div>

    <table class="crud-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Gudang</th>
            <th>Etalase</th>
            <th>Tanggal</th>
            <th>Keluar(G)</th>
            <th>Masuk(E)</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_ditempatkan']) ?></td>
                <td><?= htmlspecialchars($row['id_stok_gudang']) ?></td>
                <td><?= htmlspecialchars($row['id_stok_etalase']) ?></td>
                <td><?= htmlspecialchars($row['tgl_penempatan']) ?></td>
                <td><?= htmlspecialchars($row['stok_gudang_keluar']) ?></td>
                <td><?= htmlspecialchars($row['stok_etalase_masuk']) ?></td>
                <td class="actions">
                    <a class="btn btn-info" href="update_ditempatkan.php?id=<?= urlencode($row['id_ditempatkan']) ?>">Edit</a>
                    <a class="btn btn-danger" href="delete_ditempatkan.php?id=<?= urlencode($row['id_ditempatkan']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
