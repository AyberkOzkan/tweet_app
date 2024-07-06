<?php

spl_autoload_register(function ($className) {
    $baseDir = dirname(__DIR__);
    $paths = [$baseDir . '/core/', $baseDir . '/app/models/', $baseDir . '/app/controllers/'];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "$file not found<br>";
        }
    }
});

class Router {
    private $baseDir;

    public function __construct() {
        $this->baseDir = dirname(__DIR__);

        // Basic Routing
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        // Default Controller
        $controller = 'Home';
        $method = 'index';
        $params = [];

        if (isset($url[0]) && !empty($url[0])) {
            $controller = ucfirst($url[0]);
            unset($url[0]);
        }

        if (isset($url[1]) && !empty($url[1])) {
            $method = $url[1];
            unset($url[1]);
        }

        $params = $url ? array_values($url) : [];

        // Include and Instantiate Controller
        $file = $this->baseDir . '/app/controllers/' . $controller . '.php';
        if (file_exists($file)) {
            require_once $file;
            $controller = new $controller;
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Method $method not found in controller $controller";
            }
        } else {
            echo "Controller $controller not found";
        }
    }
}

?>
