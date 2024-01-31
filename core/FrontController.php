<?php
require_once "core/ConexionDB.php";
require_once "core/responseData.class.php";
require_once 'core/PageController.php';

class FrontController {
    private $checkSession = true; // Indica si se debe verificar la sesión

    public function __construct() {
        spl_autoload_register([$this, 'autoload']);
        $this->handleRouting();
    }

    public function isSessionStarted() {
        return $this->checkSession && isset($_SESSION['user_id']); // Cambia 'user_id' por el nombre de la variable de sesión que utilizas
    }

    private function autoload($nameClass) {
        $classFile = './controllers/' . $nameClass . '.php';
        if (file_exists($classFile)) {
            include_once $classFile;
        } else {
            $this->handleClassNotFound($nameClass);
        }
    }

    private function handleClassNotFound($nameClass) {
        if ($nameClass != 'DefaultController') {
            $responseData = new responseData;
            $responseError = $responseData->error_404();
            header('Content-Type: application/json');
            echo json_encode($responseError);
        } else {
            $this->goToMainPage();
        }
    }

    private function goToMainPage() {
        if (empty($_GET['controller'])) {
            $_GET['controller'] = 'index';
            if (file_exists('./web-app/index.php')) {
                require_once './web-app/index.php'; // Cambia la ruta según tu estructura de archivos
            } else {
                $responseData = new responseData;
                header('Content-Type: application/json');
                $responseError = $responseData->sendJsonResponse(
                    'error', 
                    'No se encontró el archivo index.php en la carpeta web-app/public'
                );
                echo json_encode($responseError);
            }
        }
    }

    private function handleRouting() {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $urlSegments = explode('/', trim($url, '/'));

        $controllerName = !empty($urlSegments[1]) ? ucfirst($urlSegments[1]) : 'Default';
        $controllerClassName = $controllerName . 'Controller';

        if (class_exists($controllerClassName)) {
            $controller = new $controllerClassName();
            $action = !empty($urlSegments[2]) ? $urlSegments[2] : 'index';
            if ($controllerClassName === 'PageController') {
                //Se crean las rutas PROVICIONAL
                $Router = new PageController();
                $Router->index();   
            }else {
                //codigo ates del if
                if (method_exists($controller, $action)) {
                    $params = array_slice($urlSegments, 3);
                    call_user_func_array([$controller, $action], $params);
                } else {
                    echo "Método no encontrado";
                }
            }
            
        }
    }
}

