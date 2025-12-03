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
        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? '',
            'jenis_barang' => $_GET['jenis_barang'] ?? '',
            'day' => $_GET['day'] ?? '',
            'month' => $_GET['month'] ?? '',
            'year' => $_GET['year'] ?? ''
        ];

        $data = $this->model->getAll($filters);

    // provide distinct jenis_barang list for filter dropdown
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
       FORM EDIT
       =========================== */
    public function edit($id) {
        $this->requireKaryawan();

        $stok = $this->model->getById($id);
        if (!$stok) {
            header('Location: ?url=stokgudang/index&error=notfound');
            exit;
        }

        include __DIR__ . '/../views/stok_gudang/edit.php';
    }

    /* ===========================
       UPDATE
       =========================== */
    public function update($id) {
        $this->requireKaryawan();

        $stok = $this->model->getById($id);
        if (!$stok) {
            header('Location: ?url=stokgudang/index&error=notfound');
            exit;
        }

        $total = (int)($_POST['total_stok_gudang'] ?? 0);
        if ($total < 0) {
            die('Jumlah stok tidak valid');
        }

        $this->model->update($id, [
            'id_barang' => $stok['id_barang'] ?? '',
            'total_stok_gudang' => $total
        ]);

        header('Location: ?url=stokgudang/index&status=updated');
        exit;
    }

    /* ===========================
       TAMPILKAN FORM PENEMPATAN
       =========================== */
    public function place($id) {
        $this->requireKaryawan();

        $stok = $this->model->getById($id);
        if (!$stok) {
            header('Location: ?url=stokgudang/index&error=notfound');
            exit;
        }

        // daftar etalase yang berisi barang yang sama
        require_once __DIR__ . '/../models/StokEtalase.php';
        $seModel = new StokEtalase();
        $etalases = [];
        if (!empty($stok['id_barang'])) {
            $etalases = $seModel->getByBarang($stok['id_barang']);
        }
    // distinct rak options for dropdown
    $rak_options = $seModel->getDistinctRak();

        include __DIR__ . '/../views/stok_gudang/place.php';
    }

    /* ===========================
       PROSES PENEMPATAN (STORE)
       =========================== */
    public function placeStore() {
        $this->requireKaryawan();

        $id_stok_gudang = $_POST['id_stok_gudang'] ?? '';
        $id_stok_etalase = $_POST['id_stok_etalase'] ?? '';
        $buat_etalase_baru = ($_POST['buat_etalase_baru'] ?? '0') === '1';
    $rak = trim($_POST['rak'] ?? '');
        $stok_gudang_keluar = (int)($_POST['stok_gudang_keluar'] ?? 0);
        $tgl_penempatan = $_POST['tgl_penempatan'] ?? date('Y-m-d');

        if (empty($id_stok_gudang) || $stok_gudang_keluar <= 0) {
            die('Data penempatan tidak lengkap');
        }

        $stok = $this->model->getById($id_stok_gudang);
        if (!$stok) die('Stok gudang tidak ditemukan');

        if ($stok_gudang_keluar > (int)$stok['total_stok_gudang']) {
            die('Jumlah yang dipindah melebihi stok gudang');
        }

        require_once __DIR__ . '/../models/StokEtalase.php';
        require_once __DIR__ . '/../models/Ditempatkan.php';

        $seModel = new StokEtalase();
        $dModel = new Ditempatkan();

        // jika buat etalase baru atau tidak ada id dipilih
        if ($buat_etalase_baru || empty($id_stok_etalase)) {
            $id_stok_etalase = $seModel->generateNewId();
            $insertEta = $seModel->insert([
                'id_stok_etalase' => $id_stok_etalase,
                'total_stok_eta' => $stok_gudang_keluar,
                'rak' => $rak
            ]);
            if (!$insertEta) die('Gagal membuat etalase baru');
        } else {
            // tambahkan ke etalase existing
            $eta = $seModel->getById($id_stok_etalase);
            if ($eta) {
                $newEtaTotal = (int)$eta['total_stok_eta'] + $stok_gudang_keluar;
                $seModel->update($id_stok_etalase, ['total_stok_eta' => $newEtaTotal]);
            } else {
                // jika id tidak valid, buat baru
                $id_stok_etalase = $seModel->generateNewId();
                $seModel->insert([
                    'id_stok_etalase' => $id_stok_etalase,
                    'total_stok_eta' => $stok_gudang_keluar,
                    'rak' => $rak
                ]);
            }
        }

        // kurangi stok gudang
        $newGudangTotal = (int)$stok['total_stok_gudang'] - $stok_gudang_keluar;
        $this->model->update($id_stok_gudang, [
            'id_barang' => $stok['id_barang'],
            'total_stok_gudang' => $newGudangTotal
        ]);

        // insert ke tabel ditempatkan
        $id_ditempatkan = $dModel->generateNewId();
        $dModel->insert([
            'id_ditempatkan' => $id_ditempatkan,
            'id_stok_gudang' => $id_stok_gudang,
            'id_stok_etalase' => $id_stok_etalase,
            'tgl_penempatan' => $tgl_penempatan,
            'stok_gudang_keluar' => $stok_gudang_keluar,
            'stok_etalase_masuk' => $stok_gudang_keluar
        ]);

        header('Location: ?url=stokgudang/index&status=placed');
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
}
