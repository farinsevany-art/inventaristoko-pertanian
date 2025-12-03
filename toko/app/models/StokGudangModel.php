<?php
require_once 'Database.php';

class StokGudangModel extends Database {

    public function getAllStokGudang($filters = []) {
        $conditions = [];

        if (!empty($filters['nama_barang'])) {
            $nama_barang = $this->conn->real_escape_string($filters['nama_barang']);
            $conditions[] = "sg.nama_barang LIKE '%$nama_barang%'";
        }
        if (!empty($filters['jenis_barang'])) {
            $jenis_barang = $this->conn->real_escape_string($filters['jenis_barang']);
            $conditions[] = "sg.jenis_barang LIKE '%$jenis_barang%'";
        }
        if (!empty($filters['kadaluarsa_barang'])) {
            $kadaluarsa_barang = $this->conn->real_escape_string($filters['kadaluarsa_barang']);
            $conditions[] = "sg.kadaluarsa_barang = '$kadaluarsa_barang'";
        }

        $where = '';
        if (count($conditions) > 0) {
            $where = 'WHERE ' . implode(' AND ', $conditions);
        }

        $query = "
        SELECT sg.*, b.nama_barang
        FROM stok_gudang sg
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        $where
        ORDER BY sg.id_stok_gudang ASC
        ";

        return $this->getAll($query);
    }

    public function getStokGudangById($id) {
        return $this->getOne("SELECT * FROM stok_gudang WHERE id_stok_gudang = '$id'");
    }

    public function tambahStokGudang($data) {
        $id     = $this->conn->real_escape_string($data['id_stok_gudang']);
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_gud']);
        $total  = (int)$data['total_stok_gudang'];

        $query = "INSERT INTO stok_gudang
                  (id_stok_gudang, nama_barang, jenis_barang, kadaluarsa_barang, tgl_update_gud, total_stok_gudang)
                  VALUES ('$id', '$nama', '$jenis', '$kadaluarsa', '$tgl_update', $total)";
        return $this->execute($query);
    }

    public function updateStokGudang($id, $data) {
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_gud']);
        $total  = (int)$data['total_stok_gudang'];

        $query = "UPDATE stok_gudang SET
                    nama_barang='$nama',
                    jenis_barang='$jenis',
                    kadaluarsa_barang='$kadaluarsa',
                    tgl_update_gud='$tgl_update',
                    total_stok_gudang=$total
                  WHERE id_stok_gudang='$id'";
        return $this->execute($query);
    }

    public function hapusStokGudang($id) {
        return $this->execute("DELETE FROM stok_gudang WHERE id_stok_gudang='$id'");
    }
    
public function getTotalStok() {
    return $this->getOne("SELECT SUM(total_stok_gudang) AS total FROM stok_gudang");
}

public function getLowStock() {
    return $this->getAll("
        SELECT sg.*, b.nama_barang 
        FROM stok_gudang sg
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        WHERE sg.total_stok_gudang > 0 
        AND sg.total_stok_gudang <= 5
        ORDER BY sg.total_stok_gudang ASC
    ");
}

public function getZeroStock() {
    return $this->getAll("
        SELECT sg.*, b.nama_barang 
        FROM stok_gudang sg
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        WHERE sg.total_stok_gudang = 0
    ");
}

public function getMaxStock() {
    return $this->getAll("
        SELECT sg.*, b.nama_barang 
        FROM stok_gudang sg
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        ORDER BY sg.total_stok_gudang DESC
        LIMIT 5
    ");
}

}
