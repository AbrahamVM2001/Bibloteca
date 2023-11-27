<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Admin extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    /* Vistas */
    function render()
    {
        if ($this->verificarAdmin()) {
            $this->view->render("admin/index");
        } else {
            $this->recargar();
        }
    }
    function eventos(){
        try {
            $eventos = AdminModel::eventos();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function guardarEvento(){
        try {
            $resp = AdminModel::guardarEvento($_POST);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Carpeta creada',
                    'respuesta' => 'Se creo correctamente la carpeta.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Carpeta no creadas',
                    'respuesta' => 'No se pudo crear correctamente la carpeta.'
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
    function programas($param = null){
        if ($this->verificarAdmin()) {
            $this->view->evento = $param[0];
            $this->view->render("admin/programas");
        } else {
            $this->recargar();
        }
    }
    function guardarPrograma(){
        try {
            $resp = AdminModel::guardarPrograma($_POST);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Programa creado',
                    'respuesta' => 'Se creo correctamente el programa.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Programa no creado',
                    'respuesta' => 'No se pudo crear correctamente el programa.'
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
    function infoProgramas($param = null){
        try {
            $eventos = AdminModel::infoProgramas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function fechas($param = null){
        if ($this->verificarAdmin()) {
            $this->view->fechas = $param[0];
            $this->view->render("admin/fechas");
        } else {
            $this->recargar();
        }
    }
    function guardarFechas(){
        try {
            $resp = AdminModel::guardarFechas($_POST);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Fecha creada',
                    'respuesta' => 'Se creo correctamente la fecha.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Fecha no creada',
                    'respuesta' => 'No se pudo crear correctamente la fecha.'
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
    function infoFechas($param = null){
        try {
            $eventos = AdminModel::infoFechas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function salones($param = null){
        if ($this->verificarAdmin()) {
            $this->view->idfecha = $param[0];
            $this->view->idprograma = $param[1];
            $this->view->render("admin/salones");
        } else {
            $this->recargar();
        }
    }
    function guardarSalones(){
        try {
            if (!empty($_POST['nuevo_salon'])) {
                $resp = AdminModel::guardarSalones($_POST);
                $resp2 = AdminModel::asignarSalonPrograma($_POST['idfecha'],$_POST['idprograma'],$resp);
                $tipo = "crear";
            }else{
                echo "Asignar salón";
                $resp = AdminModel::asignarSalonPrograma($_POST['idfecha'],$_POST['idprograma'],$_POST['asignar_salon']);
                $tipo = "asignar";
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($tipo == "crear")?'Salón creado':'Salón creado',
                    'respuesta' => ($tipo == "crear")?'Se creo correctamente el salón.':'Se asignó correctamente el salón.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($tipo == "crear")?'Salón no creado':'Salón no asignado',
                    'respuesta' => ($tipo == "crear")?'No se pudo crear correctamente el salón.':'No se pudo asignar correctamente el salón.'
                ];
            }
        } catch (\Throwable $th) {
            /* echo "respuesta:".$th->getMessage() */
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
        }
        
        echo json_encode($data);
    }
    function cat_salones($param = null){
        try {
            $salones = AdminModel::cat_salones($param[0],$param[1]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function infoSalones($param = null){
        try {
            $salones = AdminModel::infoSalones($param[0]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }


















    /* Metodos anteriores */
    function revistas()
    {
        try {
            $revistas = AdminModel::revistas();
            echo json_encode($revistas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador clientes: " . $th->getMessage();
            return;
        }
    }
    function documentos($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->revista = $param[0];
            $this->view->render("admin/documentos");
        } else {
            $this->recargar();
        }
    }
    function view($param = null)
    {
        $doc = AdminModel::documento($param[0]);
        $tipo = (isset($_GET['qr']))?0:1;
        $rastreo = AdminModel::rastreo($param[0],$tipo);
        $this->view->documento = $doc;
        $this->view->render("admin/view");
    }
    function estadisticas(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/estadisticas");
        } else {
            $this->recargar();
        }
    }
    function infoEstadisticas(){
        try {
            $revistas = AdminModel::infoEstadisticas();
            echo json_encode($revistas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador clientes: " . $th->getMessage();
            return;
        }
    }
    function infoDocumentos($param = null)
    {
        try {
            $revistas = AdminModel::infoDocumentos($param[0]);
            echo json_encode($revistas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador clientes: " . $th->getMessage();
            return;
        }
    }
    function verificarToken($token)
    {
        try {
            $resp = AdminModel::verificarToken($token);
            if (count($resp) < 1) {
                return true;
            } else {
                $this->verificarToken($token);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function generarToken()
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cadenaAleatoria = '';
        for ($i = 0; $i < 15; $i++) {
            $indice = mt_rand(0, strlen($caracteres) - 1);
            $cadenaAleatoria .= $caracteres[$indice];
        }
        if ($this->verificarToken($cadenaAleatoria)) {
            return $cadenaAleatoria;
        } else {
            $this->generarToken();
            return false;
        }
    }
    function subirDocumento()
    {
        try {
            $token = $this->generarToken();
            if ($token != false) {
                $name_doc = str_replace(" ", "_", $_POST['nombre_documento']);
                $name_doc = str_replace("/", "", $name_doc);
                $extension = explode("/", $_FILES['documento']['type']);
                $doc = ($_FILES['documento']['name'] != "") ? "public/img/documentos/" . $name_doc . "." . $extension[1] : null;
                if ($_FILES['documento']['name'] != "" && !move_uploaded_file($_FILES['documento']['tmp_name'], $doc)) {
                    echo "error al cargar documento";
                }
                $contenido_qr = constant('URL') . "admin/view/" . $token ."/?qr=true";
                $contenido= constant('URL') . "admin/view/" . $token ."/?link=true";
                $directorio = 'public/img/qr_revista/';
                $nombreArchivo = $token . '.png';
                $rutaArchivo = $directorio . $nombreArchivo;
                QRcode::png($contenido_qr, $rutaArchivo, QR_ECLEVEL_L, 10);
                $resp = AdminModel::subirDocumento($_POST, $doc, $token, $contenido, $rutaArchivo);
                if ($resp != false) {
                    $data = [
                        'estatus' => 'success',
                        'titulo' => 'Documento guardado',
                        'respuesta' => 'Se guardo correctamente el documento.'
                    ];
                } else {
                    $data = [
                        'estatus' => 'warning',
                        'titulo' => 'Documento no guardado',
                        'respuesta' => 'No se pudo guardar correctamente el documento.'
                    ];
                }
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
    function getDocumento($param = null)
    {
        try {
            $resp = AdminModel::getDocumento($param[0]);
            echo json_encode($resp);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function actualizarDocumento()
    {
        try {
            if (isset($_FILES['documento']['name']) != "" && $_FILES['documento']['name'] != "") {
                $name_doc = str_replace(" ", "_", $_POST['nombre_documento']);
                $name_doc = str_replace("/", "", $name_doc);
                $extension = explode("/", $_FILES['documento']['type']);
                $doc = ($_FILES['documento']['name'] != "") ? "public/img/documentos/" . $name_doc . "." . $extension[1] : null;
                if ($_FILES['documento']['name'] != "" && !move_uploaded_file($_FILES['documento']['tmp_name'], $doc)) {
                    echo "error al cargar documento";
                }
            } else {
                $doc = $_POST['documento_ant'];
            }

            $resp = AdminModel::actualizarDocumento($_POST, $doc);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Documento actualizado',
                    'respuesta' => 'Se actualizo correctamente el documento.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Documento no actualizado',
                    'respuesta' => 'No se pudo actualizar correctamente el documento.'
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
    function guardarCarpeta()
    {
        try {
            $resp = AdminModel::guardarCarpeta($_POST);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Carpeta creada',
                    'respuesta' => 'Se creo correctamente la carpeta.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Carpeta no creadas',
                    'respuesta' => 'No se pudo crear correctamente la carpeta.'
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas.Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }
}