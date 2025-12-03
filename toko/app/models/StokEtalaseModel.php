<?php
require_once 'Database.php';

class StokEtalaseModel extends Database {
public function getAllStokEtalase($filters = []) {
    $conditions = [];

    if (!empty($filters['nama_barang'])) {
        $nama_barang = $this->conn->real_escape_string($filters['nama_barang']);
        $conditions[] = "b.nama_barang LIKE '%$nama_barang%'";
    }
    if (!empty($filters['jenis_barang'])) {
        $jenis_barang = $this->conn->real_escape_string($filters['jenis_barang']);
        $conditions[] = "b.jenis_barang LIKE '%$jenis_barang%'";
    }
    if (!empty($filters['kadaluarsa_barang'])) {
        $kadaluarsa_barang = $this->conn->real_escape_string($filters['kadaluarsa_barang']);
        $conditions[] = "b.kadaluarsa_barang = '$kadaluarsa_barang'";
    }

    $where = '';
    if (count($conditions) > 0) {
        $where = 'WHERE ' . implode(' AND ', $conditions);
    }

    $query = "
        SELECT se.*, 
               sg.id_barang,
               b.nama_barang, 
               b.jenis_barang,
               b.kadaluarsa_barang
        FROM stok_etalase se
        LEFT JOIN ditempatkan d ON d.id_stok_etalase = se.id_stok_etalase
        LEFT JOIN stok_gudang sg ON sg.id_stok_gudang = d.id_stok_gudang
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        $where
    ";
    return $this->getAll($query);
}


    public function getStokEtalaseById($id) {
        return $this->getOne("SELECT * FROM stok_etalase WHERE id_stok_etalase = '$id'");
    }

    public function tambahStokEtalase($data) {
        $id     = $this->conn->real_escape_string($data['id_stok_etalase']);
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_eta']);
        $total  = (int)$data['total_stok_eta'];

        $query = "INSERT INTO stok_etalase 
                  (id_stok_etalase, nama_barang, jenis_barang, kadaluarsa_barang, tgl_update_eta, total_stok_eta)
                  VALUES ('$id', '$nama', '$jenis', '$kadaluarsa', '$tgl_update', $total)";
        return $this->execute($query);
    }

    public function updateStokEtalase($id, $data) {
        $nama   = $this->conn->real_escape_string($data['nama_barang']);
        $jenis  = $this->conn->real_escape_string($data['jenis_barang']);
        $kadaluarsa = $this->conn->real_escape_string($data['kadaluarsa_barang']);
        $tgl_update = $this->conn->real_escape_string($data['tgl_update_eta']);
        $total  = (int)$data['total_stok_eta'];

        $query = "UPDATE stok_etalase SET
                    nama_barang='$nama',
                    jenis_barang='$jenis',
                    kadaluarsa_barang='$kadaluarsa',
                    tgl_update_eta='$tgl_update',
                    total_stok_eta=$total
                  WHERE id_stok_etalase='$id'";
        return $this->execute($query);
    }

    public function hapusStokEtalase($id) {
        return $this->execute("DELETE FROM stok_etalase WHERE id_stok_etalase='$id'");
    }
    public function getTotalStok() {
    return $this->getOne("SELECT SUM(total_stok_eta) AS total FROM stok_etalase");
}

public function getLowStock() {
    return $this->getAll("
        SELECT se.*, 
               sg.id_barang,
               b.nama_barang
        FROM stok_etalase se
        LEFT JOIN ditempatkan d ON d.id_stok_etalase = se.id_stok_etalase
        LEFT JOIN stok_gudang sg ON sg.id_stok_gudang = d.id_stok_gudang
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        WHERE se.total_stok_eta > 0
        AND se.total_stok_eta <= 5
        ORDER BY se.total_stok_eta ASC
    ");
}

public function getZeroStock() {
    return $this->getAll("
        SELECT se.*, 
               sg.id_barang,
               b.nama_barang
        FROM stok_etalase se
        LEFT JOIN ditempatkan d ON d.id_stok_etalase = se.id_stok_etalase
        LEFT JOIN stok_gudang sg ON sg.id_stok_gudang = d.id_stok_gudang
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        WHERE se.total_stok_eta = 0
    ");
}

public function getMaxStock() {
    return $this->getAll("
        SELECT se.*, 
               sg.id_barang,
               b.nama_barang
        FROM stok_etalase se
        LEFT JOIN ditempatkan d ON d.id_stok_etalase = se.id_stok_etalase
        LEFT JOIN stok_gudang sg ON sg.id_stok_gudang = d.id_stok_gudang
        LEFT JOIN barang b ON b.id_barang = sg.id_barang
        ORDER BY se.total_stok_eta DESC
        LIMIT 5
    ");
}


}
