<?php
require_once __DIR__ . "/Database.php";

class Ditempatkan extends Database {

    public function getAll($query = null) {
        return $this->query("SELECT * FROM ditempatkan")->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = $this->escape($id);
        return $this->query("SELECT * FROM ditempatkan WHERE id_ditempatkan = '$id'")->fetch_assoc();
    }

    public function generateNewId() {
        $res = $this->query("SELECT MAX(id_ditempatkan) AS last_id FROM ditempatkan");
        $row = $res->fetch_assoc();
        $lastId = $row['last_id'] ?? 'DP000';

        $maxAttempts = 100;
        $attempt = 0;
        $num = 0;

        if (preg_match('/^DP(\d+)$/', $lastId, $matches)) {
            $num = (int)$matches[1] + 1;
        } else {
            $num = 1;
        }

        do {
            $newId = 'DP' . str_pad($num, 3, '0', STR_PAD_LEFT);
            $check = $this->query("SELECT id_ditempatkan FROM ditempatkan WHERE id_ditempatkan = '$newId'");
            if ($check && $check->num_rows === 0) {
                return $newId;
            }
            $num++;
            $attempt++;
        } while ($attempt < $maxAttempts);

        throw new Exception("Gagal membuat ID unik untuk ditempatkan setelah $maxAttempts percobaan.");
    }

    public function insert($data) {
        $id = $this->escape($data['id_ditempatkan']);
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $tgl = $this->escape($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk = (int)$data['stok_etalase_masuk'];

        return $this->query(
            "INSERT INTO ditempatkan 
            (id_ditempatkan, id_stok_gudang, id_stok_etalase, tgl_penempatan, stok_gudang_keluar, stok_etalase_masuk) 
            VALUES ('$id', '$id_stok_gudang', '$id_stok_etalase', '$tgl', '$keluar', '$masuk')"
        );
    }

    public function update($id, $data) {
        $id_stok_gudang = $this->escape($data['id_stok_gudang']);
        $id_stok_etalase = $this->escape($data['id_stok_etalase']);
        $tgl = $this->escape($data['tgl_penempatan']);
        $keluar = (int)$data['stok_gudang_keluar'];
        $masuk = (int)$data['stok_etalase_masuk'];

        return $this->query(
            "UPDATE ditempatkan 
            SET id_stok_gudang='$id_stok_gudang', id_stok_etalase='$id_stok_etalase', 
                tgl_penempatan='$tgl', stok_gudang_keluar='$keluar', stok_etalase_masuk='$masuk'
            WHERE id_ditempatkan='$id'"
        );
    }

    public function delete($id) {
        $id = $this->escape($id);
        return $this->query("DELETE FROM ditempatkan WHERE id_ditempatkan='$id'");
    }
}
