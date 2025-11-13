<?php
require_once __DIR__ . '/../app/models/MendataModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';

$m = new MendataModel();
$g = new StokGudangModel();

$list = $m->getAllMendata();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Mendata</title>
    <link rel="stylesheet" href="../public/css/crud.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
<div class="crud-container">
    <h1>Daftar Pendataan</h1>
    <div class="top-actions">
        <a class="btn btn-success" href="create_mendata.php">Tambah Pendataan</a>
        <a class="btn btn-primary" href="../public/stok">Kembali ke Stok</a>
    </div>

    <table class="crud-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>ID Karyawan</th>
            <th>ID Stok Gudang</th>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_mendata']) ?></td>
                <td><?= htmlspecialchars($row['id_karyawan']) ?></td>
                <td><?= htmlspecialchars($row['id_stok_gudang']) ?></td>
                <td><?= htmlspecialchars($row['tgl_pendataan']) ?></td>
                <td><?= htmlspecialchars($row['stok_gudang_masuk']) ?></td>
                <td class="actions">
                    <a class="btn btn-info" href="update_mendata.php?id=<?= urlencode($row['id_mendata']) ?>">Edit</a>
                    <a class="btn btn-danger" href="delete_mendata.php?id=<?= urlencode($row['id_mendata']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
