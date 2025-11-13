<?php
require_once __DIR__ . "/Database.php";

class Barang extends Database {

    // Ambil semua data barang
    public function getAll($query = null) {
        $sql = "SELECT * FROM barang ORDER BY id_barang ASC";
        $result = $this->query($sql);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Ambil barang berdasarkan ID
    public function getById($id_barang) {
        $id_barang = $this->escape($id_barang);
        $sql = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
        $result = $this->query($sql);
        return $result->fetch_assoc();
    }

    // Tambah barang + otomatis tambah stok_gudang (dengan stok dari form)
    public function insert($data) {
        $id_barang = $this->escape($data['id_barang']);
        $nama_barang = $this->escape($data['nama_barang']);
        $jenis_barang = $this->escape($data['jenis_barang']);
        $kadaluarsa_barang = $this->escape($data['kadaluarsa_barang']);
        $total_stok_gudang = isset($data['total_stok_gudang']) ? (int)$data['total_stok_gudang'] : 0;

        // 1️⃣ Tambah ke tabel barang
        $sql = "INSERT INTO barang (id_barang, nama_barang, jenis_barang, kadaluarsa_barang)
                VALUES ('$id_barang', '$nama_barang', '$jenis_barang', '$kadaluarsa_barang')";
        $this->query($sql);

        // 2️⃣ Generate ID stok gudang baru (SG###)
        $res = $this->query("SELECT MAX(id_stok_gudang) AS last_id FROM stok_gudang");
        $row = $res->fetch_assoc();
        $lastId = $row['last_id'] ?? 'SG000';
        $num = intval(substr($lastId, 2)) + 1;
        $newId = 'SG' . str_pad($num, 3, '0', STR_PAD_LEFT);

        // 3️⃣ Tambah stok_gudang sesuai input user
        $this->query("INSERT INTO stok_gudang (id_stok_gudang, total_stok_gudang, id_barang)
                      VALUES ('$newId', $total_stok_gudang, '$id_barang')");
    }

    // Update barang
    public function update($id_barang, $data) {
        $id_barang = $this->escape($id_barang);
        $nama_barang = $this->escape($data['nama_barang']);
        $jenis_barang = $this->escape($data['jenis_barang']);
        $kadaluarsa_barang = $this->escape($data['kadaluarsa_barang']);

        $sql = "UPDATE barang SET
                    nama_barang = '$nama_barang',
                    jenis_barang = '$jenis_barang',
                    kadaluarsa_barang = '$kadaluarsa_barang'
                WHERE id_barang = '$id_barang'";
        $this->query($sql);
    }

    // Hapus barang (beserta stok gudang-nya)
    public function delete($id_barang) {
        $id_barang = $this->escape($id_barang);
        // Hapus stok gudang terkait
        $this->query("DELETE FROM stok_gudang WHERE id_barang = '$id_barang'");
        // Hapus barang
        $this->query("DELETE FROM barang WHERE id_barang = '$id_barang'");
    }
}
