<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Cartas extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    /* Vistas */
    function render()
    {
        if ($this->verificarAdmin()) {
            $this->view->render("cartas/index");
        } else {
            $this->recargar();
        }
    }
    function eventos()
    {
        try {
            $eventos = CartasModel::eventos();
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
            $_SESSION['evento_carta_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8','ISO-8859-1');
            $this->view->render("cartas/programas");
        } else {
            $this->recargar();
        }
    }
    function concentrado($param = null){
        if ($this->verificarAdmin()) {
            $this->view->idprograma = $param[0];
            $_SESSION['programa_carta_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8','ISO-8859-1');
            $this->view->render("cartas/concentrado");
        } else {
            $this->recargar();
        }
    }
    function concentradoPrograma(){
        try {
            $eventos = CartasModel::eventos();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
}