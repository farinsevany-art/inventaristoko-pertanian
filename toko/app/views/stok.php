<?php include '../app/views/templates/header.php'; ?>

<div class="container mt-4">
   <h1>Manajemen Stok</h1>
   <p>Daftar stok gudang dan etalase. Gunakan tombol Edit / Hapus untuk memperbarui data (admin).</p>
   <p>
       <a class="btn btn-success" href="../crud/read_mendata.php">Kelola Pendataan (Gudang)</a>
       <a class="btn btn-info" href="../crud/read_ditempatkan.php">Kelola Penempatan (Etalase)</a>
   </p>

   <?php
   $allStok = [];
   if (!empty($stokGudang) && is_array($stokGudang)) {
         foreach ($stokGudang as $s) { $s['source'] = 'gudang'; $allStok[] = $s; }
   }
   if (!empty($stokEtalase) && is_array($stokEtalase)) {
         foreach ($stokEtalase as $s) { $s['source'] = 'etalase'; $allStok[] = $s; }
   }
   ?>

   <?php if (empty($allStok)) : ?>
      <div class="alert alert-info">Tidak ada data stok tersedia.</div>
   <?php else : ?>
      <table class="table table-striped">
         <thead>
            <tr>
               <th>no</th>
               <th>Nama Barang</th>
               <th>Jenis</th>
               <th>Kadaluarsa</th>
               <th>Lokasi</th>
               <th>Jumlah</th>
               <!-- <th>Aksi</th> -->
            </tr>
         </thead>
         <tbody>
            <?php foreach ($allStok as $i => $stok) :
               $id = isset($stok['id']) ? urlencode($stok['id']) : urlencode($stok['nama_barang']);
               $count = $stok['source'] === 'gudang' ? ($stok['total_stok_gudang'] ?? 0) : ($stok['total_stok_eta'] ?? 0);
            ?>
            <tr>
               <td><?= $i+1 ?></td>
               <td><?= htmlspecialchars($stok['nama_barang'] ?? '-') ?></td>
               <td><?= htmlspecialchars($stok['jenis_barang'] ?? '-') ?></td>
               <td><?= htmlspecialchars($stok['kadaluarsa_barang'] ?? '-') ?></td>
               <td><?= htmlspecialchars($stok['source']) ?></td>
               <td><?= htmlspecialchars($count) ?> pcs</td>
               <!-- <td>
                  <a class="btn btn-sm btn-primary" href="/crud/update.php?id=<?= $id ?>&source=<?= $stok['source'] ?>">Edit</a>
                  <a class="btn btn-sm btn-danger" href="/crud/delete.php?id=<?= $id ?>&source=<?= $stok['source'] ?>" onclick="return confirm('Hapus stok <?= addslashes($stok['nama_barang'] ?? '') ?> dari <?= $stok['source'] ?>?')">Hapus</a>
               </td> -->
            </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   <?php endif; ?>
<style>
.header_section {
  position: relative;
  z-index: 9999;
}
</style>

</div>

<?php include '../app/views/templates/footer.php'; ?>

