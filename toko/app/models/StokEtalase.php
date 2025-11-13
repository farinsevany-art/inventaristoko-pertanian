<?php
require_once __DIR__ . "/Database.php";

class StokEtalase extends Database {

    public function getAll($query = null) {
        // Try to include barang info by linking etalase -> ditempatkan -> stok_gudang -> barang
        return $this->query(
          "SELECT se.*, sg.id_barang AS id_barang, b.nama_barang AS nama_barang, b.jenis_barang AS jenis_barang, b.kadaluarsa_barang AS kadaluarsa_barang
             FROM stok_etalase se
             LEFT JOIN ditempatkan d ON se.id_stok_etalase = d.id_stok_etalase
             LEFT JOIN stok_gudang sg ON d.id_stok_gudang = sg.id_stok_gudang
             LEFT JOIN barang b ON sg.id_barang = b.id_barang
             GROUP BY se.id_stok_etalase"
        );
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM stok_etalase WHERE id_stok_etalase = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $total = (int)$data['total_stok_eta'];
        return $this->query("INSERT INTO stok_etalase VALUES ('$id_stok_etalase', '$total')");
    }

    public function update($id, $data) {
        $total = (int)$data['total_stok_eta'];
        return $this->query("UPDATE stok_etalase SET total_stok_eta='$total' WHERE id_stok_etalase='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM stok_etalase WHERE id_stok_etalase='$id'");
    }
}
