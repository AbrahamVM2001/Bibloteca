<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends ControllerBase
{

    function __construct()
    {
        parent::__construct();
    }
    function render()
    {
        $this->view->render('login/index');
    }
    function acceso()
    {
        try {
            $user = LoginModel::user($_POST);

            if ($user != false) {
                if ($user['correo'] == $_POST['correo'] && $user['pass'] == $_POST['pass']) {
                    if ($user['Estatus'] == 1) {
                        $_SESSION['id_usuario-' . constant('Sistema')] = $user['id_usuario'];
                        $_SESSION['nombre_usuario-' . constant('Sistema')] = $user['nombre'];
                        $_SESSION['correo-' . constant('Sistema')] = $user['correo'];
                        $_SESSION['tipo_usuario-' . constant('Sistema')] = $user['tipo_usuario'];

                        $data = [
                            'estatus' => 'success',
                            'titulo' => 'Bienvenido',
                            'respuesta' => ''
                        ];

                    } else {
                        $data = [
                            'estatus' => 'error',
                            'titulo' => 'Acceso denegado',
                            'respuesta' => 'Su cuenta está desactivada. Contacte al administrador.'
                        ];
                    }
                } else {
                    $data = [
                        'estatus' => 'error',
                        'titulo' => 'Credenciales incorrectas',
                        'respuesta' => 'Las credenciales ingresadas son incorrectas.'
                    ];
                }
            } else {
                $data = [
                    'estatus' => 'error',
                    'titulo' => 'Usuario incorrecto',
                    'respuesta' => 'El usuario ingresado es incorrecto.'
                ];
            }
        } catch (\Throwable $th) {
            echo "error controlador acceso: " . $th->getMessage();
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error de servidor',
                'respuesta' => 'Contacte al área de sistemas'
            ];
        }
        echo json_encode($data);
    }

    function registro() {
        try {
            $datos = $_POST;
            if (strlen($datos['pass']) < 8 || strlen($datos['pass']) > 36) {
                $data = [
                    'estatus' => 'error',
                    'titulo' => 'Error de registro',
                    'respuesta' => 'La contraseña debe tener entre 8 y 36 caracteres.'
                ];
                echo json_encode($data);
                return;
            }
            if (!preg_match('/[0-9]/', $datos['pass']) || !preg_match('/[^a-zA-Z0-9]/', $datos['pass'])) {
                $data = [
                    'estatus' => 'error',
                    'titulo' => 'Error de registro',
                    'respuesta' => 'La contraseña debe contener al menos un número y un símbolo.'
                ];
                echo json_encode($data);
                return;
            }
            $result = LoginModel::registro($datos);
            $idUsuario = $result['id_usuario'];
            if ($result['estatus'] == 'success') {
                    $_SESSION['id_usuario-' . constant('Sistema')] = $idUsuario;
                    $_SESSION['nombre_usuario-' . constant('Sistema')] = $datos['nombre'];
                    $_SESSION['correo-' . constant('Sistema')] = $datos['correo'];
                    $_SESSION['tipo_usuario-' . constant('Sistema')] = 2;
                $data = [
                    'estatus' => $result['estatus'],
                    'titulo' => 'Registro exitoso ya puedes iniciar sesión',
                    'respuesta' => $result['mensaje']
                ];
                $this->enviocorreoregistro($datos);
            } else {
                $data = [
                    'estatus' => 'error',
                    'titulo' => 'Error de registro',
                    'respuesta' => $result['mensaje']
                ];
            }
        } catch (\Throwable $th) {
            echo "error controlador registro: " . $th->getMessage();
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error de servidor',
                'respuesta' => 'Contacte al área de sistemas'
            ];
        }
    
        echo json_encode($data);
    }
    
    function enviocorreoregistro($datos) {
        $mail = new PHPMailer(true);
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro al sistema de bienvenida</title>
        <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.3/css/all.min.css" rel="stylesheet">
        <style>
            body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            }
            img {
            max-width: 100%;
            height: auto;
            }
            .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            }
            .event-info {
            border: 2px solid #244f84;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            }
            h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #406dae;
            text-align: center;
            }
            p {
            margin-bottom: 15px;
            text-align: justify;
            }
            ul {
            margin-bottom: 15px;
            padding-left: 20px;
            }
            li {
            list-style: none;
            margin-bottom: 10px;
            }
            i {
            margin-right: 10px;
            }
            address {
            font-style: normal;
            margin-top: 30px;
            }
            .text-muted {
            color: #888;
            }
            @media screen and (max-width: 600p  x) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
            }
        </style>
        </head>
        <body>
        <div class="container">
            <br>
            <img src="' . constant("URL") . 'public/img/cintillo-correo.jpg" alt="Cabezera del Correo">
            <br>
            <br>
            <div class="event-info">
            <p class="lead">Bienvenido al sistema de bibloteca virtual</p>
            <p>Bienvenido(a) al sistema! Estamos emocionados de tenerte como parte de nuestra comunidad. 
                Tu registro abre las puertas a un mundo de posibilidades. ¡Explora y disfruta de todas las funciones que tenemos para ofrecerte! Si tienes alguna pregunta, nuestro equipo está aquí para ayudarte. ¡Gracias por unirte!</p>
                <p>Nombre: ' . $datos['nombre'] . '</p>
                <p>Correo: ' . $datos['correo'] . '</p>
                <p>Contraseña: ' . $datos['pass'] . '</p>
        </div>
        </div>
        </body>
        </html>';
        try {
            $mail->IsSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            /* $mail->Host       = "smtp.gmail.com"; */
            $mail->Host = 'mail.lahe.mx'; //mail.grupolahe.com
            $mail->Port = '465'; //465
            /* $mail->Username   ="francisco.arenal@grupolahe.com"; */
            $mail->Username = 'masivos@lahe.mx';
            /* $mail->Password   ="fag1912..."; */
            $mail->Password = 'Masivos.129';
            $mail->SetFrom(trim('masivos@lahe.mx'), 'SISTEMA BIBLOTECA'); //Correo del emisor

            $mail->AddAddress(trim($datos['correo']));

            $mail->Subject = 'Registro exitoso';
            $mail->Body = $html;
            $mail->AltBody = $html;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if ($mail->Send()) {
                /* $resp = CartasModel::actualizarCorreoEnviado($profesor['id_profesor'], 'programa','cartapresencial','cartavirtual'); */
                return true;
            } else {
                /* $resp = AdminModel::actualizarCorreoEnviado($datosDestinatario['id_detalle_lista'], $datosCampania['id_campania'], 0); */
                return false;
            }
        } catch (phpmailerException $e) {
            echo "Error phpmailerexception:" . $e->errorMessage();
        } catch (Exception $e) {
            echo "Error Exception:" . $e->getMessage();
        }
    }
    function enviocorreoacceso($user){
        $mail = new PHPMailer(true);
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro al sistema de bienvenida</title>
        <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.3/css/all.min.css" rel="stylesheet">
        <style>
            body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            }
            img {
            max-width: 100%;
            height: auto;
            }
            .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            }
            .event-info {
            border: 2px solid #244f84;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            }
            h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #406dae;
            text-align: center;
            }
            p {
            margin-bottom: 15px;
            text-align: justify;
            }
            ul {
            margin-bottom: 15px;
            padding-left: 20px;
            }
            li {
            list-style: none;
            margin-bottom: 10px;
            }
            i {
            margin-right: 10px;
            }
            address {
            font-style: normal;
            margin-top: 30px;
            }
            .text-muted {
            color: #888;
            }
            @media screen and (max-width: 600p  x) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 24px;
            }
            }
        </style>
        </head>
        <body>
        <div class="container">
            <br>
            <img src="' . constant("URL") . 'public/img/cintillo-correo.jpg" alt="Cabezera del Correo">
            <br>
            <br>
            <div class="event-info">
            <p class="lead">Bienvenido al sistema de bibloteca virtual</p>
            <p>Bienvenido(a) al sistema! Estamos emocionados de tenerte como parte de nuestra comunidad. 
                Tu registro abre las puertas a un mundo de posibilidades. ¡Explora y disfruta de todas las funciones que tenemos para ofrecerte! Si tienes alguna pregunta, nuestro equipo está aquí para ayudarte. ¡Gracias por unirte!</p>
            </div>
        </div>
        </body>
        </html>';
        try {
            $mail->IsSMTP();
            $mail->isHTML(true);
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";
            /* $mail->Host       = "smtp.gmail.com"; */
            $mail->Host = 'mail.lahe.mx'; //mail.grupolahe.com
            $mail->Port = '465'; //465
            /* $mail->Username   ="francisco.arenal@grupolahe.com"; */
            $mail->Username = 'masivos@lahe.mx';
            /* $mail->Password   ="fag1912..."; */
            $mail->Password = 'Masivos.129';
            $mail->SetFrom(trim('masivos@lahe.mx'), 'SISTEMA BIBLOTECA'); //Correo del emisor

            $mail->AddAddress(trim($user['correo']));

            $mail->Subject = 'Sesion Iniciada';
            $mail->Body = $html;
            $mail->AltBody = $html;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            if ($mail->Send()) {
                /* $resp = CartasModel::actualizarCorreoEnviado($profesor['id_profesor'], 'programa','cartapresencial','cartavirtual'); */
                return true;
            } else {
                /* $resp = AdminModel::actualizarCorreoEnviado($datosDestinatario['id_detalle_lista'], $datosCampania['id_campania'], 0); */
                return false;
            }
        } catch (phpmailerException $e) {
            echo "Error phpmailerexception:" . $e->errorMessage();
        } catch (Exception $e) {
            echo "Error Exception:" . $e->getMessage();
        }
    }
    function salir()
    {
        unset($_SESSION['id_usuario-' . constant('Sistema')]);
        unset($_SESSION['nombre_usuario-' . constant('Sistema')]);
        unset($_SESSION['usuario-' . constant('Sistema')]);
        unset($_SESSION['tipo_usuario-' . constant('Sistema')]);
        /* session_destroy(); */
        header("location:" . constant('URL'));
    }
}
?>