<?php
require_once __DIR__ . '/../app/models/MendataModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';

$m = new MendataModel();
$g = new StokGudangModel();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: read_mendata.php'); exit; }

$current = $m->getMendataById($id);
if (!$current) { echo "Data tidak ditemukan"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_karyawan' => $_POST['id_karyawan'] ?? $current['id_karyawan'],
        'id_stok_gudang' => $_POST['id_stok_gudang'] ?? $current['id_stok_gudang'],
        'tgl_pendataan' => $_POST['tgl_pendataan'] ?? $current['tgl_pendataan'],
        'stok_gudang_masuk' => (int)($_POST['stok_gudang_masuk'] ?? $current['stok_gudang_masuk']),
    ];

    // adjust stok gudang: calculate diff
    $oldAmount = (int)$current['stok_gudang_masuk'];
    $newAmount = (int)$data['stok_gudang_masuk'];
    $diff = $newAmount - $oldAmount; // positive => add, negative => subtract

    // update mendata
    if ($m->updateMendata($id, $data)) {
        // apply diff to stok gudang of the targeted id
        $stok = $g->getStokGudangById($data['id_stok_gudang']);
        $currentTotal = (int)($stok['total_stok_gudang'] ?? 0);
        $newTotal = $currentTotal + $diff;
        if ($newTotal < 0) $newTotal = 0;
        $g->updateStokGudang($data['id_stok_gudang'], [
            'nama_barang' => $stok['nama_barang'] ?? '',
            'jenis_barang' => $stok['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stok['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => $newTotal,
        ]);

        header('Location: read_mendata.php');
        exit;
    }
}

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Mendata</title></head>
<body>
<h1>Edit Pendataan <?= htmlspecialchars($id) ?></h1>
<form method="post">
    <label>ID Karyawan <input name="id_karyawan" value="<?= htmlspecialchars($current['id_karyawan']) ?>"></label><br>
    <label>ID Stok Gudang <input name="id_stok_gudang" value="<?= htmlspecialchars($current['id_stok_gudang']) ?>"></label><br>
    <label>Tanggal <input type="date" name="tgl_pendataan" value="<?= htmlspecialchars($current['tgl_pendataan']) ?>"></label><br>
    <label>Jumlah Masuk <input type="number" name="stok_gudang_masuk" value="<?= htmlspecialchars($current['stok_gudang_masuk']) ?>"></label><br>
    <button type="submit">Simpan</button>
    <a href="read_mendata.php">Batal</a>
</form>
</body>
</html>
