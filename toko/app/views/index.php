<?php include '../app/views/templates/header.php';?>
         <!-- banner section start --> 
         <div class="banner_section layout_padding">
            <div class="container">
               <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-sm-6">
                              <h1 class="banner_taital" id="awal">Toko Petanian</h1>
                              <p class="banner_text"></p>
                              <div class="started_text"><a href="#barang">Lihat Barang</a></div>
                           </div>
                           <div class="col-sm-6">
                              <div class="banner_img"><img src="<?= $base_url ?>images/banner-img.jpg" style="width: 500px; height: 400px;"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- banner section end -->
      </div>
      <!-- header section end -->
      <!-- about sectuion start -->
      <div class="about_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="about_img"><img src="<?= $base_url ?>images/tentan.jpg" style="width: 500px; height: 400px;"></div>
               </div>
               <div class="col-md-6">
                  <h2 class="about_taital" id="tentang">Tentang Toko Pertanian Mbah Meth</h2>
                  <p class="about_text">Toko Pertanian Mbah meth ini berdiri sejak tahun 2021 ,   yang bertempat di Desa Malangsari, Kecamatan Tanjunganom, Kabupaten Nganjuk, Kami menyediakan berbagai  kebutuhan pertanian seperti pestisida, pupuk, mulsa, obat- obatan dan berbagai bibit tanaman seperti benih padi , jagung, cabai, dll.</p>
                  <div class="read_bt_1"><a href="#barang">Lihat Barang</a></div>
               </div>
            </div>
         </div>
      </div>
      <!-- about sectuion end -->
      <!-- cream sectuion start -->
      <div class="cream_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <h1 class="cream_taital" id="barang">BERIKUT CONTOH PRODUK KAMI</h1>
                  <p class="cream_text">terdapat berbagai macam stok produk yang kami jual</p>
               </div>
            </div>
            <div class="cream_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align : center;">
                        <div class="cream_img"><img src="<?= $base_url ?>images/Arrivo 100 ml.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">10</div> -->
                        <h6 class="strawberry_text">Arrivo</h6>
                        <a class="strawberry_text">Insektisida Arrivo<a>
                           <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                        </div>
                     </div>
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align: center;">
                        <div class="cream_img">
                           <img src="<?= $base_url ?>images/Arjuna 100 ml.jpeg" style="width: 170px; height: 210px;">
                        </div>
                        <h6 class="strawberry_text">Arjuna</h6>
                        <a class="strawberry_text">Insektisida Arjuna</a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align : center;">
                        <div class="cream_img"><img src="<?= $base_url ?>images/Ares 100 ml.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">Ares</h6>
                        <a class="strawberry_text">Insektisida Ares</a>
                        <!-- <div class="cart_bt"><a href="#"></a></div> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="cream_section_2">
               <div class="row">
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align : center;">
                        <div class="cream_img"><img src="<?= $base_url ?>images/KNO Merah.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">KNO Merah</h6>
                        <a class="strawberry_text">Pupuk KNO Merah</a>
                        <!-- <div class="cart_bt"><a href="#">Pupuk KNO Merah</a></div> -->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align : center;">
                        <div class="cream_img"><img src="<?= $base_url ?>images/KCL Mahkota.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">KCL Mahkota</h6>
                        <a class="strawberry_text">Pupuk KCL Mahkota</a>
                        <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box" style="text-align : center;">
                        <div class="cream_img"><img src="<?= $base_url ?>images/KNO Putih.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">KNO Putih</h6>
                        <a class="strawberry_text">Pupuk KNO Putih</a>
                        <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="seemore_bt"><a href="#awal">Kembali</a></div>
         </div>
      </div>
      <!-- cream sectuion end -->
      <?php include '../app/views/templates/footer.php'; ?>

