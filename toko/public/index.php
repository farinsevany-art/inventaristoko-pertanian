<?php
// ======================================================
// FRONT CONTROLLER
// ======================================================

// --- Aktifkan session (untuk login admin & user)
session_start();

// --- Error reporting (matikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Path dasar project
define('BASE_PATH', dirname(__DIR__));

// --- Fungsi helper untuk load halaman error
function showErrorPage($code = 404) {
    $errorFile = BASE_PATH . "/admin/{$code}.html";
    if (file_exists($errorFile)) {
        http_response_code($code);
        include $errorFile;
    } else {
        http_response_code($code);
        echo "<h3 style='color:red;'>Error $code: Halaman tidak ditemukan.</h3>";
    }
    exit;
}

// --- Ambil parameter URL (misal: ?url=barang/create)
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL));

// --- Tentukan controller & method
$controllerName = ucfirst($url[0]) . 'Controller';
$method = isset($url[1]) ? $url[1] : 'index';

// --- Path file controller
$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

//  stok/low, stok/habis, stok/max
if ($url[0] === "stok") {
    $controllerName = "StokController";
    $controllerFile = BASE_PATH . '/app/controllers/StokController.php';
}

// --- Cek apakah file controller ada
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Cek apakah class controller ada
    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        // Cek apakah method-nya ada
        if (method_exists($controller, $method)) {
            $params = array_slice($url, 2);
            call_user_func_array([$controller, $method], $params);
        } else {
            showErrorPage(404);
        }
    } else {
        echo "<h3 style='color:red;'>Error: Class $controllerName tidak ditemukan di $controllerFile</h3>";
    }
} else {
    showErrorPage(404);
}

