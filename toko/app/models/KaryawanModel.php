<?php
require_once 'Database.php';

class KaryawanModel extends Database {

    public function getAllKaryawan() {
        return $this->getAll("SELECT * FROM karyawan ORDER BY id_karyawan ASC");
    }

    public function getKaryawanById($id) {
        return $this->getOne("SELECT * FROM karyawan WHERE id_karyawan = '$id'");
    }

    public function tambahKaryawan($data) {
        $id_karyawan    = $this->conn->real_escape_string($data['id_karyawan']);
        $nama_karyawan  = $this->conn->real_escape_string($data['nama_karyawan']);
        $email          = $this->conn->real_escape_string($data['email']);
        $no_telp        = $this->conn->real_escape_string($data['no_telp']);
        $alamat         = $this->conn->real_escape_string($data['alamat']);
        $posisi         = $this->conn->real_escape_string($data['posisi']);

        $query = "INSERT INTO karyawan 
                  (id_karyawan, nama_karyawan, email, no_telp, alamat, posisi)
                  VALUES ('$id_karyawan', '$nama_karyawan', '$email', '$no_telp', '$alamat', '$posisi')";
        return $this->execute($query);
    }

    public function updateKaryawan($id, $data) {
        $nama_karyawan  = $this->conn->real_escape_string($data['nama_karyawan']);
        $email          = $this->conn->real_escape_string($data['email']);
        $no_telp        = $this->conn->real_escape_string($data['no_telp']);
        $alamat         = $this->conn->real_escape_string($data['alamat']);
        $posisi         = $this->conn->real_escape_string($data['posisi']);

        $query = "UPDATE karyawan SET 
                    nama_karyawan='$nama_karyawan',
                    email='$email',
                    no_telp='$no_telp',
                    alamat='$alamat',
                    posisi='$posisi'
                  WHERE id_karyawan='$id'";
        return $this->execute($query);
    }

    public function hapusKaryawan($id) {
        return $this->execute("DELETE FROM karyawan WHERE id_karyawan='$id'");
    }
}
