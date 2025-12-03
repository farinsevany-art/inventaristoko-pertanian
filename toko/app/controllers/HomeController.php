<?php
class HomeController {
    public function index() {
        require '../app/views/index.php';
    }

    public function about() {
        require '../app/views/about.php';
    }

    public function contact() {
        // handle POST insert ke tabel kontak with validation
        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Kontak.php';
            $kModel = new Kontak();

            $old['name'] = trim($_POST['name'] ?? '');
            $old['email'] = trim($_POST['email'] ?? '');
            $old['phone'] = trim($_POST['phone'] ?? '');
            $old['message'] = trim($_POST['message'] ?? '');

            // Validation
            if ($old['name'] === '') {
                $errors[] = 'Nama harus diisi.';
            }
            if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email tidak valid.';
            }
            if ($old['message'] === '') {
                $errors[] = 'Pesan tidak boleh kosong.';
            }

            // Jika valid, insert
            if (empty($errors)) {
                $data = [
                    'nama' => $old['name'],
                    'email' => $old['email'],
                    'no_telp' => $old['phone'],
                    'pesan' => $old['message']
                ];
                $inserted = $kModel->insert($data);
                if ($inserted) {
                    header('Location: ?url=home/contact&success=1');
                    exit;
                } else {
                    $errors[] = 'Terjadi kesalahan saat menyimpan pesan.';
                }
            }
        }

        require '../app/views/contact.php';
    }

    public function stok() {
        require '../app/views/stok.php';
    }

    // Forwarder: allow URLs like /home/barang/index to work by delegating
    // to the BarangController. The front controller maps 'home/barang/index'
    // to HomeController::barang('index'), so we dispatch here.
    public function barang($action = 'index', ...$params) {
        require_once __DIR__ . '/BarangController.php';
        $ctrl = new BarangController();
        if (method_exists($ctrl, $action)) {
            call_user_func_array([$ctrl, $action], $params);
        } else {
            // fallback to index
            $ctrl->index();
        }
    }
}