<?php
// Enrutador
class PageController {
    private $routes = [];

    public function index() {
        // Crear una instancia del enrutador
        $router = new PageController();

        // Definir rutas
        $router->addRoute('/', function() {
            echo "Página de inicio";
        });

        $router->addRoute('/about', function() {
            echo "Acerca de nosotros";
        });

        // Ejecutar el enrutador
        $router->run();
    }
    // Agregar una ruta
    public function addRoute($path, $callback) {
        $this->routes[$path] = $callback;
    }

    // Ejecutar el enrutador
    public function run() {
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        // Verificar si la ruta existe
        if (array_key_exists($path, $this->routes)) {
            $callback = $this->routes[$path];
            $callback();
        } else {
            // Ruta no encontrada
            echo "404 Not Found";
        }
    }
}
