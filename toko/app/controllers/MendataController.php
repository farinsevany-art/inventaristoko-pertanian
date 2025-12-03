<?php
require_once __DIR__ . '/../models/Mendata.php';

class MendataController {
    public function index() {
        $mendataModel = new Mendata();
        $mendataList = $mendataModel->getAll();
        include __DIR__ . '/../views/mendata/index.php';
    }
}
