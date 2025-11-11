<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Edit Stok Etalase</h2>
    <form method="post" action="?url=stoketalase/update/<?= urlencode($stok['id_stok_etalase']) ?>">
        <div class="form-group">
            <label>ID Stok Etalase</label>
            <input class="form-control" name="id_stok_etalase" value="<?= htmlspecialchars($stok['id_stok_etalase']) ?>" readonly />
        </div>
        <div class="form-group">
            <label>Total</label>
            <input class="form-control" name="total_stok_eta" type="number" min="0" value="<?= htmlspecialchars($stok['total_stok_eta']) ?>" required />
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="?url=stoketalase/index">Batal</a>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
