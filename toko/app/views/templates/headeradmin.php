<?php
$base_url = 'http://localhost/toko/public/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard Admin</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?= $base_url ?>../app/views/admin/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

<style>
    /* ensure navbar dropdown remains clickable: keep sidebar z-index lower than topnav */
    #layoutSidenav_nav {
        z-index: 1040; /* lower than topnav */
    }
    .sb-topnav {
        z-index: 1050; /* keep topnav above the sidebar */
    }
    /* ensure dropdown menu appears above everything */
    .dropdown-menu {
        z-index: 99999 !important;
    }

    /* default sidebar SB Admin */
    @media (max-width: 768px) {
        #layoutSidenav_nav {
            position: fixed;
            left: -250px;
            height: 100%;
            transition: left 0.3s ease;
        }
        .sb-sidenav-toggled #layoutSidenav_nav {
            left: 0 !important;
        }
    }
</style>
</head>

<body class="sb-nav-fixed">

    <!-- NAVBAR -->
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- LOGO -->
        <a class="navbar-brand ps-3" href="<?= $base_url ?>?url=admin/index">Admin Panel</a>
        <!-- TOGGLE SIDEBAR -->
        <button class="btn btn-link btn-sm me-4" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

    <!-- SEARCH removed per request -->

    <!-- USER MENU -->
    <ul class="navbar-nav ms-auto me-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg class="svg-inline--fa fa-user fa-fw" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>
                    <span><?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="<?= $base_url ?>?url=admin/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- SIDEBAR WRAPPER -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">

            <!-- SIDEBAR -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <a class="navbar-brand ps-3" href="<?= $base_url ?>?url=admin/index">Admin Panel</a>
                <div class="sb-sidenav-menu">

                    <div class="nav">

                        <div class="sb-sidenav-menu-heading">Core</div>

                        <a class="nav-link" href="<?= $base_url ?>?url=admin/index">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Interface</div>

                        <!-- MANAGEMENT STOK -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#menuStok">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            Management Stok
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="menuStok">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= $base_url ?>?url=stokgudang/index">Stok Gudang</a>
                                <a class="nav-link" href="<?= $base_url ?>?url=stoketalase/index">Stok Etalase</a>
                            </nav>
                        </div>

                        <!-- LIST BARANG -->
                        <a class="nav-link" href="<?= $base_url ?>?url=barang/index">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>List Barang
                        </a>

                        <!-- LANDING PAGE -->
                        <a class="nav-link" href="<?= $base_url ?>?url=home/index">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>Landing Page
                        </a>

                        <div class="sb-sidenav-menu-heading">Log</div>

                        <a class="nav-link" href="<?= $base_url ?>?url=ditempatkan/index">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>Penempatan
                        </a>

                        <a class="nav-link" href="<?= $base_url ?>?url=admin/mendata">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>Pendataan
                        </a>

                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                        <?= htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                </div>
            </nav>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2" crossorigin="anonymous"></script>

<script>
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.body.classList.toggle('sb-sidenav-toggled');
    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        const brand = document.getElementById("brandText");

});
</script>
<script>
// Ensure the navbar user dropdown reliably toggles when clicked
document.addEventListener('DOMContentLoaded', function () {
    var userToggle = document.getElementById('navbarDropdown');
    if (!userToggle) return;
    try {
        userToggle.addEventListener('click', function (e) {
            e.preventDefault();
            // Use Bootstrap's Dropdown API to toggle explicitly
            var bs = bootstrap.Dropdown.getInstance(userToggle) || new bootstrap.Dropdown(userToggle);
            bs.toggle();
        });
    } catch (err) {
        console.error('Dropdown toggle init error', err);
    }
});
</script>
