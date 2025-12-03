<?php
class Database {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "toko_pertanian");

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
        // gunakan utf8mb4 agar kompatibel dengan emoji & karakter
        $this->conn->set_charset("utf8mb4");
    }

    // Ambil banyak baris sebagai array assoc
    public function getAll($query = null) {
        if ($query === null) return [];
        $result = $this->conn->query($query);
        if ($result === false) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil satu baris
    public function getOne($query = null) {
        if ($query === null) return null;
        $result = $this->conn->query($query);
        if ($result === false) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_assoc();
    }

    // Jalankan INSERT/UPDATE/DELETE; kembalikan boolean
    public function execute($query) {
        if ($this->conn->query($query) === FALSE) {
            die("Query gagal: " . $this->conn->error);
        }
        return true;
    }

    // Query wrapper yang mengembalikan result object atau die on error
    public function query($query) {
        $result = $this->conn->query($query);
        if ($result === false) {
            die("Query error: " . $this->conn->error);
        }
        return $result;
    }

    // Escape helper
    public function escape($value) {
        return $this->conn->real_escape_string($value);
    }
}
