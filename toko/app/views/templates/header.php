<?php
$base_url = 'http://localhost/toko/public/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title>Inventaris Toko Pertanian</title>
   <link rel="stylesheet" type="text/css" href="<?= $base_url ?>css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="<?= $base_url ?>css/style.css">
   <link rel="stylesheet" href="<?= $base_url ?>css/responsive.css">
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
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>stok">Stok</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?= $base_url ?>home/contact">Kontak Kami</a></li>
               </ul>
               <form class="form-inline my-2 my-lg-0">
                  <div class="login_bt">
                     <a href="#">Login <span style="color:#222"><i class="fa fa-user" aria-hidden="true"></i></span></a>
                  </div>
                  <div class="fa fa-search form-control-feedback"></div>
               </form>
            </div>
         </nav>
      </div>
   </div>
