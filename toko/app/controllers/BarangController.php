<?php 
require_once __DIR__ . '/../models/Barang.php';

class BarangController {

    public function index() {
        $barangModel = new Barang();

        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? '',
            'jenis_barang' => $_GET['jenis_barang'] ?? '',
            'day' => $_GET['day'] ?? '',
            'month' => $_GET['month'] ?? '',
            'year' => $_GET['year'] ?? '',
        ];

        $barangs = $barangModel->getAll($filters);

        $jenisBarangList = $barangModel->getDistinctJenisBarang();

        if (!empty($_SESSION['admin_logged_in'])) {
            include __DIR__ . '/../views/barang/index.php';
        } else {
            // Pass filters and jenisBarangList to indexbarang.php
            include __DIR__ . '/../views/barang/indexbarang.php';
        }
    }

    public function create() {
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();

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

    public function edit($id) {
        $barangModel = new Barang();
        $stok = $barangModel->getById($id);

        include __DIR__ . '/../views/barang/edit.php';
    }

    public function update($id) {
        $barangModel = new Barang();

        $data = [
            'nama_barang'        => trim($_POST['nama_barang'] ?? ''),
            'jenis_barang'       => trim($_POST['jenis_barang'] ?? ''),
            'kadaluarsa_barang'  => trim($_POST['kadaluarsa_barang'] ?? '')
        ];

        $barangModel->update($id, $data);

        header('Location: ?url=barang/index&msg=updated');
        exit;
    }

    public function store() {
        $barangModel = new Barang();

        $nama_barang        = trim($_POST['nama_barang'] ?? '');
        $jenis_barang       = trim($_POST['jenis_barang'] ?? '');
        $kadaluarsa_barang  = trim($_POST['kadaluarsa_barang'] ?? '');
        $total_stok_gudang  = (int)($_POST['total_stok_gudang'] ?? 0);

        $barangs = $barangModel->getAll();

        // cek barang duplikat
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

        // generate id
        $max = 0;
        foreach ($barangs as $b) {
            if (preg_match('/^BG(\d{3})$/', $b['id_barang'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }

        $id_barang = 'BG' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        // insert barang
        $barangModel->insert([
            'id_barang'         => $id_barang,
            'nama_barang'       => $nama_barang,
            'jenis_barang'      => $jenis_barang,
            'kadaluarsa_barang' => $kadaluarsa_barang
        ]);

        // jika langsung menambah stok gudang
        if ($total_stok_gudang > 0) {
            require_once __DIR__ . '/../models/StokGudang.php';

            $sg = new StokGudang();
            $newSGId = $sg->generateNewId();

            $sg->insert([
                'id_stok_gudang'    => $newSGId,
                'total_stok_gudang' => $total_stok_gudang,
                'id_barang'         => $id_barang
            ]);

            // catat mendata
            require_once __DIR__ . '/../models/Mendata.php';

            $m = new Mendata();
            $m->insert([
                'nama_barang'        => $nama_barang,
                'jenis_barang'       => $jenis_barang,
                'jumlah_barang'      => $total_stok_gudang,
                'tanggal_pendataan'  => date('Y-m-d')
            ]);
        }

        header('Location: ?url=barang/index&msg=added');
        exit;
    }

    public function delete($id) {
        $barangModel = new Barang();
        $barangModel->delete($id);

        header('Location: ?url=barang/index&msg=deleted');
        exit;
    }
}
