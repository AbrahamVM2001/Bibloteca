<?php
/**
 *
 */
class LoginModel extends ModelBase{
    public function __construct(){
        parent::__construct();
    }
    public static function user($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT id_usuario, nombre, correo, tipo_usuario, pass, Estatus, Apellido_paterno, Apellido_materno, Genero from cat_usuario where correo = :correo and pass = :pass");
            $query->execute([
                ':correo' => $datos['correo'],
                ':pass' => $datos['pass']
            ]);

            $row = $query->fetch();

            if ($row) {
                return $row;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error en el modelo user: " . $e->getMessage();
            return false;
        }
    }
    public static function RegistroDispositivo($datos){
        try{
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO asignacion_dispositivo (infoModelo, Direccion, FechaTiempo, id_fk_usuario) VALUES (:info, :Dir, :FechaYTiempo, :id_usuario)");
    
            $fecha_actual = date("Y-m-d H:i:s");
            $query->execute([
                ':info' => $datos['modelo'],
                ':Dir' => $datos['ip'],
                ':FechaYTiempo' => $fecha_actual,
                ':id_usuario' => $_SESSION['id_usuario-' . constant('Sistema')]
            ]);
    
            return ['estatus' => 'success', 'mensaje' => 'Comentario insertado correctamente'];
        } catch (PDOException $e){
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el comentario en la base de datos'];
        }
    }    
    public static function registro($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_usuario (Nombre, Apellido_paterno, Apellido_materno, Genero, Tipo_usuario, Estatus, correo, pass) VALUES (:nombre, :apellido_paterno, :apellido_materno, :genero, '2', '1', :correo, :pass)");
    
            $query->execute([
                ':nombre' => $datos['nombre'],
                ':apellido_paterno' => $datos['apellido_paterno'],
                ':apellido_materno' => $datos['apellido_materno'],
                ':genero' => $datos['genero'],
                ':correo' => $datos['correo'],
                ':pass' => $datos['pass']
            ]);
            $idUsuario = $con->pdo->lastInsertId();
    
            return ['estatus' => 'success', 'mensaje' => 'Usuario insertado correctamente', 'id_usuario' => $idUsuario];
        } catch (PDOException $e) {
            echo "Error recopilación model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
}
