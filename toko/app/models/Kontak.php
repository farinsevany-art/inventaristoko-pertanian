<?php
require_once __DIR__ . "/Database.php";

class Kontak extends Database {

    // Ambil semua kontak
    public function getAll($query = null) {
        if ($query !== null) {
            return $this->conn->query($query)->fetch_all(MYSQLI_ASSOC);
        }
        return $this->conn->query("SELECT * FROM kontak ORDER BY id_kontak DESC")->fetch_all(MYSQLI_ASSOC);
    }

    // Insert data kontak
    public function insert($data) {
        $nama = $this->escape($data['nama']);
        $email = $this->escape($data['email']);
        $no_telp = $this->escape($data['no_telp'] ?? '');
        $pesan = $this->escape($data['pesan']);

        $query = "INSERT INTO kontak (nama, email, no_telp, pesan) VALUES ('$nama', '$email', '$no_telp', '$pesan')";
        return $this->conn->query($query);
    }

    // Optional: delete kontak
    public function delete($id) {
        $id = (int)$id;
        return $this->conn->query("DELETE FROM kontak WHERE id_kontak = $id");
    }
}

