<?php
require_once __DIR__ . "/Database.php";

class Karyawan extends Database {

    public function getAll($query = null) {
        return $this->query("SELECT * FROM karyawan");
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM karyawan WHERE id_karyawan = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $id_karyawan = $this->escape($data['id_karyawan']);
        $nama = $this->escape($data['nama_karyawan']);
        $email = $this->escape($data['email']);
        $no_telp = $this->escape($data['no_telp']);
        $alamat = $this->escape($data['alamat']);
        $posisi = $this->escape($data['posisi']);
        return $this->query("INSERT INTO karyawan VALUES ('$id_karyawan', '$nama', '$email', '$no_telp', '$alamat', '$posisi')");
    }

    public function update($id, $data) {
        $nama = $this->escape($data['nama_karyawan']);
        $email = $this->escape($data['email']);
        $no_telp = $this->escape($data['no_telp']);
        $alamat = $this->escape($data['alamat']);
        $posisi = $this->escape($data['posisi']);
        return $this->query("UPDATE karyawan SET nama_karyawan='$nama', email='$email', no_telp='$no_telp', alamat='$alamat', posisi='$posisi' WHERE id_karyawan='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM karyawan WHERE id_karyawan='$id'");
    }
}
