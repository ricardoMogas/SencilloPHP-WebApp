<?php
// Enrutador
class Router {
    private $routes = [];

    public function index() {
        // Crear una instancia del enrutador
        $this->run();
    }
    // Agregar una ruta
    public function showRoutes() {
        echo '<pre>';
        print_r($this->routes);
        echo '</pre>';
    }
    // Ejecutar el enrutador
    public function run() {
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $urlSegments = explode('/', trim($url, '/'));

        echo $path;
        echo '<br>';
        echo $urlSegments[0];
    }
}