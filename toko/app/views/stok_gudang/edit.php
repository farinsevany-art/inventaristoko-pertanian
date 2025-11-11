<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Stok Gudang</h2>
    <form method="post" action="?url=stokgudang/update/<?= urlencode($stok['id_stok_gudang']) ?>">
        <div class="form-group">
            <label>ID Stok Gudang</label>
            <input class="form-control" name="id_stok_gudang" value="<?= htmlspecialchars($stok['id_stok_gudang']) ?>" readonly />
        </div>
        <div class="form-group">
            <label>ID Barang</label>
            <input class="form-control" name="id_barang" value="<?= htmlspecialchars($stok['id_barang']) ?>" readonly />
        </div>
        <div class="form-group">
            <label>Total</label>
            <input class="form-control" name="total_stok_gudang" type="number" min="0" value="<?= htmlspecialchars($stok['total_stok_gudang']) ?>" required />
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="?url=stokgudang/index">Batal</a>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
