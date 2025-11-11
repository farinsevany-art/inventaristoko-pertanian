<?php include __DIR__ . '/../templates/header.php'; ?>
<div class="container mt-4">
    <h2>Tambah Barang</h2>
    <form method="post" action="?url=barang/store">
        <div class="form-group">
            <label>Nama Barang</label>
            <input class="form-control" name="nama_barang" required />
        </div>
        <div class="form-group">
            <label>Jenis Barang</label>
            <input class="form-control" name="jenis_barang" required />
        </div>
        <div class="form-group">
            <label>Kadaluarsa Barang</label>
            <input type="date" class="form-control" name="kadaluarsa_barang" required />
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="?url=barang/index">Batal</a>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>