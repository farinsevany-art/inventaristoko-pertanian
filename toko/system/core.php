<?php
class Core {
    public function run() {
        $url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
        $url = explode('/', filter_var(trim($url, '/'), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = isset($url[1]) ? $url[1] : 'index';
        $params = array_slice($url, 2);

        $controllerPath = '../app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerName;
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Method not found!";
            }
        } else {
            echo "Controller not found!";
        }
    }
}
