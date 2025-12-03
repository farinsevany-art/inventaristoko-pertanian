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

    public function edit($id) {
        $model = new DitempatkanModel();
        $current = $model->getDitempatkanById($id);
        if (!$current) {
            header('Location: ?url=ditempatkan/index&error=notfound');
            exit;
        }
        require_once "../app/views/ditempatkan/edit.php";
    }

    public function update($id) {
        $model = new DitempatkanModel();
        $data = [
            'id_stok_gudang' => $_POST['id_stok_gudang'] ?? '',
            'id_stok_etalase' => $_POST['id_stok_etalase'] ?? '',
            'tgl_penempatan' => $_POST['tgl_penempatan'] ?? date('Y-m-d'),
            'stok_gudang_keluar' => $_POST['stok_gudang_keluar'] ?? 0,
            'stok_etalase_masuk' => $_POST['stok_etalase_masuk'] ?? 0
        ];
        $model->updateDitempatkan($id, $data);
        header('Location: ?url=ditempatkan/index&status=updated');
        exit;
    }

    public function delete($id) {
        $model = new DitempatkanModel();
        $model->hapusDitempatkan($id);
        header('Location: ?url=ditempatkan/index&status=deleted');
        exit;
    }
}
