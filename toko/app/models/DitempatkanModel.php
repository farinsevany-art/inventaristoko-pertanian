<?php
require_once 'Database.php';

class DitempatkanModel extends Database {

    // Ambil semua data penempatan
    public function getAllDitempatkan() {
        return $this->getAll("SELECT * FROM ditempatkan ORDER BY id_ditempatkan ASC");
    }

    // Ambil data penempatan berdasarkan ID
    public function getDitempatkanById($id) {
        return $this->getOne("SELECT * FROM ditempatkan WHERE id_ditempatkan = '$id'");
    }

    // Tambah data penempatan
    public function tambahDitempatkan($data) {
        $id          = $this->conn->real_escape_string($data['id_ditempatkan']);
        $idGudang    = $this->conn->real_escape_string($data['id_stok_gudang']);
        $idEtalase   = $this->conn->real_escape_string($data['id_stok_etalase']);
        $tgl         = $this->conn->real_escape_string($data['tgl_penempatan']);
        $keluar      = (int)$data['stok_gudang_keluar'];
        $masuk       = (int)$data['stok_etalase_masuk'];

        $query = "INSERT INTO ditempatkan 
                  (id_ditempatkan, id_stok_gudang, id_stok_etalase, tgl_penempatan, stok_gudang_keluar, stok_etalase_masuk)
                  VALUES ('$id', '$idGudang', '$idEtalase', '$tgl', $keluar, $masuk)";
        return $this->execute($query);
    }

    // Update data penempatan
    public function updateDitempatkan($id, $data) {
        $idGudang    = $this->conn->real_escape_string($data['id_stok_gudang']);
        $idEtalase   = $this->conn->real_escape_string($data['id_stok_etalase']);
        $tgl         = $this->conn->real_escape_string($data['tgl_penempatan']);
        $keluar      = (int)$data['stok_gudang_keluar'];
        $masuk       = (int)$data['stok_etalase_masuk'];

        $query = "UPDATE ditempatkan SET 
                    id_stok_gudang='$idGudang',
                    id_stok_etalase='$idEtalase',
                    tgl_penempatan='$tgl',
                    stok_gudang_keluar=$keluar,
                    stok_etalase_masuk=$masuk
                  WHERE id_ditempatkan='$id'";
        return $this->execute($query);
    }

    // Hapus data penempatan
    public function hapusDitempatkan($id) {
        return $this->execute("DELETE FROM ditempatkan WHERE id_ditempatkan='$id'");
    }
}
