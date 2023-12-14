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
            $query = $con->pdo->prepare("SELECT cp.id_profesor,concat_ws(' ',cpr.siglas_prefijo,cp.nombre_profesor,cp.apellidop_profesor,cp.apellidom_profesor) AS profesor,cp.correo_profesor,cp.telefono_profesor,p.pais,e.estado FROM cat_profesores cp INNER JOIN cat_prefijos cpr ON cpr.id_prefijo = cp.fk_id_prefijo INNER JOIN paises p ON p.id_pais = cp.fk_id_pais INNER JOIN estados e ON e.id_estado = cp.fk_id_estado;");
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
    public static function buscarSalon($idprofesor)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_salones cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarProfesor: " . $e->getMessage();
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
    public static function buscarCapitulo($idprofesor)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_capitulos cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
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
            $query = $con->pdo->prepare("SELECT * FROM cat_actividades cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
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
    public static function buscarTema($idprofesor)//Pendiente
    {
        try {
            $con = new Database;
            $query = $con->pdo->prepare("SELECT * FROM cat_actividades cp WHERE cp.id_profesor = :idProfesor;");
            $query->execute([
                ':idProfesor' => $idprofesor
            ]);
            return $query->fetch();
        } catch (PDOException $e) {
            echo "Error recopilado model buscarTema: " . $e->getMessage();
            return;
        }
    }
    /* Actualizaciones de catalogos acorde a la sección */
    public static function updateProfesor($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_profesores SET  fk_id_prefijo = :fkPrefijo,nombre_profesor = :nombreProfesor,apellidop_profesor = :apellidoPaterno,apellidom_profesor = :apellidoMaterno,fk_id_pais = :fkPais,fk_id_estado = :fkEstado,fk_id_lada = :fkLada,telefono_profesor = :telefono,correo_profesor = :correoProfesor,rol_profesor = :rolProfesor WHERE id_profesor = :idProfesor");
            $query->execute([

                ':idProfesor' => $datos['idprofesor'],
                ':fkPrefijo' => $datos['prefijo'],
                ':nombreProfesor' => $datos['nombre_profesor'],
                ':apellidoPaterno' => $datos['apellidop_profesor'],
                ':apellidoMaterno' => $datos['apellidom_profesor'],
                ':fkPais' => $datos['pais'],
                ':fkEstado' => $datos['estado'],
                ':fkLada' => $datos['lada'],
                ':telefono' => $datos['telefono_profesor'],
                ':correoProfesor' => $datos['correo_profesor'],
                ':rolProfesor' => $datos['rol_profesor']
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateProfesor: " . $e->getMessage();
            return false;
        }
    }
    public static function updateSalon($datos)
    {
        try {
            $con = new Database;
            $con->pdo->beginTransaction();
            $query = $con->pdo->prepare("UPDATE cat_salones SET  nombre_salon = :nombreSalon WHERE id_salon = :idSalon");
            $query->execute([

                ':idSalon' => $datos['idsalon'],
                ':nombreSalon' => $datos['nombre_salon']
            ]);
            $con->pdo->commit();
            return true ;
        } catch (PDOException $e) {
            $con->pdo->rollBack();
            echo "Error recopilado model updateSalon: " . $e->getMessage();
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