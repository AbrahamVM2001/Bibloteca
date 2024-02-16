<?php

/**
 *
 */
class usuarioModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();
    }
    public static function MostrarLibroIndex(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT
                cl.id_libro,
                cl.Titulo,
                cl.Numero_paginas,
                cl.Fecha_subir_sistema,
                cl.Fecha_publicacion,
                cl.Descripcion,
                cl.Palabra_clave,
                cl.Estatus,
                cl.Imagen,
                cl.documento,
                cl.Token_documento,
                cl.Token,
                cl.id_fk_usuario,
                MAX(ac.Puntaje) AS PuntajeMaximo
            FROM
                cat_libro cl
            LEFT JOIN
                asignacion_comentarios ac ON cl.id_libro = ac.id_fk_libro
            WHERE
                cl.Estatus = 1
            GROUP BY
                cl.id_libro, cl.Titulo, cl.Numero_paginas, cl.Fecha_subir_sistema, cl.Fecha_publicacion,
                cl.Descripcion, cl.Palabra_clave, cl.Estatus, cl.Imagen, cl.documento,
                cl.Token_documento, cl.Token, cl.id_fk_usuario
            ORDER BY
                PuntajeMaximo DESC, cl.id_libro;
            ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function MostrarLibrosView($busqueda){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro WHERE id_libro = 1 AND Estatus = 1;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }    
    }
    public static function buscarLibros($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cl.*
            FROM cat_libro cl
            INNER JOIN asignacion_libro al ON cl.id_libro = al.id_fk_libro
            WHERE al.id_fk_autor = :id_autor and cl.Estatus = 1
                OR al.id_fk_editorial = :id_editorial
                OR al.id_fk_categoria = :id_categoria
                OR al.id_fk_idioma = :id_idioma
                OR cl.Titulo LIKE :busqueda_titulo
                OR cl.Palabra_clave LIKE :busqueda_palabra_clave");

            $query->execute([
                ':id_autor' => $datos['buscar'],
                ':id_editorial' => $datos['buscar'],
                ':id_categoria' => $datos['buscar'],
                ':id_idioma' => $datos['buscar'],
                ':busqueda_titulo' => '%' . $datos['buscar'] . '%',
                ':busqueda_palabra_clave' => '%' . $datos['buscar'] . '%'
            ]);
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return ['estatus' => 'success', 'mensaje' => 'Libros encontrados', 'libros' => $result];
        } catch (PDOException $e) {
            return ['estatus' => 'error', 'mensaje' => 'Libros no encontrados', 'error' => $e->getMessage()];
        }
    }
    public static function buscarLibrosEnTiempoReal($datos) {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cl.* FROM cat_libro cl INNER JOIN
            asignacion_libro al ON cl.id_libro = al.id_fk_libro
            WHERE
                (al.id_fk_autor = :id_autor OR al.id_fk_editorial = :id_editorial OR al.id_fk_categoria = :id_categoria OR al.id_fk_idioma = :id_idioma OR cl.Titulo LIKE :busqueda_titulo OR cl.Palabra_clave LIKE :busqueda_palabra_clave)
            AND cl.Estatus = 1;
            ");
    
            $query->execute([
                ':id_autor' => $datos['buscar'],
                ':id_editorial' => $datos['buscar'],
                ':id_categoria' => $datos['buscar'],
                ':id_idioma' => $datos['buscar'],
                ':busqueda_titulo' => '%' . $datos['buscar'] . '%',
                ':busqueda_palabra_clave' => '%' . $datos['buscar'] . '%'
            ]);
    
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return ['estatus' => 'success', 'mensaje' => 'Libros encontrados', 'libros' => $result];
        } catch (PDOException $e) {
            return ['estatus' => 'error', 'mensaje' => 'Libros no encontrados', 'error' => $e->getMessage()];
        }
    }
    /* Pagina de visualizacion de pdf y comentarios */
    public static function viewComentario($id_libro){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT ac.Puntaje, cu.id_usuario, ac.id_comentario, cu.Nombre, cu.Apellido_paterno, cu.Apellido_materno, ac.id_fk_libro, ac.Comentario, ac.Fecha_publicacion, ac.Estatus FROM asignacion_comentarios ac LEFT JOIN cat_usuario cu ON ac.id_fk_usuario = cu.id_usuario WHERE ac.id_fk_libro = :id_libro ORDER BY ac.Fecha_publicacion DESC;");
            $query->execute([
                'id_libro' => base64_decode(base64_decode($id_libro))
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarInfoLibro($id_libro){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro WHERE id_libro = :id_libro;");
            $query->execute([
                'id_libro' => base64_decode(base64_decode($id_libro))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function buscarIdLibro($id_libro){
        try { 
            $con = new Database;
            $query = $con->pdo->prepare("SELECT id_libro FROM cat_libro WHERE id_libro = :id_libro;");
            $query->execute([
                ':id_libro' => base64_decode(base64_decode($id_libro))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarUsuario: " . $e->getMessage();
            return;
        }
    }
    public static function RegistroComentario($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO asignacion_comentarios (id_fk_usuario, id_fk_libro, Comentario, Puntaje, Fecha_publicacion, Estatus) VALUES (:id_fk_usuario, :id_fk_libro, :comentario, :puntaje, :fecha_publicacion, '1')");
            
            $fecha_actual = date("Y-m-d H:i:s");
    
            $query->execute([
                ':id_fk_usuario' => $datos['id_usuario'],
                ':id_fk_libro' => base64_decode(base64_decode($datos['id_libro'])),
                ':comentario' => $datos['comentario'],
                ':puntaje' => $datos['estrellas'],
                ':fecha_publicacion' => $fecha_actual
            ]);
    
            return ['estatus' => 'success', 'mensaje' => 'Comentario insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el comentario en la base de datos'];
        }
    }
    public static function buscarComentarioEdicion($id_comentario){
        try { 
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_comentarios WHERE id_comentario = :id_comentario and Estatus = 1;");
            $query->execute([
                ':id_comentario' => base64_decode(base64_decode($id_comentario))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error en el modelo buscarComentarioEdicion: " . $e->getMessage();
            return;
        }
    }
    public static function editarComentario($datos){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
    
            $fecha_actual = date("Y-m-d H:i:s");
            $query = $con->pdo->prepare("UPDATE asignacion_comentarios SET 
                Comentario = :Comentario,
                Puntaje = :puntaje,
                Fecha_publicacion = :fecha_actual
            WHERE id_comentario = :id_comentario;");
        
            $query->bindParam(':id_comentario', $datos['id_comentario']);
            $query->bindParam(':Comentario', $datos['comentario']);
            $query->bindParam(':puntaje', $datos['estrellas']);
            $query->bindParam(':fecha_actual', $fecha_actual);
        
            $success = $query->execute();
    
            if ($success) {
                $con->pdo->commit();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error en el modelo editarComentario: $error_message";
            return false;
        }
    }
    public static function eliminarComentario($id_comentario){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
    
            $query = $con->pdo->prepare("DELETE FROM   asignacion_comentarios WHERE  id_comentario = :id_comentario;");
            $query->execute([
                ':id_comentario' => base64_decode(base64_decode($id_comentario))
            ]);
            
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model eliminar categoria: " . $e->getMessage();
            return false;
        }
    }

    /* FIN DE LA PAGINA PARA PDF Y COMENTARIOS */
}