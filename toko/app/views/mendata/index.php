<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mendata</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Daftar Mendata</h1>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Jumlah Barang</th>
                <th>Tanggal Pendataan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mendataList)): ?>
                <?php foreach ($mendataList as $mendata): ?>
                    <tr>
                        <td><?= htmlspecialchars($mendata['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($mendata['jenis_barang']) ?></td>
                        <td><?= htmlspecialchars($mendata['jumlah_barang']) ?></td>
                        <td><?= htmlspecialchars($mendata['tanggal_pendataan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">Tidak ada data pendataan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
