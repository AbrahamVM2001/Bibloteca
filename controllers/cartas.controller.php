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
            $_SESSION['evento_carta_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("cartas/programas");
        } else {
            $this->recargar();
        }
    }
    function infoProgramas($param = null)
    {
        try {
            $eventos = CartasModel::infoProgramas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function concentrado($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idprograma = $param[0];
            $_SESSION['programa_carta_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8', 'ISO-8859-1');
            $this->view->render("cartas/concentrado");
        } else {
            $this->recargar();
        }
    }
    function temasAsignadosProfesores($param = null)
    {
        try {
            $asignacion = CartasModel::temasAsignadosProfesores($param[0]);
            echo json_encode($asignacion);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function buscarTemasAsignados($param = null)
    {
        try {
            $temas = CartasModel::buscarTemasAsignados($param[0], $param[1]);
            echo json_encode($temas);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function previewCartas($param = null)
    {
        try {
            $resp_virtual = CartasModel::buscarTemasAsignadosVirtuales($param[0], $param[1]);
            $resp_presencial = CartasModel::buscarTemasAsignadosPresenciales($param[0], $param[1]);
            $resp_profesor = CartasModel::buscarProfesor($param[0]);
            $resp_evento = CartasModel::buscarEvento($param[1]);
            if (count($resp_presencial) > 0) {
                $this->cartaPresencial($resp_profesor['profesor'], $resp_presencial, $resp_evento);
            } else if (count($resp_virtual) > 0) {
                $this->cartaVirtual($resp_profesor['profesor'], $resp_virtual, $resp_evento);
            } else {

            }
            /* var_dump($resp_virtual); */
            /* header("Location: nueva_pagina.php"); */
        } catch (\Throwable $th) {
            echo "Error recopilado: " . $th->getMessage();
        }
    }
    function cartaPresencial($profesor, $temas, $evento)
    {
        header('Content-Type: text/html; charset=utf-8');
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        /* Fondo de marca de agua */
        $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
        /* Fecha de visualización */
        $pdf->SetXY(60, 37);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
        /* Nombre del doctor */
        $pdf->SetXY(55, 50);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor . " - Presencial", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Texto: Presente */
        $pdf->SetXY(55, 55);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding("Presente", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Texto: Estimado Colega y Amigo */
        $pdf->SetXY(55, 60);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding("Estimado Colega y Amigo", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);



        $pdf->Output('I', 'Carta-presencial-' . $profesor . "-" . date('d-m-Y') . ".pdf");
    }
    function cartaVirtual($profesor, $temas, $evento)
    {
        /* var_dump($temas);
        exit; */
        header('Content-Type: text/html; charset=utf-8');
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        /* Fondo de marca de agua */
        $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
        /* Fecha de visualización */
        $pdf->SetXY(60, 37);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
        /* Nombre del doctor */
        $pdf->SetXY(55, 50);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor . " - Virtual", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Texto: Presente */
        $pdf->SetXY(55, 55);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding("Presente", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Texto: Estimado Colega y Amigo */
        $pdf->SetXY(55, 60);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(145, 10, mb_convert_encoding("Estimado Colega y Amigo", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Texto: Agradeciendo su valiosa... */
        $fecha_evento_inicial = $evento['fecha_inicio_evento'];
        $fecha_evento_final = $evento['fecha_fin_evento'];
        $html = "Agradeciendo su valiosa e importante asistencia al <b>" . $evento['nombre_evento'] . "</b>, a realizarse en el <b>" . $evento['descripcion_evento'] . "</b>, iniciando el <b>" . $this->fechaEs($fecha_evento_inicial) . "</b> y terminando el <b>" . $this->fechaEs($fecha_evento_final) . "</b>, queda confirmada su participación en las fechas y horarios señalados:";
        $pdf->SetXY(55, 75);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetLeftMargin(55);
        $pdf->WriteHTML(mb_convert_encoding($html, 'ISO-8859-1', 'UTF-8'));
        /* Texto: En esta ocasión usted... */
        $pdf->SetXY(55, 100);
        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(145, 5, mb_convert_encoding("En esta ocasión usted tiene registrada su participación en la modalidad virtual, con el desarrollo de grabaciones, para lo cual, un proveedor hará contacto con usted para la asesoría técnica y grabación de los temas:", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
        /* Mostramos los temas asignados al profesor */
        foreach ($temas as $key => $tema) {
            //echo $this->calcularTiempoDuracion($tema['hora_inicial'],$tema['hora_final']);
            $espacioRestante = $pdf->GetPageHeight() - $pdf->GetY();
            // Comprueba si hay suficiente espacio para al menos una línea más
            if ($espacioRestante > 70) {
                // Añade más contenido
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_duracion = "<br>Duración: <b>" . $this->calcularTiempoDuracion($tema['hora_inicial'], $tema['hora_final']) . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_duracion, 'ISO-8859-1', 'UTF-8'));
                $pdf->Ln();
                /* $pdf->Line(56, $pdf->GetY() + 7, 200, $pdf->GetY() + 7); // 50mm from each edge */
            } else {
                // Si no hay suficiente espacio, añade un salto de página
                $pdf->SetTopMargin(40);
                $pdf->AddPage();
                $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
                /* Fecha de visualización */
                /* $pdf->SetXY(60, 37); */
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_duracion = "<br>Duración: <b>" . $this->calcularTiempoDuracion($tema['hora_inicial'], $tema['hora_final']) . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_duracion, 'ISO-8859-1', 'UTF-8'));
                $pdf->Ln();
            }
        }
        /* Texto: Es importante ... */
        $pdf->Ln();
        $pdf->SetX(55);
        $pdf->SetLeftMargin(55);
        $txt = "<b>Es importante ajustarse al tiempo asignado para la exposición de cada tema, ya que los videos se subirán a la plataforma OrtoNet®.</b>";
        $pdf->SetFont('Arial', '', 11);
        $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));


        $pdf->Output('I', 'Carta-virtual-' . $profesor . "-" . date('d-m-Y') . ".pdf");
    }
    function fechaEs($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        /* return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio; */
        return $numeroDia . " de " . $nombreMes . " de " . $anio;
    }
    function calcularTiempoDuracion($horainicial, $horafinal)
    {
        $dateTimeInicial = new DateTime($horainicial);
        $dateTimeFinal = new DateTime($horafinal);
        // Calcular la diferencia de tiempo
        $diferencia = $dateTimeInicial->diff($dateTimeFinal);
        // Obtener la diferencia en formato HH:MM:SS
        $tiempoDiferencia = $diferencia->format('%H:%I');
        return $tiempoDiferencia;
    }
    /* function concentradoPrograma(){
        try {
            $eventos = CartasModel::eventos();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    } */
}