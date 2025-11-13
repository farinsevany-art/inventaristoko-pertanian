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

// reverse transfer: add back to gudang
$stokG = $g->getStokGudangById($current['id_stok_gudang']);
$newG = ((int)($stokG['total_stok_gudang'] ?? 0) + (int)$current['stok_gudang_keluar']);
$g->updateStokGudang($current['id_stok_gudang'], [
    'nama_barang' => $stokG['nama_barang'] ?? '',
    'jenis_barang' => $stokG['jenis_barang'] ?? '',
    'kadaluarsa_barang' => $stokG['kadaluarsa_barang'] ?? '',
    'tgl_update_gud' => date('Y-m-d'),
    'total_stok_gudang' => $newG,
]);

// subtract from etalase
$stokE = $e->getStokEtalaseById($current['id_stok_etalase']);
$newE = ((int)($stokE['total_stok_eta'] ?? 0) - (int)$current['stok_etalase_masuk']);
if ($newE < 0) $newE = 0;
$e->updateStokEtalase($current['id_stok_etalase'], [
    'nama_barang' => $stokE['nama_barang'] ?? '',
    'jenis_barang' => $stokE['jenis_barang'] ?? '',
    'kadaluarsa_barang' => $stokE['kadaluarsa_barang'] ?? '',
    'tgl_update_eta' => date('Y-m-d'),
    'total_stok_eta' => $newE,
]);

// delete record
$d->hapusDitempatkan($id);
header('Location: read_ditempatkan.php');
exit;
