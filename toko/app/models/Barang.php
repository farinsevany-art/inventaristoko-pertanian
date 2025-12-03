<?php
require_once __DIR__ . "/Database.php";

class Barang extends Database {

    // Get distinct jenis_barang for filter dropdown
    public function getDistinctJenisBarang() {
        return $this->query("SELECT DISTINCT jenis_barang FROM barang WHERE jenis_barang IS NOT NULL AND jenis_barang != ''")->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil semua data barang with filters for nama_barang, jenis_barang, kadaluarsa_barang parts
    public function getAll($filters = []) {
        $conditions = [];

        if (!empty($filters['nama_barang'])) {
            $nama_barang = $this->escape($filters['nama_barang']);
            $conditions[] = "nama_barang LIKE '%$nama_barang%'";
        }
        if (!empty($filters['jenis_barang'])) {
            $jenis_barang = $this->escape($filters['jenis_barang']);
            $conditions[] = "jenis_barang = '$jenis_barang'";
        }
        if (!empty($filters['day'])) {
            $day = (int)$filters['day'];
            $conditions[] = "DAY(kadaluarsa_barang) = $day";
        }
        if (!empty($filters['month'])) {
            $month = (int)$filters['month'];
            $conditions[] = "MONTH(kadaluarsa_barang) = $month";
        }
        if (!empty($filters['year'])) {
            $year = (int)$filters['year'];
            $conditions[] = "YEAR(kadaluarsa_barang) = $year";
        }

        $where = '';
        if (count($conditions) > 0) {
            $where = "WHERE " . implode(" AND ", $conditions);
        }

        $sql = "SELECT * FROM barang $where ORDER BY id_barang ASC";
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

    // Tambah barang (HANYA ke tabel barang).
    // Jika ingin otomatis membuat stok, lakukan dari controller atau panggil StokGudang model.
    public function insert($data) {
        $id_barang = $this->escape($data['id_barang']);
        $nama_barang = $this->escape($data['nama_barang']);
        $jenis_barang = $this->escape($data['jenis_barang']);
        $kadaluarsa_barang = $this->escape($data['kadaluarsa_barang']);

        $sql = "INSERT INTO barang (id_barang, nama_barang, jenis_barang, kadaluarsa_barang)
                VALUES ('$id_barang', '$nama_barang', '$jenis_barang', '$kadaluarsa_barang')";
        return $this->query($sql);
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
        return $this->query($sql);
    }

    // Hapus barang (tidak otomatis menghapus stok; hapus stok dilakukan jika memang diinginkan)
    public function delete($id_barang) {
        $id_barang = $this->escape($id_barang);
        // Hati-hati: jangan otomatis hapus stok jika kebijakan tidak ingin demikian.
        // Namun jika memang ingin menghapus stok terkait, uncomment baris di bawah.
        // $this->query("DELETE FROM stok_gudang WHERE id_barang = '$id_barang'");
        return $this->query("DELETE FROM barang WHERE id_barang = '$id_barang'");
    }
}
