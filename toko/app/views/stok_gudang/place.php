<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Tempatkan Stok ke Etalase</h2>

    <?php if (empty($stok)) : ?>
        <div class="alert alert-danger">Stok tidak ditemukan.</div>
    <?php else : ?>
        <form method="post" action="?url=stokgudang/placeStore">
            <input type="hidden" name="id_stok_gudang" value="<?= htmlspecialchars($stok['id_stok_gudang']) ?>">
            <div class="form-group">
                <label>Pilih Etalase</label>
                <?php if (empty($etalases)) : ?>
                    <div class="alert alert-warning">Tidak ada etalase yang cocok untuk barang ini.</div>
                    <input type="hidden" name="buat_etalase_baru" value="1">
                    <button type="submit" class="btn btn-info mb-3">Buat Etalase Baru & Tempatkan</button>
                <?php else : ?>
                    <select name="id_stok_etalase" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($etalases as $e) : ?>
                            <option value="<?= htmlspecialchars($e['id_stok_etalase']) ?>">
                                <?= htmlspecialchars($e['id_stok_etalase'] . ' - ' . ($e['nama_barang'] ?? '-') . ' | ' . ($e['jenis_barang'] ?? '-') . ' | ' . ($e['kadaluarsa_barang'] ?? '-')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Jumlah yang dipindah</label>
                <input type="number" name="stok_gudang_keluar" class="form-control" min="1" max="<?= htmlspecialchars($stok['total_stok_gudang']) ?>" value="1" required>
                <!-- <small class="form-text text-muted">Jika membuat etalase baru, jumlah ini akan menjadi stok awal etalase.</small> -->
            </div>
            <input type="hidden" name="tgl_penempatan" value="<?= date('Y-m-d') ?>">
            <button class="btn btn-primary">Simpan Penempatan</button>
            <a class="btn btn-secondary" href="?url=stokgudang/index">Batal</a>
        </form>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
