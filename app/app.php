<?php
session_start();
require_once "controllers/error.controller.php";
class App
{
    private $alertLogin;
    private $url;
    public function __construct()
    {
        // echo "<p>Nueva App</p>";

        $this->url = isset($_GET['url']) ? $_GET['url'] : null;
        $this->url = trim($this->url ?? '', "/");
        $this->url = explode("/", $this->url);
        // Cuando se ingresa sin definir el controlador
        if (isset($_SESSION['id_usuario-' . constant('Sistema')]) && !empty($_SESSION['id_usuario-' . constant('Sistema')])) {
            if (empty($this->url[0])) {
                $archivoController = "controllers/admin.controller.php";
                require_once $archivoController;
                $controller = new Admin();
                $controller->loadModel("admin");
                $controller->render();
                return false;
            }
            $this->general($this->url);
        } else {
            // echo "No esta logueado, redireccionar a Login";
            if (empty($this->url[0])) {
                $archivoController = "controllers/login.controller.php";
                require_once $archivoController;
                $controller = new Login();
                $controller->loadModel("login");
                $controller->render();
                return false;
            }
            $this->general($this->url);
        }

    }
    function general($url_general)
    {
        $archivoController = "controllers/" . $url_general[0] . ".controller.php";

        if (file_exists($archivoController)) {
            require_once $archivoController;
            // Inicializa el controlador
            $controller = new $url_general[0];
            $controller->loadModel($url_general[0]);
            // Número de elementos del arreglo URL
            $nparam = sizeof($url_general);
            if ($nparam > 1) {
                if ($nparam > 2) {
                    $param = [];
                    for ($i = 2; $i < $nparam; $i++) {
                        array_push($param, $url_general[$i]);
                    }
                    if (method_exists($controller, $url_general[1])) {
                        $controller->{$url_general[1]}($param);
                    } else {
                        $controller = new Errores();
                    }
                    /* var_dump($param) ; */
                    // $controller->{$url_general[1]}($param);
                } else {
                    if (method_exists($controller, $url_general[1])) {
                        // echo "existe metodo";
                        $controller->{$url_general[1]}(); //Carga el metodo
                    } else {
                        // echo "no existe metodo";
                        $controller = new Errores();
                    }
                    // $controller->{$url_general[1]}();//Carga el metodo
                }
            } else {
                $controller->render();
            }
        } else {
            $controller = new Errores();
        }
    }
}