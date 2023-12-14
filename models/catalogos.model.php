<?php

/**
 *
 */
class CatalogosModel extends ModelBase
{

    public function __construct()
    {
        parent::__construct();
    }
    /* Eventos */
    public static function eventos()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_eventos WHERE estatus_evento = 1");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    public static function infoProgramas($evento)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_programa cp INNER JOIN cat_eventos ce ON ce.id_evento = cp.fk_id_evento WHERE cp.fk_id_evento = :idEvento AND cp.estatus_programa = 1;");
            $query->execute([
                ':idEvento' => base64_decode(base64_decode($evento))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model revistas: " . $e->getMessage();
            return;
        }
    }
    /* Profesores */
    public static function infoProfesores()
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT cp.id_profesor,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,cp.correo_profesor,cp.telefono_profesor,p.pais,e.estado,cp.rol_profesor,cp.idioma_cartas FROM cat_profesores cp INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN paises p ON p.id_pais = cp.fk_id_pais INNER JOIN estados e ON e.id_estado = cp.fk_id_estado;");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoProfesores: " . $e->getMessage();
            return;
        }
    }
    public static function buscarProfesor($idprofesor)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_profesores cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarProfesor: " . $e->getMessage();
            return;
        }
    }
    /* Salones */
    public static function infoSalones($idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_salones WHERE fk_id_programa = :idPrograma;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoProfesores: " . $e->getMessage();
            return;
        }
    }
    public static function buscarSalon($idsalon)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_salones WHERE id_salon = :idSalon;");
            $query->execute([
                ':idSalon' => $idsalon
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarSalon: " . $e->getMessage();
            return;
        }
    }
    /* Capitulos */
    public static function infoCapitulos($idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_capitulos WHERE fk_id_programa = :idPrograma;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoProfesores: " . $e->getMessage();
            return;
        }
    }
    public static function buscarCapitulo($idcapitulo)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_capitulos WHERE id_capitulo = :idCapitulo;");
            $query->execute([
                ':idCapitulo' => $idcapitulo
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarProfesor: " . $e->getMessage();
            return;
        }
    }
    /* Actividades */
    public static function infoActividades($idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_actividades WHERE fk_id_programa = :idPrograma;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoActividades: " . $e->getMessage();
            return;
        }
    }
    public static function buscarActividad($idprofesor)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_actividades WHERE id_actividad = :idActividad;");
            $query->execute([
                ':idActividad' => $idprofesor
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarActividad: " . $e->getMessage();
            return;
        }
    }
    /* Temas */
    public static function infoTemas($idprograma)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_temas WHERE fk_id_programa = :idPrograma;");
            $query->execute([
                ':idPrograma' => base64_decode(base64_decode($idprograma))
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model infoTemas: " . $e->getMessage();
            return;
        }
    }
    public static function buscarTema($idtema)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_temas WHERE id_tema = :idTema;");
            $query->execute([
                ':idTema' => $idtema
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarTema: " . $e->getMessage();
            return;
        }
    }
    /* Actualizaciones de catalogos acorde a la sección */
    /* Actualizar Profesor */
    public static function updateProfesor($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_profesores SET  fk_id_prefijo = :fkPrefijo,nombre_profesor = :nombreProfesor,apellidop_profesor = :apellidoPaterno,apellidom_profesor = :apellidoMaterno,fk_id_pais = :fkPais,fk_id_estado = :fkEstado,fk_id_lada = :fkLada,telefono_profesor = :telefono,correo_profesor = :correoProfesor,rol_profesor = :rolProfesor, idioma_cartas = :idiomaCartas WHERE id_profesor = :idProfesor");
            $query->execute([

                ':idProfesor' => $datos['idprofesor'],
                ':fkPrefijo' => $datos['prefijo'],
                ':nombreProfesor' => trim($datos['nombre_profesor']),
                ':apellidoPaterno' => trim($datos['apellidop_profesor']),
                ':apellidoMaterno' => trim($datos['apellidom_profesor']),
                ':fkPais' => $datos['pais'],
                ':fkEstado' => $datos['estado'],
                ':fkLada' => $datos['lada'],
                ':telefono' => trim($datos['telefono_profesor']),
                ':correoProfesor' => trim($datos['correo_profesor']),
                ':rolProfesor' => $datos['rol_profesor'],
                ':idiomaCartas' => $datos['idioma_cartas']
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateProfesor: " . $e->getMessage();
            return false;
        }
    }
    /* Actualizar Salon */
    public static function updateSalon($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_salones SET nombre_salon = :nombreSalon, nombre_salon_ingles = :salonIngles WHERE id_salon = :idSalon");
            $query->execute([

                ':idSalon' => $datos['idsalon'],
                ':nombreSalon' => trim($datos['nombre_salon']),
                ':salonIngles' => trim($datos['nombre_salon_ingles'])
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateSalon: " . $e->getMessage();
            return false;
        }
    }
    /* Actualizar Capitulo */
    public static function updateCapitulo($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_capitulos SET nombre_capitulo = :nombreCapitulo, nombre_capitulo_ingles = :capituloIngles WHERE id_capitulo = :idCapitulo");
            $query->execute([

                ':idCapitulo' => $datos['idcapitulo'],
                ':nombreCapitulo' => trim($datos['nombre_capitulo']),
                ':capituloIngles' => trim($datos['nombre_capitulo_ingles']),
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateCapitulo: " . $e->getMessage();
            return false;
        }
    }
    /* Actualizar Actividad */
    public static function updateActividad($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_actividades SET nombre_actividad = :nombreActividad, nombre_actividad_ingles = :actividadIngles  WHERE id_actividad = :idActividad");
            $query->execute([

                ':idActividad' => $datos['idactividad'],
                ':nombreActividad' => trim($datos['nombre_actividad']),
                ':actividadIngles' => trim($datos['nombre_actividad_ingles']),
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateActividad: " . $e->getMessage();
            return false;
        }
    }
    /* Actualizar Actividad */
    public static function updateTema($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_temas SET nombre_tema = :nombreTema, nombre_tema_ingles = :temaIngles WHERE id_tema = :idTema");
            $query->execute([

                ':idTema' => $datos['idtema'],
                ':nombreTema' => trim($datos['nombre_tema']),
                ':temaIngles' => (!empty(trim($datos['nombre_tema_ingles'])))?trim($datos['nombre_tema_ingles']):null
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateTema: " . $e->getMessage();
            return false;
        }
    }
    /* Catálogos */
    public static function cat_estados($id)
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM estados WHERE id_pais = :idPais;");
            $query->execute([
                ':idPais' => $id
            ]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo "Error recopilado model cat_estados: " . $e->getMessage();
            return;
        }
    }
}