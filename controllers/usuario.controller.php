<?php
require_once("public/vendor/phpmailer/src/PHPMailer.php");
require_once("public/vendor/phpmailer/src/Exception.php");
require_once("public/vendor/phpmailer/src/SMTP.php");
require_once("public/phpqrcode/qrlib.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class usuario extends ControllerBase
{
    function __construct()
    {
        parent::__construct();
    }
    function MostrarLibroIndex(){
        try {
            $eventos = usuarioModel::MostrarLibroIndex();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function MostrarLibrosView($param = null){
        try {
            $eventos = usuarioModel::mostrarInfoLibro($param);
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function buscarLibros() {
        try {
            $datos = $_POST;
            $result = usuarioModel::buscarLibros($datos);
    
            $data = [
                'estatus' => $result['estatus'],
                'titulo' => $result['mensaje'],
                'respuesta' => $result['libros'] ?? [],
            ];
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error de servidor',
                'respuesta' => 'Contacte al área de sistemas'
            ];
        }
    
        echo json_encode($data);
    }
    function buscarLibrosEnTiempoReal() {
        try {
            $datos = json_decode(file_get_contents("php://input"), true);
            $result = usuarioModel::buscarLibrosEnTiempoReal($datos);
    
            $data = [
                'estatus' => $result['estatus'],
                'titulo' => $result['mensaje'],
                'respuesta' => $result['libros'] ?? [],
            ];
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error de servidor',
                'respuesta' => 'Contacte al área de sistemas'
            ];
        }
    
        echo json_encode($data);
    }
    /* Vistas */
    function render()
    {
        if ($this->verificarUser()) {
            $this->view->render("usuario/index");
        } else {
            $this->recargar();
        }
    }
    function pdf($param = null){
        if ($this->verificarUser()) {
            $this->view->evento = $param[0];
            $this->view->render("usuario/pdf/index");
        } else {
            $this->recargar();
        }
    }
    function viewComentario($param = null){
        try {
            $comanetario = usuarioModel::viewComentario($param[0]);
            echo json_encode($comanetario);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador viewComentario: " . $th->getMessage();
            return;
        }
    }
    function buscarIdLibro($param = null){
        try {
            $categoria = usuarioModel::buscarIdLibro($param[0]);
            echo json_encode($categoria);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function infoLibro($param = null){
        try {
            $libro = usuarioModel::mostrarInfoLibro($param[0]);
            echo json_encode($libro);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function RegistroComentario() {
        try {
            $datos = $_POST;
            if ($datos['tipo'] === '1') {
                $result = usuarioModel::editarComentario($datos);
                if ($result == true) {
                    $data = [
                        'estatus' => 'success',
                        'titulo' => 'Registro actualizado',
                        'respuesta' => 'Se actualizó correctamente el registro.'
                    ];
                } else {
                    $data = [
                        'estatus' => 'warning',
                        'titulo' => 'Registro no actualizado',
                        'respuesta' => 'No se actualizó correctamente el registro.'
                    ];
                }
            } else {
                $result = usuarioModel::RegistroComentario($datos);
                if ($result['estatus'] == 'success') {
                    $data = [
                        'estatus' => $result['estatus'],
                        'titulo' => 'Registro exitoso',
                        'respuesta' => $result['mensaje']
                    ];
                } else {
                    $data = [
                        'estatus' => 'error',
                        'titulo' => 'Error de registro',
                        'respuesta' => $result['mensaje']
                    ];
                }
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
    function verificarEliminarComentario($param = null){
        try {
            $id_comentario = $param[0];
            $id_usuario_logeado = $param[1];
            $comentario = usuarioModel::buscarComentarioEdicion($id_comentario);
            if ($comentario && $comentario['id_fk_usuario'] == $id_usuario_logeado) {
                echo json_encode(['eliminar' => true]);
            } else {
                echo json_encode(['eliminar' => false]);
            }
        } catch (\Throwable $th) {
            echo json_encode(['eliminar' => false]);
        }
    }
    function eliminarComentario($param = null){
        try {
            $resp = usuarioModel::eliminarComentario($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'comentario eliminado',
                    'respuesta' => 'Se elimino correctamente el idioma.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'comentario no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente al idioma.'
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
    function buscarComentarioEditar($param = null) {
        try {
            $comentario = usuarioModel::buscarComentarioEdicion($param[0]);
            echo json_encode($comentario);
        } catch (\Throwable $th) {
            echo "Error en el controlador buscarComentarioEditar: " . $th->getMessage();
            return;
        }
    }
}