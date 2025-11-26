<?php
require_once __DIR__ . '/../models/Mendata.php';

class MendataController {
    public function index() {
        $mendataModel = new Mendata();

        $filters = [
            'nama_barang' => $_GET['nama_barang'] ?? null,
            'jenis_barang' => $_GET['jenis_barang'] ?? null,
            'day' => $_GET['day'] ?? null,
            'month' => $_GET['month'] ?? null,
            'year' => $_GET['year'] ?? null,
        ];

        $conditions = [];

        if (!empty($filters['nama_barang'])) {
            $nama_barang = $mendataModel->escape($filters['nama_barang']);
            $conditions[] = "b.nama_barang LIKE '%$nama_barang%'";
        }
        if (!empty($filters['jenis_barang'])) {
            $jenis_barang = $mendataModel->escape($filters['jenis_barang']);
            $conditions[] = "b.jenis_barang = '$jenis_barang'";
        }
        if (!empty($filters['day'])) {
            $day = (int)$filters['day'];
            $conditions[] = "DAY(m.tgl_pendataan) = $day";
        }
        if (!empty($filters['month'])) {
            $month = (int)$filters['month'];
            $conditions[] = "MONTH(m.tgl_pendataan) = $month";
        }
        if (!empty($filters['year'])) {
            $year = (int)$filters['year'];
            $conditions[] = "YEAR(m.tgl_pendataan) = $year";
        }

        $where = '';
        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $query = "
            SELECT m.*, b.nama_barang, b.jenis_barang
            FROM mendata m
            LEFT JOIN barang b ON m.id_barang = b.id_barang
            $where
            ORDER BY m.tgl_pendataan DESC
        ";

        $mendataList = $mendataModel->getAll($query);

        // Get distinct jenis_barang list for filter dropdown
        $jenisBarangList = $mendataModel->getDistinctJenisBarang();

        include __DIR__ . '/../views/mendata/index.php';
    }
}
