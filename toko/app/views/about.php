<!DOCTYPE html>
<html>

   <body>
<?php include '../app/views/templates/header.php';?>

     <!-- about sectuion start -->
     <div class="about_section layout_padding">
       <div class="container">
         <div class="row">
            <div class="col-md-6">
              <div class="about_img"><img src="<?= $base_url ?>images/banner-img.jpg" style="width: 500px; height: 400px; padding:20px;"></div>
            </div>
            <div class="col-md-6">
              <h1 class="about_taital">Tentang Toko Pertanian Mbah Meth</h1>
              <p class="about_text">Toko Pertanian Mbah meth ini berdiri sejak tahun 2021 ,   yang bertempat di Desa Malangsari, Kecamatan Tanjunganom, Kabupaten Nganjuk, Kami menyediakan berbagai  kebutuhan pertanian seperti pestisida, pupuk, mulsa, obat- obatan dan berbagai bibit tanaman seperti benih padi , jagung, cabai, dll.</p>

              <?php
              // Calculate totals from provided arrays (if available)
              $totalGudang = 0;
              $totalEtalase = 0;
              if (!empty($stokGudang) && is_array($stokGudang)) {
                 foreach ($stokGudang as $s) {
                    $totalGudang += intval($s['total_stok_gudang'] ?? 0);
                 }
              } elseif (isset($totalGudang)) {
                 $totalGudang = intval($totalGudang);
              }
              if (!empty($stokEtalase) && is_array($stokEtalase)) {
                 foreach ($stokEtalase as $s) {
                    $totalEtalase += intval($s['total_stok_eta'] ?? 0);
                 }
              } elseif (isset($totalEtalase)) {
                 $totalEtalase = intval($totalEtalase);
              }
              $grandTotal = $totalGudang + $totalEtalase;
              ?>

              <div class="mt-3">
               <h5>Stok Tersedia</h5>
               <ul>
                 <li>Stok Gudang: <strong><?= htmlspecialchars($totalGudang) ?> pcs</strong></li>
                 <li>Stok Etalase: <strong><?= htmlspecialchars($totalEtalase) ?> pcs</strong></li>
                 <li>Total Stok: <strong><?= htmlspecialchars($grandTotal) ?> pcs</strong></li>
               </ul>
              </div>

              <div class="read_bt_1"><a href="#">Read More</a></div>
            </div>
         </div>
       </div>
     </div>
     <!-- about sectuion end -->
      <?php include '../app/views/templates/footer.php'; ?>

   </body>

</html>

