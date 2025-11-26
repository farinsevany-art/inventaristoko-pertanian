<?php
require_once __DIR__ . '/../app/models/MendataModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';

$m = new MendataModel();
$g = new StokGudangModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // basic validation/assumption: fields are provided
    $data = [
        'id_mendata' => $_POST['id_mendata'] ?? uniqid('md_'),
        'id_karyawan' => $_POST['id_karyawan'] ?? '',
        'id_stok_gudang' => $_POST['id_stok_gudang'] ?? '',
        'tgl_pendataan' => $_POST['tgl_pendataan'] ?? date('Y-m-d'),
        'stok_gudang_masuk' => (int)($_POST['stok_gudang_masuk'] ?? 0),
    ];

    // insert mendata
    if ($m->tambahMendata($data)) {
        // update stok gudang total (tambah)
        $stok = $g->getStokGudangById($data['id_stok_gudang']);
        $current = $stok['total_stok_gudang'] ?? 0;
        $newTotal = $current + $data['stok_gudang_masuk'];
        $g->updateStokGudang($data['id_stok_gudang'], [
            'nama_barang' => $stok['nama_barang'] ?? '',
            'jenis_barang' => $stok['jenis_barang'] ?? '',
            'kadaluarsa_barang' => $stok['kadaluarsa_barang'] ?? '',
            'tgl_update_gud' => date('Y-m-d'),
            'total_stok_gudang' => $newTotal,
        ]);
        header('Location: /app/views/stok.php');
        exit;
    }
}

// Simple form
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Tambah Mendata</title></head>
<body>
<h1>Tambah Pendataan (Stok Gudang Masuk)</h1>
<form method="post">
    <label>ID Mendata <input name="id_mendata"></label><br>
    <label>ID Karyawan <input name="id_karyawan"></label><br>
    <label>ID Stok Gudang <input name="id_stok_gudang"></label><br>
    <label>Tanggal <input type="date" name="tgl_pendataan" value="<?= date('Y-m-d') ?>"></label><br>
    <label>Jumlah Masuk <input type="number" name="stok_gudang_masuk" value="0"></label><br>
    <button type="submit">Simpan</button>
    <a href="read_mendata.php">Batal</a>
</form>
</body>
</html>
