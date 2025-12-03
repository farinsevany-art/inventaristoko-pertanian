<?php
require_once __DIR__ . "/Database.php";

class Mendata extends Database {


    // ✅ Ambil semua data mendata dengan join ke barang untuk mendapatkan nama_barang dan jenis_barang
    public function getAll($query = null) {

        if ($query !== null) {
            return $this->conn->query($query)->fetch_all(MYSQLI_ASSOC);
        }

        // Join with barang to get nama_barang and jenis_barang
        $sql = "SELECT m.*, b.nama_barang, b.jenis_barang
                FROM mendata m
                LEFT JOIN barang b ON m.id_barang = b.id_barang
                ORDER BY m.tgl_pendataan DESC";

        return $this->conn
            ->query($sql)
            ->fetch_all(MYSQLI_ASSOC);
    }


    // ✅ AUTO GENERATE ID MENDATA
    public function generateNewId() {
        $result = $this->conn->query("SELECT MAX(id_mendata) AS last_id FROM mendata");
        $row = $result->fetch_assoc();

        if (!$row['last_id']) {
            return 'MD001';
        }

        $number = (int) preg_replace('/[^0-9]/', '', $row['last_id']);
        $new = $number + 1;

        return 'MD' . str_pad($new, 3, '0', STR_PAD_LEFT);
    }

    // ✅ INSERT DATA MENDATA (VERSI BARU)
    public function insert($data) {

        $id_mendata   = $this->generateNewId();
        $id_karyawan  = $this->escape($data['id_karyawan']);
        $id_gudang     = $this->escape($data['id_stok_gudang']);
        $id_barang     = $this->escape($data['id_barang']);
        $tgl          = $this->escape($data['tgl_pendataan']);
        $jumlah       = (int)$data['stok_gudang_masuk'];

        $query = "INSERT INTO mendata 
        (id_mendata, id_karyawan, id_stok_gudang, id_barang, tgl_pendataan, stok_gudang_masuk)
        VALUES 
        ('$id_mendata', '$id_karyawan', '$id_gudang', '$id_barang', '$tgl', $jumlah)";

        return $this->conn->query($query);
    }
}
