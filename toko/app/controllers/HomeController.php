<?php
class HomeController {
    public function index() {
        require '../app/views/index.php';
    }

    public function about() {
        require '../app/views/about.php';
    }

    public function contact() {
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
