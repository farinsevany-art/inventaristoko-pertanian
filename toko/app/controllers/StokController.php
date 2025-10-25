<?php
require_once __DIR__ . '/../models/StokGudangModel.php';
require_once __DIR__ . '/../models/StokEtalaseModel.php';

class StokController {
    public function index() {
        $gudangModel = new StokGudangModel();
        $etalaseModel = new StokEtalaseModel();

        $stokGudang = $gudangModel->getAllStokGudang();
        $stokEtalase = $etalaseModel->getAllStokEtalase();

        require __DIR__ . '/../views/stok.php';
    }
}
