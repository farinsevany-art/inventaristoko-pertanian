<?php
$base_url = 'http://localhost/toko/public/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Search Results - <?= htmlspecialchars($searchTerm) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-4">
        <h2>Search Results for: <em><?= htmlspecialchars($searchTerm) ?></em></h2>
        <?php if (count($results) > 0): ?>
            <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>no</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1; foreach ($results as $item): ?>
                        <tr>
                            <td><?= $num++ ?></td>
                            <td><?= htmlspecialchars($item['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($item['deskripsi'] ?? '') ?></td>
                            <td><?= number_format($item['harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($item['stok'] ?? '') ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            </div>
        <?php else: ?>
            <p class="mt-3">No items found matching your search.</p>
        <?php endif ?>
        <a href="<?= $base_url ?>?url=admin/index" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
