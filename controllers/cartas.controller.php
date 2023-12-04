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
            /* if (count($resp_presencial) > 0 && count($resp_virtual) > 0) {
                header('Location:' . constant('URL') . 'cartas/cartaPresencial/' . $param[0] . "/" . $param[1]);
                header('Location:' . constant('URL') . 'cartas/cartaVirtual/' . $param[0] . "/" . $param[1]);
            } */
            if (count($resp_presencial) > 0) {

                echo '<script>';
                echo 'window.open("' . constant('URL') . 'cartas/cartaPresencial/' . $param[0] . "/" . $param[1] . "/CartaPresencial" . '", "_blank");';
                echo '</script>';
                /* $pdfPresencial = $this->cartaPresencial($resp_profesor['profesor'], $resp_presencial, $resp_evento); */
            }
            if (count($resp_virtual) > 0) {

                echo '<script>';
                echo 'window.open("' . constant('URL') . 'cartas/cartaVirtual/' . $param[0] . "/" . $param[1] . "/CartaVirtual" . '", "_blank");';
                echo '</script>';
                /* $pdfVirtual = $this->cartaVirtual($resp_profesor['profesor'], $resp_virtual, $resp_evento); */
            }

            echo '<script>';
            echo 'setTimeout(() => {';
            echo 'window.close();';
            echo '}, 100);';
            echo '</script>';
        } catch (\Throwable $th) {
            echo "Error recopilado: " . $th->getMessage();
        }
    }
    function cartaPresencial($param = null)
    {
        $temas = CartasModel::buscarTemasAsignadosPresenciales($param[0], $param[1]);
        $profesor = CartasModel::buscarProfesor($param[0]);
        $evento = CartasModel::buscarEvento($param[1]);
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
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor['profesor'] . " - Presencial", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
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
                $texto_dia = "<br>Día: <b>" . $tema['fecha_programa'] . "</b>";
                $texto_horario = "<br>Horario: <b>" . $tema['hora_inicial'] . " - ".$tema['hora_final']."</b>";
                $texto_salon = "<br>Salón: <b>" . $tema['nombre_salon'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_actividad = "<br>Actividad: <b>" . $tema['nombre_actividad'] . "</b>";
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_dia, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_horario, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_salon, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_actividad, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
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
                $texto_dia = "<br>Día: <b>" . $tema['fecha_programa'] . "</b>";
                $texto_horario = "<br>Horario: <b>" . $tema['hora_inicial'] . " - ".$tema['hora_final']."</b>";
                $texto_salon = "<br>Salón: <b>" . $tema['nombre_salon'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_actividad = "<br>Actividad: <b>" . $tema['nombre_actividad'] . "</b>";
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_dia, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_horario, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_salon, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_actividad, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
                $pdf->Ln();
            }
        }
        /* Texto: Es importante ... */
        $pdf->Ln();
        $pdf->SetX(55);
        $pdf->SetLeftMargin(55);
        $espacioRestante2 = $pdf->GetPageHeight() - $pdf->GetY();
        if ($espacioRestante2 > 163) {
            $txt = "Como es de su conocimiento y por respeto a los demás ponentes, y por cumplimiento al programa académico es muy importante <b>apegarse al tiempo asignado</b>.";
            $txt .= "<br><br>Importante para contar con lo anterior, al término de su tiempo asignado, se apagará automáticamente su presentación quedando habilitado únicamente el micrófono para poder concluir.";
            $txt .= "<br><br>Su plática podrá ser entregada en una memoria USB el día anterior a su presentación, o bien utilizar su dispositivo (Laptop, Ipad, Tablet), para la proyección de plática en el salón correspondiente a su presentación. Cabe hacer notar que el tiempo de conexión de su dispositivo corre dentro del tiempo asignado a su presentación.";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        } else {
            $pdf->SetTopMargin(40);
            $pdf->AddPage();
            $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
            /* Fecha de visualización */
            $pdf->SetXY(60, 37);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
            $txt = "Como es de su conocimiento y por respeto a los demás ponentes, y por cumplimiento al programa académico es muy importante <b>apegarse al tiempo asignado</b>.";
            $txt .= "<br><br>Importante para contar con lo anterior, al término de su tiempo asignado, se apagará automáticamente su presentación quedando habilitado únicamente el micrófono para poder concluir.";
            $txt .= "<br><br>Su plática podrá ser entregada en una memoria USB el día anterior a su presentación, o bien utilizar su dispositivo (Laptop, Ipad, Tablet), para la proyección de plática en el salón correspondiente a su presentación. Cabe hacer notar que el tiempo de conexión de su dispositivo corre dentro del tiempo asignado a su presentación.";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        }

        $pdf->Output('I', 'Carta-presencial-' . date('d-m-Y'));
    }
    function cartaVirtual($param = null)
    {
        $temas = CartasModel::buscarTemasAsignadosVirtuales($param[0], $param[1]);
        $profesor = CartasModel::buscarProfesor($param[0]);
        $evento = CartasModel::buscarEvento($param[1]);
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
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor['profesor'] . " - Virtual", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
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
        $espacioRestante2 = $pdf->GetPageHeight() - $pdf->GetY();
        if ($espacioRestante2 > 128) {
            $txt = "<b>Es importante ajustarse al tiempo asignado para la exposición de cada tema, ya que los videos se subirán a la plataforma OrtoNet®.</b>";
            $txt .= "<br><br>Para apoyar lo anterior, y darle certidumbre a los tiempos y al proceso, nos comunicaremos con usted para ponernos a sus órdenes y concertar las citas de grabación.";
            $txt .= "<br><br>Se integrará la agenda para las grabaciones de cada uno de los ponentes, deberá realizarse la totalidad de las ponencias antes del 15 de marzo, para dar cumplimiento a los tiempos que se requieren para esta logística. ";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        } else {
            $pdf->SetTopMargin(40);
            $pdf->AddPage();
            $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
            /* Fecha de visualización */
            $pdf->SetXY(60, 37);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
            $txt = "<b>Es importante ajustarse al tiempo asignado para la exposición de cada tema, ya que los videos se subirán a la plataforma OrtoNet®.</b>";
            $txt .= "<br><br>Para apoyar lo anterior, y darle certidumbre a los tiempos y al proceso, nos comunicaremos con usted para ponernos a sus órdenes y concertar las citas de grabación.";
            $txt .= "<br><br>Se integrará la agenda para las grabaciones de cada uno de los ponentes, deberá realizarse la totalidad de las ponencias antes del 15 de marzo, para dar cumplimiento a los tiempos que se requieren para esta logística. ";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        }
        $pdf->Output('I', 'Carta-virtual-' . date('d-m-Y'));
    }
    function sendCartas($param = null)
    {
        try {
            $resp_virtual = CartasModel::buscarTemasAsignadosVirtuales($param[0], $param[1]);
            $resp_presencial = CartasModel::buscarTemasAsignadosPresenciales($param[0], $param[1]);
            $profesor = CartasModel::buscarProfesor($param[0]);
            $resp_evento = CartasModel::buscarEvento($param[1]);
            /* if (count($resp_presencial) > 0 && count($resp_virtual) > 0) {
                header('Location:' . constant('URL') . 'cartas/cartaPresencial/' . $param[0] . "/" . $param[1]);
                header('Location:' . constant('URL') . 'cartas/cartaVirtual/' . $param[0] . "/" . $param[1]);
            } */
            if (count($resp_presencial) > 0) {

                /* echo '<script>';
                echo 'window.open("' . constant('URL') . 'cartas/cartaPresencial/' . $param[0] . "/" . $param[1] . "/CartaPresencial" . '", "_blank");';
                echo '</script>'; */
                $pdfPresencial = $this->enviarCartaPresencial($profesor, $resp_presencial, $resp_evento);
            }
            if (count($resp_virtual) > 0) {

                /* echo '<script>';
                echo 'window.open("' . constant('URL') . 'cartas/cartaVirtual/' . $param[0] . "/" . $param[1] . "/CartaVirtual" . '", "_blank");';
                echo '</script>'; */
                $pdfVirtual = $this->enviarCartaVirtual($profesor, $resp_virtual, $resp_evento);
            }

            /* echo '<script>';
            echo 'setTimeout(() => {';
            echo 'window.close();';
            echo '}, 100);';
            echo '</script>'; */
        } catch (\Throwable $th) {
            echo "Error recopilado: " . $th->getMessage();
        }
    }
    function enviarCartaPresencial($profesor,$temas,$evento)
    {
        /* $temas = CartasModel::buscarTemasAsignadosPresenciales($param[0], $param[1]);
        $profesor = CartasModel::buscarProfesor($param[0]);
        $evento = CartasModel::buscarEvento($param[1]); */
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
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor['profesor'] . " - Presencial", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
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
                $texto_dia = "<br>Día: <b>" . $tema['fecha_programa'] . "</b>";
                $texto_horario = "<br>Horario: <b>" . $tema['hora_inicial'] . " - ".$tema['hora_final']."</b>";
                $texto_salon = "<br>Salón: <b>" . $tema['nombre_salon'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_actividad = "<br>Actividad: <b>" . $tema['nombre_actividad'] . "</b>";
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_dia, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_horario, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_salon, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_actividad, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
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
                $texto_dia = "<br>Día: <b>" . $tema['fecha_programa'] . "</b>";
                $texto_horario = "<br>Horario: <b>" . $tema['hora_inicial'] . " - ".$tema['hora_final']."</b>";
                $texto_salon = "<br>Salón: <b>" . $tema['nombre_salon'] . "</b>";
                $texto_tema = "<br>Tema: <b>" . $tema['nombre_tema'] . "</b>";
                $texto_actividad = "<br>Actividad: <b>" . $tema['nombre_actividad'] . "</b>";
                $texto_capitulo = "<br>Capítulo: <b>" . $tema['nombre_capitulo'] . "</b>";
                $pdf->SetLeftMargin(60);
                $pdf->WriteHTML(mb_convert_encoding($texto_dia, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_horario, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_salon, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_tema, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_actividad, 'ISO-8859-1', 'UTF-8'));
                $pdf->WriteHTML(mb_convert_encoding($texto_capitulo, 'ISO-8859-1', 'UTF-8'));
                $pdf->Ln();
            }
        }
        /* Texto: Es importante ... */
        $pdf->Ln();
        $pdf->SetX(55);
        $pdf->SetLeftMargin(55);
        $espacioRestante2 = $pdf->GetPageHeight() - $pdf->GetY();
        if ($espacioRestante2 > 163) {
            $txt = "Como es de su conocimiento y por respeto a los demás ponentes, y por cumplimiento al programa académico es muy importante <b>apegarse al tiempo asignado</b>.";
            $txt .= "<br><br>Importante para contar con lo anterior, al término de su tiempo asignado, se apagará automáticamente su presentación quedando habilitado únicamente el micrófono para poder concluir.";
            $txt .= "<br><br>Su plática podrá ser entregada en una memoria USB el día anterior a su presentación, o bien utilizar su dispositivo (Laptop, Ipad, Tablet), para la proyección de plática en el salón correspondiente a su presentación. Cabe hacer notar que el tiempo de conexión de su dispositivo corre dentro del tiempo asignado a su presentación.";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        } else {
            $pdf->SetTopMargin(40);
            $pdf->AddPage();
            $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
            /* Fecha de visualización */
            $pdf->SetXY(60, 37);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
            $txt = "Como es de su conocimiento y por respeto a los demás ponentes, y por cumplimiento al programa académico es muy importante <b>apegarse al tiempo asignado</b>.";
            $txt .= "<br><br>Importante para contar con lo anterior, al término de su tiempo asignado, se apagará automáticamente su presentación quedando habilitado únicamente el micrófono para poder concluir.";
            $txt .= "<br><br>Su plática podrá ser entregada en una memoria USB el día anterior a su presentación, o bien utilizar su dispositivo (Laptop, Ipad, Tablet), para la proyección de plática en el salón correspondiente a su presentación. Cabe hacer notar que el tiempo de conexión de su dispositivo corre dentro del tiempo asignado a su presentación.";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        }

        $nombe_archivo = $profesor['profesor'].".pdf";
        $nombre_carpeta = "public/cartas/".$evento['nombre_evento']."/presenciales/";
        $pdf->Output('F', $nombe_archivo);
        if (!file_exists($nombre_carpeta)) {
            mkdir($nombre_carpeta, 0777, true);
        }
        $nuevaRuta = $nombre_carpeta . '/' . $nombe_archivo;
        if (rename($nombe_archivo, $nuevaRuta)) {
            //echo "El archivo se ha movido exitosamente a la carpeta '$carpeta'.";
            $this->enviarCartaIndividual($profesor,$evento,$nuevaRuta,'Presencial');
        } else {
            echo "Error al mover la carta presencial:".$nombe_archivo;
        }
    }
    function enviarCartaVirtual($profesor,$temas,$evento)
    {
        /* $temas = CartasModel::buscarTemasAsignadosVirtuales($param[0], $param[1]);
        $profesor = CartasModel::buscarProfesor($param[0]);
        $evento = CartasModel::buscarEvento($param[1]); */
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
        $pdf->MultiCell(145, 10, mb_convert_encoding($profesor['profesor'] . " - Virtual", 'ISO-8859-1', 'UTF-8'), 0, 'L', 0);
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
        $espacioRestante2 = $pdf->GetPageHeight() - $pdf->GetY();
        if ($espacioRestante2 > 128) {
            $txt = "<b>Es importante ajustarse al tiempo asignado para la exposición de cada tema, ya que los videos se subirán a la plataforma OrtoNet®.</b>";
            $txt .= "<br><br>Para apoyar lo anterior, y darle certidumbre a los tiempos y al proceso, nos comunicaremos con usted para ponernos a sus órdenes y concertar las citas de grabación.";
            $txt .= "<br><br>Se integrará la agenda para las grabaciones de cada uno de los ponentes, deberá realizarse la totalidad de las ponencias antes del 15 de marzo, para dar cumplimiento a los tiempos que se requieren para esta logística. ";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        } else {
            $pdf->SetTopMargin(40);
            $pdf->AddPage();
            $pdf->Image(constant('URL') . "public/img/marca-agua-cmo-cartas.png", '0', '0', '210', '295');
            /* Fecha de visualización */
            $pdf->SetXY(60, 37);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->MultiCell(140, 10, mb_convert_encoding("Ciudad de México, " . $this->fechaEs(date('Y-m-d')), 'ISO-8859-1', 'UTF-8'), 0, 'R', 0);
            $txt = "<b>Es importante ajustarse al tiempo asignado para la exposición de cada tema, ya que los videos se subirán a la plataforma OrtoNet®.</b>";
            $txt .= "<br><br>Para apoyar lo anterior, y darle certidumbre a los tiempos y al proceso, nos comunicaremos con usted para ponernos a sus órdenes y concertar las citas de grabación.";
            $txt .= "<br><br>Se integrará la agenda para las grabaciones de cada uno de los ponentes, deberá realizarse la totalidad de las ponencias antes del 15 de marzo, para dar cumplimiento a los tiempos que se requieren para esta logística. ";
            $txt .= "<br><br>Cualquier aclaración, favor de contactar con Claudia Velez al e-mail eventos@colegiocmo.com.mx";
            $txt .= "<br><br>Reconociendo de antemano su apreciada colaboración, le reiteramos nuestra amistad.";
            $pdf->SetFont('Arial', '', 11);
            $pdf->WriteHTML(mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $pdf->Image(constant('URL') . "public/img/firma-presidente-cmo.png", '55', ($pdf->GetY() + 7), '60', '30');
            $pdf->Image(constant('URL') . "public/img/firma-presidente-2.png", '130', ($pdf->GetY() + 7), '60', '30');
            $txt2 = "CCP.- Dr. Daniel Diego Ball; Coordinador Académico del LXIX Congreso 2024.";
            $pdf->SetY(($pdf->GetY() + 50));
            $pdf->WriteHTML(mb_convert_encoding($txt2, 'ISO-8859-1', 'UTF-8'));
        }
        $nombe_archivo = $profesor['profesor'].".pdf";
        $nombre_carpeta = "public/cartas/".$evento['nombre_evento']."/virtuales/";
        $pdf->Output('F', $nombe_archivo);
        if (!file_exists($nombre_carpeta)) {
            mkdir($nombre_carpeta, 0777, true);
        }
        $nuevaRuta = $nombre_carpeta . '/' . $nombe_archivo;
        if (rename($nombe_archivo, $nuevaRuta)) {
            $this->enviarCartaIndividual($profesor,$evento,$nuevaRuta,'Virtual');
        } else {
            echo "Error al mover la carta virtual de:".$nombe_archivo;
        }
    }
    function enviarCartaIndividual($profesor,$evento,$archivo,$modalidad){
        $mail = new PHPMailer(true); // defaults to using php "mail()"
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro para Evento Médico</title>
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
            @media screen and (max-width: 600px) {
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
            <img src="' . constant("URL").'public/img/cintillo-correo.jpeg" alt="Cabezera del Correo">
            <br>
            <br>
            <div class="event-info">
            <p class="lead">Estimado(a) ' . $profesor['profesor'] . '</p>
            <p>Gusto en saludarlo, adjunto le enviamos la carta con los detalles de su participación en el <b>' . $evento['nombre_evento'] . '</b>.</p>
            <p>Cualquier duda o comentario con gusto podemos resolverlo.</p>
            <p>Saludos cordiales.</p>
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
            $mail->SetFrom(trim('masivos@lahe.mx'), 'COLEGIO MEXICANO DE ORTOPEDIA Y TRAUMATOLOGÍA'); //Correo del emisor
            //$mail->addCC('ameg@endoscopia.org.mx');//Con copia
            /* $mail->addCC('ameg@endoscopia.org.mx');//Con copia */
            /* if ($datosCampania['correo_respuesta'] != "" && $datosCampania['correo_respuesta'] != null) {
                $mail->AddReplyTo(trim($datosCampania['correo_respuesta']));//Correo de respuesta
            } */

            $mail->AddAddress(trim($profesor['correo_profesor'])); //Correo del receptor
            $mail->AddAttachment($archivo); //Adds an attachment from a path on the filesystem
            $mail->Subject = 'Carta de asignación de temas - '.$modalidad; //Asunto del correo
            $mail->Body = $html;
            $mail->AltBody = $html;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            /* if($datosDestinatario['archivo_constancia'] != "" && $datosDestinatario['archivo_constancia'] != null){ */
                if ($mail->Send()) {
                    /* $resp = AdminModel::actualizarCorreoEnviado($datosDestinatario['id_detalle_lista'], $datosCampania['id_campania'], 1); */
                    return true;
                } else {
                    /* $resp = AdminModel::actualizarCorreoEnviado($datosDestinatario['id_detalle_lista'], $datosCampania['id_campania'], 0); */
                    return false;
                }
            /* }else{
                return false;
            } */
            
        } catch (phpmailerException $e) {
            echo "Error phpmailerexception:".$e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            echo "Error Exception:".$e->getMessage(); //Boring error messages from anything else!
        }
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
