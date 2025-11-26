<?php
require_once __DIR__ . '/../models/StokGudang.php';
require_once __DIR__ . '/../models/KaryawanModel.php';

class StokGudangController {

    private $model;

    public function __construct() {
        $this->model = new StokGudang();
    }

    /* ===========================
       AUTH KARYAWAN
       =========================== */
    private function requireKaryawan() {

        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        $posisi = strtolower($_SESSION['posisi'] ?? '');

        $isKaryawan = (
            strpos($posisi, 'pendata') !== false ||
            strpos($posisi, 'karyawan') !== false
        );

        if (empty($_SESSION['admin_logged_in']) || !$isKaryawan) {
            header('Location: ?url=admin/login');
            exit;
        }

        // ✅ AUTO set ID KARYAWAN dari id_akun jika belum ada
        if (empty($_SESSION['id_karyawan']) && !empty($_SESSION['id_akun'])) {

            $karyawanModel = new Karyawan();

            $row = $karyawanModel->query(
                "SELECT id_karyawan FROM karyawan 
                 WHERE id_akun = '" . $_SESSION['id_akun'] . "' LIMIT 1"
            )->fetch_assoc();

            if ($row) {
                $_SESSION['id_karyawan'] = $row['id_karyawan'];
            } else {
                die('Akun ini belum terdaftar di tabel karyawan.');
            }
        }

        if (empty($_SESSION['id_karyawan'])) {
            die('SESSION ID KARYAWAN MASIH KOSONG');
        }
    }

    /* ===========================
       TAMPILKAN DATA
       =========================== */
    public function index() {
        $data = $this->model->getAll();

        require_once __DIR__ . '/../models/Barang.php';
        $barangModel = new Barang();
        $jenisBarangList = $barangModel->getDistinctJenisBarang();

        include __DIR__ . '/../views/stok_gudang/index.php';
    }

    /* ===========================
       FORM TAMBAH
       =========================== */
    public function create() {
        $this->requireKaryawan();

        require_once __DIR__ . '/../models/Barang.php';
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();

        include __DIR__ . '/../views/stok_gudang/create.php';
    }

    /* ===========================
       SIMPAN + AUTO MASUK MENDATA
       =========================== */
    public function store() {

        $this->requireKaryawan();

        $id_barang = trim($_POST['id_barang'] ?? '');
        $total_stok_gudang = (int)($_POST['total_stok_gudang'] ?? 0);

        if (empty($id_barang) || $total_stok_gudang <= 0) {
            die('Barang & jumlah stok wajib diisi');
        }

        require_once __DIR__ . '/../models/Barang.php';
        $bm = new Barang();

        if (!$bm->getById($id_barang)) {
            die('ID Barang tidak valid');
        }

        // cari stok existing
        $existing = null;

        $all = $this->model->getAll();
        foreach ($all as $row) {
            if ($row['id_barang'] === $id_barang) {
                $existing = $row;
                break;
            }
        }

        if ($existing) {

            $newTotal = (int)$existing['total_stok_gudang'] + $total_stok_gudang;

            $result = $this->model->update(
                $existing['id_stok_gudang'],
                [
                    'id_barang' => $id_barang,
                    'total_stok_gudang' => $newTotal
                ]
            );

            $id_stok_gudang_valid = $existing['id_stok_gudang'];

        } else {

            $id_stok_gudang_valid = $this->model->generateNewId();

            $result = $this->model->insert([
                'id_stok_gudang' => $id_stok_gudang_valid,
                'id_barang' => $id_barang,
                'total_stok_gudang' => $total_stok_gudang
            ]);
        }

        if (!$result) {
            die('Gagal menyimpan stok gudang');
        }

        /* ============================
           AUTO INSERT KE TABEL MENDATA
           ============================ */

        require_once __DIR__ . '/../models/Mendata.php';

        $id_karyawan = $_SESSION['id_karyawan'];

        $mendata = new Mendata();

        $insertMendata = $mendata->insert([
            'id_karyawan' => $id_karyawan,
            'id_stok_gudang' => $id_stok_gudang_valid,
            'id_barang' => $id_barang,
            'tgl_pendataan' => date('Y-m-d'),
            'stok_gudang_masuk' => $total_stok_gudang
        ]);

        if (!$insertMendata) {
            die('GAGAL: Data tidak masuk ke tabel mendata');
        }

        header('Location: ?url=stokgudang/index&status=sukses');
        exit;
    }

    /* ===========================
       DELETE
       =========================== */
    public function delete($id) {
        $this->requireKaryawan();
        $this->model->delete($id);

        header('Location: ?url=stokgudang/index');
    }

    /* ===========================
       FORM EDIT
       =========================== */
    public function edit($id) {
        $this->requireKaryawan();

        $stok = $this->model->getById($id);
        if (!$stok) {
            die('Data stok gudang tidak ditemukan');
        }

        require_once __DIR__ . '/../models/Barang.php';
        $barangModel = new Barang();
        $barangs = $barangModel->getAll();

        include __DIR__ . '/../views/stok_gudang/edit.php';
    }

    /* ===========================
       UPDATE
       =========================== */
    public function update($id) {
        $this->requireKaryawan();

        $total_stok_gudang = (int)($_POST['total_stok_gudang'] ?? 0);

        if ($total_stok_gudang < 0) {
            die('Jumlah stok wajib diisi dengan benar');
        }

        // Fetch existing stok to get existing id_barang if not sent
        $stokExisting = $this->model->getById($id);
        if (!$stokExisting) {
            die('Data stok gudang tidak ditemukan');
        }

        $id_barang = trim($_POST['id_barang'] ?? $stokExisting['id_barang']);
        // If still empty, fallback to existing value
        if (empty($id_barang)) {
            $id_barang = $stokExisting['id_barang'];
        }

        require_once __DIR__ . '/../models/Barang.php';
        $bm = new Barang();

        if (!$bm->getById($id_barang)) {
            die('ID Barang tidak valid');
        }

        $result = $this->model->update($id, [
            'id_barang' => $id_barang,
            'total_stok_gudang' => $total_stok_gudang
        ]);

        if (!$result) {
            die('Gagal memperbarui stok gudang');
        }

        header('Location: ?url=stokgudang/index&status=updated');
        exit;
    }
}
