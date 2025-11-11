<?php
require_once __DIR__ . '/../models/StokGudang.php';

class StokGudangController {
    private $model;

    public function __construct() {
        $this->model = new StokGudang();
    }

    // Check if current user is logged in and has posisi 'karyawan'
    private function requireKaryawan() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $pos = strtolower($_SESSION['posisi'] ?? '');
    $isKry = (strpos($pos, 'pendata') !== false) || (strpos($pos, 'karyawan') !== false) || ($pos === 'karyawan');
    if (empty($_SESSION['admin_logged_in']) || !$isKry) {
            // Not allowed
            header('Location: ?url=admin/login');
            exit;
        }
    }

    // Tampilkan semua data
    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/stok_gudang/index.php';
    }

    // Form tambah
    public function create() {
    $this->requireKaryawan();
        require_once __DIR__ . '/../models/Barang.php';
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();
        include __DIR__ . '/../views/stok_gudang/create.php';
    }

    // Simpan data baru
    public function store() {
    $this->requireKaryawan();
        require_once __DIR__ . '/../models/Barang.php';
        $barangModel = new Barang();

        // Ambil data barang dari form
        $nama_barang = trim($_POST['nama_barang'] ?? '');
        $jenis_barang = trim($_POST['jenis_barang'] ?? '');
        $kadaluarsa_barang = trim($_POST['kadaluarsa_barang'] ?? '');
        $total_stok_gudang = (int)($_POST['total_stok_gudang'] ?? 0);

        // 1. Cari id_barang jika sudah ada, jika belum generate BGxxx baru
        $id_barang = null;
        $barangs = $barangModel->getAll();
        foreach ($barangs as $b) {
            if (
                strtolower($b['nama_barang']) === strtolower($nama_barang) &&
                strtolower($b['jenis_barang']) === strtolower($jenis_barang) &&
                $b['kadaluarsa_barang'] === $kadaluarsa_barang
            ) {
                $id_barang = $b['id_barang'];
                break;
            }
        }
        if (!$id_barang) {
            $max = 0;
            foreach ($barangs as $b) {
                if (preg_match('/^BG(\\d{3})$/', $b['id_barang'], $m)) {
                    $num = (int)$m[1];
                    if ($num > $max) $max = $num;
                }
            }
            $id_barang = 'BG' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);
            $barangModel->insert([
                'id_barang' => $id_barang,
                'nama_barang' => $nama_barang,
                'jenis_barang' => $jenis_barang,
                'kadaluarsa_barang' => $kadaluarsa_barang
            ]);
        }

        // 2. Generate id_stok_gudang baru (SGxxx)
        $all = $this->model->getAll();
        $max = 0;
        foreach ($all as $row) {
            if (preg_match('/^SG(\\d{3})$/', $row['id_stok_gudang'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }
        $id_stok_gudang = 'SG' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        // 3. Insert ke stok_gudang, pastikan id_barang valid
        $result = $this->model->insert([
            'id_stok_gudang' => $id_stok_gudang,
            'id_barang' => $id_barang,
            'total_stok_gudang' => $total_stok_gudang
        ]);
        if (!$result) {
            die('Gagal menambah stok gudang. Pastikan data valid.');
        }
        header('Location: ?url=stokgudang/index');
    }

    // Form edit
    public function edit($id) {
    $this->requireKaryawan();
        $stok = $this->model->getById($id);
        include __DIR__ . '/../views/stok_gudang/edit.php';
    }

    // Update data
    public function update($id) {
    $this->requireKaryawan();
        $this->model->update($id, $_POST);
        header('Location: ?url=stokgudang/index');
    }

    // Hapus data
    public function delete($id) {
    $this->requireKaryawan();
        $this->model->delete($id);
        header('Location: ?url=stokgudang/index');
    }

    // Form untuk menempatkan stok gudang ke etalase
    public function place($id) {
    $this->requireKaryawan();
        require_once __DIR__ . '/../models/Ditempatkan.php';
        require_once __DIR__ . '/../models/StokEtalase.php';
        $stok = $this->model->getById($id);
        $etalaseModel = new StokEtalase();
        // Filter etalase yang id_barang-nya sama dengan stok gudang yang dipilih
        $allEtalases = $etalaseModel->getAll();
        $etalases = [];
        if (!empty($stok['id_barang'])) {
            foreach ($allEtalases as $e) {
                if (($e['id_barang'] ?? null) === $stok['id_barang']) {
                    $etalases[] = $e;
                }
            }
        }
        include __DIR__ . '/../views/stok_gudang/place.php';
    }

    // Simpan penempatan (ditempatkan)
    public function placeStore() {
    $this->requireKaryawan();
        require_once __DIR__ . '/../models/Ditempatkan.php';
        require_once __DIR__ . '/../models/StokEtalase.php';

        $id_stok_gudang = $_POST['id_stok_gudang'] ?? null;
        $tgl = $_POST['tgl_penempatan'] ?? date('Y-m-d');
        $keluar = (int)($_POST['stok_gudang_keluar'] ?? 0);
        $masuk = (int)($_POST['stok_etalase_masuk'] ?? $keluar);

        $etalaseModel = new StokEtalase();
        // Cek jika user ingin membuat etalase baru
        if (!empty($_POST['buat_etalase_baru'])) {
            // Generate id_stok_etalase: cari max SExxx, increment
            $allEta = $etalaseModel->getAll();
            $maxEta = 0;
            foreach ($allEta as $row) {
                if (preg_match('/^SE(\\d{3})$/', $row['id_stok_etalase'], $m)) {
                    $num = (int)$m[1];
                    if ($num > $maxEta) $maxEta = $num;
                }
            }
            $id_stok_etalase = 'SE' . str_pad($maxEta + 1, 3, '0', STR_PAD_LEFT);
            $stok_awal = (int)($_POST['new_etalase_stok'] ?? $keluar);
            $etalaseModel->insert([
                'id_stok_etalase' => $id_stok_etalase,
                'total_stok_eta' => $stok_awal
            ]);
            $masuk = $stok_awal;
        } else {
            $id_stok_etalase = $_POST['id_stok_etalase'] ?? null;
        }

        $dmodel = new Ditempatkan();
        // Generate id_ditempatkan: cari max DTxxx, increment
        $all = $dmodel->getAll();
        $max = 0;
        foreach ($all as $row) {
            if (preg_match('/^DT(\d{3})$/', $row['id_ditempatkan'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }
        $id_ditempatkan = 'DT' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        // insert record penempatan
        $dmodel->insert([
            'id_ditempatkan' => $id_ditempatkan,
            'id_stok_gudang' => $id_stok_gudang,
            'id_stok_etalase' => $id_stok_etalase,
            'tgl_penempatan' => $tgl,
            'stok_gudang_keluar' => $keluar,
            'stok_etalase_masuk' => $masuk
        ]);

        // update stok gudang (kurangi)
        $currentGudang = $this->model->getById($id_stok_gudang);
        $newGudangTotal = max(0, ((int)$currentGudang['total_stok_gudang']) - $keluar);
        $this->model->update($id_stok_gudang, ['id_barang' => $currentGudang['id_barang'], 'total_stok_gudang' => $newGudangTotal]);

        // update stok etalase (tambah) jika tidak baru, jika baru sudah di-set stok_awal
        if (empty($_POST['buat_etalase_baru'])) {
            $currentEta = $etalaseModel->getById($id_stok_etalase);
            $newEtaTotal = $masuk + ((int)($currentEta['total_stok_eta'] ?? 0));
            $etalaseModel->update($id_stok_etalase, ['total_stok_eta' => $newEtaTotal]);
        }

        header('Location: ?url=stokgudang/index');
    }
}
