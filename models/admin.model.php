<?php

use function GuzzleHttp\Promise\queue;

/**
 *
 */
class AdminModel extends ModelBase{

    public function __construct(){
        parent::__construct();
    }

    /* CONFIGURACION */

    public static function actualizarUsuarioGeneralSinPass($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("UPDATE cat_usuario SET
                Nombre = :nombre,
                Apellido_paterno = :apellido_paterno,
                Apellido_materno = :apellido_materno,
                Tipo_usuario = :tipo_usuario,
                Genero = :genero,
                Estatus = :estatus
            WHERE id_usuario = :id_usuario;");

            $query->bindParam(':id_usuario', $datos['id_usuario']);
            $query->bindParam(':nombre', $datos['nombre']);
            $query->bindParam(':apellido_paterno', $datos['lastname']);
            $query->bindParam(':apellido_materno', $datos['AMaterno']);
            $query->bindParam(':genero', $datos['genero']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarUsuario: $error_message";
            return false;
        }
    }
    public static function ConfiguracionActualizarDatos($datos){
        $con = new Database;

        try {
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("UPDATE cat_usuario
                SET Nombre = :nombre
                WHERE id_usuario = :id_usuario;");
            $query->bindParam(':id_usuario', $datos['id_usuario']);
            $query->bindParam(':nombre', $datos['nombre']);

            $query->execute();
            $con->pdo->commit();

            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();

            $error_message = $e->getMessage();
            echo "Error in model actualizarUsuario: $error_message";

            return false;
        }
    }
    public static function ConfiguracionActualizarPass($datos){
        $con = new Database;

        try {
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("UPDATE cat_usuario
                SET pass = :password
                WHERE id_usuario = :id_usuario;");
            $query->bindParam(':id_usuario', $datos['id_usuario']);
            $query->bindParam(':password', $datos['passwordNewRepit']);

            $query->execute();
            $con->pdo->commit();

            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();

            $error_message = $e->getMessage();
            echo "Error in model actualizarUsuario: $error_message";

            return false;
        }
    }
    public static function VerificarPasswordGeneral($id_usuario, $passwordNewRepit){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_usuario WHERE id_usuario = :id_usuario; && pass = :password");
            $query->execute([
                ':id_usuario' => base64_decode(base64_decode($id_usuario)),
                ':password' => base64_decode(base64_decode($passwordNewRepit))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarEditorial: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarDispositivos($id_usuario){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT
                id_fk_usuario,
                infoModelo,
                Direccion,
                MAX(FechaTiempo) AS FechaMasReciente,
                COUNT(*) AS VecesRepetido
                FROM asignacion_dispositivo
                WHERE id_fk_usuario = :id_usuario
                GROUP BY id_fk_usuario, infoModelo, Direccion;
            ");
            $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }    
    /* FIN CONFIGURACION */

    /* Inicio */

    public static function MostrarLibrosView(){
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
                    OR cl.Palabra_clave LIKE :busqueda_palabra_clave
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
    public static function buscarLibrosEnTiempoReal($datos){
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
    public static function MostrarLibrosViewHarry(){
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
                cl.id_fk_usuario
            FROM cat_libro cl
            INNER JOIN asignacion_libro al ON cl.id_libro = al.id_fk_libro
            INNER JOIN cat_autor a ON al.id_fk_autor = a.id_autor
            WHERE a.Nombre = 'J. K.';        
            ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function MostrarLibrosViewACII(){
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
                cl.id_fk_usuario
            FROM cat_libro cl
            INNER JOIN asignacion_libro al ON cl.id_libro = al.id_fk_libro
            INNER JOIN cat_autor a ON al.id_fk_autor = a.id_autor
            INNER JOIN cat_editorial e ON al.id_fk_editorial = e.id_editorial
            WHERE e.Nombre = 'ASCII Media Works';
            ");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    /* FIN INICIO */
    /* Autores */
    public static function MostrarAutorTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_autor");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function RegistroAutores($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_autor (Nombre, Apellido_paterno, Apellido_materno, Resumen_biblografia, Foto, Token, Estatus) VALUES (:nombre, :apellido_paterno, :apellido_materno, :biblografia, :foto, :token, :estatus)");

            $query->execute([
                ':nombre' => $datos['nombre'],
                ':apellido_paterno' => $datos['APaterno'],
                ':apellido_materno' => $datos['AMaterno'],
                ':biblografia' => $datos['biblografia'],
                ':foto' => $datos['foto'],
                'token' => $datos['token'],
                ':estatus' => $datos['estatus']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Usuario insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
    public static function buscarToken($token){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_autor WHERE Token = :token");
            $query->execute([
                ':token' => $token
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error en el modelo eventos: " . $e->getMessage();
            return [];
        }
    }
    public static function eliminarAutor($id_autor){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("DELETE FROM cat_autor  WHERE id_autor = :id_autor;");
            $query->execute([
                ':id_autor' => base64_decode(base64_decode($id_autor))
            ]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Autor en uso');
            }
            echo "Error recopilado model eliminar autor: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarAutor($id_autor){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_autor WHERE id_autor = :id_autor;");
            $query->execute([
                ':id_autor' => base64_decode(base64_decode($id_autor))
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarEditorial: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarAutor($datos, $fotoActualizada){
        try {
            $con = new Database;

            if ($fotoActualizada) {
                $query = $con->pdo->prepare("UPDATE cat_autor SET 
                    Nombre = :nombre, 
                    Apellido_paterno = :apaterno,
                    Apellido_materno = :amaterno,
                    Resumen_biblografia = :biblografia,
                    Estatus = :estatus,
                    Foto = :foto,
                    Token = :token
                    WHERE id_autor = :id_autor");
                $query->bindParam(':foto', $datos['foto']);
                $query->bindParam(':token', $datos['token']);
            } else {
                $query = $con->pdo->prepare("UPDATE cat_autor SET 
                    Nombre = :nombre, 
                    Apellido_paterno = :apaterno,
                    Apellido_materno = :amaterno,
                    Resumen_biblografia = :biblografia,
                    Estatus = :estatus
                    WHERE id_autor = :id_autor");
            }

            $query->bindParam(':id_autor', $datos['id_autor']);
            $query->bindParam(':nombre', $datos['nombre']);
            $query->bindParam(':apaterno', $datos['APaterno']);
            $query->bindParam(':amaterno', $datos['AMaterno']);
            $query->bindParam(':biblografia', $datos['biblografia']);
            $query->bindParam(':estatus', $datos['estatus']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarAutor: $error_message";
            return false;
        }
    }

    /* FIN AUTORES*/

    /* EDITORIAL */
    public static function MostrarEditorialTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_editorial");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model editorial: " . $e->getMessage();
            return;
        }
    }
    public static function ResgistroEditorial($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_editorial (Nombre, Estatus) VALUES (:nombre,:estatus)");

            $query->execute([
                ':nombre' => $datos['editorial'],
                ':estatus' => $datos['estatus']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Editorial insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
    public static function eliminarEditorial($id_editorial){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("DELETE FROM cat_editorial  WHERE id_editorial = :id_editorial;");
            $query->execute([
                ':id_editorial' => base64_decode(base64_decode($id_editorial))
            ]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Editorial en uso');
            }
            echo "Error recopilado model eliminar editorial: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarEditorial($id_editorial){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_editorial WHERE id_editorial = :id_editorial;");
            $query->execute([
                ':id_editorial' => $id_editorial
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarEditorial: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarEditorial($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("UPDATE cat_editorial SET 
                Nombre = :editorial, 
                Estatus = :estatus 
                WHERE id_editorial = :id_editorial");

            $query->bindParam(':id_editorial', $datos['id_editorial']);
            $query->bindParam(':editorial', $datos['editorial']);
            $query->bindParam(':estatus', $datos['estatus']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarEditorial: $error_message";
            return false;
        }
    }

    /* FIN EDITORIAL */

    /* IDIOMA */

    public static function MostrarIdiomaTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_idioma");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function RegistroIdioma($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_idioma (Idioma, Estatus) VALUES (:idioma,:estatus)");

            $query->execute([
                ':idioma' => $datos['idioma'],
                ':estatus' => $datos['estatus']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Idioma insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
    public static function eliminarIdioma($id_idioma){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("DELETE FROM cat_idioma  WHERE id_idioma = :id_idioma;");
            $query->execute([
                ':id_idioma' => base64_decode(base64_decode($id_idioma))
            ]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Idioma en uso');
            }
            echo "Error recopilado model eliminar Idioma: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarIdioma($id_idioma){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_idioma WHERE id_idioma = :id_idioma;");
            $query->execute([
                ':id_idioma' => $id_idioma
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarUsuario: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarIdioma($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("UPDATE cat_idioma SET 
                Idioma = :idioma, 
                Estatus = :estatus
                WHERE id_idioma = :id_idioma;");

            $query->bindParam(':id_idioma', $datos['id_idioma']);
            $query->bindParam(':idioma', $datos['idioma']);
            $query->bindParam(':estatus', $datos['estatus']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarIdioma: $error_message";
            return false;
        }
    }

    /* FIN IDIOMA */

    /* USUARIO */

    public static function MostrarUsuarioTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_usuario");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function eliminarUsuario($id_usuario){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("DELETE FROM cat_usuario  WHERE id_usuario = :id_usuario;");
            $query->execute([
                ':id_usuario' => base64_decode(base64_decode($id_usuario))
            ]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Usuario en uso');
            }

            echo "No podemos eliminar usuario: " . $e->getMessage();
            return false;
        }
    }

    public static function RegistroUsuario($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_usuario (Nombre, Apellido_paterno, Apellido_materno, Genero, Tipo_usuario, Estatus, correo, pass) VALUES (:nombre, :apellido_paterno, :apellido_materno, :genero, '2', '1', :correo, :pass)");

            $query->execute([
                ':nombre' => $datos['nombre'],
                ':apellido_paterno' => $datos['APaterno'],
                ':apellido_materno' => $datos['AMaterno'],
                ':genero' => $datos['genero'],
                ':correo' => $datos['email'],
                ':pass' => $datos['password']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Usuario insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
    public static function buscarUsuario($id_usuario){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_usuario WHERE id_usuario = :id_usuario;");
            $query->execute([
                ':id_usuario' => $id_usuario
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarUsuario: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarUsuario($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("UPDATE cat_usuario SET 
                Nombre = :nombre, 
                Apellido_paterno = :apellido_paterno, 
                Apellido_materno = :apellido_materno, 
                correo = :correo, 
                pass = :pass, 
                Tipo_usuario = :tipo_usuario, 
                Genero = :genero, 
                Estatus = :estatus 
            WHERE id_usuario = :id_usuario;");

            $query->bindParam(':id_usuario', $datos['ac_id_usuario']);
            $query->bindParam(':nombre', $datos['ac_nombre']);
            $query->bindParam(':apellido_paterno', $datos['ac_apellido_paterno']);
            $query->bindParam(':apellido_materno', $datos['ac_apellido_materno']);
            $query->bindParam(':correo', $datos['ac_correo']);
            $query->bindParam(':pass', $datos['ac_password']);
            $query->bindParam(':tipo_usuario', $datos['ac_tipo_usuario']);
            $query->bindParam(':genero', $datos['ac_genero']);
            $query->bindParam(':estatus', $datos['ac_estatus']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarUsuario: $error_message";
            return false;
        }
    }
    /* LIBRO */

    public static function MostrarLibroTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarCategoriaLibros(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_categoria WHERE Estatus = '1';");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarEditorialLibros(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_editorial WHERE Estatus = '1';");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarAutorLibros(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_autor WHERE Estatus = '1';");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function mostrarIdiomalibros(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_idioma WHERE Estatus = '1';");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function RegistroLibros($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_libro (Titulo, Numero_paginas, Fecha_subir_sistema, Fecha_publicacion, Descripcion, Palabra_clave, Estatus, Imagen, Token, documento, Token_documento) VALUES (:titulo, :numero_paginas, :fecha_subir_sistema, :fecha_publicacion, :descripcion, :palabra_clave, :estatus, :portada, :token, :documento, :token_documento)");
            $fecha_actual = date("Y-m-d H:i:s");
            $query->execute([
                ':titulo' => $datos['titulo'],
                ':numero_paginas' => $datos['Numero_pagina'],
                ':fecha_subir_sistema' => $fecha_actual,
                ':fecha_publicacion' => $datos['fecha_publicacion'],
                ':descripcion' => $datos['descripcion'],
                ':palabra_clave' => $datos['palabra_clave'],
                ':estatus' => $datos['estatus'],
                ':portada' => $datos['portada'],
                ':token' => $datos['token'],
                ':documento' => $datos['documento'],
                ':token_documento' => $datos['token_documento']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'libro insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el libro en la base de datos'];
        }
    }
    public static function obtenerUltimoIdLibro(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT MAX(id_libro) AS id_libro FROM cat_libro");
            $query->execute();
            $result = $query->fetch();
            return $result['id_libro'];
        } catch (PDOException $e) {
            echo "Error en el modelo eventos: " . $e->getMessage();
            return null;
        }
    }
    public static function asignarLibro($id_libro, $datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO asignacion_libro (id_fk_libro, id_fk_categoria, id_fk_idioma, id_fk_editorial, id_fk_autor) VALUES (:id_libro, :id_categoria, :id_idioma, :id_editorial, :id_autor)");

            $query->execute([
                ':id_libro' => $id_libro,
                ':id_categoria' => $datos['categoria'],
                ':id_idioma' => $datos['idioma'],
                ':id_editorial' => $datos['editorial'],
                ':id_autor' => $datos['autor']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Asignación de libro exitosa'];
        } catch (PDOException $e) {
            echo "Error en el modelo asignarLibro: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al asignar el libro en la base de datos'];
        }
    }
    public static function buscarTokenImagen($token){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro WHERE Token = :token");
            $query->execute([
                ':token' => $token
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error en el modelo eventos: " . $e->getMessage();
            return [];
        }
    }
    public static function buscarTokenDocumento($token_documento){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro WHERE Token_documento = :token");
            $query->execute([
                ':token' => $token_documento
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error en el modelo eventos: " . $e->getMessage();
            return [];
        }
    }
    public static function eliminarLibro($id_libro){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $idLibro = base64_decode(base64_decode($id_libro));
            $queryAsignacion = $con->pdo->prepare("DELETE FROM asignacion_libro WHERE id_fk_libro = :id_libro;");
            $queryAsignacion->execute([':id_libro' => $idLibro]);
            $queryLibro = $con->pdo->prepare("DELETE FROM cat_libro WHERE id_libro = :id_libro;");
            $queryLibro->execute([':id_libro' => $idLibro]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Libro en uso');
            }
            echo "Error en el modelo eliminar Libro: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarLibro($id_libro){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_libro,asignacion_libro WHERE id_libro = :id_libro and id_fk_libro = :id_fk_libro;");
            $query->execute([
                ':id_libro' => base64_decode(base64_decode($id_libro)),
                ':id_fk_libro' => base64_decode(base64_decode($id_libro))

            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarLibro: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarLibro($datos, $portadaActualizada, $documentoActualizado){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $queryLibro = $con->pdo->prepare("UPDATE cat_libro SET 
                Titulo = :titulo, 
                Numero_paginas = :numero_pagina,
                Fecha_publicacion = :fecha_publicacion,
                Descripcion = :descripcion,
                Palabra_clave = :palabra_clave,
                Estatus = :estatus" . ($portadaActualizada ? ", Imagen = :portada, Token = :token_portada" : "") . ($documentoActualizado ? ", Documento = :documento, Token_documento = :token_documento" : "") . "
                WHERE id_libro = :id_libro");

            if ($portadaActualizada) {
                $queryLibro->bindParam(':portada', $datos['portada']);
                $queryLibro->bindParam(':token_portada', $datos['token_portada']);
            }

            if ($documentoActualizado) {
                $queryLibro->bindParam(':documento', $datos['documento']);
                $queryLibro->bindParam(':token_documento', $datos['token_documento']);
            }

            $queryLibro->bindParam(':id_libro', $datos['id_libro']);
            $queryLibro->bindParam(':titulo', $datos['titulo']);
            $queryLibro->bindParam(':numero_pagina', $datos['Numero_pagina']);
            $queryLibro->bindParam(':fecha_publicacion', $datos['fecha_publicacion']);
            $queryLibro->bindParam(':descripcion', $datos['descripcion']);
            $queryLibro->bindParam(':palabra_clave', $datos['palabra_clave']);
            $queryLibro->bindParam(':estatus', $datos['estatus']);

            $queryLibro->execute();

            if ($queryLibro->errorCode() != 0) {
                $errorInfo = $queryLibro->errorInfo();
                throw new PDOException("Query Libro Error: " . $errorInfo[2]);
            }

            $queryAsignacion = $con->pdo->prepare("UPDATE asignacion_libro SET 
                id_fk_autor = :autor, 
                id_fk_editorial = :editorial,
                id_fk_categoria = :categoria,
                id_fk_idioma = :idioma
            WHERE id_fk_libro = :id_libro");

            $queryAsignacion->bindParam(':id_libro', $datos['id_libro']);
            $queryAsignacion->bindParam(':autor', $datos['autor']);
            $queryAsignacion->bindParam(':categoria', $datos['categoria']);
            $queryAsignacion->bindParam(':idioma', $datos['idioma']);
            $queryAsignacion->bindParam(':editorial', $datos['editorial']);

            $queryAsignacion->execute();

            if ($queryAsignacion->errorCode() != 0) {
                $errorInfo = $queryAsignacion->errorInfo();
                throw new PDOException("Query Asignacion Error: " . $errorInfo[2]);
            }

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarLibro: $error_message";
            return false;
        }
    }

    /* Categoria */

    public static function MostrarCategoriaTabla(){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_categoria");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model eventos: " . $e->getMessage();
            return;
        }
    }
    public static function RegistroCategoria($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO cat_categoria (Categoria, Estatus) VALUES (:categoria,:estatus)");

            $query->execute([
                ':categoria' => $datos['categoria'],
                ':estatus' => $datos['estatus']
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Categoria insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el usuario en la base de datos'];
        }
    }
    public static function eliminarCategoria($id_categoria){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $query = $con->pdo->prepare("DELETE FROM cat_categoria  WHERE id_categoria = :id_categoria;");
            $query->execute([
                ':id_categoria' => base64_decode(base64_decode($id_categoria))
            ]);

            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            if ($e->getCode() == '23000') {
                throw new Exception('Categoria en uso');
            }
            echo "Error recopilado model eliminar categoria: " . $e->getMessage();
            return false;
        }
    }
    public static function buscarCategoria($id_categoria){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_categoria WHERE id_categoria = :id_categoria;");
            $query->execute([
                ':id_categoria' => $id_categoria
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarCategoria: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarCategoria($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("UPDATE cat_categoria SET 
                Categoria = :categoria, 
                Estatus = :estatus
            WHERE id_categoria = :id_categoria;");

            $query->bindParam(':id_categoria', $datos['id_categoria']);
            $query->bindParam(':categoria', $datos['categoria']);
            $query->bindParam(':estatus', $datos['estatus']);

            $query->execute();
            $con->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            $error_message = $e->getMessage();
            echo "Error recopilado model actualizarCategoria: $error_message";
            return false;
        }
    }
    /* FIN DE LA CATEGORIA */

    /* visualizacion del pdf*/
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
            $query = $con->pdo->prepare("SELECT 
            cl.*,
            al.id_asignacion_libro,
            al.id_fk_autor,
            a.Nombre AS NombreAutor,
            a.Apellido_paterno AS ApellidoPaternoAutor,
            a.Apellido_materno AS ApellidoMaternoAutor,
            al.id_fk_editorial,
            e.Nombre AS NombreEditorial,
            al.id_fk_categoria,
            al.id_fk_idioma,
            al.id_fk_usuario AS id_fk_usuario_asignacion
        FROM 
            cat_libro cl
        LEFT JOIN 
            asignacion_libro al ON cl.id_libro = al.id_fk_libro
        LEFT JOIN 
            cat_autor a ON al.id_fk_autor = a.id_autor
        LEFT JOIN 
            cat_editorial e ON al.id_fk_editorial = e.id_editorial WHERE id_libro = :id_libro;");
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

            $query = $con->pdo->prepare("DELETE FROM asignacion_comentarios WHERE  id_comentario = :id_comentario;");
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
    public static function guardarProgresso($datos){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("INSERT INTO asignacion_progreso (id_fk_usuario, id_fk_libro, Fecha, progreso) VALUES (:id_fk_usuario, :id_fk_libro, :fecha_real, :progreso)");

            $fecha_actual = date("Y-m-d H:i:s");

            $query->execute([
                ':id_fk_usuario' => $datos['id_usuario'],
                ':id_fk_libro' => base64_decode(base64_decode($datos['id_libro'])),
                ':progreso' => $datos['progreso'],
                ':fecha_real' => $fecha_actual
            ]);

            return ['estatus' => 'success', 'mensaje' => 'Comentario insertado correctamente'];
        } catch (PDOException $e) {
            echo "Error recopilacion model user: " . $e->getMessage();
            return ['estatus' => 'error', 'mensaje' => 'Error al insertar el comentario en la base de datos'];
        }
    }
    public static function buscarProgreso($id_usuario, $id_libro){
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM asignacion_progreso WHERE id_fk_usuario = :idUsuario and id_fk_libro = idLibro;");
            $query->execute([
                ':idUsuario' => $id_usuario,
                'idLibro' => $id_libro
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarCategoria: " . $e->getMessage();
            return;
        }
    }
    public static function actualizarProgreso($datos){
        try {
            $con = new Database;
            $con->pdo->beginTransaction();

            $fecha_actual = date("Y-m-d H:i:s");
            $query = $con->pdo->prepare("UPDATE asignacion_progreso SET
                progreso = :progreso,
                Fecha_publicacion = :fecha_actual
            WHERE id_fk_usuario = :idUsuario and id_fk_libro = :idLibro;");

            $query->bindParam(':idUsuario', $datos['id_usuario']);
            $query->bindParam(':idLibro', $datos['id_libro']);
            $query->bindParam(':progreso', $datos['progreso']);
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
    /*FIN DE VISUALIZACION DEL PDF */
}
