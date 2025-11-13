<?php
require_once __DIR__ . "/Database.php";

class Ditempatkan extends Database {

    public function getAll($query = null) {
        return $this->query("SELECT * FROM ditempatkan");
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM ditempatkan WHERE id_ditempatkan = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $id = $this->escape($data['id_ditempatkan']);
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $tgl = $this->escape($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk = (int)$data['stok_etalase_masuk'];

        return $this->query("INSERT INTO ditempatkan VALUES ('$id', '$id_stok_gudang', '$id_stok_etalase', '$tgl', '$keluar', '$masuk')");
    }

    public function update($id, $data) {
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $tgl = $this->escape($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk = (int)$data['stok_etalase_masuk'];

        return $this->query("UPDATE ditempatkan 
            SET id_stok_gudang='$id_stok_gudang', id_stok_etalase='$id_stok_etalase', 
                tgl_penempatan='$tgl', stok_gudang_keluar='$keluar', stok_etalase_masuk='$masuk'
            WHERE id_ditempatkan='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM ditempatkan WHERE id_ditempatkan='$id'");
    }
}
