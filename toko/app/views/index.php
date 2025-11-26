<?php include '../app/views/templates/header.php';?>

<!-- Banner Section Start -->
<div class="banner_section layout_padding position-relative" 
     style="
        background-image: url('<?= $base_url ?>images/agriculture.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 120px 0;
     ">

    <!-- Overlay -->
    <div style="
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    "></div>

    <div class="container position-relative" style="z-index: 2;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="row align-items-center">

                        <!-- Text Section -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4 mb-md-0">
                            <h1 class="banner_taital" id="awal"
                                style="color: #fff; font-size: 42px; font-weight: 700;">
                                Toko Pertanian
                            </h1>

                            <p class="banner_text"
                               style="color: #f1f1f1; font-size: 18px; margin-bottom: 25px;">
                               Penyedia peralatan pertanian lengkap dan berkualitas
                            </p>

                            <a href="#barang"
                               style="
                                  display: inline-block;
                                  background: #28a745;
                                  padding: 12px 25px;
                                  color: #fff;
                                  font-weight: 600;
                                  border-radius: 6px;
                                  text-decoration: none;
                                  transition: 0.3s;
                               "
                               onmouseover="this.style.background='#218838'"
                               onmouseout="this.style.background='#28a745'">
                               Lihat Barang
                            </a>
                        </div>

                        <!-- Image Section -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="banner_img mx-auto"
                                 style="
                                    width: 100%;
                                    max-width: 420px;
                                    background-image: url('<?= $base_url ?>images/tractor.png');
                                    background-size: contain;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    /* animation: fadeInRight 1.4s; */
                                 ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animation CSS -->
<style>
@keyframes fadeInDown {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}
@keyframes fadeInUp {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}
@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}
@keyframes fadeInRight {
    from {opacity: 0; transform: translateX(40px);}
    to {opacity: 1; transform: translateX(0);}
}

/* RESPONSIVE FIXES */
@media (max-width: 768px) {
    .banner_section {
        padding: 80px 0;
    }

    /* Tetap kiri di mobile */
    .banner_taital,
    .banner_text {
        text-align: left !important;
    }

    /* Tombol tetap kiri */
    a[href="#barang"] {
        display: inline-block !important;
        margin-left: 0 !important;
        text-align: left !important;
    }
}

@media (max-width: 480px) {
    .banner_taital {
        font-size: 28px !important;
    }
    .banner_text {
        font-size: 16px !important;
    }
}

</style>
</div>
<!-- banner section end -->
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
                     <div class="cream_box">
                        <div class="cream_img"><img src="<?= $base_url ?>images/Arrivo 100 ml.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">10</div> -->
                        <h6 class="strawberry_text">Arrivo</h6>
                        <a class="strawberry_text">Insektisida Arrivo<a>
                           <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="cream_box">
                           <div class="cream_img"><img src="<?= $base_url ?>images/Arjuna 100 ml.jpeg" style="width: 170px; height: 210px;"></div>
                           <!-- <div class="price_text">$10</div> -->
                           <h6 class="strawberry_text">Arjuna</h6>
                        <a class="strawberry_text">Insektisida Arjuna</a>
                        <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
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
                     <div class="cream_box">
                        <div class="cream_img"><img src="<?= $base_url ?>images/KNO Merah.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">KNO Merah</h6>
                        <a class="strawberry_text">Pupuk KNO Merah</a>
                        <!-- <div class="cart_bt"><a href="#">Pupuk KNO Merah</a></div> -->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
                        <div class="cream_img"><img src="<?= $base_url ?>images/KCL Mahkota.jpeg" style="width: 170px; height: 210px;"></div>
                        <!-- <div class="price_text">$10</div> -->
                        <h6 class="strawberry_text">KCL Mahkota</h6>
                        <a class="strawberry_text">Pupuk KCL Mahkota</a>
                        <!-- <div class="cart_bt"><a href="#">Add To Cart</a></div> -->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="cream_box">
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

