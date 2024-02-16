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
    
    /* Inicio */
    function MostrarLibrosView() {
        try {
            $buscarPalabraClave = AdminModel::MostrarLibrosView();
            echo json_encode($buscarPalabraClave);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function buscarLibros() {
        try {
            $datos = $_POST;
            $result = AdminModel::buscarLibros($datos);
    
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
            $result = AdminModel::buscarLibrosEnTiempoReal($datos);
    
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
    /* FIN INICIO*/
    /* Vista autores */
    function autor(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/autor");
        } else {
            $this->recargar();
        }
    }
    function MostrarAutor(){
        try {
            $eventos = AdminModel::MostrarAutorTabla();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function RegistroAutor() {
        try {
            $datos = $_POST;
    
            $token = $this->generarToken();
            while ($this->buscarToken($token)) {
                $token = $this->generarToken();
            }
    
            $rutaImagen = $this->subirImagen($token,$_FILES['foto']);
            $datos['foto'] = $rutaImagen;
            $datos['token'] = $token;
            $result = AdminModel::RegistroAutores($datos);
    
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
    function generarToken() {
        $caracteres = "ABCDEFGHIJKLNMOPQRSTUVWXYZ123456789";
        $token = "";
    
        for ($i = 0; $i < 10; $i++) {
            $token .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
    
        return $token;
    }
    
    function buscarToken($token) {
        try {
            $tokensEncontrados = AdminModel::buscarToken($token);
            return count($tokensEncontrados) > 0;
        } catch (\Throwable $th) {
            echo "Error en el controlador token: " . $th->getMessage();
            return false;
        }
    }
    function subirImagen($token,$foto){
        $directorio = 'public/doc/';

        if (isset($foto) && $foto['error'] == UPLOAD_ERR_OK) {
            if ($token !== null) {
                $nombreArchivo = $token . '.' . pathinfo($foto['name'], PATHINFO_EXTENSION);
            } else {
                $nombreArchivo =$token . pathinfo($foto['name'], PATHINFO_EXTENSION);
            }
            $rutaCompleta = $directorio . $nombreArchivo;
            move_uploaded_file($foto['tmp_name'], $rutaCompleta);

            return $rutaCompleta;
        } else {
            return false;
        }
    }
    function eliminarAutor($param = null){
        try {
            $resp = AdminModel::eliminarAutor($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Autor eliminado',
                    'respuesta' => 'Se eliminó correctamente el autor.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Autor no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente el autor.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'No podemos borrar autor. Error: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Autor en uso',
                'respuesta' => 'No podemos borrar autor. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }
    function buscarAutor($param = null){
        try {
            $autor = AdminModel::buscarAutor($param[0]);
            echo json_encode($autor);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function actualizarAutor(){
        try {
            $datos = $_POST;
            $fotoActualizada = isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name']);
    
            if ($fotoActualizada) {
                $token = $this->generarToken();
                while ($this->buscarToken($token)) {
                    $token = $this->generarToken();
                }
    
                $rutaImagen = $this->subirImagen($token, $_FILES['foto']);
                $datos['foto'] = $rutaImagen;
                $datos['token'] = $token;
            }
    
            $resp = adminModel::actualizarAutor($datos, $fotoActualizada);
            
            if ($resp == true) {
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
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Registro actualizado',
                'respuesta' => 'Se actualizó correctamente.'
            ];
        }
    
        echo json_encode($data);
    }
    
    /* Fin vista autores */

    /* Vista Editoriales */
    function editoriales(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/editoriales");
        } else {
            $this->recargar();
        }
    }
    function MostrarEditorial(){
        try {
            $eventos = adminModel::MostrarEditorialTabla();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function RegistroEditorial() {
        try {
            $resp = adminModel::ResgistroEditorial($_POST);
            
            if ($resp['estatus'] == 'success') {
                $data = [
                    'estatus' => $resp['estatus'],
                    'titulo' => 'Registro exitoso',
                    'respuesta' => $resp['mensaje']
                ];
            } else {
                $data = [
                    'estatus' => 'error',
                    'titulo' => 'Error de registro',
                    'respuesta' => $resp['mensaje']
                ];
            }
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Contacte al área de sistemas. Error:' . $th->getMessage()
            ];
            return;
        }
        echo json_encode($data);
    }    
    function eliminarEditorial($param = null){
        try {
            $resp = adminModel::eliminarEditorial($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Editorial eliminado',
                    'respuesta' => 'Se eliminó correctamente el editorial.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Editorial no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente la editorial.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Error porfavor llamar área de sistemas: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Editorial en uso',
                'respuesta' => 'No podemos borrar la editorial. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }
    function buscarEditorial($param = null){
        try {
            $editorial = adminModel::buscarEditorial($param[0]);
            echo json_encode($editorial);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function actualizarEditorial(){
        try {
            $datos = $_POST;
    
            $resp = adminModel::actualizarEditorial($datos);
            if ($resp == true) {
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
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Registro actualizado',
                'respuesta' => 'Se actualizo correctamente.'
            ];
        }
    
        echo json_encode($data);
    }

    /* Fin vista editoriales */

    /* Vista Idiomas */
    function idioma(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/idioma");
        } else {
            $this->recargar();
        }
    }
    function MostrarIdioma(){
        try {
            $eventos = adminModel::MostrarIdiomaTabla();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function RegistroIdioma() {
        try {
            $datos = $_POST;
            $result = adminModel::RegistroIdioma($datos);

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
    function eliminarIdioma($param = null){
        try {
            $resp = adminModel::eliminarIdioma($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Idioma eliminado',
                    'respuesta' => 'Se eliminó correctamente el idioma.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Idioma no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente el idioma.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Porfavor contactar al área de sistemas: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Idioma en uso',
                'respuesta' => 'No podemos borrar idioma. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }
    function buscarIdioma($param = null){
        try {
            $idioma = adminModel::buscarIdioma($param[0]);
            echo json_encode($idioma);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function actualizarIdioma(){
        try {
            $datos = $_POST;
    
            $resp = adminModel::actualizarIdioma($datos);
            if ($resp == true) {
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
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Registro actualizado',
                'respuesta' => 'Se actualizo correcto el registro.'
            ];
        }
    
        echo json_encode($data);
    }
    /* Fin vista Idiomas */

    /* Vista Libros */
    function libro(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/libro");
        } else {
            $this->recargar();
        }
    }
    function MostrarLibro(){
        try {
            $eventos = AdminModel::MostrarLibroTabla();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function mostrarCategoriaLibros(){
        try {
            $mostrarcategorialibros = AdminModel::mostrarCategoriaLibros();
            echo json_encode($mostrarcategorialibros);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function mostrarAutorLibros(){
        try {
            $mostrarAutorLibros = AdminModel::mostrarAutorLibros();
            echo json_encode($mostrarAutorLibros);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function mostrarEditorialLibros(){
        try {
            $mostrarEditoriallibros = AdminModel::mostrarEditorialLibros();
            echo json_encode($mostrarEditoriallibros);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function mostrarIdiomaLibros(){
        try {
            $mostrarIdiomalibros = AdminModel::mostrarIdiomaLibros();
            echo json_encode($mostrarIdiomalibros);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function subirPortada($token,$portada){
        $directorio = 'public/PortadaLibro/';

        if (isset($portada) && $portada['error'] == UPLOAD_ERR_OK) {
            if ($token !== null) {
                $nombreArchivo = $token . '.' . pathinfo($portada['name'], PATHINFO_EXTENSION);
            } else {
                $nombreArchivo =$token . pathinfo($portada['name'], PATHINFO_EXTENSION);
            }
            $rutaCompleta = $directorio . $nombreArchivo;
            move_uploaded_file($portada['tmp_name'], $rutaCompleta);

            return $rutaCompleta;
        } else {
            return false;
        }
    }
    function subirDocumento($token_documento,$documento){
        $directorio = 'public/docLibros/';

        if (isset($documento) && $documento['error'] == UPLOAD_ERR_OK) {
            if ($token_documento !== null) {
                $nombreArchivo = $token_documento . '.' . pathinfo($documento['name'], PATHINFO_EXTENSION);
            } else {
                $nombreArchivo =$token_documento . pathinfo($documento['name'], PATHINFO_EXTENSION);
            }
            $rutaCompleta = $directorio . $nombreArchivo;
            move_uploaded_file($documento['tmp_name'], $rutaCompleta);

            return $rutaCompleta;
        } else {
            return false;
        }
    }
    function buscarTokenImagen($token) {
        try {
            $tokensEncontrados = AdminModel::buscarTokenImagen($token);
            return count($tokensEncontrados) > 0;
        } catch (\Throwable $th) {
            echo "Error en el controlador token: " . $th->getMessage();
            return false;
        }
    }
    function buscarTokenDocumento($token_documento) {
        try {
            $tokensEncontrados = AdminModel::buscarTokenDocumento($token_documento);
            return count($tokensEncontrados) > 0;
        } catch (\Throwable $th) {
            echo "Error en el controlador token: " . $th->getMessage();
            return false;
        }
    }
    function RegistroLibro() {
        try {
            $datos = $_POST;
            
            $token = $this->generarToken();
            while ($this->buscarTokenImagen($token)) {
                $token = $this->generarToken();
            }
            
            $rutaImagen = $this->subirPortada($token,$_FILES['portada']);
            $datos['portada'] = $rutaImagen;
            $datos['token'] = $token;

            $token_documento = $this->generarToken();
            
            while ($this->buscarTokenDocumento($token_documento)) {
                $token_documento = $this->generarToken();
            }
            
            $rutaDocumento = $this->subirDocumento($token_documento,$_FILES['documento']);
            $datos['documento'] = $rutaDocumento;
            $datos['token_documento'] = $token_documento;
            $result = AdminModel::RegistroLibros($datos);
            if ($result['estatus'] == 'success') {
                $idLibro = AdminModel::obtenerUltimoIdLibro();
                $asignacionResult = AdminModel::asignarLibro($idLibro, $datos);
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
    function eliminarLibro($param = null){
        try {
            $resp = AdminModel::eliminarLibro($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Libro eliminado',
                    'respuesta' => 'Se eliminó correctamente el idioma.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Libro no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente el idioma.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'errro',
                'titulo' => 'Error servidor',
                'respuesta' => 'Porfavor de contactar al área de sistemas: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Libro en uso',
                'respuesta' => 'No podemos borrar libro. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }
    function buscarLibro($param = null){
        try {
            $usuario = adminModel::buscarLibro($param[0]);
            echo json_encode($usuario);
            
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function actualizarLibro(){
        try {
            $datos = $_POST;
            $portadaActualizada = isset($_FILES['portada']['name']) && !empty($_FILES['portada']['name']);
            $documentoActualizado = isset($_FILES['documento']['name']) && !empty($_FILES['documento']['name']);
    
            if ($portadaActualizada) {
                $tokenPortada = $this->generarToken();
                while ($this->buscarTokenImagen($tokenPortada)) {
                    $tokenPortada = $this->generarToken();
                }
                $rutaPortada = $this->subirPortada($tokenPortada, $_FILES['portada']);
                $datos['token_portada'] = $tokenPortada;
                $datos['portada'] = $rutaPortada;
            }
    
            if ($documentoActualizado) {
                $tokenDocumento = $this->generarToken();
                while ($this->buscarTokenDocumento($tokenDocumento)) {
                    $tokenDocumento = $this->generarToken();
                }
                $rutaDocumento = $this->subirDocumento($tokenDocumento, $_FILES['documento']);
                $datos['token_documento'] = $tokenDocumento;
                $datos['documento'] = $rutaDocumento;
            }
    
            $resp = adminModel::actualizarLibro($datos, $portadaActualizada, $documentoActualizado);
    
            if ($resp == true) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Libro actualizado',
                    'respuesta' => 'Se actualizó correctamente el registro.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Registro no actualizado',
                    'respuesta' => 'No se actualizó correctamente el registro.'
                ];
            }
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Libro actualizado',
                'respuesta' => 'Se actualizó correctamente.'
            ];
        }
    
        echo json_encode($data);
    }
    
    /* Fin vista Libros */

    /* Vista Usuarios */
    function usuario(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/usuario");
        } else {
            $this->recargar();
        }
    }
    function MostrarUsuario(){
        try {
            $eventos = adminModel::MostrarUsuarioTabla();
            echo json_encode($eventos);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function eliminarUsuario($param = null){
        try {
            $resp = adminModel::eliminarUsuario($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Usuario eliminado',
                    'respuesta' => 'Se eliminó correctamente al usuario.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Usuario no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente al usuario.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Porfavor contactar al área de sistemas: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Usuario en uso',
                'respuesta' => 'No podemos borrar usuario. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }    
    function RegistroUsuario() {
        try {
            $datos = $_POST;
            $result = adminModel::RegistroUsuario($datos);

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
    function buscarUsuario($param = null){
        try {
            $usuario = adminModel::buscarUsuario($param[0]);
            echo json_encode($usuario);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
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
            <img src="public/img/error.jpg" alt="Cabezera del Correo">
            <br>
            <br>
            <div class="event-info">
            <p class="lead">Cuenta inabilitada</p>
            <p>Lamentamos informar que tu cuenta ha sido inhabilitada debido a una violación de nuestros términos y condiciones. Si deseas obtener más información, por favor, contacta a servicio@bibloteca.com. Agradecemos tu comprensión.
            </p>
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
    function actualizarUsuario(){
        try {
            $datos = $_POST;
    
            $resp = adminModel::actualizarUsuario($datos);
            if ($resp == true) {
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
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Registro actualizado',
                'respuesta' => 'Se actualizo correctamente.'
            ];
        }
        echo json_encode($data);
    }
    /* Fin vista Usuarios */    

    /* Categoria */

    function categoria(){
        if ($this->verificarAdmin()) {
            $this->view->render("admin/categoria");
        } else {
            $this->recargar();
        }
    }
    function MostrarCategoria(){
        try {
            $categoria = adminModel::MostrarCategoriaTabla();
            echo json_encode($categoria);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador eventos: " . $th->getMessage();
            return;
        }
    }
    function RegistroCategoria() {
        try {
            $datos = $_POST;
            $result = adminModel::RegistroCategoria($datos);

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
    function eliminarCategoria($param = null){
        try {
            $resp = adminModel::eliminarCategoria($param[0]);
            if ($resp != false) {
                $data = [
                    'estatus' => 'success',
                    'titulo' => 'Categoria eliminado',
                    'respuesta' => 'Se eliminó correctamente la categoria.'
                ];
            } else {
                $data = [
                    'estatus' => 'warning',
                    'titulo' => 'Categoria no eliminado',
                    'respuesta' => 'No se pudo eliminar correctamente la categoria.'
                ];
            }
        } catch (Exception $e) {
            $data = [
                'estatus' => 'error',
                'titulo' => 'Error servidor',
                'respuesta' => 'Porfavor contactar al área de sistemas: ' . $e->getMessage()
            ];
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'warning',
                'titulo' => 'Categoria en uso',
                'respuesta' => 'No podemos borrar la categoria. Error: ' . $th->getMessage()
            ];
        }
    
        echo json_encode($data);
    }
    function buscarCategoria($param = null){
        try {
            $categoria = adminModel::buscarCategoria($param[0]);
            echo json_encode($categoria);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function actualizarCategoria(){
        try {
            $datos = $_POST;
    
            $resp = adminModel::actualizarCategoria($datos);
            if ($resp == true) {
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
    
        } catch (\Throwable $th) {
            $data = [
                'estatus' => 'success',
                'titulo' => 'Registro actualizado',
                'respuesta' => 'Se actualizó correctamente el registro.'
            ];
        }
    
        echo json_encode($data);
    }
    /* FIN CATEGORIA*/

    /* VISUALIZADOR DE PDF */

    function pdf($param = null){
        if ($this->verificarAdmin()) {
            $this->view->evento = $param[0];
            $this->view->render("admin/pdf/index");
        } else {
            $this->recargar();
        }
    }
    function viewComentario($param = null){
        try {
            $comanetario = adminModel::viewComentario($param[0]);
            echo json_encode($comanetario);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador viewComentario: " . $th->getMessage();
            return;
        }
    }
    function buscarIdLibro($param = null){
        try {
            $categoria = adminModel::buscarIdLibro($param[0]);
            echo json_encode($categoria);
        } catch (\Throwable $th) {
            echo "Error recopilado controlador buscarUsuario: " . $th->getMessage();
            return;
        }
    }
    function infoLibro($param = null){
        try {
            $libro = AdminModel::mostrarInfoLibro($param[0]);
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
                $result = adminModel::editarComentario($datos);
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
                $result = adminModel::RegistroComentario($datos);
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
    function buscarComentarioEditar($param = null) {
        try {
            $comentario = adminModel::buscarComentarioEdicion($param[0]);
            echo json_encode($comentario);
        } catch (\Throwable $th) {
            echo "Error en el controlador buscarComentarioEditar: " . $th->getMessage();
            return;
        }
    }
    function eliminarComentario($param = null){
        try {
            $resp = adminModel::eliminarComentario($param[0]);
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
    function verificarEliminarComentario($param = null){
        try {
            $id_comentario = $param[0];
            $id_usuario_logeado = $param[1];
            $comentario = adminModel::buscarComentarioEdicion($id_comentario);
            if ($comentario && $comentario['id_fk_usuario'] == $id_usuario_logeado) {
                echo json_encode(['eliminar' => true]);
            } else {
                echo json_encode(['eliminar' => false]);
            }
        } catch (\Throwable $th) {
            echo json_encode(['eliminar' => false]);
        }
    }
    
    /* FIN DEL VISUALIZADOR DE PDF */
}