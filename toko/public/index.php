<?php
/*require_once '../system/core.php';

$core = new Core();
$core->run();*/


// --- Error reporting (bisa dimatikan di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Path dasar project
define('BASE_PATH', dirname(__DIR__));

// --- Ambil parameter dari URL (contoh: ?url=stok/index)
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL));

// --- Tentukan controller & method
$controllerName = ucfirst($url[0]) . 'Controller';
$method = isset($url[1]) ? $url[1] : 'index';

// --- Tentukan path controller
$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

// --- Cek apakah controller ada
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    // --- Cek apakah method ada di controller
    if (method_exists($controller, $method)) {
        // Jika ada parameter tambahan di URL, kirimkan juga
        $params = array_slice($url, 2);
        call_user_func_array([$controller, $method], $params);
    } else {
        echo "<h3 style='color:red;'>Error: Method '$method' tidak ditemukan di $controllerName</h3>";
    }
} else {
    echo "<h3 style='color:red;'>Error: Controller '$controllerName' tidak ditemukan</h3>";
}
