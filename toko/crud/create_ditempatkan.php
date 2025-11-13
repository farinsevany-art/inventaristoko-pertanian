<?php
require_once __DIR__ . '/../app/models/DitempatkanModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';
require_once __DIR__ . '/../app/models/StokEtalaseModel.php';

$d = new DitempatkanModel();
$g = new StokGudangModel();
$e = new StokEtalaseModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_ditempatkan' => $_POST['id_ditempatkan'] ?? uniqid('dp_'),
        'id_stok_gudang' => $_POST['id_stok_gudang'] ?? '',
        'id_stok_etalase' => $_POST['id_stok_etalase'] ?? '',
        'tgl_penempatan' => $_POST['tgl_penempatan'] ?? date('Y-m-d'),
        'stok_gudang_keluar' => (int)($_POST['stok_gudang_keluar'] ?? 0),
        'stok_etalase_masuk' => (int)($_POST['stok_etalase_masuk'] ?? 0),
    ];

    // perform transfer
    if ($d->tambahDitempatkan($data)) {
        // subtract from gudang
        $stokG = $g->getStokGudangById($data['id_stok_gudang']);
        $curG = (int)($stokG['total_stok_gudang'] ?? 0);
        $newG = $curG - $data['stok_gudang_keluar'];
        if ($newG < 0) $newG = 0;
        $g->updateStokGudang($data['id_stok_gudang'], [
            'nama_barang' => $stokG['nama_barang'] ?? '',
            'jenis_barang' => $stokG['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokG['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => $newG,
        ]);

        // add to etalase
        $stokE = $e->getStokEtalaseById($data['id_stok_etalase']);
        $curE = (int)($stokE['total_stok_eta'] ?? 0);
        $newE = $curE + $data['stok_etalase_masuk'];
        $e->updateStokEtalase($data['id_stok_etalase'], [
            'nama_barang' => $stokE['nama_barang'] ?? '',
            'jenis_barang' => $stokE['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stokE['kadaluarsa_barang'] ?? '',
            'tgl_update_eta' => date('Y-m-d'),
            'total_stok_eta' => $newE,
        ]);

        header('Location: read_ditempatkan.php');
        exit;
    }
}

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Tambah Penempatan</title></head>
<body>
<h1>Tambah Penempatan (Pindah dari Gudang ke Etalase)</h1>
<form method="post">
    <label>ID <input name="id_ditempatkan"></label><br>
    <label>ID Stok Gudang <input name="id_stok_gudang"></label><br>
    <label>ID Stok Etalase <input name="id_stok_etalase"></label><br>
    <label>Tanggal <input type="date" name="tgl_penempatan" value="<?= date('Y-m-d') ?>"></label><br>
    <label>Jumlah Keluar (Gudang) <input type="number" name="stok_gudang_keluar" value="0"></label><br>
    <label>Jumlah Masuk (Etalase) <input type="number" name="stok_etalase_masuk" value="0"></label><br>
    <button type="submit">Simpan</button>
    
    <a href="read_ditempatkan.php">Batal</a>
</form>
</body>
</html>

