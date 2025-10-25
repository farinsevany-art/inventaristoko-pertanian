<?php
class HomeController {
    public function index() {
        require '../app/views/index.php';
    }

    public function about() {
        require '../app/views/about.php';
    }

    public function contact() {
        require '../app/views/contact.php';
    }

    public function stok() {
        require '../app/views/stok.php';
    }
}