<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Reportes extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    /* Vistas */
    function render()
    {
        if ($this->verificarAdmin()) {
            $this->view->render("reportes/index");
        } else {
            $this->recargar();
        }
    }
    function eventos()
    {
        try {
            $eventos = ReportesModel::eventos();
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
            $_SESSION['evento_reporte_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("reportes/programas");
        } else {
            $this->recargar();
        }
    }
    function infoProgramas($param = null)
    {
        try {
            $eventos = ReportesModel::infoProgramas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function programa($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idprograma = $param[0];
            $this->view->exportable = $param[2];
            $_SESSION['programa_reporte_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("reportes/concentrado");
        } else {
            $this->recargar();
        }
    }
    function temasAsignadosProfesores($param = null)
    {
        try {
            $asignacion = ReportesModel::temasAsignadosProfesores($param[0]);
            echo json_encode($asignacion);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function buscarTemasAsignados($param = null)
    {
        try {
            $temas = ReportesModel::buscarTemasAsignados($param[0], $param[1]);
            echo json_encode($temas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
}
