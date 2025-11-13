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
    // Jalankan query SELECT (banyak baris)
    // Note: $query is optional to keep compatibility with child model methods named getAll()
    public function getAll($query = null) {
        if ($query === null) {
            // No query provided - return empty array (child classes usually override this method)
            return [];
        }
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query error: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Jalankan query SELECT (satu baris)
    // Jalankan query SELECT (satu baris)
    // Note: $query is optional to keep compatibility with child model methods named getOne()
    public function getOne($query = null) {
        if ($query === null) {
            return null;
        }
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

    // Compatible wrapper used by older models
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

