<?php
// index.php versi rapi & responsif
include '../app/views/templates/header.php';
$base = $base_url;
?>

<!-- Banner Section -->
<div class="banner_section banner--tight position-relative">
    <div id="bannerCarousel" class="carousel slide" data-ride="carousel" data-interval="4500">

        <ol class="carousel-indicators">
            <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#bannerCarousel" data-slide-to="1"></li>
            <li data-target="#bannerCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image: url('<?= $base ?>images/agriculture.jpg');">
                <div class="overlay"></div>
                <div class="container slide-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-7 col-12 text-area">
                            <h1 class="banner_taital" style="font-size:62px;">Toko Pertanian</h1>
                            <p class="banner_text" style="font-size:22px;">Penyedia peralatan pertanian lengkap dan berkualitas</p>
                            <a href="#barang" class="btn-slide">Lihat Barang</a>
                        </div>
                        <div class="col-lg-6 col-md-5 col-12">
                            <div class="banner_img"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image: url('<?= $base ?>images/banner2.png');">
                <div class="overlay"></div>
                <div class="container slide-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-7 col-12 text-area">
                            <h1 class="banner_taital" style="font-size:62px;">Toko Pertanian</h1>
                            <p class="banner_text" style="font-size:22px;">Penyedia peralatan pertanian lengkap dan berkualitas</p>
                            <a href="#barang" class="btn-slide">Lihat Barang</a>
                        </div>
                        <div class="col-lg-6 col-md-5 col-12">
                            <div class="banner_img"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image: url('<?= $base ?>images/banner3.jpg');">
                <div class="overlay"></div>
                <div class="container slide-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-7 col-12 text-area">
                            <h1 class="banner_taital" style="font-size:62px;">Toko Pertanian</h1>
                            <p class="banner_text" style="font-size:22px;">Penyedia peralatan pertanian lengkap dan berkualitas</p>
                            <a href="#barang" class="btn-slide">Lihat Barang</a>
                        </div>
                        <div class="col-lg-6 col-md-5 col-12">
                            <div class="banner_img"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- About Section -->
<section class="about_section py-5" id="tentang">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0">
                <img src="<?= $base ?>images/tentan.jpg" class="img-fluid rounded shadow" alt="Tentang Kami">
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <h2 class="about_taital fw-bold mb-3">Tentang Toko Pertanian Mbah Meth</h2>
                <p class="about_text">Toko Pertanian Mbah Meth berdiri sejak tahun 2021 di Desa Malangsari, Kecamatan Tanjunganom, Kabupaten Nganjuk. Kami menyediakan pestisida, pupuk, mulsa, obat-obatan, serta berbagai bibit tanaman seperti padi, jagung, cabai, dan lainnya.</p>
                <a href="#barang" class="btn btn-success mt-2">Lihat Barang</a>
            </div>
        </div>
    </div>
</section>

<!-- Produk Section -->
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
</section>

<?php include '../app/views/templates/footer.php'; ?>
