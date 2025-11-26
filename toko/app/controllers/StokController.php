<?php
require_once __DIR__ . '/../models/StokGudangModel.php';
require_once __DIR__ . '/../models/StokEtalaseModel.php';
require_once __DIR__ . '/../models/BarangModel.php';

class StokController {
    public function index() {
        // simple index: show links to separate pages
        require __DIR__ . '/../views/stok.php';
    }

    public function gudang() {
        $gudangModel = new StokGudangModel();
        $barangModel = new BarangModel();

        // Get filter parameters from GET request
        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? null,
            'jenis_barang' => $_GET['jenis_barang'] ?? null,
            'kadaluarsa_barang' => $_GET['kadaluarsa_barang'] ?? null,
        ];

        $stokGudang = $gudangModel->getAllStokGudang($filters);

        // build barang lookup maps to avoid repeated DB calls
        $allBarang = $barangModel->getAllBarang();
        $barangById = [];
        $barangByName = [];
        foreach ($allBarang as $b) {
            if (!empty($b['id'])) $barangById[$b['id']] = $b;
            if (!empty($b['nama_barang'])) $barangByName[strtolower(trim($b['nama_barang']))] = $b;
        }

        // apply authoritative fields from barang map
        foreach ($stokGudang as &$s) {
            $b = null;
            if (!empty($s['barang_id']) && isset($barangById[$s['barang_id']])) {
                $b = $barangById[$s['barang_id']];
            } else {
                $nameKey = strtolower(trim($s['nama_barang'] ?? ($s['nama'] ?? '')));
                if ($nameKey !== '' && isset($barangByName[$nameKey])) $b = $barangByName[$nameKey];
            }
            if ($b) {
                $s['nama_barang'] = $b['nama_barang'] ?? $s['nama_barang'];
                $s['jenis_barang'] = $b['jenis_barang'] ?? ($b['jenis'] ?? $s['jenis_barang']);
                $s['kadaluarsa_barang'] = $b['kadaluarsa'] ?? ($b['kadaluarsa_barang'] ?? $s['kadaluarsa_barang']);
            }
        }
        unset($s);

        require __DIR__ . '/../views/stok_gudang.php';
    }

        public function lowStock() {
        $g = new StokGudangModel();
        $e = new StokEtalaseModel();

        $lowGudang = $g->getLowStock();
        $lowEtalase = $e->getLowStock();

        include __DIR__ . '/../views/stok/low.php';
    }

    public function zeroStock() {
        $g = new StokGudangModel();
        $e = new StokEtalaseModel();

        $zeroGudang = $g->getZeroStock();
        $zeroEtalase = $e->getZeroStock();

        include __DIR__ . '/../views/stok/habis.php';
    }

    public function maxStock() {
        $g = new StokGudangModel();
        $e = new StokEtalaseModel();

        $maxGudang = $g->getMaxStock();
        $maxEtalase = $e->getMaxStock();

        include __DIR__ . '/../views/stok/max.php';
    }

    // alias agar router mengenali URL ?url=stok/low
public function low() {
    $this->lowStock();
}

// alias agar router mengenali URL ?url=stok/habis
public function habis() {
    $this->zeroStock();
}

// alias agar router mengenali URL ?url=stok/max
public function max() {
    $this->maxStock();
}


    public function etalase() {
        $etalaseModel = new StokEtalaseModel();
        $barangModel = new BarangModel();

        // Get filter parameters
        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? null,
            'jenis_barang' => $_GET['jenis_barang'] ?? null,
            'kadaluarsa_barang' => $_GET['kadaluarsa_barang'] ?? null,
        ];

        $stokEtalase = $etalaseModel->getAllStokEtalase($filters);

        // build barang lookup maps
        $allBarang = $barangModel->getAllBarang();
        $barangById = [];
        $barangByName = [];
        foreach ($allBarang as $b) {
            if (!empty($b['id'])) $barangById[$b['id']] = $b;
            if (!empty($b['nama_barang'])) $barangByName[strtolower(trim($b['nama_barang']))] = $b;
        }

        foreach ($stokEtalase as &$s) {
            $b = null;
            if (!empty($s['barang_id']) && isset($barangById[$s['barang_id']])) {
                $b = $barangById[$s['barang_id']];
            } else {
                $nameKey = strtolower(trim($s['nama_barang'] ?? ($s['nama'] ?? '')));
                if ($nameKey !== '' && isset($barangByName[$nameKey])) $b = $barangByName[$nameKey];
            }
            if ($b) {
                $s['nama_barang'] = $b['nama_barang'] ?? $s['nama_barang'];
                $s['jenis_barang'] = $b['jenis_barang'] ?? ($b['jenis'] ?? $s['jenis_barang']);
                $s['kadaluarsa_barang'] = $b['kadaluarsa'] ?? ($b['kadaluarsa_barang'] ?? $s['kadaluarsa_barang']);
            }
        }
        unset($s);

        require __DIR__ . '/../views/stok_etalase.php';
    }
}
