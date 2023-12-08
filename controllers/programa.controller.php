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
    function render()
    {
        $this->view->render("programa/index");
    }
}
