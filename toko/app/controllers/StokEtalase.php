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

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/stok_etalase/index.php';
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
        $this->model->insert([
            'id_stok_etalase' => $id_stok_etalase,
            'total_stok_eta' => $total_stok_eta
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
        $this->model->update($id, $_POST);
        header('Location: ?url=stoketalase/index');
    }

    public function delete($id) {
    $this->requireKaryawan();
        $this->model->delete($id);
        header('Location: ?url=stoketalase/index');
    }
}
