<?php
require_once __DIR__ . "/Database.php";

class StokGudang extends Database {

    // Get distinct jenis_barang for filter dropdown
    public function getDistinctJenisBarang() {
        return $this->query("SELECT DISTINCT jenis_barang FROM barang WHERE jenis_barang IS NOT NULL AND jenis_barang != ''")->fetch_all(MYSQLI_ASSOC);
    }

    // Get stok gudang data with optional filters for jenis_barang and date (day, month, year)
    public function getAll($filters = []) {
        $whereClauses = [];
        if (!empty($filters['jenis_barang'])) {
            $jenis_barang = $this->escape($filters['jenis_barang']);
            $whereClauses[] = "b.jenis_barang = '$jenis_barang'";
        }
        if (!empty($filters['day'])) {
            $day = (int)$filters['day'];
            $whereClauses[] = "DAY(b.kadaluarsa_barang) = $day";
        }
        if (!empty($filters['month'])) {
            $month = (int)$filters['month'];
            $whereClauses[] = "MONTH(b.kadaluarsa_barang) = $month";
        }
        if (!empty($filters['year'])) {
            $year = (int)$filters['year'];
            $whereClauses[] = "YEAR(b.kadaluarsa_barang) = $year";
        }

        $whereSQL = '';
        if (count($whereClauses) > 0) {
            $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
        }

    $sql = "SELECT sg.*, 
               b.nama_barang, 
               b.jenis_barang, 
               b.kadaluarsa_barang
        FROM stok_gudang sg
        LEFT JOIN barang b ON sg.id_barang = b.id_barang
        $whereSQL";

        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = $this->escape($id);
        $result = $this->query(
            "SELECT sg.*, 
                    b.nama_barang, 
                    b.jenis_barang, 
                    b.kadaluarsa_barang
             FROM stok_gudang sg
             LEFT JOIN barang b ON sg.id_barang = b.id_barang
             WHERE sg.id_stok_gudang = '$id'"
        );
        return $result->fetch_assoc();
    }
public function generateNewId() {
    $res = $this->query("SELECT MAX(id_stok_gudang) AS last_id FROM stok_gudang");
    $row = $res->fetch_assoc();
    $lastId = $row['last_id'] ?? 'SG000';

    $maxAttempts = 100;
    $attempt = 0;
    $num = 0;

    if (preg_match('/^SG(\d+)$/', $lastId, $matches)) {
        $num = (int)$matches[1] + 1;
    } else {
        $num = 1;
    }

    do {
        $newId = 'SG' . str_pad($num, 3, '0', STR_PAD_LEFT);
        $check = $this->query("SELECT id_stok_gudang FROM stok_gudang WHERE id_stok_gudang = '$newId'");
        if ($check && $check->num_rows === 0) {
            return $newId;
        }
        $num++;
        $attempt++;
    } while ($attempt < $maxAttempts);

    throw new Exception("Gagal membuat ID unik untuk stok gudang setelah $maxAttempts percobaan.");
}

    public function insert($data) {
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_barang = $this->escape($data['id_barang']);
        $total = (int)$data['total_stok_gudang'];
        return $this->query(
            "INSERT INTO stok_gudang (id_stok_gudang, id_barang, total_stok_gudang) 
             VALUES ('$id_stok_gudang', '$id_barang', '$total')"
        );
    }

    public function update($id, $data) {
        $id = $this->escape($id);
        $id_barang = $this->escape($data['id_barang']);
        $total = (int)$data['total_stok_gudang'];
        return $this->query(
            "UPDATE stok_gudang 
             SET id_barang='$id_barang', total_stok_gudang='$total'
             WHERE id_stok_gudang='$id'"
        );
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM stok_gudang WHERE id_stok_gudang='$id'");
    }
}