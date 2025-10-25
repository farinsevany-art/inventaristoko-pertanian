<!DOCTYPE html>
<html>
<?php include '../app/views/templates/header.php'; ?>

<!-- STOK GUDANG -->
<div class="cream_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h1 class="cream_taital">Stok Gudang</h1>
         </div>
      </div>

      <div class="cream_section_2">
         <div class="row">
            <?php if (!empty($stokGudang)) : ?>
               <?php foreach ($stokGudang as $stok) : ?>
                  <div class="col-md-4 mb-4">
                     <div class="cream_box">
                        <div class="cream_img">
                           <?php 
                              $imgFile = strtolower($stok['nama_barang']) . '.jpeg';
                              $imgPath = 'images/' . (file_exists(__DIR__ . '/../../public/images/' . $imgFile) ? $imgFile : 'default.png');
                           ?>
                           <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($stok['nama_barang']) ?>">
                        </div>
                        <div class="price_text"><?= htmlspecialchars($stok['total_stok_gudang']) ?> pcs</div>
                        <h6 class="strawberry_text"><?= htmlspecialchars($stok['nama_barang']) ?></h6>
                        <p class="lorem_text">Jenis: <?= htmlspecialchars($stok['jenis_barang']) ?><br>
                           Kadaluarsa: <?= htmlspecialchars($stok['kadaluarsa_barang']) ?>
                        </p>
                        <div class="cart_bt"><a href="#">Edit Stok</a></div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php else : ?>
               <div class="col-md-12"><p>Tidak ada data stok gudang ditemukan.</p></div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</div>

<!-- STOK ETALASE -->
<div class="cream_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h1 class="cream_taital">Stok Etalase</h1>
         </div>
      </div>

      <div class="cream_section_2">
         <div class="row">
            <?php if (!empty($stokEtalase)) : ?>
               <?php foreach ($stokEtalase as $stok) : ?>
                  <div class="col-md-4 mb-4">
                     <div class="cream_box">
                        <div class="cream_img">
                           <?php 
                              $imgFile = strtolower($stok['nama_barang']) . '.jpeg';
                              $imgPath = 'images/' . (file_exists(__DIR__ . '/../../public/images/' . $imgFile) ? $imgFile : 'default.png');
                           ?>
                           <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($stok['nama_barang']) ?>">
                        </div>
                        <div class="price_text"><?= htmlspecialchars($stok['total_stok_eta']) ?> pcs</div>
                        <h6 class="strawberry_text"><?= htmlspecialchars($stok['nama_barang']) ?></h6>
                        <p class="lorem_text">Jenis: <?= htmlspecialchars($stok['jenis_barang']) ?><br>
                           Kadaluarsa: <?= htmlspecialchars($stok['kadaluarsa_barang']) ?>
                        </p>
                        <div class="cart_bt"><a href="#">Edit Stok</a></div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php else : ?>
               <div class="col-md-12"><p>Tidak ada data stok etalase ditemukan.</p></div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</div>

<?php include '../app/views/templates/footer.php'; ?>
</html>
