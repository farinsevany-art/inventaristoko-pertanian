<?php
require_once "../app/models/DitempatkanModel.php";

class DitempatkanController {

    public function index() {
        $model = new DitempatkanModel();

        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? null,
            'jenis_barang' => $_GET['jenis_barang'] ?? null,
            'day' => $_GET['day'] ?? null,
            'month' => $_GET['month'] ?? null,
            'year' => $_GET['year'] ?? null,
        ];

        // Fetch filtered data
        $data['ditempatkan'] = $model->getAllDitempatkan($filters);

        // Get distinct jenis_barang list for filter dropdown
        $data['jenisBarangList'] = $model->getDistinctJenisBarang();

        require_once "../app/views/ditempatkan/index.php";
    }
}
