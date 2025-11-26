<?php
require_once 'Database.php';

class DitempatkanModel extends Database {

    // Ambil distinct jenis_barang for filter dropdown
    public function getDistinctJenisBarang() {
        return $this->query("SELECT DISTINCT jenis_barang FROM barang WHERE jenis_barang IS NOT NULL AND jenis_barang != ''")->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil semua data penempatan dengan filters untuk nama_barang, jenis_barang, dan tgl_penempatan (day, month, year)
    public function getAllDitempatkan($filters = []) {

        $conditions = [];
        $params = [];

        if (!empty($filters['nama_barang'])) {
            $nama_barang = $this->conn->real_escape_string($filters['nama_barang']);
            $conditions[] = "barang.nama_barang LIKE '%$nama_barang%'";
        }
        if (!empty($filters['jenis_barang'])) {
            $jenis_barang = $this->conn->real_escape_string($filters['jenis_barang']);
            $conditions[] = "barang.jenis_barang = '$jenis_barang'";
        }
        if (!empty($filters['day'])) {
            $day = (int)$filters['day'];
            $conditions[] = "DAY(ditempatkan.tgl_penempatan) = $day";
        }
        if (!empty($filters['month'])) {
            $month = (int)$filters['month'];
            $conditions[] = "MONTH(ditempatkan.tgl_penempatan) = $month";
        }
        if (!empty($filters['year'])) {
            $year = (int)$filters['year'];
            $conditions[] = "YEAR(ditempatkan.tgl_penempatan) = $year";
        }

        $where = '';
        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $query = "
        SELECT 
            barang.nama_barang,
            barang.jenis_barang,
            ditempatkan.tgl_penempatan,
            ditempatkan.stok_gudang_keluar,
            ditempatkan.stok_etalase_masuk
        FROM ditempatkan
        JOIN stok_gudang 
            ON ditempatkan.id_stok_gudang = stok_gudang.id_stok_gudang
        JOIN barang 
            ON stok_gudang.id_barang = barang.id_barang
        $where
        ORDER BY ditempatkan.tgl_penempatan DESC
        ";

        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // Ambil data berdasarkan ID
    public function getById($id) {
        return $this->getOne("SELECT * FROM ditempatkan WHERE id_ditempatkan = '$id'");
    }

    // Tambah data penempatan
    public function tambah($data) {
        $id     = $this->conn->real_escape_string($data['id_ditempatkan']);
        $idGdg  = $this->conn->real_escape_string($data['id_stok_gudang']);
        $idEt   = $this->conn->real_escape_string($data['id_stok_etalase']);
        $tgl    = $this->conn->real_escape_string($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk  = (int)$data['stok_etalase_masuk'];

        $query = "INSERT INTO ditempatkan 
                  (id_ditempatkan, id_stok_gudang, id_stok_etalase, tgl_penempatan, stok_gudang_keluar, stok_etalase_masuk)
                  VALUES ('$id', '$idGdg', '$idEt', '$tgl', $keluar, $masuk)";
        return $this->execute($query);
    }

    // Update
    public function update($id, $data) {
        $idGdg  = $this->conn->real_escape_string($data['id_stok_gudang']);
        $idEt   = $this->conn->real_escape_string($data['id_stok_etalase']);
        $tgl    = $this->conn->real_escape_string($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk  = (int)$data['stok_etalase_masuk'];

        $query = "UPDATE ditempatkan SET
                    id_stok_gudang='$idGdg',
                    id_stok_etalase='$idEt',
                    tgl_penempatan='$tgl',
                    stok_gudang_keluar=$keluar,
                    stok_etalase_masuk=$masuk
                  WHERE id_ditempatkan='$id'";
        return $this->execute($query);
    }

    // Hapus
    public function hapus($id) {
        return $this->execute("DELETE FROM ditempatkan WHERE id_ditempatkan='$id'");
    }
}
