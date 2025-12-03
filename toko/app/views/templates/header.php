<?php
$base_url = 'http://localhost/toko/public/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
   <style>
.header_section {
  position: relative;
  z-index: 9999;
}
</style>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title>Inventaris Toko Pertanian</title>
   <link rel="stylesheet" type="text/css" href="<?= $base_url ?>css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $base_url ?>css/style.css">
   <link rel="stylesheet" href="<?= $base_url ?>css/responsive.css">
   <!-- Banner-specific styles (kept separate for clarity) -->
   <link rel="stylesheet" href="<?= $base_url ?>css/banner.css">
   <link rel="icon" href="<?= $base_url ?>images/fevicon.png" type="image/gif" />
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="<?= $base_url ?>css/jquery.mCustomScrollbar.min.css">
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
</head>
<body>

   <div class="header_section">
      <div class="container">
         <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= $base_url ?>home/index">
               <img src="<?= $base_url ?>images/logo.png" style="width: 40px; height: 40px; border-radius: 50%; opacity: 80%;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>home/index">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>home/about">Tentang</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>home/barang/index">Barang</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>?url=stoketalase/index">Stok Etalase</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>home/contact">Kontak Kami</a></li>
                  <?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
                  <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                      <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>?url=admin/index">Dashboard</a></li>
                  <?php endif; ?>
               </ul>
               <form class="form-inline my-2 my-lg-0">
                  <div class="login_bt">
                     <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                        <!-- Show karyawan name and logout -->
                        <span style="margin-right:12px; font-weight:600;"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
                        <a href="<?= $base_url ?>?url=admin/logout">Logout <span style="color:#222"><i class="fa fa-sign-out" aria-hidden="true"></i></span></a>
                     <?php else: ?>
                        <a href="<?= $base_url ?>?url=admin/login.php">Login <span style="color:#222"><i class="fa fa-user" aria-hidden="true"></i></span></a>
                     <?php endif; ?>
                  </div>
                  <!-- search icon removed per request -->
               </form>
            </div>
         </nav>
      </div>
   </div>
