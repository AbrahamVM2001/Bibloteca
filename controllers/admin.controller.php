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