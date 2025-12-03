<?php
require_once __DIR__ . '/../app/models/MendataModel.php';
require_once __DIR__ . '/../app/models/StokGudangModel.php';

$m = new MendataModel();
$g = new StokGudangModel();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: read_mendata.php'); exit; }

$current = $m->getMendataById($id);
if (!$current) { echo "Data tidak ditemukan"; exit; }

// subtract from stok gudang
$stokGudangId = $current['id_stok_gudang'];
$stok = $g->getStokGudangById($stokGudangId);
$currentTotal = (int)($stok['total_stok_gudang'] ?? 0);
$newTotal = $currentTotal - (int)$current['stok_gudang_masuk'];
if ($newTotal < 0) $newTotal = 0;
$g->updateStokGudang($stokGudangId, [
    'nama_barang' => $stok['nama_barang'] ?? '',
    'jenis_barang' => $stok['jenis_barang'] ?? '',
    'kadaluarsa_barang' => $stok['kadaluarsa_barang'] ?? '',
    'tgl_update_gud' => date('Y-m-d'),
    'total_stok_gudang' => $newTotal,
]);

// delete record
$m->hapusMendata($id);
header('Location: read_mendata.php');
exit;
