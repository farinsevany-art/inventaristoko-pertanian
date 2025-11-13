<?php
require_once __DIR__ . "/Database.php";

class StokGudang extends Database {

    public function getAll($query = null) {
        // return stok gudang with related barang info when available
        return $this->query(
          "SELECT sg.*, b.id_barang AS id_barang, b.nama_barang AS nama_barang, b.jenis_barang AS jenis_barang, b.kadaluarsa_barang AS kadaluarsa_barang
             FROM stok_gudang sg
             LEFT JOIN barang b ON sg.id_barang = b.id_barang"
        );
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM stok_gudang WHERE id_stok_gudang = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_barang = $this->escape($data['id_barang']);
        $total = (int)$data['total_stok_gudang'];
        return $this->query("INSERT INTO stok_gudang VALUES ('$id_stok_gudang', '$id_barang', '$total')");
    }

    public function update($id, $data) {
        $id_barang = $this->escape($data['id_barang']);
        $total = (int)$data['total_stok_gudang'];
        return $this->query("UPDATE stok_gudang SET id_barang='$id_barang', total_stok_gudang='$total' WHERE id_stok_gudang='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM stok_gudang WHERE id_stok_gudang='$id'");
    }
}
