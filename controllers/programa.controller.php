<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Programa extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    /* Vistas */
    function render($param = null)
    {
        $this->sinprograma();
    }
    function programa($param = null)
    {
        if ($param == null) {
            $this->sinprograma();
        } else {
            $this->view->programa = (ProgramaModel::datosPrograma($param[0]) != false) ? $param[0] : 'Error';
            $this->view->datos = (ProgramaModel::datosPrograma($param[0]) != false) ? ProgramaModel::datosPrograma($param[0]) : 'Error';
            $this->view->fechasPrograma = (ProgramaModel::fechaPrograma($param[0]) != false) ? ProgramaModel::fechaPrograma($param[0]) : 'Error';
            $this->view->render("programa/index");
        }
    }
    function sinprograma()
    {
        $this->view->render("programa/sinprograma");
    }
    function infoPrograma($param = null)
    {
        try {
            $asignacion = ProgramaModel::infoPrograma($param[0], $param[1], $param[2]);
            echo json_encode($asignacion);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function infoCapitulos($param = null)
    {
        try {
            $capitulos = ProgramaModel::infoCapitulos($param[0], $param[1]);
            echo json_encode($capitulos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
}
