<?php
require_once __DIR__ . '/../app/models/DitempatkanModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';
require_once __DIR__ . '/../app/models/StokEtalaseModel.php';

$d = new DitempatkanModel();
$g = new StokGudangModel();
$e = new StokEtalaseModel();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: read_ditempatkan.php'); exit; }

$current = $d->getDitempatkanById($id);
if (!$current) { echo "Data tidak ditemukan"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_stok_gudang' => $_POST['id_stok_gudang'] ?? $current['id_stok_gudang'],
        'id_stok_etalase' => $_POST['id_stok_etalase'] ?? $current['id_stok_etalase'],
        'tgl_penempatan' => $_POST['tgl_penempatan'] ?? $current['tgl_penempatan'],
        'stok_gudang_keluar' => (int)($_POST['stok_gudang_keluar'] ?? $current['stok_gudang_keluar']),
        'stok_etalase_masuk' => (int)($_POST['stok_etalase_masuk'] ?? $current['stok_etalase_masuk']),
    ];

    // compute diffs
    $oldG = (int)$current['stok_gudang_keluar'];
    $oldE = (int)$current['stok_etalase_masuk'];
    $newG = (int)$data['stok_gudang_keluar'];
    $newE = (int)$data['stok_etalase_masuk'];

    // if gudang id changed, revert old gudang and apply to new
    if ($current['id_stok_gudang'] !== $data['id_stok_gudang']) {
        // revert old
        $stokOldG = $g->getStokGudangById($current['id_stok_gudang']);
        $g->updateStokGudang($current['id_stok_gudang'], [
            'nama_barang' => $stokOldG['nama_barang'] ?? '',
            'jenis_barang' => $stokOldG['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokOldG['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => ((int)($stokOldG['total_stok_gudang'] ?? 0) + $oldG),
        ]);
        // apply to new (subtract)
        $stokNewG = $g->getStokGudangById($data['id_stok_gudang']);
        $g->updateStokGudang($data['id_stok_gudang'], [
            'nama_barang' => $stokNewG['nama_barang'] ?? '',
            'jenis_barang' => $stokNewG['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokNewG['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => max(0, ((int)($stokNewG['total_stok_gudang'] ?? 0) - $newG)),
        ]);
    } else {
        // same gudang -> apply diff
        $stokG = $g->getStokGudangById($data['id_stok_gudang']);
        $cur = (int)($stokG['total_stok_gudang'] ?? 0);
        $diffG = $newG - $oldG;
        $newTotalG = $cur - $diffG; // because original already subtracted old; but to keep simple we'll compute: cur + (-diff)
        // safer compute: originalCurBefore = cur + oldG; newCur = originalCurBefore - newG
        $originalBefore = $cur + $oldG;
        $newTotalG = $originalBefore - $newG;
        if ($newTotalG < 0) $newTotalG = 0;
        $g->updateStokGudang($data['id_stok_gudang'], [
            'nama_barang' => $stokG['nama_barang'] ?? '',
            'jenis_barang' => $stokG['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokG['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => $newTotalG,
        ]);
    }

    // etalase adjustments (similar logic)
    if ($current['id_stok_etalase'] !== $data['id_stok_etalase']) {
        // revert old etalase (subtract oldE)
        $stokOldE = $e->getStokEtalaseById($current['id_stok_etalase']);
        $e->updateStokEtalase($current['id_stok_etalase'], [
            'nama_barang' => $stokOldE['nama_barang'] ?? '',
            'jenis_barang' => $stokOldE['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokOldE['kadaluarsa_barang'] ?? '',
            'tgl_update_eta' => date('Y-m-d'),
            'total_stok_eta' => max(0, ((int)($stokOldE['total_stok_eta'] ?? 0) - $oldE)),
        ]);
        // apply to new etalase (add newE)
        $stokNewE = $e->getStokEtalaseById($data['id_stok_etalase']);
        $e->updateStokEtalase($data['id_stok_etalase'], [
            'nama_barang' => $stokNewE['nama_barang'] ?? '',
            'jenis_barang' => $stokNewE['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokNewE['kadaluarsa_barang'] ?? '',
            'tgl_update_eta' => date('Y-m-d'),
            'total_stok_eta' => ((int)($stokNewE['total_stok_eta'] ?? 0) + $newE),
        ]);
    } else {
        // same etalase -> compute original before, then apply new
        $stokE = $e->getStokEtalaseById($data['id_stok_etalase']);
        $curE = (int)($stokE['total_stok_eta'] ?? 0);
        $originalBeforeE = $curE - $oldE; // since cur already includes oldE added earlier
        $newTotalE = $originalBeforeE + $newE;
        if ($newTotalE < 0) $newTotalE = 0;
        $e->updateStokEtalase($data['id_stok_etalase'], [
            'nama_barang' => $stokE['nama_barang'] ?? '',
            'jenis_barang' => $stokE['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokE['kadaluarsa_barang'] ?? '',
            'tgl_update_eta' => date('Y-m-d'),
            'total_stok_eta' => $newTotalE,
        ]);
    }

    // update record
    if ($d->updateDitempatkan($id, $data)) {
        header('Location: read_ditempatkan.php');
        exit;
    }
}

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Penempatan</title></head>
<body>
<h1>Edit Penempatan <?= htmlspecialchars($id) ?></h1>
<form method="post">
    <label>ID Stok Gudang <input name="id_stok_gudang" value="<?= htmlspecialchars($current['id_stok_gudang']) ?>"></label><br>
    <label>ID Stok Etalase <input name="id_stok_etalase" value="<?= htmlspecialchars($current['id_stok_etalase']) ?>"></label><br>
    <label>Tanggal <input type="date" name="tgl_penempatan" value="<?= htmlspecialchars($current['tgl_penempatan']) ?>"></label><br>
    <label>Jumlah Keluar (Gudang) <input type="number" name="stok_gudang_keluar" value="<?= htmlspecialchars($current['stok_gudang_keluar']) ?>"></label><br>
    <label>Jumlah Masuk (Etalase) <input type="number" name="stok_etalase_masuk" value="<?= htmlspecialchars($current['stok_etalase_masuk']) ?>"></label><br>
    <button type="submit">Simpan</button>
    <a href="read_ditempatkan.php">Batal</a>
</form>
</body>
</html>
