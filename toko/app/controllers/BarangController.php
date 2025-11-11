<?php
require_once __DIR__ . '/../models/Barang.php';

class BarangController {
    public function index() {
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();
        include __DIR__ . '/../views/barang/index.php';
    }

    public function create() {
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();

        // Generate ID Barang otomatis (BG###)
        $max = 0;
        foreach ($barangs as $b) {
            if (preg_match('/^BG(\d{3})$/', $b['id_barang'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }
        $newId = 'BG' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        include __DIR__ . '/../views/barang/create.php';
    }

    public function store() {
        $barangModel = new Barang();

        $nama_barang = trim($_POST['nama_barang'] ?? '');
        $jenis_barang = trim($_POST['jenis_barang'] ?? '');
        $kadaluarsa_barang = trim($_POST['kadaluarsa_barang'] ?? '');
        $total_stok_gudang = (int)($_POST['total_stok_gudang'] ?? 0);

        // Ambil semua barang (untuk cek duplikasi)
        $barangs = $barangModel->getAll();

        foreach ($barangs as $b) {
            if (
                strtolower($b['nama_barang']) === strtolower($nama_barang) &&
                strtolower($b['jenis_barang']) === strtolower($jenis_barang) &&
                $b['kadaluarsa_barang'] === $kadaluarsa_barang
            ) {
                header('Location: ?url=barang/index&msg=exists');
                return;
            }
        }

        // Generate id_barang baru (BGxxx)
        $max = 0;
        foreach ($barangs as $b) {
            if (preg_match('/^BG(\d{3})$/', $b['id_barang'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }
        $id_barang = 'BG' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        // Simpan ke DB
        $barangModel->insert([
            'id_barang' => $id_barang,
            'nama_barang' => $nama_barang,
            'jenis_barang' => $jenis_barang,
            'kadaluarsa_barang' => $kadaluarsa_barang,
            'total_stok_gudang' => $total_stok_gudang
        ]);

header('Location: ?url=stokgudang/index&msg=added');
exit;
    }
}
