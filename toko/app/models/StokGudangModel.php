<?php
require_once 'Database.php';

class StokGudangModel extends Database {

    public function getAllStokGudang() {
        return $this->getAll("SELECT * FROM stok_gudang ORDER BY id_stok_gudang ASC");
    }

    public function getStokGudangById($id) {
        return $this->getOne("SELECT * FROM stok_gudang WHERE id_stok_gudang = '$id'");
    }

    public function tambahStokGudang($data) {
        $id     = $this->conn->real_escape_string($data['id_stok_gudang']);
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_gud']);
        $total  = (int)$data['total_stok_gudang'];

        $query = "INSERT INTO stok_gudang
                  (id_stok_gudang, nama_barang, jenis_barang, kadaluarsa_barang, tgl_update_gud, total_stok_gudang)
                  VALUES ('$id', '$nama', '$jenis', '$kadaluarsa', '$tgl_update', $total)";
        return $this->execute($query);
    }

    public function updateStokGudang($id, $data) {
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_gud']);
        $total  = (int)$data['total_stok_gudang'];

        $query = "UPDATE stok_gudang SET
                    nama_barang='$nama',
                    jenis_barang='$jenis',
                    kadaluarsa_barang='$kadaluarsa',
                    tgl_update_gud='$tgl_update',
                    total_stok_gudang=$total
                  WHERE id_stok_gudang='$id'";
        return $this->execute($query);
    }

    public function hapusStokGudang($id) {
        return $this->execute("DELETE FROM stok_gudang WHERE id_stok_gudang='$id'");
    }
}
