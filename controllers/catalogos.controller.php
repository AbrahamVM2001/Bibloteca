<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Catalogos extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    /* Vistas */
    function render()
    {
        if ($this->verificarAdmin()) {
            $this->view->render("catalogos/index");
        } else {
            $this->recargar();
        }
    }
    function eventos()
    {
        try {
            $eventos = CatalogosModel::eventos();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function programas($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->evento = $param[0];
            $_SESSION['evento_catalogos_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("catalogos/programas");
        } else {
            $this->recargar();
        }
    }
    function infoProgramas($param = null)
    {
        try {
            $eventos = CatalogosModel::infoProgramas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function catalogos($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->programa = $param[0];
            $_SESSION['programa_catalogos_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("catalogos/catalogos");
        } else {
            $this->recargar();
        }
    }
    /* Profesores */
    function infoProfesores($param = null)
    {
        try {
            $profesores = CatalogosModel::infoProfesores();
            echo json_encode($profesores);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoProfesores: " . $th->getMessage();
            return;
        }
    }
    function buscarProfesor($param = null)
    {
        try {
            $profesor = CatalogosModel::buscarProfesor($param[0]);
            echo json_encode($profesor);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarProfesor: " . $th->getMessage();
            return;
        }
    }
    /* Salones */
    function infoSalones($param = null)
    {
        try {
            $salones = CatalogosModel::infoSalones($param[0]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoSalones: " . $th->getMessage();
            return;
        }
    }
    /* Capitulos */
    function infoCapitulos($param = null)
    {
        try {
            $capitulos = CatalogosModel::infoCapitulos($param[0]);
            echo json_encode($capitulos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoCapitulos: " . $th->getMessage();
            return;
        }
    }
    /* Actividades */
    function infoActividades($param = null)
    {
        try {
            $actividades = CatalogosModel::infoActividades($param[0]);
            echo json_encode($actividades);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoActividades: " . $th->getMessage();
            return;
        }
    }
    /* Actividades */
    function infoTemas($param = null)
    {
        try {
            $temas = CatalogosModel::infoTemas($param[0]);
            echo json_encode($temas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoTemas: " . $th->getMessage();
            return;
        }
    }
    /* Catálogos */
    function cat_estados($param = null)
    {
        try {
            $prefijos = CatalogosModel::cat_estados($param[0]);
            echo json_encode($prefijos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function actualizarCatalogo(){
        try {
            switch ($_POST['formulario']) {
                case 'profesores':
                    $resp = CatalogosModel::updateProfesor($_POST);
                    break;
                case 'salones':
                    $resp = CatalogosModel::updateSalon($_POST);
                    break;
                
                default:
                    echo "No hay formulario";
                    break;
            }
            if ($resp == true) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Registro actualizado',
                    'respuesta' => 'Se actualizo correctamente el registro.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Registro no actualizado',
                    'respuesta' => 'No se actualizo correctamente el registro.'
                ];
            }
            
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Ocurrio un problema con el servidor.'
            ];
        }
        echo json_encode($data);
    }
}
