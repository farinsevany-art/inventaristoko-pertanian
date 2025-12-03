<?php
require_once 'Database.php';

class MendataModel extends Database {

    // Ambil semua data pendataan
    public function getAllMendata() {
        return $this->getAll("SELECT * FROM mendata ORDER BY id_mendata ASC");
    }

    // Ambil satu data pendataan berdasarkan ID
    public function getMendataById($id) {
        return $this->getOne("SELECT * FROM mendata WHERE id_mendata = '$id'");
    }

    // Tambah data pendataan
    public function tambahMendata($data) {
        $id         = $this->conn->real_escape_string($data['id_mendata']);
        $idKaryawan = $this->conn->real_escape_string($data['id_karyawan']);
        $idGudang   = $this->conn->real_escape_string($data['id_stok_gudang']);
        $tgl        = $this->conn->real_escape_string($data['tgl_pendataan']);
        $masuk      = (int)$data['stok_gudang_masuk'];

        $query = "INSERT INTO mendata 
                  (id_mendata, id_karyawan, id_stok_gudang, tgl_pendataan, stok_gudang_masuk)
                  VALUES ('$id', '$idKaryawan', '$idGudang', '$tgl', $masuk)";
        return $this->execute($query);
    }

    // Update data pendataan
    public function updateMendata($id, $data) {
        $idKaryawan = $this->conn->real_escape_string($data['id_karyawan']);
        $idGudang   = $this->conn->real_escape_string($data['id_stok_gudang']);
        $tgl        = $this->conn->real_escape_string($data['tgl_pendataan']);
        $masuk      = (int)$data['stok_gudang_masuk'];

        $query = "UPDATE mendata SET 
                    id_karyawan='$idKaryawan',
                    id_stok_gudang='$idGudang',
                    tgl_pendataan='$tgl',
                    stok_gudang_masuk=$masuk
                  WHERE id_mendata='$id'";
        return $this->execute($query);
    }

    // Hapus data pendataan
    public function hapusMendata($id) {
        return $this->execute("DELETE FROM mendata WHERE id_mendata='$id'");
    }
}
