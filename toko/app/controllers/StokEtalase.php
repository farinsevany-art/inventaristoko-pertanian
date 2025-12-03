<?php
require_once __DIR__ . '/../models/StokEtalase.php';

class StokEtalaseController {
    private $model;

    public function __construct() {
        $this->model = new StokEtalase();
    }

    private function requireKaryawan() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $pos = strtolower($_SESSION['posisi'] ?? '');
        $isKry = (strpos($pos, 'pendata') !== false) || (strpos($pos, 'karyawan') !== false) || ($pos === 'karyawan');
        if (empty($_SESSION['admin_logged_in']) || !$isKry) {
            header('Location: ?url=admin/login');
            exit;
        }
    }

// Di controller StokEtalaseController - method index()
    public function index() {
        $filters = [
            'jenis_barang' => $_GET['jenis_barang'] ?? '',
        'rak' => $_GET['rak'] ?? '',
            'day' => $_GET['day'] ?? '',
            'month' => $_GET['month'] ?? '',
            'year' => $_GET['year'] ?? ''
        ];

        // Get filtered stok etalase data
        $data = $this->model->getAll($filters);

    // Get distinct jenis_barang list for filter dropdown
    $jenisBarangList = $this->model->getDistinctJenisBarang();
    // Get distinct rak list for filter dropdown
    $rakOptions = $this->model->getDistinctRak();

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!empty($_SESSION['admin_logged_in'])) {
            include __DIR__ . '/../views/stok_etalase/indexadmin.php';
        } else {
            include __DIR__ . '/../views/stok_etalase/indexetalase.php';
        }
    }
    public function create() {
    $this->requireKaryawan();
    include __DIR__ . '/../views/stok_etalase/create.php';
    }

    public function store() {
    $this->requireKaryawan();
        // Generate id_stok_etalase: cari max SExxx, increment
        $all = $this->model->getAll();
        $max = 0;
        foreach ($all as $row) {
            if (preg_match('/^SE(\\d{3})$/', $row['id_stok_etalase'], $m)) {
                $num = (int)$m[1];
                if ($num > $max) $max = $num;
            }
        }
        $id_stok_etalase = 'SE' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);

        $total_stok_eta = (int)($_POST['total_stok_eta'] ?? 0);
        $rak = trim($_POST['rak'] ?? '');
        $this->model->insert([
            'id_stok_etalase' => $id_stok_etalase,
            'total_stok_eta' => $total_stok_eta,
            'rak' => $rak
        ]);
        header('Location: ?url=stoketalase/index');
    }

    public function edit($id) {
    $this->requireKaryawan();
        $stok = $this->model->getById($id);
        include __DIR__ . '/../views/stok_etalase/edit.php';
    }

    public function update($id) {
    $this->requireKaryawan();
    $data = $_POST;
    // ensure rak is passed
    $data['rak'] = trim($_POST['rak'] ?? '');
    $this->model->update($id, $data);
        header('Location: ?url=stoketalase/index');
    }

    public function delete($id) {
    $this->requireKaryawan();
        $this->model->delete($id);
        header('Location: ?url=stoketalase/index');
    }
}
