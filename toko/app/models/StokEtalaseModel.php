<?php
require_once 'Database.php';

class StokEtalaseModel extends Database {

    public function getAllStokEtalase() {
        return $this->getAll("SELECT * FROM stok_etalase ORDER BY id_stok_etalase ASC");
    }

    public function getStokEtalaseById($id) {
        return $this->getOne("SELECT * FROM stok_etalase WHERE id_stok_etalase = '$id'");
    }

    public function tambahStokEtalase($data) {
        $id     = $this->conn->real_escape_string($data['id_stok_etalase']);
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_eta']);
        $total  = (int)$data['total_stok_eta'];

        $query = "INSERT INTO stok_etalase 
                  (id_stok_etalase, nama_barang, jenis_barang, kadaluarsa_barang, tgl_update_eta, total_stok_eta)
                  VALUES ('$id', '$nama', '$jenis', '$kadaluarsa', '$tgl_update', $total)";
        return $this->execute($query);
    }

    public function updateStokEtalase($id, $data) {
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_eta']);
        $total  = (int)$data['total_stok_eta'];

        $query = "UPDATE stok_etalase SET
                    nama_barang='$nama',
                    jenis_barang='$jenis',
                    kadaluarsa_barang='$kadaluarsa',
                    tgl_update_eta='$tgl_update',
                    total_stok_eta=$total
                  WHERE id_stok_etalase='$id'";
        return $this->execute($query);
    }

    public function hapusStokEtalase($id) {
        return $this->execute("DELETE FROM stok_etalase WHERE id_stok_etalase='$id'");
    }
}
