<?php
require_once __DIR__ . "/Database.php";

class Mendata extends Database {

    public function getAll($query = null) {
        return $this->query("SELECT * FROM mendata");
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM mendata WHERE id_mendata = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $id = $this->escape($data['id_mendata']);
        $id_karyawan = $this->escape($data['id_karyawan']);
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_barang = $this->escape($data['id_barang']);
        $tgl = $this->escape($data['tgl_pendataan']);
        $masuk = (int)$data['stok_gudang_masuk'];

        return $this->query("INSERT INTO mendata VALUES ('$id', '$id_karyawan', '$id_stok_gudang', '$id_barang', '$tgl', '$masuk')");
    }

    public function update($id, $data) {
        $id_karyawan = $this->escape($data['id_karyawan']);
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_barang = $this->escape($data['id_barang']);
        $tgl = $this->escape($data['tgl_pendataan']);
        $masuk = (int)$data['stok_gudang_masuk'];

        return $this->query("UPDATE mendata 
            SET id_karyawan='$id_karyawan', id_stok_gudang='$id_stok_gudang', id_barang='$id_barang',
                tgl_pendataan='$tgl', stok_gudang_masuk='$masuk'
            WHERE id_mendata='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM mendata WHERE id_mendata='$id'");
    }
}
