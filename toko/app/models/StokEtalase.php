<?php
require_once __DIR__ . "/Database.php";

class StokEtalase extends Database {

    // Get distinct jenis_barang for filter dropdown
    public function getDistinctJenisBarang() {
        return $this->query("SELECT DISTINCT jenis_barang FROM barang WHERE jenis_barang IS NOT NULL AND jenis_barang != ''")->fetch_all(MYSQLI_ASSOC);
    }

    // Get stok etalase data with optional filters for jenis_barang and date (month and year)
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

        $sql = "SELECT se.*, 
                       sg.id_barang,
                       b.nama_barang, 
                       b.jenis_barang, 
                       b.kadaluarsa_barang
                FROM stok_etalase se
                LEFT JOIN ditempatkan d ON se.id_stok_etalase = d.id_stok_etalase
                LEFT JOIN stok_gudang sg ON d.id_stok_gudang = sg.id_stok_gudang
                LEFT JOIN barang b ON sg.id_barang = b.id_barang
                $whereSQL
                GROUP BY se.id_stok_etalase";

        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query(
            "SELECT se.*, 
                    sg.id_barang,
                    b.nama_barang, 
                    b.jenis_barang, 
                    b.kadaluarsa_barang
             FROM stok_etalase se
             LEFT JOIN ditempatkan d ON se.id_stok_etalase = d.id_stok_etalase
             LEFT JOIN stok_gudang sg ON d.id_stok_gudang = sg.id_stok_gudang
             LEFT JOIN barang b ON sg.id_barang = b.id_barang
             WHERE se.id_stok_etalase = '$id'"
        )->fetch_assoc();
    }
public function generateNewId() {
    $res = $this->query("SELECT MAX(id_stok_etalase) AS last_id FROM stok_etalase");
    $row = $res->fetch_assoc();
    $lastId = $row['last_id'] ?? 'SE000';

    $maxAttempts = 100;
    $attempt = 0;
    $num = 0;

    if (preg_match('/^SE(\d+)$/', $lastId, $matches)) {
        $num = (int)$matches[1] + 1;
    } else {
        $num = 1;
    }

    do {
        $newId = 'SE' . str_pad($num, 3, '0', STR_PAD_LEFT);
        $check = $this->query("SELECT id_stok_etalase FROM stok_etalase WHERE id_stok_etalase = '$newId'");
        if ($check && $check->num_rows === 0) {
            return $newId;
        }
        $num++;
        $attempt++;
    } while ($attempt < $maxAttempts);

    throw new Exception("Gagal membuat ID unik untuk stok etalase setelah $maxAttempts percobaan.");
}

    public function insert($data) {
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $total = (int)$data['total_stok_eta'];
        return $this->query("INSERT INTO stok_etalase (id_stok_etalase, total_stok_eta) VALUES ('$id_stok_etalase', '$total')");
    }

    public function update($id, $data) {
        $id = $this->escape($id);
        $total = (int)$data['total_stok_eta'];
        return $this->query("UPDATE stok_etalase SET total_stok_eta='$total' WHERE id_stok_etalase='$id'");
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM stok_etalase WHERE id_stok_etalase='$id'");
    }

    // Method khusus untuk mendapatkan etalase berdasarkan barang
    public function getByBarang($id_barang) {
        $id_barang = $this->escape($id_barang);
        return $this->query(
            "SELECT se.*, 
                    sg.id_barang,
                    b.nama_barang, 
                    b.jenis_barang, 
                    b.kadaluarsa_barang
             FROM stok_etalase se
             LEFT JOIN ditempatkan d ON se.id_stok_etalase = d.id_stok_etalase
             LEFT JOIN stok_gudang sg ON d.id_stok_gudang = sg.id_stok_gudang
             LEFT JOIN barang b ON sg.id_barang = b.id_barang
             WHERE sg.id_barang = '$id_barang'
             AND b.nama_barang IS NOT NULL AND b.nama_barang != '-'
             GROUP BY se.id_stok_etalase"
        )->fetch_all(MYSQLI_ASSOC);
    }
}
