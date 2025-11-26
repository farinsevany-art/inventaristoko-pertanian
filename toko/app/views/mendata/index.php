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

    <form method="GET" action="" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($_GET['nama_barang'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                <select class="form-select" id="jenis_barang" name="jenis_barang">
                    <option value="">-- Semua Jenis --</option>
                    <?php if (!empty($jenisBarangList)): ?>
                        <?php foreach ($jenisBarangList as $jenis): ?>
                            <option value="<?= htmlspecialchars($jenis['jenis_barang']) ?>" <?= (isset($_GET['jenis_barang']) && $_GET['jenis_barang'] === $jenis['jenis_barang']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jenis['jenis_barang']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="day" class="form-label">Hari</label>
                <select class="form-select" id="day" name="day">
                    <option value="">-- Semua Hari --</option>
                    <?php for ($d = 1; $d <= 31; $d++): ?>
                        <option value="<?= $d ?>" <?= (isset($_GET['day']) && $_GET['day'] == $d) ? 'selected' : '' ?>><?= $d ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="month" class="form-label">Bulan</label>
                <select class="form-select" id="month" name="month">
                    <option value="">-- Semua Bulan --</option>
                    <?php
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'
                    ];
                    foreach ($months as $num => $name): ?>
                        <option value="<?= $num ?>" <?= (isset($_GET['month']) && $_GET['month'] == $num) ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="year" class="form-label">Tahun</label>
                <select class="form-select" id="year" name="year">
                    <option value="">-- Semua Tahun --</option>
                    <?php
                    $currentYear = (int)date('Y');
                    for ($y = $currentYear; $y >= $currentYear - 10; $y--): ?>
                        <option value="<?= $y ?>" <?= (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
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
</body>
</html>
