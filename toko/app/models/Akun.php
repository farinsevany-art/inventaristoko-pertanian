<?php
require_once __DIR__ . "/Database.php";

class Akun extends Database {

    public function getAll($query = null) {
        return $this->query("SELECT * FROM akun");
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM akun WHERE id_akun = '$id'")->fetch_assoc();
    }

    public function insert($data) {
        $username = $this->escape($data['username']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $posisi = $this->escape($data['posisi']);
        $id_karyawan = $this->escape($data['id_karyawan']);

        return $this->query("INSERT INTO akun (username, password, posisi, id_karyawan) 
                             VALUES ('$username', '$password', '$posisi', '$id_karyawan')");
    }

    public function update($id, $data) {
        $id = $this->escape($id);
        $username = $this->escape($data['username']);
        $posisi = $this->escape($data['posisi']);
        $id_karyawan = $this->escape($data['id_karyawan']);
        return $this->query("UPDATE akun SET username='$username', posisi='$posisi', id_karyawan='$id_karyawan' 
                             WHERE id_akun='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM akun WHERE id_akun='$id'");
    }
}
