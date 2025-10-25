<?php
class Database {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "toko_pertanian");

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    // Jalankan query SELECT (banyak baris)
    public function getAll($query) {
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Jalankan query SELECT (satu baris)
    public function getOne($query) {
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_assoc();
    }

    // Jalankan INSERT, UPDATE, DELETE
    public function execute($query) {
        if ($this->conn->query($query)) {
            return true;
        } else {
            die("Query gagal: " . $this->conn->error);
        }
    }
}
