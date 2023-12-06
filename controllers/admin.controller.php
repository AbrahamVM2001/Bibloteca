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
    function eventos()
    {
        try {
            $eventos = AdminModel::eventos();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function guardarEvento()
    {
        try {
            if($_POST['tipo'] == 'nuevo'){
                $resp = AdminModel::guardarEvento($_POST);
            }else{
                $resp = AdminModel::actualizarEvento($_POST);
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($_POST['tipo'] == 'nuevo')?'Evento creado':'Evento actualizado',
                    'respuesta' => ($_POST['tipo'] == 'nuevo')?'Se creo correctamente el evento.':'Se actualizo correctamente el evento'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($_POST['tipo'] == 'nuevo')?'Evento no creado':'Evento no actualizado',
                    'respuesta' => ($_POST['tipo'] == 'nuevo')?'No se pudo crear correctamente el evento.':'No se pudo actualizar correctamente el evento'
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
    function buscarEvento($param = null){
        try {
            $evento = AdminModel::buscarEvento($param[0]);
            echo json_encode($evento);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarEvento: " . $th->getMessage();
            return;
        }
    }
    /* Programas */
    function programas($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->evento = $param[0];
            $_SESSION['evento_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/programas");
        } else {
            $this->recargar();
        }
    }
    function guardarPrograma()
    {
        try {
            if($_POST['tipo'] == 'nuevo'){
                $resp = AdminModel::guardarPrograma($_POST);
            }else{
                $resp = AdminModel::actualizarPrograma($_POST);
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($_POST['tipo'] == 'nuevo')?'Programa creado':'Programa actualizado',
                    'respuesta' => ($_POST['tipo'] == 'nuevo')?'Se creo correctamente el programa.':'Se actualizo correctamente el programa'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($_POST['tipo'] == 'nuevo')?'Programa no creado':'Programa no actualizado',
                    'respuesta' => ($_POST['tipo'] == 'nuevo')?'No se pudo crear correctamente el programa.':'No se pudo actualizar correctamente el programa'
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
    function buscarPrograma($param = null){
        try {
            $programa = AdminModel::buscarPrograma($param[0]);
            echo json_encode($programa);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarPrograma: " . $th->getMessage();
            return;
        }
    }
    function infoProgramas($param = null)
    {
        try {
            $eventos = AdminModel::infoProgramas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    /* Fechas */
    function fechas($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->fechas = $param[0];
            $_SESSION['programa_seleccionado'] = mb_convert_encoding(base64_decode($param[1]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/fechas");
        } else {
            $this->recargar();
        }
    }
    function guardarFechas()
    {
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
    function eliminarFecha($param = null){
        try {
            $resp = AdminModel::eliminarFecha($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Fecha eliminada',
                    'respuesta' => 'Se elimino correctamente la fecha.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Fecha no eliminada',
                    'respuesta' => 'No se pudo eliminar correctamente la fecha.'
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
    function infoFechas($param = null)
    {
        try {
            $eventos = AdminModel::infoFechas($param[0]);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    /* Salones */
    function salones($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idfecha = $param[0];
            $this->view->idprograma = $param[1];
            $_SESSION['fecha_seleccionado'] = mb_convert_encoding(base64_decode($param[2]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/salones");
        } else {
            $this->recargar();
        }
    }
    function guardarSalones()
    {
        try {
            if (!empty($_POST['nuevo_salon'])) {
                $resp = AdminModel::guardarSalones($_POST);
                $resp2 = AdminModel::asignarSalonPrograma($_POST['idfecha'], $_POST['idprograma'], $resp);
                $tipo = "crear";
            } else {
                $resp = AdminModel::asignarSalonPrograma($_POST['idfecha'], $_POST['idprograma'], $_POST['asignar_salon']);
                $tipo = "asignar";
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($tipo == "crear") ? 'Salón creado' : 'Salón creado',
                    'respuesta' => ($tipo == "crear") ? 'Se creo correctamente el salón.' : 'Se asignó correctamente el salón.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($tipo == "crear") ? 'Salón no creado' : 'Salón no asignado',
                    'respuesta' => ($tipo == "crear") ? 'No se pudo crear correctamente el salón.' : 'No se pudo asignar correctamente el salón.'
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
    function buscarSalon($param = null){
        try {
            $salon = AdminModel::buscarSalon($param[0]);
            echo json_encode($salon);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarSalon: " . $th->getMessage();
            return;
        }
    }
    function cat_salones($param = null)
    {
        try {
            $salones = AdminModel::cat_salones($param[0], $param[1]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function infoSalones($param = null)
    {
        try {
            $salones = AdminModel::infoSalones($param[0]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    /* Capitulos */
    function capitulos($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idfecha = $param[0];
            $this->view->idprograma = $param[1];
            $this->view->idsalon = $param[2];
            $_SESSION['salon_seleccionado'] = mb_convert_encoding(base64_decode($param[3]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/capitulos");
        } else {
            $this->recargar();
        }
    }
    function guardarCapitulos()
    {
        try {
            if (!empty($_POST['nuevo_capitulo'])) {
                $resp = AdminModel::guardarCapitulos($_POST);
                $resp2 = AdminModel::asignarCapituloPrograma($_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $resp);
                $tipo = "crear";
            } else {
                $resp = AdminModel::asignarCapituloPrograma($_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $_POST['asignar_capitulo']);
                $tipo = "asignar";
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($tipo == "crear") ? 'Capitulo creado' : 'Capitulo asignado',
                    'respuesta' => ($tipo == "crear") ? 'Se creo correctamente el capitulo.' : 'Se asignó correctamente el capitulo.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($tipo == "crear") ? 'Capitulo no creado' : 'Capitulo no asignado',
                    'respuesta' => ($tipo == "crear") ? 'No se pudo crear correctamente el capitulo.' : 'No se pudo asignar correctamente el capitulo.'
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
    function cat_capitulos($param = null)
    {
        try {
            $salones = AdminModel::cat_capitulos($param[0], $param[1], $param[2]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function infoCapitulos($param = null)
    {
        try {
            $salones = AdminModel::infoCapitulos($param[0], $param[1]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    /* Actividades */
    function actividades($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idfecha = $param[0];
            $this->view->idprograma = $param[1];
            $this->view->idsalon = $param[2];
            $this->view->idcapitulo = $param[3];
            $_SESSION['capitulo_seleccionado'] = mb_convert_encoding(base64_decode($param[4]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/actividades");
        } else {
            $this->recargar();
        }
    }
    function guardarActividades()
    {
        try {
            if (!empty($_POST['nueva_actividad'])) {
                $resp = AdminModel::guardarActividades($_POST);
                $resp2 = AdminModel::asignarActividadPrograma($_POST['idcapitulo'], $_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $resp);
                $tipo = "crear";
            } else {
                $resp = AdminModel::asignarActividadPrograma($_POST['idcapitulo'], $_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $_POST['asignar_actividad']);
                $tipo = "asignar";
            }
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => ($tipo == "crear") ? 'Actividad creada' : 'Actividad asignada',
                    'respuesta' => ($tipo == "crear") ? 'Se creo correctamente la actividad.' : 'Se asignó correctamente la actividad.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => ($tipo == "crear") ? 'Actividad no creada' : 'Actividad no asignada',
                    'respuesta' => ($tipo == "crear") ? 'No se pudo crear correctamente la actividad.' : 'No se pudo asignar correctamente la actividad.'
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
    function cat_actividades($param = null)
    {
        try {
            $salones = AdminModel::cat_actividades($param[0], $param[1], $param[2], $param[3]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_actividades: " . $th->getMessage();
            return;
        }
    }
    function infoActividades($param = null)
    {
        try {
            $salones = AdminModel::infoActividades($param[0], $param[1], $param[2]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoActividades: " . $th->getMessage();
            return;
        }
    }
    /* Temas */
    function temas($param = null)
    {
        if ($this->verificarAdmin()) {
            $this->view->idfecha = $param[0];
            $this->view->idprograma = $param[1];
            $this->view->idsalon = $param[2];
            $this->view->idcapitulo = $param[3];
            $this->view->idactividad = $param[4];
            $_SESSION['actividad_seleccionado'] = mb_convert_encoding(base64_decode($param[5]), 'UTF-8','ISO-8859-1');
            $this->view->render("admin/temas");
        } else {
            $this->recargar();
        }
    }
    function guardarTemas()
    {
        try {
            $horarios_encimados = $this->verificarAsignacion($_POST['profesor'],$_POST['idfecha'],$_POST['idprograma'],$_POST['hora_inicial'],$_POST['hora_final']);
            if ($horarios_encimados == true) {
                if (!empty($_POST['nuevo_tema'])) {
                    $resp = AdminModel::guardarTemas($_POST);
                    $resp2 = AdminModel::asignarTemaPrograma($_POST['idcapitulo'], $_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $_POST['idactividad'], $resp, $_POST);
                    $tipo = "crear";
                } else {
                    $resp = AdminModel::asignarTemaPrograma($_POST['idcapitulo'], $_POST['idsalon'], $_POST['idfecha'], $_POST['idprograma'], $_POST['idactividad'], $_POST['asignar_tema'], $_POST);
                    $tipo = "asignar";
                }
                if ($resp != false) {
                    $data = [
                        'estatus' => 'success',
                        'titulo' => ($tipo == "crear") ? 'Tema creado' : 'Tema asignado',
                        'respuesta' => ($tipo == "crear") ? 'Se creo correctamente el tema.' : 'Se asignó correctamente el tema.',
                        'tipo_resp' => ''
                    ];
                } else {
                    $data = [
                        'estatus' => 'warning',
                        'titulo' => ($tipo == "crear") ? 'Tema no creado' : 'Tema no asignado',
                        'respuesta' => ($tipo == "crear") ? 'No se pudo crear correctamente el tema.' : 'No se pudo asignar correctamente el tema.',
                        'tipo_resp' => ''
                    ];
                }
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Horarios encimados',
                    'respuesta' => 'No se puede asignar el tema porque se enciman los horarios con otra ponencia.',
                    'tipo_resp' => 'horarios'
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
    function verificarAsignacion($idprofesor,$idfechas,$idprograma,$horainicial,$hora_final){
        try {
            $resp = AdminModel::verificarAsignacion($idprofesor,$idfechas,$idprograma,$horainicial,$hora_final);
            if (count($resp) > 0) {
                return false;
            }else{
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    function guardarProfesor(){
        try {
                $resp = AdminModel::guardarProfesor($_POST);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Profesor creado',
                    'respuesta' => 'Se creo correctamente el profesor.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Profesor no creado',
                    'respuesta' => 'No se pudo crear correctamente el profesor.'
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
    function cat_temas($param = null)
    {
        try {
            $salones = AdminModel::cat_temas($param[0], $param[1], $param[2], $param[3], $param[4]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_actividades: " . $th->getMessage();
            return;
        }
    }
    function cat_profesores($param = null)
    {
        try {
            $profesores = AdminModel::cat_profesores();
            echo json_encode($profesores);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function cat_prefijos(){
        try {
            $prefijos = AdminModel::cat_prefijos();
            echo json_encode($prefijos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function cat_ladas(){
        try {
            $prefijos = AdminModel::cat_ladas();
            echo json_encode($prefijos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function cat_paises(){
        try {
            $prefijos = AdminModel::cat_paises();
            echo json_encode($prefijos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function cat_estados($param = null){
        try {
            $prefijos = AdminModel::cat_estados($param[0]);
            echo json_encode($prefijos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function cat_modalidades($param = null)
    {
        try {
            $modalidades = AdminModel::cat_modalidades();
            echo json_encode($modalidades);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador cat_profesores: " . $th->getMessage();
            return;
        }
    }
    function infoTemas($param = null)
    {
        try {
            $salones = AdminModel::infoTemas($param[0], $param[1], $param[2], $param[3]);
            echo json_encode($salones);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador infoActividades: " . $th->getMessage();
            return;
        }
    }
}