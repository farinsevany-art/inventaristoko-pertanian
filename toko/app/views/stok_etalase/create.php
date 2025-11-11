<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Tambah Stok Etalase</h2>
    <form method="post" action="?url=stoketalase/store">
        <!-- ID Stok Etalase will be generated automatically -->
        <div class="form-group">
            <label>Total</label>
            <input class="form-control" name="total_stok_eta" type="number" min="0" required />
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="?url=stoketalase/index">Batal</a>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
